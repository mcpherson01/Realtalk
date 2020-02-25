<h2 class="vidseo_heading"><?php echo  esc_html__( 'Custom Youtube player options', 'vidseo' ) ;?></h2>
                
                <div class="vidseo-row">
                    
                    <div class="vidseo-column col-4">
                    
                        <span class="vidseo-label">
                            <?php  echo  esc_html__( 'Disable Annotations', 'vidseo' ); ?>
                        </span>
                    
                        <div class="vidseo-tooltip">

                            <span class="dashicons dashicons-editor-help"></span>

                            <span class="vidseo-tooltiptext">
                                <?php echo  __( 'This option will turn on annotations for all videos', 'vidseo' ); ?>
                            </span>

                        </div>

                    </div>

                    <div class="vidseo-column col-8">
                        
                        <label class="vidseo-switch">

                            <input type="checkbox" id="vidseo_annotations" name="vidseo_annotations" value="vidseo_controller" <?php if ( isset( $vidseo_options['vidseo_annotations'] ) && !empty($vidseo_options['vidseo_annotations']) ) { echo  'checked="checked"'; } ?> />
                            
                            <span class="vidseo-slider vidseo-round"></span>

                        </label>
                        &nbsp;
                        <span><?php echo  esc_html__( 'Display annotations by default on all videos.', 'vidseo' ); ?></span>
                    
                    </div>

                </div>

                
                <div class="vidseo-row">
                    
                    <div class="vidseo-column col-4">
                    
                        <span class="vidseo-label">
                            <?php  echo  esc_html__( 'Disable Full Screen Button', 'vidseo' ); ?>
                        </span>
                    
                        <div class="vidseo-tooltip">

                            <span class="dashicons dashicons-editor-help"></span>

                            <span class="vidseo-tooltiptext">
                                <?php echo  __( 'This option will disable full screen button from controls bar.', 'vidseo' ); ?>
                            </span>

                        </div>

                    </div>

                    <div class="vidseo-column col-8">
                        
                        <label class="vidseo-switch">

                            <input type="checkbox" id="vidseo_fullscreen" name="vidseo_fullscreen" value="vidseo_controller" <?php if ( isset( $vidseo_options['vidseo_fullscreen'] ) && !empty($vidseo_options['vidseo_fullscreen']) ) { echo  'checked="checked"'; } ?> />
                            
                            <span class="vidseo-slider vidseo-round"></span>

                        </label>
                        &nbsp;
                        <span><?php echo  esc_html__( 'Remove full screen button from controls bar.', 'vidseo' ); ?></span>
                    
                    </div>

                </div>
  
                
                <div class="vidseo-row">
                    
                    <div class="vidseo-column col-4">
                    
                        <span class="vidseo-label">
                            <?php  echo  esc_html__( 'Disable Youtube Logo Branding', 'vidseo' ); ?>
                        </span>
                    
                        <div class="vidseo-tooltip">

                            <span class="dashicons dashicons-editor-help"></span>

                            <span class="vidseo-tooltiptext">
                                <?php echo  __( 'This option will remove youtube logo branding from controls bar. If controls are already disabled then there is no need for this option', 'vidseo' ); ?>
                            </span>

                        </div>

                    </div>

                    <div class="vidseo-column col-8">
                        
                        <label class="vidseo-switch">

                            <input type="checkbox" id="vidseo_modestbranding" name="vidseo_modestbranding" value="vidseo_controller" <?php if ( isset( $vidseo_options['vidseo_modestbranding'] ) && !empty($vidseo_options['vidseo_modestbranding']) ) { echo  'checked="checked"'; } ?> />
                            
                            <span class="vidseo-slider vidseo-round"></span>

                        </label>
                        &nbsp;
                        <span><?php echo  esc_html__( 'Remove youtube logo from controls bar.', 'vidseo' ); ?></span>
                    
                    </div>

                </div>