<?php
/*
 * Add Meta Tags WP to the Admin Control Panel
 */


// ———————————————————————————————————————————
// Meta box template
// ———————————————————————————————————————————
function mts_custom_meta_box($object) {
  wp_nonce_field(basename(__FILE__), "meta-box-nonce");
  $status = trim( get_option( 'mts_license_status' ) );
  ?>

    <?php if( $status !== false && $status == 'valid' ) { ?>
      <div class="mts">
      <header class="mts-header">
        <ul class="mts-header__items">
          <li>
            <a class="mts-header__item-link mts-js-channel" data-channel="google">
              <svg width="21" height="22" viewBox="0 0 21 22" xmlns="http://www.w3.org/2000/svg"><path d="M20.756 9H10.744v4.25h5.763c-.537 2.7-2.784 4.25-5.763 4.25-3.516 0-6.349-2.9-6.349-6.5s2.833-6.5 6.35-6.5c1.513 0 2.88.55 3.955 1.45l3.126-3.2C15.92 1.05 13.479 0 10.744 0 4.786 0 0 4.9 0 11s4.786 11 10.744 11C16.116 22 21 18 21 11c0-.65-.098-1.35-.244-2z" fill="#FFF" fill-rule="evenodd"/></svg>
            </a>
          </li>
          <li>
            <a class="mts-header__item-link mts-js-channel" data-channel="facebook">
              <svg width="13" height="24" viewBox="0 0 13 24" xmlns="http://www.w3.org/2000/svg"><path d="M9.5 4h3c.276 0 .5-.22.5-.5v-3c0-.28-.224-.5-.5-.5h-3C6.468 0 4 2.47 4 5.5V9H.5c-.276 0-.5.22-.5.5v3c0 .28.224.5.5.5H4v10.5c0 .28.224.5.5.5h3c.276 0 .5-.22.5-.5V13h3.5c.215 0 .406-.14.475-.34l1-3A.502.502 0 0 0 12.5 9H8V5.5C8 4.67 8.673 4 9.5 4" fill="#FFF" fill-rule="evenodd"/></svg>
            </a>
          </li>
          <li>
            <a class="mts-header__item-link mts-js-channel" data-channel="twitter">
              <svg width="21" height="18" viewBox="0 0 21 18" xmlns="http://www.w3.org/2000/svg"><path d="M20.88 2.112a.456.456 0 0 0-.545-.101 3.192 3.192 0 0 1-.584.211c.322-.422.58-.909.694-1.34a.465.465 0 0 0-.18-.497.454.454 0 0 0-.523 0c-.247.175-1.442.698-2.198.864-1.706-1.497-3.692-1.653-5.756-.441-1.679.983-2.044 2.985-1.973 4.206-3.84-.367-6.227-2.415-7.571-4.096a.453.453 0 0 0-.75.046C.858 2.048.682 3.242.986 4.417c.166.643.458 1.212.794 1.672a2.621 2.621 0 0 1-.465-.304.458.458 0 0 0-.744.358c0 2.021 1.258 3.371 2.433 4.078a2.833 2.833 0 0 1-.588-.128.464.464 0 0 0-.476.137.467.467 0 0 0-.074.496 4.96 4.96 0 0 0 3.46 2.838c-1.351.8-3.16 1.194-4.817 1.001a.46.46 0 0 0-.487.312.456.456 0 0 0 .211.542c2.513 1.424 4.784 1.929 6.747 1.929 2.857 0 5.062-1.075 6.405-1.965 3.618-2.416 5.873-6.76 5.56-10.635.579-.432 1.447-1.23 1.984-2.085a.455.455 0 0 0-.048-.551" fill="#FFF" fill-rule="evenodd"/></svg>
            </a>
          </li>
          <li>
            <a class="mts-header__item-link mts-js-channel" data-channel="linkedin">
              <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><g fill="#C2D0E4" fill-rule="evenodd"><path d="M2.5 0A2.505 2.505 0 0 0 0 2.5C0 3.875 1.122 5 2.5 5S5 3.875 5 2.5 3.878 0 2.5 0M4.583 6.667H.417A.415.415 0 0 0 0 7.083v12.5c0 .234.187.417.417.417h4.166c.23 0 .417-.183.417-.417v-12.5a.415.415 0 0 0-.417-.416M16.997 6.092c-1.78-.609-4.007-.075-5.344.891a.416.416 0 0 0-.403-.316H7.083a.415.415 0 0 0-.416.416v12.5c0 .234.186.417.416.417h4.167c.23 0 .417-.183.417-.417V10.6c.673-.583 1.54-.767 2.25-.467.689.292 1.083 1 1.083 1.95v7.5c0 .234.187.417.417.417h4.166c.23 0 .417-.183.417-.417v-8.341c-.047-3.425-1.658-4.692-3.003-5.15"/></g></svg>
            </a>
          </li>
          <li>
            <a class="mts-header__item-link mts-js-channel" data-channel="pinterest">
              <svg width="20" height="24" viewBox="0 0 20 24" xmlns="http://www.w3.org/2000/svg"><path d="M5.978 11.54l-.046.21a.58.58 0 0 0-.128-.15C5.771 11.58 5 10.95 5 9.5c0-3.44 2.851-5 5.5-5 2.779 0 4.5 2.08 4.5 4 0 2.06-1.878 5.5-3 5.5-1.196 0-1.44-.91-1.488-1.32C11.639 11.39 12 9.07 12 8.46c.001-.35.003-1.1-.594-1.7C10.902 6.26 10.092 6 9 6 6.237 6 5.5 8.2 5.5 9.5c0 .76.334 1.68.478 2.04zM10.5 0C1.886 0 0 6.5 0 9c0 2.81 2.691 7 4.5 7 .223 0 .419-.15.481-.36l.394-1.38L4.01 20.4c-.016.08-.381 1.94 1.136 3.45a.49.49 0 0 0 .603.08c.065-.03 1.614-.93 2.205-2.22.412-.9 1.354-3.32 1.788-4.45A5.5 5.5 0 0 0 12.5 18c5.536 0 7.5-4.85 7.5-9 0-3.11-1.985-9-9.5-9z" fill="#C2D0E4" fill-rule="evenodd"/></svg>
            </a>
          </li>
          <li>
            <a class="mts-header__item-link mts-js-channel" data-channel="slack">
              <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M22.672 15.218l-2.431.809.84 2.515c.33 1.018-.21 2.126-1.23 2.456-.21.06-.45.12-.661.09-.78-.03-1.531-.54-1.801-1.318l-.84-2.515-5.014 1.676.84 2.516c.33 1.018-.21 2.126-1.23 2.455-.21.06-.45.12-.661.09-.78-.03-1.531-.539-1.801-1.318l-.84-2.515-2.433.809c-.21.06-.45.12-.66.09-.78-.03-1.531-.54-1.801-1.318-.33-1.018.21-2.126 1.23-2.455l2.432-.809-1.62-4.821-2.433.809c-.21.06-.45.12-.66.09-.78-.03-1.531-.54-1.801-1.318-.33-1.018.21-2.126 1.23-2.456l2.432-.808-.84-2.515c-.33-1.019.21-2.126 1.23-2.456 1.021-.33 2.132.21 2.462 1.228l.84 2.515 5.014-1.677-.84-2.515c-.33-1.018.21-2.126 1.23-2.455 1.021-.33 2.132.21 2.462 1.227l.84 2.516 2.433-.809c1.02-.33 2.131.21 2.461 1.228.33 1.018-.21 2.126-1.23 2.455l-2.432.809 1.62 4.82 2.433-.808c1.02-.33 2.131.21 2.461 1.228.33 1.018-.21 2.126-1.23 2.455zm-13.89-4.905l1.616 4.827 5.01-1.678-1.617-4.827-5.01 1.678z" fill="#C2D0E4" fill-rule="evenodd"/></svg>
            </a>
          </li>
        </ul>
        <div class="mts-header__help">
          <svg width="22" height="22" viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg"><g transform="translate(-961 -165)" fill="none" fill-rule="evenodd"><path d="M968.733 173.925c.035-1.702 1.224-2.878 3.323-2.878 1.955 0 3.247 1.087 3.247 2.666 0 1.025-.5 1.743-1.463 2.31-.91.527-1.162.862-1.162 1.518v.362h-1.812l-.013-.376c-.09-1.093.287-1.709 1.23-2.262.882-.527 1.148-.855 1.148-1.49 0-.636-.52-1.088-1.298-1.088-.787 0-1.306.486-1.347 1.238h-1.853zm3.11 7.28c-.765 0-1.243-.444-1.243-1.162 0-.725.478-1.169 1.244-1.169.765 0 1.237.444 1.237 1.169 0 .718-.472 1.162-1.237 1.162z" fill="#2A81FB"/><circle stroke="#2A81FB" stroke-width="2" cx="972" cy="176" r="10"/></g></svg>
          <a href="https://wordpress.metatags.io/" target="_blank">Need Help</a>
        </div>
      </header>
      <div class="mts-container">
        <div class="mts-metadata">
          <h5 class="mts-subtitle">Meta data</h5>
          <div class="mts-metadata__content">
            <div class="mts-metadata__image mts-js-img" style="background-image: url(<?php echo get_post_meta($object->ID, "mts-image", true); ?>)">
              <div class="mts-metadata__image-button">
                <div class="mts-metadata__image-button-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="22" height="24" viewBox="0 0 22 24">
                    <g fill="none" fill-rule="evenodd" stroke="#2A81FB" stroke-width="4" transform="translate(2 3)">
                      <polyline points="0 9 9 0 18 9"/>
                      <path d="M9,0 L9,21"/>
                    </g>
                  </svg>
                </div>
                <div class="mts-metadata__image-button-text">Click to Set Image</div>
              </div>
            </div>
            <div class="mts-metadata__text">

              <!-- Image -->
              <input class="mts-js-img-input" name="mts-image" type="hidden" value="<?php echo get_post_meta($object->ID, "mts-image", true); ?>">
              <button class="edit-slug button button-small mts-js-img-remove">Remove Image</button><br><br>

              <!-- Title -->
              <label class="mts-label" for="mts-title">Title <a class="mts-label__link mts-js-fill-title" href="">Fill Title</a></label><br>
              <input class="mts-input mts-js-title" name="mts-title" type="text" value="<?php echo get_post_meta($object->ID, "mts-title", true); ?>">

              <!-- Description -->
              <label class="mts-label" for="mts-description">Description <a class="mts-label__link mts-js-fill-description" href="" style="display: none">Fill from Yoast</a></label><br>
              <textarea class="mts-textarea mts-js-description" name="mts-description" rows="4"><?php echo get_post_meta($object->ID, "mts-description", true); ?></textarea>
            </div>
          </div>
          <br>
        </div>
        <div class="mts-preview">
          <h5 class="mts-subtitle">Visual Preview</h5>

          <div class="mts-preview__block">

            <!-- Google  -->
            <div id="google" class="mts-group">
              <h4 class="mts__title"><span class="mts__title-text">Google</span></h4>
              <div class="card-seo-google">
                <span class="card-seo-google__title mts-js-p-title">
                  <?php echo mts_add_title($object->ID) ?>
                </span>
                <div class="card-seo-google__url">
                  <span class="card-seo-google__url-title">
                    <?php echo mts_permalink($object->ID, "google"); ?>
                  </span>
                  <span class="card-seo-google__url-arrow"></span>
                </div>
                <span class="card-seo-google__description mts-js-p-description">
                  <?php echo mts_description($object->ID, "google"); ?>
                </span>
              </div>
            </div>

            <!-- Facebook  -->
            <div id="facebook" class="mts-group">
              <h4 class="mts__title"><span class="mts__title-text">Facebook</span></h4>
              <div class="card-seo-facebook">
                <div class="card-seo-facebook__image mts-js-p-image" style="background-image: url(<?php echo get_post_meta($object->ID, "mts-image", true); ?>)"></div>
                <div class="card-seo-facebook__text">
                  <span class="card-seo-facebook__link">
                    <?php echo mts_permalink($object->ID, "facebook"); ?>
                  </span>
                  <div class="card-seo-facebook__content">
                    <div style="margin-top:5px">
                      <div class="card-seo-facebook__title mts-js-p-title">
                        <?php echo mts_add_title($object->ID) ?>
                      </div>
                    </div>
                    <span class="card-seo-facebook__description mts-js-p-description">
                      <?php echo mts_description($object->ID, "facebook"); ?>
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Twitter  -->
            <div id="twitter" class="mts-group">
              <h4 class="mts__title"><span class="mts__title-text">Twitter</span></h4>
              <div class="card-seo-twitter">
                <div class="card-seo-twitter__image mts-js-p-image" style="background-image: url(<?php echo get_post_meta($object->ID, "mts-image", true); ?>)"></div>
                <div class="card-seo-twitter__text">
                  <span class="card-seo-twitter__title mts-js-p-title"><?php echo mts_add_title($object->ID) ?></span>
                  <span class="card-seo-twitter__description mts-js-p-description"><?php echo mts_description($object->ID, "facebook"); ?></span>
                  <span class="card-seo-twitter__link"><?php echo mts_permalink($object->ID, "facebook"); ?></span>
                </div>
              </div>
            </div>

            <!-- Linkedin -->
            <div id="linkedin" class="mts-group">
              <h4 class="mts__title"><span class="mts__title-text">Linkedin</span></h4>
              <div class="card-seo-linkedin">
                <div class="card-seo-linkedin__image mts-js-p-image" style="background-image: url(<?php echo get_post_meta($object->ID, "mts-image", true); ?>)"></div>
                <div class="card-seo-linkedin__text">
                  <div class="card-seo-linkedin__content">
                    <div class="card-seo-linkedin__title mts-js-p-title"><?php echo mts_add_title($object->ID) ?></div>
                    <span class="card-seo-linkedin__link"><?php echo mts_permalink($object->ID, "facebook"); ?></span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pinterest -->
            <div id="pinterest" class="mts-group">
              <h4 class="mts__title"><span class="mts__title-text">Pinterest</span></h4>
              <div class="card-seo-pinterest">
                <div class="card-seo-pinterest__image">
                  <img class="mts-js-p-img" src="<?php echo get_post_meta($object->ID, "mts-image", true); ?>" />
                </div>

                <div class="card-seo-pinterest__content">
                  <div class="card-seo-pinterest__title mts-js-p-title"><?php echo mts_add_title($object->ID) ?></div>
                  <div class="card-seo-pinterest__dots">
                    <div class="card-seo-pinterest__dot"></div>
                    <div class="card-seo-pinterest__dot"></div>
                    <div class="card-seo-pinterest__dot"></div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Slack -->
            <div id="slack" class="mts-group">
              <h4 class="mts__title"><span class="mts__title-text">Slack</span></h4>
              <div class="card-seo-slack">
                <div class="card-seo-slack__bar"></div>
                <div class="card-seo-slack__content">
                  <div class="flex">
                    <?php if (get_site_icon_url()): ?>
                    <img class="card-seo-slack__favicon js-preview-favicon" src="<?php echo get_site_icon_url(); ?>" /><?php endif; ?> <span class="card-seo-slack__link js-preview-site-name"><?php echo get_bloginfo("name"); ?></span>
                  </div>
                  <div class="card-seo-slack__title mts-js-p-title"><?php echo mts_add_title($object->ID) ?></div>
                  <span class="card-seo-slack__description mts-js-p-description"><?php echo mts_description($object->ID, "facebook"); ?></span>
                  <div class="card-seo-slack__image mts-js-p-image js-slack-image" style="background-image: url(<?php echo get_post_meta($object->ID, "mts-image", true); ?>)"></div>
                </div>
              </div>
            </div>


          </div>
        </div>
      </div>
      </div>
    <?php } else { ?>
      <div>
        Please Enter Valid License Key under <b>Plugins/Meta Tags License</b>
      </div>
    <?php } ?>
  <?php
}
function mts_global_meta_box() {
  add_meta_box("mts-meta-box", "Meta Tags WP", "mts_custom_meta_box");
}
add_action( 'add_meta_boxes', 'mts_global_meta_box' );



