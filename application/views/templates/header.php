<html>
    <head>
        <title>Kansas Knights Convention 2019</title>
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <link href="<?php echo base_url('static/styles/dist/combined.min.css'); ?>?<?php echo $version; ?>" rel="stylesheet" />
        <link href="<?php echo base_url('static/images/logotiny.png'); ?>" type="image/png" rel="icon" />
    </head>
    <body class="site">
        <?php include_once('analyticstracking.php'); ?>
        <div class="header row expanded">
            <div class="small-12 columns">
                <div class="row">
                    <div class="small-3 columns">
                        <a href="<?php echo base_url('/'); ?>"><div class="logo">Home</div></a>
                    </div>
                </div>
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
                    <?php if (!is_null($this->session->flashdata('alert'))) : ?>
                        <div class="row">
                            <div class="small-12 columns">
                                <div class="callout alert">
                                    <?php echo $this->session->flashdata('alert'); ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (!is_null($this->session->flashdata('success'))) : ?>
                        <div class="row">
                            <div class="small-12 columns">
                                <div class="callout success">
                                    <?php echo $this->session->flashdata('success'); ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>