<?php
/**
 * The main header file.
 * 
 * 
 * @package mayosis
 */
$showtopheader= get_theme_mod( 'top_header_show','off');
$showbottomheader= get_theme_mod( 'bottom_header_show','off');

$fullwidthtop= get_theme_mod( 'top_bar_fullwidth','off');
$fullwidthmain= get_theme_mod( 'main_bar_fullwidth','off');
$fullwidthbottom= get_theme_mod( 'bottom_bar_fullwidth','off');

$stickyenble= get_theme_mod( 'sticky_hide','stickydisabled');
$smartsticky= get_theme_mod( 'smart_sticky','smartdisable');
?>
<?php if ( class_exists( 'mayosis_core' ) ) { ?>
<?php if ($showtopheader == 'on'): ?>
<div class="header-top">
    <?php if ($fullwidthtop == 'on'): ?>
    <div class="container-fluid">
    <?php else : ?>
    <div class="container">
    <?php endif;?>
        
            <?php get_template_part('includes/header/header','top'); ?>
       
    </div>
</div><!-- .header-top -->
<?php endif; ?>

<div class="header-master <?php echo  esc_html($stickyenble); ?> <?php echo  esc_html($smartsticky); ?>">
    <?php if ($fullwidthmain == 'on'): ?>
    <div class="container-fluid">
    <?php else : ?>
    <div class="container">
    <?php endif;?>
     
            <?php get_template_part('includes/header/header', 'main'); ?>
       
    </div>
</div><!-- .header-master -->

<?php if ($showbottomheader == 'on'): ?>
<div class="header-bottom">
    <?php if ($fullwidthbottom == 'on'): ?>
    <div class="container-fluid">
    <?php else : ?>
    <div class="container">
    <?php endif;?>

           <?php  get_template_part('includes/header/header', 'bottom'); ?>
    </div>
</div><!-- .header-bottom -->   
<?php endif;?>
<?php } else { ?>
<?php get_template_part('includes/header/header','default'); ?>
<?php } ?>