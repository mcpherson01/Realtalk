<?php $feat_cat = (int) get_catId( get_option( 'lightsource_feat_cat' ) ); ?>
<div id="featured-container">
    <div class="prev"></div>
    <div id="featured">
        <ul>
            <?php $lightsource_homepage_featured = (int) get_option('lightsource_homepage_featured');
            $my_query = new WP_Query("cat=$feat_cat&posts_per_page=$lightsource_homepage_featured;");
while ($my_query->have_posts()) : $my_query->the_post(); ?>
            <li> <span class="titles-featured"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','LightSource'), get_the_title()) ?>">
                <?php the_title(); ?>
                </a></span>
                <?php get_template_part('includes/postinfo'); ?>
                <div style="clear: both;"></div>
                <?php truncate_post(425); ?>
            </li>
            <?php endwhile; ?>
        </ul>
    </div>
    <div class="next"></div>
</div>