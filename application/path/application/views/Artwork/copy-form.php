<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		
		$("#customer").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});

		
		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});

		$("#article_no").live('keyup',function() {
   var article_no = $('#article_no').val();
   $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
   $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/version_no",data: {article_no : $('#article_no').val()},cache: false,success: function(html){
    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#version_no").html(html);
    } 
    });
   });
   

				var counter_hot_foil=0;

    var x = document.getElementsByName("hot_foil[]");

    var counter_hot_foil=x.length+1;
    $("#add_1").live('click',function () {
    	var newtr = $(document.createElement('tr')).attr("id", 'hot_foil_'+counter_hot_foil);
    	 newtr.html('<td>Hot Foil '+counter_hot_foil+' <input type="hidden" name="hot_foil[]" value="'+counter_hot_foil+'"/></td><td><input type="text" name="hot_foil_'+counter_hot_foil+'" id="hot_foil_'+counter_hot_foil+'" value="<?php echo set_value('hot_foil_"+counter_hot_foil+"');?>" /></td>');
    	 var lastcounter_hot_foil=counter_hot_foil-1;
    	 newtr.insertAfter("#hot_foil_"+lastcounter_hot_foil);
    	 counter_hot_foil++;
    });

    $("#remove_1").click(function(){
      if(counter_hot_foil==2){ alert("No more textbox to remove"); return false;}
         counter_hot_foil--;
          $("#hot_foil_" + counter_hot_foil).remove();
     });


    var counter_lacquer_type=0;

    var x = document.getElementsByName("lacquer_type[]");

    var counter_lacquer_type=x.length+1;
    $("#add_2").live('click',function () {
    	var newtr = $(document.createElement('tr')).attr("id", 'lacquer_type_'+counter_lacquer_type);
    	 newtr.html('<td>Lacquer Type '+counter_lacquer_type+' <input type="hidden" name="lacquer_type[]" value="'+counter_lacquer_type+'"/></td><td><input type="text" name="lacquer_type_'+counter_lacquer_type+'" id="lacquer_type_'+counter_lacquer_type+'" value="<?php echo set_value('lacquer_type_"+counter_lacquer_type+"');?>" /></td>');
    	 var lastcounter_lacquer_type=counter_lacquer_type-1;
    	 newtr.insertAfter("#lacquer_type_"+lastcounter_lacquer_type);
    	 counter_lacquer_type++;
    });

    $("#remove_2").click(function(){
      if(counter_lacquer_type==2){ alert("No more textbox to remove"); return false;}
         counter_lacquer_type--;
          $("#lacquer_type_" + counter_lacquer_type).remove();
     });

	});
