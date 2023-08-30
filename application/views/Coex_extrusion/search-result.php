<div class="record_form_design">
<?php 
setlocale(LC_MONETARY, 'en_IN');
if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
<h4>Search Records From <?php echo $this->input->post('from_date');?> To <?php echo $this->input->post('to_date');?></h4>
	<div class="record_inner_design" style="overflow: scroll;">
			<table class="ui very basic collapsing celled table"  style="font-size:10px;">
				<thead>
				<tr>
					<th>Id</th>
					<th>Date</th>
					<th>Machine</th>
					<th>Shift</th>
					<th>Order No</th>
					<th>Product No</th>
					<th>Job No</th>
					<th>Sleeve Weight</th>
					<th>Dia</th>
					<th>Length</th>
					<th>Rm Used Kg</th>
					<th>Production Qty</th>
					<th>Scrap Qty</th>
					<th>Scrap Weight Kg</th>
					<!--<th>Job Runtime</th>-->
					<th>Cutting Speed</th>
					<th>R %</th>
					<th>QC</th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody>
				<?php if($coex_extrusion==FALSE){
					echo "<tr><td colspan='15'>No Active Records Found</td></tr>";
				}else{
						$i=1;
						foreach($coex_extrusion as $row){

							
							echo "<tr>
									<td>".$i."</td>
									<td>".$this->common_model->view_date($row->extrusion_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$row->machine_name."</td>
									<td>".$row->shift_name."</td>
									<td>".($row->order_no=='' ? 'Purging' : $row->order_no)."</td>
									<td>".$row->article_no."</td>
									<td>".$row->jobcard_no."</td>
									<td class='right aligned'>".($row->sleeve_weight_kg*1000)."<i> Gm</i></td>
									<td>".$row->diameter."</td>
									<td>".($row->length=='' ? '' : $row->length." MM")."</td>
									<td class='right aligned'>".$row->rm_mixed_qty_kg." Kg</td>
									<td class='positive right aligned'><b>".money_format('%!.0n',$row->ok_qty_no)."</b><i> No</i></td>
									<td class='negative right aligned'><b>".($row->scrap_tube_no!=0 ? money_format('%!.0n',$row->scrap_tube_no) : '0')."</b> <i>No</i></td>
									<td class='right aligned'>".round($row->scrap_weight_kg,1)." <i>Kg</i></td>
									<td class='right aligned'>".$row->cutting_speed_minutes." <i>Min</i></td>
									<td class='warning right aligned'>".round($row->rejection_percentage)."%</td>
									<td>".($row->qc_status==1 ? '<i class="check circle icon"></i>' :'<a href="'.base_url('index.php/'.$this->router->fetch_class().'/qc_check/'.$row->ce_id).'"><i class="hand paper icon"></i></a>')."</td>
									<td>";

									foreach($formrights as $formrights_row){ 

										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->ce_id).'" target="_blank"><i class="print icon"></i></a> ' : '');


										echo ($formrights_row->modify==1 && $row->final_approval_flag<>1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->ce_id).'"><i class="edit icon"></i></a> ' : '');

										echo ($row->archive<>1 && $formrights_row->delete==1 && $row->final_approval_flag<>1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->ce_id).'"><i class="trash icon"></i></a> ' : '');
										
									} 
									echo "</td>

									</tr>";
							$i++;
						}
					}
					?>
			</tbody>				
		</table>
						
	</div>	
</div>