<style type="text/css">
	<style>
.on-hower{
    background-color:#e4e4e4;
}
tr:hover {background-color:#e4e4e4;}
th{text-align: center !important;padding: 5px 5px 5px 5px !important;border-top: 1px solid rgba(34,36,38,.1)}
table th{background-color:#e4e4e4 !important;font-size: 12px;}
/*table th {
    background-color: #F9FAFB !important;
    font-size: 12px;
}
.ui.selectable.table tbody tr:hover, .ui.table tbody tr td.selectable:hover {
    background: rgba(0, 0, 0, 0.05) !important;
    color: rgba(0, 0, 0, 0.95) !important;
}
tbody{
   background: #fff;
}*/
</style>
<div class="record_form_design">
   <?php 
      setlocale(LC_MONETARY, 'en_IN');
      if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
   <h4>Active Records</h4>
   <div class="record_inner_design" >
        <table class="ui very basic collapsing celled table" style="font-size:9px;">
         <thead>
            <tr>
               <th>Id</th>
               <th>Date</th>
               <th >Machine</th>
               <th>Shift</th>
               <th>Order No</th>
               <th>Product No</th>
               <th>Job No</th>
               <th>Layer No.</th>
               <th>Sleeve Weight</th>
               <th>Dia</th>
               <th>Length</th>
               <th>Rm Used Kg</th>
               <th>Production Qty</th>
               <th>Total Box</th>
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
            <?php 
               $sum_rm_mixed_qty_kg=0;
               $sum_ok_qty_no=0;
               $sum_scrap_tube_no=0;
               $sum_scrap_weight_kg=0;
               $sum_box=0;
               if($coex_extrusion==FALSE){
               echo "<tr><td colspan='15'>No Active Records Found</td></tr>";
               }else{
               $i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
               
               foreach($coex_extrusion as $row){
               
           
               $total_box=$this->common_model->get_total_box('coex_extrusion',$row->jobcard_no,$this->session->userdata['logged_in']['company_id']);               
               
               $a=$row->ok_qty_no/$total_box;              
               $b = (int)$a;
               if($a>$b){
                  $c=$b+1;
               }else{
                  $c=$b;
               }
               
               echo "<tr>
               <td style='text-align: center !important;'>".$i."</td>
               <td>".$this->common_model->view_date($row->extrusion_date,$this->session->userdata['logged_in']['company_id'])."</td>
               <td>".$row->machine_name."</td>
               <td>".$row->shift_name."</td>
               <td>".($row->order_no=='' ? 'Purging' : $row->order_no)."</td>
               <td>".$row->article_no."</td>
               <td>".$row->jobcard_no."</td>
               <td style='text-align: center !important;'>".$row->layer_no."</td>
               <td class='right aligned'>".($row->sleeve_weight_kg*1000)."<i> Gm</i></td>
               <td>".$row->diameter."</td>
               <td>".($row->length=='' ? '' : $row->length." MM")."</td>
               <td class='right aligned'>".$row->rm_mixed_qty_kg." Kg</td>
               <td class='positive right aligned'><b>".money_format('%!.0n',$row->ok_qty_no)."</b><i> No</i></td>
               <td style='text-align: center !important;'>".$c."</td>
               <td class='negative right aligned'><b>".($row->scrap_tube_no!=0 ? money_format('%!.0n',$row->scrap_tube_no) : '0')."</b> <i>No</i></td>
               <td class='right aligned'>".round($row->scrap_weight_kg,1)." <i>Kg</i></td>
               <td class='right aligned'>".$row->cutting_speed_minutes." <i>Min</i></td>
               <td class='warning right aligned'>".round($row->rejection_percentage)."%</td>
               <td>".($row->qc_flag==1 ? '<i style="color:#21ba45" class="check circle icon"></i>' :'<i style="color:#db2828" class="close icon"></i>')."</td>
               <td>";
               
               foreach($formrights as $formrights_row){ 
               
               echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->ce_id).'" target="_blank"><i class="print icon"></i></a> ' : '');
               
               
               echo ($formrights_row->modify==1  && $row->qc_flag==0 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->ce_id).'"><i class="edit icon"></i></a> ' : '');
               
               echo ($row->archive<>1 && $formrights_row->delete==1  ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->ce_id).'"><i class="trash icon"></i></a> ' : '');
               
               } 
               echo "</td>
               
               </tr>";
               $i++;
               $sum_rm_mixed_qty_kg+=$row->rm_mixed_qty_kg;
               $sum_ok_qty_no+=$row->ok_qty_no;
               $sum_scrap_tube_no+=$row->scrap_tube_no;
               $sum_scrap_weight_kg+=$row->scrap_weight_kg;
               $sum_box+=$c;
               }
               echo"<tr><td colspan='11' style='text-align:right;'><b>TOTAL</b></td>
                            <td class=' right aligned'><b>".number_format($sum_rm_mixed_qty_kg,0,'.',',')." <i>KG</i></b></td>
                            <td class='positive right aligned'><b>".number_format($sum_ok_qty_no,0,'.',',')." <i>NOS</i></b></td>
                            <td class=' right aligned'><b>".$sum_box."<i>  BOX</i></b></td>
                            <td class='negative right aligned'><b>".number_format($sum_scrap_tube_no,0,'.',',')." <i>NOS</i></b></td>
                            <td class=' right aligned'><b>".number_format($sum_scrap_weight_kg,0,'.',',')." <i>KG</i></b></td></tr>";
               }
               ?>
         </tbody>
      </table>
      <div class="pagination"><?php echo $this->pagination->create_links();?></div>
   </div>
</div>