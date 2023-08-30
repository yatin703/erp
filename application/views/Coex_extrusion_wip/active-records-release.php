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
   input, select, textarea{
      padding: 3px;
   }
button, input, optgroup, select, textarea{
   font-family: verdana;
    font-size: 100%;
   
}
input[type="text"]{width: 50px;}
input[type="number"]{
   width: 50px;
   border: 0px;
   
   
}
.wip_qty{
   color: #2c662d;
   text-align: right;
}
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0; 
}
</style>
<div class="record_form_design">
<?php 
setlocale(LC_MONETARY, 'en_IN');
if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
<h4>Active Records</h4>
<span class='save'></span>
         <div class="record_inner_design" >
            <table class="ui very basic collapsing celled table" style="font-size:9px;" id="tbl_data">
               <tr>
                  <th style="text-align: center;">Sr no.</th>
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
                  <th>To Release</th>
                  <th>Release QTY</th>
                  <th></th>
                  
               </tr>
            <tbody>
            <?php 
               $sum_bm_wip_qty=0;
               $sum_total_box=0;
               $sum_bm_wip_qty_cost=0;
               if($coex_extrusion_wip==FALSE){
               echo "<tr><td colspan='19' style='text-align: center !important;'>No Active Records Found</td></tr>";
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

                     $data['process_zero']=$this->coex_extrusion_model->get_to_process_zero($row->jobcard_no);
                     $flag="";
                     foreach($data['process_zero'] as $hold){
                        $flag .=$hold->flag;
                      }
            ?>

<script type="text/javascript">    

$(document).ready(function() {
   $(".scrap_qty_<?php echo $i;?>").live("change", function() {
      var ok_qty      = Number($('input[name=ok_by_qc_<?php echo $i;?>]').val());
      var release_qty = Number($("#scrap_qty_<?php echo $i;?>").val());
      

      if(release_qty > ok_qty){
         alert('Ok Qty Greater Than Release Qty');
         Number($('#scrap_qty_<?php echo $i;?>').removeAttr('value'));
         location.reload();
      }else{
         $("#wip_qty_<?php echo $i;?>").val(ok_qty - release_qty);
  
      }

   });
});

$(function() {
  $('.scrap_qty_<?php echo $i;?>').click(function() {
    $('#output_<?php echo $i;?>').html(function(i, val) {   
      if(val == 1){
         alert('ReEnter Qty');
         location.reload();
      }else{
         return val * 1 + 1;
      }
    });
  });
});

$(function() {
   $('#to_process_<?php echo $i;?>').change(function() { 
      if($(this).val() == "0") {
         //$('#update_<?php echo $i;?>').prop('disabled', true);
         $("#update_<?php echo $i;?>").attr('disabled','disabled');
      }else{
         //$('#update_<?php echo $i;?>').prop('disabled', false);
         $("#update_<?php echo $i;?>").removeAttr('disabled');
      }
   });
});

$(function() {
   $('#update_<?php echo $i;?>').click(function() {  
   alert('hi');       
      $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/coex_extrusion_wip/wip_release_save_qty",
         data: {ce_id: $('#ce_id_<?php echo $i;?>').val(),qc_id: $('#qc_id_<?php echo $i;?>').val(),wip_id: $('#wip_id_<?php echo $i;?>').val(),order_no: $('#order_no_<?php echo $i;?>').val(),article_no: $('#article_no_<?php echo $i;?>').val(),jobcard_no: $('#jobcard_no_<?php echo $i;?>').val(),sleeve_weight_gm: $('#sleeve_weight_gm_<?php echo $i;?>').val(),diameter: $('#diameter_<?php echo $i;?>').val(),layer_no: $('#layer_no_<?php echo $i;?>').val(),to_process : $('#to_process_<?php echo $i;?>').val(),release_qty : $('#release_qty_<?php echo $i;?>').val()},
         cache: false,success: function(html){
         setTimeout(function () {
             $("#loading").hide();$("#cover").hide();},200);
             $(".save").html(html);
           } 
      });   
   });
});

</script>
            <?php


            echo "

