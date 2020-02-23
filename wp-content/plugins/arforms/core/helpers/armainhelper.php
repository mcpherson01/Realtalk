<?php

class armainhelper {

    function get_pages() {
        global $wpdb, $armainhelper;

        $post = $wpdb->get_results('select * from ' . $wpdb->prefix . 'posts where post_type = "page" and (post_status = "publish" or post_status = "private") order by post_title asc limit 0,999');

        return $post;
    }

    function wp_pages_dropdown($field_name, $page_id, $truncate = false, $id = '') {

        global $wpdb, $armainhelper;

        $pages = $armainhelper->get_pages();

        if ($id != '') {
            $selec_id = $id;
        } else {
            $selec_id = $field_name;
        }

        $arf_cl_field_selected_option = array();
        $arf_cl_field_options = '';
        $cntr = 0;
        foreach ($pages as $page) {

            $post_title_value = ($truncate) ? $armainhelper->truncate($page->post_title, $truncate) : $page->post_title;

            if ((isset($_POST[$field_name]) and $_POST[$field_name] == $page->ID) or ( !isset($_POST[$field_name]) and $page_id == $page->ID) || $cntr == 0) {
                $arf_cl_field_selected_option['page_id'] = $page->ID;
                $arf_cl_field_selected_option['name'] = $post_title_value;
            }

            $arf_cl_field_options .= '<li class="arf_selectbox_option" data-value="' . $page->ID . '" data-label="' . htmlentities($post_title_value) . '">' . $post_title_value . '</li>';
            $cntr++;
        }
        $arf_cl_selected_page_id = isset($arf_cl_field_selected_option['page_id']) ? $arf_cl_field_selected_option['page_id'] : '';
        $arf_cl_selected_name = isset($arf_cl_field_selected_option['name']) ? $arf_cl_field_selected_option['name'] : '';
        echo '<input id="' . $selec_id . '_arf_wp_pages" name="' . $field_name . '" value="' . $arf_cl_selected_page_id . '" type="hidden" class="frm-dropdown frm-pages-dropdown">
			  <dl class="arf_selectbox" data-name="' . $field_name . '" data-id="' . $selec_id . '_arf_wp_pages" style="width:240px;">
				<dt><span>' . $arf_cl_selected_name . '</span>
				<input value="' . $arf_cl_selected_name . '" style="display:none;width:118px;" class="arf_autocomplete" type="text">
				<i class="arfa arfa-caret-down arfa-lg"></i></dt>
				<dd>
					<ul class="field_dropdown_menu_pages" style="display: none;" data-id="' . $selec_id . '_arf_wp_pages">
						' . $arf_cl_field_options . '
					</ul>
				</dd>
			  </dl>';
    }

    function esc_textarea($text) {


        $safe_text = str_replace('&quot;', '"', $text);


        $safe_text = htmlspecialchars($safe_text, ENT_NOQUOTES);


        return apply_filters('esc_textarea', $safe_text, $text);
    }

    function script_version($handle, $list = 'scripts') {


        global $wp_scripts;


        if (!$wp_scripts)
            return false;





        $ver = 0;





        if (isset($wp_scripts->registered[$handle]))
            $query = $wp_scripts->registered[$handle];





        if (is_object($query))
            $ver = $query->ver;





        return $ver;
    }

    function get_unique_key($name = '', $table_name, $column, $id = 0, $num_chars = 6) {

	   global $wpdb;

        $key = '';

        if (!empty($name)) {


            if (function_exists('sanitize_key'))
                $key = sanitize_key($name);
            else
                $key = sanitize_title_with_dashes($name);
        }

        if (empty($key)) {


            $max_slug_value = pow(36, $num_chars);


            $min_slug_value = 37;


            $key = base_convert(rand(intval($min_slug_value), intval($max_slug_value)), 10, 36);
        }


        if (is_numeric($key) or in_array($key, array('id', 'key', 'created-at', 'detaillink', 'editlink', 'siteurl', 'evenodd')))
            $key = $key . 'a';


        $query = "SELECT $column FROM $table_name WHERE $column = %s AND ID != %d LIMIT 1";

        $key_check = $wpdb->get_var($wpdb->prepare($query, $key, $id));

        if ($key_check or is_numeric($key_check)) {


            $suffix = 2;


            do {


                $alt_post_name = substr($key, 0, 200 - (strlen($suffix) + 1)) . "$suffix";


                $key_check = $wpdb->get_var($wpdb->prepare($query, $alt_post_name, $id));


                $suffix++;
            } while ($key_check || is_numeric($key_check));


            $key = $alt_post_name;
        }


        return $key;
    }

    function get_us_states() {


        return apply_filters('arfusstates', array(
            'AL' => 'Alabama', 'AK' => 'Alaska', 'AR' => 'Arkansas', 'AZ' => 'Arizona',
            'CA' => 'California', 'CO' => 'Colorado', 'CT' => 'Connecticut', 'DE' => 'Delaware',
            'FL' => 'Florida', 'GA' => 'Georgia', 'HI' => 'Hawaii', 'ID' => 'Idaho',
            'IL' => 'Illinois', 'IN' => 'Indiana', 'IA' => 'Iowa', 'KS' => 'Kansas',
            'KY' => 'Kentucky', 'LA' => 'Louisiana', 'ME' => 'Maine', 'MD' => 'Maryland',
            'MA' => 'Massachusetts', 'MI' => 'Michigan', 'MN' => 'Minnesota', 'MS' => 'Mississippi',
            'MO' => 'Missouri', 'MT' => 'Montana', 'NE' => 'Nebraska', 'NV' => 'Nevada',
            'NH' => 'New Hampshire', 'NJ' => 'New Jersey', 'NM' => 'New Mexico', 'NY' => 'New York',
            'NC' => 'North Carolina', 'ND' => 'North Dakota', 'OH' => 'Ohio', 'OK' => 'Oklahoma',
            'OR' => 'Oregon', 'PA' => 'Pennsylvania', 'RI' => 'Rhode Island', 'SC' => 'South Carolina',
            'SD' => 'South Dakota', 'TN' => 'Tennessee', 'TX' => 'Texas', 'UT' => 'Utah',
            'VT' => 'Vermont', 'VA' => 'Virginia', 'WA' => 'Washington', 'WV' => 'West Virginia',
            'WI' => 'Wisconsin', 'WY' => 'Wyoming'
        ));
    }

