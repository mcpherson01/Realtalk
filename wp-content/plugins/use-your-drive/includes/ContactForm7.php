<?php

namespace TheLion\UseyourDrive;

class ContactFormAddon {

    /**
     *
     * @var \TheLion\UseyourDrive\Main 
     */
    private $_main;

    public function __construct(Main $_main) {
        $this->_main = $_main;

        add_action('wpcf7_init', array(&$this, 'add_shortcode_handler'));
        add_action('wpcf7_admin_init', array(&$this, 'add_tag_generator'), 60);

        add_action('admin_enqueue_scripts', array(&$this, 'add_admin_scripts'));
        add_action('wpcf7_admin_footer', array(&$this, 'load_admin_scripts'));
        add_action('wpcf7_enqueue_scripts', array(&$this, 'add_front_end_scripts'));

        add_filter('wpcf7_mail_tag_replaced_useyourdrive*', array(&$this, 'set_email_tag'), 999, 4);
        add_filter('wpcf7_mail_tag_replaced_useyourdrive', array(&$this, 'set_email_tag'), 999, 4);

        add_filter('useyourdrive_private_folder_name', array(&$this, 'new_private_folder_name'), 10, 2);
        add_filter('useyourdrive_private_folder_name_guests', array(&$this, 'rename_private_folder_names_for_guests'), 10, 2);
    }

    public function add_admin_scripts($hook_suffix) {
        if (false === strpos($hook_suffix, 'wpcf7')) {
            return;
        }

        $this->get_main()->load_scripts();
        $this->get_main()->load_styles();

        wp_enqueue_script('WPCloudplugin.Libraries');
        wp_enqueue_script('UseyourDrive.tinymce');
        wp_enqueue_style('Awesome-Font-5-css');
        wp_enqueue_style('UseyourDrive.tinymce');
    }

    public function add_front_end_scripts() {
        wp_register_script('UseyourDrive.ContactForm7', plugins_url('js/ContactForm7.js', __FILE__), array('jquery'), USEYOURDRIVE_VERSION, true);
    }

    public function load_admin_scripts() {
        $this->add_front_end_scripts();
        wp_enqueue_script('UseyourDrive.ContactForm7');
    }

    public function add_tag_generator() {
        if (class_exists('WPCF7_TagGenerator')) {
            $tag_generator = \WPCF7_TagGenerator::get_instance();
            $tag_generator->add('useyourdrive', 'Use-your-Drive', array($this, 'tag_generator_body'));
        }
    }

    public function tag_generator_body($contact_form, $args = '') {

        $args = wp_parse_args($args, array());
        $type = 'useyourdrive';

        $description = __("Generate a form-tag for a Use-your-Drive Upload field.", 'contact-form-7');
        ?>
        <div class="control-box">
          <fieldset>
            <legend><?php echo sprintf(esc_html($description)); ?></legend>
            <table class="form-table">
              <tbody>
                <tr>
                  <th scope="row"><?php echo esc_html(__('Field type', 'contact-form-7')); ?></th>
                  <td>
                    <fieldset>
                      <legend class="screen-reader-text"><?php echo esc_html(__('Field type', 'contact-form-7')); ?></legend>
                      <label><input type="checkbox" name="required" /> <?php echo esc_html(__('Required field', 'contact-form-7')); ?></label>
                    </fieldset>
                  </td>
                </tr>

                <tr>
                  <th scope="row"><label for="<?php echo esc_attr($args['content'] . '-name'); ?>"><?php echo esc_html(__('Name', 'contact-form-7')); ?></label></th>
                  <td><input type="text" name="name" class="tg-name oneline" id="<?php echo esc_attr($args['content'] . '-name'); ?>" /></td>
                </tr>

                <tr>
                  <th scope="row"><label for="<?php echo esc_attr($args['content'] . '-shortcode'); ?>"><?php echo esc_html(__('Use-your-Drive Shortcode', 'useyourdrive')); ?></label></th>
                  <td>
                    <input type="hidden" name="shortcode" class="useyourdrive-shortcode-value large-text option" id="<?php echo esc_attr($args['content'] . '-shortcode'); ?>" />
                    <code id="useyourdrive-shortcode-decoded-value" style="margin-bottom:15px;display:none;width: 400px;word-wrap: break-word;"></code>
                    <input type="button" class="button button-primary UseyourDrive-CF-shortcodegenerator " value="<?php echo esc_attr(__('Build your Use-your-Drive shortcode', 'useyourdrive')); ?>" />
                    <iframe id="useyourdrive-shortcode-iframe" src="about:blank" data-src='<?php echo USEYOURDRIVE_ADMIN_URL; ?>?action=useyourdrive-getpopup&type=contactforms7' width='100%' height='500' tabindex='-1' frameborder='0' style="display:none"></iframe>
                    <p class="use-your-drive-upload-folder description">You can use the available input fields in your form to name the upload folder based on user input. To do so, just add the <code>useyourdrive_private_folder_name</code> to the Class attribute of your input field (i.e. <code>[text* your-name class:useyourdrive_private_folder_name]</code>).</p>
                  </td>
                </tr>

              </tbody>
            </table>
          </fieldset>
        </div>

        <div class="insert-box">
          <input type="text" name="<?php echo $type; ?>" class="tag code" readonly="readonly" onfocus="this.select()" />

          <div class="submitbox">
            <input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr(__('Insert Tag', 'contact-form-7')); ?>" />
          </div>

          <br class="clear" />

          <p class="description mail-tag"><label for="<?php echo esc_attr($args['content'] . '-mailtag'); ?>"><?php echo sprintf(esc_html("To list the uploads in your email, insert the mail-tag (%s) in the Mail tab."), '<strong><span class="mail-tag"></span></strong>'); ?><input type="text" class="mail-tag code hidden" readonly="readonly" id="<?php echo esc_attr($args['content'] . '-mailtag'); ?>" /></label></p>
        </div>
        <?php
    }

