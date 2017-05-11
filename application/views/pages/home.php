			<div class="show-for-large row expanded">
				<div class="logo-bg small-8 columns">
					<div class="row">
						<div class="top small-12 columns">
							<h1>Kansas Knights State Convention</h1>
							<h2>Manhattan 2019</h2>
							<p>The Kansas Knights of Columbus State Convention will be held from May 2nd until May 4th of 2019 in Manhattan, Kansas.  This is the 118th state convention for Kansas since 1901.</p>
							<?php if ($this->session->userdata('logged_in')) : ?>
								<p>Get ready for the convention, <?php echo $this->session->userdata('first_name'); ?>.</p>
								<p>The first thing you'll need to do is actually register yourself and your guests for the convention.</p>
								<p>When the registration opens, you will receive an email notifying you of what do to next.</p>
							<?php else : ?>
								<p>If you do not have an account, you will need to register. Otherwise, you can log in and register yourself and any guests for the 2019 convention.</p>
								<div class="row">
									<div class="small-12 large-4 large-offset-2 columns">
										<a href="<?php echo base_url('/register'); ?>" class="button expanded success">Register</a>
									</div>
									<div class="small-12 large-4 columns">
										<a href="<?php echo base_url('/login'); ?>" class="expanded button">Login</a>
									</div>
								</div>
							<?php endif; ?>
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
					<p>The Kansas Knights of Columbus State Convention will be held from May 2nd until May 4th of 2019 in Manhattan, Kansas.  This is the 118th state convention for Kansas since 1901.</p>
					<?php if ($this->session->userdata('logged_in')) : ?>
						<p>Get ready for the convention, <?php echo $this->session->userdata('first_name'); ?>.</p>
						<p>The first thing you'll need to do is actually register yourself and your guests for the convention.</p>
						<p>When the registration opens, you will receive an email notifying you of what do to next.</p>
					<?php else : ?>
						<p>If you do not have an account, you will need to register. Otherwise, you can log in and register yourself and any guests for the 2019 convention.</p>
						<div class="row">
							<div class="small-12 large-4 large-offset-2 columns">
								<a href="<?php echo base_url('/register'); ?>" class="button expanded success">Register</a>
							</div>
							<div class="small-12 large-4 columns">
								<a href="<?php echo base_url('/login'); ?>" class="expanded button">Login</a>
							</div>
						</div>
					<?php endif; ?>
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