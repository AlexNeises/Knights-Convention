<?php foreach ($news as $news_item) : ?>
    <?php if (ENVIRONMENT == 'production') : ?>
        <?php $time = strtotime($news_item->get_submitted_on()) + 2 * 60 * 60; ?>
    <?php else : ?>
        <?php $time = strtotime($news_item->get_submitted_on()); ?>
    <?php endif; ?>
	<h3><?php echo $news_item->get_title(); ?></h3>
	<div class="main">
		<em><?php echo $news_item->get_blurb(); ?>...</em>
        <div><small>Posted <?php echo date('F j, Y', $time); ?> at <?php echo date('g:i A', $time); ?></small></div>
	</div>
	<p><a href="<?php echo base_url('news/' . $news_item->get_slug()); ?>">View article</a></p>
<?php endforeach; ?>
<br />
<div class="padding-bottom">
    <a href="<?php echo base_url('/'); ?>">Home</a>
</div>