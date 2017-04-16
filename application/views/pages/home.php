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
								<?php if (ENVIRONMENT == 'production') : ?>
									<?php $time = strtotime($item['submitted_on']) + 2 * 60 * 60; ?>
								<?php else : ?>
									<?php $time = strtotime($item['submitted_on']); ?>
								<?php endif; ?>
								<div><small>Posted <?php echo date('F j, Y', $time); ?> at <?php echo date('g:i A', $time); ?></small></div>
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