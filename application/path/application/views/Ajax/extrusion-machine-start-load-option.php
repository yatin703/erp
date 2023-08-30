<script>
	var counter=1;
	$(document).ready(function(){

		$("#refresh").live('click',function() {
			
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/machine_start');?>",data: {machine:$("#machine").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#machine_start_load_details").html(html);
				} 
			});
		});
		
		$("#machine_stop").live('click',function() {
			
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			if($("#coex_extrusion_machine_stop_reasons").val()!=""){
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/machine_stop_entry');?>",data: {machine:$("#machine").val(),
				coex_extrusion_machine_stop_reasons:$("#coex_extrusion_machine_stop_reasons").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#machine_start_load_details").html(html);

				} 
			});
			}else{
				alert('Select Machine Stop Reason');
				$("#loading").hide();$("#cover").hide();
			}


			if(counter==1){$("#machine_stop").off();}counter++;
		});



	});//Jquery closed

</script>

<?php 
 	if($machine_start==FALSE){
      		echo '<span class="ui green button" id="machine_start">
      				Machine Start
      			  </span>
      			  <select name="coex_extrusion_machine_start_reasons" id="coex_extrusion_machine_start_reasons" required><option value="">--Reason--</option>';
						if($coex_extrusion_machine_start_reasons==FALSE){
							echo '<option value="">--Setup Required--</option>';
						}
						else{
							foreach($coex_extrusion_machine_start_reasons as $coex_extrusion_machine_start_reasons_row){
								echo "<option value='".$coex_extrusion_machine_start_reasons_row->cemssr_id."'  ".set_select('coex_extrusion_machine_start_reasons',''.$coex_extrusion_machine_start_reasons_row->cemssr_id.'').">".$coex_extrusion_machine_start_reasons_row->coex_machine_start_stop_reasons."</option>";
							}
						}
			echo '</select>';
        }else{
        	foreach($machine_start as $machine_start_row){

        		if($machine_start_row->machine_start_stop_flag==1){
        			echo '<div class="ui mini labeled button" tabindex="0">
						  <div class="ui mini button">Machine Started On</div>
						  <a class="ui basic label">
						    '.date('d-M-Y',$machine_start_row->machine_start_stop_timestamp).'
						  </a>

						  <a class="ui basic label">
						    '.date('h:i:s A',$machine_start_row->machine_start_stop_timestamp).'
						  </a>
						 </div>
						 <br/>
						 <br/>
						<div class="ui mini labeled button" tabindex="0">
							<div class="ui mini button">Machine Running Since</div>
							  <a class="ui basic timr label" id="timer">
							  '.$this->common_model->time_diffrence($machine_start_row->machine_start_stop_time,date('Y-m-d H:i:s')).'
							  </a>
						</div>

						<div class="ui mini icon button" id="refresh">
						  <i class="history icon"></i>
						</div>

						<select name="coex_extrusion_machine_stop_reasons" id="coex_extrusion_machine_stop_reasons"><option value="">--Reason--</option>';
						if($coex_extrusion_machine_stop_reasons==FALSE){
							echo '<option value="">--Setup Required--</option>';
						}
						else{
							foreach($coex_extrusion_machine_stop_reasons as $coex_extrusion_machine_stop_reasons_row){
								echo "<option value='".$coex_extrusion_machine_stop_reasons_row->cemssr_id."'  ".set_select('coex_extrusion_machine_stop_reasons',''.$coex_extrusion_machine_stop_reasons_row->cemssr_id.'').">".$coex_extrusion_machine_stop_reasons_row->coex_machine_start_stop_reasons."</option>";
							}
						}
						echo '</select>
						<br/><br/>
					<span class="ui red button" id="machine_stop">
						Machine Stop
					</span>';
        		}else{
        			echo '<span class="ui green button" id="machine_start">
      						Machine Start
      					</span>
      					<select name="coex_extrusion_machine_start_reasons" id="coex_extrusion_machine_start_reasons" required><option value="">--Reason--</option>';
						if($coex_extrusion_machine_start_reasons==FALSE){
							echo '<option value="">--Setup Required--</option>';
						}
						else{
							foreach($coex_extrusion_machine_start_reasons as $coex_extrusion_machine_start_reasons_row){
								echo "<option value='".$coex_extrusion_machine_start_reasons_row->cemssr_id."'  ".set_select('coex_extrusion_machine_start_reasons',''.$coex_extrusion_machine_start_reasons_row->cemssr_id.'').">".$coex_extrusion_machine_start_reasons_row->coex_machine_start_stop_reasons."</option>";
							}
						}
						echo '</select>';
        		}

        	}
        	
        }     
    

?>