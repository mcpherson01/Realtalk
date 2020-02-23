	<div id="footer-top">
		<!--Begin Footer Archives-->
		<div class="footerboxes">
			<h3><?php esc_html_e('Archives','TidalForce'); ?></h3>
			<ul>
				<?php wp_get_archives("type=monthly"); ?>
			</ul>
		</div>
		<!--End Footer Archives-->

		<!--Begin Footer Featured Posts-->
		<div class="footerboxes">
			<h3><?php esc_html_e('Featured Posts','TidalForce'); ?></h3>
			<ul>
				<?php
				$featured_cat = get_option('tidalforce_feat_cat');
				$featured_num = (int) get_option('tidalforce_feat_cat_foooternum');

				query_posts("posts_per_page=$featured_num&cat=".get_catId($featured_cat));
				while (have_posts()) : the_post(); 	?>
					<li>
						<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','TidalForce'), the_title()) ?>">
							<?php the_title(); ?>
						</a>
					</li>
				<?php endwhile; wp_reset_query(); ?>
			</ul>
		</div>
		<!--End Footer Featured Posts-->

		<!--Begin Footer RSS Links-->
		<div class="footerboxes">
			<h3 style="margin-left: 30px;"><?php esc_html_e('RSS Feeds','TidalForce'); ?></h3>
			<ul id="rssbox">
				<li><a href="<?php bloginfo('rss2_url'); ?>" rel="bookmark" title="RSS"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-rss.gif" alt="logo" style="border: none; margin-right: 8px; margin-bottom: -4px;" />RSS 2.0 Feed URL</a></li>
				<li><a href="<?php bloginfo('atom_url'); ?>" rel="bookmark" title="RSS"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-rss.gif" alt="logo" style="border: none; margin-right: 8px; margin-bottom: -4px;" />Atom Feed URL</a></li>
				<li><a href="<?php bloginfo('comments_rss2_url'); ?>" rel="bookmark" title="RSS"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-rss.gif" alt="logo" style="border: none; margin-right: 8px; margin-bottom: -4px;" />Comments RSS 2.0 Feed</a></li>
				<li><a href="<?php bloginfo('rdf_url'); ?>" rel="bookmark" title="RSS"> <img src="<?php echo get_template_directory_uri(); ?>/images/icon-rss.gif" alt="logo" style="border: none; margin-right: 8px; margin-bottom: -4px;" /> RSS/RDF 1.0 Feed URL</a></li>
			</ul>
		</div>
		<!--End Footer RSS Links-->
		<div style="clear: both;"></div>
	</div> <!-- end #footer-top -->


	<!--Begin Footer-->
	<div id="footer">
		<img src="<?php echo get_template_directory_uri(); ?>/images/footer-left.gif" alt="logo" style="float:left;" />
		<div id="footer-inside">
			<?php esc_html_e('Designed by ','TidalForce'); ?> <a href="http://www.elegantthemes.com" title="Elegant Themes">Elegant Themes</a> | <?php esc_html_e('Powered by ','TidalForce'); ?> <a href="http://www.wordpress.org">Wordpress</a>
		</div>
		<img src="<?php echo get_template_directory_uri(); ?>/images/footer-right.gif" alt="logo" style="float:left;" />
	</div>
	<div style="clear: both;"></div>
	<!--End Footer-->
</div>

<?php get_template_part('includes/scripts'); ?>
<?php wp_footer(); ?>