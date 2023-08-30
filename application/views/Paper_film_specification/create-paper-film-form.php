<script type="text/javascript">
$(document).ready(function() {
	$("#loading").hide();
	$("#cover").hide();

	$("#sub_group").change(function(event) {
   var main_group = $('#main_group').val();
   var sub_group = $('#sub_group').val();
  // alert(main_group);
   //alert(sub_group);
   $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/sub_group_article",data: {sub_group : $('#sub_group').val(),main_group : $('#main_group').val()},cache: false,success: function(html){
    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#article_no").html(html);
    } 
    });
   });


   /*$("#pf_width").change(function(event) {

		if($("#pf_thickness").val()!=''){ var pf_thickness=$("#pf_thickness").val()+"%";}else{var pf_thickness="";}

		if($("#layer_no option:selected").val()!=''){ var layer_no=$("#layer_no option:selected").text();}else{var layer_no="";}
            
		if($("#pf_width").val()!=''){ var pf_width=$("#pf_width").val()+"%";}else{var pf_width="";}
   
        if(pf_width!=''){

			$("#article_name").html("<span class='ui teal label'>"+pf_thickness+"</span>+<span class='ui teal label'>"+layer_no+"</span>+<span class='ui teal label'>"+pf_width+"</span>");
		}else{
			$("#article_name").html('');
		}

    });*/
		

});
</script>


<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_paper_film');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">
                  <tr>
							<input type="hidden" id="main_group" value="1">
							<td class="label">Main Group <span style="color:red;">*</span> :</td>
							<td><select name="sub_group" id="sub_group" style="width: 100%;"><option value=''>--Select Group--</option>
								<option value='340'>PE PAPER</option>
							</select></td>
						</tr>

						<tr>
							<td class="label">Paper Film No <span style="color:red;">*</span> :</td>
							<td><select name="article_no" id="article_no"  style="width: 100%;">
							<option value="">--Select Article Code--</option>
											
							</select></td>
						</tr>

						<tr>
							<td class="label">Paper Film Name (Sales)<span style="color:red;">*</span> :</td>
							<td><input type="text" name="pf_sales" id="pf_sales" value="<?php echo set_value('pf_sales');?>" ></td>
						</tr>

						<tr>
							<td class="label">Paper Film Name (Purchase)<span style="color:red;">*</span> :</td>
							<td><input type="text" name="pf_purchase" id="pf_purchase" value="<?php echo set_value('pf_purchase');?>" ></td>
						</tr> 
									
						<tr>
							<td class="label">Dia <span style="color:red;">*</span> :</td>
							<td><select name="sleeve_dia" id="sleeve_dia" required style="width: 100%;"><option value=''>--Select Dia--</option>
							<?php if($sleeve_dia==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($sleeve_dia as $sleeve_dia_row){
										echo "<option value='".$sleeve_dia_row->sleeve_diameter."'  ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_diameter.'').">".$sleeve_dia_row->sleeve_diameter."</option>";
									}
							}?></td>
						</tr>

						<tr>
							<td class="label">Total Thickness<span style="color:red;">*</span> :</td>
							<td><input type="text" name="pf_thickness" id="pf_thickness" value="<?php echo set_value('pf_thickness');?>" ></td>
						</tr>

						<tr>
							<td class="label">Layer <span style="color:red;">*</span> :</td>
							<td><select name="layer_no" id="layer_no" style="width: 100%;"><option value=''>--Select Layer--</option>
							<option value='1'>1 Layer</option>
							<option value='2'>2 Layer</option>
							<option value='3'>3 Layer</option>
							<option value='4'>4 Layer</option>
							<option value='5'>5 Layer</option>
							<option value='6'>6 Layer</option>
							<option value='7'>7 Layer</option>
							</select></td>
						</tr>

						<tr>
							<td class="label">Width<span style="color:red;">*</span> :</td>
							<td><input type="text" name="pf_width" id="pf_width" value="<?php echo set_value('pf_width');?>" ></td>
						</tr>
									
						
									
									
						<!-- <tr>
							<td class="label">Paper Film Name (Sales)<span style="color:red;">*</span> :</td>
							<td><input type="text" name="pf_sales" id="pf_sales" value="<?php echo set_value('pf_sales');?>" ></td>
						</tr> -->

						<tr>
						   <td class="label">Approval Authority <span style="color:red;">*</span>:</td>
							<td><select name="approval_authority">
							<option value=''>--Select Authority--</option>
							<?php 
							foreach ($approval_authority as $approval_authority_row) {
			             echo "<option value='".$approval_authority_row->employee_id."' ".set_select('approval_authority',$approval_authority_row->employee_id).">".strtoupper($approval_authority_row->username)."</option>";
			             }
			             ?>
			            </select></td>
			         </tr>

					</table>
				</td>
					<td>
						<table>
							<tr>
								<!-- <td class="label">Paper Film Name * :</td>
								<td><span id="article_name" style="color:green;font-weight: bold">
									<?php
										if(!empty($this->input->post('sleeve_dia'))){
					                  $sleeve_diaa=explode('//',$this->input->post('sleeve_dia'));
					                     echo "<span class='ui teal label'>$sleeve_diaa[0]</span>";
						               }else{
						                  $sleeve_diaa[0]='';
						               }

							            if(!empty($this->input->post('pf_thickness'))){
									         $total_thicknesss=explode('//',$this->input->post('shoulder'));
									            echo "+<span class='ui teal label'>$total_thicknesss[0]</span>";
									         }else{
									            $total_thicknesss[0]='';
									         }


									?>
								</span></td>	 -->
										
							</tr>
						</table>
					</td>
			</tr>
		</table>
	</div>

	<div class="form_design">
		<div class="ui buttons">
	  <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  <div class="or"></div>
	  <button class="ui positive button">Save</button>
		</div>
	</div>
		
</form>
				
				
				
				
				
			