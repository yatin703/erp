<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#release_to_order_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/spring_open_so_no');?>", {selectFirst: true});
		
		$("#tr_release_to_order_no").hide();
		$("#td_release_order").hide();

		if($("#release_to_order_no_1").val()!=''){

			$("#tr_release_to_order_no").show();
			$("#td_release_order").show();

			$.ajax({

				   	type: "POST",
				   	url: "<?php echo base_url();?>/index.php/ajax_springtube/spsm_spsp_no",
				   	data: {order_no : $('#release_to_order_no').val()},
				   	cache: false,
				   	success: function(html){
				    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				    		//alert(html);
				    	//if(html!=''){
				    		//$("#release_to_order_no_1").val(release_to_order_no);
				    		$("#release_article_no").html('');
				    		$("#release_article_no").html(html);
				    		for (var i = 2; i <= 8; i++) {
					   			$("#tr_"+i).remove();
					   		}
				    	//}			    		
		 
				    },
					beforeSend: function(){
									$("#loading").show();
									$("#cover").show();
									$('#loading').html('<img src="images/loading.gif"> Loading...');	
									
					},
					complete: function(){
					 				$("#loading").hide(); $("#cover").hide();
									
									
					} 
			    });//AJAX Closed
		}



		$("#release_to").change(function(){

			if($('#release_to').val()=='1'){

				$("#tr_release_to_order_no").show();
				$("#release_to_order_no").attr("readonly",false);

				var order_no=$('#order_no').val();
				var result=order_no.indexOf("ST");
				//alert(result);
				// For Stock SO
				if(result<0){
					$("#td_release_order").hide();
					$("#release_to_order_no").val($('#order_no').val());
					$("#release_to_order_no").attr("readonly",true);

				}else{
					$("#release_to_order_no").val('');
					$("#release_to_order_no").attr("readonly",false);
				}			  
		        

			}else{
				$("#tr_release_to_order_no").hide();
			}
			

		});

		$("#release_reels").keyup(function(){
			
			if($("#release_reels").val()!=''){
			
				var release_reels=parseInt($("#release_reels").val());
				
				var reel_length=<?php echo $this->config->item('springtube_reel_length');?>;
				$("#release_meters").val(reel_length*release_reels);
			}else{
				$("#release_meters").val('');
			}
		});

				
		$("#release_meters").blur(function(){
			
			if($("#release_meters").val()!='' || $("#release_meters").val()!='0'){
				
				if(parseInt($("#release_meters").val()) > parseInt($("#total_ok_meters").val())){

					alert('Release meter must be less than or equal to Total Ok meters');
					$("#release_meters").val('');
					$("#release_meters").focus();
				}
				
			}
		});

		$("#release_to_order_no").bind('blur',function() {
			var release_to_order_no = $('#release_to_order_no').val();
			//alert(release_to_order_no);
			if(release_to_order_no.length>=13){

				$("#td_release_order").show();				
				   	
			    $.ajax({

				   	type: "POST",
				   	url: "<?php echo base_url();?>/index.php/ajax_springtube/spsm_spsp_no",
				   	data: {order_no : $('#release_to_order_no').val()},
				   	cache: false,
				   	success: function(html){
				    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				    		//alert(html);
				    	//if(html!=''){
				    		$("#release_to_order_no_1").val(release_to_order_no);
				    		$("#release_article_no").html('');
				    		$("#release_article_no").html(html);
				    		for (var i = 2; i <= 8; i++) {
					   			$("#tr_"+i).remove();
					   		}
				    	//}			    		
		 
				    },
					beforeSend: function(){
									$("#loading").show();
									$("#cover").show();
									$('#loading').html('<img src="images/loading.gif"> Loading...');	
									
					},
					complete: function(){
					 				$("#loading").hide(); $("#cover").hide();
									
									
					} 
			    });//AJAX Closed

		   }

   		});


		$("#release_article_no").bind('change',function() {
			var release_to_order_no = $('#release_to_order_no_1').val();
			//alert(release_to_order_no);
			var release_article_no=$("#release_article_no").val();
			
			if(release_article_no!=''){
			//alert(release_article_no);			
				   	
			   $.ajax({

				   	type: "POST",
				   	url: "<?php echo base_url();?>/index.php/ajax_springtube/get_order_details_for_extrusion_wip_issue",
				   	data: {order_no : release_to_order_no, article_no : release_article_no},
				   	cache: false,	
				   	success: function(html){
				    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				    	
				    if(html!=''){
				    	
				    	$("#tbl_release_order").append(html);

				    }			    		
		 
				    },
					beforeSend: function(){
									$("#loading").show();
									$("#cover").show();
									$('#loading').html('<img src="images/loading.gif"> Loading...');	
									
					},
					complete: function(){
					 				$("#loading").hide(); $("#cover").hide();
									
									
					} 
			    });//AJAX Closed

		   }else{

		   		for (var i = 2; i <= 8; i++) {
		   			$("#tr_"+i).remove();
		   		}

		   }

   		});






	});//Jquery closed

