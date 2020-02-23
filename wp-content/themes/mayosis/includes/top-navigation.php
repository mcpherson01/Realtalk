                     <?php wp_nav_menu( 
									array( 
									'theme_location' => 'top-menu', 
									'container_id' => 'top-main-menu',
									'fallback_cb' => 'mayosis_menu_walker::fallback',
                					'walker'  => new mayosis_menu_walker()
									) 
								); ?>