<?php 
/*
*Template Name: Sitemap
* @package mayosis
*/ 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
get_header();
$mayosis_breadcrumb_color = get_post_meta( $post->ID, 'mayosis_breadcrumb_color', true );
$mayosis_page_bg = get_post_meta( $post->ID, 'mayosis_page_bg', true );

$mayosis_gradient= get_post_meta( $post->ID, 'breadcrumb_gradient', true );

$mayosis_gradient_a = get_post_meta( $post->ID, 'mayosis_gradient_a', true );

$mayosis_gradient_b = get_post_meta( $post->ID, 'mayosis_gradient_b', true );
?>
<?php if ( is_home() ) {
    $breadcrumb_hide = get_post_meta(get_queried_object_id(), 'breadcrumb_hide', true );
} else {
    $breadcrumb_hide = get_post_meta(get_queried_object_id(), 'breadcrumb_hide', true );
} ?>
<div class="container-fluid">
				<?php  if($breadcrumb_hide == "Yes"){ ?>
					<?php  if($mayosis_gradient == "Yes"){ ?>
				<div class="row page_breadcrumb" style="background:linear-gradient(45deg, <?php echo esc_html($mayosis_gradient_a); ?> , <?php echo esc_html($mayosis_gradient_b); ?>);">
				<?php } else { ?>
				
				<?php  if($mayosis_breadcrumb_color){ ?>
				<div class="row page_breadcrumb" style="background-color:<?php echo esc_html($mayosis_breadcrumb_color); ?>;">
				<?php } else { ?>
				
				<div class="row page_breadcrumb" style="background-image:url(<?php echo get_post_meta(get_the_ID(), 'breadcrumb_image', true ); ?>);">
				<?php } ?>
					
					 <?php } ?>
					 <div class="container">
					<h2 class="page_title_single"><?php the_title(); ?></h2>
						<?php if (function_exists('dm_breadcrumbs')) dm_breadcrumbs(); ?>
						</div>
					</div>
				<?php } ?>
					</div>
					<div class="welcome_screen_sitemp">
					<div class="container">
						<?php 
                        if(have_posts()) : while(have_posts()) : the_post();
		                 the_content();
		                 endwhile; endif; ;
                        ?>
						</div>
</div>
<div class="container sitemap_content">
<h2 id="sitemap_pages"><?php esc_html_e('Pages','mayosis'); ?></h2>
<ul class="sitemap_page_list">
<?php
// Add pages you'd like to exclude in the exclude here
wp_list_pages(
  array(
    'exclude' => '',
    'title_li' => '',
  )
);
?>
</ul>


<ul>
<?php
// Add categories you'd like to exclude in the exclude here
$cats = get_categories('exclude=');
foreach ($cats as $cat) {
  echo '<h2 id="sitemap_pages">'.esc_html__('Posts By Blog Category','mayosis').' </h2>';
  echo "<h3 class='category_sitemap_headings'>". esc_html__('Category:','mayosis')." <span>".$cat->cat_name."</span></h3>";
  echo '<ul class="sitemap_page_list">';
  query_posts('posts_per_page=-1&cat='.$cat->cat_ID);
  while(have_posts()) {
    the_post();
    $category = get_the_category();
    // Only display a post link once, even if it's in multiple categories
    if ($category[0]->cat_ID == $cat->cat_ID) {
      echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
    }
  }
  echo "</ul>";
  echo "</li>";
}
?>
</ul>
<?php if (class_exists('Easy_Digital_Downloads')): ?>
	<div class="cat_product_sitemap">

	<h2 id="sitemap_pages"><?php esc_html_e('Products','mayosis'); ?></h2>


<ul class="sitemap_page_list">
<?php
$myposts = get_posts('numberposts=-1&post_type=download&offset=');
foreach($myposts as $post) :
?>
<li class="sitemap"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php endforeach; ?>
</ul>

	</div>
	<div class="cat_list_sitemap">
	<h2 id="sitemap_pages"><?php esc_html_e('Products Categories','mayosis'); ?></h2>
	<?php
echo "<ul class=\"sitemap_page_list\">\n";
			wp_list_categories( 'title_li=&taxonomy=download_category');
		echo "</ul>\n";
?>
	</div>
</div>
<?php endif; ?>

<?php get_footer();?>