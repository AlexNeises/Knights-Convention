<html>
	<head>
		<title>Kansas Knights Convention 2019</title>
		<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
		<link href="<?php echo site_url('static/styles/dist/combined.min.css'); ?>?<?php echo time(); ?>" rel="stylesheet" />
		<link href="<?php echo site_url('static/images/logotiny.png'); ?>" type="image/png" rel="icon" />
	</head>
	<body class="site">
		<div class="header row expanded">
			<div class="small-12 columns">
				<a href="<?php echo site_url('/'); ?>"><div class="logo">Home</div></a>
			</div>
		</div>
		<main class="site-content">
			<div class="header-img">
				<div class="text-box">
					<p class="top-text"><?php echo isset($top_text) ? $top_text : null; ?></p>
					<?php if (isset($bottom_text) && $bottom_text == '--logo--') : ?>
						<p class="bottom-text-home"></p>
					<?php else : ?>
						<p class="bottom-text"><?php echo isset($bottom_text) ? $bottom_text : null; ?></p>
					<?php endif; ?>
				</div>
				<div class="home"></div>
			</div>
			<div class="row expanded gutter">
				<div class="small-12 columns">