    function get_countries() {


        return apply_filters('arfcountries', array(
            addslashes(__('Afghanistan', 'ARForms')), addslashes(__('Albania', 'ARForms')), addslashes(__('Algeria', 'ARForms')),
            addslashes(__('American Samoa', 'ARForms')), addslashes(__('Andorra', 'ARForms')), addslashes(__('Angola', 'ARForms')),
            addslashes(__('Anguilla', 'ARForms')), addslashes(__('Antarctica', 'ARForms')), addslashes(__('Antigua and Barbuda', 'ARForms')),
            addslashes(__('Argentina', 'ARForms')), addslashes(__('Armenia', 'ARForms')), addslashes(__('Aruba', 'ARForms')),
            addslashes(__('Australia', 'ARForms')), addslashes(__('Austria', 'ARForms')), addslashes(__('Azerbaijan', 'ARForms')),
            addslashes(__('Bahamas', 'ARForms')), addslashes(__('Bahrain', 'ARForms')), addslashes(__('Bangladesh', 'ARForms')),
            addslashes(__('Barbados', 'ARForms')), addslashes(__('Belarus', 'ARForms')), addslashes(__('Belgium', 'ARForms')),
            addslashes(__('Belize', 'ARForms')), addslashes(__('Benin', 'ARForms')), addslashes(__('Bermuda', 'ARForms')),
            addslashes(__('Bhutan', 'ARForms')), addslashes(__('Bolivia', 'ARForms')), addslashes(__('Bosnia and Herzegovina', 'ARForms')),
            addslashes(__('Botswana', 'ARForms')), addslashes(__('Brazil', 'ARForms')), addslashes(__('Brunei', 'ARForms')),
            addslashes(__('Bulgaria', 'ARForms')), addslashes(__('Burkina Faso', 'ARForms')), addslashes(__('Burundi', 'ARForms')),
            addslashes(__('Cambodia', 'ARForms')), addslashes(__('Cameroon', 'ARForms')), addslashes(__('Canada', 'ARForms')),
            addslashes(__('Cape Verde', 'ARForms')), addslashes(__('Cayman Islands', 'ARForms')), addslashes(__('Central African Republic', 'ARForms')),
            addslashes(__('Chad', 'ARForms')), addslashes(__('Chile', 'ARForms')), addslashes(__('China', 'ARForms')),
            addslashes(__('Colombia', 'ARForms')), addslashes(__('Comoros', 'ARForms')), addslashes(__('Congo', 'ARForms')),
            addslashes(__('Costa Rica', 'ARForms')), addslashes(__('Croatia', 'ARForms')),
            addslashes(__('Cuba', 'ARForms')), addslashes(__('Cyprus', 'ARForms')), addslashes(__('Czech Republic', 'ARForms')),
            addslashes(__('Denmark', 'ARForms')), addslashes(__('Djibouti', 'ARForms')), addslashes(__('Dominica', 'ARForms')),
            addslashes(__('Dominican Republic', 'ARForms')), addslashes(__('East Timor', 'ARForms')), addslashes(__('Ecuador', 'ARForms')),
            addslashes(__('Egypt', 'ARForms')), addslashes(__('El Salvador', 'ARForms')), addslashes(__('Equatorial Guinea', 'ARForms')),
            addslashes(__('Eritrea', 'ARForms')), addslashes(__('Estonia', 'ARForms')), addslashes(__('Ethiopia', 'ARForms')),
            addslashes(__('Fiji', 'ARForms')), addslashes(__('Finland', 'ARForms')), addslashes(__('France', 'ARForms')),
            addslashes(__('French Guiana', 'ARForms')), addslashes(__('French Polynesia', 'ARForms')), addslashes(__('Gabon', 'ARForms')),
            addslashes(__('Gambia', 'ARForms')), addslashes(__('Georgia', 'ARForms')), addslashes(__('Germany', 'ARForms')),
            addslashes(__('Ghana', 'ARForms')), addslashes(__('Gibraltar', 'ARForms')), addslashes(__('Greece', 'ARForms')),
            addslashes(__('Greenland', 'ARForms')), addslashes(__('Grenada', 'ARForms')), addslashes(__('Guam', 'ARForms')),
            addslashes(__('Guatemala', 'ARForms')), addslashes(__('Guinea', 'ARForms')), addslashes(__('Guinea-Bissau', 'ARForms')),
            addslashes(__('Guyana', 'ARForms')), addslashes(__('Haiti', 'ARForms')), addslashes(__('Honduras', 'ARForms')),
            addslashes(__('Hong Kong', 'ARForms')), addslashes(__('Hungary', 'ARForms')), addslashes(__('Iceland', 'ARForms')),
            addslashes(__('India', 'ARForms')), addslashes(__('Indonesia', 'ARForms')), addslashes(__('Iran', 'ARForms')),
            addslashes(__('Iraq', 'ARForms')), addslashes(__('Ireland', 'ARForms')), addslashes(__('Israel', 'ARForms')),
            addslashes(__('Italy', 'ARForms')), addslashes(__('Jamaica', 'ARForms')), addslashes(__('Japan', 'ARForms')),
            addslashes(__('Jordan', 'ARForms')), addslashes(__('Kazakhstan', 'ARForms')), addslashes(__('Kenya', 'ARForms')),
            addslashes(__('Kiribati', 'ARForms')), addslashes(__('North Korea', 'ARForms')), addslashes(__('South Korea', 'ARForms')),
            addslashes(__('Kuwait', 'ARForms')), addslashes(__('Kyrgyzstan', 'ARForms')), addslashes(__('Laos', 'ARForms')),
            addslashes(__('Latvia', 'ARForms')), addslashes(__('Lebanon', 'ARForms')), addslashes(__('Lesotho', 'ARForms')),
            addslashes(__('Liberia', 'ARForms')), addslashes(__('Libya', 'ARForms')), addslashes(__('Liechtenstein', 'ARForms')),
            addslashes(__('Lithuania', 'ARForms')), addslashes(__('Luxembourg', 'ARForms')), addslashes(__('Macedonia', 'ARForms')),
            addslashes(__('Madagascar', 'ARForms')), addslashes(__('Malawi', 'ARForms')), addslashes(__('Malaysia', 'ARForms')),
            addslashes(__('Maldives', 'ARForms')), addslashes(__('Mali', 'ARForms')), addslashes(__('Malta', 'ARForms')),
            addslashes(__('Marshall Islands', 'ARForms')), addslashes(__('Mauritania', 'ARForms')), addslashes(__('Mauritius', 'ARForms')),
            addslashes(__('Mexico', 'ARForms')), addslashes(__('Micronesia', 'ARForms')), addslashes(__('Moldova', 'ARForms')),
            addslashes(__('Monaco', 'ARForms')), addslashes(__('Mongolia', 'ARForms')), addslashes(__('Montenegro', 'ARForms')),
            addslashes(__('Montserrat', 'ARForms')), addslashes(__('Morocco', 'ARForms')), addslashes(__('Mozambique', 'ARForms')),
            addslashes(__('Myanmar', 'ARForms')), addslashes(__('Namibia', 'ARForms')), addslashes(__('Nauru', 'ARForms')),
            addslashes(__('Nepal', 'ARForms')), addslashes(__('Netherlands', 'ARForms')), addslashes(__('New Zealand', 'ARForms')),
            addslashes(__('Nicaragua', 'ARForms')), addslashes(__('Niger', 'ARForms')), addslashes(__('Nigeria', 'ARForms')),
            addslashes(__('Norway', 'ARForms')), addslashes(__('Northern Mariana Islands', 'ARForms')), addslashes(__('Oman', 'ARForms')),
            addslashes(__('Pakistan', 'ARForms')), addslashes(__('Palau', 'ARForms')), addslashes(__('Palestine', 'ARForms')),
            addslashes(__('Panama', 'ARForms')), addslashes(__('Papua New Guinea', 'ARForms')), addslashes(__('Paraguay', 'ARForms')),
            addslashes(__('Peru', 'ARForms')), addslashes(__('Philippines', 'ARForms')), addslashes(__('Poland', 'ARForms')),
            addslashes(__('Portugal', 'ARForms')), addslashes(__('Puerto Rico', 'ARForms')), addslashes(__('Qatar', 'ARForms')),
            addslashes(__('Romania', 'ARForms')), addslashes(__('Russia', 'ARForms')), addslashes(__('Rwanda', 'ARForms')),
            addslashes(__('Saint Kitts and Nevis', 'ARForms')), addslashes(__('Saint Lucia', 'ARForms')),
            addslashes(__('Saint Vincent and the Grenadines', 'ARForms')), addslashes(__('Samoa', 'ARForms')),
            addslashes(__('San Marino', 'ARForms')), addslashes(__('Sao Tome and Principe', 'ARForms')), addslashes(__('Saudi Arabia', 'ARForms')),
            addslashes(__('Senegal', 'ARForms')), addslashes(__('Serbia and Montenegro', 'ARForms')), addslashes(__('Seychelles', 'ARForms')),
            addslashes(__('Sierra Leone', 'ARForms')), addslashes(__('Singapore', 'ARForms')), addslashes(__('Slovakia', 'ARForms')),
            addslashes(__('Slovenia', 'ARForms')), addslashes(__('Solomon Islands', 'ARForms')), addslashes(__('Somalia', 'ARForms')),
            addslashes(__('South Africa', 'ARForms')), addslashes(__('Spain', 'ARForms')), addslashes(__('Sri Lanka', 'ARForms')),
            addslashes(__('Sudan', 'ARForms')), addslashes(__('Suriname', 'ARForms')), addslashes(__('Swaziland', 'ARForms')),
            addslashes(__('Sweden', 'ARForms')), addslashes(__('Switzerland', 'ARForms')), addslashes(__('Syria', 'ARForms')),
            addslashes(__('Taiwan', 'ARForms')), addslashes(__('Tajikistan', 'ARForms')), addslashes(__('Tanzania', 'ARForms')),
            addslashes(__('Thailand', 'ARForms')), addslashes(__('Togo', 'ARForms')), addslashes(__('Tonga', 'ARForms')),
            addslashes(__('Trinidad and Tobago', 'ARForms')), addslashes(__('Tunisia', 'ARForms')), addslashes(__('Turkey', 'ARForms')),
            addslashes(__('Turkmenistan', 'ARForms')), addslashes(__('Tuvalu', 'ARForms')), addslashes(__('Uganda', 'ARForms')),
            addslashes(__('Ukraine', 'ARForms')), addslashes(__('United Arab Emirates', 'ARForms')), addslashes(__('United Kingdom', 'ARForms')),
            addslashes(__('United States', 'ARForms')), addslashes(__('Uruguay', 'ARForms')), addslashes(__('Uzbekistan', 'ARForms')),
            addslashes(__('Vanuatu', 'ARForms')), addslashes(__('Vatican City', 'ARForms')), addslashes(__('Venezuela', 'ARForms')),
            addslashes(__('Vietnam', 'ARForms')), addslashes(__('Virgin Islands, British', 'ARForms')),
            addslashes(__('Virgin Islands, U.S.', 'ARForms')), addslashes(__('Yemen', 'ARForms')), addslashes(__('Zambia', 'ARForms')),
            addslashes(__('Zimbabwe', 'ARForms'))
        ));
    }

