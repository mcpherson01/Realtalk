	<div id="share">
		<a href="#" id="share-link"><?php esc_html_e('share','eNews') ?></a>
		<div id="share-icons">
			<a href="http://del.icio.us/post?url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/delicious.jpg" alt="share this article on delicious" width="21px" height="21px" /></a>
			<a href="http://www.squidoo.com/lensmaster/bookmark?<?php the_permalink() ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/squidoo.jpg" alt="share this article on squidoo" width="21px" height="21px" /></a>
			<a href="http://www.stumbleupon.com/submit?url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/stumbleupon.jpg" alt="share this article on stumbleupon" width="21px" height="21px" /></a>
			<a href="http://www.digg.com/submit?phase=2&amp;url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/digg.jpg" alt="share this article on digg" width="21px" height="21px" /></a>
			<a href="http://www.technorati.com/faves?add=<?php the_permalink() ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/technorati.jpg" alt="share this article on technorati" width="21px" height="21px" /></a>
			<a href="http://www.reddit.com/submit?url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/reddit.jpg" alt="share this article on reddit" width="21px" height="21px" /></a>
			<a href="http://www.linkedin.com/shareArticle?mini=true&amp;<?php the_permalink() ?>&amp;summary=&amp;source="><img src="<?php echo get_template_directory_uri(); ?>/images/linkedin.jpg" alt="share this article on linkedin" width="21px" height="21px" /></a>
			<a href="http://www.google.com/bookmarks/mark?op=edit&amp;bkmk=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/google.jpg" alt="share this article on google bookmarks" width="21px" height="21px" /></a>
			<a href="http://www.blinklist.com/index.php?Action=Blink/addblink.php&amp;Url=<?php the_permalink() ?>&amp;Title=<?php the_title(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/blinklist.jpg" alt="share this article on blinklist" width="21px" height="21px" /></a>
			<a href="http://www.furl.net/storeIt.jsp?t=<?php the_title(); ?>&amp;u=<?php the_permalink() ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/furl.jpg" alt="share this article on furl" width="21px" height="21px" /></a>
			<a href="http://www.sphinn.com/submit.php?url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/sphinn.jpg" alt="share this article on sphinn" width="21px" height="21px" /></a>
			<a href="http://www.newsvine.com/_tools/seed&amp;save?popoff=0&amp;u=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/newsvine.jpg" alt="share this article on newsvine" width="21px" height="21px" /></a>
			<div class="clear"></div>
		</div> <!-- end share-icons -->
		<a href="#" id="this-link"><?php esc_html_e('this','eNews') ?></a>
	</div> <!-- end share -->