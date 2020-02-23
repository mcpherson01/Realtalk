<?php
/*
*Template Name: Blog Authors List
* @package mayosis
*/

// Get all users order by amount of posts
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
get_header();
$mayosis_breadcrumb_color = get_post_meta( $post->ID, 'mayosis_breadcrumb_color', true );


$mayosis_gradient= get_post_meta( $post->ID, 'breadcrumb_gradient', true );

$mayosis_gradient_a = get_post_meta( $post->ID, 'mayosis_gradient_a', true );

$mayosis_gradient_b = get_post_meta( $post->ID, 'mayosis_gradient_b', true );

$allUsers = get_users('orderby=post_count&order=DESC');
$users = array();

// Remove subscribers from the list as they won't write any articles

foreach($allUsers as $currentUser)
	{
	if (!in_array('subscriber', $currentUser->roles))
		{
		$users[] = $currentUser;
		}
	}

?>

<?php if ( is_home() ) {
    $breadcrumb_hide = get_post_meta(get_queried_object_id(), 'breadcrumb_hide', true );
     $sidebar_hide = get_post_meta(get_queried_object_id(), 'page_sidebar', true );
} else {
    $breadcrumb_hide = get_post_meta(get_queried_object_id(), 'breadcrumb_hide', true );
     $sidebar_hide = get_post_meta(get_the_ID(), 'page_sidebar', true );
} ?>

<div class="container-fluid">
<?php  if($breadcrumb_hide == "Yes"){ ?>

						<?php  if($mayosis_gradient == "Yes"){ ?>
				<div class="row page_breadcrumb" style="background:linear-gradient(45deg, <?php echo esc_html($mayosis_gradient_a); ?> , <?php echo esc_html($mayosis_gradient_b); ?>);">
				<?php } else { ?>
					<div class="row page_breadcrumb" style="background-color:<?php echo esc_html($mayosis_breadcrumb_color); ?>;background-image:url(<?php echo get_post_meta(get_the_ID(), 'breadcrumb_image', true ); ?>);">
					 <?php } ?>
					 <div class="container">
					<h2 class="page_title_single"><?php
	the_title(); ?></h2>
						<?php
	if (function_exists('dm_breadcrumbs')) dm_breadcrumbs(); ?>
						</div>
						</div>
			 <?php } ?>
</div>
<div class="container-fluid">
	<?php  if($sidebar_hide == "Show"){ ?>
						
						<div class="container dm-column-container author-list-page">
						<div class="row">
							<div class="col-md-8">
							<h2 class="dm-author-list-main"><?php esc_html_e( 'Our authors who contributed useful articles for you!', 'mayosis' ); ?> </h2>
						<div class="row fix">
	<?php
	foreach($users as $user)
		{
		$post_count = count_user_posts($user->ID);
?>
			<div class="col-md-6">
			  
			<div class="dm-author-list">
				<div class="dm-authorAvatar col-sm-4 no-padding">
				<a href="<?php
		echo esc_url(get_author_posts_url($user->ID)); ?>"><?php
		echo get_avatar($user->user_email, '90', array(
			'class' => array(
				'd-block',
				'img-responsive'
			)
		)); ?></a>
				</div>
				<div class="dm-authorInfo col-sm-8 no-padding">
					<h2 class="authorName"><a href="<?php
		echo esc_url(get_author_posts_url($user->ID)); ?>"><i class="fa fa-user" aria-hidden="true"></i>
					<?php
		echo esc_html($user->display_name); ?></a></h2>
					<p class="dm-authorPost"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
 <?php
		echo esc_html($post_count); ?> <?php esc_html_e('Articles','mayosis'); ?></p>
				</div>
				<div class="clearfix"></div>
			
			</div>
			</div>
			<?php
		}

?>
	</div>
						</div>
						<div class="col-md-4 ">
							     <?php
	if (is_active_sidebar('single-post')): ?>
					<?php
		dynamic_sidebar('single-post'); ?>
				<?php
	endif; ?>
						</div>
							<div class="clearfix"></div>
							</div>
						</div>
						<?php
} else{ ?>
					<div class="container dm-column-container author-list-page">
				   <h2 class="dm-author-list-main"><?php esc_html_e( 'Our authors who contributed useful articles for you!', 'mayosis' ); ?> </h2>
					   <div class="row fix">
	<?php
	foreach($users as $user)
		{
		$post_count = count_user_posts($user->ID);
?>
			<div class="col-md-4 col-sm-6 col-sm-12">
			  
			<div class="dm-author-list">
				<div class="dm-authorAvatar col-sm-4 col-sm-5 no-padding">
					<a href="<?php
		echo esc_url(get_author_posts_url($user->ID)); ?>"><?php
		echo get_avatar($user->user_email, '90', array(
			'class' => array(
				'd-block',
				''
			)
		)); ?></a>
				</div>
				<div class="dm-authorInfo col-md-8  col-sm-7">
					<h2 class="authorName"><a href="<?php
		echo esc_url(get_author_posts_url($user->ID)); ?>"><i class="fa fa-user" aria-hidden="true"></i>
					<?php
		echo esc_html($user->display_name); ?></a></h2>
					<p class="dm-authorPost"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
 <?php
		echo esc_html($post_count); ?> <?php esc_html_e('Articles','mayosis'); ?></p>
				</div>
				<div class="clearfix"></div>
			
			</div>
			</div>
			<?php
		}

?>
	</div>
						</div>
		<?php } ?>


</div>
<?php
get_footer(); ?>