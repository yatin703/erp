<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">
									
									<tr>
										<td class="label">Purging Material<span style="color:red;">*</span>  :</td>
										<td>
										<select name="purging_material"><option value=''>--Select Purging Material--</option>
										<?php if($purging==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($purging as $purging_row){
													echo "<option value='".$purging_row->article_no."' ".set_select('purging_material',''.$purging_row->article_no.'')." >".$purging_row->lang_article_description." ".$purging_row->lang_sub_description."</option>";
												}
										}?></select></td>
									</tr>

										<tr>
										

									<tr>
										<td class="label">Percentage <span style="color:red;">*</span> :</td>
										<td><input type="text" name="purging_perc" value="<?php echo set_value('purging_perc');?>"></td>
									</tr>
									 
						</table>			
								
				</td>
							
			</tr>
		</table>
					
	</div>

	<div class="form_design">
			
		<button class="submit" name="submit">Save</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div>
</form>
