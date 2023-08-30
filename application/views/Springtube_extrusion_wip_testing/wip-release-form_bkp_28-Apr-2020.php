<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#jobcard_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_extrusion_autocomplete');?>", {selectFirst: true});
		$("#tr_release_to_order_no").hide();

		$("#release_to").change(function(){
			if($('#release_to').val()=='1'){

				$("#tr_release_to_order_no").show();

				$("#loading").show();
	            $("#cover").show();
	            $('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
		        $.ajax({type: "POST",
		        	url: "<?php echo base_url(); ?>" + "index.php/ajax_springtube/get_orders_for_wip_release",
		        	data: {order_no : $('#order_no').val()},
		        	cache: false,
		        	success: function(html){
		               setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
			            if(html!=''){
			            	$("#release_to_order_no").html(html);
			            }
		         	} 
		        });   
		        

			}else{
				$("#tr_release_to_order_no").hide();
			}
			

		});

		$("#release_reels").keyup(function(){
			
			if($("#release_reels").val()!=''){
			
				var release_reels=parseInt($("#release_reels").val());
				
				var reel_length=<?php echo $this->config->item('springtube_reel_length');?>;
				$("#release_meters").val(reel_length*release_reels);
			}else{
				$("#release_meters").val('');
			}
		});

				
		$("#release_meters").blur(function(){
			
			if($("#release_meters").val()!='' || $("#release_meters").val()!='0'){


				
				if(parseInt($("#release_meters").val()) > parseInt($("#total_ok_meters").val())){

					alert('Release meter must be less than or equal to Total Ok meters');
					$("#release_meters").val('');
					$("#release_meters").focus();
				}
				
			}
		});

	});//Jquery closed

</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/wip_release_save');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">

						<?php foreach($springtube_extrusion_wip_master as $row):?>

						<tr>
							<td class="label">Release Date <span style="color:red;">*</span> :</td>
							<td><input type="hidden" name="wip_id" value="<?php echo set_value('wip_id',$row->wip_id);?>">
								<input type="date" name="release_date"   value="<?php echo set_value('release_date',date('Y-m-d'));?>" readonly /></td>
							
						</tr>
						<tr>
							<td class="label">Order No.  :</td>
							<td ><input type="text" name="order_no" id="order_no"  size="20" value="<?php echo set_value('order_no',$row->order_no);?>"/></td>
						</tr>
						<tr>
							<td class="label">Article No.  :</td>
							<td ><input type="text" name="article_no" id="article_no"  size="60" value="<?php echo set_value('article_no',$this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id']).'//'.$row->article_no);?>" readonly/></td>
						</tr>
						<tr>
							<td class="label">Jobcard No.  :</td>
							<td ><input type="text" name="jobcard_no" id="jobcard_no"  size="20" value="<?php echo set_value('jobcard_no',$row->jobcard_no);?>" readonly/></td>
						</tr>
						<tr>
							<td class="label">Total Ok Meters  :</td>
							<td ><input type="hidden" name="wip_cost_per_meter" value="<?php echo set_value('wip_cost_per_meter',$row->wip_cost_per_meter);?>"
								<input type="text" name="total_ok_meters" id="total_ok_meters"  size="20" value="<?php echo set_value('total_ok_meters',$row->total_ok_meters);?>" readonly/></td>
						</tr>
						<tr>
							<td class="label">Total Ok Reels  :</td>
							<td ><input type="number" name="total_ok_reels" id="total_ok_reels"  size="20" maxlength="5" min="1" max="1000" step="1" value="<?php echo set_value('total_ok_reels',($row->total_ok_meters/$this->config->item('springtube_reel_length')));?>" readonly/></td>
						</tr>
						<tr>
							<td class="label">Release Reels  :</td>
							<td ><input type="number" name="release_reels" id="release_reels"  size="20" maxlength="5" min="1" max="1000" step="1" value="<?php echo set_value('release_reels');?>" required/></td>
						</tr>
						<tr>
							<td class="label">Release Meters  :</td>
							<td ><input type="text" name="release_meters" id="release_meters"  size="20" maxlength="10" min="1" max="100000" value="<?php echo set_value('release_meters');?>" required/></td>
						</tr>
						<tr>
							<td class="label" >Release Towards:</td>
							<td><select name="release_to" id="release_to">					
								<option value="">--Please select--</option>
								<option value="1" <?php echo set_select('release_to','1');?> >SPRING PRINTING WIP BEFORE PRINT</option>
								<option value="2" <?php echo set_select('release_to','2');?> >SPRING EXTRUSION SCRAP</option>
																
							</select>
							</td>
						</tr>
						<tr id="tr_release_to_order_no">
							<td class="label" >Release To Order No:</td>
							<td><select name="release_to_order_no" id="release_to_order_no" >					
								<option value="">--Please select--</option>
							</select>
							</td>
						</tr>
						<tr>
							<td class="label">Remarks :</td>
							<td>
								<textarea name="release_remarks" id="release_remarks" cols="40" rows="3" value="<?php echo trim(set_value('release_remarks'));?>" maxlength="256">
								<?php echo trim(set_value('release_remarks'));?>	
								</textarea>
							</td>
						</tr>

				<?php endforeach;?>		
						

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

	
</form>




				
				
				
			