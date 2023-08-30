<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

							<?php foreach($purging_perc_master as $row):?>

									<tr>
										<td class="label">Purging Material <span style="color:red;">* </span> :</td>
										<td><input type="hidden" name="ppm_id" value='<?php echo $row->ppm_id;?>'>
											<select name="purging_material"><option value=''>--Select Purging Material--</option>
										<?php
										foreach ($purging as $purging_row) {
											$selected=($purging_row->article_no==$row->article_no ? 'selected' :'');
											echo "<option value='".$purging_row->article_no."' ".set_select('purging_material',$purging_row->article_no)." $selected>".$purging_row->lang_article_description."</option>";
										}
										?>
										</select>
										</td>
									</tr>
									<tr>
										<td class="label">Percentage <span style="color:red;">*</span> :</td>
										<td><input type="text" name="purging_perc" value="<?php echo set_value('purging_perc',$this->common_model->read_number($row->purging_perc,$this->session->userdata['logged_in']['company_id']));?>"></td>
									</tr>
									
							<?php endforeach;?>		

					</table>			
								
				</td>
							
			</tr>
		</table>
					
	</div>

	<div class="form_design">
			
		<button class="submit" name="submit">Update</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div>
		
</form>
				
