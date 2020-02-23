<?php
function mayosis_header_builder(){
    global $builder_items;
     $headerlayoutmaster = get_theme_mod( 'header_layout_type','one');
    ?>
    <div class="header-builder">
      <div class="header-toolbar">
        <span class="left">
             <a class="mayosis-green-button white-scheme main-header-settings-button enable-layout" data-section="header-content-main"><span class="dashicons dashicons-schedule"></span><span class="title-icon">Layout</span></a>
             <a class="mayosis-green-button white-scheme header-preset-button enable-preset" data-section="header_sticky"><span class="dashicons dashicons-sticky"></span><span class="title-icon">Sticky Header</span></a>
               <?php if ($headerlayoutmaster == 'two'): ?>
                <a class="mayosis-green-button white-scheme header-preset-button enable-preset" data-section="header_collapsed"><span class="dashicons dashicons-editor-contract"></span><span class="title-icon">Collapsed Header</span></a>
               <?php endif;?>
            <a class="mayosis-green-button white-scheme header-preset-button enable-preset" data-section="header-presets"><span class="dashicons dashicons-screenoptions"></span><span class="title-icon">Prebuilt Header</span></a>
            
        </span>
        <span class="center display-toggle">
            <a class="mayosis-green-button enable-desktop"><span class="dashicons dashicons-desktop"></span><span class="title-icon">Desktop</span></a>
            <a class="mayosis-green-button enable-tablet"><span class="dashicons dashicons-smartphone"></span><span class="title-icon">Mobile/Tablet</span></a>
        </span>
        <span class="right">
            <a class="mayosis-green-button red-color-text header-clear-button"><span class="dashicons dashicons-trash"></span><span class="title-icon">Remove All</span></a>
            <a class="mayosis-green-button white-color-text header-close-button"><span class="dashicons dashicons-dismiss"></span><span class="title-icon">Close Panel</span></a>
        </span>
      </div>

      <div class="ms-wrapper ms-wrapper-desktop">

        <div class="ms-wrap ms-desktop">

            <div class="ms ms-top">
                <div class="ms-tooltip" data-section="top_bar">Top bar <i class="dashicons dashicons-admin-generic"></i></div>

                <div class="ms-left ms-drop"
                    data-id="topbar_elements_left" id="resizable">
                </div>
                <div class="ms-center ms-drop"
                    data-id="topbar_elements_center" id="resizable">
                </div>
                <div class="ms-right ms-drop"
                    data-id="topbar_elements_right" id="resizable">
                </div>
            </div>
            <div class="ms ms-main">
                <div class="ms-tooltip" data-section="master_head">Header Main <i class="dashicons dashicons-admin-generic"></i></div>
                <div class="ms-left ms-drop"  data-id="header_elements_left">
                </div>
                <div class="ms-drop" data-id="header_elements_center">
                </div>
                <div class="ms-right ms-drop" data-id="header_elements_right">
                </div>
            </div>
            <div class="ms ms-bottom">
                <div class="ms-tooltip" data-section="bottom_bar">Header Bottom <i class="dashicons dashicons-admin-generic"></i></div>
                <div class="ms-left ms-drop"
                    data-id="header_elements_bottom_left">
                </div>
                
                <div class="ms-center ms-drop"
                    data-id="header_elements_bottom_center">
                </div>
            
                <div class="ms-right ms-drop"
                    data-id="header_elements_bottom_right">
                </div>
            </div>

        </div>
         <div class="ms ms-avaiable ms-avaiable-desktop">
         <div class="ms-tooltip">Not in use</div>
                <div class="ms-list ms-drop">
                    <?php
                        foreach ($builder_items as $key => $value) {
                           echo '<span data-id="'.$key.'"> <i class="dashicons dashicons-admin-generic"></i> '.$value.'</span>';
                        }
                    ?>
                </div>
            </div>
        </div><!-- .ms-wrapper -->

        <div class="ms-wrapper ms-wrapper-mobile">
            
    <div class="ms-sidebar ms-mobile">
        <div class="ms ms-top">
             <div class="ms-tooltip" data-section="top_bar">Sidebar(Mobile Hamburger menu) <i class="dashicons dashicons-admin-generic"></i></div>
                <div class="ms-left ms-drop-mobile"
                data-id="header_mobile_sidebar_left">
                </div>
                
                 <div class="ms-right ms-drop-mobile"
                data-id="header_mobile_sidebar_right">
                </div>
            </div>
            
             <div class="ms ms-main">
                <div class="ms-center ms-drop-mobile"
                data-id="header_mobile_elements_sidebar_main">
                </div>
            </div>
            
             <div class="ms ms-bottom">
                <div class="ms-left ms-drop-mobile"
                data-id="header_mobile_sidebar_bottom_left">
                </div>
                
                 <div class="ms-right ms-drop-mobile"
                data-id="header_mobile_sidebar_bottom_right">
                </div>
            </div>
    </div>

        <div class="ms-wrap ms-mobile">
            <div class="ms ms-top">
                <div class="ms-center ms-drop-mobile"
                data-id="header_mobile_elements_top">
                </div>
            </div>
            <div class="ms ms-main">
                <div class="ms-tooltip" data-section="header_mobile">Header Mobile<i class="dashicons dashicons-admin-generic"></i></div>
                <div class="ms-left ms-drop-mobile"
                    data-id="header_mobile_elements_left">
                </div>
                
                <div class="ms-left ms-drop-mobile"
                    data-id="header_mobile_elements_center">
                </div> 
                <div class="ms-right ms-drop-mobile"
                data-id="header_mobile_elements_right">
                </div>
            </div>
            <div class="ms ms-bottom">
                <div class="ms-full ms-center ms-drop-mobile"
                data-id="header_mobile_elements_bottom">
                </div>
            </div>

        </div><!-- Mobile -->

        <div class="ms ms-avaiable ms-avaiable-mobile">
        <div class="ms-tooltip">Not in use</div>
                <div class="ms-list ms-drop-mobile">
                    <?php
                        foreach ($builder_items as $key => $value) {
                           echo '<span data-id="'.$key.'"><i class="dashicons dashicons-admin-generic"></i> '.$value.'</span>';
                        }
                    ?>
                </div>
        </div>

        </div><!-- .mobile wrap -->
        </div><!-- .ms-wrapper -->

    </div>
    <?php
}
add_action('customize_controls_print_footer_scripts', 'mayosis_header_builder');
