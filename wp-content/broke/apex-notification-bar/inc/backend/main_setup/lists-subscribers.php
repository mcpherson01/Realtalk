<?php defined('ABSPATH') or die("No script kiddies please!"); 
global $wpdb; // this is how you get access to the database
if(isset($_POST['remove_subs'])){
            $table_name = $wpdb->prefix . 'apexnb_subscriber';
            if ( isset( $_POST['rem'] ) ) {
                $si_id = $_POST['rem'];
                if(!$si_id ==''){
                    foreach($si_id as $id){
                        $wpdb->delete( $table_name, array( 'id' => $id ), array( '%d' ) );
                      $_SESSION['edn-message'] = __('User deleted successfully.',APEXNB_TD);
                     //   wp_redirect(admin_url('admin.php?page=apexnb-opt-subscribers-list&message=1'));
                    }  
                }else{
                $_SESSION['edn-message'] = __('Fail to delete',APEXNB_TD);
                   // wp_redirect(admin_url('admin.php?page=apexnb-opt-subscribers-list&message=2'));
                }
            }else{
             $_SESSION['edn-message'] = __('No any data choosed.',APEXNB_TD);
               // wp_redirect(admin_url('admin.php?page=apexnb-opt-subscribers-list&message=3'));
            }
        }
?>
<div class="edn-wrap edn-clear">
            <div class="edn-body-wrapper edn-settings-wrapper clearfix">
                <div class="edn-panel">
                 <?php include_once(APEXNB_PRO_PATH.'inc/backend/panel-head.php');?>
                 <div class="edn-panel-body apexnb-backend-setup apexnb-lists-subscribers">
                    <?php
                    if (isset($_SESSION['edn-message'])) {
                        ?>
                        <div class="edn-message edn-message-success updated">
                            <p>
                                <?php
                                echo $_SESSION['edn-message'];
                                ?>
                            </p>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="edn-form-wrap">
                     <div class="edn-backend-h-title"><?php _e('Visitors Subscriptions',APEXNB_TD);?></div>
                     <form method="post" action=""> 
                         <div class="ednpro-subscribe_list ednpro-panel-body">
                            <input type="submit" name="remove_subs" id="ednpro-remove-sub" class="button button-primary edn_subs_remove_button apexnb-btn" value="Remove Subscriber" onclick="return confirm('<?php _e('Are you sure you want to delete?', APEXNB_TD); ?>')" />

                            <a class="button button-primary apexnbpro-export-csv apexnb-btn" href="<?php echo plugins_url( 'export-csv.php', __FILE__ ); ?>">Export as CSV</a>    
                            <table class="widefat">
                                <thead>
                                    <tr>
                                        <th scope="col" id="sub_cbx" class="manage-column column-title sortable asc" style="width: 40px;">
                                            <span><input type="checkbox" name="checkall_sub" value="1" id="ednpro-subs-checkall" /></span>
                                        </th>
                                        <th scope="col" id="sub_email" class="manage-column column-title sortable asc" style="">
                                            <span><?php _e('Email', APEXNB_TD); ?></span> 
                                        </th>
                                        <th scope="col" id="sub_date" class="manage-column column-shortcode" style="">
                                            <span><?php _e('Subscribtion Date', APEXNB_TD); ?></span> 
                                        </th>
                                        <th scope="col" id="sub_date" class="manage-column column-shortcode" style="">
                                            <span><?php _e('Send Email Reply', APEXNB_TD); ?></span> 
                                        </th>
                                    </tr>
                                </thead>

                                <tbody id="the-list" data-wp-lists="list:post">
                                    <?php
                                    $table_name = $wpdb->prefix . 'apexnb_subscriber';
                                    $subs_datas = $wpdb->get_results( " SELECT * FROM $table_name WHERE email IS NOT NULL AND TRIM(email) <> ''");

                                    if (count($subs_datas) > 0) {

                                        foreach ($subs_datas as $subs_data) { ?>
                                        <tr>
                                            <td class="shortcode column-shortcode"><tr>
                                                <th class="check-column" style="padding:5px 0 2px 0;width: 40px;"><?php echo '<input type="checkbox" name="rem[]" class="edn-select-all-subs" value="'.esc_js(esc_html($subs_data->id)).'">'; ?>
                                                </td>
                                                <td class="shortcode column-shortcode"><?php echo $subs_data->email; ?></td>
                                                <td class="shortcode column-shortcode"><?php echo $subs_data->date; ?></td>
                                                <td class="shortcode column-shortcode"><a href= "mailto:<?php echo $subs_data->email;?>"><?php _e('Send Email',APEXNB_TD);?></a></td>
                                            </tr>
                                            <?php }
                                        }
                                        else{ ?>
                                        <tr>
                                            <td colspan="2">
                                                <div class="edn-noresult"><?php _e('No Subscribers Found', APEXNB_TD); ?></div>
                                            </td>
                                        </tr>
                                        <?php } ?>


                                    </table> 
                                </div>
                            </form>

                        </div>
                    </div><!-- .edn-panel-body -->
                </div>
            </div>
        </div>