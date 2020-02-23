<?php
/**
 * The template part for displaying a message that posts cannot be found.
 */
  if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="archive_bredcrumb_header container-fluid">
    <h1 class="blog-page-title"><?php esc_html_e('Nothing Found','mayosis'); ?></h1>
    </div>
<section class="no-results not-found not--found--categories container">
	<div class="page-header">
		<h2><?php esc_html_e( 'This Category is empty', 'mayosis' ); ?></h2>
	</div>

	<div class="page-content">

			<p><?php esc_html_e( 'Please add some products on it !', 'mayosis' ); ?></p>
		
	</div>
</section>