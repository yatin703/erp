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

							<?php foreach($stores_and_spares_consumption_master as $row):?>

									<tr>
										<td class="label">Consumption From Date <span style="color:red;">*</span> :</td>
										<td><input type="date" name="from_date" value="<?php echo set_value('from_date',$row->from_date);?>">
											<input type="hidden" name="sscm_id" value="<?php echo $row->sscm_id;?>"></td>
									</tr>

									<tr>
										<td class="label"> Consumption To Date <span style="color:red;">*</span> :</td>
										<td><input type="date" name="to_date" value="<?php echo set_value('to_date',$row->to_date);?>"></td>
									</tr>

									<tr>
										<td class="label">Stores And Spares Category <span style="color:red;">*</span> :</td>
										<td><select name="stores_and_spares_category_id" id="stores_and_spares_category_id"><option value=''>--Select Stores And Spares Category--</option>
										<?php 
											$selected=($row->stores_and_spares_category_id==1?'selected':'');										
											echo "<option value='1' ".($row->stores_and_spares_category_id==1?'selected':'').">Import</option>
												  <option value='0' ".($row->stores_and_spares_category_id==0?'selected':'').">Local</option>";
												
										?>
										</select></td>
									</tr>

								<!--<tr>
										<td class="label">Stores And Spares <span style="color:red;">*</span> :</td>
										<td><input type="text" name="stores_and_spares" value="<?php echo set_value('stores_and_spares',$row->stores_and_spares);?>"></td>
									</tr>
								-->

									<tr>
										<td class="label">Consumption Value <span style="color:red;">*</span> :</td>
										<td><input type="text" name="consumption_value" id="consumption_value" value="<?php echo set_value('consumption_value',$row->consumption_value);?>"></td>
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
				
