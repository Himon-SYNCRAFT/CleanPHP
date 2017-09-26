<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>CleanPhp</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css"
		media="screen" rel="stylesheet" type="text/css">
		<link href="/css/application.css" media="screen"
		rel="stylesheet" type="text/css">
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="/">CleanPhp</a>
				</div>
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li>
							<a href="/customers">Customers</a>
						</li>
						<li>
							<a href="/orders">Orders</a>
						</li>
						<li>
							<a href="/invoices">Invoices</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container">
			<?php if (Session::has('success')): ?>
			<div class="alert alert-success"><?= Session::get('success') ?></div>
			<?php endif; ?>
			@yield('content')
			<hr>
			<footer>
				<p>I'm the footer.</p>
			</footer>
		</div>
	</body>
</html>
