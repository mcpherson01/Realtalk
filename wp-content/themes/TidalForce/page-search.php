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

<div id="container">
	<div id="left-div" <?php if($fullwidth) echo (' class="no_sidebar"');?>>
		<div id="left-inside">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<!--Begin Post Single-->
			<div class="post-wrapper">
				<?php if (get_option('tidalforce_show_share') == 'on') get_template_part('includes/share');  ?>
				<h1 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','TidalForce'), the_title()) ?>">
					<?php the_title(); ?>
					</a></h1>
				<div style="clear: both;"></div>

				<?php if (get_option('tidalforce_page_thumbnails') == 'on') { ?>

					<?php $thumb = '';

					$width = (int) get_option('tidalforce_thumbnail_width_pages');
					$height = (int) get_option('tidalforce_thumbnail_height_pages');
					$classtext = '';
					$titletext = get_the_title();

					$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
					$thumb = $thumbnail["thumb"]; ?>

					<?php if($thumb <> '') { ?>
						<div class="thumbnail-div">
							<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
						</div>
					<?php }; ?>

				<?php }; ?>

				<?php the_content(); ?>
					<div id="et-search">
						<div id="et-search-inner" class="clearfix">
							<p id="et-search-title"><span><?php esc_html_e('search this website','TidalForce'); ?></span></p>
							<form action="<?php echo esc_url( home_url() ); ?>" method="get" id="et_search_form">
								<div id="et-search-left">
									<p id="et-search-word"><input type="text" id="et-searchinput" name="s" value="<?php esc_attr_e('search this site...','TidalForce'); ?>" /></p>

									<p id="et_choose_posts"><label><input type="checkbox" id="et-inc-posts" name="et-inc-posts" /> <?php esc_html_e('Posts','TidalForce'); ?></label></p>
									<p id="et_choose_pages"><label><input type="checkbox" id="et-inc-pages" name="et-inc-pages" /> <?php esc_html_e('Pages','TidalForce'); ?></label></p>
									<p id="et_choose_date">
										<select id="et-month-choice" name="et-month-choice">
											<option value="no-choice"><?php esc_html_e('Select a month','TidalForce'); ?></option>
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
									<input class="et_search_submit" type="submit" value="<?php esc_attr_e('Submit','TidalForce'); ?>" id="et_search_submit" />
								</div> <!-- #et-search-right -->
							</form>
						</div> <!-- end #et-search-inner -->
					</div> <!-- end #et-search -->

				<div style="clear: both;"></div>

				<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','TidalForce').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				<?php edit_post_link(esc_html__('Edit this page','TidalForce')); ?>

			</div>
			<img src="<?php echo get_template_directory_uri(); ?>/images/content-white-bottom<?php if ($fullwidth) echo ('-full');?>.gif" alt="bottom" style="margin-bottom: 7px; float: left;" />
			<!--End Post Single-->

			<?php if (get_option('tidalforce_show_pagescomments') == 'on') { ?>
				<!--Begin Comments Template-->
				<div class="recentposts">
					<?php comments_template('', true); ?>
				</div>
				<!--End Comments Template-->
			<?php }; ?>
		<?php endwhile; endif; ?>
		</div>
	</div>
	<!--Begin Sidebar-->
	<?php if (!$fullwidth) get_sidebar(); ?>
	<!--End Sidebar-->
</div>
<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</body>
</html>