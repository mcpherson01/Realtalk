<div class="wrap">
    <h3><?php _e('Facebook Accounts', NJT_FB_PR_I18N) ?></h3>
    
    <p>
        <?php echo $connect_to_facebook_btn; ?>
    </p>
    <table class="wp-list-table widefat fixed striped posts">
        <thead>
            <tr>
                <th scope="row"><?php _e('ID', NJT_FB_PR_I18N) ?></th>
                <th scope="row"><?php _e('Name', NJT_FB_PR_I18N) ?></th>
                <th scope="row"><?php _e('Delete', NJT_FB_PR_I18N) ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($admins as $id => $name) {
                ?>
                <tr>
                    <td><a href="<?php echo add_query_arg(array('page' => $dashboard_page_slug, 'user_id' => $id), admin_url('admin.php')); ?>"><?php echo $id; ?></a></td>
                    <td><?php echo $name; ?></td>
                    <td>
                        <a onclick="return confirm('<?php _e('Are you sure?', NJT_FB_PR_I18N); ?>');" class="button" href="<?php echo add_query_arg(array('page' => $dashboard_page_slug, 'reload_pages' => 'true', 'user_id' => $id, '_nonce' => $nonce, 'return_url' => $fbaccount_page), admin_url('admin.php')); ?>">
                            <span class="dashicons dashicons-trash"></span>
                        </a>
                    </td>
                </tr>
                <?php
            }
            ?>
            
        </tbody>
    </table>
</div>