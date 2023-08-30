<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script type="text/javascript">
	$(document).ready(function(){

		$("#loading").hide(); $("#cover").hide();


		$(".ink").each(function(i){		  
		 $(this).autocomplete("<?php echo base_url('index.php/ajax_coextube/coextube_direct_ink_autocomplete');?>", {selectFirst: true});
		});
		
   		$("#add").click(function(e){   			
		 	var counter= $('#tablePanton tr').length;
		 	//alert(counter);	 	
			var markup = '<tr id="'+ counter +'"><td><input type="hidden" name="sr_no[]" value="'+ counter +'">INK '+ counter+'</td><td><input class="ink" type="text" name="inks[]" id="inks[]" maxlength="200" size="60" placeholder="Ink Name" required/ style="width: 100%;"><td><input type="number" name="quantity[]" min="1" max="100000" step="any"/ style="width: 100%;"></td></tr>';
			$("#tablePanton").append(markup);

			$(".ink").each(function(i){		  
		 	$(this).autocomplete("<?php echo base_url('index.php/ajax_coextube/coextube_direct_ink_autocomplete');?>", {selectFirst: true});
			});
		});

   		$("#remove").click(function(e){

   			var flag=0;
								
			$("#tablePanton").find('input[name="record"]').each(function(){

				var tr_number=$(this).parents("tr").attr('id');
				if(tr_number>1){
					if($(this).is(":checked")){
						$(this).parents("tr").remove();
					}
					
				}
				else{
					alert('Please enter atleast one record.');	
				}
													
				// if($('#tablePanton tr').length>2){
				// 	if($(this).is(":checked")){
				// 		if(confirm('Confirm delete!')){
				// 			$(this).parents("tr").remove();
				// 		}
				// 	}
				// }
				// else{
				// alert('Please enter atleast one record.');	
					
				// }
			});	
			
				
		});

		//VALIDATION STARTS--------------------------------------------------------
		

        $("#btnsubmit").click(function(e){

			if($("#master_ink").val()==""){
				alert('Select the Ink Name.');
				$("#master_ink").focus();
				return false;
			}					
			
			var flag_ink=1;
			$("#tablePanton").find('input[name="inks[]"]').each(function(){
				
				if ($(this).val()==''){
					flag_ink=0;
				}
								
			});

			var flag_quantity=1;
			$("#tablePanton").find('input[name="quantity[]"]').each(function(){
				
				if ($(this).val()==''){
					flag_quantity=0;
				}
								
			});

			
			if(flag_ink==0 || flag_quantity==0){
				alert('Enter the all Ink details');
				return false;

			}

			return true;


         });

	});
</script>
<style type="text/css">
	table.middle_form_table_design {
    margin-bottom: 10px;
    width: 60%;
    border-collapse: collapse;
}
</style>
<?php foreach ($coextube_ink_mixing_master as $coextube_ink_mixing_master_row):?>
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST"  >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>

		<input type="hidden" name="mixing_id" value="<?php echo set_value('mixing_id',$coextube_ink_mixing_master_row->mixing_id );?>" />

		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">
						<tr>
							<td class="label">Substrate<span style="color:red;">*</span> :</td>
							<td><select name="substrate" id="substrate" required><option value=''>--Select Substrate--</option>
							<?php   if($coextube_color_master==FALSE){
										echo"<option value=''>--Setup Required--</option>";

									}else{
									foreach($coextube_color_master as $coextube_color_master_row){
										$selected=($coextube_color_master_row->color_name==$coextube_ink_mixing_master_row->substrate ?'selected':'');
										echo "<option value='".$coextube_color_master_row->color_name."'  ".set_select('substrate',''.$coextube_color_master_row->color_name.'').$selected.">".$coextube_color_master_row->color_name."</option>";
									}
							}?>
							</select></td>
						</tr>

						<tr>
					
							<td class="label">Pantone Code <span style="color:red;">*</span> :</td>
							<td><input type="text" name="master_ink" id="master_ink" maxlength="200" size="30" value="<?php echo set_value('master_ink',$coextube_ink_mixing_master_row->pantone_code);?>" placeholder="Pantone Code" required >
							</td>
							</td>
						</tr> 
											
					</table>	
				</td>							
			</tr>
		</table>

		</br>
		</br>

		<div class="middle_form_design">
			
						
				<div class="ui buttons">
				<input type="button" value="Remove" id="remove" class="ui button">
				<div class="or"></div>
				<input type="button" value="Add" id="add" class="ui positive button">
				</div>		

				</br>
				</br>
				
				<table class="middle_form_table_design" id="tablePanton">

					<tr>
						<!-- <th>Select</th> -->
						<th>Ink No.</th>
						<th>Ink Name</th>
						<th>Quantity (Grams)</th>										
					</tr>								

					<?php

						if(!empty($this->input->post('sr_no[]'))){

							$j=1;
							for($i=0;$i<count($this->input->post('sr_no[]'));$i++)	{?>

								<script>
									$(document).ready(function(){

									$("#loading").hide(); $("#cover").hide();

									$(".ink").each(function(i){

										$(this).autocomplete("<?php echo base_url('index.php/ajax_coextube/coextube_direct_ink_autocomplete');?>", {selectFirst: true});
										});

									});
								</script>

							<?php echo'<tr id="'.$j++.'">
									<!--<td><input type="checkbox" name="record"></td>-->
									<td><input type="hidden" name="sr_no[]" value="<?php echo $i;?>"/>INK <?php echo $i;?></td>
									<td><input type="text" name="inks[]" id="inks[]" maxlength="200" size="60" value="'.set_value('inks[]').'" placeholder="Ink Name" required style="width: 100%;">
									</td> 
									<td><input type="number" name="quantity[]" value="'.set_value('quantity[]').'" min="1" max="100000" step="any" style="width: 100%;"></td></tr>';

							}
							
						} 
						else{

							$data=array('mixing_id'=>$coextube_ink_mixing_master_row->mixing_id);

							$result_coextube_ink_mixing_details=$this->coextube_ink_mixing_model->active_details_records('coextube_ink_mixing_details',$data,$this->session->userdata['logged_in']['company_id']);

							$j=1;

							foreach($result_coextube_ink_mixing_details as $details_row ){

								$article_name=$this->common_model->get_article_name($details_row->ink_name,$this->session->userdata['logged_in']['company_id']);

								echo'<tr id="'.$j++.'">
								<!--<td><input type="checkbox" name="record"></td>-->
								<td><input type="hidden" name="sr_no[]" value="'.$details_row->ink_seq_no.'">INK '.$details_row->ink_seq_no.'</td>
								<td><input type="text" name="inks[]" id="inks[]" maxlength="200" size="60" value="'.set_value('inks[]',$article_name.'//'.$details_row->ink_name).'" placeholder="Ink Name" required style="width: 100%;">
								</td> 
								<td><input type="number" name="quantity[]" value="'.set_value('quantity[]',$details_row->quantity).'" min="1" max="100000" step="any"/ style="width: 100%;"></td>
								</tr>';
							}	
							
						}							
						

					?>

				</table>				
			
		
</div>
<div class="middle_form_design">

	
		<div class="ui buttons">
		  <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
		  <div class="or"></div>
		  <button class="ui positive button" id="btnsubmit" >Update</button>
		<!-- <input type="submit" class="ui positive button" value="Save"/>-->
		</div>
	

</div>
		
</form>
<?php endforeach;?>	

		
				
				
				
				
			