<!-- Start Secondary Menu Layout -->
    	<div class="secondary-nav container-fluid hidden-xs hidden-sm">
    		<div class="container">
    			<div class="row">
    				<div class="col-md-9 nav-sec-body">
    				<?php if ( function_exists('max_mega_menu_is_enabled') && max_mega_menu_is_enabled('secondary-menu') ) : ?>
						<?php wp_nav_menu( array( 'theme_location' => 'secondary-menu') ); ?>
					<?php else: ?>
    					<nav class="navbar navbar-default navbar-light">
								
							<!-- End Mobile Toggle-->
							<!-- Collect the nav links, forms, and other content for toggling -->
							    <div class="collapse navbar-collapse" id="secondary-navbar">
							    <?php wp_nav_menu( 
									array( 
									'theme_location' => 'secondary-menu', 
									'container_class' => 'new_menu_class',
									'menu_class'=> 'nav navbar-nav',
									) 
								); ?>
							</div>
						</nav>
   				<?php endif; ?>
    				</div>
    				<div class="col-md-3 search-main">
			<?php get_template_part("searchform","download"); ?>
    				</div>
    			</div>
    		</div>
    	</div>
	<!-- End Secondary Menu Layout -->  