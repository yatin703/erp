<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		
		$("#loading").hide();$("#cover").hide();

		$('#btn_start_job').attr('disabled',true);
		//$('#btn_save_counter').attr('disabled',true);
		$('#btn_save_entry').attr('disabled',false);


		$("#jobcard_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_printing_production_done_autocomplete');?>", {selectFirst: true});	
				
		$("#jobcard_no").bind('keyup blur',function() {

			var jobcard_no = $('#jobcard_no').val();
			//alert(jobcard_no);
			if(jobcard_no.length>=15){

				if(!$("#jobcard_no").attr('readonly')){
			   	
				   $.ajax({

					   	type: "POST",
					   	url: "<?php echo base_url('index.php/ajax_springtube/get_order_details_for_printing');?>",
					   	data: {jobcard_no : $('#jobcard_no').val()},
					   	cache: false,
					   	success: function(html){
					    		$("#loading").hide();$("#cover").hide();
					    		if(html!=''){
					    			$("#order_details").html(html);
					       			$('#btn_start_job').attr('disabled',false);
					       			$('#jobcard_no').attr('readonly',true);
					    		}else{
					    			$("#order_details").html('');
					       			$('#btn_start_job').attr('disabled',true);
					       			$('#jobcard_no').attr('readonly',false);

					    		}				       		
			 
					    },
						beforeSend: function(){
										$("#loading").show();
										$("#cover").show();
										$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');	
										
						},
						complete: function(){
						 				$("#loading").hide(); $("#cover").hide();
										
										
						} 
				    });//AJAX Closed
				}   

		   }else{

		   		$("#order_details").html('');
		   		$('#btn_start_job').attr('disabled',true);
		   }

   		});

   		$("#btn_start_job").click(function(e){
   			//e.preventDefault();

   			if($("#shift").val()==""){
				alert('Select the Shift');
				$("#shift").focus();
				return false;
			}
			if($("#machine").val()==""){
				alert('Select the Machine');
				$("#machine_id").focus();
				return false;
			}
			if($("#job_type").val()==""){
				alert('Select the Job Type');
				$("#job_type").focus();
				return false;
			}
			if($("#job_category").val()==""){
				alert('Select the Job Category');
				$("#job_category").focus();
				return false;
			}
			if($("#job_speed").val()==""){
				alert('Enter the Job Speed');
				$("#job_speed").focus();
				return false;
			}			
			if($("#jobcard_no").val()==""){
				alert('Select the Jobcard No.');
				$("#jobcard_no").focus();
				return false;
			}


			$.ajax({


			   	type: "POST",
			   	url: "<?php echo base_url('index.php/'.$this->router->fetch_class().'/start_job');?>",
			   	data: {jobcard_no : $('#jobcard_no').val(), production_date : $("#production_date").val(), shift : $("#shift").val(), machine : $("#machine").val(), job_type : $("#job_type").val(), job_category : $("#job_category").val(), job_speed : $("#job_speed").val() },
			   	cache: false,
			   	dataType: 'json',
			   	success: function(data){
			    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
			    		
			       		if(data.status){
			       			alert(data.message);
			       			$("#production_id").val(data.production_id);

			       			$('#jobcard_no').attr('readonly','readonly');
			       			$('#shift').attr('disabled',true);
			       			$('#machine').attr('disabled',true);
			       			$('#job_type').attr('disabled',true);
			       			$('#job_category').attr('disabled',true);
			       			$('#job_speed').attr('disabled',true);

			       			$('#btn_start_job').attr('disabled',true);
							$('#btn_save_counter').attr('disabled',false);
							//$('#btn_shift_break').attr('disabled',false);
							//$('#btn_end_job').attr('disabled',true);
							$('#btn_save_entry').attr('disabled',false);

			       		}else{
			       			alert(data.message);
			       		}
			       		

			    },
				beforeSend: function(){
								$("#loading").show();
								$("#cover").show();
								$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');	
								
				},
				complete: function(){
				 	$("#loading").hide(); $("#cover").hide();
								
								
				},
				error: function() {
          			alert('Something is wrong');
       			}
			});//AJAX Closed			
			return false;			

         });

  		
   		var i=<?php echo count($springtube_printing_production_details);?>;

   		//var counter_sum=parseInt($("#counter_sum").val());

   		

   		$("#btn_save_counter").click(function(e){
   			//e.preventDefault();
   			// alert($("#production_id").val());
   			// alert($("#counter").val());
   			// alert($("#stop_reason").val());
   			//alert('save');

   			if($("#counter").val()=="" || $("#counter").val()=="0" ){
				alert('Please enter counter');
				$("#shift").focus();
				return false;
			}
			if($("#stop_reason").val()==""){
				alert('Please enter the machine stop reason');
				$("#stop_reason").focus();
				return false;
			}
			if(parseInt($("#counter").val()) > parseInt($("#pending_counter").text())){
				alert('Counter must be less than equal to Pending Counter');
				return false;
			}

			// if($("#production_id").val()=="" || $("#production_id").val()=="0"){
			// 	alert('Some thing went wrong!');
				
			// 	return false;
			// }

			$.ajax({

			   	type: "POST",
			   	url: "<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_counter');?>",
			   	data: { production_id : $("#production_id").val(),jobcard_no : $('#jobcard_no').val(), counter : $("#counter").val(), stop_reason : $("#stop_reason").val()},
			   	cache: false,
			   	dataType: 'json',
			   	success: function(data){
			    		$("#loading").hide();$("#cover").hide();

			    		//alert(data);
			    		
			       		if(data.status){      			

			       			//alert('Counter saved successfully');
			       			//counter_sum+=parseInt($("#counter").val());

			       			$("#pending_counter").html(data.pending_counter);
			       			$("#printed_counter").html(data.total_counter);
			       			$("#table_counter_1").empty();
			       			$("#table_counter_1").append('<tr><th width="1%">#</th><th width="11%">Counter</th><th width="77%">Counter Stop Reason</th><th>Time</th></tr>');


			       			var obj=data.details_data;
			       			var j=1;
			       			for(var k=0;k<obj.length;k++){

			       				//alert(obj[k].details_id);	

			       				var str=obj[k].time_stamp;
			       				var time = str.substring(str.length- 8, str.length);	       				

			       				//var tr='<tr><td>'+j+'</td><td>'+obj[i].counter+'</td><td>'+obj[i].stop_reason+'</td><td><a onclick="window.open('+"'"+url+"','Springtube Printing Counter Update','width=200,height=100' "+')" target="_blank" title="Modify"><i class="edit icon"></i></a>&nbsp;<a onclick="window.open('+"'"+url+"','Springtube Printing Counter Delete','width=200,height=100' "+')" target="_blank" title="Delete"><i class="trash icon"></i></a></td></tr>';

			       				var tr='<tr><td>'+j+'</td><td>'+obj[k].counter+'</td><td>'+obj[k].stop_reason+'</td><td>'+time+'</td></tr>';

			       				//alert(tr);

			       				$("#table_counter_1").append(tr);
			       				j++;
			       				
			       			}
			       			$("#counter").val('');
			       			$("#stop_reason").val('');

			       			alert(data.message);
			       			i++;


			       		}else{
			       			alert(data.message);
			       		}
			       		

			    },
				beforeSend: function(){
								$("#loading").show();
								$("#cover").show();
								$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');	
								
				},
				complete: function(){
				 	$("#loading").hide(); $("#cover").hide();
								
								
				},
				error: function() {
          			alert('Something is wrong');
       			}
			});//AJAX Closed
			
			return false;			

         });


   		$("#btn_save_entry").click(function(e){

   			if(confirm('Are you sure to save entry?')){
   				if($("#shift_issues").val()==''){
   					alert('Select Job end reason');
   					$("#shift_issues").focus();
   					return false;
	   			}
	   			if($("#shift_issues").val()!='14' && $("#remarks").val()==''){
	   			 	alert('Enter the Remarks');
	   				$("#remarks").focus();
	   			 	return false;

	   			}
   				return true;
   			}else{
   				return false;

   			}   			
   			
   		});
   	 	


	});//Jquery closed

