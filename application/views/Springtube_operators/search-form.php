<script type="text/javascript">
$(document).ready(function() {

	$("#loading").hide();
	$("#cover").hide();
		 
});
</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" method="POST" >
	<div class="form_design ">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">
									
						<tr>
							<td class="label"> Process Name *  :</td>
							<td><select name="process" id="process"><option value="">--Select Process--</option>
							<?php if($springtube_process_master==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($springtube_process_master as $springtube_process_master_row){
										echo "<option value='".$springtube_process_master_row->process_id."'  ".set_select('process',''.$springtube_process_master_row->process_id.'').">".strtoupper($springtube_process_master_row->process_name)."</option>";
									}
							}?>
							</select></td>
						</tr>
						<tr>
							<td class="label">Operator Name  * :</td>
							<td>
								<input type="text" name="operator" id="operator" value="<?php echo set_value('operator');?>" size="20"/>
							</td>
						</tr>							
									
					</table>				
				</td>
							
			</tr>
		</table>
					
	</div>

	<div class="form_design">
		<button class="submit" name="submit">Search</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div>
		
</form>
				
				
				
				
				
			