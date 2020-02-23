<?php
defined('ABSPATH') or die();
 $headersearchstyle= get_theme_mod( 'search_form_style','standard');
 $headerplaceholdertext= get_theme_mod( 'search_form_placeholder_cs','e.g. mockup');
?>
 <?php if ($headersearchstyle == "ghost"): ?>
  <div class="header-ghost-form header-search-form">
      <?php else : ?>
      
      <div class="product-search-form header-search-form">
      <?php endif; ?>
		<form method="GET" action="<?php echo esc_url(home_url('/')); ?>">
	<?php 
				$taxonomies = array('download_category');
				$args = array('orderby'=>'count','hide_empty'=>true);
				echo mayosis_vendor_cat_dropdown($taxonomies, $args);
			 ?>
		
			
			 
			<div class="search-fields">
				<input name="s" value="<?php echo (isset($_GET['s']))?$_GET['s']: null; ?>" type="text" placeholder="<?php echo esc_html($headerplaceholdertext); ?>">
				<input type="hidden" name="post_type" value="download">
			<span class="search-btn"><input value="" type="submit"></span>
			</div>
		</form>
	</div>