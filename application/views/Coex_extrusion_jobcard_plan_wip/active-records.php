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
<!--    <div class="record_inner_design">
         <table class="ui very basic collapsing celled table"  style="font-size:10px;" id="tbl_data"> -->
            <div class="record_inner_design" style="overflow: scroll;white-space: nowrap;">
            <table class="ui very basic collapsing celled table" style="font-size:9px;" id="tbl_data">
               <tr>
                  <th style="text-align: center;">Sr no.</th>
                  <th>Action</th>
                  <th>Extrusion Date</th>
                  <th>Machine</th>
                  <th>Shift</th>
                  <th>Order No</th>
                  <th>Article No</th>
                  <th>Jobcard No</th>
                  <th>Layer No</th>
                  <th>Sleeve Weight</th>
                  <th>Dia</th>
                  <th>Length</th>
                  <th>WIP QTY</th>
                  <th>Total Box</th>
                  <th>Cost/Qty</th>
                  <th>WIP Cost</th>
                  <!-- <th>QC Process</th> -->
                  <th>Job Issue</th>
                  <th>Next Process</th>
                  <th>Job Close</th>
                  <th>Job Plan Date/Time</th>
               </tr>
            <tbody>
               <?php 

               $sum_bm_wip_qty=0;
               $sum_cost=0;
               $sum_bm_wip_qty_cost=0;
               if($coex_extrusion_wip==FALSE){
                   
               echo "<tr><td colspan='12'>No Active Records Found</td></tr>";
               }else{
                  $i=1;
                  foreach($coex_extrusion_wip as $row){
                     if($row->next_process_print=='5'){
                        $process_print ='Heading';
                     }else if($row->next_process_print=='6'){
                        $process_print ='Printing';
                     }else{
                        $process_print ='-';
                     }


                       $j_close ='';
                        $data['jobcard_close']=$this->coex_extrusion_model->get_jobcard_close_check($row->jobcard_no);
                        foreach($data['jobcard_close'] as $job_close){
                           $j_close=$job_close->jobcard_close;
                           
                        }


                        $total_box=$this->common_model->get_total_box('coex_extrusion_wip',$row->jobcard_no,$this->session->userdata['logged_in']['company_id']);               
               
                   $a=$row->total_qty/$total_box;              
                   $b = (int)$a;
                   if($a>$b){
                      $box=$b+1;
                   }else{
                      $box=$b;
                   }


                         

                     echo "<tr>
                           <td class='center aligned'>".$i."</td>
                           <td>";
                              foreach($formrights as $formrights_row){ 
                                 if($row->hold_by_qc=='0'){
                                   echo ($formrights_row->modify==1 && $row->total_qty !=0   && $row->jobcard_issue !=1 ?  '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/jobcard_issue/'.$row->cewip_id).'" title="WIP Release" target="_blank"><i class="plus circle icon"></i></a> ' : '');
                                 }                                    
                              }
                              
                           echo"

                           </td>

                           <td>".$this->common_model->view_date($row->extrusion_date,$this->session->userdata['logged_in']['company_id'])."</td>
                           <td>".$row->machine_name."</td>
                           <td>".$row->shift_name."</td>
                           <td>".($row->order_no=='' ? 'Purging' : $row->order_no)."</td>
                           <td>".$row->article_no."</td>
                           <td>".$row->jobcard_no."</td>
                           <td>".$row->layer_no."</td>
                           <td>".($row->sleeve_weight_gm)."<i> Gm</i></td>
                           <td>".$row->diameter."</td>
                           <td>".($row->length=='' ? '' : $row->length." MM")."</td>
                           <td style='text-align:right;background:#fff;' ".($row->total_qty==0? "class='td_wip_cost'":"")."> <span style='color:#2c662d!important;'><b> ".number_format($row->total_qty,0,'.',',')." </b><i> No</i></span></td>
                           <td class='center aligned'>".$box."</td>";
                           
                              
                              echo "<td style='background:#fff;'><span style='color:#00b5ad!important;'><b>&#x20B9;".round($row->cost, 4)."</b></span></td>";
                         

                            
                            echo "<td style='text-align:right;background:#fff;'><span style='color:#2c662d!important;'><b>".money_format('%.0n',$row->total_qty*$row->cost)."</b></span></td>";
                            
                           echo "

                           
                           <td class='center aligned'>".($row->jobcard_issue=='1' ? '<i class="check circle icon" style="color:#06c806;">' : '<i class="times circle icon" style="color:#ff0000;">')."</td>
                          <td>".($process_print)."</td>
                           <td class='center aligned'>".($j_close=='1' ? '<i class="check circle icon" style="color:#06c806;">' : '<i class="times circle icon" style="color:#ff0000;">')."</td>
                          ";
                           echo "</td>
                           </tr>";
                     $i++;
                   $sum_bm_wip_qty+=$row->total_qty;

                   $sum_bm_wip_qty_cost+=$row->total_qty*$row->cost;

                   $sum_cost+=$box;
               }
               echo"<tr><td colspan='12' style='text-align:right;'><b>TOTAL</b></td>
               <td class='positive right aligned'><b>".number_format($sum_bm_wip_qty,0,'.',',')."</b> <i>NOS</i></td>
               <td class=' right aligned'><b>".$box."</b> <i>BOX</i></td>
               <td></td>
               <td class='positive right aligned'><b>".money_format('%.0n',$sum_bm_wip_qty_cost)."</b> </td></tr>";
               }
            
               ?>
            </tbody>
      </table>
<div class="pagination"><?php echo $this->pagination->create_links();?></div>
   </div>
</div>

 <!-- <td class='center aligned'>".($row->hold_by_qc=='0' ? '<i class="check circle icon" style="color:#06c806;">' : '<i class="times circle icon" style="color:#ff0000;">')."</td> 

 <td>".($process_print)."</td>
 -->