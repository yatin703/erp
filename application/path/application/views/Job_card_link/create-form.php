<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();

		$("#so_no").autocomplete("<?php echo base_url('index.php/ajax/so_no');?>", {selectFirst: true

		});

		$("#so_no").bind('keyup blur',function() {

			$("#loading").hide(); $("#cover").hide();
		   	var order_no = $('#so_no').val();
		   	var order_no_length=order_no.length;

		   		//$("#article_no").html("<option value=''>---Please Select---</option>");
			   	$("#loading").show();
						$("#cover").show();
						$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			   $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/psm_psp_no",data: {order_no : $('#so_no').val()},cache: false,success: function(html){
			    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
			    		//alert(html);
			       $("#article_no").html(html);

			       //alert($("#link_so_no").html());
			    	} 
			    });

   		});
		
						
	});
</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST"  >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">
						<?php foreach ($job_card as $job_card_row):?>
						<tr>
							<td class="label">Jobcard No. * :</td>
							<td><input type="text" name="mp_pos_no" id="mp_pos_no"  size="20" value="<?php echo set_value('mp_pos_no',$job_card_row->mp_pos_no);?>" placeholder="Jobcard No" readonly/></td>
						</tr>
						<tr>
							<td class="label">Sales Order No. * :</td>
							<td>
								<input type="text" name="sales_ord_no" id="sales_ord_no"  size="20" value="<?php echo set_value('sales_ord_no',$job_card_row->sales_ord_no);?>" placeholder="Sales Order No" readonly/>
							</td>
						</tr>
						<tr>	
							<td class="label">New Sales Order No. * :</td>
							<td>
								<input type="text" name="so_no" id="so_no"  size="20" value="<?php echo set_value('so_no');?>" placeholder=" New Sales Order No."/> &nbsp <a name="link_so_no" id="link_so_no" href="#" target="_blank"></a>
							</td>
						</tr>
						<tr>
							<td class="label">Article No.  <span style="color:red;">*</span> :</td>
							<td>
								<select name="article_no" id="article_no" required >
									<option value="">----Select Article No.----</option>
									<?php
									    if($this->input->post('article_no')!=''){
									    	echo '<option value="'.$this->input->post('article_no').'" selected>'.$this->input->post('article_no').'</option>';
									    }
									?>	
								</select>
							</td>
						</tr>
						<tr>
							<td class="label">Comment. * :</td>
							<td>
								<textarea name="comment" value="<?php echo set_value('comment',$job_card_row->comment);?>" rows="5" cols="30"><?php echo set_value('comment',$job_card_row->comment);?></textarea>
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
		  <button class="ui positive button" id="btnsubmit" >Save</button>
		<!-- <input type="submit" class="ui positive button" value="Save"/>-->
		</div>
	

</div>
		
</form>
				
				
				
				
				
			