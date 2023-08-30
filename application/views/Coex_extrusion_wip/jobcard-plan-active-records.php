<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

   $(document).ready(function(){
      
       $("table tr").click(function(e){
         $("table tr").removeClass('on-hower'); 
           $(this).addClass('on-hower');
       }); 

       $("#tbl_data .td_wip_cost").each(function(){
         //alert($(this).html());
         //if($(this).html()==0){
            //$(this).parent("tr").css("background-color","pink");
            $(this).parent("tr").addClass("negative");
         //}

      })
   });
</script>

<style>
   .on-hower{
        background-color:#e4e4e4;
    }
   tr:hover {background-color:#e4e4e4;}
   th{text-align: center;padding: 5px 5px 5px 5px;border-top: 1px solid rgba(34,36,38,.1)}
   table th{background-color:#e4e4e4 !important;font-size: 12px;}
</style>
<div class="record_form_design">
<?php 
setlocale(LC_MONETARY, 'en_IN');
if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
<h4>Active Records</h4>
   <div class="record_inner_design" style="overflow: scroll;">
         <table class="ui very basic collapsing celled table"  style="font-size:10px;" id="tbl_data">
               <tr>
                  <th style="text-align: center;">Sr no.</th>
                  <th>Action</th>
         			<th>WIP Date</th>
                  <th>Machine</th>
                  <th>Shift</th>
                  <th>Order No</th>
                  <th>Article No</th>
                  <th>Jobcard No</th>
         			<th>Sleeve Weight</th>
                  <th>Dia</th>
                  <th>Length</th>
         			<th>WIP QTY</th>
                  <th>Cost/Qty</th>
                  <th>WIP Cost</th>
                  <th>QC Process</th>
                  <th>Jobcard Issue</th>
                  <th>Next Process</th>
               </tr>
            <tbody>
               <?php 

               $sum_bm_wip_qty=0;
               $sum_cost=0;
               if($coex_extrusion_wip==FALSE){
                   
               echo "<tr><td colspan='12'>No Active Records Found</td></tr>";
               }else{
               	$i=1;
               	foreach($coex_extrusion_wip as $row){
                     if($row->w_next_process_print=='5'){
                        $process_print ='Heading';
                     }else if($row->w_next_process_print=='6'){
                        $process_print ='Printing';
                     }else{
                        $process_print ='-';
                     }

                     $purchase_price=0;
                     $data['jobcard_purchase_price']=$this->coex_extrusion_model->active_record_jobcard_purchase_price($row->w_jobcard_no);
                        foreach($data['jobcard_purchase_price'] as $price){
                           $purchase_price=$price->material_price;
                        }

                        $cost     = $purchase_price/$row->quantity;
                        //echo "<br>"; 
                        $wip_cost = $row->quantity*$cost;
               		echo "<tr>
               				<td class='center aligned'>".$i."</td>
                           <td>";
                              foreach($formrights as $formrights_row){ 
                                 if($row->q_hold_by_qc=='0'){
                                   echo ($formrights_row->modify==1 && $row->w_ok_by_qc !=0   && $row->w_jobcard_issue !=1 ?  '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/jobcard_issue/'.$row->w_cewip_id).'" title="WIP Release" target="_blank"><i class="plus circle icon"></i></a> ' : '');
                                 }                                    
                              }
                              
                           echo"

                           </td>

               				<td>".$this->common_model->view_date($row->w_created_date,$this->session->userdata['logged_in']['company_id'])."</td>
                           <td>".$row->machine_name."</td>
                           <td>".$row->shift_name."</td>
                           <td>".($row->w_order_no=='' ? 'Purging' : $row->w_order_no)."</td>
                           <td>".$row->w_article_no."</td>
               				<td>".$row->w_jobcard_no."</td>
                           <td>".($row->w_sleeve_weight_gm)."<i> Gm</i></td>
                           <td>".$row->w_diameter."</td>
                           <td>".($row->w_length=='' ? '' : $row->w_length." MM")."</td>
               				<td style='text-align:right;background:#fff;' ".($row->quantity==0? "class='td_wip_cost'":"")."> <span style='color:#2c662d!important;'><b> ".number_format($row->quantity,0,'.',',')." </b><i> No</i></span></td>

                           <td>&#x20B9;".number_format($cost, 2)."</td>
                           <td style='text-align:right;background:#fff;'><span style='color:#2c662d!important;'><b>".money_format('%.0n',$wip_cost)."</b></span></td>
                           <td class='center aligned'>".($row->q_hold_by_qc=='0' ? '<i class="check circle icon" style="color:#06c806;">' : '<i class="times circle icon" style="color:#c80606;">')."</td>
                           <td class='center aligned'>".($row->w_jobcard_issue=='1' ? '<i class="check circle icon" style="color:#06c806;">' : '<i class="times circle icon" style="color:#c80606;">')."</td>
                           <td>".($process_print)."</td>";
                           echo "</td>
               				</tr>";
               		$i++;
               	 $sum_bm_wip_qty+=$row->quantity;
                   $sum_cost+=$wip_cost;
               }
               echo"<tr><td colspan='11' style='text-align:right;'><b>TOTAL</b></td>
               <td class='positive right aligned'><b>".number_format($sum_bm_wip_qty,0,'.',',')."</b> <i>NOS</i></td>
               <td></td>
               <td class='positive right aligned'><b>".money_format('%.0n',$sum_cost)."</b> </td></tr>";
               }
            
               ?>
            </tbody>
      </table>
      <div class="pagination"><?php echo $this->pagination->create_links();?></div>
   </div>
</div>

 