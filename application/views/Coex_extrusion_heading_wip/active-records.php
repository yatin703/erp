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
   th{text-align:center;border-top: 1px solid rgba(34,36,38,.1)}
</style>
<div class="record_form_design">
<?php 
setlocale(LC_MONETARY, 'en_IN');
if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
<h4>Active Records</h4>
   <div class="record_inner_design" style="overflow: scroll;">
         <table class="ui very basic collapsing celled table"  style="font-size:10px;" id="tbl_data">
            <thead>
               <tr>
                  <th>Sr no.</th>
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
                  <th>Status</th>
                  <th>To Process</th>
               </tr>
            </thead>
            <tbody>
               <?php 
               $sum_bm_wip_qty=0;
               if($coex_extrusion_heading_wip==FALSE){
               echo "<tr><td colspan='12'>No Active Records Found</td></tr>";
               }else{
                  $i=1;
                  foreach($coex_extrusion_heading_wip as $row){
               
                     echo "<tr>
                           <td>".$i."</td>
                           <td>";
                                 foreach($formrights as $formrights_row){ 
                                echo ($formrights_row->new==1 && $row->ok_by_qc !=0 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/wip_release/'.$row->hwip_id).'" title="WIP Release" target="_blank"><i class="edit icon"></i></a> ' : '');                                                         
                                 }
                           echo"

                           </td>
                           <td>".$this->common_model->view_date($row->created_date,$this->session->userdata['logged_in']['company_id'])."</td>
                           <td>".$row->machine_name."</td>
                           <td>".$row->shift_name."</td>
                           <td>".($row->order_no=='' ? 'Purging' : $row->order_no)."</td>
                           <td>".$row->article_no."</td>
                           <td>".$row->jobcard_no."</td>
                           <td>".($row->sleeve_weight_gm)."<i> Gm</i></td>
                           <td>".$row->diameter."</td>
                           <td>".($row->length=='' ? '' : $row->length." MM")."</td>
                           <td style='text-align:right;background:#fff;' ".($row->ok_by_qc==0? "class='td_wip_cost'":"")."> <span style='color:#2c662d!important;'><b> ".number_format($row->ok_by_qc,0,'.',',')." </b><i> No</i></span></td>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td>".$row->form_process."</td>
                                ";
                               echo "</td>
                           </tr>";
                     $i++;
                   $sum_bm_wip_qty+=$row->ok_by_qc;
               }
               echo"<tr><td colspan='11' style='text-align:right;'><b>TOTAL</b></td>
               <td class='positive right aligned'><b>".number_format($sum_bm_wip_qty,0,'.',',')."</b> <i>NOS</i></td></tr>";
               }
               ?>
            </tbody>
      </table>
      <div class="pagination"><?php echo $this->pagination->create_links();?></div>
   </div>
</div>

