<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
   $(document).ready(function(){
   $("#loading").hide(); $("#cover").hide();
   $("#so_no").autocomplete("<?php echo base_url('index.php/ajax/get_so_no_transfer');?>", {selectFirst: true});
          
         $("#so_no").live('keyup',function(){
   $("#loading").show(); $("#cover").show();
   $('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
   $.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/get_product_no_transfer');?>",data: {so_no : $("#so_no").val()},cache: false,success: function(html){
   setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
   $("#articl_no").html(html);
   }
   });
   });
   
   $("#so_no").live('keyup',function(){
   $("#loading").show(); $("#cover").show();
   $('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
   $.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/get_rfd_qty_transfer');?>",data: {so_no : $("#so_no").val()},cache: false,success: function(html){
   setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
   $("#transfer_rfd_qty").html(html);
   }
   });
   });
   
   
         $("#so_no").live('keyup',function(){
   $("#loading").show(); $("#cover").show();
   $('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
   $.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/get_rfd_jobcard_transfer');?>",data: {so_no : $("#so_no").val()},cache: false,success: function(html){
   setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
   $("#job_card_no").html(html);
   }
   });
   });
   
   
   
   
   
   /*$("#article_no").live('change',function(){
   $("#loading").show(); $("#cover").show();
   $('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
   $.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/get_cap_height_coa');?>",data: {shoulder_thread_type : $("#shoulder_style").val(),specification_diameter : $("#cap_diameter").val(),cap_type : $("#cap_dia").val()},cache: false,success: function(html){
   setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
   $("#cap_height").val(html);
   }
   article_no
   articl_no
   });
   });*/
   
   });//Jquery closed
      
      
   
      
</script>
<!-- <script>
   $(document).ready(function(){
   
   $("#release_qty").bind('keyup blur',function(){
   //alert();
   
   if($("#release_qty").val()!=''){
   
   var total_rfd_qty=Number($("#total_rfd_qty").val());
   var release_qty=Number($("#release_qty").val());
   
   if(release_qty>total_rfd_qty){
   
   alert('Release Qty less than or equal to Total RFD Qty');
   $("#release_qty").val('');
   $("#pending_rfd_qty").val('');
   $("#release_qty").focus();
   }else{
   var remaining_rfd=total_rfd_qty-release_qty;
   $("#pending_rfd_qty").val(remaining_rfd);
   
   }
   }else{
   
   $("#pending_rfd_qty").val('');
   
   }
   
   });
   
   });
   </script> -->
<script type="text/javascript">
   $(document).ready(function() {
   
      $(".transfer_qty").live("change", function() {
    var total_rfd_qty=Number($("#total_rfd_qty").val());
    var transfer_qty=Number($("#transfer_qty").val());
    var article_no=$("#article_no").val();
    var articl_no=$("#articl_no").val();
   
   
            
         if (article_no==articl_no) {
         if(transfer_qty>=total_rfd_qty){
        
           alert('Transfer Qty Greater Than RFD Qty');
           Number($('#transfer_qty').removeAttr('value'));
     location.reload();
          
    
         }else{
          
         }
      }else{
   
       alert('BOTH ARTICLE NUMBER DOES NOT MATCH');
           Number($('#transfer_qty').removeAttr('value'));
     location.reload();
   
      }
   
   });
   });
   
</script>
<script type="text/javascript">
   $(document).ready(function() {
   
      $(".transfer_qty").live("change", function() {
    var total_rfd_qty=Number($("#total_rfd_qty").val());
    var transfer_qty=Number($("#transfer_qty").val());
    var total_order_qty=Number($("#total_order_qty").val());
    var dispatch_tolerance=Number($("#dispatch_tolerance").val());
    var transfer_rfd_qty=Number($("#transfer_rfd_qty").val());
    var article_no=$("#article_no").val();
    var articl_no=$("#articl_no").val();
   
            
         if (article_no==articl_no) {
    
    if(total_rfd_qty>=total_order_qty){
     var a=total_order_qty*(100+dispatch_tolerance);
     var b=a/100;
   
     if(total_rfd_qty>b){
     var c=total_rfd_qty-b;
     if(transfer_qty>c){
   
     alert('Transfer Qty Is Not More Then Remaining Qty');
           Number($('#transfer_qty').removeAttr('value'));
     location.reload();
   
     }
     }else{
   
          alert(' RFD Qty Not Grather Than Tolrance Qty');
           Number($('#transfer_qty').removeAttr('value'));
     location.reload();
     }
        
          
          
    
         }else{
          
         }
      }else{
   
       alert('BOTH ARTICLE NUMBER DOES NOT MATCH');
           Number($('#transfer_qty').removeAttr('value'));
     location.reload();
      }
   
   });
   });
   