    function get_country_codes() {


        return apply_filters('arfcountrycodes', array(
            '+1' => 'North America',
            '+269' => 'Mayotte, Comoros Is.',
            '+501' => 'Belize',
            '+690' => 'Tokelau',
            '+20' => 'Egypt',
            '+27' => 'South Africa',
            '+502' => 'Guatemala',
            '+691' => 'F.S. Micronesia',
            '+212' => 'Morocco',
            '+290' => 'Saint Helena',
            '+503' => 'El Salvador',
            '+692' => 'Marshall Islands',
            '+213' => 'Algeria',
            '+291' => 'Eritrea',
            '+504' => 'Honduras',
            '+7' => 'Russia, Kazakhstan',
            '+216' => 'Tunisia',
            '+297' => 'Aruba',
            '+505' => 'Nicaragua',
            '+800' => 'Int\'l Freephone',
            '+218' => 'Libya',
            '+298' => 'Færoe Islands',
            '+506' => 'Costa Rica',
            '+81' => 'Japan',
            '+220' => 'Gambia',
            '+299' => 'Greenland',
            '+507' => 'Panama',
            '+82' => 'Korea (South)',
            '+221' => 'Senegal',
            '+30' => 'Greece',
            '+508' => 'St Pierre & Miquélon',
            '+84' => 'Viet Nam',
            '+222' => 'Mauritania',
            '+31' => 'Netherlands',
            '+509' => 'Haiti',
            '+850' => 'DPR Korea (North)',
            '+223' => 'Mali',
            '+32' => 'Belgium',
            '+51' => 'Peru',
            '+224' => 'Guinea',
            '+33' => 'France',
            '+52' => 'Mexico',
            '+852' => 'Hong Kong',
            '+225' => 'Ivory Coast',
            '+34' => 'Spain',
            '+53' => 'Cuba',
            '+853' => 'Macau',
            '+226' => 'Burkina Faso',
            '+350' => 'Gibraltar',
            '+54' => 'Argentina',
            '+855' => 'Cambodia',
            '+227' => 'Niger',
            '+351' => 'Portugal',
            '+55' => 'Brazil',
            '+856' => 'Laos',
            '+228' => 'Togo',
            '+352' => 'Luxembourg',
            '+56' => 'Chile',
            '+86' => '(People\'s Rep.) China',
            '+229' => 'Benin',
            '+353' => 'Ireland',
            '+57' => 'Colombia',
            '+870' => 'Inmarsat SNAC',
            '+230' => 'Mauritius',
            '+354' => 'Iceland',
            '+58' => 'Venezuela',
            '+871' => 'Inmarsat (Atl-East)',
            '+231' => 'Liberia',
            '+355' => 'Albania',
            '+590' => 'Guadeloupe',
            '+872' => 'Inmarsat (Pacific)',
            '+232' => 'Sierra Leone',
            '+356' => 'Malta',
            '+591' => 'Bolivia',
            '+873' => 'Inmarsat (Indian O.)',
            '+233' => 'Ghana',
            '+357' => 'Cyprus',
            '+592' => 'Guyana',
            '+874' => 'Inmarsat (Atl-West)',
            '+234' => 'Nigeria',
            '+358' => 'Finland',
            '+593' => 'Ecuador',
            '+880' => 'Bangladesh',
            '+235' => 'Chad',
            '+359' => 'Bulgaria',
            '+594' => 'Guiana (French)',
            '+881' => 'Satellite services',
            '+236' => 'Central African Rep.',
            '+36' => 'Hungary',
            '+595' => 'Paraguay',
            '+886' => 'Taiwan/"reserved"',
            '+237' => 'Cameroon',
            '+370' => 'Lithuania',
            '+596' => 'Martinique',
            '+90' => 'Turkey',
            '+238' => 'Cape Verde',
            '+371' => 'Latvia',
            '+597' => 'Suriname',
            '+91' => 'India',
            '+239' => 'São Tomé & Principé',
            '+372' => 'Estonia',
            '+598' => 'Uruguay',
            '+92' => 'Pakistan',
            '+240' => 'Equatorial Guinea',
            '+373' => 'Moldova',
            '+599' => 'Netherlands Antilles',
            '+93' => 'Afghanistan',
            '+241' => 'Gabon',
            '+374' => 'Armenia',
            '+60' => 'Malaysia',
            '+94' => 'Sri Lanka',
            '+242' => 'Congo',
            '+375' => 'Belarus',
            '+61' => 'Australia',
            '+95' => 'Myanmar (Burma)',
            '+243' => 'Zaire',
            '+376' => 'Andorra',
            '+62' => 'Indonesia',
            '+960' => 'Maldives',
            '+244' => 'Angola',
            '+377' => 'Monaco',
            '+63' => 'Philippines',
            '+961' => 'Lebanon',
            '+245' => 'Guinea-Bissau',
            '+378' => 'San Marino',
            '+64' => 'New Zealand',
            '+962' => 'Jordan',
            '+246' => 'Diego Garcia',
            '+379' => 'Vatican City (use +39)',
            '+65' => 'Singapore',
            '+963' => 'Syria',
            '+247' => 'Ascension',
            '+380' => 'Ukraine',
            '+66' => 'Thailand',
            '+964' => 'Iraq',
            '+248' => 'Seychelles',
            '+381' => 'Yugoslavia',
            '+670' => 'East Timor',
            '+965' => 'Kuwait',
            '+249' => 'Sudan',
            '+385' => 'Croatia',
            '+966' => 'Saudi Arabia',
            '+250' => 'Rwanda',
            '+386' => 'Slovenia',
            '+672' => 'Australian Ext. Terr.',
            '+967' => 'Yemen',
            '+251' => 'Ethiopia',
            '+387' => 'Bosnia - Herzegovina',
            '+673' => 'Brunei Darussalam',
            '+968' => 'Oman',
            '+252' => 'Somalia',
            '+389' => '(FYR) Macedonia',
            '+674' => 'Nauru',
            '+970' => 'Palestine',
            '+253' => 'Djibouti',
            '+39' => 'Italy',
            '+675' => 'Papua New Guinea',
            '+971' => 'United Arab Emirates',
            '+254' => 'Kenya',
            '+40' => 'Romania',
            '+676' => 'Tonga',
            '+972' => 'Israel',
            '+255' => 'Tanzania',
            '+41' => 'Switzerland, (Liecht.)',
            '+677' => 'Solomon Islands',
            '+973' => 'Bahrain',
            '+256' => 'Uganda',
            '+678' => 'Vanuatu',
            '+974' => 'Qatar',
            '+257' => 'Burundi',
            '+420' => 'Czech Republic',
            '+679' => 'Fiji',
            '+975' => 'Bhutan',
            '+258' => 'Mozambique',
            '+421' => 'Slovakia',
            '+680' => 'Palau',
            '+976' => 'Mongolia',
            '+260' => 'Zambia',
            '+423' => 'Liechtenstein',
            '+681' => 'Wallis and Futuna',
            '+977' => 'Nepal',
            '+261' => 'Madagascar',
            '+43' => 'Austria',
            '+682' => 'Cook Islands',
            '+98' => 'Iran',
            '+262' => 'Reunion Island',
            '+44' => 'United Kingdom',
            '+683' => 'Niue',
            '+992' => 'Tajikistan',
            '+263' => 'Zimbabwe',
            '+45' => 'Denmark',
            '+684' => 'American Samoa',
            '+993' => 'Turkmenistan',
            '+264' => 'Namibia',
            '+46' => 'Sweden',
            '+685' => 'Western Samoa',
            '+994' => 'Azerbaijan',
            '+265' => 'Malawi',
            '+47' => 'Norway',
            '+686' => 'Kiribati',
            '+995' => 'Rep. of Georgia',
            '+266' => 'Lesotho',
            '+48' => 'Poland',
            '+687' => 'New Caledonia',
            '+996' => 'Kyrgyz Republic',
            '+267' => 'Botswana',
            '+49' => 'Germany',
            '+688' => 'Tuvalu',
            '+997' => 'Kazakhstan',
            '+268' => 'Swaziland',
            '+500' => 'Falkland Islands',
            '+689' => 'French Polynesia',
            '+998' => 'Uzbekistan',
        ));
    }

