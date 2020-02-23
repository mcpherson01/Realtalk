<?php
/**
 * The template for displaying Author Archive.
 *
 * @package mayosis
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
get_header(); 


?>
<div class="section">
	<div class="container-author">
        <?php            
        if(!isset($_GET['author_downloads'])) { ?>
        <?php  } ?>
                <?php
                if(isset($_GET['author_downloads']) && $_GET['author_downloads']=='true') {
                  get_template_part('content/content-author-download'); 
              }else{ 
                ?>
                <div class="page-head">
            
            <!-- Begin Page Headings Layout -->
    <div class="single_author_box no-margin single_author_page container-fluid">
        <div class="container">
           			<div class="col-md-3">
           			<div class="author_meta_single author_single_dm_box">
           			<?php echo get_avatar( get_the_author_meta('email'), '90' ); ?>
           				<h2><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta('ID') )); ?>"><i class="zil zi-user" aria-hidden="true"></i>
 <?php echo esc_html(get_the_author()); ?></a></h2>
           			
           				<p class="post_count_single"><i class="zil zi-pencil" aria-hidden="true"></i>
 <?php $author_id = get_the_author_meta('ID');
echo esc_html(count_user_posts($author_id)); ?> <?php esc_html_e('Articles','mayosis'); ?></p>
         			
          			<div class="author_social_items">
						<h4><?php esc_html_e('Network','mayosis'); ?></h4>
						<ul class="icons">
					<?php 
						$behance_profile = get_the_author_meta( 'behance_profile',$author->ID );
						if ( $behance_profile && $behance_profile != '' ) {
							echo '<li class="rss"><a href="' . esc_url($behance_profile) . '"><i class="zil zi-behance" aria-hidden="true"></i>
</a></li>';
						}
						
						$dribble_profile = get_the_author_meta( 'dribble_profile',$author->ID );
						if ( $dribble_profile && $dribble_profile != '' ) {
							echo '<li class="google"><a href="' . esc_url($dribble_profile) . '" rel="author"><i class="zil zi-dribbble" aria-hidden="true"></i>
</a></li>';
						}
						
						$twitter_profile = get_the_author_meta( 'twitter_profile',$author->ID );
						if ( $twitter_profile && $twitter_profile != '' ) {
							echo '<li class="twitter"><a href="' . esc_url($twitter_profile) . '"><i class="zil zi-twitter" aria-hidden="true"></i>
</a></li>';
						}
						
						$facebook_profile = get_the_author_meta( 'facebook_profile',$author->ID );
						if ( $facebook_profile && $facebook_profile != '' ) {
							echo '<li class="facebook"><a href="' . esc_url($facebook_profile) . '"><i class="zil zi-facebook" aria-hidden="true"></i>
</a></li>';
						}
						
						$linkedin_profile = get_the_author_meta( 'linkedin_profile',$author->ID );
						if ( $linkedin_profile && $linkedin_profile != '' ) {
							echo '<li class="linkedin"><a href="' . esc_url($linkedin_profile) . '"><i class="zil zi-linked-in" aria-hidden="true"></i>
</a></li>';
						}
					?>
				</ul>
				</div>
           			</div>
					</div>
					<div class="col-md-9 author_single_description">
						<h3><?php esc_html_e('Author&#39;s Biography','mayosis'); ?></h3>
						<p class="author-description"><?php echo mayosis_description(5); ?></p>
						
					</div>
					<div class="clearfix"></div>
				</div>
    </div>
    <!-- End Page Headings Layout -->
        </div>
                <div class="row">
                    <?php get_template_part('content/content-author-blog'); ?>
                     
                </div>
                <?php	} ?>
            </div>
        </div>
        <?php get_footer(); ?>