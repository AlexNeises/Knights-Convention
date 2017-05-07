			<div class="show-for-large row">
				<div class="logo-bg small-8 columns">
					<div class="row">
						<div class="top small-12 columns">
							<h1>Kansas Knights State Convention</h1>
							<h2>Manhattan 2019</h2>
						</div>
					</div>
				</div>
				<div class="small-4 columns">
					<h3>News</h3>
					<?php for ($i = 0; $i < sizeof($news_item); $i++) : ?>
						<?php if ($i < 5) : ?>
							<div class="news_item">
								<?php $item = $news_item[$i]; ?>
								<h4><?php echo $item->get_title(); ?></h4>
								<em><?php echo $item->get_blurb(); ?>...</em>
								<?php if (ENVIRONMENT == 'production') : ?>
									<?php $time = strtotime($item->get_submitted_on()) + 2 * 60 * 60; ?>
								<?php else : ?>
									<?php $time = strtotime($item->get_submitted_on()); ?>
								<?php endif; ?>
								<div><small>Posted <?php echo date('F j, Y', $time); ?> at <?php echo date('g:i A', $time); ?></small></div>
								<a href="<?php echo base_url('news/' . $item->get_slug()); ?>">View article</a>
								<hr />
							</div>
						<?php endif; ?>
					<?php endfor; ?>
					<div class="padding-bottom">
						<a href="<?php echo base_url('news/'); ?>">View older items</a>
					</div>
				</div>
			</div>
			<div class="hide-for-large row">
				<div class="top small-12 columns">
					<h1>Kansas Knights State Convention</h1>
					<h2>Manhattan 2019</h2>
				</div>
			</div>
			<div class="hide-for-large row">
				<div class="small-12 columns">
					<h3>News</h3>
					<?php for ($i = 0; $i < sizeof($news_item); $i++) : ?>
						<?php if ($i < 5) : ?>
							<div class="news_item">
								<?php $item = $news_item[$i]; ?>
								<h4><?php echo $item->get_title(); ?></h4>
								<em><?php echo $item->get_blurb(); ?>...</em>
								<?php if (ENVIRONMENT == 'production') : ?>
									<?php $time = strtotime($item->get_submitted_on()) + 2 * 60 * 60; ?>
								<?php else : ?>
									<?php $time = strtotime($item->get_submitted_on()); ?>
								<?php endif; ?>
								<div><small>Posted <?php echo date('F j, Y', $time); ?> at <?php echo date('g:i A', $time); ?></small></div>
								<a href="<?php echo base_url('news/' . $item->get_slug()); ?>">View article</a>
								<hr />
							</div>
						<?php endif; ?>
					<?php endfor; ?>
					<div class="padding-bottom">
						<a href="<?php echo base_url('news/'); ?>">View older items</a>
					</div>
				</div>
			</div>