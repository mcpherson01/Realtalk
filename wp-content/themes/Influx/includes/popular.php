<!--Begin Most Commented Articles-->
<span class="headings"><?php esc_html_e('popular articles','Influx'); ?></span>
<div style="clear: both;"></div>
<ul class="list2">
	<?php $popular_num = (int) get_option('influx_popular_num');
	$result = $wpdb->get_results("SELECT comment_count,ID,post_title FROM $wpdb->posts ORDER BY comment_count DESC LIMIT 0 , $popular_num");
	foreach ($result as $post) {
		#setup_postdata($post);
		$postid = (int) $post->ID;
		$title = $post->post_title;
		$commentcount = (int) $post->comment_count;
		if ($commentcount != 0) { ?>
			<li><a href="<?php echo esc_url(get_permalink($postid)); ?>" title="<?php echo esc_attr($title); ?>">
			<?php echo esc_html($title); ?> (<?php echo esc_html($commentcount); ?>)</a></li>
		<?php }
	} ?>
</ul>
<!--End Most Commented Articles-->