			<div class="row">
				<div class="small-8 columns">

				</div>
				<div class="small-4 columns">
					<h3>News</h3>
					<?php for ($i = 0; $i < sizeof($news_item); $i++) : ?>
						<?php if ($i < 5) : ?>
							<div class="news_item">
								<?php $item = $news_item[$i]; ?>
								<h4><?php echo $item['title']; ?></h4>
								<em><?php echo $item['blurb']; ?>...</em>
								<div><small>Posted <?php echo date('F j, Y', strtotime($item['submitted_on'])); ?> at <?php echo date('g:i A', strtotime($item['submitted_on'])); ?></small></div>
								<a href="<?php echo site_url('news/' . $item['slug']); ?>">View article</a>
								<hr />
							</div>
						<?php endif; ?>
					<?php endfor; ?>
					<div class="padding-bottom">
						<a href="<?php echo site_url('news/'); ?>">View older items</a>
					</div>
				</div>
			</div>