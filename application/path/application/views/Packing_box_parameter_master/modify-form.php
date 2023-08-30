<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

							<?php foreach($packing_box_parameter_master as $row):?>
									<tr>
										<td class="label">Packing Box<span style="color:red;">*</span>  :</td>
										<td>
											<input type="hidden" name="pbp_id"  value="<?php echo set_value('pbp_id',$row->pbp_id);?>" />
										<select name="packing_box"><option value='<?php echo $row->article_no;?>'>--Select Packing Box--</option>
										<?php if($packing_box==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($packing_box as $packing_box_row){
													$selected=($packing_box_row->article_no==$row->article_no ? 'selected' : '');
													echo "<option value='".$packing_box_row->article_no."'  ".set_select('packing_box',''.$packing_box_row->article_no.'')." $selected>".$packing_box_row->lang_article_description." ".$packing_box_row->lang_sub_description."</option>";
												}
										}?></select></td>
									</tr>

									<tr>
										<td class="label">Type <span style="color:red;">*</span> :</td>
										<td><select name="packing_box_type" ><option value=''>--Select Packing Type--</option>
											<option value='RE' <?php echo set_select('packing_box_type','RE',$row->type=='RE' ? TRUE : FALSE);?>>RE</option>
											<option value='EX' <?php echo set_select('packing_box_type','EX',$row->type=='EX' ? TRUE : FALSE);?>>EX</option>
											<option value='NA' <?php echo set_select('packing_box_type','NA',$row->type=='NA' ? TRUE : FALSE);?>>NA</option></select></td>
									</tr>

									<tr>
										<td class="label">Ply <span style="color:red;">*</span> :</td>
										<td><input type="text" name="ply" value="<?php echo set_value('ply',$row->ply);?>"></td>
									</tr>

									<tr>
										<td class="label">Height <span style="color:red;">*</span> :</td>
										<td><input type="text" name="packing_box_height" value="<?php echo set_value('packing_box_height',$row->height);?>"></td>
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
				
