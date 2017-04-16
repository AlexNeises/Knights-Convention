<?php foreach ($news as $news_item) : ?>
	<h3><?php echo $news_item['title']; ?></h3>
	<div class="main">
		<em><?php echo $news_item['blurb']; ?>...</em>
        <div><small>Posted <?php echo date('F j, Y', strtotime($news_item['submitted_on'])); ?> at <?php echo date('g:i A', strtotime($news_item['submitted_on'])); ?></small></div>
	</div>
	<p><a href="<?php echo site_url('news/' . $news_item['slug']); ?>">View article</a></p>
<?php endforeach; ?>