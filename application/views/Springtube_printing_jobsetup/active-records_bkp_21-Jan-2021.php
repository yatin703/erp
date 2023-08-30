<style>	
   tr:hover {background-color:#e4e4e4;}
</style>
<div class="record_form_design">
<h4>Active Records</h4>
	<div class="record_inner_design"  style="overflow: scroll; white-space: nowrap;">
			<table class="record_table_design_without_fixed">
				<tr>
					<th colspan="15" style="text-align: center;">Setup Details</th>
					<th colspan="11" style="text-align: center;">ABG-1 FLEXO UNIT 1</th>
					<th colspan="10" style="text-align: center;">ABG-1 FLEXO UNIT 2</th>
					<th colspan="10" style="text-align: center;">ABG-1 FLEXO UNIT 3</th>
					<th colspan="10" style="text-align: center;">ABG-1 FLEXO UNIT 4</th>
					<th colspan="17" style="text-align: center;">DURST</th>
					<th colspan="11" style="text-align: center;">ABG-2 FLEXO UNIT 1</th>
					<th colspan="11" style="text-align: center;">ABG-2 FLEXO UNIT 2</th>
					<th colspan="3" style="text-align: center;">APPROVALS</th>
				</tr>
				<tr>
					<th>Sr No.</th>
					<th>Action</th>
					<th>Setup Date</th>
					<th>Job Id</th>
					<th>Customer</th>
					<th>Order No</th>
					<th>Article No.</th>
					<!-- <th>Product Name</th> -->
					<th>Artwork</th>
					<!-- <th>Order Qty</th> -->
					<th>Dia X Length</th>
					<!-- <th>Length</th> -->
					<th>Print Type</th>
					<th>Film Color</th>
					<th>Body Making</th>
					<th>Jobcard No</th>
					<th>Jobcard Qty</th>
					<th>Printing Qty</th>

					<!--ABG -1 Unit 1-->
					<th>Abg1 carona 1</th>
					<th>Abg1 ink id 1</th>
					<th>Abg1 ink usage 1 (Grams)</th>
					<th>Abg1 anilox 1</th>
					<th>Abg1 applying method 1</th>
					<th>Abg1 cylinder teeth 1</th>
					<th>Abg1 rotary 1</th>
					<th>Abg1 uv power 1</th>
					<th>Abg1 uv speed 1</th>
					<th>Abg1 uv hours 1</th>
					<th>Abg1 unit 1 comment</th>

					<!--ABG -1 Unit 2-->
					<th>Abg1 ink id 2</th>
					<th>Abg1 ink usage 2 (Grams)</th>
					<th>Abg1 anilox 2</th>
					<th>Abg1 applying method 2</th>
					<th>Abg1 cylinder teeth 2</th>
					<th>Abg1 rotary 2</th>
					<th>Abg1 uv power 2</th>
					<th>Abg1 uv speed 2</th>
					<th>Abg1 uv hours 2</th>					
					<th>Abg1 unit 2 comment</th>

					<!--ABG -1 Unit 3-->
					<th>Abg1 ink id 3</th>
					<th>Abg1 ink usage 3 (Grams)</th>
					<th>Abg1 anilox 3</th>
					<th>Abg1 applying method 3</th>
					<th>Abg1 cylinder teeth 3</th>
					<th>Abg1 rotary 3</th>
					<th>Abg1 uv power 3</th>
					<th>Abg1 uv speed 3</th>
					<th>Abg1 uv hours 3</th>					
					<th>Abg1 unit 3 comment</th>

					<!--ABG -1 Unit 4-->
					<th>Abg1 ink id 4</th>
					<th>Abg1 ink usage 4 (Grams)</th>
					<th>Abg1 anilox 4</th>
					<th>Abg1 applying method 4</th>
					<th>Abg1 cylinder teeth 4</th>
					<th>Abg1 rotary 4</th>
					<th>Abg1 uv power 4</th>
					<th>Abg1 uv speed 4</th>
					<th>Abg1 uv hours 4</th>					
					<th>Abg1 unit 4 comment</th>

					<!-- DURST -->
					<th>is durst</th>
					<th>durst corona</th>
					<th>print confg</th>
					<th>digital white</th>
					<th>colour policy</th>
					<th>substrate defination</th>
					<th>printing speed</th>
					<th>unwind tension</th>
					<th>pinning w</th>
					<th>pinning k</th>
					<th>durst uv curing 1</th>
					<th>durst uv lamp hrs 1</th>
					<th>durst uv curing 2</th>
					<th>durst uv lamp hrs 2</th>
					<th>nitrogen</th>
					<th>durst comment</th>
					<th>digital cost in euro</th>

					<!-- ABG-2 Unit 1 -->
					<th>abg2 carona 1</th>
					<th>abg2 ink id 1</th>
					<th>abg2 ink usage 1 (Grams)</th>
					<th>abg2 anilox 1</th>
					<th>abg2 applying method 1</th>
					<th>abg2 cylinder teeth 1</th>
					<th>abg2 rotary 1</th>
					<th>abg2 uv power 1</th>
					<th>abg2 uv speed 1</th>
					<th>abg2 uv hours 1</th>					
					<th>abg2 unit 1 comment</th>

					<!-- ABG-2 Unit 2-->
					<th>abg2 ink id 2</th>
					<th>abg2 ink usage 2 (Grams)</th>
					<th>abg2 anilox 2</th>
					<th>abg2 applying method 2</th>
					<th>abg2 cylinder teeth 2</th>
					<th>abg2 rotary 2</th>
					<th>abg2 uv power 2</th>
					<th>abg2 uv speed 2</th>
					<th>abg2 uv hours 2</th>					
					<th>abg2 unit 2 comment</th>
					<th>is extended path</th>					 
					<!-- <th>slitting</th> -->

					<th>Created by</th>					
					<th>Approval date</th>
					<th>Approved by</th>
				 					
					
				</tr>
				<?php 				 

				if($springtube_printing_jobsetup_master==FALSE){
					echo "<tr><td colspan='19'>No Active Records Found</td></tr>";
				}else{
						$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
							 	
						foreach($springtube_printing_jobsetup_master as $row){
							$customer='';
							$jobcard_qty=0;
					        $order_no='';
					        $article_no='';
					        $ad_id='';
					        $version_no='';
					        $dia='';
					        $length='';
					        $print_type='';
					        $laminate_color='';
					        $body_making_type='';
					        $total_order_quantity='';
					        $printed_counter=0;

							$data['production_master']=$this->job_card_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$row->jobcard_no);
					        //echo $this->db->last_query();
					       

					        foreach ($data['production_master'] as $production_master_row) {
					          
					          $jobcard_qty=$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
					          $order_no=$production_master_row->sales_ord_no;
					          $article_no=$production_master_row->article_no;

					        }

					        $order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);
					        foreach($order_master_result as $order_master_row){
					          $customer=$order_master_row->customer_no;                      
					        }

					        $data_order_details=array('order_no'=>$order_no,'article_no'=>$article_no);

					        $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
					        foreach($order_details_result as $order_details_row){
					          $total_order_quantity=$this->common_model->read_number($order_details_row->total_order_quantity,$this->session->userdata['logged_in']['company_id']);
					          $ad_id=$order_details_row->ad_id;
					          $version_no=$order_details_row->version_no;
					          $bom_no=$order_details_row->spec_id;
					          $bom_version_no=$order_details_row->spec_version_no;
					        }
					        //Artwork Deatils-------------------------
					        $data=array('ad_id'=>$ad_id,
					            'version_no'=>$version_no
					              );
					        $springtube_artwork_result=$this->artwork_springtube_model->active_record_search_new('springtube_artwork_devel_master',$data,'','','',$this->session->userdata['logged_in']['company_id']);

					        foreach ($springtube_artwork_result as $springtube_artwork_row) {
					          $body_making_type=$springtube_artwork_row->body_making_type;
					          $print_type=$springtube_artwork_row->print_type;
					          $dia=$springtube_artwork_row->sleeve_dia;
					          $length=$springtube_artwork_row->sleeve_length;
					          $laminate_color=$springtube_artwork_row->laminate_color;
					        }					        

					        $search_data=array('jobcard_no'=>$row->jobcard_no);
					        $counter_result=$this->springtube_printing_production_model->select_total_counter('springtube_printing_production_master',$search_data);
					        foreach ($counter_result as $counter_row) {
					          $printed_counter=$counter_row->total_counter;
					        }
								
							echo"<tr>
								<td>".$i."</td>
								<td>";
								foreach($formrights as $formrights_row){ 

										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->job_id).'" target="_blank"><i class="print icon"></i></a> ' : '');

										echo ($formrights_row->modify==1 && $row->pending_flag==0 && $row->final_approval_flag<>1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->job_id).'" target="_blank"><i class="edit icon"></i></a> ' : '');

										echo ($formrights_row->copy==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/copy/'.$row->job_id).'" target="_blank"><i class="copy icon"></i></a> ' : '');										
										echo ($row->archive<>1 && $formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->job_id).'"><i class="trash icon" target="_blank"></i></a> ' : '');


																														
									}
								echo"</td>
								<td>".$this->common_model->view_date($row->jobsetup_date,$this->session->userdata['logged_in']['company_id'])."</td>
								<td >".($row->final_approval_flag==1?"<i style='color:#06c806;' class='check circle icon'></i>" :($row->final_approval_flag==0 && $row->pending_flag==1?"<i style='color:blue;'class='circle icon' title='Sent For Approval'>":""))."<a href='".base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->job_id)."' target='_blank'></i>".$row->job_id."</a> 
								</td>
								<td>".$this->common_model->get_customer_name($customer,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".'<a href="'.base_url('index.php/sales_order_book/view/'.$order_no).'" target="_blank" >'.$order_no."</a></td>
								<td title='".$this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id'])."'>".$article_no."</td>
								<!--<td>".$this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
								-->
								<td>".'<a href="'.base_url('index.php/artwork_springtube/view/'.$ad_id.'/'.$version_no).'" target="_blank" >'.($ad_id!=''?$ad_id."_R".$version_no:"")."</td>
								<!--<td>".number_format($total_order_quantity,0,'.',',')."</td>-->
								<td>".$dia." X ".$length." MM</td>
								<!--<td>".$length." MM</td>-->
								<td>".$print_type."</td>
								<td>".$laminate_color."</td>
								<td>".$body_making_type."</td>
								<td>".'<a href="'.base_url('index.php/sales_order_item_parameterwise/view_new/'.$row->jobcard_no.'/'.$bom_no.'/'.$bom_version_no).'" target="_blank" >'.$row->jobcard_no."</td>
								<td>".number_format($jobcard_qty,0,'.',',')."</td>
								<td>".number_format(round($printed_counter*2),0,'.',',')."</td>

								<td>".$row->abg1_carona_1."</td>
								<td>";
									$ink_1_result=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$row->abg1_ink_id_1);
									foreach ($ink_1_result as $key => $ink_1_row) {
										echo $ink_1_row->ink_desc;
									}
									
								echo "</td>
								<td>".$row->abg1_ink_usage_1."</td>
								<td>";
								$result_anilox1=$this->common_model->select_one_active_record('springtube_anilox_master',$this->session->userdata['logged_in']['company_id'],'anilox_id',$row->abg1_anilox_1);
								foreach ($result_anilox1 as $key => $anilox1_row) {
									echo $anilox1_row->anilox_lpi;
								}								
								echo "</td>
								<td>".($row->abg1_applying_method_1!=''?($row->abg1_applying_method_1==1?'Plate Through':'Roller Through'):'')."</td>
								<td>";
								$cylinder_master_result_1=$this->common_model->select_one_active_record('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id'],'cylinder_id',$row->abg1_cylinder_teeth_1);
		                        foreach ($cylinder_master_result_1 as $cylinder_master_row_1) {
		                            echo $cylinder_master_row_1->teeth;
		                        }
								
								echo "</td>
								<td>".($row->abg1_rotary_1!=''?($row->abg1_rotary_1==1?'[SR]-Semi Rotary':'[FR]-Full Rotary'):'')."</td>
								<td>".($row->abg1_uv_power_1!=''?$row->abg1_uv_power_1." %" :"")." </td>
								<td>".($row->abg1_uv_speed_1!=''?$row->abg1_uv_speed_1." %":"")."</td>
								<td>".($row->abg1_uv_hours_1!=''?$row->abg1_uv_hours_1." HRS":"")."</td>			
								<td>".$row->abg1_unit_1_comment."</td>

								<td>";
									$ink_2_result=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$row->abg1_ink_id_2);
									foreach ($ink_2_result as $key => $ink_2_row) {
										echo $ink_2_row->ink_desc;
									}
									
								echo "</td>
								<td>".$row->abg1_ink_usage_2."</td>
								<td>";
								$result_anilox2=$this->common_model->select_one_active_record('springtube_anilox_master',$this->session->userdata['logged_in']['company_id'],'anilox_id',$row->abg1_anilox_2);
								foreach ($result_anilox2 as $key => $anilox2_row) {
									echo $anilox2_row->anilox_lpi;
								}								
								echo "</td>
								<td>".($row->abg1_applying_method_2!=''?($row->abg1_applying_method_2==1?'Plate Through':'Roller Through'):'')."</td>
								<td>";
								$cylinder_master_result_2=$this->common_model->select_one_active_record('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id'],'cylinder_id',$row->abg1_cylinder_teeth_2);
		                        foreach ($cylinder_master_result_2 as $cylinder_master_row_2) {
		                            echo $cylinder_master_row_2->teeth;
		                        }
								
								echo "</td>
								<td>".($row->abg1_rotary_2!=''?($row->abg1_rotary_2==1?'[SR]-Semi Rotary':'[FR]-Full Rotary'):'')."</td>
								<td>".($row->abg1_uv_power_2!=''?$row->abg1_uv_power_2." %" :"")." </td>
								<td>".($row->abg1_uv_speed_2!=''?$row->abg1_uv_speed_2." %":"")."</td>
								<td>".($row->abg1_uv_hours_2!=''?$row->abg1_uv_hours_2." HRS":"")."</td>							
								<td>".$row->abg1_unit_2_comment."</td>

								<td>";
									$ink_3_result=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$row->abg1_ink_id_3);
									foreach ($ink_3_result as $key => $ink_3_row) {
										echo $ink_3_row->ink_desc;
									}
									
								echo "</td>
								<td>".$row->abg1_ink_usage_3."</td>
								<td>";
								$result_anilox3=$this->common_model->select_one_active_record('springtube_anilox_master',$this->session->userdata['logged_in']['company_id'],'anilox_id',$row->abg1_anilox_3);
								foreach ($result_anilox3 as $key => $anilox3_row) {
									echo $anilox3_row->anilox_lpi;
								}								
								echo "</td>
								<td>".($row->abg1_applying_method_3!=''?($row->abg1_applying_method_3==1?'Plate Through':'Roller Through'):'')."</td>
								<td>";
								$cylinder_master_result_3=$this->common_model->select_one_active_record('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id'],'cylinder_id',$row->abg1_cylinder_teeth_3);
		                        foreach ($cylinder_master_result_3 as $cylinder_master_row_3) {
		                            echo $cylinder_master_row_3->teeth;
		                        }
								
								echo "</td>
								<td>".($row->abg1_rotary_3!=''?($row->abg1_rotary_3==1?'[SR]-Semi Rotary':'[FR]-Full Rotary'):'')."</td>
								<td>".($row->abg1_uv_power_3!=''?$row->abg1_uv_power_3." %" :"")." </td>
								<td>".($row->abg1_uv_speed_3!=''?$row->abg1_uv_speed_3." %":"")."</td>
								<td>".($row->abg1_uv_hours_3!=''?$row->abg1_uv_hours_3." HRS":"")."</td>						
								<td>".$row->abg1_unit_3_comment."</td>

								<td>";
									$ink_4_result=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$row->abg1_ink_id_4);
									foreach ($ink_4_result as $key => $ink_4_row) {
										echo $ink_4_row->ink_desc;
									}
									
								echo "</td>
								<td>".$row->abg1_ink_usage_4."</td>
								<td>";
								$result_anilox4=$this->common_model->select_one_active_record('springtube_anilox_master',$this->session->userdata['logged_in']['company_id'],'anilox_id',$row->abg1_anilox_4);
								foreach ($result_anilox4 as $key => $anilox4_row) {
									echo $anilox4_row->anilox_lpi;
								}								
								echo "</td>
								<td>".($row->abg1_applying_method_4!=''?($row->abg1_applying_method_4==1?'Plate Through':'Roller Through'):'')."</td>
								<td>";
								$cylinder_master_result_4=$this->common_model->select_one_active_record('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id'],'cylinder_id',$row->abg1_cylinder_teeth_4);
		                        foreach ($cylinder_master_result_4 as $cylinder_master_row_4) {
		                            echo $cylinder_master_row_4->teeth;
		                        }
								
								echo "</td>
								<td>".($row->abg1_rotary_4!=''?($row->abg1_rotary_4==1?'[SR]-Semi Rotary':'[FR]-Full Rotary'):'')."</td>
								<td>".($row->abg1_uv_power_4!=''?$row->abg1_uv_power_4." %" :"")." </td>
								<td>".($row->abg1_uv_speed_4!=''?$row->abg1_uv_speed_4." %":"")."</td>
								<td>".($row->abg1_uv_hours_4!=''?$row->abg1_uv_hours_4." HRS":"")."</td>								
								<td>".$row->abg1_unit_4_comment."</td>

								<td>".($row->is_durst==1?"YES":"NO")."</td>
								<td>".$row->durst_corona."</td>
								<td>".$row->print_confg."</td>
								<td>".$row->digital_white."</td>
								<td>";
								$springtube_printing_color_policy_master_result=$this->common_model->select_one_active_record('springtube_printing_color_policy_master',$this->session->userdata['logged_in']['company_id'],'id',$row->colour_policy);
					            foreach ($springtube_printing_color_policy_master_result as $key => $springtube_printing_color_policy_master_row) {
					                
					                echo $springtube_printing_color_policy_master_row->colour_policy;
					            }								
								echo 
								"</td>
								<td>".$row->substrate_defination."</td>
								<td>".$row->printing_speed."</td>
								<td>".$row->unwind_tension."</td>
								<td>".$row->pinning_w." %</td>
								<td>".$row->pinning_k." %</td>
								<td>".$row->durst_uv_curing_1." %</td>
								<td>".$row->durst_uv_lamp_hrs_1."</td>
								<td>".$row->durst_uv_curing_2." %</td>
								<td>".$row->durst_uv_lamp_hrs_2."</td>
								<td>".$row->nitrogen."</td>
								<td>".$row->durst_comment."</td>
								<td>".$row->digital_cost_in_euro."</td>

								<td>".$row->abg2_carona_1."</td>

								<td>";
									$ink_5_result=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$row->abg2_ink_id_1);
									foreach ($ink_5_result as $key => $ink_5_row) {
										echo $ink_5_row->ink_desc;
									}
									
								echo "</td>
								<td>".$row->abg2_ink_usage_1."</td>

								<td>";
								$result_anilox5=$this->common_model->select_one_active_record('springtube_anilox_master',$this->session->userdata['logged_in']['company_id'],'anilox_id',$row->abg2_anilox_2);
								foreach ($result_anilox5 as $key => $anilox5_row) {
									echo $anilox5_row->anilox_lpi;
								}								
								echo "</td>
								<td>".($row->abg2_applying_method_1!=''?($row->abg2_applying_method_1==1?'Plate Through':'Roller Through'):'')."</td>
								<td>";
								$cylinder_master_result_5=$this->common_model->select_one_active_record('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id'],'cylinder_id',$row->abg2_cylinder_teeth_2);
		                        foreach ($cylinder_master_result_5 as $cylinder_master_row_5) {
		                            echo $cylinder_master_row_5->teeth;
		                        }
								
								echo "</td>
								<td>".($row->abg2_rotary_1!=''?($row->abg2_rotary_1==1?'[SR]-Semi Rotary':'[FR]-Full Rotary'):'')."</td>
								<td>".($row->abg2_uv_power_1!=''?$row->abg2_uv_power_1." %" :"")." </td>
								<td>".($row->abg2_uv_speed_1!=''?$row->abg2_uv_speed_1." %":"")."</td>
								<td>".($row->abg2_uv_hours_1!=''?$row->abg2_uv_hours_1." HRS":"")."</td>
								
								<td>".$row->abg2_unit_1_comment."</td>

								<td>";
									$ink_6_result=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$row->abg2_ink_id_2);
									foreach ($ink_6_result as $key => $ink_6_row) {
										echo $ink_6_row->ink_desc;
									}
									
								echo "</td>
								<td>".$row->abg2_ink_usage_2."</td>
								<td>";
								$result_anilox6=$this->common_model->select_one_active_record('springtube_anilox_master',$this->session->userdata['logged_in']['company_id'],'anilox_id',$row->abg2_anilox_2);
								foreach ($result_anilox6 as $key => $anilox6_row) {
									echo $anilox6_row->anilox_lpi;
								}								
								echo "</td>
								<td>".($row->abg2_applying_method_2!=''?($row->abg2_applying_method_2==1?'Plate Through':'Roller Through'):'')."</td>
								<td>";
								$cylinder_master_result_6=$this->common_model->select_one_active_record('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id'],'cylinder_id',$row->abg2_cylinder_teeth_2);
		                        foreach ($cylinder_master_result_6 as $cylinder_master_row_6) {
		                            echo $cylinder_master_row_6->teeth;
		                        }
								
								echo "</td>
								<td>".($row->abg2_rotary_2!=''?($row->abg2_rotary_2==1?'[SR]-Semi Rotary':'[FR]-Full Rotary'):'')."</td>

								<td>".($row->is_extended_path!=''|| $row->abg2_uv_power_2 !=''?($row->is_extended_path=="YES"?$row->abg2_extended_uv_power_2.' %' :$row->abg2_uv_power_2.' %'):"")."</td>
								<td>".($row->is_extended_path!=''|| $row->abg2_uv_power_2 !=''?($row->is_extended_path=="YES"?$row->abg2_extended_uv_speed_2.' %':$row->abg2_uv_speed_2.' %'):"")."</td>
								<td>".($row->is_extended_path!=''|| $row->abg2_uv_power_2 !=''?($row->is_extended_path=="YES"?$row->abg2_extended_uv_hours_2.' Hrs' :$row->abg2_uv_hours_2.' Hrs'):"")."</td>
								<td>".$row->abg2_unit_2_comment."</td>
								<td>".$row->is_extended_path."</td>								
								<!--<td>".$row->slitting."</td>-->

								<td>".$this->common_model->get_user_name($row->user_id,$this->session->userdata['logged_in']['company_id'])."</td>								
								<td>".($row->approval_date!=''?$this->common_model->view_date($row->approval_date,$this->session->userdata['logged_in']['company_id']):"")."</td>
								<td>".$this->common_model->get_user_name($row->approved_by,$this->session->userdata['logged_in']['company_id'])."</td>";									

							echo "</tr>";				 


							$i++;
							}
						}?>							 
							 	
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>