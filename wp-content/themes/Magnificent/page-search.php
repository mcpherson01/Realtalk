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

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<?php get_template_part('includes/breadcrumbs'); ?>

<?php if (get_option('magnificent_integration_single_top') <> '' && get_option('magnificent_integrate_singletop_enable') == 'on') echo(get_option('magnificent_integration_single_top')); ?>

	<div id="entries"<?php if ($fullwidth) echo ' class="fullwidth"'; ?>>
		<div class="entry post entry-full">
			<div class="border">
				<div class="bottom">
					<div class="entry-content clearfix">
						<h1 class="title"><?php the_title(); ?></h1>


						<?php if (get_option('magnificent_page_thumbnails') == 'on') { ?>

							<?php $thumb = '';
							$width = 218;
							$height = 218;
							$classtext = '';
							$titletext = get_the_title();

							$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
							$thumb = $thumbnail["thumb"]; ?>

							<?php if($thumb <> '') { ?>
								<div class="thumbnail">
									<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
									<span class="overlay"></span>
								</div> 	<!-- end .thumbnail -->
							<?php }; ?>

						<?php }; ?>

						<?php the_content(); ?>
						<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','Magnificent').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

						<div id="et-search">
							<div id="et-search-inner" class="clearfix">
								<p id="et-search-title"><span><?php esc_html_e('search this website','Magnificent'); ?></span></p>
								<form action="<?php echo esc_url( home_url() ); ?>" method="get" id="et_search_form">
									<div id="et-search-left">
										<p id="et-search-word"><input type="text" id="et-searchinput" name="s" value="<?php esc_attr_e('search this site...','Magnificent'); ?>" /></p>

										<p id="et_choose_posts"><label><input type="checkbox" id="et-inc-posts" name="et-inc-posts" /> <?php esc_html_e('Posts','Magnificent'); ?></label></p>
										<p id="et_choose_pages"><label><input type="checkbox" id="et-inc-pages" name="et-inc-pages" /> <?php esc_html_e('Pages','Magnificent'); ?></label></p>
										<p id="et_choose_date">
											<select id="et-month-choice" name="et-month-choice">
												<option value="no-choice"><?php esc_html_e('Select a month','Magnificent'); ?></option>
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
										<input class="et_search_submit" type="submit" value="<?php esc_attr_e('Submit','Magnificent'); ?>" id="et_search_submit" />
									</div> <!-- #et-search-right -->
								</form>
							</div> <!-- end #et-search-inner -->
						</div> <!-- end #et-search -->

						<div class="clear"></div>

						<?php edit_post_link(esc_html__('Edit this page','Magnificent')); ?>

					</div> <!-- end .entry-content -->
				</div> <!-- end .bottom -->
			</div> <!-- end .border -->
		</div> <!-- end .entry -->

		<div class="clear"></div>

		<?php if (get_option('magnificent_integration_single_bottom') <> '' && get_option('magnificent_integrate_singlebottom_enable') == 'on') echo(get_option('magnificent_integration_single_bottom')); ?>

	</div> <!-- end #entries -->

<?php endwhile; endif; ?>

	<?php if (!$fullwidth) { ?>
		<div id="sidebar-right" class="sidebar">
			<div class="block">
				<div class="block-border">
					<div class="block-content">
						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar Right Top') ) : ?>
						<?php endif; ?>
					</div> <!-- end .block-content -->
				</div> <!-- end .block-border -->
			</div> <!-- end .block -->

			<div class="block">
				<div class="block-border">
					<div class="block-content">
						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar Right Bottom') ) : ?>
						<?php endif; ?>
					</div> <!-- end .block-content -->
				</div> <!-- end .block-border -->
			</div> <!-- end .block -->
		</div> <!-- end #sidebar-right -->
	<?php }  ?>

<?php get_footer(); ?>