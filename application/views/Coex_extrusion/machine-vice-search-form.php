<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/machine_vice_search_result');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">
						<tr>
							<td class="label"><b>From Date</b><span style="color:red;">*</span> :</td>
							<td><input type="date" name="from_date" size="10" value="<?php echo set_value('from_date',date('Y-m-d'));?>" required/>
							<b>To Date</b><span style="color:red;">*</span> :
							<input type="date" name="to_date" size="10" value="<?php echo set_value('to_date',date('Y-m-d'));?>" required/></td>
						</tr>
					</table>
				</td>
				<td>
					<div class="">
						<div class="ui buttons">
					  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
					  		<div class="or"></div>
					  		<button class="ui positive button">Search</button>
						</div>
					</div>
				</td>

			</tr>
		</table>
	</div>
	
</form>
