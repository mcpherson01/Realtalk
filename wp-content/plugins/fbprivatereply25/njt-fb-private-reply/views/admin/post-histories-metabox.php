<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<table class="wp-list-table widefat fixed striped posts">
    <thead>
        <tr>
            <th><?php _e('Sender Name', NJT_FB_PR_I18N); ?></th>
            <th><?php _e('Sender ID', NJT_FB_PR_I18N); ?></th>
            <th><?php _e('Message', NJT_FB_PR_I18N); ?></th>
            <th><?php _e('Time', NJT_FB_PR_I18N); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($histories as $k => $v) {
            $sender_id = ((isset($v['sender_id'])) ? $v['sender_id'] : $v['from']['id']);
            ?>
            <tr>
                <td><?php echo ((isset($v['sender_name'])) ? $v['sender_name'] : $v['from']['name']); ?></td>
                <td><?php echo sprintf('<a href="%1$s" target="_blank">%2$s</a>', esc_url('https://facebook.com/' . $sender_id), $sender_id); ?></td>
                <td><?php echo $v['message']; ?></td>
                <td><?php echo date_i18n('Y-m-d H:i:s', $v['created_time']); ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
