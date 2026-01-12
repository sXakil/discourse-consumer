<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>The Church of Toiletology &#8211; The truth among the noise.</title>
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
	<div class="container-fluid mb-5 px-sm-5">
		<div class="row justify-content-center">
			<div class="col-12">
				@yield('content')
			</div>
		</div>
	</div>
	<footer>
		<hr>
		<div class="links">
			<a href="https://forum.toiletology.org">Forum</a>
			<a href="https://news.toiletology.org">News</a>
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
</body>

</html>