<input type='hidden' name='ce_id_".$i."'    id='ce_id_".$i."'  value='$row->ce_id'>
<input type='hidden' name='qc_id_".$i."'    id='qc_id_".$i."'  value='$row->qc_id'>
<input type='hidden' name='wip_id_".$i."'   id='wip_id_".$i."' value='$row->wip_id'>
<input type='hidden' name='order_no_".$i."' id='order_no_".$i."' 
value='$row->order_no'>
<input type='hidden' name='article_no_".$i."' id='article_no_".$i."' value='$row->article_no'>
<input type='hidden' name='jobcard_no_".$i."' id='jobcard_no_".$i."' value='$row->jobcard_no'>
<input type='hidden' name='sleeve_weight_gm_".$i."' id='sleeve_weight_gm_".$i."' value='$row->sleeve_weight_gm'>
<input type='hidden' name='diameter_".$i."'  id='diameter_".$i."' value='$row->diameter'>
<input type='hidden' name='length_".$i."'    id='length_".$i."' value='$row->length'>
<input type='hidden' name='layer_no_".$i."'  id='layer_no_".$i."' value='$row->layer_no'>
            <tr>
               		<td class='center aligned'>".$i."</td>
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
         				<td style='text-align:right;background:#fff;' ".($row->ok_by_qc==0? "class='td_wip_cost'":"")."> <span style='color:#2c662d!important;'><b> <input type='number' name='ok_by_qc_".$i."' id='wip_qty_".$i."' min='0' class='wip_qty'  value='$row->ok_by_qc' readonly/></b><i> No</i></span></td>
                     <td style='text-align:center;'>".$c."</td>
                     <td>".round($row->cost, 4)."</td>
                     <td style='text-align:right;background:#fff;'><span style='color:#2c662d!important;'><b>". money_format('%.0n',$row->ok_by_qc*$row->cost)."</b></span></td>

                     <input type='hidden' name='ok_qty_".$i."' id='ok_qty_".$i."' value='$row->ok_by_qc'>

                     <td>
                        <select name='to_process_".$i."' id='to_process_".$i."'>           
                           <option value='0'>--Please select--</option>
                           <option value='4' ".set_select('WIP Scrap','4').">WIP Scrap</option>
                           <option value='7' ".set_select('Return Extrusion QC','7').">Return Extrusion QC</option>";
                           
                           if($flag =='0'){
                              echo "
                                 <option value='5' ".set_select('Heading','5').">Heading</option>
                                 <option value='6' ".set_select('Printing','6').">Printing</option>";
                           }else{
                              
                           }

                          echo "                   
                        </select>
                     </td>
                     <td><input type='number' name='release_qty_".$i."' id='scrap_qty_".$i."' class='scrap_qty_".$i."' min='0'  Placeholder='QTY'></td>
                     <td><input type='submit' class='update' id='update_".$i."' name='update_".$i."' value='Update' disabled></td>";

                     echo "</td>
               	</tr>";
               	$i++;
               	$sum_bm_wip_qty+=$row->ok_by_qc;
                  $sum_total_box+=$c;
                  $sum_bm_wip_qty_cost+=$row->ok_by_qc*$row->cost;
               }

          echo"<tr>
                  <td colspan='12' style='text-align:right;'><b>TOTAL</b></td>
                  <td class='positive right aligned'><b>".number_format($sum_bm_wip_qty,0,'.',',')."</b> <i>NOS</i></td>
                  <td class='right aligned' ><b>".number_format($sum_total_box,0,'.',',')."</b> <i>BOX</i></td>               
                  <td></td>
                  <td class='positive right aligned'><b>".money_format('%.0n',$sum_bm_wip_qty_cost)."</b></td>
               </tr>";



            }


         ?>
         </tbody>
        </table>
      <div class="pagination"><?php echo $this->pagination->create_links();?></div>
   </div>
   <?php
   $i=1;
   foreach($coex_extrusion_wip as $row){
      echo "<div style='visibility: hidden' id='output_".$i."'>0</div>";
      $i++;
    }
   ?>

</div>
