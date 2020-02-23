<?php
/**
 * The template for displaying search forms in mayosis
 *
 * @package mayosis
 */
 ?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<?php $searchresults = get_search_query(); ?>
							<input class="search-field" value="<?php echo esc_html($searchresults); ?>" placeholder="<?php esc_html_e( 'Search', 'mayosis' ); ?>" type="search" name="s" id="search">
							<input type="hidden" name="post_type" value="post" />
							
						</form>