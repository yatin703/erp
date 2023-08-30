<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){

		$("#loading").hide(); $("#cover").hide();

		//$("#jobcard_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_bodymaking_autocomplete');?>", {selectFirst: true});

		$("#inspection_qty").attr("max",$("#bm_wip_qty").val());
		$("#counter_sample_qty").attr("max",$("#bm_wip_qty").val());				

		 
  		$(".bodymaking_inspection").bind('blur keyup',function() {

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
			var inspection_qty=0;
			var total_rfd_qty=0;
			var remaning_wip=0;
			var counter_sample_qty=0;

			if($("#bm_wip_qty").val()!='' && Number($("#bm_wip_qty").val())>0){
				bodymaking_wip=Number($("#bm_wip_qty").val());
			}
			if($("#total_rejected_printing_issue").val()!='' && Number($("#total_rejected_printing_issue").val())>0 ){
				total_printing=Number($("#total_rejected_printing_issue").val());
			}
			if($("#inspection_qty").val()!='' && Number($("#inspection_qty").val())>0 ){
				inspection_qty=Number($("#inspection_qty").val());
			}
			if($("#counter_sample_qty").val()!='' && Number($("#counter_sample_qty").val())>0 ){
				counter_sample_qty=Number($("#counter_sample_qty").val());
			}

			if(bodymaking_wip>0){
				var total_rejected=(total_bodymaking+total_printing);
				total_rfd_qty=inspection_qty-total_rejected-counter_sample_qty;				
				$("#total_rejected_qty").val(total_rejected);
				$("#rfd_qty").val(total_rfd_qty);

				// Ajax for rejected-------------------------
				$.ajax({type: "POST",
					url: "<?php echo base_url(); ?>" + "index.php/ajax_springtube/spring_aql_input_boxes",
					data: {jobcard_no : $('#jobcard_no').val(), qty : $("#total_rejected_qty").val() },
					cache: false,
					success: function(html){
					    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
					    		
					    var obj=JSON.parse(html);						
						$("#total_rejected_qty_boxes").html(obj.boxes);
							
					} 
				});	

				// Ajax for RFD----------------------

				$.ajax({type: "POST",
					url: "<?php echo base_url(); ?>" + "index.php/ajax_springtube/spring_aql_input_boxes",
					data: {jobcard_no : $('#jobcard_no').val(), qty : $("#rfd_qty").val() },
					cache: false,
					success: function(html){
					    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);				    		
					    var obj=JSON.parse(html);						
						$("#rfd_qty_boxes").html(obj.boxes);
							
					} 
				});			

			}


	});

	$(".printing_inspection").bind('blur keyup',function() {

  		var total=0;
  		$("#total_rejected_printing_issue").val(0);

	  	$(".printing_inspection").each(function() {
	    	var num=Number($(this).val());
	    	total+=num;
		});

		$("#total_rejected_printing_issue").val(total);

		var bodymaking_wip=0;
		var total_bodymaking=0;
		var total_printing=total;
		var inspection_qty=0;
		var total_rfd_qty=0;
		var remaning_wip=0;
		var counter_sample_qty=0;

		if($("#bm_wip_qty").val()!='' && Number($("#bm_wip_qty").val())>0){
			bodymaking_wip=Number($("#bm_wip_qty").val());
		}
		if($("#total_rejected_bodymaking_issue").val()!='' && Number($("#total_rejected_bodymaking_issue").val())>0 ){
			total_bodymaking=Number($("#total_rejected_bodymaking_issue").val());
		}
		if($("#inspection_qty").val()!='' && Number($("#inspection_qty").val())>0 ){
			inspection_qty=Number($("#inspection_qty").val());
		}
		if($("#counter_sample_qty").val()!='' && Number($("#counter_sample_qty").val())>0 ){
			counter_sample_qty=Number($("#counter_sample_qty").val());
		}

		if(bodymaking_wip>0){

			var total_rejected=(total_bodymaking+total_printing);
			total_rfd_qty=inspection_qty-total_rejected-counter_sample_qty;
			$("#rfd_qty").val(total_rfd_qty);
			$("#total_rejected_qty").val(total_rejected);

			// Ajax for rejected-------------------------
			$.ajax({type: "POST",
				url: "<?php echo base_url(); ?>" + "index.php/ajax_springtube/spring_aql_input_boxes",
				data: {jobcard_no : $('#jobcard_no').val(), qty : $("#total_rejected_qty").val() },
				cache: false,
				success: function(html){
				    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				    		
				    var obj=JSON.parse(html);						
					$("#total_rejected_qty_boxes").html(obj.boxes);
						
				} 
			});	

			// Ajax for RFD----------------------

			$.ajax({type: "POST",
				url: "<?php echo base_url(); ?>" + "index.php/ajax_springtube/spring_aql_input_boxes",
				data: {jobcard_no : $('#jobcard_no').val(), qty : $("#rfd_qty").val() },
				cache: false,
				success: function(html){
				    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);				    		
				    var obj=JSON.parse(html);						
					$("#rfd_qty_boxes").html(obj.boxes);
						
				} 
			});			


		}

	});


	$("#inspection_qty").bind('blur keyup',function() {

		$("#loading").hide(); $("#cover").hide();			
		
		$("#inspection_qty_boxes").val('');			

   		if($("#jobcard_no").val()!='' && Number($("#inspection_qty").val())>0){   			
   			//alert($("#bm_wip_qty").val());

   			var bm_wip_qty=Number($("#bm_wip_qty").val());
   			var inspection_qty=Number($("#inspection_qty").val());
   			var remaining_wip=bm_wip_qty-inspection_qty;
   			var total_rejected=Number($("#total_rejected_qty").val());
   			var counter_sample_qty=Number($("#counter_sample_qty").val());	
   			//alert(remaining_wip);	
   			var rfd_qty=inspection_qty-total_rejected-counter_sample_qty; 			
   			$("#remaining_wip").val(remaining_wip);
   			$("#rfd_qty").val(rfd_qty);


   			// AJAX for Inspection Qty --------------
	    	$.ajax({type: "POST",
	    		url: "<?php echo base_url(); ?>" + "index.php/ajax_springtube/spring_aql_input_boxes",
	    		data: {jobcard_no : $('#jobcard_no').val(), qty : $("#inspection_qty").val() }
	    		,cache: false,
	    		success: function(html){
			    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
			    		//alert(html);
			    	var obj=JSON.parse(html);
					
					$("#inspection_qty_boxes").html(obj.boxes);
					$("#counter_sample_qty").val(obj.no_of_tubes_per_box);
					$("#counter_sample_boxes").html('1');
					//$("#rfd_qty").val(inspection_qty-obj.no_of_tubes_per_box);
			    } 
			});

			// Ajax for RFD----------------------

			$.ajax({type: "POST",
				url: "<?php echo base_url(); ?>" + "index.php/ajax_springtube/spring_aql_input_boxes",
				data: {jobcard_no : $('#jobcard_no').val(), qty : $("#rfd_qty").val() },
				cache: false,
				success: function(html){
				    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);				    		
				    var obj=JSON.parse(html);						
					$("#rfd_qty_boxes").html(obj.boxes);
						
				} 
			});	

   		}else{
   			$("#loading").hide();$("#cover").hide();	   			
			$("#remaning_wip").val('');
			$("#inspection_qty_boxes").val('');
			$("#rfd_qty").val('');	

   		}

   	});

   	$("#counter_sample_qty").bind('blur keyup',function() {

		$("#loading").hide(); $("#cover").hide();			
		
		
		var inspection_qty=0;
		var counter_sample_qty=0;
		var total_rejected_qty=0;

		if($("#inspection_qty").val()!='' && Number($("#inspection_qty").val())>0 ){
			inspection_qty=Number($("#inspection_qty").val());
		}
		if($("#total_rejected_qty").val()!='' && Number($("#total_rejected_qty").val())>0 ){
			total_rejected_qty=Number($("#total_rejected_qty").val());
		}
		if($("#counter_sample_qty").val()!='' && Number($("#counter_sample_qty").val())>0 ){
			counter_sample_qty=Number($("#counter_sample_qty").val());
		}

		var rfd_qty=inspection_qty-total_rejected_qty-counter_sample_qty;
		//alert(counter_sample_qty);
		$("#rfd_qty").val(rfd_qty);			

   		if($("#jobcard_no").val()!='' && Number($("#counter_sample_qty").val())>0){  

   			//alert(); 			
   			// AJAX for counter Sample Qty --------------
	    	$.ajax({type: "POST",
	    		url: "<?php echo base_url(); ?>" + "index.php/ajax_springtube/spring_aql_input_boxes",
	    		data: {jobcard_no : $('#jobcard_no').val(), qty : $("#counter_sample_qty").val() }
	    		,cache: false,
	    		success: function(html){
			    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
			    		//alert(html);
			    	var obj=JSON.parse(html);					
					$("#counter_sample_boxes").html(obj.boxes);
			    } 
			});

				

   		}else{
   			$("#loading").hide();$("#cover").hide();
			$("#counter_sample_boxes").val('');
			

   		}

   	});


});//Jquery closed