    function user_has_permission($needed_role) {


        if ($needed_role == '' or current_user_can($needed_role))
            return true;





        $roles = array('administrator', 'editor', 'author', 'contributor', 'subscriber');


        foreach ($roles as $role) {


            if (current_user_can($role))
                return true;


            if ($role == $needed_role)
                break;
        }


        return false;
    }

    function is_super_admin($user_id = false) {


        if (function_exists('is_super_admin'))
            return is_super_admin($user_id);
        else
            return is_site_admin($user_id);
    }

    function checked($values, $current) {

        global $armainhelper;


        if ($armainhelper->check_selected($values, $current))
            echo ' checked="checked"';
    }

    function check_selected($values, $current) {
        
        $current = esc_attr($current);
        

        if (is_array($values))
            $values = array_map(array('armainhelper', 'recursive_trim'), $values);
        else
            $values = trim($values);


        $current = trim($current);



        if ((is_array($values) && in_array($current, $values)) or ( !is_array($values) and $values == $current))
            return true;
        else
            return false;
    }

    function recursive_trim(&$value) {


        if (is_array($value))
            $value = array_map(array('armainhelper', 'recursive_trim'), $value);
        else
            $value = trim($value);





        return esc_attr($value);
    }

    function frm_get_main_message($message = '') {
        return $message;
    }