    /**
     * Add shortcode handler to CF7
     *
     */
    public function add_shortcode_handler() {
        if (function_exists('wpcf7_add_form_tag')) {
            wpcf7_add_form_tag(
                    array('useyourdrive', 'useyourdrive*'), array($this, 'shortcode_handler'), true
            );
        }
    }

    public function shortcode_handler($tag) {

        $tag = new \WPCF7_FormTag($tag);

        if (empty($tag->name)) {
            return '';
        }

        $required = ( '*' == substr($tag->type, -1) );
        if ($required) {
            add_filter('useyourdrive_shortcode_set_options', array(&$this, 'set_required_shortcode'), 10, 3);
        }
        /* Shortcode */
        $shortcode = base64_decode(urldecode($tag->get_option('shortcode', '', true)));
        $return = apply_filters('useyourdrive-wpcf7-render-shortcode', do_shortcode($shortcode));
        $return .= "<input type='hidden' name='" . $tag->name . "' class='fileupload-filelist fileupload-input-filelist'/>";

        wp_enqueue_script('UseyourDrive.ContactForm7');

        return $return;
    }

    public function set_required_shortcode($options, $processor, $atts) {
        $options['class'] .= ' wpcf7-validates-as-required';
        return $options;
    }

    public function set_email_tag($output, $submission, $ashtml, $mail_tag) {
        $filelist = stripslashes($submission);
        return $this->render_uploaded_files_list($filelist, $ashtml);
    }

    public function render_uploaded_files_list($data, $ashtml = true) {

        $uploadedfiles = json_decode($data);

        if (($uploadedfiles !== NULL) && (count((array) $uploadedfiles) > 0)) {

            $first_entry = current($uploadedfiles);
            $folder_location = ($ashtml && isset($first_entry->folderurl)) ? '<a href="' . urldecode($first_entry->folderurl) . '">' . dirname($first_entry->path) . '</a>' : dirname($first_entry->path);

            /* Fill our custom field with the details of our upload session */
            $html = sprintf(__('%d file(s) uploaded to %s:', 'useyourdrive'), count((array) $uploadedfiles), $folder_location);
            $html .= ($ashtml) ? '<ul>' : "\r\n";

            foreach ($uploadedfiles as $fileid => $file) {
                $html .= ($ashtml) ? '<li><a href="' . urldecode($file->link) . '">' : "";
                $html .= basename($file->path);
                $html .= ($ashtml) ? '</a>' : "";
                $html .= ' (' . $file->size . ')';
                $html .= ($ashtml) ? '</li>' : "\r\n";
            }

            $html .= ($ashtml) ? '</ul>' : "";
        } else {
            return $data;
        }

        return $html;
    }

    /**
     * Function to change the Private Folder Name
     * 
     * @param string $private_folder_name
     * @param \TheLion\UseyourDrive\Processor $useyourdrive_processor
     * @return string
     */
    public function new_private_folder_name($private_folder_name, $useyourdrive_processor) {

        if (!isset($_COOKIE['UyD-CF7-NAME'])) {
            return $private_folder_name;
        }

        if ($useyourdrive_processor->get_shortcode_option('class') !== 'cf7_upload_box') {
            return $private_folder_name;
        }

        return trim(str_replace(array('|', '/'), ' ', sanitize_text_field($_COOKIE['UyD-CF7-NAME'])));
    }

    /**
     * Function to change the Private Folder Name for Guest users
     * 
     * @param string $private_folder_name_guest
     * @param \TheLion\UseyourDrive\Processor $useyourdrive_processor
     * @return string
     */
    public function rename_private_folder_names_for_guests($private_folder_name_guest, $useyourdrive_processor) {
        if ($useyourdrive_processor->get_shortcode_option('class') !== 'cf7_upload_box') {
            return $private_folder_name_guest;
        }

        return str_replace(__('Guests', 'useyourdrive') . ' - ', '', $private_folder_name_guest);
    }

    /**
     * 
     * @return \TheLion\UseyourDrive\Main
     */
    public function get_main() {
        return $this->_main;
    }

}

$CF7UseyourDriveAddOn = new ContactFormAddon($this);
