<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Facades\Http;

enum Type: string {
	case BLOG = 'blog';
	case NEWS = 'news';
	case RADIO = 'radio';
	case LESSONS = 'lessons';
}

class ApiController extends Controller {

	function index($type, Request $request, $year = null) {
		$id = null;

		if ($type == Type::BLOG->value) {
			$id = 23;
		} elseif ($type == Type::NEWS->value) {
			$id = 24;
		} elseif ($type == Type::RADIO->value) {
			$id = 27;
		} elseif ($type == Type::LESSONS->value) {
			$id = 36;
		} else {
			return response('Invalid type', 400);
		}

		if ($year == null) {
			$year = $request->get('year');
		}
		if ($year == null) {
			$year = date('Y');
		}

		try {
			$cached_response = Cache::remember(
				$type . '_topics_'  . $year,
				86400,
				function () use ($id, $year) {
					$url = 'https://forum.toiletology.org/api/categories/' . $id . '/topics/' . $year;
					$response = Http::withHeaders([
						'Api-Key' => env('DISCOURSE_API_KEY'),
						'Api-Username' => 'developer'
					])->get($url);
					return $response->json();
				}
			);
		} catch (\Exception $e) {
			$cached_response = null;
		}

		$topics = [];
		if (array_key_exists('topics', $cached_response)) {
			$topics = $cached_response['topics'];
		}

		$stats = [];
		if (array_key_exists('stats', $cached_response)) {
			$stats = $cached_response['stats'];
			krsort($stats);
			if (array_keys($stats)[0] != date('Y')) {
				$stats = ["Jump to " . date('Y') => null] + $stats;
			}
		}

		return view('index', [
			'type' => $type,
			'selected_year' => $year,
			'topics' => $topics,
			'stats' => $stats
		]);
	}

	function flushCache($type) {
		$start_year = 2020;
		$end_year = date('Y');
		for ($i = $end_year; $i >= $start_year; $i--) {
			if (Cache::has($type . '_topics_' . $i)) {
				Cache::forget($type . '_topics_' . $i);
			}
		}
		return response('All ' . $type . ' cache flushed', 200);
	}
}
