<?php

if (!defined('ABSPATH'))
	{
	exit; // Exit if accessed directly.
	}
$collapsebuttonshow= get_theme_mod( 'collapse_button',1 );
?>
<div class="container-fluid">

                <div class="mayosis-sidenav-extra-header hidden-sm hidden-xs">
                    <?php if($collapsebuttonshow == 'on') :?>
                     <div class="mayosis-collapsible-box">
                            <button type="button" id="mayosis-sidebarCollapse" class="mayosis-collapse-btn">
                                <i class="zil zi-bars"></i>
                               
                            </button>
                       </div>
                       <?php endif; ?>
                    <div class="mayosis-sidebar-header-search">
                       <?php get_template_part( 'searchform-download-sidebar-header' ); ?>
                    </div>
                      
                  <div class="sidemenu-login">
                      <ul>
                      <?php get_template_part( 'includes/login-meta' ); ?>
                      </ul>
                  </div>
                </div>
                
                </div>