</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/end_job');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		

		<?php foreach($springtube_printing_production_master as $row): ?>

		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">									
						<tr>
							<td class="label">Production Date <span style="color:red;">*</span> :</td>
							<td><input type="date" name="production_date" id="production_date"  value="<?php echo set_value('production_date',$row->production_date)?>" readonly />
							</td>
							<td class="label">Shift<span style="color:red;">*</span> :</td>
							<td>
								<select name="shift" id="shift" disabled>

									<option value=''>-----Select Shift-----</option>
									<option value='1' <?php echo($row->shift==1? 'selected':'')?>  <?php set_select('shift');?>>1</option>
									<option value='2' <?php echo($row->shift==2? 'selected':'')?> <?php set_select('shift');?>>2</option>
									<option value='3' <?php echo($row->shift==3? 'selected':'')?> <?php set_select('shift');?>>3</option>
								</select>
							</td> 
							
						</tr>
						<tr>
							<td class="label">Jobcard No: <span style="color:red;">*</span> :</td>
							<td><input type="text" name="jobcard_no" id="jobcard_no"  value="<?php echo set_value('jobcard_no',$row->jobcard_no);?>" maxlength="20" size="20" readonly/></td>
						</tr>
						
						
					</table>			
				</td>
				<td>
					<table>
						<tr>
							<td class="label">Machine <span style="color:red;">*</span> :</td>
							<td><select name="machine" id="machine" disabled ><option value=''>----Select Machine-----</option>
							<?php if($springtube_machine_master==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($springtube_machine_master as $machine_row){
										$selected=($machine_row->machine_id==2?'selected':'');
										echo "<option value='".$machine_row->machine_id."'  ".set_select('machine',''.$machine_row->machine_id.'').$selected.">".$machine_row->machine_name."</option>";
									}
							}?>
							</select></td>
							<td class="label">Job Type: <span style="color:red;">*</span> :</td>
							<td><select name="job_type" id="job_type" disabled><option value=''>----Select Job Type-----</option>
							<?php if($springtube_printing_jobtype_master==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{

									foreach($springtube_printing_jobtype_master as $job_type_row){

										$selected=($row->job_type==$job_type_row->id?'selected':'');
										
										echo "<option value='".$job_type_row->id."'  ".set_select('job_type',''.$job_type_row->job_type.'').$selected.">".$job_type_row->job_type."</option>";
									}
							}?>
							</select></td>
						</tr>
						<tr>							
							<td class="label">Job Category <span style="color:red;">*</span> :</td>
							<td>
								<select name="job_category" id="job_category" disabled>
									<option value=''>--Select Job Category--</option>
									<option value='1' <?php echo($row->job_category==1? 'selected':'')?>  <?php set_select('job_category');?>>NEW JOB</option>
									<option value='2' <?php echo($row->job_category==2? 'selected':'')?> <?php set_select('job_category');?>>REPEAT JOB</option>
									
								</select>
							</td>
							<td class="label">Job Speed <span style="color:red;">*</span> :</td>
							<td>
								<input type="number" id="job_speed" name="job_speed" min="20" max="60" step="1" value="<?php echo set_value('job_speed',$row->job_speed);?>" required readonly>  
							</td>  
						</tr>
													

					</table>
				</td>							
			</tr>
			<tr>
				<td colspan="2"><div id="order_details">
				<?php
					$total_counter='';
		            $pending_counter='';
		            $jobcard_qty='';

					$jobcard_no=$row->jobcard_no;

				    if($jobcard_no!=''){

				      $this->load->model('job_card_model');

				      $jobcard_qty=0;
				      $order_no='';
				      $article_no='';
				      $ad_id='';
				      $version_no='';
				      $dia='';
				      $length='';
				      $print_type='';
				      $laminate_color='';
				      $total_order_quantity='';

				      $printed_counter=0;


				      $data['production_master']=$this->job_card_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$jobcard_no);
				        //echo $this->db->last_query();
				      if($data['production_master']){

				        foreach ($data['production_master'] as $production_master_row) {
				          
				          $jobcard_qty=$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
				          $order_no=$production_master_row->sales_ord_no;
				          $article_no=$production_master_row->article_no;

				        }

				        $order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);
				        foreach($order_master_result as $order_master_row){
				          $customer=$order_master_row->customer_no;                      
				        }

				        $data_order_details=array('order_no'=>$order_no,'article_no'=>$article_no);

				        $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
				        foreach($order_details_result as $order_details_row){
				          $total_order_quantity=$order_details_row->total_order_quantity;
				          $ad_id=$order_details_row->ad_id;
				          $version_no=$order_details_row->version_no;
				          $bom_no=$order_details_row->spec_id;
				          $bom_version_no=$order_details_row->spec_version_no;
				        }
				        //Artwork Deatils-------------------------
				        $data=array('ad_id'=>$ad_id,
				            'version_no'=>$version_no
				              );
				        $springtube_artwork_result=$this->artwork_springtube_model->active_record_search_new('springtube_artwork_devel_master',$data,'','','',$this->session->userdata['logged_in']['company_id']);

				        foreach ($springtube_artwork_result as $springtube_artwork_row) {
				          $body_making_type=$springtube_artwork_row->body_making_type;
				          $print_type=$springtube_artwork_row->print_type;
				          $dia=$springtube_artwork_row->sleeve_dia;
				          $length=$springtube_artwork_row->sleeve_length;
				          $laminate_color=$springtube_artwork_row->laminate_color;
				        }

				        // Pending counter logic-------------------

				        

                  		$data_total_counter=array(                  
                  		'jobcard_no'=>$row->jobcard_no                      
                  		);

                    	$result_total_counter=$this->springtube_printing_production_model->select_total_counter('springtube_printing_production_master',$data_total_counter);

                    	

	                    foreach ($result_total_counter as  $total_counter_row) {
	                      $printed_counter=$total_counter_row->total_counter;
	                    }

                    	$pending_counter=round($jobcard_qty/2)-$printed_counter;


				                        
				    	echo'<table class="record_table_design_without_fixed">
				        <tr>
				            <th>Customer</th>
				            <th>Order No.</th>
				            <th>Article No.</th>
				            <th>Article Name</th>
				            <th>Dia</th>
				            <th>Length</th>
				            <th>Print Type</th>
				            <th>Substrate</th> 
				            <th>Artwork</th>
				            <th>Order Qty</th>
				            <th>Jobcard Qty</th>
				            <th>Jobcard Counter</th>
				            <th>Pending Counter</th>
				            <th>Printed Counter</th>				                         
				                
				        </tr>  
				        <tr>
			                <td>'.$this->common_model->get_customer_name($customer,$this->session->userdata['logged_in']['company_id']).'</td>
			                <td>'.$order_no.'</td>
			                <td>'.$article_no.'</td>
			                <td>'.$this->common_model->get_article_name($article_no,$this->session->userdata['logged_in']['company_id']).'</td>
			                <td>'.$dia.'</td>
			                <td>'.$length.' + 2.5 = '.($length+2.5).' MM</td>
			                <td>'.$print_type.'</td>
			                <td>'.$laminate_color.'</td>
			                <td><a href="'.base_url('index.php/Artwork_springtube/view/'.$ad_id.'/'.$version_no).'" target="_blank">'.$ad_id.'@@'.$version_no.'</a></td>
			                <td>'.$this->common_model->read_number($total_order_quantity,$this->session->userdata['logged_in']['company_id']).'</td>
			                <td>'.$jobcard_qty.'</td>
			                <td>'.round($jobcard_qty/2).'</td>
			                <td><div id="pending_counter" style="color:blue;"><b>'.$pending_counter.'</b></div></td>
			                <td><div id="printed_counter" style="color:blue;"><b>'.$printed_counter.'</b></div</td>
				                
				        </tr>
				    	</table>';


				      	}


				    }?>
				    	
				    </div>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<div class="ui buttons">	  		
			  			<button class="ui positive button" id="btn_start_job">Start Job</button>
					</div>
				</td>
			</tr>
		</table>

	<?php endforeach;?>					
	</div>
	

	<div class="middle_form_design">
		<div class="middle_form_inner_design">			
			<table class="middle_form_table_design" id="table_counter">
				<tr>
					<th>#</th>					
					<th>Counter</th>									
					<th>Counter Stop Reason</th>
					<th>Save Counter</th>					
				</tr>

				<tr>
					<td></td>										
					<td><input type="hidden" name="production_id" id="production_id" value="<?php echo set_value('production_id',$row->production_id);?>"/>
						<input type="number" name="counter"  id="counter" class="quantity" value="<?php echo set_value('counter','0');?>" maxlength="10" size="20"  />
					</td>
					<td>
						<textarea name="stop_reason" id="stop_reason" value="<?php echo set_value('stop_reason');?>" cols="175" rows='3'  maxlength="200" style="margin: 0px; height: 50px; width: 900px;"></textarea>
					</td>
					<td>
						<div class="ui buttons">
					  		<button class="ui orange button" id="btn_save_counter">Save Counter</button>
						</div>
						
					</td>		

				</tr>
			</table>
			<table class="middle_form_table_design" id="table_counter_1" width="100%">
				<tr>
					<th width="1%">#</th>					
					<th width="11%">Counter</th>									
					<th width="77%">Counter Stop Reason</th>
					<th width="11%">Time</th>				
					
				</tr>
				<?php
					$j=1;
					foreach($springtube_printing_production_details as $details_row){

						echo'<tr><td>'.$j++.'</td><td>'.$details_row->counter.'</td><td>'.$details_row->stop_reason.'</td><td>'.substr($details_row->time_stamp,-8).'</td></tr>';

					}

				?>
			</table>
			<!-- <input type="text" name="counter_sum" id="counter_sum" class="quantity" value="<?php echo $total_counter?>" size="17" readonly/> -->	
		</div>
	</div>
