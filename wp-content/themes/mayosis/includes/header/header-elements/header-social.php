<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
global $mayosis_options; 

$facebookurl= get_theme_mod('facebook_url','https://facebook.com/'); 
$twitterurl= get_theme_mod('twitter_url','https://twitter.com/'); 
$instagramurl= get_theme_mod('instagram_url','https://instagram.com/');
$pinteresturl= get_theme_mod('pinterest_url','https://pinterest.com/'); 
$youtubeurl= get_theme_mod('youtube_url','https://youtube.com/');
$linkedinurl= get_theme_mod('linkedin_url','https://linkedin.com/');
$githuburl= get_theme_mod('github_url','https://github.io/'); 
$slackurl= get_theme_mod('slack_url','https://slack.com/');
$envatourl= get_theme_mod('envato_url','https://envato.com/');
$behanceurl= get_theme_mod('behance_url','https://behance.com/');
$dribbbleurl= get_theme_mod('dribbble_url','https://dribbble.com/');
$vimeourl= get_theme_mod('vimeo_url','https://vimeo.com/'); 
$spotifyurl= get_theme_mod('spotify_url','https://spotify.com/');

$facebookenable= get_theme_mod('facebook_enable',1);
$twitterenable= get_theme_mod('twitter_enable', 1);
$instagramenable= get_theme_mod('instagram_enable', 1);
$pinterestenable= get_theme_mod('pinterest_enable', 1);
$youtubeenable= get_theme_mod('youtube_enable', 1);
$linkedinenable= get_theme_mod('linkedin_enable', 2);
$githubenable= get_theme_mod('github_enable', 2);
$slackenable= get_theme_mod('slack_enable', 2);
$envatoenable= get_theme_mod('envato_enable', 2);
$behanceenable= get_theme_mod('behance_enable', 2);
$dribbbleenable= get_theme_mod('dribbble_enable',2);
$vimeoenable= get_theme_mod('vimeo_enable',2);
$spotifyenable= get_theme_mod('spotify_enable', 2);
?>

<ul class="top-social-icon">
        <?php if ($facebookenable == 1){ ?>
        		<li><a href="<?php echo esc_url($facebookurl);?>" target="_blank"><i class="zil zi-facebook"></i></a></li>
        <?php } ?>
        
        <?php if ($twitterenable == 1){ ?>
    				<li><a href="<?php echo esc_url($twitterurl);?>" target="_blank"><i class="zil zi-twitter"></i></a></li>
    	<?php } ?>
    	
    	 <?php if ($instagramenable == 1){ ?>
    				<li><a href="<?php echo esc_url($instagramurl);?>" target="_blank"><i class="zil zi-instagram"></i></a></li>
    		<?php } ?>
    		
    		<?php if ($pinterestenable == 1){ ?>
    				<li><a href="<?php echo esc_url($pinteresturl);?>" target="_blank"><i class="zil zi-pinterest"></i></a></li>
    		<?php } ?>
    		
    	  <?php if ($youtubeenable == 1){ ?>
    				<li><a href="<?php echo esc_url($youtubeurl);?>" target="_blank"><i class="zil zi-youtube"></i></a></li>
    		<?php } ?>
    		
    		<?php if ($linkedinenable == 1){ ?>
    				<li><a href="<?php echo esc_url($linkedinurl);?>" target="_blank"><i class="zil zi-linked-in"></i></a></li>
    		<?php } ?>
    		
    		 <?php if ($githubenable == 1){ ?>
    				<li><a href="<?php echo esc_url($githuburl);?>" target="_blank"><i class="zil zi-github"></i></a></li>
    		<?php } ?>
    		
    		<?php if ($slackenable == 1){ ?>
    				<li><a href="<?php echo esc_url($slackurl);?>" target="_blank"><i class="zil zi-slack"></i></a></li>
    		<?php } ?>
    		
    		<?php if ($envatoenable == 1){ ?>
    				<li><a href="<?php echo esc_url($envatourl);?>" target="_blank"><i class="zil zi-envato"></i></a></li>
    		<?php } ?>
    		
    		<?php if ($behanceenable == 1){ ?>
    				<li><a href="<?php echo esc_url($behanceurl);?>" target="_blank"><i class="zil zi-behance"></i></a></li>
    		<?php } ?>
    		
    		<?php if ($dribbbleenable == 1){ ?>
    				<li><a href="<?php echo esc_url($dribbbleurl);?>" target="_blank"><i class="zil zi-dribbble"></i></a></li>
    		<?php } ?>
    		
    		<?php if ($vimeoenable == 1){ ?>
    				<li><a href="<?php echo esc_url($vimeourl);?>" target="_blank"><i class="zil zi-vimeo"></i></a></li>
    		<?php } ?>
    		
    		<?php if ($spotifyenable == 1){ ?>
    				<li><a href="<?php echo esc_url($spotifyurl);?>" target="_blank"><i class="zil zi-spotify"></i></a></li>
    		<?php } ?>
    	
    						
    			
    </ul>