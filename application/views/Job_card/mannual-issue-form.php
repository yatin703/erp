<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){

		$("#loading").hide(); $("#cover").hide();
		//RM Closed--------
		//$("#product_name_1").autocomplete("<?php echo base_url('index.php/ajax/mannual_issue_article_no');?>", {selectFirst: true});

		//RM Open--------
		$("#product_name_1").autocomplete("<?php echo base_url('index.php/ajax/mannual_issue_article_no_open');?>", {selectFirst: true});

		// $("#product_name_1").live('keyup',function(){

		// 	var arr=$("#product_name_1").val().split("//");
			

		// 	 if(arr.length>1){

		// 	 	var article_no=arr[1];
							
		// 		$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/get_rm_for_issue');?>",data: {article_no : article_no},cache: 	false,
		// 			success: function(html){
		// 				//alert(html);
		// 				var arr=html.split("//");
		// 				$("#availabel_quantity_1").val(arr[0]);
		// 				$("#calculated_purchase_price_1").val(arr[1]);
		// 			},
		// 			beforeSend: function(){
		// 				$("#loading").show();
		// 				$("#cover").show();
		// 				$('#loading').html('<img src="images/loading.gif"> Loading...');	
						
		// 			},
		// 			complete: function(){
		// 				$("#loading").hide(); $("#cover").hide();
						
						
		// 			}  
					
		// 		});
		// 	}
						
		// });

		// $("#issue_quantity_1").blur(function(){
			
								
		// 	if($("#issue_quantity_1").val()!='' && $("#issue_quantity_1").val()!='0'){
					
		// 			//if(parseInt($("#issue_quantity_1").val())<=parseInt($("#availabel_quantity_1").val())){
		// 				var amount=	$("#issue_quantity_1").val() * $("#calculated_purchase_price_1").val();
		// 				amount=amount.toFixed(2);
		// 				$("#amt_manual_1").val(amount);
		// 			//}
		// 			//else{
		// 				//$("#amt_manual_1").val();
		// 				//alert('Please enter correct qty.');
		// 			//}
		// 	}
		// });

		

 		

		$("#add").live('click',function () {
			var header_row=1;
			var counter=$("#table_article tr").length;
			var mark_up='<tr id="tr_'+ counter +'"><td><input type="hidden" name="sr_no[]" value="'+counter+'"/>'+counter+'</td><td><select name="process_'+counter+'" id="process_'+counter+'"><option value="0" <?php set_select('process_"+counter+"',0);?>>COEX</option><option value="1" <?php set_select('process_"+counter+"',1);?>>SPRINGTUBE</option></select></td><td><input type="text" name="document_no_'+counter+'"  id="document_no_'+counter+'" class="quantity" value="<?php echo set_value('document_no_"+counter+"');?>" maxlength="50" size="20" /></td><td><input type="date" name="date_required_'+counter+'"  id="date_required_'+counter+'" class="quantity" value="<?php echo set_value('date_required_"+counter+"',date('Y-m-d'));?>" maxlength="10" size="20" /></td><td><input type="text" name="product_name_'+counter+'" id="product_name_'+counter+'" value="<?php echo set_value('product_name_"+counter+"');?>"size="80" placeholder="Goods Information"/></td><!--<td><input type="text" name="availabel_quantity_'+counter+'" id="availabel_quantity_'+counter+'"  value="<?php echo set_value('availabel_quantity_"+counter+"');?>" maxlength="15" size="20" class="quantity" /></td>--><td><input type="text" name="issue_quantity_'+counter+'"  id="issue_quantity_'+counter+'" class="quantity" value="<?php echo set_value('issue_quantity_"+counter+"');?>" maxlength="15" size="20" placeholder="Quantity" /></td><!--<td><input type="text" name="calculated_purchase_price_'+counter+'"  id="calculated_purchase_price_'+counter+'" class="quantity" value="<?php echo set_value('calculated_purchase_price_"+counter+"');?>" maxlength="15" size="20" /></td><td><input type="text" name="amt_manual_'+counter+'"  id="amt_manual_'+counter+'" class="quantity" value="<?php echo set_value('amt_manual_"+counter+"');?>" maxlength="15" size="20" /></td>--></tr>';

				//alert(mark_up);
				$("#table_article").append(mark_up);

				// RM CLosed-----
				//$("#product_name_"+counter).autocomplete("<?php echo base_url('index.php/ajax/mannual_issue_article_no');?>", {selectFirst: true});

				// RM Open-----
				$("#product_name_"+counter).autocomplete("<?php echo base_url('index.php/ajax/mannual_issue_article_no_open');?>", {selectFirst: true});

				





				// $("#product_name_"+counter).live('keyup',function(){

				// 	var arr=$("#product_name_"+counter).val().split("//");
					

				// 	if(arr.length>1){
				// 	 	var article_no=arr[1];									
				// 		$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/get_rm_for_issue');?>",data: {article_no : article_no},cache: 	false,
				// 			success: function(html){
				// 				//alert(html);
				// 				var arr=html.split("//");
				// 				$("#availabel_quantity_"+counter).val(arr[0]);
				// 				$("#calculated_purchase_price_"+counter).val(arr[1]);
				// 			},
				// 			beforeSend: function(){
				// 				$("#loading").show();
				// 				$("#cover").show();
				// 				$('#loading').html('<img src="images/loading.gif"> Loading...');	
								
				// 			},
				// 			complete: function(){
				// 				$("#loading").hide(); $("#cover").hide();				
								
				// 			}  
							
				// 		});
				// 	}
								
				// });


				// $("#issue_quantity_"+counter).blur(function(){
								
				// 	if($("#issue_quantity_"+counter).val()!='' && $("#issue_quantity_"+counter).val()!='0'){
							
				// 			//if(parseInt($("#issue_quantity_"+counter).val())<=parseInt($("#availabel_quantity_"+counter).val())){
				// 				var amount=	$("#issue_quantity_"+counter).val() * $("#calculated_purchase_price_"+counter).val();
				// 				amount=amount.toFixed(2);
				// 				$("#amt_manual_"+counter).val(amount);
				// 			//}
				// 			//else{
				// 				//$("#amt_manual_"+counter).val();
				// 				//alert('Please enter correct qty.');
				// 			//}
				// 	}
				// });



					
		});


		$("#remove").click(function(e){

				var header_row=1;
				var counter=$("#table_article tr").length;
				counter=counter-header_row;
				if(counter>1){
					if(confirm('Confirm delete!')){
						$("#tr_"+counter).remove();
					}
				}
				else{
					alert('No more textbox to remove');
				}
			
									
		});
		


	});
