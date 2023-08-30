

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_attach_customer_file');?>" method="POST" autocomplete="off" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
				
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner" >

						<tr>
							<?php foreach($artwork as $artwork_row){
								echo'<td class="label">Artwork No * :</td>
								     <td><input type="text" name="artwork_no" value="'.set_value('artwork_no',$artwork_row->ad_id).'" readonly/>
								     </td>
								     <td class="label">Version No * :</td>
								     <td>
								  		 <input type="text" name="version_no" value="'.set_value('version_no',$artwork_row->version_no).'" readonly/>
								  	</td>';

							}?>
							
						</tr>
						<tr>
								<td colspan="2" class="label">Attach Customer Approved File <span style="color:red;">*</span> :</td>
								<td colspan="2"><input type="file" name="userfile1" required /></td>
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
	  <button class="ui positive button" id="btnupload" >Upload</button>


		</div>
	</div>
	<!--<input type="submit" value="upload" />-->
		
</form>