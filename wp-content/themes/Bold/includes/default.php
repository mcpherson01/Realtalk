<?php if (get_option('bold_display_sidebar') == 'on') { ?>
<div class="home-left">
    <!--Begin recent post-->
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class="home-post-wrap">
			<span class="post-info">
				<span class="post-date">
					<span class="post-date-inside"><?php the_time(get_option('bold_date_format')) ?></span><span class="date-right"></span>
				</span>

				<span class="post-author">
					<?php esc_html_e('Posted by','Bold') ?> <strong><?php the_author() ?></strong>
				</span>
			</span>

			<div style="clear: both;"></div>

			<h2 class="post-title-2">
				<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','Bold'), get_the_title()) ?>">
					<?php the_title() ?>
				</a>
			</h2>

			<div style="clear: both;"></div>

		<?php
			$width = 85;
			$height = 85;
			$classtext = '';
			$titletext = get_the_title();

			$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
			$thumb = $thumbnail["thumb"];
		?>

		<?php if($thumb <> '') { ?>
			<div class="featured-thumb-wrapper">
				<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','Bold'), get_the_title()) ?>">
					<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
				</a>
			</div>
		<?php } ?>

			<div>
				<?php truncate_post(205); ?>
			</div>

			<a href="<?php the_permalink() ?>" rel="bookmark" class="readmore" title="<?php printf(esc_attr__('Permanent Link to %s','Bold'), get_the_title()) ?>">
				<?php esc_html_e('read more','Bold') ?>
			</a>

			<div style="clear: both;"></div>
        </div>
    <?php endwhile; ?>
        <div style="clear: both;"></div>
		<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
		else { ?>
		<p class="pagination">
			<?php next_posts_link(esc_html__('&laquo; Previous Entries','Bold')) ?>
			<?php previous_posts_link(esc_html__('Next Entries &raquo;','Bold')) ?>
		</p>
		<?php } ?>
	<?php endif; ?>
	<!--End recent post-->
</div>

<div class="home-right">
        <?php if (get_option('bold_popular_display') == 'on') { ?>
<!--Begin Most Commented Articles-->
<span class="headings"><?php esc_html_e('popular articles','Bold') ?> </span>
<div class="home-sidebar-box">
<ul>
<?php $result = $wpdb->get_results("SELECT comment_count,ID,post_title FROM $wpdb->posts ORDER BY comment_count DESC LIMIT 0 ,".get_option('bold_popular_count')."");
foreach ($result as $post) {
#setup_postdata($post);
$postid = (int) $post->ID;
$title = $post->post_title;
$commentcount = (int) $post->comment_count;
if ($commentcount != 0) { ?>
<li><a href="<?php echo esc_url( get_permalink($postid) ); ?>" title="<?php echo esc_attr( $title ); ?>">
<?php echo esc_html( $title ); ?></a> (<?php echo esc_html( $commentcount ); ?>)</li>
<?php } } ?>
</ul>
</div>
<!--End Most Commented Articles-->
        <?php }; ?>

        <?php if (get_option('bold_random_display') == 'on') { ?>
<!--Begin Random Articles-->
<span class="headings"><?php esc_html_e('random articles','Bold') ?></span>
<div class="home-sidebar-box">
    <ul>
        <?php $my_query = new WP_Query('orderby=rand&posts_per_page='.get_option('bold_random').'');
while ($my_query->have_posts()) : $my_query->the_post();
?>
        <li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','Bold'), get_the_title()) ?>">
            <?php truncate_title(35) ?>
            </a></li>
        <?php endwhile; wp_reset_postdata(); ?>
    </ul>
</div>
<!--End Random Articles-->
        <?php }; ?>

        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Homepage") ) : ?>
        <?php endif; ?>
    </div>
<?php } else { ?>


        <!--Begind recent post-->
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class="cat-post-wrap">

        <span class="post-info">

            <span class="post-date">
            <span class="post-date-inside"><?php the_time(get_option('bold_date_format')) ?></span><span class="date-right"></span>
            </span>

            <span class="post-author">
            <?php esc_html_e('Posted by','Bold') ?> <strong><?php the_author() ?></strong>
            </span>

            </span>
            <div style="clear: both;"></div>
                        <h2 class="post-title-2"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','Bold'), get_the_title()) ?>">
                <?php the_title() ?>
                </a></h2>
            <div style="clear: both;"></div>

	<?php $width = 85;
		  $height = 85;
		  $classtext = 'featured-thumb';
		  $titletext = get_the_title();

		  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
		  $thumb = $thumbnail["thumb"]; ?>

    <?php if($thumb <> '') { ?>
        <div class="featured-thumb-wrapper">
			<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','Bold'), get_the_title()) ?>">
				<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
			</a>
		</div>
	<?php } ?>

            <?php truncate_post(410); ?>

                <a href="<?php the_permalink() ?>" rel="bookmark" class="readmore" title="<?php printf(esc_attr__('Permanent Link to %s','Bold'), get_the_title()) ?>">
    <?php esc_html_e('read more','Bold') ?>
    </a>
    <div style="clear: both;"></div>
        </div>
        <?php endwhile; ?>
        <div style="clear: both;"></div>
<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
else { ?>
<p class="pagination">
    <?php next_posts_link(esc_html__('&laquo; Previous Entries','Bold')) ?>
	<?php previous_posts_link(esc_html__('Next Entries &raquo;','Bold')) ?>
</p>
<?php } ?>
    <?php else : ?>
    <!--If no results are found-->
    <div class="single-post-wrap">
    <h1><?php esc_html_e('No Results Found','Bold') ?></h1>
	<p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','Bold') ?></p>
    </div>
    <!--End if no results are found-->
    <?php endif; ?>
        <!--End recent post-->

<?php }; ?>