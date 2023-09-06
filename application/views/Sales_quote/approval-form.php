<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();

		$("#customer_category").autocomplete("<?php echo base_url('index.php/ajax/customer_category_autocomplete');?>", {selectFirst: true});
		
		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});
		$("#invoice_no").autocomplete("<?php echo base_url('index.php/ajax/ar_invoice_no');?>", {selectFirst: true});
		$("#tube_color").autocomplete("<?php echo base_url('index.php/ajax/tube_color');?>", {selectFirst: true});
		$("#shoulder_color").autocomplete("<?php echo base_url('index.php/ajax/tube_color');?>", {selectFirst: true});
		$("#cap_color").autocomplete("<?php echo base_url('index.php/ajax/tube_color');?>", {selectFirst: true});


		$("#customer_category").blur(function() {
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/purchase_manager');?>",data: {customer : $("#customer_category").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#pm_1").html(html);
				} 
			});
		});	

		var customer_flag = 0;
		$("#customer_flag").val(customer_flag.toFixed(2));	
		$("#customer_category").blur(function() {
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/get_customer_flag');?>",data: {customer : $("#customer_category").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#customer_flag").val(html);
				} 
			});
		});

		// if($("#customer").val()!=''){
		// 	$("#loading").show(); $("#cover").show();
		// 	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
		// 	$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/purchase_manager');?>",data: {customer : $("#customer").val()},cache: false,success: function(html){
		// 		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
		// 		$("#pm_1").html(html);
		// 		} 
		// 	});
		// }

		$("#print_type").change(function(event) {

		  $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
							
		    $.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/machine_type');?>",data:{print_type : $('#print_type').val()},cache: false,success: function(html){
		    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
		       $("#machine_type").html(html);
		    } 
		    });
   		});

		$("#machine_type").change(function(event) {

		  $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');				
		    $.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/machine_type_details');?>",data:{machine_type : $('#machine_type').val()},cache: false,success: function(html){
		    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
		       $("#running_speed").val(html);
		       var running_speed_90 = $('#running_speed').val() * 0.9;
		       $("#running_speed_90").val(running_speed_90);
		    } 
		    });
   		});

		$("#machine_type").change(function(event) {

		  $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');				
		    $.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/machine_type_min_contribution');?>",data:{machine_type : $('#machine_type').val()},cache: false,success: function(html){
		    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
		       $("#min_contribution").val(html);
		    } 
		    });
   		});

		$("#machine_type").change(function(event) {

		  $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');				
		    $.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/machine_type_jobchangeover_details');?>",data:{machine_type : $('#machine_type').val()},cache: false,success: function(html){
		    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
		       $("#job_changeover").val(html);
		    } 
		    });
   		});

		$("#machine_type").change(function(event) {

		  $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');				
		    $.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/machine_type_capacity_details');?>",data:{machine_type : $('#machine_type').val()},cache: false,success: function(html){
		    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
		       $("#capacity").val(html);
		    } 
		    });
   		});

		$("#sleeve_dia").live('change',function() {
   		var sleeve_dia = $('#sleeve_dia').val();
		   $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
							
		    $.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/shoulder'); ?>",data: {sleeve_dia : $('#sleeve_dia').val()},cache: false,success: function(html){
		    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
		       $("#shoulder").html(html);
		    } 
		    });
   		});


		$('#shoulder').change(function(event) {
	      if ($('#shoulder').val()=='ZELLER//6' || $('#shoulder').val()=='NOZZLE//3' || $('#shoulder').val()=='TEAR OFF//4' || $('#shoulder').val()=='BEVEL//2' ){
	      	$("#shoulder_foil").hide();
	      }else{
	        $("#shoulder_foil").show();
	      }
	    });

	    
	
		$("#shoulder").change(function(event) {
		   var sleeve_dia = $('#sleeve_dia').val();
		   var shoulder = $('#shoulder').val();
		   $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
		    $.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/shoulder_orifice'); ?>",data: {sleeve_dia : $('#sleeve_dia').val(),shoulder : $('#shoulder').val()},cache: false,success: function(html){
		    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
		       $("#shoulder_orifice").html(html);
		    } 
		    });
   		});
	


		$("#shoulder").live('change',function() {
		   var sleeve_dia = $('#sleeve_dia').val();
		   var shoulder = $('#shoulder').val();
		   var shoulder_orifice = $('#shoulder_orifice').val();
   			$("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
		    $.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/cap_type'); ?>",data: {sleeve_dia : $('#sleeve_dia').val(),shoulder : $('#shoulder').val(),shoulder_orifice :$('#shoulder_orifice').val()},cache: false,success: function(html){
		    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
		       $("#cap_type").html(html);
		    } 
		    });
		   });

  

  		$("#cap_type").live('change',function() {
  		 var cap_type = $('#cap_type').val();
  		 $("#loading").show();
    		  $("#cover").show();
     		 $('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
		      $.ajax({type: "POST",url: "<?php echo base_url("index.php/ajax/spec_cap_finish");?>",data: {cap_type:$('#cap_type').val()},cache: false,success: function(html){
		        setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
		       $("#cap_finish").html(html);
   			 } 
   			 });
 			  });

        $("#cap_finish").change(function(event) {
			   var sleeve_dia = $('#sleeve_dia').val();
			   var shoulder = $('#shoulder').val();
			   var shoulder_orifice = $('#shoulder_orifice').val();
			   var cap_type = $('#cap_type').val();
			   var cap_finish = $('#cap_finish').val();
			   $("#loading").show();
						$("#cover").show();
						$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			    $.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/cap_dia'); ?>",data: {sleeve_dia : $('#sleeve_dia').val(),shoulder : $('#shoulder').val(),shoulder_orifice :$('#shoulder_orifice').val(),cap_type:$('#cap_type').val(),cap_finish:$('#cap_finish').val()},cache: false,success: function(html){
			    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
			       $("#cap_dia").html(html);
			    } 
			    });
			   });

        // Cap Orifice Load

		   $("#cap_dia").change(function(event) {
			   var cap_type = $('#cap_type').val();
			   var cap_finish = $('#cap_finish').val();
			   var cap_dia = $('#cap_dia').val();
			   $("#loading").show();
			   $("#cover").show();
			   $('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			   $.ajax({type: "POST",url: "<?php echo base_url("index.php/ajax/spec_cap_orifice"); ?>",data: {cap_type:$('#cap_type').val(),cap_finish:$('#cap_finish').val(),cap_dia:$('#cap_dia').val()},cache: false,success: function(html){
			        setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
			       $("#cap_orifice").html(html);

		    } 
		    });
		   });


   	//--------------------Layers------------------------------------

   $("#check").click(function(event) {
   	//alert($("#cap_dia").val());
   	 $("#loading").show();
	   $("#cover").show();
	   $('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   if($("#cap_metalization").is(':checked')){
	   	var cap_metalization = $("#cap_metalization").val();
	   }
	   if($("#cap_foil").is(':checked')){
	   	var cap_foil= $("#cap_foil").val();
	   }   if($("#layer").val()!=""){
	   	$.ajax({type: "POST",
	   	url: "<?php echo base_url(); ?>" + "index.php/ajax/costsheet_data",
	   	data: {
	   		layer:$("#layer").val(),
	   		sleeve_dia:$("#sleeve_dia").val(),
	   		shoulder:$("#shoulder").val(),
	   		cap_type:$("#cap_type").val(),
	   		cap_finish:$("#cap_finish").val(),
	   		cap_dia:$("#cap_dia").val(),
	   		print_type:$("#print_type").val(),
	   		shoulder_foil:$("#shoulder_foil").val(),
	   		cap_foil:cap_foil,
	   		cap_metalization:cap_metalization,
	   		cap_shrink_sleeve:$("#cap_shrink_sleeve").val(),
	   		tube_foil:$("#tube_foil").val(),


	   	},cache: false,
	   	success: function(html){
	   		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	   		$("#costsheet_table").html(html);
	   	}
	   });
	   }else{
	   	alert('Please Select Layer');
	   	$("#loading").hide();
	   	$("#cover").hide();
	   }

	  });

   //---------sleeve length---

   $("#sleeve_length").blur(function(){
   		$("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
					
		   $.ajax({type: "POST",
		    		url: "<?php echo base_url(); ?>" + "index.php/ajax/sleeve_length",
		    		data: {
		    		sleeve_dia : $('#sleeve_dia').val(),
		    		sleeve_length:$('#sleeve_length').val()
		    		},
    				cache: false,
    				success: function(html){
    				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
      			$("#sleeve_length").html(html);
    			} 
		    });

   		});




   //--------------------Quote price------------------------------------

   $("#_5k_cost").blur(function(){
			
								
			if($("#_5k_quoted_contr").val()!='' && $("#_5k_cost").val()!=''){
					
						//var less_than_10k_quoted_contr=$("#less_than_10k_quoted_contr").val();
						//alert(parseInt(less_than_10k_quoted_contr).toFixed(1));

						var _5k_quoted_price= parseFloat($("#_5k_quoted_contr").val()) + parseFloat($("#_5k_cost").val());
						$("#_5k_quoted_price").val(_5k_quoted_price.toFixed(2));
					
			}
		});

   $("#_10k_cost").blur(function(){
			
								
			if($("#_10k_quoted_contr").val()!='' && $("#_10_cost").val()!=''){
					
						var _10k_quoted_price=	parseFloat($("#_10k_quoted_contr").val()) + parseFloat($("#_10k_cost").val());
						$("#_10k_quoted_price").val(_10k_quoted_price.toFixed(2));
					
			}
		});

   $("#_25k_cost").blur(function(){
			
								
			if($("#_25k_quoted_contr").val()!='' && $("#_25k_cost").val()!=''){
					
						var _25k_quoted_price=	parseFloat($("#_25k_quoted_contr").val()) + parseFloat($("#_25k_cost").val());
						$("#_25k_quoted_price").val(_25k_quoted_price.toFixed(2));
					
			}
		});

   $("#_50k_cost").blur(function(){
			
								
			if($("#_50k_quoted_contr").val()!='' && $("#_50k_cost").val()!=''){
					
						var _50k_quoted_price=	parseFloat($("#_50k_quoted_contr").val()) + parseFloat($("#_50k_cost").val());
						$("#_50k_quoted_price").val(_50k_quoted_price.toFixed(2));
					
			}
		});

   $("#_100k_cost").blur(function(){
			
								
			if($("#_100k_quoted_contr").val()!='' && $("#_100k_cost").val()!=''){
					
						var _100k_quoted_price=	parseFloat($("#_100k_quoted_contr").val()) + parseFloat($("#_100k_cost").val());
						$("#_100k_quoted_price").val(_100k_quoted_price.toFixed(2));
					
			}
		});

   $("#free_cost").blur(function(){
			
								
			if($("#free_quoted_contr").val()!='' && $("#free_cost").val()!=''){
					
						var free_quoted_price=	parseFloat($("#free_quoted_contr").val()) + parseFloat($("#free_cost").val());
						$("#free_quoted_price").val(free_quoted_price.toFixed(2));
					
			}
		});
  /* //-------------- Total packing cost addition
   $("#customer_category").blur(function(){		

   		//var customer_flag = $("#customer_flag").html().split('.');
   		//alert(customer_flag[1]);
   		var packing_bopp_tape = parseFloat($("#packing_bopp_tape").text()) ;

   		var other_packing_material = parseFloat($("#other_packing_material").text()) ;
					
		var packing_stickers = parseFloat($("#packing_stickers").text()) ;

		var packing_corrugated_sheet = parseFloat($("#packing_corrugated_sheet").text()) ;

		var packing_shrink_flim = parseFloat($("#packing_shrink_flim").text()) ;

		var total_packing = packing_bopp_tape + other_packing_material + packing_stickers + packing_corrugated_sheet + packing_shrink_flim;
		//alert(total_packing);

		$("#total_packing").val(total_packing);
		$("#total_packing").html(total_packing);
					
			
		});*/

  //----------------------------  layer 1 RM cost--------------------------
		

		$("#sl_ldpe").live('change',function() {
			//alert('hi');

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/get_rm_rate'); ?>",data: {rm:$('#sl_ldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer1_ldpe_rate").val(html);

		   	 } 
		    	});
  		 });

		$("#sl_lldpe").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#sl_lldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer1_lldpe_rate").val(html);

		   	 } 
		    	});
  		 });	

		$("#sl_hdpe").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#sl_hdpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer1_hdpe_rate").val(html);

		   	 } 
		    	});
  		 });

		$("#sl_masterbatch").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#sl_masterbatch').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer1_mb_rate").val(html);

		   	 } 
		    	});
  		 });

		//------------------------Layer 1 Check button---------------
		var sleeve_cost=0;
		//$('#sleeve_cost_view').val(sleeve_cost.toFixed(2));


		$("#layer1_sleevecost").live('click',function() {
			//alert('hi');

			if($('#sleeve_dia').val()=="" || $('#sleeve_length').val()==""){
				alert("Please enter the Diameter,Length");
			}else if($('#micron').val()=="" || $('#layer1_ld_percentage').val()=="" || $('#layer1_lld_percentage').val()=="" || $('#layer1_hd_percentage').val()=="" ){
				alert("Please enter Micron , % ");
			}else if(parseFloat($('#layer1_ld_percentage').val())!== 0 && $('#sl_ldpe').val()==""  || parseFloat($('#layer1_lld_percentage').val())!== 0 && $('#sl_lldpe').val()=="" ){
				alert("Please select RM ");
			}else if(parseFloat($('#layer1_hd_percentage').val())!== 0 && $('#sl_hdpe').val()==""  || parseFloat($('#layer1_lld_percentage').val())!== 0 && $('#sl_lldpe').val()=="" ){
				alert("Please select RM ");		
		  }else if(parseFloat($("#layer1_ld_percentage").val()) + parseFloat($("#layer1_lld_percentage").val()) + parseFloat($("#layer1_hd_percentage").val())!== 100 ){
				alert(" % of LD , LLD and HD should be 100");
			}else if($('#sl_masterbatch').val()=="" && $('#layer1_mb1').val()==""){
				alert("Please Enter MB ");
			 // }else if($('#sl_masterbatch').val()!="" && ($('#layer1_mb_rate').val()== "" || $('#layer1_mb_percentage').val()==0)){
			 // alert("Please correct MB Deatils ");
			 }else if($('#sl_masterbatch').val()!="" && $('#layer1_mb_rate').val()>0  && $('#layer1_mb_percentage').val()==0){
			alert("Please correct MB  % Deatils ");
			}else if($('#layer1_mb1').val()!="" && ($('#layer1_mb1_rate').val()==""  ||  $('#layer1_mb_percentage1').val()=="")){
			alert("Please correct MB1 Rate & % Deatils ");
			}else if($('#layer1_mb1').val()!="" && $('#layer1_mb1_rate').val()>0  && $('#layer1_mb_percentage1').val()==0){
			alert("Please correct MB1  % Deatils ");
			}else if($('#layer1_rejection').val()=="" || $('#layer1_rejection').val()==0){
			alert("Please enter rejection %");
			}else{
				var check = parseInt($("#layer1_ld_percentage").val()) + parseInt($("#layer1_lld_percentage").val()) +  parseInt($("#layer1_hd_percentage").val()) ;
				

				var sleeveweight= (((parseFloat($('#sleeve_dia').val()) * parseFloat($('#sleeve_length').val()) * parseFloat($('#micron').val()) * 3.14 * 0.92/1000000)/1000)*parseFloat($('#quantity').val()));

				sleeveweight=sleeveweight+sleeveweight*(parseFloat($('#layer1_rejection').val())/100);

				var ldweight = (sleeveweight * parseFloat($('#layer1_ld_percentage').val())) / 100 ;
				var lldweight = (sleeveweight * parseFloat($('#layer1_lld_percentage').val())) / 100 ;
				var hdweight = (sleeveweight * parseFloat($('#layer1_hd_percentage').val())) / 100 ;
				var mbweight = (sleeveweight * parseFloat($('#layer1_mb_percentage').val())) / 100 ;
				var mb1weight = (sleeveweight * parseFloat($('#layer1_mb_percentage1').val())) / 100 ;
				//alert(mbweight);
				//alert(mb1weight);

				var ldvalue = ($("#layer1_ldpe_rate").val()* ldweight) ;
				var lldvalue = ($("#layer1_lldpe_rate").val()* lldweight) ;
				var hdvalue = ($("#layer1_hdpe_rate").val()* hdweight) ;
				var mbvalue = ($("#layer1_mb_rate").val()* mbweight) ;
				var mb1value = ($("#layer1_mb1_rate").val()* mb1weight);
				//alert(mbvalue);
				//alert(mb1value);

				var ldcost_per_tube = 	(ldvalue / parseFloat($('#quantity').val()));	
				var lldcost_per_tube = 	(lldvalue / parseFloat($('#quantity').val()));
				var hdcost_per_tube = 	(hdvalue / parseFloat($('#quantity').val()));
				var mbcost_per_tube = 	(mbvalue / parseFloat($('#quantity').val()));
				var mb1cost_per_tube = 	(mb1value / parseFloat($('#quantity').val()));
				//alert(mbcost_per_tube);
				//alert(mb1cost_per_tube);

				 sleeve_cost = (ldcost_per_tube + lldcost_per_tube + hdcost_per_tube + mbcost_per_tube + mb1cost_per_tube );
				//alert(sleeve_cost);
				$('#sleeve_cost').val(sleeve_cost.toFixed(2));
				$('#sleeve_cost_view').val(sleeve_cost.toFixed(2));
				
			}
		});


		//------------------------LAYER 2 RM -------------------
		$("#layer2_layer1_sl_ldpe").live('change',function() {

		$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer2_layer1_sl_ldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer2_layer1_ldpe_rate").val(html);

		   	 } 
		    	});
  		 });

		$("#layer2_layer1_sl_lldpe").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer2_layer1_sl_lldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer2_layer1_lldpe_rate").val(html);

		   	 } 
		    	});
  		 });	

		$("#layer2_layer1_sl_hdpe").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer2_layer1_sl_hdpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer2_layer1_hdpe_rate").val(html);

		   	 } 
		    	});
  		 });

		$("#layer2_layer2_sl_ldpe").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer2_layer2_sl_ldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer2_layer2_ldpe_rate").val(html);

		   	 } 
		    	});
  		 });

		$("#layer2_layer2_sl_lldpe").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer2_layer2_sl_lldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer2_layer2_lldpe_rate").val(html);

		   	 } 
		    	});
  		 });	

		$("#layer2_layer2_sl_hdpe").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer2_layer2_sl_hdpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer2_layer2_hdpe_rate").val(html);

		   	 } 
		    	});
  		 });

		$("#layer2_layer_1_rm_4_code").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer2_layer_1_rm_4_code').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer2_layer_1_rm_4_rate").val(html);

		   	 } 
		    	});
  		 });

		$("#layer2_layer_2_rm_9_code").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer2_layer_2_rm_9_code').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer2_layer_2_rm_9_rate").val(html);

		   	 } 
		    	});
  		 });

	//--------Layer 2 check button-----------

		$("#layer2_sleevecost").live('click',function() {

			if($('#sleeve_dia').val()=="" || $('#sleeve_length').val()==""){
				alert("Please enter the Diameter,Length");
			}else if($('#layer2_layer1_micron').val()=="" || $('#layer2_layer1_ld_percentage').val()=="" || $('#layer2_layer1_lld_percentage').val()=="" || $('#layer2_layer1_hd_percentage').val()=="" ){
				alert("Please Enter Layer1 Micron , % ");		
			}else if(parseInt($('#layer2_layer1_ld_percentage').val())!== 0 && $('#layer2_layer1_sl_ldpe').val()==""  || parseInt($('#layer2_layer1_lld_percentage').val())!== 0 && $('#layer2_layer1_sl_lldpe').val()=="" ){
				alert("Please Select Layer1 RM ");
			}else if(parseInt($('#layer2_layer1_hd_percentage').val())!== 0 && $('#layer2_layer1_sl_hdpe').val()==""  || parseInt($('#layer2_layer1_lld_percentage').val())!== 0 && $('#layer2_layer1_sl_lldpe').val()=="" ){
				alert("Please Select Layer1 RM ");	
			}else if(parseInt($("#layer2_layer1_ld_percentage").val()) + parseInt($("#layer2_layer1_lld_percentage").val()) + parseInt($("#layer2_layer1_hd_percentage").val())!== 100 ){
				alert(" % of LD , LLD and HD should be 100");							
			}else if($('#layer2_layer_1_rm_4_code').val()=="" && $('#layer2_layer_1_rm_5_code').val()==""){
				alert("Please Enter MB ");

			// }else if($('#layer2_layer_1_rm_4_code').val()!="" && (parseFloat($('#layer2_layer_1_rm_4_rate').val())== "" || parseFloat($('#layer2_layer_1_rm_4_percentage').val())==0)){
			// alert("Please correct MB Deatils ");
			}else if($('#layer2_layer_1_rm_4_code').val()!="" && $('#layer2_layer_1_rm_4_rate').val()>0  && $('#layer2_layer_1_rm_4_percentage').val()==0){
			alert("Please correct MB  % Deatils ");

			}else if($('#layer2_layer_1_rm_5_code').val()!="" && ($('#layer2_layer_1_rm_5_rate').val()==""  ||  $('#layer2_layer_1_rm_5_percentage').val()=="")){
			alert("Please correct MB Rate & % Deatils ");
			}else if($('#layer2_layer_1_rm_5_code').val()!="" && $('#layer2_layer_1_rm_5_rate').val()>0  && $('#layer2_layer_1_rm_5_percentage').val()==0){
			alert("Please correct MB  % Deatils ");

			//------------------layer 2 validation	
			}else if($('#layer2_layer2_micron').val()=="" || $('#layer2_layer2_ld_percentage').val()=="" || $('#layer2_layer2_lld_percentage').val()=="" || $('#layer2_layer2_hd_percentage').val()=="" ){
				alert("Please Enter Layer2 Micron , % ");		
			}else if(parseInt($('#layer2_layer2_ld_percentage').val())!== 0 && $('#layer2_layer2_sl_ldpe').val()==""  || parseInt($('#layer2_layer2_lld_percentage').val())!== 0 && $('#layer2_layer2_sl_lldpe').val()=="" ){
				alert("Please Select Layer2 RM ");
			}else if(parseInt($('#layer2_layer2_hd_percentage').val())!== 0 && $('#layer2_layer2_sl_hdpe').val()==""  || parseInt($('#layer2_layer2_lld_percentage').val())!== 0 && $('#layer2_layer2_sl_lldpe').val()=="" ){
				alert("Please Select Layer2 RM ");	
			}else if(parseInt($("#layer2_layer2_ld_percentage").val()) + parseInt($("#layer2_layer2_lld_percentage").val()) + parseInt($("#layer2_layer2_hd_percentage").val())!== 100 ){
				alert(" % of LD , LLD and HD should be 100");							
			}else if($('#layer2_layer_2_rm_9_code').val()=="" && $('#layer2_layer_2_rm_10_code').val()==""){
				alert("Please Enter MB ");
			// }else if($('#layer2_layer_2_rm_9_code').val()!="" && (parseFloat($('#layer2_layer_2_rm_9_rate').val())== "" || parseFloat($('#layer2_layer_2_rm_9_percentage').val())==0)){
			// alert("Please correct MB Deatils ");
			}else if($('#layer2_layer_2_rm_9_code').val()!="" && $('#layer2_layer_2_rm_9_rate').val()>0  && $('#layer2_layer_2_rm_9_percentage').val()==0){
			alert("Please correct MB  % Deatils ");

			}else if($('#layer2_layer_2_rm_10_code').val()!="" && ($('#layer2_layer_2_rm_10_rate').val()==""  ||  $('#layer2_layer_2_rm_10_percentage').val()=="")){
			alert("Please correct MB Rate & % Deatils ");
			}else if($('#layer2_layer_2_rm_10_code').val()!="" && $('#layer2_layer_2_rm_10_rate').val()>0  && $('#layer2_layer_2_rm_10_percentage').val()==0){
			alert("Please correct MB  % Deatils ");

			}else if($('#layer2_rejection').val()=="" && $('#layer2_rejection').val()==0){
			alert("Please enter Rejection  % Deatils ");

			}else{
				var check = parseInt($("#layer2_layer1_ld_percentage").val()) + parseInt($("#layer2_layer1_lld_percentage").val()) +  parseInt($("#layer2_layer1_hd_percentage").val()) ;
				//alert(check); 

				var layer2_layer1_sleeveweight= (((parseFloat($('#sleeve_dia').val()) * parseFloat($('#sleeve_length').val()) * parseFloat($('#layer2_layer1_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseFloat($('#layer2_quantity').val()));

				layer2_layer1_sleeveweight=layer2_layer1_sleeveweight+layer2_layer1_sleeveweight*(parseFloat($('#layer2_rejection').val())/100);

				var layer2_layer2_sleeveweight= (((parseInt($('#sleeve_dia').val()) * parseFloat($('#sleeve_length').val()) * parseInt($('#layer2_layer2_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseInt($('#layer2_quantity').val())) ;

				layer2_layer2_sleeveweight=layer2_layer2_sleeveweight+layer2_layer2_sleeveweight*(parseFloat($('#layer2_rejection').val())/100);

				//alert(layer2_layer1_sleeveweight);
				//alert(layer2_layer2_sleeveweight);

				var layer2_layer1_ldweight = (layer2_layer1_sleeveweight * parseInt($('#layer2_layer1_ld_percentage').val())) / 100 ;
				var layer2_layer1_lldweight = (layer2_layer1_sleeveweight * parseInt($('#layer2_layer1_lld_percentage').val())) / 100 ;
				var layer2_layer1_hdweight = (layer2_layer1_sleeveweight * parseInt($('#layer2_layer1_hd_percentage').val())) / 100 ;
				var layer2_layer1_mbweight = (layer2_layer1_sleeveweight * parseInt($('#layer2_layer_1_rm_4_percentage').val())) / 100 ;
				var layer2_layer1_mb1weight = (layer2_layer1_sleeveweight * parseInt($('#layer2_layer_1_rm_5_percentage').val())) / 100 ;

				var layer2_layer2_ldweight = (layer2_layer2_sleeveweight * parseInt($('#layer2_layer2_ld_percentage').val())) / 100 ;
				var layer2_layer2_lldweight = (layer2_layer2_sleeveweight * parseInt($('#layer2_layer2_lld_percentage').val())) / 100 ;
				var layer2_layer2_hdweight = (layer2_layer2_sleeveweight * parseInt($('#layer2_layer2_hd_percentage').val())) / 100 ;
				var layer2_layer2_mbweight = (layer2_layer2_sleeveweight * parseInt($('#layer2_layer_2_rm_9_percentage').val())) / 100 ;
				var layer2_layer2_mb1weight = (layer2_layer2_sleeveweight * parseInt($('#layer2_layer_2_rm_10_percentage').val())) / 100 ;
				//alert(layer2_layer2_ldweight);
				//alert(layer2_layer2_mb1weight);	

				var layer2_layer1_ldvalue = ($("#layer2_layer1_ldpe_rate").val()* layer2_layer1_ldweight) ;
				var layer2_layer1_lldvalue = ($("#layer2_layer1_lldpe_rate").val()* layer2_layer1_lldweight) ;
				var layer2_layer1_hdvalue = ($("#layer2_layer1_hdpe_rate").val()* layer2_layer1_hdweight) ;
				var layer2_layer1_mbvalue = ($("#layer2_layer_1_rm_4_rate").val()* layer2_layer1_mbweight) ;
				var layer2_layer1_mb1value = ($("#layer2_layer_1_rm_5_rate").val()* layer2_layer1_mb1weight);

				var layer2_layer2_ldvalue = ($("#layer2_layer2_ldpe_rate").val()* layer2_layer2_ldweight) ;
				var layer2_layer2_lldvalue = ($("#layer2_layer2_lldpe_rate").val()* layer2_layer2_lldweight) ;
				var layer2_layer2_hdvalue = ($("#layer2_layer2_hdpe_rate").val()* layer2_layer2_hdweight) ;
				var layer2_layer2_mbvalue = ($("#layer2_layer_2_rm_9_rate").val()* layer2_layer2_mbweight) ;
				var layer2_layer2_mb1value = ($("#layer2_layer_2_rm_10_rate").val()* layer2_layer2_mb1weight);
				//alert(layer2_layer2_ldvalue);
				//alert(layer2_layer2_lldvalue);				

				var layer2_layer1_ldcost_per_tube = 	(layer2_layer1_ldvalue / parseInt($('#layer2_quantity').val()));	
				var layer2_layer1_lldcost_per_tube = 	(layer2_layer1_lldvalue / parseInt($('#layer2_quantity').val()));
				var layer2_layer1_hdcost_per_tube = 	(layer2_layer1_hdvalue / parseInt($('#layer2_quantity').val()));
				var layer2_layer1_mbcost_per_tube = 	(layer2_layer1_mbvalue / parseFloat($('#layer2_quantity').val()));
				var layer2_layer1_mb1cost_per_tube = 	(layer2_layer1_mb1value / parseFloat($('#layer2_quantity').val()));

				var layer2_layer2_ldcost_per_tube = 	(layer2_layer2_ldvalue / parseInt($('#layer2_quantity').val()));	
				var layer2_layer2_lldcost_per_tube = 	(layer2_layer2_lldvalue / parseInt($('#layer2_quantity').val()));
				var layer2_layer2_hdcost_per_tube = 	(layer2_layer2_hdvalue / parseInt($('#layer2_quantity').val()));
				var layer2_layer2_mbcost_per_tube = 	(layer2_layer2_mbvalue / parseFloat($('#layer2_quantity').val()));
				var layer2_layer2_mb1cost_per_tube = 	(layer2_layer2_mb1value / parseFloat($('#layer2_quantity').val()));
				//alert(layer2_layer2_ldcost_per_tube);				
				//alert(layer2_layer2_lldcost_per_tube);	

				var layer2_sleeve_cost = (layer2_layer1_ldcost_per_tube + layer2_layer1_lldcost_per_tube + layer2_layer1_hdcost_per_tube + layer2_layer1_mbcost_per_tube + layer2_layer1_mb1cost_per_tube + layer2_layer2_ldcost_per_tube + layer2_layer2_lldcost_per_tube + layer2_layer2_hdcost_per_tube + layer2_layer2_mbcost_per_tube + layer2_layer2_mb1cost_per_tube);
				//alert(layer2_sleeve_cost);

				$('#layer2_sleeve_cost').val(layer2_sleeve_cost.toFixed(2));
				$('#sleeve_cost_view').val(layer2_sleeve_cost.toFixed(2));
				
			}
		});


//-------------------------------------LAYER 3 RM -----------------------
		$("#layer3_layer1_sl_ldpe").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer3_layer1_sl_ldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer3_layer1_ldpe_rate").val(html);

		   	 } 
		    	});
  		 });

		$("#layer3_layer1_sl_lldpe").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer3_layer1_sl_lldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer3_layer1_lldpe_rate").val(html);

		   	 } 
		    	});
  		 });	

		$("#layer3_layer1_sl_hdpe").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer3_layer1_sl_hdpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer3_layer1_hdpe_rate").val(html);

		   	 } 
		    	});
  		 });

		$("#layer3_layer2_sl_hdpe").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer3_layer2_sl_hdpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer3_layer2_hdpe_rate").val(html);

		   	 } 
		    	});
  		 });

		$("#layer3_layer3_sl_ldpe").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer3_layer3_sl_ldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer3_layer3_ldpe_rate").val(html);

		   	 } 
		    	});
  		 });

		$("#layer3_layer3_sl_lldpe").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer3_layer3_sl_lldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer3_layer3_lldpe_rate").val(html);

		   	 } 
		    	});
  		 });	

		$("#layer3_layer3_sl_hdpe").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer3_layer3_sl_hdpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer3_layer3_hdpe_rate").val(html);

		   	 } 
		    	});
  		 });

		$("#layer3_layer_1_rm_4_code").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer3_layer_1_rm_4_code').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer3_layer_1_rm_4_rate").val(html);

		   	 } 
		    	});
  		 });

		$("#layer3_layer_3_rm_10_code").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer3_layer_3_rm_10_code').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer3_layer_3_rm_10_rate").val(html);

		   	 } 
		    	});
  		 });

		//--------layer 3 check button-----------
		$("#layer3_sleevecost").live('click',function() {

			if($('#sleeve_dia').val()=="" || $('#sleeve_length').val()==""){
				alert("Please enter the Diameter,Length");
			}else if($('#layer3_layer1_micron').val()=="" || $('#layer3_layer1_ld_percentage').val()=="" || $('#layer3_layer1_lld_percentage').val()=="" || $('#layer3_layer1_hd_percentage').val()=="" ){
				alert("Please Enter Layer1 Micron , % ");		
			}else if(parseInt($('#layer3_layer1_ld_percentage').val())!== 0 && $('#layer3_layer1_sl_ldpe').val()==""  || parseInt($('#layer3_layer1_lld_percentage').val())!== 0 && $('#layer3_layer1_sl_lldpe').val()=="" ){
				alert("Please Select Layer1 RM ");
			}else if(parseInt($('#layer3_layer1_hd_percentage').val())!== 0 && $('#layer3_layer1_sl_hdpe').val()==""  || parseInt($('#layer3_layer1_lld_percentage').val())!== 0 && $('#layer3_layer1_sl_lldpe').val()=="" ){
				alert("Please Select Layer1 RM ");	
			}else if(parseInt($("#layer3_layer1_ld_percentage").val()) + parseInt($("#layer3_layer1_lld_percentage").val()) + parseInt($("#layer3_layer1_hd_percentage").val())!== 100 ){
				alert(" % of LD , LLD and HD should be 100");							
			}else if($('#layer3_layer_1_rm_4_code').val()=="" && $('#layer3_layer_1_rm_5_code').val()==""){
				alert("Please Enter MB ");

			// }else if($('#layer3_layer_1_rm_4_code').val()!="" && (parseFloat($('#layer3_layer_1_rm_4_rate').val())== "" || parseFloat($('#layer3_layer_1_rm_4_percentage').val())==0)){
			// alert("Please correct MB Deatils ");
			}else if($('#layer3_layer_1_rm_4_code').val()!="" && $('#layer3_layer_1_rm_4_rate').val()>0  && $('#layer3_layer_1_rm_4_percentage').val()==0){
			alert("Please correct MB  % Deatils ");

			}else if($('#layer3_layer_1_rm_5_code').val()!="" && ($('#layer3_layer_1_rm_5_rate').val()==""  ||  $('#layer3_layer_1_rm_5_percentage').val()=="")){
			alert("Please correct MB Rate & % Deatils ");
			}else if($('#layer3_layer_1_rm_5_code').val()!="" && $('#layer3_layer_1_rm_5_rate').val()>0  && $('#layer3_layer_1_rm_5_percentage').val()==0){
			alert("Please correct MB  % Deatils ");
			}else if($('#layer3_layer2_micron').val()=="" || $('#layer3_layer2_sl_hdpe').val()==""  ){
				alert("Please Select Layer2 RM ");	

			//------------------layer 3 validation	
			}else if($('#layer3_layer3_micron').val()=="" || $('#layer3_layer3_ld_percentage').val()=="" || $('#layer3_layer3_lld_percentage').val()=="" || $('#layer3_layer3_hd_percentage').val()=="" ){
				alert("Please Enter Layer3 Micron , % ");		
			}else if(parseInt($('#layer3_layer3_ld_percentage').val())!== 0 && $('#layer3_layer3_sl_ldpe').val()==""  || parseInt($('#layer3_layer3_lld_percentage').val())!== 0 && $('#layer3_layer3_sl_lldpe').val()=="" ){
				alert("Please Select Layer3 RM ");
			}else if(parseInt($('#layer3_layer3_hd_percentage').val())!== 0 && $('#layer3_layer3_sl_hdpe').val()==""  || parseInt($('#layer3_layer3_lld_percentage').val())!== 0 && $('#layer3_layer3_sl_lldpe').val()=="" ){
				alert("Please Select Layer3 RM ");	
			}else if(parseInt($("#layer3_layer3_ld_percentage").val()) + parseInt($("#layer3_layer3_lld_percentage").val()) + parseInt($("#layer3_layer3_hd_percentage").val())!== 100 ){
				alert(" % of LD , LLD and HD should be 100");							
			}else if($('#layer3_layer_3_rm_10_code').val()=="" && $('#layer3_layer_3_rm_11_code').val()==""){
				alert("Please Enter MB ");
			// }else if($('#layer3_layer_3_rm_10_code').val()!="" && (parseFloat($('#layer3_layer_3_rm_10_rate').val())== "" || parseFloat($('#layer3_layer_3_rm_10_percentage').val())==0)){
			// alert("Please correct MB Deatils ");
			}else if($('#layer3_layer_3_rm_10_code').val()!="" && $('#layer3_layer_3_rm_10_rate').val()>0  && $('#layer3_layer_3_rm_10_percentage').val()==0){
			alert("Please correct MB  % Deatils ");

			}else if($('#layer3_layer_3_rm_11_code').val()!="" && ($('#layer3_layer_3_rm_11_rate').val()==""  ||  $('#layer3_layer_3_rm_11_percentage').val()=="")){
			alert("Please correct MB Rate & % Deatils ");
			}else if($('#layer3_layer_3_rm_11_code').val()!="" && $('#layer3_layer_3_rm_11_rate').val()>0  && $('#layer3_layer_3_rm_11_percentage').val()==0){
			alert("Please correct MB  % Deatils ");	
			}else if($('#layer3_rejection').val()=="" && $('#layer3_rejection').val()==0){
			alert("Please enter Rejection  % Deatils ");
			
			}else{
				var check = parseInt($("#layer3_layer1_ld_percentage").val()) + parseInt($("#layer3_layer1_lld_percentage").val()) +  parseInt($("#layer3_layer1_hd_percentage").val()) ;
				//alert(check);

				
				var layer3_layer1_sleeveweight= (((parseFloat($('#sleeve_dia').val()) * parseFloat($('#sleeve_length').val()) * parseFloat($('#layer3_layer1_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseFloat($('#layer3_quantity').val())) ;
				layer3_layer1_sleeveweight=layer3_layer1_sleeveweight+layer3_layer1_sleeveweight*(parseFloat($('#layer3_rejection').val())/100);

				var layer3_layer2_sleeveweight= (((parseFloat($('#sleeve_dia').val()) * parseFloat($('#sleeve_length').val()) * parseFloat($('#layer3_layer2_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseFloat($('#layer3_quantity').val()));

				layer3_layer2_sleeveweight=layer3_layer2_sleeveweight+layer3_layer2_sleeveweight*(parseFloat($('#layer3_rejection').val())/100);

				var layer3_layer3_sleeveweight= (((parseFloat($('#sleeve_dia').val()) * parseFloat($('#sleeve_length').val()) * parseFloat($('#layer3_layer3_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseFloat($('#layer3_quantity').val())) ;

				layer3_layer3_sleeveweight=layer3_layer3_sleeveweight+layer3_layer3_sleeveweight*(parseFloat($('#layer3_rejection').val())/100);
				//alert(layer3_layer1_sleeveweight);
				//alert(layer3_layer3_sleeveweight);

				var layer3_layer1_ldweight = (layer3_layer1_sleeveweight * parseFloat($('#layer3_layer1_ld_percentage').val())) / 100 ;
				var layer3_layer1_lldweight =(layer3_layer1_sleeveweight * parseFloat($('#layer3_layer1_lld_percentage').val())) / 100 ;
				var layer3_layer1_hdweight = (layer3_layer1_sleeveweight * parseFloat($('#layer3_layer1_hd_percentage').val())) / 100 ;
				var layer3_layer1_mbweight = (layer3_layer1_sleeveweight * parseInt($('#layer3_layer_1_rm_4_percentage').val())) / 100 ;
				var layer3_layer1_mb1weight = (layer3_layer1_sleeveweight * parseInt($('#layer3_layer_1_rm_5_percentage').val())) / 100 ;
				//alert(layer3_layer1_mbweight);
				//alert(layer3_layer1_mb1weight);

				var layer3_layer2_hdweight = (layer3_layer2_sleeveweight * parseFloat($('#layer3_layer2_hd_percentage').val())) / 100 ;

				var layer3_layer3_ldweight = (layer3_layer3_sleeveweight * parseFloat($('#layer3_layer3_ld_percentage').val())) / 100 ;
				var layer3_layer3_lldweight = (layer3_layer3_sleeveweight * parseFloat($('#layer3_layer3_lld_percentage').val())) / 100 ;
				var layer3_layer3_hdweight = (layer3_layer3_sleeveweight * parseFloat($('#layer3_layer3_hd_percentage').val())) / 100 ;
				var layer3_layer3_mbweight = (layer3_layer3_sleeveweight * parseInt($('#layer3_layer_3_rm_10_percentage').val())) / 100 ;
				var layer3_layer3_mb1weight = (layer3_layer3_sleeveweight * parseInt($('#layer3_layer_3_rm_11_percentage').val())) / 100 ;
				//alert(layer3_layer3_mb1weight);
				

				var layer3_layer1_ldvalue = ($("#layer3_layer1_ldpe_rate").val()* layer3_layer1_ldweight) ;
				var layer3_layer1_lldvalue = ($("#layer3_layer1_lldpe_rate").val()* layer3_layer1_lldweight) ;
				var layer3_layer1_hdvalue = ($("#layer3_layer1_hdpe_rate").val()* layer3_layer1_hdweight) ;
				var layer3_layer1_mbvalue = ($("#layer3_layer_1_rm_4_rate").val()* layer3_layer1_mbweight) ;
				var layer3_layer1_mb1value = ($("#layer3_layer_1_rm_5_rate").val()* layer3_layer1_mb1weight);

				var layer3_layer2_hdvalue = ($("#layer3_layer2_hdpe_rate").val()* layer3_layer2_hdweight) ;

				var layer3_layer3_ldvalue = ($("#layer3_layer3_ldpe_rate").val()* layer3_layer3_ldweight) ;
				var layer3_layer3_lldvalue = ($("#layer3_layer3_lldpe_rate").val()* layer3_layer3_lldweight) ;
				var layer3_layer3_hdvalue = ($("#layer3_layer3_hdpe_rate").val()* layer3_layer3_hdweight) ;
				var layer3_layer3_mbvalue = ($("#layer3_layer_3_rm_10_rate").val()* layer3_layer3_mbweight) ;
				var layer3_layer3_mb1value = ($("#layer3_layer_3_rm_11_rate").val()* layer3_layer3_mb1weight);
				//alert(layer3_layer2_hdvalue);				

				var layer3_layer1_ldcost_per_tube = 	(layer3_layer1_ldvalue / parseInt($('#layer3_quantity').val()));	
				var layer3_layer1_lldcost_per_tube = 	(layer3_layer1_lldvalue / parseInt($('#layer3_quantity').val()));
				var layer3_layer1_hdcost_per_tube = 	(layer3_layer1_hdvalue / parseInt($('#layer3_quantity').val()));
				var layer3_layer1_mbcost_per_tube = 	(layer3_layer1_mbvalue / parseFloat($('#layer3_quantity').val()));
				var layer3_layer1_mb1cost_per_tube = 	(layer3_layer1_mb1value / parseFloat($('#layer3_quantity').val()));

				var layer3_layer2_hdcost_per_tube = 	(layer3_layer2_hdvalue / parseInt($('#layer3_quantity').val()));

				var layer3_layer3_ldcost_per_tube = 	(layer3_layer3_ldvalue / parseInt($('#layer3_quantity').val()));	
				var layer3_layer3_lldcost_per_tube = 	(layer3_layer3_lldvalue / parseInt($('#layer3_quantity').val()));
				var layer3_layer3_hdcost_per_tube = 	(layer3_layer3_hdvalue / parseInt($('#layer3_quantity').val()));
				var layer3_layer3_mbcost_per_tube = 	(layer3_layer3_mbvalue / parseFloat($('#layer3_quantity').val()));
				var layer3_layer3_mb1cost_per_tube = 	(layer3_layer3_mb1value / parseFloat($('#layer3_quantity').val()));
				//alert(layer3_layer2_hdcost_per_tube);	

				var layer3_sleeve_cost = (layer3_layer1_ldcost_per_tube + layer3_layer1_lldcost_per_tube + layer3_layer1_hdcost_per_tube + layer3_layer1_mbcost_per_tube + layer3_layer1_mb1cost_per_tube + layer3_layer2_hdcost_per_tube + layer3_layer3_ldcost_per_tube + layer3_layer3_lldcost_per_tube + layer3_layer3_hdcost_per_tube + layer3_layer3_mbcost_per_tube + layer3_layer3_mb1cost_per_tube );
				//alert(layer3_sleeve_cost);

				$('#layer3_sleeve_cost').val(layer3_sleeve_cost.toFixed(2));
				$('#sleeve_cost_view').val(layer3_sleeve_cost.toFixed(2));
			}
		});

//-------------------------------------LAYER 5 RM -----------------------
		$("#layer5_layer1_sl_ldpe").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer5_layer1_sl_ldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer5_layer1_ldpe_rate").val(html);

		   	 } 
		    	});
  		 });
		$("#layer5_layer1_sl_lldpe").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer5_layer1_sl_lldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer5_layer1_lldpe_rate").val(html);

		   	 } 
		    	});
  		 });	

		$("#layer5_layer1_sl_hdpe").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer5_layer1_sl_hdpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer5_layer1_hdpe_rate").val(html);

		   	 } 
		    	});
  		 });

		$("#layer5_layer2_admer").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer5_layer2_admer').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer5_layer2_admer_rate").val(html);

		   	 } 
		    	});
  		 });

		$("#layer5_layer3_evoh").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer5_layer3_evoh').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer5_layer3_evoh_rate").val(html);

		   	 } 
		    	});
  		 });

		$("#layer5_layer4_admer").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer5_layer4_admer').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer5_layer4_admer_rate").val(html);

		   	 } 
		    	});
  		 });

		$("#layer5_layer5_sl_ldpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer5_layer5_sl_ldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer5_layer5_ldpe_rate").val(html);

		   	 } 
		    	});
  		 });

		$("#layer5_layer5_sl_lldpe").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer5_layer5_sl_lldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer5_layer5_lldpe_rate").val(html);

		   	 } 
		    	});
  		 });

		$("#layer5_layer5_sl_hdpe").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer5_layer5_sl_hdpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer5_layer5_hdpe_rate").val(html);

		   	 } 
		    	});
  		 });

		$("#layer5_layer_1_rm_4_code").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer5_layer_1_rm_4_code').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer5_layer_1_rm_4_rate").val(html);

		   	 } 
		    	});
  		 });

		$("#layer5_layer_5_rm_12_code").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer5_layer_5_rm_12_code').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer5_layer_5_rm_12_rate").val(html);

		   	 } 
		    	});
  		 });

		//--------layer 5 check button-----------
		$("#layer5_sleevecost").live('click',function() {

			if($('#sleeve_dia').val()=="" || $('#sleeve_length').val()==""){
				alert("Please enter the Diameter,Length");
			}else if($('#layer5_layer1_micron').val()=="" || $('#layer5_layer1_ld_percentage').val()=="" || $('#layer5_layer1_lld_percentage').val()=="" || $('#layer5_layer1_hd_percentage').val()=="" ){
				alert("Please Enter Layer1 Micron , % ");		
			}else if(parseInt($('#layer5_layer1_ld_percentage').val())!== 0 && $('#layer5_layer1_sl_ldpe').val()==""  || parseInt($('#layer5_layer1_lld_percentage').val())!== 0 && $('#layer5_layer1_sl_lldpe').val()=="" ){
				alert("Please Select Layer1 RM ");
			}else if(parseInt($('#layer5_layer1_hd_percentage').val())!== 0 && $('#layer5_layer1_sl_hdpe').val()==""  || parseInt($('#layer5_layer1_lld_percentage').val())!== 0 && $('#layer5_layer1_sl_lldpe').val()=="" ){
				alert("Please Select Layer1 RM ");	
			}else if(parseInt($("#layer5_layer1_ld_percentage").val()) + parseInt($("#layer5_layer1_lld_percentage").val()) + parseInt($("#layer5_layer1_hd_percentage").val())!== 100 ){
				alert(" % of LD , LLD and HD should be 100");							
			}else if($('#layer5_layer_1_rm_4_code').val()=="" && $('#layer5_layer_1_rm_5_code').val()==""){
				alert("Please Enter MB ");
			// }else if($('#layer5_layer_1_rm_4_code').val()!="" && (parseFloat($('#layer5_layer_1_rm_4_rate').val())== "" || parseFloat($('#layer5_layer_1_rm_4_percentage').val())==0)){
			// alert("Please correct MB Deatils ");
			}else if($('#layer5_layer_1_rm_4_code').val()!="" && $('#layer5_layer_1_rm_4_rate').val()>0  && $('#layer5_layer_1_rm_4_percentage').val()==0){
			alert("Please correct MB  % Deatils ");

			}else if($('#layer5_layer_1_rm_5_code').val()!="" && ($('#layer5_layer_1_rm_5_rate').val()==""  ||  $('#layer5_layer_1_rm_5_percentage').val()=="")){
			alert("Please correct MB Rate & % Deatils ");
			}else if($('#layer5_layer_1_rm_5_code').val()!="" && $('#layer5_layer_1_rm_5_rate').val()>0  && $('#layer5_layer_1_rm_5_percentage').val()==0){
			alert("Please correct MB  % Deatils ");	
			//-------------Layer 2,3,4validation
			}else if($('#layer5_layer2_micron').val()=="" || $('#layer5_layer2_admer').val()==""  ){
				alert("Please Select Layer2 RM ");	
			}else if($('#layer5_layer3_micron').val()=="" || $('#layer5_layer3_evoh').val()==""  ){
				alert("Please Select Layer3 RM ");
			}else if($('#layer5_layer4_micron').val()=="" || $('#layer5_layer4_admer').val()==""  ){
				alert("Please Select Layer4 RM ");	
			//-------------Layer 5 validation		
			}else if($('#layer5_layer5_micron').val()=="" || $('#layer5_layer5_ld_percentage').val()=="" || $('#layer5_layer5_lld_percentage').val()=="" || $('#layer5_layer5_hd_percentage').val()=="" ){
				alert("Please Enter Layer5 Micron , % ");		
			}else if(parseInt($('#layer5_layer5_ld_percentage').val())!== 0 && $('#layer5_layer5_sl_ldpe').val()==""  || parseInt($('#layer5_layer5_lld_percentage').val())!== 0 && $('#layer5_layer5_sl_lldpe').val()=="" ){
				alert("Please Select Layer5 RM ");
			}else if(parseInt($('#layer5_layer5_hd_percentage').val())!== 0 && $('#layer5_layer5_sl_hdpe').val()==""  || parseInt($('#layer5_layer5_lld_percentage').val())!== 0 && $('#layer5_layer5_sl_lldpe').val()=="" ){
				alert("Please Select Layer5 RM ");	
			}else if(parseInt($("#layer5_layer5_ld_percentage").val()) + parseInt($("#layer5_layer5_lld_percentage").val()) + parseInt($("#layer5_layer5_hd_percentage").val())!== 100 ){
				alert(" % of LD , LLD and HD should be 100");							
			}else if($('#layer5_layer_5_rm_12_code').val()=="" && $('#layer5_layer_5_rm_13_code').val()==""){
				alert("Please Enter MB ");
			// }else if($('#layer5_layer_5_rm_12_code').val()!="" && (parseFloat($('#layer5_layer_5_rm_12_rate').val())== "" || parseFloat($('#layer5_layer_5_rm_12_percentage').val())==0)){
			// alert("Please correct MB Deatils ");
			}else if($('#layer5_layer_5_rm_12_code').val()!="" && $('#layer5_layer_5_rm_12_rate').val()>0  && $('#layer5_layer_5_rm_12_percentage').val()==0){
			alert("Please correct MB  % Deatils ");
			}else if($('#layer5_layer_5_rm_13_code').val()!="" && ($('#layer5_layer_5_rm_13_rate').val()==""  ||  $('#layer5_layer_5_rm_13_percentage').val()=="")){
			alert("Please correct MB Rate & % Deatils ");
			}else if($('#layer5_layer_5_rm_13_code').val()!="" && $('#layer5_layer_5_rm_13_rate').val()>0  && $('#layer5_layer_5_rm_13_percentage').val()==0){
			alert("Please correct MB  % Deatils ");		
			}else if($('#layer5_rejection').val()=="" && $('#layer5_rejection').val()==0){
			alert("Please enter Rejection  % Deatils ");
			
			}else{
				var check = parseInt($("#layer3_layer1_ld_percentage").val()) + parseInt($("#layer3_layer1_lld_percentage").val()) +  parseInt($("#layer3_layer1_hd_percentage").val()) ;
				//alert(check);

				var layer5_layer1_sleeveweight= (((parseFloat($('#sleeve_dia').val()) * parseFloat($('#sleeve_length').val()) * parseFloat($('#layer5_layer1_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseFloat($('#layer5_quantity').val())) ;

				layer5_layer1_sleeveweight=layer5_layer1_sleeveweight+layer5_layer1_sleeveweight*(parseFloat($('#layer5_rejection').val())/100);

				var layer5_layer2_sleeveweight= (((parseFloat($('#sleeve_dia').val()) * parseFloat($('#sleeve_length').val()) * parseFloat($('#layer5_layer2_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseFloat($('#layer5_quantity').val())) ;

				layer5_layer2_sleeveweight=layer5_layer2_sleeveweight+layer5_layer2_sleeveweight*(parseFloat($('#layer5_rejection').val())/100);

				var layer5_layer3_sleeveweight= (((parseFloat($('#sleeve_dia').val()) * parseFloat($('#sleeve_length').val()) * parseFloat($('#layer5_layer3_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseFloat($('#layer5_quantity').val())) ;
				layer5_layer3_sleeveweight=layer5_layer3_sleeveweight+layer5_layer3_sleeveweight*(parseFloat($('#layer5_rejection').val())/100);

				var layer5_layer4_sleeveweight= (((parseFloat($('#sleeve_dia').val()) * parseFloat($('#sleeve_length').val()) * parseFloat($('#layer5_layer4_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseFloat($('#layer5_quantity').val())) ;
				layer5_layer4_sleeveweight=layer5_layer4_sleeveweight+layer5_layer4_sleeveweight*(parseFloat($('#layer5_rejection').val())/100);

				var layer5_layer5_sleeveweight= (((parseFloat($('#sleeve_dia').val()) * parseFloat($('#sleeve_length').val()) * parseFloat($('#layer5_layer5_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseFloat($('#layer5_quantity').val())) ;

				layer5_layer5_sleeveweight=layer5_layer5_sleeveweight+layer5_layer5_sleeveweight*(parseFloat($('#layer5_rejection').val())/100);
	
				//alert(layer5_layer4_sleeveweight);

				var layer5_layer1_ldweight = (layer5_layer1_sleeveweight * parseFloat($('#layer5_layer1_ld_percentage').val())) / 100 ;
				var layer5_layer1_lldweight =(layer5_layer1_sleeveweight * parseFloat($('#layer5_layer1_lld_percentage').val())) / 100 ;
				var layer5_layer1_hdweight = (layer5_layer1_sleeveweight * parseFloat($('#layer5_layer1_hd_percentage').val())) / 100 ;
				var layer5_layer1_mbweight = (layer5_layer1_sleeveweight * parseFloat($('#layer5_layer_1_rm_4_percentage').val())) / 100 ;
				var layer5_layer1_mb1weight = (layer5_layer1_sleeveweight * parseFloat($('#layer5_layer_1_rm_5_percentage').val())) / 100 ;
				
				var layer5_layer2_admerweight =(layer5_layer2_sleeveweight * parseFloat($('#layer5_layer2_admer_percentage').val())) /100 ;

				var layer5_layer3_evohweight = (layer5_layer3_sleeveweight * parseFloat($('#layer5_layer3_evoh_percentage').val())) / 100 ;

				var layer5_layer4_admerweight =(layer5_layer4_sleeveweight * parseFloat($('#layer5_layer4_admer_percentage').val())) /100 ;
				
				var layer5_layer5_ldweight = (layer5_layer5_sleeveweight * parseFloat($('#layer5_layer5_ld_percentage').val())) / 100 ;
				var layer5_layer5_lldweight =(layer5_layer5_sleeveweight * parseFloat($('#layer5_layer5_lld_percentage').val())) / 100 ;
				var layer5_layer5_hdweight = (layer5_layer5_sleeveweight * parseFloat($('#layer5_layer5_hd_percentage').val())) / 100 ;
				var layer5_layer5_mbweight = (layer5_layer5_sleeveweight * parseFloat($('#layer5_layer_5_rm_12_percentage').val())) / 100 ;
				var layer5_layer5_mb1weight = (layer5_layer5_sleeveweight * parseFloat($('#layer5_layer_5_rm_13_percentage').val())) /100 ;
				//alert(layer5_layer5_ldweight);

				var layer5_layer1_ldvalue = ($("#layer5_layer1_ldpe_rate").val()* layer5_layer1_ldweight) ;
				var layer5_layer1_lldvalue =($("#layer5_layer1_lldpe_rate").val()* layer5_layer1_lldweight) ;
				var layer5_layer1_hdvalue = ($("#layer5_layer1_hdpe_rate").val()* layer5_layer1_hdweight) ;	
				var layer5_layer1_mbvalue = ($("#layer5_layer_1_rm_4_rate").val()* layer5_layer1_mbweight) ;
				var layer5_layer1_mb1value = ($("#layer5_layer_1_rm_5_rate").val()* layer5_layer1_mb1weight);

				var layer5_layer2_admervalue = ($("#layer5_layer2_admer_rate").val()* layer5_layer2_admerweight) ;
				var layer5_layer3_evohvalue = ($("#layer5_layer3_evoh_rate").val()* layer5_layer3_evohweight) ;
				var layer5_layer4_admervalue = ($("#layer5_layer4_admer_rate").val()* layer5_layer4_admerweight) ;

				var layer5_layer5_ldvalue = ($("#layer5_layer5_ldpe_rate").val()* layer5_layer5_ldweight) ;
				var layer5_layer5_lldvalue =($("#layer5_layer5_lldpe_rate").val()*layer5_layer5_lldweight) ;
				var layer5_layer5_hdvalue = ($("#layer5_layer5_hdpe_rate").val()* layer5_layer5_hdweight) ;
				var layer5_layer5_mbvalue = ($("#layer5_layer_5_rm_12_rate").val()* layer5_layer5_mbweight) ;
				var layer5_layer5_mb1value = ($("#layer5_layer_5_rm_13_rate").val()* layer5_layer5_mb1weight);
				//alert(layer5_layer5_lldvalue);			

				var layer5_layer1_ldcost_per_tube = 	(layer5_layer1_ldvalue / parseInt($('#layer5_quantity').val()));	
				var layer5_layer1_lldcost_per_tube =   (layer5_layer1_lldvalue /parseInt($('#layer5_quantity').val()));
				var layer5_layer1_hdcost_per_tube = 	(layer5_layer1_hdvalue / parseInt($('#layer5_quantity').val()));
				var layer5_layer1_mbcost_per_tube = 	(layer5_layer1_mbvalue / parseFloat($('#layer5_quantity').val()));
				var layer5_layer1_mb1cost_per_tube = 	(layer5_layer1_mb1value / parseFloat($('#layer5_quantity').val()));

				var layer5_layer2_admercost_per_tube = (layer5_layer2_admervalue / parseInt($('#layer5_quantity').val()));
				var layer5_layer3_evohcost_per_tube = (layer5_layer3_evohvalue / parseInt($('#layer5_quantity').val()));
				var layer5_layer4_admercost_per_tube = (layer5_layer4_admervalue / parseInt($('#layer5_quantity').val()));

				var layer5_layer5_ldcost_per_tube = 	(layer5_layer5_ldvalue / parseInt($('#layer5_quantity').val()));	
				var layer5_layer5_lldcost_per_tube = 	(layer5_layer5_lldvalue / parseInt($('#layer5_quantity').val()));
				var layer5_layer5_hdcost_per_tube = 	(layer5_layer5_hdvalue / parseInt($('#layer5_quantity').val()));
				var layer5_layer5_mbcost_per_tube = 	(layer5_layer5_mbvalue / parseFloat($('#layer5_quantity').val()));
				var layer5_layer5_mb1cost_per_tube = 	(layer5_layer5_mb1value / parseFloat($('#layer5_quantity').val()));
				//alert(layer5_layer5_lldcost_per_tube);	

				var layer5_sleeve_cost = (layer5_layer1_ldcost_per_tube + layer5_layer1_lldcost_per_tube + layer5_layer1_hdcost_per_tube + layer5_layer1_mbcost_per_tube + layer5_layer1_mb1cost_per_tube + layer5_layer2_admercost_per_tube + layer5_layer3_evohcost_per_tube + layer5_layer4_admercost_per_tube + layer5_layer5_ldcost_per_tube + layer5_layer5_lldcost_per_tube + layer5_layer5_hdcost_per_tube + layer5_layer5_mbcost_per_tube + layer5_layer5_mb1cost_per_tube );
				//alert(layer5_sleeve_cost);

				$('#layer5_sleeve_cost').val(layer5_sleeve_cost.toFixed(2));
				$('#sleeve_cost_view').val(layer5_sleeve_cost.toFixed(2));
				
			}
		});

//-------------------------------------LAYER 7 RM -----------------------
		$("#layer7_layer1_sl_ldpe").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer1_sl_ldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer1_ldpe_rate").val(html);

		   	 } 
		    	});
  		 });
		$("#layer7_layer1_sl_lldpe").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer1_sl_lldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer1_lldpe_rate").val(html);

		   	 } 
		    	});
  		 });	

		$("#layer7_layer1_sl_hdpe").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer1_sl_hdpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer1_hdpe_rate").val(html);

		   	 } 
		    	});
  		 });

		$("#layer7_layer2_sl_ldpe").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer2_sl_ldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer2_ldpe_rate").val(html);

		   	 } 
		    	});
  		 });
		$("#layer7_layer2_sl_lldpe").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer2_sl_lldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer2_lldpe_rate").val(html);

		   	 } 
		    	});
  		 });	

		$("#layer7_layer2_sl_hdpe").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer2_sl_hdpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer2_hdpe_rate").val(html);

		   	 } 
		    	});
  		 });

		$("#layer7_layer3_admer").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer3_admer').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer3_admer_rate").val(html);

		   	 } 
		    	});
  		 });

		$("#layer7_layer4_evoh").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer4_evoh').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer4_evoh_rate").val(html);

		   	 } 
		    	});
  		 });

		$("#layer7_layer5_admer").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer5_admer').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer5_admer_rate").val(html);

		   	 } 
		    	});
  		 });

		$("#layer7_layer6_sl_ldpe").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer6_sl_ldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer6_ldpe_rate").val(html);

		   	 } 
		    	});
  		 });
		$("#layer7_layer6_sl_lldpe").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer6_sl_lldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer6_lldpe_rate").val(html);

		   	 } 
		    	});
  		 });	

		$("#layer7_layer6_sl_hdpe").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer6_sl_hdpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer6_hdpe_rate").val(html);

		   	 } 
		    	});
  		 });

		$("#layer7_layer7_sl_ldpe").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer7_sl_ldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer7_ldpe_rate").val(html);

		   	 } 
		    	});
  		 });
		$("#layer7_layer7_sl_lldpe").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer7_sl_lldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer7_lldpe_rate").val(html);

		   	 } 
		    	});
  		 });	

		$("#layer7_layer7_sl_hdpe").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer7_sl_hdpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer7_hdpe_rate").val(html);

		   	 } 
		    	});
  		 });

		$("#layer7_layer_2_rm_7_code").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer_2_rm_7_code').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer_2_rm_7_rate").val(html);

		   	 } 
		    	});
  		 });

		$("#layer7_layer_6_rm_15_code").live('change',function() {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer_6_rm_15_code').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer_6_rm_15_rate").val(html);

		   	 } 
		    	});
  		 });


		//--------layer 7 check button-----------
		$("#layer7_sleevecost").live('click',function() {

			if($('#sleeve_dia').val()=="" || $('#sleeve_length').val()==""){
				alert("Please enter the Diameter,Length");
			}else if($('#layer7_layer1_micron').val()=="" || $('#layer7_layer1_ld_percentage').val()=="" || $('#layer7_layer1_lld_percentage').val()=="" || $('#layer7_layer1_hd_percentage').val()=="" ){
				alert("Please Enter Layer1 Micron , % ");		
			}else if(parseInt($('#layer7_layer1_ld_percentage').val())!== 0 && $('#layer7_layer1_sl_ldpe').val()==""  || parseInt($('#layer7_layer1_lld_percentage').val())!== 0 && $('#layer7_layer1_sl_lldpe').val()=="" ){
				alert("Please Select Layer1 RM ");
			}else if(parseInt($('#layer7_layer1_hd_percentage').val())!== 0 && $('#layer7_layer1_sl_hdpe').val()==""  || parseInt($('#layer7_layer1_lld_percentage').val())!== 0 && $('#layer7_layer1_sl_lldpe').val()=="" ){
				alert("Please Select Layer1 RM ");	
			}else if(parseInt($("#layer7_layer1_ld_percentage").val()) + parseInt($("#layer7_layer1_lld_percentage").val()) + parseInt($("#layer7_layer1_hd_percentage").val())!== 100 ){
				alert(" % of LD , LLD and HD should be 100");	
				//---------layer 2 validation
			}else if($('#layer7_layer2_micron').val()=="" || $('#layer7_layer2_ld_percentage').val()=="" || $('#layer7_layer2_lld_percentage').val()=="" || $('#layer7_layer2_hd_percentage').val()=="" ){
				alert("Please Enter Layer2 Micron , % ");		
			}else if(parseInt($('#layer7_layer2_ld_percentage').val())!== 0 && $('#layer7_layer2_sl_ldpe').val()==""  || parseInt($('#layer7_layer2_lld_percentage').val())!== 0 && $('#layer7_layer2_sl_lldpe').val()=="" ){
				alert("Please Select Layer2 RM ");
			}else if(parseInt($('#layer7_layer2_hd_percentage').val())!== 0 && $('#layer7_layer2_sl_hdpe').val()==""  || parseInt($('#layer7_layer2_lld_percentage').val())!== 0 && $('#layer7_layer2_sl_lldpe').val()=="" ){
				alert("Please Select Layer2 RM ");	
			}else if(parseInt($("#layer7_layer2_ld_percentage").val()) + parseInt($("#layer7_layer2_lld_percentage").val()) + parseInt($("#layer7_layer2_hd_percentage").val())!== 100 ){
				alert(" % of LD , LLD and HD should be 100");		
			}else if($('#layer7_layer_2_rm_7_code').val()=="" && $('#layer7_layer_2_rm_8_code').val()==""){
				alert("Please Enter MB ");
			// }else if($('#layer7_layer_2_rm_7_code').val()!="" && (parseFloat($('#layer7_layer_2_rm_7_rate').val())== "" || parseFloat($('#layer7_layer_2_rm_7_percentage').val())==0)){
			// alert("Please correct MB Deatils ");
			}else if($('#layer7_layer_2_rm_7_code').val()!="" && $('#layer7_layer_2_rm_7_rate').val()>0  && $('#layer7_layer_2_rm_7_percentage').val()==0){
			alert("Please correct MB  % Deatils ");
			}else if($('#layer7_layer_2_rm_8_code').val()!="" && ($('#layer7_layer_2_rm_8_rate').val()==""  ||  $('#layer7_layer_2_rm_8_percentage').val()=="")){
			alert("Please correct MB Rate & % Deatils ");
			}else if($('#layer7_layer_2_rm_8_code').val()!="" && $('#layer7_layer_2_rm_8_rate').val()>0  && $('#layer7_layer_2_rm_8_percentage').val()==0){
			alert("Please correct MB  % Deatils ");		
			//------------Layer 3,4,5 validation
			}else if($('#layer7_layer3_micron').val()=="" || $('#layer7_layer3_admer').val()==""  ){
				alert("Please Select Layer3 RM ");	
			}else if($('#layer7_layer4_micron').val()=="" || $('#layer7_layer4_evoh').val()==""  ){
				alert("Please Select Layer4 RM ");
			}else if($('#layer7_layer5_micron').val()=="" || $('#layer7_layer5_admer').val()==""  ){
				alert("Please Select Layer5 RM ");	
			//------------Layer 6 validation
			}else if($('#layer7_layer6_micron').val()=="" || $('#layer7_layer6_ld_percentage').val()=="" || $('#layer7_layer6_lld_percentage').val()=="" || $('#layer7_layer6_hd_percentage').val()=="" ){
				alert("Please Enter Layer6 Micron , % ");		
			}else if(parseInt($('#layer7_layer6_ld_percentage').val())!== 0 && $('#layer7_layer6_sl_ldpe').val()==""  || parseInt($('#layer7_layer6_lld_percentage').val())!== 0 && $('#layer7_layer6_sl_lldpe').val()=="" ){
				alert("Please Select Layer6 RM ");
			}else if(parseInt($('#layer7_layer6_hd_percentage').val())!== 0 && $('#layer7_layer6_sl_hdpe').val()==""  || parseInt($('#layer7_layer6_lld_percentage').val())!== 0 && $('#layer7_layer6_sl_lldpe').val()=="" ){
				alert("Please Select Layer6 RM ");	
			}else if(parseInt($("#layer7_layer6_ld_percentage").val()) + parseInt($("#layer7_layer6_lld_percentage").val()) + parseInt($("#layer7_layer6_hd_percentage").val())!== 100 ){
				alert(" % of LD , LLD and HD should be 100");		
			}else if($('#layer7_layer_6_rm_15_code').val()=="" && $('#layer7_layer_6_rm_16_code').val()==""){
				alert("Please Enter MB ");
			// }else if($('#layer7_layer_6_rm_15_code').val()!="" && (parseFloat($('#layer7_layer_6_rm_15_rate').val())== "" || parseFloat($('#layer7_layer_6_rm_15_percentage').val())==0)){
			// alert("Please correct MB Deatils ");
			}else if($('#layer7_layer_6_rm_15_code').val()!="" && $('#layer7_layer_6_rm_15_rate').val()>0  && $('#layer7_layer_6_rm_15_percentage').val()==0){
			alert("Please correct MB  % Deatils ");
			}else if($('#layer7_layer_6_rm_16_code').val()!="" && ($('#layer7_layer_6_rm_16_rate').val()==""  ||  $('#layer7_layer_6_rm_16_percentage').val()=="")){
			alert("Please correct MB Rate & % Deatils ");
			}else if($('#layer7_layer_6_rm_16_code').val()!="" && $('#layer7_layer_6_rm_16_rate').val()>0  && $('#layer7_layer_6_rm_16_percentage').val()==0){
			alert("Please correct MB  % Deatils ");	
			//------------Layer 7 validation
			}else if($('#layer7_layer7_micron').val()=="" || $('#layer7_layer7_ld_percentage').val()=="" || $('#layer7_layer7_lld_percentage').val()=="" || $('#layer7_layer7_hd_percentage').val()=="" ){
				alert("Please Enter Layer7 Micron , % ");		
			}else if(parseInt($('#layer7_layer7_ld_percentage').val())!== 0 && $('#layer7_layer7_sl_ldpe').val()==""  || parseInt($('#layer7_layer7_lld_percentage').val())!== 0 && $('#layer7_layer7_sl_lldpe').val()=="" ){
				alert("Please Select Layer7 RM ");
			}else if(parseInt($('#layer7_layer7_hd_percentage').val())!== 0 && $('#layer7_layer7_sl_hdpe').val()==""  || parseInt($('#layer7_layer7_lld_percentage').val())!== 0 && $('#layer7_layer7_sl_lldpe').val()=="" ){
				alert("Please Select Layer7 RM ");	
			}else if(parseInt($("#layer7_layer7_ld_percentage").val()) + parseInt($("#layer7_layer7_lld_percentage").val()) + parseInt($("#layer7_layer7_hd_percentage").val())!== 100 ){
				alert(" % of LD , LLD and HD should be 100");
			}else if($('#layer7_rejection').val()=="" && $('#layer7_rejection').val()==0){
				alert("Please enter Rejection  % Deatils ");	
			}else{
				var check = parseInt($("#layer3_layer1_ld_percentage").val()) + parseInt($("#layer3_layer1_lld_percentage").val()) +  parseInt($("#layer3_layer1_hd_percentage").val()) ;
				//alert(check);

				var layer7_layer1_sleeveweight= (((parseFloat($('#sleeve_dia').val()) * parseFloat($('#sleeve_length').val()) * parseFloat($('#layer7_layer1_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseFloat($('#layer7_quantity').val())) ;

				layer7_layer1_sleeveweight=layer7_layer1_sleeveweight+layer7_layer1_sleeveweight*(parseFloat($('#layer7_rejection').val())/100);

				var layer7_layer2_sleeveweight= (((parseFloat($('#sleeve_dia').val()) * parseFloat($('#sleeve_length').val()) * parseFloat($('#layer7_layer2_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseFloat($('#layer7_quantity').val())) ;
				layer7_layer2_sleeveweight=layer7_layer2_sleeveweight+layer7_layer2_sleeveweight*(parseFloat($('#layer7_rejection').val())/100);

				var layer7_layer3_sleeveweight= (((parseFloat($('#sleeve_dia').val()) * parseFloat($('#sleeve_length').val()) * parseFloat($('#layer7_layer3_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseFloat($('#layer7_quantity').val())) ;
				layer7_layer3_sleeveweight=layer7_layer3_sleeveweight+layer7_layer3_sleeveweight*(parseFloat($('#layer7_rejection').val())/100);
			
				var layer7_layer4_sleeveweight= (((parseFloat($('#sleeve_dia').val()) * parseFloat($('#sleeve_length').val()) * parseFloat($('#layer7_layer4_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseFloat($('#layer7_quantity').val())) ;
				layer7_layer4_sleeveweight=layer7_layer4_sleeveweight+layer7_layer4_sleeveweight*(parseFloat($('#layer7_rejection').val())/100);

				var layer7_layer5_sleeveweight= (((parseFloat($('#sleeve_dia').val()) * parseFloat($('#sleeve_length').val()) * parseFloat($('#layer7_layer5_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseFloat($('#layer7_quantity').val())) ;	
				layer7_layer5_sleeveweight=layer7_layer5_sleeveweight+layer7_layer5_sleeveweight*(parseFloat($('#layer7_rejection').val())/100);

				var layer7_layer6_sleeveweight= (((parseFloat($('#sleeve_dia').val()) * parseFloat($('#sleeve_length').val()) * parseFloat($('#layer7_layer6_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseFloat($('#layer7_quantity').val())) ;
				layer7_layer6_sleeveweight=layer7_layer6_sleeveweight+layer7_layer6_sleeveweight*(parseFloat($('#layer7_rejection').val())/100);

				var layer7_layer7_sleeveweight= (((parseFloat($('#sleeve_dia').val()) * parseFloat($('#sleeve_length').val()) * parseFloat($('#layer7_layer7_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseFloat($('#layer7_quantity').val())) ;
				layer7_layer7_sleeveweight=layer7_layer7_sleeveweight+layer7_layer7_sleeveweight*(parseFloat($('#layer7_rejection').val())/100);

				//alert(layer7_layer7_sleeveweight);

				var layer7_layer1_ldweight = (layer7_layer1_sleeveweight * parseFloat($('#layer7_layer1_ld_percentage').val())) / 100 ;
				var layer7_layer1_lldweight =(layer7_layer1_sleeveweight * parseFloat($('#layer7_layer1_lld_percentage').val())) / 100 ;
				var layer7_layer1_hdweight = (layer7_layer1_sleeveweight * parseFloat($('#layer7_layer1_hd_percentage').val())) / 100 ;

				var layer7_layer2_ldweight = (layer7_layer2_sleeveweight * parseFloat($('#layer7_layer2_ld_percentage').val())) / 100 ;
				var layer7_layer2_lldweight =(layer7_layer2_sleeveweight * parseFloat($('#layer7_layer2_lld_percentage').val())) / 100 ;
				var layer7_layer2_hdweight = (layer7_layer2_sleeveweight * parseFloat($('#layer7_layer2_hd_percentage').val())) / 100 ;
				var layer7_layer2_mbweight = (layer7_layer2_sleeveweight * parseFloat($('#layer7_layer_2_rm_7_percentage').val())) / 100 ;
				var layer7_layer2_mb1weight = (layer7_layer2_sleeveweight * parseFloat($('#layer7_layer_2_rm_8_percentage').val())) / 100 ;
			
				var layer7_layer3_admerweight =(layer7_layer3_sleeveweight * parseFloat($('#layer7_layer3_admer_percentage').val())) /100 ;

				var layer7_layer4_evohweight = (layer7_layer4_sleeveweight * parseFloat($('#layer7_layer4_evoh_percentage').val())) / 100 ;

				var layer7_layer5_admerweight =(layer7_layer5_sleeveweight * parseFloat($('#layer7_layer5_admer_percentage').val())) /100 ;
				
				var layer7_layer6_ldweight = (layer7_layer6_sleeveweight * parseFloat($('#layer7_layer6_ld_percentage').val())) / 100 ;
				var layer7_layer6_lldweight =(layer7_layer6_sleeveweight * parseFloat($('#layer7_layer6_lld_percentage').val())) / 100 ;
				var layer7_layer6_hdweight = (layer7_layer6_sleeveweight * parseFloat($('#layer7_layer6_hd_percentage').val())) / 100 ;
				var layer7_layer6_mbweight = (layer7_layer6_sleeveweight * parseFloat($('#layer7_layer_6_rm_15_percentage').val())) / 100 ;
				var layer7_layer6_mb1weight = (layer7_layer6_sleeveweight * parseFloat($('#layer7_layer_6_rm_16_percentage').val())) /100 ;

				var layer7_layer7_ldweight = (layer7_layer7_sleeveweight * parseFloat($('#layer7_layer7_ld_percentage').val())) / 100 ;
				var layer7_layer7_lldweight =(layer7_layer7_sleeveweight * parseFloat($('#layer7_layer7_lld_percentage').val())) / 100 ;
				var layer7_layer7_hdweight = (layer7_layer7_sleeveweight * parseFloat($('#layer7_layer7_hd_percentage').val())) / 100 ;

				//alert(layer7_layer7_hdweight);	

				var layer7_layer1_ldvalue = ($("#layer7_layer1_ldpe_rate").val()* layer7_layer1_ldweight) ;
				var layer7_layer1_lldvalue =($("#layer7_layer1_lldpe_rate").val()* layer7_layer1_lldweight) ;
				var layer7_layer1_hdvalue = ($("#layer7_layer1_hdpe_rate").val()* layer7_layer1_hdweight) ;	

				var layer7_layer2_ldvalue = ($("#layer7_layer2_ldpe_rate").val()* layer7_layer2_ldweight) ;
				var layer7_layer2_lldvalue =($("#layer7_layer2_lldpe_rate").val()* layer7_layer2_lldweight) ;
				var layer7_layer2_hdvalue = ($("#layer7_layer2_hdpe_rate").val()* layer7_layer2_hdweight) ;	
				var layer7_layer2_mbvalue = ($("#layer7_layer_2_rm_7_rate").val()* layer7_layer2_mbweight) ;
				var layer7_layer2_mb1value = ($("#layer7_layer_2_rm_8_rate").val()* layer7_layer2_mb1weight);

				var layer7_layer3_admervalue = ($("#layer7_layer3_admer_rate").val()* layer7_layer3_admerweight) ;
				var layer7_layer4_evohvalue = ($("#layer7_layer4_evoh_rate").val()* layer7_layer4_evohweight) ;
				var layer7_layer5_admervalue = ($("#layer7_layer5_admer_rate").val()* layer7_layer5_admerweight) ;

				var layer7_layer6_ldvalue = ($("#layer7_layer6_ldpe_rate").val()* layer7_layer6_ldweight) ;
				var layer7_layer6_lldvalue =($("#layer7_layer6_lldpe_rate").val()*layer7_layer6_lldweight) ;
				var layer7_layer6_hdvalue = ($("#layer7_layer6_hdpe_rate").val()* layer7_layer6_hdweight) ;
				var layer7_layer6_mbvalue = ($("#layer7_layer_6_rm_15_rate").val()* layer7_layer6_mbweight) ;
				var layer7_layer6_mb1value = ($("#layer7_layer_6_rm_16_rate").val()* layer7_layer6_mb1weight);

				var layer7_layer7_ldvalue = ($("#layer7_layer7_ldpe_rate").val()* layer7_layer7_ldweight) ;
				var layer7_layer7_lldvalue =($("#layer7_layer7_lldpe_rate").val()*layer7_layer7_lldweight) ;
				var layer7_layer7_hdvalue = ($("#layer7_layer7_hdpe_rate").val()* layer7_layer7_hdweight) ;
						
				//alert(layer7_layer7_hdvalue);

				var layer7_layer1_ldcost_per_tube = 	(layer7_layer1_ldvalue / parseInt($('#layer7_quantity').val()));	
				var layer7_layer1_lldcost_per_tube =   (layer7_layer1_lldvalue /parseInt($('#layer7_quantity').val()));
				var layer7_layer1_hdcost_per_tube = 	(layer7_layer1_hdvalue / parseInt($('#layer7_quantity').val()));

				var layer7_layer2_ldcost_per_tube = 	(layer7_layer2_ldvalue / parseInt($('#layer7_quantity').val()));	
				var layer7_layer2_lldcost_per_tube =   (layer7_layer2_lldvalue /parseInt($('#layer7_quantity').val()));
				var layer7_layer2_hdcost_per_tube = 	(layer7_layer2_hdvalue / parseInt($('#layer7_quantity').val()));
				var layer7_layer2_mbcost_per_tube = 	(layer7_layer2_mbvalue / parseFloat($('#layer7_quantity').val()));
				var layer7_layer2_mb1cost_per_tube = 	(layer7_layer2_mb1value / parseFloat($('#layer7_quantity').val()));

				var layer7_layer3_admercost_per_tube = (layer7_layer3_admervalue / parseInt($('#layer7_quantity').val()));
				var layer7_layer4_evohcost_per_tube = (layer7_layer4_evohvalue / parseInt($('#layer7_quantity').val()));
				var layer7_layer5_admercost_per_tube = (layer7_layer5_admervalue / parseInt($('#layer7_quantity').val()));

				var layer7_layer6_ldcost_per_tube = 	(layer7_layer6_ldvalue / parseInt($('#layer7_quantity').val()));	
				var layer7_layer6_lldcost_per_tube = 	(layer7_layer6_lldvalue / parseInt($('#layer7_quantity').val()));
				var layer7_layer6_hdcost_per_tube = 	(layer7_layer6_hdvalue / parseInt($('#layer7_quantity').val()));
				var layer7_layer6_mbcost_per_tube = 	(layer7_layer6_mbvalue / parseFloat($('#layer7_quantity').val()));
				var layer7_layer6_mb1cost_per_tube = 	(layer7_layer6_mb1value / parseFloat($('#layer7_quantity').val()));

				var layer7_layer7_ldcost_per_tube = 	(layer7_layer7_ldvalue / parseInt($('#layer7_quantity').val()));	
				var layer7_layer7_lldcost_per_tube = 	(layer7_layer7_lldvalue / parseInt($('#layer7_quantity').val()));
				var layer7_layer7_hdcost_per_tube = 	(layer7_layer7_hdvalue / parseInt($('#layer7_quantity').val()));
				//alert(layer5_layer5_lldcost_per_tube);	

				var layer7_sleeve_cost = (layer7_layer1_ldcost_per_tube + layer7_layer1_lldcost_per_tube + layer7_layer1_hdcost_per_tube + layer7_layer2_ldcost_per_tube + layer7_layer2_lldcost_per_tube + layer7_layer2_hdcost_per_tube + layer7_layer2_mbcost_per_tube + layer7_layer2_mb1cost_per_tube +layer7_layer3_admercost_per_tube + layer7_layer4_evohcost_per_tube + layer7_layer5_admercost_per_tube + layer7_layer6_ldcost_per_tube + layer7_layer6_lldcost_per_tube + layer7_layer6_hdcost_per_tube + layer7_layer6_mbcost_per_tube + layer7_layer6_mb1cost_per_tube + layer7_layer7_ldcost_per_tube + layer7_layer7_lldcost_per_tube + layer7_layer7_hdcost_per_tube);
				//alert(layer7_sleeve_cost);

				$('#layer7_sleeve_cost').val(layer7_sleeve_cost.toFixed(2));
				$('#sleeve_cost_view').val(layer7_sleeve_cost.toFixed(2));
				
			}
		});


   //---------------CAP Metalization check box 

   $("#cap_metalization").live('click',function() {
   if ($(this).is(":checked")) {
    $("#metalization_div").show();
   } else {
   	$("#metalization_div").hide();
   	$("#cap_metalization_color").val("");
   }
  });

    $("#cap_foil").live('click',function() {
   if ($(this).is(":checked")) {
    $("#foil_div").show();
   } else {
   	$("#foil_div").hide();
   	$("#cap_foil_width").val("");
   }
  });

  // ---------------------------Link Hide 
  	if($("#layer").val()==""){
  		$('.layer_link').hide();
  	}
  	if( $("#tube_lacquer").val()=="" ||  $("#tube_lacquer").val()=='NO'){
  		$('#lacquer_link').hide();
  	}
  	if( $("#print_type").val()==""){
  		$('.tube_print_link').hide();
  	}
  	if( $("#special_ink").val()=="" ||  $("#special_ink").val()=='NO'){
  		$('#special_ink_link').hide();
  	}
  	if( $("#shoulder_orifice").val()==""){
  		$('#shoulder_link').hide();
  	}
  	if( $("#cap_dia").val()==""){
  		$('#cap_link').hide();
  	}
  	if( $("#tube_foil").val()=="" || $("#tube_foil").val()=='NO'){
  		$('#tube_foil_link').hide();
  	}
  	//$('#tube_foil_link').hide();

  	if( $("#shoulder_foil").val()=="" || $("#shoulder_foil").val()=='NO'){
  		$('#shoulder_foil_link').hide();
  	}
  	//$('#shoulder_foil_link').hide();
  	
  	if( $("#cap_shrink_sleeve").val()=="" || $("#cap_shrink_sleeve").val()=='NO'){
  		$('#cap_shrink_sleeve_link').hide();
  	}
    if( $("#cap_metalization_finish").val()=="" || $("#cap_metalization_finish").val()=='NO'){
  		$('#cap_metalization_link').hide();
  	}
    if( $("#cap_foil_dist_frm_bottom").val()=="" || $("#cap_foil_dist_frm_bottom").val()=='NO'){
  		$('#cap_foil_link').hide();
  	}
    

    //---------------Layers POPUP BOX
   // $('.ui.modal').modal();
    $("#layer").live('change',function() {
    	if($("#layer").val()!=""){
    		$('.layer_link').show();
    	}else{
    		$('.layer_link').hide();
    	}
    	

    	switch(layer){
    		case("1"):$('#layer1').show();
    		break;
    		case("2"):$("#layer2").show();
    		//case("2"):$('#layer2_link').show();
    		break;
    		case("3"):$("#layer3").show();
    		//case("3"):$('#layer3_link').show();
    		break;
    		case("5"):$("#layer5").show();
    		//case("5"):$('#layer5_link').show();
    		break;
    		case("7"):$("#layer7").show();
    		//case("7"):$('#layer7_link').show();
    		break;
    	}
		 
	 });

     $(".layer_link").click(function(event) {


    	var layer=$("#layer").val();

    	switch(layer){
    		case("1"):$('#layer1').show();
    		break;
    		case("2"):$("#layer2").show();
    		break;
    		case("3"):$("#layer3").show();
    		break;
    		case("5"):$("#layer5").show();
    		break;
    		case("7"):$("#layer7").show();
    		break;
    	}
		 
	 });


    $(".close").click(function(event) {
    	$('#layer1').css('display','none');
    	$('#layer2').css('display','none');
    	$('#layer3').css('display','none');
    	$('#layer5').css('display','none');
    	$('#layer7').css('display','none');    	
    	$('#shoulder_div').css('display','none');
    	$('#tube_lacquer_div').css('display','none');
    	$('#plain_div').css('display','none');
    	$('#label_div').css('display','none');
    	$('#spring_div').css('display','none');
    	$('#screen_div').css('display','none');
    	$('#offset_div').css('display','none');
    	$('#cap_div').css('display','none');
    	$('#tube_foil_div').css('display','none');
    	$('#shoulder_foil_div').css('display','none');
    	$('#cap_shrink_sleeve_div').css('display','none'); 
    	$('#cap_metalization_charges_div').css('display','none'); 
    	$('#cap_foil_div').css('display','none'); 
    	$('#special_ink_div').css('display','none'); 
    });

//---------------------------Lacquer Popup


    $("#tube_lacquer").live('change',function() {

    	//$('#lacquer_link').show();
    	if($("#tube_lacquer").val()=='YES'){
		   	$('#tube_lacquer_div').show();
		   	$('#lacquer_link').show();
    	}else{
    		$('#tube_lacquer_div').css('display','none');
    		$('#lacquer_link').hide();
    	}
	 
	 });

    $("#lacquer_link").live('click',function() {

    	$('#tube_lacquer_div').show();
		 
	 });
			

//---------Lacquer Calculator


    $("#lacquer_type_1").live('change',function() {

		$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/get_rm_rate'); ?>",data: {rm:$('#lacquer_type_1').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#lacquer_type_1_rate").val(html);

		   	 } 
		   });
  	});

  	$("#lacquer_type_1").live('change',function() {

		$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/get_lacquer_consumption'); ?>",data: {rm:$('#lacquer_type_1').val(),sleeve_dia:$('#sleeve_dia').val(),sleeve_length:$('#sleeve_length').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#lacquer_type_1_gm_per_tube").val(html);

		   	 } 
		   });
  	});

  	$("#lacquer_type_2").live('change',function() {

		$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#lacquer_type_2').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#lacquer_type_2_rate").val(html);

		   	 } 
		   });
  	});

  	$("#lacquer_type_2").live('change',function() {

		$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_lacquer_consumption",data: {rm:$('#lacquer_type_2').val(),sleeve_dia:$('#sleeve_dia').val(),sleeve_length:$('#sleeve_length').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#lacquer_type_2_gm_per_tube").val(html);

		   	 } 
		   });
  	});


  	var total_lacquer_cost=0;
	 	//$("#lacquer_cost_view").val(total_lacquer_cost.toFixed(2));

    $("#tube_lacquer_cost").live('click',function() {

    	var lacquer_1_cost=0;
    	var lacquer_2_cost=0;
    	if($('#sleeve_dia').val()=="" || $('#sleeve_length').val()==""){
				alert("Please enter the Diameter,Length");
		}else if($('#lacquer_type_1').val()=="" || $('#lacquer_type_1_percentage').val()==""){
			alert("Enter Lacquer Code & %");
		}else if($('#lacquer_rejection').val()=="" && $('#lacquer_rejection').val()==0){
				alert("Please enter Rejection  % Deatils ");	
		// }else if(parseInt($("#lacquer_type_1_percentage").val()) + parseInt($("#lacquer_type_2_percentage").val()) !== 100){
		// 	alert("Addition of Both Lacquer shoulde be 100%");
		}else {
			var lacquer_1_cost_per_tube=0;
    		var lacquer_2_cost_per_tube=0;
    	
			var curved_surface_area=(parseInt($('#sleeve_dia').val())*3.142*(parseFloat($('#sleeve_length').val())+3))/10000;
			//alert($("#lacquer_type_1_rate").val());
			lacquer_1_cost_per_tube=(($("#lacquer_type_1_rate").val()/1000)*parseFloat($("#lacquer_type_1_gm_per_tube").val())*(parseInt($("#lacquer_type_1_percentage").val())/100)*curved_surface_area);
			//lacquer_1_cost=lacquer_1_cost_per_tube;

			if($('#lacquer_type_2').val()!="" || $('#lacquer_type_2_percentage').val()!=""){

			lacquer_2_cost_per_tube=(($("#lacquer_type_2_rate").val()/1000)*parseFloat($("#lacquer_type_2_gm_per_tube").val())*(parseInt($("#lacquer_type_2_percentage").val())/100)*curved_surface_area);
				if(isNaN(lacquer_2_cost_per_tube)){
					lacquer_2_cost_per_tube=0;
				}
			}

			total_lacquer_cost=(+lacquer_1_cost_per_tube)+(+lacquer_2_cost_per_tube);

			total_lacquer_cost = total_lacquer_cost+total_lacquer_cost*(parseFloat($('#lacquer_rejection').val())/100);

			$("#lacquer_cost_per_tube").val(total_lacquer_cost.toFixed(2));
			//$("#lacquer_cost_view").html(total_lacquer_cost.toFixed(2));
			$("#lacquer_cost_view").val(total_lacquer_cost.toFixed(2));
		}
		
    });

    //-----------------------------------Print Type POPUP BOX----------------------------------------

    var offset_consumable_view = 0;
    var screen_flexo_consumable_view = 0;
    var spring_consumable_view = 0;
   // $("#offset_consumable_view").val(offset_consumable_view.toFixed(2));		   
   // $("#screen_flexo_consumable_view").val(screen_flexo_consumable_view.toFixed(2));	  
   // $("#spring_consumable_view").val(spring_consumable_view.toFixed(2));

     $("#print_type").live('change',function() {

     	//$(".tube_print_link").show();
     	if($("#print_type").val()!=""){
    		$('.tube_print_link').show();
    	}else{
    		$('.tube_print_link').hide();
    	}

    	var print_type=$("#print_type").val();

    	switch(print_type){
    		case("PLAIN"):$('#plain_div').show();
    		$(".tube_print_link").show();
    		break;
    		case("LABEL"):$("#label_div").show();
    		$(".tube_print_link").show();
    		break;
    		case("SPRING"):$("#spring_div").show();
    		$(".tube_print_link").show();
    		$("#loading").show();
		   	$("#cover").show();
		   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
		   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_consumable",data: {consumable_category_id:6},cache: false,success: function(html){
		        	setTimeout(function () {
		        		$("#loading").hide();$("#cover").hide();},200);
		       			$("#spring_consumable_view").val(html);
		       			offset_consumable_view = 0;
		       			$("#offset_consumable_view").val(offset_consumable_view.toFixed(2));
		       			screen_flexo_consumable_view = 0;
		       			$("#screen_flexo_consumable_view").val(screen_flexo_consumable_view.toFixed(2));	

			   	 } 
			   });
    		break;

    		case("SCREEN+FLEXO"):$("#screen_div").show();
    		$(".tube_print_link").show();
    		$("#loading").show();
		   	$("#cover").show();
		   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
		   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_screen_flexo_consumable",data: {screen:5,flexo:3},cache: false,success: function(html){
		        	setTimeout(function () {
		        		$("#loading").hide();$("#cover").hide();},200);
		       			$("#screen_flexo_consumable_view").val(html);

		       			offset_consumable_view = 0;
		       			$("#offset_consumable_view").val(offset_consumable_view.toFixed(2));
		       			spring_consumable_view = 0;
		       			$("#spring_consumable_view").val(spring_consumable_view.toFixed(2));	
			   	 } 
			   });
    		break;

    		case("OFFSET"):$("#offset_div").show();
    		$("#loading").show();
		   	$("#cover").show();
		   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
		   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_consumable",data: {consumable_category_id:4},cache: false,success: function(html){
		        	setTimeout(function () {
		        		$("#loading").hide();$("#cover").hide();},200);
		       			$("#offset_consumable_view").val(html);

		       			screen_flexo_consumable_view = 0;
		       			$("#screen_flexo_consumable_view").val(screen_flexo_consumable_view.toFixed(2));

		       			spring_consumable_view = 0;
		       			$("#spring_consumable_view").val(spring_consumable_view.toFixed(2));
			   	 } 
			   });
    		break;
    	}
		 
	 });

	 $(".tube_print_link").live('click',function() {


    	var print_type=$("#print_type").val();

    	switch(print_type){
    		case("PLAIN"):$('#plain_div').show();
    		break;
    		case("LABEL"):$('#label_div').show();
    		break;
    		case("SPRING"):$('#spring_div').show();
    		break;
    		case("SCREEN+FLEXO"):$('#screen_div').show();
    		break;
    		case("OFFSET"):$('#offset_div').show();
    		break;
    		
    	}
		 
	 });
    
//---------Offset Calculator


    $("#offset_rm_month").live('change',function() {

		$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_ink_rate",data: {ink_id:$('#offset_rm_month').val(),ink_id:2},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#offset_rate").val(html);

		   	 } 
		   });
  	});

  	$("#offset_rm_month").live('change',function() {

		$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_consumption_rate",data: {lacquer_type_id:$('#offset_rm_month').val(),lacquer_type_id:2},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#offset_plate_rate").val(html);


		   	 } 
		   });
  	});



    var offset_ink_cost_per_tube  = 0;
    //$("#offset_cost_view").val(offset_ink_cost_per_tube.toFixed(2));

    var offset_plate_cost = 0;
    // $("#offset_plate_cost_view").val(offset_plate_cost.toFixed(2));

    var offset_plate_cost_per_tube = 0;
    //$("#offset_plate_cost_view").val(offset_plate_cost_per_tube.toFixed(2));    


    $("#offset_cost").live('click',function() {
    	//-----------------screen value set to 0	
    	var total_screen_flexo_ink_cost = 0;	 
      $("#screen_flexo_cost_view").val(total_screen_flexo_ink_cost.toFixed(2));
       var screen_film_cost_per_tube = 0;
      $("#screen_plate_cost_view").val(screen_film_cost_per_tube.toFixed(2));	
      var flexo_plate_cost_per_tube = 0; 
      $("#flexo_plate_cost_view").val(flexo_plate_cost_per_tube.toFixed(2));

      
      if($('#offset_percentage').val()==""){
        alert("Please enter the Ink Coverage %");
    }else if($('#sleeve_dia').val()=="" || $('#sleeve_length').val()==""){
        alert("Please enter the Diameter,Length");    
    }else if($('#offset_gm_per_tube').val()=="" ){
        alert("Please Enter offset ink Gm/tube"); 
    }else if($('#offset_rm_month').val()=="" ){
        alert("Please select offset ink");  
    // }else if($('#offset_plate_cost').val()=="" ){
    //     alert("Please enter offset plate rate");  
    // }else if($('#offset_impresssion').val()=="" ){
    //     alert("Please enter No. of Impression"); 
	}else if($('#offset_rejection').val()=="" && $('#offset_rejection').val()==0){
				alert("Please enter Rejection  % Deatils ");             
    }else if($('#offset_plate_cost').val()== 0){    
        var offset_plate_cost_per_tube = 0 ;
        $("#offset_plate_cost_per_tube").val(offset_plate_cost_per_tube.toFixed(2));
        $("#offset_plate_cost_view").val(offset_plate_cost_per_tube.toFixed(2));

        var curved_surface_area=(parseInt($('#sleeve_dia').val())*3.142*(parseFloat($('#sleeve_length').val())+3))/1000;
     		//alert($("#offset_rate").html());

        offset_ink_cost_per_tube=(($("#offset_rate").val()/1000)*parseFloat($("#offset_gm_per_tube").val())*(parseInt($("#offset_percentage").val())/100)*curved_surface_area)/100;

        $("#offset_cost_per_tube").val(offset_ink_cost_per_tube.toFixed(2));
        $("#offset_cost_view").val(offset_ink_cost_per_tube.toFixed(2));
    }else {

	      var offset_color = parseFloat($('#offset_color').val());
	      var offset_sets = parseFloat($('#offset_sets').val());
	      var offset_impresssion = parseFloat($('#offset_impresssion').val());

      	var curved_surface_area=(parseInt($('#sleeve_dia').val())*3.142*(parseFloat($('#sleeve_length').val())+3))/1000;
        //alert($("#offset_rate").html());

     		offset_ink_cost_per_tube=(($("#offset_rate").val()/1000)*parseFloat($("#offset_gm_per_tube").val())*(parseInt($("#offset_percentage").val())/100)*curved_surface_area)/100;

     		//alert(offset_ink_cost_per_tube*(parseFloat($('#offset_rejection').val())/100));

     		offset_ink_cost_per_tube = offset_ink_cost_per_tube+offset_ink_cost_per_tube*(parseFloat($('#offset_rejection').val())/100);

      	offset_plate_cost = parseFloat($('#offset_plate_cost').val());
      // $("#offset_plate_cost_view").val(offset_plate_cost.toFixed(2));
      
     		offset_plate_cost_per_tube= (offset_plate_cost * offset_color * offset_sets) / offset_impresssion  ;
       // alert(offset_plate_cost_per_tube);
      
      $("#offset_cost_per_tube").val(offset_ink_cost_per_tube.toFixed(2));
      $("#offset_cost_view").val(offset_ink_cost_per_tube.toFixed(2));
      $("#offset_plate_cost_per_tube").val(offset_plate_cost_per_tube.toFixed(2));
      $("#offset_plate_cost_view").val(offset_plate_cost_per_tube.toFixed(2));

    }
    
    });
 
    //---------Screen Calculator


    $("#screen_rm_month").live('change',function() {

		$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_ink_rate",data: {ink_id:$('#screen_rm_month').val(),ink_id:3},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#screen_rate").val(html);

		   	 } 
		   });
  	});

  	$("#flexo_rm_month").live('change',function() {

		$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_ink_rate",data: {ink_id:$('#flexo_rm_month').val(),ink_id:1},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#flexo_rate").val(html);

		   	 } 
		   });
  	});



  	var total_screen_flexo_ink_cost	= 0;
		//$("#screen_flexo_cost_view").val(total_screen_flexo_ink_cost.toFixed(2));
	var screen_plate_cost	= 0;
		//$("#screen_plate_cost_view").val(screen_plate_cost.toFixed(2));
	var flexo_plate_cost	= 0;
		  //$("#flexo_plate_cost_view").val(flexo_plate_cost.toFixed(2)); 

    $("#screen_flexo_cost").live('click',function() {
    	//-----------------offset value set to 0
    	var offset_ink_cost_per_tube = 0;
    	$("#offset_cost_view").val(offset_ink_cost_per_tube.toFixed(2));
    	var offset_plate_cost_per_tube = 0;
    	$("#offset_plate_cost_view").val(offset_plate_cost_per_tube.toFixed(2));

    	
    	if($('#sleeve_dia').val()=="" || $('#sleeve_length').val()==""){
				alert("Please enter the Diameter,Length");
		}else if($('#screen_rm_month').val()=="" && $('#flexo_rm_month').val()=="" ){
				alert("Please select Print Type");
		}else if($('#screen_flexo_rejection').val()=="" && $('#screen_flexo_rejection').val()==0){
				alert("Please enter Rejection  % Deatils ");		
		}else {

				var flexo_ink_cost_per_tube=0;
    			var screen_ink_cost_per_tube=0;
   	
				var curved_surface_area=(parseInt($('#sleeve_dia').val())*3.142*(parseFloat($('#sleeve_length').val())+3))/1000;
			
				flexo_ink_cost_per_tube=(($("#flexo_rate").val()/1000)*parseFloat($("#flexo_gm_per_tube").val())*(parseInt($("#flexo_percentage").val())/100)*curved_surface_area)/100;
			
			//lacquer_1_cost=lacquer_1_cost_per_tube;

			if($('#screen_rm_month').val()!="" || $('#screen_percentage').val()!=""){

			screen_ink_cost_per_tube=(($("#screen_rate").val()/1000)*parseFloat($("#screen_gm_per_tube").val())*(parseInt($("#screen_percentage").val())/100)*curved_surface_area)/100;
				if(isNaN(screen_ink_cost_per_tube)){
					screen_ink_cost_per_tube=0;
				}
			}

			// screen_plate_cost = parseFloat($('#screen_plate_cost').val());
			// $("#screen_plate_cost_view").val(screen_plate_cost.toFixed(2));

			// flexo_plate_cost = parseFloat($('#flexo_plate_cost').val());
			// $("#flexo_plate_cost_view").val(flexo_plate_cost.toFixed(2));

			total_screen_flexo_ink_cost=(+flexo_ink_cost_per_tube)+(+screen_ink_cost_per_tube);

			total_screen_flexo_ink_cost = total_screen_flexo_ink_cost+total_screen_flexo_ink_cost*(parseFloat($('#screen_flexo_rejection').val())/100);

			screen_plate_cost_per_tube =  parseFloat($('#screen_plate_cost_per_tube').val());
			flexo_plate_cost_per_tube =  parseFloat($('#screen_plate_cost_per_tube').val());

		
			$("#screen_flexo_cost_per_tube").val(total_screen_flexo_ink_cost.toFixed(2));
			$("#screen_flexo_cost_view").val(total_screen_flexo_ink_cost.toFixed(2));
			
		}
		
    });  

  
 //----------------------screen Plate  
 		var screen_film_cost_per_tube = 0;	
 		//$("#screen_film_cost_per_tube").val(screen_film_cost_per_tube.toFixed(2));
		//$("#screen_plate_cost_view").val(screen_film_cost_per_tube.toFixed(2));	

    $("#screen_film_cost").live('click',function() {

    	
    	if($('#screen_film_rate').val()=="" || $('#screen_colors').val()=="" || $('#screen_impresssion').val()=="" || $('#screen_sets').val()==""){
				alert("Please enter the Screen Deatils");
		}else {

				var screen_film_cost_per_tube = 0;

				screen_film_cost_per_tube = (parseFloat($('#screen_film_rate').val()) * parseFloat($('#screen_colors').val()) * parseFloat($('#screen_sets').val())) / parseFloat($('#screen_impresssion').val());
				
				$("#screen_film_cost_per_tube").val(screen_film_cost_per_tube.toFixed(2));
				$("#screen_plate_cost_view").val(screen_film_cost_per_tube.toFixed(2));	
		}
		
    }); 

  //----------------------Flexo Plate  
  	var flexo_plate_cost_per_tube = 0;
  	//$("#flexo_plate_cost_per_tube").val(flexo_plate_cost_per_tube.toFixed(2));
		//$("#flexo_plate_cost_view").val(flexo_plate_cost_per_tube.toFixed(2));	

    $("#flexo_plate_cost").live('click',function() {

    	
    	if($('#flexo_plate_rate').val()=="" || $('#flexo_colors').val()=="" || $('#flexo_impresssion').val()=="" || $('#flexo_sets').val()==""){
				alert("Please enter the Flexo Deatils");
		}else {

				flexo_plate_cost_per_tube = (parseFloat($('#flexo_plate_rate').val()) * parseFloat($('#flexo_colors').val()) * parseFloat($('#flexo_sets').val())) / parseFloat($('#flexo_impresssion').val());
				
				$("#flexo_plate_cost_per_tube").val(flexo_plate_cost_per_tube.toFixed(2));
				$("#flexo_plate_cost_view").val(flexo_plate_cost_per_tube.toFixed(2));	
		}
		
    });     

   //-----------------------Label Calculator
   

   var label_cost	= 0;
	//$("#label_cost_view").val(label_cost.toFixed(2));

   $("#label_cost").live('click',function() {
    	
    	if($('#label_rate').val()=="" ){
				alert("Please enter the Label Rate");
		}else if($('#label_rejection').val()=="" && $('#label_rejection').val()==0){
				alert("Please enter Rejection  % Deatils ");
		
		}else {
    			
			var label_rate = (parseFloat($('#label_rate').val()));
			label_cost=label_rate;

			label_cost = label_cost+label_cost*(parseFloat($('#label_rejection').val())/100);

			$("#label_cost_per_tube").val(label_cost.toFixed(2));
			$("#label_cost_view").val(label_cost.toFixed(2));
		}
		
    }); 

 //--------------Special Ink Pop Up

    $("#special_ink").live('change',function() {
    	//$('#special_ink_link').show();
    	if($("#special_ink").val()=='YES'){
    		alert('hi');
		   	$('#special_ink_div').show();
		   	$('#special_ink_link').show();
    	}else{
    		$('#special_ink_div').css('display','none');
    		$('#special_ink_link').hide();
    	}	 
	 });

    $("#special_ink_link").live('click',function() {

    	$('#special_ink_div').show();
		 
	 });

 //----------------Special Ink Calculator
   $("#special_rm_month").live('change',function() {

		$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_ink_rate",data: {ink_id:$('#special_rm_month').val(),ink_id:4},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#special_ink_rate").val(html);

		   	 } 
		   });
  	});

   var special_ink_cost_per_tube = 0;
  // $("#special_ink_cost_view").val(special_ink_cost_per_tube.toFixed(2));

   $("#special_ink_cost").live('click',function() {

    	
    	if($('#special_percentage').val()==""){
				alert("Please enter the Ink Coverage %");
		}else if($('#special_gm_per_tube').val()=="" ){
				alert("Please Enter ink Gm/tube");	
		}else if($('#special_rm_month').val()=="" ){
				alert("Please select Special ink");	
		}else if($('#sleeve_dia').val()=="" || $('#sleeve_length').val()==""){
				alert("Please enter the Diameter,Length");
		}else if($('#specialink_rejection').val()=="" && $('#specialink_rejection').val()==0){
				alert("Please enter Rejection  % Deatils ");		
		}else {

			var curved_surface_area=(parseInt($('#sleeve_dia').val())*3.142*(parseFloat($('#sleeve_length').val())+3))/1000;
			//alert(curved_surface_area);

			special_ink_cost_per_tube=(($("#special_ink_rate").val()/1000)*parseFloat($("#special_gm_per_tube").val())*(parseInt($("#special_percentage").val())/100)*curved_surface_area)/100;

			special_ink_cost_per_tube = special_ink_cost_per_tube+special_ink_cost_per_tube*(parseFloat($('#specialink_rejection').val())/100);

			$("#special_ink_cost_per_tube").val(special_ink_cost_per_tube.toFixed(2));
			$("#special_ink_cost_view").val(special_ink_cost_per_tube.toFixed(2));
		}
		
    }); 
     

 //---------------------------Shoulder POPUP BOX
   
    $("#shoulder_orifice").live('change',function() {

    	if($("#shoulder_orifice").val()!=""){
    		$('#shoulder_div').show();
    		$('#shoulder_link').show();
    	}else{
    		$('#shoulder_link').hide();
    	}
	 
	 });

    $("#shoulder_link").live('click',function() {

    	$('#shoulder_div').show();
		 
	 });

//-----------------------------Shoulder rate-----------
	$("#sh_hdpe_one").live('change',function() {

      $("#loading").show();
      $("#cover").show();
      $('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
      $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#sh_hdpe_one').val()},cache: false,success: function(html){
            setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
          $("#sh_hdpe_one_rate").val(html);

         } 
         });
   });

   $("#sh_hdpe_two").live('change',function() {

      $("#loading").show();
      $("#cover").show();
      $('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
      $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#sh_hdpe_two').val()},cache: false,success: function(html){
            setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
          $("#sh_hdpe_two_rate").val(html);

         } 
         });
   });

	$("#shoulder_mb").live('change',function() {

      $("#loading").show();
      $("#cover").show();
      $('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
      $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#shoulder_mb').val()},cache: false,success: function(html){
            setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
          $("#shoulder_mb_rate").val(html);

         } 
         });
   });
	//--------------------------Shoulder calculator--------------------

	var shoulder_cost=0;
	//$('#shoulder_cost_view').val(shoulder_cost.toFixed(2));
	$("#shouldercost").live('click',function() {

		
      if($('#sleeve_dia').val()=="" || $('#Shoulder').val()==""){
        alert("Please enter the Diameter,Shoulder");
      }else if($('#hdpe_m').val()=="" || $('#hdpe_f').val()=="" || $('#sh_hdpe_one').val()=="" || $('#sh_hdpe_two').val()==""){
        alert("Please enter % , RM ");
      }else if(parseFloat($("#hdpe_m").val()) + parseFloat($("#hdpe_f").val())!== 100 ){
        alert(" % of HDPE1 and HDPE2 should be 100");
      }else if($('#shoulder_mb').val()=="" && $('#shoulder_mb1').val()==""){
        alert("Please Enter MB ");
      }else if($('#sh_rejection').val()=="" || $('#sh_rejection').val()==0){
			alert("Please enter rejection %"); 
      }else{
        
        $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_shoulder_weight",data: {sleeve_id:$('#sleeve_dia').val(),shld_type_id:$('#shoulder').val(),shld_orifice_id:$('#shoulder_orifice').val(),sh_rejection:$('#sh_rejection').val()},cache: false,success: function(html){
            setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
          $("#shoulder_weight").html(html);
          //alert(html);
		  var hdpe1 = ((parseFloat($("#hdpe_m").val())) / 100 )* html;
          var hdpe2 = ((parseFloat($("#hdpe_f").val())) / 100 )* html;       
          var shoulder_mb = ((parseFloat($("#shoulder_mb_percentage").val())) / 100 )* html;
          var shoulder_mb1 = ((parseFloat($("#shoulder_mb_percentage1").val())) / 100 )* html;
       // alert(shoulder_mb);
        //  alert(shoulder_mb1);

      	 var kgs1 = (hdpe1 / 1000)* (parseFloat($("#sh_quantity").val())) ;
      	 var kgs2 = (hdpe2 / 1000)* (parseFloat($("#sh_quantity").val())) ;

      	 var kgs3 = (shoulder_mb / 1000)* (parseFloat($("#sh_quantity").val())) ;
      	 var kgs4 = (shoulder_mb1 / 1000)* (parseFloat($("#sh_quantity").val())) ;
 			// alert(kgs3);
 			// alert(kgs4);

 			 var value1 = (kgs1 * $("#sh_hdpe_one_rate").val())  ;
 			 var value2 = (kgs2 * $("#sh_hdpe_two_rate").val())  ;
 			 var value3 = (kgs3 * $("#shoulder_mb_rate").val())  ;
 			 var value4 = (kgs4 * ($("#shoulder_mb1_rate").val())) ;
 			 //alert(value3);
      	 	shoulder_cost = ((value1 + value2 + value3 + value4 )/ (parseFloat($("#sh_quantity").val())) );
         //alert(shoulder_cost);
        $('#shoulder_cost').val(shoulder_cost.toFixed(2));
        $('#shoulder_cost_view').val(shoulder_cost.toFixed(2));

         } 
         });      
      
      }
    });
 

  //---------------------------Cap POPUP BOX
   
    $("#cap_dia").live('change',function() {

    	// $('#cap_link').show();
    	// var cap_dia=$("#cap_dia").val();
    	// $('#cap_div').show();
    	if($("#cap_dia").val()!=""){
    		$('#cap_div').show();
    		$('#cap_link').show();
    	}else{
    		$('#cap_link').hide();
    	}
	 
	 }); 

	 $("#cap_link").live('click',function() {

    	$('#cap_div').show();
		 
	 }); 

//----------------------cap calculator
	$("#cap_dia").live('change',function() {

		$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_cap_height",data: {sleeve_id:$('#sleeve_dia').val(),shld_type_id:$('#shoulder').val(),shld_orifice_id:$('#shoulder_orifice').val(),cap_type_id:$('#cap_type').val(),cap_finish_id:$('#cap_finish').val(),cap_dia_id:$('#cap_dia').val(),sleeve_length:$('#sleeve_length').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#bottom_box").html(html);
		   	 } 
		   });
  	});

  	

    $("#cap_dia").live('change',function() {

		$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_cap_weight",data: {sleeve_id:$('#sleeve_dia').val(),shld_type_id:$('#shoulder').val(),shld_orifice_id:$('#shoulder_orifice').val(),cap_type_id:$('#cap_type').val(),cap_finish_id:$('#cap_finish').val(),cap_dia_id:$('#cap_dia').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#cap_weight_rate").val(html);
	       	// var mould_type = $('#cap_type').val().split('//');
	       	// $("#mould_type").val(mould_type[0]);
		   	 } 
		   });
  	});

  	$("#cap_dia").live('change',function() {

		$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_mould_type",data: {cap_type_id:$('#cap_type').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#mould_type").val(html);
	       	
		   	 } 
		   });
  	});

  	$("#cap_dia").live('change',function() {

		$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_runner_waste",data: {cap_type_id:$('#cap_type').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#runner_waste").val(html);
	       	
		   	 } 
		   });
  	});

  	$("#cap_dia").live('click',function() {
    	
    	if($('#sleeve_dia').val()=="" || $('#sleeve_length').val()=="" ){
				alert("Please enter the Diameter,Length");
		}	
		
    }); 


  	var total_cap_weight_cost=0;
    //$("#cap_cost_view").val(total_cap_weight_cost.toFixed(2));

  	$("#cap_cost").live('click',function() {

    	
    	if($('#sleeve_dia').val()=="" || $('#sleeve_length').val()==""){
				alert("Please enter the Diameter,Length");
		}else if($('#runner_waste').val()=="" ){
				alert("Please enter Runner Waste");	
		}else if($('#pp_price').val()=="" ){
				alert("Please enter PP Price");	
		}else if($('#mb_price').val()=="" ){
				alert("Please enter MB Price");		
		}else if($('#mb_loading').val()=="" ){
				alert("Please enter MB Loading");	
		}else if($('#moulding_cost').val()=="" ){
				alert("Please enter Moulding Cost");			
		}else if($('#cap_rejection').val()=="" && $('#cap_rejection').val()==0){
				alert("Please enter Rejection  % Deatils ");								
		}else {

			var runner_waste_percentage = parseFloat($('#runner_waste').val())/100 ;
			var mb_loading_percentage = parseFloat($('#mb_loading').val())/100 ;
			var moulding_cost = parseFloat($('#moulding_cost').val());

			var cap_weight = (parseFloat($("#cap_weight_rate").val())+($("#cap_weight_rate").val()* runner_waste_percentage));

			var pp_price = (cap_weight * parseFloat($('#pp_price').val()));
			
			var weight_mb = (parseFloat($("#cap_weight_rate").val()) * mb_loading_percentage );

			var mb_price = (weight_mb * parseFloat($('#mb_price').val()));
			
			total_cap_weight_cost = ((mb_price + pp_price ) / 1000) + moulding_cost ;

			total_cap_weight_cost = total_cap_weight_cost+total_cap_weight_cost*(parseFloat($('#cap_rejection').val())/100);
			//alert(total_cap_weight_cost);

			$("#cap_cost_per_tube").val(total_cap_weight_cost.toFixed(2));
			$("#cap_cost_view").val(total_cap_weight_cost.toFixed(2));
		}
		
    }); 


    //-------------Top Box Rate
    $("#top_box").live('change',function() {

		$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#top_box').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#top_box_rate").val(html);
		   	 } 
		   });
  	});

  	//-------------Box Liners Rate
    $("#box_liners").live('change',function() {

		$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#box_liners').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#box_liners_rate").val(html);
		   	 } 
		   });
  	});

    //-------------Bottom Box Rate
    $("#bottom_box").live('change',function() {

		$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/get_rm_rate'); ?>",data: {rm:$('#bottom_box').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#bottom_box_rate").val(html);
		   	 } 
		   });
  	});




    var total_box_rate = 0;
  	//$("#packing_box_view").val(total_box_rate.toFixed(2));	
  	var liner_gm_per_tube = 0;
  	//$("#liners_view").val(liner_gm_per_tube.toFixed(2));

  	$("#total_box").live('click',function() {

  		var sum = 0;

  		if($('#top_box').val()=="" || $('#bottom_box').val()=="" || $('#box_liners').val()==""){
  			alert("Please select Top Box , Bottom Box , Liners ");
  		}else{
  			$("#loading").show();
	   		$("#cover").show();
	   		$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
  			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/get_packing_box_tubes'); ?>",data: {sleeve_id:$('#sleeve_dia').val()},cache: false,success: function(html){
	        	setTimeout(function () {
	        		$("#loading").hide();$("#cover").hide();},200);
	       			$("#boxdia_per_tube").val(html);

	       	var top_box_rate = $("#top_box_rate").val();
	    	
	    	var bottom_box_rate = $("#bottom_box_rate").val();

	    	var box_liners_rate = $("#box_liners_rate").val();
	    	
	    	var boxdia_per_tube = $("#boxdia_per_tube").val()/100;

	    	var liner_gm = $("#liner_gm").val();

	    	liner_gm_per_tube = (liner_gm/boxdia_per_tube)* box_liners_rate;
	    	//alert(liner_gm_per_tube);
	    	
	    	sum = (+top_box_rate) + (+bottom_box_rate);
	    	
	    	total_box_rate = sum / boxdia_per_tube ; 
	    	//alert(total_box_rate);
	    $("#total_box_rate").val(total_box_rate.toFixed(2));	
			$("#total_box_rate").html(total_box_rate.toFixed(2));
			$("#liner_gm_per_tube").val(liner_gm_per_tube.toFixed(2));
			$("#liner_gm_per_tube").html(liner_gm_per_tube.toFixed(2));
			$("#liners_view").val(liner_gm_per_tube.toFixed(2));
			$("#packing_box_view").val(total_box_rate.toFixed(2));		
		   	 } 
		   });
    	}	
    });

// Tube FOil Pop up

   $("#tube_foil").live('change',function() {

   		
    	if($("#tube_foil").val()=='YES'){
		   	$('#tube_foil_div').show();
		   	$('#tube_foil_link').show();
    	}else{
    		$('#tube_foil_link').hide();
    		$('#tube_foil_div').css('display','none');
    	}
	 
	 });

	 $("#tube_foil_link").live('click',function() {

    	$('#tube_foil_div').show();
		 
	 });

// Tube foil calculator

    $("#hot_foil_1").live('change',function() {

		$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#hot_foil_1').val()},cache: false,success: function(html){
	        	setTimeout(function () {
	        		$("#loading").hide();$("#cover").hide();},200);
	       			$("#hot_foil_1_rate").val(html);

		   	 } 
		   });
  	});


  	$("#hot_foil_2").live('change',function() {

		$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#hot_foil_2').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#hot_foil_2_rate").val(html);
		   	 } 
		   });
  	});


  	var total_tube_foil_cost = 0;
  	//$("#tube_foil_cost_view").val(total_tube_foil_cost.toFixed(2));
  	$("#tube_foil_cost").live('click',function() {

    	var hot_foil_1_cost=0;
    	var hot_foil_1_cost=0;
    	if($('#sleeve_dia').val()=="" || $('#sleeve_length').val()==""){
				alert("Please enter the Diameter,Length");
		}else if($('#hot_foil_1').val()=="" || $('#hot_foil_1_percentage').val()==""){
			alert("Enter Foil Code & %");
		}else if($('#tube_foil_rejection').val()=="" && $('#tube_foil_rejection').val()==0){
				alert("Please enter Rejection  % Deatils ");	
		}else {
			var hot_foil_1_cost_per_tube=0;
    		var hot_foil_2_cost_per_tube=0;
    	
			var curved_surface_area=(parseInt($('#sleeve_dia').val())*3.142*(parseFloat($('#sleeve_length').val())+3))/1000;
			//alert(curved_surface_area);
			
			hot_foil_1_cost_per_tube=(($("#hot_foil_1_rate").val()*curved_surface_area)/1000)*(parseInt($("#hot_foil_1_percentage").val())/100);
			//lacquer_1_cost=lacquer_1_cost_per_tube;

			if($('#hot_foil_2').val()!="" || $('#hot_foil_2_percentage').val()!=""){

				hot_foil_2_cost_per_tube=(($("#hot_foil_2_rate").val()*curved_surface_area)/1000)*(parseInt($("#hot_foil_2_percentage").val())/100);
			
				if(isNaN(hot_foil_2_cost_per_tube)){
					hot_foil_2_cost_per_tube=0;
				}
			}

			total_tube_foil_cost=(+hot_foil_1_cost_per_tube)+(+hot_foil_2_cost_per_tube);

			total_tube_foil_cost = total_tube_foil_cost+total_tube_foil_cost*(parseFloat($('#tube_foil_rejection').val())/100);

			$("#tube_foil_cost_per_tube").val(total_tube_foil_cost.toFixed(2));
			$("#tube_foil_cost_view").val(total_tube_foil_cost.toFixed(2));
		}
		
    });

//--------------Shoulder Foil Pop up

    $("#shoulder_foil").live('change',function() {

    	
    	if($("#shoulder_foil").val()=='YES'){
		   	$('#shoulder_foil_div').show();
		   	$('#shoulder_foil_link').show();
    	}else{
    		$('#shoulder_foil_link').hide();
    		$('#shoulder_foil_div').css('display','none');
    	}
	 
	 });
    $("#shoulder_foil_link").live('click',function() {

    	$('#shoulder_foil_div').show();
		 
	 });


    //Shoulder Foil rm

    $("#shoulder_foil_tag").live('change',function() {

		$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#shoulder_foil_tag').val()},cache: false,success: function(html){
	        	setTimeout(function () {
	        		$("#loading").hide();$("#cover").hide();},200);
	       			$("#shoulder_foil_rate").val(html);
		   	 } 
		   });
  	});

   $("#shoulder_foil_tag").live('change',function() {

		$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_shoulder_per_tube",data: {rm:$('#shoulder_foil_tag').val(),sleeve_id:$('#sleeve_dia').val()},cache: false,success: function(html){
	        	setTimeout(function () {
	        		$("#loading").hide();$("#cover").hide();},200);
	       			$("#shoulder_foil_sqm_per_tube").val(html);
		   	 } 
		   });
  	});

   	//Shoulder Foil Calculate

    var shoulder_foil_cost = 0;
    //$("#shoulder_foil_cost_view").val(shoulder_foil_cost.toFixed(2));

    $("#shoulder_foil_cost").live('click',function() {
    	

    	if($('#sleeve_dia').val()==""){
				alert("Please enter the Diameter");
		}else if($('#shoulder_foil_tag').val()==""){
			alert("Enter Foil Code");
		}else {
			shoulder_foil_cost=$("#shoulder_foil_sqm_per_tube").val()*$("#shoulder_foil_rate").val();
			$("#shoulder_foil_cost_per_tube").val(shoulder_foil_cost.toFixed(2));
			$("#shoulder_foil_cost_view").val(shoulder_foil_cost.toFixed(2));
		}
		
    });


//Cap Shrink Sleeve Pop up

    $("#cap_shrink_sleeve").live('change',function() {

    		
    	if($("#cap_shrink_sleeve").val()=='YES'){
		   	$('#cap_shrink_sleeve_div').show();
		   	$('#cap_shrink_sleeve_link').show();	
    	}else{
    		$('#cap_shrink_sleeve_link').hide();	
    		$('#cap_shrink_sleeve_div').css('display','none');
    	}	 
	 });

    $("#cap_shrink_sleeve_link").live('click',function() {

    	$('#cap_shrink_sleeve_div').show();
		 
	 });

    $("#cap_shrink_sleeve_code").live('change',function() {

		$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#cap_shrink_sleeve_code').val()},cache: false,success: function(html){
	        	setTimeout(function () {
	        		$("#loading").hide();$("#cover").hide();},200);
	       			$("#cap_shrink_sleeve_rate").val(html);
		   	 } 
		   });
  	});


    var cap_shrink_sleeve_cost = 0;
   // $("#cap_shrink_sleeve_cost_view").val(cap_shrink_sleeve_cost.toFixed(2));

  	$("#cap_shrink_sleeve_cost").live('click',function() {
    	if($('#sleeve_dia').val()==""){
				alert("Please enter the Diameter");
		}else if($('#cap_shrink_sleeve_code').val()==""){
			alert("Enter the Code");
		}else {
			cap_shrink_sleeve_cost=parseFloat($("#cap_shrink_sleeve_rate").val());
			//alert(cap_shrink_sleeve_cost);

			$("#cap_shrink_sleeve_cost_per_tube").val(cap_shrink_sleeve_cost);
			$("#cap_shrink_sleeve_cost_view").val(cap_shrink_sleeve_cost);
		}
		
    });    


    //-----Cap Metalization Pop Up

    $("#cap_metalization_finish").live('change',function() {

    	if($("#cap_metalization_finish").val()!=''){
    		$('#cap_metalization_link').show();
		   	$('#cap_metalization_charges_div').show();
    	}else{
    		$('#cap_metalization_link').hide();
    		$('#cap_metalization_charges_div').css('display','none');
    	}	 
	 });

    $("#cap_metalization_link").live('click',function() {

    	$('#cap_metalization_charges_div').show();
		 
	 });

 	var cap_metalization_rate = 0;
   // $("#cap_metalization_cost_view").val(cap_metalization_rate.toFixed(2));

    $("#cap_metalization_cost").live('click',function() {	

    	if($('#cap_type').val()==""){
				alert("Please enter the cap type");
		}else {
			cap_metalization_rate=parseFloat($("#cap_metalization_rate").val());
			//alert(cap_metalization_rate);
			$("#cap_metalization_cost_per_tube").val(cap_metalization_rate);
			$("#cap_metalization_cost_view").val(cap_metalization_rate);
		}
		
    });   

    //--------------Cap Foil Pop Up

    $("#cap_foil_dist_frm_bottom").live('change',function() {

    	
    	if($("#cap_foil_dist_frm_bottom").val()!=''){
		   	$('#cap_foil_div').show();
		   	$('#cap_foil_link').show();
    	}else{
    		$('#cap_foil_div').css('display','none');
    		$('#cap_foil_link').hide();
    	}	 
	 });

    $("#cap_foil_link").live('click',function() {

    	$('#cap_foil_div').show();
		 
	 });

    var cap_foil_rate = 0 ;
   // $("#cap_foil_cost_view").val(cap_foil_rate.toFixed(2));
    $("#cap_foil_cost").live('click',function() {

    	

    	if($('#cap_type').val()==""){
				alert("Please enter the cap type");
		}else {
			cap_foil_rate=parseFloat($("#cap_foil_rate").val());
			//alert(cap_foil_rate);
			$("#cap_foil_cost_per_tube").val(cap_foil_rate);
			$("#cap_foil_cost_view").val(cap_foil_rate);
		}
		
    });
   

     //-------------- Total Final cost addition
 
     	$("#abc").live('mouseover',function(event) {
     		//alert('hi');

		/*var sleeve_cost_view = $('#sleeve_cost_view').html(sleeve_cost.toFixed(2)) ;
   		var cap_metalization_cost_view = parseFloat($("#cap_metalization_cost_view").text()) ;
   		var cap_foil_cost_view = parseFloat($("#cap_foil_cost_view").text()) ;*/
   		//var cap_shrink_sleeve_cost_view = parseFloat($("#cap_shrink_sleeve_cost_view").text()) ;
   		//alert(cap_shrink_sleeve_cost_view);
   		//var screen_flexo_consumable_view = parseFloat($("#screen_flexo_consumable_view").text()) ;
   		//var offset_consumable_view = parseFloat($("#offset_consumable_view").text()) ;
   		//var spring_consumable_view = parseFloat($("#spring_consumable_view").text()) ;	
   		var sleeve_cost_view = parseFloat($("#sleeve_cost_view").val()); 
   		var shoulder_cost_view = parseFloat($("#shoulder_cost_view").val()) ;
   		var lacquer_cost_view = parseFloat($("#lacquer_cost_view").val()) ;
   		var cap_cost_view = parseFloat($("#cap_cost_view").val()) ;
   		var hygenic_consumable_view = parseFloat($("#hygenic_consumable_view").val()); 
   		var other_consumable_view = parseFloat($("#other_consumable_view").val());

   		var offset_cost_view = parseFloat($("#offset_cost_view").val()) ;  
   		var offset_plate_cost_per_tube = parseFloat($("#offset_plate_cost_view").val());

   		var screen_flexo_cost_view = parseFloat($("#screen_flexo_cost_view").val()) ;
   		var screen_film_cost_per_tube = parseFloat($("#screen_plate_cost_view").val());
   		var flexo_plate_cost_per_tube = parseFloat($("#flexo_plate_cost_view").val());
   		var label_cost_view = parseFloat($("#label_cost_view").val()) ;
   		var special_ink_cost_view = parseFloat($("#special_ink_cost_view").val()) ;

   		var packing_bopp_tape = parseFloat($("#packing_bopp_tape").val()) ; 
   		var liners_view = parseFloat($("#liners_view").val()) ; 
   		var packing_box_view = parseFloat($("#packing_box_view").val()) ; 

   		var customer_flag = parseFloat($("#customer_flag").val()) ;
   		//alert(customer_flag);

   		var other_packing_material = parseFloat($("#other_packing_material").val()) ;			
			var packing_stickers = parseFloat($("#packing_stickers").val()) ;
			var packing_corrugated_sheet = parseFloat($("#packing_corrugated_sheet").val()) ;
			var packing_shrink_flim = parseFloat($("#packing_shrink_flim").val()) ;

			var stores_spares_local_view = parseFloat($("#stores_spares_local_view").val()) ;
			//alert(stores_spares_local_view);
   		var stores_spares_import_view = parseFloat($("#stores_spares_import_view").val()) ;	

   		var freight = parseFloat($("#freight").val()) ;
   		var offset_consumable_view = parseFloat($("#offset_consumable_view").val()) ;
   		var screen_flexo_consumable_view = parseFloat($("#screen_flexo_consumable_view").val()) ;
   		var spring_consumable_view = parseFloat($("#spring_consumable_view").val()) ;
   		var tube_foil_cost_view = parseFloat($("#tube_foil_cost_view").val()) ;
   		var shoulder_foil_cost_view = parseFloat($("#shoulder_foil_cost_view").val()) ;
   		var cap_shrink_sleeve_cost_view = parseFloat($("#cap_shrink_sleeve_cost_view").val()) ;
   		var cap_foil_cost_view = parseFloat($("#cap_foil_cost_view").val()) ;
   		var cap_metalization_cost_view = parseFloat($("#cap_metalization_cost_view").val()) ;
   		var packing_box_view =  parseFloat($("#packing_box_view").val()) ;
   		//alert(cap_foil_cost_view);

   		var total_cost_per_tube=0;	
   		var total_rm_cost_per_tube = 0;
   		var total_consummable_cost_per_tube = 0;
   		var total_packing_cost_per_tube = 0;
   		var total_stores_cost_per_tube=0;


			total_cost_per_tube = sleeve_cost_view + lacquer_cost_view + offset_cost_view + screen_flexo_cost_view+  label_cost_view + special_ink_cost_view + shoulder_cost_view + cap_cost_view + tube_foil_cost_view + shoulder_foil_cost_view + cap_shrink_sleeve_cost_view + cap_metalization_cost_view + cap_foil_cost_view + screen_flexo_consumable_view + offset_consumable_view + spring_consumable_view+hygenic_consumable_view +other_consumable_view + offset_plate_cost_per_tube + screen_film_cost_per_tube + flexo_plate_cost_per_tube+ packing_box_view+ liners_view + customer_flag + other_packing_material + packing_bopp_tape + packing_stickers + packing_corrugated_sheet + packing_shrink_flim + stores_spares_local_view+ stores_spares_import_view;
		//alert(total_cost_per_tube);

			$("#total_cost_per_tube").val(total_cost_per_tube.toFixed(2));
			$("#total_cost_per_tube").html(total_cost_per_tube.toFixed(2));

			//----total of RM
			total_rm_cost_per_tube = sleeve_cost_view + shoulder_cost_view + cap_cost_view + lacquer_cost_view + tube_foil_cost_view + offset_cost_view + screen_flexo_cost_view+ special_ink_cost_view + label_cost_view + shoulder_foil_cost_view + cap_shrink_sleeve_cost_view + cap_metalization_cost_view + cap_foil_cost_view  ;	
			//alert(lacquer_cost_view);

			$("#total_rm_cost_per_tube").val(total_rm_cost_per_tube.toFixed(2));
			$("#total_rm_cost_per_tube").html(total_rm_cost_per_tube.toFixed(2));

			//----total of Consumable
			total_consummable_cost_per_tube = screen_flexo_consumable_view + offset_consumable_view + spring_consumable_view+hygenic_consumable_view +other_consumable_view + offset_plate_cost_per_tube + screen_film_cost_per_tube + flexo_plate_cost_per_tube;
			//alert(flexo_plate_cost_per_tube);

			$("#total_consummable_cost_per_tube").val(total_consummable_cost_per_tube.toFixed(2));
			$("#total_consummable_cost_per_tube").html(total_consummable_cost_per_tube.toFixed(2));

			//----total of Packing
			total_packing_cost_per_tube =  packing_box_view+ liners_view + customer_flag + other_packing_material + packing_bopp_tape +packing_stickers + packing_corrugated_sheet + packing_shrink_flim ;

			//alert(packing_box_view);

			$("#total_packing_cost_per_tube").val(total_packing_cost_per_tube.toFixed(2));
			$("#total_packing_cost_per_tube").html(total_packing_cost_per_tube.toFixed(2));

			//----total of Storese & Spares
			total_stores_cost_per_tube = stores_spares_local_view+ stores_spares_import_view;

			$("#total_stores_cost_per_tube").val(total_stores_cost_per_tube.toFixed(2));
			$("#total_stores_cost_per_tube").html(total_stores_cost_per_tube.toFixed(2));	
			
     	if($("#waste_perc").val() == ''){
     		//alert('hi') ;
     	}else{

     		var waste_perc = total_cost_per_tube*parseFloat($("#waste_perc").val()) / 100 ; 
				var waste_total_cost_per_tube = 0;
				waste_total_cost_per_tube = waste_perc + total_cost_per_tube + freight ;
				//alert(waste_perc);

				var waste_5k= waste_total_cost_per_tube+(parseFloat($("#_5k_waste").val()) / 100)*waste_total_cost_per_tube;
				if($("#running_speed_90").val()!=''){

				$("._5k_quote_cost").val(waste_5k.toFixed(2));
				
				var quoted_5k_contribution=(((parseFloat($("#_5k").val())/parseFloat($("#running_speed_90").val()))+parseFloat($("#job_changeover").val()))*parseFloat($("#min_contribution").val())*(parseFloat($("#capacity").val())/1440))/parseFloat($("#_5k").val());
				//alert(quoted_5k_contribution);
				$("#_5k_quoted_contr").val(quoted_5k_contribution.toFixed(2));
				
				var waste_10k= waste_total_cost_per_tube+(parseFloat($("#_10k_waste").val()) / 100)*waste_total_cost_per_tube;
				$("._10k_quote_cost").val(waste_10k.toFixed(2));

				var quoted_10k_contribution=(((parseFloat($("#_10k").val())/parseFloat($("#running_speed_90").val()))+parseFloat($("#job_changeover").val()))*parseFloat($("#min_contribution").val())*(parseFloat($("#capacity").val())/1440))/parseFloat($("#_10k").val());
				//alert(quoted_5k_contribution);
				$("#_10k_quoted_contr").val(quoted_10k_contribution.toFixed(2));
			
				var waste_25k= waste_total_cost_per_tube+(parseFloat($("#_25k_waste").val()) / 100)*waste_total_cost_per_tube;
				$("._25k_quote_cost").val(waste_25k.toFixed(2));

				var quoted_25k_contribution=(((parseFloat($("#_25k").val())/parseFloat($("#running_speed_90").val()))+parseFloat($("#job_changeover").val()))*parseFloat($("#min_contribution").val())*(parseFloat($("#capacity").val())/1440))/parseFloat($("#_25k").val());
				//alert(quoted_5k_contribution);
				$("#_25k_quoted_contr").val(quoted_25k_contribution.toFixed(2));

				var waste_50k= waste_total_cost_per_tube+(parseFloat($("#_50k_waste").val()) / 100)*waste_total_cost_per_tube;
				$("._50k_quote_cost").val(waste_50k.toFixed(2));

				var quoted_50k_contribution=(((parseFloat($("#_50k").val())/parseFloat($("#running_speed_90").val()))+parseFloat($("#job_changeover").val()))*parseFloat($("#min_contribution").val())*(parseFloat($("#capacity").val())/1440))/parseFloat($("#_50k").val());
				//alert(quoted_5k_contribution);
				$("#_50k_quoted_contr").val(quoted_50k_contribution.toFixed(2));

				var waste_100k= waste_total_cost_per_tube+(parseFloat($("#_100k_waste").val()) / 100)*waste_total_cost_per_tube;
				$("._100k_quote_cost").val(waste_100k.toFixed(2));

				var quoted_100k_contribution=(((parseFloat($("#_100k").val())/parseFloat($("#running_speed_90").val()))+parseFloat($("#job_changeover").val()))*parseFloat($("#min_contribution").val())*(parseFloat($("#capacity").val())/1440))/parseFloat($("#_100k").val());
				//alert(quoted_5k_contribution);
				$("#_100k_quoted_contr").val(quoted_100k_contribution.toFixed(2));
				}

				if($("#_5k_quoted_contr").val()!='' && $("#_5k_cost").val()!=''){
					
						//var less_than_10k_quoted_contr=$("#less_than_10k_quoted_contr").val();
						//alert(parseInt(less_than_10k_quoted_contr).toFixed(1));

						var _5k_quoted_price=parseFloat($("#_5k_quoted_contr").val()) + parseFloat($("#_5k_cost").val());
						$("#_5k_quoted_price").val(_5k_quoted_price.toFixed(2));
					
			}

			if($("#_10k_quoted_contr").val()!='' && $("#_10_cost").val()!=''){
					
						var _10k_quoted_price=	parseFloat($("#_10k_quoted_contr").val()) + parseFloat($("#_10k_cost").val());
						$("#_10k_quoted_price").val(_10k_quoted_price.toFixed(2));
					
			}

			if($("#_25k_quoted_contr").val()!='' && $("#_25k_cost").val()!=''){
					
						var _25k_quoted_price=	parseFloat($("#_25k_quoted_contr").val()) + parseFloat($("#_25k_cost").val());
						$("#_25k_quoted_price").val(_25k_quoted_price.toFixed(2));
					
			}

			if($("#_50k_quoted_contr").val()!='' && $("#_50k_cost").val()!=''){
					
						var _50k_quoted_price=	parseFloat($("#_50k_quoted_contr").val()) + parseFloat($("#_50k_cost").val());
						$("#_50k_quoted_price").val(_50k_quoted_price.toFixed(2));
					
			}

			if($("#_100k_quoted_contr").val()!='' && $("#_100k_cost").val()!=''){
					
						var _100k_quoted_price=	parseFloat($("#_100k_quoted_contr").val()) + parseFloat($("#_100k_cost").val());
						$("#_100k_quoted_price").val(_100k_quoted_price.toFixed(2));
					
			}
			if($("#free_quantity").val()!='' && $("#_free_quantity_waste").val()!=''){
					
						var free_quoted_price=	parseFloat($("#free_quoted_contr").val()) + parseFloat($("#free_cost").val());
						$("#free_quoted_price").val(free_quoted_price.toFixed(2));

						var waste_free_quantity= waste_total_cost_per_tube+(parseFloat($("#_free_quantity_waste").val()) / 100)*waste_total_cost_per_tube;
					$("._free_quantity_quote_cost").val(waste_free_quantity.toFixed(2));

					var free_quoted_contr=(((parseFloat($("#free_quantity").val())/parseFloat($("#running_speed_90").val()))+parseFloat($("#job_changeover").val()))*parseFloat($("#min_contribution").val())*(parseFloat($("#capacity").val())/1440))/parseFloat($("#free_quantity").val());
				//alert(quoted_5k_contribution);
					$("#free_quoted_contr").val(free_quoted_contr.toFixed(2));

					
			}

				$(".quote_cost").val(waste_total_cost_per_tube.toFixed(2));
				$("#waste_total_cost_per_tube").html(waste_total_cost_per_tube.toFixed(2));
				$("#waste_total_cost_per_tube").val(waste_total_cost_per_tube.toFixed(2));
     	}
			
				
				
		



		}); 

	});//Jquery closed

</script>
<style type="text/css">
	fieldset {border: 1px solid #8cacbb;}
	fieldset legend{font-weight: bold;}
	.number{
		width:25%;
	}
	.number1{
		width:100%;
	}
	
</style>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/approval_update');?>" method="POST" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<?php foreach($sales_quote_master as $row):
			/*$customer_name='';
			$customer_category_result=$this->common_model->select_one_active_record('address_category_master',$this->session->userdata['logged_in']['company_id'],'adr_category_id',$row->customer_no);

			foreach ($customer_category_result as $key => $customer_category_row) {
				$customer_name=$customer_category_row->category_name."//".$customer_category_row->adr_category_id;
			}

			*/
			/*
			$customer_name='';
			$sales_quote_customer_master_result=$this->common_model->select_one_active_record('sales_quote_customer_master',$this->session->userdata['logged_in']['company_id'],'customer_id',$row->customer_no);

			foreach ($sales_quote_customer_master_result as $key => $sales_quote_customer_master_row) {
				$customer_name=$sales_quote_customer_master_row->customer_name."//".$sales_quote_customer_master_row->customer_id;
			}
				*/


		 ?>	

			<table class="form_table_design" id="abc">
			<tr>
				<td width="50%">
					<table class="form_table_inner" width="100%">
						<tr>
							<td>
								<fieldset>
									<legend>Information:</legend>
									<table class="form_table_inner">	
										<tr>

											<td class="label"  width="26%"> Quotation No : <span style="color:red;">*</span> :</td>
											<td colspan="3">
												<input type="text" name="quotation_no" value="<?php echo $row->quotation_no;?>" readonly>
											</td>		

											<td class="label" width="20%">Version No <span style="color:red;">*</span> :</td>
											<td width="25%">

											<input type="text" name="version_no" size="5" value="<?php echo $row->version_no;?>" readonly >
											
											</td>								
										</tr>

										<tr>

											<td class="label"  width="26%"> Customer: <span style="color:red;">*</span> :</td>
											<td colspan="3">
												<input type="hidden" name="id" value="<?php echo $row->id;?>" readonly>
												<input type="hidden" name="transaction_no" value="<?php echo $this->uri->segment(5);?>" readonly>	
												<input type="hidden" name="record_no" value="<?php echo $row->quotation_no.'@@@'.$row->version_no;?>" readonly>
												<input type="text"  disabled  name="customer" id="customer_category"  size="50" value="<?php echo set_value('category_name',$row->category_name.'//'.$row->customer_no.'');?>" /></td>
												
																	
										</tr>
										<tr>							
											<td class="label">Purchase Manager <span style="color:red;">*</span> :</td>
											<!-- <td colspan="3"><input type="text"  name="pm_1" id="pm_1" value="<?php echo set_value('pm_1',$row->pm_1);?>" />
											</td>  -->
																												
															
											 <td colspan="3">
												
												<select name="pm_1" id="pm_1" disabled>
												<option value=''>--Select PM--</option>
													<?php if($purchase_manager==FALSE){
													echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach ($purchase_manager as $purchase_manager_row) {
														$selected=($purchase_manager_row->address_category_contact_id==$row->pm_1?'selected':'');

														echo "<option value='".$purchase_manager_row->address_category_contact_id."' ".set_select('pm_1',''.$purchase_manager_row->address_category_contact_id.'').$selected.">".$purchase_manager_row->contact_name."</option>";
													}
													}?>
												</select>
											</td>	 		 
										</tr>
									
										
										
										<tr>							
											<td class="label">Product Name <span style="color:red;">*</span> :</td>
											<td colspan="3"> <input type="text" disabled name="product_name"  size="50" value="<?php echo set_value('product_name',$row->product_name);?>" />
																	
											</td>								
										</tr>

										<tr>
											<td class="label">Payment Terms <span style="color:red;">*</span>  :</td>
											<td colspan="3"><input type="text" disabled name="credit_days" value="<?php echo set_value('credit_days',$row->credit_days	);?>" >
											</td>
									 	</tr>

									 	<tr>
											<td class="label">Date of Enquiry <span style="color:red;">*</span>  :</td>
											<td colspan="3"><input type="date" disabled name="enquiry_date" value="<?php echo set_value('enquiry_date',$row->enquiry_date	);?>" >
											</td>
									 	</tr>
										


									</table>
								</fieldset>
							</td>
						</tr>

						<tr>
							<td colspan="4">
								<fieldset>
									<legend>Tube Specification:</legend>
								<table class="form_table_inner">

									<tr>
										<td class="label" width="25%">Tube Dia <span style="color:red;">*</span>:</td>
										<td width="25%"><select disabled name="sleeve_dia" id="sleeve_dia" ><option value=''>--Select Dia--</option>
										<?php if($sleeve_dia==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($sleeve_dia as $sleeve_dia_row){
													$selected=($sleeve_dia_row->sleeve_id==$row->sleeve_dia ? 'selected' : '');

													echo "<option value='".$sleeve_dia_row->sleeve_diameter."//".$sleeve_dia_row->sleeve_id."' $selected ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_diameter.'//'.$sleeve_dia_row->sleeve_id.'').">".$sleeve_dia_row->sleeve_diameter."</option>";
												}
										}?>


									</select>
										</td>
										<td class="label" width="25%">Tube Length <span style="color:red;">*</span> :</td>
										<td width="25%"><input type="number" class="number1" disabled name="sleeve_length" min="10"  max="500" step="0.1"  id="sleeve_length"  maxlength="5" value="<?php echo set_value('sleeve_length',$row->sleeve_length);?>" >
										</td>

									</tr>

									<tr>
										<td class="label">Layer <span style="color:red;">*</span> :</td>
										<td>
											<select disabled name="layer" id="layer" >
												<option value="">--Select Layer--</option>							 
												<option value="1" <?php echo set_select('layer',1);?>  <?php echo($row->layer=='1'?"selected":"");?>>1</option>
												<option value="2" <?php echo set_select('layer',2);?> <?php echo($row->layer=='2'?"selected":"");?>>2</option>
												<option value="3" <?php echo set_select('layer',3);?> <?php echo($row->layer=='3'?"selected":"");?> >3</option>
												
												<option value="5" <?php echo set_select('layer',5);?>  <?php echo($row->layer=='5'?"selected":"");?>>5</option>
												
												<option value="7" <?php echo set_select('layer',7);?>  <?php echo($row->layer=='7'?"selected":"");?>>7</option>
												
											</select>
										</td>
										<td><span class="layer_link"><i class="window maximize outline icon"></i></span></td>
									</tr>

									

									<tr>
										<td class="label">Tube Color <span style="color:red;">*</span>  :</td>
										<td colspan="3"><input type="text" disabled name="tube_color" id="tube_color"value="<?php echo set_value('tube_color',$row->tube_color);?>"><a href="<?php echo base_url('index.php/color_master');?>" target="_blank"><i class="edit icon"></i></a>
										</td>
									</tr>
									
									<tr>
										<td class="label">Tube Lacquer <span style="color:red;">*</span> :</td>
										<td>
											<select disabled name="tube_lacquer" id="tube_lacquer" >
												<option value="">--Select Tube Lacquer--</option>
												<option value="YES" <?php echo set_select('tube_lacquer','YES');?> <?php echo($row->tube_lacquer=='YES'?"selected":"");?> >YES</option>
												<option value="NO" <?php echo set_select('tube_lacquer','NO');?> <?php echo($row->tube_lacquer=='NO'?"selected":"");?> >NO</option>
											</select>
											
										</td>
										<td><span id="lacquer_link" ><i class="window maximize outline icon"></i></span></td>
									</tr>

									<tr>
										<td class="label">Tube Print Type <span style="color:red;">*</span> :</td>
										<td>
											<select disabled name="print_type" id="print_type" >
												<option value=''>--Select Print Type --</option>
										<?php if($print_type==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
										else{
											foreach($print_type as $print_type_row){
												$selected=($print_type_row->print_type==$row->print_type?'selected':'');
												echo "<option value='".$print_type_row->print_type."'  ".set_select('print_type',''.$print_type_row->print_type.'').$selected.">".$print_type_row->print_type."</option>";
												}
											}?>
											</select>
											
										</td>

										<td><span class="tube_print_link"><i class="window maximize outline icon"></i></span></td>
									</tr>
									
									<tr>
										<td class="label">Special Ink <span style="color:red;">*</span> :</td>	 
										<td>  
											<select disabled name="special_ink" id="special_ink" >
												<option value="">--Select Special ink--</option>
												<option value="YES" <?php echo set_select('special_ink','YES');?> <?php echo($row->special_ink=='YES'?"selected":"");?>>YES</option>
												<option value="NO" <?php echo set_select('special_ink','NO');?> <?php echo($row->special_ink=='NO'?"selected":"");?> >NO</option>
											</select>							
										</td>
										<td><span id="special_ink_link"><i class="window maximize outline icon"></i></span></td>
									</tr>
								
									
								</table>
							</fieldset>
						</td>
						</tr>


						<tr>
							<td colspan="4">
								<fieldset>
									<legend>Shoulder Specification:</legend>
								<table class="form_table_inner">

									<tr>
										<td class="label">Shoulder <span style="color:red;">*</span> :</td>
										<td><select disabled name="shoulder" id="shoulder"><option value=''>--Select Shoulder--</option>
										

										<?php if($shoulder_types==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($shoulder_types as $shoulder_types_row){
													$selected=($shoulder_types_row->shld_type_id==$row->shoulder ? 'selected' : '');
													echo "<option value='".$shoulder_types_row->shoulder_type."//".$shoulder_types_row->shld_type_id."' $selected ".set_select('shoulder',''.$shoulder_types_row->shoulder_type.'//'.$shoulder_types_row->shld_type_id.'').">".$shoulder_types_row->shoulder_type."</option>";
												}
										}?>
										</select></td>
									</tr>
									<tr>

										<td class="label">Shoulder Orifice  :</td>
										<td colspan="3"><select disabled name="shoulder_orifice" id="shoulder_orifice"><option value=''>--Select Orifice--</option>
										<?php if($shoulder_orifice==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($shoulder_orifice as $shoulder_orifice_row){
													$selected=($shoulder_orifice_row->orifice_id==$row->shoulder_orifice ? 'selected' : '');
													echo "<option value='".$shoulder_orifice_row->shoulder_orifice."//".$shoulder_orifice_row->orifice_id."' $selected ".set_select('shoulder_orifice',''.$shoulder_orifice_row->shoulder_orifice.'//'.$shoulder_orifice_row->orifice_id.'').">".$shoulder_orifice_row->shoulder_orifice."</option>";
												}
										}?></select></td>
										<td><span id="shoulder_link"><i class="window maximize outline icon"></i></span></td>
									</tr>
									

									<tr>
										<td class="label">Shoulder Color <span style="color:red;">*</span>  :</td>
										<td colspan="3"><input type="text" disabled name="shoulder_color" id="shoulder_color" value="<?php echo set_value('shoulder_color',$row->shoulder_color);?>" >
										</td>
									</tr>
								</table>
								</fieldset>
							</td>
				
						</tr>

						<tr>
							<td colspan="4">
								<fieldset>
									<legend>Cap  Specification:</legend>
								<table class="form_table_inner">

									<tr>
										<td class="label">Cap Type <span style="color:red;">*</span> :</td>
										<td>

											<select disabled name="cap_type" id="cap_type" ><option value=''>--Select Cap Type--</option>
											

											<?php if($cap_type==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($cap_type as $cap_type_row){
													$selected=($cap_type_row->cap_type_id==$row->cap_type ? 'selected' : '');

													echo "<option value='".$cap_type_row->cap_type."//".$cap_type_row->cap_type_id."' $selected ".set_select('cap_type',''.$cap_type_row->cap_type.'//'.$cap_type_row->cap_type_id.'').">".$cap_type_row->cap_type."</option>";
												}
										}?>

											</select>
										</td>
									</tr>

									<tr>
										<td class="label">Cap Finish <span style="color:red;">*</span> :</td>
										<td>
											
											<select disabled name="cap_finish" id="cap_finish" >
												<option value="">--Select Cap Finish--</option>
												<?php if($cap_finish==FALSE){
																echo "<option value=''>--Setup Required--</option>";}
													else{
														foreach($cap_finish as $cap_finish_row){
															$selected=($cap_finish_row->cap_finish_id==$row->cap_finish? 'selected' : '');
															echo "<option value='".$cap_finish_row->cap_finish."//".$cap_finish_row->cap_finish_id."' $selected ".set_select('cap_finish',''.$cap_finish_row->cap_finish.'//'.$cap_finish_row->cap_finish_id.'').">".$cap_finish_row->cap_finish."</option>";
														}
												}?>
											</select>
										</td>	
										
									</tr>
									<tr>
										<td class="label">Cap Dia <span style="color:red;">*</span> :</td>
										<td><select disabled name="cap_dia" id="cap_dia"><option value=''>--Select Cap Dia--</option>
										<?php if($cap_dia==FALSE){
															echo "<option value=''>--Setup Required--</option>";}
												else{
													foreach($cap_dia as $cap_dia_row){
														$selected=($cap_dia_row->cap_dia_id==$row->cap_dia ? 'selected' : '');
														echo "<option value='".$cap_dia_row->cap_dia."//".$cap_dia_row->cap_dia_id."' $selected ".set_select('cap_dia',''.$cap_dia_row->cap_dia.'//'.$cap_dia_row->cap_dia_id.'').">".$cap_dia_row->cap_dia."</option>";
													}
											}?></select></td>
											<td><span id="cap_link"><i class="window maximize outline icon"></i></span></td>
									</tr>

									<tr>
										<td class="label">Cap Orifice :</td>
										<td><select disabled name="cap_orifice" id="cap_orifice">
										<option value=''>--Select Cap Orifice--</option>
											<?php if($cap_orifice==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($cap_orifice as $cap_orifice_row){
													$selected=($cap_orifice_row->cap_orifice_id==$row->cap_orifice ? 'selected' : '');
													echo "<option value='".$cap_orifice_row->cap_orifice."//".$cap_orifice_row->cap_orifice_id."'  $selected ".set_select('cap_orifice',''.$cap_orifice_row->cap_orifice.'//'.$cap_orifice_row->cap_orifice_id.'').">".$cap_orifice_row->cap_orifice."</option>";
												}
										}?></select>
										</td>
									</tr>


									<tr>
										<td class="label">Cap Color <span style="color:red;">*</span>  :</td>
										<td colspan="3"><input type="text" disabled name="cap_color" id="cap_color" value="<?php echo set_value('cap_color',$row->cap_color);?>" >
										</td>
									</tr>
									
								</table>
								</fieldset>
							</td>
				
						</tr>

						<tr>
							<td colspan="4">
								<fieldset>
									<legend>Decorative Elements:</legend>
								<table class="form_table_inner">

									<tr>
										<td class="label">Tube Foil <span style="color:red;">*</span>:</td>
										<td colspan="3">
											<select disabled name="tube_foil" id="tube_foil" >
												<option value="">--Select Tube Foil--</option>
												<option value="YES" <?php echo set_select('tube_foil','YES');?> <?php echo($row->tube_foil=='YES'?"selected":"");?>>YES</option>
												<option value="NO" <?php echo set_select('tube_foil','NO');?> <?php echo($row->tube_foil=='NO'?"selected":"");?> >NO</option>
											</select>
										</td>
										<td><span id="tube_foil_link"><i class="window maximize outline icon"></i></span></td>
									</tr>

									<tr>
										<td class="label">Shoulder Foil <span style="color:red;">*</span>:</td>
										<td colspan="3">
											<select disabled name="shoulder_foil" id="shoulder_foil" >
												<option value="">--Select Tube Foil--</option>
												<option value="YES" <?php echo set_select('shoulder_foil','YES');?> <?php echo($row->shoulder_foil=='YES'?"selected":"");?>>YES</option>
												<option value="NO" <?php echo set_select('shoulder_foil','NO');?> <?php echo($row->shoulder_foil=='NO'?"selected":"");?>>NO</option>
											</select>
										</td>
										<td><span id="shoulder_foil_link"><i class="window maximize outline icon"></i></span></td>
									</tr>

									<tr>
										<td class="label">Cap Shirnk Sleeve <span style="color:red;">*</span> :</td>
										<td>
											<select disabled name="cap_shrink_sleeve" id="cap_shrink_sleeve" >
												<option value="">--Select Shrink Sleeve--</option>
												<option value="YES" <?php echo set_select('cap_shrink_sleeve','YES');?> <?php echo($row->cap_shrink_sleeve=='YES'?"selected":"");?>>YES</option>
												<option value="NO" <?php echo set_select('cap_shrink_sleeve','NO');?> <?php echo($row->cap_shrink_sleeve=='NO'?"selected":"");?> >NO</option>
											</select>
										</td>
										<td><span id="cap_shrink_sleeve_link"><i class="window maximize outline icon"></i></span></td>
									</tr>

									<!--//-----------------------CAP Metalizaion and Cap Foil CheckBox-->

									<?php
                    if($this->input->post('cap_metalization') &&  $this->input->post('cap_metalization')=='YES'){

                      echo '<tr>
                      <td class="label">Cap Metalization :</td>
                      <td><input type="checkbox" name="cap_metalization" id="cap_metalization" value="YES" '.set_checkbox('cap_metalization','YES').' '.($row->cap_metalization=='YES' ? 'value="YES" checked' : 'value="NO"').'/></td>
                    </tr>

                    <tr id="metalization_div">
                      <td></td><td>
                    Color : &nbsp;&nbsp;<select name="cap_metalization_color" id="cap_metalization_color">
                      <option value="">--Select--</option>
                      <option value="GOLD" "'.set_select('cap_metalization_color', 'GOLD').'">GOLD</option>
                      <option value="SILVER" "'.set_select('cap_metalization_color', 'SILVER').'">SILVER</option>
                      <option value="PINK" "'.set_select('cap_metalization_color', 'PINK').'">PINK</option>
                      <option value="CHAMPION" "'.set_select('cap_metalization_color', 'CHAMPION').'">CHAMPION</option>
                      <option value="WINE" "'.set_select('cap_metalization_color', 'WINE').'">WINE</option>
                      <option value="COPPER" "'.set_select('cap_metalization_color', 'COPPER').'">COPPER</option>
                      <option value="BELLISIMA" "'.set_select('cap_metalization_color', 'BELLISIMA').'">BELLISIMA</option>
                      
                      <option value="MAGENTA" "'.set_select('cap_metalization_color', 'MAGENTA').'">MAGENTA</option>
                      <option value="LIGHT PURPLE" "'.set_select('cap_metalization_color', 'LIGHT PURPLE').'">LIGHT PURPLE</option>
                      <option value="RHODAMINE RED" "'.set_select('cap_metalization_color', 'RHODAMINE RED').'">RHODAMINE RED</option>
                      <option value="ROSE GOLD" "'.set_select('cap_metalization_color', 'ROSE GOLD').'">ROSE GOLD</option>
                      <option value="SHINY GOLD" "'.set_select('cap_metalization_color', 'SHINY GOLD').'">SHINY GOLD</option>
                      <option value="COCO BROWN" "'.set_select('cap_metalization_color', 'COCO BROWN').'">COCO BROWN</option>

                    </select>


                    <br/>

                    Finish : <select name="cap_metalization_finish" id="cap_metalization_finish">
                      <option value="">--Select--</option>
                      <option value="GLOSS" "'.set_select('cap_metalization_finish', 'GLOSS').'">GLOSS</option>
                      <option value="MATT" "'.set_select('cap_metalization_finish', 'MATT').'">MATT</option>
                    </select>
                  </td>
                  </tr>';
                    }else{?>
							<tr>
								<td class="label">Cap Metalization :</td>
								<td><input type="checkbox" disabled name="cap_metalization" id="cap_metalization" value="YES" <?php echo set_checkbox('cap_metalization','YES');?> <?php echo ($row->cap_metalization=='YES' ? 'value="YES" checked' : 'value="NO"');?> /></td>
							</tr>

							<tr id="metalization_div" <?php echo ($row->cap_metalization=='YES' ? '' : 'style="display: none"');?>>
								<td></td><td>
							Color : &nbsp;&nbsp;<select name="cap_metalization_color" id="cap_metalization_color">
                      <option value="">--Select--</option>
                      <option value='GOLD' <?php echo  set_select('cap_metalization_color', 'GOLD'); ?> <?php echo($row->cap_metalization_color=='GOLD'?"selected":"");?>>GOLD</option>
                      <option value='SILVER' <?php echo  set_select('cap_metalization_color', 'SILVER'); ?><?php echo($row->cap_metalization_color=='SILVER'?"selected":"");?>>SILVER</option>
                      <option value='PINK' <?php echo  set_select('cap_metalization_color', 'PINK'); ?><?php echo($row->cap_metalization_color=='PINK'?"selected":"");?>>PINK</option>
                      <option value='CHAMPION' <?php echo  set_select('cap_metalization_color', 'CHAMPION'); ?><?php echo($row->cap_metalization_color=='CHAMPION'?"selected":"");?>>CHAMPION</option>
                      <option value='WINE' <?php echo  set_select('cap_metalization_color', 'WINE'); ?> <?php echo($row->cap_metalization_color=='WINE'?"selected":"");?>>WINE</option>
                      <option value='COPPER' <?php echo  set_select('cap_metalization_color', 'COPPER'); ?> <?php echo($row->cap_metalization_color=='COPPER'?"selected":"");?>>COPPER</option>
                      <option value='BELLISIMA' <?php echo  set_select('cap_metalization_color', 'BELISIMA'); ?> <?php echo($row->cap_metalization_color=='BELLISIMA'?"selected":"");?>>BELLISIMA</option>
                      <option value='MAGENTA' <?php echo  set_select('cap_metalization_color', 'MAGENTA'); ?> <?php echo($row->cap_metalization_color=='MAGENTA'?"selected":"");?>>MAGENTA</option>
                      <option value='LIGHT PURPLE' <?php echo  set_select('cap_metalization_color', 'LIGHT PURPLE'); ?> <?php echo($row->cap_metalization_color=='LIGHT PURPLE'?"selected":"");?>>LIGHT PURPLE</option>
                      <option value='RHODAMINE RED' <?php echo  set_select('cap_metalization_color', 'RHODAMINE RED'); ?> <?php echo($row->cap_metalization_color=='RHODAMINE'?"selected":"");?>>RHODAMINE RED</option>
                      <option value='ROSE GOLD' <?php echo  set_select('cap_metalization_color', 'ROSE GOLD'); ?> <?php echo($row->cap_metalization_color=='ROSE GOLD'?"selected":"");?>>ROSE GOLD</option>
                      <option value='SHINY GOLD' <?php echo  set_select('cap_metalization_color', 'SHINY GOLD'); ?><?php echo($row->cap_metalization_color=='SHINY GOLD'?"selected":"");?>>SHINY GOLD</option>
                      <option value='COCO BROWN' <?php echo  set_select('cap_metalization_color', 'COCO BROWN'); ?><?php echo($row->cap_metalization_color=='COCO BROWN'?"selected":"");?>>COCO BROWN</option>
                    </select>

										<br/>

										Finish : &nbsp;<select name="cap_metalization_finish" id="cap_metalization_finish">
											<option value="">--Select--</option>
											<option value='GLOSS' <?php echo  set_select('cap_metalization_finish', 'GLOSS'); ?><?php echo($row->cap_metalization_finish=='GLOSS'?"selected":"");?> >GLOSS</option>
											<option value='MATT' <?php echo  set_select('cap_metalization_finish', 'MATT'); ?><?php echo($row->cap_metalization_finish=='MATT'?"selected":"");?>>MATT</option>
										</select>
									</td>
									<td><span id="cap_metalization_link"><i class="window maximize outline icon"></i></span></td>
									</tr>


		                    <?php }
		                    ?>

										<tr>

									<?php
			                    if($this->input->post('cap_foil') &&  $this->input->post('cap_foil')=='YES'){

			                      echo '<tr>
			                      <td class="label">Cap Foil :</td>
			                      <td><input type="checkbox" name="cap_foil" id="cap_foil" value="YES" '.set_checkbox('cap_foil','YES').' '.($row->cap_foil=='YES' ? 'value="YES" checked' : 'value="NO"').'/></td>
			                    </tr>

			                    <tr id="foil_div">
			                      <td></td><td>
			                    Color : &nbsp;&nbsp;
			                    <input type="number" name="cap_foil_width" id="cap_foil_width" value="'.set_value('cap_foil_width').'">

			                    <br/>

			                    Cap Foil Dist From Bottom : &nbsp;
			                    <input type="number" min="0" max="20" step="any"  name="cap_foil_dist_frm_bottom" id="cap_foil_dist_frm_bottom" size="3" maxlength="3" value="'.set_value('cap_foil_dist_frm_bottom').'">
														
			                  </td>
			                  </tr>';
			                    }else{?>
										<tr>
											<td class="label">Cap Foil :</td>
											<td><input type="checkbox" disabled name="cap_foil" id="cap_foil" value="YES" <?php echo set_checkbox('cap_foil','YES');?> <?php echo ($row->cap_foil=='YES' ? 'value="YES" checked' : 'value="NO"');?>/></td>
										</tr>

										<tr id="foil_div" <?php echo ($row->cap_foil=='YES' ? '' : 'style="display: none"');?>>
											<td></td><td>
										Cap Foil Width : &nbsp;&nbsp;
                    			 <input type="number" min="1" max="5" step="any" name="cap_foil_width" id="cap_foil_width" size="3" maxlength="3" value="<?php echo set_value('cap_foil_width',$row->cap_foil_width);?>">

										<br/>

										Cap Foil Dist From Bottom : &nbsp;
											<input type="number" min="0" max="20" step="any"  name="cap_foil_dist_frm_bottom" id="cap_foil_dist_frm_bottom" size="3" maxlength="3" value="<?php echo set_value('cap_foil_dist_frm_bottom',$row->cap_foil_dist_frm_bottom);?>">
									</td>
									<td><span id="cap_foil_link"><i class="window maximize outline icon"></i></span></td>
									</tr>


                    <?php }
                    ?>

									<tr>								


								</table>
								</fieldset>
							</td>
				
						</tr>
						<!-- Freight Price Range -->
						
						<tr>
							<td colspan="4">
						
								<fieldset>
									<LEGEND> Freight Cost:</LEGEND>
									<table class="form_table_inner">		
									<tr>
										<td class="label">Freight <span style="color:red;">*</span> :</td>
										<td colspan="3"><input type="text" disabled name="freight" id="freight"  value="<?php echo set_value('freight',$row->freight);?>" />
										</td>
									</tr>									
									</table>
								</fieldset>
							</td>
						</tr>											
					</table>						 
				</td>

		
				<td width="40%">
					<table class="form_table_inner">
						<!-- QUOTE -->
						<tr>
							<td colspan="5" width="100%">
								<fieldset>
										<legend>Quote:</legend>
								<table class="form_table_inner">
									<tr>
										<th></th>
										<th>Machine</th>
										<th>Capacity</th>
										<th>Speed</th>
										<th>Speed 90%</th>										
										<th>Setup Time</th>
										<th>Contribution</th>
									</tr>
									<tr>
										<td width="2%"></td>
										
										<td width="10%">
											<select name="machine_type" id="machine_type" >
												<option value=''>--Machine --</option>
										<?php if($machine_type==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
										else{
											foreach($machine_type as $machine_type_row){
													$selected=($machine_type_row->machine_id==$row->machine_print_type_id?'selected':'');
												echo "<option value='".$machine_type_row->machine_id."'  ".set_select('machine_type',''.$machine_type_row->machine_name.'').$selected.">".$machine_type_row->machine_name."</option>";
												}
											}?>
											</select>
											
										</td>
										<td width="3%">
										<input type="text" readonly="readonly" name="capacity" id="capacity"  size="3" value="<?php echo set_value('capacity',$row->machine_capacity_without_changeover);?>"  /> 
										</td>
										<td width="10%">&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="text" readonly="readonly" name="running_speed" id="running_speed"  size="4" value="<?php echo set_value('running_speed',$row->running_speed);?>"  />
										</td>
										<td width="10%">&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="text" readonly="readonly" name="running_speed_90" id="running_speed_90"  size="4" value="<?php echo set_value('running_speed_90',$row->running_speed * 0.9);?>"  />
										</td>
										<td width="10%">&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="text" name="job_changeover" id="job_changeover"  size="4" value="<?php echo set_value('job_changeover',$row->job_changeover_time);?>"  />
										</td>
										<td width="10%">&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="text" readonly="readonly" name="min_contribution" id="min_contribution" size="4" value="<?php echo set_value('min_contribution',$row->minimum_contribution);?>"  />
										</td>

									</tr>


									<tr>
										<th width="2%"> </th><th width="10%">Quote</th>
										<th width="3%">Waste %</th>
										<!-- <th width="10%">Target Contr.</th> --><th width="10%">Quoted Contr.</th><th width="10%">Cost</th>	<th width="10%">Quoted Price</th><th width="10%">HOD Price</th>
									</tr>
									<tr>
										<td><input type="checkbox" name="_5k_flag" id="_5k_flag" value="1" <?php echo set_checkbox('_5k_flag','1');?><?php echo ($row->_5k_flag=='1' ? 'value="1" checked' : 'value="0"');?>/></td>


										<td class="label"> 5K <input type="hidden" name="_5k" id="_5k" value="5000"><span style="color:red;">*</span></td>
										<td><input type="text" readonly="readonly" style="background-color: #ddd" name="_5k_waste" id="_5k_waste"   value="<?php echo set_value('_5k_waste',$row->_5k_waste);?>"  size="3"/></td>
										<!-- <td ><input type="text" class="number1" name="_5k_target_contr" id="_5k_target_contr"   value="<?php echo set_value('_5k_target_contr',$row->_5k_target_contr);?>"  />
										</td> -->
										<td ><input type="text" readonly="readonly" style="background-color: #ddd" class="number1" name="_5k_quoted_contr" id="_5k_quoted_contr"  value="<?php echo set_value('_5k_quoted_contr',$row->_5k_quoted_contr);?>"  size="4"/>
										</td>
										<td ><input readonly="readonly" style="background-color: #ddd" type="text" class="number1 _5k_quote_cost" name="_5k_cost" id="_5k_cost"  value="<?php echo set_value('_5k_cost',$row->_5k_cost);?>" size="4"/>
										</td>
										<td > <input type="text" style="background-color: #ddd" class="number1" name="_5k_quoted_price" id="_5k_quoted_price"  value="<?php echo set_value('_5k_quoted_price',$row->_5k_quoted_price);?>" size="4"/>
										</td>
										<td ><input type="text" class="number1" name="_5k_approved_contr" id="_5k_approved_contr"   value="<?php echo set_value('_5k_approved_contr','0');?>"  />
										</td>
									</tr>
									<tr>
										<td><input type="checkbox" name="_10k_flag" id="_10k_flag" value="1" <?php echo set_checkbox('_10k_flag','1');?> <?php echo ($row->_10k_flag=='1' ? 'value="1" checked' : 'value="0"');?>/></td>
										<td class="label" >10K <input type="hidden" name="_10k" id="_10k" value="10000"><span style="color:red;">*</span></td>
										<td><input type="text" readonly="readonly" style="background-color: #ddd" size="3" name="_10k_waste" id="_10k_waste"  value="<?php echo set_value('_10k_waste',$row->_10k_waste);?>"  /></td>
										<!-- <td><input type="text" class="number1" name="_10k_target_contr" id="_10k_target_contr"  value="<?php echo set_value('_10k_target_contr',$row->_10k_target_contr);?>" />
										</td> -->
										<td><input type="text" readonly="readonly" style="background-color: #ddd" class="number1" name="_10k_quoted_contr" id="_10k_quoted_contr"  value="<?php echo set_value('_10k_quoted_contr',$row->_10k_quoted_contr);?>" />
										</td>
										<td><input readonly="readonly" style="background-color: #ddd" type="text" class="number1 _10k_quote_cost" name="_10k_cost"  id="_10k_cost"   value="<?php echo set_value('_10k_cost',$row->_10k_cost);?>"  />
										</td>
										<td><input type="text" readonly="readonly" style="background-color: #ddd" class="number1" name="_10k_quoted_price" id="_10k_quoted_price" value="<?php echo set_value('_10k_quoted_price',$row->_10k_quoted_price);?>" />
										</td>
										<td ><input type="text"  class="number1" name="_10k_approved_contr" id="_10k_approved_contr"   value="<?php echo set_value('_10k_approved_contr','0');?>"  />
										</td>
									</tr>
									<tr>
										<td><input type="checkbox" name="_25k_flag" id="_25k_flag" value="1" <?php echo set_checkbox('_25k_flag','1');?> <?php echo ($row->_25k_flag=='1' ? 'value="1" checked' : 'value="0"');?>/></td>
										<td class="label">25K  <input type="hidden" name="_25k" id="_25k" value="25000"><span style="color:red;">*</span></td>
										<td><input type="text" readonly="readonly" style="background-color: #ddd" size="3" name="_25k_waste" id="_25k_waste"   value="<?php echo set_value('_25k_waste',$row->_25k_waste);?>"  /></td>
										<!-- <td><input type="text" class="number1" name="_25k_target_contr" id="_25k_target_contr"  value="<?php echo set_value('_25k_target_contr',$row->_25k_target_contr);?>" />
										</td> -->
										<td><input type="text" readonly="readonly" style="background-color: #ddd" class="number1" name="_25k_quoted_contr" id="_25k_quoted_contr"  value="<?php echo set_value('_25k_quoted_contr',$row->_25k_quoted_contr);?>" />
										</td>
										<td><input readonly="readonly" style="background-color: #ddd" type="text" class="number1 _25k_quote_cost" name="_25k_cost" id="_25k_cost"  value="<?php echo set_value('_25k_cost',$row->_25k_cost);?>" />
										</td>
										<td><input type="text" readonly="readonly" style="background-color: #ddd" class="number1" name="_25k_quoted_price" id="_25k_quoted_price"  value="<?php echo set_value('_25k_quoted_price',$row->_25k_quoted_price);?>" />
										</td>
										<td ><input type="text" class="number1" name="_25k_approved_contr" id="_25k_approved_contr"   value="<?php echo set_value('_25k_approved_contr','0');?>"  />
										</td>
									</tr>
									<tr>
										<td><input type="checkbox" name="_50k_flag" id="_50k_flag" value="1" <?php echo set_checkbox('_50k_flag','1');?> <?php echo ($row->_50k_flag=='1' ? 'value="1" checked' : 'value="0"');?>/></td>
										<td class="label">50K <input type="hidden" name="_50k" id="_50k" value="50000"><span style="color:red;">*</span></td>
										<td><input type="text" readonly="readonly" style="background-color: #ddd" size="3" name="_50k_waste" id="_50k_waste"   value="<?php echo set_value('_50k_waste',$row->_50k_waste);?>"  /></td>										
										<!-- <td><input type="text" class="number1" name="_50k_target_contr" id="_50k_target_contr"  value="<?php echo set_value('_50k_target_contr',$row->_50k_target_contr);?>" />
										</td> -->
										<td><input type="text" readonly="readonly" style="background-color: #ddd" class="number1" name="_50k_quoted_contr" id="_50k_quoted_contr"  value="<?php echo set_value('_50k_quoted_contr',$row->_50k_quoted_contr);?>" />
										</td>
										<td><input readonly="readonly" style="background-color: #ddd" type="text" class="number1 _50k_quote_cost" name="_50k_cost" id="_50k_cost"  value="<?php echo set_value('_50k_cost',$row->_50k_cost);?>"  />
										</td>
										<td><input type="text" readonly="readonly" style="background-color: #ddd" class="number1" name="_50k_quoted_price" id="_50k_quoted_price"  value="<?php echo set_value('_50k_quoted_price',$row->_50k_quoted_price);?>" />
										</td>
										<td ><input type="text" class="number1" name="_50k_approved_contr" id="_50k_approved_contr"   value="<?php echo set_value('_50k_approved_contr','0');?>"  />
										</td>
									</tr>
									<tr>
										<td><input type="checkbox" name="_100k_flag" id="_100k_flag" value="1" <?php echo set_checkbox('_100k_flag','1');?><?php echo ($row->_100k_flag=='1' ? 'value="1" checked' : 'value="0"');?>/></td>
										<td class="label">100K  <input type="hidden" name="_100k" id="_100k" value="100000"><span style="color:red;">*</span></td>
										<td><input type="text" readonly="readonly" style="background-color: #ddd" size="3" name="_100k_waste" id="_100k_waste"   value="<?php echo set_value('_100k_waste',$row->_100k_waste);?>"  /></td>
										<!-- <td><input type="text" class="number1" name="_100k_target_contr" id="_100k_target_contr"  value="<?php echo set_value('_100k_target_contr',$row->_100k_target_contr);?>"  />
										</td> -->
										<td><input type="text" readonly="readonly" style="background-color: #ddd" class="number1" name="_100k_quoted_contr" id="_100k_quoted_contr"  value="<?php echo set_value('_100k_quoted_contr',$row->_100k_quoted_contr);?>" />
										</td>
										<td><input readonly="readonly" style="background-color: #ddd" type="text" class="number1 _100k_quote_cost" name="_100k_cost" id="_100k_cost"  value="<?php echo set_value('_100k_cost',$row->_100k_cost);?>"  />
										</td>
										<td><input type="text" readonly=""readonly style="background-color: #ddd" class="number1" name="_100k_quoted_price" id="_100k_quoted_price" value="<?php echo set_value('_100k_quoted_price',$row->_100k_quoted_price);?>" />
										</td>
										<td ><input type="text" class="number1" name="_100k_approved_contr" id="_100k_approved_contr"   value="<?php echo set_value('_100k_approved_contr','0');?>"  />
										</td>
									</tr>
									<tr>
										<td><input type="checkbox" name="free_flag" id="free_flag" value="1" <?php echo set_checkbox('free_flag','1');?> <?php echo ($row->free_flag=='1' ? 'value="1" checked' : 'value="0"');?>/></td>
											
										<td class="label"> <input type="text" name="free_quantity" id="free_quantity"  size="10" value="<?php echo set_value('free_quantity',$row->free_quantity);?>"></td>
										<td><input type="text" readonly="readonly" style="background-color: #ddd" size="3" name="_free_quantity_waste" id="_free_quantity_waste"   value="<?php echo set_value('_free_quantity_waste',$row->_free_quantity_waste);?>"  /></td>
										<!-- <td><input type="text" class="number1" name="free_target_contr" id="free_target_contr"  value="<?php echo set_value('free_target_contr',$row->free_target_contr);?>"  />
										</td> -->
										<td><input type="text" readonly="readonly" style="background-color: #ddd" class="number1" name="free_quoted_contr" id="free_quoted_contr"  value="<?php echo set_value('free_quoted_contr',$row->free_quoted_contr);?>" />
										</td>
										<td><input readonly="readonly" style="background-color: #ddd" type="text" class="number1 _free_quantity_quote_cost" name="free_cost" id="free_cost"  value="<?php echo set_value('free_cost',$row->free_cost);?>" />
										</td>
										<td><input type="text" readonly="readonly" style="background-color: #ddd" class="number1" name="free_quoted_price" id="free_quoted_price"  value="<?php echo set_value('free_quoted_price',$row->free_quoted_price);?>"  />
										</td>
										<td ><input type="text" class="number1" name="_free_approved_contr" id="_free_approved_contr"   value="<?php echo set_value('_free_approved_contr','0');?>"  />
										</td>
									</tr>

								</table>
							</fieldset>
							</td>
						</tr>
							


						<!-- Customer Price Range -->
						
						<!-- Cost sheet details -->
						<tr>
							<td colspan="4">						
								<fieldset>
									<LEGEND> Cost Taken Based On:</LEGEND>
									<table>		
										
										<tr>
											<td class="label">Invoice no :</td>
											<td colspan="3"><input type="text" name="invoice_no" id="invoice_no"  value="<?php echo set_value('invoice_no',$row->invoice_no);?>" />
											</td>
										</tr>
										
											


									</table>
								</fieldset>
							</td>				
						</tr>

						<!-- Sales Quote Upload details -->
						<tr>
							<td colspan="4">						
								<fieldset>
									<LEGEND> Upload:</LEGEND>
									<table>		
										
										<tr>
											<td class="label">File Upload <span style="color:red;">*</span> :</td>
											<td><input type="file" multiple="" name="userfile" disabled></td>
											
										</tr>
										<?php if(!empty($row->images)){
											echo '<tr>
														<td>Uploaded File  <input type="hidden" name="sales_files" value="'.$row->images.'" readonly> </td>

														<td><a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/sales_quote_ref/'.$row->images.'').'" ><i class="file pdf outline icon"></i></a></td>
												</tr>';
											}?>
											


									</table>
								</fieldset>
							</td>				
						</tr>

						<tr>
							<td>
								<fieldset>
									<legend>Remarks:</legend>

									<table class="form_table_inner">
										<tr>
											<td class="label" width="27%">Remarks  :</td>
											<td colspan="3">
												<textarea name="remarks" id="remarks" cols="50" rows="5" value="<?php echo trim(set_value('remarks'));?>" maxlength="512"><?php echo trim(set_value('remarks',$row->remarks));?></textarea>
											</td>
										</tr>
																			
									</table>
								</fieldset>	
									<div class="ui red segment">	
								<table class="ui very basic collapsing celled table" style="font-size:12px">
								<thead>	
									<tr>
										<th colspan="8" class="center aligned"> Rm Cost/Tube</th>
									</tr>
									<tr>
										<th>Rm</th>
										<th> </th>
										<th> Consumable</th>
										<th> </th>
										<th> Packing</th>
										<th> </th>
										<th> Stores & Spares</th>
										<th> </th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Tube </td>
										<td><input type="text" readonly="readonly" id="sleeve_cost_view" name="sleeve_cost_view" value="<?php echo set_value('sleeve_cost_view',$row->sleeve_per_cost);?>" size="5"></td>
										<td>Screen Flexo </td>
										<td><input type="text" readonly="readonly" id="screen_flexo_consumable_view" name="screen_flexo_consumable_view" value="<?php echo set_value('screen_flexo_consumable_view',$row->screen_flexo_consumable_view);?>" size="5"></td>
										<td>Packing Box</td>
										<td><input type="text" readonly="readonly" id="packing_box_view" name="packing_box_view" value="<?php echo set_value('packing_box_view',$row->total_box_rate);?>" size="5"></td>
										<td>Local </td>
										<td><input type="text" readonly="readonly" id="stores_spares_local_view" name="stores_spares_local_view" value="<?php echo set_value('stores_spares_local_view',$row->stores_spares_local_view);?>" size='5'></td>
									</tr>

									<tr>
										<td>Shoulder</td>
										<td><input type="text" readonly="readonly" id="shoulder_cost_view" name="shoulder_cost_view" value="<?php echo set_value('shoulder_cost_view',$row->shoulder_cost);?>" size="5"></td>
										<td >Offset </td>
										<td><input type="text" readonly="readonly" id="offset_consumable_view" name="offset_consumable_view" value="<?php echo set_value('offset_consumable_view',$row->offset_consumable_view);?>" size="5"></td>
										<td>Liners</td>
										<td><input type="text" readonly="readonly" id="liners_view" name="liners_view" value="<?php echo set_value('liners_view',$row->liner_gm_per_tube);?>" size="5"></td>
										<td> Import</td>
										<td><input type="text" readonly="readonly" id="stores_spares_import_view" name="stores_spares_import_view" value="<?php echo set_value('stores_spares_import_view',$row->stores_spares_import_view);?>" size='5'></td>
									</tr>

									<tr>
										<td>Cap </td>
										<td><input type="text" readonly="readonly" id="cap_cost_view" name="cap_cost_view" value="<?php echo set_value('cap_cost_view',$row->cap_cost_per_tube);?>" size="5"></td>
										<td>Decoseam </td>
										<td><input type="text" readonly="readonly" id="spring_consumable_view" name="spring_consumable_view" value="<?php echo set_value('spring_consumable_view',$row->spring_consumable_view);?>" size="5"></td>
										<td>Export Packing </td>
										<td id="customer_flag_view"><input type="text" readonly="readonly" id="customer_flag" name="customer_flag" value="<?php echo set_value('customer_flag',$row->export_packing);?>" size="5"></td>
									</tr>
									<tr>
										<td>Lacquer </td>
										<td><input type="text" readonly="readonly" id="lacquer_cost_view" name="lacquer_cost_view" value="<?php echo set_value('lacquer_cost_view',$row->lacquer_cost_per_tube);?>" size="5"></td>										
										<td>Hygenic Consumable :</td>
										<td><input type="text" readonly="readonly" id="hygenic_consumable_view" name="hygenic_consumable_view" value="<?php echo set_value('hygenic_consumable_view',$row->hygenic_consumable_view);?>" size='5'></td>		
										
										<td>Shrink Flim</td>	
										<td><input type="text" readonly="readonly" id="packing_shrink_flim" name="packing_shrink_flim" value="<?php echo set_value('packing_shrink_flim',$row->packing_shrink_flim);?>" size='5'></td>
											
									</tr>
									<tr>
										<td>Tube Foil</td>
										<td><input type="text" readonly="readonly" id="tube_foil_cost_view" name="tube_foil_cost_view" value="<?php echo set_value('tube_foil_cost_view',$row->tube_foil_cost_per_tube);?>" size="5"></td>
										<td>Other Consumable </td>
										<td><input type="text" readonly="readonly" id="other_consumable_view" name="other_consumable_view" value="<?php echo set_value('other_consumable_view',$row->other_consumable_view);?>" size="5"></td>
										
										<td >Corrugated Sheet</td>
										<td><input type="text" readonly="readonly" id="packing_corrugated_sheet" name="packing_corrugated_sheet" value="<?php echo set_value('packing_corrugated_sheet',$row->packing_corrugated_sheet);?>" size="5"></td>
										
									</tr>

									<tr>
										<td>Offset Ink </td>
										<td><input type="text" readonly="readonly" id="offset_cost_view" name="offset_cost_view" value="<?php echo set_value('offset_cost_view',$row->offset_cost_per_tube);?>" size="5"></td>
										<td>Offset Plate</td>
										<td><input type="text" readonly="readonly" id="offset_plate_cost_view" name="offset_plate_cost_view" value="<?php echo set_value('offset_plate_cost_view',$row->offset_plate_cost_per_tube);?>" size="5"></td>
										<td>Bopp Tape </td>
										<td><input type="text" readonly="readonly" id="packing_bopp_tape" name="packing_bopp_tape" value="<?php echo set_value('packing_bopp_tape',$row->packing_bopp_tape);?>" size="5"></td>

									</tr>	

									<tr>
										<td>Screen+FlexoInk </td>
										<td><input type="text" readonly="readonly" id="screen_flexo_cost_view" name="screen_flexo_cost_view" value="<?php echo set_value('screen_flexo_cost_view',$row->screen_flexo_cost_per_tube);?>" size="5"></td>
										<td>Screen +ve Film</td>
										<td><input type="text" readonly="readonly" id="screen_plate_cost_view" name="screen_plate_cost_view" value="<?php echo set_value('screen_plate_cost_view',$row->screen_film_cost_per_tube);?>" size="5"></td>
										<td>Stickers </td>
										<td><input type="text" readonly="readonly" id="packing_stickers" name="packing_stickers" value="<?php echo set_value('packing_stickers',$row->packing_stickers);?>" size="5"></td>
											
									</tr>

									<tr>
										<td>Special Ink </td>
										<td><input type="text" readonly="readonly" id="special_ink_cost_view" name="special_ink_cost_view" value="<?php echo set_value('special_ink_cost_view',$row->special_ink_cost_per_tube);?>" size="5"></td>
										<td>Flexo Plate</td>
										<td><input type="text" readonly="readonly" id="flexo_plate_cost_view" name="flexo_plate_cost_view" value="<?php echo set_value('flexo_plate_cost_view',$row->flexo_plate_cost_per_tube);?>" size="5"></td>
										<td>Other Packing Material </td>
										<td><input type="text" readonly="readonly" id="other_packing_material" name="other_packing_material" value="<?php echo set_value('other_packing_material',$row->other_packing_material);?>" size="5"></td>
									</tr>

									<tr>
										<td>Label </td>
										<td><input type="text" readonly="readonly" id="label_cost_view" name="label_cost_view" value="<?php echo set_value('label_cost_view',$row->label_cost_per_tube);?>" size="5"></td>
										<td></td>
										<td><span id=""></span></td>
									</tr>

									<tr>
										<td>Shoulder Foil </td>
										<td><input type="text" readonly="readonly" id="shoulder_foil_cost_view" name="shoulder_foil_cost_view" value="<?php echo set_value('shoulder_foil_cost_view',$row->shoulder_foil_cost_per_tube);?>" size="5"></td>
										<td></td>
										<td><span id=""></span></td>
									</tr>

									<tr>
										<td>Shrink Sleeve </td>
										<td><input type="text" readonly="readonly" id="cap_shrink_sleeve_cost_view" name="cap_shrink_sleeve_cost_view" value="<?php echo set_value('cap_shrink_sleeve_cost_view',$row->cap_shrink_sleeve_cost_per_tube);?>" size="5"></td>
										<td></td>
										<td><span id=""></span></td>
									</tr>

									<tr>
										<td>Metalization </td>
										<td><input type="text" readonly="readonly" id="cap_metalization_cost_view" name="cap_metalization_cost_view" value="<?php echo set_value('cap_metalization_cost_view',$row->cap_metalization_cost_view);?>" size="5"></td>
										<td></td>
										<td><span id=""></span></td>
									</tr>

									<tr>
										<td>Cap foil </td>
										<td><input type="text" readonly="readonly" id="cap_foil_cost_view" name="cap_foil_cost_view" value="<?php echo set_value('cap_foil_cost_view',$row->cap_foil_cost_view);?>" size="5"></td>
										<td></td>
										<td><span id=""></span></td>
									</tr>
									
								
									<tr>
										<td><b>Total</b></td>
										<td><input type="text" readonly="readonly" name="total_rm_cost_per_tube" id="total_rm_cost_per_tube" value="<?php echo set_value('total_rm_cost_per_tube',$row->total_rm_cost_per_tube);?>" size="5"></td>
										<td> </td>
										<td><input type="text" readonly="readonly" id="total_consummable_cost_per_tube" name="total_consummable_cost_per_tube" value="<?php echo set_value('total_consummable_cost_per_tube',$row->total_consummable_cost_per_tube);?>" size="5"></td>
										<td> </td>
										<td><input type="text" readonly="readonly" id="total_packing_cost_per_tube" name="total_packing_cost_per_tube" value="<?php echo set_value('total_packing_cost_per_tube',$row->total_packing_cost_per_tube);?>" size="5"></td>
										<td> </td>
										<td><input type="text" readonly="readonly" id="total_stores_cost_per_tube" name="total_stores_cost_per_tube" value="<?php echo set_value('total_stores_cost_per_tube',$row->total_stores_cost_per_tube);?>" size="5"></td>
									</tr>									
									
									<tr class="active">
										<td><b>Total</b></td>
										<td><input type="text" readonly="readonly" id="total_cost_per_tube" name="total_cost_per_tube" value="<?php echo set_value('total_cost_per_tube',$row->total_cost_per_tube);?>" size="5"></td>
										<td><!-- <b>Waste % </b> --></td>
										<td> <input type="text" readonly="readonly"  hidden="hidden" name="waste_perc" id="waste_perc" size="5" placeholder="%" value="<?php echo set_value('waste_perc','0');?>" /></td>
										<td><!-- <b> Total Including waste </b> --></td>
										<td><input type="text" readonly="readonly"  hidden="hidden" id="waste_total_cost_per_tube" name="waste_total_cost_per_tube" value="<?php echo set_value('waste_total_cost_per_tube',$row->waste_total_cost_per_tube);?>" size="5"></td>
										<td> </td>
										<td> <span id=""></span></td>
									</tr>
								
									</tbody>

								
								</table>
								</div>


							</td>							
						</tr>

					</table>
				</td>							
			</tr>
		</table>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner" width="100%">
						<tr >
							<td>
								<fieldset>
									<legend>Costsheet:</legend>

								<table class="form_table_inner">
									<tr>
										<td><a class="ui red label" id="check">Check</a></td>
									</tr>
									<tr>
										<td colspan="5">
											<span id ="costsheet_table"></span>
										</td>
									</tr>
																		
								</table>
								</fieldset>	
							</td>							
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<?php endforeach;?>		
					
	</div>

	<!------------------------Layer1 Div------------------------>

<div id="layer1" class="modal" style="display:none;">
  <div class="modal-content">

    <span class="close">&times;</span>   
    
		<table class="ui celled structured table">
			<thead>
			<tr>
				<th>SR NO</th><th>LAYER</th><th>RM </th><th>RATE/KG </th><th>MICRON</th><th>LOADING %</th>
				
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><input type='hidden' name='layer_1_rows' value='5'>
					<input type='hidden' name='layer_1_sr_no_1' value='1'>1</td>

				<td rowspan="5">LAYER 1 <input type='hidden' name='layer_1_rm_1' value='LDPE'></td>
				<?php 
		    $layer_1_ldpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'1','rm'=>'LDPE');
		    $result_layer_1_ldpe=$this->common_model->select_one_active_record_nonlanguage_without_archives('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_1_ldpe_data);
		   // echo $this->db->last_query();

		   	if($result_layer_1_ldpe==FALSE){
		    	$layer_1_ldpe = '';
		    	$layer_1_ldpe_rate='';
		    	$layer_1_micron='';
		    	$layer_1_ldpe_percentage='';
		    }
		    else{
					foreach ($result_layer_1_ldpe as $result_layer_1_ldpe_row){
						$layer_1_ldpe = $result_layer_1_ldpe_row->rm_code;
						$layer_1_ldpe_rate=$result_layer_1_ldpe_row->rm_rate;
						$layer_1_micron=$result_layer_1_ldpe_row->micron;
						$layer_1_ldpe_percentage=$result_layer_1_ldpe_row->rm_percentage;
						$layer_1_sqsd_1=$result_layer_1_ldpe_row->sqsd_id;
					}
				}
				?>	
				<td> LD : <select name="layer_1_rm_1_code" id="sl_ldpe">
										<option value=''>--Select RM --</option>
								<?php if($ldpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
										foreach ($ldpe as $ldpe_row) {
											$selected=($ldpe_row->article_no==$layer_1_ldpe?'selected':'');
											echo "<option value='".$ldpe_row->article_no."' ".set_select('layer_1_rm_1_code',''.$ldpe_row->article_no.'').$selected.">".$ldpe_row->lang_article_description."</option>";
										}
										}?>
										</select>
				
				</td>
				<td>
					<input type='hidden' name='layer_1_sqsd_1' value='<?php echo $layer_1_sqsd_1;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer1_ldpe_rate" name="layer_1_rm_1_rate" value="<?php echo set_value('layer_1_rm_1_rate',$layer_1_ldpe_rate);?>" size="5">
				</td>
				<td rowspan="5"><input type="text" style="width: 7em;" name="micron" id="micron" class="number3" value="<?php echo set_value('micron',$layer_1_micron);?>"  />
				</td>
				<td><input type="number" style="width: 7em;" name="layer_1_rm_1_percentage" id="layer1_ld_percentage" placeholder="%" class="number3" value="<?php echo set_value('layer_1_rm_1_percentage',$layer_1_ldpe_percentage);?>" />
				</td>			
			</tr>
			<tr>
				<td><input type='hidden' name='layer_1_sr_no_1' value='2'>2 <input type='hidden' name='layer_1_rm_2' value='LLDPE'></td>				
				<td>
				<?php 
		    $layer_1_lldpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'1','rm'=>'LLDPE');
		    $result_layer_1_lldpe=$this->common_model->select_one_active_record_nonlanguage_without_archives('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_1_lldpe_data);
		   // echo $this->db->last_query();
		   	if($result_layer_1_lldpe==FALSE){
		    	$layer_1_lldpe = '';
		    	$layer_1_lldpe_rate='';
		    	$layer_1_micron='';
		    	$layer_1_lldpe_percentage='';
		    }
		    else{
					foreach ($result_layer_1_lldpe as $result_layer_1_lldpe_row){
						$layer_1_lldpe = $result_layer_1_lldpe_row->rm_code;
						$layer_1_lldpe_rate=$result_layer_1_lldpe_row->rm_rate;
						$layer_1_micron=$result_layer_1_lldpe_row->micron;
						$layer_1_lldpe_percentage=$result_layer_1_lldpe_row->rm_percentage;
						$layer_1_sqsd_2=$result_layer_1_lldpe_row->sqsd_id;
					}
				}
				?>	
					LLD : <select name="layer_1_rm_2_code" id="sl_lldpe">
										<option value=''>--Select RM --</option>
										<?php if($lldpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach ($lldpe as $lldpe_row) {
											$selected=($lldpe_row->article_no==$layer_1_lldpe?'selected':'');
											echo "<option value='".$lldpe_row->article_no."' ".set_select('layer_1_rm_2_code',''.$lldpe_row->article_no.'').$selected.">".$lldpe_row->lang_article_description."</option>";
										}
										}?>
										</select>

				</td>
				<td>
					<input type='hidden' name='layer_1_sqsd_2' value='<?php echo $layer_1_sqsd_2;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer1_lldpe_rate" name="layer_1_rm_2_rate" value="<?php echo set_value('layer_1_rm_2_rate',$layer_1_lldpe_rate);?>" size="5">
				</td>		
				<td ><input type="number" style="width: 7em;" name="layer_1_rm_2_percentage" id="layer1_lld_percentage" placeholder="%" value="<?php echo set_value('layer_1_rm_2_percentage',$layer_1_lldpe_percentage);?>" />
				</td>			
			</tr>

			<tr>
				<td><input type='hidden' name='sr_no[2]' value='3'>3</td>
				<td> 
				<?php 
		    $layer_1_hdpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'1','rm'=>'HDPE');
		    $result_layer_1_hdpe=$this->common_model->select_one_active_record_nonlanguage_without_archives('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_1_hdpe_data);
		   	if($result_layer_1_hdpe==FALSE){
		    	$layer_1_hdpe = '';
		    	$layer_1_hdpe_rate='';
		    	$layer_1_micron='';
		    	$layer_1_hdpe_percentage='';
		    }
		    else{
					foreach ($result_layer_1_hdpe as $result_layer_1_hdpe_row){
						$layer_1_hdpe = $result_layer_1_hdpe_row->rm_code;
						$layer_1_hdpe_rate=$result_layer_1_hdpe_row->rm_rate;
						$layer_1_micron=$result_layer_1_hdpe_row->micron;
						$layer_1_hdpe_percentage=$result_layer_1_hdpe_row->rm_percentage;
						$layer_1_sqsd_3=$result_layer_1_hdpe_row->sqsd_id;
					}
				}
				?>	
					HD <input type='hidden' name='layer_1_rm_3' value='HDPE'>: <select name="layer_1_rm_3_code" id="sl_hdpe">
										<option value=''>--Select HDPE--</option>
										<?php if($hdpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach ($hdpe as $hdpe_row) {
											$selected=($hdpe_row->article_no==$layer_1_hdpe?'selected':'');
											echo "<option value='".$hdpe_row->article_no."' ".set_select('layer_1_rm_3_code',$hdpe_row->article_no).$selected.">".$hdpe_row->lang_article_description."</option>";

										}
										}?>
										</select>

				</td>
				<td>
					<input type='hidden' name='layer_1_sqsd_3' value='<?php echo $layer_1_sqsd_3;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer1_hdpe_rate" name="layer_1_rm_3_rate" value="<?php echo set_value('layer_1_rm_3_rate',$layer_1_hdpe_rate);?>" size="5">
				</td>	
				<td><input type="number" style="width: 7em;" name="layer_1_rm_3_percentage" id="layer1_hd_percentage" placeholder="%" value="<?php echo set_value('layer_1_rm_3_percentage',$layer_1_hdpe_percentage);?>" />
				</td>			
			</tr>

			<tr>
				<td><input type='hidden' name='sr_no[]' value='4'>4 <input type='hidden' name='layer_1_rm_4' value='MB'></td>
				<td> 
					<?php 
		    $layer_1_mb_data = array('quotation_no'=>$row->quotation_no,'layer'=>'1','rm'=>'MB');
		    $result_layer_1_mb=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_1_mb_data,$order_by="",1,0);
		    //echo $this->db->last_query();
		   	if($result_layer_1_mb==FALSE){
		    	$layer_1_mb = '';
		    	$layer_1_mb_rate='';
		    	$layer_1_micron='';
		    	$layer_1_mb_percentage='';
		    }
		    else{
					foreach ($result_layer_1_mb as $result_layer_1_mb_row){
						$layer_1_mb = $result_layer_1_mb_row->rm_code;
						$layer_1_mb_rate=$result_layer_1_mb_row->rm_rate;
						$layer_1_micron=$result_layer_1_mb_row->micron;
						$layer_1_mb_percentage=$result_layer_1_mb_row->rm_percentage;
						$layer_1_sqsd_4=$result_layer_1_mb_row->sqsd_id;
						
					}
				}
				?>	
					MB : <select name="layer_1_rm_4_code" id="sl_masterbatch" >
									<option value=''>--Select MB--</option>
										<?php if($masterbatch==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach ($masterbatch as $masterbatch_row) {
											$selected=($masterbatch_row->article_no==$layer_1_mb?'selected':'');
											echo "<option value='".$masterbatch_row->article_no."' ".set_select('layer_1_rm_4_code',''.$masterbatch_row->article_no.'').$selected.">".$masterbatch_row->lang_article_description."</option>";
										}
										}?>
									</select>

				</td>
				<td>
					<input type='hidden' name='layer_1_sqsd_4' value='<?php echo $layer_1_sqsd_4;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer1_mb_rate" name="layer_1_rm_4_rate" value="<?php echo set_value('layer_1_rm_4_rate',$layer_1_mb_rate);?>" size="5">
				</td>	
				<td ><input type="number" style="width: 7em;" name="layer_1_rm_4_percentage" id="layer1_mb_percentage" placeholder="%" value="<?php echo set_value('layer_1_rm_4_percentage',$layer_1_mb_percentage);?>" />
				</td>			
			</tr>

			<tr>
				<td><input type='hidden' name='sr_no[]' value='5'>5 <input type='hidden' name='layer_1_rm_5' value='MB'></td>
				<td>
				<?php 
		    $layer_1_mb1_data = array('quotation_no'=>$row->quotation_no,'layer'=>'1','rm'=>'MB');
		    $result_layer_1_mb1=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_1_mb1_data,$order_by="",2,0);
		    //echo $this->db->last_query();
		   	if($result_layer_1_mb1==FALSE){
		    	$layer_1_mb1 = '';
		    	$layer_1_mb1_rate='';
		    	$layer_1_micron='';
		    	$layer_1_mb1_percentage='';
		    }
		    else{
					foreach ($result_layer_1_mb1 as $result_layer_1_mb1_row){
						$layer_1_mb1 = $result_layer_1_mb1_row->rm_code;
						$layer_1_mb1_rate=$result_layer_1_mb1_row->rm_rate;
						$layer_1_micron=$result_layer_1_mb1_row->micron;
						$layer_1_mb1_percentage=$result_layer_1_mb1_row->rm_percentage;
						$layer_1_sqsd_5=$result_layer_1_mb1_row->sqsd_id;
					}
				}
				?>		
				 MB : <input type="text" size="25" name="layer_1_rm_5_code" id="layer1_mb1" placeholder="If MB is not in system"value="<?php echo set_value('layer_1_rm_5_code',$layer_1_mb1);?>" />

				</td>
				<td>
					<input type='hidden' name='layer_1_sqsd_5' value='<?php echo $layer_1_sqsd_5;?>'>
					<input type="text" size="5" name="layer_1_rm_5_rate" id="layer1_mb1_rate" value="<?php echo set_value('layer_1_rm_5_rate',$layer_1_mb1_rate);?>" />
				</td>	
				<td ><input type="number" style="width: 7em;" name="layer_1_rm_5_percentage" id="layer1_mb_percentage1" placeholder="%" value="<?php echo set_value('layer_1_rm_5_percentage',$layer_1_mb1_percentage);?>" />
				</td>			
			</tr>
			<tr>
				<td colspan="5">
				<?php 
		    $layer_1_rejection_data = array('quotation_no'=>$row->quotation_no,'layer'=>'1');
		    $result_layer_1_rejection=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_1_rejection_data,$order_by="",1,0);
		    //echo $this->db->last_query();
		    	if($result_layer_1_rejection==FALSE){
		    	$layer_1_rejection = '';
		    }
		    else{
					foreach ($result_layer_1_rejection as $result_layer_1_rejection_row){
						$layer_1_rejection = $result_layer_1_rejection_row->rejection;
					
					}
				}
		    ?>

				Rejection %</td>				
				<td> <input type="number" style="width: 7em;" name="layer1_rejection" id="layer1_rejection" value="<?php echo set_value('layer1_rejection',$layer_1_rejection);?>" />	</td>			
			</tr>

			<tr>
				<td colspan="5">Quantity</td>				
				<td> <input type="number" readonly="readonly" style="width: 7em; background-color: #ddd" name="quantity" id="quantity" value="<?php echo set_value('quantity','1');?>" />	</td>			
			</tr>


			<tr>
				<td colspan="5">
					<?php 
		    $layer_1_sleeve_cost_data = array('quotation_no'=>$row->quotation_no,'layer'=>'1');
		    $result_layer_1_sleeve_cost=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_1_sleeve_cost_data,$order_by="",1,0);
		    //echo $this->db->last_query();
		    	if($result_layer_1_sleeve_cost==FALSE){
		    	$layer_1_sleeve_cost = '';
		    }
		    else{
					foreach ($result_layer_1_sleeve_cost as $result_layer_1_sleeve_cost_row){
						$layer_1_sleeve_cost = $result_layer_1_sleeve_cost_row->sleeve_per_cost;
					
					}
				}
		    ?>		
					<span class="ui green label" id="layer1_sleevecost" >ADD</span></td>
				<td><input  readonly="readonly" type="number" style="width: 7em;" name="sleeve_cost" id="sleeve_cost" value="<?php echo set_value('sleeve_cost',$layer_1_sleeve_cost);?>"  />	
				</td>

			</tr>
			


			</tbody>
		</table>
		
  </div>
</div>

	<!--------------------------------------------------Layer 2 --------------------------------->
<div id="layer2" class="modal" style="display:none;">
  <div class="modal-content" style="height:550px;overflow-y: scroll;">

    <span class="close">&times;</span>
    	
    	<table class="ui celled structured table">
			<thead>
			<tr>
				<th>SR NO</th><th>LAYER</th><th>RM </th><th>RATE </th><th>MICRON</th><th>LOADING%</th>
				
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<input type='hidden' name='layer_2_rows' value='10'>
					<input type='hidden' name='sr_no[]' value='1'>1 
					<input type='hidden' name='layer_2_rm_1' value='LDPE'></td>
				<td rowspan="5">LAYER 1</td>
				<?php 
		    $layer_2_layer_1_ldpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'2','rm'=>'LDPE');
		    $result_layer_2_layer_1_ldpe=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_2_layer_1_ldpe_data,$order_by="",1,0);
		    //echo $this->db->last_query();
		   	if($result_layer_2_layer_1_ldpe==FALSE){
		    	$layer_2_layer_1_ldpe = '';
		    	$layer_2_layer_1_ldpe_rate='';
		    	$layer_2_layer_1_micron='';
		    	$layer_2_layer_1_ldpe_percentage='';
		    }
		    else{
					foreach ($result_layer_2_layer_1_ldpe as $result_layer_2_layer_1_ldpe_row){
						$layer_2_layer_1_ldpe = $result_layer_2_layer_1_ldpe_row->rm_code;
						$layer_2_layer_1_ldpe_rate=$result_layer_2_layer_1_ldpe_row->rm_rate;
						$layer_2_layer_1_micron=$result_layer_2_layer_1_ldpe_row->micron;
						$layer_2_layer_1_ldpe_percentage=$result_layer_2_layer_1_ldpe_row->rm_percentage;
						$layer_2_sqsd_1=$result_layer_2_layer_1_ldpe_row->sqsd_id;
					}
				}
				?>

				<td>LD : <select name="layer_2_rm_1_code" id="layer2_layer1_sl_ldpe">
										<option value=''>--Select RM --</option>
								<?php if($ldpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
										foreach ($ldpe as $ldpe_row) {
											$selected=($ldpe_row->article_no==$layer_2_layer_1_ldpe?'selected':'');
											echo "<option value='".$ldpe_row->article_no."' ".set_select('layer_2_rm_1_code',$ldpe_row->article_no).$selected.">".$ldpe_row->lang_article_description."</option>";
										}
										}?>
										</select>
				
				</td>
				<td>
					<input type='hidden' name='layer_2_sqsd_1' value='<?php echo $layer_2_sqsd_1;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer2_layer1_ldpe_rate" name="layer_2_rm_1_rate" value="<?php echo set_value('layer_2_rm_1_rate',$layer_2_layer_1_ldpe_rate);?>" size="5">
				</td>
				<td rowspan="5"><input type="text" style="width: 7em;" name="layer_2_layer_1_micron" id="layer2_layer1_micron" class="number3" value="<?php echo set_value('layer_2_layer_1_micron',$layer_2_layer_1_micron);?>"  />
				</td>
				<td><input type="number" style="width: 7em;" name="layer_2_rm_1_percentage" id="layer2_layer1_ld_percentage" placeholder="%" class="number3" value="<?php echo set_value('layer_2_rm_1_percentage',$layer_2_layer_1_ldpe_percentage);?>" />
				</td>			
			</tr>
			<tr>
				<td><input type='hidden' name='sr_no[]' value='2'>2 <input type='hidden' name='layer_2_rm_2' value='LLDPE'></td>				
				<td>
				<?php 
				$layer_2_layer_1_lldpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'2','rm'=>'LLDPE');
				$result_layer_2_layer_1_lldpe=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_2_layer_1_lldpe_data,$order_by="",1,0);
				//echo $this->db->last_query();
					if($result_layer_2_layer_1_lldpe==FALSE){
					$layer_2_layer_1_lldpe = '';
					$layer_2_layer_1_lldpe_rate='';
					$layer_2_layer_1_micron='';
					$layer_2_layer_1_lldpe_percentage='';
				}
				else{
						foreach ($result_layer_2_layer_1_lldpe as $result_layer_2_layer_1_lldpe_row){
							$layer_2_layer_1_lldpe = $result_layer_2_layer_1_lldpe_row->rm_code;
							$layer_2_layer_1_lldpe_rate=$result_layer_2_layer_1_lldpe_row->rm_rate;
							$layer_2_layer_1_micron=$result_layer_2_layer_1_lldpe_row->micron;
							$layer_2_layer_1_lldpe_percentage=$result_layer_2_layer_1_lldpe_row->rm_percentage;
							$layer_2_sqsd_2=$result_layer_2_layer_1_lldpe_row->sqsd_id;
						}
					}
					?>		

				 LLD : <select name="layer_2_rm_2_code" id="layer2_layer1_sl_lldpe">
										<option value=''>--Select RM --</option>
										<?php if($lldpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
										foreach ($lldpe as $lldpe_row) {
											$selected=($lldpe_row->article_no==$layer_2_layer_1_lldpe?'selected':'');
											echo "<option value='".$lldpe_row->article_no."' ".set_select('layer_2_rm_2_code',$lldpe_row->article_no).$selected.">".$lldpe_row->lang_article_description."</option>";
										}
										}?>
										</select>

				</td>
				<td>
					<input type='hidden' name='layer_2_sqsd_2' value='<?php echo $layer_2_sqsd_2;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer2_layer1_lldpe_rate" name="layer_2_rm_2_rate" value="<?php echo set_value('layer_2_rm_2_rate',$layer_2_layer_1_lldpe_rate);?>" size="5">
				</td>		
				
				<td ><input type="number" style="width: 7em;" name="layer_2_rm_2_percentage" id="layer2_layer1_lld_percentage" placeholder="%" value="<?php echo set_value('layer_2_rm_2_percentage',$layer_2_layer_1_lldpe_percentage);?>" />
					<input type="hidden"  name="layer_2_layer_2_micron" value="<?php echo set_value('layer_2_layer_2_micron');?>" />
				</td>			
			</tr>

			<tr>
				<td><input type='hidden' name='sr_no[]' value='3'>3 <input type='hidden' name='layer_2_rm_3' value='HDPE'></td>
				<td> 
					<?php 
				$layer_2_layer_1_hdpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'2','rm'=>'HDPE');
				$result_layer_2_layer_1_hdpe=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_2_layer_1_hdpe_data,$order_by="",1,0);
				//echo $this->db->last_query();
					if($result_layer_2_layer_1_hdpe==FALSE){
					$layer_2_layer_1_hdpe = '';
					$layer_2_layer_1_hdpe_rate='';
					$layer_2_layer_1_micron='';
					$layer_2_layer_1_hdpe_percentage='';
				}
				else{
						foreach ($result_layer_2_layer_1_hdpe as $result_layer_2_layer_1_hdpe_row){
							$layer_2_layer_1_hdpe = $result_layer_2_layer_1_hdpe_row->rm_code;
							$layer_2_layer_1_hdpe_rate=$result_layer_2_layer_1_hdpe_row->rm_rate;
							$layer_2_layer_1_micron=$result_layer_2_layer_1_hdpe_row->micron;
							$layer_2_layer_1_hdpe_percentage=$result_layer_2_layer_1_hdpe_row->rm_percentage;
							$layer_2_sqsd_3=$result_layer_2_layer_1_hdpe_row->sqsd_id;
						}
					}
					?>	

					HD : <select name="layer_2_rm_3_code" id="layer2_layer1_sl_hdpe">
										<option value=''>--Select HDPE--</option>
										<?php if($hdpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
										foreach ($hdpe as $hdpe_row) {
											$selected=($hdpe_row->article_no==$layer_2_layer_1_hdpe?'selected':'');
											echo "<option value='".$hdpe_row->article_no."' ".set_select('layer_2_rm_3_code',$hdpe_row->article_no).$selected.">".$hdpe_row->lang_article_description."</option>";
										}
										}?>
										</select>

				</td>
				<td>
					<input type='hidden' name='layer_2_sqsd_3' value='<?php echo $layer_2_sqsd_3;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer2_layer1_hdpe_rate" name="layer_2_rm_3_rate" value="<?php echo set_value('layer_2_rm_3_rate',$layer_2_layer_1_hdpe_rate);?>" size="5">
				</td>	
				<td ><input type="number" style="width: 7em;" name="layer_2_rm_3_percentage" id="layer2_layer1_hd_percentage" placeholder="%"   value="<?php echo set_value('layer_2_rm_3_percentage',$layer_2_layer_1_hdpe_percentage);?>" />
					<input type="hidden"  name="layer_2_layer_3_micron" value="<?php echo set_value('layer_2_layer_3_micron');?>" />
				</td>			
			</tr>
			<tr>
				<td><input type='hidden' name='sr_no[]' value='4'>4 <input type='hidden' name='layer_2_rm_4' value='MB'></td>
				<td>
				<?php 
		    $layer_2_layer_1_mb_data = array('quotation_no'=>$row->quotation_no,'layer'=>'2','rm'=>'MB');
		    $result_layer_2_layer_1_mb=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_2_layer_1_mb_data,$order_by="",1,0);
		    //echo $this->db->last_query();
		   	if($result_layer_2_layer_1_mb==FALSE){
		    	$layer_2_layer_1_mb = '';
		    	$layer_2_layer_1_mb_rate='';
		    	$layer_2_layer_1_micron='';
		    	$layer_2_layer_1_mb_percentage='';
		    }
		    else{
					foreach ($result_layer_2_layer_1_mb as $result_layer_2_layer_1_mb_row){
						$layer_2_layer_1_mb = $result_layer_2_layer_1_mb_row->rm_code;
						$layer_2_layer_1_mb_rate=$result_layer_2_layer_1_mb_row->rm_rate;
						$layer_2_layer_1_micron=$result_layer_2_layer_1_mb_row->micron;
						$layer_2_layer_1_mb_percentage=$result_layer_2_layer_1_mb_row->rm_percentage;
						$layer_2_sqsd_4=$result_layer_2_layer_1_mb_row->sqsd_id;
					}
				}
				?>		
					
				 MB : <select name="layer_2_rm_4_code" id="layer2_layer_1_rm_4_code" ><option value=''>--Select MB--</option>
										<option value=''>--Select MB--</option>
										<?php if($masterbatch==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach ($masterbatch as $masterbatch_row) {
											$selected=($masterbatch_row->article_no==$layer_2_layer_1_mb?'selected':'');
											echo "<option value='".$masterbatch_row->article_no."' ".set_select('layer_2_rm_4_code',$masterbatch_row->article_no).$selected.">".$masterbatch_row->lang_article_description."</option>";
										}
										}?></select>

				</td>
				<td>
					<input type='hidden' name='layer_2_sqsd_4' value='<?php echo $layer_2_sqsd_4;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer2_layer_1_rm_4_rate" name="layer_2_rm_4_rate" value="<?php echo set_value('layer_2_rm_4_rate',$layer_2_layer_1_mb_rate);?>" size="5">
				</td>	
				<td ><input type="number" style="width: 7em;" name="layer_2_rm_4_percentage" id="layer2_layer_1_rm_4_percentage" placeholder="%" value="<?php echo set_value('layer_2_rm_4_percentage',$layer_2_layer_1_mb_percentage);?>" />
					<input type="hidden"  name="layer_2_layer_4_micron" value="<?php echo set_value('layer_2_layer_4_micron');?>" />
				</td>			
			</tr>

			<tr>
				<td><input type='hidden' name='sr_no[]' value='5'>5 <input type='hidden' name='layer_2_rm_5' value='MB'></td>
				<td> 
					<?php 
		    $layer_2_layer_1_mb1_data = array('quotation_no'=>$row->quotation_no,'layer'=>'2','rm'=>'MB');
		    $result_layer_2_layer_1_mb1=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_2_layer_1_mb1_data,$order_by="",2,0);
		    //echo $this->db->last_query();
		   	if($result_layer_2_layer_1_mb1==FALSE){
		    	$layer_2_layer_1_mb1 = '';
		    	$layer_2_layer_1_mb1_rate='';
		    	$layer_2_layer_1_micron='';
		    	$layer_2_layer_1_mb1_percentage='';
		    }
		    else{
					foreach ($result_layer_2_layer_1_mb1 as $result_layer_2_layer_1_mb1_row){
						$layer_2_layer_1_mb1 = $result_layer_2_layer_1_mb1_row->rm_code;
						$layer_2_layer_1_mb1_rate=$result_layer_2_layer_1_mb1_row->rm_rate;
						$layer_2_layer_1_micron=$result_layer_2_layer_1_mb1_row->micron;
						$layer_2_layer_1_mb1_percentage=$result_layer_2_layer_1_mb1_row->rm_percentage;
						$layer_2_sqsd_5=$result_layer_2_layer_1_mb1_row->sqsd_id;
					}
				}
				?>

					MB : <input type="text" size="25" name="layer_2_rm_5_code" id="layer2_layer_1_rm_5_code" placeholder="If MB is not in system"value="<?php echo set_value('layer_2_rm_5_code',$layer_2_layer_1_mb1);?>" />

				</td>
				<td>
					<input type='hidden' name='layer_2_sqsd_5' value='<?php echo $layer_2_sqsd_5;?>'>
					<input type="text" size="5" name="layer_2_rm_5_rate" id="layer2_layer_1_rm_5_rate" value="<?php echo set_value('layer_2_rm_5_rate',$layer_2_layer_1_mb1_rate);?>" />
				</td>	
				<td ><input type="number" style="width: 7em;" name="layer_2_rm_5_percentage" id="layer2_layer_1_rm_5_percentage" placeholder="%" value="<?php echo set_value('layer_2_rm_5_percentage',$layer_2_layer_1_mb1_percentage);?>" />
					<input type="hidden"  name="layer_2_layer_5_micron" value="<?php echo set_value('layer_2_layer_5_micron');?>" />
				</td>			
			</tr>

			<tr>
				<td><input type='hidden' name='sr_no[]' value='6'>6 <input type='hidden' name='layer_2_rm_6' value='LDPE'></td>
				<td rowspan="5">LAYER 2</td>

				<td>
				<?php 
		    $layer_2_layer_2_ldpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'2','rm'=>'LDPE');
		    $result_layer_2_layer_2_ldpe=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_2_layer_2_ldpe_data,$order_by="",2,0);
		   	if($result_layer_2_layer_2_ldpe==FALSE){
		    	$layer_2_layer_2_ldpe = '';
		    	$layer_2_layer_2_ldpe_rate='';
		    	$layer_2_layer_2_micron='';
		    	$layer_2_layer_2_ldpe_percentage='';
		    }
		    else{
					foreach ($result_layer_2_layer_2_ldpe as $result_layer_2_layer_2_ldpe_row){
						$layer_2_layer_2_ldpe = $result_layer_2_layer_2_ldpe_row->rm_code;
						$layer_2_layer_2_ldpe_rate=$result_layer_2_layer_2_ldpe_row->rm_rate;
						$layer_2_layer_2_micron=$result_layer_2_layer_2_ldpe_row->micron;
						$layer_2_layer_2_ldpe_percentage=$result_layer_2_layer_2_ldpe_row->rm_percentage;
						$layer_2_sqsd_6=$result_layer_2_layer_2_ldpe_row->sqsd_id;
					}
				}
				?>	
				 LD : <select name="layer_2_rm_6_code" id="layer2_layer2_sl_ldpe">
										<option value=''>--Select RM --</option>
								<?php 
								if($ldpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
										foreach ($ldpe as $ldpe_row) {
											$selected=($ldpe_row->article_no==$layer_2_layer_2_ldpe?'selected':'');
											echo "<option value='".$ldpe_row->article_no."' ".set_select('layer_2_rm_6_code',$ldpe_row->article_no).$selected.">".$ldpe_row->lang_article_description."</option>";
										}
										}?>
										</select>
				
				</td>
				<td>
					<input type='hidden' name='layer_2_sqsd_6' value='<?php echo $layer_2_sqsd_6;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer2_layer2_ldpe_rate" name="layer_2_rm_6_rate" value="<?php echo set_value('layer_2_rm_6_rate',$layer_2_layer_2_ldpe_rate);?>" size="5">
				</td>
				<td rowspan="5"><input type="text" style="width: 7em;" name="layer_2_layer_6_micron" id="layer2_layer2_micron" class="number3" value="<?php echo set_value('layer_2_layer_6_micron',$layer_2_layer_2_micron);?>"  />
				</td>
				<td><input type="number" style="width: 7em;" name="layer_2_rm_6_percentage" id="layer2_layer2_ld_percentage" placeholder="%" class="number3" value="<?php echo set_value('layer_2_rm_6_percentage',$layer_2_layer_2_ldpe_percentage);?>" />
				</td>			
			</tr>
			<tr>
				<td><input type='hidden' name='sr_no[]' value='7'>7 <input type='hidden' name='layer_2_rm_7' value='LLDPE'></td>				
				<td>
				<?php 
					$layer_2_layer_2_lldpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'2','rm'=>'LLDPE');
					$result_layer_2_layer_2_lldpe=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_2_layer_2_lldpe_data,$order_by="",2,0);
					//echo $this->db->last_query();
						if($result_layer_2_layer_2_lldpe==FALSE){
						$layer_2_layer_2_lldpe = '';
						$layer_2_layer_2_lldpe_rate='';
						$layer_2_layer_2_micron='';
						$layer_2_layer_2_lldpe_percentage='';
					}
					else{
							foreach ($result_layer_2_layer_2_lldpe as $result_layer_2_layer_2_lldpe_row){
								$layer_2_layer_2_lldpe = $result_layer_2_layer_2_lldpe_row->rm_code;
								$layer_2_layer_2_lldpe_rate=$result_layer_2_layer_2_lldpe_row->rm_rate;
								$layer_2_layer_2_micron=$result_layer_2_layer_2_lldpe_row->micron;
								$layer_2_layer_2_lldpe_percentage=$result_layer_2_layer_2_lldpe_row->rm_percentage;
								$layer_2_sqsd_7=$result_layer_2_layer_2_lldpe_row->sqsd_id;
							}
						}
						?>		
				 LLD : <select name="layer_2_rm_7_code" id="layer2_layer2_sl_lldpe">
										<option value=''>--Select RM --</option>
										<?php if($lldpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach ($lldpe as $lldpe_row) {
											$selected=($lldpe_row->article_no==$layer_2_layer_2_lldpe?'selected':'');
											echo "<option value='".$lldpe_row->article_no."' ".set_select('layer_2_rm_7_code',$lldpe_row->article_no).$selected.">".$lldpe_row->lang_article_description."</option>";
										}
										}?>
										</select>

				</td>
				<td>
					<input type='hidden' name='layer_2_sqsd_7' value='<?php echo $layer_2_sqsd_7;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer2_layer2_lldpe_rate" name="layer_2_rm_7_rate" value="<?php echo set_value('layer_2_rm_7_rate',$layer_2_layer_2_lldpe_rate);?>" size="5">
				</td>		
				<td ><input type="number" style="width: 7em;" name="layer_2_rm_7_percentage" id="layer2_layer2_lld_percentage" placeholder="%"  value="<?php echo set_value('layer_2_rm_7_percentage',$layer_2_layer_2_lldpe_percentage);?>" />
					<input type="hidden"  name="layer_2_layer_7_micron" value="<?php echo set_value('layer_2_layer_7_micron');?>" />
				</td>			
			</tr>

			<tr>
				<td><input type='hidden' name='sr_no[]' value='8'>8 <input type='hidden' name='layer_2_rm_8' value='HDPE'></td>
				<td>
				<?php 
		    $layer_2_layer_2_hdpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'2','rm'=>'HDPE');
		    $result_layer_2_layer_2_hdpe=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_2_layer_2_hdpe_data,$order_by="",2,0);
		    //echo $this->db->last_query();
		   	if($result_layer_2_layer_2_hdpe==FALSE){
		    	$layer_2_layer_2_hdpe = '';
		    	$layer_2_layer_2_hdpe_rate='';
		    	$layer_2_layer_2_micron='';
		    	$layer_2_layer_2_hdpe_percentage='';
		    }
		    else{
					foreach ($result_layer_2_layer_2_hdpe as $result_layer_2_layer_2_hdpe_row){
						$layer_2_layer_2_hdpe = $result_layer_2_layer_2_hdpe_row->rm_code;
						$layer_2_layer_2_hdpe_rate=$result_layer_2_layer_2_hdpe_row->rm_rate;
						$layer_2_layer_2_micron=$result_layer_2_layer_2_hdpe_row->micron;
						$layer_2_layer_2_hdpe_percentage=$result_layer_2_layer_2_hdpe_row->rm_percentage;
						$layer_2_sqsd_8=$result_layer_2_layer_2_hdpe_row->sqsd_id;
					}
				}
				?>	
				 HD : <select name="layer_2_rm_8_code" id="layer2_layer2_sl_hdpe">
										<option value=''>--Select HDPE--</option>
										<?php if($hdpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach ($hdpe as $hdpe_row) {
											$selected=($hdpe_row->article_no==$layer_2_layer_2_hdpe?'selected':'');
											echo "<option value='".$hdpe_row->article_no."' ".set_select('layer_2_rm_8_code',$hdpe_row->article_no).$selected.">".$hdpe_row->lang_article_description."</option>";
										}
										}?>
										</select>

				</td>
				<td>
					<input type='hidden' name='layer_2_sqsd_8' value='<?php echo $layer_2_sqsd_8;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer2_layer2_hdpe_rate" name="layer_2_rm_8_rate" value="<?php echo set_value('layer_2_rm_8_rate',$layer_2_layer_2_hdpe_rate);?>" size="5">
				</td>	
				<td ><input type="number" style="width: 7em;" name="layer_2_rm_8_percentage" id="layer2_layer2_hd_percentage" placeholder="%"   value="<?php echo set_value('layer_2_rm_8_percentage',$layer_2_layer_2_hdpe_percentage);?>" />
					<input type="hidden"  name="layer_2_layer_8_micron" value="<?php echo set_value('layer_2_layer_8_micron');?>" />
				</td>			
			</tr>
			<tr>
				<td><input type='hidden' name='sr_no[]' value='9'>9 <input type='hidden' name='layer_2_rm_9' value='MB'></td>
				<td>
				<?php 
		    $layer_2_layer_2_mb_data = array('quotation_no'=>$row->quotation_no,'layer'=>'2','rm'=>'MB');
		    $result_layer_2_layer_2_mb=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_2_layer_2_mb_data,$order_by="",1,0);
		    //echo $this->db->last_query();
		   	if($result_layer_2_layer_2_mb==FALSE){
		    	$layer_2_layer_2_mb = '';
		    	$layer_2_layer_2_mb_rate='';
		    	$layer_2_layer_2_micron='';
		    	$layer_2_layer_2_mb_percentage='';
		    }
		    else{
					foreach ($result_layer_2_layer_2_mb as $result_layer_2_layer_2_mb_row){
						$layer_2_layer_2_mb = $result_layer_2_layer_2_mb_row->rm_code;
						$layer_2_layer_2_mb_rate=$result_layer_2_layer_2_mb_row->rm_rate;
						$layer_2_layer_2_micron=$result_layer_2_layer_2_mb_row->micron;
						$layer_2_layer_2_mb_percentage=$result_layer_2_layer_2_mb_row->rm_percentage;
						$layer_2_sqsd_9=$result_layer_2_layer_2_mb_row->sqsd_id;
					}
				}
				?>		

				 MB : <select name="layer_2_rm_9_code" id="layer2_layer_2_rm_9_code" ><option value=''>--Select MB--</option>
										<option value=''>--Select MB--</option>
										<?php if($masterbatch==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach ($masterbatch as $masterbatch_row) {
											$selected=($masterbatch_row->article_no==$layer_2_layer_2_mb?'selected':'');
											echo "<option value='".$masterbatch_row->article_no."' ".set_select('layer_2_rm_9_code',$masterbatch_row->article_no).$selected.">".$masterbatch_row->lang_article_description."</option>";
										}
										}?>
									</select>

				</td>
				<td>
					<input type='hidden' name='layer_2_sqsd_9' value='<?php echo $layer_2_sqsd_9;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer2_layer_2_rm_9_rate" name="layer_2_rm_9_rate" value="<?php echo set_value('layer_2_rm_9_rate',$layer_2_layer_2_mb_rate);?>" size="5">
				</td>	
				<td ><input type="number" style="width: 7em;" name="layer_2_rm_9_percentage" id="layer2_layer_2_rm_9_percentage" placeholder="%" value="<?php echo set_value('layer_2_rm_9_percentage',$layer_2_layer_2_mb_percentage);?>" />
					<input type="hidden"  name="layer_2_layer_9_micron" value="<?php echo set_value('layer_2_layer_9_micron');?>" />
				</td>			
			</tr>

			<tr>
				<td><input type='hidden' name='sr_no[]' value='10'>10 <input type='hidden' name='layer_2_rm_10' value='MB'></td>
				<td>
				<?php 
		    $layer_2_layer_2_mb1_data = array('quotation_no'=>$row->quotation_no,'layer'=>'2','rm'=>'MB');
		    $result_layer_2_layer_2_mb1=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_2_layer_2_mb1_data,$order_by="",4,0);
		    //echo $this->db->last_query();
		   	if($result_layer_2_layer_2_mb1==FALSE){
		    	$layer_2_layer_2_mb1 = '';
		    	$layer_2_layer_2__mb1_rate='';
		    	$layer_2_layer_2_micron='';
		    	$layer_2_layer_2_mb1_percentage='';
		    }
		    else{
					foreach ($result_layer_2_layer_2_mb1 as $result_layer_2_layer_2_mb1_row){
						$layer_2_layer_2_mb1 = $result_layer_2_layer_2_mb1_row->rm_code;
						$layer_2_layer_2_mb1_rate=$result_layer_2_layer_2_mb1_row->rm_rate;
						$layer_2_layer_2_micron=$result_layer_2_layer_2_mb1_row->micron;
						$layer_2_layer_2_mb1_percentage=$result_layer_2_layer_2_mb1_row->rm_percentage;
						$layer_2_sqsd_10=$result_layer_2_layer_2_mb1_row->sqsd_id;
					}
				}
				?>		

				 MB : <input type="text" size="25" name="layer_2_rm_10_code" id="layer2_layer_2_rm_10_code" placeholder="If MB is not in system"value="<?php echo set_value('layer_2_rm_10_code',$layer_2_layer_2_mb1);?>" />

				</td>
				<td>
					<input type='hidden' name='layer_2_sqsd_10' value='<?php echo $layer_2_sqsd_10;?>'>
					<input type="text" size="5" name="layer_2_rm_10_rate" id="layer2_layer_2_rm_10_rate" value="<?php echo set_value('layer_2_rm_10_rate',$layer_2_layer_2_mb1_rate);?>" />
				</td>	
				<td ><input type="number" style="width: 7em;" name="layer_2_rm_10_percentage" id="layer2_layer_2_rm_10_percentage" placeholder="%" value="<?php echo set_value('layer_2_rm_10_percentage',$layer_2_layer_2_mb1_percentage);?>" />
				</td>	
				<input type="hidden"  name="layer_2_layer_10_micron" value="<?php echo set_value('layer_2_layer_10_micron');?>" />		
			</tr>
			<tr>
				<td colspan="5">
				<?php 
		    $layer_2_rejection_data = array('quotation_no'=>$row->quotation_no,'layer'=>'2');
		    $result_layer_2_rejection=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_2_rejection_data,$order_by="",1,0);
		    //echo $this->db->last_query();
		    	if($result_layer_2_rejection==FALSE){
		    	$layer_2_rejection = '';
		    }
		    else{
					foreach ($result_layer_2_rejection as $result_layer_2_rejection_row){
						$layer_2_rejection = $result_layer_2_rejection_row->rejection;
					
					}
				}
		    ?>	

					Rejection %</td>				
				<td> <input type="number" style="width: 7em;" name="layer2_rejection" id="layer2_rejection" value="<?php echo set_value('layer2_rejection',$layer_2_rejection);?>" />	</td>			
			</tr>

			<tr>
				<td colspan="5">Quantity</td>
				<td> <input type="number" readonly="readonly" style="width: 7em;background-color: #ddd" name="layer2_quantity" id="layer2_quantity"  value="<?php echo set_value('layer2_quantity','1');?>" />	</td>			
			</tr>

			<tr>
				<td colspan="5">
					<?php 
		    $layer_2_sleeve_cost_data = array('quotation_no'=>$row->quotation_no,'layer'=>'2');
		    $result_layer_2_sleeve_cost=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_2_sleeve_cost_data,$order_by="",1,0);
		    //echo $this->db->last_query();
		    	if($result_layer_2_sleeve_cost==FALSE){
		    	$layer_2_sleeve_cost = '';
		    }
		    else{
					foreach ($result_layer_2_sleeve_cost as $result_layer_2_sleeve_cost_row){
						$layer_2_sleeve_cost = $result_layer_2_sleeve_cost_row->sleeve_per_cost;
					
					}
				}
		    ?>
					<span class="ui green label" id="layer2_sleevecost" >ADD</span></td>
				<td><input  readonly="readonly" type="number" style="width: 7em;" name="layer2_sleeve_cost" id="layer2_sleeve_cost" value="<?php echo set_value('layer2_sleeve_cost',$layer_2_sleeve_cost);?>"  />	
				</td>

			</tr>
			</tbody>
		</table>
    
  </div>
</div>
	
	<!--------------------------------------------------Layer 3 --------------------------------->
<div id="layer3" class="modal" style="display:none;">
  <div class="modal-content" style="height:550px;overflow-y: scroll;">
    <span class="close">&times;</span>
    
    <table class="ui celled structured table">
			<thead>
			<tr>
				<th>SR NO</th><th>LAYER</th><th>RM </th><th>RATE </th><th>MICRON</th><th>LOADING%</th>
				
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<input type='hidden' name='layer_3_rows' value='11'>
					<input type='hidden' name='sr_no[]' value='1'>1 
					<input type='hidden' name='layer_3_rm_1' value='LDPE'></td>
				<td rowspan="5">LAYER 1</td>

				<td>
				<?php 
		    $layer_3_layer_1_ldpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'3','rm'=>'LDPE');
		    $result_layer_3_layer_1_ldpe=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_3_layer_1_ldpe_data,$order_by="",1,0);
		   	if($result_layer_3_layer_1_ldpe==FALSE){
		    	$layer_3_layer_1_ldpe = '';
		    	$layer_3_layer_1_ldpe_rate='';
		    	$layer_3_layer_1_micron='';
		    	$layer_3_layer_1_ldpe_percentage='';
		    }
		    else{
					foreach ($result_layer_3_layer_1_ldpe as $result_layer_3_layer_1_ldpe_row){
						$layer_3_layer_1_ldpe = $result_layer_3_layer_1_ldpe_row->rm_code;
						$layer_3_layer_1_ldpe_rate=$result_layer_3_layer_1_ldpe_row->rm_rate;
						$layer_3_layer_1_micron=$result_layer_3_layer_1_ldpe_row->micron;
						$layer_3_layer_1_ldpe_percentage=$result_layer_3_layer_1_ldpe_row->rm_percentage;
						$layer_3_sqsd_1=$result_layer_3_layer_1_ldpe_row->sqsd_id;
					}
				}
				?>		
									

				 LD : <select name="layer_3_rm_1_code" id="layer3_layer1_sl_ldpe">
										<option value=''>--Select RM --</option>
								<?php 
								if($ldpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
										foreach ($ldpe as $ldpe_row) {
											$selected=($ldpe_row->article_no==$layer_3_layer_1_ldpe?'selected':'');
											echo "<option value='".$ldpe_row->article_no."' ".set_select('layer_3_rm_1_code',$ldpe_row->article_no).$selected.">".$ldpe_row->lang_article_description."</option>";
										}
										}?>
										</select>
				
				</td>
				<td>
					<input type='hidden' name='layer_3_sqsd_1' value='<?php echo $layer_3_sqsd_1;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer3_layer1_ldpe_rate" name="layer_3_rm_1_rate" value="<?php echo set_value('layer_3_rm_1_rate',$layer_3_layer_1_ldpe_rate);?>" size="5">
				</td>
				<td rowspan="5"><input type="text" style="width: 7em;" name="layer_3_layer_1_micron" id="layer3_layer1_micron" class="number3" value="<?php echo set_value('layer_3_layer_1_micron',$layer_3_layer_1_micron);?>"  />
				</td>
				<td><input type="number" style="width: 7em;" name="layer_3_rm_1_percentage" id="layer3_layer1_ld_percentage" placeholder="%" class="number3" value="<?php echo set_value('layer_3_rm_1_percentage',$layer_3_layer_1_ldpe_percentage);?>" />
				</td>			
			</tr>
			<tr>
				<td><input type='hidden' name='sr_no[]' value='2'>2 <input type='hidden' name='layer_3_rm_2' value='LLDPE'></td>				
				<td> 
				<?php 
					$layer_3_layer_1_lldpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'3','rm'=>'LLDPE');
					$result_layer_3_layer_1_lldpe=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_3_layer_1_lldpe_data,$order_by="",1,0);
					//echo $this->db->last_query();
						if($result_layer_3_layer_1_lldpe==FALSE){
						$layer_3_layer_1_lldpe = '';
						$layer_3_layer_1_lldpe_rate='';
						$layer_3_layer_1_micron='';
						$layer_3_layer_1_lldpe_percentage='';
					}
					else{
							foreach ($result_layer_3_layer_1_lldpe as $result_layer_3_layer_1_lldpe_row){
								$layer_3_ayer_1_lldpe = $result_layer_3_layer_1_lldpe_row->rm_code;
								$layer_3_layer_1_lldpe_rate=$result_layer_3_layer_1_lldpe_row->rm_rate;
								$layer_3_layer_1_micron=$result_layer_3_layer_1_lldpe_row->micron;
								$layer_3_layer_1_lldpe_percentage=$result_layer_3_layer_1_lldpe_row->rm_percentage;
								$layer_3_sqsd_2=$result_layer_3_layer_1_lldpe_row->sqsd_id;
							}
						}
					?>			


					LLD : <select name="layer_3_rm_2_code" id="layer3_layer1_sl_lldpe">
										<option value=''>--Select RM --</option>
										<?php if($lldpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach ($lldpe as $lldpe_row) {
											$selected=($lldpe_row->article_no==$layer_3_ayer_1_lldpe?'selected':'');
											echo "<option value='".$lldpe_row->article_no."' ".set_select('layer_3_rm_2_code',$lldpe_row->article_no).$selected.">".$lldpe_row->lang_article_description."</option>";
										}
										}?>
										</select>

				</td>
				<td>
					<input type='hidden' name='layer_3_sqsd_2' value='<?php echo $layer_3_sqsd_2;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer3_layer1_lldpe_rate" name="layer_3_rm_2_rate" value="<?php echo set_value('layer_3_rm_2_rate',$layer_3_layer_1_lldpe_rate);?>" size="5">
				</td>		
				<td ><input type="number" style="width: 7em;" name="layer_3_rm_2_percentage" id="layer3_layer1_lld_percentage" placeholder="%"  value="<?php echo set_value('layer_3_rm_2_percentage',$layer_3_layer_1_lldpe_percentage);?>" />
					<input type="hidden"  name="layer_3_layer_2_micron" value="<?php echo set_value('layer_3_layer_2_micron');?>" />
				</td>			
			</tr>

			<tr>
				<td><input type='hidden' name='sr_no[]' value='3'>3 <input type='hidden' name='layer_3_rm_3' value='HDPE'></td>
				<td>
				<?php 
		    $layer_3_layer_1_hdpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'3','rm'=>'HDPE');
		    $result_layer_3_layer_1_hdpe=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_3_layer_1_hdpe_data,$order_by="",1,0);
		   	if($result_layer_3_layer_1_hdpe==FALSE){
		    	$layer_3_layer_1_hdpe = '';
		    	$layer_3_layer_1_hdpe_rate='';
		    	$layer_3_layer_1_micron='';
		    	$layer_3_layer_1_hdpe_percentage='';
		    }
		    else{
					foreach ($result_layer_3_layer_1_hdpe as $result_layer_3_layer_1_hdpe_row){
						$layer_3_layer_1_hdpe = $result_layer_3_layer_1_hdpe_row->rm_code;
						$layer_3_layer_1_hdpe_rate=$result_layer_3_layer_1_hdpe_row->rm_rate;
						$layer_3_layer_1_micron=$result_layer_3_layer_1_hdpe_row->micron;
						$layer_3_layer_1_hdpe_percentage=$result_layer_3_layer_1_hdpe_row->rm_percentage;
						$layer_3_sqsd_3=$result_layer_3_layer_1_hdpe_row->sqsd_id;
					}
				}
				?>	

				 HD : <select name="layer_3_rm_3_code" id="layer3_layer1_sl_hdpe">
										<option value=''>--Select HDPE--</option>
										<?php if($hdpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach ($hdpe as $hdpe_row) {
											$selected=($hdpe_row->article_no==$layer_3_layer_1_hdpe?'selected':'');
											echo "<option value='".$hdpe_row->article_no."' ".set_select('layer_3_rm_3_code',$hdpe_row->article_no).$selected.">".$hdpe_row->lang_article_description."</option>";
										}
										}?>
										</select>

				</td>
				<td>
					<input type='hidden' name='layer_3_sqsd_3' value='<?php echo $layer_3_sqsd_3;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer3_layer1_hdpe_rate" name="layer_3_rm_3_rate" value="<?php echo set_value('layer_3_rm_3_rate',$layer_3_layer_1_hdpe_rate);?>" size="5">
				</td>	
				<td ><input type="number" style="width: 7em;" name="layer_3_rm_3_percentage" id="layer3_layer1_hd_percentage" placeholder="%" value="<?php echo set_value('layer_3_rm_3_percentage',$layer_3_layer_1_hdpe_percentage);?>" />
					<input type="hidden"  name="layer_3_layer_3_micron" value="<?php echo set_value('layer_3_layer_3_micron');?>" />
				</td>			
			</tr>

			<tr>
				<td><input type='hidden' name='sr_no[]' value='4'>4 <input type='hidden' name='layer_3_rm_4' value='MB'></td>
				<td>
				<?php 
		    $layer_3_layer_1_mb_data = array('quotation_no'=>$row->quotation_no,'layer'=>'3','rm'=>'MB');
		    $result_layer_3_layer_1_mb=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_3_layer_1_mb_data,$order_by="",1,0);
		    //echo $this->db->last_query();
		   	if($result_layer_3_layer_1_mb==FALSE){
		    	$layer_3_layer_1_mb = '';
		    	$layer_3_layer_1_mb_rate='';
		    	$layer_3_layer_1_micron='';
		    	$layer_3_layer_1_mb_percentage='';
		    }
		    else{
					foreach ($result_layer_3_layer_1_mb as $result_layer_3_layer_1_mb_row){
						$layer_3_layer_1_mb = $result_layer_3_layer_1_mb_row->rm_code;
						$layer_3_layer_1_mb_rate=$result_layer_3_layer_1_mb_row->rm_rate;
						$layer_3_layer_1_micron=$result_layer_3_layer_1_mb_row->micron;
						$layer_3_layer_1_mb_percentage=$result_layer_3_layer_1_mb_row->rm_percentage;
						$layer_3_sqsd_4=$result_layer_3_layer_1_mb_row->sqsd_id;
					}
				}
				?>		

				 MB : <select name="layer_3_rm_4_code" id="layer3_layer_1_rm_4_code" >
				 								<option value=''>--Select MB--</option>
										<?php if($masterbatch==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach ($masterbatch as $masterbatch_row) {
											$selected=($masterbatch_row->article_no==$layer_3_layer_1_mb?'selected':'');
											echo "<option value='".$masterbatch_row->article_no."' ".set_select('layer_3_rm_4_code',$masterbatch_row->article_no).$selected.">".$masterbatch_row->lang_article_description."</option>";
										}
										}?>
									</select>

				</td>
				<td>
					<input type='hidden' name='layer_3_sqsd_4' value='<?php echo $layer_3_sqsd_4;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer3_layer_1_rm_4_rate" name="layer_3_rm_4_rate" value="<?php echo set_value('layer_3_rm_4_rate',$layer_3_layer_1_mb_rate);?>" size="5">
				</td>	
				<td ><input type="number" style="width: 7em;" name="layer_3_rm_4_percentage" id="layer3_layer_1_rm_4_percentage" placeholder="%" value="<?php echo set_value('layer_3_rm_4_percentage',$layer_3_layer_1_mb_percentage);?>" />
					<input type="hidden"  name="layer_3_layer_4_micron" value="<?php echo set_value('layer_3_layer_4_micron');?>" />
				</td>			
			</tr>

			<tr>
				<td><input type='hidden' name='sr_no[]' value='5'>5 <input type='hidden' name='layer_3_rm_5' value='MB'></td>
				<td>
				<?php 
		    $layer_3_layer_1_mb1_data = array('quotation_no'=>$row->quotation_no,'layer'=>'3','rm'=>'MB');
		    $result_layer_3_layer_1_mb1=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_3_layer_1_mb1_data,$order_by="",2,0);
		    //echo $this->db->last_query();
		   	if($result_layer_3_layer_1_mb1==FALSE){
		    	$layer_3_layer_1_mb1 = '';
		    	$layer_3_layer_1_mb1_rate='';
		    	$layer_3_layer_1_micron='';
		    	$layer_3_layer_1_mb1_percentage='';
		    }
		    else{
					foreach ($result_layer_3_layer_1_mb1 as $result_layer_3_layer_1_mb1_row){
						$layer_3_layer_1_mb1 = $result_layer_3_layer_1_mb1_row->rm_code;
						$layer_3_layer_1_mb1_rate=$result_layer_3_layer_1_mb1_row->rm_rate;
						$layer_3_layer_1_micron=$result_layer_3_layer_1_mb1_row->micron;
						$layer_3_layer_1_mb1_percentage=$result_layer_3_layer_1_mb1_row->rm_percentage;
						$layer_3_sqsd_5=$result_layer_3_layer_1_mb1_row->sqsd_id;
					}
				}
				?>	


				 MB : <input type="text" size="25" name="layer_3_rm_5_code" id="layer3_layer_1_rm_5_code" placeholder="If MB is not in system"value="<?php echo set_value('layer_3_rm_5_code',$layer_3_layer_1_mb1);?>" />

				</td>
				<td>
					<input type='hidden' name='layer_3_sqsd_5' value='<?php echo $layer_3_sqsd_5;?>'>
					<input type="text" size="5" name="layer_3_rm_5_rate" id="layer3_layer_1_rm_5_rate" value="<?php echo set_value('layer_3_rm_5_rate',$layer_3_layer_1_mb1_rate);?>" />
				</td>	
				<td ><input type="number" style="width: 7em;" name="layer_3_rm_5_percentage" id="layer3_layer_1_rm_5_percentage" placeholder="%" value="<?php echo set_value('layer_3_rm_5_percentage',$layer_3_layer_1_mb1_percentage);?>" />
					<input type="hidden"  name="layer_3_layer_5_micron" value="<?php echo set_value('layer_3_layer_5_micron');?>" />
				</td>			
			</tr>

			<tr>
				<td><input type='hidden' name='sr_no[]' value='6'>6 <input type='hidden' name='layer_3_rm_6' value='HDPE'></td>
				<td>LAYER 2</td>

				<td>
				<?php 
		    $layer_3_layer_2_hdpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'3','rm'=>'HDPE');
		    $result_layer_3_layer_2_hdpe=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_3_layer_2_hdpe_data,$order_by="",2,0);
		    //echo $this->db->last_query();
		   	if($result_layer_3_layer_2_hdpe==FALSE){
		    	$layer_3_layer_2_hdpe = '';
		    	$layer_3_layer_2_hdpe_rate='';
		    	$layer_3_layer_2_micron='';
		    	$layer_3_layer_2_hdpe_percentage='';
		    }
		    else{
					foreach ($result_layer_3_layer_2_hdpe as $result_layer_3_layer_2_hdpe_row){
						$layer_3_layer_2_hdpe = $result_layer_3_layer_2_hdpe_row->rm_code;
						$layer_3_layer_2_hdpe_rate=$result_layer_3_layer_2_hdpe_row->rm_rate;
						$layer_3_layer_2_micron=$result_layer_3_layer_2_hdpe_row->micron;
						$layer_3_layer_2_hdpe_percentage=$result_layer_3_layer_2_hdpe_row->rm_percentage;
						$layer_3_sqsd_6=$result_layer_3_layer_2_hdpe_row->sqsd_id;
					}
				}
				?>	

				 HD : <select name="layer_3_rm_6_code" id="layer3_layer2_sl_hdpe">
										<option value=''>--Select HDPE--</option>
										<?php if($hdpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach ($hdpe as $hdpe_row) {
											$selected=($hdpe_row->article_no==$layer_3_layer_2_hdpe?'selected':'');
											echo "<option value='".$hdpe_row->article_no."' ".set_select('layer_3_rm_6_code',$hdpe_row->article_no).$selected.">".$hdpe_row->lang_article_description."</option>";
										}
										}?>
										</select>

				</td>
				<td>
					<input type='hidden' name='layer_3_sqsd_6' value='<?php echo $layer_3_sqsd_6;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer3_layer2_hdpe_rate" name="layer_3_rm_6_rate" value="<?php echo set_value('layer_3_rm_6_rate',$layer_3_layer_2_hdpe_rate);?>" size="5">
				</td>
				<td ><input type="text" style="width: 7em;" name="layer_3_layer_6_micron" id="layer3_layer2_micron" class="number3" value="<?php echo set_value('layer_3_layer_6_micron',$layer_3_layer_2_micron);?>"  />
				</td>
				<td><input type="number" style="width: 7em;" name="layer_3_rm_6_percentage" id="layer3_layer2_hd_percentage" placeholder="%" class="number3"  value="<?php echo set_value('layer_3_rm_6_percentage',$layer_3_layer_2_hdpe_percentage);?>" />
				</td>			
			</tr>
			


			<tr>
				<td><input type='hidden' name='sr_no[]' value='7'>7 <input type='hidden' name='layer_3_rm_7' value='LDPE'></td>
				<td rowspan="5">LAYER 3</td>

				<td>
				<?php 
		    $layer_3_layer_3_ldpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'3','rm'=>'LDPE');
		    $result_layer_3_layer_3_ldpe=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_3_layer_3_ldpe_data,$order_by="",2,0);
		   // echo $this->db->last_query();
		   	if($result_layer_3_layer_3_ldpe==FALSE){
		    	$layer_3_layer_3_ldpe = '';
		    	$layer_3_layer_3_ldpe_rate='';
		    	$layer_3_layer_3_micron='';
		    	$layer_3_layer_3_ldpe_percentage='';
		    }
		    else{
					foreach ($result_layer_3_layer_3_ldpe as $result_layer_3_layer_3_ldpe_row){
						$layer_3_layer_3_ldpe = $result_layer_3_layer_3_ldpe_row->rm_code;
						$layer_3_layer_3_ldpe_rate=$result_layer_3_layer_3_ldpe_row->rm_rate;
						$layer_3_layer_3_micron=$result_layer_3_layer_3_ldpe_row->micron;
						$layer_3_layer_3_ldpe_percentage=$result_layer_3_layer_3_ldpe_row->rm_percentage;
						$layer_3_sqsd_7=$result_layer_3_layer_3_ldpe_row->sqsd_id;
					}
				}
				?>	
				 LD : <select name="layer_3_rm_7_code" id="layer3_layer3_sl_ldpe">
										<option value=''>--Select RM --</option>
								<?php 
								if($ldpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
										foreach ($ldpe as $ldpe_row) {
											$selected=($ldpe_row->article_no==$layer_3_layer_3_ldpe?'selected':'');
											echo "<option value='".$ldpe_row->article_no."' ".set_select('layer_3_rm_7_code',$ldpe_row->article_no).$selected.">".$ldpe_row->lang_article_description."</option>";
										}
										}?>
										</select>
				
				</td>
				<td>
					<input type='hidden' name='layer_3_sqsd_7' value='<?php echo $layer_3_sqsd_7;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer3_layer3_ldpe_rate" name="layer_3_rm_7_rate" value="<?php echo set_value('layer_3_rm_7_rate',$layer_3_layer_3_ldpe_rate);?>" size="5">
				</td>
				<td rowspan="5"><input type="text" style="width: 7em;" name="layer_3_layer_7_micron" id="layer3_layer3_micron" class="number3" value="<?php echo set_value('layer_3_layer_7_micron',$layer_3_layer_3_micron);?>"  />
				</td>
				<td><input type="number" style="width: 7em;" name="layer_3_rm_7_percentage" id="layer3_layer3_ld_percentage" placeholder="%" class="number3"  value="<?php echo set_value('layer_3_rm_7_percentage',$layer_3_layer_3_ldpe_percentage);?>" />
				</td>			
			</tr>
			<tr>
				<td><input type='hidden' name='sr_no[]' value='8'>8 <input type='hidden' name='layer_3_rm_8' value='LLDPE'></td>				
				<td>
				<?php 
					$layer_3_layer_3_lldpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'3','rm'=>'LLDPE');
					$result_layer_3_layer_3_lldpe=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_3_layer_3_lldpe_data,$order_by="",2,0);
					//echo $this->db->last_query();
						if($result_layer_3_layer_3_lldpe==FALSE){
						$layer_3_layer_3_lldpe = '';
						$layer_3_layer_3_lldpe_rate='';
						$layer_3_layer_3_micron='';
						$layer_3_layer_3_lldpe_percentage='';
					}
					else{
							foreach ($result_layer_3_layer_3_lldpe as $result_layer_3_layer_3_lldpe_row){
								$layer_3_layer_3_lldpe = $result_layer_3_layer_3_lldpe_row->rm_code;
								$layer_3_layer_3_lldpe_rate=$result_layer_3_layer_3_lldpe_row->rm_rate;
								$layer_3_layer_3_micron=$result_layer_3_layer_3_lldpe_row->micron;
								$layer_3_layer_3_lldpe_percentage=$result_layer_3_layer_3_lldpe_row->rm_percentage;
								$layer_3_sqsd_8=$result_layer_3_layer_3_lldpe_row->sqsd_id;
							}
						}
						?>	
					
				 LLD : <select name="layer_3_rm_8_code" id="layer3_layer3_sl_lldpe">
										<option value=''>--Select RM --</option>
										<?php if($lldpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach ($lldpe as $lldpe_row) {
											$selected=($lldpe_row->article_no==$layer_3_layer_3_lldpe?'selected':'');
											echo "<option value='".$lldpe_row->article_no."' ".set_select('layer_3_rm_8_code',$lldpe_row->article_no).$selected.">".$lldpe_row->lang_article_description."</option>";
										}
										}?>
										</select>

				</td>
				<td>
					<input type='hidden' name='layer_3_sqsd_8' value='<?php echo $layer_3_sqsd_8;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer3_layer3_lldpe_rate" name="layer_3_rm_8_rate" value="<?php echo set_value('layer_3_rm_8_rate',$layer_3_layer_3_lldpe_rate);?>" size="5">
				</td>		
				<td ><input type="number" style="width: 7em;" name="layer_3_rm_8_percentage" id="layer3_layer3_lld_percentage" placeholder="%"  value="<?php echo set_value('layer_3_rm_8_percentage',$layer_3_layer_3_lldpe_percentage);?>" />
					<input type="hidden"  name="layer_3_layer_8_micron" value="<?php echo set_value('layer_3_layer_8_micron');?>" />
				</td>			
			</tr>

			<tr>
				<td><input type='hidden' name='sr_no[]' value='9'>9 <input type='hidden' name='layer_3_rm_9' value='HDPE'></td>		
				<td>
				<?php 
		    $layer_3_layer_3_hdpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'3','rm'=>'HDPE');
		    $result_layer_3_layer_3_hdpe=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_3_layer_3_hdpe_data,$order_by="",3,0);
		   	if($result_layer_3_layer_3_hdpe==FALSE){
		    	$layer_3_layer_3_hdpe = '';
		    	$layer_3_layer_3_hdpe_rate='';
		    	$layer_3_layer_3_micron='';
		    	$layer_3_layer_3_hdpe_percentage='';
		    }
		    else{
					foreach ($result_layer_3_layer_3_hdpe as $result_layer_3_layer_3_hdpe_row){
						$layer_3_layer_3_hdpe = $result_layer_3_layer_3_hdpe_row->rm_code;
						$layer_3_layer_3_hdpe_rate=$result_layer_3_layer_3_hdpe_row->rm_rate;
						$layer_3_layer_3_micron=$result_layer_3_layer_3_hdpe_row->micron;
						$layer_3_layer_3_hdpe_percentage=$result_layer_3_layer_3_hdpe_row->rm_percentage;
						$layer_3_sqsd_9=$result_layer_3_layer_3_hdpe_row->sqsd_id;
					}
				}
				?>	

				 HD : <select name="layer_3_rm_9_code" id="layer3_layer3_sl_hdpe">
									<option value=''>--Select HDPE--</option>
										<?php if($hdpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach ($hdpe as $hdpe_row) {
											$selected=($hdpe_row->article_no==$layer_3_layer_3_hdpe?'selected':'');
											echo "<option value='".$hdpe_row->article_no."' ".set_select('layer_3_rm_9_code',$hdpe_row->article_no).$selected.">".$hdpe_row->lang_article_description."</option>";
										}
										}?>
										</select>

				</td>
				<td>
					<input type='hidden' name='layer_3_sqsd_9' value='<?php echo $layer_3_sqsd_9;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer3_layer3_hdpe_rate" name="layer_3_rm_9_rate" value="<?php echo set_value('layer_3_rm_9_rate',$layer_3_layer_3_hdpe_rate);?>" size="5">
				</td>	
				<td ><input type="number" style="width: 7em;" name="layer_3_rm_9_percentage" id="layer3_layer3_hd_percentage" placeholder="%"  value="<?php echo set_value('layer_3_rm_9_percentage',$layer_3_layer_3_hdpe_percentage);?>" />
					<input type="hidden"  name="layer_3_layer_9_micron" value="<?php echo set_value('layer_3_layer_9_micron');?>" />
				</td>			
			</tr>
			<tr>
				<td><input type='hidden' name='sr_no[]' value='10'>10 <input type='hidden' name='layer_3_rm_10' value='MB'></td>
				<td>
				<?php 
		    $layer_3_layer_3_mb_data = array('quotation_no'=>$row->quotation_no,'layer'=>'3','rm'=>'MB');
		    $result_layer_3_layer_3_mb=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_3_layer_3_mb_data,$order_by="",3,0);
		    //echo $this->db->last_query();
		   	if($result_layer_3_layer_3_mb==FALSE){
		    	$layer_3_layer_3_mb = '';
		    	$layer_3_layer_3_mb_rate='';
		    	$layer_3_layer_3_micron='';
		    	$layer_3_layer_3_mb_percentage='';
		    }
		    else{
					foreach ($result_layer_3_layer_3_mb as $result_layer_3_layer_3_mb_row){
						$layer_3_layer_3_mb = $result_layer_3_layer_3_mb_row->rm_code;
						$layer_3_layer_3_mb_rate=$result_layer_3_layer_3_mb_row->rm_rate;
						$layer_3_layer_3_micron=$result_layer_3_layer_3_mb_row->micron;
						$layer_3_layer_3_mb_percentage=$result_layer_3_layer_3_mb_row->rm_percentage;
						$layer_3_sqsd_10=$result_layer_3_layer_3_mb_row->sqsd_id;
					}
				}
				?>	

				 MB : <select name="layer_3_rm_10_code" id="layer3_layer_3_rm_10_code" >
				 							<option value=''>--Select MB--</option>
										<?php if($masterbatch==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach ($masterbatch as $masterbatch_row) {
											$selected=($masterbatch_row->article_no==$layer_3_layer_3_mb?'selected':'');
											echo "<option value='".$masterbatch_row->article_no."' ".set_select('layer_3_rm_10_code',$masterbatch_row->article_no).$selected.">".$masterbatch_row->lang_article_description."</option>";
										}
										}?></select>

				</td>
				<td>
					<input type='hidden' name='layer_3_sqsd_10' value='<?php echo $layer_3_sqsd_10;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer3_layer_3_rm_10_rate" name="layer_3_rm_10_rate" value="<?php echo set_value('layer_3_rm_10_rate',$layer_3_layer_3_mb_rate);?>" size="5">
				</td>	
				<td ><input type="number" style="width: 7em;" name="layer_3_rm_10_percentage" id="layer3_layer_3_rm_10_percentage" placeholder="%" value="<?php echo set_value('layer_3_rm_10_percentage',$layer_3_layer_3_mb_percentage);?>" />
					<input type="hidden"  name="layer_3_layer_10_micron" value="<?php echo set_value('layer_3_layer_10_micron');?>" />
				</td>			
			</tr>

			<tr>
				<td><input type='hidden' name='sr_no[]' value='11'>11 <input type='hidden' name='layer_3_rm_11' value='MB'></td>
				<td>
				<?php 
		    $layer_3_layer_3_mb1_data = array('quotation_no'=>$row->quotation_no,'layer'=>'3','rm'=>'MB');
		    $result_layer_3_layer_3_mb1=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_3_layer_3_mb1_data,$order_by="",4,0);
		    //echo $this->db->last_query();
		   	if($result_layer_3_layer_3_mb1==FALSE){
		    	$layer_3_layer_3_mb1 = '';
		    	$layer_3_layer_3_mb1_rate='';
		    	$layer_3_layer_3_micron='';
		    	$layer_3_layer_3_mb1_percentage='';
		    }
		    else{
					foreach ($result_layer_3_layer_3_mb1 as $result_layer_3_layer_3_mb1_row){
						$layer_3_layer_3_mb1 = $result_layer_3_layer_3_mb1_row->rm_code;
						$layer_3_layer_3_mb1_rate=$result_layer_3_layer_3_mb1_row->rm_rate;
						$layer_3_layer_3_micron=$result_layer_3_layer_3_mb1_row->micron;
						$layer_3_layer_3_mb1_percentage=$result_layer_3_layer_3_mb1_row->rm_percentage;
						$layer_3_sqsd_11=$result_layer_3_layer_3_mb1_row->sqsd_id;
					}
				}
				?>	

				 MB : <input type="text" size="25" name="layer_3_rm_11_code" id="layer3_layer_3_rm_11_code" placeholder="If MB is not in system"value="<?php echo set_value('layer_3_rm_11_code',$layer_3_layer_3_mb1);?>" />

				</td>
				<td>
						<input type='hidden' name='layer_3_sqsd_11' value='<?php echo $layer_3_sqsd_11;?>'>
					<input type="text" size="5" name="layer_3_rm_11_rate" id="layer3_layer_3_rm_11_rate" value="<?php echo set_value('layer_3_rm_11_rate',$layer_3_layer_3_mb1_rate);?>" />
				</td>	
				<td ><input type="number" style="width: 7em;" name="layer_3_rm_11_percentage" id="layer3_layer_3_rm_11_percentage" placeholder="%" value="<?php echo set_value('layer_3_rm_11_percentage',$layer_3_layer_3_mb1_percentage);?>" />
					<input type="hidden"  name="layer_3_layer_11_micron" value="<?php echo set_value('layer_3_layer_11_micron');?>" />
				</td>			
			</tr>

			<tr>
				<td colspan="5">
				<?php 
		    $layer_3_rejection_data = array('quotation_no'=>$row->quotation_no,'layer'=>'3');
		    $result_layer_3_rejection=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_3_rejection_data,$order_by="",1,0);
		    //echo $this->db->last_query();
		    	if($result_layer_3_rejection==FALSE){
		    	$layer_3_rejection = '';
		    }
		    else{
					foreach ($result_layer_3_rejection as $result_layer_3_rejection_row){
						$layer_3_rejection = $result_layer_3_rejection_row->rejection;
					
					}
				}
		    ?>		

				Rejection %</td>				
				<td> <input type="number" style="width: 7em;" name="layer3_rejection" id="layer3_rejection" value="<?php echo set_value('layer3_rejection',$layer_3_rejection);?>" />	</td>			
			</tr>

			<tr>
				<td colspan="5">Quantity</td>
				
				<td> <input type="number" readonly="readonly" style="width: 7em;background-color: #ddd" name="layer3_quantity" id="layer3_quantity" value="<?php echo set_value('layer3_quantity','1');?>" />	</td>			
			</tr>


			<tr>
				<td colspan="5">
				<?php 
		    $layer_3_sleeve_cost_data = array('quotation_no'=>$row->quotation_no,'layer'=>'3');
		    $result_layer_3_sleeve_cost=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_3_sleeve_cost_data,$order_by="",1,0);
		    //echo $this->db->last_query();
		    	if($result_layer_3_sleeve_cost==FALSE){
		    	$layer_3_sleeve_cost = '';
		    }
		    else{
					foreach ($result_layer_3_sleeve_cost as $result_layer_3_sleeve_cost_row){
						$layer_3_sleeve_cost = $result_layer_3_sleeve_cost_row->sleeve_per_cost;
					
					}
				}
		    ?>	

				<span class="ui green label" id="layer3_sleevecost" >ADD</span></td>
				<td><input  readonly="readonly" type="number" style="width: 7em;" name="layer3_sleeve_cost" id="layer3_sleeve_cost" value="<?php echo set_value('layer3_sleeve_cost',$layer_3_sleeve_cost);?>"  />	
				</td>
			</tr>
			</tbody>
		</table>
    
  </div>
</div>

	<!--------------------------------------------------Layer 5 --------------------------------->
<div id="layer5" class="modal" style="display:none;">
  <div class="modal-content" style="height:550px;overflow-y: scroll;">
    <span class="close">&times;</span>
    
    <table class="ui celled structured table">
			<thead>
			<tr>
				<th>SR NO</th><th>LAYER</th><th>RM </th><th>RATE </th><th>MICRON</th><th>LOADING%</th>
				
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<input type='hidden' name='layer_5_rows' value='13'>
					<input type='hidden' name='sr_no[]' value='1'>1 
					<input type='hidden' name='layer_5_rm_1' value='LDPE'></td>
				<td rowspan="5">LAYER 1</td>

				<td> 		
				<?php 
		    $layer_5_layer_1_ldpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'5','rm'=>'LDPE');
		    $result_layer_5_layer_1_ldpe=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_5_layer_1_ldpe_data,$order_by="",1,0);
		    //echo $this->db->last_query();
		   	if($result_layer_5_layer_1_ldpe==FALSE){
		    	$layer_5_layer_1_ldpe = '';
		    	$layer_5_layer_1_ldpe_rate='';
		    	$layer_5_layer_1_micron='';
		    	$layer_5_layer_1_ldpe_percentage='';
		    }
		    else{
					foreach ($result_layer_5_layer_1_ldpe as $result_layer_5_layer_1_ldpe_row){
						$layer_5_layer_1_ldpe = $result_layer_5_layer_1_ldpe_row->rm_code;
						$layer_5_layer_1_ldpe_rate=$result_layer_5_layer_1_ldpe_row->rm_rate;
						$layer_5_layer_1_micron=$result_layer_5_layer_1_ldpe_row->micron;
						$layer_5_layer_1_ldpe_percentage=$result_layer_5_layer_1_ldpe_row->rm_percentage;
						$layer_5_sqsd_1=$result_layer_5_layer_1_ldpe_row->sqsd_id;
					}
				}
				?>	

					LD : <select name="layer_5_rm_1_code" id="layer5_layer1_sl_ldpe">
										<option value=''>--Select RM --</option>
								<?php 
								if($ldpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
										foreach ($ldpe as $ldpe_row) {
											$selected=($ldpe_row->article_no==$layer_5_layer_1_ldpe?'selected':'');
											echo "<option value='".$ldpe_row->article_no."' ".set_select('layer_5_rm_1_code',$ldpe_row->article_no).$selected.">".$ldpe_row->lang_article_description."</option>";
										}
										}?>
										</select>
				
				</td>
				<td>
					<input type='hidden' name='layer_5_sqsd_1' value='<?php echo $layer_5_sqsd_1;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer5_layer1_ldpe_rate" name="layer_5_rm_1_rate" value="<?php echo set_value('layer_5_rm_1_rate',$layer_5_layer_1_ldpe_rate);?>" size="5">
				</td>
				<td rowspan="5"><input type="text" style="width: 7em;" name="layer_5_layer_1_micron" id="layer5_layer1_micron" value="<?php echo set_value('layer_5_layer_1_micron',$layer_5_layer_1_micron);?>"  />
				</td>
				<td><input type="number" style="width: 7em;" name="layer_5_rm_1_percentage" id="layer5_layer1_ld_percentage" placeholder="%" value="<?php echo set_value('layer_5_rm_1_percentage',$layer_5_layer_1_ldpe_percentage);?>" />
				</td>			
			</tr>
			<tr>
				<td><input type='hidden' name='sr_no[]' value='2'>2 <input type='hidden' name='layer_5_rm_2' value='LLDPE'></td>
				<td>
				<?php 
					$layer_5_layer_1_lldpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'5','rm'=>'LLDPE');
					$result_layer_5_layer_1_lldpe=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_5_layer_1_lldpe_data,$order_by="",1,0);
					//echo $this->db->last_query();
						if($result_layer_5_layer_1_lldpe==FALSE){
						$layer_5_layer_1_lldpe = '';
						$layer_5_layer_1_lldpe_rate='';
						$layer_5_layer_1_micron='';
						$layer_5_layer_1_lldpe_percentage='';
					}
					else{
							foreach ($result_layer_5_layer_1_lldpe as $result_layer_5_layer_1_lldpe_row){
								$layer_5_layer_1_lldpe = $result_layer_5_layer_1_lldpe_row->rm_code;
								$layer_5_layer_1_lldpe_rate=$result_layer_5_layer_1_lldpe_row->rm_rate;
								$layer_5_layer_1_micron=$result_layer_5_layer_1_lldpe_row->micron;
								$layer_5_layer_1_lldpe_percentage=$result_layer_5_layer_1_lldpe_row->rm_percentage;
								$layer_5_sqsd_2=$result_layer_5_layer_1_lldpe_row->sqsd_id;
							}
						}
						?>		

				 LLD : <select name="layer_5_rm_2_code" id="layer5_layer1_sl_lldpe">
										<option value=''>--Select RM --</option>
										<?php if($lldpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach ($lldpe as $lldpe_row) {
											$selected=($lldpe_row->article_no==$layer_5_layer_1_lldpe?'selected':'');
											echo "<option value='".$lldpe_row->article_no."' ".set_select('layer_5_rm_2_code',$lldpe_row->article_no).$selected.">".$lldpe_row->lang_article_description."</option>";
										}
										}?>
										</select>

				</td>
				<td>
					<input type='hidden' name='layer_5_sqsd_2' value='<?php echo $layer_5_sqsd_2;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer5_layer1_lldpe_rate" name="layer_5_rm_2_rate" value="<?php echo set_value('layer_5_rm_2_rate',$layer_5_layer_1_lldpe_rate);?>" size="5">
				</td>		
				<td ><input type="number" style="width: 7em;" name="layer_5_rm_2_percentage" id="layer5_layer1_lld_percentage" placeholder="%" value="<?php echo set_value('layer_5_rm_2_percentage',$layer_5_layer_1_lldpe_percentage);?>" />
					<input type="hidden"  name="layer_5_layer_2_micron" value="<?php echo set_value('layer_5_layer_2_micron');?>" />
				</td>			
			</tr>

			<tr>
				<td><input type='hidden' name='sr_no[]' value='3'>3 <input type='hidden' name='layer_5_rm_3' value='HDPE'></td>
				<td>
				<?php 
		    $layer_5_layer_1_hdpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'5','rm'=>'HDPE');
		    $result_layer_5_layer_1_hdpe=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_5_layer_1_hdpe_data,$order_by="",1,0);
		    //echo $this->db->last_query();
		   	if($result_layer_5_layer_1_hdpe==FALSE){
		    	$layer_5_layer_1_hdpe = '';
		    	$layer_5_layer_1_hdpe_rate='';
		    	$layer_5_layer_1_micron='';
		    	$layer_5_layer_1_hdpe_percentage='';
		    }
		    else{
					foreach ($result_layer_5_layer_1_hdpe as $result_layer_5_layer_1_hdpe_row){
						$layer_5_layer_1_hdpe = $result_layer_5_layer_1_hdpe_row->rm_code;
						$layer_5_layer_1_hdpe_rate=$result_layer_5_layer_1_hdpe_row->rm_rate;
						$layer_5_layer_1_micron=$result_layer_5_layer_1_hdpe_row->micron;
						$layer_5_layer_1_hdpe_percentage=$result_layer_5_layer_1_hdpe_row->rm_percentage;
						$layer_5_sqsd_3=$result_layer_5_layer_1_hdpe_row->sqsd_id;
					}
				}
				?>	

				 HD : <select name="layer_5_rm_3_code" id="layer5_layer1_sl_hdpe">
										<option value=''>--Select HDPE--</option>
										<?php if($hdpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach ($hdpe as $hdpe_row) {
											$selected=($hdpe_row->article_no==$layer_5_layer_1_hdpe?'selected':'');
											echo "<option value='".$hdpe_row->article_no."' ".set_select('layer_5_rm_3_code',$hdpe_row->article_no).$selected.">".$hdpe_row->lang_article_description."</option>";
										}
										}?>
										</select>

				</td>
				<td>
					<input type='hidden' name='layer_5_sqsd_3' value='<?php echo $layer_5_sqsd_3;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer5_layer1_hdpe_rate" name="layer_5_rm_3_rate" value="<?php echo set_value('layer_5_rm_3_rate',$layer_5_layer_1_hdpe_rate);?>" size="5">
				</td>	
				<td ><input type="number" style="width: 7em;" name="layer_5_rm_3_percentage" id="layer5_layer1_hd_percentage" placeholder="%" value="<?php echo set_value('layer_5_rm_3_percentage',$layer_5_layer_1_hdpe_percentage);?>" />
					<input type="hidden"  name="layer_5_layer_3_micron" value="<?php echo set_value('layer_5_layer_3_micron');?>" />
				</td>			
			</tr>
			<tr>
				<td><input type='hidden' name='sr_no[]' value='4'>4 <input type='hidden' name='layer_5_rm_4' value='MB'></td>
				<td>
				<?php 
		    $layer_5_layer_1_mb_data = array('quotation_no'=>$row->quotation_no,'layer'=>'5','rm'=>'MB');
		    $result_layer_5_layer_1_mb=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_5_layer_1_mb_data,$order_by="",1,0);
		    //echo $this->db->last_query();
		   	if($result_layer_5_layer_1_mb==FALSE){
		    	$layer_5_layer_1_mb = '';
		    	$layer_5_layer_1_mb_rate='';
		    	$layer_5_layer_1_micron='';
		    	$layer_5_layer_1_mb_percentage='';
		    }
		    else{
					foreach ($result_layer_5_layer_1_mb as $result_layer_5_layer_1_mb_row){
						$layer_5_layer_1_mb = $result_layer_5_layer_1_mb_row->rm_code;
						$layer_5_layer_1_mb_rate=$result_layer_5_layer_1_mb_row->rm_rate;
						$layer_5_layer_1_micron=$result_layer_5_layer_1_mb_row->micron;
						$layer_5_layer_1_mb_percentage=$result_layer_5_layer_1_mb_row->rm_percentage;
						$layer_5_sqsd_4=$result_layer_5_layer_1_mb_row->sqsd_id;
					}
				}
				?>		
					
				 MB : <select name="layer_5_rm_4_code" id="layer5_layer_1_rm_4_code" >
				 							<option value=''>--Select MB--</option>
										<?php if($masterbatch==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach ($masterbatch as $masterbatch_row) {
											$selected=($masterbatch_row->article_no==$layer_5_layer_1_mb?'selected':'');
											echo "<option value='".$masterbatch_row->article_no."' ".set_select('layer_5_rm_4_code',$masterbatch_row->article_no).$selected.">".$masterbatch_row->lang_article_description."</option>";
										}
										}?></select>

				</td>
				<td>
					<input type='hidden' name='layer_5_sqsd_4' value='<?php echo $layer_5_sqsd_4;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer5_layer_1_rm_4_rate" name="layer_5_rm_4_rate" value="<?php echo set_value('layer_5_rm_4_rate',$layer_5_layer_1_mb_rate);?>" size="5">
				</td>	
				<td ><input type="number" style="width: 7em;" name="layer_5_rm_4_percentage" id="layer5_layer_1_rm_4_percentage" placeholder="%" value="<?php echo set_value('layer_5_rm_4_percentage',$layer_5_layer_1_mb_percentage);?>" />
					<input type="hidden"  name="layer_5_layer_4_micron" value="<?php echo set_value('layer_5_layer_4_micron');?>" />
				</td>			
			</tr>

			<tr>
				<td><input type='hidden' name='sr_no[]' value='5'>5 <input type='hidden' name='layer_5_rm_5' value='MB'></td>
				<td> 
					<?php 
		    $layer_5_layer_1_mb1_data = array('quotation_no'=>$row->quotation_no,'layer'=>'5','rm'=>'MB');
		    $result_layer_5_layer_1_mb1=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_5_layer_1_mb1_data,$order_by="",2,0);
		    //echo $this->db->last_query();
		   	if($result_layer_5_layer_1_mb1==FALSE){
		    	$layer_5_layer_1_mb1 = '';
		    	$layer_5_layer_1_mb1_rate='';
		    	$layer_5_layer_1_micron='';
		    	$layer_5_layer_1_mb1_percentage='';
		    }
		    else{
					foreach ($result_layer_5_layer_1_mb1 as $result_layer_5_layer_1_mb1_row){
						$layer_5_layer_1_mb1 = $result_layer_5_layer_1_mb1_row->rm_code;
						$layer_5_layer_1_mb1_rate=$result_layer_5_layer_1_mb1_row->rm_rate;
						$layer_5_layer_1_micron=$result_layer_5_layer_1_mb1_row->micron;
						$layer_5_layer_1_mb1_percentage=$result_layer_5_layer_1_mb1_row->rm_percentage;
						$layer_5_sqsd_5=$result_layer_5_layer_1_mb1_row->sqsd_id;
					}
				}
				?>

					MB : <input type="text" size="25" name="layer_5_rm_5_code" id="layer5_layer_1_rm_5_code" placeholder="If MB is not in system"value="<?php echo set_value('layer_5_rm_5_code',$layer_5_layer_1_mb1);?>" />

				</td>
				<td>
					<input type='hidden' name='layer_5_sqsd_5' value='<?php echo $layer_5_sqsd_5;?>'>
					<input type="text" size="5" name="layer_5_rm_5_rate" id="layer5_layer_1_rm_5_rate" value="<?php echo set_value('layer_5_rm_5_rate',$layer_5_layer_1_mb1_rate);?>" />
				</td>	
				<td ><input type="number" style="width: 7em;" name="layer_5_rm_5_percentage" id="layer5_layer_1_rm_5_percentage" placeholder="%" value="<?php echo set_value('layer_5_rm_5_percentage',$layer_5_layer_1_mb1_percentage);?>" />
					<input type="hidden"  name="layer_5_layer_5_micron" value="<?php echo set_value('layer_5_layer_5_micron');?>" />
				</td>			
			</tr>

			<tr>
				<td><input type='hidden' name='sr_no[]' value='6'>6 <input type='hidden' name='layer_5_rm_6' value='ADMER'></td>
				<td>LAYER 2</td>

				<td>
				<?php 
		    $layer_5_layer_2_admer_data = array('quotation_no'=>$row->quotation_no,'layer'=>'5','rm'=>'ADMER');
		    $result_layer_5_layer_2_admer=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_5_layer_2_admer_data,$order_by="",1,0);
		    //echo $this->db->last_query();
		    	if($result_layer_5_layer_2_admer==FALSE){
		    	$layer_5_layer_2_admer = '';
		    	$layer_5_layer_2_admer_rate='';
		    	$layer_5_layer_2_micron='';
		    	$layer_5_layer_2_admer_percentage='';
		    }
		    else{
					foreach ($result_layer_5_layer_2_admer as $result_layer_5_layer_2_admer_row){
						$layer_5_layer_2_admer = $result_layer_5_layer_2_admer_row->rm_code;
						$layer_5_layer_2_admer_rate=$result_layer_5_layer_2_admer_row->rm_rate;
						$layer_5_layer_2_micron=$result_layer_5_layer_2_admer_row->micron;
						$layer_5_layer_2_admer_percentage=$result_layer_5_layer_2_admer_row->rm_percentage;
						$layer_5_sqsd_6=$result_layer_5_layer_2_admer_row->sqsd_id;
					
					}
				}
		    ?>	

				 ADMER : <select name="layer_5_rm_6_code" id="layer5_layer2_admer" >
                             <option value=''>--Select Admer--</option>
                              <?php if($admer==FALSE){
																echo "<option value=''>--Setup Required--</option>";}
														else{
                              foreach ($admer as $admer_row) {
                              	$selected=($admer_row->article_no==$layer_5_layer_2_admer?'selected':'');
                                 echo "<option value='".$admer_row->article_no."' ".set_select('layer_5_rm_6_code',$admer_row->article_no).$selected.">".$admer_row->lang_article_description."</option>";
                              }
                              }?>
                              </select>

				</td>
				<td>
					<input type='hidden' name='layer_5_sqsd_6' value='<?php echo $layer_5_sqsd_6;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer5_layer2_admer_rate" name="layer_5_rm_6_rate" value="<?php echo set_value('layer_5_rm_6_rate',$layer_5_layer_2_admer_rate);?>" size="5">
				</td>
				<td><input type="text" style="width: 7em;" name="layer_5_layer_6_micron" id="layer5_layer2_micron" value="<?php echo set_value('layer_5_layer_6_micron',$layer_5_layer_2_micron);?>"  />
				</td> 
				<td><input type="number" style="width: 7em;" name="layer_5_rm_6_percentage" id="layer5_layer2_admer_percentage" placeholder="%" value="<?php echo set_value('layer_5_rm_6_percentage',$layer_5_layer_2_admer_percentage);?>" />
				</td>			
			</tr>
			

			<tr>
				<td><input type='hidden' name='sr_no[]' value='7'>7 <input type='hidden' name='layer_5_rm_7' value='EVOH'></td>
				<td>LAYER 3</td>

				<td> 
					<?php 
		    $layer_5_layer_3_evoh_data = array('quotation_no'=>$row->quotation_no,'layer'=>'5','rm'=>'EVOH');
		    $result_layer_5_layer_3_evoh=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_5_layer_3_evoh_data,$order_by="",1,0);
		    //echo $this->db->last_query();
		    	if($result_layer_5_layer_3_evoh==FALSE){
		    	$layer_5_layer_3_evoh = '';
		    	$layer_5_layer_3_evoh_rate='';
		    	$layer_5_layer_3_micron='';
		    	$layer_5_layer_3_evoh_percentage='';
		    }
		    else{
					foreach ($result_layer_5_layer_3_evoh as $result_layer_5_layer_3_evoh_row){
						$layer_5_layer_3_evoh = $result_layer_5_layer_3_evoh_row->rm_code;
						$layer_5_layer_3_evoh_rate=$result_layer_5_layer_3_evoh_row->rm_rate;
						$layer_5_layer_3_micron=$result_layer_5_layer_3_evoh_row->micron;
						$layer_5_layer_3_evoh_percentage=$result_layer_5_layer_3_evoh_row->rm_percentage;
						$layer_5_sqsd_7=$result_layer_5_layer_3_evoh_row->sqsd_id;
					
					}
				}
		    ?>	

					EVOH : <select name="layer_5_rm_7_code" id="layer5_layer3_evoh" >
                              <option value=''>--Select evoh--</option>
                            <?php if($evoh==FALSE){
																echo "<option value=''>--Setup Required--</option>";}
														else{
                              foreach ($evoh as $evoh_row) {
                              	$selected=($evoh_row->article_no==$layer_5_layer_3_evoh?'selected':'');
                                 echo "<option value='".$evoh_row->article_no."' ".set_select('layer_5_rm_7_code',$evoh_row->article_no).$selected.">".$evoh_row->lang_article_description."</option>";
                              }
                              }?>
                              </select>

				</td>
				<td>
					<input type='hidden' name='layer_5_sqsd_7' value='<?php echo $layer_5_sqsd_7;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer5_layer3_evoh_rate" name="layer_5_rm_7_rate" value="<?php echo set_value('layer_5_rm_7_rate',$layer_5_layer_3_evoh_rate);?>" size="5">
				</td>
				<td><input type="text" style="width: 7em;" name="layer_5_layer_7_micron" id="layer5_layer3_micron" value="<?php echo set_value('layer_5_layer_7_micron',$layer_5_layer_3_micron);?>"  />
				</td>
				<td><input type="number" style="width: 7em;" name="layer_5_rm_7_percentage" id="layer5_layer3_evoh_percentage" placeholder="%" value="<?php echo set_value('layer_5_rm_7_percentage',$layer_5_layer_3_evoh_percentage);?>" />
				</td>			
			</tr>

			<tr>
				<td><input type='hidden' name='sr_no[]' value='8'>8 <input type='hidden' name='layer_5_rm_8' value='ADMER'></td>
				<td>LAYER 4</td>

				<td> 
				<?php 
		    $layer_5_layer_4_admer_data = array('quotation_no'=>$row->quotation_no,'layer'=>'5','rm'=>'ADMER');
		    $result_layer_5_layer_4_admer=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_5_layer_4_admer_data,$order_by="",2,0);
		    //echo $this->db->last_query();
		    	if($result_layer_5_layer_4_admer==FALSE){
		    	$layer_5_layer_4_admer = '';
		    	$layer_5_layer_4_admer_rate='';
		    	$layer_5_layer_4_micron='';
		    	$layer_5_layer_4_admer_percentage='';
		    }
		    else{
					foreach ($result_layer_5_layer_4_admer as $result_layer_5_layer_4_admer_row){
						$layer_5_layer_4_admer = $result_layer_5_layer_4_admer_row->rm_code;
						$layer_5_layer_4_admer_rate=$result_layer_5_layer_4_admer_row->rm_rate;
						$layer_5_layer_4_micron=$result_layer_5_layer_4_admer_row->micron;
						$layer_5_layer_4_admer_percentage=$result_layer_5_layer_4_admer_row->rm_percentage;
						$layer_5_sqsd_8=$result_layer_5_layer_4_admer_row->sqsd_id;
					
					}
				}
		    ?>		

					ADMER : <select name="layer_5_rm_8_code" id="layer5_layer4_admer" >
                              <option value=''>--Select Admer--</option>
                              <?php if($admer==FALSE){
																echo "<option value=''>--Setup Required--</option>";}
														else{
                              foreach ($admer as $admer_row) {
                              	$selected=($admer_row->article_no==$layer_5_layer_4_admer?'selected':'');
                                 echo "<option value='".$admer_row->article_no."' ".set_select('layer_5_rm_8_code',$admer_row->article_no).$selected.">".$admer_row->lang_article_description."</option>";
                              }
                              }?>
                              </select>

				</td>
				<td>
					<input type='hidden' name='layer_5_sqsd_8' value='<?php echo $layer_5_sqsd_8;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer5_layer4_admer_rate" name="layer_5_rm_8_rate" value="<?php echo set_value('layer_5_rm_8_rate',$layer_5_layer_4_admer_rate);?>" size="5">
				</td>
				<td><input type="text" style="width: 7em;" name="layer_5_layer_8_micron" id="layer5_layer4_micron" value="<?php echo set_value('layer_5_layer_8_micron',$layer_5_layer_4_micron);?>"  />
				</td>
				<td><input type="number" style="width: 7em;" name="layer_5_rm_8_percentage" id="layer5_layer4_admer_percentage" placeholder="%" value="<?php echo set_value('layer_5_rm_8_percentage',$layer_5_layer_4_admer_percentage);?>" />
				</td>			
			</tr>


			<tr>
				<td><input type='hidden' name='sr_no[]' value='9'>9 <input type='hidden' name='layer_5_rm_9' value='LDPE'></td>
				<td rowspan="5">LAYER 5</td>

				<td>
				<?php 
		    $layer_5_layer_5_ldpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'5','rm'=>'LDPE');
		    $result_layer_5_layer_5_ldpe=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_5_layer_5_ldpe_data,$order_by="",2,0);
		    //echo $this->db->last_query();
		   	if($result_layer_5_layer_5_ldpe==FALSE){
		    	$layer_5_layer_5_ldpe = '';
		    	$layer_5_layer_5_ldpe_rate='';
		    	$layer_5_layer_5_micron='';
		    	$layer_5_layer_5_ldpe_percentage='';
		    }
		    else{
					foreach ($result_layer_5_layer_5_ldpe as $result_layer_5_layer_5_ldpe_row){
						$layer_5_layer_5_ldpe = $result_layer_5_layer_5_ldpe_row->rm_code;
						$layer_5_layer_5_ldpe_rate=$result_layer_5_layer_5_ldpe_row->rm_rate;
						$layer_5_layer_5_micron=$result_layer_5_layer_5_ldpe_row->micron;
						$layer_5_layer_5_ldpe_percentage=$result_layer_5_layer_5_ldpe_row->rm_percentage;
						$layer_5_sqsd_9=$result_layer_5_layer_5_ldpe_row->sqsd_id;
					}
				}
				?>	
					
				 LD : <select name="layer_5_rm_9_code" id="layer5_layer5_sl_ldpe">
										<option value=''>--Select RM --</option>
									<?php 
								if($ldpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
										foreach ($ldpe as $ldpe_row) {
											$selected=($ldpe_row->article_no==$layer_5_layer_5_ldpe?'selected':'');
											echo "<option value='".$ldpe_row->article_no."' ".set_select('layer_5_rm_9_code',$ldpe_row->article_no).$selected.">".$ldpe_row->lang_article_description."</option>";
										}
										}?>
										</select>
				
				</td>
				<td>
					<input type='hidden' name='layer_5_sqsd_9' value='<?php echo $layer_5_sqsd_9;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer5_layer5_ldpe_rate" name="layer_5_rm_9_rate" value="<?php echo set_value('layer_5_rm_9_rate',$layer_5_layer_5_ldpe_rate);?>" size="5">
				</td>
				<td rowspan="5"><input type="text" style="width: 7em;" name="layer_5_layer_9_micron" id="layer5_layer5_micron" value="<?php echo set_value('layer_5_layer_9_micron',$layer_5_layer_5_micron);?>"  />
				</td>
				<td><input type="number" style="width: 7em;" name="layer_5_rm_9_percentage" id="layer5_layer5_ld_percentage" placeholder="%" value="<?php echo set_value('layer_5_rm_9_percentage',$layer_5_layer_5_ldpe_percentage);?>" />
				</td>			
			</tr>
			<tr>
				<td><input type='hidden' name='sr_no[]' value='10'>10 <input type='hidden' name='layer_5_rm_10' value='LLDPE'></td>				
				<td>
				<?php 
					$layer_5_layer_5_lldpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'5','rm'=>'LLDPE');
					$result_layer_5_layer_5_lldpe=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_5_layer_5_lldpe_data,$order_by="",2,0);
					//echo $this->db->last_query();
						if($result_layer_5_layer_5_lldpe==FALSE){
						$layer_5_layer_5_lldpe = '';
						$layer_5_layer_5_lldpe_rate='';
						$layer_5_layer_5_micron='';
						$layer_5_layer_5_lldpe_percentage='';
					}
					else{
							foreach ($result_layer_5_layer_5_lldpe as $result_layer_5_layer_5_lldpe_row){
								$layer_5_layer_5_lldpe = $result_layer_5_layer_5_lldpe_row->rm_code;
								$layer_5_layer_5_lldpe_rate=$result_layer_5_layer_5_lldpe_row->rm_rate;
								$layer_5_layer_5_micron=$result_layer_5_layer_5_lldpe_row->micron;
								$layer_5_layer_5_lldpe_percentage=$result_layer_5_layer_5_lldpe_row->rm_percentage;
								$layer_5_sqsd_10=$result_layer_5_layer_5_lldpe_row->sqsd_id;
							}
						}
						?>	

				 LLD : <select name="layer_5_rm_10_code" id="layer5_layer5_sl_lldpe">
										<option value=''>--Select RM --</option>
										<?php if($lldpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach ($lldpe as $lldpe_row) {
											$selected=($lldpe_row->article_no==$layer_5_layer_5_lldpe?'selected':'');
											echo "<option value='".$lldpe_row->article_no."' ".set_select('layer_5_rm_10_code',$lldpe_row->article_no).$selected.">".$lldpe_row->lang_article_description."</option>";
										}
										}?>
										</select>

				</td>
				<td>
					<input type='hidden' name='layer_5_sqsd_10' value='<?php echo $layer_5_sqsd_10;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer5_layer5_lldpe_rate" name="layer_5_rm_10_rate" value="<?php echo set_value('layer_5_rm_10_rate',$layer_5_layer_5_lldpe_rate);?>" size="5">
				</td>		
				<td ><input type="number" style="width: 7em;" name="layer_5_rm_10_percentage" id="layer5_layer5_lld_percentage" placeholder="%" value="<?php echo set_value('layer_5_rm_10_percentage',$layer_5_layer_5_lldpe_percentage);?>" />
					<input type="hidden"  name="layer_5_layer_10_micron" value="<?php echo set_value('layer_5_layer_10_micron');?>" />
				</td>			
			</tr>

			<tr>
				<td><input type='hidden' name='sr_no[]' value='11'>11 <input type='hidden' name='layer_5_rm_11' value='HDPE'></td>	
				<td> 
					<?php 
		    $layer_5_layer_5_hdpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'5','rm'=>'HDPE');
		    $result_layer_5_layer_5_hdpe=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_5_layer_5_hdpe_data,$order_by="",2,0);
		   	if($result_layer_5_layer_5_hdpe==FALSE){
		    	$layer_5_layer_5_hdpe = '';
		    	$layer_5_layer_5_hdpe_rate='';
		    	$layer_5_layer_5_micron='';
		    	$layer_5_layer_5_hdpe_percentage='';
		    }
		    else{
					foreach ($result_layer_5_layer_5_hdpe as $result_layer_5_layer_5_hdpe_row){
						$layer_5_layer_5_hdpe = $result_layer_5_layer_5_hdpe_row->rm_code;
						$layer_5_layer_5_hdpe_rate=$result_layer_5_layer_5_hdpe_row->rm_rate;
						$layer_5_layer_5_micron=$result_layer_5_layer_5_hdpe_row->micron;
						$layer_5_layer_5_hdpe_percentage=$result_layer_5_layer_5_hdpe_row->rm_percentage;
						$layer_5_sqsd_11=$result_layer_5_layer_5_hdpe_row->sqsd_id;
					}
				}
				?>		

					HD : <select name="layer_5_rm_11_code" id="layer5_layer5_sl_hdpe">
										<option value=''>--Select HDPE--</option>
										<?php if($hdpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach ($hdpe as $hdpe_row) {
											$selected=($hdpe_row->article_no==$layer_5_layer_5_hdpe?'selected':'');
											echo "<option value='".$hdpe_row->article_no."' ".set_select('layer_5_rm_11_code',$hdpe_row->article_no).$selected.">".$hdpe_row->lang_article_description."</option>";
										}
										}?>
										</select>

				</td>
				<td>
					<input type='hidden' name='layer_5_sqsd_11' value='<?php echo $layer_5_sqsd_11;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer5_layer5_hdpe_rate" name="layer_5_rm_11_rate" value="<?php echo set_value('layer_5_rm_11_rate',$layer_5_layer_5_hdpe_rate);?>" size="5">
				</td>	
				<td ><input type="number" style="width: 7em;" name="layer_5_rm_11_percentage" id="layer5_layer5_hd_percentage" placeholder="%" value="<?php echo set_value('layer_5_rm_11_percentage',$layer_5_layer_5_hdpe_percentage);?>" />
					<input type="hidden"  name="layer_5_layer_11_micron" value="<?php echo set_value('layer_5_layer_11_micron');?>" />
				</td>			
			</tr>

			<tr>
				<td><input type='hidden' name='sr_no[]' value='12'>12 <input type='hidden' name='layer_5_rm_12' value='MB'></td>
				<td>
				<?php 
		    $layer_5_layer_5_mb_data = array('quotation_no'=>$row->quotation_no,'layer'=>'5','rm'=>'MB');
		    $result_layer_5_layer_5_mb=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_5_layer_5_mb_data,$order_by="",3,0);
		    //echo $this->db->last_query();
		   	if($result_layer_5_layer_5_mb==FALSE){
		    	$layer_5_layer_5_mb = '';
		    	$layer_5_layer_5_mb_rate='';
		    	$layer_5_layer_5_micron='';
		    	$layer_5_layer_5_mb_percentage='';
		    }
		    else{
					foreach ($result_layer_5_layer_5_mb as $result_layer_5_layer_5_mb_row){
						$layer_5_layer_5_mb = $result_layer_5_layer_5_mb_row->rm_code;
						$layer_5_layer_5_mb_rate=$result_layer_5_layer_5_mb_row->rm_rate;
						$layer_5_layer_5_micron=$result_layer_5_layer_5_mb_row->micron;
						$layer_5_layer_5_mb_percentage=$result_layer_5_layer_5_mb_row->rm_percentage;
						$layer_5_sqsd_12=$result_layer_5_layer_5_mb_row->sqsd_id;
					}
				}
				?>		

				 MB : <select name="layer_5_rm_12_code" id="layer5_layer_5_rm_12_code" >
				 								<option value=''>--Select MB--</option>
										<?php if($masterbatch==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach ($masterbatch as $masterbatch_row) {
											$selected=($masterbatch_row->article_no==$layer_5_layer_5_mb?'selected':'');
											echo "<option value='".$masterbatch_row->article_no."' ".set_select('layer_5_rm_12_code',$masterbatch_row->article_no).$selected.">".$masterbatch_row->lang_article_description."</option>";
										}
										}?></select>

				</td>
				<td>
					<input type='hidden' name='layer_5_sqsd_12' value='<?php echo $layer_5_sqsd_12;?>'>
					<input type="text" readonly="readonly" style="background-color: #ddd" id="layer5_layer_5_rm_12_rate" name="layer_5_rm_12_rate" value="<?php echo set_value('layer_5_rm_12_rate',$layer_5_layer_5_mb_rate);?>" size="5">
				</td>	
				<td ><input type="number" style="width: 7em;" name="layer_5_rm_12_percentage" id="layer5_layer_5_rm_12_percentage" placeholder="%" value="<?php echo set_value('layer_5_rm_12_percentage',$layer_5_layer_5_mb_percentage);?>" />
					<input type="hidden"  name="layer_5_layer_12_micron" value="<?php echo set_value('layer_5_layer_12_micron');?>" />
				</td>			
			</tr>

			<tr>
				<td><input type='hidden' name='sr_no[]' value='13'>13 <input type='hidden' name='layer_5_rm_13' value='MB'></td>
				<td> 
					<?php 
		    $layer_5_layer_5_mb1_data = array('quotation_no'=>$row->quotation_no,'layer'=>'5','rm'=>'MB');
		    $result_layer_5_layer_5_mb1=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_5_layer_5_mb1_data,$order_by="",4,0);
		    //echo $this->db->last_query();
		   	if($result_layer_5_layer_5_mb1==FALSE){
		    	$layer_5_layer_5_mb1 = '';
		    	$layer_5_layer_5_mb1_rate='';
		    	$layer_5_layer_5_micron='';
		    	$layer_5_layer_5_mb1_percentage='';
		    }
		    else{
					foreach ($result_layer_5_layer_5_mb1 as $result_layer_5_layer_5_mb1_row){
						$layer_5_layer_5_mb1 = $result_layer_5_layer_5_mb1_row->rm_code;
						$layer_5_layer_5_mb1_rate=$result_layer_5_layer_5_mb1_row->rm_rate;
						$layer_5_layer_5_micron=$result_layer_5_layer_5_mb1_row->micron;
						$layer_5_layer_5_mb1_percentage=$result_layer_5_layer_5_mb1_row->rm_percentage;
						$layer_5_sqsd_13=$result_layer_5_layer_5_mb1_row->sqsd_id;
					}
				}
				?>

					MB : <input type="text" size="25" name="layer_5_rm_13_code" id="layer5_layer_5_rm_13_code" placeholder="If MB is not in system"value="<?php echo set_value('layer_5_rm_13_code',$layer_5_layer_5_mb1);?>" />

				</td>
				<td>
					<input type='hidden' name='layer_5_sqsd_13' value='<?php echo $layer_5_sqsd_13;?>'>
					<input type="text" name="layer_5_rm_13_rate" id="layer5_layer_5_rm_13_rate" value="<?php echo set_value('layer_5_rm_13_rate',$layer_5_layer_5_mb1_rate);?>" size="5" />
				</td>	
				<td ><input type="number" style="width: 7em;" name="layer_5_rm_13_percentage" id="layer5_layer_5_rm_13_percentage" placeholder="%" value="<?php echo set_value('layer_5_rm_13_percentage',$layer_5_layer_5_mb1_percentage);?>" />
					<input type="hidden"  name="layer_5_layer_13_micron" value="<?php echo set_value('layer_5_layer_13_micron');?>" />
				</td>			
			</tr>

			<tr>
				<td colspan="5">
				<?php 
		    $layer_5_rejection_data = array('quotation_no'=>$row->quotation_no,'layer'=>'5');
		    $result_layer_5_rejection=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_5_rejection_data,$order_by="",1,0);
		    //echo $this->db->last_query();
		    	if($result_layer_5_rejection==FALSE){
		    	$layer_5_rejection = '';
		    }
		    else{
					foreach ($result_layer_5_rejection as $result_layer_5_rejection_row){
						$layer_5_rejection = $result_layer_5_rejection_row->rejection;
					
					}
				}
		    ?>		

				Rejection %</td>				
				<td> <input type="number" style="width: 7em;" name="layer5_rejection" id="layer5_rejection" value="<?php echo set_value('layer5_rejection',$layer_5_rejection);?>" />	</td>			
			</tr>

			<tr>
				<td colspan="5">Quantity</td>
				<td> <input type="number" readonly="readonly" style="width: 7em;background-color: #ddd" size="3" name="layer5_quantity" id="layer5_quantity" value="<?php echo set_value('layer5_quantity','1');?>" />	</td>			
			</tr>

			<tr>
				<td colspan="5">
					<?php 
		    $layer_5_sleeve_cost_data = array('quotation_no'=>$row->quotation_no,'layer'=>'5');
		    $result_layer_5_sleeve_cost=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_5_sleeve_cost_data,$order_by="",1,0);
		    //echo $this->db->last_query();
		    	if($result_layer_5_sleeve_cost==FALSE){
		    	$layer_5_sleeve_cost = '';
		    }
		    else{
					foreach ($result_layer_5_sleeve_cost as $result_layer_5_sleeve_cost_row){
						$layer_5_sleeve_cost = $result_layer_5_sleeve_cost_row->sleeve_per_cost;
					
					}
				}
		    ?>

					<span class="ui green label" id="layer5_sleevecost" >ADD</span></td>
				<td><input  readonly="readonly" type="number" style="width: 7em;" name="layer5_sleeve_cost" id="layer5_sleeve_cost" value="<?php echo set_value('layer5_sleeve_cost',$layer_5_sleeve_cost);?>"  />	
				</td>

			</tr>
			</tbody>
		</table>
  </div>
</div>

	<!--------------------------------------------------Layer 7 --------------------------------->
<div id="layer7" class="modal" style="display:none;">
  <div class="modal-content" style="height:550px;overflow-y: scroll;">

    <span class="close">&times;</span>
    
    <table class="ui celled structured table" >
      <thead>
      <tr>
        <th>SR NO</th><th>LAYER</th><th>RM </th><th>RATE </th><th>MICRON</th><th>LOADING%</th>
        
      </tr>
    </thead>
    <tbody>
      <tr> 
        <td>
        	<input type='hidden' name='layer_7_rows' value='19'>
        	<input type='hidden' name='sr_no[]' value='1'>1 
        	<input type='hidden' name='layer_7_rm_1' value='LDPE'></td>
        <td rowspan="3">LAYER 1</td>

        <td>
        <?php 
		    $layer_7_layer_1_ldpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'7','rm'=>'LDPE');
		    $result_layer_7_layer_1_ldpe=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_7_layer_1_ldpe_data,$order_by="",1,0);
		   	if($result_layer_7_layer_1_ldpe==FALSE){
		    	$layer_7_layer_1_ldpe = '';
		    	$layer_7_layer_1_ldpe_rate='';
		    	$layer_7_layer_1_micron='';
		    	$layer_7_layer_1_ldpe_percentage='';
		    }
		    else{
					foreach ($result_layer_7_layer_1_ldpe as $result_layer_7_layer_1_ldpe_row){
						$layer_7_layer_1_ldpe = $result_layer_7_layer_1_ldpe_row->rm_code;
						$layer_7_layer_1_ldpe_rate=$result_layer_7_layer_1_ldpe_row->rm_rate;
						$layer_7_layer_1_micron=$result_layer_7_layer_1_ldpe_row->micron;
						$layer_7_layer_1_ldpe_percentage=$result_layer_7_layer_1_ldpe_row->rm_percentage;
						$layer_7_sqsd_1=$result_layer_7_layer_1_ldpe_row->sqsd_id;
					}
				}
				?>		

         LD : <select name="layer_7_rm_1_code" id="layer7_layer1_sl_ldpe">
                    <option value=''>--Select RM --</option>
								<?php 
								if($ldpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
										foreach ($ldpe as $ldpe_row) {
											$selected=($ldpe_row->article_no==$layer_7_layer_1_ldpe?'selected':'');
                      echo "<option value='".$ldpe_row->article_no."' ".set_select('layer_7_rm_1_code',$ldpe_row->article_no).$selected.">".$ldpe_row->lang_article_description."</option>";
                    }
                    }?>
                    </select>
        
        </td>
        <td>
        	<input type='hidden' name='layer_7_sqsd_1' value='<?php echo $layer_7_sqsd_1;?>'>
        	<input type="text" readonly="readonly" style="background-color: #ddd" id="layer7_layer1_ldpe_rate" name="layer_7_rm_1_rate" value="<?php echo set_value('layer_7_rm_1_rate',$layer_7_layer_1_ldpe_rate);?>" size="5">
        </td>
        <td rowspan="3"><input type="text" style="width: 7em;" name="layer_7_layer_1_micron" id="layer7_layer1_micron" value="<?php echo set_value('layer_7_layer_1_micron',$layer_7_layer_1_micron);?>"  />
        </td>
        <td><input type="number" style="width: 7em;" name="layer_7_rm_1_percentage" id="layer7_layer1_ld_percentage" placeholder="%" value="<?php echo set_value('layer_7_rm_1_percentage',$layer_7_layer_1_ldpe_percentage);?>" />
        </td>     
      </tr>
      <tr>  
        <td><input type='hidden' name='sr_no[]' value='2'>2 <input type='hidden' name='layer_7_rm_2' value='LLDPE'></td>      
        <td>	
        <?php 
					$layer_7_layer_1_lldpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'7','rm'=>'LLDPE');
					$result_layer_7_layer_1_lldpe=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_7_layer_1_lldpe_data,$order_by="",1,0);
					//echo $this->db->last_query();
						if($result_layer_7_layer_1_lldpe==FALSE){
						$layer_7_layer_1_lldpe = '';
						$layer_7_layer_1_lldpe_rate='';
						$layer_7_layer_1_micron='';
						$layer_7_layer_1_lldpe_percentage='';
					}
					else{
							foreach ($result_layer_7_layer_1_lldpe as $result_layer_7_layer_1_lldpe_row){
								$layer_7_layer_1_lldpe = $result_layer_7_layer_1_lldpe_row->rm_code;
								$layer_7_layer_1_lldpe_rate=$result_layer_7_layer_1_lldpe_row->rm_rate;
								$layer_7_layer_1_micron=$result_layer_7_layer_1_lldpe_row->micron;
								$layer_7_layer_1_lldpe_percentage=$result_layer_7_layer_1_lldpe_row->rm_percentage;
								$layer_7_sqsd_2=$result_layer_7_layer_1_lldpe_row->sqsd_id;
							}
						}
						?>	


         LLD : <select name="layer_7_rm_2_code" id="layer7_layer1_sl_lldpe">
                    <option value=''>--Select RM --</option>
										<?php if($lldpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach ($lldpe as $lldpe_row) {
											$selected=($lldpe_row->article_no==$layer_7_layer_1_lldpe?'selected':'');
                      echo "<option value='".$lldpe_row->article_no."' ".set_select('layer_7_rm_2_code',$lldpe_row->article_no).$selected.">".$lldpe_row->lang_article_description."</option>";
                    }
                    }?>
                    </select>

        </td>
        <td>
        	<input type='hidden' name='layer_7_sqsd_2' value='<?php echo $layer_7_sqsd_2;?>'>
        	<input type="text" readonly="readonly" style="background-color: #ddd" id="layer7_layer1_lldpe_rate" name="layer_7_rm_2_rate" value="<?php echo set_value('layer_7_rm_2_rate',$layer_7_layer_1_lldpe_rate);?>" size="5">
        </td>    
        <td ><input type="number" style="width: 7em;" name="layer_7_rm_2_percentage" id="layer7_layer1_lld_percentage" placeholder="%"  value="<?php echo set_value('layer_7_rm_2_percentage',$layer_7_layer_1_lldpe_percentage);?>" />
        	<input type="hidden"  name="layer_7_layer_2_micron" value="<?php echo set_value('layer_7_layer_2_micron');?>" />
        </td>     
      </tr>

      <tr>
      	<td><input type='hidden' name='sr_no[]' value='3'>3 <input type='hidden' name='layer_7_rm_3' value='HDPE'></td>
        <td>
        	<?php 
		    $layer_7_layer_1_hdpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'7','rm'=>'HDPE');
		    $result_layer_7_layer_1_hdpe=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_7_layer_1_hdpe_data,$order_by="",1,0);
		   	if($result_layer_7_layer_1_hdpe==FALSE){
		    	$layer_7_layer_1_hdpe = '';
		    	$layer_7_layer_1_hdpe_rate='';
		    	$layer_7_layer_1_micron='';
		    	$layer_7_layer_1_hdpe_percentage='';
		    }
		    else{
					foreach ($result_layer_7_layer_1_hdpe as $result_layer_7_layer_1_hdpe_row){
						$layer_7_layer_1_hdpe = $result_layer_7_layer_1_hdpe_row->rm_code;
						$layer_7_layer_1_hdpe_rate=$result_layer_7_layer_1_hdpe_row->rm_rate;
						$layer_7_layer_1_micron=$result_layer_7_layer_1_hdpe_row->micron;
						$layer_7_layer_1_hdpe_percentage=$result_layer_7_layer_1_hdpe_row->rm_percentage;
						$layer_7_sqsd_3=$result_layer_7_layer_1_hdpe_row->sqsd_id;
					}
				}
				?>				
         HD : <select name="layer_7_rm_3_code" id="layer7_layer1_sl_hdpe">
                    <option value=''>--Select HDPE--</option>
										<?php if($hdpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach ($hdpe as $hdpe_row) {
											$selected=($hdpe_row->article_no==$layer_7_layer_1_hdpe?'selected':'');
                      echo "<option value='".$hdpe_row->article_no."' ".set_select('layer_7_rm_3_code',$hdpe_row->article_no).$selected.">".$hdpe_row->lang_article_description."</option>";
                    }
                    }?>
                    </select>

        </td>
        <td>
        	<input type='hidden' name='layer_7_sqsd_3' value='<?php echo $layer_7_sqsd_3;?>'>
        	<input type="text" readonly="readonly" style="background-color: #ddd" id="layer7_layer1_hdpe_rate" name="layer_7_rm_3_rate" value="<?php echo set_value('layer_7_rm_3_rate',$layer_7_layer_1_hdpe_rate);?>" size="5">
        </td> 
        <td ><input type="number" style="width: 7em;" name="layer_7_rm_3_percentage" id="layer7_layer1_hd_percentage" placeholder="%"  value="<?php echo set_value('layer_7_rm_3_percentage',$layer_7_layer_1_hdpe_percentage);?>" />
        	<input type="hidden"  name="layer_7_layer_3_micron" value="<?php echo set_value('layer_7_layer_3_micron');?>" />
        </td>     
      </tr>

      <tr>
      	<td><input type='hidden' name='sr_no[]' value='4'>4 <input type='hidden' name='layer_7_rm_4' value='LDPE'></td>
        <td rowspan="5">LAYER 2</td>

        <td>
        	<?php 
		    $layer_7_layer_2_ldpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'7','rm'=>'LDPE');
		    $result_layer_7_layer_2_ldpe=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_7_layer_2_ldpe_data,$order_by="",2,0);
		   	if($result_layer_7_layer_2_ldpe==FALSE){
		    	$layer_7_layer_2_ldpe = '';
		    	$layer_7_layer_2_ldpe_rate='';
		    	$layer_7_layer_2_micron='';
		    	$layer_7_layer_2_ldpe_percentage='';
		    }
		    else{
					foreach ($result_layer_7_layer_2_ldpe as $result_layer_7_layer_2_ldpe_row){
						$layer_7_layer_2_ldpe = $result_layer_7_layer_2_ldpe_row->rm_code;
						$layer_7_layer_2_ldpe_rate=$result_layer_7_layer_2_ldpe_row->rm_rate;
						$layer_7_layer_2_micron=$result_layer_7_layer_2_ldpe_row->micron;
						$layer_7_layer_2_ldpe_percentage=$result_layer_7_layer_2_ldpe_row->rm_percentage;
						$layer_7_sqsd_4=$result_layer_7_layer_2_ldpe_row->sqsd_id;
					}
				}
				?>	

        	 LD : <select name="layer_7_rm_4_code" id="layer7_layer2_sl_ldpe">
                   <option value=''>--Select RM --</option>
								<?php 
								if($ldpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
										foreach ($ldpe as $ldpe_row) {
											$selected=($ldpe_row->article_no==$layer_7_layer_1_ldpe?'selected':'');
                      echo "<option value='".$ldpe_row->article_no."' ".set_select('layer_7_rm_4_code',$ldpe_row->article_no).$selected.">".$ldpe_row->lang_article_description."</option>";
                    }
                    }?>
                    </select>
        
        </td>
        <td>
        	<input type='hidden' name='layer_7_sqsd_4' value='<?php echo $layer_7_sqsd_4;?>'>
        	<input type="text" readonly="readonly" style="background-color: #ddd" id="layer7_layer2_ldpe_rate" name="layer_7_rm_4_rate" value="<?php echo set_value('layer_7_rm_4_rate',$layer_7_layer_2_ldpe_rate);?>" size="5">
        </td>
        <td rowspan="5"><input type="text" style="width: 7em;" name="layer_7_layer_4_micron" id="layer7_layer2_micron" value="<?php echo set_value('layer_7_layer_4_micron',$layer_7_layer_2_micron);?>"  />
        </td>
        <td><input type="number" style="width: 7em;" name="layer_7_rm_4_percentage" id="layer7_layer2_ld_percentage" placeholder="%" value="<?php echo set_value('layer_7_rm_4_percentage',$layer_7_layer_2_ldpe_percentage);?>" />
        </td>     
      </tr>
      <tr>      
      	<td><input type='hidden' name='sr_no[]' value='5'>5 <input type='hidden' name='layer_7_rm_5' value='LLDPE'></td>  
        <td> 
        	<?php 
						$layer_7_layer_2_lldpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'7','rm'=>'LLDPE');
						$result_layer_7_layer_2_lldpe=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_7_layer_2_lldpe_data,$order_by="",2,0);
						//echo $this->db->last_query();
							if($result_layer_7_layer_2_lldpe==FALSE){
							$layer_7_layer_2_lldpe = '';
							$layer_7_layer_2_lldpe_rate='';
							$layer_7_layer_2_micron='';
							$layer_7_layer_2_lldpe_percentage='';
						}
						else{
								foreach ($result_layer_7_layer_2_lldpe as $result_layer_7_layer_2_lldpe_row){
									$layer_7_layer_2_lldpe = $result_layer_7_layer_2_lldpe_row->rm_code;
									$layer_7_layer_2__lldpe_rate=$result_layer_7_layer_2_lldpe_row->rm_rate;
									$layer_7_layer_2_micron=$result_layer_7_layer_2_lldpe_row->micron;
									$layer_7_layer_2_lldpe_percentage=$result_layer_7_layer_2_lldpe_row->rm_percentage;
									$layer_7_sqsd_5=$result_layer_7_layer_2_lldpe_row->sqsd_id;
								}
							}
							?>	

        	LLD : <select name="layer_7_rm_5_code" id="layer7_layer2_sl_lldpe">
                    <option value=''>--Select RM --</option>
										<?php if($lldpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach ($lldpe as $lldpe_row) {
											$selected=($lldpe_row->article_no==$layer_7_layer_2_lldpe?'selected':'');
                      echo "<option value='".$lldpe_row->article_no."' ".set_select('layer_7_rm_5_code',$lldpe_row->article_no).$selected.">".$lldpe_row->lang_article_description."</option>";
                    }
                    }?>
                    </select>

        </td>
        <td>
        	<input type='hidden' name='layer_7_sqsd_5' value='<?php echo $layer_7_sqsd_5;?>'>
        	<input type="text" readonly="readonly" style="background-color: #ddd" id="layer7_layer2_lldpe_rate" name="layer_7_rm_5_rate" value="<?php echo set_value('layer_7_rm_5_rate',$layer_7_layer_2__lldpe_rate);?>" size="5">
        </td>    
        <td ><input type="number" style="width: 7em;" name="layer_7_rm_5_percentage" id="layer7_layer2_lld_percentage" placeholder="%" value="<?php echo set_value('layer_7_rm_5_percentage',$layer_7_layer_2_lldpe_percentage);?>" />
        	<input type="hidden"  name="layer_7_layer_5_micron" value="<?php echo set_value('layer_7_layer_5_micron');?>" />
        </td>     
      </tr>

      <tr>
      	<td><input type='hidden' name='sr_no[]' value='6'>6 <input type='hidden' name='layer_7_rm_6' value='HDPE'></td>  
        <td> 
        	<?php 
		    $layer_7_layer_2_hdpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'7','rm'=>'HDPE');
		    $result_layer_7_layer_2_hdpe=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_7_layer_2_hdpe_data,$order_by="",2,0);
		   	if($result_layer_7_layer_2_hdpe==FALSE){
		    	$layer_7_layer_2_hdpe = '';
		    	$layer_7_layer_2_hdpe_rate='';
		    	$layer_7_layer_2_micron='';
		    	$layer_7_layer_2_hdpe_percentage='';
		    }
		    else{
					foreach ($result_layer_7_layer_2_hdpe as $result_layer_7_layer_2_hdpe_row){
						$layer_7_layer_2_hdpe = $result_layer_7_layer_2_hdpe_row->rm_code;
						$layer_7_layer_2_hdpe_rate=$result_layer_7_layer_2_hdpe_row->rm_rate;
						$layer_7_layer_2_micron=$result_layer_7_layer_2_hdpe_row->micron;
						$layer_7_layer_2_hdpe_percentage=$result_layer_7_layer_2_hdpe_row->rm_percentage;
						$layer_7_sqsd_6=$result_layer_7_layer_2_hdpe_row->sqsd_id;
					}
				}
				?>

        	HD : <select name="layer_7_rm_6_code" id="layer7_layer2_sl_hdpe">
                   <option value=''>--Select HDPE--</option>
										<?php if($hdpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach ($hdpe as $hdpe_row) {
											$selected=($hdpe_row->article_no==$layer_7_layer_2_hdpe?'selected':'');
                      echo "<option value='".$hdpe_row->article_no."' ".set_select('layer_7_rm_6_code',$hdpe_row->article_no).$selected.">".$hdpe_row->lang_article_description."</option>";
                    }
                    }?>
                    </select>

        </td>
        <td>
        	<input type='hidden' name='layer_7_sqsd_6' value='<?php echo $layer_7_sqsd_6;?>'>
        	<input type="text" readonly="readonly" style="background-color: #ddd" id="layer7_layer2_hdpe_rate" name="layer_7_rm_6_rate" value="<?php echo set_value('layer_7_rm_6_rate',$layer_7_layer_2_hdpe_rate);?>" size="5">
        </td> 
        <td ><input type="number" style="width: 7em;" name="layer_7_rm_6_percentage" id="layer7_layer2_hd_percentage" placeholder="%" value="<?php echo set_value('layer_7_rm_6_percentage',$layer_7_layer_2_hdpe_percentage);?>" />
        	<input type="hidden"  name="layer_7_layer_6_micron" value="<?php echo set_value('layer_7_layer_6_micron');?>" />
        </td>     
      </tr>

      <tr>
		<td><input type='hidden' name='sr_no[]' value='7'>7 <input type='hidden' name='layer_7_rm_7' value='MB'></td>
		<td>
		<?php 
		    $layer_7_layer_2_mb_data = array('quotation_no'=>$row->quotation_no,'layer'=>'7','rm'=>'MB');
		    $result_layer_7_layer_2_mb=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_7_layer_2_mb_data,$order_by="",1,0);
		    //echo $this->db->last_query();
		   	if($result_layer_7_layer_2_mb==FALSE){
		    	$layer_7_layer_2_mb = '';
		    	$layer_7_layer_2_mb_rate='';
		    	$layer_7_layer_2_micron='';
		    	$layer_7_layer_2_mb_percentage='';
		    }
		    else{
					foreach ($result_layer_7_layer_2_mb as $result_layer_7_layer_2_mb_row){
						$layer_7_layer_2_mb = $result_layer_7_layer_2_mb_row->rm_code;
						$layer_7_layer_2_mb_rate=$result_layer_7_layer_2_mb_row->rm_rate;
						$layer_7_layer_2_micron=$result_layer_7_layer_2_mb_row->micron;
						$layer_7_layer_2_mb_percentage=$result_layer_7_layer_2_mb_row->rm_percentage;
						$layer_7_sqsd_7=$result_layer_7_layer_2_mb_row->sqsd_id;
					}
				}
				?>		
			
		 MB : <select name="layer_7_rm_7_code" id="layer7_layer_2_rm_7_code" >
		 								<option value=''>--Select MB--</option>
										<?php if($masterbatch==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach ($masterbatch as $masterbatch_row) {
											$selected=($masterbatch_row->article_no==$layer_7_layer_2_mb?'selected':'');
									echo "<option value='".$masterbatch_row->article_no."' ".set_select('layer_7_rm_7_code',$masterbatch_row->article_no).$selected.">".$masterbatch_row->lang_article_description."</option>";
								}
								}?></select>

		</td>
		<td>
			<input type='hidden' name='layer_7_sqsd_7' value='<?php echo $layer_7_sqsd_7;?>'>
			<input type="text" readonly="readonly" style="background-color: #ddd" id="layer7_layer_2_rm_7_rate" name="layer_7_rm_7_rate" value="<?php echo set_value('layer_7_rm_7_rate',$layer_7_layer_2_mb_rate);?>" size="5">
		</td>	
		<td ><input type="number" style="width: 7em;" name="layer_7_rm_7_percentage" id="layer7_layer_2_rm_7_percentage" placeholder="%" value="<?php echo set_value('layer_7_rm_7_percentage',$layer_7_layer_2_mb_percentage);?>" />
			<input type="hidden"  name="layer_7_layer_7_micron" value="<?php echo set_value('layer_7_layer_7_micron');?>" />
		</td>			
	  </tr>

	  <tr>
		<td><input type='hidden' name='sr_no[]' value='8'>8 <input type='hidden' name='layer_7_rm_8' value='MB'></td>
		<td>
			<?php 
		    $layer_7_layer_2_mb1_data = array('quotation_no'=>$row->quotation_no,'layer'=>'7','rm'=>'MB');
		    $result_layer_7_layer_2_mb1=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_7_layer_2_mb1_data,$order_by="",2,0);
		    //echo $this->db->last_query();
		   	if($result_layer_7_layer_2_mb1==FALSE){
		    	$layer_7_layer_2_mb1 = '';
		    	$layer_7_layer_2_mb1_rate='';
		    	$layer_7_layer_2__micron='';
		    	$layer_7_layer_2_mb1_percentage='';
		    }
		    else{
					foreach ($result_layer_7_layer_2_mb1 as $result_layer_7_layer_2_mb1_row){
						$layer_7_layer_2_mb1 = $result_layer_7_layer_2_mb1_row->rm_code;
						$layer_7_layer_2_mb1_rate=$result_layer_7_layer_2_mb1_row->rm_rate;
						$layer_7_layer_2_micron=$result_layer_7_layer_2_mb1_row->micron;
						$layer_7_layer_2_mb1_percentage=$result_layer_7_layer_2_mb1_row->rm_percentage;
						$layer_7_sqsd_8=$result_layer_7_layer_2_mb1_row->sqsd_id;
					}
				}
				?>		


		 MB : <input type="text" size="25" name="layer_7_rm_8_code" id="layer7_layer_2_rm_8_code" placeholder="If MB is not in system"value="<?php echo set_value('layer_7_rm_8_code',$layer_7_layer_2_mb1);?>" />

		</td>
		<td>
			<input type='hidden' name='layer_7_sqsd_8' value='<?php echo $layer_7_sqsd_8;?>'>
			<input type="text" size="5" name="layer_7_rm_8_rate" id="layer7_layer_2_rm_8_rate" value="<?php echo set_value('layer_7_rm_8_rate',$layer_7_layer_2_mb1_rate);?>" />
		</td>	
		<td ><input type="number" style="width: 7em;" name="layer_7_rm_8_percentage" id="layer7_layer_2_rm_8_percentage" placeholder="%" value="<?php echo set_value('layer_7_rm_8_percentage',$layer_7_layer_2_mb1_percentage);?>" />
			<input type="hidden"  name="layer_7_layer_8_micron" value="<?php echo set_value('layer_7_layer_8_micron');?>" />
		</td>			
	  </tr>

      <tr>
      	<td><input type='hidden' name='sr_no[]' value='9'>9 <input type='hidden' name='layer_7_rm_9' value='Admer'></td>
        <td>LAYER 3</td>

        <td> 
        	<?php 
		    $layer_7_layer_3_admer_data = array('quotation_no'=>$row->quotation_no,'layer'=>'7','rm'=>'ADMER');
		    $result_layer_7_layer_3_admer=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_7_layer_3_admer_data,$order_by="",1,0);
		    //echo $this->db->last_query();
		    	if($result_layer_7_layer_3_admer==FALSE){
		    	$layer_7_layer_3_admer = '';
		    	$layer_7_layer_3_admer_rate='';
		    	$layer_7_layer_3_micron='';
		    	$layer_7_layer_3_admer_percentage='';
		    }
		    else{
					foreach ($result_layer_7_layer_3_admer as $result_layer_7_layer_3_admer_row){
						$layer_7_layer_3_admer = $result_layer_7_layer_3_admer_row->rm_code;
						$layer_7_layer_3_admer_rate=$result_layer_7_layer_3_admer_row->rm_rate;
						$layer_7_layer_3_micron=$result_layer_7_layer_3_admer_row->micron;
						$layer_7_layer_3_admer_percentage=$result_layer_7_layer_3_admer_row->rm_percentage;
						$layer_7_sqsd_9=$result_layer_7_layer_3_admer_row->sqsd_id;
					
					}
				}
		    ?>	

        	ADMER : <select name="layer_7_rm_9_code" id="layer7_layer3_admer" >
                             <option value=''>--Select Admer--</option>
                              <?php if($admer==FALSE){
																echo "<option value=''>--Setup Required--</option>";}
														else{
                              foreach ($admer as $admer_row) {
                              	$selected=($admer_row->article_no==$layer_7_layer_3_admer?'selected':'');
                                 echo "<option value='".$admer_row->article_no."' ".set_select('layer_7_rm_9_code',$admer_row->article_no).$selected.">".$admer_row->lang_article_description."</option>";
                              }
                              }?>
                              </select>

        </td>
        <td>
        	<input type='hidden' name='layer_7_sqsd_9' value='<?php echo $layer_7_sqsd_9;?>'>
        	<input type="text" readonly="readonly" style="background-color: #ddd" id="layer7_layer3_admer_rate" name="layer_7_rm_9_rate" value="<?php echo set_value('layer_7_rm_9_rate',$layer_7_layer_3_admer_rate);?>" size="5">
        </td>
        <td ><input type="text" style="width: 7em;" name="layer_7_layer_9_micron" id="layer7_layer3_micron" value="<?php echo set_value('layer_7_layer_9_micron',$layer_7_layer_3_micron);?>"  />
        </td>
        <td><input type="number" style="width: 7em;" name="layer_7_rm_9_percentage" id="layer7_layer3_admer_percentage" placeholder="%" value="<?php echo set_value('layer_7_rm_9_percentage',$layer_7_layer_3_admer_percentage);?>" />
        </td>     
      </tr>

      <tr>
      	<td><input type='hidden' name='sr_no[]' value='10'>10 <input type='hidden' name='layer_7_rm_10' value='Evoh'></td>
        <td >LAYER 4</td>

        <td> 
        	<?php 
		    $layer_7_layer_4_evoh_data = array('quotation_no'=>$row->quotation_no,'layer'=>'7','rm'=>'EVOH');
		    $result_layer_7_layer_4_evoh=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_7_layer_4_evoh_data,$order_by="",1,0);
		    //echo $this->db->last_query();
		    	if($result_layer_7_layer_4_evoh==FALSE){
		    	$layer_7_layer_4_evoh = '';
		    	$layer_7_layer_4_evoh_rate='';
		    	$layer_7_layer_4_micron='';
		    	$layer_7_layer_4_evoh_percentage='';
		    }
		    else{
					foreach ($result_layer_7_layer_4_evoh as $result_layer_7_layer_4_evoh_row){
						$layer_7_layer_4_evoh = $result_layer_7_layer_4_evoh_row->rm_code;
						$layer_7_layer_4_evoh_rate=$result_layer_7_layer_4_evoh_row->rm_rate;
						$layer_7_layer_4_micron=$result_layer_7_layer_4_evoh_row->micron;
						$layer_7_layer_4_evoh_percentage=$result_layer_7_layer_4_evoh_row->rm_percentage;
						$layer_7_sqsd_10=$result_layer_7_layer_4_evoh_row->sqsd_id;
					
					}
				}
		    ?>	

        	EVOH : <select name="layer_7_rm_10_code" id="layer7_layer4_evoh" >
                              <option value=''>--Select evoh--</option>
                            <?php if($evoh==FALSE){
																echo "<option value=''>--Setup Required--</option>";}
														else{
                              foreach ($evoh as $evoh_row) {
                              	$selected=($evoh_row->article_no==$layer_7_layer_4_evoh?'selected':'');
                                 echo "<option value='".$evoh_row->article_no."' ".set_select('layer_7_rm_10_code',$evoh_row->article_no).$selected.">".$evoh_row->lang_article_description."</option>";
                              }
                              }?>
                              </select>

        </td>
        <td>
        	<input type='hidden' name='layer_7_sqsd_10' value='<?php echo $layer_7_sqsd_10;?>'>
        	<input type="text" readonly="readonly" style="background-color: #ddd" id="layer7_layer4_evoh_rate" name="layer_7_rm_10_rate" value="<?php echo set_value('layer_7_rm_10_rate',$layer_7_layer_4_evoh_rate);?>" size="5">
        </td>
        <td><input type="text" style="width: 7em;" name="layer_7_layer_10_micron" id="layer7_layer4_micron" value="<?php echo set_value('layer_7_layer_10_micron',$layer_7_layer_4_micron);?>"  />
        </td>
        <td><input type="number" style="width: 7em;" name="layer_7_rm_10_percentage" id="layer7_layer4_evoh_percentage" placeholder="%" value="<?php echo set_value('layer_7_rm_10_percentage',$layer_7_layer_4_evoh_percentage);?>" />
        </td>     
      </tr>

      <tr>
      	<td><input type='hidden' name='sr_no[]' value='11'>11 <input type='hidden' name='layer_7_rm_11' value='Admer'></td>
        <td>LAYER 5</td>

        <td>
        	<?php 
		    $layer_7_layer_5_admer_data = array('quotation_no'=>$row->quotation_no,'layer'=>'7','rm'=>'ADMER');
		    $result_layer_7_layer_5_admer=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_7_layer_5_admer_data,$order_by="",2,0);
		    //echo $this->db->last_query();
		    	if($result_layer_7_layer_5_admer==FALSE){
		    	$layer_7_layer_5_admer = '';
		    	$layer_7_layer_5_admer_rate='';
		    	$layer_7_layer_5_micron='';
		    	$layer_7_layer_5_admer_percentage='';
		    }
		    else{
					foreach ($result_layer_7_layer_5_admer as $result_layer_7_layer_5_admer_row){
						$layer_7_layer_5_admer = $result_layer_7_layer_5_admer_row->rm_code;
						$layer_7_layer_5_admer_rate=$result_layer_7_layer_5_admer_row->rm_rate;
						$layer_7_layer_5_micron=$result_layer_7_layer_5_admer_row->micron;
						$layer_7_layer_5_admer_percentage=$result_layer_7_layer_5_admer_row->rm_percentage;
						$layer_7_sqsd_11=$result_layer_7_layer_5_admer_row->sqsd_id;
					
					}
				}
		    ?>	
        		
         ADMER : <select name="layer_7_rm_11_code" id="layer7_layer5_admer" >
                               <option value=''>--Select Admer--</option>
                              <?php if($admer==FALSE){
																echo "<option value=''>--Setup Required--</option>";}
														else{
                              foreach ($admer as $admer_row) {
                              	$selected=($admer_row->article_no==$layer_7_layer_5_admer?'selected':'');
                                 echo "<option value='".$admer_row->article_no."' ".set_select('layer_7_rm_11_code',$admer_row->article_no).$selected.">".$admer_row->lang_article_description."</option>";
                              }
                              }?>
                              </select>

        </td>
        <td>
        	<input type='hidden' name='layer_7_sqsd_11' value='<?php echo $layer_7_sqsd_11;?>'>
        	<input type="text" readonly="readonly" style="background-color: #ddd" id="layer7_layer5_admer_rate" name="layer_7_rm_11_rate" value="<?php echo set_value('layer_7_rm_11_rate',$layer_7_layer_5_admer_rate);?>" size="5">
        </td>
        <td><input type="text" style="width: 7em;" name="layer_7_layer_11_micron" id="layer7_layer5_micron" value="<?php echo set_value('layer_7_layer_11_micron',$layer_7_layer_5_micron);?>"  />
        </td>
        <td><input type="number" style="width: 7em;" name="layer_7_rm_11_percentage" id="layer7_layer5_admer_percentage" placeholder="%" value="<?php echo set_value('layer_7_rm_11_percentage',$layer_7_layer_5_admer_percentage);?>" />
        </td>     
      </tr>


      <tr>
      	<td><input type='hidden' name='sr_no[]' value='12'>12 <input type='hidden' name='layer_7_rm_12' value='LDPE'></td>
        <td rowspan="5">LAYER 6</td>

        <td>
        	<?php 
			    $layer_7_layer_6_ldpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'7','rm'=>'LDPE');
			    $result_layer_7_layer_6_ldpe=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_7_layer_6_ldpe_data,$order_by="",3,0);
			   	if($result_layer_7_layer_6_ldpe==FALSE){
			    	$layer_7_layer_6_ldpe = '';
			    	$layer_7_layer_6_ldpe_rate='';
			    	$layer_7_layer_6_micron='';
			    	$layer_7_layer_6_ldpe_percentage='';
			    }
			    else{
						foreach ($result_layer_7_layer_6_ldpe as $result_layer_7_layer_6_ldpe_row){
							$layer_7_layer_6_ldpe = $result_layer_7_layer_6_ldpe_row->rm_code;
							$layer_7_layer_6_ldpe_rate=$result_layer_7_layer_6_ldpe_row->rm_rate;
							$layer_7_layer_6_micron=$result_layer_7_layer_6_ldpe_row->micron;
							$layer_7_layer_6_ldpe_percentage=$result_layer_7_layer_6_ldpe_row->rm_percentage;
							$layer_7_sqsd_12=$result_layer_7_layer_6_ldpe_row->sqsd_id;
						}
					}
					?>

        	 LD : <select name="layer_7_rm_12_code" id="layer7_layer6_sl_ldpe">
                    <option value=''>--Select RM --</option>
								<?php 
								if($ldpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
										foreach ($ldpe as $ldpe_row) {
											$selected=($ldpe_row->article_no==$layer_7_layer_6_ldpe?'selected':'');
                      echo "<option value='".$ldpe_row->article_no."' ".set_select('layer_7_rm_12_code',$ldpe_row->article_no).$selected.">".$ldpe_row->lang_article_description."</option>";
                    }
                    }?>
                    </select>
        
        </td>
        <td>
        	<input type='hidden' name='layer_7_sqsd_12' value='<?php echo $layer_7_sqsd_12;?>'>
        	<input type="text" readonly="readonly" style="background-color: #ddd" id="layer7_layer6_ldpe_rate" name="layer_7_rm_12_rate" value="<?php echo set_value('layer_7_rm_12_rate',$layer_7_layer_6_ldpe_rate);?>" size="5">
        </td>
        <td rowspan="5"><input type="text" style="width: 7em;" name="layer_7_layer_12_micron" id="layer7_layer6_micron" class="number3" value="<?php echo set_value('layer_7_layer_12_micron',$layer_7_layer_6_micron);?>"  />
        </td>
        <td><input type="number" style="width: 7em;" name="layer_7_rm_12_percentage" id="layer7_layer6_ld_percentage" placeholder="%" value="<?php echo set_value('layer_7_rm_12_percentage',$layer_7_layer_6_ldpe_percentage);?>" />
        </td>     
      </tr>
      <tr>  
      	<td><input type='hidden' name='sr_no[]' value='13'>13 <input type='hidden' name='layer_7_rm_13' value='LLDPE'></td>      
        <td>
        	<?php 
						$layer_7_layer_6_lldpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'7','rm'=>'LLDPE');
						$result_layer_7_layer_6_lldpe=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_7_layer_6_lldpe_data,$order_by="",3,0);
						//echo $this->db->last_query();
							if($result_layer_7_layer_6_lldpe==FALSE){
							$layer_7_layer_6_lldpe = '';
							$layer_7_layer_6_lldpe_rate='';
							$layer_7_layer_6_micron='';
							$layer_7_layer_6_lldpe_percentage='';
						}
						else{
								foreach ($result_layer_7_layer_6_lldpe as $result_layer_7_layer_6_lldpe_row){
									$layer_7_layer_6_lldpe = $result_layer_7_layer_6_lldpe_row->rm_code;
									$layer_7_layer_6_lldpe_rate=$result_layer_7_layer_6_lldpe_row->rm_rate;
									$layer_7_layer_6_micron=$result_layer_7_layer_6_lldpe_row->micron;
									$layer_7_layer_6_lldpe_percentage=$result_layer_7_layer_6_lldpe_row->rm_percentage;
									$layer_7_sqsd_13=$result_layer_7_layer_6_lldpe_row->sqsd_id;
								}
							}
							?>	


        	 LLD : <select name="layer_7_rm_13_code" id="layer7_layer6_sl_lldpe">
                   <option value=''>--Select RM --</option>
										<?php if($lldpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach ($lldpe as $lldpe_row) {
											$selected=($lldpe_row->article_no==$layer_7_layer_6_lldpe?'selected':'');
                      echo "<option value='".$lldpe_row->article_no."' ".set_select('layer_7_rm_13_code',$lldpe_row->article_no).$selected.">".$lldpe_row->lang_article_description."</option>";
                    }
                    }?>
                    </select>

        </td>
        <td>
        	<input type='hidden' name='layer_7_sqsd_13' value='<?php echo $layer_7_sqsd_13;?>'>
        	<input type="text" readonly="readonly" style="background-color: #ddd" id="layer7_layer6_lldpe_rate" name="layer_7_rm_13_rate" value="<?php echo set_value('layer_7_rm_13_rate',$layer_7_layer_6_lldpe_rate);?>" size="5">
        </td>    
        <td ><input type="number" style="width: 7em;" name="layer_7_rm_13_percentage" id="layer7_layer6_lld_percentage" placeholder="%" value="<?php echo set_value('layer_7_rm_13_percentage',$layer_7_layer_6_lldpe_percentage);?>" />
        	<input type="hidden"  name="layer_7_layer_13_micron" value="<?php echo set_value('layer_7_layer_13_micron');?>" />
        </td>     
      </tr>

      <tr>
      	<td><input type='hidden' name='sr_no[]' value='14'>14 <input type='hidden' name='layer_7_rm_14' value='HDPE'></td>  
        <td>
        	<?php 
		    $layer_7_layer_6_hdpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'7','rm'=>'HDPE');
		    $result_layer_7_layer_6_hdpe=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_7_layer_6_hdpe_data,$order_by="",3,0);
		   	if($result_layer_7_layer_6_hdpe==FALSE){
		    	$layer_7_layer_6_hdpe = '';
		    	$layer_7_layer_6_hdpe_rate='';
		    	$layer_7_layer_6_micron='';
		    	$layer_7_layer_6_hdpe_percentage='';
		    }
		    else{
					foreach ($result_layer_7_layer_6_hdpe as $result_layer_7_layer_6_hdpe_row){
						$layer_7_layer_6_hdpe = $result_layer_7_layer_6_hdpe_row->rm_code;
						$layer_7_layer_6_hdpe_rate=$result_layer_7_layer_6_hdpe_row->rm_rate;
						$layer_7_layer_6_micron=$result_layer_7_layer_6_hdpe_row->micron;
						$layer_7_layer_6_hdpe_percentage=$result_layer_7_layer_6_hdpe_row->rm_percentage;
						$layer_7_sqsd_14=$result_layer_7_layer_6_hdpe_row->sqsd_id;
					}
				}
				?>	

         HD : <select name="layer_7_rm_14_code" id="layer7_layer6_sl_hdpe">
                    <option value=''>--Select HDPE--</option>
										<?php if($hdpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach ($hdpe as $hdpe_row) {
											$selected=($hdpe_row->article_no==$layer_7_layer_6_hdpe?'selected':'');
                      echo "<option value='".$hdpe_row->article_no."' ".set_select('layer_7_rm_14_code',$hdpe_row->article_no).$selected.">".$hdpe_row->lang_article_description."</option>";
                    }
                    }?>
                    </select>

        </td>
        <td>
        	<input type='hidden' name='layer_7_sqsd_14' value='<?php echo $layer_7_sqsd_14;?>'>
        	<input type="text" readonly="readonly" style="background-color: #ddd" id="layer7_layer6_hdpe_rate" name="layer_7_rm_14_rate" value="<?php echo set_value('layer_7_rm_14_rate',$layer_7_layer_6_hdpe_rate);?>" size="5">
        </td> 
        <td ><input type="number" style="width: 7em;" name="layer_7_rm_14_percentage" id="layer7_layer6_hd_percentage" placeholder="%" value="<?php echo set_value('layer_7_rm_14_percentage',$layer_7_layer_6_hdpe_percentage);?>" />
        	<input type="hidden"  name="layer_7_layer_14_micron" value="<?php echo set_value('layer_7_layer_14_micron');?>" />
        </td>     
      </tr>
      <tr>
		<td><input type='hidden' name='sr_no[]' value='15'>15 <input type='hidden' name='layer_7_rm_15' value='MB'></td>
		<td>
			<?php 
		    $layer_7_layer_6_mb_data = array('quotation_no'=>$row->quotation_no,'layer'=>'7','rm'=>'MB');
		    $result_layer_7_layer_6_mb=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_7_layer_6_mb_data,$order_by="",3,0);
		    //echo $this->db->last_query();
		   	if($result_layer_7_layer_6_mb==FALSE){
		    	$layer_7_layer_6_mb = '';
		    	$layer_7_layer_6_mb_rate='';
		    	$layer_7_layer_6_micron='';
		    	$layer_7_layer_6_mb_percentage='';
		    }
		    else{
					foreach ($result_layer_7_layer_6_mb as $result_layer_7_layer_6_mb_row){
						$layer_7_layer_6_mb = $result_layer_7_layer_6_mb_row->rm_code;
						$layer_7_layer_6_mb_rate=$result_layer_7_layer_6_mb_row->rm_rate;
						$layer_7_layer_6_micron=$result_layer_7_layer_6_mb_row->micron;
						$layer_7_layer_6_mb_percentage=$result_layer_7_layer_6_mb_row->rm_percentage;
						$layer_7_sqsd_15=$result_layer_7_layer_6_mb_row->sqsd_id;
					}
				}
				?>	

		 MB : <select name="layer_7_rm_15_code" id="layer7_layer_6_rm_15_code" >
		 								<option value=''>--Select MB--</option>
										<?php if($masterbatch==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach ($masterbatch as $masterbatch_row) {
											$selected=($masterbatch_row->article_no==$layer_7_layer_6_mb?'selected':'');
									echo "<option value='".$masterbatch_row->article_no."' ".set_select('layer_7_rm_15_code',$masterbatch_row->article_no).$selected.">".$masterbatch_row->lang_article_description."</option>";
								}
								}?></select>

		</td>
		<td>
			<input type='hidden' name='layer_7_sqsd_15' value='<?php echo $layer_7_sqsd_15;?>'>
			<input type="text" readonly="readonly" style="background-color: #ddd" id="layer7_layer_6_rm_15_rate" name="layer_7_rm_15_rate" value="<?php echo set_value('layer_7_rm_15_rate',$layer_7_layer_6_mb_rate);?>" size="5">
		</td>	
		<td ><input type="number" style="width: 7em;" name="layer_7_rm_15_percentage" id="layer7_layer_6_rm_15_percentage" placeholder="%" value="<?php echo set_value('layer_7_rm_15_percentage',$layer_7_layer_6_mb_percentage);?>" />
			<input type="hidden"  name="layer_7_layer_15_micron" value="<?php echo set_value('layer_7_layer_15_micron');?>" />
		</td>			
	   </tr>

		<tr>
			<td><input type='hidden' name='sr_no[]' value='16'>16 <input type='hidden' name='layer_7_rm_16' value='MB'></td>
			<td>
				<?php 
		    $layer_7_layer_6_mb1_data = array('quotation_no'=>$row->quotation_no,'layer'=>'7','rm'=>'MB');
		    $result_layer_7_layer_6_mb1=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_7_layer_6_mb1_data,$order_by="",4,0);
		    //echo $this->db->last_query();
		   	if($result_layer_7_layer_6_mb1==FALSE){
		    	$layer_7_layer_6_mb1 = '';
		    	$layer_7_layer_6_mb1_rate='';
		    	$layer_7_layer_6_micron='';
		    	$layer_7_layer_6_mb1_percentage='';
		    }
		    else{
					foreach ($result_layer_7_layer_6_mb1 as $result_layer_7_layer_6_mb1_row){
						$layer_7_layer_6_mb1 = $result_layer_7_layer_6_mb1_row->rm_code;
						$layer_7_layer_6_mb1_rate=$result_layer_7_layer_6_mb1_row->rm_rate;
						$layer_7_layer_6_micron=$result_layer_7_layer_6_mb1_row->micron;
						$layer_7_layer_6_mb1_percentage=$result_layer_7_layer_6_mb1_row->rm_percentage;
						$layer_7_sqsd_16=$result_layer_7_layer_6_mb1_row->sqsd_id;
					}
				}
				?>			

			 MB : <input type="text" size="25" name="layer_7_rm_16_code" id="layer7_layer_6_rm_16_code" placeholder="If MB is not in system"value="<?php echo set_value('layer_7_rm_16_code',$layer_7_layer_6_mb1);?>" />

			</td>
			<td>
				<input type='hidden' name='layer_7_sqsd_16' value='<?php echo $layer_7_sqsd_16;?>'>
				<input type="text" size="5" name="layer_7_rm_16_rate" id="layer7_layer_6_rm_16_rate" value="<?php echo set_value('layer_7_rm_16_rate',$layer_7_layer_6_mb1_rate);?>" />
			</td>	
			<td ><input type="number" style="width: 7em;" name="layer_7_rm_16_percentage" id="layer7_layer_6_rm_16_percentage" placeholder="%" value="<?php echo set_value('layer_7_rm_16_percentage',$layer_7_layer_6_mb1_percentage);?>" />
				<input type="hidden"  name="layer_7_layer_16_micron" value="<?php echo set_value('layer_7_layer_16_micron');?>" />
			</td>			
		</tr>

      <tr>
      	<td><input type='hidden' name='sr_no[]' value='17'>17 <input type='hidden' name='layer_7_rm_17' value='LDPE'></td>
        <td rowspan="3">LAYER 7</td>

        <td>
        	<?php 
		    $layer_7_layer_7_ldpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'7','rm'=>'LDPE');
		    $result_layer_7_layer_7_ldpe=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_7_layer_7_ldpe_data,$order_by="",4,0);
		   	if($result_layer_7_layer_7_ldpe==FALSE){
		    	$layer_7_layer_7_ldpe = '';
		    	$layer_7_layer_7_ldpe_rate='';
		    	$layer_7_layer_7_micron='';
		    	$layer_7_layer_7_ldpe_percentage='';
		    }
		    else{
					foreach ($result_layer_7_layer_7_ldpe as $result_layer_7_layer_7_ldpe_row){
						$layer_7_layer_7_ldpe = $result_layer_7_layer_7_ldpe_row->rm_code;
						$layer_7_layer_7_ldpe_rate=$result_layer_7_layer_7_ldpe_row->rm_rate;
						$layer_7_layer_7_micron=$result_layer_7_layer_7_ldpe_row->micron;
						$layer_7_layer_7_ldpe_percentage=$result_layer_7_layer_7_ldpe_row->rm_percentage;
						$layer_7_sqsd_17=$result_layer_7_layer_7_ldpe_row->sqsd_id;
					}
				}
				?>

         LD : <select name="layer_7_rm_17_code" id="layer7_layer7_sl_ldpe">
                    <option value=''>--Select RM --</option>
								<?php 
								if($ldpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
										foreach ($ldpe as $ldpe_row) {
											$selected=($ldpe_row->article_no==$layer_7_layer_7_ldpe?'selected':'');
                      echo "<option value='".$ldpe_row->article_no."' ".set_select('layer_7_rm_17_code',$ldpe_row->article_no).$selected.">".$ldpe_row->lang_article_description."</option>";
                    }
                    }?>
                    </select>
        
        </td>
        <td>
        	<input type='hidden' name='layer_7_sqsd_17' value='<?php echo $layer_7_sqsd_17;?>'>
        	<input type="text" readonly="readonly" style="background-color: #ddd" id="layer7_layer7_ldpe_rate" name="layer_7_rm_17_rate" value="<?php echo set_value('layer_7_rm_17_rate',$layer_7_layer_7_ldpe_rate);?>" size="5">
        </td>
        <td rowspan="3"><input type="text" style="width: 7em;" name="layer_7_layer_17_micron" id="layer7_layer7_micron" class="number3" value="<?php echo set_value('layer_7_layer_17_micron',$layer_7_layer_7_micron);?>"  />
        </td>
        <td><input type="number" style="width: 7em;" name="layer_7_rm_17_percentage" id="layer7_layer7_ld_percentage" placeholder="%" value="<?php echo set_value('layer_7_rm_17_percentage',$layer_7_layer_7_ldpe_percentage);?>" />
        </td>     
      </tr>
      <tr>    
      	<td><input type='hidden' name='sr_no[]' value='18'>18 <input type='hidden' name='layer_7_rm_18' value='LLDPE'></td>    
        <td>
        	<?php 
						$layer_7_layer_7_lldpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'7','rm'=>'LLDPE');
						$result_layer_7_layer_7_lldpe=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_7_layer_7_lldpe_data,$order_by="",4,0);
						//echo $this->db->last_query();
							if($result_layer_7_layer_7_lldpe==FALSE){
							$layer_7_layer_7_lldpe = '';
							$layer_7_layer_7_lldpe_rate='';
							$layer_7_layer_7_micron='';
							$layer_7_layer_7_lldpe_percentage='';
						}
						else{
								foreach ($result_layer_7_layer_7_lldpe as $result_layer_7_layer_7_lldpe_row){
									$layer_7_layer_7_lldpe = $result_layer_7_layer_7_lldpe_row->rm_code;
									$layer_7_layer_7_lldpe_rate=$result_layer_7_layer_7_lldpe_row->rm_rate;
									$layer_7_layer_7_micron=$result_layer_7_layer_7_lldpe_row->micron;
									$layer_7_layer_7_lldpe_percentage=$result_layer_7_layer_7_lldpe_row->rm_percentage;
									$layer_7_sqsd_18=$result_layer_7_layer_7_lldpe_row->sqsd_id;
								}
							}
							?>	

         LLD : <select name="layer_7_rm_18_code" id="layer7_layer7_sl_lldpe">
                    <option value=''>--Select RM --</option>
										<?php if($lldpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach ($lldpe as $lldpe_row) {
											$selected=($lldpe_row->article_no==$layer_7_layer_7_lldpe?'selected':'');
                      echo "<option value='".$lldpe_row->article_no."' ".set_select('layer_7_rm_18_code',$lldpe_row->article_no).$selected.">".$lldpe_row->lang_article_description."</option>";
                    }
                    }?>
                    </select>

        </td>
        <td>
        	<input type='hidden' name='layer_7_sqsd_18' value='<?php echo $layer_7_sqsd_18;?>'>
        	<input type="text" readonly="readonly" style="background-color: #ddd" id="layer7_layer7_lldpe_rate" name="layer_7_rm_18_rate" value="<?php echo set_value('layer_7_rm_18_rate',$layer_7_layer_7_lldpe_rate);?>" size="5">
        </td>    
        <td ><input type="number" style="width: 7em;" name="layer_7_rm_18_percentage" id="layer7_layer7_lld_percentage" placeholder="%" value="<?php echo set_value('layer_7_rm_18_percentage',$layer_7_layer_7_lldpe_percentage);?>" />
        	<input type="hidden"  name="layer_7_layer_18_micron" value="<?php echo set_value('layer_7_layer_18_micron');?>" />

        </td>     
      </tr>

      <tr>
      	<td><input type='hidden' name='sr_no[]' value='19'>19 <input type='hidden' name='layer_7_rm_19' value='HDPE'></td>  
        <td> 
        	<?php 
				    $layer_7_layer_7_hdpe_data = array('quotation_no'=>$row->quotation_no,'layer'=>'7','rm'=>'HDPE');
				    $result_layer_7_layer_7_hdpe=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_7_layer_7_hdpe_data,$order_by="",4,0);
				   	if($result_layer_7_layer_7_hdpe==FALSE){
				    	$layer_7_layer_7_hdpe = '';
				    	$layer_7_layer_7_hdpe_rate='';
				    	$layer_7_layer_7_micron='';
				    	$layer_7_layer_7_hdpe_percentage='';
				    }
				    else{
							foreach ($result_layer_7_layer_7_hdpe as $result_layer_7_layer_7_hdpe_row){
								$layer_7_layer_7_hdpe = $result_layer_7_layer_7_hdpe_row->rm_code;
								$layer_7_layer_7_hdpe_rate=$result_layer_7_layer_7_hdpe_row->rm_rate;
								$layer_7_layer_7_micron=$result_layer_7_layer_7_hdpe_row->micron;
								$layer_7_layer_7_hdpe_percentage=$result_layer_7_layer_7_hdpe_row->rm_percentage;
								$layer_7_sqsd_19=$result_layer_7_layer_7_hdpe_row->sqsd_id;
							}
						}
						?>
        	HD : <select name="layer_7_rm_19_code" id="layer7_layer7_sl_hdpe">
                    <option value=''>--Select HDPE--</option>
										<?php if($hdpe==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach ($hdpe as $hdpe_row) {
											$selected=($hdpe_row->article_no==$layer_7_layer_7_hdpe?'selected':'');
                      echo "<option value='".$hdpe_row->article_no."' ".set_select('layer_7_rm_19_code',$hdpe_row->article_no).$selected.">".$hdpe_row->lang_article_description."</option>";
                    }
                    }?>
                    </select>

        </td>
        <td>
        	<input type='hidden' name='layer_7_sqsd_19' value='<?php echo $layer_7_sqsd_19;?>'>
        	<input type="text" readonly="readonly" style="background-color: #ddd" id="layer7_layer7_hdpe_rate" name="layer_7_rm_19_rate" value="<?php echo set_value('layer_7_rm_19_rate',$layer_7_layer_7_hdpe_rate);?>" size="5">
        </td> 
        <td ><input type="number" style="width: 7em;" name="layer_7_rm_19_percentage" id="layer7_layer7_hd_percentage" placeholder="%" value="<?php echo set_value('layer_7_rm_19_percentage',$layer_7_layer_7_hdpe_percentage);?>" />
        	<input type="hidden"  name="layer_7_layer_19_micron" value="<?php echo set_value('layer_7_layer_19_micron');?>" />
        </td>     
      </tr>

      <tr>
				<td colspan="5">
				<?php 
		    $layer_7_rejection_data = array('quotation_no'=>$row->quotation_no,'layer'=>'7');
		    $result_layer_7_rejection=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_7_rejection_data,$order_by="",1,0);
		    //echo $this->db->last_query();
		    	if($result_layer_7_rejection==FALSE){
		    	$layer_7_rejection = '';
		    }
		    else{
					foreach ($result_layer_7_rejection as $result_layer_7_rejection_row){
						$layer_7_rejection = $result_layer_7_rejection_row->rejection;
					
					}
				}
		    ?>

				Rejection %</td>				
				<td> <input type="number" style="width: 7em;" name="layer7_rejection" id="layer7_rejection" value="<?php echo set_value('layer7_rejection',$layer_7_rejection);?>" />	</td>			
		  </tr>

      <tr>
        <td colspan="5">Quantity</td>

        
        <td> <input type="number" readonly="readonly" style="width: 7em; background-color: #ddd" name="layer7_quantity" id="layer7_quantity" value="<?php echo set_value('layer7_quantity','1');?>" /> </td>     
      </tr>

      <tr>
        <td colspan="5">
        	<?php 
		    $layer_7_sleeve_cost_data = array('quotation_no'=>$row->quotation_no,'layer'=>'7');
		    $result_layer_7_sleeve_cost=$this->common_model->select_one_active_record_with_limit('sales_quote_sleeve_details',$this->session->userdata['logged_in']['company_id'],$layer_7_sleeve_cost_data,$order_by="",1,0);
		    //echo $this->db->last_query();
		    	if($result_layer_7_sleeve_cost==FALSE){
		    	$layer_7_sleeve_cost = '';
		    }
		    else{
					foreach ($result_layer_7_sleeve_cost as $result_layer_7_sleeve_cost_row){
						$layer_7_sleeve_cost = $result_layer_7_sleeve_cost_row->sleeve_per_cost;
					
					}
				}
		    ?>
        	<span class="ui green label" id="layer7_sleevecost" >ADD</span></td>

        <td><input  readonly="readonly" type="number" style="width: 7em;" name="layer7_sleeve_cost" id="layer7_sleeve_cost" value="<?php echo set_value('layer7_sleeve_cost',$layer_7_sleeve_cost);?>"  />	
				</td>

      </tr>

      </tbody>
    </table>
  </div>
</div>


<!-----------------------Cap Foil DIv------------------------>

<div id="cap_foil_div" class="modal" style="display:none;">
  <div class="modal-content" style="width:900px;">
  		
    <span class="close">&times;</span>
    	
    	<table class="ui celled structured table">
      		<thead>
		      <tr>
		        <th>RM</th><th>RATE/PC</th>
		      </tr>
    		</thead>
   			<tbody>
		      <tr>
		        <td>Cap Foil</td>
				<td><input type="text" size="7" name="cap_foil_rate" id="cap_foil_rate" value="<?php echo set_value('cap_foil_rate',$row->cap_foil_rate);?>" /></td>
		      </tr>
		     
		      <tr>
		        <td><span class="ui green label" id="cap_foil_cost" >ADD</span></td>
		        <td><input  readonly="readonly" type="number" style="width: 7em;" name="cap_foil_cost_per_tube" id="cap_foil_cost_per_tube" value="<?php echo set_value('cap_foil_cost_per_tube',$row->cap_foil_cost_view);?>"  /></td>
		      </tr>
    		</tbody>
   		</table>	
  </div>
</div>	

<div id="cap_metalization_charges_div" class="modal" style="display:none;">
  <div class="modal-content" style="width:900px;">
  		
    <span class="close">&times;</span>
    	
    	<table class="ui celled structured table">
      		<thead>
		      <tr>
		        <th>RM</th><th>RATE/PC</th>
		      </tr>
    		</thead>
   			<tbody>
		      <tr>
		        <td>Cap Metalization </td>
				<td><input type="text" size="7" name="cap_metalization_rate" id="cap_metalization_rate" value="<?php echo set_value('cap_metalization_rate',$row->cap_metalization_rate);?>"/></td>
		      </tr>
		     
		      <tr>
		        <td><span class="ui green label" id="cap_metalization_cost" >ADD</span></td>
		        <td><input  readonly="readonly" style="width: 7em;" type="number" size="3" name="cap_metalization_cost_per_tube" id="cap_metalization_cost_per_tube" value="<?php echo set_value('cap_metalization_cost_per_tube',$row->cap_metalization_cost_view);?>"  /></td>
		      </tr>
    		</tbody>
   		</table>	
  </div>
</div>

<div id="cap_shrink_sleeve_div" class="modal" style="display:none;">
  <div class="modal-content" style="width:900px;">
  		
    <span class="close">&times;</span>
    	
    	<table class="ui celled structured table">
      		<thead>
		      <tr>
		        <th>RM</th><th>RATE/PC</th>
		      </tr>
    		</thead>
   			<tbody>
		      <tr>
		        <td><select name="cap_shrink_sleeve_code" id="cap_shrink_sleeve_code">
						<option value=''>--Select Shrink Sleeve--</option>
						<?php
							foreach ($cap_shrink_sleeve as $cap_shrink_sleeve_row) {
								$selected=($cap_shrink_sleeve_row->article_no==$row->cap_shrink_sleeve_code?'selected':'');
								echo "<option value='".$cap_shrink_sleeve_row->article_no."' ".set_select('cap_shrink_sleeve_code',$cap_shrink_sleeve_row->article_no).$selected.">".$cap_shrink_sleeve_row->lang_article_description."</option>";
							}
						?>
					</select>
				</td>
				<td><input type="text" readonly="readonly" style="background-color: #ddd" name="cap_shrink_sleeve_rate" id="cap_shrink_sleeve_rate" value="<?php echo set_value('cap_shrink_sleeve_rate',$row->cap_shrink_sleeve_rate);?>"></td>
		      </tr>
		     
		      <tr>
		        <td><span class="ui green label" id="cap_shrink_sleeve_cost" >ADD</span></td>
		        <td><input  readonly="readonly" type="number" size="3" name="cap_shrink_sleeve_cost_per_tube" id="cap_shrink_sleeve_cost_per_tube" value="<?php echo set_value('cap_shrink_sleeve_cost_per_tube',$row->cap_shrink_sleeve_cost_per_tube);?>" /></td>
		      </tr>
    		</tbody>
   		</table>	
  </div>
</div>	

	<!-------------------- shoulder foil Div ----------------------------->

<div id="shoulder_foil_div" class="modal" style="display:none;">
  <div class="modal-content" style="width:1000px;">
  		
    <span class="close">&times;</span>
    	
    	<table class="ui celled structured table">
      		<thead>
		      <tr>
		        <th>RM</th><th>RATE/SQM</th><th>SQM/TUBE</th>
		      </tr>
    		</thead>
   			<tbody>
		      <tr>
		        <td><select name="shoulder_foil_tag" id="shoulder_foil_tag">
						<option value=''>--Select Foil--</option>
						<option value="RM-HSF-000-0023" <?php echo set_select('shoulder_foil_tag','RM-HSF-000-0023');?> <?php echo($row->shoulder_foil_tag=='RM-HSF-000-0023'?"selected":"");?> >TOP SEAL FOIL 32MM 16981</option></select>
				</td>
				<td><input type="text" readonly="readonly" style="background-color: #ddd" name="shoulder_foil_rate" id="shoulder_foil_rate" value="<?php echo set_value('shoulder_foil_rate',$row->shoulder_foil_rate);?>"></td>				
				<td><input type="text" readonly="readonly" style="background-color: #ddd" name="shoulder_foil_sqm_per_tube" id="shoulder_foil_sqm_per_tube" value="<?php echo set_value('shoulder_foil_sqm_per_tube',$row->shoulder_foil_sqm_per_tube);?>"></td>
		      </tr>
		     
		      <tr>
		        <td colspan="2"><span class="ui green label" id="shoulder_foil_cost" >ADD</span></td>
		        <td><input  readonly="readonly" type="number" size="3" name="shoulder_foil_cost_per_tube" id="shoulder_foil_cost_per_tube" value="<?php echo set_value('shoulder_foil_cost_per_tube',$row->shoulder_foil_cost_per_tube);?>" /></td>
		      </tr>
    		</tbody>
   		</table>	
  </div>
</div>	

	<!-------------------- tube foil Div ----------------------------->
<div id="tube_foil_div" class="modal" style="display:none;">
  <div class="modal-content" style="width:1100px;">
      
    <span class="close">&times;</span>
      
      <table class="ui celled structured table">
          <thead>
          <tr>
            <th>RM</th><th>RATE</th><th>COVERAGE %</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><select name="hot_foil_1" id="hot_foil_1">
              <option value=''>--Select Hot Foil--</option>
          <?php if($hot_foil==FALSE){

            echo "<option value=''>--Setup Required--</option>";
          }
          else{
            foreach($hot_foil as $hot_foil_row){
            	$selected=($hot_foil_row->article_no==$row->hot_foil_1?'selected':'');
              echo "<option value='".$hot_foil_row->article_no."'   ".set_select('hot_foil_1',$hot_foil_row->article_no).$selected.">".$hot_foil_row->lang_article_description."</option>";
            }
          }?><?php if($cold_foil==FALSE){
              echo "<option value=''>--Setup Required--</option>";
            }else{
              foreach($cold_foil as $cold_foil_row){
              	$selected=($cold_foil_row->article_no==$row->hot_foil_1?'selected':'');
                echo "<option value='".$cold_foil_row->article_no."'   ".set_select('hot_foil_1',$cold_foil_row->article_no).$selected.">".$cold_foil_row->lang_article_description."</option>";
              }
            }
          ?></select>
        </td>
        <td><input type="text" readonly="readonly" style="background-color: #ddd;width: 7em;" name="hot_foil_1_rate" id="hot_foil_1_rate" value="<?php echo set_value('hot_foil_1_rate',$row->hot_foil_1_rate);?>"></td> 
        <td><input type="number" style="width: 7em;" name="hot_foil_1_percentage" id="hot_foil_1_percentage" placeholder="%" class="number3" value="<?php echo set_value('hot_foil_1_percentage',$row->hot_foil_1_percentage);?>" /></td>    
          </tr>

        <tr>
        <td><select name="hot_foil_2" id="hot_foil_2"><option value=''>--Select Hot Foil--</option>
        <?php if($hot_foil==FALSE){
          echo "<option value=''>--Setup Required--</option>";}
          else{
            foreach($hot_foil as $hot_foil_row){
            	$selected=($hot_foil_row->article_no==$row->hot_foil_2?'selected':'');
            echo "<option value='".$hot_foil_row->article_no."'  ".set_select('hot_foil_2',$hot_foil_row->article_no).$selected.">".$hot_foil_row->lang_article_description."</option>";
            }
            }?>
            <?php if($cold_foil==FALSE){
              echo "<option value=''>--Setup Required--</option>";}
            else{
              foreach($cold_foil as $cold_foil_row){
              	$selected=($cold_foil_row->article_no==$row->hot_foil_2?'selected':'');
                echo "<option value='".$cold_foil_row->article_no."'  ".set_select('hot_foil_2',$cold_foil_row->article_no).$selected.">".$cold_foil_row->lang_article_description."</option>";
              }
            }?>
            </select></td>
        <td><input type="text" readonly="readonly" style="background-color: #ddd;width: 7em;" name="hot_foil_2_rate" id="hot_foil_2_rate" value="<?php echo set_value('hot_foil_2_rate',$row->hot_foil_2_rate);?>"></td>
        <td><input type="number" style="width: 7em;" name="hot_foil_2_percentage" id="hot_foil_2_percentage" placeholder="%" class="number3"  value="<?php echo set_value('hot_foil_2_percentage',$row->hot_foil_2_percentage);?>" /></td>
        </tr>

        <tr>
			<td colspan="2">Rejection %</td>				
			<td> <input type="number" style="width: 7em;" name="tube_foil_rejection" id="tube_foil_rejection" value="<?php echo set_value('tube_foil_rejection',$row->tube_foil_rejection);?>" />	</td>			
		</tr>	

         
          <tr>
            <td colspan="2"><span class="ui green label" id="tube_foil_cost" >ADD</span></td>
            <td><input  readonly="readonly" type="number" style="width: 7em;" name="tube_foil_cost_per_tube" id="tube_foil_cost_per_tube" value="<?php echo set_value('tube_foil_cost_per_tube',$row->tube_foil_cost_per_tube);?>"  /></td>
          </tr>
        </tbody>
      </table>  
  </div>
</div>

	<!-------------------- Cap Div ----------------------------->

<div id="cap_div" class="modal" style="display:none;">
  <div class="modal-content">
  		
    <span class="close">&times;</span>
    	
    	<table class="ui celled structured table">
      		<thead>
		      <tr>
		        <th>MOULD TYPE</th><th>CAP WEIGHT </th><th> RUNNER WASTE %</th><th>PP Price</th><th>MB Price</th><th>MB LOADING </th><th>MOULDING COST </th><th>REJECTION %</th>
		      </tr>
    		</thead>
   			<tbody>
		      <tr>		        
		        <td><input type="text" readonly="readonly" style="background-color: #ddd" size="10" name="mould_type" id="mould_type" value="<?php echo set_value('mould_type',$row->mould_type);?>"></td>     
		        <td><input type="text" readonly="readonly" style="background-color: #ddd" size="10" name="cap_weight_rate" id="cap_weight_rate" value="<?php echo set_value('cap_weight_rate',$row->cap_weight_rate);?>"></td>  
		        <td><input type="text" readonly="readonly" style="background-color: #ddd" size="10" maxlength="3" min="0" max="100" name="runner_waste" id="runner_waste" placeholder="%" value="<?php echo set_value('runner_waste',$row->runner_waste);?>" />
		        </td>
		        <td ><input type="text" size="10"  name="pp_price" id="pp_price" value="<?php echo set_value('pp_price',$row->pp_price);?>" />
						</td>
						<td ><input type="text" size="10"  name="mb_price" id="mb_price" value="<?php echo set_value('mb_price',$row->mb_price);?>" />
						</td>
						<td ><input type="text" size="10" name="mb_loading" id="mb_loading" placeholder="%" value="<?php echo set_value('mb_loading',$row->mb_loading);?>" />
						</td>
						<td ><input type="text" readonly="readonly" style="background-color: #ddd" size="10" name="moulding_cost" id="moulding_cost" value="<?php echo set_value('moulding_cost',$row->moulding_cost);?>" />
						</td>
						<td ><input type="text" size="10" name="cap_rejection" id="cap_rejection" value="<?php echo set_value('cap_rejection',$row->cap_rejection);?>" />
						</td>
		      </tr>

		      <tr>
		        <td colspan="7"><span class="ui green label" id="cap_cost" >ADD</span></td>
		        <td><input  readonly="readonly" type="text" size="10" name="cap_cost_per_tube" id="cap_cost_per_tube" value="<?php echo set_value('cap_cost_per_tube',$row->cap_cost_per_tube);?>" /></td>   	
		      </tr>

		      
    		</tbody>
   		</table>
   		<table class="ui celled structured table">
   			<thead>
		      <tr>
		        <th>TOP BOX</th><th>BOTTOM BOX</th><th>POLYTHELENE LINERS</th>
		      </tr>
    		</thead>
    		<tbody>
   			  <tr>
              
              <td>
              		<select name="top_box" id="top_box">
              		<option value=''>--Select Top Box--</option>							 
									<option value="PM-CB-000-0043" <?php echo set_select('top_box','PM-CB-000-0043');?> <?php echo($row->top_box=='PM-CB-000-0043'?"selected":"");?> >CORRUGATED BOX PLAIN TOP 3 PLY 567 X 380 X 70	</option>
									<option value="PM-CB-000-0076" <?php echo set_select('top_box','PM-CB-000-0076');?> <?php echo($row->top_box=='PM-CB-000-0076'?"selected":"");?> >CORRUGATED BOX PRINTED TOP 3 PLY 567 X 380 X 70</option>
									</select>
          		</td>

          		<td>
              		<select name="bottom_box" id="bottom_box"><option value=''>--Select Packing Box--</option>
									<?php if($packing_box==FALSE){
													echo "<option value=''>--Setup Required--</option>";}
										else{
											foreach($packing_box as $packing_box_row){
													$selected=($packing_box_row->article_no==$row->bottom_box?'selected':'');
												echo "<option value='".$packing_box_row->article_no."' ".set_select('bottom_box',''.$packing_box_row->article_no.'').$selected." >".$this->common_model->get_article_name($packing_box_row->article_no,$this->session->userdata['logged_in']['company_id'])."</option>";
											}
									}?></select>
							</td>	
							
							<td>
	          		<select name="box_liners" id="box_liners">
	          			<option value=''>--Select Box Liners--</option>							 
									<option value="PM-PL-000-0009" <?php echo set_select('box_liners','PM-PL-000-0009');?> <?php echo($row->box_liners=='PM-PL-000-0009'?"selected":"");?>>POLYTHELENE LINERS 27 X 7 X 7 X 30 80G	</option>						
									</select>
									<input type="text" readonly="readonly" style="background-color: #ddd" size="10" name="liner_gm" id="liner_gm" value="<?php echo set_value('liner_gm','0.02941');?>">
          		</td>
          </tr>
          <tr>
             	
              <td><input type="text" readonly="readonly" style="background-color: #ddd" size="10" name="top_box_rate" id="top_box_rate" value="<?php echo set_value('top_box_rate',$row->top_box_rate);?>"></td>
              <td><input type="text" readonly="readonly" style="background-color: #ddd" size="10" name="bottom_box_rate" id="bottom_box_rate" value="<?php echo set_value('bottom_box_rate',$row->bottom_box_rate);?>"></td>
              
              <td><input type="text" readonly="readonly" style="background-color: #ddd" size="10" name="box_liners_rate" id="box_liners_rate" value="<?php echo set_value('box_liners_rate',$row->box_liners_rate);?>"></td>
          </tr>
          
          
          <tr>
          	<td><span class="ui green label" id="total_box" >ADD</span></td>
          	<td><input type="text" readonly="readonly" size="10" name="total_box_rate" id="total_box_rate" value="<?php echo set_value('total_box_rate',$row->total_box_rate);?>"></td>              	
          	<td><input hidden="hidden" type="text" readonly="readonly" name="boxdia_per_tube" id="boxdia_per_tube">
          		<input type="text" readonly="readonly" size="10" name="liner_gm_per_tube" id="liner_gm_per_tube" value="<?php echo set_value('liner_gm_per_tube',$row->liner_gm_per_tube);?>">
          	</td>
          </tr>  
        </tbody>  
   		</table>	
  </div>
</div>

	<!---------------------Shoulder DIv------------------>

<div id="shoulder_div" class="modal" style="display:none;">
  <div class="modal-content" style="width:1000px;">
  		
    <span class="close">&times;</span>
    	
    	<table class="ui celled structured table">
      <thead>
      <tr>
        <th>Shoulder-RM</th><th>	RATE/KG </th><th>%</th>
        
      </tr>
    </thead>
    <tbody>
      <tr>
        <td >HD : 
        		 <select name="sh_hdpe_one" id="sh_hdpe_one" >
					<option value=''>--Select HD--</option>
					<?php if($hdpe==FALSE){
								echo "<option value=''>--Setup Required--</option>";}
						else{
						foreach ($hdpe as $hdpe_row) {
						$selected=($hdpe_row->article_no==$row->sh_hdpe_one?'selected':'');		
						echo "<option value='".$hdpe_row->article_no."' ".set_select('sh_hdpe_one',$hdpe_row->article_no).$selected.">".$hdpe_row->lang_article_description."</option>";
					}
					}?>
					</select>
        </td> 
        <td><input type="text" readonly="readonly" style="background-color: #ddd" name="sh_hdpe_one_rate" id="sh_hdpe_one_rate" value="<?php echo set_value('sh_hdpe_one_rate',$row->sh_hdpe_one_rate);?>" size="5"></td>
        <td><input type="number" style="width: 7em;" name="hdpe_m" id="hdpe_m" placeholder="%" class="number3" value="<?php echo set_value('hdpe_m',$row->hdpe_m);?>" /></td>     
      </tr>

      <tr>
        <td >HD :
        		 <select name="sh_hdpe_two" id="sh_hdpe_two" >
					<option value=''>--Select HD--</option>
					<?php if($hdpe==FALSE){
								echo "<option value=''>--Setup Required--</option>";}
						else{
						foreach ($hdpe as $hdpe_row) {
						$selected=($hdpe_row->article_no==$row->sh_hdpe_two?'selected':'');
						echo "<option value='".$hdpe_row->article_no."' ".set_select('sh_hdpe_two',$hdpe_row->article_no).$selected.">".$hdpe_row->lang_article_description."</option>";
					}
					}?>
					</select>
        </td>
        <td><input type="text" readonly="readonly" style="background-color: #ddd" name="sh_hdpe_two_rate" id="sh_hdpe_two_rate" value="<?php echo set_value('sh_hdpe_two_rate',$row->sh_hdpe_two_rate);?>" size="5"></td>
        <td><input type="number" style="width: 7em;" name="hdpe_f" id="hdpe_f" placeholder="%" class="number3" value="<?php echo set_value('hdpe_f',$row->hdpe_f);?>" /></td>     
      </tr>

      <tr>
        <td> MB : <select name="shoulder_mb" id="shoulder_mb" >
        								<option value=''>--Select MB--</option>
                    <?php if($masterbatch==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach ($masterbatch as $masterbatch_row) {
											$selected=($masterbatch_row->article_no==$row->shoulder_mb?'selected':'');
                      echo "<option value='".$masterbatch_row->article_no."' ".set_select('shoulder_mb',$masterbatch_row->article_no).$selected.">".$masterbatch_row->lang_article_description."</option>";
                    }
                    }?></select>
        </td>
        <td><input type="text" readonly="readonly" style="background-color: #ddd" name="shoulder_mb_rate" id="shoulder_mb_rate" value="<?php echo set_value('shoulder_mb_rate',$row->shoulder_mb_rate);?>" size="5"></td>
        <td><input type="number" style="width: 7em;" name="shoulder_mb_percentage" id="shoulder_mb_percentage" placeholder="%"  value="<?php echo set_value('shoulder_mb_percentage',$row->shoulder_mb_percentage);?>" />
        </td>     
      </tr>

      <tr>
				<td> MB : <input type="text" size="25" name="shoulder_mb1" id="shoulder_mb1" placeholder="If MB is not in system"value="<?php echo set_value('shoulder_mb1',$row->shoulder_mb1);?>" />
				</td>
				<td>  <input type="text" size="5" name="shoulder_mb1_rate" id="shoulder_mb1_rate" value="<?php echo set_value('shoulder_mb1_rate',$row->shoulder_mb1_rate);?>" />  </td>	
				<td ><input type="number" style="width: 7em;" name="shoulder_mb_percentage1" id="shoulder_mb_percentage1" placeholder="%"  value="<?php echo set_value('shoulder_mb_percentage1',$row->shoulder_mb_percentage1);?>" />
				</td>			
	  	</tr>

	  	<tr>
        <td colspan="2">Rejection %</td>
        <td> <input type="number" style="width: 7em;" name="sh_rejection" id="sh_rejection" value="<?php echo set_value('sh_rejection',$row->sh_rejection);?>" />  </td>     
      </tr>

      <tr>
        <td colspan="2">Quantity</td>
        <td> <input type="number" style="width: 7em; background-color: #ddd" name="sh_quantity" id="sh_quantity" value="<?php echo set_value('sh_quantity',$row->sh_quantity);?>" />  </td>     
      </tr>

      <tr>
        <td colspan="2"><span class="ui green label" id="shouldercost" >ADD</span></td>

        <td><input  readonly="readonly" type="number" style="width: 7em;" name="shoulder_cost" id="shoulder_cost" value="<?php echo set_value('shoulder_cost',$row->shoulder_cost);?>"  />	
				</td>

      </tr>

      </tbody>
    </table>	
		
  </div>
</div>	
		


	<!---------------------Special ink DIv------------------>
<div id="special_ink_div" class="modal" style="display:none;">
  <div class="modal-content" style="width:1100px;">
  		
    <span class="close">&times;</span>
    	
    	<table class="ui celled structured table">
	      <thead>
	       <tr><th>RM</th><th>RATE/KG</th><th>GM/TUBE</th><th>REJECTION %</th><th>INK COVERAGE %</th></tr>
	      </thead>
		  <tbody>
		      <tr>
		        <td>SPECIAL INK : <select name="special_rm_month" id="special_rm_month" ><option value=''>--Select Special Ink--</option>
		          <?php if($special_ink==FALSE){
						echo "<option value=''>--Setup Required--</option>";}
						else{
							foreach($special_ink as $special_ink_row){
							$selected=($special_ink_row->ipm_id==$row->special_rm_month?'selected':'');		
						echo "<option value='".$special_ink_row->ipm_id."'   ".set_select('special_rm_month',$special_ink_row->ipm_id).$selected.">".$special_ink_row->rm."</option>";
							}
					}?></select></td> 
		        <td><input type="text" readonly="readonly" style="background-color: #ddd" name="special_ink_rate" id="special_ink_rate" value="<?php echo set_value('special_ink_rate',$row->special_ink_rate);?>" size="7"></td>
		        <td><input type="number" style="width: 7em;" name="special_gm_per_tube" id="special_gm_per_tube" value="<?php echo set_value('special_gm_per_tube',$row->special_gm_per_tube);?>" /></td>

		        <td><input type="number"  style="width: 7em;" name="specialink_rejection" id="specialink_rejection" value="<?php echo set_value('specialink_rejection',$row->specialink_rejection);?>" />
		        </td>
		        <td><input type="number" style="width: 7em;" name="special_percentage" id="special_percentage" placeholder="%" class="number3" value="<?php echo set_value('special_percentage',$row->special_percentage);?>" /></td>     
		      </tr>
		      <tr>
		        <td colspan="4"><span class="ui green label" id="special_ink_cost" >ADD</span></td>
		        <td><b><input  readonly="readonly" type="number" style="width: 7em;" name="special_ink_cost_per_tube" id="special_ink_cost_per_tube" value="<?php echo set_value('special_ink_cost_per_tube',$row->special_ink_cost_per_tube);?>" ></td>
		      </tr>
		  </tbody>
	  </table>		
  </div>
</div>	

	<!---------------------Offset DIv------------------>

<div id="offset_div" class="modal" style="display:none;">
  <div class="modal-content" style="width:1100px;">
  	<span class="close">&times;</span>
      <table class="ui celled structured table">
	      <thead>
	       <tr><th>RM</th><th>RATE/KG</th><th>GM/TUBE</th><th>REJECTION %</th><th>INK COVERAGE %</th></tr>
	      </thead>
		  <tbody>
		      <tr>
		        <td>OFFSET : <select name="offset_rm_month" id="offset_rm_month" ><option value=''>--Select Offset--</option>
		          <?php if($offset==FALSE){
						echo "<option value=''>--Setup Required--</option>";}
						else{
							foreach($offset as $offset_row){
								$selected=($offset_row->ipm_id==$row->offset_rm_month?'selected':'');
						echo "<option value='".$offset_row->ipm_id."'   ".set_select('offset_rm_month',$offset_row->ipm_id).$selected.">".$offset_row->rm."</option>";
							}
					}?></select></td> 
		        <td><input type="text" readonly="readonly" style="background-color: #ddd" name="offset_rate" id="offset_rate" value="<?php echo set_value('offset_rate',$row->offset_rate);?>" size="7"></td>
		        <td><input type="text" name="offset_gm_per_tube" id="offset_gm_per_tube" value="<?php echo set_value('offset_gm_per_tube',$row->offset_gm_per_tube);?>" size="7" /></td>
		        <td><input type="number" style="width: 7em;" name="offset_rejection" id="offset_rejection" placeholder="%" class="number3" value="<?php echo set_value('offset_rejection',$row->offset_rejection);?>" /></td> 
		        <td><input type="number" style="width: 7em;" name="offset_percentage" id="offset_percentage" placeholder="%" class="number3" value="<?php echo set_value('offset_percentage',$row->offset_percentage);?>" /></td>     
		      </tr>
		      <tr>
		        <td colspan="4"><span class="ui green label" id="offset_cost" >Add</span></td>
		        <td><b><input  readonly="readonly" style="width: 7em;" type="number" name="offset_cost_per_tube" id="offset_cost_per_tube" value="<?php echo set_value('offset_cost_per_tube',$row->offset_cost_per_tube);?>"  ></td>
		      </tr>
		      <!--<tr>
		      	<td>
		      		Number of Offset color plates
		      	</td>
		      	<td> <input type="text" name="offset_plate_rate"  id="offset_plate_rate" />
		      	<td>
		      		<input type="number" size="3" name="offset_color" id="offset_color" placeholder="color" maxlength="3" min="0" max="100"  value="<?php echo set_value('offset_color');?>" />
		      	</td>
		      	<td>
		      		<input type="number" size="3" name="offset_set" id="offset_set" placeholder="sets" maxlength="3"  min="0" max="100"  value="<?php echo set_value('offset_set','2');?>" />
		      	</td>
		      </tr>
		      <tr>
		      	<td colspan="3">ADD</td>
		      	<td>
		      		<input type="number" size="3" name="offset_plates_total" id="offset_plates_total" maxlength="3" min="0" max="100"  value="<?php echo set_value('offset_plates_total');?>" />
		      	</td>
		      </tr>-->
		      </tbody>
	  		</table>	

	  		<table class="ui celled structured table">
	      <thead>
	       <tr><th>PLATE PRICE</th><th>NO. OF COLORS</th><th>NO. OF IMPRESSION</th><th>SETS</th></tr>
	      </thead>
		  		<tbody>
		      <tr>
		      	<td>
		      		<input type="number" style="width: 7em;" name="offset_plate_cost" id="offset_plate_cost" class="number3" value="<?php echo set_value('offset_plate_cost',$row->offset_plate_cost);?>" />
		      	</td>
		      	
		      	<td>
		      		<input type="number" style="width: 7em;" name="offset_color" id="offset_color" class="number3" value="<?php echo set_value('offset_color',$row->offset_color);?>" />
		      	</td>
		      	<td>
		      		<input type="number" style="width: 7em;" name="offset_impresssion" id="offset_impresssion" class="number3" value="<?php echo set_value('offset_impresssion',$row->offset_impresssion);?>" />
		      	</td>
		      	<td>
		      		<input type="number" style="width: 7em;" name="offset_sets" id="offset_sets" class="number3" value="<?php echo set_value('offset_sets',$row->offset_sets);?>" />
		      	</td>
		      </tr>
		      <tr>
		        <td colspan="3"><span class="ui green label" id="offset_cost" >ADD</span></td>
		        <td><b><input  readonly="readonly" style="width: 7em;" size="3" name="offset_plate_cost_per_tube" id="offset_plate_cost_per_tube" value="<?php echo set_value('offset_plate_cost_per_tube',$row->offset_plate_cost_per_tube);?>" ></td>
		      </tr>
		  		</tbody>
	 			 </table>	
  </div>
</div>



	<!---------------------screen DIv------------------>

<div id="screen_div" class="modal" style="display:none;">
  <div class="modal-content" style="width:1100px;">
  	<span class="close">&times;</span>
      <table class="ui celled structured table">
	      <thead>
	       <tr><th>RM</th><th>RATE/KG</th><th>GM/TUBE</th><th>AREA COVERAGE %</th></tr>
	      </thead>
		  <tbody>
		      <tr>
		        <td>SCREEN : <select name="screen_rm_month" id="screen_rm_month" ><option value=''>--Select Lacquer--</option>
					<?php if($screen==FALSE){
						echo "<option value=''>--Setup Required--</option>";}
						else{
							foreach($screen as $screen_row){
								$selected=($screen_row->ipm_id==$row->screen_rm_month?'selected':'');
						echo "<option value='".$screen_row->ipm_id."'   ".set_select('screen_rm_month',$screen_row->ipm_id).$selected.">".$screen_row->rm."</option>";
							}
					}?></select></td> 
		        <td><input type="text" readonly="readonly" style="background-color: #ddd" name="screen_rate" id="screen_rate" value="<?php echo set_value('screen_rate',$row->screen_rate);?>" size="7"></td>
		        <td><input type="text"  name="screen_gm_per_tube" id="screen_gm_per_tube" value="<?php echo set_value('screen_gm_per_tube',$row->screen_gm_per_tube);?>" size="7" /></td>
		        <td><input type="number" style="width: 7em;" name="screen_percentage" id="screen_percentage" placeholder="%" class="number3" value="<?php echo set_value('screen_percentage',$row->screen_percentage);?>" /></td>     
		      </tr>

		      <tr>
		        <td>FLEXO : <select name="flexo_rm_month" id="flexo_rm_month" ><option value=''>--Select Lacquer--</option>
					<?php if($flexo==FALSE){
						echo "<option value=''>--Setup Required--</option>";}
						else{
							foreach($flexo as $flexo_row){
								$selected=($flexo_row->ipm_id==$row->flexo_rm_month?'selected':'');
						echo "<option value='".$flexo_row->ipm_id."'   ".set_select('flexo_rm_month',$flexo_row->ipm_id).$selected.">".$flexo_row->rm."</option>";
							}
					}?></select></td> 
		        <td><input type="text" readonly="readonly" style="background-color: #ddd" name="flexo_rate" id="flexo_rate" value="<?php echo set_value('flexo_rate',$row->flexo_rate);?>" size="7"></td>
		        <td><input type="text"  name="flexo_gm_per_tube" id="flexo_gm_per_tube" value="<?php echo set_value('flexo_gm_per_tube',$row->flexo_gm_per_tube);?>" size="7" /></td>		        
		        <td><input type="number" style="width: 7em;" name="flexo_percentage" id="flexo_percentage" placeholder="%" class="number3" value="<?php echo set_value('flexo_percentage',$row->flexo_percentage);?>" /></td>     
		      </tr>
		       <tr>
		        <td  colspan="3">Rejection%</td>
		        <td><input  type="number" style="width: 7em;" name="screen_flexo_rejection" id="screen_flexo_rejection" value="<?php echo set_value('screen_flexo_rejection',$row->screen_flexo_rejection);?>" />
		        </td>
		      </tr>

		      <tr>
		        <td  colspan="3">Quantity</td>
		        <td><input readonly="readonly" type="number" style="background-color: #ddd;width: 7em;" name="screen_flexo_quantity" id="screen_flexo_quantity" value="<?php echo set_value('screen_flexo_quantity','1');?>" />
		        </td>
		      </tr>

		      <tr>
		        <td colspan="3"><span class="ui green label" id="screen_flexo_cost" >ADD</span></td>
		        <td><b><input  readonly="readonly" type="number" style="width: 7em;" name="screen_flexo_cost_per_tube" id="screen_flexo_cost_per_tube" value="<?php echo set_value('screen_flexo_cost_per_tube',$row->screen_flexo_cost_per_tube);?>" ></td>
		      </tr>
		      
		  </tbody>
	  </table>
	  <table class="ui celled structured table">
	      <thead>
	       <tr><th>PLATE PRICE</th><th>NO. OF COLORS</th><th>NO. OF IMPRESSION</th><th>SETS</th></tr>
	      </thead>
		  		<tbody>
		      <tr>
		      	<td>SCREEN PLATES
		      		<input type="number" style="width: 7em;" name="screen_film_rate" id="screen_film_rate" class="number3" value="<?php echo set_value('screen_film_rate',$row->screen_film_rate);?>" />
		      	</td>
		      	
		      	<td>
		      		<input type="number" style="width: 7em;" name="screen_colors" id="screen_colors" class="number3" value="<?php echo set_value('screen_colors',$row->screen_colors);?>" />
		      	</td>
		      	<td>
		      		<input type="number" style="width: 7em;" name="screen_impresssion" id="screen_impresssion" class="number3" value="<?php echo set_value('screen_impresssion',$row->screen_impresssion);?>" />
		      	</td>
		      	<td>
		      		<input type="number" style="width: 7em;" name="screen_sets" id="screen_sets" class="number3" value="<?php echo set_value('screen_sets',$row->screen_sets);?>" />
		      	</td>
		      </tr>
		      <tr>
		        <td colspan="3"><span class="ui green label"  id="screen_film_cost" >Add</span></td>
		        <td><b><input  readonly="readonly" type="number" style="width: 7em;" name="screen_film_cost_per_tube" id="screen_film_cost_per_tube" value="<?php echo set_value('screen_film_cost_per_tube',$row->screen_film_cost_per_tube);?>" ></td>
		      </tr>
		      <tr>
		      	<td>FLEXO PLATES
		      		<input type="number" style="width: 7em;" name="flexo_plate_rate" id="flexo_plate_rate" class="number3" value="<?php echo set_value('flexo_plate_rate',$row->flexo_plate_rate);?>" />
		      	</td>
		      	
		      	<td>
		      		<input type="number" style="width: 7em;" name="flexo_colors" id="flexo_colors" class="number3" value="<?php echo set_value('flexo_colors',$row->flexo_colors);?>" />
		      	</td>
		      	<td>
		      		<input type="number" style="width: 7em;" name="flexo_impresssion" id="flexo_impresssion" class="number3" value="<?php echo set_value('flexo_impresssion',$row->flexo_impresssion);?>" />
		      	</td>
		      	<td>
		      		<input type="number" style="width: 7em;" name="flexo_sets" id="flexo_sets" class="number3" value="<?php echo set_value('flexo_sets',$row->flexo_sets);?>" />
		      	</td>
		      </tr>

		      <tr>
		        <td colspan="3"><span class="ui green label" id="flexo_plate_cost" >Add</span></td>
		        <td><b><input  readonly="readonly" type="number" style="width: 7em;" name="flexo_plate_cost_per_tube" id="flexo_plate_cost_per_tube" value="<?php echo set_value('flexo_plate_cost_per_tube',$row->flexo_plate_cost_per_tube);?>" ></td>
		      </tr>
		  		</tbody>
	 			 </table>	

  </div>
</div>


	<!---------------------label DIv------------------>

<div id="label_div" class="modal" style="display:none;">
  <div class="modal-content" style="width:600px;">
  	<span class="close">&times;</span>
      <table class="ui celled structured table">
	      <thead>
	       <tr><th>RM</th><th>REJECTION%</th><th>LABEL PURCHASE PRICE</th></tr>
	      </thead>
		  <tbody>
		      <tr>
		        <td>LABEL : </td> 
		        <td><input type="number" style="width: 7em;" name="label_rejection" id="label_rejection" placeholder="%" class="number3" value="<?php echo set_value('label_rejection',$row->label_rejection);?>" /></td>
		        <td><input type="number" style="width: 7em;" name="label_rate" id="label_rate" placeholder="Rate" class="number3" value="<?php echo set_value('label_rate',$row->label_rate);?>" /></td>  
		      </tr>  
		      <tr>
		        <td colspan="2"><span class="ui green label" id="label_cost" >ADD</span></td>
		        <td><b><input  readonly="readonly" type="number" style="width: 7em;" name="label_cost_per_tube" id="label_cost_per_tube" value="<?php echo set_value('label_cost_per_tube',$row->label_cost_per_tube);?>" ></td>
		      </tr>
		  </tbody>
	  </table>	
  </div>
</div>

	<!---------------------Lacquer DIv------------------>

				<div id="tube_lacquer_div" class="modal" style="display:none;">
				  <div class="modal-content" style="width:1100px;">
				  	<span class="close">&times;</span>
				      <table class="ui celled structured table">
					      <thead>
					       <tr><th>RM</th><th>RATE/KG</th><th>GM/TUBE</th><th>AREA COVERAGE %</th></tr>
					      </thead>
						  <tbody>
						      <tr>
						        <td>GLOSS : <select name="lacquer_type_1" id="lacquer_type_1" >
						        	<option value=''>--Select Lacquer--</option>
									<?php if($lacquer==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
										else{
											foreach($lacquer as $lacquer_row){
										$selected=($lacquer_row->article_no==$row->lacquer_1?'selected':'');		
										echo "<option value='".$lacquer_row->article_no."'   ".set_select('lacquer_type_1',$lacquer_row->article_no).$selected.">".$lacquer_row->lang_article_description."</option>";
											}
									}?></select></td> 
						        <td><input type="text" readonly="readonly" style="background-color: #ddd" name="lacquer_type_1_rate" id="lacquer_type_1_rate" value="<?php echo set_value('lacquer_type_1_rate',$row->lacquer1_rate);?>" size="7">
						        </td>
						        <td><input type="text" readonly="readonly" style="background-color: #ddd" name="lacquer_type_1_gm_per_tube" id="lacquer_type_1_gm_per_tube" value="<?php echo set_value('lacquer_type_1_gm_per_tube',$row->lacquer1_gm_per_tube);?>" size="7">
						        </td>
						        <td><input type="number"  style="width: 7em;" name="lacquer_type_1_percentage" id="lacquer_type_1_percentage" placeholder="%" class="number3" value="<?php echo set_value('lacquer_type_1_percentage',$row->lacquer1_perc);?>" />
						        </td>     
						      </tr>

						      <tr>
						        <td>MATT : <select name="lacquer_type_2" id="lacquer_type_2" ><option value=''>--Select Lacquer--</option>
									<?php if($lacquer==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
										else{
											foreach($lacquer as $lacquer_row){
										$selected=($lacquer_row->article_no==$row->lacquer_2?'selected':'');		
										echo "<option value='".$lacquer_row->article_no."'   ".set_select('lacquer_type_2',$lacquer_row->article_no).$selected.">".$lacquer_row->lang_article_description."</option>";
											}
									}?></select></td> 
						        <td><input type="text" readonly="readonly" style="background-color: #ddd" name="lacquer_type_2_rate" id="lacquer_type_2_rate" value="<?php echo set_value('lacquer_type_2_rate',$row->lacquer2_rate);?>" size="7">
						        </td>
						        <td><input type="text" readonly="readonly" style="background-color: #ddd" name="lacquer_type_2_gm_per_tube" id="lacquer_type_2_gm_per_tube" value="<?php echo set_value('lacquer_type_2_gm_per_tube',$row->lacquer2_gm_per_tube);?>" size="7">
						        </td>		        
						        <td><input type="number"  style="width: 7em;" name="lacquer_type_2_percentage" id="lacquer_type_2_percentage" placeholder="%" class="number3" value="<?php echo set_value('lacquer_type_2_percentage',$row->lacquer2_perc);?>" />
						        </td>     
						      </tr>

						      <tr>
						        <td  colspan="3">Rejection %</td>
						        <td><input type="number"  style="width: 7em;" name="lacquer_rejection" id="lacquer_rejection" value="<?php echo set_value('lacquer_rejection',$row->lacquer_rejection);?>" />
						        </td>
						      </tr>

						      <tr>
						        <td  colspan="3">Quantity</td>
						        <td><input type="number" readonly="readonly" style="background-color: #ddd;width: 7em;" name="lacquer_quantity" id="lacquer_quantity" value="<?php echo set_value('lacquer_quantity','1');?>" />
						        </td>
						      </tr>

						      <tr>
						        <td colspan="3"><span class="ui green label" id="tube_lacquer_cost" >ADD</span></td>
						        <td><b><input  readonly="readonly" type="number" style="width: 7em;" name="lacquer_cost_per_tube" id="lacquer_cost_per_tube" value="<?php echo set_value('lacquer_cost_per_tube',$row->lacquer_cost_per_tube);?>" ></td>
						      </tr>
						  </tbody>
					  </table>	
				  </div>
				</div>

	
	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/sales_quote_followup');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button" onClick="return confirm('Are you sure to approve Record?');">Approve</button>
		</div>
	</div>	
</form>
				
				
				
			