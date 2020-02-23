<?php
global $current_user, $arformcontroller;
?>
<style>
    .purchased_info{
        color:#7cba6c;
        font-weight:bold;
        font-size: 15px;
    }
    .wrap .greensavebtn {cursor:pointer;outline:0;background-color:#8ccf7a;-moz-box-shadow:0 4px 0 0 #7CBA6C;-o-box-shadow:0 4px 0 0 #7CBA6C;-webkit-box-shadow:0 4px 0 0 #7CBA6C;box-shadow:0 4px 0 0 #7CBA6C;color:#FFF}
    .wrap .greensavebtn:hover{cursor:pointer;outline:0;background-color:#7cba6c;-moz-box-shadow:0 4px 0 0 #70a761;-o-box-shadow:0 4px 0 0 #70a761;-webkit-box-shadow:0 4px 0 0 #70a761;box-shadow:0 4px 0 0 #70a761;color:#FFF}

	#license_success{
		color:#8ccf7a !important;
	}
    #arfresetlicenseform.arfmodal {
        border-radius:0px;
        -webkit-border-radius:0px;
        -o-border-radius:0px;
        -moz-border-radius:0px;
        text-align:center;
        width:700px;
        height:500px;
        left:35%;
        border:none;
    }
	.arfnewmodalclose
    {
        font-size: 15px;
        font-weight: bold;
        height: 19px;
        position: absolute;
        right: 3px;
        top:5px;
        width: 19px;
        cursor:pointer;
        color:#D1D6E5;
    }
