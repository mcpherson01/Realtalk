<?php
/*
Template Name: Blog Page
*/
?>
<?php
$et_ptemplate_settings = array();
$et_ptemplate_settings = maybe_unserialize( get_post_meta( get_the_ID(), 'et_ptemplate_settings', true ) );

$fullwidth = isset( $et_ptemplate_settings['et_fullwidthpage'] ) ? (bool) $et_ptemplate_settings['et_fullwidthpage'] : false;

$et_ptemplate_blogstyle = isset( $et_ptemplate_settings['et_ptemplate_blogstyle'] ) ? (bool) $et_ptemplate_settings['et_ptemplate_blogstyle'] : false;

$et_ptemplate_showthumb = isset( $et_ptemplate_settings['et_ptemplate_showthumb'] ) ? (bool) $et_ptemplate_settings['et_ptemplate_showthumb'] : false;

$blog_cats = isset( $et_ptemplate_settings['et_ptemplate_blogcats'] ) ? (array) $et_ptemplate_settings['et_ptemplate_blogcats'] : array();
$et_ptemplate_blog_perpage = isset( $et_ptemplate_settings['et_ptemplate_blog_perpage'] ) ? (int) $et_ptemplate_settings['et_ptemplate_blog_perpage'] : 10;
?>
<?php get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<?php $video = get_post_meta(get_the_ID(), 'Video', $single = true); ?>
<?php
if($video !== '') { ?>

<div id="header4">
    <div id="header5">
        <div class="video-nav ievideo-nav" style="margin-left: 100px;"> <span class="video-button-hover"> <img src="<?php echo get_template_directory_uri(); ?>/images/video-button-embed.png" style="margin: 2px 0px 0px 0px; border: none; cursor: pointer;" alt="embed" /> <img src="<?php echo get_template_directory_uri(); ?>/images/video-button-embed-hover.gif" alt="embed" class="embed-button video-button-hover-image"  /> </span> <span class="video-button-hover"> <img src="<?php echo get_template_directory_uri(); ?>/images/video-button-share.png" style="margin: 2px 0px 0px 0px; border: none; cursor: pointer;" alt="share" /> <img src="<?php echo get_template_directory_uri(); ?>/images/video-button-share-hover.gif" alt="share" class="share-button video-button-hover-image"  /> </span> <span class="video-button-hover"> <img src="<?php echo get_template_directory_uri(); ?>/images/video-button-link.png" style="margin: 2px 0px 0px 0px; border: none; cursor: pointer;" alt="link" /> <img src="<?php echo get_template_directory_uri(); ?>/images/video-button-link-hover.gif" alt="link" class="link-button video-button-hover-image"  /> </span> <span class="video-button-hover"> <img src="<?php echo get_template_directory_uri(); ?>/images/video-button-comment.png" style="margin: 2px 0px 0px 0px; border: none; cursor: pointer;" alt="comment"  /> <a href="#respond" class="video-button-hover-image" ><img src="<?php echo get_template_directory_uri(); ?>/images/video-button-comment-hover.gif" alt="comment" style="border: none;" class="comment-button" /></a> </span> </div>
        <div id="video">
            <div id="video-inside"> <?php echo $video; ?> </div>
        </div>
        <div class="video-embed video2"> <span class="video-titles"><?php esc_html_e('Embed This Video','eVid') ?></span> <img src="<?php echo get_template_directory_uri(); ?>/images/close.png" style="margin: 10px 10px 0px 0px; float: right; cursor: pointer;" alt="close" class="close" />
            <div style="clear: both;"></div>
            <textarea rows="4" style="border:1px solid #1F1F1F; width:90%; height: 200px; background:#373737; padding:10px; color:#CCCCCC; margin-left: 15px; float: left; margin-top: 15px;"><?php echo get_post_meta(get_the_ID(), "Video", true); ?>
</textarea>
        </div>
        <div class="video-share video2"> <span class="video-titles"><?php esc_html_e('Share This Video','eVid') ?></span> <img src="<?php echo get_template_directory_uri(); ?>/images/close.png" style="margin: 10px 10px 0px 0px; float: right; cursor: pointer;" alt="close" class="close" />
            <div style="clear: both;"></div>
            <a href="http://del.icio.us/post?url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/bookmark-1.gif" alt="bookmark" style="float: left; margin-left: 15px; margin-right: 8px; border: none;" /></a> <a href="http://www.digg.com/submit?phase=2&amp;url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>"  target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/bookmark-2.gif" alt="bookmark" style="float: left; margin-right: 8px; border: none;" /></a> <a href="http://www.reddit.com/submit?url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>"  target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/bookmark-3.gif" alt="bookmark" style="float: left; margin-right: 8px; border: none;" /></a> <a href="http://www.stumbleupon.com/submit?url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>"  target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/bookmark-4.gif" alt="bookmark" style="float: left; margin-right: 8px; border: none;" /></a> <a href="http://www.squidoo.com/lensmaster/bookmark?<?php the_permalink() ?>"  target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/bookmark-5.gif" alt="bookmark" style="float: left; margin-right: 8px; border: none;" /></a> <a href="http://myweb2.search.yahoo.com/myresults/bookmarklet?t=<?php the_title(); ?>&amp;u=<?php the_permalink() ?>"  target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/bookmark-6.gif" alt="bookmark" style="float: left; margin-right: 8px; border: none;" /></a> <a href="http://www.google.com/bookmarks/mark?op=edit&amp;bkmk=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>"  target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/bookmark-7.gif" alt="bookmark" style="float: left; margin-right: 8px; border: none;" /></a> <a href="http://www.blinklist.com/index.php?Action=Blink/addblink.php&amp;Url=<?php the_permalink() ?>&amp;Title=<?php the_title(); ?>"  target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/bookmark-8.gif" alt="bookmark" style="float: left; margin-right: 8px; border: none;" /></a> <a href="http://www.technorati.com/faves?add=<?php the_permalink() ?>"  target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/bookmark-9.gif" alt="bookmark" style="float: left; margin-right: 8px; border: none;" /></a> <a href="http://www.furl.net/storeIt.jsp?t=<?php the_title(); ?>&amp;u=<?php the_permalink() ?>"  target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/bookmark-10.gif" alt="bookmark" style="float: left; margin-right: 8px; border: none;" /></a> <a href="http://cgi.fark.com/cgi/fark/edit.pl?new_url=<?php the_permalink() ?>&amp;new_comment=<?php the_title(); ?>"  target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/bookmark-11.gif" alt="bookmark" style="float: left; margin-right: 8px; border: none;" /></a> <a href="http://www.sphinn.com/submit.php?url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>"  target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/bookmark-12.gif" alt="bookmark" style="float: left; margin-right: 8px; border: none;" /></a> </div>
        <div class="video-link video2"> <span class="video-titles"><?php esc_html_e('Link To This Video','eVid') ?></span> <img src="<?php echo get_template_directory_uri(); ?>/images/close.png" style="margin: 10px 10px 0px 0px; float: right; cursor: pointer;" alt="close" class="close" />
            <div style="clear: both;"></div>
            <textarea rows="4" style="border:1px solid #1F1F1F; width:90%; height: 200px; background:#373737; padding:10px; color:#CCCCCC; margin-left: 15px; float: left; margin-top: 15px;">
<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permanent Link to %s','eVid'), get_the_title()) ?>"><?php the_title(); ?></a>
</textarea>
        </div>
        <div class="video-comment video2"> <img src="<?php echo get_template_directory_uri(); ?>/images/close.png" style="margin: 10px 10px 0px 0px; float: right; cursor: pointer;" alt="embed" class="close" /> <?php esc_html_e('test','eVid') ?> </div>
        <div class="video-rate video2"> <span class="video-titles"><?php esc_html_e('Rate This Video','eVid') ?></span> <img src="<?php echo get_template_directory_uri(); ?>/images/close.png" style="margin: 10px 10px 0px 0px; float: right; cursor: pointer;" alt="embed" class="close" />
            <div style="clear: both;"></div>
            <div style="border:1px solid #1F1F1F; width:90%; height: 200px; background:#373737; padding:10px; color:#CCCCCC; margin-left: 15px; float: left; margin-top: 15px;">
                <?php if(function_exists('the_ratings')) { the_ratings(); } ?>
            </div>
        </div>
        <div class="video-tags video2"> <span class="video-titles"><?php esc_html_e('Tags For This Video','eVid') ?></span> <img src="<?php echo get_template_directory_uri(); ?>/images/close.png" style="margin: 10px 10px 0px 0px; float: right; cursor: pointer;" alt="tags" class="close" />
            <div style="clear: both;"></div>
            <?php the_tags('', ' ', ''); ?>
        </div>
        <div class="video-related video2"> <span class="video-titles"><?php esc_html_e('Related Videos','eVid') ?></span> <img src="<?php echo get_template_directory_uri(); ?>/images/close.png" style="margin: 10px 10px 0px 0px; float: right; cursor: pointer;" alt="related posts" class="close" />
            <div style="clear: both;"></div>
            <?php wp_related_posts(); ?>
        </div>
        <div class="video-nav"> <span class="video-button-hover"> <img src="<?php echo get_template_directory_uri(); ?>/images/video-button-rate.png" style="margin: 2px 0px 0px 0px; border: none; cursor: pointer;" alt="rate" /> <img src="<?php echo get_template_directory_uri(); ?>/images/video-button-rate-hover.gif" alt="rate" style="left: 5px !important;" class="rate-button video-button-hover-image"  /> </span> <span class="video-button-hover"> <img src="<?php echo get_template_directory_uri(); ?>/images/video-button-tags.png" style="margin: 2px 0px 0px 0px; border: none; cursor: pointer;" alt="tags" /> <img src="<?php echo get_template_directory_uri(); ?>/images/video-button-tags-hover.gif" alt="tags" style="left: 5px !important;" class="tags-button video-button-hover-image"  /> </span> <span class="video-button-hover"> <img src="<?php echo get_template_directory_uri(); ?>/images/video-button-related.png" style="margin: 2px 0px 0px 0px; border: none; cursor: pointer;" alt="related" /> <img src="<?php echo get_template_directory_uri(); ?>/images/video-button-related-hover.gif" alt="related" style="left: 5px !important;" class="related-button video-button-hover-image"  /> </span> <span class="video-button-hover"> <img src="<?php echo get_template_directory_uri(); ?>/images/video-button-lights.png" style="margin: 2px 0px 0px 0px; border: none; cursor: pointer;" alt="lights" /> <img src="<?php echo get_template_directory_uri(); ?>/images/video-button-lights-hover.gif" alt="lights" style="left: 5px !important;" class="lights-button video-button-hover-image"  /> </span> </div>
    </div>
</div>
<?php } else { echo ''; } ?>
<div id="wrapper2" <?php if($fullwidth) echo ('class="no_sidebar"');?>>

