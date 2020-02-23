<!--Begind Feautred Articles-->

<div style="clear: both;"></div>
<?php
query_posts("posts_per_page=".get_option('cion_homepage_featured')."&cat=".get_catId(get_option('cion_feat_cat')));
while (have_posts()) : the_post(); ?>

<?php $width = 183;
	  $height = 160;

	  $classtext = 'featured-thumb-img';
	  $titletext = get_the_title();

	  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
	  $thumb = $thumbnail["thumb"]; ?>

<?php if($thumb != '') { ?>
	<div class="featured-item">
		<a href="<?php the_permalink() ?>" class="featured-thumb">
			<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
		</a>

		<div class="featured-info"> <span class="featured-title">
			<?php truncate_title(30) ?>
			</span>
			<div style="clear: both;"></div>
			<?php esc_html_e('Posted by','Cion') ?>
			<?php the_author() ?>
			<?php esc_html_e('on','Cion') ?>
			<?php the_time('m jS, Y') ?>
			|
			<?php comments_popup_link(esc_html__('No Comments','Cion'), esc_html__('1 Comment','Cion'), esc_html__('% Comments','Cion')); ?>
		</div>
	</div>
<?php } ?>
<?php endwhile; ?>
<?php wp_reset_query(); ?>
<div style="clear: both;"></div>
<!--End Feautred Articles-->