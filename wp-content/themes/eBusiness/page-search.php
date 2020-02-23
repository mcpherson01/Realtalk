<?php
/*
Template Name: Search Page
*/
?>
<?php
	$et_ptemplate_settings = array();
	$et_ptemplate_settings = maybe_unserialize( get_post_meta(get_the_ID(),'et_ptemplate_settings',true) );

	$fullwidth = isset( $et_ptemplate_settings['et_fullwidthpage'] ) ? (bool) $et_ptemplate_settings['et_fullwidthpage'] : false;
?>

<?php get_header(); ?>

<?php if (get_option('ebusiness_blog_style') == 'Blog Based') : ?>

	<?php if (get_option('ebusiness_categories') == 'on') : ?>
	<div id="categories"> <img src="<?php echo get_template_directory_uri(); ?>/images/categories-left-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="line" style="float: left;" />
		<?php $menuClass = 'nav superfish';
		$menuID = 'nav2';
		$secondaryNav = '';
		if (function_exists('wp_nav_menu')) {
			$secondaryNav = wp_nav_menu( array( 'theme_location' => 'secondary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'menu_id' => $menuID, 'echo' => false ) );
		};
		if ($secondaryNav == '') { ?>
			<ul id="<?php echo esc_attr( $menuID ); ?>" class="<?php echo esc_attr( $menuClass ); ?>">
				<?php show_categories_menu($menuClass,false); ?>
			</ul> <!-- end ul#nav -->
		<?php }
		else echo($secondaryNav); ?>
		<img src="<?php echo get_template_directory_uri(); ?>/images/categories-right-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="line" style="float: left;" /> </div>
	<?php endif; ?>

<?php endif; ?>

<div id="container">
   	<div id="left-div<?php if ($fullwidth) echo('-full'); ?>">
        <!--Start Post-->
        <div class="home-post-wrap-2">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <h1 class="titles"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','eBusiness'), get_the_title()) ?>">
                <?php the_title() ?>
                </a></h1>
            <?php $desc = get_post_meta($post->ID, 'Description', $single = true); ?>
            <?php if($desc != '') { ?>
            <div class="post-info-wrap"> <img src="<?php echo get_template_directory_uri(); ?>/images/home-title-2-left-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="home title" class="home-title-image" /> <span class="post-info"><?php echo esc_html($desc); ?></span> <img src="<?php echo get_template_directory_uri(); ?>/images/home-title-2-right-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="home title" class="home-title-image" /> </div>
            <?php } ?>
            <div style="clear: both;"></div>

			<?php if (get_option('ebusiness_page_thumbnails') == 'on') { ?>

				<?php $width = (int) get_option('ebusiness_thumbnail_width_pages');
					  $height = (int) get_option('ebusiness_thumbnail_height_pages');
					  $classtext = 'thumbnail';
					  $titletext = get_the_title();

				      $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
					  $thumb = $thumbnail["thumb"];  ?>

				<?php if($thumb != '') { ?>
					<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','eBusiness'), get_the_title()) ?>">
						<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
					</a>
				<?php } ?>

			<?php } ?>

            <?php the_content(''); ?>

			<div id="et-search">
				<div id="et-search-inner" class="clearfix">
					<p id="et-search-title"><span><?php esc_html_e('search this website','eBusiness'); ?></span></p>
					<form action="<?php echo esc_url( home_url() ); ?>" method="get" id="et_search_form">
						<div id="et-search-left">
							<p id="et-search-word"><input type="text" id="et-searchinput" name="s" value="<?php esc_attr_e('search this site...','eBusiness'); ?>" /></p>

							<p id="et_choose_posts"><label><input type="checkbox" id="et-inc-posts" name="et-inc-posts" /> <?php esc_html_e('Posts','eBusiness'); ?></label></p>
							<p id="et_choose_pages"><label><input type="checkbox" id="et-inc-pages" name="et-inc-pages" /> <?php esc_html_e('Pages','eBusiness'); ?></label></p>
							<p id="et_choose_date">
								<select id="et-month-choice" name="et-month-choice">
									<option value="no-choice"><?php esc_html_e('Select a month','eBusiness'); ?></option>
									<?php
										global $wpdb, $wp_locale;

										$selected = '';
										$arcresults = $wpdb->get_results(
											$wpdb->prepare( "SELECT YEAR(post_date) AS %s, MONTH(post_date) AS %s, count(ID) as posts FROM $wpdb->posts GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC", 'year', 'month' )
										);

										foreach ( (array) $arcresults as $arcresult ) {
											if ( isset($_POST['et-month-choice']) && ( $_POST['et-month-choice'] == ($arcresult->year . $arcresult->month) ) ) {
												$selected = ' selected="selected"';
											}
											echo "<option value='{$arcresult->year}{$arcresult->month}'{$selected}>{$wp_locale->get_month($arcresult->month)}" . ", {$arcresult->year}</option>";
											if ( $selected <> '' ) $selected = '';
										}
									?>
								</select>
							</p>

							<p id="et_choose_cat"><?php wp_dropdown_categories('show_option_all=Choose a Category&show_count=1&hierarchical=1&id=et-cat&name=et-cat'); ?></p>
						</div> <!-- #et-search-left -->

						<div id="et-search-right">
							<input type="hidden" name="et_searchform_submit" value="et_search_proccess" />
							<input class="et_search_submit" type="submit" value="<?php esc_attr_e('Submit','eBusiness'); ?>" id="et_search_submit" />
						</div> <!-- #et-search-right -->
					</form>
				</div> <!-- end #et-search-inner -->
			</div> <!-- end #et-search -->

			<div class="clear"></div>

            <?php if (get_option('ebusiness_foursixeight') == 'on') { ?>
            <?php get_template_part('includes/468x60'); ?>
            <?php } else { echo ''; } ?>
		<?php endwhile; endif; ?>
	</div>
	</div>

	<?php if (!$fullwidth) { ?>
		<!--Begin Sidebar-->
		<div id="sidebar">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Pages") ) : ?>
			<?php endif; ?>
		</div>
		<!--End Sidebar-->
	<?php } ?>
    <img src="<?php echo get_template_directory_uri(); ?>/images/content-bg-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="line" style="float: left; margin-top: 15px;" /> </div>
<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</body></html>