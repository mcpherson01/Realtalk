<?php

$plugins = array(
    array(
    "name" => __( "Schema App Structured Data by Hunch Manifest", 'vidseo' ),
    "desc" => __( "Get Schema.org structured data for all pages, posts, categories and profile pages on activation.", 'vidseo' ),
    "link" => "https://wordpress.org/plugins/schema-app-structured-data-for-schemaorg/",
    "img"  => "../assets/imgs/1.jpg",
),
    array(
    "name" => __( "Yasr – Yet Another Stars Rating by Dario Curvino", 'vidseo' ),
    "desc" => __( "Boost the way people interact with your website, e-commerce or blog with an easy and intuitive WordPress rating system!", 'vidseo' ),
    "link" => "https://wordpress.org/plugins/yet-another-stars-rating/",
    "img"  => "../assets/imgs/2.jpg",
),
    array(
    "name" => __( "Better Robots.txt optimization – Website indexing, traffic, ranking & SEO Booster + Woocommerce", 'vidseo' ),
    "desc" => __( "Better Robots.txt is an all in one SEO robots.txt plugin, it creates a virtual robots.txt including your XML sitemaps (Yoast or else) to boost your website ranking on search engines.", 'vidseo' ),
    "link" => "https://wordpress.org/plugins/better-robots-txt/",
    "img"  => "../assets/imgs/3.png",
),
    array(
    "name" => __( "Smush Image Compression and Optimization By WPMU DEV", 'vidseo' ),
    "desc" => __( "Compress and optimize (or optimise) image files, improve performance and boost your SEO rank using Smush WordPress image compression and optimization.", 'vidseo' ),
    "link" => "https://wordpress.org/plugins/wp-smushit/",
    "img"  => "../assets/imgs/4.jpg",
),
    array(
    "name" => __( "404 to 301 By Joel James", 'vidseo' ),
    "desc" => __( "Automatically redirect, log and notify all 404 page errors to any page using 301 redirection...", 'vidseo' ),
    "link" => "https://wordpress.org/plugins/404-to-301/",
    "img"  => "../assets/imgs/5.png",
),
    array(
    "name" => __( "Yoast SEO By Team Yoast", 'vidseo' ),
    "desc" => __( "Improve your WordPress SEO: Write better content and have a fully optimized WordPress site using the Yoast SEO plugin.", 'vidseo' ),
    "link" => "https://wordpress.org/plugins/wordpress-seo/",
    "img"  => "../assets/imgs/6.png",
)
);
?>
<h3>
    <?php 
echo  __( 'Top plugins for SEO performance:', 'vidseo' ) ;
?>
</h3>

<div class="recs-tab">

    <div class="vidseo-note" style="background-color: #fff; margin: 10px 0;">
        <p><?php 
echo  __( "Video SEO Transcription Embedder by Pagup provides a selection of plugins allowing to keep your website healthy, get better results on Search engines and increase your sales for ecommerce solutions.", 'vidseo' ) ;
?></p>
    </div>

    <div class="vidseo-row">
        
        <?php 
$last = count( $plugins ) - 1;
foreach ( $plugins as $i => $plugin ) {
    $isFirst = $i == 0;
    $isLast = $i == $last;
    ?>
            <div class="vidseo-column col-4 col-link">
                <div class="link-box">
                    <h3 title="<?php 
    echo  $plugin['name'] ;
    ?>"><?php 
    echo  mb_strimwidth(
        $plugin['name'],
        0,
        48,
        "..."
    ) ;
    ?></h3>

                    <p><img src="<?php 
    echo  plugin_dir_url( __FILE__ ) . $plugin['img'] ;
    ?>" />
                        <?php 
    echo  mb_strimwidth(
        $plugin['desc'],
        0,
        120,
        "..."
    ) ;
    ?>
                    </p>

                    <a href="<?php 
    echo  $plugin['link'] ;
    ?>" class="link-btn" target="_blank">
                        <?php 
    echo  __( 'Download', 'vidseo' ) ;
    ?>
                    </a>
                </div>
            </div>
        <?php 
}
// end recs loop
?>

   </div>
    
<?php 
// display pro message
?>
       
    <div class="vidseo-note" style="background-color: #60DABF; margin: 10px 0;">
        <h2 style="font-size: 20px; text-align: center"><span class="dashicons dashicons-lock" style="font-size: 28px; margin-top: -3px;"></span>  &nbsp; <?php 
echo  __( 'Upgrade to PRO version to UNLOCK 12 additional awesome plugins recommendations for SEO & Conversion performance', 'vidseo' ) ;
?></h2>
    </div>
    
    <?php 
//end pro message
?>
    
    <div class="vidseo-note" style="background-color: #fff; margin: 10px 0;">
        <p><?php 
echo  __( "Want to suggest another plugin ? ... Send us a message at support@better-robots.com", 'vidseo' ) ;
?></p>
    </div>
    

</div>