    function truncate($str, $length, $minword = 3, $continue = '...') {


        $length = (int) $length;


        $str = strip_tags($str);


        $original_len = (function_exists('mb_strlen')) ? mb_strlen($str) : strlen($str);

        if ($length == 0) {
            return '';
        } else if ($length <= 10) {

            $sub = (function_exists('mb_substr')) ? mb_substr($str, 0, $length) : substr($str, 0, $length);
            return $sub . (($length < $original_len) ? $continue : '');
        }

        $sub = '';
        $len = 0;

        $words = (function_exists('mb_split')) ? mb_split(' ', $str) : explode(' ', $str);

        foreach ($words as $word) {


            $part = (($sub != '') ? ' ' : '') . $word;


            $sub .= $part;


            $len += (function_exists('mb_strlen')) ? mb_strlen($part) : strlen($part);


            $total_len = (function_exists('mb_strlen')) ? mb_strlen($sub) : strlen($sub);





            if (str_word_count($sub) > $minword && $total_len >= $length)
                break;





            unset($total_len);
        }





        return $sub . (($len < $original_len) ? $continue : '');
    }

    function prepend_and_or_where($starts_with = ' WHERE ', $where = '') {


        if (is_array($where)) {


            global $MdlDb, $wpdb;


            extract($MdlDb->get_where_clause_and_values($where));


            $where = $wpdb->prepare($where, $values);
        } else {


            $where = (( $where == '' ) ? '' : $starts_with . $where);
        }





        return $where;
    }

