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

</script>
<?php foreach($springtube_bodymaking_wip_master as $row){ ?>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/wip_release_save/'.$row->bm_wip_id);?>" method="POST" >
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
							<td><input type="hidden" name="bm_wip_id" value="<?php echo set_value('bm_wip_id',$row->bm_wip_id);?>">
								<input type="date" name="release_date"   value="<?php echo set_value('release_date',date('Y-m-d'));?>" readonly /></td>
							
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
							<td ><input type="text" name="shortfall_qty" id="shortfall_qty"  size="20" value="<?php echo set_value('shortfall_qty',$row->bm_wip_qty);?>" /></td>
						</tr>

						<tr>
							<td class="label">Release Qty <span style="color:red;">*</span>  :</td>
							<td ><input type="text" name="scrap_qty" id="shortfall_qty"  size="20" value="<?php echo set_value('scrap_qty',$row->scrap_qty);?>" /></td>
						</tr>
						<tr>
						
						<tr>
							<td class="label" >Release Towards <span style="color:red;">*</span>:</td>
							<td><select name="to_process" id="to_process">				
								<option value="">--Please select--</option>
								<option value="1" <?php echo set_select('to_process','1');?>>SPRINGTUBE BODYMAKING SHORT FALL</option>
								<option value="1" <?php echo set_select('to_process','2');?>>SCRAP</option>
									
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