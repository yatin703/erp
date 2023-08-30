<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
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

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/wip_release_save');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
	    <?php foreach($coex_extrusion_scrap as $row):?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

						
                        <input type="hidden" name="ce_id" value="<?php echo set_value('ce_id',$row->ce_id);?>">
						<input type="hidden" name="qc_id" value="<?php echo set_value('qc_id',$row->qc_id);?>">
						<input type="hidden" name="wip_id" value="<?php echo set_value('wip_id',$row->wip_id);?>">
						<tr>
							<td class="label">Release Date <span style="color:red;">*</span> :</td>
							<td>
								<input type="date" name="release_date"   value="<?php echo set_value('release_date',date('Y-m-d'));?>" readonly />
							</td>
						</tr>

						<tr>
							<td class="label">Machine <span style="color:red;">*</span> :</td>
							<td>
								<select name="machine" id="machine" readonly required/><option value=''>--Machine--</option>
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
							<td class="label">Shift :</td>
							<td >
								<select name="shift" id="shift" readonly required/><option value=''>--Shift--</option>
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
						</tr>

						<tr>
							<td class="label">Operator  :</td>
							<td ><input type="text" name="operator" id="operator" value="<?php echo set_value('operator',$row->operator);?>" placeholder="Operator" readonly required/ >
							</td>
						</tr>

						<tr>
							<td class="label">Order No.  :</td>
							<td ><input type="text" name="order_no" id="order_no"  size="20" value="<?php echo set_value('order_no',$row->order_no);?>" readonly/>
							</td>
						</tr>

						<tr>
							<td class="label">Article No.  :</td>
							<td ><input type="text" name="article_no" id="article_no"  size="60" value="<?php echo set_value('diameter',$row->article_no);?>" readonly/></td>
						</tr>

						<tr>
							<td class="label">Jobcard No.  :</td>
							<td ><input type="text" name="jobcard_no" id="jobcard_no"  size="60" value="<?php echo set_value('jobcard_no',$row->jobcard_no);?>" readonly/></td>
						</tr>

						<tr>
							<td class="label">Sleeve Weight :</td>
							<td ><input type="text" name="sleeve_weight_gm" id="sleeve_weight_gm"  size="20" value="<?php echo set_value('sleeve_weight_gm',$row->sleeve_weight_gm);?>" readonly/>
							</td>
						</tr>

						<tr>
							<td class="label">Dia :</td>
							<td ><input type="text" name="diameter" id="diameter"  size="20" value="<?php echo set_value('diameter',$row->diameter);?>" readonly/>
							</td>
						</tr>

						<tr>
							<td class="label">Length :</td>
							<td ><input type="text" name="length" id="length"  size="20" value="<?php echo set_value('length',$row->length);?>" readonly/>
							</td>
						</tr>					
						
						<tr>
							<td class="label">Release Qty <span style="color:red;">*</span>  :</td>
							<td ><input type="text" name="ok_by_qc" id="wip_qty" class="wip_qty"  size="20" value="<?php echo set_value('ok_by_qc',$row->ok_by_qc);?>" readonly/>
                            <input type="text" name="release_qty" id="scrap_qty" class="scrap_qty" size="20" value="<?php echo set_value('release_qty');?>" >
							</td>
						</tr>

						<tr>
							<td class="label" >Release Towards <span style="color:red;">*</span>:</td>
							<td><select name="to_process" id="to_process">				
								<option value="">--Please select--</option>
								<option value="1" <?php echo set_select('scrap','1');?>>WIP Scrap</option>
								<option value="2" <?php echo set_select('heading','2');?>>Heading</option>
								<option value="3" <?php echo set_select('printing','3');?>>Printing</option>
								<option value="4" <?php echo set_select('release_qc','4');?>>Return Extrusion QC</option>
							</select>
							</td>
						</tr>

						<tr>
							<td class="label">Released By <span style="color:red;">*</span>:</td>
							<td><input type="text" name="release_by" id="release_by"  size="20" value="<?php echo set_value('release_by');?>"></td>
						</tr>

						<tr>
							<td class="label">Remark :</td>
							<td ><textarea  name="remark" id="remark" value="<?php echo set_value('remark');?>" rows="3"></textarea></td>
						</tr>	

					</table>			
				</td>
			</tr>
		</table>
		<?php endforeach;?>	
							
	</div>
	
	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button">Release</button>
		</div>
	</div>


	
</form>




				
				
				
			 -->