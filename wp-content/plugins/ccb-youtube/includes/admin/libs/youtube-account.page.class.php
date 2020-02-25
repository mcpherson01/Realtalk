<?php

class CBC_YouTube_Account_Page extends CBC_Page_Init implements CBC_Page{

	/*
	 * (non-PHPdoc)
	 * @see CBC_Page::get_html()
	 */
	public function get_html(){
		$this->my_yt_table->prepare_items();
		?>
<div class="wrap">
	<div class="icon32 icon32-posts-video" id="icon-edit">
		<br>
	</div>
	<h2>
		<?php _e('My YouTube Account', 'cbc_video')?>
		<a class="add-new-h2"
			href="<?php menu_page_url( 'cbc_settings' );?>#cbc-settings-auth-options"><?php _e( 'Setup OAuth', 'cbc_video' );?></a>
	</h2>
	<form method="post" action="">
		<?php wp_nonce_field( 'cbc_channels_table_actions', 'cbc_nonce' );?>
		<?php $this->my_yt_table->views();?>
		<?php $this->my_yt_table->display();?>
	</form>
</div>
<?php
	}

	/*
	 * (non-PHPdoc)
	 * @see CBC_Page::on_load()
	 */
	public function on_load(){
		require_once CBC_PATH . '/includes/admin/libs/channels-list-table.class.php';
		$this->my_yt_table = new CBC_Channels_List_Table();
	}
}