    function getLastRecordNum($r_count, $current_p, $p_size) {


        return (($r_count < ($current_p * $p_size)) ? $r_count : ($current_p * $p_size));
    }

    function getFirstRecordNum($r_count, $current_p, $p_size) {


        if ($current_p == 1)
            return 1;
        else
            return ($this->getLastRecordNum($r_count, ($current_p - 1), $p_size) + 1);
    }

    function getRecordCount($where = "", $table_name) {


        global $wpdb, $armainhelper;


        $query = 'SELECT COUNT(*) FROM ' . $table_name . $armainhelper->prepend_and_or_where(' WHERE ', $where);


        return $wpdb->get_var($query);
    }

    function getPageCount($p_size, $where = "", $table_name) {


        if (is_numeric($where))
            return ceil((int) $where / (int) $p_size);
        else
            return ceil((int) $this->getRecordCount($where, $table_name) / (int) $p_size);
    }

    function getPage($current_p, $p_size, $where = "", $order_by = '', $table_name) {


        global $wpdb, $armainhelper;


        $end_index = $current_p * $p_size;


        $start_index = $end_index - $p_size;


        $query = 'SELECT *  FROM ' . $table_name . $armainhelper->prepend_and_or_where(' WHERE', $where) . $order_by . ' LIMIT ' . $start_index . ',' . $p_size;


        $results = $wpdb->get_results($query);


        return $results;
    }

    function get_referer_query($query) {


        if (strpos($query, "google.")) {


            $pattern = '/^.*[\?&]q=(.*)$/';
        } else if (strpos($query, "bing.com")) {


            $pattern = '/^.*q=(.*)$/';
        } else if (strpos($query, "yahoo.")) {


            $pattern = '/^.*[\?&]p=(.*)$/';
        } else if (strpos($query, "ask.")) {


            $pattern = '/^.*[\?&]q=(.*)$/';
        } else {


            return false;
        }


        preg_match($pattern, $query, $matches);

        if( isset($matches) && count($matches) < 1 ){
            return urldecode($query);
        }
        

        $querystr = substr($matches[1], 0, strpos($matches[1], '&'));


        return urldecode($querystr);
    }

    function get_referer_info() {

        global $armainhelper;


        $referrerinfo = '';


        $keywords = array();


        $i = 1;


        if (isset($_SESSION) and isset($_SESSION['arfhttpreferer']) and $_SESSION['arfhttpreferer']) {


            foreach ($_SESSION['arfhttpreferer'] as $referer_info) {


                $referrerinfo .= str_pad("Referer $i: ", 20) . $referer_info . "\r\n";


                $keywords_used = $armainhelper->get_referer_query($referer_info);


                if ($keywords_used)
                    $keywords[] = $keywords_used;





                $i++;
            }





            $referrerinfo .= "\r\n";
        }else {


            $referrerinfo = @$_SERVER['HTTP_REFERER'];
        }





        $i = 1;


        if (isset($_SESSION) and isset($_SESSION['arfhttppages']) and $_SESSION['arfhttppages']) {


            foreach ($_SESSION['arfhttppages'] as $page) {


                $referrerinfo .= str_pad("Page visited $i: ", 20) . $page . "\r\n";


                $i++;
            }





            $referrerinfo .= "\r\n";
        }





        $i = 1;


        foreach ($keywords as $keyword) {


            $referrerinfo .= str_pad("Keyword $i: ", 20) . $keyword . "\r\n";


            $i++;
        }


        $referrerinfo .= "\r\n";





        return $referrerinfo;
    }

    function jquery_classic_themes() {


        return array(
            'default_theme' => 'Default',
            '1' => 'Sky Blue',
            '2' => 'Lime Green',
            '3' => 'White',
            '4' => 'White (Reverse)',
            '5' => 'Coral',
            '6' => 'Violet',
            '7' => 'Red',
            '8' => 'Forest Green',
            '9' => 'Royal Blue',
            '10' => 'Hot Pink',
            '11' => 'Aquamarine',
            '12' => 'Golden'
        );
    }
	
	function jquery_solid_themes() {


        return array(
            '13' => 'Violet',
            '14' => 'Forest Green',
            '15' => 'Sky Blue',
            '16' => 'Aqua Blue',
            '17' => 'Hot Pink',
            '18' => 'Coral',
            '19' => 'Red',
            '20' => 'Deep Pink',
            '21' => 'Royal Blue',
            '22' => 'Ivory',
            '23' => 'Off White',
            '24' => 'Black'
        );
    }

