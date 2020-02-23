<?php
add_action( 'after_setup_theme', 'et_setup_theme' );
if ( ! function_exists( 'et_setup_theme' ) ){
	function et_setup_theme(){
		global $themename, $shortname, $default_colorscheme;
		$themename = "eBusiness";
		$shortname = "ebusiness";
		$default_colorscheme = "";

		$template_dir = get_template_directory();

		require_once($template_dir . '/epanel/custom_functions.php');

		require_once($template_dir . '/includes/functions/comments.php');

		require_once($template_dir . '/includes/functions/sidebars.php');

		load_theme_textdomain('eBusiness',$template_dir.'/lang');

		require_once($template_dir . '/epanel/core_functions.php');

		require_once($template_dir . '/includes/post_thumbnails_ebusiness.php');

		include($template_dir . '/includes/widgets.php');

		remove_action( 'admin_init', 'et_epanel_register_portability' );

		add_action( 'pre_get_posts', 'et_home_posts_query' );

		add_theme_support( 'title-tag' );
	}
}

if ( ! function_exists( '_wp_render_title_tag' ) ) :
/**
 * Manually add <title> tag in head for WordPress 4.1 below for backward compatibility
 * Title tag is automatically added for WordPress 4.1 above via theme support
 * @return void
 */
	function et_add_title_tag_back_compat() { ?>
		<title><?php wp_title( '-', true, 'right' ); ?></title>
<?php
	}
	add_action( 'wp_head', 'et_add_title_tag_back_compat' );
endif;

add_action('wp_head','et_portfoliopt_additional_styles',100);
function et_portfoliopt_additional_styles(){ ?>
	<style type="text/css">
		#et_pt_portfolio_gallery { margin-left: -15px; }
		.et_pt_portfolio_item { margin-left: 21px; }
		.et_portfolio_small { margin-left: -40px !important; }
		.et_portfolio_small .et_pt_portfolio_item { margin-left: 32px !important; }
		.et_portfolio_large { margin-left: -8px !important; }
		.et_portfolio_large .et_pt_portfolio_item { margin-left: 7px !important; }
	</style>
<?php }

function register_main_menus() {
	register_nav_menus(
		array(
			'primary-menu' => __( 'Primary Menu', 'eBusiness' ),
			'secondary-menu' => __( 'Secondary Menu', 'eBusiness' )
		)
	);
};
if (function_exists('register_nav_menus')) add_action( 'init', 'register_main_menus' );

if ( ! function_exists( 'et_list_pings' ) ){
	function et_list_pings($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment; ?>
		<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?> - <?php comment_excerpt(); ?>
	<?php }
}

if ( ! function_exists( 'et_comment_form' ) ){
	function et_comment_form( $args = array(), $post_id = null ) {
		# copy of comment_form() function, we just add 2 more action hooks to style it properly

		global $user_identity, $id;

		if ( null === $post_id )
			$post_id = $id;
		else
			$id = $post_id;

		$commenter = wp_get_current_commenter();

		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		$fields =  array(
			'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
						'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
			'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
						'<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
			'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website' ) . '</label>' .
						'<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
		);

		$required_text = sprintf( ' ' . __('Required fields are marked %s'), '<span class="required">*</span>' );
		$defaults = array(
			'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
			'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
			'must_log_in'          => '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
			'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
			'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published.' ) . ( $req ? $required_text : '' ) . '</p>',
			'comment_notes_after'  => '<p class="form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ), ' <code>' . allowed_tags() . '</code>' ) . '</p>',
			'id_form'              => 'commentform',
			'id_submit'            => 'submit',
			'title_reply'          => __( 'Leave a Reply' ),
			'title_reply_to'       => __( 'Leave a Reply to %s' ),
			'cancel_reply_link'    => __( 'Cancel reply' ),
			'label_submit'         => __( 'Post Comment' ),
		);

		$args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );

		?>
			<?php if ( comments_open() ) : ?>
				<?php do_action( 'comment_form_before' ); ?>
				<div id="respond">
					<?php do_action( 'et_comment_respond_top' ); ?>
					<h3 id="reply-title"><?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?> <small><?php cancel_comment_reply_link( $args['cancel_reply_link'] ); ?></small></h3>
					<?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
						<?php echo $args['must_log_in']; ?>
						<?php do_action( 'comment_form_must_log_in_after' ); ?>
					<?php else : ?>
						<form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>">
							<?php do_action( 'comment_form_top' ); ?>
							<?php if ( is_user_logged_in() ) : ?>
								<?php echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity ); ?>
								<?php do_action( 'comment_form_logged_in_after', $commenter, $user_identity ); ?>
							<?php else : ?>
								<?php echo $args['comment_notes_before']; ?>
								<?php
								do_action( 'comment_form_before_fields' );
								foreach ( (array) $args['fields'] as $name => $field ) {
									echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
								}
								do_action( 'comment_form_after_fields' );
								?>
							<?php endif; ?>
							<?php echo apply_filters( 'comment_form_field_comment', $args['comment_field'] ); ?>
							<?php echo $args['comment_notes_after']; ?>
							<p class="form-submit">
								<input name="submit" type="submit" id="<?php echo esc_attr( $args['id_submit'] ); ?>" value="<?php echo esc_attr( $args['label_submit'] ); ?>" />
								<?php comment_id_fields( $post_id ); ?>
							</p>
							<?php do_action( 'comment_form', $post_id ); ?>
						</form>
					<?php endif; ?>
					<?php do_action( 'et_comment_respond_bottom' ); ?>
				</div><!-- #respond -->
				<?php do_action( 'comment_form_after' ); ?>
			<?php else : ?>
				<?php do_action( 'comment_form_comments_closed' ); ?>
			<?php endif; ?>
		<?php
	}
}

