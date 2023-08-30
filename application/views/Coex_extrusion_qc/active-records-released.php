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
.ui.four.column.grid {
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
.column.pending:hover{
   background: #dee7ec; 
   border-radius: 0px;
   border: 1px solid #fff; 
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
.column.pending{
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
<div class="ui four column grid">
  <div class="row">
    <div class="column pending">
        <a class="nav-link" href="<?php echo base_url(); ?>index.php/coex_extrusion_qc" style="color:#000">Qc Pending</a>
    </div>
    <div class="column hold">
        <a class="nav-link " href="<?php echo base_url(); ?>index.php/coex_extrusion_qc/pending">Qc Hold </a>
    </div>
    <div class="column released">
        <a class="nav-link active" href="<?php echo base_url(); ?>index.php/coex_extrusion_qc/released" style="color:#000">Qc Released (<?php echo $total_realesed;?>)</a>
    </div>
    <div class="column scrap">
        <a class="nav-link active" href="<?php echo base_url(); ?>index.php/coex_extrusion_qc/hold_scrap" style="color:#000">Qc Scrap</a>
    </div>
  </div>
</div>
<h4>Active Records</h4>
<!--style="overflow: scroll;white-space: nowrap;"-->
   <div class="record_inner_design" style="overflow: scroll;white-space: nowrap;">
     <table class="ui very basic collapsing celled table" style="font-size:9px;">
         <tr>
             <th>Sr. No.</th>
             <th>Action</th>
             <th>Qc Released Date</th>
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
            echo "<tr><td colspan='17' style='text-align: center !important;'>No Active Records Found</td></tr>";
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
                        <td>".($row->flag==1 ? '<span class="" style="font-size: 10px;color: #fff;background: #21ba45 ;padding: 4px;border-radius: 5px;font-weight: bold;"><i class="check circle outline icon"></i> Released</span>' :'<a href="'.base_url('index.php/'.$this->router->fetch_class().'/hold_qc/'.$row->qc_id).'" style="font-size: 10px;color: #fff;background: #4183c4;padding: 4px;border-radius: 5px;font-weight: bold;"><i class="plus circle icon"></i><span> QC Hold</span></a>')."</td>
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
                        <td class='positive right aligned'><b>".money_format('%!.0n',$row->release_qty)."<i> No</i></b></td>
                        <td style='text-align: center !important;'>".$box."</td>
                        <td>".$row->form_process."</td>                       
                        <td>".$def['defect']."</td>
                        </tr>";
            		$i++;

                        $sum_bm_wip_qty+=$row->hold_by_qc;
                        $sum_total_box+=$box;
            	}
               echo"<tr><td colspan='13' style='text-align:right;'><b>TOTAL</b></td>
               <td class='positive right aligned'><b>".number_format($sum_bm_wip_qty,0,'.',',')." <i>NOS</i></b></td>
               <td class='right aligned'><b>".round($sum_total_box)." <i>BOX</i></b></td></tr></tr>";
            }
            ?>
      </table>
      <div class="pagination"><?php echo $this->pagination->create_links();?></div>
   </div>
</div>