<br/><br/>
	<div class="form_design">
		<table class="form_table_design">
			<tr>
				<td width="30%">
					<table class="form_table_inner">
						<tr>
							<td class="label">Job End Reason: <span style="color:red;">*</span> :</td>
								<td><select name="shift_issues" id="shift_issues" ><option value="">----Select Job End Reason-----</option>
								<?php if($springtube_shift_issues_master==FALSE){
												echo '<option value="">--Setup Required--</option>';}
									else{
										foreach($springtube_shift_issues_master as $springtube_shift_issues_row){

											$selected=($row->shift_issues==$springtube_shift_issues_row->shift_issue_id?'selected':'');
											
											echo "<option value='".$springtube_shift_issues_row->shift_issue_id."'  ".set_select('shift_issues',''.$springtube_shift_issues_row->shift_issue_id.'').$selected.">".$springtube_shift_issues_row->shift_issue."</option>";
										}
								}?>
								</select>
							</td>
						</tr>	
					</table>
				</td>
				<td width="35%">
					<table class="form_table_inner">
						<tr>
							<td class="label">Extrusion Scrap MTRS (Due to Bad Reel): <span style="color:red;">*</span> :</td>
							<td>
								<input type="number" name="extrusion_scrap" min="0" maxlength="5" step="any" size="20" value="<?php echo set_value('extrusion_scrap',$row->extrusion_scrap);?>">
							</td>
						</tr>	
					</table>
				</td>

				<td width="30">
					<table>
						<tr>
							<td class="label">Remarks :</td>
							<td><textarea name="remarks" id="remarks" maxlength="300" style="margin: 0px; height: 50px; width: 300px;" value="<?php echo set_value('remarks',$row->remarks);?>"><?php echo set_value('remarks',$row->remarks);?></textarea></td>
							
						</tr>	

					</table>
				</td>

			</tr>
			<tr>
				<td colspan="3">
					<div class="ui buttons">	  		
				  		<button class="ui positive button" name="btn_save_entry" id="btn_save_entry">End Job</button>
					</div>
				</td>
		</tr>
		</table>
	</div>				
	

	

	
</form>




				
				
				
			