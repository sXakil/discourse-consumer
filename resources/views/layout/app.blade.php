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
	<div class="d-flex justify-content-center">
		<a href="{{ url('/') }}" class="header">
			<h1 class="text-center my-4">The Church of Toiletology</h1>
			<img class="d-block" src="{{ asset('logo.png') }}" alt="The Church of Toiletology Logo">
		</a>
	</div>
	<hr>
	<div class="container mb-5">
		<div class="row">
			<div class="col-lg-8">
				@yield('content')
			</div>
			<div class="col-lg-4">
				<div class="collapse d-lg-block" id="sidebarCollapse">
					<aside class="sidebar">
						<h4>Archives</h4>
						@foreach ($months_by_group as $year => $months)
							<div class="year-group">
								<div class="year-header" data-bs-toggle="collapse" data-bs-target="#year{{ $year }}">
									<strong>{{ $year }}</strong> <span class="float-end">▼</span>
								</div>
								<ul class="month-list collapse show" id="year{{ $year }}">
									@foreach ($months as $month)
										<li class="@if (isset($selected_year) && isset($selected_month) && $year == $selected_year && $month['name'] == $selected_month) active @endif">
											<a href="{{ url($year . '/' . $month['name']) }}" class="text-decoration-none d-block">
												{{ $month['name'] }}
											</a>
										</li>
									@endforeach
								</ul>
							</div>
						@endforeach
					</aside>
				</div>
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