    function jquery_css_url($arfcalthemecss) {
        
        $uploads = wp_upload_dir();

        if (!$arfcalthemecss or $arfcalthemecss == '' or $arfcalthemecss == 'default') {

            $css_file = ARFURL . '/css/calender/default_theme_bootstrap-datetimepicker.css';
        } else if (preg_match('/^http.?:\/\/.*\..*$/', $arfcalthemecss)) {

            $css_file = $arfcalthemecss;
        } else {

            $file_path = ARFURL . '/css/calender/' . $arfcalthemecss . '_bootstrap-datetimepicker.css';

            $css_file = $file_path;
        }


        return $css_file;
    }

    function datepicker_version() {

        global $armainhelper;


        $jq = $armainhelper->script_version('jquery');


        $new_ver = true;


        if ($jq) {


            $new_ver = ((float) $jq >= 1.5) ? true : false;
        } else {


            global $wp_version;


            $new_ver = true;
        }

        return ($new_ver) ? '' : '.1.7.3';
    }

    function get_user_id_param($user_id) {


        if ($user_id and ! empty($user_id) and ! is_numeric($user_id)) {


            if ($user_id == 'current') {


                global $user_ID;


                $user_id = $user_ID;
            } else {


                if (function_exists('get_user_by'))
                    $user = get_user_by('login', $user_id);
                else
                    $user = get_userdatabylogin($user_id);


                if ($user)
                    $user_id = $user->ID;


                unset($user);
            }
        }


        return $user_id;
    }

    function get_formatted_time($date, $date_format = false, $time_format = false) {


        if (empty($date))
            return $date;


        if (!$date_format)
            $date_format = get_option('date_format');


        if (preg_match('/^\d{1-2}\/\d{1-2}\/\d{4}$/', $date)) {


            global $style_settings, $armainhelper;


            $date = $armainhelper->convert_date($date, $style_settings->date_format, 'Y-m-d');
        }


        $do_time = (date('H:i:s', strtotime($date)) == '00:00:00') ? false : true;


        $date = get_date_from_gmt($date);


        $formatted = date_i18n($date_format, strtotime($date));


        if ($do_time) {


            if (!$time_format)
                $time_format = get_option('time_format');


            $trimmed_format = trim($time_format);


            if ($time_format and ! empty($trimmed_format))
                $formatted .= ' ' . addslashes(__('at', 'ARForms')) . ' ' . date_i18n($time_format, strtotime($date));
        }


        return $formatted;
    }

    function get_custom_taxonomy($post_type, $field) {


        $taxonomies = get_object_taxonomies($post_type);


        if (!$taxonomies) {


            return false;
        } else {


            $field = (array) $field;


            if (!isset($field['taxonomy'])) {


                $field['field_options'] = maybe_unserialize($field['field_options']);


                $field['taxonomy'] = $field['field_options']['taxonomy'];
            }





            if (isset($field['taxonomy']) and in_array($field['taxonomy'], $taxonomies))
                return $field['taxonomy'];


            else if ($post_type == 'post')
                return 'category';
            else
                return reset($taxonomies);
        }
    }

    function convert_date($date_str, $from_format, $to_format) {


        $base_struc = preg_split("/[\/|.| |-]/", $from_format);


        $date_str_parts = preg_split("/[\/|.| |-]/", $date_str);


        $date_elements = array();


        $p_keys = array_keys($base_struc);


        foreach ($p_keys as $p_key) {


            if (!empty($date_str_parts[$p_key]))
                $date_elements[$base_struc[$p_key]] = $date_str_parts[$p_key];
            else
                return false;
        }


        if (is_numeric($date_elements['m']))
            $dummy_ts = mktime(0, 0, 0, $date_elements['m'], (isset($date_elements['j']) ? $date_elements['j'] : $date_elements['d']), $date_elements['Y']);
        else
            $dummy_ts = strtotime($date_str);


        return date($to_format, $dummy_ts);
    }

    function get_shortcodes($content, $form_id) {


        global $arffield;


        $fields = $arffield->getAll("fi.type not in ('divider','captcha','break','html') and fi.form_id=" . $form_id);





        $tagregexp = 'editlink|siteurl|sitename|id|key|attachment_id|ip_address|created-at';


        foreach ($fields as $field)
            $tagregexp .= '|' . $field->id . '|' . $field->field_key;


        preg_match_all("/\[(if )?($tagregexp)\b(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?/s", $content, $matches, PREG_PATTERN_ORDER);


        return $matches;
    }

    function human_time_diff($from, $to = '') {


        if (empty($to))
            $to = time();


        $chunks = array(
            array(60 * 60 * 24 * 365, addslashes(__('year', 'ARForms')), addslashes(__('years', 'ARForms'))),
            array(60 * 60 * 24 * 30, addslashes(__('month', 'ARForms')), addslashes(__('months', 'ARForms'))),
            array(60 * 60 * 24 * 7, addslashes(__('week', 'ARForms')), addslashes(__('weeks', 'ARForms'))),
            array(60 * 60 * 24, addslashes(__('day', 'ARForms')), addslashes(__('days', 'ARForms'))),
            array(60 * 60, addslashes(__('hour', 'ARForms')), addslashes(__('hours', 'ARForms'))),
            array(60, addslashes(__('minute', 'ARForms')), addslashes(__('minutes', 'ARForms'))),
            array(1, addslashes(__('second', 'ARForms')), addslashes(__('seconds', 'ARForms')))
        );


        $diff = (int) ($to - $from);


        if (0 > $diff)
            return '';


        for ($i = 0, $j = count($chunks); $i < $j; $i++) {


            $seconds = $chunks[$i][0];


            if (( $count = floor($diff / $seconds) ) != 0)
                break;
        }


        $output = ( 1 == $count ) ? '1 ' . $chunks[$i][1] : $count . ' ' . $chunks[$i][2];


        if (!(int) trim($output))
            $output = '0 ' . addslashes(__('seconds', 'ARForms'));


        return $output;
    }

