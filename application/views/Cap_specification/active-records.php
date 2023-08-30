<div class="record_form_design">
	<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
<h4>Active Records</h4>
	<div class="record_inner_design" style="overflow: scroll;">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					
					<th>Date</th>
					<th>Cap Code</th>
					<th>Type</th>
					<th>Finish</th>
					<th>Dia</th>
					<th>Orifice</th>
					<th>MB %</th>
					<th>Foil</th>
					<th>Foil Width</th>
					<th>C.Foil Dist From Bot</th>
					<th>Shrink Sleeve</th>
					<th>Metalization</th>
					<th>Closing Stock</th>
					<th>Created By</th>
					<th>Approved Date</th>
					<th>Approved By</th>
					<th>Action</th>
				</tr>
				<?php if($specification==FALSE){
					echo "<tr><td colspan='16'>No Active Records Found</td></tr>";
				}else{
								$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
								
							foreach($specification as $row){
								$cap_stock=0;

								$data=array('spec_id'=>$row->spec_id,
									'spec_version_no'=>$row->spec_version_no);
								$data['specs_details']=$this->sales_order_book_model->select_cap_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);
								foreach($data['specs_details'] as $specs_details_row){
									$CAP_STYLE=$specs_details_row->CAP_STYLE;
									$CAP_MOLD_FINISH=$specs_details_row->CAP_MOLD_FINISH;
									$CAP_ORIFICE=$specs_details_row->CAP_ORIFICE;
									$CAP_DIA=$specs_details_row->CAP_DIA;
									$CAP_FOIL_COLOR=$specs_details_row->CAP_FOIL_COLOR;
									$CAP_FOIL_WIDTH=$specs_details_row->CAP_FOIL_WIDTH;
									$CAP_SHRINK_SLEEVE=$specs_details_row->CAP_SHRINK_SLEEVE;
									$CAP_MASTER_BATCH=$specs_details_row->CAP_MASTER_BATCH;
									$CAP_METALIZATION=$specs_details_row->CAP_METALIZATION;
									$CAP_MB_PERC=$specs_details_row->CAP_MB_PERC;
									$CAP_FOIL_DIST_FROM_BOT=$specs_details_row->CAP_FOIL_DIST_FROM_BOT;
								}

								$data['cap_mb_result']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$CAP_MASTER_BATCH);

								foreach($data['cap_mb_result'] as $cap_mb_row){
									$mb_name=$cap_mb_row->article_name;
								}
								
								$conn=mysqli_connect('192.168.0.33','root','NewUser@php','tw-erp');
								$stock_query="SELECT closing_stock from stock_athal where item_code='$row->article_no' order by date desc limit 0,1";
								$result_stock_query=mysqli_query($conn,$stock_query);
								while($row_cap_stock = mysqli_fetch_array($result_stock_query)){
									$cap_stock=$row_cap_stock['closing_stock'];
								}
								
								echo "<tr>
									<td>".$i."</td>
									<td>".$this->common_model->view_date($row->spec_created_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td title='".$this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id'])."'><a href=".base_url('index.php/'.$this->router->fetch_class().'/view_cap/'.$row->spec_id.'/'.$row->spec_version_no)." target='_blank'>".$row->article_no."</a></td>
									<td>".$CAP_STYLE."</td>
									<td>".$CAP_MOLD_FINISH."</td>
									<td>".$CAP_DIA."</td>
									<td>".$CAP_ORIFICE."</td>
									<td style='backgroud:$mb_name'>".$mb_name." ".$CAP_MB_PERC."%</td>
									<td>".$CAP_FOIL_COLOR."</td>
									<td>".$CAP_FOIL_WIDTH.($CAP_FOIL_COLOR!=""?"MM":"")."</td>
									<td>".($CAP_FOIL_DIST_FROM_BOT!=''?$CAP_FOIL_DIST_FROM_BOT."MM":"")."</td>
									<td>".$CAP_SHRINK_SLEEVE."</td>
									<td>".$CAP_METALIZATION."</td>
									<td>".number_format($cap_stock)."</td>
									<td><a class='ui tiny label'><i class='user icon'></i> ".strtoupper($this->common_model->get_user_name($row->user_id,$this->session->userdata['logged_in']['company_id']))."</a></td>
									<td>".$this->common_model->view_date($row->approval_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".($row->approved_by!='' ? "<a class='ui tiny label'><i class='checkmark box icon'></i>":'' )."".strtoupper($this->common_model->get_user_name($row->approved_by,$this->session->userdata['logged_in']['company_id']))."</td>
									<td>";
									foreach($formrights as $formrights_row){ 

										echo ($formrights_row->view==1 && substr($row->dyn_qty_present,4,1)==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view_cap/'.$row->spec_id.'/'.$row->spec_version_no).'" target="_blank"><i class="print icon"></i></a> ' : '');

										echo ($formrights_row->modify==1 && $row->final_approval_flag<>1 && $row->pending_flag<>1  && $row->user_id==$this->session->userdata['logged_in']['user_id'] && substr($row->dyn_qty_present,4,1)==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify_cap/'.$row->spec_id.'/'.$row->spec_version_no).'"><i class="edit icon"></i></a> ' : '');

									
										echo ($formrights_row->copy==1 && $row->final_approval_flag==1  ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/copy_cap/'.$row->spec_id.'/'.$row->spec_version_no).'" target="_blank"><i class="copy icon"></i></a> ' : '');

										echo ($row->archive<>1 && $formrights_row->delete==1 && $row->final_approval_flag<>1 && $row->pending_flag<>1 && $row->user_id==$this->session->userdata['logged_in']['user_id'] ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete_cap/'.$row->spec_id.'/'.$row->spec_version_no).'"><i class="trash icon"></i></a> ' : '');

										
									}
									echo "</td>
							</tr>";
							$i++;
							}
						}?>
								
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>
