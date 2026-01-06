<?php

namespace App\Http\Controllers;

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
                $m['first_day'] = date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
                $m['last_day'] = date('Y-m-d', mktime(0, 0, 0, $month + 1, 0, $year));
                $months_by_group[$year][] = $m;
            }
        }
        return $months_by_group;
    }
    function index() {

        // $response = Http::withHeaders([
        //     'Api-Key' => env('DISCOURSE_API_KEY'),
        //     'Api-Username' => 'developer'
        // ])->get('https://forum.toiletology.org/c/blog/23.json');
        // $topic_list = $response->json()['topic_list'];
        $topics = json_decode('
        [
			{
				"fancy_title": "Explaining the difference between 4D and 5D reality",
				"fancy_title_localized": false,
				"locale": null,
				"id": 75,
				"title": "Explaining the difference between 4D and 5D reality",
				"slug": "explaining-the-difference-between-4d-and-5d-reality",
				"posts_count": 1,
				"reply_count": 0,
				"highest_post_number": 1,
				"image_url": "//forum.toiletology.org/uploads/default/original/1X/38155ca4fd5da01ff80b4c033c01af8eee0358fd.gif",
				"created_at": "2026-01-02T04:54:45.199Z",
				"last_posted_at": "2026-01-02T04:54:45.272Z",
				"bumped": true,
				"bumped_at": "2026-01-02T04:54:45.272Z",
				"archetype": "regular",
				"unseen": false,
				"pinned": false,
				"unpinned": null,
				"excerpt": "4D (density) is the next step outside of your current 3D reality. You can think of your current reality as a cube and the next step as the tesseract. It happens in your mind first, which then starts to shape your surrounding reality. Its a dimension tha&hellip;",
				"visible": true,
				"closed": false,
				"archived": false,
				"bookmarked": null,
				"liked": null,
				"thumbnails": [
					{
						"max_width": null,
						"max_height": null,
						"width": 750,
						"height": 423,
						"url": "//forum.toiletology.org/uploads/default/original/1X/38155ca4fd5da01ff80b4c033c01af8eee0358fd.gif"
					},
					{
						"max_width": 600,
						"max_height": 600,
						"width": 600,
						"height": 338,
						"url": "//forum.toiletology.org/uploads/default/optimized/1X/38155ca4fd5da01ff80b4c033c01af8eee0358fd_2_600x338.gif"
					},
					{
						"max_width": 400,
						"max_height": 400,
						"width": 400,
						"height": 225,
						"url": "//forum.toiletology.org/uploads/default/optimized/1X/38155ca4fd5da01ff80b4c033c01af8eee0358fd_2_400x225.gif"
					},
					{
						"max_width": 300,
						"max_height": 300,
						"width": 300,
						"height": 169,
						"url": "//forum.toiletology.org/uploads/default/optimized/1X/38155ca4fd5da01ff80b4c033c01af8eee0358fd_2_300x169.gif"
					},
					{
						"max_width": 200,
						"max_height": 200,
						"width": 200,
						"height": 112,
						"url": "//forum.toiletology.org/uploads/default/optimized/1X/38155ca4fd5da01ff80b4c033c01af8eee0358fd_2_200x112.gif"
					}
				],
				"tags": [],
				"tags_descriptions": {},
				"views": 8,
				"like_count": 0,
				"has_summary": false,
				"last_poster_username": "hipp0",
				"category_id": 23,
				"pinned_globally": false,
				"featured_link": null,
				"has_accepted_answer": false,
				"can_vote": false,
				"posters": [
					{
						"extras": "latest single",
						"description": "Original Poster, Most Recent Poster",
						"user_id": 2,
						"primary_group_id": null,
						"flair_group_id": 59
					}
				]
			},
			{
				"fancy_title": "She’s the first to rise to the top of the ranks!",
				"fancy_title_localized": false,
				"locale": null,
				"id": 69,
				"title": "She’s the first to rise to the top of the ranks!",
				"slug": "she-s-the-first-to-rise-to-the-top-of-the-ranks",
				"posts_count": 1,
				"reply_count": 0,
				"highest_post_number": 1,
				"image_url": "//forum.toiletology.org/uploads/default/optimized/1X/583df9505d1bf515c39e19773d4b7de53930c062_2_821x1024.jpeg",
				"created_at": "2026-01-02T00:27:26.310Z",
				"last_posted_at": "2026-01-02T00:27:26.383Z",
				"bumped": true,
				"bumped_at": "2026-01-02T00:27:26.383Z",
				"archetype": "regular",
				"unseen": false,
				"pinned": false,
				"unpinned": null,
				"excerpt": "She’s the first to rise to the top of the ranks!\n\n\nIt took her 11 years to do it but she finally reached the #1 rank of Toiletology aka &hellip;",
				"visible": true,
				"closed": false,
				"archived": false,
				"bookmarked": null,
				"liked": null,
				"thumbnails": [
					{
						"max_width": null,
						"max_height": null,
						"width": 1080,
						"height": 1346,
						"url": "//forum.toiletology.org/uploads/default/original/1X/583df9505d1bf515c39e19773d4b7de53930c062.jpeg"
					},
					{
						"max_width": 1024,
						"max_height": 1024,
						"width": 821,
						"height": 1024,
						"url": "//forum.toiletology.org/uploads/default/optimized/1X/583df9505d1bf515c39e19773d4b7de53930c062_2_821x1024.jpeg"
					},
					{
						"max_width": 800,
						"max_height": 800,
						"width": 641,
						"height": 800,
						"url": "//forum.toiletology.org/uploads/default/optimized/1X/583df9505d1bf515c39e19773d4b7de53930c062_2_641x800.jpeg"
					},
					{
						"max_width": 600,
						"max_height": 600,
						"width": 481,
						"height": 600,
						"url": "//forum.toiletology.org/uploads/default/optimized/1X/583df9505d1bf515c39e19773d4b7de53930c062_2_481x600.jpeg"
					},
					{
						"max_width": 400,
						"max_height": 400,
						"width": 320,
						"height": 400,
						"url": "//forum.toiletology.org/uploads/default/optimized/1X/583df9505d1bf515c39e19773d4b7de53930c062_2_320x400.jpeg"
					},
					{
						"max_width": 300,
						"max_height": 300,
						"width": 240,
						"height": 300,
						"url": "//forum.toiletology.org/uploads/default/optimized/1X/583df9505d1bf515c39e19773d4b7de53930c062_2_240x300.jpeg"
					},
					{
						"max_width": 200,
						"max_height": 200,
						"width": 160,
						"height": 200,
						"url": "//forum.toiletology.org/uploads/default/optimized/1X/583df9505d1bf515c39e19773d4b7de53930c062_2_160x200.jpeg"
					}
				],
				"tags": [],
				"tags_descriptions": {},
				"views": 7,
				"like_count": 0,
				"has_summary": false,
				"last_poster_username": "hipp0",
				"category_id": 23,
				"pinned_globally": false,
				"featured_link": null,
				"has_accepted_answer": false,
				"can_vote": false,
				"posters": [
					{
						"extras": "latest single",
						"description": "Original Poster, Most Recent Poster",
						"user_id": 2,
						"primary_group_id": null,
						"flair_group_id": 59
					}
				]
			},
			{
				"fancy_title": "In the beginning the Toilet God was mathematical",
				"fancy_title_localized": false,
				"locale": null,
				"id": 68,
				"title": "In the beginning the Toilet God was mathematical",
				"slug": "in-the-beginning-the-toilet-god-was-mathematical",
				"posts_count": 1,
				"reply_count": 0,
				"highest_post_number": 1,
				"image_url": null,
				"created_at": "2026-01-02T00:26:10.359Z",
				"last_posted_at": "2026-01-02T00:26:10.436Z",
				"bumped": true,
				"bumped_at": "2026-01-02T00:26:10.436Z",
				"archetype": "regular",
				"unseen": false,
				"pinned": false,
				"unpinned": null,
				"excerpt": ".welcome-banner__title { \nposition: relative; \ndisplay: inline-block; \ncolor: #ffffff; \ntext-shadow: 0 0 10px #8e0086; \nopacity: 0; \npadding-right: 30px; \nleft: 50%; \ntransform: translateX(-50%); \nanimation: fadeIn 2s forwards; \n} \n.welcome-banner__title:&hellip;",
				"visible": true,
				"closed": false,
				"archived": false,
				"bookmarked": null,
				"liked": null,
				"thumbnails": null,
				"tags": [],
				"tags_descriptions": {},
				"views": 3,
				"like_count": 0,
				"has_summary": false,
				"last_poster_username": "hipp0",
				"category_id": 23,
				"pinned_globally": false,
				"featured_link": null,
				"has_accepted_answer": false,
				"can_vote": false,
				"posters": [
					{
						"extras": "latest single",
						"description": "Original Poster, Most Recent Poster",
						"user_id": 2,
						"primary_group_id": null,
						"flair_group_id": 59
					}
				]
			},
			{
				"fancy_title": "Beaver Theory :beaver:",
				"fancy_title_localized": false,
				"locale": null,
				"id": 66,
				"title": "Beaver Theory 🦫",
				"slug": "beaver-theory",
				"posts_count": 1,
				"reply_count": 0,
				"highest_post_number": 1,
				"image_url": "//forum.toiletology.org/uploads/default/original/1X/6360b5604ac897b11b22991ad11baa3d0107319f.gif",
				"created_at": "2026-01-01T23:04:01.423Z",
				"last_posted_at": "2026-01-01T23:04:01.516Z",
				"bumped": true,
				"bumped_at": "2026-01-01T23:04:01.516Z",
				"archetype": "regular",
				"unseen": false,
				"pinned": false,
				"unpinned": null,
				"excerpt": "test this is a test testing im testing",
				"visible": true,
				"closed": false,
				"archived": false,
				"bookmarked": null,
				"liked": null,
				"thumbnails": [
					{
						"max_width": null,
						"max_height": null,
						"width": 220,
						"height": 165,
						"url": "//forum.toiletology.org/uploads/default/original/1X/6360b5604ac897b11b22991ad11baa3d0107319f.gif"
					},
					{
						"max_width": 200,
						"max_height": 200,
						"width": 200,
						"height": 150,
						"url": "//forum.toiletology.org/uploads/default/optimized/1X/6360b5604ac897b11b22991ad11baa3d0107319f_2_200x150.gif"
					}
				],
				"tags": [
					"holofractal",
					"vesica-pisces",
					"ooze",
					"karma",
					"beaver"
				],
				"tags_descriptions": {},
				"views": 11,
				"like_count": 0,
				"has_summary": false,
				"last_poster_username": "hipp0",
				"category_id": 23,
				"pinned_globally": false,
				"featured_link": null,
				"has_accepted_answer": false,
				"can_vote": false,
				"posters": [
					{
						"extras": "latest single",
						"description": "Original Poster, Most Recent Poster",
						"user_id": 2,
						"primary_group_id": null,
						"flair_group_id": 59
					}
				]
			}
		]'); # $topic_list['topics'];
        return view('blog.index', ['topics' => $topics, 'months_by_group' => $this->getMonthsByGroup(2026)]);
    }
}
