 <div class="row fix">
					    	 <?php

while (have_posts()):
	the_post(); ?>
					    <div class="col-md-6 col-xs-12 col-sm-6">
					     <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			 		 <div class="blog-box grid_dm">
							<figure class="mayosis-fade-in"> 
							<a href="<?php
	the_permalink(); ?>"> 
								   <?php
								// display featured image?
								if ( has_post_thumbnail() ) :
									the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) ); ?>
<?php endif; ?>                         
								
							</a>
						<figcaption>
							    <div class="overlay_content_center blog_overlay_content">
							    <a href="<?php the_permalink(); ?>"><i class="zil zi-plus"></i></a>
							    </div>
							</figcaption>
						</figure>
						<div class="clearfix"></div>
						<div class="blog-meta">
					
                     <?php
 global $post;
 $categories = get_the_category($post->ID);
 $cat_link = get_category_link($categories[0]->cat_ID);
?>
					
							<h4 class="blog-title"><a href="<?php
	the_permalink(); ?>"> <?php
	the_title(); ?></a></h4>
							<div class="meta-bottom">
								<div class="user-info">
								<span><?php esc_html_e('by','mayosis'); ?></span>	<a href="<?php
	echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php
	the_author(); ?></a> <span><?php esc_html_e('in','mayosis'); ?></span>	<a href="<?php echo  esc_url($cat_link); ?>"><?php
	$category = get_the_category();
	$dmcat = $category[0]->cat_name;
	echo esc_html($dmcat); ?></a>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div><!-- .blog box -->
                    <!-- Blog Post-->
							</div>
					   </div>
					   
					  
                 <?php
endwhile; ?> 
					   </div>