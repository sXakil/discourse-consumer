<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Facades\Http;

class BlogController extends Controller {
	private function getMonthsByGroup($start_year) {
		$months_by_group = [];
		$current_year = date('Y');
		$current_month = date('n');
		for ($year = $start_year; $year <= $current_year; $year++) {
			$months_by_group[$year] = [];
			$end_month = ($year == $current_year) ? $current_month : 12;
			for ($month = 1; $month <= $end_month; $month++) {
				$m = [];
				$m['name'] = date('F', mktime(0, 0, 0, $month, 10));
				$months_by_group[$year][] = $m;
			}
		}
		return $months_by_group;
	}

	private function filterVisibleTopics($topics) {
		return array_filter($topics, function ($topic) {
			return $topic['visible'];
		});
	}

	function index(Request $request) {
		$page = $request->get('page', 0);
		$url = 'https://forum.toiletology.org/c/blog/23.json?page=' . $page;
		try {
			$cached_topics_list = Cache::remember(
				'blog_topics_'  . $page,
				3600,
				function () use ($url) {
					$response = Http::withHeaders([
						'Api-Key' => env('DISCOURSE_API_KEY'),
						'Api-Username' => 'developer'
					])->get($url);
					$response_json = $response->json();
					if (array_key_exists('topic_list', $response_json)) {
						return $response_json['topic_list'];
					}
					return [];
				}
			);
		} catch (\Exception $e) {
			$cached_topics_list = [];
		}

		$topics = [];
		if (array_key_exists('topics', $cached_topics_list)) {
			$topics = $this->filterVisibleTopics($cached_topics_list['topics']);
		}
		if (array_key_exists('more_topics_url', $cached_topics_list) && $cached_topics_list["more_topics_url"] != null) {
			$page++;
		}

		return view('blog.index', ['topics' => $topics, 'months_by_group' => $this->getMonthsByGroup(2026), 'next_page' => $page > 0 ? $page : null]);
	}

	function byMonth($year, $month) {
		try {
			$month_index = date('n', strtotime($month . ' 1 ' . $year));
			$start_date = date('Y-m-d', mktime(0, 0, 0, $month_index, 1, $year));
			$end_date = date('Y-m-d', mktime(0, 0, 0, $month_index + 1, 0, $year));
			$query_params = urlencode("after:" . $start_date . " before:" . $end_date . " #blog status:open order:latest_topic");

			$cache_key = 'blog_topics_' . $year . '_' . $month_index;

			$cached_topics = Cache::remember(
				$cache_key,
				86400,
				function () use ($query_params) {
					$response = Http::withHeaders([
						'Api-Key' => env('DISCOURSE_API_KEY'),
						'Api-Username' => 'developer'
					])->get('https://forum.toiletology.org/search.json?q=' . $query_params);
					$response_json = $response->json();
					$topics = $response_json['topics'] ?? [];
					return $this->filterVisibleTopics($topics);
				}
			);
		} catch (\Exception $e) {
			$cached_topics = [];
		}
		return view('blog.month', ['topics' => $cached_topics, 'months_by_group' => $this->getMonthsByGroup(2026), 'selected_year' => $year, 'selected_month' => $month]);
	}

	function flushCache() {
		$page = 0;
		while (Cache::has('blog_topics_' . $page)) {
			Cache::forget('blog_topics_' . $page);
			$page++;
		}
		$months_by_group = $this->getMonthsByGroup(2026);
		foreach ($months_by_group as $year => $months) {
			foreach ($months as $month) {
				$month_index = date('n', strtotime($month['name'] . ' 1 ' . $year));
				$cache_key = 'blog_topics_' . $year . '_' . $month_index;
				Cache::forget($cache_key);
			}
		}
		return response('Cache flushed', 200);
	}
}
