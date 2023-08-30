<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

							<?php foreach($lacquer_consumption_master as $row):?>

									<tr>
										<td class="label">Lacquer <span style="color:red;">* </span> :</td>
										<td><input type="hidden" name="lcm_id" value='<?php echo $row->lcm_id;?>'>
											<select name="lacquer"><option value=''>--Select Lacquer--</option>
										<?php
										foreach ($lacquer as $lacquer_row) {
											$selected=($lacquer_row->article_no==$row->article_no ? 'selected' :'');
											echo "<option value='".$lacquer_row->article_no."' ".set_select('lacquer',$lacquer_row->article_no)." $selected>".$lacquer_row->lang_article_description."</option>";
										}
										?>
										</select>
										</td>
									</tr>

									<tr>
										<td class="label">Sleeve Diameter <span style="color:red;">* </span> :</td>
										<td>
											<select name="sleeve_dia" id="sleeve_dia"><option value=''>--Select Sleeve Dia--</option>
										<?php if($sleeve_dia==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($sleeve_dia as $sleeve_dia_row){
												$selected=($sleeve_dia_row->sleeve_id==$row->sleeve_id ? 'selected' :'');
													echo "<option value='".$sleeve_dia_row->sleeve_id."' ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_id.'')." $selected >".$sleeve_dia_row->sleeve_diameter."</option>";
												}
										}?></select>
										</td>
									</tr>

									<tr>
										<td class="label">Length From <span style="color:red;">*</span> :</td>
										<td><input type="text" name="length_from" value="<?php echo set_value('length_from',$row->length_from);?>"></td>
									</tr>

									<tr>
										<td class="label">Length To <span style="color:red;">*</span> :</td>
										<td><input type="text" name="length_to" value="<?php echo set_value('length_to',$row->length_to);?>"></td>
									</tr>

									<tr>
										<td class="label">Comsumption Per Tube <span style="color:red;">*</span> :</td>
										<td><input type="text" name="consumption_per_tube" value="<?php echo set_value('consumption_per_tube',$row->consumption_per_tube);?>"></td>
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
				
