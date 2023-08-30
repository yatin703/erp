<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
   $(document).ready(function(){
   	$("#loading").hide(); $("#cover").hide();
   	$("#release_to_order_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/spring_open_so_no');?>", {selectFirst: true});		
   	$("#tr_release_to_order_no").hide();
   	$("#td_release_order").hide()
   });//Jquery closed
   
   
   $(document).ready(function() {
        $( ".scrap_qty" ).live( "change", function() {
       var tr = $(this).closest("tr");
       tr.find(".wip_qty").val(Number(tr.find(".wip_qty").val()) - Number(tr.find(".scrap_qty").val()));
       if (a > 0) {
   		  $("#display").text(a + " is greater than 0");
   		}   
     });
   });
   
   
</script>
<style>
   .on-hower {
   background-color: #e4e4e4;
   }
   input[readonly]{background: #f7f7f7;cursor:no-drop;}
   select[readonly]{
   background: #f7f7f7;
   cursor:no-drop;
   }
   select[readonly] option{
   display:none;
   }
   fieldset{
   border: 1px solid #8cacbb;
   width: 59%;
   }
</style>
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/return_scrap_wip');?>" method="POST"  >
   <div class="form_design">
      <?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
      <?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
      <?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
      <?php
         if($coex_extrusion_wip_scrap!='False'){
         	foreach ($coex_extrusion_wip_scrap as $row) {
         ?>

      <input type="hidden" name="wip_scrap_id" value="<?php echo set_value('scrap_id',$row->wip_scrap_id);?>">
      <input type="hidden" name="ce_id" value="<?php echo set_value('ce_id',$row->ce_id);?>">
      <input type="hidden" name="qc_id" value="<?php echo set_value('qc_id',$row->qc_id);?>">
      <input type="hidden" name="wip_id" value="<?php echo set_value('wip_id',$row->wip_id);?>">

      <fieldset style="border: 1px solid #8cacbb;">
         <legend><b>Extrusion Hold Quantity Return</b></legend>

         <table class="form_table_design">
            <tr>
               <td width="100%">
                  <table class="form_table_inner">
                     <?php
                        if($coex_extrusion_wip_scrap!=''){
                        foreach ($coex_extrusion_wip_scrap as $row) {
                        ?>

                     <tr>
                        <td class="label"> Production Date :</td>
                        <td><input type="date" name="release_date"   value="<?php echo set_value('release_date',date('Y-m-d'));?>" readonly / style="width: 100%;"></td>
                        <td class="label">Operator :</td>
                        <td><input type="text" name="operator" id="operator" value="<?php echo set_value('operator',$row->operator);?>" placeholder="Operator" readonly required/ style="width: 100%;">
                        </td>
                     </tr>

                     <tr>
                        <td class="label" >Shift :</td>
                        <td>
                           <select name="shift" id="shift" readonly required/ style="width: 100%;">
                              <option value=''>--Shift--</option>
                              <?php if($shift_master==FALSE){
                                 echo "<option value=''>--Setup Required--</option>";}
                                 else{
                                 foreach($shift_master as $shift_master_row){
                                 $selected=($shift_master_row->shift_id==$row->shift_id ? 'selected' :'');
                                 echo "<option value='".$shift_master_row->shift_id."'  $selected ".set_select('shift',''.$shift_master_row->shift_id.'').">".$shift_master_row->shift_name."</option>";
                                 	}
                                 }?>
                           </select>
                        </td>
                        <td class="label">Machine :</td>
                        <td>
                           <select name="machine" id="machine" readonly required/ style="width: 100%;">
                              <option value=''>--Machine--</option>
                              <?php if($coex_machine_master==FALSE){
                                 echo "<option value=''>--Setup Required--</option>";}
                                  else{
                                 foreach($coex_machine_master as $machine_row){
                                 $selected=($machine_row->machine_id==$row->machine_id ? 'selected' :'');
                                 echo "<option value='".$machine_row->machine_id."' $selected ".set_select('machine',''.$machine_row->machine_id.'').">".$machine_row->machine_name."</option>";
                                  }
                                 }?>
                           </select>
                        </td>
                     </tr>

                     <tr>
                        <td class="label">Order No :</td>
                        <td>
                           <input type="text" name="order_no" id="order_no"  size="20" value="<?php echo set_value('order_no',$row->order_no);?>" readonly/ style="width: 100%;">
                        </td>
                        <td class="label">Product No :</td>
                        <td>
                           <input type="text" name="article_no" id="article_no"  size="20" value="<?php echo set_value('diameter',$row->article_no);?>" readonly/>
                        </td>
                     </tr>

                     <tr>
                        <td class="label">Job No:</td>
                        <td>
                           <input type="text" name="jobcard_no" id="jobcard_no"  size="20" value="<?php echo set_value('jobcard_no',$row->jobcard_no);?>" readonly/ style="width: 100%;">
                        </td>
                        <td class="label">Sleeve Weight :</td>
                        <td><input type="text" name="sleeve_weight_gm" id="sleeve_weight_gm"  size="20" value="<?php echo set_value('sleeve_weight_gm',$row->sleeve_weight_gm);?>" readonly/></td>
                     </tr>

                     <tr>
                        <td class="label">Dia:</td>
                        <td>
                           <input type="text" name="diameter" id="diameter"  size="20" value="<?php echo set_value('diameter',$row->diameter);?>" readonly/ style="width: 100%;">
                        </td>
                        <td class="label">Length :</td>
                        <td><input type="text" name="length" id="length"  size="20" value="<?php echo set_value('length',$row->length);?>" readonly/></td>
                     </tr>
                     
                     <tr>
                        <th style="background: #dee7ec;text-align: left;">WIP Scrap Qty</th>
                        <th style="background: #dee7ec;text-align: left;">Release WIP Qty<span style="color:red;">*</span></th>
                        <th colspan="2" style="background: #dee7ec;text-align: left;">Inspector Name<span style="color:red;">*</span></th>
                     </tr>

                     <tr>
                        <td><input type="number" name="ok_by_qc" id="wip_qty" class="wip_qty"  size="20" value="<?php echo set_value('ok_by_qc',$row->scrap_qty);?>" readonly required style="font-weight: 600;"></td>
                        <td ><input type="number" name="release_qty" id="scrap_qty" class="scrap_qty" size="20" value="<?php echo set_value('release_qty');?>" style="font-weight: 600;"></td>
                        <td ><input type="text" name="release_by" id="release_by"  size="20" value="<?php echo set_value('release_by');?>" style="width: 230%;"></td>
                     </tr>

                     <tr>
						<td class="label" colspan="4">Remark</td>
					 </tr>
            
                     <tr>
						<td colspan="4">
							  <textarea id="remark" name="remark" rows="5" cols="93"></textarea>
						</td>
					  </tr>
                    
                     <?php 
                        }
                        }
                        ?>						
                  </table>
               </td>
            </tr>

            <tr>
               <td colspan="2">
                  <div class="ui buttons">
                     <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
                     <div class="or"></div>
                     <button class="ui positive button" id="btnsubmit" class="disabled">Save</button>
                  </div>
               </td>
            </tr>

         </table>
      </fieldset>
      <?php 
         }
         }
         ?>	
   </div>
   <div style="visibility: hidden" id="output">0</div>
   <div style="visibility: hidden" id="output_scrap">0</div>
</form>