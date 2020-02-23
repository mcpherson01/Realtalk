<?php
/**
 * The Template for displaying all single posts.
 *  @package mayosis
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
get_header();
$blogcommentsize= get_theme_mod( 'blog_comment_size','two' );
?>



	<div id="primary">
		

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content/content', 'single' ); ?>


<?php if($blogcommentsize == 'one') :?>
<div class="container">
			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() ) :
					comments_template();
				endif;
			?>

		

</div>
<?php endif; ?>

<?php endwhile;  ?>
	</div>


<?php get_footer(); ?>