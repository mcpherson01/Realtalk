<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
} ?>
<li class="dropdown hide-expand">
            <a href="#"  data-toggle="dropdown"><i class="fa fa-search" aria-hidden="true"></i></a>
            <ul class="dropdown-menu">
                <form role="search" method="get" class="search-form-none search-form-collapsed" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<?php $searchresults = get_search_query(); ?>
                    <input  value="<?php echo esc_html($searchresults); ?>" placeholder="<?php esc_html_e( 'Type and Hit Enter', 'mayosis' ); ?>" type="search" name="s" class="dm_search"   >
                        <button type="submit">
                            <i class="fa fa-search" aria-hidden="true"></i>
                            <input type="hidden" name="post_type" value="download" />
                        </button>  
              </ul>
          </li>