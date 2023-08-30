<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){

		$("#loading").hide(); $("#cover").hide();

		$("#order_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/spring_open_so_no');?>", {selectFirst: true});				


		$("#order_no").bind('keyup',function() {
			$("#loading").hide(); $("#cover").hide();
		   	var order_no = $('#order_no').val();
		   	var order_no_length=order_no.length;

	   		$("#article_no").html("<option value=''>---Please Select---</option>");
		   	$("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
		    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax_springtube/spsm_spsp_no",data: {order_no : $('#order_no').val()},cache: false,success: function(html){
		    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
		    		//alert(html);
		       $("#article_no").html(html);
		    	} 
		    });

   		});

   		$("#article_no").change(function() {
   			
   			$("#loading").hide(); $("#cover").hide();
   			$("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');		    
	   		var article_no = $(this).find(':selected').val();
	   		$("#bm_wip_qty").val('');
	   		$(".bodymaking_inspection").val('');
	   		$(".printing_inspection").val('');
	   		$("#total_rejected_bodymaking_issue").val('');
	   		$("#total_rejected_printing_issue").val('');
	   		$("#rfd").val('');
			$("#remaining_wip").val('');

	   		if(article_no!=''){

	   			//var selectedText = $(this).find(':selected').text();
		    	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax_springtube/spring_bodymaking_wip",data: {article_no : article_no,order_no : $('#order_no').val() },cache: false,success: function(html){
				    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				    		//alert(html);

				    	var wip=Number(html);
				    	var rfd=wip;
				    	var remaining_wip=Number(wip-rfd);	
				        $("#bm_wip_qty").val(wip);
				        $("#rfd").val(rfd);
						$("#remaining_wip").val(remaining_wip);
				    } 
				});

	   		}else{
	   			$("#loading").hide();$("#cover").hide()
	   			$("#bm_wip_qty").val('');
	   			$("#rfd").val('');
				$("#remaining_wip").val('');
	   		}
		    
		});

		// $("#jobcard_no").bind('blur',function() {			

		// 	$("#loading").hide(); $("#cover").hide();
		//     var jobcard_no = $('#jobcard_no').val();
		//     var jobcard_no_length=jobcard_no.length;
		//     //alert(jobcard_no_length);
		   		    
		//     if(jobcard_no_length==15){
		   		
		// 	    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax_springtube/get_order_details_for_extrusion_control_plan",
		// 	    	data: {jobcard_no : $('#jobcard_no').val()},
		// 	    	cache: false,
		// 	    	success: function(html){

		// 	    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);

		// 				var obj=JSON.parse(html);
		// 				//alert(obj.order_no);
		// 	    		//alert(obj.article_no);
		// 	    		$("#order_no").val(obj.order_no);
		// 	    		$("#article_no").val(obj.article_no);
		// 	    		$("#thickness_std").val(obj.total_microns);
		// 	    		$('input[name="reel_length_std"]').val(obj.reel_length);
		// 	    		$('input[name="first_layer_micron_std"]').val(obj.micron_1);
		// 	    		$('input[name="second_layer_micron_std"]').val(obj.micron_2);
		// 	    		$('input[name="third_layer_micron_std"]').val(obj.micron_3);
		// 	    		$('input[name="fourth_layer_micron_std"]').val(obj.micron_4);
		// 	    		$('input[name="fifth_layer_micron_std"]').val(obj.micron_5);
		// 	    		$('input[name="sixth_layer_micron_std"]').val(obj.micron_6);
		// 	    		$('input[name="seventh_layer_micron_std"]').val(obj.micron_7);
			    		
		// 	    		var Url="<?php echo base_url(); ?>" + "index.php/sales_order_item_parameterwise/view_new/" + jobcard_no +"/"+ obj.bom_no + "/" + obj.bom_version_no;
		// 	    		$("#jobcard_view").attr("href", Url);
		// 	    		$("#jobcard_view").html(jobcard_no);
			       	
		// 	       	} 
		// 	    });
			   
		//     }		   

  //  		});

  	//var total=0;

  	$(".bodymaking_inspection").bind('blur',function() {

  		var total=0;

  		$("#total_rejected_bodymaking_issue").val(0);

	  	$(".bodymaking_inspection").each(function() {
	    	var num=Number($(this).val());
	    	//alert(num);
	    	total+=num;
		});

		$("#total_rejected_bodymaking_issue").val(total);

		var bodymaking_wip=0;
		var total_bodymaking=total;
		var total_printing=0;
		var short_fall=0;
		var total_rfd=0;
		var remaning_wip=0;

		if($("#bm_wip_qty").val()!='' && Number($("#bm_wip_qty").val())>0){
			bodymaking_wip=Number($("#bm_wip_qty").val());
		}
		if($("#total_rejected_printing_issue").val()!='' && Number($("#total_rejected_printing_issue").val())>0 ){
			total_printing=Number($("#total_rejected_printing_issue").val());
		}
		if($("#short_fall").val()!='' && Number($("#short_fall").val())>0 ){
			short_fall=Number($("#short_fall").val());
		}

		//alert(bodymaking_wip);

		if(bodymaking_wip>0){

			var total_rejected=(total_bodymaking+total_printing+short_fall);
			total_rfd=bodymaking_wip-total_rejected;
			remaining_wip=bodymaking_wip-(total_rejected+total_rfd);

			$("#rfd").val(total_rfd);
			$("#remaining_wip").val(remaining_wip);

		}


	});

	$(".printing_inspection").bind('blur',function() {

  		var total=0;

  		$("#total_rejected_printing_issue").val(0);

	  	$(".printing_inspection").each(function() {
	    	var num=Number($(this).val());
	    	//alert(num);
	    	total+=num;
		});

		$("#total_rejected_printing_issue").val(total);

		var bodymaking_wip=0;
		var total_bodymaking=0;
		var total_printing=total;
		var short_fall=0;
		var total_rfd=0;
		var remaning_wip=0;

		if($("#bm_wip_qty").val()!='' && Number($("#bm_wip_qty").val())>0){
			bodymaking_wip=Number($("#bm_wip_qty").val());
		}
		if($("#total_rejected_bodymaking_issue").val()!='' && Number($("#total_rejected_bodymaking_issue").val())>0 ){
			total_bodymaking=Number($("#total_rejected_bodymaking_issue").val());
		}
		if($("#short_fall").val()!='' && Number($("#short_fall").val())>0 ){
			short_fall=Number($("#short_fall").val());
		}

		//alert(bodymaking_wip);

		if(bodymaking_wip>0){

			var total_rejected=(total_bodymaking+total_printing+short_fall);
			total_rfd=bodymaking_wip-total_rejected;
			remaining_wip=bodymaking_wip-(total_rejected+total_rfd);

			$("#rfd").val(total_rfd);
			$("#remaining_wip").val(remaining_wip);

		}

	});

	$("#short_fall").bind('blur',function() {

		var short_fall=0;
		var bodymaking_wip=0;
		var total_bodymaking=0;
		var total_printing=0;

		if($("#short_fall").val()!='' && Number($("#short_fall").val())>0){

			short_fall=Number($("#short_fall").val());

		}		

		if($("#bm_wip_qty").val()!='' && Number($("#bm_wip_qty").val())>0){
			bodymaking_wip=Number($("#bm_wip_qty").val());
		}

		if($("#total_rejected_bodymaking_issue").val()!='' && Number($("#total_rejected_bodymaking_issue").val())>0 ){
			total_bodymaking=Number($("#total_rejected_bodymaking_issue").val());
		}

		if($("#total_rejected_printing_issue").val()!='' && Number($("#total_rejected_printing_issue").val())>0 ){
			total_printing=Number($("#total_rejected_printing_issue").val());
		}


		if(bodymaking_wip>0){

			var total_rejected=(total_bodymaking+total_printing+short_fall);
			total_rfd=bodymaking_wip-total_rejected;
			remaining_wip=bodymaking_wip-(total_rejected+total_rfd);

			$("#rfd").val(total_rfd);
			$("#remaining_wip").val(remaining_wip);

		}

	});	


	$("#rfd").bind('blur',function() {
		var rfd=0;
		var short_fall=0;
		var bodymaking_wip=0;
		var total_bodymaking=0;
		var total_printing=0;

		if($("#rfd").val()!='' && Number($("#rfd").val())>0){

			rfd=Number($("#rfd").val());

		}	

		if($("#bm_wip_qty").val()!='' && Number($("#bm_wip_qty").val())>0){
			bodymaking_wip=Number($("#bm_wip_qty").val());
		}

		if($("#total_rejected_bodymaking_issue").val()!='' && Number($("#total_rejected_bodymaking_issue").val())>0 ){
			total_bodymaking=Number($("#total_rejected_bodymaking_issue").val());
		}

		if($("#total_rejected_printing_issue").val()!='' && Number($("#total_rejected_printing_issue").val())>0 ){
			total_printing=Number($("#total_rejected_printing_issue").val());
		}

		if($("#short_fall").val()!='' && Number($("#short_fall").val())>0){

			short_fall=Number($("#short_fall").val());

		}


		if(bodymaking_wip>0){

			var total_rejected=(total_bodymaking+total_printing+short_fall);
			remaining_wip=bodymaking_wip-(total_rejected+rfd);

			$("#remaining_wip").val(remaining_wip);

		}

	});	


	});//Jquery closed

