
	<div id="sidebar-wrapper">
		<?php if (get_option('tidalforce_show_sidebardark') == 'on') { ?>
			<div id="sidebardark" >
				<!--Begin Search Slider-->
				<p class="slide2"><a href="#" class="btn-slide2"><?php esc_html_e('search our blog','TidalForce'); ?></a></p>
				<div id="panel2">
					<div class="search_bg">
						<div id="search">
							<form method="get" action="<?php echo home_url(); ?>" style="padding:0px 0px 0px 0px; margin:0px 0px 0px 0px">
								<input type="text"  name="s" value="<?php echo esc_attr( get_search_query() ); ?>"/>
								<input type="image" class="input" src="<?php bloginfo('template_directory'); ?>/images/search.gif" value="submit"/>
							</form>
						</div>
					</div>
					<div style="clear: both;"></div>
				</div>
				<!--End Search Slider-->

				<!--Begin Subscribe Slider-->
				<p class="slide3"><a href="#" class="btn-slide3"><?php esc_html_e('subscribe to rss','TidalForce'); ?></a></p>
				<div id="panel3">
					<form action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
						<input value="Your email address" onfocus="clearDefault(this)" name="email" id="emailer" type="text" />
						<input value="<?php echo esc_attr(get_option('tidalforce_feed')); ?>" name="uri" type="hidden" /><br />
						<input value="Email Subscribe" name="title" type="hidden" />
						<input value="submit" class="feedsubmit" type="submit" />
					</form>
					<div style="clear: both;"></div>
				</div>
				<!--End Subscribe Slider-->

				<!--Begin Tags Slider-->
				<p class="slide4"><a href="#" class="btn-slide4"><?php esc_html_e('popular tags','TidalForce'); ?></a></p>
				<div id="panel4">
					<p class="panel-inside">
						<?php wp_tag_cloud(''); ?>
					</p>
				</div>
				<!--End Tags Slider-->

			</div> <!-- end #sidebardark -->
			<img src="<?php bloginfo('template_directory'); ?>/images/sidebar-dark-bottom.gif" alt="bottom" style="float: left;" />
		<?php }; ?>

		<div id="sidebar">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar') ) : ?>
			<?php endif; ?>
		</div> <!-- end #sidebar -->

	</div> <!-- end #sidebar-wrapper -->