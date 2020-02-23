<div class="clear"></div>
<div id="controllers">
	<?php next_posts_link('<span id="right-arrow"></span>', 0); ?>
	<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
	<?php previous_posts_link('<span id="left-arrow"></span>', 0); ?>
</div>	<!-- end #controllers -->