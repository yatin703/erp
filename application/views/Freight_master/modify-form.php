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

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

							<?php foreach($freight_master as $row):

								$customer_name='';

								$customer=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$row->customer_no);
								foreach ($customer as $key => $customer_row) {
									$customer_name=$customer_row->name1."//".$customer_row->adr_company_id."//".$customer_row->lang_property_name;
								}

								?>

									<tr>
										<td class="label">Customer <span style="color:red;">*</span> :</td>
										<td><input type="hidden" name="freight_master_id" value="<?php echo $row->freight_master_id;?>" readonly>
											<input type="text" name="customer_no" id="customer_no"  size="60" value="<?php echo set_value('customer_no',$customer_name);?>" /></td>
									</tr>
									<tr>
										<td class="label">Dia<span style="color:red;">*</span> :</td>
										<td><select name="sleeve_id" id="sleeve_id">
											<option value=''>--Select Dia--</option>
										<?php 
											if($sleeve_diameter_master==FALSE){
												echo "<option value=''>--Setup Required--</option>";
											}
											else{
												foreach($sleeve_diameter_master as $sleeve_diameter_master_row){

													$selected=($sleeve_diameter_master_row->sleeve_diameter==$row->sleeve_id?"selected":"");
													echo "<option value='".$sleeve_diameter_master_row->sleeve_diameter."'  ".set_select('sleeve_id',''.$sleeve_diameter_master_row->sleeve_diameter.'').$selected.">".$sleeve_diameter_master_row->sleeve_diameter."</option>";
												}
										}?>
										</select>
										</td>
									</tr>
									

									<tr>
										<td class="label">Cost Per Tube <span style="color:red;">* </span> :</td>
										<td><input type="number" name="cost_per_tube" id="cost_per_tube" step="any" value="<?php echo set_value('cost_per_tube',$row->cost_per_tube);?>" ></td>
									</tr>
									<tr>
										<td class="label" >Apply From <span style="color:red;">* </span> :</td>
										<td><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date',$row->apply_from_date);?>">
										<input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date',$row->apply_to_date);?>"></td>
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
				
