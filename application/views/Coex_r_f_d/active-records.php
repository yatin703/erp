<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
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

   <div class="record_inner_design" style="overflow: scroll;white-space: nowrap;">
            <table class="ui very basic collapsing celled table" style="font-size:9px;">
         <tr>
             <th>Sr. No.</th>
             <th>AQL Date</th>
    		 <th>Order No</th>
             <th>OC Date</th>
             <th>Customer</th>
             <th>Article No</th>
             <th>Product</th>
             <th>Print Type</th>
             <th>Order Status</th>
    		    <th>RFD Quantity</th>
             <th>Action</th>
         </tr>

         <?php 

            if($coex_rfd==FALSE){
            echo "<tr><td colspan='11' style='text-align: center !important;'>No Active Records Found</td></tr>";
            }else{
            	$i=1;
            	foreach($coex_rfd as $row){

            		echo "<tr>
            		     <td class='center aligned'>".$i."</td>
                        
                        <td>".$this->common_model->view_date($row->aql_date,$this->session->userdata['logged_in']['company_id'])."</td>
                        <td>".$row->order_no."</td>
                        <td>".$this->common_model->view_date($row->oc_date,$this->session->userdata['logged_in']['company_id'])."</td>
                        <td>".$row->customer."</td>
                        <td>".$row->article_no."</td>
            			   <td>".$row->product."</td>
                        <td>".$row->print_type."</td>
                        <td>".$row->order_status."</td>
                        <td class='right aligned'>".$row->rfd."</td>
                        <td>".($row->rfd_flag==1 ? '<i style="color:#21ba45" class="check circle icon"></i>' :'<i style="color:#db2828" class="close icon"></i>')."</td>
            
                        </tr>";
            		$i++;
              
            	}

            }
            ?>
      </table>
      <div class="pagination"><?php echo $this->pagination->create_links();?></div>
   </div>
</div>