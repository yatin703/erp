<div class="record_form_design">
<?php 
setlocale(LC_MONETARY, 'en_IN');
if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
<h4>Active Records</h4>
   <div class="record_inner_design" style="overflow: scroll;">
         <table class="ui very basic collapsing celled table"  style="font-size:10px;">
            <thead>
               <tr>
                  <th>Sr no.</th>
         			<th>Heading Date</th>
                  <th>Machine</th>
                  <th>Shift</th>
                  <th>Order No</th>
                  <th>Product No</th>
                  <th>Job No</th>
                  <th>Dia</th>
                  <th>Length</th>
         			<th>Production QTY</th>
               </tr>
            </thead>
            <tbody>
               <?php 
               $sum_bm_wip_qty=0;
               if($coex_extrusion_capping==FALSE){
               echo "<tr><td colspan='12'>No Active Records Found</td></tr>";
               }else{
               	$i=1;
               	foreach($coex_extrusion_capping as $row){
               
               		echo "<tr>
               				<td>".$i."</td>
               				<td>".$this->common_model->view_date($row->created_date,$this->session->userdata['logged_in']['company_id'])."</td>
                           <td>".$row->machine_name."</td>
                           <td>".$row->shift_name."</td>
                           <td>".($row->order_no=='' ? 'Purging' : $row->order_no)."</td>
                           <td>".$row->article_no."</td>
               				<td>".$row->jobcard_no."</td>
                           <td>".$row->diameter."</td>
                           <td>".($row->length=='' ? '' : $row->length." MM")."</td>
                           <td style='text-align:right;background:#fff;' ".($row->capping_qty==0? "class='td_wip_cost'":"")."> <span style='color:#2c662d!important;'><b> ".number_format($row->capping_qty,0,'.',',')." </b><i> No</i></span></td>
                          
                          
               				</tr>";
               		$i++;
               	 $sum_bm_wip_qty+=$row->capping_qty;
               }
               echo"<tr><td colspan='9' style='text-align:right;'><b>TOTAL</b></td>
               <td class='positive right aligned'><b>".number_format($sum_bm_wip_qty,0,'.',',')."</b> <i>NOS</i></td></tr>";
               }
               ?>
            </tbody>
      </table>
      <div class="pagination"><?php echo $this->pagination->create_links();?></div>
   </div>
</div>
