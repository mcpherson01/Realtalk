<?php
$mode = $this->get_processor()->get_shortcode_option('mode');

$classes = '';
if ($this->get_processor()->get_shortcode_option('playlistthumbnails') === '0') {
    $classes .= 'nothumbnails ';
}

if ($this->get_processor()->get_shortcode_option('show_filedate') === '0') {
    $classes .= 'nodate ';
}

$max_width = $this->get_processor()->get_shortcode_option('maxwidth');
$hide_playlist = $this->get_processor()->get_shortcode_option('hideplaylist');
$show_playlistonstart = $this->get_processor()->get_shortcode_option('showplaylistonstart');
$playlist_inline = $this->get_processor()->get_shortcode_option('playlistinline');
$controls = implode(',', $this->get_processor()->get_shortcode_option('mediabuttons'));
$autoplay = $this->get_processor()->get_shortcode_option('autoplay');

$ads_active = $this->get_processor()->get_shortcode_option('ads') === '1';
$ads_tag_url = ($this->get_processor()->get_shortcode_option('ads_tag_url') !== '' ? htmlspecialchars_decode($this->get_processor()->get_shortcode_option('ads_tag_url')) : $this->get_processor()->get_setting('mediaplayer_ads_tagurl'));
$ads_can_skip = $this->get_processor()->get_shortcode_option('ads_skipable') === '1';

$shortcode_ads_skip_after_seconds = $this->get_processor()->get_shortcode_option('ads_skipable_after');
$ads_skip_after_seconds = (empty($shortcode_ads_skip_after_seconds) ? $this->get_processor()->get_setting('mediaplayer_ads_skipable_after') : $shortcode_ads_skip_after_seconds );
?><div 
  class="wpcp__main-container wpcp__loading wpcp__<?php echo$mode; ?> <?php echo $classes; ?>" 
  style="width:100%; max-width:<?php echo $max_width; ?>;"
  data-hide-playlist="<?php echo $hide_playlist; ?>" 
  data-open-playlist="<?php echo $show_playlistonstart; ?>"
  data-playlist-inline="<?php echo $playlist_inline; ?>"
  data-controls="<?php echo $controls; ?>"
  data-ads-tag-url="<?php echo ($ads_active) ? $ads_tag_url : ''; ?>"
  data-ads-skip="<?php echo (($ads_can_skip && ((int) $ads_skip_after_seconds > -1)) ? $ads_skip_after_seconds : '-1'); ?>"
  >
  <div class="loading initialize"><svg class="loader-spinner" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10"></circle></svg></div>
  <<?php echo $mode; ?> <?php echo ($autoplay === '1') ? 'autoplay' : '' ?> preload="metadata" playsinline webkit-playsinline crossorigin="anonymous"></<?php echo$mode; ?>>
</div>