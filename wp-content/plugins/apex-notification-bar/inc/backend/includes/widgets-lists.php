<div class="edn-lightbox">
    <div class="edn-lightbox-inner-wrap">
        <div class="edn-lightbox-inner-content">
            <a href="javascript:void(0)" class="edn-close-widgets" aria-label="font close button"><span class="dashicons dashicons-no-alt"></span></a>
                <div class="edn-row">
             <div class="lists_widgets">       
               <h3><?php _e('Lists Of Widgets',APEXNB_TD)?></h3>
                 <ul class="clearfix"><?php $get_all_widgets = APEXNB_Class::edn_get_available_widgets();
                    foreach ($get_all_widgets as $key => $value) { ?>
                     <li class="all_wp_widgets" data-value="<?php echo $value['value'];?>" 
                     data-text="<?php echo $value['text'];?>">
                       <div class="widget-type-wrapper">
                         <span class="widget-icon dashicons dashicons-wordpress"></span>
                          <h3><?php echo $value['text'];?></h3>
                          <p class="widgets_description"><?php echo $value['description'];?></p>
                        </div>
                     </li>
                   <?php }
                  ?>
                 </ul>
                </div>
                </div> 
        </div>
    </div>
</div>