</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
	<?php foreach($springtube_aql_rfd_master as $master_row): ?>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">

						<tr>
							<td class="label">AQL Date <span style="color:red;">*</span> :</td>
							<td>
								<input type="hidden" name="aql_id" value="<?php echo set_value('aql_id',$master_row->aql_id); ?>">
								<input type="date" name="aql_date"   value="<?php echo set_value('aql_date',$master_row->aql_date);?>" />
							</td>
							<td class="label">Jobcard No.  <span style="color:red;">*</span> :</td>
							<td>
								<input type="text" name="jobcard_no" id="jobcard_no"  size="20" value="<?php echo set_value('jobcard_no',$master_row->jobcard_no);?>" readonly/>
							</td>
							
						</tr>						
						<tr>	
							<td class="label">Order No. :</td>
							<td>
								<input type="text" name="order_no" id="order_no"  size="20" value="<?php echo set_value('order_no',$master_row->order_no);?>" readonly placeholder="Order no."/>
							</td>
							<td class="label">Article No. :</td>
							<td>
								<input type="text" name="article_no" id="article_no"  size="20" value="<?php echo set_value('article_no',$master_row->article_no);?>" readonly placeholder="Article no."/>
							</td>							
						</tr>						 
						<tr>
							<td class="label">Bodymaking WIP Qty <span style="color:red;">*</span></td>
							<td>
								<input type="text" name="bm_wip_qty" id="bm_wip_qty" size="20" value="<?php echo set_value('bm_wip_qty',$master_row->bm_wip_qty);?>" readonly placeholder="WIP Qty after Bodymaking."/>
							</td>
							<td colspan="2">
								<b> No. Of Boxes: </b><span style="color:blue;" name="bm_wip_boxes" id="bm_wip_boxes"><?php echo set_value('bm_wip_boxes');?></span>
								
							</td>
						</tr>

						<tr>
							<td class="label">Inspection Qty <span style="color:red;">*</span></td>
							<td>
								<input type="number" name="inspection_qty" id="inspection_qty"  min="0" steps="any" value="<?php echo set_value('inspection_qty',$master_row->inspection_qty);?>" placeholder="Inspection Qty"/>
							</td>
							<td colspan="2">
								<b> No. Of Boxes: </b><span style="color:blue;" name="inspection_qty_boxes" id="inspection_qty_boxes"><?php echo set_value('inspection_qty_boxes');?></span>
								
							</td>
						</tr>
						<tr>
							<td class="label">
								Remaining WIP Qty <span style="color:red;">*</span> :
							</td>
							<td>
								<input type="number" name="remaining_wip"  id="remaining_wip" min="0" max="1000000" step="any" value="<?php echo set_value('remaining_wip',$master_row->remaining_wip);?>" readonly placeholder="remaining WIP">
							</td>
						</tr>


						<tr>
							<td class="label" colspan="4"><b>BODYMAKING INSPECTION</b></td>
						</tr>
						<tr>
							<td class="label" colspan="3">Seam welding (in startup box) Decoseam one side <span style="color:red;">*</span> :
							</td>													
							<td><input class="bodymaking_inspection" type="number" name="seam_welding_stratup_box"  id="seam_welding_stratup_box" min="0" max="100000" step="any" value="<?php echo set_value('seam_welding_stratup_box',$master_row->seam_welding_stratup_box);?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">Seam welding (in ok box) <span style="color:red;">*</span> :
							</td>					
							<td>
								<input class="bodymaking_inspection" type="number" name="seam_welding_ok_box"  id="seam_welding_ok_box" min="0" max="100000" step="any" value="<?php echo set_value('seam_welding_ok_box',$master_row->seam_welding_ok_box);?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								Shoulder welding (in ok box) one side decoseam <span style="color:red;">*</span> :
							</td>														
							<td>
								<input  class="bodymaking_inspection" type="number" name="shoulder_welding_ok_box"  id="shoulder_welding_ok_box" min="0" max="100000" step="any" value="<?php echo set_value('shoulder_welding_ok_box',$master_row->shoulder_welding_ok_box);?>">
							</td>
						</tr>						
						<tr>
							<td class="label" colspan="3">
								Ink flaking (ink wrinkles in seam) <span style="color:red;">*</span> :
							</td>													
							<td>
								<input class="bodymaking_inspection" type="number" name="ink_flaking"  id="ink_flaking" min="0" max="100000" step="any" value="<?php echo set_value('ink_flaking',$master_row->ink_flaking);?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
							Cap oriantation alignment <span style="color:red;">*</span> :
							</td>
							<td>
								<input class="bodymaking_inspection" type="number" name="cap_oriantation_alignment"  id="cap_oriantation_alignment" min="0" max="100000" step="any" value="<?php echo set_value('cap_oriantation_alignment',$master_row->cap_oriantation_alignment);?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								Wrong position tube cutting <span style="color:red;">*</span> :
							</td>
							<td>
								<input class="bodymaking_inspection" type="number" name="wrong_position_tube_cutting"  id="wrong_position_tube_cutting" min="0" max="100000" step="any" value="<?php echo set_value('wrong_position_tube_cutting',$master_row->wrong_position_tube_cutting);?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								Scratch Lines <span style="color:red;">*</span> :
							</td>
							<td>
								<input class="bodymaking_inspection" type="number" name="scratch_line"  id="scratch_line" min="0" max="100000" step="any" value="<?php echo set_value('scratch_line',$master_row->scratch_line);?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								Shoulder Short Shot <span style="color:red;">*</span> :
							</td>
							<td>
								<input class="bodymaking_inspection" type="number" name="shoulder_short_shot"  id="shoulder_short_shot" min="0" max="100000" step="any" value="<?php echo set_value('shoulder_short_shot',$master_row->shoulder_short_shot);?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								Cap Gap Issue <span style="color:red;">*</span> :
							</td>
							<td>
								<input class="bodymaking_inspection" type="number" name="cap_gap_issue"  id="cap_gap_issue" min="0" max="100000" step="any" value="<?php echo set_value('cap_gap_issue',$master_row->cap_gap_issue);?>">
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
								<input type="number" name="total_rejected_bodymaking_issue"  id="total_rejected_bodymaking_issue" min="0" max="1000000" step="any" value="<?php echo set_value('total_rejected_bodymaking_issue',$master_row->total_rejected_bodymaking_issue);?>" readonly>
							</td>
						</tr>
						<!-- <tr>
							<td class="label" colspan="3">
								<b>Short Fall Qty <span style="color:red;">*</span> :</b>
							</td>
							<td>
								<input type="number" name="short_fall"  id="short_fall" min="0" max="1000000" step="any" value="<?php echo set_value('short_fall',$master_row->short_fall);?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								<b>Total rfd Qty<span style="color:red;">*</span> :</b>
							</td>
							<td>
								<input type="number" name="rfd_qty"  id="rfd_qty" min="0" max="1000000" step="any" value="<?php echo set_value('rfd_qty',$master_row->rfd_qty);?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								<b>Remaining WIP Qty <span style="color:red;">*</span> :</b>
							</td>
							<td>
								<input type="number" name="remaining_wip"  id="remaining_wip" min="0" max="1000000" step="any" value="<?php echo set_value('remaining_wip',$master_row->remaining_wip);?>" readonly>
							</td>
						</tr> -->
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
						
						<tr>
							<td class="label" colspan="4"><b>PRINTING INSPECTION</b></td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								Smudge Printing <span style="color:red;">*</span> :
							</td>
							<td>
								<input class="printing_inspection" type="number" name="smudge_printing"  id="smudge_printing" min="0" max="100000" step="any" value="<?php echo set_value('smudge_printing',$master_row->smudge_printing);?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								Print / Foil miss registation <span style="color:red;">*</span> :
							</td>
							<td>
								<input class="printing_inspection" type="number" name="print_miss_registration"  id="print_miss_registration" min="0" max="100000" step="any" value="<?php echo set_value('print_miss_registration',$master_row->print_miss_registration);?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								Foil cut / Unsharp foil <span style="color:red;">*</span> :
							</td>
							<td>
								<input class="printing_inspection" type="number" name="foil_cut"  id="foil_cut" min="0" max="100000" step="any" value="<?php echo set_value('foil_cut',$master_row->foil_cut);?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								Stopage marks <span style="color:red;">*</span> :
							</td>
							<td>
								<input class="printing_inspection" type="number" name="stopage_marks"  id="stopage_marks" min="0" max="100000" step="any" value="<?php echo set_value('stopage_marks',$master_row->stopage_marks);?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								Without Varnsih <span style="color:red;">*</span> :
							</td>
							<td>
								<input class="printing_inspection" type="number" name="without_varnish"  id="without_varnish" min="0" max="100000" step="any" value="<?php echo set_value('without_varnish',$master_row->without_varnish);?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								Wet varnish / motlling <span style="color:red;">*</span> :
							</td>
							<td>
								<input class="printing_inspection" type="number" name="wet_varnish"  id="wet_varnish" min="0" max="100000" step="any" value="<?php echo set_value('wet_varnish',$master_row->wet_varnish);?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								Streaks / Nozzle lines <span style="color:red;">*</span> :
							</td>
							<td>
								<input class="printing_inspection" type="number" name="streaks_nozzle_lines"  id="streaks_nozzle_lines" min="0" max="100000" step="any" value="<?php echo set_value('streaks_nozzle_lines',$master_row->streaks_nozzle_lines);?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								Ghost Printing <span style="color:red;">*</span> :
							</td>
							<td>
								<input class="printing_inspection" type="number" name="ghost_printing"  id="ghost_printing" min="0" max="100000" step="any" value="<?php echo set_value('ghost_printing',$master_row->ghost_printing);?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								Nozzle ink dots <span style="color:red;">*</span> :
							</td>
							<td>
								<input class="printing_inspection" type="number" name="nozzle_ink_dots"  id="nozzle_ink_dots" min="0" max="100000" step="any" value="<?php echo set_value('nozzle_ink_dots',$master_row->nozzle_ink_dots);?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								Reel trimming issue <span style="color:red;">*</span> :
							</td>
							<td>
								<input class="printing_inspection" type="number" name="reel_trimming_issue"  id="reel_trimming_issue" min="0" max="100000" step="any" value="<?php echo set_value('reel_trimming_issue',$master_row->reel_trimming_issue);?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								Peel off and varnish cut <span style="color:red;">*</span> :
							</td>
							<td>
								<input class="printing_inspection" type="number" name="peel_off_varnish_cut"  id="peel_off_varnish_cut" min="0" max="100000" step="any" value="<?php echo set_value('peel_off_varnish_cut',$master_row->peel_off_varnish_cut);?>">
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								Other printing defects <span style="color:red;">*</span> :
							</td>
							<td>
								<input class="printing_inspection" type="number" name="other_print_defects"  id="other_print_defects" min="0" max="100000" step="any" value="<?php echo set_value('other_print_defects',$master_row->other_print_defects);?>">
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
								<input type="number" name="total_rejected_printing_issue"  id="total_rejected_printing_issue" min="0" max="1000000" step="any" value="<?php echo set_value('total_rejected_printing_issue',$master_row->total_rejected_printing_issue);?>" readonly>
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								<b>Total Rejected Qty<span style="color:red;">*</span> :</b>
							</td>
							<td>
								<input type="number" name="total_rejected_qty"  id="total_rejected_qty" min="0" step="any" value="<?php echo set_value('total_rejected_qty',$master_row->total_rejected_qty);?>" readonly>
							</td>
							<td colspan="2">
								<b> No. Of Boxes: </b><span style="color:blue;"name="total_rejected_qty_boxes" id="total_rejected_qty_boxes"><?php echo set_value('total_rejected_qty_boxes');?></span>
								
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								<b>Counter Sample Tubes<span style="color:red;">*</span> :</b>
							</td>
							<td>
								<input type="number" name="counter_sample_qty"  id="counter_sample_qty" min="0" step="any" value="<?php echo set_value('counter_sample_qty',$master_row->counter_sample_qty);?>" >
							</td>
							<td colspan="2">
								<b> No. Of Boxes: </b><span style="color:blue;"name="counter_sample_boxes" id="counter_sample_boxes"><?php echo set_value('counter_sample_boxes');?></span>
								
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">
								<b>Total rfd Qty<span style="color:red;">*</span> :</b>
							</td>
							<td>
								<input type="number" name="rfd_qty"  id="rfd_qty" min="0"  step="any" value="<?php echo set_value('rfd_qty',$master_row->rfd_qty);?>" readonly>
							</td>
							<td colspan="2">
								<b> No. Of Boxes: </b><span style="color:blue;" name="rfd_qty_boxes" id="rfd_qty_boxes"><?php echo set_value('rfd_qty_boxes');?></span>
								
							</td>
						</tr>	

					</table>
				</td>							
			</tr>
		</table>
	<?php endforeach;?>		
					
	</div>
	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button" onClick="return confirm('Are you sure to update Record?');">Update</button>
		</div>
	</div>	
