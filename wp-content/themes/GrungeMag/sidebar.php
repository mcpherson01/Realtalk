<div id="sidebar">
	<?php if(get_option('grungemag_show_tabbed') == 'on') { ?>
		<!--Begin Sidebar Tabbed Menu-->
		<ul class="idTabs">
			<li><a href="#recententries"><?php esc_html_e('Recent Entries','GrungeMag'); ?></a></li>
			<li><a href="#recentcomments2"><?php esc_html_e('Recent Comments','GrungeMag'); ?></a></li>
			<li><a href="#mostcomments"><?php esc_html_e('About Us','GrungeMag'); ?></a></li>
		</ul>
		<div id="recententries" class="sidebar-box">
			<ul>
				<?php $tab_entries = get_option('grungemag_tab_entries');
				wp_get_archives('postbypost', "$tab_entries;"); ?>
			</ul>
		</div>
		<div id="recentcomments2" class="sidebar-box">
			<?php include (get_template_directory() . '/simple_recent_comments.php'); /* recent comments plugin by: www.g-loaded.eu */ ?>
			<?php $tab_comments = (int) get_option('grungemag_tab_comments');
			if (function_exists('src_simple_recent_comments')) { src_simple_recent_comments("$tab_comments;", 85, '', ''); } ?>
		</div>
		<div id="mostcomments" class="sidebar-box"> <?php echo(get_option('grungemag_abouttext')); ?> </div>
		<!--End Sidebar Tabbed Menu-->
	<?php }; ?>

    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
    <?php endif; ?>
</div> <!-- end #sidebar -->
</div>