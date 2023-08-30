<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();


		$("#sale_of_tubes").blur(function(){
			
								
			if($("#sale_of_tubes").val()!='' && $("#other_cost_value").val()!='0'){
					
					
						var cost_per_tube=	$("#other_cost_value").val() / $("#sale_of_tubes").val();
						cost_per_tube=cost_per_tube.toFixed(4);
						//$("#cost_per_tube").val(cost_per_tube);
					
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

							<?php foreach($other_cost_master as $row):?>

									<tr>
										<td class="label">Consumption Period <span style="color:red;">* (3 Months)</span> :</td>
										<td><input type="date" name="from_date" value="<?php echo set_value('from_date',$row->from_date);?>">
											<input type="hidden" name="ocsm_id" value="<?php echo $row->ocsm_id;?>">
											<input type="date" name="to_date" value="<?php echo set_value('to_date',$row->to_date);?>"></td>
									</tr>
									<tr>
										<td class="label">Order Type  :</td>
										<td >
											<select name="order_flag">

												<option value="">--Please Select--</option>
												<option value="0" <?php echo $selected=($row->order_flag==0 ? 'selected': '' ); echo set_select('order_flag','0');?>>Coex</option>
												<option value="1" <?php echo $selected=($row->order_flag==1 ? 'selected': '' ); echo set_select('order_flag','1');?> >Spring</option>
												<option value="3" <?php echo $selected=($row->order_flag==3 ? 'selected': '' ); echo set_select('order_flag','3');?> >Both</option>
												
											</select>

										</td>
									</tr>
									<tr>
										<td class="label">Dia * :</td>
										<td><select name="sleeve_dia"><option value=''>--Select Sleeve Dia--</option>
										<?php if($sleeve_dia==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($sleeve_dia as $sleeve_dia_row){
													$selected=($sleeve_dia_row->sleeve_diameter===$row->sleeve_dia ? 'selected':'');
													echo "<option value='".$sleeve_dia_row->sleeve_diameter."'  ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_diameter.'')." $selected>".$sleeve_dia_row->sleeve_diameter."</option>";
												}
										}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">Cap Type <span style="color:red;">*</span> :</td>
										<td><select name="cap_type" id="cap_type"><option value=''>--Select Cap Type--</option>
										<?php if($cap_type==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($cap_type as $cap_type_row){
													$selected=($cap_type_row->cap_type===$row->cap_type ? 'selected':'');
													
													echo "<option value='".$cap_type_row->cap_type."' ".set_select('cap_type',''.$cap_type_row->cap_type.'')." $selected>".$cap_type_row->cap_type."</option>";
												}
										}?>
										</select></td></tr>

									<tr>
									
									<tr>
										<td class="label">Other Cost<span style="color:red;">*</span> :</td>
										<td><input type="text" name="other_cost" value="<?php echo set_value('other_cost',$row->other_cost);?>"></td>
									</tr>
									
									<tr>
										<td class="label">Other Cost Value <span style="color:red;">*</span> :</td>
										<td><input type="text" name="other_cost_value" id="other_cost_value" value="<?php echo set_value('other_cost_value',$row->other_cost_value);?>"></td>
									</tr>

									<tr>
										<td class="label">No of Tubes Sold in Consumption Period <span style="color:red;">* <a href="<?php echo base_url('index.php/sales_invoice_book');?>" target="_blank">(From Sales Register)</a></span> :</td>
										<td><input type="text" name="sale_of_tubes" id="sale_of_tubes" value="<?php echo set_value('sale_of_tubes',$row->sale_of_tubes);?>"></td>
									</tr>

									<tr>
										<td class="label">Cost Per Tube <span style="color:red;">* (Automatic)</span> :</td>
										<td><input type="text" name="cost_per_tube" id="cost_per_tube" value="<?php echo set_value('cost_per_tube',$row->cost_per_tube);?>"></td>
									</tr>

									<tr>
										<td class="label">Apply From date <span style="color:red;">* (Automatic)</span> :</td>
										<td><input type="date" name="apply_from_date"  value="<?php echo set_value('apply_from_date',$row->apply_from_date);?>"></td>
									</tr>
									<tr>
										<td class="label">Apply To date <span style="color:red;">* (Automatic)</span> :</td>
										<td><input type="date" name="apply_to_date"  value="<?php echo set_value('apply_to_date',$row->apply_to_date);?>"></td>
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
				
