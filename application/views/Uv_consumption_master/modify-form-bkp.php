<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();


		$("#sale_of_tubes").blur(function(){
			
								
			if($("#sale_of_tubes").val()!='' && $("#consumption_value").val()!='0'){
					
					
						var cost_per_tube=	$("#consumption_value").val() / $("#sale_of_tubes").val();
						cost_per_tube=cost_per_tube.toFixed(4);
						$("#cost_per_tube").val(cost_per_tube);
					
			}
		});



	});
</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" enctype="multipart/form-data" autocomplete="off">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

							<?php foreach($uv_consumption_master as $row):?>
									<tr>
										<td class="label" colspan="2"> <span style="color:red;">* Note: </span> To take data of three months:</td>
										
									</tr>

									<tr>
										<td class="label">From Date <span style="color:red;">*</span> :</td>
										<td><input type="date" name="from_date" value="<?php echo set_value('from_date',$row->from_date);?>">
											<input type="hidden" name="uvc_id" value="<?php echo $row->uvc_id;?>"></td>
									</tr>

									<tr>
										<td class="label">To Date <span style="color:red;">*</span> :</td>
										<td><input type="date" name="to_date" value="<?php echo set_value('to_date',$row->to_date);?>"></td>
									</tr>
									<tr>
										<td class="label">Print Type<span style="color:red;">*</span> :</td>
										<td><select name="lacquer_type_id" id="lacquer_type_id" multiple><option value=''>----Select Print Type----</option>
										<?php if($lacquer_types_master==FALSE){
														echo "<option value=''>--Setup Required--</option>";
												}
											else{
												foreach($lacquer_types_master as $lacquer_types_master_row){
														$selected=($lacquer_types_master_row->lacquer_type_id==$row->lacquer_type_id?'selected':'');
													echo "<option value='".$lacquer_types_master_row->lacquer_type_id."'  ".set_select('lacquer_type_id',''.$lacquer_types_master_row->lacquer_type_id.'').$selected.">".$lacquer_types_master_row->lacquer_type."</option>";
												}
										}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">RM <span style="color:red;">*</span> :</td>
										<td><input type="text" name="rm" value="<?php echo set_value('rm',$row->rm);?>"></td>
									</tr>

									<tr>
										<td class="label">Consumption Value <span style="color:red;">*</span> :</td>
										<td><input type="text" name="consumption_value"  id="consumption_value" value="<?php echo set_value('consumption_value',$row->consumption_value);?>"></td>
									</tr>

									<tr>
										<td class="label">Sale Of Tubes <span style="color:red;">*</span> :</td>
										<td><input type="text" name="sale_of_tubes" id="sale_of_tubes" value="<?php echo set_value('sale_of_tubes',$row->sale_of_tubes);?>"></td>
									</tr>

									<tr>
										<td class="label">Cost Per Tube <span style="color:red;">*</span> :</td>
										<td><input type="text" name="cost_per_tube" id="cost_per_tube" value="<?php echo set_value('cost_per_tube',$row->cost_per_tube);?>"></td>
									</tr>
								<!--<tr>
										<td class="label">Apply From date <span style="color:red;">*</span> :</td>
										<td><input type="date" name="apply_from_date" value="<?php echo set_value('apply_from_date',$row->apply_from_date);?>"></td>
									</tr>

									<tr>
										<td class="label">Apply To date <span style="color:red;">*</span> :</td>
										<td><input type="date" name="apply_to_date" value="<?php echo set_value('apply_to_date',$row->apply_to_date);?>"></td>
									</tr>
								-->
									
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
				
