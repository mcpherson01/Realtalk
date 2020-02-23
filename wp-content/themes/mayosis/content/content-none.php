<?php
/**
 * The template part for displaying a message that posts cannot be found.
 */
  if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<section class="no-results not-found container">
	<div class="page-header">
		<h2><?php esc_html_e( 'Nothing Found', 'mayosis' ); ?></h2>
	</div>

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( esc_html__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'mayosis' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'mayosis' ); ?></p>
			
<?php get_template_part( 'searchform-download-sidebar-header' ); ?>

		<?php else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'mayosis' ); ?></p>
		

		<?php endif; ?>
	</div>
</section>