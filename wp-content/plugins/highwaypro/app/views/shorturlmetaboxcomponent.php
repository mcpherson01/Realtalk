<?php use HighWayPro\Original\Environment\Env; ?>
<?php wp_nonce_field('hwpro_save_url', 'hwpro_save_url_nonce'); ?>

<div class="hwpro-url-meta-box" data-url-id="<?php print esc_attr($self->getUrlId()); ?>">
    <?php if (!$this->getPost()->hasShortUrlsFromMeta() && !$this->getPost()->canCreateShortUrl()): ?>
        <div class="hwpro-auto-creation-disabled">

<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" d="M0 0h24v24H0V0z"/><path d="M21.71 11.29l-9-9c-.39-.39-1.02-.39-1.41 0l-9 9c-.39.39-.39 1.02 0 1.41l9 9c.39.39 1.02.39 1.41 0l9-9c.39-.38.39-1.01 0-1.41zM14 14.5V12h-4v2c0 .55-.45 1-1 1s-1-.45-1-1v-3c0-.55.45-1 1-1h5V7.5l3.15 3.15c.2.2.2.51 0 .71L14 14.5z" fill="#8fabbe"/></svg>
            <p><?php print esc_html__('Automatic short url creation is disabled. You can still edit the short urls for the posts that already have short urls but you may not create new ones. You can enable this feature by going to the HighWayPro dashboard > preferences > URLS.', Env::textDomain()) ?></p>
        </div>
    <?php else: ?>
        <div class="hwpro-url-path-field">
            <label class="hwpro-url-path--label" for="hwpro-url-path">
                <?php print esc_html($self->getBasePath()) ?>
            </label>
            <input id="hwpro-url-path" name="hwpro-url-path" type="text" value="<?php print esc_attr($self->getPath()); ?>">
            <br>
        </div>
        <p class="hwpro-url-path-final"><?php print esc_html($self->getFullUrlWithBase()); ?><span class="hwpro-url-path-final--path"><?php print esc_html($self->getPath()); ?></span></p>
        <div class="hwpro-quick-stats">
            <div class="hwpro-stats-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" fill="#3e74d3"/><path d="M0 0h24v24H0z" fill="none"/></svg>
            </div>
            <div class="hwpro-stats-data">
                <span class="hwpro-stats--number"><?php print esc_html__('No', Env::textDomain()); ?></span>
                <span class="hwpro-stats--description"><?php print esc_html__('clicks', Env::textDomain()); ?></span>
            </div>
        </div>
    <?php endif; ?>
</div>