</style> 
<div class="wrap arf_license_page">

    <span class="h2" style="padding-left:30px;padding-top:30px;position: absolute;"><?php echo addslashes(__('Manage ARForms License', 'ARForms')); ?></span>

    <div id="poststuff" class="metabox-holder">


        <div id="post-body" style="margin-top:80px !important;">

            <div class="inside" style="background-color:#ffffff;">    


                <div class="clear"></div>

                <form name="frm_license_form" method="post" class="frm_license_form" onsubmit="return global_form_validate();">

                    <div style="margin-left: 15px;">
                       <?php
                        if (isset($message) && $message != '') {
                            ?>
                            <?php
                            if (is_admin()) {
                                ?>
                                <script type="text/javascript" language="javascript"> setTimeout( function(){ success_msg(); },100 ); </script>
                                <div id="success_message" class="arf_success_message">
                                <div class="message_descripiton">
                                    <div style="float: left; margin-right: 15px;"><?php } echo $message; if(is_admin()){ ?></div>
                                    <div class="message_svg_icon">
                                    <svg style="height: 14px;width: 14px;"><path fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M6.075,14.407l-5.852-5.84l1.616-1.613l4.394,4.385L17.181,0.411
    l1.616,1.613L6.392,14.407H6.075z"></path></svg>
                                </div>
                                </div>
                                </div>
                                <?php
                                    }
                                }
                                ?>

                        <?php if (isset($errors) && is_array($errors) && count($errors) > 0) { ?>



                            <div style="margin-bottom:0px; margin-top:8px;">

                                <ul id="frm_errors" style="margin-bottom: 3px; margin-top: 3px;">

                                    <?php
                                    foreach ($errors as $error)
                                        echo '<li><div class="arferrmsgicon"></div><div id="error_message">' . stripslashes($error) . '</div></li>';
                                    ?>

                                </ul>

                            </div>

                        <?php } ?>
                    </div>


                    <div id="general_settings" style="border-top:none; background-color:#FFFFFF; border-radius:5px 5px 5px 5px;-webkit-border-radius:5px 5px 5px 5px;-o-border-radius:5px 5px 5px 5px;-moz-border-radius:5px 5px 5px 5px; padding-top:10px; padding-left: 20px; padding-top: 30px; padding-bottom:1px; ">


                        <table class="form-table" style="margin-top:0px;">

                            <?php
                            $hostname = $_SERVER["HTTP_HOST"];
							$get_purchased_info = "";
                            global $arformcontroller,$arformsplugin;
                            $setvaltolic = 0;
                            $setvaltolic = $arformcontroller->$arformsplugin();
                            
                            if ($setvaltolic == 1) {
                                $get_purchased_info = get_option('arfSortInfo');
                                $sortorderval = base64_decode($get_purchased_info);
                                $ordering = array();
                                
                                $pcodeinfo = "";
                                $pcodedate = "";
                                $pcodedateexp = "";
                                $pcodelastverified = "";
                                $pcodecustemail = "";
                                
                                if(is_array($ordering))
                                {
                                    $ordering = explode("^", $sortorderval);
                                    
                                    $pcodeinfo = $ordering[0];
                                    $pcodedate = $ordering[1];
                                    $pcodedateexp = $ordering[2];
                                    $pcodelastverified = $ordering[3];
                                    $pcodecustemail = $ordering[4];
                                }
                                
                                ?>
                                <tr class="arfmainformfield" valign="top"><td class="lbltitle" colspan="2"><?php echo addslashes(__('ARForms License', 'ARForms')); ?>&nbsp;</td></tr>

                                <tr class="arfmainformfield" valign="top">


                                    <td class="tdclass" style="padding-left:30px; vertical-align:top; padding-top:25px;" width="18%">



                                        <label class="lblsubtitle"><?php echo addslashes(__('License Status', 'ARForms'));?></label>

                                    </td>

                                    <td>	
                                        <div id="licenseactivatedmessage" class="updated" style="width:250px; vertical-align:top;"><?php echo "Your license is currently Active."; ?></div>

                                        <span id="license_link"><button type="button" id="remove-license-purchase-code" name="remove_license" style="width:150px; border:0px; color:#FFFFFF; height:40px; border-radius:3px;-webkit-border-radius:3px;-o-border-radius:3px;-moz-border-radius:3px;" onclick="deactivate_license();" class="red_remove_license_btn"><?php echo addslashes(__('Remove License', 'ARForms')); ?></button></span>

                                        <span id="deactivate_loader" style="display:none;"><img src="<?php echo ARFURL . '/images/loading_299_1.gif'; ?>" height="15" /></span>   		
                                        <span id="deactivate_error" class="frm_not_verify_li" style="display:none;"><?php echo addslashes(__('There is some error while processing your request', 'ARForms')); ?></span>
                                        <span id="deactivate_success" class="frm_verify_li"  style="display:none;"><?php echo addslashes(__('License Deactivated Successfully.', 'ARForms')); ?></span>


                                    </td>
                                </tr>
                                
                                <?php if($get_purchased_info != "") { ?>
                                
                                <tr class="arfmainformfield" valign="top">


                                    <td class="tdclass" style="padding-left:30px;" width="25%" >



                                        

                                    </td>
                                    
                                    <td>	
                                       
                                       <label class="lblsubtitle" style="font-weight:bold;margin-left:-135px;"><?php echo addslashes(__('Activation Information:', 'ARForms')); ?>&nbsp;&nbsp;</label>


                                    </td>
                                    

                                </tr>
                                
                                <tr class="arfmainformfield" valign="top">


                                    <td class="tdclass" style="padding-left:30px;" width="25%">



                                        <label class="lblsubtitle"><?php echo addslashes(__('Purchase Code:', 'ARForms')); ?>&nbsp;&nbsp;</label>

                                    </td>

                                    <td>	
                                       
                                        <label class="purchased_info"><?php echo $pcodeinfo;?></label>


                                    </td>
                                </tr>
                                
                                <tr class="arfmainformfield" valign="top">


                                    <td class="tdclass" style="padding-left:30px;" width="25%">



                                        <label class="lblsubtitle"><?php echo addslashes(__('Purchased On:', 'ARForms')); ?>&nbsp;&nbsp;</label>

                                    </td>

                                    <td>	
                                       
                                          <label class="purchased_info"><?php echo $pcodedate;?></label>


                                    </td>
                                </tr>

                                <tr class="arfmainformfield" valign="top">

                                    <td class="tdclass" style="padding-left:30px;" width="25%">         			


                                        <label class="lblsubtitle"><?php echo addslashes(__('Support Expires On:', 'ARForms')); ?>&nbsp;&nbsp;</label>

                                    </td>

                                    <td>	

                                        <label class="purchased_info"><?php echo $pcodedateexp;?></label>

                                    </td>


                                </tr>

                                
                                <tr class="arfmainformfield" valign="top">


                                    <td class="tdclass" style="padding-left:30px;" width="25%">



                                        <label class="lblsubtitle"><?php echo addslashes(__('Customer Email:', 'ARForms')); ?>&nbsp;&nbsp;&nbsp;</label>

                                    </td>

                                    <td>	
                                        
                                           <label class="purchased_info"><?php echo $pcodecustemail;?></label>


                                    </td>
                                </tr> 
								
                                <?php } ?>
                               
                                <tr class="arfmainformfield" valign="top">
                                    <td colspan="2"><div style="width:96%" class="dotted_line"></div></td>
                                </tr>

                                <?php
                            }
                            if ($setvaltolic != 1) {
                                ?>


                                <tr class="arfmainformfield" valign="top"><td class="lbltitle" colspan="2"><?php echo addslashes(__('Product License', 'ARForms')); ?>&nbsp;</td></tr>

                                <tr>
                                    <td colspan="2">
                                        <label class="lblsubtitle"><?php echo addslashes(__('A valid license key entitles you to support and enables automatic upgrades. Also you can remove Rebradning link only after activate your license. A license key only be used for one installation of WordPress at a time.', 'ARForms')); ?></label><br /><br />
                                    </td>
                                </tr>

                                <tr class="arfmainformfield" valign="top">


                                    <td class="tdclass" style="padding-left:30px;" width="18%">



                                        <label class="lblsubtitle"><?php echo addslashes(__('Customer Name', 'ARForms')); ?>&nbsp;&nbsp;<span style="vertical-align:middle" class="arfglobalrequiredfield">*</span></label>

                                    </td>

                                    <td>	
                                        <input type="text" name="li_customer_name" id="li_customer_name" class="txtstandardnew" size="42" value="Shadow" autocomplete="off" />
                                        <div class="arferrmessage" id="li_customer_name_error" style="display:none;"><?php echo addslashes(__('This field cannot be blank.', 'ARForms')); ?></div>



                                    </td>
                                </tr>

                                <tr class="arfmainformfield" valign="top">


                                    <td class="tdclass" style="padding-left:30px;" width="18%">



                                        <label class="lblsubtitle"><?php echo addslashes(__('Customer Email', 'ARForms')); ?>&nbsp;&nbsp;&nbsp;</label>

                                    </td>

                                    <td>	
                                        <input type="text" name="li_customer_email" id="li_customer_email" class="txtstandardnew" size="42" value="" autocomplete="off" />



                                    </td>
                                </tr> 	

                                <tr class="arfmainformfield" valign="top">

                                    <td class="tdclass">        			


                                        <label class="lblsubtitle"><?php echo addslashes(__('Purchase Code', 'ARForms')); ?>&nbsp;&nbsp;<span style="vertical-align:middle" class="arfglobalrequiredfield">*</span></label>

                                    </td>

                                    <td>	

                                        <input type="text" name="li_license_key" id="li_license_key" class="txtstandardnew" size="42" value="" autocomplete="off" placeholder="Type 'www.nulled.ch' here"/>
                                        <div class="arferrmessage" id="li_license_key_error" style="display:none;"><?php echo addslashes(__('This field cannot be blank.', 'ARForms')); ?></div>

                                    </td>


                                </tr>

                                <tr class="arfmainformfield" valign="top">

                                    <td class="tdclass">        			


                                        <label class="lblsubtitle"><?php echo addslashes(__('Domain Name', 'ARForms')); ?>&nbsp;&nbsp;&nbsp;</label>

                                    </td>

                                    <td>	
                                        <label class="lblsubtitle"><?php echo $hostname; ?></label>
                                        <input type="hidden" name="li_domain_name" id="li_domain_name" class="txtstandardnew" size="42" value="<?php echo $hostname; ?>" autocomplete="off" />

                                    </td>


                                </tr>

                                <tr class="arfmainformfield" valign="top">

                                    <td class="tdclass">        			


                                    </td>



                                    <td>					
                                        <span id="license_link"><button type="button" id="verify-purchase-code" name="continue" style="width:150px; border:0px; color:#FFFFFF; height:40px; border-radius:3px;-webkit-border-radius:3px;-o-border-radius:3px;-moz-border-radius:3px;" class="greensavebtn"><?php echo addslashes(__('Activate License', 'ARForms')); ?></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-can-I-find-my-Purchase-Code-" target="_blank" title="Get Your Purchase Code">Where can I find my Purchase Code?</a></span>
                                        <span id="license_loader" style="display:none;"><img src="<?php echo ARFURL . '/images/loading_299_1.gif'; ?>" height="15" /></span>   		
                                        <span id="license_error" class="frm_not_verify_li" style="display:none;">&nbsp;</span>
                                        <span id="license_reset" class="frm_not_verify_li" style="display:none;"><a data-toggle="arfmodal" onclick="arfresetlicenseform();" href="#arfresetlicenseform">Click here to RESET</a></span>
                                        <span id="license_success" class="frm_verify_li"  style="display:none;"><?php echo addslashes(__('License Activated Successfully.', 'ARForms')); ?></span>
                                    </td>




                                </tr>


                                <tr class="arfmainformfield" valign="top">
                                    <td colspan="2"><div style="width:96%" class="dotted_line"></div></td>
                                </tr>

                            <?php }
							
							if(isset($installed_addons) && is_array($installed_addons) && count($installed_addons) > 0) {
                            foreach($installed_addons as $key => $addon){
                                ?>


                                <tr class="arfmainformfield" valign="top"><td class="lbltitle" colspan="2"><?php echo $addon["name"]; ?>&nbsp;</td></tr>

                                <tr>
                                    <td colspan="2">
                                        <label class="lblsubtitle"><?php echo addslashes(__('A valid license key entitles you to support and enables automatic upgrades. Also you can remove Rebradning link only after activate your license. A license key only be used for one installation of WordPress at a time.', 'ARForms')); ?></label><br /><br />
                                    </td>
                                </tr>

                                

                                <tr class="arfmainformfield" valign="top">

                                    <td class="tdclass">        			


                                        <label class="lblsubtitle"><?php echo addslashes(__('Purchase Code', 'ARForms')); ?>&nbsp;&nbsp;<span style="vertical-align:middle" class="arfglobalrequiredfield">*</span></label>

                                    </td>

                                    <td>	

                                        <input type="text" name="li_license_key" id="li_license_key" class="txtstandardnew" size="42" value="" autocomplete="off" placeholder="Type 'www.nulled.ch' here"/>
                                        <div class="arferrmessage" id="li_license_key_error" style="display:none;"><?php echo addslashes(__('This field cannot be blank.', 'ARForms')); ?></div>

                                    </td>


                                </tr>

                                <tr class="arfmainformfield" valign="top">

                                    <td class="tdclass">        			


                                        <label class="lblsubtitle"><?php echo addslashes(__('Domain Name', 'ARForms')); ?>&nbsp;&nbsp;&nbsp;</label>

                                    </td>

                                    <td>	
                                        <label class="lblsubtitle"><?php echo $hostname; ?></label>
                                        <input type="hidden" name="li_domain_name" id="li_domain_name" class="txtstandardnew" size="42" value="<?php echo $hostname; ?>" autocomplete="off" />

                                    </td>


                                </tr>

                                <tr class="arfmainformfield" valign="top">

                                    <td class="tdclass">        			


                                    </td>



                                    <td>					
                                        <span id="license_link"><button type="button" id="verify-purchase-code" name="continue" style="width:150px; border:0px; color:#FFFFFF; height:40px; border-radius:3px;-webkit-border-radius:3px;-o-border-radius:3px;-moz-border-radius:3px;" class="greensavebtn"><?php echo addslashes(__('Activate License', 'ARForms')); ?></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-can-I-find-my-Purchase-Code-" target="_blank" title="Get Your Purchase Code">Where can I find my Purchase Code?</a></span>
                                        <span id="license_loader" style="display:none;"><img src="<?php echo ARFURL . '/images/loading_299_1.gif'; ?>" height="15" /></span>   		
                                        <span id="license_error" class="frm_not_verify_li" style="display:none;">&nbsp;</span>
                                        <span id="license_success" class="frm_verify_li"  style="display:none;"><?php echo addslashes(__('License Activated Successfully.', 'ARForms')); ?></span>
                                    </td>




                                </tr>


                                <tr class="arfmainformfield" valign="top">
                                    <td colspan="2"><div style="width:96%" class="dotted_line"></div></td>
                                </tr>

                            <?php }
							}  ?>

                        </table>


                    </div>
                    
                </form>
                
                
                <?php do_action('arf_addon_license_activation_block'); ?>
                
            </div>  
        </div>
    </div>
</div>
<div id="arfresetlicenseform" style="display:none; left:30%;" class="arfmodal hide fade">
		
		<div class="arfnewmodalclose" data-dismiss="arfmodal" onclick="Closeresetmodal();"><img src="<?php echo ARFIMAGESURL . '/close-button.png'; ?>" align="absmiddle" /></div>
        <div class="newform_modal_title_container">
        	<div class="newform_modal_title">&nbsp;RESET LICENSE</div>
    	</div>
       <div class="newmodal_field_title"><?php echo addslashes(__('Please submit this form if you have trouble activating license.', 'ARForms')); ?></div>
        <iframe style="display:block; height:100%; width:100%; margin-top:0px;" frameborder="0" name="test" id="resetlicframe" src="" hspace="0"></iframe>
</div>                 