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
             <th>Heading Date</th>
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
             <th>Production QTY</th>
             <th>Total Box</th>
            </tr>
         </thead>
         <tbody>
               <?php 
               $sum_bm_wip_qty=0;
               $sum_total_box=0;
               if($coex_extrusion_heading==FALSE){
               echo "<tr><td class='center aligned' colspan='13'>No Active Records Found</td></tr>";
               }else{
                  $i=1;
                  foreach($coex_extrusion_heading as $row){

               
                  $total_box=$this->common_model->get_total_box('coex_extrusion_heading',$row->jobcard_no,$this->session->userdata['logged_in']['company_id']);               
               
                     $a=$row->heading_qty/$total_box;              
                     $b = (int)$a;
                     if($a>$b){
                        $box=$b+1;
                     }else{
                        $box=$b;
                     }

                     echo "<tr>
                           <td style='text-align: center !important;'>".$i."</td>
                           <td>".$this->common_model->view_date($row->created_date,$this->session->userdata['logged_in']['company_id'])."</td>
                           <td>".$this->common_model->view_date($row->extrusion_date,$this->session->userdata['logged_in']['company_id'])."</td>
                           <td>".$row->machine_name."</td>
                           <td>".$row->shift_name."</td>
                           <td>".($row->order_no=='' ? 'Purging' : $row->order_no)."</td>
                           <td>".$row->article_no."</td>
                           <td>".$row->jobcard_no."</td>
                           <td class='center aligned'>".$row->layer_no."</td>
                           <td>".$row->diameter."</td>
                           <td>".($row->length=='' ? '' : $row->length." MM")."</td>
                           <td class='center aligned'>".$row->sleeve_weight_gm."</td>
                           <td style='text-align:right;background:#fff;' ".($row->heading_qty==0? "class='td_wip_cost'":"")."> <span style='color:#2c662d!important;'><b> ".number_format($row->heading_qty,0,'.',',')." </b><i> No</i></span></td>
                          <td class='center aligned'>".$box."</td>
                          
                           </tr>";
                     $i++;
                   $sum_bm_wip_qty+=$row->heading_qty;
                   $sum_total_box+=$box;
               }
               echo"<tr><td colspan='12' style='text-align:right;'><b>TOTAL</b></td>
               <td class='positive right aligned'><b>".number_format($sum_bm_wip_qty,0,'.',',')."</b> <i>NOS</i></td>
               <td class='right aligned' ><b>".number_format($sum_total_box,0,'.',',')."</b> <i>BOX</i></td></tr>";
               }
               ?>
            </tbody>
      </table>
      <div class="pagination"><?php echo $this->pagination->create_links();?></div>
   </div>
</div>