<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script type="text/javascript">
	
	$(document).ready(function(){
		//$("#loading").hide(); $("#cover").hide();

		$("#part_no").autocomplete("<?php echo base_url('index.php/ajax/raw_material_autocomplet_tally');?>", {selectFirst: true});
	});	

</script>


<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

							<?php foreach($tally_material_issue_master as $row):

								$main_group_id='';

								if($row->part_no!=''){

									$data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$row->part_no);
									foreach ($data['article'] as  $article_row) {
										$main_group_id=$article_row->main_group_id;
									}

							    }
							?>    

									<tr>
										<td class="label"> Issue Date <span style="color:red;">* </span> :
										</td>
										<td>
											<input type="hidden" name="id" value='<?php echo $row->id;?>'>
											<input type="date" name="issue_date" id="issue_date" value="<?php echo set_value('issue_date',date('Y-m-d'));?>" required readonly/>
										</td>
									</tr>
									<tr>
										<td class="label"> Jobcard No. <span style="color:red;">* </span> :
										</td>
										<td>
											
											<input type="text" name="jobcard_no" id="jobcard_no" size="60"readonly value="<?php echo set_value('jobcard_no',$row->jobcard_no);?>" required/>

										</td>
									</tr>
									
									<tr>
										<td class="label"> Part no. <span style="color:red;">* </span> :
										</td>
										<td>											
											<input type="text" name="part_no" id="part_no" size="60" value="<?php echo set_value('part_no',$this->common_model->get_article_name($row->part_no,$this->session->userdata['logged_in']['company_id']).'//'.$row->part_no);?>" required   />
										</td>
									</tr>
									<tr>
										<td class="label">Qantity <span style="color:red;">* </span> :
										</td>
										<td>
											
											<input type="text" name="qty" id="qty" size="20" value="<?php echo set_value('qty',$row->qty);?>" required <?php echo ($main_group_id=='1' || $main_group_id=='9'? 'readonly':'')?> />
										</td>
									</tr>
									
									<tr>
										<td class="label"> Status <span style="color:red;">* </span> :
										</td>
										<td>
											
											<input type="text" name="status" id="status" size="20" value="<?php echo set_value('status',$row->status);?>"/>
										</td>
									</tr>
									<tr>
										<td class="label"> Remarks <span style="color:red;">* </span> :
										</td>
										<td>
											
											<input type="text" name="remarks" id="remarks" size="60" value="<?php echo set_value('remarks',$row->remarks);?>"/>
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
				
