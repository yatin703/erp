<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

							<?php foreach($springtube_jobcard_perc_master as $row):?>
									<tr>
										<td class="label">Jobcard % <span style="color:red;">*</span> :</td>
										<td>
											<input type="hidden" name="id"  value="<?php echo set_value('id',$row->id);?>" readonly/>
											<input type="number" name="perc"  value="<?php echo set_value('perc',$row->perc);?>" />
										</td>
									</tr>
									
							<?php endforeach;?>		

					</table>			
								
				</td>
							
			</tr>
		</table>
					
	</div>

	<div class="form_design">
			
		<button class="submit" name="submit">Update</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div>
		
</form>
				
