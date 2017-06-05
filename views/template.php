<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<head>
	<title><?= $title; ?></title>

	<style type="text/css">
		body {
			font-family: sans-serif;
			font-weight: 300;
			max-width: 700px;
			margin: auto;
			color: #525252;
		}

		pre {
			border: 1px solid #525252;
			padding: 10px;
			overflow-x: auto;
		}
	</style>
</head>
<body>
	<header>
		<h1>Wafer</h1>
		<nav>
			<ul>
				<li><a href="/">Home</a></li>
				<li><a href="subpage">Example Subpage</a></li>
			</ul>
		</nav>
	</header>
	<div class="main">
		<?php 
		//Include this function where you want to pull in your page view
		getPageContent(); ?>
	</div>
	
</body>
</html>