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
										<td class="label">Packing Box<span style="color:red;">*</span>  :</td>
										<td>
										<select name="packing_box"><option value=''>--Select Packing Box--</option>
										<?php if($packing_box==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($packing_box as $packing_box_row){
													echo "<option value='".$packing_box_row->article_no."' ".set_select('packing_box',''.$packing_box_row->article_no.'')." >".$packing_box_row->lang_article_description." ".$packing_box_row->lang_sub_description."</option>";
												}
										}?></select></td>
									</tr>

									<tr>
										<td class="label">Type <span style="color:red;">*</span> :</td>
										<td><select name="packing_box_type" ><option value=''>--Select Packing Type--</option>
											<option value='RE'>RE</option>
											<option value='EX'>EX</option>
											<option value='NA'>NA</option></select></td>
									</tr>

									<tr>
										<td class="label">Ply <span style="color:red;">*</span> :</td>
										<td><input type="text" name="ply" value="<?php echo set_value('ply');?>"></td>
									</tr>

									<tr>
										<td class="label">Height <span style="color:red;">*</span> :</td>
										<td><input type="text" name="packing_box_height" value="<?php echo set_value('packing_box_height');?>"></td>
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
