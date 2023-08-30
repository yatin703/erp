<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();

		$("#order_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/spring_so_no');?>", {selectFirst: true});

		$("#order_no").bind('keyup blur',function() {
			$("#loading").hide(); $("#cover").hide();
		   var order_no = $('#order_no').val();
		   var order_no_length=order_no.length;
		   //alert();
		   if(order_no_length>=13){

		   		//$("#article_no").html("<option value=''>--Select Article--</option>");
			   	$("#loading").show();
				$("#cover").show();
				$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax_springtube/spsm_spsp_no",data: {order_no : $('#order_no').val()},cache: false,success: function(html){
			    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
			    		//alert(html);
			        $("#article_no").html(html);
			    	} 
			    });
			   
		   }
		   

   		});

	});

</script>


<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result_spring_track_order');?>" id="form1" method="POST" >

	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">
						<tr><td class="label">Order No.:</td>
							<td><input type="text" name="order_no" id="order_no"  size="20" value="<?php echo set_value('order_no');?>" placeholder="Order No"/>
							</td>
							<td class="label">Article No.:</td>
							<td><select name="article_no" id="article_no"><option>--Select Article--</option>								
							</select></td>	
						</tr>
						<!-- <tr>
							<td class="label">Article No.:</td>
							<td><select name="article_no" id="article_no"><option>--Select Article--</option>								
							</select></td>
						</tr>								
						 -->
						
									
									 
					</table>	
				</td>							
			</tr>
		</table>					
	</div>

	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button" onClick="return validate_form(); ">Search</button>
		</div>
	</div>
	

</form>


		

		
				
				
				
			