<?php
$productgallerytype= get_theme_mod( 'product_gallery_type','one' );
$disablethumb= get_theme_mod( 'disable_thumbnail','yes' );
$ids = get_post_meta($post->ID, 'vdw_gallery_id', true);
$thumburl= wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
if( $ids ):
    ?>
    <?php if ($productgallerytype == 'one'): ?>
    <div id="mayosisone_1">
        <ul id="image-gallery" class="gallery list-unstyled cS-hidden">

            <li data-thumb="<?php echo esc_url($thumburl); ?>">

                <img src="<?php echo esc_url($thumburl); ?>" alt="gallery-image" data-lity />
            </li>
            <?php if ($ids) : foreach ($ids as $key => $value) : $image = wp_get_attachment_image_src($value,$size = 'full'); ?>
                <li data-thumb="<?php echo esc_url($image[0]); ?>">

                    <img src="<?php echo esc_url($image[0]); ?>" alt="gallery-image" data-lity />
                </li>
            <?php endforeach; endif; ?>
        </ul>
    </div>
<?php elseif ($productgallerytype == 'two'): ?>
    <div id="mayosisone_1">
        <ul id="vertical">
            <li data-thumb="<?php echo esc_url($thumburl); ?>">

                <img src="<?php echo esc_url($thumburl); ?>" alt="gallery-image" data-lity />
            </li>

            <?php if ($ids) : foreach ($ids as $key => $value) : $image = wp_get_attachment_image_src($value,$size = 'full'); ?>
                <li data-thumb="<?php echo esc_url($image[0]); ?>">

                    <img src="<?php echo esc_url($image[0]); ?>" alt="gallery-image" data-lity />
                </li>
            <?php endforeach; endif; ?>
        </ul>
    </div>
<?php elseif ($productgallerytype == 'three'): ?>
    <div id="mayosisone_1">
        <ul id="without-thumb">

            <li data-thumb="<?php echo esc_url($thumburl); ?>">

                <img src="<?php echo esc_url($thumburl); ?>" alt="gallery-image" data-lity />
            </li>
            <?php if ($ids) : foreach ($ids as $key => $value) : $image = wp_get_attachment_image_src($value,$size = 'full'); ?>
                <li data-thumb="<?php echo esc_url($image[0]); ?>">

                    <img src="<?php echo esc_url($image[0]); ?>" alt="gallery-image" data-lity />
                </li>
            <?php endforeach; endif; ?>
        </ul>
    </div>
<?php elseif ($productgallerytype == 'four'): ?>

    <ul id="carousel-gallery">
        <li data-thumb="<?php echo esc_url($thumburl); ?>">

            <img src="<?php echo esc_url($thumburl); ?>" alt="gallery-image" data-lity />
        </li>

        <?php if ($ids) : foreach ($ids as $key => $value) : $image = wp_get_attachment_image_src($value,$size = 'full'); ?>
            <li data-thumb="<?php echo esc_url($image[0]); ?>">

                <img src="<?php echo esc_url($image[0]); ?>" alt="gallery-image" data-lity />
            </li>
        <?php endforeach; endif; ?>
    </ul>

<?php endif; ?>
<?php endif; ?>
<div class="clearfix"></div>
