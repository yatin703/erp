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
   th{text-align: center !important;padding: 5px 5px 5px 5px !important;border-top: 1px solid rgba(34,36,38,.1)}
   table th{background-color:#e4e4e4 !important;font-size: 12px;}
</style>
<div class="record_form_design">
<?php 
setlocale(LC_MONETARY, 'en_IN');
if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>

   <div class="record_inner_design" style="overflow: scroll;white-space: nowrap;">
            <table class="ui very basic collapsing celled table" style="font-size:9px;">
         <tr>
             <th>Sr. No.</th>
             <th>Action</th>
             <th>Qc Date</th>
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
    		 <th>QC QTY</th>
             <th>Total Box</th>
             <th>To Process</th>            
             
             <th>Qc Defect</th>
         </tr>
         <?php 
            $sum_bm_wip_qty=0;
            $sum_total_box=0;
            if($coex_extrusion_qc==FALSE){
            echo "<tr><td colspan='13'>No Active Records Found</td></tr>";
            }else{
            	$i=1;
            	foreach($coex_extrusion_qc as $row){
                
                $total_box=$this->common_model->get_total_box('coex_extrusion_qc',$row->jobcard_no,$this->session->userdata['logged_in']['company_id']);

                $a=$row->hold_by_qc/$total_box;              
                $b = (int)$a;
                if($a>$b){
                  $box=$b+1;
                }else{
                  $box=$b;
                }

                $d_arr = $row->defect;                
                $def=$this->coex_extrusion_model->get_defect_details_by_id($d_arr);
            		echo "<tr>
            		     <td class='center aligned'>".$i."</td>
                        <td>".($row->flag==1 ? '<span class="" style="font-size: 10px;color: #fff;background: #0E6EB8;padding: 4px;border-radius: 5px;font-weight: bold;"><i class="check circle outline icon"></i> Released</span>' :'<a href="'.base_url('index.php/'.$this->router->fetch_class().'/hold_qc/'.$row->qc_id).'" style="font-size: 10px;color: #fff;background: #4183c4;padding: 4px;border-radius: 5px;font-weight: bold;"><i class="plus circle icon"></i><span> QC Hold</span></a>')."</td>
                             ";
                            echo "</td>
                        <td>".$this->common_model->view_date($row->created_date,$this->session->userdata['logged_in']['company_id'])."</td>
                        <td>".$this->common_model->view_date($row->extrusion_date,$this->session->userdata['logged_in']['company_id'])."</td>
                        
                        <td>".$row->machine_name."</td>
                        <td>".$row->shift_name."</td>
                        <td>".($row->order_no=='' ? 'Purging' : $row->order_no)."</td>
                        <td>".$row->article_no."</td>
            			<td>".$row->jobcard_no."</td>
                        <td style='text-align: center !important;'>".$row->layer_no."</td>
                        <td>".($row->sleeve_weight_gm)."<i> Gm</i></td>
                        <td>".$row->diameter."</td>
                        <td>".($row->length=='' ? '' : $row->length." MM")."</td>
                        <td class='positive right aligned'><b>".money_format('%!.0n',$row->hold_by_qc)."<i> No</i></b></td>
                        <td>".$box."</td>
                        <td>".$row->form_process."</td>                                              
                        <td>".$def['defect']."</td>
                        </tr>";
            		$i++;

                        $sum_bm_wip_qty+=$row->hold_by_qc;
                        $sum_total_box+=$box;
            	}
               echo"<tr><td colspan='13' style='text-align:right;'><b>TOTAL</b></td>
               <td class='positive right aligned'><b>".number_format($sum_bm_wip_qty,0,'.',',')." <i>NOS</i></b></td>
               <td class=' right aligned'><b>".round($sum_total_box)." <i>BOX</i></b></td></tr>";
            }
            ?>
      </table>
      <div class="pagination"><?php echo $this->pagination->create_links();?></div>
   </div>
</div>