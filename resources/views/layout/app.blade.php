<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	@php
		$title = isset($type) ? ucfirst($type) . ' - ' : '';
		$title .= 'The Church of Toiletology 🚽';
	@endphp
	<title>{{ $title }}</title>
	<meta name="description" content="The truth among the noise. 🪠">
	<meta property="og:site_name" content="The Church of Toiletology 🚽" />
	<meta property="og:type" content="website" />
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:image" content="{{ url()->current() . '/icons/meta.png' }}" />
	<meta property="og:image" content="{{ url()->current() . '/icons/meta.png' }}" />
	<meta property="og:url" content="{{ url()->current() }}" />
	<meta name="twitter:url" content="{{ url()->current() }}" />
	<meta property="og:title" content="The Church of Toiletology 🚽" />
	<meta name="twitter:title" content="The Church of Toiletology 🚽" />
	<meta property="og:description" content="The truth among the noise. 🪠" />
	<meta name="twitter:description" content="The truth among the noise. 🪠" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200..800&display=swap" rel="stylesheet">
	<link href="{{ asset('bs5/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>

<body>
	<div class="d-flex justify-content-center">
		<a href="{{ url('/') }}" class="header">
			<h1 class="text-center my-4">The Church of Toiletology</h1>
			<img class="d-block" src="{{ asset('logo.png') }}" alt="The Church of Toiletology Logo">
		</a>
	</div>
	<hr>
	<div class="main-container">
		@yield('content')
	</div>
	<footer>
		<hr>
		<div class="links">
			<a href="https://forum.toiletology.org">Forum</a>
			<a href="https://news.toiletology.org">News</a>
			<a href="https://radio.toiletology.org">Radio</a>
			<a href="https://lessons.toiletology.org">Lessons</a>
			<a href="https://anti.biz/toiletology">Store</a>
			<a href="https://toiletology.org/donate">Donate</a>
			<a href="https://anti.biz/goosexxx">Promote</a>
			<a href="https://toiletology.org/faq">FAQ</a>
		</div>
		<p class="copy">
			Copyright © {{ date('Y') }} &middot;
			<a href="https://toiletology.org">
				<u>Toiletology.org</u>
			</a>
		</p>
	</footer>
	<script src="{{ asset('bs5/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('js/imagesloaded.pkgd.min.js') }}"></script>
	<script src="{{ asset('js/masonry.pkgd.min.js') }}"></script>
	@yield('scripts')
</body>

</html>
