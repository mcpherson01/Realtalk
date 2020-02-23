<?php
   $job = get_post_meta( get_the_ID(), 'tbay_testimonial_job', true );
   $post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
?>
<div class="testimonials-body">
	<div class="testimonials-profile"> 
	  	<div class="wrapper-avatar">
	     	<div class=" testimonial-avatar tbay-image-loaded">
            	<?php echo urna_tbay_get_attachment_image_loaded($post_thumbnail_id, 'urna_avatar_post_carousel'); ?>
	     	</div>
	  	</div>
	  	<div class="testimonial-meta">
	     	<span class="name-client"> <?php the_title(); ?></span>
	     	<span class="job"><?php echo trim($job); ?></span>
	  	</div> 
	</div> 
	<div class="description">
	 	<?php echo get_the_excerpt(); ?>
	</div>
</div>