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
      <div class="record_inner_design" style="overflow: scroll;white-space: nowrap;">
         <table class="ui very basic collapsing celled table" style="font-size:9px;">
               <tr>
                  <th style="text-align: center;">Sr no.</th>
                  <th>Action</th>
                  <th>WIP Date</th>
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
                  <th>Form Process</th>
                  <th>Released To Process</th>
                  <th>Released To Order No</th>
                  <th>Released To Jobcard No</th>
                  <th>Released On</th>
                  <th>Release Qty</th>
                  <th>Release By</th>
                  <th>Remark</th> 
               </tr>
            <tbody>
               <?php 
               $sum_bm_wip_qty=0;
               $sum_total_box=0;
               $sum_bm_wip_qty_cost=0;
               $sum_release_qty=0;
               if($coex_extrusion_wip==FALSE){
               echo "<tr><td colspan='20' style='text-align: center !important;'>No Active Records Found</td></tr>";
               }else{
               	$i=1;
               	foreach($coex_extrusion_wip as $row){
                     
                     if($row->release_date =='0000-00-00'){
                        $release_date ='';
                     }else{
                        $release_date = date("d-M-Y", strtotime($row->release_date));
                     }

                     if($row->to_process == '0'){
                        $to_process = " - ";
                     }else if($row->to_process == '4'){
                        $to_process = "WIP Scrap";
                     }else if($row->to_process == '2'){
                        $to_process = "Heading";
                     }else if($row->to_process == '3'){
                        $to_process = "Printing";
                     }else if($row->to_process == '7'){
                        $to_process = "Return Extrusion QC";
                     }

                     $total_box=$this->common_model->get_total_box('coex_extrusion_wip',$row->jobcard_no,$this->session->userdata['logged_in']['company_id']);               
               
                     $a=$row->ok_by_qc/$total_box;              
                     $b = (int)$a;
                     if($a>$b){
                        $c=$b+1;
                     }else{
                        $c=$b;
                     }


               		echo "<tr>
               				<td class='center aligned'>".$i."</td>
                           <td>";
                                 foreach($formrights as $formrights_row){ 
                                echo ($formrights_row->new==1 && $row->ok_by_qc !=0 && $row->status == 0 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/wip_release/'.$row->cewip_id).'" title="WIP Release" target="_blank"><i class="plus circle icon"></i></a> ' : '');                                                         
                                 }
                           echo"

                           </td>
                           <td>".date("d-M-Y", strtotime($row->created_date))."</td>
               				<td>".date("d-M-Y", strtotime($row->extrusion_date))."</td>
                           <td>".$row->machine_name."</td>
                           <td>".$row->shift_name."</td>
                           <td>".($row->order_no=='' ? 'Purging' : $row->order_no)."</td>
                           <td>".$row->article_no."</td>
               				<td>".$row->jobcard_no."</td>
                           <td class='center aligned'>".$row->layer_no."</td>
                           <td>".($row->sleeve_weight_gm)."<i> Gm</i></td>
                           <td>".$row->diameter."</td>
                           <td>".($row->length=='' ? '' : $row->length." MM")."</td>
               				<td style='text-align:right;background:#fff;' ".($row->ok_by_qc==0? "class='td_wip_cost'":"")."> <span style='color:#2c662d!important;'><b> ".number_format($row->ok_by_qc,0,'.',',')." </b><i> No</i></span></td>
                           
                           <td style='text-align:center;'>".$c."</td>
                           <td>".round($row->cost, 4)."</td>
                           <td style='text-align:right;background:#fff;'><span style='color:#2c662d!important;'><b>". money_format('%.0n',$row->ok_by_qc*$row->cost)."</b></span></td>
                           <td class='left aligned'><b>".$row->form_process."</b></td>
                           <td>".$to_process."</td>
                           <td>".$row->release_order_no."</td>
                           <td>".$row->release_jobcard_no."</td>
                           <td>".$release_date."</td>
                           <td style='text-align:right;background:#fff;'>".($row->release_qty=='0' ? ' ' : $row->release_qty.'<i> No</i>' )." </td>
                           <td>".$row->inspection_name."</td>
                           <td>".$row->remark."</td>
                           ";
                           echo "</td>
               				</tr>";
               		$i++;
               	 $sum_bm_wip_qty+=$row->ok_by_qc;
                   $sum_total_box+=$c;
                   $sum_bm_wip_qty_cost+=$row->ok_by_qc*$row->cost;
                   $sum_release_qty+=$row->release_qty;
                
               }

               echo"<tr><td colspan='13' style='text-align:right;'><b>TOTAL</b></td>
               <td class='positive right aligned'><b>".number_format($sum_bm_wip_qty,0,'.',',')."</b> <i>NOS</i></td>
              
               <td class='right aligned' ><b>".number_format($sum_total_box,0,'.',',')."</b> <i>BOX</i></td>
               
               <td></td>
               <td class='positive right aligned'><b>".money_format('%.0n',$sum_bm_wip_qty_cost)."</b></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td class='positive right aligned'><b>".number_format($sum_release_qty,0,'.',',')."</b> <i>NOS</i></td>
               </tr>
               ";
               }
               ?>
            </tbody>
      </table>
      <div class="pagination"><?php echo $this->pagination->create_links();?></div>
   </div>
</div>
