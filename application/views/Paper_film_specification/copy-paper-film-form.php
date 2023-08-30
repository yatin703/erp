<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
	   $("#loading").hide();
		$("#cover").hide();

		$("#sub_group").change(function(event) {
	   var main_group = $('#main_group').val();
	   var sub_group = $('#sub_group').val();
	   // alert(main_group);
	   //alert(sub_group);
	   $("#loading").show();
				$("#cover").show();
				$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/sub_group_article",data: {sub_group : $('#sub_group').val(),main_group : $('#main_group').val()},cache: false,success: function(html){
	    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       $("#article_no").html(html);
	    } 
	    });
	   });
   });
</script>

<?php foreach($specification as $specification_row):?>


<?php
$result_paper_film_dia=$this->paper_film_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','1_1','srd_id','asc');

	foreach($result_paper_film_dia as $paper_film_dia_row){ $paper_film_dias=$paper_film_dia_row->relating_master_value;}

$result_paper_film_total_thickness=$this->paper_film_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','1_4','srd_id','asc');

	foreach($result_paper_film_total_thickness as $paper_film_total_thickness_row){ $shoulder_mb=$paper_film_total_thickness_row->mat_article_no; $paper_film_total_thickness=$paper_film_total_thickness_row->parameter_value;}

$result_paper_film_total_width=$this->paper_film_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','1_4','srd_id','asc');

	foreach($result_paper_film_total_width as $paper_film_total_width_row){ $shoulder_mb=$paper_film_total_width_row->mat_article_no; $paper_film_width=$paper_film_total_width_row->parameter_value;}

$result_paper_film_layer_no=$this->paper_film_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','1_6_1','srd_id','asc');

	foreach($result_paper_film_layer_no as $paper_film_layer_no_row){ $shoulder_mb=$paper_film_layer_no_row->mat_article_no; $paper_film_layer_no=$paper_film_layer_no_row->parameter_value;}

?>


<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_paper_film');?>" method="POST" >


	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">

								<input type="hidden" name="spec_id"  value="<?php echo set_value('spec_id',$specification_row->spec_id);?>" readonly/>


								<input type="hidden" name="record_no" value="<?php echo $specification_row->spec_id.'@@@'.$specification_row->spec_version_no;?>">

								<input type="hidden" name="spec_version_no"  value="<?php echo set_value('spec_version_no',$specification_row->spec_version_no);?>" readonly/>

                           <input type="hidden" id="main_group" value="1">

									<tr>
										<td class="label">Main Group * :</td>
										<td>
											<select name="sub_group" id="sub_group" style="width: 100%;">
												<option value=''>--Select Group--</option>
									         <option value='340'>PE PAPER</option>
							            </select>
							         </td>
									</tr>

										<tr>
										<td class="label">Paper Film No * :</td>
										<td><select name="article_no" id="article_no" >
										<?php if($this->input->post('article_no')){
											echo '<option value="'.$this->input->post('article_no').'">'.$this->input->post('article_no').'</option>';
										}else{
											echo '<option value="">--Select Article Code--</option>';
										}?>
														
										</select></td>
									</tr>

									<tr>
										<td class="label">Dia <span style="color:red;">*</span> :</td>
										<td><select name="sleeve_dia" id="sleeve_dia" style="width: 100%;"><option value=''>--Select Dia--</option>
										<?php if($sleeve_dia==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($sleeve_dia as $sleeve_dia_row){
													$selected=($sleeve_dia_row->sleeve_diameter==$paper_film_dias ? 'selected' : '');
													echo "<option value='".$sleeve_dia_row->sleeve_diameter."' $selected ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_diameter.'').">".$sleeve_dia_row->sleeve_diameter."</option>";
												}
										}?></select></td>
									</tr>

									<tr>
										<td class="label">Total Thickness<span style="color:red;">*</span> :</td>
										<td><input type="text" name="pf_thickness" id="pf_thickness"  value="<?php echo set_value('pf_thickness',$paper_film_total_thickness);?>" style="width: 100%;"></td>
									</tr>

									<?php
										$paper_film_purchase = $this->paper_film_specification_model->paper_film_active_record_search($specification_row->article_no);
										foreach($paper_film_purchase as $pf_purchase)
										$purchase  = $pf_purchase->lang_article_description;
									?>

									<tr>
										<td class="label">Layer <span style="color:red;">*</span> :</td>
										<td><select name="layer_no" id="layer_no" style="width: 100%;"><option value=''>--Select Layer--</option>
										<option value='1'  <?php if($paper_film_layer_no == '1') echo "selected"; ?> <?php set_select('layer_no','1') ?> >1 Layer</option>
										<option value='2' <?php if($paper_film_layer_no == '2') echo "selected"; ?> <?php set_select('layer_no','2') ?>>2 Layer</option>
										<option value='3' <?php if($paper_film_layer_no == '3') echo "selected"; ?> <?php set_select('layer_no','3') ?>>3 Layer</option>
										<option value='4' <?php if($paper_film_layer_no == '4') echo "selected"; ?> <?php set_select('layer_no','4') ?>>4 Layer</option>
										<option value='5' <?php if($paper_film_layer_no == '5') echo "selected"; ?> <?php set_select('layer_no','5') ?>>5 Layer</option>
										<option value='6' <?php if($paper_film_layer_no == '6') echo "selected"; ?> <?php set_select('layer_no','6') ?>>6 Layer</option>
										<option value='7' <?php if($paper_film_layer_no == '7') echo "selected"; ?> <?php set_select('layer_no','7') ?>>7 Layer</option>
										</select></td>
									</tr>

									<tr>
										<td class="label">Width<span style="color:red;">*</span> :</td>
										<td><input type="text" name="pf_width" id="pf_width"  value="<?php echo set_value('pf_width',$paper_film_width);?>" style="width: 100%;">
										</td>
									</tr>

									<tr>
										<td class="label">Paper Film Name (Purchase)<span style="color:red;">*</span> :</td>
										<td><input type="text" name="pf_purchase" id="pf_purchase" value="<?php echo set_value('pf_purchase',$purchase);?>" style="width: 100%;"></td>
									</tr>

									<tr>
										<td class="label">Approval Authority :</td>
										<td><select name="approval_authority">
											<option value=''>--Select Authority--</option>
											<?php 
												foreach ($approval_authority as $approval_authority_row) {
												echo "<option value='".$approval_authority_row->employee_id."' ".set_select('approval_authority',$approval_authority_row->employee_id).">".strtoupper($approval_authority_row->username)."</option>";
												}
											?>
										</select></td>
									</tr>

									</table>
							</td>
							<td>
								<table>
									<tr>
										
									</tr>
								</table>	
							</td>
						</tr>
			</table>
				
			

	</div>

	<div class="form_design">
		<div class="ui buttons">
	  <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  <div class="or"></div>
	  <button class="ui positive button">Save Copy</button>
		</div>
	</div>
		
</form>
<?php endforeach;?>
				
				
				
				
				
			