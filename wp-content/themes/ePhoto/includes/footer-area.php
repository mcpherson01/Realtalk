<?php $feat_cat = get_catId(get_option('ephoto_feat_cat')); ?>
<?php $width = 59;
      $height = 59; ?>
<?php if (get_option('ephoto_footer_1') == 'false') : ?>
<?php else : ?>
        <div class="bottom-box">
            <h3><?php esc_html_e('Featured Photos','ePhoto') ?></h3>
            <?php query_posts("cat=$feat_cat&orderby=desc&posts_per_page=3"); ?>
            <?php while (have_posts()) : the_post(); ?>
            <div class="bottom-box-inside">

                <?php $classtext = '';
                      $titletext = get_the_title();

                      $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,true);
                      $thumb = $thumbnail["thumb"]; ?>

                <?php if($thumb <> '') { ?>
                    <div class="bottom-thumbnail">
                        <a href="<?php echo $thumbnail["fullpath"]; ?>" class="fancybox" rel="footer">
                            <?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
                        </a>
                    </div>
                <?php } ?>

                <span class="bottom-span"> <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','ePhoto'), get_the_title()) ?>">
                <?php truncate_title(20) ?>
                </a> </span> <span class="bottom-span2"> <?php esc_html_e('Posted by','ePhoto') ?> <img src="<?php bloginfo('template_directory'); ?>/images/icon-author.gif" style="margin: 0px 3px;" alt="author icon" />
                <?php the_author() ?>
                </span> <span class="bottom-span3">
                <?php the_time(get_option('ephoto_date_format')) ?>
                |
                <?php comments_popup_link(esc_html__('no responses','ePhoto'), esc_html__('one response','ePhoto'), esc_html__('% responses','ePhoto')); ?>
                </span> </div>
            <?php endwhile; ?>
        </div>
<?php endif; ?>


<?php if (get_option('ephoto_footer_2') == 'false') : ?>
<?php else : ?>
        <div class="bottom-box">
            <h3><?php esc_html_e('Random Photos','ePhoto') ?></h3>
            <?php $blog_id_number = (int) get_catId(get_option('ephoto_blog_cat'));
                $ephoto_random = (int) get_option('ephoto_random');
            ?>
            <?php query_posts("orderby=rand&posts_per_page=$ephoto_random&cat=-$blog_id_number"); ?>
            <?php while (have_posts()) : the_post(); ?>
            <div class="bottom-box-inside">

                <?php $classtext = '';
                      $titletext = get_the_title();

                      $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,true);
                      $thumb = $thumbnail["thumb"]; ?>

                <?php if($thumb <> '') { ?>
                    <div class="bottom-thumbnail">
                        <a href="<?php echo $thumbnail["fullpath"]; ?>" class="fancybox" rel="footer">
                            <?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
                        </a>
                    </div>
                <?php } ?>

                <span class="bottom-span"> <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','ePhoto'), get_the_title()) ?>">
                <?php truncate_title(20) ?>
                </a> </span> <span class="bottom-span2"> <?php esc_html_e('Posted by','ePhoto') ?> <img src="<?php bloginfo('template_directory'); ?>/images/icon-author.gif" style="margin: 0px 3px;" alt="author icon" />
                <?php the_author() ?>
                </span> <span class="bottom-span3">
                <?php the_time(get_option('ephoto_date_format')) ?>
                |
                <?php comments_popup_link(esc_html__('no responses','ePhoto'), esc_html__('one response','ePhoto'), esc_html__('% responses','ePhoto')); ?>
                </span> </div>
            <?php endwhile; ?>
        </div>
<?php endif; ?>

<?php if (get_option('ephoto_footer_3') == 'false') : ?>
<?php else : ?>
        <div class="bottom-box">
            <h3><?php esc_html_e('Top Rated','ePhoto') ?></h3>
            <?php query_posts("r_sortby=highest_rated&posts_per_page=3"); ?>
            <?php while (have_posts()) : the_post(); ?>
            <div class="bottom-box-inside">

                <?php $classtext = '';
                      $titletext = get_the_title();

                      $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,true);
                      $thumb = $thumbnail["thumb"]; ?>

                <?php if($thumb <> '') { ?>
                    <div class="bottom-thumbnail">
                        <a href="<?php echo $thumbnail["fullpath"]; ?>" class="fancybox" rel="footer">
                            <?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
                        </a>
                    </div>
                <?php } ?>

                <span class="bottom-span"> <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','ePhoto'), get_the_title()) ?>">
                <?php truncate_title(20) ?>
                </a> </span> <span class="bottom-span2"> <?php esc_html_e('Posted by','ePhoto') ?> <img src="<?php bloginfo('template_directory'); ?>/images/icon-author.gif" style="margin: 0px 3px;" alt="author icon" />
                <?php the_author() ?>
                </span>
                <div class="bottom-span3">
                    <?php if(function_exists('the_ratings')) { the_ratings(); } ?>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
<?php endif; ?>

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer") ) : ?>
<?php endif; ?>