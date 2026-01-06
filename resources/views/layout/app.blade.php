<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>The Church of Toiletology &#8211; The truth among the noise.</title>
	<link href="{{ asset('bs5/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>

<body>
	<a href="{{ url('/') }}" class="header">
		<h1 class="text-center my-4">The Church of Toiletology</h1>
		<img class="d-block" src="{{ asset('logo.png') }}" alt="The Church of Toiletology Logo">
	</a>
	<hr>
	@yield('content')
	<footer>
		<div class="links">
			<a href="https://forum.toiletology.org">Forum</a>
			<a href="https://news.toiletology.org">News</a>
			<a href="https://anti.biz/toiletology">Store</a>
			<a href="https://toiletology.org/donate">Donate</a>
			<a href="https://anti.biz/goosexxx">Promote</a>
			<a href="https://toiletology.org/faq">FAQ</a>
		</div>
		<hr>
		<p class="copy">
			Copyright © {{ date('Y') }},
			<a href="https://toiletology.org">
				<u>Toiletology.org</u>
			</a>
		</p>
	</footer>
	<script src="{{ asset('bs5/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
