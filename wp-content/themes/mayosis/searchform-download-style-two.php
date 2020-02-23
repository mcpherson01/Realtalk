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
<li>
	<div id="imaginary_container"> 
                <div class="input-group stylish-input-group">
                       <form role="search" method="get" class="search-form-none" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<?php $searchresults = get_search_query(); ?>
                    <input  value="<?php the_search_query(); ?>" placeholder="<?php esc_html_e( 'Type and Hit Enter', 'mayosis' ); ?>" type="search" name="s" id="s" class="dm_search"   >
                        <button type="submit" value="Search">
                            <i class="zil zi-search" aria-hidden="true"></i>
                            <input type="hidden" name="post_type" value="download" />
                        </button>  
                
                    </form>
                </div>
            </div>
            
    </li>