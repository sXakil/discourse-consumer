@extends('layout.app')

@section('content')
	<div class="d-flex flex-column mb-6 position-relative">
		<div class="year-selector dropdown">
			<button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown"
				aria-expanded="false">
				Select Year ({{ $selected_year }})
			</button>
			<ul class="dropdown-menu dropdown-menu-end">
				@foreach ($stats as $year => $count)
					<li>
						@php
							$link = strlen($year) > 4 ? url('/') : url('/?year=' . $year);
						@endphp
						<a
							class="dropdown-item @if ($count === 0) empty @endif @if ($year == $selected_year) selected @endif"
							href="{{ $link }}">
							{{ $year }}
							&nbsp;
							@unless ($count === null)
								({{ $count }})
							@endunless
						</a>
					</li>
				@endforeach
			</ul>
		</div>
		@php
			$hasContent = false;
		@endphp
		@for ($i = 1; $i <= 12; $i++)
			@php
				$month_group = date('Y-m', mktime(0, 0, 0, $i, 10));
			@endphp
			@if (isset($topics[$month_group]) && count($topics[$month_group]) > 0)
				@php
					$hasContent = true;
				@endphp
				<h2 class="month-label mx-4 mb-5">{{ date('F Y', strtotime($month_group . '-01')) }}</h2>
				<div class="month-row">
					@php
						$m_topics = $topics[$month_group];
					@endphp
					@foreach ($m_topics as $topic)
						<div class="article-card">
							<figure class="article-thumbnail is-loading">
								@if (isset($topic['image_url']) && $topic['image_url'])
									<img src="{{ $topic['image_url'] }}" alt="Topic Image" loading="lazy">
								@else
									<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="#aaaaaa" viewBox="0 0 16 16">
										<path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
										<path
											d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9 9 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.4 10.4 0 0 1-.524 2.318l-.003.011a11 11 0 0 1-.244.637c-.079.186.074.394.273.362a22 22 0 0 0 .693-.125m.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6-3.004 6-7 6a8 8 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a11 11 0 0 0 .398-2" />
									</svg>
								@endif
							</figure>
							<h3 class="article-title">
								{{ $topic['title'] }}
							</h3>
							@isset($topic['user'])
								<p class="article-author">&mdash; {{ $topic['user']['username'] ?? '' }}</p>
							@endisset
							<a class="article-link" href="https://forum.toiletology.org/t/{{ $topic['slug'] }}/{{ $topic['id'] }}">
								<div class="article-timestamp">
									<span>{{ date('M j, Y', strtotime($topic['created_at'])) }}</span>
									<span>{{ $topic['posts_count'] - 1 }} post{{ $topic['posts_count'] - 1 != 1 ? 's' : '' }}</span>
								</div>
								<div class="article-tags">
									@foreach ($topic['tags'] as $tag)
										#{{ $tag['name'] }}
									@endforeach
								</div>
							</a>
						</div>
					@endforeach
				</div>
			@endif
		@endfor
		@if (!$hasContent)
			<p class="text-center text-white">No {{ $type }} posts available.</p>
		@endif
	</div>
@endsection

@section('scripts')
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			var viewWidth = document.documentElement.clientWidth - 20;
			var maxColumns = Math.floor(viewWidth / 300);
			var gapWidth = (maxColumns - 1) * 10;
			var columnWidth = (Math.floor((viewWidth - gapWidth) / maxColumns));

			var monthRows = document.querySelectorAll('.month-row');
			monthRows.forEach(function(monthRow) {
				var msnry = new Masonry(monthRow, {
					itemSelector: '.article-card',
					columnWidth: columnWidth,
					fitWidth: true,
					gutter: 10
				});

				msnry.layout();

				var thumbs = monthRow.querySelectorAll('.article-thumbnail img');
				var imgLoad = imagesLoaded(thumbs);

				imgLoad.on('progress', function(instance, image) {
					var status = image.isLoaded ? 'is-loaded' : 'is-broken';
					image.img.parentElement.classList.remove('is-loading');
					image.img.parentElement.classList.add(status);

					msnry.layout();
				});
			});
		});
	</script>
@endsection
