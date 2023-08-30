 <style>
      .tableFixHead {
        overflow-y: auto;
        height: 550px;
      }
      .tableFixHead thead th {
        position: sticky;
        top: 0;
      }
  </style>
  <span id='check'>
<div class="record_form_design">
	
		<div class="record_inner_design">

			<div class="tableFixHead">
				<table class="record_table_design_without_fixed" >
						<thead>
						<tr>
							<th>Sr. No.</th>
							<th>Order Date</th>
							<th>Order No.</th>				
							<th>Bill To</th>
							<th>Dia</th>
							<th>Length</th>
							<th>Print Type</th>
							<th>Delivery Date</th>
							<th>Article No.</th>
							<th>Article Description</th>
						<!--<th>Delivery Date</th>-->
							<th>Order Qty</th>
							<th>Unit Rate</th>
							<th>Net Amount</th>
							<th>Bom No.</th>
							<th>Artwork No.</th>
							<!--<th>Layer</th>				
							<th>Sleeve Outer MB</th>
							<th>Shoulder Type</th>
							<th>Shoulder Orifice</th>
							<th>Shoulder MB</th>
							<th>Shoulder Foil</th>
							<!--<th>Cap dia</th>-->
							<!--<th>Cap Type</th>
							<th>Cap Finish</th>
							<th>Cap Orifice</th>
							<th>Cap MB</th>
							<th>Cap Foil</th>
							<th>Cap Shrink Sleeve</th>
							<th>Cap Metalization</th>
							<th>Tube Foil</th>
							<th>Order Type</th>
							<th>Is Sample</th>-->
							<th>Created By</th>
							<!--<th>Approve By</th>-->
							<th>Approved On</th>

							<th>Lead Time</th>							
							<th>Status</th>														
							<th>Pending Qty</th>
							<th>Oc Date</th>
							<th>Update</th>					
						</tr>
					</thead>
				<?php 

				 	$sum_quantity=0;
				    $sum_net_amount=0;

				if($order_master==FALSE){
					echo "<tr><td colspan='7'>No Records Found</td></tr>";
				}
				else 
				{
					$ci =&get_instance();
					$ci->load->model('sales_order_book_model');
				    $ci->load->model('common_model');
				    $ci->load->model('article_model');
				    $ci->load->model('customer_model');

				    $i=1;
				    $n=1;
					foreach($order_master as $mrow){
						?>


						<script>
						$(document).ready(function(){
						$("#loading").hide(); $("#cover").hide();

						var today = new Date().toISOString().split('T')[0];
						document.getElementsByName("oc_date")[0].setAttribute('min', today);

							$("#oc_date_<?php echo $i;?>").on('blur focusout',function(){
								//alert(1);
								if($('#oc_date_<?php echo $i;?>').val()==""){
									alert('Enter the Oc date');
								}else if($("#order_date_<?php echo $i;?>").val()>$("#oc_date_<?php echo $i;?>").val()){
									alert('Enter the correct date');
								}
								else{
									$("#loading").show();
									$("#cover").show();
									$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
									$(".update").prop('disabled',true);
							    $("#update_<?php echo $i;?>").prop('disabled',false);
							    $(".oc_date").prop('disabled',true);
							    $("#oc_date_<?php echo $i;?>").prop('disabled',false);
							    $("#loading").hide();$("#cover").hide();
							}

							});

							$("#update_<?php echo $i;?>").on('click',function(){

								if($('#oc_date_<?php echo $i;?>').val()==""){
									alert('Enter the Oc date');
								}else{
									$("#loading").show();
									$("#cover").show();
									$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
									
									$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/oc_date_confirmation",data: {order_no : $('#order_no_<?php echo $i;?>').val(),article_no : $('#article_no_<?php echo $i;?>').val(),oc_date:$('#oc_date_<?php echo $i;?>').val(),order_created_by:$('#created_by_<?php echo $i;?>').val(),order_arropved_by:$('#approved_by_<?php echo $i;?>').val()},cache: false,success: function(html){
							    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
								       $("#check").html(html);

							    		} 
							    	});
								
								}
								
							});


							//$("#shift_<?php echo $i;?>").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});
						});
						</script>

						<?php
						$details_data=array();
						$details_data['order_no']=$mrow->order_no;
						/*if(!empty($this->input->post('article_no'))){
							$arr=explode("//",$this->input->post('article_no'));
							$article_no=$arr[1];
							$details_data['article_no']=$article_no;
						}*/
							
						$result=$ci->sales_order_book_model->active_details_records('order_details',$details_data,$this->session->userdata['logged_in']['company_id']);
						//echo $this->db->last_query();
						
						$rowspan=count($result);
					    $tr=$rowspan;

					    if($rowspan>0){


							$currency=($mrow->currency_id!='' ? $mrow->currency_id:'');
							$exchange_rate=($mrow->exchange_rate!='0' ?number_format($ci->common_model->read_number($mrow->exchange_rate,$this->session->userdata['logged_in']['company_id']),2,'.',','):'');

							
					echo "<tr ".($mrow->hold_flag == 1 ? "style='background-color:#fff6f6;color:#9f3a38;'" : "").">
							<td rowspan='".$rowspan."'>".$n."</td>
							<td rowspan='".$rowspan."'><input type='hidden' name='order_date' id='order_date_".$i."' value='".$mrow->order_date."'>".$ci->common_model->view_date($mrow->order_date,$this->session->userdata['logged_in']['company_id'])."</td>
							<td rowspan='".$rowspan."'><input type='hidden' name='order_no' id='order_no_".$i."' value='".$mrow->order_no."'>".($mrow->final_approval_flag==1 ? "<i class='check circle icon'></i>" : "")." <a href=".base_url('index.php/sales_order_book/view/'.$mrow->order_no)." target='_blank'>".$mrow->order_no."</a></td>
							
							<td rowspan='".$rowspan."'>".$mrow->name1." (".strtoupper($mrow->lang_property_name).") </td>";

							$r=0;
							$n++;
							foreach ($result as $drow){

								$dia='';	
								$length='';
								$sleeve_mb='';
								$print_type_artwork='';
								$print_type_bom='';
								$layer_no='';
								$shoulder_type='';
								$shoulder_orifice='';
								$shoulder_mb='';
								$shoulder_foil='';
								$cap_dia='';
								$cap_type='';
								$cap_finish='';
								$cap_orifice='';
								$cap_mb='';
								$cap_foil='';
								$cap_shrink_sleeve='';
								$cap_metalization='';
								$specs_comment='';
								$hot_foil_1='';
								$hot_foil_2='';
								$hot_foil='';
								$lacquer_1='';
								$lacquer_2='';
								$lacquer='';


								//ARTWORK DEATILS--------

								if(!empty($drow->ad_id)){
									$artwork['ad_id']=$drow->ad_id;
									$artwork['version_no']=$drow->version_no;
									$search='';
									$from='';
									$to='';
									$artwork_result=$ci->artwork_model->active_record_search('artwork_devel_master',$artwork,$search,$from,$to,$this->session->userdata['logged_in']['company_id']);

									
									
									foreach ($artwork_result as $artwork_row) {
										$print_type_artwork=$artwork_row->print_type;
										
									}


								}
								$artwork['ad_id']=$drow->ad_id;
								$artwork['version_no']=$drow->version_no;

								$artwork_details_result=$this->common_model->select_active_records_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],$artwork);

							foreach ($artwork_details_result as $artwork_details_row) {
								if($artwork_details_row->artwork_para_id==11){
									$foil_arr=explode('||',$artwork_details_row->parameter_value);
									$hot_foil=($foil_arr[1]!=''?str_replace('^',',',$foil_arr[1]):'');								

								}
								if($artwork_details_row->artwork_para_id==12){									
									$lacquer_arr=explode('||',$artwork_details_row->parameter_value);
									$lacquer=($lacquer_arr[1]!=''?str_replace('^',',',$lacquer_arr[1]):'');

								}
								if($artwork_details_row->artwork_para_id==23){
									$hot_foil_1=$this->common_model->get_article_name($artwork_details_row->parameter_value,$this->session->userdata['logged_in']['company_id']);
								}
								if($artwork_details_row->artwork_para_id==25){
									$hot_foil_2=$this->common_model->get_article_name($artwork_details_row->parameter_value,$this->session->userdata['logged_in']['company_id']);
								}
								if($artwork_details_row->artwork_para_id==27){
									$lacquer_1=$this->common_model->get_article_name($artwork_details_row->parameter_value,$this->session->userdata['logged_in']['company_id']);
								}
								if($artwork_details_row->artwork_para_id==29){
									$lacquer_2=$this->common_model->get_article_name($artwork_details_row->parameter_value,$this->session->userdata['logged_in']['company_id']);
								}

								if($hot_foil_1!=''){
									$hot_foil=($hot_foil_2!=''?$hot_foil_1.','.$hot_foil_2:$hot_foil_1);

								}
								if($lacquer_1!=''){
									$lacquer=($lacquer_2!=''?$lacquer_1.','.$lacquer_2:$lacquer_1);
								}
								
							}


								// SPECS DETAILS-----
								if(!empty($drow->spec_id)){

									$specs['spec_id']=$drow->spec_id;
									$specs['spec_version_no']=$drow->spec_version_no;

									$specs_master_result=$ci->common_model->select_active_records_where('specification_sheet',$this->session->userdata['logged_in']['company_id'],$specs);
									if($specs_master_result){
											foreach($specs_master_result as $specs_master_result_row){
												$layer_arr=explode("|", $specs_master_result_row->dyn_qty_present);
												$layer_no=substr($layer_arr[1],0,1);							

											}
										$specs_result=$ci->sales_order_book_model->select_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
										if($specs_result){
											foreach($specs_result as $specs_row){
												$dia=$specs_row->SLEEVE_DIA;
												$length=$specs_row->SLEEVE_LENGTH;
												$sleeve_mb=$specs_row->SLEEVE_MASTER_BATCH;
												$print_type_bom=$specs_row->SLEEVE_PRINT_TYPE;
												$shoulder_type=$specs_row->SHOULDER_NECK_TYPE;
												$shoulder_orifice=$specs_row->SHOULDER_ORIFICE;
												$shoulder_mb=$specs_row->SHOULDER_MASTER_BATCH;
												$shoulder_foil=$specs_row->SHOULDER_FOIL_TAG;
												$cap_dia=$specs_row->CAP_DIA;
												$cap_type=$specs_row->CAP_STYLE;
												$cap_finish=$specs_row->CAP_MOLD_FINISH;
												$cap_orifice=$specs_row->CAP_ORIFICE;
												$cap_foil=$specs_row->CAP_FOIL_COLOR;
												$cap_mb=$specs_row->CAP_MASTER_BATCH;
												$cap_shrink_sleeve=	$specs_row->CAP_SHRINK_SLEEVE_NAME;


											}
									    }

									    $specs_lang_result=$ci->common_model->select_active_records_where('specification_sheet_lang',$this->session->userdata['logged_in']['company_id'],$specs);
									    if($specs_lang_result){

									    	foreach ($specs_lang_result as $specs_lang_row) {

									    		$specs_comment= strtoupper($specs_lang_row->lang_comments);

										    	$a_ss=strpos(strtoupper($specs_lang_row->lang_comments),'SHRINK');
												$a_met=strpos(metaphone(strtoupper($specs_lang_row->lang_comments)),'MTL');
												$b_met=strpos(metaphone(strtoupper($specs_lang_row->lang_comments)),'MTLST');
												$c_met=strpos(metaphone(strtoupper($specs_lang_row->lang_comments)),'MTLS');
													
												if($a_ss){
													$cap_shrink_sleeve='YES';
												}
													
												if($a_met OR $b_met OR $c_met){
													$cap_metalization='YES';
												}
									    	}

									    	

									    }
	

								    }else{
								    	// BOM DEATILS-------


								    	$sleeve_code='';


								    	$bom_data['bom_no']=$drow->spec_id;
										$bom_data['bom_version_no']=$drow->spec_version_no;

								    	$bom_result=$ci->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$bom_data);
								    	if($bom_result){

								    		foreach($bom_result as $bom_result_row){										
								    			$sleeve_code=$bom_result_row->sleeve_code;
								    			$shoulder_code=$bom_result_row->shoulder_code;
								    			$cap_code=$bom_result_row->cap_code;
								    			$label_code=$bom_result_row->label_code;
								    			$print_type_bom=$bom_result_row->print_type;
								    			$specs_comment=strtoupper($bom_result_row->comment);
								    		}
								    	

								    	//  FOR SLEEVE -----
								    		//echo substr($sleeve_code,0,3);
								    	if(substr($sleeve_code,0,3)=="SLV"){	
								    		
								    		$sleeve_code_result=$ci->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$sleeve_code);
								    		$sleeve_spec_id="";
								    		$sleeve_spec_version="";
								    		foreach($sleeve_code_result as $sleeve_code_row){										
								    			$sleeve_spec_id=$sleeve_code_row->spec_id;
								    			$sleeve_spec_version=$sleeve_code_row->spec_version_no;
								    		}

								    		$specs['spec_id']=$sleeve_spec_id;
											$specs['spec_version_no']=$sleeve_spec_version;

											$specs_master_result=$ci->common_model->select_active_records_where('specification_sheet',$this->session->userdata['logged_in']['company_id'],$specs);
											//if($specs_master_result){
													foreach($specs_master_result as $specs_master_result_row){
														$layer_arr=explode("|", $specs_master_result_row->dyn_qty_present);
														$layer_no=substr($layer_arr[1],0,1);							

													}
												$specs_result=$ci->sales_order_book_model->select_sleeve_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
												if($specs_result){
													foreach($specs_result as $specs_row){
														$dia=$specs_row->SLEEVE_DIA;
														$length=$specs_row->SLEEVE_LENGTH;
														$sleeve_mb=$specs_row->SLEEVE_MASTER_BATCH;								

													}
											    }
										}else{
											// FOR LMAINATED FILM------
											// $film_spec_sheet=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$sleeve_code);

											// //if($specs_master_result){
											// 		foreach($film_spec_sheet as $film_spec_sheet_row){
											// 			$layer_arr=explode("|", $film_spec_sheet_row->dyn_qty_present);
											// 			$layer_no=substr($layer_arr[1],0,1);


											// 	}											

												$film_spec_sheet=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$sleeve_code);
												foreach ($film_spec_sheet as $film_spec_sheet_row) {
										
													$film_spec_id=$film_spec_sheet_row->spec_id;
													$film_spec_version_no=$film_spec_sheet_row->spec_version_no;

													$layer_arr=explode("|", $film_spec_sheet_row->dyn_qty_present);
														$layer_no=substr($layer_arr[1],0,1);


													$data=array('spec_id'=>$film_spec_id,
																'spec_version_no'=>$film_spec_version_no);

													$data['film_specs_details']=$this->sales_order_book_model->select_film_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);
													//echo $this->db->last_query();

													foreach ($data['film_specs_details'] as $film_specs_details_row) {
														$dia=$film_specs_details_row->SLEEVE_DIA;
														$length=$film_specs_details_row->SLEEVE_LENGTH;
														$sleeve_mb=$film_specs_details_row->FILM_MASTER_BATCH_2;
														$sleeve_mb_perc=$film_specs_details_row->FILM_MB_PERC_2;

													}

												}

										}	    



											    //SHOULDER----------

												$shoulder_code_result=$ci->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$shoulder_code);
												$shoulder_spec_id="";
												$shoulder_spec_version="";
									    		foreach($shoulder_code_result as $shoulder_code_row){										
									    			$shoulder_spec_id=$shoulder_code_row->spec_id;
									    			$shoulder_spec_version=$shoulder_code_row->spec_version_no;
									    		}

									    		$shoulder_specs['spec_id']=$shoulder_spec_id;
												$shoulder_specs['spec_version_no']=$shoulder_spec_version;

												$shoulder_specs_result=$ci->sales_order_book_model->select_shoulder_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$shoulder_specs);
												if($shoulder_specs_result){
													foreach($shoulder_specs_result as $shoulder_specs_row){
														$shoulder_type=$shoulder_specs_row->SHOULDER_STYLE;
														$shoulder_orifice=$shoulder_specs_row->SHOULDER_ORIFICE;
														$shoulder_foil=($shoulder_specs_row->SHOULDER_FOIL_TAG!=''?'YES':'');
														$shoulder_mb=$shoulder_specs_row->SHOULDER_MASTER_BATCH;								

													}
											    }

											    //CAP------------

											    $cap_code_result=$ci->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$cap_code);
											    $cap_spec_id="";
											    $cap_spec_version="";
									    		foreach($cap_code_result as $cap_code_row){										
									    			$cap_spec_id=$cap_code_row->spec_id;
									    			$cap_spec_version=$cap_code_row->spec_version_no;
									    		}

									    		$cap_specs['spec_id']=$cap_spec_id;
												$cap_specs['spec_version_no']=$cap_spec_version;

												$cap_specs_result=$ci->sales_order_book_model->select_cap_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$cap_specs);
												
												if($cap_specs_result){
													foreach($cap_specs_result as $cap_specs_row){
														$cap_dia=$cap_specs_row->CAP_DIA;
														$cap_type=$cap_specs_row->CAP_STYLE;
														$cap_finish=$cap_specs_row->CAP_MOLD_FINISH;
														$cap_orifice=$cap_specs_row->CAP_ORIFICE;
														$cap_mb=$cap_specs_row->CAP_MASTER_BATCH;
														$cap_foil=$this->common_model->get_article_name($cap_specs_row->CAP_FOIL_CODE,$this->session->userdata['logged_in']['company_id']);
														$cap_shrink_sleeve=$this->common_model->get_article_name($cap_specs_row->CAP_SHRINK_SLEEVE_CODE,$this->session->userdata['logged_in']['company_id']);
														$cap_metalization=$cap_specs_row->CAP_METALIZATION;							

													}
											    }


								    		//}//SPECS MASTER

								        }//BOM RESULT

								    }//ELSE

								}//SPECS DETAILS				

						    

								if($mrow->for_export==1){
									$unit_rate=0;
									$unit_rate=$drow->calc_sell_price;
									$net_amount=$ci->common_model->read_number($drow->total_order_quantity,$this->session->userdata['logged_in']['company_id'])*$drow->calc_sell_price;

								}else{
									$unit_rate=0;
									$unit_rate=number_format($this->common_model->read_number($drow->selling_price,$this->session->userdata['logged_in']['company_id']),2,'.',',');

									$net_amount=$ci->common_model->read_number($drow->total_order_quantity,$this->session->userdata['logged_in']['company_id'])* $ci->common_model->read_number($drow->selling_price,$this->session->userdata['logged_in']['company_id']);
								}




								//---------------------------------------------------------------------------------------													

									echo"
									<td>".$dia."</td>
									<td>".$length."</td>
									<td>".($print_type_artwork==''?$print_type_bom:$print_type_artwork)."</td>
									<td>".($drow->delivery_date!='0000-00-00'?$ci->common_model->view_date($drow->delivery_date,$this->session->userdata['logged_in']['company_id']):"")."</td>
									<td><input type='hidden' name='article_no' id='article_no_".$i."' value='".$drow->article_no."'>".$drow->article_no."</td>
									<td>".$this->common_model->get_article_name($drow->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
								<!--<td>".$ci->common_model->view_date(($drow->delivery_date!='0000-00-00'?$drow->delivery_date:""),$this->session->userdata['logged_in']['company_id'])."</td>-->
									<td>".number_format($ci->common_model->read_number($drow->total_order_quantity,$this->session->userdata['logged_in']['company_id']),0,'.',',')."</td>
									<td>".$unit_rate."</td>
									<td>".number_format($net_amount,2,'.',',')."</td>
									
									<td>";
									if(!empty($drow->spec_id)){

											if(substr($drow->spec_id,0,1)=="S"){
												echo "<a href='".base_url()."index.php/specification/view/".$drow->spec_id."/".$drow->spec_version_no." ' target='blank'>".$drow->spec_id."_".$drow->spec_version_no."</a>";
											}else{
												$bom=array('bom_no'=>$drow->spec_id,
													'bom_version_no'=>$drow->spec_version_no);
												$data['bom']=$this->common_model->select_active_records_where("bill_of_material",$this->session->userdata['logged_in']['company_id'],$bom);
												
												foreach($data['bom'] as $bom_row){											
												echo "<a href='".base_url()."index.php/bill_of_material/view/".$bom_row->bom_id."' target='blank'>".$drow->spec_id."_".$drow->spec_version_no."</a>";
												}									
											}
									}
									
									echo "</td>
									<td>";

									//<a href='".base_url()."/index.php/artwork_new/view/".$drow->ad_id."/".$drow->version_no." ' target='blank'>".($drow->ad_id!=""? $drow->ad_id."_R".$drow->version_no:"")."</a>
									if($drow->ad_id!='' && substr($drow->ad_id,0,2)=='AW'){
										echo"<a href='".base_url()."index.php/artwork_new/view/".$drow->ad_id."/".$drow->version_no." ' target='blank'>".($drow->ad_id!=""? $drow->ad_id."_R".$drow->version_no:"")."</a>";
									}else if($drow->ad_id!='' && substr($drow->ad_id,0,3)=='SAW'){

										echo"<a href='".base_url()."index.php/artwork_springtube/view/".$drow->ad_id."/".$drow->version_no." ' target='blank'>".($drow->ad_id!=""? $drow->ad_id."_R".$drow->version_no:"")."</a>";
									}

									echo"</td>

									<!--<td>".$layer_no."</td>
									
									<td>".$this->common_model->get_article_name($sleeve_mb,$this->session->userdata['logged_in']['company_id'])."</td>							
									<td>".$shoulder_type."</td>
									<td>".$shoulder_orifice."</td>
									<td>".$this->common_model->get_article_name($shoulder_mb,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$shoulder_foil."</td>-->
								<!--<td>".$cap_dia."</td>-->
									<!--<td>".$cap_type."</td>
									<td>".$cap_finish."</td>
									<td>".$cap_orifice."</td>
									<td>".$this->common_model->get_article_name($cap_mb,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$cap_foil."</td>
									<td>".$cap_shrink_sleeve."</td>
									<td>".$cap_metalization."</td>
									<td>".$hot_foil."</td>-->
								<!--<td>".$lacquer."</td>
									<td>".$specs_comment."</td>-->
									
									";

					    			if($r==0){

					    				echo "<td class='ellipses' rowspan='".$rowspan."'>
					    					<input type='hidden' name='created_by' id='created_by_".$i."' value='".$mrow->user_id."'>
					    					<input type='hidden' name='approved_by' id='approved_by_".$i."' value='".$mrow->approved_by."'>
					    					
					    					<a class='ui tiny label'><i class='user icon'></i>".strtoupper($ci->common_model->get_user_name($mrow->user_id,$this->session->userdata['logged_in']['company_id']))."</a></td>";
											/*<td class='ellipses' rowspan='".$rowspan."'>".($mrow->final_approval_flag==1 ? "<a class='ui tiny label'><i class='checkmark box icon'></i>".substr(strtoupper($ci->common_model->get_user_name($mrow->approved_by,$this->session->userdata['logged_in']['company_id'])),0,strpos($ci->common_model->get_user_name($mrow->approved_by,$this->session->userdata['logged_in']['company_id']),' '))."</a>" : '')."</td>*/
								            
								         echo "<td  rowspan='".$rowspan."'>".$ci->common_model->view_date($mrow->approval_date,$this->session->userdata['logged_in']['company_id'])."</td>

						            	<td>".($mrow->max_lead_time!='' ? $mrow->max_lead_time." Days" : "")."</td>
						            	<td>".$this->sales_order_book_model->get_order_status($mrow->order_no)."</td>
													<td>".$this->sales_order_book_model->get_pending_qty($mrow->order_no)."</td>";


											foreach($formrights as $formrights_row){
												if($formrights_row->new==1 && $mrow->hold_flag<>1){

													echo "<td><input type='date' id='oc_date_".$i."' class='oc_date' name='oc_date'></td>

								            <td><input type='submit' class='update' id='update_".$i."' name='update_".$i."' value='Update'></td>";

								          }
								      }

								            $i++;
					    			}

									echo"</tr>";
									if($rowspan>1 && --$tr>0){
											echo'<tr>';
									}			

									$r++;
									
							}

						}//detail if	
						
					}


				} 
				?>				
					</table>

			</div>
				
		</div>
			
						
	</div>
	</span>	
</div>