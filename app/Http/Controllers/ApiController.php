<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Facades\Http;

class ApiController extends Controller {
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

	private function fetchTopics($id, $year, $topics = []) {
		$url = 'https://forum.toiletology.org/api/categories/' . $id . '/topics/' . $year;
		$response = Http::withHeaders([
			'Api-Key' => env('DISCOURSE_API_KEY'),
			'Api-Username' => 'developer'
		])->get($url);
		$resp = $response->json();
		$_topics = $resp['topics'] ?? [];
		$topics = array_merge($topics, $_topics);

		$total = count($topics, COUNT_RECURSIVE) - count($topics);
		if ($total > 50 || $year < 2000) {
			return $topics;
		}
		return $this->fetchTopics($id, $year - 1, $topics);
	}

	function index(Request $request, $type, $year = null) {
		$page = $request->get('page', 0);
		$id = null;

		if ($type == 'blog') {
			$id = 23;
		} elseif ($type == 'news') {
			$id = 24;
		} else {
			return response('Invalid type', 400);
		}

		if ($year == null) $year = date('Y');

		try {
			$cached_response = Cache::remember(
				$type . '_topics_'  . $page,
				7 * 86400,
				function () use ($id, $year) {
					return $this->fetchTopics($id, $year);
				}
			);
		} catch (\Exception $e) {
			$cached_response = null;
		}

		$topics = [];
		if (array_key_exists('topics', $cached_response)) {
			$topics = $cached_response['topics'];
		}

		$meta = [];
		if (array_key_exists('meta', $cached_response)) {
			$meta = $cached_response['meta'];
		}

		$topics = $this->filterVisibleTopics($topics);

		if (array_key_exists('has_more', $meta) && $meta["has_more"] != null) {
			$page++;
		}

		return view('index', [
			'type' => $type,
			'topics' => $topics,
			'next_page' => $page > 0 ? $page : null
		]);
	}

	function byMonth($type, $year, $month) {
		try {
			$month_index = date('n', strtotime($month . ' 1 ' . $year));
			$start_date = date('Y-m-d', mktime(0, 0, 0, $month_index, 1, $year));
			$end_date = date('Y-m-d', mktime(0, 0, 0, $month_index + 1, 0, $year));
			$query_params = urlencode("after:" . $start_date . " before:" . $end_date . " #" . $type . " status:open order:latest_topic");

			$cache_key = $type . '_topics_' . $year . '_' . $month_index;

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
		return view('month', ['type' => $type, 'topics' => $cached_topics, 'months_by_group' => $this->getMonthsByGroup(2026), 'selected_year' => $year, 'selected_month' => $month]);
	}

	function flushCache($type) {
		$page = 0;
		while (Cache::has($type . '_topics_' . $page)) {
			Cache::forget($type . '_topics_' . $page);
			$page++;
		}
		$months_by_group = $this->getMonthsByGroup(2026);
		foreach ($months_by_group as $year => $months) {
			foreach ($months as $month) {
				$month_index = date('n', strtotime($month['name'] . ' 1 ' . $year));
				$cache_key = $type . '_topics_' . $year . '_' . $month_index;
				Cache::forget($cache_key);
			}
		}
		return response('Cache flushed', 200);
	}
}
