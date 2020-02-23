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
		<div class="entry<?php if($fullwidth) echo(' no_sidebar');?>">
			<div class="entry-top"></div>

			<?php get_template_part('includes/share'); ?>

			<div class="post clearfix">
				<div class="content clearfix">

					<h1 class="title"><?php the_title(); ?></h1>

					<div class="clear"></div>

					<?php $thumb = '';
						  $width = 184;
						  $height = 184;
						  $classtext = '';
						  $titletext = get_the_title();

						  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'thumb');
						  $thumb = $thumbnail["thumb"]; ?>

					<?php if($thumb <> '' && get_option('lightbright_page_thumbnails') == 'on') { ?>
						<div class="thumb">
							<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>

							<span class="overlay"></span>
						</div> <!-- end .thumb -->
					<?php }; ?>

					<?php the_content(); ?>
					<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','LightBright').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

					<div id="et-search">
						<div id="et-search-inner" class="clearfix">
							<p id="et-search-title"><span><?php esc_html_e('search this website','LightBright'); ?></span></p>
							<form action="<?php echo esc_url( home_url() ); ?>" method="get" id="et_search_form">
								<div id="et-search-left">
									<p id="et-search-word"><input type="text" id="et-searchinput" name="s" value="<?php esc_attr_e('search this site...','LightBright'); ?>" /></p>

									<p id="et_choose_posts"><label><input type="checkbox" id="et-inc-posts" name="et-inc-posts" /> <?php esc_html_e('Posts','LightBright'); ?></label></p>
									<p id="et_choose_pages"><label><input type="checkbox" id="et-inc-pages" name="et-inc-pages" /> <?php esc_html_e('Pages','LightBright'); ?></label></p>
									<p id="et_choose_date">
										<select id="et-month-choice" name="et-month-choice">
											<option value="no-choice"><?php esc_html_e('Select a month','LightBright'); ?></option>
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
									<input class="et_search_submit" type="submit" value="<?php esc_attr_e('Submit','LightBright'); ?>" id="et_search_submit" />
								</div> <!-- #et-search-right -->
							</form>
						</div> <!-- end #et-search-inner -->
					</div> <!-- end #et-search -->

					<div class="clear"></div>

					<?php edit_post_link(esc_html__('Edit this page','LightBright')); ?>

				</div> <!-- end .content -->

				<div class="entry-bottom-top"></div>

				<div class="entry-meta clearfix">
					<p class="meta"><span class="main"><?php esc_html_e('Posted by','LightBright');?> <?php the_author_posts_link(); ?></span> <span class="comment-count"><?php comments_popup_link('0','1','%'); ?></span></p>
					<?php if(!is_single()) { ?>
						<a href="<?php the_permalink(); ?>" class="readmore"><span><?php esc_html_e('read more','LightBright'); ?></span></a>
					<?php }; ?>
				</div> <!-- end .entry-meta -->

			</div> <!-- end .post -->

			<div class="entry-bottom"></div>
		</div> <!-- end .entry -->
	<?php endwhile; endif; ?>
	</div> <!-- end #main-area -->

	<?php if (!$fullwidth) get_sidebar(); ?>

<?php get_footer(); ?>