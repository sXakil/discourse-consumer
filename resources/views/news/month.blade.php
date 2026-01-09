@extends('layout.app')

@section('content')
	@empty($topics)
		<p class="text-center text-white">No news posts for this month.</p>
	@else
		<h3 class="text-center text-white mb-3">News from {{ $selected_month }}, {{ $selected_year }}</h3>
		@foreach ($topics as $topic)
			<article class="blog-post d-flex flex-column align-items-center flex-md-row gap-1 mb-4">
				<div class="d-flex flex-column flex-grow-1 w-100 w-md-auto">
					<h2>{{ $topic['title'] }}</h2>
					<div class="blog-meta">
						<span>{{ date('F j, Y', strtotime($topic['created_at'])) }}</span>
					</div>
					<p>{!! $topic['excerpt'] !!}</p>
					<a href="https://forum.toiletology.org/t/{{ $topic['slug'] }}/{{ $topic['id'] }}"
						class="read-more align-self-end">Read More</a>
				</div>
			</article>
		@endforeach
	@endempty
@endsection
