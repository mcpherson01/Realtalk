<?php $listings1 = get_option('elegantestate_listings1');
$listings2 = get_option('elegantestate_listings2');
$listings3 = get_option('elegantestate_listings3');
$listings4 = get_option('elegantestate_listings4'); ?>
<div id="listings">
	<div id="listings-content">
		<h4 class="title"><span><?php esc_html_e('Browse Listings','ElegantEstate'); ?></span></h4>

		<div id="listings-options">

			<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="clearfix">
				<div class="select">
					<select class="option-listing" name="option-listing">
						<?php if ( false !== $listings1 ) { ?>
							<?php foreach ($listings1 as $item) { ?>
								<option value="<?php echo esc_attr($item); ?>"><?php echo esc_html(get_cat_name($item)); ?></option>
							<?php } ?>
						<?php } ?>
					</select>
				</div> <!-- end .select -->

				<input class="view-button" type="submit" value="<?php esc_attr_e('view','ElegantEstate'); ?>" name="submit" />
			</form>

			<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="clearfix">
				<div class="select">
					<select class="option-listing" name="option-listing">
						<?php if ( false !== $listings2 ) { ?>
							<?php foreach ($listings2 as $item) { ?>
								<option value="<?php echo esc_attr($item); ?>"><?php echo esc_html(get_cat_name($item)); ?></option>
							<?php } ?>
						<?php } ?>
					</select>
				</div> <!-- end .select -->

				<input class="view-button" type="submit" value="<?php esc_attr_e('view','ElegantEstate'); ?>" name="submit" />
			</form>

			<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="clearfix">
				<div class="select">
					<select class="option-listing" name="option-listing">
						<?php if ( false !== $listings3 ) { ?>
							<?php foreach ($listings3 as $item) { ?>
								<option value="<?php echo esc_attr($item); ?>"><?php echo esc_html(get_cat_name($item)); ?></option>
							<?php } ?>
						<?php } ?>
					</select>
				</div> <!-- end .select -->

				<input class="view-button" type="submit" value="<?php esc_attr_e('view','ElegantEstate'); ?>" name="submit" />
			</form>

			<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="clearfix">
				<div class="select">
					<select class="option-listing" name="option-listing">
						<?php if ( false !== $listings4 ) { ?>
							<?php foreach ($listings4 as $item) { ?>
								<option value="<?php echo esc_attr($item); ?>"><?php echo esc_html(get_cat_name($item)); ?></option>
							<?php } ?>
						<?php } ?>
					</select>
				</div> <!-- end .select -->

				<input class="view-button" type="submit" value="<?php esc_attr_e('view','ElegantEstate'); ?>" name="submit" />
			</form>

		</div> <!-- end #listings-options -->
	</div> <!-- end #listings-content -->

	<div id="listings-bottom">
		<div id="search-container">
			<form action="<?php echo esc_url( home_url( '/' ) ); ?>" id="searchform" method="get">
				<input type="text" id="searchinput" name="s" value="<?php esc_attr_e('or search our property listings...','ElegantEstate'); ?>"/>
			</form>
		</div> <!-- end #search-container -->
	</div> <!-- end #listings-bottom -->
</div> <!-- end #listings -->