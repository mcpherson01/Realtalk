	<div class="wrap imapper-admin-wrapper">
		<h2 class="imapper-backend-header">Leadeo			<a href="<?php echo $this->admin_url; ?>_edit" class="add-new-h2">Add New</a>
		</h2>
		<ul class="imapper-backend-ul">
			<li>




				<table class="widefat">
					<thead>
					<tr>
						<th width="5%">ID</th>
						<th width="30%">Name</th>
						<th width="30%">Shortcode</th>
						<th width="35%">Actions</th>
					</tr>
					</thead>
					<tbody>
<?php
    if (count($items)==0) {
        echo '<tr><td colspan="4" style="text-align: center;">';
        echo '<b>There are no created items. <a href="'.$this->admin_url.'_edit">Create one now</a>.</b>';
        echo '</td></tr>';
    }
	foreach($items as $row):
?>
					<tr id="tr_id_<?php echo $row['id']; ?>">
						<td><?php echo $row['id']; ?></td>
						<td><a title="Edit" href="<?php echo $this->admin_url; ?>_edit&id=<?php echo $row['id']; ?>"><?php if ($row['name']=='') echo '(no name)'; else echo $row['name']; ?></a></td>
						<td>[leadeo id="<?php echo $row['id']; ?>"]</td>
						<td>
							<a href="<?php echo $this->admin_url; ?>_edit&id=<?php echo $row['id']; ?>" class="imapper-edit-button">Edit</a>
							<a href="<?php echo $this->admin_url; ?>&action=delete&id=<?php echo $row['id']; ?>" class="imapper-delete-button">Delete</a>
							<a href="<?php echo $this->admin_url; ?>&action=list_submitted_data&id=<?php echo $row['id']; ?>" class="imapper-edit-button" style="margin-left: 5px;">Browse submitted data</a>
						</td>
					</tr>
<?php
	endforeach;
?>
					</tbody></table>
				<script type="text/javascript">
				</script>
			</li>
		</ul>
		<div style="margin-top:20px;">

			<h2 class="imapper-backend-header">Step by step instructions:</h2>
			<ul class="imapper-backend-ul">
				<li><h3>1. Click the <span class="emphasize">"Add New"</span> button</h3></li>
				<li><h3>2. Name your Leadeo</h3></li>
				<li><h3>3. Add URL of your <span class="emphasize">video</span></h3></li>
				<li><h3>4. Select the <span class="emphasize">type of form</span> that you want to appear</h3></li>
				<li><h3>5. <span class="emphasize">Setup your form</span></h3></li>
				<li><h3>6. Choose the intro animation</h3></li>
				<li><h3>7. Save and <span class="emphasize">Publish</span></h3></li>
				<li><h3>8. Enjoy</h3></li>
			</ul>
		</div>
	</div>
	<div class="clear"></div>