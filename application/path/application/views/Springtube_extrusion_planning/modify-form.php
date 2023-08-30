<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#adr_company_id").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});
		//$("#consin_adr_company_id").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});
		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});
		$("#order_no").autocomplete("<?php echo base_url('index.php/ajax/so_no');?>", {selectFirst: true});

		

	$("#jobcard_perc").live('keyup',function(){
		$("#loading").show(); $("#cover").show();
		$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
		if($("#jobcard_perc").val()!=''){

			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/springtube_extrusion_planning');?>",data: {id : $("#id1").val(),order_no : $("#order_no").val(),article_no : $("#article_no").val(),jobcard_perc : $("#jobcard_perc").val() },cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				var result=html;
				//alert(result);

					
				
				} 
			});

		}


	});

		$("#jobcard_perc").blur(function(){
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			
			if($("#jobcard_perc").val()!=''){

				$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/springtube_extrusion_planning');?>",data: {id : $("#id1").val(),order_no : $("#order_no").val(),article_no : $("#article_no").val(),jobcard_perc : $("#jobcard_perc").val() },cache: false,success: function(html){
					setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
					var result=html;
					alert(result);
					
                  
                
					
					} 
				});

			}


		});

	});

</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design" id="myTable">
			<tr>
				<td>
					<table class="form_table_inner">

						<?php foreach($spring_extrusion_planning_master as $row):?>

							<tr>
								<td class="label"> Planning From Date <span style="color:red;">* </span> :
								</td>
								<td>
									<input type="hidden" name="id1" id="id1" value='<?php echo $row->id;?>'>
									<input type="date" name="planning_from_date" id="planning_from_date" value="<?php echo set_value('planning_from_date',$row->planning_from_date);?>"/>
								</td>
							</tr>
							<tr>
								<td class="label"> Planning To Date <span style="color:red;">* </span> :
								</td>
								<td>											
									<input type="date" name="planning_to_date" id="planning_to_date" value="<?php echo set_value('planning_to_date',$row->planning_to_date);?>"/>
								</td>
							</tr>
							<tr>
								<td class="label"> Order No <span style="color:red;">* </span> :
								</td>
								<td>											
									<input type="text" name="order_no" id="order_no" readonly value="<?php echo set_value('order_no',$row->order_no);?>"/> 

								</td>
							</tr>
							<tr>
								<td class="label"> Article No <span style="color:red;">* </span> :
								</td>
								<td>											
									<input type="text" name="article_no" id="article_no" readonly value="<?php echo set_value('article_no',$row->article_no);?>"/> 

								</td>
							</tr>
							<tr>
								<td class="label"> Article Desc <span style="color:red;">* </span> :
								</td>
								<td>											
									<input type="text" name="article_desc" id="article_desc" readonly size="60" value="<?php echo set_value('article_desc',$this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id']));?>"/> 

								</td>
							</tr>
							<tr>
								<td class="label"> Extra % <span style="color:red;">* </span> :
								</td>
								<td>											
									<input type="text" name="jobcard_perc" id="jobcard_perc" value="<?php echo set_value('jobcard_perc',$row->jobcard_perc);?>"/> 

								</td>
							</tr>

							<!--<tr>
								<td class="label"> Jobcard Qty % <span style="color:red;">* </span> :
								</td>
								<td>											
									<input type="text" name="jobcard_qty" id="jobcard_qty" value="<?php echo set_value('jobcard_qty',$row->jobcard_qty);?>"/> 

								</td>
							</tr>-->
							<!--<tr>
								<td class="label"> No. Of Reels Planned <span style="color:red;">* </span> :
								</td>
								<td>											
									<input type="text" name="reels_planned" id="reels_planned" value="<?php echo set_value('reels_planned',$row->reels_planned);?>"/> 

								</td>
							</tr>-->
																		
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
				
