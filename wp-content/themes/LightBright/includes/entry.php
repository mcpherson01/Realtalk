<?php $postType = 'text';
if('note' == $post->post_type) $postType = 'text';
if('video' == $post->post_type) $postType = 'video';
if('quote' == $post->post_type) $postType = 'quote';
if('photo' == $post->post_type) $postType = 'photo';
if('customlink' == $post->post_type) $postType = 'link';
if('audio' == $post->post_type) $postType = 'audio';
?>

<div class="entry<?php echo(" $postType"); ?>">
	<div class="entry-top"></div>

	<?php get_template_part('includes/share'); ?>

	<div class="post clearfix">
		<div class="content clearfix">

			<?php $custom = get_post_custom($post->ID);
			$link = ''; ?>

			<?php if ($postType == 'link') $link = isset($custom["customlink"][0]) ? $custom["customlink"][0] : '';
			if ($link == '') $link = get_permalink(); ?>

		<?php
			$post_type_name = $post->post_type;
			if ( 'post' == $post_type_name ) $post_type_name = 'note';
		?>

			<a href="<?php echo esc_url( get_post_type_archive_link( $post_type_name ) ); ?>" class="bubble"><?php the_title(); ?></a>

			<h<?php if(!is_single()) echo('2'); else echo('1'); ?> class="title"><?php if(!is_single()) echo('<a href="'. esc_url($link) .'">');?><?php the_title(); ?><?php if(!is_single()) echo('</a>'); ?></h<?php if(!is_single()) echo('2'); else echo('1'); ?>>
			<span class="date"><?php the_time('M d'); ?></span>

			<div class="clear"></div>

			<?php $thumb = '';
			if ($postType == 'text' || $postType == 'photo') {
				if ($postType == 'text') { $width = 184; $height = 184; }
				if ($postType == 'photo') { $width = 445; $height = 299; }
				$classtext = '';
				$titletext = get_the_title();

				$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,true,'thumb');
				$thumb = $thumbnail["thumb"];
			}; ?>


			<?php if (!is_single()) { ?>
				<?php if ($thumb <> '' && $postType == 'text' && get_option('lightbright_thumbnails_index') == 'on') { ?>
					<div class="small-thumb">
						<a href="<?php echo $thumbnail["fullpath"]; ?>" rel="gallery" title="<?php the_title(); ?>" class="fancybox">
							<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
							<span class="overlay"></span>
						</a>
					</div>
				<?php }; ?>

				<?php if ($thumb <> '' && $postType == 'photo' && get_option('lightbright_thumbnails_index') == 'on') { ?>
					<div class="big-thumb">
						<a href="<?php echo $thumbnail["fullpath"]; ?>" rel="gallery" title="<?php the_title(); ?>" class="fancybox">
							<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
							<span class="overlay"></span>
						</a>
					</div>
				<?php }; ?>
			<?php } else { ?>
				<?php if (get_option('lightbright_thumbnails') == 'on') { ?>
					<?php if ($thumb <> '' && $postType == 'text') { ?>
						<div class="small-thumb">
							<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
							<span class="overlay"></span>
						</div>
					<?php }; ?>

					<?php if ($thumb <> '' && $postType == 'photo') { ?>
						<div class="big-thumb">
							<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
							<span class="overlay"></span>
						</div>
					<?php }; ?>
				<?php }; ?>
			<?php }; ?>


			<?php if ($postType == 'quote') { ?>
				<blockquote>
					<p><?php $quote = isset($custom["quote"][0]) ? $custom["quote"][0] : ''; echo $quote; ?>"</p>
					<span class="quote_bg"></span>
				</blockquote>
			<?php }; ?>

			<?php if ($postType == 'video') { ?>
				<div class="video-block">
					<?php $video = isset($custom["video"][0]) ? $custom["video"][0] : '';
					$video_width = isset($custom["video_width"][0]) ? $custom["video_width"][0] : '424';
					$video_height = isset($custom["video_height"][0]) ? $custom["video_height"][0] : '264'; ?>

					<?php
					$video = preg_replace("/height=\"[0-9]*\"/", "height=$video_height", $video);
					$video = preg_replace("/width=\"[0-9]*\"/", "width=$video_width", $video);
					echo $video; ?>
				</div> <!-- end .video-block -->
			<?php }; ?>

			<?php if ($postType == 'audio') { ?>
				<?php $audio = isset($custom["audio"][0]) ? $custom["audio"][0] : ''; ?>
				<div class="audio-block">
					<?php $postID = $post->ID; ?>
					<p id="audioplayer_<?php echo($postID); ?>">Mp3 file</p>
					<script type="text/javascript">
						AudioPlayer.embed("audioplayer_<?php echo esc_js($postID); ?>", {soundFile: "<?php echo esc_js($audio); ?>"});
					</script>

				</div> <!-- end .audio-block -->
			<?php }; ?>

			<?php if ($postType == 'video') echo('<div class="video-text">'); ?>

				<?php if (get_option('lightbright_blog_style') == 'on' || is_single()) the_content(""); else { ?>
					<p><?php truncate_post(400); ?></p>
				<?php }; ?>

			<?php if ($postType == 'video') echo('</div> <!-- end .video-text -->'); ?>

			<?php if (is_single()) { ?>
				<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','LightBright').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				<?php edit_post_link(esc_html__('Edit this page','LightBright')); ?>
			<?php }; ?>

		</div> <!-- end .content -->

		<div class="entry-bottom-top"></div>

		<div class="entry-meta clearfix">
			<p class="meta"><span class="main"><?php esc_html_e('Posted by','LightBright');?> <?php the_author_posts_link(); ?>
			<?php $taxonomyName = 'custom-tax';
			if ($postType == 'video') $taxonomyName = 'custom-tax2';
			if ($postType == 'quote') $taxonomyName = 'custom-tax3';
			if ($postType == 'photo') $taxonomyName = 'custom-tax4';
			if ($postType == 'customlink') $taxonomyName = 'custom-tax5';
			if ($postType == 'audio') $taxonomyName = 'custom-tax6'; ?>
			<?php echo get_the_term_list( $post->ID, $taxonomyName, esc_html__(' in ','LightBright'),', ' ); ?>
			<?php if (get_the_category()) { esc_html_e(' in ','LightBright'); the_category(', '); } ?>

			</span> <span class="comment-count"><?php comments_popup_link('0','1','%'); ?></span></p>
			<?php if(!is_single()) { ?>
				<a href="<?php the_permalink(); ?>" class="readmore"><span><?php esc_html_e('read more','LightBright'); ?></span></a>
			<?php }; ?>
		</div> <!-- end .entry-meta -->

	</div> <!-- end .main -->

	<div class="entry-bottom"></div>
</div> <!-- end .entry -->

<?php if (get_option('lightbright_468_enable') == 'on') { ?>
	<?php if(get_option('lightbright_468_adsense') <> '') echo(get_option('lightbright_468_adsense'));
	else { ?>
		<a href="<?php echo esc_url(get_option('lightbright_468_url')); ?>"><img src="<?php echo esc_attr(get_option('lightbright_468_image')); ?>" alt="468 ad" class="foursixeight" /></a>
	<?php } ?>
<?php } ?>

<?php if (get_option('lightbright_show_postcomments') == 'on') comments_template('', true); ?>