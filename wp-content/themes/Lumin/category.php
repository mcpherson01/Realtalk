<?php $projects_cat = (int) get_catid(get_option('lumin_projects_cat'));
$is_gallery = false; ?>
<?php get_header(); ?>
	<h1 id="post-title"><span><?php single_cat_title("") ?></span></h1>
	<div id="main">
		<?php if (is_category($projects_cat) || in_subcat($projects_cat,$cat)) { $post_number = (int) get_option('lumin_gallery_catnum'); $is_gallery = true; } else { $post_number = (int) get_option('lumin_catnum_posts'); } ;?>

		<div class="post<?php if ($is_gallery) echo " gallery"; else echo " index"; ?>">
			<?php if ($is_gallery) get_template_part('includes/category_gallery');
				  else get_template_part('includes/category_usual'); ?>
			<div class="clear"></div>
		</div> <!-- end .post -->
	</div> <!-- end #main-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>