</form>

<script>

	$(document).ready(function(){

		$("#loading").hide(); $("#cover").hide();


		// Ajax for Bodymaking WIP-------------------------
		if($("#bm_wip_qty").val()!=''){

			$.ajax({type: "POST",
				url: "<?php echo base_url(); ?>" + "index.php/ajax_springtube/spring_aql_input_boxes",
				data: {jobcard_no : $('#jobcard_no').val(), qty : $("#bm_wip_qty").val() },
				cache: false,
				success: function(html){
				    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				    		
				    var obj=JSON.parse(html);						
					$("#bm_wip_boxes").html(obj.boxes);
						
				} 
			});	
		}

		// Ajax for Inspection Qty -------------------------
		if($("#inspection_qty").val()!=''){

			$.ajax({type: "POST",
				url: "<?php echo base_url(); ?>" + "index.php/ajax_springtube/spring_aql_input_boxes",
				data: {jobcard_no : $('#jobcard_no').val(), qty : $("#inspection_qty").val() },
				cache: false,
				success: function(html){
				    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				    		
				    var obj=JSON.parse(html);						
					$("#inspection_qty_boxes").html(obj.boxes);
						
				} 
			});	
		}


		// Ajax for rejected-------------------------
		if($("#total_rejected_qty").val()!=''){

			$.ajax({type: "POST",
				url: "<?php echo base_url(); ?>" + "index.php/ajax_springtube/spring_aql_input_boxes",
				data: {jobcard_no : $('#jobcard_no').val(), qty : $("#total_rejected_qty").val() },
				cache: false,
				success: function(html){
				    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				    		
				    var obj=JSON.parse(html);						
					$("#total_rejected_qty_boxes").html(obj.boxes);
						
				} 
			});	
		}
		
		if($("#rfd_qty").val()!=''){	

			// Ajax for RFD----------------------

			$.ajax({type: "POST",
				url: "<?php echo base_url(); ?>" + "index.php/ajax_springtube/spring_aql_input_boxes",
				data: {jobcard_no : $('#jobcard_no').val(), qty : $("#rfd_qty").val() },
				cache: false,
				success: function(html){
				    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);				    		
				    var obj=JSON.parse(html);						
					$("#rfd_qty_boxes").html(obj.boxes);
						
				} 
			});	
		}





	});


</script>

				
				
				
			