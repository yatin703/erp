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
a.nav-link {
    font-size: 12px;
    font-weight: 700;
    color: #000 !important;
    padding: 5px 110px;
}
.column.hold{
border: 2px solid #fff;    
}
.column.report{
border: 2px solid #fff;    
}
.column.report:hover{
   background: #dee7ec; 
   border-radius: 0px;
   border: 1px solid #fff; 
}
</style>
<div class="record_form_design">
<?php 
setlocale(LC_MONETARY, 'en_IN');
if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
 <div class="ui three column grid">
  <div class="row">
    <div class="column hold">
        <a class="nav-link " href="<?php echo base_url(); ?>index.php/coex_r_f_d" style="color:#000">R_F_D</a>
    </div>
    <div class="column released">
        <a class="nav-link active" href="<?php echo base_url(); ?>index.php/coex_r_f_d/released" style="color:#000">R_F_D Consume</a>
    </div>
    <div class="column report">
        <a class="nav-link" href="<?php echo base_url(); ?>index.php/coex_r_f_d/report" style="color:#000">R_F_D Report</a>
    </div>
  </div>
</div> 
<h4>Active Records</h4>

   <div class="record_inner_design" style="overflow: scroll;white-space: nowrap;">
            <table class="ui very basic collapsing celled table" style="font-size:9px;">
         <tr>
             <th>Sr. No.</th>
             <th>Release Date</th>
             <th>AQL Date</th>
    		 <th>Order No</th>
             <th>OC Date</th>
             <th>Customer</th>
             <th>Article No</th>
             <th>Product</th>
             <th>Print Type</th>
    		 <th>Released Quantity</th>
         </tr>

         <?php 
            $sum_release_qty=0;
            if($coex_rfd==FALSE){
            echo "<tr><td colspan='11' style='text-align: center !important;'>No Active Records Found</td></tr>";
            }else{
            	$i=1;
            	foreach($coex_rfd as $row){

            		echo "<tr>
            		     <td class='center aligned'>".$i."</td>
                        <td>".$this->common_model->view_date($row->release_date,$this->session->userdata['logged_in']['company_id'])."</td>
                        <td>".$this->common_model->view_date($row->aql_date,$this->session->userdata['logged_in']['company_id'])."</td>
                        <td>".$row->order_no."</td>
                        <td>".$this->common_model->view_date($row->oc_date,$this->session->userdata['logged_in']['company_id'])."</td>
                        <td>".$row->name1."</td>
                        <td>".$row->article_no."</td>
                        <td><span style='color:blue;'>".substr($row->lang_sub_description,0,15)."</span> ".$row->lang_article_description."</td>
                        <td>".$row->print_type."</td>
                        <td class='right aligned positive'>".$row->rfd."</td>
                        </tr>";
            		$i++;
                    $sum_release_qty+=$row->rfd;
              
            	}
                echo"<tr><td colspan='9' style='text-align:right;'><b>TOTAL</b></td>
                            <td class=' right aligned positive'><b>".number_format($sum_release_qty,0,'.',',')." <i>QTY</i></b></td>
                            </tr>";
            }
            ?>
      </table>
      <div class="pagination"><?php echo $this->pagination->create_links();?></div>
   </div>
</div>