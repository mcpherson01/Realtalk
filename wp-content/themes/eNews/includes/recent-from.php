<?php function recent_from($category_name,$index_num) {
query_posts("posts_per_page=1&cat=".get_catId($category_name)."&ignore_sticky_posts=1");
while (have_posts()) : the_post();
global $post, $ids2; ?>

<?php $width = 74;
	  $height = 74;
	  $titletext = get_the_title();
	  $thumbnail = get_thumbnail($width,$height,'',$titletext,$titletext);
	  $thumb = $thumbnail["thumb"]; ?>

	<h4><?php esc_html_e('RECENT FROM','eNews') ?> <?php echo esc_html($category_name); ?></h4>
	<div class="recent-postwrap">
		<h3><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','eNews'), get_the_title()) ?>"><?php truncate_title(25); ?></a></h3>

		<?php if ($thumb <> '') { ?>
			<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height); ?>
		<?php }; ?>

		<p><?php truncate_post(110) ?></p>
	</div>
<?php $ids2[]= $post->ID; endwhile; wp_reset_query();
} ?>