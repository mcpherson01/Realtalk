<?php $icon = get_post_meta($post->ID, 'Icon', true); ?>
<?php if ($icon <> '') { ?>
	<img class="icon" src="<?php echo esc_url($icon); ?>" alt="" />
<?php }; ?>

<h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

<?php global $more;
	  $more = 0;
	  the_content(""); ?>

<a href="<?php the_permalink(); ?>" class="readmore"><span><?php esc_html_e('Read more','MyProduct'); ?></span></a>