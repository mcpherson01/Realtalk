<?php
function wcr_category_fields($term) {
    // we check the name of the action because we need to have different output
    // if you have other taxonomy name, replace category with the name of your taxonomy. ex: book_add_form_fields, book_edit_form_fields
    if (current_filter() == 'download_category_edit_form_fields') {
        $additional_description = get_term_meta($term->term_id, 'additional_description', true);
        $color_code = get_term_meta($term->term_id, 'color_code', true);
        ?>
        <tr class="form-field">
            <th valign="top" scope="row"><label for="term_fields[additional_description]"><?php _e('Additional Description'); ?></label></th>
            <td>
                <textarea class="large-text" cols="50" rows="11" id="term_fields[additional_description]" name="term_fields[additional_description]"><?php echo esc_textarea($additional_description); ?></textarea><br/>
                <span class="description"><?php _e('Please enter additional description.This field support few HTML Tags'); ?></span>
            </td>
        </tr>
	<?php } elseif (current_filter() == 'download_category_add_form_fields') {
        ?>
        <div class="form-field">
            <label for="term_fields[additional_description]"><?php _e('Additional Description'); ?></label>
            <textarea cols="40" rows="11" id="term_fields[additional_description]" name="term_fields[additional_description]"></textarea>
            <p class="description"><?php _e('Please enter Additional description.This field support few HTML Tags.'); ?></p>
        </div>
    
    <?php
    }
}

// Add the fields, using our callback function  
// if you have other taxonomy name, replace category with the name of your taxonomy. ex: book_add_form_fields, book_edit_form_fields
add_action('download_category_add_form_fields', 'wcr_category_fields', 10, 2);
add_action('download_category_edit_form_fields', 'wcr_category_fields', 10, 2);

function wcr_save_category_fields($term_id) {
    if (!isset($_POST['term_fields'])) {
        return;
    }

    foreach ($_POST['term_fields'] as $key => $value) {
        update_term_meta($term_id, $key, wp_kses_post($value));
    }
}

// Save the fields values, using our callback function
// if you have other taxonomy name, replace category with the name of your taxonomy. ex: edited_book, create_book
add_action('edited_download_category', 'wcr_save_category_fields', 10, 2);
add_action('created_download_category', 'wcr_save_category_fields', 10, 2);