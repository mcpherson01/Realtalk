<?php
/**
 * The template for displaying search forms in mayosis
 *
 * @package mayosis
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<form role="search" method="get" class="search-form-none" action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <div class="form-group" style="display:inline;">
          <div class="fill">
            	<?php $searchresults = get_search_query(); ?>
                    <input  value="<?php the_search_query(); ?>" placeholder="<?php esc_html_e( 'Type and Hit Enter', 'mayosis' ); ?>" type="search" name="s" id="s" class="form-control"   >
            <span class="btn btn-default"><i class="zil zi-search"></i> <input type="hidden" name="post_type" value="download" /></span>
          </div>
        </div>
      </form>