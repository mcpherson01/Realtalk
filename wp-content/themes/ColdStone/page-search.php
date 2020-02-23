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

<div class="single_wrap <?php if($fullwidth) echo (' no_sidebar');?>">

    <div class="single_post">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <h1><a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
            </a></h1>
		<?php if (get_option('coldstone_page_thumbnails') == 'on') { get_template_part( 'includes/thumbnail'); } ?>
        <?php the_content();?>
					<div id="et-search">
						<div id="et-search-inner" class="clearfix">
							<p id="et-search-title"><span><?php esc_html_e('search this website','ColdStone'); ?></span></p>
							<form action="<?php echo esc_url( home_url() ); ?>" method="get" id="et_search_form">
								<div id="et-search-left">
									<p id="et-search-word"><input type="text" id="et-searchinput" name="s" value="<?php esc_attr_e('search this site...','ColdStone'); ?>" /></p>

									<p id="et_choose_posts"><label><input type="checkbox" id="et-inc-posts" name="et-inc-posts" /> <?php esc_html_e('Posts','ColdStone'); ?></label></p>
									<p id="et_choose_pages"><label><input type="checkbox" id="et-inc-pages" name="et-inc-pages" /> <?php esc_html_e('Pages','ColdStone'); ?></label></p>
									<p id="et_choose_date">
										<select id="et-month-choice" name="et-month-choice">
											<option value="no-choice"><?php esc_html_e('Select a month','ColdStone'); ?></option>
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
									<input class="et_search_submit" type="submit" value="<?php esc_attr_e('Submit','ColdStone'); ?>" id="et_search_submit" />
								</div> <!-- #et-search-right -->
							</form>
						</div> <!-- end #et-search-inner -->
					</div> <!-- end #et-search -->

		<?php edit_post_link(); ?>
		<div style="clear: both;"></div>
		<?php if (get_option('coldstone_show_pagescomments') == 'on') { ?>
			<?php comments_template('', true); ?>
		<?php }; ?>
		<?php endwhile; endif; ?>
    </div>
    <!-- /single_post -->
    <?php if (!$fullwidth) get_sidebar(); ?>
</div>
<div class="footer" style="height:15px;margin-bottom:0;"></div>
<?php get_footer(); ?>