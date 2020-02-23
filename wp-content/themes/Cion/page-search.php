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
<div id="container"<?php if ($fullwidth) echo ' class="no_sidebar"'; ?>>
<div id="left-div">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <!--Start Post-->
    <div class="home-post-wrap2">
		<?php if (get_option('cion_share_this_pages') == 'on') { ?>
			<?php get_template_part( 'includes/share' ); ?>
		<?php }; ?>
        <?php if (get_option('cion_integration_single_top') <> '' && get_option('cion_integrate_singletop_enable') == 'on') echo(get_option('cion_integration_single_top')); ?>

        <h1 class="titles"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','Cion'), get_the_title()) ?>">
            <?php the_title(); ?>
            </a></h1>

        <?php if (get_option('cion_page_thumbnails') == 'on') { ?>
			<?php $width = (int) get_option('cion_thumbnail_width_pages');
				  $height = (int) get_option('cion_thumbnail_height_pages');

				  $classtext = 'thumbnail';
				  $titletext = get_the_title();

				  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
				  $thumb = $thumbnail["thumb"]; ?>

			<?php if($thumb != '') { ?>
				<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','Cion'), get_the_title()) ?>" class="thumbnail-link">
					<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
				</a>
			<?php } ?>
        <?php }; ?>

        <?php the_content(); ?>
    </div>
        <div style="clear: both;"></div>

		<div id="et-search">
			<div id="et-search-inner" class="clearfix">
				<p id="et-search-title"><span><?php esc_html_e('search this website','Cion'); ?></span></p>
				<form action="<?php echo esc_url( home_url() ); ?>" method="get" id="et_search_form">
					<div id="et-search-left">
						<p id="et-search-word"><input type="text" id="et-searchinput" name="s" value="<?php esc_attr_e('search this site...','Cion'); ?>" /></p>

						<p id="et_choose_posts"><label><input type="checkbox" id="et-inc-posts" name="et-inc-posts" /> <?php esc_html_e('Posts','Cion'); ?></label></p>
						<p id="et_choose_pages"><label><input type="checkbox" id="et-inc-pages" name="et-inc-pages" /> <?php esc_html_e('Pages','Cion'); ?></label></p>
						<p id="et_choose_date">
							<select id="et-month-choice" name="et-month-choice">
								<option value="no-choice"><?php esc_html_e('Select a month','Cion'); ?></option>
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
						<input class="et_search_submit" type="submit" value="<?php esc_attr_e('Submit','Cion'); ?>" id="et_search_submit" />
					</div> <!-- #et-search-right -->
				</form>
			</div> <!-- end #et-search-inner -->
		</div> <!-- end #et-search -->

		<div class="clear"></div>

          <?php if (get_option('cion_integration_single_bottom') <> '' && get_option('cion_integrate_singlebottom_enable') == 'on') echo(get_option('cion_integration_single_bottom')); ?>
        <div style="clear: both;"></div>
	<?php endwhile; endif; ?>
</div>
<?php if($fullwidth) echo ('</div>');?>
<!--Begin Sidebar-->
<?php if (!$fullwidth) get_sidebar(); ?>
<!--End Sidebar-->
<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</body>
</html>