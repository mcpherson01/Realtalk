<!--Begin Feaured Article-->
<?php if (get_option('puretype_featured') == 'on') { get_template_part('includes/featured'); } ?>
<!--End Feaured Article-->

<div class="home-wrapper">
    <div class="home-left">
        <!--Begin recent post-->
<?php $loopcounter = 0;
if (have_posts()) : while (have_posts()) : the_post();
$loopcounter++; ?>
        <div class="home-post-wrap">
            <?php get_template_part('includes/postinfo-create'); ?>
            <div style="clear: both;"></div>
            <?php if (($loopcounter % 2) <> 0) : ?>
            <h2 class="titles"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','PureType'), get_the_title()) ?>">
                <?php truncate_title(36) ?>
                </a></h2>
            <?php else : ?>
            <h2 class="titles-orange"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','PureType'), get_the_title()) ?>">
                <?php truncate_title(36) ?>
                </a></h2>
            <?php endif; ?>
            <div style="clear: both;"></div>

            <?php $width = 98;
                  $height = 98;

                  $classtext = '';
                  $titletext = get_the_title();

                  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
                  $thumb = $thumbnail["thumb"];  ?>

            <?php if($thumb != '') { ?>
                <div class="thumbnail-div">
                    <a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s','PureType'), get_the_title()) ?>">
                        <?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
                    </a>
                </div>
            <?php }  ?>

            <?php truncate_post(210) ?>

            <div style="clear: both;"></div>
        </div>
<?php endwhile; ?>
<?php get_template_part('includes/page-navigation'); ?>
<?php endif; ?>
        <!--End recent post-->
    </div>
    <div class="home-right">
        <?php if (get_option('puretype_popular') == 'on') { get_template_part('includes/popular'); } ?>
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Homepage") ) : ?>
        <?php endif; ?>
    </div>
</div>