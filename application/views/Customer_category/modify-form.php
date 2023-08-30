
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
				<?php foreach($customer as $row):?>
					<table class="form_table_inner">
									
									<tr>
										<td class="label">Category Name <span style="color:red;">*</span> :</td>
										<td><input type="text" name="category_name" maxlength="150" size="60" value="<?php echo set_value('category_name',$row->category_name);?>" title="<?php echo set_value('category_name',$row->category_name);?>" />
										<input type="hidden" name="adr_category_id" value="<?php echo $row->adr_category_id;?>" /></td>
									</tr>

									
				</table>			
								
				</td>

				
							
			</tr>
		</table>
					<?php endforeach;?>
	</div>

	<div class="form_design">
		<button class="submit" name="submit">Update</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div>
		
</form>
				
				
				
				
				
			