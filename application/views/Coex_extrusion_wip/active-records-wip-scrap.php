<style>
   .on-hower{
        background-color:#e4e4e4;
    }
   tr:hover {background-color:#e4e4e4;}
   th{text-align: center !important;padding: 5px 5px 5px 5px !important;border-top: 1px solid rgba(34,36,38,.1)}
   table th{background-color:#e4e4e4 !important;font-size: 12px;}
</style>
<div class="record_form_design">
<?php 
setlocale(LC_MONETARY, 'en_IN');
if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
<h4>Active Records</h4>
	<div class="record_inner_design" >
			<table class="ui very basic collapsing celled table"  style="font-size:10px;" id="tbl_data">
				<thead>
				<tr>
					<th>Sr. No.</th>
					<th>Action</th>
					<th>Scrap Date</th>
					<th>Extrusion Date</th>
					<th>Machine</th>
					<th>Shift</th>
					<th>Order No</th>
					<th>Product No</th>
					<th>Job No</th>
					<th>Layer No</th>
					<th>Sleeve Weight</th>
					<th>Dia</th>
					<th>Length</th>					
					<th>Scrap Qty</th>
					<th>Scrap Qty Kg</th>
					<th>Total Box</th>
					<th>Form Process</th>	
									
				</tr>
				</thead><tbody>
				<?php 
                 $sum_scrap_qty=0;
                 $sum_box=0;
                 $sum_total_qty_kg=0;
				if($coex_extrusion_wip_scrap==FALSE){
					echo "<tr><td colspan='16' style='text-align: center !important;'>No Active Records Found</td></tr>";
				}else{
					$i=1;
					foreach($coex_extrusion_wip_scrap as $row){
                
                $total_box=$this->common_model->get_total_box('coex_extrusion_wip_scrap',$row->jobcard_no,$this->session->userdata['logged_in']['company_id']);               
               
                     $a=$row->scrap_qty/$total_box;              
                     $b = (int)$a;
                     if($a>$b){
                        $box=$b+1;
                     }else{
                        $box=$b;
                     }
                  
                  $qty_total_gm= $row->sleeve_weight_gm*$row->scrap_qty;
                  $qty_total_kg=$qty_total_gm/1000;

                  echo "<tr>
								<td class='center aligned'>".$i."</td>
								<td>";
                          foreach($formrights as $formrights_row){ 
                          echo ($formrights_row->new==1 && $row->scrap_qty !=0  && $row->status==0? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/return_scrap/'.$row->wip_scrap_id).'" title="WIP Release" target="_blank"><i class="edit icon"></i></a> ' : '');                                                         
                           }
                          echo"
                        </td>
                        <td>".$this->common_model->view_date($row->created_date,$this->session->userdata['logged_in']['company_id'])."</td>  
								<td>".$this->common_model->view_date($row->extrusion_date,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".$row->machine_name."</td>
								<td>".$row->shift_name."</td>
								<td>".($row->order_no=='' ? 'Purging' : $row->order_no)."</td>
								<td>".$row->article_no."</td>
								<td>".$row->jobcard_no."</td>
								<td>".$row->layer_no."</td>
								<td>".$row->sleeve_weight_gm."<i> Gm</i></td>
								<td>".$row->diameter."</td>
								<td>".($row->length=='' ? '' : $row->length." MM")."</td>
								<td class='negative right aligned'><b>".money_format('%!.0n',$row->scrap_qty)."</b><i> No</i></td>
								<td class='right aligned'>".$qty_total_kg."<i> Kg</i></td>
								<td>".$box."</td>
                        <td>".$row->form_process."</td>
                        ";
                     echo "</td>
                  </tr>";
               $i++;
               $sum_scrap_qty+=$row->scrap_qty;
               $sum_box+=$box;
               $sum_total_qty_kg+=$qty_total_kg;
               }
               echo"<tr><td colspan='13' style='text-align:right;'><b>TOTAL</b></td>
               <td class='negative right aligned'><b>".number_format($sum_scrap_qty,0,'.',',')."</b> <i>NOS</i></td>
               <td class=' right aligned'><b>".$sum_total_qty_kg." <i>Kg</i></b></td>
                <td class=' right aligned'><b>".$sum_box."</b> <i>BOX</i></td></tr>";
            }
					?>
		</tbody>			
		</table>
		<div class="pagination"><?php echo $this->pagination->create_links();?></div>
						
	</div>	
</div>