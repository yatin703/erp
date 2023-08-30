<div class="form_design">
	<form name="" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST">
	<?php foreach ($form as $row):?>
	<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
	<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
	<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
			<table class="form_table_design" >
				<tr>
					<td>
						<table class="form_table_inner" >
							<tr>
								<td class="label">Module Name <span style="color:red;">*</span> :</td>
								<td><select name="module"><option value=''>--Select Module--</option>
								<?php 
									if($modules==FALSE){
										echo "<option value=''>--Module Setup Required--</option>";
									}else{
										foreach($modules as $module_row){
											$selected=($row->module_id===$module_row->module_id ? 'selected':'');
											echo "<option value='$module_row->module_id'  $selected >$module_row->module_name</option>";
										}
									}
								?>
								</select>
								<input type="hidden" name="form_id" value="<?php echo $row->form_id;?>"></td>
							</tr>
							<tr>
								<td class="label">Parent Form Name <span style="color:red;">*</span> :</td>
								<td><select name="parent"><option value=''>--Select Parent Form--</option>
								<?php 
									if($parent==FALSE){
										echo "<option value=''>--Parent Form Setup Required--</option>";
									}else{
										foreach($parent as $parent_row){
											$selected=($row->parent_form_id===$parent_row->form_id ? 'selected':'');
											echo "<option value='$parent_row->form_id' $selected>$parent_row->form_name</option>";
										}
									}
								?>
								</select></td>
							</tr>
							<tr>
								<td class="label">Form Name <span style="color:red;">*</span> :</td>
								<td><input type="text" name="form_name" maxlength="64" size="50" value="<?php echo set_value('form_name',$row->form_name);?>" /></td>
							</tr>
							<tr>
								<td class="label">File Name <span style="color:red;">*</span> :</td>
								<td><input type="text" name="file_name" maxlength="64" size="50" value="<?php echo set_value('file_name',$row->file_name);?>" /></td>
							</tr>

							<tr>
								<td class="label">Icon <span style="color:red;">*</span> :</td>
								<td><input type="text" name="icon" maxlength="256" size="50" value="<?php echo set_value('icon',$row->icon);?>" /></td>
							</tr>

							<tr>
								<td class="label">View <span style="color:red;">*</span> :</td>
								<td><input type="checkbox" name="view" value="1"  <?php echo set_checkbox('view','1');?> <?php echo ($row->view==1 ? 'value="1" checked' : 'value="NULL"');?>/></td>
							</tr>

							<tr>
								<td class="label">New <span style="color:red;">*</span> :</td>
								<td><input type="checkbox" name="new" value="1" <?php echo set_checkbox('new','1');?> <?php echo ($row->new==1 ? 'value="1" checked' : 'value="NULL"');?>/></td>
							</tr>

							<tr>
								<td class="label">Modify <span style="color:red;">*</span> :</td>
								<td><input type="checkbox" name="modify" value="1" <?php echo set_checkbox('modify','1');?> <?php echo ($row->modify==1 ? 'value="1" checked' : 'value="NULL"');?>/></td>
							</tr>

							<tr>
								<td class="label">Delete <span style="color:red;">*</span> :</td>
								<td><input type="checkbox" name="delete" value="1" <?php echo set_checkbox('delete','1');?> <?php echo ($row->delete==1 ? 'value="1" checked' : 'value="NULL"');?>/></td>
							</tr>

							<tr>
								<td class="label">Copy <span style="color:red;">*</span> :</td>
								<td><input type="checkbox" name="copy" value="1" <?php echo set_checkbox('copy','1');?> <?php echo ($row->copy==1 ? 'value="1" checked' : 'value="NULL"');?>/></td>
							</tr>

							<tr>
								<td class="label">Dearchive <span style="color:red;">*</span> :</td>
								<td><input type="checkbox" name="dearchive" value="1" <?php echo set_checkbox('dearchive','1');?> <?php echo ($row->dearchive==1 ? 'value="1" checked' : 'value="NULL"');?>/></td>
							</tr>

							<tr>
								<td class="label">TOC <span style="color:red;">*</span> :</td>
								<td><textarea name="toc" cols="150" rows="30" <?php echo set_value('toc',$row->toc);?>><?php echo set_value('toc',$row->toc);?></textarea></td>
							</tr>



						</table>
					</td>
				</tr>
			</table>
		<button class="submit" name="submit">Update</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	<?php endforeach;?>
	</form>
</div>
				
				