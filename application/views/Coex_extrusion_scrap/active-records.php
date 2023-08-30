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
         <tr>
         <th>Sr. No.</th>
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
         <th>Scrap QTY</th>
         <th>Total Box</th>
         <th>To Process</th>
         <th>Scrap Date/Time</th>   
         </tr>
         <?php 
            $sum_bm_wip_qty=0;
            if($coex_extrusion_scrap==FALSE){
            echo "<tr><td colspan='4'>No Active Records Found</td></tr>";
            }else{
               $i=1;
               foreach($coex_extrusion_scrap as $row){


                if($row->dyn_qty_present == 'SLEEVE|1')
                    { $layer_no ='1';}
                elseif($row->dyn_qty_present == 'SLEEVE|2')
                    {$layer_no ='2';}
                elseif($row->dyn_qty_present == 'SLEEVE|3')
                    {$layer_no ='3';}
                elseif($row->dyn_qty_present == 'SLEEVE|4')
                    {$layer_no ='4';}
                elseif($row->dyn_qty_present == 'SLEEVE|5')
                    {$layer_no ='5';}
                else{$layer_no ='Not Applicable';}
                
                if($row->created_date){
                    $created_date = date("d-M-Y H:i:s", strtotime($row->created_date));
                }else{
                    $created_date = '-';
                }
                
                $total_box=$this->common_model->get_total_box('coex_extrusion_qc',$row->jobcard_no,$this->session->userdata['logged_in']['company_id']);
            
                  echo "<tr>
                        <td class='center aligned'>".$i."</td>
                        <td>".$this->common_model->view_date($row->extrusion_date,$this->session->userdata['logged_in']['company_id'])."</td>
                        <td>".$row->machine_name."</td>
                        <td>".$row->shift_name."</td>
                        <td>".($row->order_no=='' ? 'Purging' : $row->order_no)."</td>
                        <td>".$row->article_no."</td>
                        <td>".$row->jobcard_no."</td>
                        <td>".$layer_no."</td>
                        <td>".($row->sleeve_weight_gm)."<i> Gm</i></td>
                        <td>".$row->diameter."</td>
                        <td>".($row->length=='' ? '' : $row->length." MM")."</td>
                        <td class='negative right aligned'><b>".money_format('%!.0n',$row->scrap_by_qc)."</b><i> No</i></td>
                        <td>".$row->scrap_by_qc/$total_box."</td>
                        <td>".$row->form_process."</td> 
                         <td>".$created_date."</td>    ";
                            echo "</td>
                        </tr>";
                  $i++;

                  $sum_bm_wip_qty+=$row->scrap_by_qc;
               }
               echo"<tr><td colspan='11' style='text-align:right;'><b>TOTAL</b></td>
               <td class='negative right aligned'><b>".number_format($sum_bm_wip_qty,0,'.',',')."</b> <i>NOS</i></td></tr>";
            }
            ?>
      </table>
      <div class="pagination"><?php echo $this->pagination->create_links();?></div>
   </div>
</div>

