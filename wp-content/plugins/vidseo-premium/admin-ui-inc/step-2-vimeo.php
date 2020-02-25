<h2 class="vidseo_heading"><?php echo  esc_html__( 'Custom Vimeo player options', 'vidseo' ) ;?></h2>
                
               
                <div class="vidseo-row">
                    
                    <div class="vidseo-column col-4">
                    
                        <span class="vidseo-label">
                            <?php  echo  esc_html__( 'Muted Video', 'vidseo' ); ?>
                        </span>
                    
                        <div class="vidseo-tooltip">

                            <span class="dashicons dashicons-editor-help"></span>

                            <span class="vidseo-tooltiptext">
                                <?php echo  __( 'Vimeo videos will be muted by default. Users will have to turn on volume manually. Useful when videos are set to auto play', 'vidseo' ); ?>
                            </span>

                        </div>

                    </div>

                    <div class="vidseo-column col-8">
                        
                        <label class="vidseo-switch">

                            <input type="checkbox" id="vidseo_muted" name="vidseo_muted" value="vidseo_controller" <?php if ( isset( $vidseo_options['vidseo_muted'] ) && !empty($vidseo_options['vidseo_muted']) ) { echo  'checked="checked"'; } ?> />
                            
                            <span class="vidseo-slider vidseo-round"></span>

                        </label>
                        &nbsp;
                        <span><?php echo  esc_html__( 'Vimeo videos will be muted by default.', 'vidseo' ); ?></span>
                    
                    </div>

                </div>


                <div class="vidseo-row">
                    
                    <div class="vidseo-column col-4">
                    
                        <span class="vidseo-label">
                            <?php  echo  esc_html__( 'Hide Title', 'vidseo' ); ?>
                        </span>
                    
                        <div class="vidseo-tooltip">

                            <span class="dashicons dashicons-editor-help"></span>

                            <span class="vidseo-tooltiptext">
                                <?php echo  __( 'This option will remove title from Vimeo Videos. Note: If uploader has set to display title then this option will be ignored for those videos.', 'vidseo' ); ?>
                            </span>

                        </div>

                    </div>

                    <div class="vidseo-column col-8">
                        
                        <label class="vidseo-switch">

                            <input type="checkbox" id="vidseo_vimeo_title" name="vidseo_vimeo_title" value="vidseo_controller" <?php if ( isset( $vidseo_options['vidseo_vimeo_title'] ) && !empty($vidseo_options['vidseo_vimeo_title']) ) { echo  'checked="checked"'; } ?> />
                            
                            <span class="vidseo-slider vidseo-round"></span>

                        </label>
                        &nbsp;
                        <span><?php echo  esc_html__( 'Remove video title from Vimeo Playert.', 'vidseo' ); ?></span>
                    
                    </div>

                </div>


                <div class="vidseo-row">
                    
                    <div class="vidseo-column col-4">
                    
                        <span class="vidseo-label">
                            <?php  echo  esc_html__( 'Hide Author', 'vidseo' ); ?>
                        </span>
                    
                        <div class="vidseo-tooltip">

                            <span class="dashicons dashicons-editor-help"></span>

                            <span class="vidseo-tooltiptext">
                                <?php echo  __( 'This option will remove author name from Vimeo Videos. Note: If uploader has set to display author name then this option will be ignored for those videos.', 'vidseo' ); ?>
                            </span>

                        </div>

                    </div>

                    <div class="vidseo-column col-8">
                        
                        <label class="vidseo-switch">

                            <input type="checkbox" id="vidseo_author" name="vidseo_author" value="vidseo_controller" <?php if ( isset( $vidseo_options['vidseo_author'] ) && !empty($vidseo_options['vidseo_author']) ) { echo  'checked="checked"'; } ?> />
                            
                            <span class="vidseo-slider vidseo-round"></span>

                        </label>
                        &nbsp;
                        <span><?php echo  esc_html__( 'Remove video author from Vimeo Player.', 'vidseo' ); ?></span>
                    
                    </div>

                </div>