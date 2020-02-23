<div id="container">
<div id="left-div">
    <div id="left-inside">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <!--Begin Article Single-->
        <div class="home-post-wrap">
            <div class="entry">
                <h1 class="titles"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>">
                    <?php truncate_title(50) ?>
                    </a></h1>
                <div class="articleinfo">Posted by
                    <?php the_author() ?>
                    in
                    <?php the_category(', ') ?>
                    on
                    <?php the_time('F j, Y') ?>
                    |
                    <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?>
                </div>
                <?php the_content(); ?>
            </div>
        </div>
        <!--End Article Single-->
        <?php endwhile; ?>
        <div style="clear: both;"></div>
<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
else { ?>
<p class="pagination">
    <?php next_posts_link('&laquo; Previous Entries') ?>
    <?php previous_posts_link('Next Entries &raquo;') ?>
</p>
<?php } ?>
        <?php else : ?>
        <!--If no results are found-->
        <h1>No Results Found</h1>
        <p>The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.</p>
        <!--End if no results are found-->
        <?php endif; ?>
    </div>
</div>
<!--Begin sidebar-->
<?php get_sidebar(); ?>
<!--End sidebar-->
<!--Begin Footer-->
<?php get_footer(); ?>
<!--End Footer-->
</body>
</html>