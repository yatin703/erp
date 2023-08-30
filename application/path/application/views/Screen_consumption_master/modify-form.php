<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();


		$("#consumption_quantity").blur(function(){
			
								
			if($("#consumption_quantity").val()!='' && $("#consumption_value").val()!='0'){			
				var consumption_unit_rate=	$("#consumption_value").val() / $("#consumption_quantity").val();
					consumption_unit_rate=consumption_unit_rate.toFixed(4);
					$("#consumption_unit_rate").val(consumption_unit_rate);
					
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

							<?php foreach($screen_consumption_master as $row):?>
									<tr>
										<td class="label" >Consumption Period <span style="color:red;">* (3 Months)</span> :</td>
										<td><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date',$row->from_date);?>">
										<input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date',$row->to_date);?>">
									<input type="hidden" name="scm_id" value="<?php echo $row->scm_id;?>">			
									</td>
									</tr>
									
									<tr>
										<td class="label">Print Type<span style="color:red;">*</span> :</td>
										<td>
										<?php
											$check_box="";
											foreach ($lacquer_types_master as $lacquer_types_row) {

												$check_box="<input type='checkbox' name='lacquer_type_id[]' value='".$lacquer_types_row->lacquer_type_id."'" ;
												if(!empty($this->input->post('lacquer_type_id[]'))){ 
													$check_box.= in_array($lacquer_types_row->lacquer_type_id,$this->input->post('lacquer_type_id[]'),TRUE)?"checked" :"";
												 }
												 if($lacquer_types_row->lacquer_type_id==$row->lacquer_type_id){
												 	$check_box.="checked";

												 }
												// else{ 
												// 	$check_box.="checked";
												// } 
												$check_box.=">".$lacquer_types_row->lacquer_type."</br>";
												echo $check_box;		
											}
										?>
										</td>
									</tr>
								
									<tr>
										<td class="label">Stock Consumption Value <span style="color:red;">* (From Stock Report)</span> :</td>
										<td><input type="text" name="consumption_value" id="consumption_value" value="<?php echo set_value('consumption_value',$row->consumption_value);?>"></td>
									</tr>

									<tr>
										<td class="label">Screen/Plates Consumed in Consumption Period <span style="color:red;">* (From Daily Screen/Plates Records)</span> :</td>
										<td><input type="text" name="consumption_quantity" id="consumption_quantity" value="<?php echo set_value('consumption_quantity',$row->consumption_quantity);?>"></td>
									</tr>

									<tr>
										<td class="label">Cost Per Screen/Plate <span style="color:red;">* (Automatic)</span> :</td>
										<td><input type="text" name="consumption_unit_rate" id="consumption_unit_rate" value="<?php echo set_value('consumption_unit_rate',$row->consumption_unit_rate);?>"></td>
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
				
