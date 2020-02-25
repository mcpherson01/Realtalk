<!-- SECTIONER WRAP -->
<div class="sectioner-wrap">
  <!-- NAVIGATION -->
  <nav id="asg-navigation" class="navigation scroll-anim">
    <!-- LOGO WRAP -->
    <div class="logo-wrap">
      <!-- LOGO -->
      <img class="logo" src="<?php echo esc_url(ASGARDALERTS_PAT_URL); ?>img/logo.png" alt="logo">
      <!-- /LOGO -->

      <!-- LOGO -->
      <img class="logo v2" src="<?php echo esc_url(ASGARDALERTS_PAT_URL); ?>img/logo-v2.png" alt="logo-v2">
      <!-- /LOGO -->
    </div>
    <!-- LOGO WRAP -->

    <!-- BUTTON -->
    <p id="save-credentials-button" class="button"><?php esc_html_e('Save Credentials!', 'asgardalerts_pat'); ?></p>
    <!-- /BUTTON -->
  </nav>
  <!-- /NAVIGATION -->

  <!-- BANNER WRAP -->
  <div class="banner-wrap">
    <!-- BANNER -->
    <div class="banner grid-limit">
      <!-- BANNER SUBTITLE -->
      <p class="banner-subtitle"><?php esc_html_e('Manage your', 'asgardalerts_pat'); ?></p>
      <!-- /BANNER SUBTITLE -->

      <!-- BANNER TITLE -->
      <p class="banner-title"><?php printf(esc_html('Social Media%sCredentials', 'asgardalerts_pat'), '<br>'); ?></p>
      <!-- /BANNER TITLE -->

      <!-- TAG -->
      <p class="tag"><?php esc_html_e('WordPress Version', 'asgardalerts_pat'); ?></p>
      <!-- /TAG -->
    </div>
    <!-- /BANNER -->
  </div>
  <!-- /BANNER WRAP -->

  <!-- SECTION MAIN WRAP -->
  <div class="section-main-wrap">
    <!-- SECTION MAIN -->
    <div class="section-main">
      <!-- SECTION TITLE WRAP -->
      <div class="section-title-wrap">
        <!-- SECTION TITLE -->
        <p class="section-title"><?php esc_html_e('Managing your credentials', 'asgardalerts_pat'); ?></p>
        <!-- /SECTION TITLE -->
      </div>
      <!-- /SECTION TITLE WRAP -->

      <!-- SECTION PARAGRAPH -->
      <p class="section-paragraph"><?php printf(esc_html('Here you can manage your active credentials for the social networks that have %sserver%s alert types (that is, they need to get information from the social network to be automatically filled with content).', 'asgardalerts_pat'), '<span class="bold">', '</span>'); ?></p>
      <!-- /SECTION PARAGRAPH -->

      <!-- SECTION PARAGRAPH -->
      <p class="section-paragraph"><?php printf(esc_html('To modify any credential, enter the credential value in the corresponding input and click on the %sSave Credentials!%s button that is on the right side of the top bar.', 'asgardalerts_pat'), '<span class="bold">', '</span>'); ?></p>
      <!-- /SECTION PARAGRAPH -->

      <!-- SECTION PARAGRAPH -->
      <p class="section-paragraph"><?php printf(esc_html('%sFor a detailed explanation on how to get the required credentials please refer to the documentation included in the package.%s', 'asgardalerts_pat'), '<span class="bold">', '</span>'); ?></p>
      <!-- /SECTION PARAGRAPH -->

      <!-- SECTION TITLE WRAP -->
      <div class="section-title-wrap">
        <!-- SECTION TITLE ICON -->
        <svg class="section-title-icon icon-pat">
          <use xlink:href="#svg-icon-pat"></use>
        </svg>
        <!-- /SECTION TITLE ICON -->

        <!-- SECTION TITLE -->
        <p class="section-title"><?php esc_html_e('Patreon', 'asgardalerts_pat'); ?></p>
        <!-- /SECTION TITLE -->
      </div>
      <!-- /SECTION TITLE WRAP -->

      <!-- SECTION LABEL -->
      <label for="pat-access-token" class="section-label"><?php esc_html_e('Access Token', 'asgardalerts_pat'); ?></label>
      <!-- /SECTION LABEL -->

      <!-- SECTION INPUT -->
      <input type="text" id="pat-access-token" class="section-input" placeholder="<?php esc_attr_e('Enter your Access Token...', 'asgardalerts_pat'); ?>">
      <!-- /SECTION INPUT -->
    </div>
    <!-- /SECTION MAIN -->
  </div>
  <!-- /SECTION MAIN WRAP -->
</div>
<!-- /SECTIONER WRAP -->