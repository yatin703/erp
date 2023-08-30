<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/javascript/semantic.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.address/1.6/jquery.address.min.js"></script>
<script>
	$(document).ready(function(){

		$('.menu .item').tab();
});
</script>

<div class="record_form_design">
	<div class="record_inner_design" style="overflow: scroll;">
		<div class="row">
			<div class="column">
				
				<div class="ui top attached tabular menu">
					
						<?php foreach($coex_machine_master as $machine_row){?>
							<a class="red item"  data-tab="<?php echo $machine_row->machine_id;?>"><?php echo $machine_row->machine_name;?></a>
						<?php } ?>
				</div>
		        <?php foreach($coex_machine_master as $machine_row){?>
				<div class="ui bottom attached tab segment active" data-tab="<?php echo $machine_row->machine_id;?>">

				<table class="ui selectable celled table" style="font-size:10px;">
						<thead>
							<tr>
								<th>Id</th>
								<th>Date</th>
								<th >Machine</th>
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
								<th>Cutting Speed</th>
								<th>R %</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$sum_rm_mixed_qty_kg=0;
				            $sum_ok_qty_no=0;
				            $sum_scrap_tube_no=0;
				            $sum_scrap_weight_kg=0;
				            $sum_box=0;

                            $data = array('coex_extrusion.machine_id'=>$machine_row->machine_id);
							$from=$this->input->post('from_date');
                            $to=$this->input->post('to_date');
                            $data['coex_extrusion']=$this->coex_extrusion_model->active_record_search('coex_extrusion',$data,$from,$to,$this->session->userdata['logged_in']['company_id']);
                            //echo $this->db->last_query();

							if($data['coex_extrusion']==FALSE){
							echo "<tr><td colspan='15'>No Active Records Found</td></tr>";
							}else{
							$i=1;
							foreach($data['coex_extrusion'] as $row){


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
									
									<td>";

									foreach($formrights as $formrights_row){ 

										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->ce_id).'" target="_blank"><i class="print icon"></i></a> ' : '');


										echo ($formrights_row->modify==1  ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->ce_id).'"><i class="edit icon"></i></a> ' : '');

										echo ($row->archive<>1 && $formrights_row->delete==1  ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->ce_id).'"><i class="trash icon"></i></a> ' : '');
										
									} 
									echo "</td>

									</tr>";
							$i++;

						   $sum_rm_mixed_qty_kg+=$row->rm_mixed_qty_kg;
			               $sum_ok_qty_no+=$row->ok_qty_no;
			               $sum_scrap_tube_no+=$row->scrap_tube_no;
			               $sum_scrap_weight_kg+=$row->scrap_weight_kg;
						}
						echo"<tr><td colspan='10' style='text-align:right;'><b>TOTAL</b></td>
                            <td class=' right aligned'><b>".number_format($sum_rm_mixed_qty_kg,0,'.',',')." <i>Kg</i></b></td>
                            <td class='positive right aligned'><b>".number_format($sum_ok_qty_no,0,'.',',')." <i>NOS</i></b></td>
                            <td class='negative right aligned'><b>".number_format($sum_scrap_tube_no,0,'.',',')." <i>NOS</i></b></td>
                            <td class=' right aligned'><b>".number_format($sum_scrap_weight_kg,0,'.',',')." <i>Kg</i></b></td></tr>";
					}
					?>
						</tbody>
				    </table>
					
				</div>
				<?php } ?>
			</div>
		</div>