</script>



<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_mannual_issue');?>" method="POST">
	

	<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
	<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
	<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>	

		<h4 class="ui top attached header">
		   MANUAL MATERIAL ISSUE:
		   &nbsp; &nbsp; &nbsp; &nbsp;
		</h4>

	<br/>   
	<div class="middle_form_design">
		<div class="middle_form_inner_design">   

		    <div class="ui buttons">
						<input type="button" value="Remove" id="remove" class="ui button">
						<div class="or"></div>
						<input type="button" value="Add" id="add" class="ui positive button">
			</div>

			<br/><br/>		

			<table class="middle_form_table_design" id="table_article">
				<tr>
						<th>Sr No.</th>
						<th>Process</th>
						<th>Document No.</th>
						<th>Date</th>
						<th>Product</th>
						<!--<th>Available Quantity</th>-->
						<th>Issue Quantity</th>
						<!--<th>Rate</th>
						<th>Amount</th>-->
				</tr>

			<?php
			if($this->input->post('sr_no')){
				$total_quantity=0;
				for($i=1;$i<=count($this->input->post('sr_no[]'));$i++){?>

				<script>
					$(document).ready(function(){
					$("#loading").hide(); $("#cover").hide();

					// RM CLosed----
					//$("#product_name_<?php echo $i;?>").autocomplete("<?php echo base_url('index.php/ajax/mannual_issue_article_no');?>", {selectFirst: true});

					//RM OPEN-----
					$("#product_name_<?php echo $i;?>").autocomplete("<?php echo base_url('index.php/ajax/mannual_issue_article_no_open');?>", {selectFirst: true});

					});
				</script>
				<tr id="tr_<?php echo $i;?>">
					<td><input type="hidden" name="sr_no[]" value="<?php echo $i;?>"/><?php echo $i;?>
					</td>

					<td>
						<select name="process_<?php echo $i;?>" id="process_<?php echo $i;?>">
							<option value="0" <?php echo set_select('process_'.$i,0)?>>COEX</option>
							<option value="1" <?php echo set_select('process_'.$i,1)?>>SPRINGTUBE</option>
						</select>
					</td>

					<td>
					<input type="text" name="document_no_<?php echo $i;?>"  id="document_no_<?php echo $i;?>" class="quantity" value="<?php echo set_value('document_no_'.$i.'');?>" maxlength="50" size="20" />
				</td>
				<td>
					<input type="date" name="date_required_<?php echo $i;?>"  id="date_required_<?php echo $i;?>" class="quantity" value="<?php echo set_value('date_required_'.$i.'',date('Y-m-d'));?>" maxlength="10" size="20" />
				</td>
				<td>
					<input type="text" name="product_name_<?php echo $i;?>" id="product_name_<?php echo $i;?>"size="80"  value="<?php echo set_value('product_name_'.$i.'');?>" placeholder="Goods Information"/>
				</td>
			<!--	<td>
					<input type="text" name="availabel_quantity_<?php echo $i;?>"  id="availabel_quantity_<?php echo $i;?>" class="quantity" value="<?php echo set_value('availabel_quantity_'.$i.'');?>" maxlength="15" size="20" />
				</td>
			-->									
				<td>
					<input type="text" name="issue_quantity_<?php echo $i;?>"  id="issue_quantity_<?php echo $i;?>" class="quantity" value="<?php echo set_value('issue_quantity_'.$i.'');?>" maxlength="15" size="20" placeholder="Quantity" />
				</td>
			<!--	<td>
					<input type="text" name="calculated_purchase_price_<?php echo $i;?>"  id="calculated_purchase_price_<?php echo $i;?>" class="quantity" value="<?php echo set_value('calculated_purchase_price_'.$i.'');?>" maxlength="15" size="20" />
				</td>
				<td>
					<input type="text" name="amt_manual_<?php echo $i;?>"  id="amt_manual_<?php echo $i;?>" class="quantity" value="<?php echo set_value('amt_manual_'.$i.'');?>" maxlength="15" size="20" />
				</td>
			-->	
					
				</tr>

				<?php 
			$total_quantity+=$this->input->post('quantity_'.$i.'');
				}
			}else{?>
			<tr id="tr_1">
				<td>
					<input type="hidden" name="sr_no[]" value="1"/>1
				</td>
				<td>
					<select name="process_1" id="process_1">
						<option value="0" <?php echo set_select('process_1',0)?>>COEX</option>
						<option value="1" <?php echo set_select('process_1',1)?>>SPRINGTUBE</option>
					</select>
				</td>
				
				<td>
					<input type="text" name="document_no_1"  id="document_no_1" class="quantity" value="<?php echo set_value('document_no_1');?>" maxlength="50" size="20" />
				</td>
				<td>
					<input type="date" name="date_required_1"  id="date_required_1" class="quantity" value="<?php echo set_value('date_required_1',date('Y-m-d'));?>" maxlength="10" size="20" />
				</td>
				<td>
					<input type="text" name="product_name_1" id="product_name_1"size="80"  value="<?php echo set_value('product_name_1');?>" placeholder="Goods Information"/>
				</td>
			<!--	<td>
					<input type="text" name="availabel_quantity_1"  id="availabel_quantity_1" class="quantity" value="<?php echo set_value('availabel_quantity_1');?>" maxlength="15" size="20" />
				</td>
			-->								
				<td>
					<input type="text" name="issue_quantity_1"  id="issue_quantity_1" class="quantity" value="<?php echo set_value('issue_quantity_1');?>" maxlength="15" size="20" placeholder="Quantity" />
				</td>
			<!--<td>
					<input type="text" name="calculated_purchase_price_1"  id="calculated_purchase_price_1" class="quantity" value="<?php echo set_value('calculated_purchase_price_1');?>" maxlength="15" size="20" />
				</td>
				<td>
					<input type="text" name="amt_manual_1"  id="amt_manual_1" class="quantity" value="<?php echo set_value('amt_manual_1');?>" maxlength="15" size="20" />
				</td>
			-->
			</tr>
						
			<?php
			}
			?>
			

		</table>
	</div>
</div>	

	<div class="form_design">
		<div class="ui buttons">
					<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
					<div class="or"></div>
					<button class="ui positive button">Save</button>
		</div>
	</div>		

</form>

			
				
				
				
				
			