</script>

<?php
   $order_flag=0;
   foreach ($order as $order_row):
   $order_flag=$order_row->order_flag; ?>
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_rfd_transfer');?>" method="POST" >
   <div class="form_design">
      <?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
      <?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
      <?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
      <table class="form_table_design">
         <tr>
            <td>
               <table class="form_table_inner">
                  <?php foreach($select_active_records_rfd_data as $row_data) {?>
                  <tr>
                     <td><input type="hidden" name="dia" value="<?php echo $row_data->sleeve_dia;?>" ></td>
                  </tr>
                  <?php } ?>
                  <tr>
                     <td class="label">Order No * :</td>
                     <td>
                        <input type="hidden" name="order_flag" value="<?php echo $order_row->order_flag;?>">
                        <input type="text" name="order_no" id="order_no"value="<?php echo $order_row->order_no;?>" readonly>
                     </td>
                  </tr>
                  <?php foreach($select_active_records_rfd_data as $row_data) {?>
                  <tr>
                     <td><input type="hidden" name="total_microns" value="<?php echo $row_data->total_microns;?>" ></td>
                  </tr>
                  <?php  } ?>
                  <tr>
                     <td class="label">Order Date * :</td>
                     <td><input type="text" name="order_date" value="<?php echo $order_row->order_date;?>" disabled></td>
                  </tr>
                  <?php foreach($select_active_records_rfd_data as $row_data) {?>
                  <tr>
                     <td><input type="hidden" name="sleeve_length" value="<?php echo $row_data->sleeve_length;?>" ></td>
                  </tr>
                  <?php }  ?>  
                  <tr>
                     <td class="label">Po No * :</td>
                     <td><input type="text" name="po_no" value="<?php echo set_value('po_no',$order_row->cust_order_no);?>" disabled/></td>
                  </tr>
                  <?php foreach($select_active_records_rfd_data as $row_data) {?>
                  <tr>
                     <td><input type="hidden" name="second_layer_mb" value="<?php echo $row_data->second_layer_mb;?>" ></td>
                  </tr>
                  <?php  } ?>
                  <tr>
                     <td class="label">Po Date * :</td>
                     <td><input type="date" name="po_date" value="<?php echo set_value('po_date',$order_row->order_date);?>" disabled/></td>
                  </tr>
                  <?php foreach($select_active_records_rfd_data as $row_data) {?>
                  <tr>
                     <td><input type="hidden" name="sixth_layer_mb" value="<?php echo $row_data->sixth_layer_mb;?>" ></td>
                  </tr>
                  <?php } ?>
                  <?php foreach($select_active_records_rfd_data as $row_data) {?>
                  <tr>
                     <td><input type="hidden" name="customer" value="<?php echo $row_data->customer;?>" ></td>
                  </tr>
                  <?php break; } ?>
                  <?php foreach($order_details as $order_details_row):?>
                  <tr>
                     <td class="label">Product Code * :</td>
                     <td><input type="text" name="article_no" id="article_no" value="<?php echo $order_details_row->article_no;?>" readonly>
                        <input type="hidden" name="ord_pos_no" value="<?php echo $order_details_row->ord_pos_no;?>">
                     </td>
                  </tr>
                  <?php foreach($select_active_records_rfd_data as $row_data) {?>
                  <tr>
                     <td><input type="hidden" name="user_id" value="<?php echo $row_data->user_id;?>" ></td>
                  </tr>
                  <?php break; } ?>
                  <tr>
                     <td class="label">Product Name * :</td>
                     <td><input type="text" name="article_name" size="50" value="<?php echo $order_details_row->description;?>" disabled></td>
                  </tr>
                  <?php foreach($select_active_records_rfd_data as $row_data) {?>
                  <tr>
                     <td><input type="hidden" name="film_code" value="<?php echo $row_data->film_code;?>" ></td>
                  </tr>
                  <?php }  ?>
                  <?php
                     $total_rfd_qty=0;
                     $total_dispatch_qty=0;
                     $i=0;
                     
                     if($springtube_rfd_master==TRUE){
                     
                     foreach ($springtube_rfd_master as  $springtube_rfd_master_row) {
                     $total_rfd_qty+=$springtube_rfd_master_row->rfd_qty;
                     $total_dispatch_qty+=$springtube_rfd_master_row->release_qty;
                     $i++;
                     }
                     }
                     ?>
                  <tr>
                     <td class="label"> RFD Qty <span style="color:red">*</span> :</td>
                     <td><input type="text" name="total_rfd_qty" id="total_rfd_qty" value="<?php echo set_value('total_rfd_qty',$total_rfd_qty);?>" readonly></td>
                  </tr>
                  <?php foreach($select_active_records_rfd_data as $row_data) {?>
                  <tr>
                     <td><input type="hidden" name="created_date" value="<?php echo $row_data->created_date;?>" ></td>
                  </tr>
                  <?php break; } ?>
                  <?php
                     foreach($rfd_transfer as $rfd_transfer_row){ ?>
                  <tr>
                     <td class="label">Total Order Qty <span style="color:red">*</span> :</td>
                     <td><input type="text" name="total_order_qty" id="total_order_qty" value="<?php echo $rfd_transfer_row->order_quantity;?>" readonly></td>
                  </tr>
                  <tr>
                     <td class="label">Tolrance % <span style="color:red">*</span> :</td>
                     <td><input type="text" name="dispatch_tolerance" id="dispatch_tolerance" value="<?php echo $rfd_transfer_row->dispatch_tolerance;?>" readonly></td>
                  </tr>
                  <tr>
                     <td class="label"><b>Transfer Qty </b> <span style="color:red">*</span> :</td>
                     <td><input type="text" name="transfer_qty" id="transfer_qty" class="transfer_qty" value="">
                        <input type="hidden" name="ord_pos_no" value="<?php echo $order_details_row->ord_pos_no;?>">
                     </td>
                  </tr>
                  <tr>
                     <td class="label">Export  :</td>
                     <td><input type="checkbox" name="export"  value="1" <?php echo set_checkbox('export',1);?> <?php echo ($order_row->for_export==1 ? 'value="1" checked' : 'value="0"');?> disabled/></td>
                  </tr>
                  <tr>
                     <td class="label">For Sample  :</td>
                     <td><input type="checkbox" name="for_sampling"  value="1" <?php echo set_checkbox('for_sampling',1);?> <?php echo ($order_row->for_sampling==1 ? 'value="1" checked' : 'value="0"');?> disabled/></td>
                  </tr>
                  <?php }  ?>
                  <?php endforeach;?>
               </table>
            </td>
            <td>
               <table class="form_table_inner">
                  <?php foreach ($rfd as $rfd_row) {?>
                  <tr>
                     <td><input type="hidden" name="article_no" id="article_no" value="<?php echo $order_details_row->article_no;?>" readonly>
                        <input type="hidden" name="jobcard_no" value="<?php echo $rfd_row->jobcard_no;?>">
                     </td>
                  </tr>
                  <?php  } ;?>
                  <tr>
                     <td class="label"><b>Transfer Order No </b> :</td>
                     <td>
                        <input type="text" name="so_no" id="so_no"value="<?php echo set_value('order_no');?>" placeholder="Order No">
                     </td>
                  </tr>
                  <tr>
                     <td class="label align-ctr align-ctr"><b>Transfer Product Code *</b><span style="color:red;"></span> :</td>
                     <td colspan="3">
                        <select name="articl_no" id="articl_no" required/>
                           <option value="<?php echo set_value('article_no');?>"> Select Article No.</option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <td class="label align-ctr align-ctr"><b> Jobcard No *</b><span style="color:red;"></span> :</td>
                     <td colspan="3">
                        <select name="job_card_no" id="job_card_no" required/>
                           <option value="<?php echo set_value('jobcard_no');?>"> Select Jobcard No.</option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <td class="label align-ctr align-ctr"><b>Transfer RFD Qty *</b><span style="color:red;"></span> :</td>
                     <td colspan="3">
                        <select name="transfer_rfd_qty" id="transfer_rfd_qty" class="transfer_rfd_qty" required/>
                           <option value="<?php echo set_value('rfd_qty');?>"> Select RFD Qty</option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <td class="label">Transfer Product Name * :</td>
                     <td><input type="text" name="article_name" id="article_name" value="<?php echo set_value('article_no');?>"></td>
                  </tr>
               </table>
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <div class="ui buttons">
                  <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
                  <div class="or"></div>
                  <button class="ui positive button">Submit</button>
               </div>
            </td>
         </tr>
      </table>
   </div>
</form>
<?php endforeach;?>