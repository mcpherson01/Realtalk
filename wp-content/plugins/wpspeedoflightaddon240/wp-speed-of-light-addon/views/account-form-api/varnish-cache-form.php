<?php
$varnish = get_option('wpsol_addon_varnish_ip');
?>
<div class="account-form" id="varnish-cache-form">
    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td><label><?php esc_html_e('Varnish Server IP', 'wp-speed-of-light-addon'); ?></label></td>
            <td><input type="text" value="<?php echo(!empty($varnish['ip']) ? esc_html($varnish['ip']) : '127.0.0.1') ?>"
                       class="ju-input"  name="varnish-ip"/></td>
        </tr>
        <tr>
            <td>
                <button type="button" id="varnish-save-settings"
                       class="ju-button orange-button waves-effect waves-light cdn-btn">
                    <span><?php esc_html_e('Save', 'wp-speed-of-light-addon'); ?></span>
                </button>
                <label class="varnish-display-results">Saved!</label>
            </td>
        </tr>
    </table>
</div>