// ———————————————————————————————————————————
// Save function
// ———————————————————————————————————————————
function mts_save_meta_box($post_id, $post, $update)
{
  if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
    return $post_id;

  if(!current_user_can("edit_post", $post_id))
    return $post_id;

  if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
    return $post_id;


  $image_value = "";
  $title_value = "";
  $description_value = "";

  if(isset($_POST["mts-image"]))
  {
    $image_value = $_POST["mts-image"];
  }
  update_post_meta($post_id, "mts-image", $image_value);

  if(isset($_POST["mts-title"]))
  {
    $title_value = $_POST["mts-title"];
  }
  update_post_meta($post_id, "mts-title", $title_value);

  if(isset($_POST["mts-description"]))
  {
    $title_value = $_POST["mts-description"];
  }
  update_post_meta($post_id, "mts-description", $title_value);
}
add_action("save_post", "mts_save_meta_box", 10, 3);



// ———————————————————————————————————————————
// Helper functions
// ———————————————————————————————————————————
function mts_add_title($id) {
  $title =  get_post_meta($id, "mts-title", true);
  if ( empty($title) ) {
    return "Enter Custom Title";
  } else {
    return $title;
  }
}


function mts_permalink($id, $channel) {
  $url = get_permalink($id);
  $values = parse_url($url);
  $display = '';

  switch ($channel) {
    case 'google':
      $display .= $values['scheme'];
      $display .= '://';
      $display .= $values['host'];
      $display .= $values['path'];
      break;
    case 'facebook':
      $display .= $values['host'];
      break;
  }
  return $display;
}


function mts_description($id, $channel) {
  $description = get_post_meta($id, "mts-description", true);
  if ( empty($description) ) {
    return "Enter Custom Description. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.";
  } else {
    $words = substr($description, 0, 160);
    if (substr($words, -1) == '.') {
      return $words;
    } else if (strlen($words) >= 160) {
      return $words.'...';
    } else {
      return $words;
    }
  }
}


function mts_breadcrumb($path) {
  if($path != ''){
    $b = '';
    $links = explode('/', rtrim($path,'/'));
    $last = end($links);

    foreach($links as $l){
      $b .= $l;
      if($l == $last) {
        return $b;
      } else {
        $b .= ' › ';
      }
    }
    return $b;
  }
}






