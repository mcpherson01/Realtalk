<?php
defined('ABSPATH') or die();
 global $post;
 $categories = get_the_category($post->ID);
 $cat_link = get_category_link($categories[0]->cat_ID);
?>

 <span class="toolspan"><?php esc_html_e("in","mayosis"); ?></span> <a href="<?php echo  esc_url($cat_link); ?>" class="blog--layout--contents"> <?php
	$category = get_the_category();
	$dmcat = $category[0]->cat_name;
	echo esc_html($dmcat); ?></a>