<div id="container">
    <div id="left-div">
        <div id="left-inside">
            <!--Begin Post-->
            <div class="post-wrapper">
                <h1 class="post-title"><?php the_title(); ?></h1>

				<?php if (get_option('evid_page_thumbnails') == 'on') { get_template_part( 'includes/thumbnail'); } ?>
                <?php the_content(); ?>
					<div id="et_pt_blog">
						<?php $cat_query = '';
						if ( !empty($blog_cats) ) $cat_query = '&cat=' . implode(",", $blog_cats);
						else echo '<!-- blog category is not selected -->'; ?>
						<?php
							$et_paged = is_front_page() ? get_query_var( 'page' ) : get_query_var( 'paged' );
						?>
						<?php query_posts("posts_per_page=$et_ptemplate_blog_perpage&paged=" . $et_paged . $cat_query); ?>
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<div class="et_pt_blogentry clearfix">
								<h2 class="et_pt_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

								<p class="et_pt_blogmeta"><?php esc_html_e('Posted','eVid'); ?> <?php esc_html_e('by','eVid'); ?> <?php the_author_posts_link(); ?> <?php esc_html_e('on','eVid'); ?> <?php the_time(get_option('evid_date_format')) ?> <?php esc_html_e('in','eVid'); ?> <?php the_category(', ') ?> | <?php comments_popup_link(esc_html__('0 comments','eVid'), esc_html__('1 comment','eVid'), '% '.esc_html__('comments','eVid')); ?></p>

								<?php $thumb = '';
								$width = 184;
								$height = 184;
								$classtext = '';
								$titletext = get_the_title();

								$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
								$thumb = $thumbnail["thumb"]; ?>

								<?php if ( $thumb <> '' && !$et_ptemplate_showthumb ) { ?>
									<div class="et_pt_thumb alignleft">
										<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
										<a href="<?php the_permalink(); ?>"><span class="overlay"></span></a>
									</div> <!-- end .thumb -->
								<?php }; ?>

								<?php if (!$et_ptemplate_blogstyle) { ?>
									<p><?php truncate_post(550);?></p>
									<a href="<?php the_permalink(); ?>" class="readmore"><span><?php esc_html_e('read more','eVid'); ?></span></a>
								<?php } else { ?>
									<?php
										global $more;
										$more = 0;
									?>
									<?php the_content(); ?>
								<?php } ?>
							</div> <!-- end .et_pt_blogentry -->

						<?php endwhile; ?>
							<div class="page-nav clearfix">
								<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
								else { ?>
									 <?php get_template_part('includes/navigation'); ?>
								<?php } ?>
							</div> <!-- end .entry -->
						<?php else : ?>
							<?php get_template_part('includes/no-results'); ?>
						<?php endif; wp_reset_query(); ?>

					</div> <!-- end #et_pt_blog -->
				<div style="clear: both;"></div>
                <?php if (get_option('evid_foursixeight') == 'on') { get_template_part('includes/468x60'); } ?>
				<div style="clear: both;"></div>
				<?php if (get_option('evid_show_pagescomments') == 'on') { ?>
					<?php comments_template('', true); ?>
				<?php }; ?>

            </div>

        </div>
    </div>
	<?php endwhile; endif; ?>
	<!--Begin Sidebar-->
    <?php if (!$fullwidth) get_sidebar(); ?>
    <!--End Sidebar-->
    <!--Begin Footer-->
    <?php get_footer(); ?>
    <!--End Footer-->
</div>
</body>
</html>