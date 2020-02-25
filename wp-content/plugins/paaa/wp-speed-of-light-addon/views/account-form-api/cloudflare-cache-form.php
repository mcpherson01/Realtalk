<?php
$cloudflare = get_option('wpsol_addon_author_cloudflare');
?>
<div class="account-form" id="cloudflare-cache-form">
    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td><label><?php esc_html_e('Username', 'wp-speed-of-light-addon'); ?></label></td>
            <td><input type="text" value="<?php echo(!empty($cloudflare['username']) ? esc_html($cloudflare['username']) : '') ?>"
                     class="ju-input"  name="cloudflare-username"/></td>
        </tr>
        <tr>
            <td><label><?php esc_html_e('API Key', 'wp-speed-of-light-addon'); ?></label></td>
            <td><input type="text" value="<?php echo(!empty($cloudflare['key']) ? esc_html($cloudflare['key']) : '') ?>"
                       class="ju-input"    name="cloudflare-key"/></td>
        </tr>
        <tr>
            <td><label><?php esc_html_e('Domains', 'wp-speed-of-light-addon'); ?></label></td>
            <td><input type="text" value="<?php echo(!empty($cloudflare['domain']) ? esc_html($cloudflare['domain']) : '') ?>"
                       class="ju-input"     name="cloudflare-domain"/></td>
        </tr>
        <tr>
            <td>
                <button type="button" id="cloudflare-save-settings"
                       class="ju-button orange-button waves-effect waves-light cdn-btn">
                    <span><?php esc_html_e('Save', 'wp-speed-of-light-addon'); ?></span>
                </button>
                <label class="cloudflare-display-results">Saved!</label>
            </td>
        </tr>
    </table>
</div>