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
   $(".scrap_qty").live("change", function() {
	   var ok_qty      = Number($('input[name=rfd]').val());
	   var release_qty = Number($("#scrap_qty").val());
      

      if(release_qty > ok_qty){
       	alert('RFD Qty Greater Than Release Qty');
		   Number($('#scrap_qty').removeAttr('value'));
		   location.reload();
      }else{
       	$("#wip_qty").val(ok_qty - release_qty);
  
      }

	});
});

$(function() {
  $('.scrap_qty').click(function() {
    $('#output').html(function(i, val) {   
      if(val == 1){
         alert('ReEnter Qty');
         location.reload();
      }else{
      	return val * 1 + 1;
      }
    });
  });
});

</script>
<style>
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
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST"  >

	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<?php foreach($coex_r_f_d as $row):?>

		
		
		<fieldset style="border: 1px solid #8cacbb;">
		<legend><b>RFD Quantity Check </b></legend>
		<table class="form_table_design">
			<tr>
				<td width="100%">
					<table class="form_table_inner">
					
            <input type="hidden" name="release_rfd_id" value="<?php echo set_value('release_rfd_id',$row->rfd_id);?>">

						<tr>
							<td class="label" >AQL Date :</td>
							<td>
								<input type="date" name="aql_date"  id="aql_date" size="10" value="<?php echo set_value('aql_date',$row->aql_date);?>" readonly required style="width:168px;">
							</td>

							<td class="label">OC Date :</td>
							<td>
							    <input type="date" name="oc_date"  id="oc_date" size="10" value="<?php echo set_value('oc_date',$row->oc_date);?>" readonly required style="width:168px;">
						  </td>
						</tr>						
						
						<tr>
							<td class="label">Customer :</td>
							<td colspan="4">
							    <input type="text" name="customer" id="customer"  size="72" value="<?php echo set_value('customer',$row->name1);?>" readonly/>
						  </td>
						</tr> 

						<tr>
							<td class="label">Article No. :</td>
							<td>
							  <input type="text" name="article_no" id="article_no"  size="20" value="<?php echo set_value('article_no',$row->article_no);?>" readonly/>
							</td>

							<td class="label">Order No :</td>
							<td>
							  <input type="text" name="order_no" id="order_no"  size="20" value="<?php echo set_value('order_no',$row->order_no);?>" readonly/>
						  </td>
						</tr>
						
						<tr>
							<td class="label">Product :</td>
							<td colspan="4">
							    <input type="text" name="product" id="product"  size="72" value="<?php echo set_value('product',$row->lang_article_description);?>" readonly/>
						  </td>
						</tr>

						<tr>
							<td class="label">Print Type :</td>
              <td colspan="4">
              	<input type="text" name="print_type" id="print_type"  size="72" value="<?php echo set_value('print_type',$row->print_type);?>" readonly/>
              </td>
						</tr>
                         
						<tr>
							<th style="background: #dee7ec;text-align: left;">RFD Qty</th>
							<th style="background: #dee7ec;text-align: left;">Release RFD Qty<span style="color:red;">*</span></th>
							<th colspan="2" style="background: #dee7ec;text-align: left;">Inspector Name<span style="color:red;">*</span></th>
						</tr>
            
            <input type="hidden" name="ok_qty" id="ok_qty" size="20" value="<?php echo set_value('ok_qty',$row->rfd);?>" >

						<tr>
							<td>
								<input type="number" name="rfd" id="wip_qty" class="wip_qty"  size="20" min="0" value="<?php echo set_value('rfd',$row->rfd);?>" readonly/ style="font-weight: 600;">
							</td>
							
							<td>
								<input type="number" name="release_qty" id="scrap_qty" class="scrap_qty" size="20" min="0" value="<?php echo set_value('release_qty');?>" style="font-weight: 600;">
							</td>
                     
							<td >
								<input type="text" name="inspector_name" id="inspector_name"  size="20" value="<?php echo set_value('inspector_name');?>" style="width:205%">
							</td>
						</tr>

						<tr>
							<td class="label" colspan="4">Remark</td>
						</tr>
            
            <tr>
							<td colspan="4">
								  <textarea id="remark" name="remark" rows="5" cols="99"></textarea>
							</td>
						</tr>	

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
       <?php endforeach;?>	
</div>
<div style="visibility: hidden" id="output">0</div>	
</form>