</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/wip_release_save');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<table class="form_table_design">
			<tr>
				<td width="55%">
					<table class="form_table_inner">

						<?php 
							//print_r($springtube_extrusion_wip_master);
						foreach($springtube_extrusion_wip_master as $row){
							$order_no='';
							$article_no='';
							$bom_no='';
							$bom_version_no='';
							$ad_id='';
							$version_no='';
							$default_reel_length='';

							$production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $row->jobcard_no);
  
		                    foreach($production_master_result as $production_master_row) {
		                      $order_no=$production_master_row->sales_ord_no;
		                      $article_no=$production_master_row->article_no;
		                      $default_reel_length=$production_master_row->reel_length;
		                    }

							$data_order_details=array(
		                    'order_no'=>$order_no,
		                    'article_no'=>$article_no
		                    );

		                    $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
		                    foreach($order_details_result as $order_details_row){
		                      $bom_no=$order_details_row->spec_id;
		                      $bom_version_no=$order_details_row->spec_version_no;
		                      $ad_id=$order_details_row->ad_id;
		                      $version_no=$order_details_row->version_no;
		                    }
		                    // BOM Details---------
		                    $data=array('bom_no'=>$bom_no,'bom_version_no'=>$bom_version_no);

		                    $bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

		                    foreach ($bill_of_material_result as $bill_of_material_row) {
		                      $bom_id=$bill_of_material_row->bom_id;
		                      $film_code=$bill_of_material_row->sleeve_code;
		                       
		                    }
		                    //SLEEVE---------------------------------
						    $film_spec_id='';
						    $film_spec_version='';

						    $film_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$film_code);

						    foreach($film_code_result as $film_code_row){                   
						      $film_spec_id=$film_code_row->spec_id;
						      $film_spec_version=$film_code_row->spec_version_no;
						    }

						    $specs['spec_id']=$film_spec_id;
						    $specs['spec_version_no']=$film_spec_version;

						    $specs_result=$this->sales_order_book_model->select_film_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
						      
						    if($specs_result){

						      $total_microns=0;
						      foreach($specs_result as $specs_row){
						        $sleeve_diameter=$specs_row->SLEEVE_DIA;
						        $sleeve_length=$specs_row->SLEEVE_LENGTH;
						        // Layer 1
						        $micron_1=$specs_row->FILM_GUAGE_1;					         
						        //Layer 2
						        $micron_2=$specs_row->FILM_GUAGE_2;
						        $film_mb_2=$specs_row->FILM_MASTER_BATCH_2;			         
						        //Layer 3
						        $micron_3=$specs_row->FILM_GUAGE_3;					         
						        //Layer 4
						        $micron_4=$specs_row->FILM_GUAGE_4;					         
						        //Layer 5
						        $micron_5=$specs_row->FILM_GUAGE_5;					         
						        //Layer 6
						        $micron_6=$specs_row->FILM_GUAGE_6;
						        $film_mb_6=$specs_row->FILM_MASTER_BATCH_6;			         
						        // Layer 7
						        $micron_7=$specs_row->FILM_GUAGE_7;
						         

						      } 

						       $total_microns= $micron_1+$micron_2+$micron_3+$micron_4+$micron_5+$micron_6+$micron_7;                  

						    }


						?>

						<tr>
							<td class="label">Release Date <span style="color:red;">*</span> :</td>
							<td><input type="hidden" name="wip_id" value="<?php echo set_value('wip_id',$row->wip_id);?>">
								<input type="date" name="release_date"   value="<?php echo set_value('release_date',date('Y-m-d'));?>" readonly /></td>
							
						</tr>
						<tr>
							<td class="label">Order No.  :</td>
							<td ><input type="text" name="order_no" id="order_no"  size="20" value="<?php echo set_value('order_no',$order_no);?>"/></td>
						</tr>
						<tr>
							<td class="label">Article No.  :</td>
							<td ><input type="text" name="article_no" id="article_no"  size="60" value="<?php echo set_value('article_no',$this->common_model->get_article_name($article_no,$this->session->userdata['logged_in']['company_id']).'//'.$article_no);?>" readonly/></td>
						</tr>
						<tr>
							<td class="label">Spec No * :</td>
							<td><input type="text" name="bom" value="<?php  echo ($bom_no!='' ? $bom_no."_R".$bom_version_no : '');?>" readonly>
								<input type="hidden" name="spec_id" value="<?php  echo $bom_no;?>">
								<input type="hidden" name="spec_version_no" value="<?php  echo $bom_version_no;?>">
								<a href="<?php echo base_url('/index.php/bill_of_material/view/'.$bom_id)?>" target="_blank"><?php  echo ($bom_no!='' ? $bom_no."_R".$bom_version_no : '');?></a>
							</td>
						<tr>
						<tr>
				            <td class="label">Sleeve Dia :</td>
				            <td><input type="text"  name="sleeve_diameter" id="sleeve_diameter" value="<?php echo $sleeve_diameter;?>" readonly>
				              Length:<input type="text"  name="sleeve_length" id="sleeve_length" value="<?php echo $sleeve_length.' MM';?>"  readonly>
				            </td>
				        </tr>
				        <tr>
				            <td class="label">Total Microns :</td>
				            <td><input type="text"  name="total_microns" id="total_microns" value="<?php echo $total_microns;?>" readonly>
				            </td>
				        </tr>
				        <tr>
				            <td class="label">Second Layer MB :</td>
				            <td><input type="text"  name="film_mb_2" id="film_mb_2" value="<?php echo $this->common_model->get_article_name($film_mb_2,$this->session->userdata['logged_in']['company_id']);?>" readonly>
				            </td>
				        </tr>
				        <tr>
				            <td class="label">Sixth Layer MB :</td>
				            <td><input type="text"  name="film_mb_6" id="film_mb_6" value="<?php echo $this->common_model->get_article_name($film_mb_6,$this->session->userdata['logged_in']['company_id']);?>" readonly>
				            </td>
				        </tr>
						<tr>
							<td class="label">Artwork No :</td>
							<td><input type="text" name="artwork" value="<?php  echo ($ad_id!='' ? $ad_id."_R".$version_no : '');?>" readonly>
								<input type="hidden" name="ad_id" value="<?php  echo $ad_id;?>">
								<input type="hidden" name="version_no" value="<?php  echo $version_no;?>">
								<a href="<?php echo base_url('/index.php/artwork_springtube/view/'.$ad_id.'/'.$version_no)?>" target="_blank"><?php  echo ($ad_id!='' ? $ad_id."_R".$version_no : '');?></a>
							</td>
						<tr>
							<td class="label">Jobcard No.  :</td>
							<td ><input type="text" name="jobcard_no" id="jobcard_no"  size="20" value="<?php echo set_value('jobcard_no',$row->jobcard_no);?>" readonly/></td>
						</tr>
						<tr>
							<td class="label">Total Ok Meters  :</td>
							<td ><input type="hidden" name="wip_cost_per_meter" value="<?php echo set_value('wip_cost_per_meter',$row->wip_cost_per_meter);?>">					
							<input type="text" name="total_ok_meters" id="total_ok_meters"  size="20" value="<?php echo set_value('total_ok_meters',$row->total_ok_meters);?>" readonly/></td>
						</tr>
						<tr>
							<td class="label">Total Ok Reels  :</td>
							<td ><input type="number" name="total_ok_reels" id="total_ok_reels"  size="20" maxlength="5" min="1" max="1000" step="1" value="<?php echo set_value('total_ok_reels',round($row->total_ok_meters/$default_reel_length,2));?>" readonly/></td>
						</tr>
						<!-- <tr>
							<td class="label">Release Reels <span style="color:red;">*</span>  :</td>
							<td ><input type="number" name="release_reels" id="release_reels"  size="20" maxlength="5" min="1" max="1000" step="1" value="<?php echo set_value('release_reels');?>" required/></td>
						</tr> -->
						<tr>
							<td class="label">Release Meters <span style="color:red;">*</span>  :</td>
							<td ><input type="text" name="release_meters" id="release_meters"  size="20" maxlength="10" min="1" max="100000" value="<?php echo set_value('release_meters');?>" required/></td>
						</tr>
						<tr>
							<td class="label" >Release Towards <span style="color:red;">*</span>:</td>
							<td><select name="release_to" id="release_to">					
								<option value="">--Please select--</option>
								<option value="1" <?php echo set_select('release_to','1');?> >SPRING PRINTING WIP BEFORE PRINT</option>
								<option value="2" <?php echo set_select('release_to','2');?> >SPRING EXTRUSION WIP SCRAP</option>
																
							</select>
							</td>
						</tr>
						<tr id="tr_release_to_order_no">
							<td class="label" >Release To Order No <span style="color:red;">*</span>:</td>
							<td><input type="text"  name="release_to_order_no" id="release_to_order_no" value="<?php echo set_value('release_to_order_no');?>">
							</td>
						</tr>
						<tr>
							<td class="label">Remarks <span style="color:red;">*</span> :</td>
							<td>
								<textarea name="release_remarks" id="release_remarks" cols="40" rows="3" value="<?php echo trim(set_value('release_remarks'));?>" maxlength="256">
								<?php echo trim(set_value('release_remarks'));?>	
								</textarea>
							</td>
						</tr>					

					</table>
			
				</td>
				<td id="td_release_order">
					<table id="tbl_release_order">
						<tr>
							<td class="label">Release To Order No <span style="color:red;">*</span> :</td>
							<td><input type="text"  name="release_to_order_no_1" id="release_to_order_no_1" value="<?php echo set_value('release_to_order_no_1');?>" readonly>
							</td>
						</tr>
						<tr>
							<td class="label">Release To Article No  <span style="color:red;">*</span>:</td>
							<td><select name="release_article_no" id="release_article_no">
									<option value=''>--Select Article No</option>
								</select>
							</td>
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
	  		<button class="ui positive button">Release</button>
		</div>
	</div>

<?php }?>
	
</form>




				
				
				
			