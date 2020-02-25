<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<table data-id="<?php echo $id; ?>">
    <?php
    foreach ($group as $k => $rule) {
        $data = array('rule' => $rule, 'id' => $k, 'group_id' => $id, 'input_name' => $input_name);
        echo NjtFbPrView::load('admin.conditional-rule', $data);
    }
    ?>
</table>
<h4 class="njt_fb_pr_group_or_title" data-for_group="<?php echo $id; ?>"><?php _e('Or', NJT_FB_PR_I18N); ?></h4>