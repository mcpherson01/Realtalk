<div class="share">
	<span class="share_button"><?php esc_html_e('share','LightBright'); ?></span>

	<div class="share-box">
		<div class="buttons">
			<?php #if (function_exists('simple_url_shortener')) { ?>
				<?php #$permalink = simple_url_shortener(get_permalink(),'service=is.gd&cache=no'); ?>
			<?php #} else { ?>
				<?php $permalink = get_permalink(); ?>
			<?php #}; ?>

			<a href="http://twitter.com/home?status=<?php the_title(); echo(' '); echo esc_url($permalink); ?>">
				<img src="<?php echo get_template_directory_uri(); ?>/images/share-icon1.png" alt="" />
				<span class="tooltip">
					<?php esc_html_e('tweet this post','LightBright'); ?>
					<span class="left-arrow"></span>
				</span>
			</a>
			<a href="http://del.icio.us/post?url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>">
				<img src="<?php echo get_template_directory_uri(); ?>/images/share-icon2.png" alt="" />
				<span class="tooltip">
					<?php esc_html_e('share on delicious','LightBright'); ?>
					<span class="left-arrow"></span>
				</span>
			</a>
			<a href="http://www.digg.com/submit?phase=2&amp;url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>">
				<img src="<?php echo get_template_directory_uri(); ?>/images/share-icon3.png" alt="" />
				<span class="tooltip">
					<?php esc_html_e('dig this post','LightBright'); ?>
					<span class="left-arrow"></span>
				</span>
			</a>
			<a href="http://www.stumbleupon.com/submit?url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>">
				<img src="<?php echo get_template_directory_uri(); ?>/images/share-icon4.png" alt="" />
				<span class="tooltip">
					<?php esc_html_e('share on stumbleupon','LightBright'); ?>
					<span class="left-arrow"></span>
				</span>
			</a>
			<a href="http://www.squidoo.com/lensmaster/bookmark?<?php the_permalink() ?>">
				<img src="<?php echo get_template_directory_uri(); ?>/images/share-icon5.png" alt="" />
				<span class="tooltip">
					<?php esc_html_e('share on squidoo','LightBright'); ?>
					<span class="left-arrow"></span>
				</span>
			</a>
			<a href="http://in.buzz.yahoo.com/buzz?targetUrl=<?php the_permalink(); ?>">
				<img src="<?php echo get_template_directory_uri(); ?>/images/share-icon6.png" alt="" />
				<span class="tooltip">
					<?php esc_html_e('share on yahoo buzz','LightBright'); ?>
					<span class="left-arrow"></span>
				</span>
			</a>
			<a href="http://www.blinklist.com/index.php?Action=Blink/addblink.php&amp;Url=<?php the_permalink() ?>&amp;Title=<?php the_title(); ?>">
				<img src="<?php echo get_template_directory_uri(); ?>/images/share-icon7.png" alt="" />
				<span class="tooltip">
					<?php esc_html_e('share on blinklist','LightBright'); ?>
					<span class="left-arrow"></span>
				</span>
			</a>
			<a href="http://www.mixx.com/submit?page_url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>">
				<img src="<?php echo get_template_directory_uri(); ?>/images/share-icon8.png" alt="" />
				<span class="tooltip">
					<?php esc_html_e('share on mixx','LightBright'); ?>
					<span class="left-arrow"></span>
				</span>
			</a>
			<a href="http://www.furl.net/storeIt.jsp?t=<?php the_title(); ?>&amp;u=<?php the_permalink() ?>">
				<img src="<?php echo get_template_directory_uri(); ?>/images/share-icon9.png" alt="" />
				<span class="tooltip">
					<?php esc_html_e('share on furl','LightBright'); ?>
					<span class="left-arrow"></span>
				</span>
			</a>
		</div> <!-- end .buttons -->

		<a href="#" class="arrow"></a>
	</div> <!-- end .share-box -->
</div> <!-- end .share -->