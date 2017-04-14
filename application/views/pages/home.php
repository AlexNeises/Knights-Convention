				<div class="main-info">

				</div>
				<div class="news">
					<h3>News</h3>
					<?php for ($i = 0; $i < sizeof($news_item); $i++) : ?>
						<?php if ($i < 5) : ?>
							<div class="news_item">
								<?php $item = $news_item[$i]; ?>
								<h4><?php echo $item['title']; ?></h4>
								<p><?php echo $item['text']; ?></p>
								<hr />
							</div>
						<?php endif; ?>
					<?php endfor; ?>
				</div>