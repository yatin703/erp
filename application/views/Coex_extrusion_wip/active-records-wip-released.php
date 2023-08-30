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
.ui.three.column.grid {
    text-align: center;
    border: 1px solid #e4e4e4;
    border-radius: 0px;
}
.ui.grid>.row {
    padding-top: 0rem;
    padding-bottom: 0rem;
}
.column.released{
    background: #21ba45;
    border-radius: 0px;
    border: 1px solid #fff;
}
.column.released a.nav-link.active{
    color: #fff !important;
}
.column.released a.nav-link.active {
    font-size: 12px;
    font-weight: 700;
    color: #fff !important;
    padding: 5px 100px;
}

.column.hold:hover{
   background: #dee7ec; 
   border-radius: 0px;
   border: 1px solid #fff; 
}
.column.scrap:hover{
   background: #dee7ec; 
   border-radius: 0px;
   border: 1px solid #fff;
}
a.nav-link {
    font-size: 12px;
    font-weight: 700;
    color: #000 !important;
    padding: 5px 110px;
}

.column.hold{
border: 2px solid #fff;    
}
.column.scrap{
border: 2px solid #fff;    
}
</style>
<div class="record_form_design">
<?php 
setlocale(LC_MONETARY, 'en_IN');
if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
<div class="ui three column grid">
  <div class="row">
    <div class="column hold">
        <a class="nav-link" href="<?php echo base_url(); ?>index.php/coex_extrusion_wip">WIP Hold</a>
    </div>
    <div class="column released">
        <a class="nav-link active" href="<?php echo base_url(); ?>index.php/coex_extrusion_wip/released" style="color:#000">WIP Released</a>
    </div>
    <div class="column scrap">
        <a class="nav-link" href="<?php echo base_url(); ?>index.php/coex_extrusion_wip/scrap" style="color:#000">WIP Scrap</a>
    </div>
  </div>
</div>

<h4>Active Records</h4>
         <div class="record_inner_design" style="overflow: scroll;white-space: nowrap;">
            <table class="ui very basic collapsing celled table" style="font-size:9px;">
               <tr>
                  <th style="text-align: center;">Id</th>
                  <th>Action</th>
                  <th>WIP Released Date</th>
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
         		  <th>WIP Released QTY</th>
                  <th>Total Box</th>
                  <th>Form Process</th>
                  <th>To Process</th>
                  <th>Remark</th>
                  
               </tr>
            <tbody>
               <?php 
               $sum_bm_wip_qty=0;
               $sum_total_box=0;
               $sum_bm_wip_qty_cost=0;
               if($coex_extrusion_wip==FALSE){
               echo "<tr><td colspan='18' style='text-align: center !important;'>No Active Records Found</td></tr>";
               }else{
               	$i=1;
               	foreach($coex_extrusion_wip as $row){                                         
                     
                    $total_box=$this->common_model->get_total_box('coex_extrusion_wip',$row->jobcard_no,$this->session->userdata['logged_in']['company_id']);               
               
                     $a=$row->ok_by_qc/$total_box;              
                     $b = (int)$a;
                     if($a>$b){
                        $c=$b+1;
                     }else{
                        $c=$b;
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

               		echo "<tr>
               				<td class='center aligned'>".$i."</td>
                           <td>";
                                 foreach($formrights as $formrights_row){ 
                                echo ($formrights_row->new==1 && $row->release_qty !=0 && $row->status ==1  ? '<span class="" style="font-size: 10px;color: #fff;background: #21ba45 ;padding: 4px;border-radius: 5px;font-weight: bold;"><i class="check circle outline icon"></i> Released</span>' : '');                                                         
                                 }
                           echo"

                           </td>
                           <td>".date("d-M-Y", strtotime($row->release_date))."</td>
               				<td>".date("d-M-Y", strtotime($row->extrusion_date))."</td>
                           <td>".$row->machine_name."</td>
                           <td>".$row->shift_name."</td>
                           <td>".($row->order_no=='' ? 'Purging' : $row->order_no)."</td>
                           <td>".$row->article_no."</td>
               				<td>".$row->jobcard_no."</td>
                           <td class='center aligned'>".$row->layer_no."</td>
                           <td class='right aligned'>".($row->sleeve_weight_gm)."<i> Gm</i></td>
                           <td>".$row->diameter."</td>
                           <td>".($row->length=='' ? '' : $row->length." MM")."</td>
               				<td style='text-align:right;background:#fff;' ".($row->release_qty==0? "class='td_wip_cost'":"")."> <span style='color:#2c662d!important;'><b> ".number_format($row->release_qty,0,'.',',')." </b><i> No</i></span></td>
                           <td style='text-align:center;'>".$c."</td>
                           <td class='left aligned'><b>".$row->form_process."</b></td>
                           <td class='left aligned'><b>".$to_process."</b></td>
                           <td class='left aligned'><b>".$row->remark."</b></td>
                           ";
                           echo "</td>
               				</tr>";
               		$i++;
               	   $sum_bm_wip_qty+=$row->release_qty;
                   $sum_total_box+=$c;
                
               }

               echo"<tr><td colspan='13' style='text-align:right;'><b>TOTAL</b></td>
               <td class='positive right aligned'><b>".number_format($sum_bm_wip_qty,0,'.',',')."</b> <i>NOS</i></td>
               
               <td class='right aligned' ><b>".number_format($sum_total_box,0,'.',',')."</b> <i>BOX</i></td>

               </tr>
               ";
               }
               ?>
            </tbody>
      </table>
      <div class="pagination"><?php echo $this->pagination->create_links();?></div>
   </div>
</div>