</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">

						<tr>
							<td class="label">AQL Date <span style="color:red;">*</span> :</td>
							<td><input type="date" name="aql_date"   value="<?php echo set_value('aql_date',date('Y-m-d'));?>" readonly />
							</td>
							<td class="label">Order No.  <span style="color:red;">*</span> :</td>
							<td>
								<input type="text" name="order_no" id="order_no"  size="20" value="<?php echo set_value('order_no');?>" placeholder="Order no."/>
							</td>
							
						</tr>						
						<!-- <tr>	
							<td class="label">Order No. :</td>
							<td>
								<input type="text" name="order_no" id="order_no"  size="20" value="<?php echo set_value('order_no');?>" readonly placeholder="Order no."/>
							</td>							
						</tr> -->
						<!-- <tr>
							<td class="label">Article No. <span style="color:red;">*</span> :</td>
							<td>
								<select name="article_no" id="article_no" required >
									<option value="">----Select Article No.----</option>	
								</select>
							</td>
							<td class="label">Bodymaking WIP Qty <span style="color:red;">*</span></td>
							<td>
								<input type="text" name="bm_wip_qty" id="bm_wip_qty" size="20" value="<?php echo set_value('bm_wip_qty');?>" readonly placeholder="WIP Qty after Bodymaking."/>
							</td>

						</tr> -->
						<!-- <tr>	
							<td class="label">Bodymaking WIP Qty<span style="color:red;">*</span></td>
							<td>
								<input type="text" name="bm_wip_qty" id="bm_wip_qty" size="20" value="<?php echo set_value('bm_wip_qty');?>" readonly placeholder="WIP Qty after Bodymaking."/>
							</td>							
						</tr> -->
						<tr>
							<td class="label">Article No. <span style="color:red;">*</span> :</td>
							<td>
								<select name="article_no" id="article_no" required >
									<option value="">----Select Article No.----</option>	
								</select>
							</td>
							<td class="label">Bodymaking WIP Qty <span style="color:red;">*</span></td>
							<td>
								<input type="text" name="bm_wip_qty" id="bm_wip_qty" size="20" value="<?php echo set_value('bm_wip_qty');?>" readonly placeholder="WIP Qty after Bodymaking."/>
							</td>

						</tr>
						<tr>
							<td class="label" colspan="4"><b>BODYMAKING INSPECTION</b></td>
						</tr>
						<tr>
							<td class="label" colspan="3">Seam welding (in startup box) Decoseam one side <span style="color:red;">*</span> :
							</td>													
							<td><input class="bodymaking_inspection" type="number" name="seam_welding_stratup_box"  id="seam_welding_stratup_box" min="0" max="100000" step="any">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">Seam welding (in ok box) <span style="color:red;">*</span> :
							</td>					
							<td>
								<input class="bodymaking_inspection" type="number" name="seam_welding_ok_box"  id="seam_welding_ok_box" min="0" max="100000" step="any">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								Shoulder welding (in ok box) one side decoseam <span style="color:red;">*</span> :
							</td>														
							<td>
								<input  class="bodymaking_inspection" type="number" name="shoulder_welding_ok_box"  id="shoulder_welding_ok_box" min="0" max="100000" step="any">
							</td>
						</tr>						
						<tr>
							<td class="label" colspan="3">
								Ink flaking (ink wrinkles in seam) <span style="color:red;">*</span> :
							</td>													
							<td>
								<input class="bodymaking_inspection" type="number" name="ink_flaking"  id="ink_flaking" min="0" max="100000" step="any">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
							Cap oriantation alignment <span style="color:red;">*</span> :
							</td>
							<td>
								<input class="bodymaking_inspection" type="number" name="cap_oriantation_alignment"  id="cap_oriantation_alignment" min="0" max="100000" step="any">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								Wrong position tube cutting <span style="color:red;">*</span> :
							</td>
							<td>
								<input class="bodymaking_inspection" type="number" name="wrong_position_tube_cutting"  id="wrong_position_tube_cutting" min="0" max="100000" step="any">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								Scratch Lines <span style="color:red;">*</span> :
							</td>
							<td>
								<input class="bodymaking_inspection" type="number" name="scratch_line"  id="scratch_line" min="0" max="100000" step="any">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="4">&nbsp; 
							</td>					
							
						</tr>
						<tr>
							<td class="label" colspan="4">&nbsp; 
							</td>					
							
						</tr>
						<tr>
							<td class="label" colspan="4">&nbsp; 
							</td>					
							
						</tr>
						<tr>
							<td class="label" colspan="4">&nbsp; 
							</td>					
							
						</tr>
						<tr>
							<td class="label" colspan="3">+
							</td>
							<td>
								+
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								<b>Total Rejected Tubes due to Bodymakig issue <span style="color:red;">*</span> :</b>
							</td>
							<td>
								<input type="number" name="total_rejected_bodymaking_issue"  id="total_rejected_bodymaking_issue" min="0" max="1000000" step="any" value="<?php echo('total_rejected_bodymaking_issue');?>" readonly>
							</td>
						</tr>

						<tr>
							<td class="label" colspan="3">
								<b>Short Fall Qty <span style="color:red;">*</span> :</b>
							</td>
							<td>
								<input type="number" name="short_fall"  id="short_fall" min="0" max="1000000" step="any" value="<?php echo('short_fall');?>">
							</td>
						</tr>

						<tr>
							<td class="label" colspan="3">
								<b>Total RFD Qty<span style="color:red;">*</span> :</b>
							</td>
							<td>
								<input type="number" name="rfd"  id="rfd" min="0" max="1000000" step="any" value="<?php echo('rfd');?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								<b>Remaining WIP Qty <span style="color:red;">*</span> :</b>
							</td>
							<td>
								<input type="number" name="remaining_wip"  id="remaining_wip" min="0" max="1000000" step="any" value="<?php echo('remaining_wip');?>" readonly>
							</td>
						</tr>
						<!-- <tr>
							<td class="label">Remarks :</td>
							<td colspan="3">
								<textarea name="remarks" id="remarks" style="width:410px;height:80px;" value="<?php echo trim(set_value('remarks'));?>" maxlength="500"><?php echo trim(set_value('remarks'));?>	
								</textarea>
							</td>
						</tr> -->				
						

					</table>
			
				</td>
				<td>
					<table>	

						<!-- <tr>
							<td class="label">Article No. <span style="color:red;">*</span> :</td>
							<td>
								<select name="article_no" id="article_no" required >
									<option value="">----Select Article No.----</option>	
								</select>
							</td>
							<td class="label">Bodymaking WIP Qty <span style="color:red;">*</span></td>
							<td>
								<input type="text" name="bm_wip_qty" id="bm_wip_qty" size="20" value="<?php echo set_value('bm_wip_qty');?>" readonly placeholder="WIP Qty after Bodymaking."/>
							</td>

						</tr> -->
						<tr>
							<td class="label" colspan="4"><b>PRINTING INSPECTION</b></td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								Smudge Printing <span style="color:red;">*</span> :
							</td>
							<td>
								<input class="printing_inspection" type="number" name="smudge_printing"  id="smudge_printing" min="0" max="100000" step="any" value="<?php echo('smudge_printing');?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								Print / Foil miss registation <span style="color:red;">*</span> :
							</td>
							<td>
								<input class="printing_inspection" type="number" name="print_miss_registration"  id="print_miss_registration" min="0" max="100000" step="any" value="<?php echo('print_miss_registration');?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								Foil cut / Unsharp foil <span style="color:red;">*</span> :
							</td>
							<td>
								<input class="printing_inspection" type="number" name="foil_cut"  id="foil_cut" min="0" max="100000" step="any" value="<?php echo('foil_cut');?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								Stopage marks <span style="color:red;">*</span> :
							</td>
							<td>
								<input class="printing_inspection" type="number" name="stopage_marks"  id="stopage_marks" min="0" max="100000" step="any" value="<?php echo('stopage_marks');?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								Without Varnsih <span style="color:red;">*</span> :
							</td>
							<td>
								<input class="printing_inspection" type="number" name="without_varnish"  id="without_varnish" min="0" max="100000" step="any" value="<?php echo('without_varnish');?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								Wet varnish / motlling <span style="color:red;">*</span> :
							</td>
							<td>
								<input class="printing_inspection" type="number" name="wet_varnish"  id="wet_varnish" min="0" max="100000" step="any" value="<?php echo('wet_varnish');?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								Streaks / Nozzle lines <span style="color:red;">*</span> :
							</td>
							<td>
								<input class="printing_inspection" type="number" name="streaks_nozzle_lines"  id="streaks_nozzle_lines" min="0" max="100000" step="any" value="<?php echo('streaks_nozzle_lines');?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								Ghost Printing <span style="color:red;">*</span> :
							</td>
							<td>
								<input class="printing_inspection" type="number" name="ghost_printing"  id="ghost_printing" min="0" max="100000" step="any" value="<?php echo('ghost_printing');?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								Nozzle ink dots <span style="color:red;">*</span> :
							</td>
							<td>
								<input class="printing_inspection" type="number" name="nozzle_ink_dots"  id="nozzle_ink_dots" min="0" max="100000" step="any" value="<?php echo('nozzle_ink_dots');?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								Reel trimming issue <span style="color:red;">*</span> :
							</td>
							<td>
								<input class="printing_inspection" type="number" name="reel_trimming_issue"  id="reel_trimming_issue" min="0" max="100000" step="any" value="<?php echo('reel_trimming_issue');?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								Other print defects / Head touch / Printing dust / Nipple dust <span style="color:red;">*</span> :
							</td>
							<td>
								<input class="printing_inspection" type="number" name="other_print_defects"  id="other_print_defects" min="0" max="100000" step="any" value="<?php echo('other_print_defects');?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								+
							</td>
							<td>
								+
						</tr>
						<tr>
							<td class="label" colspan="3">
								<b>Total Rejected Tubes due to Printing issue <span style="color:red;">*</span> :</b>
							</td>
							<td>
								<input type="number" name="total_rejected_printing_issue"  id="total_rejected_printing_issue" min="0" max="1000000" step="any" value="<?php echo('total_rejected_printing_issue');?>" readonly>
							</td>
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




				
				
				
			