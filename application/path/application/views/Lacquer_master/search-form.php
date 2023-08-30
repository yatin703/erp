<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" method="POST" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">
									
									<tr>
										<td class="label">Lacquer<span style="color:red;">*</span>  :</td>
										<td>
										<select name="lacquer"><option value=''>--Select Lacquer Code--</option>
										<?php if($lacquer==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($lacquer as $lacquer_row){
													echo "<option value='".$lacquer_row->article_no."' ".set_select('lacquer',''.$lacquer_row->article_no.'')." >".$lacquer_row->lang_article_description." ".$lacquer_row->lang_sub_description."</option>";
												}
										}?></select></td>
									</tr>

										<tr>
										<td class="label">Sleeve Dia <span style="color:red;">*</span>  :</td>
										<td>
										<select name="sleeve_dia" id="sleeve_dia"><option value=''>--Select Sleeve Dia--</option>
										<?php if($sleeve_dia==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($sleeve_dia as $sleeve_dia_row){
												$selected=($sleeve_dia_row->sleeve_id==$row->sleeve_id ? 'selected' :'');
													echo "<option value='".$sleeve_dia_row->sleeve_id."' ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_id.'')." >".$sleeve_dia_row->sleeve_diameter."</option>";
												}
										}?></select></td>
									</tr>

									<tr>
										<td class="label">Length From <span style="color:red;">*</span> :</td>
										<td><input type="text" name="length_from" value="<?php echo set_value('length_from');?>"></td>
									</tr>

									<tr>
										<td class="label">Length To <span style="color:red;">*</span> :</td>
										<td><input type="text" name="length_to" value="<?php echo set_value('length_to');?>"></td>
									</tr>

									<tr>
										<td class="label">Comsumption Per Tube <span style="color:red;">*</span> :</td>
										<td><input type="text" name="consumption_per_tube" value="<?php echo set_value('consumption_per_tube');?>"></td>
									</tr>
									 
						</table>			
								
				</td>
							
			</tr>
		</table>
					
	</div>

	<div class="form_design">
			
		<button class="submit" name="submit">Search</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div>
</form>
