<?php

if ( !(defined('URNA_CORE_ACTIVED') && URNA_CORE_ACTIVED) ) return;


extract( $args );
extract( $instance );
$title = apply_filters('widget_title', $instance['title']);
?>
<?php
if ( $title ) {
    echo trim($before_title)  . trim( $title );
?>
    <a href="<?php echo trailingslashit( '//instagram.com/' . esc_attr( trim( $username ) ) ); ?>" rel="me" target="<?php echo esc_attr( $target ); ?>"></a>
<?php
    echo  trim($after_title);
}
$bcol = 12/(int)$columns;
if ($columns == 5) {
    $bcol = 'cus-5';
}

    if ( $username != '' ) {
        $media_array = urna_core_scrape_instagram( $username );

        if ( is_wp_error( $media_array ) ) {

            echo wp_kses_post( $media_array->get_error_message() );

        } else {

            // filter for images only?
            if ( $images_only = apply_filters( 'tbay_framework_instagram_widget_images_only', FALSE ) ) {
                $media_array = array_filter( $media_array, 'tbay_framework_images_only' );
            }

            // slice list down to required number
            $media_array = array_slice( $media_array, 0, $number );
            ?>
            <div class="row instagram-pics">
                <?php
                foreach ( $media_array as $item ) {
                    echo '<div class="col-xs-4 col-sm-3 col-md-'.esc_attr($bcol).'">';
                    echo '<a href="'. esc_url( $item['link'] ) .'" target="'. esc_attr( $target ) .'"><img src="'. esc_url( $item[$size] ) .'"  alt="'. esc_attr( $item['description'] ) .'" title="'. esc_attr( $item['description'] ).'"/></a>';
                    echo '</div>';
                }
                ?>
            </div>
            <?php
        }
    }
?>