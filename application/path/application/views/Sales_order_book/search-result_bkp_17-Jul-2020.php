
<script>
$(document).ready(function(){
$("#check-all").show();
$("#uncheck-all").hide();
		$('#check-all').click(function(){
			$("input:checkbox").attr('checked', true);
			$("#uncheck-all").show();
			$("#check-all").hide();
		});
		$('#uncheck-all').click(function(){
			$("#check-all").show();
			$("input:checkbox").attr('checked', false);
			$("#uncheck-all").hide();
		});
		});

</script>
<div class="record_form_design">
	<h4>Search Records From <?php echo $this->input->post('from_date');?> TO <?php echo $this->input->post('to_date');?></h4>
	<a target="_blank" href="<?php echo base_url('/index.php/'.$this->router->fetch_class().'/export_to_excel?from_date=').''.$this->input->post('from_date').'&to_date='.$this->input->post('to_date').'&adr_company_id='.$this->input->post('adr_company_id').'&consin_adr_company_id='.$this->input->post('consin_adr_company_id').'&article_no='.$this->input->post('article_no').'&order_no='.$this->input->post('order_no').'&for_export='.$this->input->post('for_export').'&for_sampling='.$this->input->post('for_sampling').'&final_approval_flag='.$this->input->post('final_approval_flag').'&trans_closed='.$this->input->post('trans_closed').'&cust_order_no='.$this->input->post('cust_order_no').'&cust_order_date='.$this->input->post('cust_order_date').'&user_id='.$this->input->post('user_id');?>" >
		<button class="ui icon blue mini button" id="export_to_excel">
				 <i class="file excel outline icon"></i> Export to Excel
		</button>

	</a>

	<!--<a target="_blank" href="<?php echo base_url('/index.php/'.$this->router->fetch_class().'/export_to_excel_tally?from_date=').''.$this->input->post('from_date').'&to_date='.$this->input->post('to_date').'&adr_company_id='.$this->input->post('adr_company_id').'&consin_adr_company_id='.$this->input->post('consin_adr_company_id').'&article_no='.$this->input->post('article_no').'&order_no='.$this->input->post('order_no').'&for_export='.$this->input->post('for_export').'&for_sampling='.$this->input->post('for_sampling').'&final_approval_flag='.$this->input->post('final_approval_flag').'&trans_closed='.$this->input->post('trans_closed').'&cust_order_no='.$this->input->post('cust_order_no').'&cust_order_date='.$this->input->post('cust_order_date').'&user_id='.$this->input->post('user_id');?>" >
		<button class="ui icon blue mini button" id="export_to_excel">
				 <i class="file excel outline icon"></i> Export to Tally
		</button>

	</a>-->
	<div class="record_inner_design" style="overflow: scroll;">		
		<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/hold');?>" method="POST" target="_blank">
		<table class="record_table_design_without_fixed"  >
			<tr>
				<th>Sr. No.</th>
				<th>Hold/Unhold</th>
				<th>Jobcard Created</th>
				<th>Action <!--<a id="check-all" class="submit-green" href="javascript:void(0);">Hold all</a>
					<a id="uncheck-all" class="submit-green" href="javascript:void(0);">Unhold all</a>--></th>
				
				<th>Order Date</th>
				<th>Order No.</th>				
				<th>Bill To</th>				
				<th>Ship To</th>				
				<th>Po No.</th>
				<th>Po Date</th>
			<!--<th>Currency</th>
				<th>Exchange Rate</th>-->
				<th>Dia</th>
				<th>Length</th>
				<th>Print Type</th>
				<th>Delivery Date</th>
				<th>Article No.</th>
				<th>Article Description</th>
			<!--<th>Delivery Date</th>-->
				<th>Order Quantity</th>
				<th>Unit Rate</th>
				<th>Net Amount</th>
				<th>Bom No.</th>
				<th>Artwork No.</th>
				<th>Layer</th>				
				<th>Sleeve Outer MB</th>
				<th>Shoulder Type</th>
				<th>Shoulder Orifice</th>
				<th>Shoulder MB</th>
				<th>Shoulder Foil</th>
			<!--<th>Cap Dia</th>-->
				<th>Cap Type</th>
				<th>Cap Finish</th>
				<th>Cap Orifice</th>
				<th>Cap MB</th>
				<th>Cap Foil</th>
				<th>Cap Shrink Sleeve</th>
				<th>Cap Metalization</th>
				<th>Tube Foil</th>
			<!--<th>Lacquer</th>
				<th>Specs Comment</th>-->				
				<th>Supply Qty</th>
				<th>Pending Qty</th>
				<th>Status</th>
				<th>Cancel Qty</th>
				<th>Total Tax</th>
				
				<?php 
					global $total_array;
					
					if($tax_header==FALSE){
						echo "<th></th>";
					}else{
						$i=0;
						foreach ($tax_header as $row){
				    		echo'<th>'.ucwords(strtolower($row->lang_tax_code_desc)).'</th>';
				    		$total_array[$i]=0;
				    		$i++;
				    	}
					}
				?>
				<th>Gross Amount</th>
				<th>Comments</th>
				<th>Shipping Details</th>
				<th>Order Type</th>
				<th>Is Sample</th>
				<th>Created By</th>
				<th>Approve By</th>
				<th>Approval Date</th>
				<!-- <th>Action</th> -->
		
			</tr>
		<?php if($order_master==FALSE){
			echo "<tr><td colspan='7'>No Records Found</td></tr>";
		}
		else 
		{
			$ci =&get_instance();
			$ci->load->model('sales_order_book_model');
		    $ci->load->model('common_model');
		    $ci->load->model('article_model');
		    $ci->load->model('customer_model');

		    $sum_quantity=0;
		    $sum_net_amount=0;
		    $sum_total_tax=0;
		    $sum_gross_amount=0;
		    $sum_supply_qty=0;
		    $sum_cancel_qty=0;

		    //MASTER ROW---------
		    
		    $n=1;
			foreach($order_master as $mrow){

				$details_data=array();
				$details_data['order_no']=$mrow->order_no;
				if(!empty($this->input->post('article_no'))){
					$arr=explode("//",$this->input->post('article_no'));
					$article_no=$arr[1];
					$details_data['article_no']=$article_no;
				}
				if(!empty($this->input->post('delivery_date'))){
                 $details_data['delivery_date']=$this->input->post('delivery_date');
              	}
					
				$result=$ci->sales_order_book_model->active_details_records('order_details',$details_data,$this->session->userdata['logged_in']['company_id']);
				//echo $this->db->last_query();
				
				$rowspan=count($result);
			    $tr=$rowspan;

			    if($rowspan>0){

					$ship_to='';
					$ship_to_gst='';
					if($mrow->consin_adr_company_id!=''){

						$arr=explode("|",$mrow->consin_adr_company_id);
						$consignee=$arr[0];
						$result_consignee=$ci->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$consignee);
						foreach ($result_consignee as $row_consignee){
							$ship_to=$row_consignee->name1.' ('.$row_consignee->lang_property_name.')';
							$ship_to_gst=$row_consignee->isdn_local;
						}


					}
					else{

						$ship_to=$mrow->name1." (".strtoupper($mrow->lang_property_name).")";
					}

					$currency=($mrow->currency_id!='' ? $mrow->currency_id:'');
					$exchange_rate=($mrow->exchange_rate!='0' ?number_format($ci->common_model->read_number($mrow->exchange_rate,$this->session->userdata['logged_in']['company_id']),2,'.',','):'');

					$result_job=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'production_master.sales_ord_no',$mrow->order_no);
					if($result_job==FALSE){
						$jobcard_flag=0;
					}else{
						foreach($result_job as $result_job_row){
							$result_job_row->mp_pos_no;

							$jobcard_flag=1;
						}
					}
						
					echo "<tr ".($mrow->hold_flag == 1 ? "style='background-color:#fff6f6;color:#9f3a38;'" : "").">
					<td rowspan='".$rowspan."'>".$n."</td>
					<td rowspan='".$rowspan."'>".($mrow->order_closed==1 ? "<a class='ui blue label'>COMPLETE</a>" : ($mrow->trans_closed<>1 ? ($mrow->hold_flag == 1  ? "<a class='ui red label'>HOLD BY ".strtoupper($ci->common_model->get_user_name($mrow->hold_by,$this->session->userdata['logged_in']['company_id']))."</a>" : "<a class='ui green label'>UNHOLD</a>") : ''))."</td>
					<td rowspan='".$rowspan."'>".($jobcard_flag==1 ? 'Yes' : 'No')."</td>
					<td rowspan='".$rowspan."'>";
					

					foreach($formrights as $formrights_row){ 
						echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$mrow->order_no.'').'" target="_blank"><i class="print icon"></i></a> ' : '');

						if($jobcard_flag==0 &&  $mrow->user_id==$this->session->userdata['logged_in']['user_id']){
							echo ($formrights_row->modify==1 &&  $mrow->order_closed<>1 && $mrow->trans_closed<>1 || $jobcard_flag==1 ? "<a href='".base_url('index.php/'.$this->router->fetch_class().'/hold_modify/'.$mrow->order_no)."' target='_blank'><i class='thumbs ".($mrow->hold_flag == 1 ? 'down ' : 'up ')." icon'></i></a> <input type='hidden' name='hold_flag_$n' value='1'  ".($mrow->hold_flag == 1  ? "checked" : "unchecked").">
											<input type='hidden' name='ord_no[]' value='$mrow->order_no'>" :"");
						}else{

						}

						echo ($formrights_row->modify==1 && $mrow->final_approval_flag<>1 && $mrow->pending_flag<>1 && $mrow->trans_closed<>1  ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$mrow->order_no.'').'" target="_blank"><i class="edit icon"></i></a> ' : '');
						echo ($mrow->archive<>1 && $formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$mrow->order_no.'').'"><i class="trash icon"></i></a> ' : '');

						echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view_spring_track/'.$mrow->order_no.'').'" target="_blank" title="Track My Order"><i class="print icon"></i></a> ' : '');
										
					}

					$n++;

					echo "</td>";

					echo"<td rowspan='".$rowspan."'>".$ci->common_model->view_date($mrow->order_date,$this->session->userdata['logged_in']['company_id'])."</td>
					<td rowspan='".$rowspan."'>".($mrow->final_approval_flag==1 ? "<i class='check circle icon'></i>" : "")." <a href=".base_url('index.php/'.$this->router->fetch_class().'/view/'.$mrow->order_no)." target='_blank'>".$mrow->order_no."</a></td>
					
					<td rowspan='".$rowspan."'>".$mrow->name1." (".strtoupper($mrow->lang_property_name).") </td>
				<!--<td rowspan='".$rowspan."'>".$mrow->isdn_local."</td>-->
					<td rowspan='".$rowspan."'>".$ship_to."</td>
				<!--<td rowspan='".$rowspan."'>".$ship_to_gst."</td>-->
					<td rowspan='".$rowspan."'>".$mrow->cust_order_no."</td>
					<td rowspan='".$rowspan."'>".$ci->common_model->view_date($mrow->cust_order_date,$this->session->userdata['logged_in']['company_id'])."</td>
				<!--<td rowspan='".$rowspan."'>".$currency."</td>
					<td rowspan='".$rowspan."'>".$exchange_rate."</td>-->
					";

					
					//Shipping Details---------------------------------------------------------
					$shipping_details='';
					$freight_type_master_lang_result=$this->freight_type_model->select_one_active_record('freight_type_master_lang','freight_type_id',$mrow->freight_type_id,$this->session->userdata['logged_in']['language_id']);
					//print_r($freight_type_master_lang_result);
					foreach ($freight_type_master_lang_result as  $freight_type_master_lang_row)
					{
						$shipping_details=$freight_type_master_lang_row->lang_freight_type;						
					}

					//DETAILS ROW-----------------
						
					$r=0;
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
						$hot_foil='';
						$hot_foil_1='';
						$hot_foil_2='';
						$lacquer='';
						$lacquer_1='';
						$lacquer_2='';
						$cold_foil_1='';
						$cold_foil_2='';

						$specs_comment='';

						//ARTWORK DEATILS-----------------

						if($drow->ad_id!='' && substr($drow->ad_id,0,2)=='AW'){

							$artwork['ad_id']=$drow->ad_id;
							$artwork['version_no']=$drow->version_no;
							$search='';
							$from='';
							$to='';
							$artwork_result=$ci->artwork_model->active_record_search_new('artwork_devel_master',$artwork,$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
							//echo $this->db->last_query();
							foreach ($artwork_result as $artwork_row) {
								$print_type_artwork=$artwork_row->print_type;
								
							}

							$artwork_details_result=$ci->common_model->select_active_records_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],$artwork);

							foreach ($artwork_details_result as $artwork_details_row) {
								if($artwork_details_row->artwork_para_id==11){
									$foil_arr=explode('||',$artwork_details_row->parameter_value);
									$hot_foil=($foil_arr[1]!=''?str_replace('^',',',$foil_arr[1]):'');								

								}
								if($artwork_details_row->artwork_para_id==12 && $artwork_details_row->parameter_value!=''){									
									$lacquer_arr=explode('||',$artwork_details_row->parameter_value);
									//print_r($lacquer_arr);
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

							



						}
						else if($drow->ad_id!='' && substr($drow->ad_id,0,3)=='SAW'){

							$artwork_springtube['ad_id']=$drow->ad_id;
							$artwork_springtube['version_no']=$drow->version_no;
							$search='';
							$from='';
							$to='';
							$artwork_springtube_result=$this->artwork_springtube_model->active_record_search_new('springtube_artwork_devel_master',$artwork_springtube,$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
							//print_r($artwork_result);
							foreach ($artwork_springtube_result as $artwork_springtube_row) {
								$print_type_artwork=$artwork_springtube_row->print_type;
								$cold_foil_1=$artwork_springtube_row->cold_foil_1;
								$cold_foil_2=$artwork_springtube_row->cold_foil_2;
							}

							if($cold_foil_1!=''){
									$hot_foil=($cold_foil_2!=''? $this->common_model->get_article_name($cold_foil_1,$this->session->userdata['logged_in']['company_id']).','.$cold_foil_2:$this->common_model->get_article_name($cold_foil_1,$this->session->userdata['logged_in']['company_id']));

								}

						}

						
						//SLEEVE DETAILS-----------------

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
								//echo $this->db->last_query();
								
								if($specs_result){
									foreach($specs_result as $specs_row){
										$dia=$specs_row->SLEEVE_DIA;
										$length=$specs_row->SLEEVE_LENGTH;
										$sleeve_mb=$specs_row->SLEEVE_MASTER_BATCH;
										$print_type_bom=$specs_row->SLEEVE_PRINT_TYPE;
										$shoulder_type=$specs_row->SHOULDER_NECK_TYPE;
										$shoulder_orifice=$specs_row->SHOULDER_ORIFICE;
										$shoulder_mb=$specs_row->SHOULDER_MASTER_BATCH;
										$shoulder_foil=$specs_row->SHOULDER_FOIL;
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

						    		$sleeve_code_result=$ci->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$sleeve_code);

						    		//echo $this->db->last_query();

						    		foreach($sleeve_code_result as $sleeve_code_row){										
						    			$sleeve_spec_id=$sleeve_code_row->spec_id;
						    			$sleeve_spec_version=$sleeve_code_row->spec_version_no;
						    		}

						    		$specs['spec_id']=$sleeve_spec_id;
									$specs['spec_version_no']=$sleeve_spec_version;

									$specs_master_result=$ci->common_model->select_active_records_where('specification_sheet',$this->session->userdata['logged_in']['company_id'],$specs);
									if($specs_master_result){
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
									    //SHOULDER----------

										$shoulder_code_result=$ci->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$shoulder_code);

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
									    
									    $cap_spec_id='';
									    $cap_spec_version='';

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


						    		}//SPECS MASTER

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

						

						//---NEW STATUS ADDED ON DEMAND OF PRAJAKTA----------------------------------------------
							// Tolerance-----------------
							$address_master_result=$ci->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$mrow->customer_no);

							foreach ($address_master_result as $address_master_row) {

								$total_order_quantity=$ci->common_model->read_number($drow->total_order_quantity,$this->session->userdata['logged_in']['company_id']);									
								//Factory Tolerance-------	
								$factory_tolerance=30;
								$factory_tolerance_qty=($total_order_quantity*$factory_tolerance)/100;
								$minus_factory_dispatch_qty=$total_order_quantity-$factory_tolerance_qty;

								//Customer Tolerance-------		
								//$customer_tolerance=10;
								$customer_tolerance=0;
								$customer_tolerance=($address_master_row->dispatch_tolerance!=''?$address_master_row->dispatch_tolerance:0);

								if($customer_tolerance!=0){
									$tolerance_qty=($total_order_quantity*$customer_tolerance)/100;
									$plus_tolerance_qty=$total_order_quantity+$tolerance_qty;
									$minus_tolerance_qty=$total_order_quantity-$tolerance_qty;
								}
								else{
									
									$tolerance_qty=0;
									$plus_tolerance_qty=$total_order_quantity+$tolerance_qty;
									$minus_tolerance_qty=$total_order_quantity-$tolerance_qty;
									
								}
							}

							// Conditions-----------------
							$pending_qty=0;
							$total_arid_qty=0;
							$supplyqty=0;
							$cancel_qty=0;
							// $search_arr=array('ref_ord_no'=>$drow->order_no,
							// 				  'article_no'=>$drow->article_no);
							
							// $ar_invoice_details_result=$this->common_model->select_active_records_where('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],$search_arr);

							// foreach ($ar_invoice_details_result as $ar_invoice_details_row) {
							// 	$total_arid_qty+=$ar_invoice_details_row->arid_qty;
							// }

							$invoice=array();
							$invoice['ref_ord_no']=$drow->order_no;
							$invoice['article_no']=$drow->article_no;

							$supply_qty_result=$ci->sales_order_status_model->sum_supply_qty('ar_invoice_master',$invoice,$this->session->userdata['logged_in']['company_id']);

							foreach($supply_qty_result as $supply_qty_row){
								$supply_qty=$supply_qty_row->supply_qty;

							}

							//$supplyqty=$ci->common_model->read_number($total_arid_qty,$this->session->userdata['logged_in']['company_id']);
							$supplyqty=$ci->common_model->read_number($supply_qty,$this->session->userdata['logged_in']['company_id']);

							if($mrow->trans_closed==1){

								if($supplyqty==0)
								{	$status="Cancel Order";
									$cancel_qty=$total_order_quantity;
								}else if($supplyqty<$minus_factory_dispatch_qty){																
									$status="Manual Closed (Order cancelled from customer end) ".($drow->pr_pos_complete_flag==0?"(INV)":"(PR)")."";
									$cancel_qty=$total_order_quantity- $supplyqty;
									$status.=number_format($total_order_quantity - $supplyqty,2,'.',',');
								}
								else if($supplyqty<$minus_tolerance_qty && $supplyqty>$minus_factory_dispatch_qty){																
									$status="Manual Closed (Below Tolerance) ".($drow->pr_pos_complete_flag==0?"(INV)":"(PR)")." ";
									$cancel_qty=$total_order_quantity - $supplyqty;
									$status.=number_format($total_order_quantity - $supplyqty,2,'.',',');
								}
								elseif($supplyqty>=$minus_tolerance_qty && $supplyqty<$total_order_quantity){
									$status="Short Closed ".($drow->pr_pos_complete_flag==0?"(INV)":"(PR)")." ";
									//$cancel_qty=number_format(get_value($row_order_details['total_order_quantity'])- $supplyqty,2,'.',',');
									$status.=number_format($total_order_quantity- $supplyqty,2,'.',',');
								}
								else{
									
									$status="Completed ".($drow->pr_pos_complete_flag==0 ? "(INV)":"(PR)")." ";
								}
								
							}else{								
								
								if($total_order_quantity<=$supplyqty && $supplyqty<>0){
									$status="Completed ".($drow->pr_pos_complete_flag==0 ? "(INV)":"(PR)")." ";
									//$status="Completed (INV)";
								}
								elseif($total_order_quantity>$supplyqty && $supplyqty<>0){
									$status="Partially Completed ".($drow->pr_pos_complete_flag==0?"(INV)":"(PR)")." ";
									$pending_qty=number_format($total_order_quantity- $supplyqty,0,'.',',');
									$status.=number_format($total_order_quantity- $supplyqty,0,'.',',');
								}
								else{
									
									$status="Pending";
									$pending_qty=number_format($total_order_quantity,0,'.',',');
								}
								
							}


						//---------------------------------------------------------------------------------------
						
						
							$sum_cancel_qty+=$cancel_qty;
							echo"
							<td>".$dia."</td>
							<td>".$length."</td>
							<td>".($print_type_artwork==''?$print_type_bom:$print_type_artwork)."</td>
							<td>".($drow->delivery_date!='0000-00-00'? $ci->common_model->view_date($drow->delivery_date,$this->session->userdata['logged_in']['company_id']):"")."</td>
							<td>".$drow->article_no."</td>
							<td>".$this->common_model->get_article_name($drow->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
						
							<td>".number_format($ci->common_model->read_number($drow->total_order_quantity,$this->session->userdata['logged_in']['company_id']),0,'.',',')."</td>
							<td>".$mrow->currency_id." ".$unit_rate."</td>
							<td>".$mrow->currency_id." ".number_format($net_amount,2,'.',',')."</td>

							<td>";
							if(!empty($drow->spec_id)){

									if(substr($drow->spec_id,0,1)=="S"){
										echo "<a href='".base_url()."/index.php/specification/view/".$drow->spec_id."/".$drow->spec_version_no." ' target='blank'>".$drow->spec_id."_".$drow->spec_version_no."</a>";
									}else{
										$bom=array('bom_no'=>$drow->spec_id,
											'bom_version_no'=>$drow->spec_version_no);
										$data['bom']=$this->common_model->select_active_records_where("bill_of_material",$this->session->userdata['logged_in']['company_id'],$bom);
										
										foreach($data['bom'] as $bom_row){											
										echo "<a href='".base_url()."/index.php/bill_of_material/view/".$bom_row->bom_id."' target='blank'>".$drow->spec_id."_".$drow->spec_version_no."</a>";
										}									
									}
							}
							
							echo "</td>
							<td>";

							if($drow->ad_id!='' && substr($drow->ad_id,0,2)=='AW'){
								echo"<a href='".base_url()."/index.php/artwork_new/view/".$drow->ad_id."/".$drow->version_no." ' target='blank'>".($drow->ad_id!=""? $drow->ad_id."_R".$drow->version_no:"")."</a>";
							}else if($drow->ad_id!='' && substr($drow->ad_id,0,3)=='SAW'){

								echo"<a href='".base_url()."/index.php/artwork_springtube/view/".$drow->ad_id."/".$drow->version_no." ' target='blank'>".($drow->ad_id!=""? $drow->ad_id."_R".$drow->version_no:"")."</a>";
							}

							echo"</td>
							<td>".$layer_no."</td>
							
							<td>".$this->common_model->get_article_name($sleeve_mb,$this->session->userdata['logged_in']['company_id'])."</td>	
							<td>".$shoulder_type."</td>
							<td>".$shoulder_orifice."</td>
							<td>".$this->common_model->get_article_name($shoulder_mb,$this->session->userdata['logged_in']['company_id'])."</td>		
							<td>".$shoulder_foil."</td>	
						<!--<td>".$cap_dia."</td>-->
							<td>".$cap_type."</td>
							<td>".$cap_finish."</td>
							<td>".$cap_orifice."</td>
							<td>".$this->common_model->get_article_name($cap_mb,$this->session->userdata['logged_in']['company_id'])."</td>	
							<td>".$cap_foil."</td>	
							<td>".$cap_shrink_sleeve."</td>	
							<td>".$cap_metalization."</td>
							<td>".$hot_foil."</td>
						<!--<td>".$lacquer."</td>
							<td>".$specs_comment."</td>-->

							
							<td>".number_format($supplyqty,0,'.',',')."</td>
							<td>".$pending_qty."</td>
							<td>".$status."</td>
							<td>".number_format($cancel_qty,0,'.',',')."</td>

							<td>".number_format($ci->common_model->read_number($drow->total_tax,$this->session->userdata['logged_in']['company_id']),2,'.',',')."</td>
							
							";
							$arr=explode("|",$drow->tax_grid_amount);

							$edit=$drow->tax_pos_no;
							$result=$ci->sales_order_book_model->select_tax('tax_grid_details',$this->session->userdata['logged_in']['company_id'],'tax_id',$edit,'priority');

							$i=0;
							foreach ($tax_header as $trow){

						    	echo'<td>';

						    	$j=0;
						    	foreach ($result as $row) {

								 	if($row->tax_code==$trow->tax_code){

								 		if($arr[$j]!=''){
								 			echo number_format($arr[$j],2,'.',',');
								 			$total_array[$i]+=$arr[$j];
								 		}
								 		
								 	}
								 	$j++;

								}

								echo'</td>';

								$i++;


			    			}

			    			if($r==0){

			    				$sum_gross_amount+=$ci->common_model->read_number($mrow->total_amount,$this->session->userdata['logged_in']['company_id']);

			    				echo"<td rowspan='".$rowspan."'>".$mrow->currency_id." ".number_format($ci->common_model->read_number($mrow->total_amount,$this->session->userdata['logged_in']['company_id']),2,'.',',')."</td>
			    					<td  rowspan='".$rowspan."'>".$mrow->lang_addi_info."</td>
									<td  rowspan='".$rowspan."'>".$shipping_details."</td>
									<td  rowspan='".$rowspan."'>".($mrow->for_export=='1'?"EXPORT":"LOCAL")."</td>
						            <td  rowspan='".$rowspan."'>".($mrow->for_sampling=='1'?"SAMPLE":"")."</td>
			    					<td class='ellipses' rowspan='".$rowspan."'><a class='ui tiny label'><i class='user icon'></i>".strtoupper($ci->common_model->get_user_name($mrow->user_id,$this->session->userdata['logged_in']['company_id']))."</a></td>
									<td class='ellipses' rowspan='".$rowspan."'>".($mrow->final_approval_flag==1 ? "<a class='ui tiny label'><i class='checkmark box icon'></i>".substr(strtoupper($ci->common_model->get_user_name($mrow->approved_by,$this->session->userdata['logged_in']['company_id'])),0,strpos($ci->common_model->get_user_name($mrow->approved_by,$this->session->userdata['logged_in']['company_id']),' '))."</a>" : '')."</td>
						            <td  rowspan='".$rowspan."'>".$ci->common_model->view_date($mrow->approval_date,$this->session->userdata['logged_in']['company_id'])."</td>
									
									<!--<td rowspan='".$rowspan."'>";
									foreach($formrights as $formrights_row){ 
										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$mrow->order_no.'').'" target="_blank"><i class="print icon"></i></a> ' : '');
										echo ($formrights_row->modify==1 && $mrow->final_approval_flag<>1 && $mrow->pending_flag<>1 && $mrow->trans_closed<>1  ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$mrow->order_no.'').'" target="_blank"><i class="edit icon"></i></a> ' : '');
										echo ($mrow->archive<>1 && $formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$mrow->order_no.'').'"><i class="trash icon"></i></a> ' : '');
										
									}
									echo "</td>

								-->	";

			    			}

							echo"</tr>";
							if($rowspan>1 && --$tr>0){
									echo'<tr>';
							}			

							$r++;

							//------TOTAL----------
							$sum_quantity+=$ci->common_model->read_number($drow->total_order_quantity,$this->session->userdata['logged_in']['company_id']);
							$sum_net_amount+=$net_amount;
							$sum_total_tax+=$ci->common_model->read_number($drow->total_tax,$this->session->userdata['logged_in']['company_id']);
							$sum_supply_qty+=$supplyqty;
							//$sum_cancel_qty+=$cancel_qty;

					}

				}//detail if	
				
			}


		} 
		?>
		<?php  
			echo"<tr>
				<td colspan='16' style='text-align:right;'><b>TOTAL</b></td>
				<td><b>".number_format($sum_quantity,0,'.',',')."</b></td>
				<td></td>
				<td><b>".number_format($sum_net_amount,2,'.',',')."</b></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				
				<td></td>
				<td><b>".number_format($sum_supply_qty,0,'.',',')."</b></td>
				<td></td>
				<td></td>
				<td><b>".number_format($sum_cancel_qty,0,'.',',')."</b></td>
				<td><b>".number_format($sum_total_tax,2,'.',',')."</b></td>";
					$i=0;
					foreach ($tax_header as $row){
			    		echo'<td><b>'.number_format($total_array[$i],2,'.',',').'</b></td>';
			    		$i++;
			    	}
				echo"<td><b>".number_format($sum_gross_amount,2,'.',',')."</b></td>
				 <td></td>
				 <td></td>
				 <td></td>
				 <td></td>
				 <td></td>
				 <td></td>
				 <td></td>
				 

			</tr>";

		?>				
	</table>
		<!--<button class="ui green button" type ="submit" name="submit">Update</button>-->
	</form>			
	</div>
</div>
				
				
				
				
				
			