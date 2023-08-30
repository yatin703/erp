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
   $(".reverce_qty").live("change", function() {
	   var release_qty      = Number($('input[name=release_qty]').val());
       var shortfall_qty      = Number($('input[name=shortfall_qty]').val());
	   var reverce_qty = Number($("#reverce_qty").val());
      

      if(reverce_qty > release_qty){
       	alert('Ok Qty Greater Than Reverce Qty');
		   Number($('#reverce_qty').removeAttr('value'));
		   location.reload();
      }else{
       	$("#release_qty").val(release_qty - reverce_qty);
        $("#shortfall_qty").val(shortfall_qty + reverce_qty);
  
      }

	});
});

$(function() {
  $('.release_qty').click(function() {
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


<?php foreach($springtube_printing_wip_master_after as $row){ ?>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/wip_release_save_scrap/'.$row->aprint_wip_id);?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

						

						<tr>
							<td class="label">Release Date <span style="color:red;">*</span> :</td>
							
							<td><input type="hidden" name="aprint_wip_id" value="<?php echo set_value('aprint_wip_id',$row->aprint_wip_id);?>">
							<input type="date" name="release_date"   value="<?php echo set_value('release_date',date('Y-m-d'));?>" readonly /></td>
							<td><input type="hidden" name="aprint_wip_date" value="<?php echo set_value('aprint_wip_date',$row->aprint_wip_date);?>">
							<td><input type="hidden" name="total_microns" value="<?php echo set_value('aprint_wip_date',$row->total_microns);?>">
							<td><input type="hidden" name="second_layer_mb" value="<?php echo set_value('second_layer_mb',$row->second_layer_mb);?>">
							<td><input type="hidden" name="sixth_layer_mb" value="<?php echo set_value('sixth_layer_mb',$row->sixth_layer_mb);?>">
							<td><input type="hidden" name="sleeve_dia" value="<?php echo set_value('sleeve_dia',$row->sleeve_dia);?>">
							<td><input type="hidden" name="sleeve_length" value="<?php echo set_value('sleeve_length',$row->sleeve_length);?>">
								
							
						</tr> 
						<tr>
							<td class="label">Jobcard No.  :</td>
							<td ><input type="text" name="jobcard_no" id="jobcard_no"  size="20" value="<?php echo set_value('jobcard_no',$row->jobcard_no);?>" readonly/></td>
						</tr>
						<tr>
							<td class="label">Order No.  :</td>
							<td ><input type="text" name="order_no" id="order_no"  size="20" value="<?php echo set_value('order_no',$row->order_no);?>" readonly/></td>
						</tr>
						<tr>
							<td class="label">Article No.  :</td>
							<td ><input type="text" name="article_no" id="article_no"  size="60" value="<?php echo set_value('article_no',$this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id']).'//'.$row->article_no);?>" readonly/></td>
						</tr>	

                        <tr>
							<td class="label">Input Qty <span style="color:red;">*</span>  :</td>
							<td ><input type="text" name="shortfall_qty" id="shortfall_qty" class="shortfall_qty"  size="20" value="<?php echo set_value('shortfall_qty',$row->aprint_wip_qty);?>" readonly/></td>
						</tr>
                        
                        <tr>
							<td class="label">Release Qty <span style="color:red;">*</span>  :</td>
							<td ><input type="text" name="release_qty" id="release_qty" class="release_qty" size="20" value="<?php echo set_value('release_qty',$row->release_qty);?>" readonly/></td>
						</tr>
						
						<tr>
							<td class="label">Reverce Qty <span style="color:red;">*</span>  :</td>
							<td ><input type="text" name="reverce_qty" id="reverce_qty" class="reverce_qty"  size="20" value="" /></td>
						</tr>

						
						<tr>
						
						<tr>
							<td class="label" >Release Towards <span style="color:red;">*</span>:</td>
							<td><select name="to_process" id="to_process">				
								<option value="">--Please select--</option>
								<option value="1" <?php echo set_select('to_process','1');?>>SPRINGTUBE BODYMAKING SHORT FALL</option>
								<option value="1" <?php echo set_select('to_process','2');?>>Printing WIP Reverce</option>
									
							</select>
							</td>
						</tr>						 
					</table>			
				</td>
			</tr>
		</table>							
	</div>
	
	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button">Release</button>
		</div>
	</div>

<?php }?>
	
</form>