</script>
<?php foreach($artwork as $artwork_row):?>
	<?php
        $result_dia=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','1');

        foreach($result_dia as $dia_row){ $dia=$dia_row->parameter_value; }

        $result_length=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','2');

        foreach($result_length as $length_row){ $length=$length_row->parameter_value; }

        $result_sleeve_color=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','7');

        foreach($result_sleeve_color as $sleeve_color_row){ $sleeve_color=$sleeve_color_row->parameter_value; }

        $result_print_type=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','17');

        foreach($result_print_type as $print_type_row){ $print_ty=$print_type_row->parameter_value; }

       $result_printing_upto_neck=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','8');

        foreach($result_printing_upto_neck as $printing_upto_neck_row){ $printing_upto_neck=$printing_upto_neck_row->parameter_value; }

        $result_hot_foil=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','11');

        foreach($result_hot_foil as $hot_foil_row){ $hot_foil=$hot_foil_row->parameter_value; }

        $result_lacquer_type=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','12');

        foreach($result_lacquer_type as $lacquer_row){ $lacquer=$lacquer_row->parameter_value;}

        $result_sealing=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','5');

        foreach($result_sealing as $sealing_row){ $sealing=$sealing_row->parameter_value; }
    ?>
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_copy');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

									<tr>
										<td class="label">Artwork No * :</td>
										<td><input type="text" name="artwork_no" size="10" value="<?php echo set_value('artwork_no',$artwork_row->ad_id);?>" readonly/></td>
									</tr>

									<tr>
										<td class="label">Customer * :</td>
										<td><input type="text" name="customer" id="customer"  size="60" value="<?php echo set_value('customer',$artwork_row->customer_name."//".$artwork_row->adr_company_id);?>" /></td>
									</tr>

									<tr>
										<td class="label">Article  * :</td>
										<td><input type="text" name="article_no" id="article_no"  size="60" value="<?php echo set_value('article_no',$artwork_row->article_name."//".$artwork_row->article_no);?>"  /></td>
									</tr>

									<tr>
										<td class="label">Version No * :</td>
										<td><select id="version_no" name="version_no" readonly>
											<?php
											$data['version']=$this->artwork_model->select_artwork_verion_no('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$artwork_row->article_no);
              foreach ($data['version'] as $version_row) {

                if($version_row->version_no==NULL){
                		$version_no=1;
                }else{
                  $version_no=$version_row->version_no;
                }
              }
											?>
											<option value="<?php echo $version_no;?>"><?php echo $version_no;?></option>

										</select>
										<?php 
										if($this->input->post('copy_version_no')){
											echo '<input type="hidden" name="copy_version_no" value="'.$this->input->post('copy_version_no').'">';

										}else{
											echo '<input type="hidden" name="copy_version_no" value="'.$this->uri->segment(4).'">';
										}?>
										</td>
									</tr>
									
									<tr>
										<td class="label">Dia * :</td>
										<td><select name="sleeve_dia"><option value=''>--Select Sleeve Dia--</option>
										<?php if($sleeve_dia==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($sleeve_dia as $sleeve_dia_row){
													$selected=($sleeve_dia_row->sleeve_diameter==$dia ? 'selected' :'');
													echo "<option value='".$sleeve_dia_row->sleeve_diameter."' $selected ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_diameter.'').">".$sleeve_dia_row->sleeve_diameter."</option>";
												}
										}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">Length * :</td>
										<td><input type="text" name="sleeve_length" size="10" value="<?php echo set_value('sleeve_length',$length);?>"></td>
									</tr>

									<tr>
										<td class="label">Sleeve Color * :</td>
										<td><input type="text" name="sleeve_color" value="<?php echo set_value('sleeve_color',$sleeve_color);?>"></td>
									</tr>

									<tr>
										<td class="label">Print Type * :</td>
										<td><select name="print_type"><option value=''>--Select Print Type--</option>
										<?php if($print_type==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($print_type as $print_type_row){
													$selected=($print_type_row->lacquer_type==$print_ty ? 'selected' :'');
													echo "<option value='".$print_type_row->lacquer_type."'  $selected ".set_select('print_type',''.$print_type_row->lacquer_type.'').">".$print_type_row->lacquer_type."</option>";
												}
										}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">Printing upto neck * :</td>
										<td><select name="printing_upto_neck"><option value="">--Select--</option>
											<option value="YES" <?php echo  set_select('printing_upto_neck', 'YES' ,$printing_upto_neck==="YES" ? TRUE : FALSE); ?>>YES</option>
											<option value="NO" <?php echo  set_select('printing_upto_neck', 'NO', $printing_upto_neck==="NO" ? TRUE : FALSE); ?>>NO</option>
										</select></td>
									</tr>

									<tr>
											<td></td>
											<td><input type="button" id="add_1" value="Add"><input type="button" id="remove_1" value="Remove"></td>
									</tr>
									<?php if($this->input->post('hot_foil')){
										for($i=1;$i<=count($this->input->post('hot_foil'));$i++){
											?>
											<tr id="hot_foil_<?php echo $i;?>">
												<td class="label">Hot Foil <?php echo $i;?> * :<input type="hidden" name="hot_foil[]" value="<?php echo $i;?>" /></td>
												<td><input type="text" name="hot_foil_<?php echo $i;?>" value="<?php echo set_value('hot_foil_'.$i.'');?>"></td>
											</tr>
											<?php
										}

										}else{
											$hot_foil_count=substr($hot_foil, 0, strpos($hot_foil, '|'));
											$hot_foils=substr($hot_foil, strpos($hot_foil, "||") + 2);
											for($i=1;$i<=$hot_foil_count;$i++){
												$p=$i-1;
												$hot_foil_arr=explode("^",$hot_foils);
											?>

									<tr id="hot_foil_<?php echo $i;?>">
										<td class="label">Hot Foil <?php echo $i;?> * :<input type="hidden" name="hot_foil[]" value="<?php echo $i;?>" /></td>
										<td><input type="text" name="hot_foil_<?php echo $i;?>" value="<?php echo set_value('hot_foil_'.$i.'',$hot_foil_arr[$p]);?>"></td>
									</tr>

									<?php 
										}
									} ?>

									

									<tr>
										<td class="label">Sealing Non Lacquring Area * :</td>
										<td><input type="text" name="sealing_non_lacquering_area" value="<?php echo set_value('sealing_non_lacquering_area',$sealing);?>"></td>
									</tr>

									<tr>
											<td></td>
											<td><input type="button" id="add_2" value="Add"><input type="button" id="remove_2" value="Remove"></td>
									</tr>

									<?php if($this->input->post('lacquer_type')){
										for($i=1;$i<=count($this->input->post('lacquer_type'));$i++){
											?>
											<tr id="lacquer_type_<?php echo $i;?>">
												<td class="label">Lacquer Type <?php echo $i;?> * :<input type="hidden" name="lacquer_type[]" value="<?php echo $i;?>" /></td>
												<td><input type="text" name="lacquer_type_<?php echo $i;?>" value="<?php echo set_value('lacquer_type_'.$i.'');?>"></td>
											</tr>
											<?php
										}

										}else{
											$lacquer_count=substr($lacquer, 0, strpos($lacquer, '|'));
											$lacquers=substr($lacquer, strpos($lacquer, "||") + 2);
											for($i=1;$i<=$lacquer_count;$i++){
												$p=$i-1;
												$lacquer_arr=explode("^",$lacquers);
											?>

									<tr id="lacquer_type_<?php echo $i;?>">
										<td class="label">Lacquer Type <?php echo $i;?> * :<input type="hidden" name="lacquer_type[]" value="<?php echo $i;?>"/></td>
										<td><input type="text" name="lacquer_type_<?php echo $i;?>" value="<?php echo set_value('lacquer_type_'.$i.'',$lacquer_arr[$p]);?>"></td>
									</tr>
									<?php 
									}
									} ?>
									
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
				
				
				
				
				
			