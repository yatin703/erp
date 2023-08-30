<div class="form_design">
	<form name="" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" method="POST">
	<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
	<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		
			<table class="form_table_design" >
				<tr>
					<td>
						<table class="form_table_inner" >
							<tr>
								<td class="label">Module Name  :</td>
								<td><select name="module"><option value=''>--Select Module--</option>
								<?php 
									if($modules==FALSE){
										echo "<option value=''>--Module Setup Required--</option>";
									}else{
										foreach($modules as $module_row){
											echo "<option value='$module_row->module_id'  ".set_select('module',$module_row->module_id).">$module_row->module_name</option>";
										}
									}
								?>
								</select></td>
							</tr>
							<tr>
								<td class="label">Parent Form Name  :</td>
								<td><select name="parent"><option value=''>--Select Parent Form--</option>
								<?php 
									if($parent==FALSE){
										echo "<option value=''>--Parent Form Setup Required--</option>";
									}else{
										foreach($parent as $parent_row){
											echo "<option value='$parent_row->form_id'  ".set_select('parent',$parent_row->form_id).">$parent_row->form_name</option>";
										}
									}
								?>
								</select></td>
							</tr>
							<tr>
								<td class="label">Form Name :</td>
								<td><input type="text" name="form_name" maxlength="64" size="50" value="<?php echo set_value('form_name');?>" /></td>
							</tr>
							<tr>
								<td class="label">File Name :</td>
								<td><input type="text" name="file_name" maxlength="64" size="50" value="<?php echo set_value('file_name');?>" /></td>
							</tr>

							<tr>
								<td class="label">View :</td>
								<td><input type="checkbox" name="view" value="1"  <?php echo set_checkbox('view','1',TRUE);?> /></td>
							</tr>

							<tr>
								<td class="label">New :</td>
								<td><input type="checkbox" name="new" value="1" <?php echo set_checkbox('new','1');?>/></td>
							</tr>

							<tr>
								<td class="label">Modify :</td>
								<td><input type="checkbox" name="modify" value="1" <?php echo set_checkbox('modify','1');?>/></td>
							</tr>

							<tr>
								<td class="label">Delete :</td>
								<td><input type="checkbox" name="delete" value="1" <?php echo set_checkbox('delete','1');?>/></td>
							</tr>

							<tr>
								<td class="label">Copy :</td>
								<td><input type="checkbox" name="copy" value="1" <?php echo set_checkbox('copy','1');?>/></td>
							</tr>

							<tr>
								<td class="label">Dearchive :</td>
								<td><input type="checkbox" name="dearchive" value="1" <?php echo set_checkbox('dearchive','1');?>/></td>
							</tr>


						</table>
					</td>
				</tr>
			</table>
		<button class="submit" name="submit">Search</button> <a href="<?php echo base_url('index.php/form');?>">Cancel</a>
	</form>
</div>
				
