<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){

		
	    $("table tr").click(function(e){
	    	$("table tr").removeClass('on-hower');	
	        $(this).addClass('on-hower');
	    });    


	});
</script>

<style>
	.on-hower{
        background-color:#e4e4e4;
    }
	tr:hover {background-color:#e4e4e4;}
</style>
<!-- <style>	
   tr:hover {background-color:#e4e4e4;}
</style> -->
<div class="record_form_design">
	<h4>Active Records <?php echo ($this->input->post('from_date')!=''? 'From '.$this->input->post('from_date').' To '.$this->input->post('to_date'):'')?></h4>
	<div class="record_inner_design" style="overflow: scroll; white-space: nowrap;">
			

			<table class="ui very basic collapsing celled table"  style="font-size:10px;">
				
				<thead>
				<tr>
					
					<th>Sr no.</th>
					<th>Action</th>
					<th>Date</th>					
					<th>Shift</th>					
					<!-- <th>Machine</th> -->
					<!-- <th>Job Type</th>
					<th>Job Category</th> -->
					
					<!-- <th>Jobsetup?</th>
					<th>Inspection?</th> -->						
					<th>Customer</th>
					<th>Order No</th>
					<th>Article No.</th>
					<!-- <th>Product Name</th> -->
					<th>Dia X Length</th>
					<!-- <th>Length</th> -->
					<th>Print Type</th>
					<th>Film Color</th>
					<th>Body Making</th>
					<th>Jobcard No.</th>					
					<th>Job Counter</th>
					<th>Jobcard Qty</th>
					<th>Prod.Counter</th>										
					<th>Prod.Qty</th>
					<th>Jobsetup?</th>
					<th>Inspection?</th>

					<th>Job Type</th>
					<th>Job Category</th>
					<th>Job Started On</th>
					<th>Job Ended On</th>
					<th>Job End Reason</th>
					<th>Remarks</th>
					<th>User Name</th>
					<th>Action</th>
				
									
				</tr>	
				</thead>
				<tbody>
				<?php 

				$sum_counter=0;
				$sum_printed_qty=0;
				$printing_done='0';
				$sum_jobcard_qty=0;
				$sum_jobcard_counter=0;

				if($springtube_printing_production_master==FALSE){
					echo "<tr><td colspan='25'>No Active Records Found</td></tr>";
				}
				else{

					$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
					
					$reel_length=$this->config->item('springtube_reel_length');
					$n=1;	
					foreach($springtube_printing_production_master as $master_row){
						
						

            			$details_data=array();
						$details_data['production_date']=$master_row->production_date;
						$details_data['shift']=$master_row->shift;

						if(!empty($this->input->post('order_no'))){
						 	
						 	$details_data['order_no']=$this->input->post('order_no');
						}
						if(!empty($this->input->post('jobcard_no'))){
						 	
						 	$details_data['jobcard_no']=$this->input->post('jobcard_no');
						}

						if(!empty($this->input->post('article_no'))){
						 	$arr=explode("//",$this->input->post('article_no'));
						 	$article_no=$arr[1];
						 	$details_data['article_no']=$article_no;
						}

						if(!empty($this->input->post('customer'))){
						 	$customer_arr=explode("//",$this->input->post('customer'));
						 	$customer=$customer_arr[1];
						 	$details_data['customer']=$customer;
						}						
					

						if(!empty($this->input->post('job_type'))){
						 	
						 	$details_data['job_type']=$this->input->post('job_type');
						}

						if(!empty($this->input->post('job_category'))){
						 	
						 	$details_data['job_category']=$this->input->post('job_category');
						}

						if(!empty($this->input->post('laminate_color'))){
						 	
						 	$details_data['laminate_color']=$this->input->post('laminate_color');
						}
						if(!empty($this->input->post('print_type'))){
						 	
						 	$details_data['print_type']=$this->input->post('print_type');
						}
						if(!empty($this->input->post('shift_issues'))){
						 	
						 	$details_data['shift_issues']=$this->input->post('shift_issues');
						}



							
						$result=$this->springtube_printing_production_model->select_active_shiftwise_master_records('springtube_printing_production_master',$details_data,$this->session->userdata['logged_in']['company_id']);
						//echo $this->db->last_query();
						
						$rowspan=count($result);
		    			$tr=$rowspan;

		    			if($rowspan>0){		    				

		    				echo '<tr>
		    				<td rowspan="'.$rowspan.'">'.$n++.'</td>
		    				<td rowspan="'.$rowspan.'">';
		    				foreach($formrights as $formrights_row){ 
								echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view_shiftwise/'.$master_row->production_date.'/'.$master_row->shift.'').'" target="_blank"><i class="print icon"></i></a> ' : '');
							}	

							echo '</td>							
							<td rowspan="'.$rowspan.'">'.$this->common_model->view_date($master_row->production_date,$this->session->userdata['logged_in']['company_id']).'</td>
							<td rowspan="'.$rowspan.'">'.$master_row->shift.'</td>
							';

							$r=0;
							foreach ($result as $drow){


								$order_no='';
								$article_no='';
								$jobcard_qty='';
								$ad_id='';
		            			$version_no='';
		            			$bom_no='';
		            			$bom_version_no='';
		            			$printing_done=0;
		            			$inspection_done=0;
		            			$print_type_artwork='';
								$cold_foil_1='';
								$cold_foil_2='';
								$ups=2;	
								$sleeve_dia='';	            			

								$data['production_master']=$this->job_card_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$drow->jobcard_no);					        

						        foreach ($data['production_master'] as $production_master_row) {
						        	$order_no=$production_master_row->sales_ord_no;
						        	$article_no=$production_master_row->article_no;
						          
						            $jobcard_qty=$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
						          
						            $printing_done=$production_master_row->printing_done;
						            $inspection_done=$production_master_row->inspection_done;
						        }

								$data_order_details=array(
				                    'order_no'=>$order_no,
				                    'article_no'=>$article_no
				                    );

				                $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
				                foreach($order_details_result as $order_details_row){
				                  $ad_id=$order_details_row->ad_id;
				                  $version_no=$order_details_row->version_no;
				                  $bom_no=$order_details_row->spec_id;
				                  $bom_version_no=$order_details_row->spec_version_no;
				                }

				                $artwork_springtube['ad_id']=$ad_id;
								$artwork_springtube['version_no']=$version_no;
								$search='';
								$from='';
								$to='';
								$artwork_springtube_result=$this->artwork_springtube_model->active_record_search_new('springtube_artwork_devel_master',$artwork_springtube,$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
								

								//print_r($artwork_result);
								foreach ($artwork_springtube_result as $artwork_springtube_row) {
									$print_type_artwork=$artwork_springtube_row->print_type;
									$cold_foil_1=$artwork_springtube_row->cold_foil_1;
									$cold_foil_2=$artwork_springtube_row->cold_foil_2;
									$sleeve_dia=$artwork_springtube_row->sleeve_dia;

								}

								$sleeve_id='';
				                $sleeve_diameter_master_result=$this->common_model->select_one_active_record('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id'],'sleeve_diameter',$sleeve_dia);

				                foreach ($sleeve_diameter_master_result as $key => $sleeve_diameter_master_row) {
				                	$sleeve_id=$sleeve_diameter_master_row->sleeve_id;
				                }


				                $data=array('sleeve_dia_id'=>$sleeve_id
                        		);

						        $result_spring_width_calculation=$this->common_model->select_active_records_where('spring_width_calculation',$this->session->userdata['logged_in']['company_id'],$data);

						        
						        $ups=0; 
						                  
						        foreach ($result_spring_width_calculation as $spring_width_calculation_row) {
						          $ups=$spring_width_calculation_row->ups;
						          
						        }

				    


				                $search_arr=array('production_id'=>$drow->production_id);
							
							    $springtube_printing_production_details_result=$this->springtube_printing_production_model->active_details_records('springtube_printing_production_details',$search_arr);
								$printed_counter=0;    
								foreach ($springtube_printing_production_details_result as $springtube_printing_production_details_row) {
									$printed_counter+=$springtube_printing_production_details_row->counter;
								}


								echo"
								<!--<td>".$drow->machine_name."
								--></td>
								
								

								";
								
								/*<$data_search=array('jobcard_no'=>$drow->jobcard_no,'archive'=>'0');

								$springtube_printing_jobsetup_master_result=$this->common_model->select_active_records_where('springtube_printing_jobsetup_master',$this->session->userdata['logged_in']['company_id'],$data_search);

								if($springtube_printing_jobsetup_master_result==TRUE){

									foreach ($springtube_printing_jobsetup_master_result as $key => $springtube_printing_jobsetup_master_row) {
									
										echo
										"<a href='".base_url('index.php/Springtube_printing_jobsetup/view/'.$springtube_printing_jobsetup_master_row->job_id)."' target='_blank' style='color:#06c806;' ><i class='check circle icon'></i> Done<a>";
									}
								}else{

									echo'<a href="#" style="color: #f10606;"><i class="times circle icon"></i>Pending</a>';
								} 
								echo"</td>
								<td>";

								if($inspection_done){

									echo"<a  href='#' target='_blank' style='color:#06c806;' ><i class='check circle icon'></i> Done<a>";

								}else{
									echo'<a href="#" style="color: #f10606;"><i class="times circle icon"></i>Pending</a>';
								}
							*/
								echo"
								
								<!--<td>".$this->common_model->get_customer_name($drow->customer,$this->session->userdata['logged_in']['company_id'])."</td>
								-->
								<td>".$this->common_model->get_parent_name($drow->article_no,$this->session->userdata['logged_in']['company_id'])."</td>

								<td><a href='".base_url('index.php/sales_order_book/view/'.$drow->order_no)."' target='_blank'> ".$drow->order_no."</a></td>			
								<td title='".$this->common_model->get_article_name($drow->article_no,$this->session->userdata['logged_in']['company_id'])."'>".$drow->article_no."</td>	
								<td>".$drow->sleeve_dia." X ".$drow->sleeve_length."</td>
								<!--<td>".$drow->sleeve_length."</td>-->
								<td>".$drow->print_type."</td>
								<td>".$drow->laminate_color."</td>
								<td>".$drow->body_making_type."</td>
								<td><a href='".base_url('index.php/sales_order_item_parameterwise/view_new/'.$drow->jobcard_no.'/'.$bom_no.'/'.$bom_version_no)."' target='_blank'>".$drow->jobcard_no."</td>
								<td>".number_format($jobcard_qty/$ups,0,'.',',')."</td>
								<td>".number_format($jobcard_qty,0,'.',',')."</td>								
								<td class='positive right aligned'><b>".number_format($printed_counter,0,'.',',')."</b></td>
								<td class='positive right aligned'><b>".number_format($printed_counter*$ups,0,'.',',')."</b></td>
								<td>";
								$data_search=array('jobcard_no'=>$drow->jobcard_no,'archive'=>'0');

								$springtube_printing_jobsetup_master_result=$this->common_model->select_active_records_where('springtube_printing_jobsetup_master',$this->session->userdata['logged_in']['company_id'],$data_search);

								if($springtube_printing_jobsetup_master_result==TRUE){

									foreach ($springtube_printing_jobsetup_master_result as $key => $springtube_printing_jobsetup_master_row) {
									
										echo
										"<a href='".base_url('index.php/Springtube_printing_jobsetup/view/'.$springtube_printing_jobsetup_master_row->job_id)."' target='_blank' style='color:#06c806;' ><i class='check circle icon'></i> Done<a>";
									}
								}else{

									echo'<a href="#" style="color: #f10606;"><i class="times circle icon"></i>Pending</a>';
								} 
								echo"</td>
								<td>";

								if($inspection_done){

									echo"<a  href='#' target='_blank' style='color:#06c806;' ><i class='check circle icon'></i> Done<a>";

								}else{
									echo'<a href="#" style="color: #f10606;"><i class="times circle icon"></i>Pending</a>';
								}
								echo"</td>
								<td>".$drow->job_type."</td>								
								<td >".($drow->job_category!=''?($drow->job_category==1?"NEW JOB":"REPEAT JOB"):"")."</td>
								
								<td>".$this->common_model->view_date($drow->job_started_on,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".($drow->job_ended_on!='0000-00-00 00:00:00'?$this->common_model->view_date($drow->job_ended_on,$this->session->userdata['logged_in']['company_id']):"")."</td>
								<td>".$drow->shift_issue."</td>
								<td>".$drow->remarks."</td>
								<td>".$this->common_model->get_user_name($drow->user_id,$this->session->userdata['logged_in']['company_id'])."</td>
								<td >";
									foreach ($formrights as $formrights_row) {

										echo ($formrights_row->view==1 ? ' | <a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$drow->production_id.'').'" title="view" target="_blank"><i class="print icon"></i></a>' : '');

										echo ($formrights_row->modify==1 && $printing_done<>1 ? ' | <a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$drow->production_id.'').'" title="Modify" target="_blank"><i class="edit icon"></i></a>' : '');

										echo ($formrights_row->delete==1 ? ' | <a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$drow->production_id.'').'" title="Delete" target="_blank"><i class="trash icon"></i></a> ' : '');
											
									}
							echo"</td>";
							echo"</tr>";

							$sum_counter+=$printed_counter;
							$sum_printed_qty+=$printed_counter*$ups;
								if($rowspan>1 && --$tr>0){
									echo'<tr>';
								}			

								$r++;


							}

            			 
					    }	


					}//master Foreach

					echo'<tr style="color:blue;font-weight:bold;"><td colspan="14" style="text-align:right;">TOTAL</td>
							<td class="positive right aligned"><b>'.number_format($sum_counter,0,'.',',').'</b></td>
							<td class="positive right aligned"><b>'.number_format($sum_printed_qty,0,'.',',').'</b></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>';	 

				}?>

			</tbody>								
			</table>
			<div class="pagination"><?php echo $this->pagination->create_links();?></div>
	</div>
</div>