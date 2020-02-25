<?php/*  Name: Tile (1 column) */__('Tile (1 column)', 'affegg-tpl');?><?php $this->enqueueStyle(); ?><div class="egg-container egg-grid">    <div class="row">        <?php foreach ($items as $i => $item): ?>            <div class="col-md-12">                 <a rel="nofollow" target="_blank" href="<?php echo esc_url($item['url']) ?>" class="thumbnail"<?php echo $item['ga_event'] ?>>                    <?php if ($item['img']): ?>                        <img src="<?php echo esc_attr($item['img']) ?>" alt="<?php echo esc_attr($item['title']); ?>" />                    <?php else: ?>                        <?php echo esc_html($item['title']); ?><?php if ($item['manufacturer']): ?>, <?php echo esc_html($item['manufacturer']); ?><?php endif; ?>                                                    <?php endif; ?>                </a>            </div>        <?php endforeach; ?>    </div></div>   