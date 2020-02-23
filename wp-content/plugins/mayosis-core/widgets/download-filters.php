<?php
add_action('widgets_init', 'mayosis_download_filters');

function mayosis_download_filters()
{
    register_widget('mayosis_download_filters');
}

class mayosis_download_filters extends WP_Widget {

    function __construct()
    {
        $widget_ops = array('classname' => 'mayosis_download_filters', 'description' =>esc_html__('Displays download item filters. Used in Download Category Sidebar','mayosis'));
        $control_ops = array('id_base' => 'mayosis_download_filters');
        parent::__construct('mayosis_download_filters', esc_html__('Mayosis download Filters','mayosis'), $widget_ops, $control_ops);
    }

    function widget($args, $instance)
    {
        extract($args);
        echo $before_widget;
        ?>
        <div class="mayosis-filter">
            <?php
            $OldestFirst=null;
            $Lowtohigh=null;
            $Hightolow=null;
            $BestReady=null;
            $NewstFirst=null;
            $TitleAtoZ=null;
            $TitleZtoA=null;
            if(isset($_GET['orderby'])){
                if($_GET['orderby']=="price_asc"){
                    $Lowtohigh="selected";
                }

                else if($_GET['orderby']=="price_desc"){
                    $Hightolow="selected";
                }
                
                else if($_GET['orderby']=="newness_asc"){
                    $NewstFirst="selected";
                }

                else if($_GET['orderby']=="newness_desc"){
                    $OldestFirst="selected";
                }
                else if($_GET['orderby']=="sales"){
                    $BestReady="selected";
                }
                
                else if($_GET['orderby']=="title_asc"){
                    $TitleAtoZ="selected";
                }
                
                else if($_GET['orderby']=="title_desc"){
                    $TitleZtoA="selected";
                }

            }
            else{
                $OldestFirst="selected";
            } ?>
        <select class="product_filter_mayosis" onchange="if (this.value) window.location.href=this.value">

            <option <?php echo esc_html($OldestFirst); ?> value="<?php echo esc_url(add_query_arg(array( 'orderby'=>'newness_desc'))); ?>"><?php esc_html_e('Newest First','mayosis'); ?></option>
            
            <option <?php echo esc_html($NewstFirst); ?>  value="<?php echo esc_url(add_query_arg(array( 'orderby'=>'newness_asc'))); ?>"><?php esc_html_e('Oldest First','mayosis'); ?></option>
            
            <option <?php echo esc_html($Lowtohigh); ?> value="<?php echo esc_url(add_query_arg(array( 'orderby'=>'price_asc'))); ?>"><?php esc_html_e('Lowest to Hightest','mayosis'); ?></option>
            
            <option <?php echo esc_html($Hightolow); ?> value="<?php echo esc_url(add_query_arg(array( 'orderby'=>'price_desc'))); ?>"><?php esc_html_e('Hightest to Lowest','mayosis'); ?></option>
            
            <option <?php echo esc_html($BestReady); ?> value="<?php echo esc_url(add_query_arg(array( 'orderby'=>'sales'))); ?>"><?php esc_html_e('Best Selling','mayosis'); ?></option>
            
            <option <?php echo esc_html($TitleAtoZ); ?>  value="<?php echo esc_url(add_query_arg(array( 'orderby'=>'title_asc'))); ?>"><?php esc_html_e('Title (A - Z)','mayosis'); ?></option>
            
            <option <?php echo esc_html($TitleZtoA); ?> value="<?php echo esc_url(add_query_arg(array( 'orderby'=>'title_desc'))); ?>"><?php esc_html_e('Title (Z - A)','mayosis'); ?></option>
        </select>
        
        </div>
        <?php
        echo $after_widget;
    }
}
