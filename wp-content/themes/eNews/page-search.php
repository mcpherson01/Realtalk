<?php
/*
Template Name: Search Page
*/
?>
<?php get_header(); ?>
<?php
	$et_ptemplate_settings = array();
	$et_ptemplate_settings = maybe_unserialize( get_post_meta(get_the_ID(),'et_ptemplate_settings',true) );

	$fullwidth = isset( $et_ptemplate_settings['et_fullwidthpage'] ) ? (bool) $et_ptemplate_settings['et_fullwidthpage'] : false;
?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<div id="post-top">
	<div class="breadcrumb">
		<?php if(function_exists('bcn_display')) { bcn_display(); }
		else { ?>
			<?php esc_html_e('You are currently viewing','eNews') ?>: <em><?php the_title() ?></em>
		<?php }; ?>
	</div> <!-- end breadcrumb -->
</div> <!-- end post-top -->

<div id="main-area-wrap" <?php if($fullwidth) echo ('class="no_sidebar"');?>>
	<div id="wrapper">
		<div id="main" class="noborder">
			<h1 class="page-title"><?php the_title() ?></h1>
			<div id="post-content">

				<?php $width = (int) get_option('enews_thumbnail_width_pages');
					  $height = (int) get_option('enews_thumbnail_height_pages');
					  $classtext = 'thumbnail alignleft';
					  $titletext = get_the_title();

				$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
				$thumb = $thumbnail["thumb"];  ?>

				<?php if($thumb <> '' && get_option('enews_page_thumbnails') == 'on') { ?>
					<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
				<?php }; ?>

				<?php the_content(); ?>
					<div id="et-search">
						<div id="et-search-inner" class="clearfix">
							<p id="et-search-title"><span><?php esc_html_e('search this website','eNews'); ?></span></p>
							<form action="<?php echo esc_url( home_url() ); ?>" method="get" id="et_search_form">
								<div id="et-search-left">
									<p id="et-search-word"><input type="text" id="et-searchinput" name="s" value="<?php esc_attr_e('search this site...','eNews'); ?>" /></p>

									<p id="et_choose_posts"><label><input type="checkbox" id="et-inc-posts" name="et-inc-posts" /> <?php esc_html_e('Posts','eNews'); ?></label></p>
									<p id="et_choose_pages"><label><input type="checkbox" id="et-inc-pages" name="et-inc-pages" /> <?php esc_html_e('Pages','eNews'); ?></label></p>
									<p id="et_choose_date">
										<select id="et-month-choice" name="et-month-choice">
											<option value="no-choice"><?php esc_html_e('Select a month','eNews'); ?></option>
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
									<input class="et_search_submit" type="submit" value="<?php esc_attr_e('Submit','eNews'); ?>" id="et_search_submit" />
								</div> <!-- #et-search-right -->
							</form>
						</div> <!-- end #et-search-inner -->
					</div> <!-- end #et-search -->
				<?php edit_post_link(esc_html__('Edit this page','eNews')); ?>

			</div> <!-- end post-content -->
			<br class="clearfix"/>
			<?php if (get_option('enews_show_pagescomments') == 'on') comments_template('', true); ?>

		</div> <!-- end main -->
<?php endwhile; endif; ?>
<?php if (!$fullwidth) get_sidebar(); ?>
<?php get_footer(); ?>