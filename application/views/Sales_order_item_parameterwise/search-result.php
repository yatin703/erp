<div class="record_form_design">
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<h4>Sales Order Item Parameter Wise Records From <?php echo $this->input->post('from_date');?> TO <?php echo $this->input->post('to_date');?></h4>
	 <div class="record_inner_design" style="overflow: scroll; white-space: nowrap;">
		
					<table class="ui very basic collapsing celled table"  style="font-size:10px;">

						<thead>

							<tr>
								<th></th>
								<th style='text-align: center;' colspan='8'>Order Details</th>
								<th style='text-align: center;' colspan='4'>Sleeve Details</th>
								<th style='text-align: center;' colspan='3'>Printing Details</th>
								<th style='text-align: center;' colspan='4'>Shoulder Details</th>
								<th style='text-align: center;' colspan='4'>Cap Details</th>
							</tr>
							<tr>

							<th>Sr No</th>
							<th>Plan</th>
							<th>Hold</th>
							<th>Order No.</th>
							<th>Order Date</th>
							<th>Bill To</th>
							<th>Article Code</th>
							<th>Article Name</th>
							
							<th>Artwork</th>
							<th>Delivery Date</th>
							<th>Layer</th>
							<th>Dia</th>
							<th>Length</th>

							<th>Sleeve MB</th>
							<th>Print Type</th>
							<th>Lacquer</th>
							<th>Foil</th>
							<th>Shoulder </th>
							<th>Orifice</th>
							<th>MB</th>
							<th>Foil</th>
							<th>Cap Code</th>
							<th>Cap Type</th>
							<th>Cap Dia</th>
							<th>Cap Finish</th>
							<th>Cap Orifice</th>
							<th>Cap MB</th>							
							<th>Cap Foil</th>
							<th>Metalization</th>
							<!--<th>Cap foil Width</th>-->
							<th>Shrink Sleeve</th>
							<th>Quantity</th>
							<th>Rest Qty</th>
							<th>Jobcards Generated</th>
							<!--<th>Created By</th>
							<th>Approved By</th>-->
							<th>Approval Date</th>
							<!--<th>Order Type</th>-->
							<th>Is Sample</th>
							<th>Order Status</th>
							<th>Transaction Status</th>
							<th>SO Comment</th>
							<th>Action</th>
							<!-- <th>Action</th> -->
							<th>Ready To Print (Meters)</th>
							<th>Action</th>
							<th>Ready To Body Making Qty</th>
							<th>Action</th>
					
						</tr>
					</thead>
					<tbody>
				<?php if($order_master==FALSE){
					echo "<tr><td colspan='15'>No Records Found</td></tr>";
				}
				else{
					$n=1;
					foreach ($order_master as $order_master_row) {


						$print_type_artwork="";
						$ship_to='';
						$ship_to_gst='';
						$currency='';
						$exchange_rate='';						
						$sleeve_diameter='';
						$sleeve_length='';
						$sleeve_master_batch='';
						$sleeve_master_batch_2='';
						$sleeve_print_type='';
						$shoulder_type='';
						$shoulder_orifice='';
						$shoulder_master_batch='';
						$shoulder_foil_tag='';
						$cap_finish='';
						$cap_orifice='';
						$cap_master_batch='';
						$cap_foil_color='';
						$cap_foil_width='';
						$cap_height='';
						$hot_foil="";
						$hot_foil_1='';
						$hot_foil_2='';
						$cold_foil_1='';
						$cold_foil_2='';
						$lacquer='';
						$lacquer_1='';
						$lacquer_2='';
						
						$layer='';
						$bom_id='';

						// Ship to Details------------------------------------------

						if($order_master_row->consin_adr_company_id!=''){

							$arr=explode("|",$order_master_row->consin_adr_company_id);
							 $consignee=$arr[0];
							$result_consignee=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$consignee);
							foreach ($result_consignee as $row_consignee){
								$ship_to=$row_consignee->name1.' ('.$row_consignee->lang_property_name.')';
							 	$ship_to_gst=$row_consignee->isdn_local;
							}


						}
						else{

							$ship_to=$order_master_row->name1;
							$ship_to_gst=$order_master_row->isdn_local;
						}
						//Currency and Exchange rate-----------------------------------	

						$currency=($order_master_row->currency_id!='' ? $order_master_row->currency_id:'');
						$exchange_rate=($order_master_row->exchange_rate!='0' ?number_format($this->common_model->read_number($order_master_row->exchange_rate,$this->session->userdata['logged_in']['company_id']),2,'.',','):'');	
						
						// Specification Parameter search-------------------------------

						$search=array();
						if(!empty($this->input->post('sleeve_diameter'))){
                      		$search['sleeve_diameter']=$this->input->post('sleeve_diameter');
		                }
		                if(!empty($this->input->post('sleeve_print_type'))){
                      		$search['sleeve_print_type']=$this->input->post('sleeve_print_type');
		                }
		                if(!empty($this->input->post('shoulder_type'))){
		                    $search['shoulder_type']=$this->input->post('shoulder_type');
		                }
		                 if(!empty($this->input->post('shoulder_orifice'))){
		                    $search['shoulder_orifice']=$this->input->post('shoulder_orifice');
		                }
	                  	if(!empty($this->input->post('cap_orifice'))){
	                      $search['cap_orifice']=$this->input->post('cap_orifice');
	                  	}
	                  	if(!empty($this->input->post('cap_finish'))){
	                      $search['cap_finish']=$this->input->post('cap_finish');
		                }
		                $flag=0;
		                $spec_id='';
		                $spec_version_no='';		                

	                	$spec_id=$order_master_row->spec_id;
	                	$spec_version_no=$order_master_row->spec_version_no;

	                	if($order_master_row->ad_id!='' && substr($order_master_row->ad_id,0,2)=='AW'){

							$artwork['ad_id']=$order_master_row->ad_id;
							$artwork['version_no']=$order_master_row->version_no;
							$search='';
							$from='';
							$to='';
							$artwork_result=$this->artwork_model->active_record_search_new('artwork_devel_master',$artwork,$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
							//echo $this->db->last_query();
							foreach ($artwork_result as $artwork_row) {
								$print_type_artwork=$artwork_row->print_type;
								
							}

							$artwork_details_result=$this->common_model->select_active_records_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],$artwork);

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
									$hot_foil=($hot_foil_2!=''? '<span style="color:blue;">'.$hot_foil_1.'</span>,<span style="color:green;">'.$hot_foil_2.'</span>': $hot_foil_1);

								}
								if($lacquer_1!=''){
									$lacquer=($lacquer_2!=''?$lacquer_1.','.$lacquer_2:$lacquer_1);
								}
								
							}

							



						}
						else if($order_master_row->ad_id!='' && substr($order_master_row->ad_id,0,3)=='SAW'){

							$artwork_springtube['ad_id']=$order_master_row->ad_id;
							$artwork_springtube['version_no']=$order_master_row->version_no;
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
									$hot_foil=($cold_foil_2!=''? '<span style="color:blue;">'.$this->common_model->get_article_name($cold_foil_1,$this->session->userdata['logged_in']['company_id']).'</span>,<span style="color:green;">'.$this->common_model->get_article_name($cold_foil_2,$this->session->userdata['logged_in']['company_id']).'</span>' : $this->common_model->get_article_name($cold_foil_1,$this->session->userdata['logged_in']['company_id']));

								}

						}

	                	if($spec_id!='' && $spec_version_no!=''){

	                		//SPECS DETAILS BY BOM
	                		if(strtoupper(substr($spec_id, 0,3))=='BOM'){
	                			$print_type_bom="";
	                			//  BOM DETAILS--------------
	                			$sleeve_spec_id='';
	                			$sleeve_spec_version='';
	                			$shoulder_spec_id='';
	                			$shoulder_spec_version='';
	                			$cap_spec_id='';
								$cap_spec_version='';

	                			$bom_no=$spec_id;
	                			$bom_version_no=$spec_version_no;
	                			$data=array('bom_no'=>$bom_no,
	                						'bom_version_no'=>$bom_version_no);

	                			$bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

	                			foreach (
	                				$bill_of_material_result as $bill_of_material_row) {
	                				$bom_id=$bill_of_material_row->bom_id;
	                				$sleeve_code=$bill_of_material_row->sleeve_code;
						    		$shoulder_code=$bill_of_material_row->shoulder_code;
						    		$cap_code=$bill_of_material_row->cap_code;
						    		$label_code=$bill_of_material_row->label_code;
						    		$print_type_bom=$bill_of_material_row->print_type;
						    		$specs_comment=strtoupper($bill_of_material_row->comment);
	                			}

	                			//SLEEVE------------
	                			$sleeve_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$sleeve_code);

					    		foreach($sleeve_code_result as $sleeve_code_row){										
					    			$sleeve_spec_id=$sleeve_code_row->spec_id;
					    			$sleeve_spec_version=$sleeve_code_row->spec_version_no;
					    		}

					    		$specs['spec_id']=$sleeve_spec_id;
								$specs['spec_version_no']=$sleeve_spec_version;

								$specs_master_result=$this->common_model->select_active_records_where('specification_sheet',$this->session->userdata['logged_in']['company_id'],$specs);
									if($specs_master_result){
								foreach($specs_master_result as $specs_master_result_row){
												$layer_arr=explode("|", $specs_master_result_row->dyn_qty_present);
												$layer_no=substr($layer_arr[1],0,1);							

									}
								}

								$specs_result=$this->sales_order_book_model->select_sleeve_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
										if($specs_result){
											foreach($specs_result as $specs_row){
												$sleeve_diameter=$specs_row->SLEEVE_DIA;
												$sleeve_length=$specs_row->SLEEVE_LENGTH;
												$sleeve_master_batch=$specs_row->SLEEVE_MASTER_BATCH;

												$sleeve_master_batch_2=$specs_row->SLEEVE_MASTER_BATCH_2;											

											}
									    }
									    //SHOULDER----------

										$shoulder_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$shoulder_code);

							    		foreach($shoulder_code_result as $shoulder_code_row){										
							    			$shoulder_spec_id=$shoulder_code_row->spec_id;
							    			$shoulder_spec_version=$shoulder_code_row->spec_version_no;
							    		}

							    		$shoulder_specs['spec_id']=$shoulder_spec_id;
										$shoulder_specs['spec_version_no']=$shoulder_spec_version;

										$shoulder_specs_result=$this->sales_order_book_model->select_shoulder_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$shoulder_specs);
										if($shoulder_specs_result){
											foreach($shoulder_specs_result as $shoulder_specs_row){
												$shoulder_type=$shoulder_specs_row->SHOULDER_STYLE;
												$shoulder_orifice=$shoulder_specs_row->SHOULDER_ORIFICE;
												$shoulder_foil=$shoulder_specs_row->SHOULDER_FOIL_TAG;	
												$shoulder_master_batch=$shoulder_specs_row->SHOULDER_MASTER_BATCH;								
											}
									    }

									    //CAP------------

									    $cap_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$cap_code);
									    
									    

							    		foreach($cap_code_result as $cap_code_row){										
							    			$cap_spec_id=$cap_code_row->spec_id;
							    			$cap_spec_version=$cap_code_row->spec_version_no;
							    		}

							    		$cap_specs['spec_id']=$cap_spec_id;
										$cap_specs['spec_version_no']=$cap_spec_version;

										$cap_specs_result=$this->sales_order_book_model->select_cap_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$cap_specs);
										
										if($cap_specs_result){
											foreach($cap_specs_result as $cap_specs_row){
												$cap_dia=$cap_specs_row->CAP_DIA;
												$cap_type=$cap_specs_row->CAP_STYLE;
												$cap_finish=$cap_specs_row->CAP_MOLD_FINISH;
												$cap_orifice=$cap_specs_row->CAP_ORIFICE;
												$cap_master_batch=$cap_specs_row->CAP_MASTER_BATCH;
												$cap_foil_color=$this->common_model->get_article_name($cap_specs_row->CAP_FOIL_COLOR,$this->session->userdata['logged_in']['company_id']);
												$cap_shrink_sleeve=$this->common_model->get_article_name($cap_specs_row->CAP_SHRINK_SLEEVE_CODE,$this->session->userdata['logged_in']['company_id']);
												$cap_metalization=$cap_specs_row->CAP_METALIZATION;							

											}

										}else{
											$cap_type='';
											$cap_dia='';
											$cap_metalization='';
											$cap_shrink_sleeve='';
										}

	                			

							//------------------------------------------	
	                		}else{
	                			// SPECS DETAILS BY SPECS----------------
	                			$data=array('spec_id'=>$spec_id,
	                						'spec_version_no'=>$spec_version_no);
	                			$specification_result=$this->sales_order_item_parameterwise_model->select_specs_by_parameter('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data,$search);

	                			if(count($specification_result)>0){
	                				$flag=1;
	                				foreach($specification_result as $specification_row){

										$sleeve_diameter=$specification_row->sleeve_diameter;
										$sleeve_length=$specification_row->sleeve_length;
										$sleeve_master_batch=$specification_row->sleeve_master_batch;
										$sleeve_print_type=$specification_row->sleeve_print_type;
										$shoulder_type=$specification_row->shoulder_type;
										$shoulder_orifice=$specification_row->shoulder_orifice;
										$shoulder_master_batch=$specification_row->shoulder_master_batch;
										$shoulder_foil_tag=$specification_row->shoulder_foil_tag;
										$cap_dia="NA";
										$cap_type="NA";
										$cap_finish=$specification_row->cap_finish;
										$cap_orifice=$specification_row->cap_orifice;
										$cap_master_batch=$specification_row->cap_master_batch;
										$cap_foil_color=$specification_row->cap_foil_color;
										$cap_foil_width=$specification_row->cap_foil_width;
										$cap_height=$specification_row->cap_height;
									}
								}else{

	                				continue;
	                			}

	                		} // END SPECS DETAILS BY SPECS      	

	                	}else{
	                		$sleeve_diameter='';
							$sleeve_length='';
							$sleeve_master_batch='';
							$sleeve_print_type='';
							$shoulder_type='';
							$shoulder_orifice='';
							$shoulder_master_batch='';
							$shoulder_foil_tag='';
							$cap_finish='';
							$cap_orifice='';
							$cap_master_bacth='';
							$cap_foil_color='';
							$cap_foil_width='';
							$cap_height='';
	                	}


	             		//  ROWS------------------------------------------------------

	                	echo"<tr>
								<td>".$n++."</td>
								<td><a target='_blank' href='".base_url('index.php/'.$this->router->fetch_class().'/add_to_plan/'.$order_master_row->order_no.'/'.$order_master_row->article_no)."'>Add</a></td>
								<td>".($order_master_row->hold_flag==1 ?"<a class='ui red label'>HOLD</a>" : "")."</td>
								<td>".($order_master_row->final_approval_flag==1 ? "<i class='check circle icon'></i>" : "")." <a href=".base_url('index.php/sales_order_book/view/'.$order_master_row->order_no)." target='_blank'>".$order_master_row->order_no."</a></td>
								<td>".$this->common_model->view_date($order_master_row->order_date,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".$order_master_row->name1."</td>
								
								
								";
								

								// REST QUANTITY-----------------
								$total_order_quantity=$this->common_model->read_number($order_master_row->total_order_quantity,$this->session->userdata['logged_in']['company_id']);
								$total_arid_qty=0;
								$supplyqty=0;
								$rest_qty=0;
								$search_arr=array('ref_ord_no'=>$order_master_row->order_no,
												  'article_no'=>$order_master_row->article_no);
								
								$ar_invoice_details_result=$this->common_model->select_active_records_where('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],$search_arr);

								foreach ($ar_invoice_details_result as $ar_invoice_details_row) {
									$total_arid_qty+=$ar_invoice_details_row->arid_qty;
								}

								$supplyqty=$this->common_model->read_number($total_arid_qty,$this->session->userdata['logged_in']['company_id']);

								$rest_qty=$total_order_quantity-$supplyqty;

								echo"
								<td>".$order_master_row->article_no."</td>
								<td>".$this->common_model->get_article_name($order_master_row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
								<td><a href='".base_url()."/index.php/".($order_master_row->ad_id!="" && substr($order_master_row->ad_id,0,3)=='SAW'?"artwork_springtube":"artwork_new")."/view/".$order_master_row->ad_id."/".$order_master_row->version_no." ' target='blank'>".($order_master_row->ad_id!=""? $order_master_row->ad_id."_R".$order_master_row->version_no:"")."</a></td>
								
								<td>".$this->common_model->view_date(($order_master_row->delivery_date!='0000-00-00'?$order_master_row->delivery_date:""),$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".$layer_no."</td>
								<td>".$sleeve_diameter."</td>
								<td>".$sleeve_length."</td>
								<td>".$this->common_model->get_article_name($sleeve_master_batch,$this->session->userdata['logged_in']['company_id'])." ".$this->common_model->get_article_name($sleeve_master_batch_2,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".($print_type_artwork==''? $print_type_bom : $print_type_artwork)."</td>
								<td>".$lacquer."</td>
								<td>".$hot_foil."</td>
								
								<td>".$shoulder_type."</td>
								<td>".$shoulder_orifice."</td>
								<td>".$this->common_model->get_article_name($shoulder_master_batch,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".$shoulder_foil_tag."</td>
								<td>".$cap_code."</td>
								<td>".$cap_type."</td>
								<td>".$cap_dia."</td>
								<td>".$cap_finish."</td>
								<td>".$cap_orifice."</td>
								<td>".$this->common_model->get_article_name($cap_master_batch,$this->session->userdata['logged_in']['company_id'])."</td>								
								<td>".$cap_foil_color."</td>
								<td>".$cap_metalization."</td>
								<td>".$cap_shrink_sleeve."</td>
								<td>".number_format($this->common_model->read_number($order_master_row->total_order_quantity,$this->session->userdata['logged_in']['company_id']),0,'.',',')."</td>
								<td>".number_format($rest_qty,0,'.',',')."</td>
								<td>";

									$sum_actual_qty_manufactured=0;
									// Jobcards generated--------------------------------
									$jobcard_data=array();
									$jobcard_data['sales_ord_no']=$order_master_row->order_no;
									$jobcard_data['article_no']=$order_master_row->article_no;
									$jobcard_data['archive']=0;

									$jobcard_result=$this->common_model->active_record_search('production_master',$jobcard_data,$this->session->userdata['logged_in']['company_id']);

									foreach($jobcard_result as $jobcard_row){

										if(!empty($order_master_row->spec_id)){
											if(substr($order_master_row->spec_id,0,1)=="S"){

												echo "<a target='_blank' href='".base_url('index.php/'.$this->router->fetch_class().'/view/'.$jobcard_row->mp_pos_no.'/'.$order_master_row->spec_id.'/'.$order_master_row->spec_version_no)."' >";

											}else{
												$bom=array('bom_no'=>$order_master_row->spec_id,
			                                    'bom_version_no'=>$order_master_row->spec_version_no);
			                                	$data['bom']=$this->common_model->select_active_records_where("bill_of_material",$this->session->userdata['logged_in']['company_id'],$bom);
			                                    foreach($data['bom'] as $bom_row){                                          
			                                    
			                                    echo "<a target='_blank' href='".base_url('index.php/'.$this->router->fetch_class().'/view_new/'.$jobcard_row->mp_pos_no.'/'.$order_master_row->spec_id.'/'.$order_master_row->spec_version_no)."' >";


			                                    } 
											}
										}
										

										 echo $jobcard_row->mp_pos_no."=".number_format($this->common_model->read_number($jobcard_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']),2,'.',',');
										echo"</a>";
										echo"</br>";

										$sum_actual_qty_manufactured+=$this->common_model->read_number($jobcard_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
									}
									echo "<p style='color:red !important;'> <u>TOTAL_GENERATED=".number_format($sum_actual_qty_manufactured,2,'.',',')."</u></p>";

								echo"</td>
								";

								/*<td>".($order_master_row->user_id!='' ? strtoupper($this->common_model->get_user_name($order_master_row->user_id,$this->session->userdata['logged_in']['company_id'])): '')."</td>
								<td>".($order_master_row->approved_by!='' ? strtoupper($this->common_model->get_user_name($order_master_row->approved_by,$this->session->userdata['logged_in']['company_id'])): '')."</td>*/

								echo "<td>".$this->common_model->view_date($order_master_row->approval_date,$this->session->userdata['logged_in']['company_id'])."</td>";

								/*<td>".($order_master_row->for_export==1 ? "EXPORT":"LOCAL")."</td>*/
								echo "
								<td>".($order_master_row->for_sampling==1 ? "SAMPLE":"")."</td>
								<td>";
					             	if($order_master_row->order_closed==0){
					             		echo "OPEN";
					             	}
					             	if($order_master_row->order_closed==1){
					             		echo "COMPLETED";
					             	}
					             	if($order_master_row->order_closed==2){
					             		echo "PARTIALLY COMPLETED";
					             	}
								echo "</td>
								<td>";
					             	if($order_master_row->trans_closed==1){
					             		echo "MANUALLY CLOSED";
					             	}
								             	
								echo "</td>
										<td>".$order_master_row->lang_addi_info."</td>";

									foreach($formrights as $formrights_row){ 
										echo"<td>";
											//echo $order_master_row->order_flag;
										if($formrights_row->new=='1' && $order_master_row->final_approval_flag=='1' && $order_master_row->order_closed<>1 && $order_master_row->trans_closed<>1 && $order_master_row->hold_flag<>1){

											if($order_master_row->order_flag=='1' || $order_master_row->order_flag=='4'){
											
											echo '<a target="_blank" href="'.base_url('index.php/'.$this->router->fetch_class().'/job_card/'.$order_master_row->order_no.'/'.$order_master_row->article_no).'">Create Spring Extrusion Job Card</a>';

											}else{

												echo'<a target="_blank" href="'.base_url('index.php/'.$this->router->fetch_class().'/job_card/'.$order_master_row->order_no.'/'.$order_master_row->article_no).'">Create Coex Job Card</a> ';
											}
										}	
										

										echo"</td>";
										// echo"<td>";
										// echo ($formrights_row->new==1 && $order_master_row->order_flag==1 && $order_master_row->final_approval_flag==1 && $order_master_row->order_closed<>1 && $order_master_row->trans_closed<>1 && $order_master_row->ref_order_no=='' ? '<a target="_blank" href="'.base_url('index.php/'.$this->router->fetch_class().'/setup_job_card/'.$order_master_row->order_no.'/'.$order_master_row->article_no).'">Create Setup Job Card</a> ' : '');

										// echo"</td>";
										echo"<td>";
										
										$data_search=array(
											'order_no'=>$order_master_row->order_no,
											'article_no'=>$order_master_row->article_no,
											'status'=>'0'
										);

										$springtube_printing_wip_master_before_result=$this->common_model->select_active_records_where('springtube_printing_wip_master_before',$this->session->userdata['logged_in']['company_id'],$data_search);
										
										$sum_bprint_wip_meters=0;
										foreach ($springtube_printing_wip_master_before_result as  $springtube_printing_wip_master_before_row) {
											
											echo $springtube_printing_wip_master_before_row->jobcard_no.'='.$springtube_printing_wip_master_before_row->bprint_wip_meters;
											$sum_bprint_wip_meters+=$springtube_printing_wip_master_before_row->bprint_wip_meters;
											echo"</br>";

										}
										echo "<p style='color:red !important;'> <u>TOTAL_READY_TO_PRINT=".$sum_bprint_wip_meters."</u></p>";
										
										echo"</td>";
										echo"<td>";

										echo ($formrights_row->new==1 && $order_master_row->order_flag==1 && $order_master_row->final_approval_flag==1 && $order_master_row->order_closed<>1 && $order_master_row->trans_closed<>1 && $order_master_row->hold_flag<>1 && $sum_bprint_wip_meters>0 ? '<a target="_blank" href="'.base_url('index.php/springtube_printing_wip_before_print/create_printing_jobcard/'.$order_master_row->order_no.'/'.$order_master_row->article_no).'">Create Spring Printing Job Card</a> ' : '');

										
										echo"</td>";

										echo"<td>";
										
										$data_search=array(
											'order_no'=>$order_master_row->order_no,
											'article_no'=>$order_master_row->article_no,
											'status'=>'0',
											'archive'=>'0'
										);

										$springtube_printing_wip_master_after_result=$this->common_model->select_active_records_where('springtube_printing_wip_master_after',$this->session->userdata['logged_in']['company_id'],$data_search);
										
										$sum_aprint_wip_qty=0;
										foreach ($springtube_printing_wip_master_after_result as  $springtube_printing_wip_master_after_row) {
											
											echo $springtube_printing_wip_master_after_row->jobcard_no.'='.$springtube_printing_wip_master_after_row->aprint_wip_qty;
											$sum_aprint_wip_qty+=$springtube_printing_wip_master_after_row->aprint_wip_qty;
											echo"</br>";

										}
										echo "<p style='color:red !important;'> <u>TOTAL_READY_TO_BODYMAKING=".$sum_aprint_wip_qty."</u></p>";
										
										echo"</td>";
										echo"<td>";

										echo ($formrights_row->new==1 && $order_master_row->order_flag==1 || $order_master_row->order_flag=='4' && $order_master_row->final_approval_flag==1 && $order_master_row->order_closed<>1 && $order_master_row->trans_closed<>1 && $order_master_row->hold_flag<>1 && $sum_aprint_wip_qty>0 ? '<a target="_blank" href="'.base_url('index.php/springtube_printing_wip_after_print/create_bodymaking_jobcard/'.$order_master_row->order_no.'/'.$order_master_row->article_no).'">Create Spring Bodymaking Job Card</a> ' : '');

										
										echo"</td>";									

									}
								echo"</tr>";



						
					}//FOREACH

				}//ELSE
			?>			
				</tbody>	
				</table>
					
		</div>
</div>

				
				
				
				
				
			