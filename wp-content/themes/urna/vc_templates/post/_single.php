<?php 
    $thumbsize                 = isset($thumbsize) ? $thumbsize : 'medium';
    $show_category_post        = isset($show_category_post) ? $show_category_post : get_query_var('show_category_post');
    $show_description_post     = isset($show_description_post) ? $show_description_post : get_query_var('show_description_post');
    $description_number        = isset($description_number) ? $description_number : get_query_var('description_number');

    $text_domain               = esc_html__(' comments','urna');    
        if( get_comments_number() == 1) {
            $text_domain = esc_html__(' comment','urna');
        }
?>
<article class="post">   
    <figure class="entry-thumb <?php echo  (!has_post_thumbnail() ? 'no-thumb' : ''); ?>">
        <a href="<?php the_permalink(); ?>"  class="entry-image tbay-image-loaded">
          <?php
            if ( defined('URNA_VISUALCOMPOSER_ACTIVED') && URNA_VISUALCOMPOSER_ACTIVED ) {

                $thumbnail_id = get_post_thumbnail_id(get_the_ID());

                if (in_array( $thumbsize, get_intermediate_image_sizes() ))  {
                    echo urna_tbay_get_attachment_image_loaded($thumbnail_id, $thumbsize);
                } else {
                    $custom_src = vc_get_image_by_size($thumbnail_id, $thumbsize); 

                    if( is_array($custom_src) ) {
                        $custom_src = $custom_src['0'];
                    }
                    urna_tbay_src_image_loaded($custom_src,array('alt' => get_the_title()));
                }

            } else {
                the_post_thumbnail();
            }

          ?>
        </a>
    </figure>
    <div class="entry-header">
        <?php if( ( isset($show_category_post) && $show_category_post ) ) : ?>
        <span class="entry-category">
            <?php urna_the_post_category_full(false); ?>
        </span>
        <?php endif; ?>

        <?php do_action('urna_blog_before_meta_list'); ?>

        <div class="entry-meta-list">
            <li class="entry-date"><i class="linear-icon-calendar-31"></i><?php echo urna_time_link(); ?></li>
            <li class="comments-link"><i class="linear-icon-bubbles"></i> 
                <?php comments_popup_link( 
                    '0' .'<span>'. $text_domain .'</span>', 
                    '1' .'<span>'. $text_domain .'</span>', 
                    '%' .'<span>'. $text_domain .'</span>'); 
                ?>
            </li>
        </div>
        <?php if (get_the_title()) { ?>
        <h4 class="entry-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h4>
        <?php } ?>

        <?php if( ( isset($show_description_post) && $show_description_post ) ) : ?>
            <div class="entry-description"><?php echo urna_tbay_substring( get_the_excerpt(), $description_number, '...' ); ?></div>
        <?php endif; ?>

        <a href="<?php the_permalink(); ?>" class="readmore" title="<?php esc_attr_e( 'Read more', 'urna' ); ?>"><?php esc_html_e( 'Read more', 'urna' ); ?></a>

        <?php do_action('urna_blog_after_meta_list'); ?>
    </div>
</article>
