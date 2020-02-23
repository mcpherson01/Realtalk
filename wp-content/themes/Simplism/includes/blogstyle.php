<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>

<div class="post-wrapper" style="padding-top: 5px !important; margin-top: 15px;">
    <h2 class="titles2"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>">
        <?php the_title(); ?>
        </a></h2>
    <div class="articleinfo">Posted by
        <?php the_author() ?>
        in
        <?php the_category(', ') ?>
        on
        <?php the_time('m jS, Y') ?>
        | <a href="#postcomment" title="<?php esc_html_e("Leave a comment"); ?>">
        <?php comments_number('no responses','one response','% responses'); ?>
        </a></div>
    <div style="clear: both;"></div>
        <?php the_content(); ?>
    <div style="clear: both;"></div>
</div>
<?php endwhile; ?>
<p class="pagination">
    <?php next_posts_link('&laquo; Previous Entries') ?>
    <?php previous_posts_link('Next Entries &raquo;') ?>
</p>
<?php else : ?>
<!--If no results are found-->
<h1>No Results Found</h1>
<p>The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.</p>
<!--End if no results are found-->
<?php endif; ?>