    function upload_file($field_id, $fomr_id = null) {


        require_once(ABSPATH . 'wp-admin/includes/file.php');


        require_once(ABSPATH . 'wp-admin/includes/image.php');

        require_once(ABSPATH . 'wp-admin/includes/media.php');

        require_once(plugin_dir_path(__FILE__) . 'arupload_media.php');

        add_filter('upload_dir', array(&$this, 'upload_dir'));

        $media_id = media_handle_upload_custom($field_id, 0, $fomr_id);

        remove_filter('upload_dir', array(&$this, 'upload_dir'));

        return $media_id;
    }

    function upload_dir($uploads) {

        $relative_path = apply_filters('arfuploadfolder', 'arforms/userfiles');

        $relative_path = untrailingslashit($relative_path);

        if (!empty($relative_path)) {

            $uploads['path'] = $uploads['basedir'] . '/' . $relative_path;

            $uploads['url'] = $uploads['baseurl'] . '/' . $relative_path;

            $uploads['subdir'] = '/' . $relative_path;
        }

        return $uploads;
    }

    function get_param($param, $default = '', $src = 'get') {


        if (strpos($param, '[')) {

            $params = explode('[', $param);

            $param = $params[0];
        }

        

        
        $str = '';
        if (isset($_POST) && !empty($_POST)) {
            $_POST['filtered_form'] = isset($_POST['filtered_form']) ? $_POST['filtered_form'] : '';
            @$str = stripslashes_deep(@$_POST['filtered_form']);
            @$str = json_decode(@$str, true);
        }

        if ($src == 'get') {

            $value = ( isset($_POST[$param]) ?
                            stripslashes_deep($_POST[$param]) :
                            (isset($str[$param]) ?
                                    stripslashes_deep($str[$param]) :
                                    (isset($_GET[$param]) ?
                                            stripslashes_deep($_GET[$param]) :
                                            $default)));


            if ((!isset($_POST[$param]) or ! isset($str[$param])) and isset($_GET[$param]) and ! is_array($value))
                $value = urldecode($value);
        }else {

            $value = isset($_POST[$param]) ? stripslashes_deep(maybe_unserialize($_POST[$param])) : isset($str[$param]) ? stripslashes_deep(maybe_unserialize($str[$param])) : $default;
        }





        if (isset($params) and is_array($value) and ! empty($value)) {


            foreach ($params as $k => $p) {


                if (!$k or ! is_array($value))
                    continue;





                $p = trim($p, ']');


                $value = (isset($value[$p])) ? $value[$p] : $default;
            }
        }

        return $value;
    }

    function frm_capabilities() {

        $cap = array(
            'arfviewforms' => addslashes(__('View Forms and Templates', 'ARForms')),
            'arfeditforms' => addslashes(__('Add/Edit Forms and Templates', 'ARForms')),
            'arfdeleteforms' => addslashes(__('Delete Forms and Templates', 'ARForms')),
            'arfchangesettings' => addslashes(__('Access this Settings Page', 'ARForms')),
            'arfimportexport' => addslashes(__('Access this Settings Page', 'ARForms')),
        );



        $cap['arfviewentries'] = addslashes(__('View Entries from Admin Area', 'ARForms'));


        $cap['arfcreateentries'] = addslashes(__('Add Entries from Admin Area', 'ARForms'));


        $cap['arfeditentries'] = addslashes(__('Edit Entries from Admin Area', 'ARForms'));


        $cap['arfdeleteentries'] = addslashes(__('Delete Entries from Admin Area', 'ARForms'));


        $cap['arfviewreports'] = addslashes(__('View Reports', 'ARForms'));


        $cap['arfeditdisplays'] = addslashes(__('Add/Edit Custom Displays', 'ARForms'));
        
        $cap['arflicensing'] = addslashes(__('Manage ARForms License', 'ARForms'));


        return $cap;
    }

    function get_post_param($param, $default = '') {


        return isset($_POST[$param]) ? stripslashes_deep(maybe_unserialize($_POST[$param])) : $default;
    }

    function load_scripts($scripts) {
        global $wp_version;
            foreach ((array) $scripts as $s)
                wp_enqueue_script($s);
    }

    function load_styles($styles) {
        global $wp_version;
            foreach ((array) $styles as $s)
                wp_enqueue_style($s);
    }
    
    /**** function to generate default captch ************/
    function arf_generate_captcha_code($length) {
        $charLength = round($length * 0.8);
        $numLength = round($length * 0.2);
        $keywords = array(
            array('count' => $charLength, 'char' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'),
            array('count' => $numLength, 'char' => '0123456789')
        );
        $temp_array = array();
        foreach ($keywords as $char_set) {
            for ($i = 0; $i < $char_set['count']; $i++) {
                $temp_array[] = $char_set['char'][rand(0, strlen($char_set['char']) - 1)];
            }
        }
        shuffle($temp_array);
        return implode('', $temp_array);
    }

    function arf_update_fa_font_class($value){
        $fa_font_arr = array();
        if(file_exists(VIEWS_PATH.'/arforms_font_awesome_array.php')){
            include_once(VIEWS_PATH.'/arforms_font_awesome_array.php');
            $fa_font_arr = arforms_font_awesome_font_array();
        }

        foreach( $fa_font_arr as $k => $val ){
            if( $value == $k ){
                $value = $val['style'].' '.$val['code'];
            }
        }

        return $value;
    }


}

?>