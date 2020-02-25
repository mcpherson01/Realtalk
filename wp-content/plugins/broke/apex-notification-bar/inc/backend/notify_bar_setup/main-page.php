<?php defined('ABSPATH') or die("No script kiddies please!");?>
<div class="edn-wrap">
<?php
    if (isset($_GET['action'], $_GET['_wpnonce'], $_GET['nb_id']) && wp_verify_nonce($_GET['_wpnonce'], 'edn-edit-nonce')) {
        include_once('edit-notification-bar.php');
    } else {
?>
    <div class="edn-main-page-wrapper clearfix">
        <div class="edn-panel">
          <?php include_once(APEXNB_PRO_PATH.'inc/backend/panel-head.php');?>
            <?php
                if (isset($_GET['message'])) {
                    ?>
                    <div class="edn-message edn-message-success updated">
                        <p>
                            <?php
                            // echo $_SESSION['edn_message'];
                            // unset($_SESSION['edn_message']);
                            if(isset($_GET['message'])){
                              if($_GET['message'] == 3){
                                _e('Notification Bar Copied Successfully.', APEXNB_TD);
                              }else if($_GET['message'] == 2){
                                _e('Default Settings Added Successfully.', APEXNB_TD);
                              }else if($_GET['message'] == 1){
                                 _e('Notification Bar Updated Successfully.',APEXNB_TD);
                              }else if($_GET['message'] == 4){
                                 _e('Notification bar deleted successfully.',APEXNB_TD);
                              }
                            }
                            ?>
                        </p>
                    </div>
                    <?php
                }

            ?>
            <div class="edn-panel-body apexnb-backend-setup apexnb-bar-lists">
                <div class="edn-backend-h-title"><?php _e('Notification Bars Lists',APEXNB_TD); ?> 
                <a href="<?php echo admin_url() . 'admin.php?page=apexnb-add-bar' ?>" class="button-primary edn-add-new-h2"><?php _e('Add New',APEXNB_TD);?></a></div>
                   <form id="ednpro_live-search" action="" class="styled" method="post">
                  <fieldset>
                      <input type="search" class="text-input all-options" id="ednpro_filter" value="" 
                      placeholder="<?php _e('Search By Title',APEXNB_TD);?>"/>
                  </fieldset>
                </form>

                   <?php $edn_bars = $this->get_all_notification_bar_data();
                    if (count($edn_bars) > 0) { ?>
                             <div class="edn-pagination manage-column column-title sortable asc apexnb-pageination-lists" style="">
                               <div class="tablenav">
                                <div class="tablenav-pages">
                                  <?php $this->edn_custom_pagination(); ?>
                                 </div>
                                </div>
                             </div>
                             <?php } ?>
            
            <div class="apexnb-tbl-wrapper">  
                <table class="wp-list-table widefat fixed posts">
                    <thead>
                        <tr>
                            <th scope="col" id="title" class="manage-column column-title sortable asc" style="">
                                <a href="javascript:void(0)"> <span><?php _e('Title', APEXNB_TD); ?></span> </a>
                            </th>
                            <th scope="col" id="title" class="manage-column column-title sortable asc" style="">
                                <a href="javascript:void(0)"><span><?php _e('Position', APEXNB_TD); ?></span></a>
                            </th>
                            <th scope="col" id="template-shortcode" class="manage-column column-title sortable asc" style="">
                                <a href="javascript:void(0)"><span><?php _e('Template Style', APEXNB_TD); ?></span></a>
                            </th>
                             <th scope="col" id="template-shortcode" class="manage-column column-title sortable asc" style="">
                                <a href="javascript:void(0)"><span><?php _e('Last Modified', APEXNB_TD); ?></span></a>
                            </th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                             <th scope="col" class="manage-column column-title sortable asc" style=""><a href="javascript:void(0)"><span><?php _e('Title', APEXNB_TD); ?></span></a></th>
                             <th scope="col" id="title" class="manage-column column-title sortable asc" style=""><a href="javascript:void(0)"><span><?php _e('Position', APEXNB_TD); ?></span></a></th>
                             <th scope="col" id="template-shortcode" class="manage-column column-title sortable asc" style=""><a href="javascript:void(0)"><span><?php _e('Template Style', APEXNB_TD); ?></span></a></th>
                             <th scope="col" id="template-shortcode" class="manage-column column-title sortable asc" style=""><a href="javascript:void(0)"><span><?php _e('Last Modified', APEXNB_TD); ?></span></a></th>
                        </tr>
                    </tfoot>

                    <tbody id="the-list" data-wp-lists="list:post">
                      <tr  class="no-results" style="display:none;"><td><span id="filter-count"><?php _e('No any search results found.',APEXNB_TD);?></span></td><td></td></tr>
                    <?php 
                        // $this->edn_pro_print_array($edn_bars);
                        if (count($edn_bars) > 0) {
                            $pro_bar_counter = 1;
                            foreach ($edn_bars as $pro_bar) {
                                $each_bardata = unserialize($pro_bar->edn_bar);
                                if($each_bardata['edn_bar_type'] == 2){
                                    $templatenum = $each_bardata['edn_bar_template'];
                                    $template_type = "Template ".$templatenum;
                                }else{
                                    $template_type = "Custom";
                                }
                                //$this->edn_pro_print_array($each_bardata);
                                $edit_nonce = wp_create_nonce('edn-edit-nonce');
                                $delete_nonce = wp_create_nonce('edn-delete-nonce');
                                $copy_nonce = wp_create_nonce('edn-copy-nonce');
                                ?>
                                <tr <?php if ($pro_bar_counter % 2 != 0) { ?>class="alternate"<?php } ?>>
                                    <td class="title column-title">
                                        <strong>
                                            <a class="row-title" href="<?php echo admin_url() . 'admin.php?page=apexnb-pro&action=edit_nb&nb_id=' . $pro_bar->nb_id . '&_wpnonce=' . $edit_nonce; ?>" title="Edit">
                                                <?php echo esc_attr($pro_bar->edn_bar_name); ?>
                                            </a>
                                        </strong>
                                        <div class="row-actions">
                                            <span class="edit"><a href="<?php echo admin_url() . 'admin.php?page=apexnb-pro&action=edit_si&nb_id=' . $pro_bar->nb_id . '&_wpnonce=' . $edit_nonce; ?>">Edit</a> | </span>
                                            <span class="copy"><a href="<?php echo admin_url() . 'admin-post.php?action=edn_copy_action&nb_id=' . $pro_bar->nb_id . '&_wpnonce=' . $copy_nonce; ?>" onclick="return confirm('<?php _e('Are you sure you want to copy this notification bar?', APEXNB_TD); ?>')"><?php _e('Copy', APEXNB_TD); ?></a> | </span>
                                            <span class="delete"><a href="<?php echo admin_url() . 'admin-post.php?action=edn_delete_action&nb_id=' . $pro_bar->nb_id . '&_wpnonce=' . $delete_nonce; ?>" onclick="return confirm('<?php _e('Are you sure you want to delete this notification bar?', APEXNB_TD); ?>')"><?php _e('Delete', APEXNB_TD); ?></a> | </span>
                                            <span class="apex-preview"><a href="<?php echo site_url( '?apexnb_bar_preview=true&_wpnonce=' . $edit_nonce.'&nb_id=' . $pro_bar->nb_id ); ?>" target="_blank"><?php _e('Preview', APEXNB_TD); ?></a> | </span>
                                        </div>
                                    </td>
                                    <td class="shortcode column-shortcode"><?php echo esc_attr(ucwords(str_replace('_', ' ', $pro_bar->edn_position))); ?></td>
                                    <td class="shortcode column-shortcode"><?php echo esc_attr($template_type); ?></td>
                                    <td class="shortcode column-shortcode"><?php echo date( 'h:i:s A M jS, Y ', strtotime( $pro_bar->nb_modified ) ); ?></td>
                                </tr>
                                <?php
                                $pro_bar_counter++;
                            }               
                      } else {
                            ?>
                            <tr><td colspan="2"><div class="edn-noresult"><?php _e('Notification bar not added yet.', APEXNB_TD); ?></div></td></tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

                  <?php if (count($edn_bars) > 0) { ?>
                             <div class="edn-pagination manage-column column-title sortable asc" style="">
                               <div class="tablenav">
                                <div class="tablenav-pages">
                                  <?php $this->edn_custom_pagination(); ?>
                                 </div>
                                </div>
                             </div>
                             <?php } ?>
            </div><!--edn-panel-body-->
        </div><!--edn-panel-->
    </div><!-- edn-add-bar-wrapper -->
<?php }?>
</div><!-- edn-wrap -->

