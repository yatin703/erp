<div class="record_form_design">
<?php 
setlocale(LC_MONETARY, 'en_IN');
if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
<h4>Active Records</h4>
   <div class="record_inner_design" style="overflow: scroll;">
         <table class="ui very basic collapsing celled table"  style="font-size:10px;">
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
         <th>Scrap QTY</th>
         <th>To Process</th>
         </tr>
         <?php 
            $sum_bm_wip_qty=0;
            if($coex_extrusion_heading_scrap==FALSE){
            echo "<tr><td colspan='4'>No Active Records Found</td></tr>";
            }else{
               $i=1;
               foreach($coex_extrusion_heading_scrap as $row){
            
                  echo "<tr>
                        <td>".$i."</td>
                        <td>".$this->common_model->view_date($row->extrusion_date,$this->session->userdata['logged_in']['company_id'])."</td>
                        <td>".$row->machine_name."</td>
                        <td>".$row->shift_name."</td>
                        <td>".($row->order_no=='' ? 'Purging' : $row->order_no)."</td>
                        <td>".$row->article_no."</td>
                        <td>".$row->jobcard_no."</td>
                        <td>".($row->sleeve_weight_gm)."<i> Gm</i></td>
                        <td>".$row->diameter."</td>
                        <td>".($row->length=='' ? '' : $row->length." MM")."</td>
                        <td class='negative right aligned'><b>".money_format('%!.0n',$row->scrap_by_qc)."</b><i> No</i></td>
                        <td>".$row->form_process."</td>     ";
                            echo "</td>
                        </tr>";
                  $i++;

                  $sum_bm_wip_qty+=$row->scrap_by_qc;
               }
               echo"<tr><td colspan='10' style='text-align:right;'><b>TOTAL</b></td>
               <td class='negative right aligned'><b>".number_format($sum_bm_wip_qty,0,'.',',')."</b> <i>NOS</i></td></tr>";
            }
            ?>
      </table>
      <div class="pagination"><?php echo $this->pagination->create_links();?></div>
   </div>
</div>