add_action( 'et_comment_respond_top', 'ebusiness_comment_respond_top' );
function ebusiness_comment_respond_top(){ ?>
	<div id="comments">
		<div class="post-info-wrap"> <img src="<?php echo get_template_directory_uri(); ?>/images/home-title-2-left-2-<?php echo(get_option('ebusiness_color_scheme')); ?>.png" alt="home title" class="home-title-image" /> <span class="post-info">
<?php }

/**
 * Filters the main query on homepage
 */
function et_home_posts_query( $query = false ) {
	/* Don't proceed if it's not homepage or the main query */
	if ( ! is_home() || ! is_a( $query, 'WP_Query' ) || ! $query->is_main_query() ) return;

	/* Set the amount of posts per page on homepage */
	$query->set( 'posts_per_page', (int) et_get_option( 'ebusiness_homepage_posts', '6' ) );

	/* Exclude categories set in ePanel */
	$exclude_categories = et_get_option( 'ebusiness_exlcats_recent', false );
	if ( $exclude_categories ) $query->set( 'category__not_in', array_map( 'intval', et_generate_wpml_ids( $exclude_categories, 'category' ) ) );
}

add_action( 'et_comment_respond_bottom', 'ebusiness_comment_respond_bottom' );
function ebusiness_comment_respond_bottom(){
	echo '</div> <!-- end #comments -->';
}

function et_epanel_custom_colors_css(){
	global $shortname; ?>

	<style type="text/css">
		body { color: #<?php echo esc_html(get_option($shortname.'_color_mainfont')); ?>; }
		body { background-color: #<?php echo esc_html(get_option($shortname.'_color_bgcolor')); ?>; }
		a:link, a:visited { color: #<?php echo esc_html(get_option($shortname.'_color_mainlink')); ?>; }
		div#pages-inside ul.nav li a { color: #<?php echo esc_html(get_option($shortname.'_color_pagelink')); ?>; }
		div#categories ul#nav2 li a:link, div#categories ul#nav2 li a:visited { color: #<?php echo esc_html(get_option($shortname.'_color_catslink')); ?>; }
		.recent-info { color: #<?php echo esc_html(get_option($shortname.'_color_postinfo')); ?>; }
		#sections h2 { color: #<?php echo esc_html(get_option($shortname.'_color_featheader')); ?>; }
		.slider-left { color: #<?php echo esc_html(get_option($shortname.'_color_feattext')); ?>; }
		.sidebar-box-title { background-color: #<?php echo esc_html(get_option($shortname.'_color_sidebarbg_titles'));?> }
		.sidebar-box-title { color:#<?php echo esc_html(get_option($shortname.'_color_sidebar_titles')); ?>; }
		.footer-box h3 { color:#<?php echo esc_html(get_option($shortname.'_color_footer_titles')); ?>; }
		#footer a:link, #footer a:visited { color:#<?php echo esc_html(get_option($shortname.'_color_footer_links')); ?>; }
		.titles a:link, .titles a:visited, .titles a:active { color:#<?php echo esc_html(get_option($shortname.'_color_heading')); ?>; }
	</style>

<?php }

function et_remove_additional_epanel_styles() {
	return true;
}
add_filter( 'et_epanel_is_divi', 'et_remove_additional_epanel_styles' );

function et_register_updates_component() {
	require_once( get_template_directory() . '/core/updates_init.php' );

	et_core_enable_automatic_updates( get_template_directory_uri(), et_get_theme_version() );
}
add_action( 'admin_init', 'et_register_updates_component' );

if ( ! function_exists( 'et_core_portability_link' ) && ! class_exists( 'ET_Builder_Plugin' ) ) :
function et_core_portability_link() {
	return '';
}
endif;

function et_theme_maybe_load_core() {
	if ( et_core_exists_in_active_plugins() ) {
		return;
	}

	if ( defined( 'ET_CORE' ) ) {
		return;
	}

	require_once get_template_directory() . '/core/init.php';

	et_core_setup( get_template_directory_uri() );
}
add_action( 'after_setup_theme', 'et_theme_maybe_load_core' );

