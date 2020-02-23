<div class="wrap arfforms_page">
    <div class="top_bar" style="margin-bottom: 10px;">
	<span class="h2"> <?php echo addslashes(__('ARForms Add-Ons','ARForms')); ?></span>
    </div>
	<div id="poststuff" class="">
    	<div id="post-body" >
        	<div class="addon_content">
                <div class="addon_page_desc"> <?php echo __('Add more features to ARForms using Add-Ons','ARForms'); ?></div>
                <div class="addon_page_content">
					<?php
						global $arsettingcontroller;
						$arsettingcontroller->addons_page();
					?>
                </div>
            </div>
        </div>
    </div>
</div>
