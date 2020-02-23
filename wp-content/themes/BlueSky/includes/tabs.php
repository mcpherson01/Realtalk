<ul class="idTabs">
	<?php if (get_option('bluesky_show_tabarea_recententries') == 'on') { ?>
		<li><a href="#recententries"><?php esc_html_e('Entries','Bluesky'); ?></a></li>
	<?php }; ?>
	<?php if (get_option('bluesky_show_tabarea_recentcomments') == 'on') { ?>
		<li><a href="#recentcomments2"><?php esc_html_e('Comments','Bluesky'); ?></a></li>
	<?php }; ?>
	<?php if (get_option('bluesky_show_tabarea_popular') == 'on') { ?>
		<li><a href="#mostcomments"><?php esc_html_e('Popular','Bluesky'); ?></a></li>
	<?php }; ?>
</ul>

<?php if (get_option('bluesky_show_tabarea_recententries') == 'on') { ?>
	<div id="recententries">
		<span class="toptitle"><?php esc_html_e('Recent Posts','Bluesky'); ?></span>
		<?php $recentPostsNum = (int) get_option('bluesky_recentposts_num'); ?>
		<ul class="list2">
			<?php wp_get_archives('postbypost', $recentPostsNum); ?>
		</ul>
	</div> <!-- end #recententries -->
<?php }; ?>

<?php if (get_option('bluesky_show_tabarea_recentcomments') == 'on') { ?>
	<div id="recentcomments2">
		<span class="toptitle"><?php esc_html_e('Recent Comments','Bluesky'); ?></span>
		<?php $recentCommentsNum = (int) get_option('bluesky_recentcomments_num'); ?>
		<?php get_template_part('simple_recent_comments'); /* recent comments plugin by: www.g-loaded.eu */?>
		<?php if (function_exists('src_simple_recent_comments')) { src_simple_recent_comments($recentCommentsNum, 60, '', ''); } ?>
	</div> <!-- end #recentcomments2 -->
<?php }; ?>

<?php if (get_option('bluesky_show_tabarea_popular') == 'on') { ?>
	<div id="mostcomments">
		<span class="toptitle"><?php esc_html_e('Popular Articles','Bluesky'); ?></span>
		<?php $popularNum = (int) get_option('bluesky_popular_posts_num'); ?>
		<ul class="list2">
			<?php $result = $wpdb->get_results("SELECT comment_count,ID,post_title FROM $wpdb->posts ORDER BY comment_count DESC LIMIT 0 , $popularNum");
			foreach ($result as $post) {
				#setup_postdata($post);
				$postid = (int) $post->ID;
				$title = $post->post_title;
				$commentcount = (int) $post->comment_count;
				if ($commentcount != 0) { ?>
				<li><a href="<?php echo esc_url( get_permalink( $postid ) ); ?>" title="<?php echo esc_attr( $title ); ?>">
				<?php echo esc_html( $title ); ?> (<?php echo esc_html( $commentcount ); ?>)</a></li>
			<?php } } ?>
		</ul>
	</div> <!-- end #mostcomments -->
<?php }; ?>