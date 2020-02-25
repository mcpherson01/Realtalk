<?php /* @var $this wtb_idf_calculator_actions */ ?>

<div class="wrap">
    <h2><?php echo __('Edit', 'wtb_idf_calculator') ?></h2>

    <form method="post" action="admin.php?page=wtb-idf-stop-keywords" class="validate">
        <input type="hidden" name="page" value="wtb-idf-stop-keywords" />
        <input type="hidden" name="action" value="save" />
        <input type="hidden" name="stopkeyword" value="<?php echo esc_attr($sk->id) ?>" />
        <?php wp_original_referer_field(true, 'previous'); ?>
        <table class="form-table">
            <tr class="form-field form-required">
                <th scope="row" valign="top"><label for="keyword"><?php _e('Stopword', 'wtb_idf_calculator'); ?></label></th>
                <td><input name="keyword" id="keyword" type="text" 
                           value="<?php if ( isset( $sk->keyword ) ) echo esc_attr($sk->keyword); ?>" size="20" aria-required="true" />
            </tr>
            <tr class="form-field">
                <th scope="row" valign="top"><label for="language"><?php __('Language', 'wtb_idf_calculator'); ?></label></th>
                <td><input name="language" id="language" type="hidden" 
                           value="<?php if ( isset( $sk->language) ) echo esc_attr($sk->language); ?>" size="20" />
            </tr>
        </table>
        <?php
            submit_button( __('Update') );
        ?>
    </form>

</div>