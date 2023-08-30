
<div class="record_form_design">
	<h3>Active Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Order Date</th>
					<th>Order No</th>
					<th>Customer</th>
					<th>Customer Po No/Date</th>
					<th>Article No</th>
					<th>Article Name</th>
					<th>DiaXLength</th>
					<th>Specification</th>
					<th>Artwork</th>
					<th>Serial No Range</th>
					<th>Unit Box</th>
					<th>Action</th>


					
				</tr>
				<?php if($order_master==FALSE){
					echo "<tr><td colspan='11'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?1:$this->uri->segment(3));
							foreach($order_master as $mrow){

								$details_data=array();
								$details_data['order_no']=$mrow->order_no;
								if(!empty($this->input->post('article_no'))){
									$arr=explode("//",$this->input->post('article_no'));
									$article_no=$arr[1];
									$details_data['article_no']=$article_no;
								}
								$result=$this->sales_order_book_model->active_details_records_new('order_details',$details_data,$this->session->userdata['logged_in']['company_id'],'','');

								$rowspan=count($result);
							    $tr=$rowspan;

							    if($rowspan>0){
							    	echo"
									<tr>
										<td rowspan='".$rowspan."'>".$i++."</td>
										<td rowspan='".$rowspan."'>".$this->common_model->view_date($mrow->order_date,$this->session->userdata['logged_in']['company_id'])."</td>
										<td rowspan='".$rowspan."'>".($mrow->final_approval_flag==1 ? "<i class='check circle icon'></i>" : "")." <a href=".base_url('index.php/sales_order_book/view/'.$mrow->order_no)." target='_blank'>".$mrow->order_no."</a></td>
										<td rowspan='".$rowspan."'>".$mrow->name1." (".strtoupper($mrow->lang_property_name).") </td>
										<td rowspan='".$rowspan."'>".$mrow->cust_order_no."/".$this->common_model->view_date($mrow->cust_order_date,$this->session->userdata['logged_in']['company_id'])."</td>";

										
										$sleeve_code='';
										$dia='';
										$length='';
										$r=0;
										foreach ($result as $drow){

											$bom_data['bom_no']=$drow->spec_id;
											$bom_data['bom_version_no']=$drow->spec_version_no;

									    	$bom_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$bom_data);
									    	if($bom_result){
									    		foreach($bom_result as $bom_result_row){										
									    			$sleeve_code=$bom_result_row->sleeve_code;
									    			
									    		}

									    		$sleeve_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$sleeve_code);

									    		//echo $this->db->last_query();

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
													$specs_result=$this->sales_order_book_model->select_sleeve_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);

													//echo $this->db->last_query();


													if($specs_result){
														foreach($specs_result as $specs_row){
															$dia=$specs_row->SLEEVE_DIA;
															$length=$specs_row->SLEEVE_LENGTH;	

														}
												    }
												}
											}	    

											echo"<td>".$drow->article_no."</td>
											<td>".$this->common_model->get_article_name($drow->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
											<td>".$dia."X".$length."MM</td>
											<td>

											";
											if(!empty($drow->spec_id)){

												if(substr($drow->spec_id,0,1)=="S"){
													echo "<a href='".base_url()."/index.php/specification/view/".$drow->spec_id."/".$drow->spec_version_no." ' target='blank'>".$drow->spec_id."_".$drow->spec_version_no."</a>";
												}else{

													$bom=array('bom_no'=>$drow->spec_id,'bom_version_no'=>$drow->spec_version_no);
													$data['bom']=$this->common_model->select_active_records_where("bill_of_material",$this->session->userdata['logged_in']['company_id'],$bom);
													
													foreach($data['bom'] as $bom_row){							
														echo "<a href='".base_url()."/index.php/bill_of_material/view/".$bom_row->bom_id."' target='blank'>".$drow->spec_id."_".$drow->spec_version_no."</a>";
													}									
												}
											}

											echo"</td>
											<td>";

											if($drow->ad_id!='' && substr($drow->ad_id,0,2)=='AW'){
												echo"<a href='".base_url()."/index.php/artwork_new/view/".$drow->ad_id."/".$drow->version_no." ' target='blank'>".($drow->ad_id!=""? $drow->ad_id."_R".$drow->version_no:"")."</a>";
											}else if($drow->ad_id!='' && substr($drow->ad_id,0,3)=='SAW'){

												echo"<a href='".base_url()."/index.php/artwork_springtube/view/".$drow->ad_id."/".$drow->version_no." ' target='blank'>".($drow->ad_id!=""? $drow->ad_id."_R".$drow->version_no:"")."</a>";
											}
											echo"</td>


											<td>
											<form target='_blank' name='lable_printing' method='post' action='".base_url('index.php/'.$this->router->fetch_class().'/view')."'/>
											<input type='hidden' name='order_no' value='".$mrow->order_no."'/>
											<input type='hidden' name='article_no' value='".$drow->article_no."'/>
											<input type='number' name='start_range' min='1' max='10000000' step='1' required/><input type='number' name='end_range' min='1' max='10000000' step='1' required/>
											</td>
											<td>
											<input type='number' name='unit_box' min='1' max='10000000' step='1' required/>

											</td>
											<td>
											<div class='ui buttons'>
											<button class='ui positive button'>View</button>
											</div>
											</form>
											</td>
										</tr>";
											if($rowspan>1 && --$tr>0){
													echo'<tr>';
											}			

											$r++;									

										}										

									echo"</tr>";
								}
							}

					}?>
							
						</table>
						
	</div>
</div>