<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<?php elegant_description(); ?>
<?php elegant_keywords(); ?>
<?php elegant_canonical(); ?>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

   <!--[if lt IE 7]>
      <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie6style.css" />
      <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/DD_belatedPNG_0.0.8a-min.js"></script>
      <script type="text/javascript">DD_belatedPNG.fix('#main-leftarea #glow, #main-rightarea, #main-leftarea #right-border , #tagline, span.overlay, span.magnify, .gallery-area .thumb, span#active-arrow');</script>
   <![endif]-->
   <!--[if IE 7]>
      <link rel="stylesheet" type="text/css" href="css/ie7style.css" />
   <![endif]-->

<script type="text/javascript">
   document.documentElement.className = 'js';
</script>

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>
</head>

<body <?php body_class('clearfix'); ?>>

   <div id="main-leftarea">
      <div class="topbg"></div>

      <a href="<?php echo esc_url( home_url( '' ) ); ?>"><?php $logo = (get_option('glider_logo') <> '') ? get_option('glider_logo') : get_template_directory_uri().'/images/logo.png'; ?>
            <img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" id="logo"/></a>

      <div id="glow"></div>

      <?php $home = is_home(); ?>

      <div id="menu">
         <ul id="main-menu">
            <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>#home" class="active<?php if (!$home) echo(' external'); ?>"><?php esc_html_e('Home','Glider') ?></a></li>

            <?php
            $pagesContent = array();
            $i=0;

            $home_pages_num = count(get_option('glider_home_pages'));

            $arr = array(
               'post_type' => 'page',
               'orderby' => 'menu_order',
               'order' => 'ASC',
               'posts_per_page' => (int) $home_pages_num,
            );

            if ( is_array( get_option('glider_home_pages') ) )
               $arr['post__in'] = (array) array_map( 'intval', get_option('glider_home_pages') );

            query_posts( $arr ); ?>
            <?php if (have_posts()) : while(have_posts()) : the_post(); ?>
            <?php $hash = 'et_page_' . get_the_ID(); ?>

               <?php if ($i!=0) { ?>
                  <li><a href="<?php echo esc_url( home_url( '' ) ); ?>/#<?php echo esc_attr($hash); ?>"<?php if (!$home) echo(' class="external"'); ?>><?php the_title(); ?></a></li>
               <?php } ?>

               <?php $pagesContent[$i]['hash'] = $hash;
               global $more; $more=1;
               $pagesContent[$i]['content'] = get_the_content();
               $pagesContent[$i]['content'] = apply_filters('the_content', $pagesContent[$i]['content']);
               $pagesContent[$i]['title'] = get_the_title();

               $thumb = '';
               $width = 173;
               $height = 173;
               $classtext = '';
               $titletext = get_the_title();

               $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);

               $pagesContent[$i]['thumbnail'] = $thumbnail["thumb"];

               $pagesContent[$i]['use_timthumb'] = $thumbnail["use_timthumb"];

               $pagesContent[$i]['portfolio_categories'] = get_post_meta(get_the_ID(),'et_portfolio_categories',true) ? get_post_meta(get_the_ID(),'et_portfolio_categories',true) : '';

               $pagesContent[$i]['portfolio'] = ( (bool) get_post_meta(get_the_ID(),'et_portfolio_page',true) ) ? true : false;

               $i++; ?>
            <?php endwhile; endif; wp_reset_query(); ?>

            <li><a href="<?php echo esc_url(get_category_link(get_catId(get_option('glider_blog_cat')))); ?>" class="external"><?php esc_html_e('Blog','Glider'); ?></a></li>

         </ul>
      </div> <!-- #main-menu -->

      <span id="active-arrow"></span>

      <div id="right-border"></div>
   </div> <!-- #main-leftarea -->