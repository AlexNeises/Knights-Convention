<html>
	<head>
		<title>Kansas Knights Convention 2019</title>
		<link href="<?php echo site_url('static/bootstrap/dist/css/bootstrap.min.css'); ?>?<?php echo time(); ?>" rel="stylesheet" />
		<link href="<?php echo site_url('static/tether/css/tether.min.css'); ?>" rel="stylesheet" />
	</head>
	<body class="site">
		<div class="container-fluid container-header">
			<h1><?php echo $logo; ?></h1>
		</div>
		<main class="site-content">
			<div class="header-img">
				<div class="text-box">
					<p class="top-text"><?php echo isset($top_text) ? $top_text : null; ?></p>
					<p class="bottom-text"><?php echo isset($bottom_text) ? $bottom_text : null; ?></p>
				</div>
				<div class="home"></div>
			</div>
			<div class="container">
				<div class="container-<?php echo $type; ?>">