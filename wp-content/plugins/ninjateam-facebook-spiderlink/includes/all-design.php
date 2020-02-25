<?php
global $wpdb;
$table_design = $wpdb->prefix.'njt_like_comment_design';
if(isset($_POST["apply"])){
	$apply = $_POST["action"];
	$list_design = $_POST["njt_user"];
	
	if($apply=="delete"){

		if(!empty($list_design)){
			foreach ($list_design as $key => $design) {
				$delete=$wpdb->delete($table_design, array( 'id' => $design), array('%d') );
			}
		}
		
	}
	
}
$list_design = $wpdb->get_results("SELECT * FROM $table_design ORDER BY ID DESC");

?>
<div class="wrap">
<h1 class="wp-heading-inline">Templates Design</h1>
<?php 
	$add_new_url= add_query_arg(array('page'=>'add-design'),admin_url('admin.php'));
?>
 <a href="<?php echo $add_new_url; ?>" class="page-title-action">Add New Template</a>
<hr class="wp-header-end">
</div>
<?php if(isset($_GET['success'])){ ?>
<div style="margin-left: 0px;margin-top: 15px;" class="notice notice-success is-dismissible mst-popup-notifi-save-changed">
<p><?php _e('Save changed!',NJT_APP_LIKE_COMMENT) ?></p>
</div>
<?php } ?>
<?php 
	$url_design= add_query_arg(array('page'=>'list-design','success'=>true),admin_url('admin.php'));
?>
<input type="hidden" id="url_design" value="<?php echo $url_design; ?>">
<form action="" method="POST">
	<div class="tablenav top">
		<div class="alignleft actions bulkactions">
			<label for="bulk-action-selector-top" class="screen-reader-text">Select bulk action</label>
			<select name="action" id="bulk-action-selector-top">
				<option value="-1">Bulk Actions</option>
				<option value="delete">Delete</option>
			</select>
			<input type="submit" name="apply" class="button action" value="Apply">
		</div>
		
	</div>
	
	<table class="wp-list-table widefat fixed striped posts">
	<thead>
	<tr>
		<td style="width:5%" id="cb" class="manage-column column-cb check-column">
			<div class="checkbox success">
				<input type="checkbox" id="list-campaign-checkall" name="campaign[checbox]"><label for="list-campaign-checkall"></label>
			</div>
		</td>
		<th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
			<a href=""><span>Title</span>
				<span class="sorting-indicator"></span>
			</a>
		</th>
		<th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
		</th>
		<th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
		</th>
		<th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
		</th>
	</tr>

	
	</thead>

	<tbody id="the-list">
		<?php if(!empty($list_design)){ 
				foreach ($list_design as $key => $design) {
					$edit= add_query_arg(array('page'=>'add-design','edit'=>$design->id),admin_url('admin.php'));
		?>
			<tr class="iedit author-self level-0 post-1 type-post status-publish format-standard hentry category-uncategorized">
				<th scope="row" class="check-column">
					<div class="checkbox success">
						<input value="<?php echo $design->id; ?>" type="checkbox" id="campaign_cb__<?php echo $design->id; ?>" name="njt_user[]" class="checkbox-with-campaign"><label for="campaign_cb__<?php echo $design->id; ?>"></label>
					</div>
				</th>
				<td class="">
					<?php if(isset($design->title) && !empty($design->title)){?>
						<strong><a class="row-title" href="<?php echo $edit; ?>"><?php echo $design->title; ?></a></strong>
					<?php } else { ?>
						<strong><a class="row-title" href="<?php echo $edit; ?>"><?php echo "Design ".$design->id; ?></a></strong>
					<?php } ?>
				</td>
				<td>
				</td>
				<td>
				</td>
				<td>
					<a class="button button-primary button-large" href="<?php echo $edit; ?>">Edit Template</a>
					<a data-design_id="<?php echo $design->id;?>" class="button delete-designs" href="javascript:void(0)">Delete</a>
				</td>
				
			</tr>
		<?php } } else {?>
			<tr class="iedit author-self level-0 post-1 type-post status-publish format-standard hentry category-uncategorized">
				<td colspan="5">You have no template design. Start create new one or use default template.</td>
			</tr>
		<?php } ?>
			
	</tbody>


</table>		
</form>

<script type="text/javascript">
	jQuery(document).ready(function($){
		$(document).on("click",".delete-designs",function(e){
			var r = confirm("Do you really want to delete?");
			var url_design = $("#url_design").val();
	       //cancel clicked : stop button default action 
	       	if (r === false) {
	           return false;
	        }else{
	        	var id_design = $(this).data('design_id');
				var action_data = {
	            	action:'njt_like_comment_delete_design',
	            	id_design: id_design
	        	};
				$.post(ajaxurl,action_data,function(result){

	                if(result){

	                	window.location = url_design;
	                }
	        	});
	        }
			
		});
	});
</script>