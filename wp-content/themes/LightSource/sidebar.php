<div id="sidebar">
    <?php if (!(is_home())) { get_template_part('includes/lifestream'); } ?>

    <div style="margin-top: 18px;">
        <!--Begin 250x250 Ad Block-->
        <?php if (get_option('lightsource_twofifty') == 'on') { get_template_part('includes/250x250'); } ?>
        <!--End 250x250 Ad Block-->
    </div>
    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Sidebar") ) : ?>
    <?php endif; ?>
</div> <!-- end sidebar div -->
</div>