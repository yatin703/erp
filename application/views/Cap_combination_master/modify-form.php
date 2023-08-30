<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();

		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});
		$("#ref_article_no").autocomplete("<?php echo base_url('index.php/ajax/purchase_article_no');?>", {selectFirst: true});
						
	});
</script>


<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST"  >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">
						<?php foreach($cap_combination_master as $row):?>	
						<tr>
							<td class="label">Cap Article No. * :</td>
							<td><input type="hidden" name="id" value="<?php echo set_value('id',$row->id);?>"/>
								<input type="text" name="article_no" id="article_no"  size="60" value="<?php echo set_value('article_no',$this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id']).'//'.$row->article_no);?>" required placeholder="Cap Article No"/></td>
							<td class="label">Cap Metalization Charges. * :</td>
							<td>
								<input type="text" name="ref_article_no" id="ref_article_no"  size="60" value="<?php echo set_value('ref_article_no',$this->common_model->get_article_name($row->ref_article_no,$this->session->userdata['logged_in']['company_id']).'//'.$row->ref_article_no);?>" required placeholder="Cap Metalization Charges"/>
							</td>
						</tr>
						<?php endforeach;?>							

					</table>			
								
				</td>
											
			</tr>
		</table>

<div class="middle_form_design">
	
		<div class="ui buttons">
		  <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
		  <div class="or"></div>
		  <button class="ui positive button" id="btnsubmit" >Update</button>
		<!-- <input type="submit" class="ui positive button" value="Save"/>-->
		</div>
	

</div>
		
</form>
				
				
				
				
				
			