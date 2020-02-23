
<?php
$vendor_announcement = EDD_FES()->helper->get_option( 'fes-dashboard-notification', '' );
if ( $vendor_announcement ) {
	?>
	<div id="fes-vendor-announcements">
		<?php echo apply_filters( 'fes_dashboard_content', do_shortcode( $vendor_announcement ) ); ?>
	</div>
	<?php
}
?>

<div class="clearfix"></div>
<div id="fes-vendor-store-link">
	<?php echo EDD_FES()->vendors->get_vendor_store_url_dashboard(); ?>
</div>

<div class="fes-comments-wrap">
	<table id="fes-comments-table">
		<tr class="heading_tr">
			<th class="col-author"><?php  esc_html_e( 'Author', 'mayosis' ); ?></th>
			<th class="col-content"><?php  esc_html_e( 'Comment', 'mayosis' ); ?></th>
		</tr>
		<?php echo EDD_FES()->dashboard->render_comments_table( 10 ); ?>
	</table>
</div>