<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){

		
		$("#loading").hide(); $("#cover").hide();

		//$('.ui.modal').modal();


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

		if($("#customer").val()!=''){
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/purchase_manager');?>",data: {customer : $("#customer").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#pm_1").html(html);
				} 
			});
		}
		$("#sleeve_dia").change(function(event) {
   		var sleeve_dia = $('#sleeve_dia').val();
		   $("#loading").show();
					$("#cover").show();
					$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
					if($("#sleeve_dia option:selected" ).val()!=''){
						$("#article_name").html("<span class='ui teal label'>"+$("#sleeve_dia option:selected").text()+"<span>");
					}else{
						$("#article_name").html('');
					}
					
		    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/shoulder",data: {sleeve_dia : $('#sleeve_dia').val()},cache: false,success: function(html){
		    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
		       $("#shoulder").html(html);
		    } 
		    });
   		});


		$('#shoulder').change(function(event) {
	      if ($('#shoulder').val()=='ZELLER//6' || $('#shoulder').val()=='NOZZLE//3' || $('#shoulder').val()=='TEAR OFF//4' || $('#shoulder').val()=='BEVEL//2' ){
	      	$("#shoulder_foil_tag").val('');
	      	$("#shoulder_foils").hide();
	      }else{
	        $("#shoulder_foils").show();
	      }
	    });

	    
	
		$("#shoulder").change(function(event) {
		   var sleeve_dia = $('#sleeve_dia').val();
		   var shoulder = $('#shoulder').val();
		   $("#loading").show();
					$("#cover").show();
					$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');


					if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text();}else{var sleeve_dia="";}

					if($("#shoulder option:selected").val()!=''){ var shoulder=$("#shoulder option:selected").text();}else{var shoulder="";}

					if(shoulder!=''){
						$("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"</span>+<span class='ui teal label'>"+shoulder+"</span>");
					}else{
						$("#article_name").html('');
					}
		    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/shoulder_orifice",data: {sleeve_dia : $('#sleeve_dia').val(),shoulder : $('#shoulder').val()},cache: false,success: function(html){
		    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
		       $("#shoulder_orifice").html(html);
		    } 
		    });
   		});


		$("#shoulder_orifice").change(function(event) {
   
		   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text();}else{var sleeve_dia="";}

					if($("#shoulder option:selected").val()!=''){ var shoulder=$("#shoulder option:selected").text();}else{var shoulder="";}

					if($("#shoulder_orifice option:selected").val()!=''){ var shoulder_orifice=$("#shoulder_orifice option:selected").text();}else{var shoulder_orifice="";}

		   if(shoulder_orifice!=''){
		   		$("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"</span>+<span class='ui teal label'>"+shoulder+"</span>+<span class='ui teal label'>"+shoulder_orifice+"</span>");
						}else{
							$("#article_name").html('');
						}

		   });		


		$("#shoulder").change(function(event) {
		   var sleeve_dia = $('#sleeve_dia').val();
		   var shoulder = $('#shoulder').val();
		   var shoulder_orifice = $('#shoulder_orifice').val();
		   $("#loading").show();
					$("#cover").show();
					$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
		    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/cap_type",data: {sleeve_dia : $('#sleeve_dia').val(),shoulder : $('#shoulder').val(),shoulder_orifice :$('#shoulder_orifice').val()},cache: false,success: function(html){
		    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
		       $("#cap_type").html(html);
		    } 
		    });
		   });

  

  		$("#cap_type").change(function(event) {
  		 var cap_type = $('#cap_type').val();
  		 $("#loading").show();
    		  $("#cover").show();
     		 $('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
		      if($("#cap_type option:selected" ).val()!=''){
		        $("#article_name").html($("#cap_type option:selected").text());
		      }else{
		        $("#article_name").html('');
		      }
      
		    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/spec_cap_finish",data: {cap_type:$('#cap_type').val()},cache: false,success: function(html){
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
			    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/cap_dia",data: {sleeve_dia : $('#sleeve_dia').val(),shoulder : $('#shoulder').val(),shoulder_orifice :$('#shoulder_orifice').val(),cap_type:$('#cap_type').val(),cap_finish:$('#cap_finish').val()},cache: false,success: function(html){
			    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
			       $("#cap_dia").html(html);
			    } 
			    });
			   });

		   $("#cap_dia").change(function(event) {
			   var cap_type = $('#cap_type').val();
			   var cap_finish = $('#cap_finish').val();
			   var cap_dia = $('#cap_dia').val();
			   $("#loading").show();
			      $("#cover").show();
			      $('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			      if($("#cap_type option:selected" ).val()!='' && $("#cap_finish option:selected" ).val()!='' && $("#cap_dia option:selected" ).val()!=''){
			      $("#article_name").html($("#cap_type option:selected").text()+" "+$( "#cap_finish option:selected").text()+" "+$("#cap_dia option:selected" ).text());
			      }else{
			        $("#article_name").html('');
			      }
			    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/spec_cap_orifice",data: {cap_type:$('#cap_type').val(),cap_finish:$('#cap_finish').val(),cap_dia:$('#cap_dia').val()},cache: false,success: function(html){
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


   $("#cap_orifice").change(function(event) {
   
	   if($("#cap_type option:selected").val()!='' && $("#cap_finish option:selected" ).val()!='' && $("#cap_dia option:selected").val()!='' && $("#cap_orifice option:selected").val()!=''){
	      $("#article_name").html($("#cap_type option:selected" ).text()+" "+$( "#cap_finish option:selected").text()+" "+$( "#cap_dia option:selected" ).text()+" "+$("#cap_orifice option:selected").text());
	        }else{
	          $("#article_name").html('');
	        }

   });

	$("#cap_type").change(function(event) {

	    if($("#cap_type option:selected").val()!=''){ var cap_type=$("#cap_type option:selected").text(); }else{var cap_type="";}

	    if(cap_type!=''){
	      $("#article_name").html("<span class='ui teal label'>"+cap_type+"</span>");
	    }else{
	      $("#article_name").html('');
	    }

  });

	$("#cap_finish").change(function(event) {
    
	    if($("#cap_type option:selected").val()!=''){ var cap_type=$("#cap_type option:selected").text(); }else{var cap_type="";}
	    if($("#cap_finish option:selected").val()!=''){ var cap_finish=$("#cap_finish option:selected").text();}else{var cap_finish="";}
	    if(cap_finish!=''){
	      $("#article_name").html("<span class='ui teal label'>"+cap_type+"</span>+<span class='ui teal label'>"+cap_finish+"</span>");
	    }else{
	      $("#article_name").html('');
	    }

   });

   $("#cap_dia").change(function(event) {
    
	    if($("#cap_type option:selected").val()!=''){ var cap_type=$("#cap_type option:selected").text(); }else{var cap_type="";}
	    if($("#cap_finish option:selected").val()!=''){ var cap_finish=$("#cap_finish option:selected").text();}else{var cap_finish="";}
	    if($("#cap_dia option:selected").val()!=''){ var cap_dia=$("#cap_dia option:selected").text();}else{var cap_dia="";}
	    if(cap_dia!=''){
	      $("#article_name").html("<span class='ui teal label'>"+cap_type+"</span>+<span class='ui teal label'>"+cap_finish+"</span>+<span class='ui teal label'>"+cap_dia+"</span>");
	    }else{
	      $("#article_name").html('');
	    }

   });


   $("#cap_orifice").change(function(event) {
   
	    if($("#cap_type option:selected").val()!=''){ var cap_type=$("#cap_type option:selected").text(); }else{var cap_type="";}

	    if($("#cap_finish option:selected").val()!=''){ var cap_finish=$("#cap_finish option:selected").text();}else{var cap_finish="";}

	    if($("#cap_dia option:selected").val()!=''){ var cap_dia=$("#cap_dia option:selected").text();}else{var cap_dia="";}

	    if($("#cap_orifice option:selected").val()!=''){ var cap_ori=$("#cap_orifice option:selected").text();}else{var cap_ori="";}

	    if(cap_ori!=''){

	      $("#article_name").html("<span class='ui teal label'>"+cap_type+"</span>+<span class='ui teal label'>"+cap_finish+"</span>+<span class='ui teal label'>"+cap_dia+"</span>+<span class='ui teal label'>"+cap_ori+"</span>");

	        }else{
	          $("#article_name").html('');
	        }

   }); 


   //--------------------Quote price------------------------------------

   $("#less_than_10k_cost").blur(function(){
			
								
			if($("#less_than_10k_quoted_contr").val()!='' && $("#less_than_10k_cost").val()!=''){
					
						//var less_than_10k_quoted_contr=$("#less_than_10k_quoted_contr").val();
						//alert(parseInt(less_than_10k_quoted_contr).toFixed(1));

						var less_than_10k_quoted_price=	parseFloat($("#less_than_10k_quoted_contr").val()) + parseFloat($("#less_than_10k_cost").val());
						$("#less_than_10k_quoted_price").val(less_than_10k_quoted_price.toFixed(2));
					
			}
		});

   $("#_10k_to_25k_cost").blur(function(){
			
								
			if($("#_10k_to_25k_quoted_contr").val()!='' && $("#_10k_to_25k_cost").val()!=''){
					
						var _10k_to_25k_quoted_price=	parseFloat($("#_10k_to_25k_quoted_contr").val()) + parseFloat($("#_10k_to_25k_cost").val());
						$("#_10k_to_25k_quoted_price").val(_10k_to_25k_quoted_price.toFixed(2));
					
			}
		});

   $("#_25k_to_50k_cost").blur(function(){
			
								
			if($("#_25k_to_50k_quoted_contr").val()!='' && $("#_25k_to_50k_cost").val()!=''){
					
						var _25k_to_50k_quoted_price=	parseFloat($("#_25k_to_50k_quoted_contr").val()) + parseFloat($("#_25k_to_50k_cost").val());
						$("#_25k_to_50k_quoted_price").val(_25k_to_50k_quoted_price.toFixed(2));
					
			}
		});

   $("#_50k_to_100k_cost").blur(function(){
			
								
			if($("#_50k_to_100k_quoted_contr").val()!='' && $("#_50k_to_100k_cost").val()!=''){
					
						var _50k_to_100k_quoted_price=	parseFloat($("#_50k_to_100k_quoted_contr").val()) + parseFloat($("#_50k_to_100k_cost").val());
						$("#_50k_to_100k_quoted_price").val(_50k_to_100k_quoted_price.toFixed(2));
					
			}
		});

   $("#_100k_to_250k_cost").blur(function(){
			
								
			if($("#_100k_to_250k_quoted_contr").val()!='' && $("#_100k_to_250k_cost").val()!=''){
					
						var _100k_to_250k_quoted_price=	parseFloat($("#_100k_to_250k_quoted_contr").val()) + parseFloat($("#_100k_to_250k_cost").val());
						$("#_100k_to_250k_quoted_price").val(_100k_to_250k_quoted_price.toFixed(2));
					
			}
		});

   $("#greater_than_250k_cost").blur(function(){
			
								
			if($("#greater_than_250k_quoted_contr").val()!='' && $("#greater_than_250k_cost").val()!=''){
					
						var greater_than_250k_quoted_price=	parseFloat($("#greater_than_250k_quoted_contr").val()) + parseFloat($("#greater_than_250k_cost").val());
						$("#greater_than_250k_quoted_price").val(greater_than_250k_quoted_price.toFixed(2));
					
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


    //---------------Layers POPUP BOX
   // $('.ui.modal').modal();
    $("#layer").change(function(event) {

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
    });

    //---------------Print Type POPUP BOX
     $("#print_type").change(function(event) {

    	var print_type=$("#print_type").val();

    	switch(print_type){
    		case("PLAIN"):$('#plain_div').show();
    		break;
    		case("LABEL"):$("#label_div").show();
    		break;
    		case("SPRING"):$("#spring_div").show();
    		break;
    		case("SCREEN"):$("#screen_div").show();
    		break;
    		case("OFFSET"):$("#offset_div").show();
    		break;
    	}
		 
	 });

 //---------------------------Shoulder POPUP BOX
   
    $("#shoulder_orifice").change(function(event) {

    	var shoulder_ori=$("#shoulder_orifice").val();
    	
    	$('#shoulder_div').show();
	 
	 });

  //---------------------------Lacquer Popup

    $("#tube_lacquer").change(function(event) {

    	if($("#tube_lacquer").val()=='YES'){
		   	$('#tube_lacquer_div').show();
    	}else{
    		$('#tube_lacquer_div').css('display','none');
    	}
	 
	 });


    //---------Lacquer Calculator


    $("#lacquer_type_1").change(function(event) {

		$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#lacquer_type_1').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#lacquer_type_1_rate").html(html);

		   	 } 
		   });
  	});

  	$("#lacquer_type_1").change(function(event) {

		$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_lacquer_consumption",data: {rm:$('#lacquer_type_1').val(),sleeve_dia:$('#sleeve_dia').val(),sleeve_length:$('#sleeve_length').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#lacquer_type_1_gm_per_tube").html(html);

		   	 } 
		   });
  	});

  	$("#lacquer_type_2").change(function(event) {

		$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#lacquer_type_2').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#lacquer_type_2_rate").html(html);

		   	 } 
		   });
  	});

  	$("#lacquer_type_2").change(function(event) {

		$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_lacquer_consumption",data: {rm:$('#lacquer_type_2').val(),sleeve_dia:$('#sleeve_dia').val(),sleeve_length:$('#sleeve_length').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#lacquer_type_2_gm_per_tube").html(html);

		   	 } 
		   });
  	});



    $("#tube_lacquer_cost").click(function(event) {

    	var std_print_rejection = parseInt($("#std_print_rejection").val());
    	var lacquer_1_cost=0;
    	var lacquer_2_cost=0;
    	if($('#sleeve_dia').val()=="" || $('#sleeve_length').val()==""){
				alert("Please enter the Diameter,Length");
		}else if($('#lacquer_type_1').val()=="" || $('#lacquer_type_1_percentage').val()==""){
			alert("Enter Lacquer Code & %");
		}else if(parseInt($("#lacquer_type_1_percentage").val()) + parseInt($("#lacquer_type_2_percentage").val()) !== 100){
			alert("Addition of Both Lacquer shoulde be 100%");
		}else if( parseInt($("#printing_rejection").val())< std_print_rejection ){
				alert(" Rejection % should be greater than 5");		
		}else {
			var lacquer_1_cost_per_tube=0;
    		var lacquer_2_cost_per_tube=0;
    	
			var curved_surface_area=(parseInt($('#sleeve_dia').val())*3.142*(parseFloat($('#sleeve_length').val())+2))/1000;
			
			lacquer_1_cost_per_tube=(($("#lacquer_type_1_rate").html()/1000)*parseFloat($("#lacquer_type_1_gm_per_tube").html())*(parseInt($("#lacquer_type_1_percentage").val())/100)*curved_surface_area)/100;
			//lacquer_1_cost=lacquer_1_cost_per_tube;

			if($('#lacquer_type_2').val()!="" || $('#lacquer_type_2_percentage').val()!=""){

			lacquer_2_cost_per_tube=(($("#lacquer_type_2_rate").html()/1000)*parseFloat($("#lacquer_type_2_gm_per_tube").html())*(parseInt($("#lacquer_type_2_percentage").val())/100)*curved_surface_area)/100;
				if(isNaN(lacquer_2_cost_per_tube)){
					lacquer_2_cost_per_tube=0;
				}
			}

			var total_lacquer_cost=(+lacquer_1_cost_per_tube)+(+lacquer_2_cost_per_tube);

			$("#lacquer_cost_per_tube").val(total_lacquer_cost.toFixed(2));
			$("#lacquer_cost_view").html(total_lacquer_cost.toFixed(2));
		}
		
    });
   //-----------------------Label Calculator
   
   $("#label_cost").click(function(event) {

   	var std_lb_rejection = parseInt($("#std_lb_rejection").val());
    	
    	if($('#label_rate').val()=="" ){
				alert("Please enter the Label Rate");
		}else if($('#label_rejection').val()=="" ){
			alert("Enter Rejection %");
		}else if( parseInt($("#label_rejection").val())< std_lb_rejection ){
				alert(" Rejection % should be greater than 2");	
		}else {
    			
			var label_rate = (parseFloat($('#label_rate').val()));
			var label_rejection = (parseFloat($('#label_rejection').val())) / 100;

			var label_cost=label_rate + (label_rate * label_rejection);
			//alert(label_cost);

			$("#label_cost_per_tube").val(label_cost.toFixed(2));
			$("#label_cost_view").html(label_cost.toFixed(2));
		}
		
    }); 

   //---------Offset Calculator


    $("#offset_rm_month").change(function(event) {

		$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_offset_rate",data: {ink_id:$('#offset_rm_month').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#offset_rate").html(html);

		   	 } 
		   });
  	});

    $("#offset_cost").click(function(event) {

   	var std_off_rejection = parseInt($("#std_off_rejection").val());
    	
    	if($('#offset_percentage').val()=="" ){
				alert("Please enter the Offset %");
		}else if($('#offset_rejection').val()=="" ){
			alert("Enter Rejection %");
		}else if( parseInt($("#offset_rejection").val())< std_off_rejection ){
				alert(" Rejection % should be greater than 5");	
		}else {
    			
			var label_rate = (parseFloat($('#label_rate').val()));
			var label_rejection = (parseFloat($('#label_rejection').val())) / 100;

			var label_cost=label_rate + (label_rate * label_rejection);
			//alert(label_cost);

			$("#offset_cost_per_tube").val(label_cost.toFixed(2));
			$("#offset_cost_view").html(label_cost.toFixed(2));
		}
		
    });  



//----------------------------RM CALCULATOR--------------------------


		$("#sl_ldpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#sl_ldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer1_ldpe_rate").html(html);

		   	 } 
		    	});
  		 });

		$("#sl_lldpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#sl_lldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer1_lldpe_rate").html(html);

		   	 } 
		    	});
  		 });	

		$("#sl_hdpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#sl_hdpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer1_hdpe_rate").html(html);

		   	 } 
		    	});
  		 });

		$("#sl_masterbatch").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#sl_masterbatch').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer1_mb_rate").html(html);

		   	 } 
		    	});
  		 });

//------------------------Layer 1 Check button---------------
		$("#layer1_sleevecost").click(function(event) {

			var std_rejection = parseInt($("#std_rejection").val());

			if($('#sleeve_dia').val()=="" || $('#sleeve_length').val()==""){
				alert("Please enter the Diameter,Length");
			}else if($('#micron').val()=="" || $('#layer1_ld_percentage').val()=="" || $('#layer1_lld_percentage').val()=="" || $('#layer1_hd_percentage').val()=="" ){
				alert("Please enter Micron , % ");
			}else if(parseInt($('#layer1_ld_percentage').val())!== 0 && $('#sl_ldpe').val()==""  || parseInt($('#layer1_lld_percentage').val())!== 0 && $('#sl_lldpe').val()=="" ){
				alert("Please select RM ");
			}else if(parseInt($('#layer1_hd_percentage').val())!== 0 && $('#sl_hdpe').val()==""  || parseInt($('#layer1_lld_percentage').val())!== 0 && $('#sl_lldpe').val()=="" ){
				alert("Please select RM ");	
				
		   }else if(parseInt($("#layer1_ld_percentage").val()) + parseInt($("#layer1_lld_percentage").val()) + parseInt($("#layer1_hd_percentage").val())!== 100 ){
				alert(" % of LD , LLD and HD should be 100");
			}else if($('#sl_masterbatch').val()=="" && $('#layer1_mb1').val()==""){
				alert("Please Enter MB ");
			}else if($('#layer1_mb1').val()!=="" && $('#layer1_mb1_rate').val()=="" && $('#layer1_mb_percentage1').val()== 0){
				alert("Please Enter MB Rate , %");	
			}else if( parseFloat($('#layer1_mb1_rate').val())!== 0 && parseInt($('#layer1_mb_percentage1').val())== 0){
				alert("Please correct MB %");	
			}else if( parseFloat($('#quantity').val())== 0){
				alert("Quantity cannot be 0");	
			}else if( parseInt($("#rejection").val())< std_rejection ){
				alert(" rejection % should be greater than 5");
			}else{
				var check = parseInt($("#layer1_ld_percentage").val()) + parseInt($("#layer1_lld_percentage").val()) +  parseInt($("#layer1_hd_percentage").val()) ;
				

				var sleeveweight= (((parseInt($('#sleeve_dia').val()) * parseFloat($('#sleeve_length').val()) * parseInt($('#micron').val()) * 3.14 * 0.92/1000000)/1000)*parseFloat($('#quantity').val()))+ ((((parseInt($('#sleeve_dia').val()) * parseFloat($('#sleeve_length').val()) * parseInt($('#micron').val()) * 3.14 * 0.92/1000000)/1000)* parseFloat($('#quantity').val()))*parseInt($('#rejection').val()))/100 ;

				var ldweight = (sleeveweight * parseInt($('#layer1_ld_percentage').val())) / 100 ;
				var lldweight = (sleeveweight * parseInt($('#layer1_lld_percentage').val())) / 100 ;
				var hdweight = (sleeveweight * parseInt($('#layer1_hd_percentage').val())) / 100 ;
				var mbweight = (sleeveweight * parseInt($('#layer1_mb_percentage').val())) / 100 ;
				var mb1weight = (sleeveweight * parseInt($('#layer1_mb_percentage1').val())) / 100 ;
				//alert(mbweight);
				//alert(mb1weight);

				var ldvalue = ($("#layer1_ldpe_rate").html()* ldweight) ;
				var lldvalue = ($("#layer1_lldpe_rate").html()* lldweight) ;
				var hdvalue = ($("#layer1_hdpe_rate").html()* hdweight) ;
				var mbvalue = ($("#layer1_mb_rate").html()* mbweight) ;
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

				var sleeve_cost = (ldcost_per_tube + lldcost_per_tube + hdcost_per_tube + mbcost_per_tube + mb1cost_per_tube );
				//alert(sleeve_cost);
				$('#sleeve_cost').val(sleeve_cost.toFixed(2));
				$('#sleeve_cost_view').html(sleeve_cost.toFixed(2));
				
			}
		});

//------------------------LAYER 2 RM -------------------
		$("#layer2_layer1_sl_ldpe").change(function(event) {

		$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer2_layer1_sl_ldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer2_layer1_ldpe_rate").html(html);

		   	 } 
		    	});
  		 });

		$("#layer2_layer1_sl_lldpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer2_layer1_sl_lldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer2_layer1_lldpe_rate").html(html);

		   	 } 
		    	});
  		 });	

		$("#layer2_layer1_sl_hdpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer2_layer1_sl_hdpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer2_layer1_hdpe_rate").html(html);

		   	 } 
		    	});
  		 });

		$("#layer2_layer2_sl_ldpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer2_layer2_sl_ldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer2_layer2_ldpe_rate").html(html);

		   	 } 
		    	});
  		 });

		$("#layer2_layer2_sl_lldpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer2_layer2_sl_lldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer2_layer2_lldpe_rate").html(html);

		   	 } 
		    	});
  		 });	

		$("#layer2_layer2_sl_hdpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer2_layer2_sl_hdpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer2_layer2_hdpe_rate").html(html);

		   	 } 
		    	});
  		 });

		//--------check button-----------

		$("#layer2_sleevecost").click(function(event) {

			if($('#sleeve_dia').val()=="" || $('#sleeve_length').val()==""){
				alert("Please enter the Diameter,Length");
			}else if($('#layer2_layer1_micron').val()=="" || $('#layer2_layer2_micron').val()=="" || $('#layer2_layer1_ld_percentage').val()=="" || $('#layer2_layer1_lld_percentage').val()=="" ||  $('#layer2_layer1_hd_percentage').val()=="" || $('#layer2_layer2_ld_percentage').val()=="" ||  $('#layer2_layer2_lld_percentage').val()=="" || $('#layer2_layer2_hd_percentage').val()=="" || $('#layer2_layer1_sl_ldpe').val()=="" || $('#layer2_layer1_sl_lldpe').val()=="" || $('#layer2_layer2_sl_ldpe').val()=="" || $('#layer2_layer2_sl_lldpe').val()==""  ){
				alert("Please enter Micron , % , RM ");
			}else{
				var check = parseInt($("#layer2_layer1_ld_percentage").val()) + parseInt($("#layer2_layer1_lld_percentage").val()) +  parseInt($("#layer2_layer1_hd_percentage").val()) ;
				//alert(check);

				var layer2_layer1_sleeveweight= (((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer2_layer1_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseInt($('#layer2_quantity').val()))+ ((((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer2_layer1_micron').val()) * 3.14 * 0.92/1000000)/1000)* parseInt($('#layer2_quantity').val()))*parseInt($('#layer2_rejection').val()))/100 ;

				var layer2_layer2_sleeveweight= (((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer2_layer2_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseInt($('#layer2_quantity').val()))+ ((((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer2_layer2_micron').val()) * 3.14 * 0.92/1000000)/1000)* parseInt($('#layer2_quantity').val()))*parseInt($('#layer2_rejection').val()))/100 ;

				var layer2_layer1_ldweight = (layer2_layer1_sleeveweight * parseInt($('#layer2_layer1_ld_percentage').val())) / 100 ;
				var layer2_layer1_lldweight = (layer2_layer1_sleeveweight * parseInt($('#layer2_layer1_lld_percentage').val())) / 100 ;
				var layer2_layer1_hdweight = (layer2_layer1_sleeveweight * parseInt($('#layer2_layer1_hd_percentage').val())) / 100 ;

				var layer2_layer2_ldweight = (layer2_layer2_sleeveweight * parseInt($('#layer2_layer2_ld_percentage').val())) / 100 ;
				var layer2_layer2_lldweight = (layer2_layer2_sleeveweight * parseInt($('#layer2_layer2_lld_percentage').val())) / 100 ;
				var layer2_layer2_hdweight = (layer2_layer2_sleeveweight * parseInt($('#layer2_layer2_hd_percentage').val())) / 100 ;
				//alert(layer2_layer2_ldweight);

				var layer2_layer1_ldvalue = ($("#layer2_layer1_ldpe_rate").html()* layer2_layer1_ldweight) ;
				var layer2_layer1_lldvalue = ($("#layer2_layer1_lldpe_rate").html()* layer2_layer1_lldweight) ;
				var layer2_layer1_hdvalue = ($("#layer2_layer1_hdpe_rate").html()* layer2_layer1_hdweight) ;

				var layer2_layer2_ldvalue = ($("#layer2_layer2_ldpe_rate").html()* layer2_layer2_ldweight) ;
				var layer2_layer2_lldvalue = ($("#layer2_layer2_lldpe_rate").html()* layer2_layer2_lldweight) ;
				var layer2_layer2_hdvalue = ($("#layer2_layer2_hdpe_rate").html()* layer2_layer2_hdweight) ;
				//alert(layer2_layer2_ldvalue);
				//alert(layer2_layer2_lldvalue);				

				var layer2_layer1_ldcost_per_tube = 	(layer2_layer1_ldvalue / parseInt($('#layer2_quantity').val()));	
				var layer2_layer1_lldcost_per_tube = 	(layer2_layer1_lldvalue / parseInt($('#layer2_quantity').val()));
				var layer2_layer1_hdcost_per_tube = 	(layer2_layer1_hdvalue / parseInt($('#layer2_quantity').val()));

				var layer2_layer2_ldcost_per_tube = 	(layer2_layer2_ldvalue / parseInt($('#layer2_quantity').val()));	
				var layer2_layer2_lldcost_per_tube = 	(layer2_layer2_lldvalue / parseInt($('#layer2_quantity').val()));
				var layer2_layer2_hdcost_per_tube = 	(layer2_layer2_hdvalue / parseInt($('#layer2_quantity').val()));
				//alert(layer2_layer2_ldcost_per_tube);				
				//alert(layer2_layer2_lldcost_per_tube);	

				var layer2_sleeve_cost = (layer2_layer1_ldcost_per_tube + layer2_layer1_lldcost_per_tube + layer2_layer1_hdcost_per_tube + layer2_layer2_ldcost_per_tube + layer2_layer2_lldcost_per_tube + layer2_layer2_hdcost_per_tube);
				//alert(layer2_sleeve_cost);

				$('#layer2_sleeve_cost').html(layer2_sleeve_cost.toFixed(2));
				
			}
		});
//-------------------------------------LAYER 3 RM -----------------------
		$("#layer3_layer1_sl_ldpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer3_layer1_sl_ldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer3_layer1_ldpe_rate").html(html);

		   	 } 
		    	});
  		 });

		$("#layer3_layer1_sl_lldpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer3_layer1_sl_lldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer3_layer1_lldpe_rate").html(html);

		   	 } 
		    	});
  		 });	

		$("#layer3_layer1_sl_hdpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer3_layer1_sl_hdpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer3_layer1_hdpe_rate").html(html);

		   	 } 
		    	});
  		 });

		$("#layer3_layer2_sl_hdpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer3_layer2_sl_hdpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer3_layer2_hdpe_rate").html(html);

		   	 } 
		    	});
  		 });

		$("#layer3_layer3_sl_ldpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer3_layer3_sl_ldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer3_layer3_ldpe_rate").html(html);

		   	 } 
		    	});
  		 });

		$("#layer3_layer3_sl_lldpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer3_layer3_sl_lldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer3_layer3_lldpe_rate").html(html);

		   	 } 
		    	});
  		 });	

		$("#layer3_layer3_sl_hdpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer3_layer3_sl_hdpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer3_layer3_hdpe_rate").html(html);

		   	 } 
		    	});
  		 });
		//--------check button-----------
		$("#layer3_sleevecost").click(function(event) {

			if($('#sleeve_dia').val()=="" || $('#sleeve_length').val()==""){
				alert("Please enter the Diameter,Length");
			}else if($('#layer3_layer1_micron').val()=="" || $('#layer3_layer2_micron').val()=="" || $('#layer3_layer3_micron').val()=="" || $('#layer3_layer1_ld_percentage').val()=="" || $('#layer3_layer1_lld_percentage').val()=="" ||  $('#layer3_layer1_hd_percentage').val()=="" || $('#layer3_layer2_ld_percentage').val()=="" ||  $('#layer3_layer2_lld_percentage').val()=="" || $('#layer3_layer2_hd_percentage').val()=="" || $('#layer3_layer3_ld_percentage').val()=="" ||  $('#layer3_layer3_lld_percentage').val()=="" || $('#layer3_layer3_hd_percentage').val()=="" || $('#layer3_layer1_sl_ldpe').val()=="" || $('#layer3_layer1_sl_lldpe').val()=="" || $('#layer3_layer2_sl_hdpe').val()=="" || $('#layer3_layer3_sl_ldpe').val()=="" || $('#layer3_layer3_sl_lldpe').val()==""  ){
				alert("Please enter Micron , % , RM ");
			}else{
				var check = parseInt($("#layer3_layer1_ld_percentage").val()) + parseInt($("#layer3_layer1_lld_percentage").val()) +  parseInt($("#layer3_layer1_hd_percentage").val()) ;
				//alert(check);

				var layer3_layer1_sleeveweight= (((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer3_layer1_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseInt($('#layer3_quantity').val()))+ ((((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer3_layer1_micron').val()) * 3.14 * 0.92/1000000)/1000)* parseInt($('#layer3_quantity').val()))*parseInt($('#layer3_rejection').val()))/100 ;

				var layer3_layer2_sleeveweight= (((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer3_layer2_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseInt($('#layer3_quantity').val()))+ ((((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer3_layer2_micron').val()) * 3.14 * 0.92/1000000)/1000)* parseInt($('#layer3_quantity').val()))*parseInt($('#layer3_rejection').val()))/100 ;

				var layer3_layer3_sleeveweight= (((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer3_layer3_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseInt($('#layer3_quantity').val()))+ ((((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer3_layer3_micron').val()) * 3.14 * 0.92/1000000)/1000)* parseInt($('#layer3_quantity').val()))*parseInt($('#layer3_rejection').val()))/100 ;
				//alert(layer3_layer2_sleeveweight);

				var layer3_layer1_ldweight = (layer3_layer1_sleeveweight * parseInt($('#layer3_layer1_ld_percentage').val())) / 100 ;
				var layer3_layer1_lldweight =(layer3_layer1_sleeveweight * parseInt($('#layer3_layer1_lld_percentage').val())) / 100 ;
				var layer3_layer1_hdweight = (layer3_layer1_sleeveweight * parseInt($('#layer3_layer1_hd_percentage').val())) / 100 ;

				var layer3_layer2_hdweight = (layer3_layer2_sleeveweight * parseInt($('#layer3_layer2_hd_percentage').val())) / 100 ;

				var layer3_layer3_ldweight = (layer3_layer3_sleeveweight * parseInt($('#layer3_layer3_ld_percentage').val())) / 100 ;
				var layer3_layer3_lldweight = (layer3_layer3_sleeveweight * parseInt($('#layer3_layer3_lld_percentage').val())) / 100 ;
				var layer3_layer3_hdweight = (layer3_layer3_sleeveweight * parseInt($('#layer3_layer3_hd_percentage').val())) / 100 ;
				//alert(layer3_layer2_hdweight);
				

				var layer3_layer1_ldvalue = ($("#layer3_layer1_ldpe_rate").html()* layer3_layer1_ldweight) ;
				var layer3_layer1_lldvalue = ($("#layer3_layer1_lldpe_rate").html()* layer3_layer1_lldweight) ;
				var layer3_layer1_hdvalue = ($("#layer3_layer1_hdpe_rate").html()* layer3_layer1_hdweight) ;

				var layer3_layer2_hdvalue = ($("#layer3_layer2_hdpe_rate").html()* layer3_layer2_hdweight) ;

				var layer3_layer3_ldvalue = ($("#layer3_layer3_ldpe_rate").html()* layer3_layer3_ldweight) ;
				var layer3_layer3_lldvalue = ($("#layer3_layer3_lldpe_rate").html()* layer3_layer3_lldweight) ;
				var layer3_layer3_hdvalue = ($("#layer3_layer3_hdpe_rate").html()* layer3_layer3_hdweight) ;
				//alert(layer3_layer2_hdvalue);				

				var layer3_layer1_ldcost_per_tube = 	(layer3_layer1_ldvalue / parseInt($('#layer3_quantity').val()));	
				var layer3_layer1_lldcost_per_tube = 	(layer3_layer1_lldvalue / parseInt($('#layer3_quantity').val()));
				var layer3_layer1_hdcost_per_tube = 	(layer3_layer1_hdvalue / parseInt($('#layer3_quantity').val()));

				var layer3_layer2_hdcost_per_tube = 	(layer3_layer2_hdvalue / parseInt($('#layer3_quantity').val()));

				var layer3_layer3_ldcost_per_tube = 	(layer3_layer3_ldvalue / parseInt($('#layer3_quantity').val()));	
				var layer3_layer3_lldcost_per_tube = 	(layer3_layer3_lldvalue / parseInt($('#layer3_quantity').val()));
				var layer3_layer3_hdcost_per_tube = 	(layer3_layer3_hdvalue / parseInt($('#layer3_quantity').val()));
				//alert(layer3_layer2_hdcost_per_tube);	

				var layer3_sleeve_cost = (layer3_layer1_ldcost_per_tube + layer3_layer1_lldcost_per_tube + layer3_layer1_hdcost_per_tube + layer3_layer2_hdcost_per_tube + layer3_layer3_ldcost_per_tube + layer3_layer3_lldcost_per_tube + layer3_layer3_hdcost_per_tube);
				//alert(layer3_sleeve_cost);

				$('#layer3_sleeve_cost').html(layer3_sleeve_cost.toFixed(2));
				
			}
		});
//-------------------------------------LAYER 5 RM -----------------------
		$("#layer5_layer1_sl_ldpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer5_layer1_sl_ldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer5_layer1_ldpe_rate").html(html);

		   	 } 
		    	});
  		 });
		$("#layer5_layer1_sl_lldpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer5_layer1_sl_lldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer5_layer1_lldpe_rate").html(html);

		   	 } 
		    	});
  		 });	

		$("#layer5_layer1_sl_hdpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer5_layer1_sl_hdpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer5_layer1_hdpe_rate").html(html);

		   	 } 
		    	});
  		 });

		$("#layer5_layer2_admer").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer5_layer2_admer').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer5_layer2_admer_rate").html(html);

		   	 } 
		    	});
  		 });

		$("#layer5_layer3_evoh").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer5_layer3_evoh').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer5_layer3_evoh_rate").html(html);

		   	 } 
		    	});
  		 });

		$("#layer5_layer4_admer").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer5_layer4_admer').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer5_layer4_admer_rate").html(html);

		   	 } 
		    	});
  		 });

		$("#layer5_layer5_sl_ldpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer5_layer5_sl_ldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer5_layer5_ldpe_rate").html(html);

		   	 } 
		    	});
  		 });

		$("#layer5_layer5_sl_lldpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer5_layer5_sl_lldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer5_layer5_lldpe_rate").html(html);

		   	 } 
		    	});
  		 });

		$("#layer5_layer5_sl_hdpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer5_layer5_sl_hdpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer5_layer5_hdpe_rate").html(html);

		   	 } 
		    	});
  		 });

		//--------check button-----------
		$("#layer5_sleevecost").click(function(event) {

			if($('#sleeve_dia').val()=="" || $('#sleeve_length').val()==""){
				alert("Please enter the Diameter,Length");
			}else if($('#layer5_layer1_micron').val()=="" || $('#layer5_layer2_micron').val()=="" || $('#layer5_layer3_micron').val()=="" || $('#layer5_layer4_micron').val()=="" || $('#layer5_layer5_micron').val()=="" ||  $('#layer5_layer1_ld_percentage').val()=="" || $('#layer5_layer1_lld_percentage').val()=="" ||  $('#layer5_layer1_hd_percentage').val()=="" || $('#layer5_layer2_admer_percentage').val()=="" || $('#layer5_layer3_evoh_percentage').val()=="" ||  $('#layer5_layer4_admer_percentage').val()=="" || $('#layer5_layer5_ld_percentage').val()=="" || $('#layer5_layer5_lld_percentage').val()=="" || $('#layer5_layer5_hd_percentage').val()=="" || $('#layer5_layer1_sl_ldpe').val()=="" || $('#layer5_layer1_sl_lldpe').val()=="" || $('#layer5_layer2_admer').val()=="" || $('#layer5_layer3_evoh').val()=="" || $('#layer5_layer4_admer').val()=="" || $('#layer5_layer5_sl_ldpe').val()=="" || $('#layer5_layer5_sl_lldpe').val()=="" ){
				alert("Please enter Micron , % , RM ");
			}else{
				var check = parseInt($("#layer3_layer1_ld_percentage").val()) + parseInt($("#layer3_layer1_lld_percentage").val()) +  parseInt($("#layer3_layer1_hd_percentage").val()) ;
				//alert(check);

				var layer5_layer1_sleeveweight= (((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer5_layer1_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseInt($('#layer5_quantity').val()))+ ((((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer5_layer1_micron').val()) * 3.14 * 0.92/1000000)/1000)* parseInt($('#layer5_quantity').val()))*parseInt($('#layer5_rejection').val()))/100 ;

				var layer5_layer2_sleeveweight= (((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer5_layer2_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseInt($('#layer5_quantity').val()))+ ((((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer5_layer2_micron').val()) * 3.14 * 0.92/1000000)/1000)* parseInt($('#layer5_quantity').val()))*parseInt($('#layer5_rejection').val()))/100 ;

				var layer5_layer3_sleeveweight= (((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer5_layer3_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseInt($('#layer5_quantity').val()))+ ((((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer5_layer3_micron').val()) * 3.14 * 0.92/1000000)/1000)* parseInt($('#layer5_quantity').val()))*parseInt($('#layer5_rejection').val()))/100 ;

				var layer5_layer4_sleeveweight= (((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer5_layer4_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseInt($('#layer5_quantity').val()))+ ((((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer5_layer4_micron').val()) * 3.14 * 0.92/1000000)/1000)* parseInt($('#layer5_quantity').val()))*parseInt($('#layer5_rejection').val()))/100 ;

				var layer5_layer5_sleeveweight= (((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer5_layer5_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseInt($('#layer5_quantity').val()))+ ((((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer5_layer5_micron').val()) * 3.14 * 0.92/1000000)/1000)* parseInt($('#layer5_quantity').val()))*parseInt($('#layer5_rejection').val()))/100 ;

				//alert(layer5_layer4_sleeveweight);

				var layer5_layer1_ldweight = (layer5_layer1_sleeveweight * parseInt($('#layer5_layer1_ld_percentage').val())) / 100 ;
				var layer5_layer1_lldweight =(layer5_layer1_sleeveweight * parseInt($('#layer5_layer1_lld_percentage').val())) / 100 ;
				var layer5_layer1_hdweight = (layer5_layer1_sleeveweight * parseInt($('#layer5_layer1_hd_percentage').val())) / 100 ;
				
				var layer5_layer2_admerweight =(layer5_layer2_sleeveweight * parseInt($('#layer5_layer2_admer_percentage').val())) / 100 ;

				var layer5_layer3_evohweight = (layer5_layer3_sleeveweight * parseInt($('#layer5_layer3_evoh_percentage').val())) / 100 ;

				var layer5_layer4_admerweight =(layer5_layer4_sleeveweight * parseInt($('#layer5_layer4_admer_percentage').val())) / 100 ;
				
				var layer5_layer5_ldweight = (layer5_layer5_sleeveweight * parseInt($('#layer5_layer5_ld_percentage').val())) / 100 ;
				var layer5_layer5_lldweight =(layer5_layer5_sleeveweight * parseInt($('#layer5_layer5_lld_percentage').val())) / 100 ;
				var layer5_layer5_hdweight = (layer5_layer5_sleeveweight * parseInt($('#layer5_layer5_hd_percentage').val())) / 100 ;
				//alert(layer5_layer5_ldweight);

				var layer5_layer1_ldvalue = ($("#layer5_layer1_ldpe_rate").html()* layer5_layer1_ldweight) ;
				var layer5_layer1_lldvalue =($("#layer5_layer1_lldpe_rate").html()* layer5_layer1_lldweight) ;
				var layer5_layer1_hdvalue = ($("#layer5_layer1_hdpe_rate").html()* layer5_layer1_hdweight) ;	

				var layer5_layer2_admervalue = ($("#layer5_layer2_admer_rate").html()* layer5_layer2_admerweight) ;
				var layer5_layer3_evohvalue = ($("#layer5_layer3_evoh_rate").html()* layer5_layer3_evohweight) ;
				var layer5_layer4_admervalue = ($("#layer5_layer4_admer_rate").html()* layer5_layer4_admerweight) ;

				var layer5_layer5_ldvalue = ($("#layer5_layer5_ldpe_rate").html()* layer5_layer5_ldweight) ;
				var layer5_layer5_lldvalue =($("#layer5_layer5_lldpe_rate").html()*layer5_layer5_lldweight) ;
				var layer5_layer5_hdvalue = ($("#layer5_layer5_hdpe_rate").html()* layer5_layer5_hdweight) ;
				//alert(layer5_layer5_lldvalue);			

				var layer5_layer1_ldcost_per_tube = 	(layer5_layer1_ldvalue / parseInt($('#layer5_quantity').val()));	
				var layer5_layer1_lldcost_per_tube =   (layer5_layer1_lldvalue /parseInt($('#layer5_quantity').val()));
				var layer5_layer1_hdcost_per_tube = 	(layer5_layer1_hdvalue / parseInt($('#layer5_quantity').val()));

				var layer5_layer2_admercost_per_tube = (layer5_layer2_admervalue / parseInt($('#layer5_quantity').val()));
				var layer5_layer3_evohcost_per_tube = (layer5_layer3_evohvalue / parseInt($('#layer5_quantity').val()));
				var layer5_layer4_admercost_per_tube = (layer5_layer4_admervalue / parseInt($('#layer5_quantity').val()));

				var layer5_layer5_ldcost_per_tube = 	(layer5_layer5_ldvalue / parseInt($('#layer5_quantity').val()));	
				var layer5_layer5_lldcost_per_tube = 	(layer5_layer5_lldvalue / parseInt($('#layer5_quantity').val()));
				var layer5_layer5_hdcost_per_tube = 	(layer5_layer5_hdvalue / parseInt($('#layer5_quantity').val()));
				//alert(layer5_layer5_lldcost_per_tube);	

				var layer5_sleeve_cost = (layer5_layer1_ldcost_per_tube + layer5_layer1_lldcost_per_tube + layer5_layer1_hdcost_per_tube + layer5_layer2_admercost_per_tube + layer5_layer3_evohcost_per_tube + layer5_layer4_admercost_per_tube + layer5_layer5_ldcost_per_tube + layer5_layer5_lldcost_per_tube + layer5_layer5_hdcost_per_tube);
				//alert(layer5_sleeve_cost);

				$('#layer5_sleeve_cost').html(layer5_sleeve_cost.toFixed(2));
				
			}
		});
//-------------------------------------LAYER 7 RM -----------------------
		$("#layer7_layer1_sl_ldpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer1_sl_ldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer1_ldpe_rate").html(html);

		   	 } 
		    	});
  		 });
		$("#layer7_layer1_sl_lldpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer1_sl_lldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer1_lldpe_rate").html(html);

		   	 } 
		    	});
  		 });	

		$("#layer7_layer1_sl_hdpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer1_sl_hdpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer1_hdpe_rate").html(html);

		   	 } 
		    	});
  		 });

		$("#layer7_layer2_sl_ldpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer2_sl_ldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer2_ldpe_rate").html(html);

		   	 } 
		    	});
  		 });
		$("#layer7_layer2_sl_lldpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer2_sl_lldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer2_lldpe_rate").html(html);

		   	 } 
		    	});
  		 });	

		$("#layer7_layer2_sl_hdpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer2_sl_hdpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer2_hdpe_rate").html(html);

		   	 } 
		    	});
  		 });

		$("#layer7_layer3_admer").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer3_admer').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer3_admer_rate").html(html);

		   	 } 
		    	});
  		 });

		$("#layer7_layer4_evoh").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer4_evoh').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer4_evoh_rate").html(html);

		   	 } 
		    	});
  		 });

		$("#layer7_layer5_admer").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer5_admer').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer5_admer_rate").html(html);

		   	 } 
		    	});
  		 });

		$("#layer7_layer6_sl_ldpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer6_sl_ldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer6_ldpe_rate").html(html);

		   	 } 
		    	});
  		 });
		$("#layer7_layer6_sl_lldpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer6_sl_lldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer6_lldpe_rate").html(html);

		   	 } 
		    	});
  		 });	

		$("#layer7_layer6_sl_hdpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer6_sl_hdpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer6_hdpe_rate").html(html);

		   	 } 
		    	});
  		 });

		$("#layer7_layer7_sl_ldpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer7_sl_ldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer7_ldpe_rate").html(html);

		   	 } 
		    	});
  		 });
		$("#layer7_layer7_sl_lldpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer7_sl_lldpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer7_lldpe_rate").html(html);

		   	 } 
		    	});
  		 });	

		$("#layer7_layer7_sl_hdpe").change(function(event) {

			$("#loading").show();
	   	$("#cover").show();
	   	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
	   	$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#layer7_layer7_sl_hdpe').val()},cache: false,success: function(html){
	        	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
	       	$("#layer7_layer7_hdpe_rate").html(html);

		   	 } 
		    	});
  		 });


		//--------check button-----------
		$("#layer7_sleevecost").click(function(event) {

			if($('#sleeve_dia').val()=="" || $('#sleeve_length').val()==""){
				alert("Please enter the Diameter,Length");
			}/*else if($('#layer5_layer1_micron').val()=="" || $('#layer5_layer2_micron').val()=="" || $('#layer5_layer3_micron').val()=="" || $('#layer5_layer4_micron').val()=="" || $('#layer5_layer5_micron').val()=="" ||  $('#layer5_layer1_ld_percentage').val()=="" || $('#layer5_layer1_lld_percentage').val()=="" ||  $('#layer5_layer1_hd_percentage').val()=="" || $('#layer5_layer2_admer_percentage').val()=="" || $('#layer5_layer3_evoh_percentage').val()=="" ||  $('#layer5_layer4_admer_percentage').val()=="" || $('#layer5_layer5_ld_percentage').val()=="" || $('#layer5_layer5_lld_percentage').val()=="" || $('#layer5_layer5_hd_percentage').val()=="" || $('#layer5_layer1_sl_ldpe').val()=="" || $('#layer5_layer1_sl_lldpe').val()=="" || $('#layer5_layer2_admer').val()=="" || $('#layer5_layer3_evoh').val()=="" || $('#layer5_layer4_admer').val()=="" || $('#layer5_layer5_sl_ldpe').val()=="" || $('#layer5_layer5_sl_lldpe').val()=="" ){
				alert("Please enter Micron , % , RM ");
			}*/else{
				var check = parseInt($("#layer3_layer1_ld_percentage").val()) + parseInt($("#layer3_layer1_lld_percentage").val()) +  parseInt($("#layer3_layer1_hd_percentage").val()) ;
				//alert(check);

				var layer7_layer1_sleeveweight= (((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer7_layer1_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseInt($('#layer7_quantity').val()))+ ((((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer7_layer1_micron').val()) * 3.14 * 0.92/1000000)/1000)* parseInt($('#layer7_quantity').val()))*parseInt($('#layer7_rejection').val()))/100 ;

				var layer7_layer2_sleeveweight= (((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer7_layer2_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseInt($('#layer7_quantity').val()))+ ((((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer7_layer2_micron').val()) * 3.14 * 0.92/1000000)/1000)* parseInt($('#layer7_quantity').val()))*parseInt($('#layer7_rejection').val()))/100 ;

				var layer7_layer3_sleeveweight= (((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer7_layer3_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseInt($('#layer7_quantity').val()))+ ((((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer7_layer3_micron').val()) * 3.14 * 0.92/1000000)/1000)* parseInt($('#layer7_quantity').val()))*parseInt($('#layer7_rejection').val()))/100 ;

				var layer7_layer4_sleeveweight= (((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer7_layer4_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseInt($('#layer7_quantity').val()))+ ((((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer7_layer4_micron').val()) * 3.14 * 0.92/1000000)/1000)* parseInt($('#layer7_quantity').val()))*parseInt($('#layer7_rejection').val()))/100 ;

				var layer7_layer5_sleeveweight= (((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer7_layer5_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseInt($('#layer7_quantity').val()))+ ((((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer7_layer5_micron').val()) * 3.14 * 0.92/1000000)/1000)* parseInt($('#layer7_quantity').val()))*parseInt($('#layer7_rejection').val()))/100 ;

				var layer7_layer6_sleeveweight= (((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer7_layer6_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseInt($('#layer7_quantity').val()))+ ((((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer7_layer6_micron').val()) * 3.14 * 0.92/1000000)/1000)* parseInt($('#layer7_quantity').val()))*parseInt($('#layer7_rejection').val()))/100 ;

				var layer7_layer7_sleeveweight= (((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer7_layer7_micron').val()) * 3.14 * 0.92/1000000)/1000)*parseInt($('#layer7_quantity').val()))+ ((((parseInt($('#sleeve_dia').val()) * parseInt($('#sleeve_length').val()) * parseInt($('#layer7_layer7_micron').val()) * 3.14 * 0.92/1000000)/1000)* parseInt($('#layer7_quantity').val()))*parseInt($('#layer7_rejection').val()))/100 ;

				//alert(layer7_layer7_sleeveweight);

				var layer7_layer1_ldweight = (layer7_layer1_sleeveweight * parseInt($('#layer7_layer1_ld_percentage').val())) / 100 ;
				var layer7_layer1_lldweight =(layer7_layer1_sleeveweight * parseInt($('#layer7_layer1_lld_percentage').val())) / 100 ;
				var layer7_layer1_hdweight = (layer7_layer1_sleeveweight * parseInt($('#layer7_layer1_hd_percentage').val())) / 100 ;

				var layer7_layer2_ldweight = (layer7_layer2_sleeveweight * parseInt($('#layer7_layer2_ld_percentage').val())) / 100 ;
				var layer7_layer2_lldweight =(layer7_layer2_sleeveweight * parseInt($('#layer7_layer2_lld_percentage').val())) / 100 ;
				var layer7_layer2_hdweight = (layer7_layer2_sleeveweight * parseInt($('#layer7_layer2_hd_percentage').val())) / 100 ;
			
				var layer7_layer3_admerweight =(layer7_layer3_sleeveweight * parseInt($('#layer7_layer3_admer_percentage').val())) / 100 ;

				var layer7_layer4_evohweight = (layer7_layer4_sleeveweight * parseInt($('#layer7_layer4_evoh_percentage').val())) / 100 ;

				var layer7_layer5_admerweight =(layer7_layer5_sleeveweight * parseInt($('#layer7_layer5_admer_percentage').val())) / 100 ;
				
				var layer7_layer6_ldweight = (layer7_layer6_sleeveweight * parseInt($('#layer7_layer6_ld_percentage').val())) / 100 ;
				var layer7_layer6_lldweight =(layer7_layer6_sleeveweight * parseInt($('#layer7_layer6_lld_percentage').val())) / 100 ;
				var layer7_layer6_hdweight = (layer7_layer6_sleeveweight * parseInt($('#layer7_layer6_hd_percentage').val())) / 100 ;

				var layer7_layer7_ldweight = (layer7_layer7_sleeveweight * parseInt($('#layer7_layer7_ld_percentage').val())) / 100 ;
				var layer7_layer7_lldweight =(layer7_layer7_sleeveweight * parseInt($('#layer7_layer7_lld_percentage').val())) / 100 ;
				var layer7_layer7_hdweight = (layer7_layer7_sleeveweight * parseInt($('#layer7_layer7_hd_percentage').val())) / 100 ;

				//alert(layer7_layer7_hdweight);	

				var layer7_layer1_ldvalue = ($("#layer7_layer1_ldpe_rate").html()* layer7_layer1_ldweight) ;
				var layer7_layer1_lldvalue =($("#layer7_layer1_lldpe_rate").html()* layer7_layer1_lldweight) ;
				var layer7_layer1_hdvalue = ($("#layer7_layer1_hdpe_rate").html()* layer7_layer1_hdweight) ;	

				var layer7_layer2_ldvalue = ($("#layer7_layer2_ldpe_rate").html()* layer7_layer2_ldweight) ;
				var layer7_layer2_lldvalue =($("#layer7_layer2_lldpe_rate").html()* layer7_layer2_lldweight) ;
				var layer7_layer2_hdvalue = ($("#layer7_layer2_hdpe_rate").html()* layer7_layer2_hdweight) ;	

				var layer7_layer3_admervalue = ($("#layer7_layer3_admer_rate").html()* layer7_layer3_admerweight) ;
				var layer7_layer4_evohvalue = ($("#layer7_layer4_evoh_rate").html()* layer7_layer4_evohweight) ;
				var layer7_layer5_admervalue = ($("#layer7_layer5_admer_rate").html()* layer7_layer5_admerweight) ;

				var layer7_layer6_ldvalue = ($("#layer7_layer6_ldpe_rate").html()* layer7_layer6_ldweight) ;
				var layer7_layer6_lldvalue =($("#layer7_layer6_lldpe_rate").html()*layer7_layer6_lldweight) ;
				var layer7_layer6_hdvalue = ($("#layer7_layer6_hdpe_rate").html()* layer7_layer6_hdweight) ;

				var layer7_layer7_ldvalue = ($("#layer7_layer7_ldpe_rate").html()* layer7_layer7_ldweight) ;
				var layer7_layer7_lldvalue =($("#layer7_layer7_lldpe_rate").html()*layer7_layer7_lldweight) ;
				var layer7_layer7_hdvalue = ($("#layer7_layer7_hdpe_rate").html()* layer7_layer7_hdweight) ;
						
				//alert(layer7_layer7_hdvalue);

				var layer7_layer1_ldcost_per_tube = 	(layer7_layer1_ldvalue / parseInt($('#layer7_quantity').val()));	
				var layer7_layer1_lldcost_per_tube =   (layer7_layer1_lldvalue /parseInt($('#layer7_quantity').val()));
				var layer7_layer1_hdcost_per_tube = 	(layer7_layer1_hdvalue / parseInt($('#layer7_quantity').val()));

				var layer7_layer2_ldcost_per_tube = 	(layer7_layer2_ldvalue / parseInt($('#layer7_quantity').val()));	
				var layer7_layer2_lldcost_per_tube =   (layer7_layer2_lldvalue /parseInt($('#layer7_quantity').val()));
				var layer7_layer2_hdcost_per_tube = 	(layer7_layer2_hdvalue / parseInt($('#layer7_quantity').val()));

				var layer7_layer3_admercost_per_tube = (layer7_layer3_admervalue / parseInt($('#layer7_quantity').val()));
				var layer7_layer4_evohcost_per_tube = (layer7_layer4_evohvalue / parseInt($('#layer7_quantity').val()));
				var layer7_layer5_admercost_per_tube = (layer7_layer5_admervalue / parseInt($('#layer7_quantity').val()));

				var layer7_layer6_ldcost_per_tube = 	(layer7_layer6_ldvalue / parseInt($('#layer7_quantity').val()));	
				var layer7_layer6_lldcost_per_tube = 	(layer7_layer6_lldvalue / parseInt($('#layer7_quantity').val()));
				var layer7_layer6_hdcost_per_tube = 	(layer7_layer6_hdvalue / parseInt($('#layer7_quantity').val()));

				var layer7_layer7_ldcost_per_tube = 	(layer7_layer7_ldvalue / parseInt($('#layer7_quantity').val()));	
				var layer7_layer7_lldcost_per_tube = 	(layer7_layer7_lldvalue / parseInt($('#layer7_quantity').val()));
				var layer7_layer7_hdcost_per_tube = 	(layer7_layer7_hdvalue / parseInt($('#layer7_quantity').val()));
				//alert(layer5_layer5_lldcost_per_tube);	

				var layer7_sleeve_cost = (layer7_layer1_ldcost_per_tube + layer7_layer1_lldcost_per_tube + layer7_layer1_hdcost_per_tube + layer7_layer2_ldcost_per_tube + layer7_layer2_lldcost_per_tube + layer7_layer2_hdcost_per_tube +layer7_layer3_admercost_per_tube + layer7_layer4_evohcost_per_tube + layer7_layer5_admercost_per_tube + layer7_layer6_ldcost_per_tube + layer7_layer6_lldcost_per_tube + layer7_layer6_hdcost_per_tube + layer7_layer7_ldcost_per_tube + layer7_layer7_lldcost_per_tube + layer7_layer7_hdcost_per_tube);
				//alert(layer7_sleeve_cost);

				$('#layer7_sleeve_cost').html(layer7_sleeve_cost.toFixed(2));
				
			}
		});

	//-----------------------------Shoulder rate-----------
	$("#sh_hdpe_one").change(function(event) {

      $("#loading").show();
      $("#cover").show();
      $('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
      $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#sh_hdpe_one').val()},cache: false,success: function(html){
            setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
          $("#sh_hdpe_one_rate").html(html);

         } 
         });
   });

   $("#sh_hdpe_two").change(function(event) {

      $("#loading").show();
      $("#cover").show();
      $('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
      $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#sh_hdpe_two').val()},cache: false,success: function(html){
            setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
          $("#sh_hdpe_two_rate").html(html);

         } 
         });
   });

	$("#shoulder_mb").change(function(event) {

      $("#loading").show();
      $("#cover").show();
      $('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
      $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_rm_rate",data: {rm:$('#shoulder_mb').val()},cache: false,success: function(html){
            setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
          $("#shoulder_mb_rate").html(html);

         } 
         });
   });
	//--------------------------Shoulder Check button--------------------

	$("#shouldercost").click(function(event) {

		var std_sh_rejection = parseInt($("#std_sh_rejection").val());

      if($('#sleeve_dia').val()=="" || $('#Shoulder').val()==""){
        alert("Please enter the Diameter,Shoulder");
      }else if($('#hdpe_m').val()=="" || $('#hdpe_f').val()=="" || $('#sh_hdpe_one').val()=="" || $('#sh_hdpe_two').val()==""){
        alert("Please enter % , RM ");
      }else if(parseInt($("#hdpe_m").val()) + parseInt($("#hdpe_f").val())!== 100 ){
        alert(" % of HDPE1 and HDPE2 should be 100");
      }else if($('#shoulder_mb').val()=="" && $('#shoulder_mb1').val()==""){
        alert("Please Enter MB ");
      }else if( parseInt($("#sh_rejection").val())< std_sh_rejection ){
        alert(" Rejection % should be greater than 1");
      }else{
        
        $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/get_shoulder_weight",data: {sleeve_id:$('#sleeve_dia').val(),shld_type_id:$('#shoulder').val(),shld_orifice_id:$('#shoulder_orifice').val()},cache: false,success: function(html){
            setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
          $("#shoulder_weight").html(html);

			//alert(html);  

			 var hdpe1 = ((parseInt($("#hdpe_m").val())) / 100 )* html;
          var hdpe2 = ((parseInt($("#hdpe_f").val())) / 100 )* html;       
          var shoulder_mb = ((parseInt($("#shoulder_mb_percentage").val())) / 100 )* html;
          var shoulder_mb1 = ((parseInt($("#shoulder_mb_percentage1").val())) / 100 )* html;
          //alert(shoulder_mb);
          //alert(shoulder_mb1);

      	 var kgs1 = (hdpe1 / 1000)* (parseInt($("#sh_quantity").val())) ;
      	 var kgs2 = (hdpe2 / 1000)* (parseInt($("#sh_quantity").val())) ;

      	 var kgs3 = (shoulder_mb / 1000)* (parseInt($("#sh_quantity").val())) ;
      	 var kgs4 = (shoulder_mb1 / 1000)* (parseInt($("#sh_quantity").val())) ;
 			 //alert(kgs3);
 			 //alert(kgs4);

 			 var value1 = (kgs1 * $("#sh_hdpe_one_rate").html())  ;
 			 var value2 = (kgs2 * $("#sh_hdpe_two_rate").html())  ;
 			 var value3 = (kgs3 * $("#shoulder_mb_rate").html())  ;
 			 var value4 = (kgs4 * (parseInt($("#shoulder_mb1_rate").val())) ) ;

      	 var shoulder_cost = ((value1 + value2 + value3 + value4 )/ (parseInt($("#sh_quantity").val())) );
         // alert(shoulder_cost);
        $('#shoulder_cost').val(shoulder_cost.toFixed(2));
        $('#shoulder_cost_view').html(shoulder_cost.toFixed(2));

         } 
         });      
      
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


<div id="layer1" class="modal" style="display:none;">
  <div class="modal-content">

    <span class="close">&times;</span>
    
		<table class="ui celled structured table">
			<thead>
			<tr>
				<th>LAYER</th><th>RM </th><th>RATE/KG </th><th>Micron</th><th>%</th>
				
			</tr>
		</thead>
		<tbody>
			<tr>
				<td rowspan="5">LAYER 1</td>

				<td> LD : <select name="sl_ldpe" id="sl_ldpe">
										<option value=''>--Select LDPE--</option>
										<?php
										foreach ($ldpe as $ldpe_row) {
											echo "<option value='".$ldpe_row->article_no."' ".set_select('sl_ldpe',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
										}
										?>
										</select>
				
				</td>
				<td><span id="layer1_ldpe_rate"></span></td>
				<td rowspan="5"><input type="text" style="width: 7em;" name="micron" id="micron" class="number3" value="<?php echo set_value('micron');?>"  />
				</td>
				<td><input type="number" name="layer1_ld_percentage" id="layer1_ld_percentage" placeholder="%" class="number3"  min="0" max="100" value="<?php echo set_value('layer1_ld_percentage','70');?>" />
				</td>			
			</tr>
			<tr>				
				<td> LLD : <select name="sl_lldpe" id="sl_lldpe">
										<option value=''>--Select LLDPE--</option>
										<?php
										foreach ($lldpe as $lldpe_row) {
											echo "<option value='".$lldpe_row->article_no."' ".set_select('sl_lldpe',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
										}
										?>
										</select>

				</td>
				<td><span id="layer1_lldpe_rate"></span></td>		
				<td ><input type="number" size="3" name="layer1_lld_percentage" id="layer1_lld_percentage" placeholder="%" maxlength="3" id="" min="0" max="100" value="<?php echo set_value('layer1_lld_percentage','30');?>" />
				</td>			
			</tr>

			<tr>
				<td> HD : <select name="sl_hdpe" id="sl_hdpe">
										<option value=''>--Select HDPE--</option>
										<?php
										foreach ($hdpe as $hdpe_row) {
											echo "<option value='".$hdpe_row->article_no."' ".set_select('sl_hdpe',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
										}
										?>
										</select>

				</td>
				<td><span id="layer1_hdpe_rate"></span></td>	
				<td ><input type="number" size="3" name="layer1_hd_percentage" id="layer1_hd_percentage" placeholder="%" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('layer1_hd_percentage','0');?>" />
				</td>			
			</tr>

			<tr>
				<td> MB : <select name="sl_masterbatch" id="sl_masterbatch" required><option value=''>--Select MB--</option>
										<?php foreach ($masterbatch as $masterbatch_row) {
											echo "<option value='".$masterbatch_row->article_no."' ".set_select('sl_masterbatch',$masterbatch_row->article_no).">".$masterbatch_row->lang_article_description."</option>";
										}?></select>

				</td>
				<td><span id="layer1_mb_rate"></span></td>	
				<td ><input type="number" size="3" name="layer1_mb_percentage" id="layer1_mb_percentage" placeholder="%" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('layer1_mb_percentage','0');?>" />
				</td>			
			</tr>

			<tr>
				<td> MB : <input type="text" size="25" name="layer1_mb1" id="layer1_mb1" placeholder="If MB is not in system"value="<?php echo set_value('layer1_mb1');?>" />

				</td>
				<td>  <input type="text" size="5" name="layer1_mb1_rate" id="layer1_mb1_rate" value="<?php echo set_value('layer1_mb1_rate');?>" />  </td>	
				<td ><input type="number" size="3" name="layer1_mb_percentage1" id="layer1_mb_percentage1" placeholder="%" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('layer1_mb_percentage1','0');?>" />
				</td>			
			</tr>

			<tr>
				<td colspan="4">Quantity</td>

				
				<td> <input type="number" size="3" name="quantity" id="quantity" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('quantity','1');?>" />	</td>			
			</tr>

			<tr>
				<td colspan="4">Standard Waste %</td>
					<?php 
					foreach($workprocedure_types_master as $workprocedure_types_master){
                      $rejection=$this->common_model->read_number($workprocedure_types_master->rejection_perc,$this->session->userdata['logged_in']['company_id']);
                    }

              	?>
				<td><input type="number" size="3" name="rejection" id="rejection" placeholder="%" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('rejection',$rejection);?>" />
					<input type="hidden" id="std_rejection" value="<?php echo set_value('rejection',$rejection);?>" /></td>		
			</tr>

			<tr>
				<td colspan="4"><button id="layer1_sleevecost"> Calculate Sleeve Cost </button></td>

				<td><input  readonly="readonly" type="number" size="3" id="sleeve_cost" maxlength="3" min="0" max="100"  />	
				</td>

			</tr>
			


			</tbody>
		</table>
		
  </div>
</div>
<!--------------------------------------------------Layer 2 --------------------------------->
<div id="layer2" class="modal" style="display:none;">
  <div class="modal-content">

    <span class="close">&times;</span>
    	
    	<table class="ui celled structured table">
			<thead>
			<tr>
				<th>LAYER</th><th>RM </th><th>RATE </th><th>Micron</th><th>%</th>
				
			</tr>
		</thead>
		<tbody>
			<tr>
				<td rowspan="3">LAYER 1</td>

				<td> LD : <select name="layer2_layer1_sl_ldpe" id="layer2_layer1_sl_ldpe">
										<option value=''>--Select LDPE--</option>
										<?php
										foreach ($ldpe as $ldpe_row) {
											echo "<option value='".$ldpe_row->article_no."' ".set_select('sl_ldpe',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
										}
										?>
										</select>
				
				</td>
				<td><span id="layer2_layer1_ldpe_rate"></span></td>
				<td rowspan="3"><input type="text" style="width: 7em;" name="layer2_layer1_micron" id="layer2_layer1_micron" class="number3" value="<?php echo set_value('layer2_layer1_micron');?>"  />
				</td>
				<td><input type="number" name="layer2_layer1_ld_percentage" id="layer2_layer1_ld_percentage" placeholder="%" class="number3"  min="0" max="100" value="<?php echo set_value('layer2_layer1_ld_percentage');?>" />
				</td>			
			</tr>
			<tr>				
				<td> LLD : <select name="layer2_layer1_sl_lldpe" id="layer2_layer1_sl_lldpe">
										<option value=''>--Select LLDPE--</option>
										<?php
										foreach ($lldpe as $lldpe_row) {
											echo "<option value='".$lldpe_row->article_no."' ".set_select('sl_lldpe',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
										}
										?>
										</select>

				</td>
				<td><span id="layer2_layer1_lldpe_rate"></span></td>		
				<td ><input type="number" size="3" name="layer2_layer1_lld_percentage" id="layer2_layer1_lld_percentage" placeholder="%" maxlength="3" id="" min="0" max="100" value="<?php echo set_value('layer2_layer1_lld_percentage');?>" />
				</td>			
			</tr>

			<tr>
				<td> HD : <select name="layer2_layer1_sl_hdpe" id="layer2_layer1_sl_hdpe">
										<option value=''>--Select HDPE--</option>
										<?php
										foreach ($hdpe as $hdpe_row) {
											echo "<option value='".$hdpe_row->article_no."' ".set_select('sl_hdpe',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
										}
										?>
										</select>

				</td>
				<td><span id="layer2_layer1_hdpe_rate"></span></td>	
				<td ><input type="number" size="3" name="layer2_layer1_hd_percentage" id="layer2_layer1_hd_percentage" placeholder="%" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('layer2_layer1_hd_percentage');?>" />
				</td>			
			</tr>

			<tr>
				<td rowspan="3">LAYER 2</td>

				<td> LD : <select name="layer2_layer2_sl_ldpe" id="layer2_layer2_sl_ldpe">
										<option value=''>--Select LDPE--</option>
										<?php
										foreach ($ldpe as $ldpe_row) {
											echo "<option value='".$ldpe_row->article_no."' ".set_select('sl_ldpe',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
										}
										?>
										</select>
				
				</td>
				<td><span id="layer2_layer2_ldpe_rate"></span></td>
				<td rowspan="3"><input type="text" style="width: 7em;" name="layer2_layer2_micron" id="layer2_layer2_micron" class="number3" value="<?php echo set_value('layer2_layer2_micron');?>"  />
				</td>
				<td><input type="number" name="layer2_layer2_ld_percentage" id="layer2_layer2_ld_percentage" placeholder="%" class="number3"  min="0" max="100" value="<?php echo set_value('layer2_layer2_ld_percentage');?>" />
				</td>			
			</tr>
			<tr>				
				<td> LLD : <select name="layer2_layer2_sl_lldpe" id="layer2_layer2_sl_lldpe">
										<option value=''>--Select LLDPE--</option>
										<?php
										foreach ($lldpe as $lldpe_row) {
											echo "<option value='".$lldpe_row->article_no."' ".set_select('sl_lldpe',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
										}
										?>
										</select>

				</td>
				<td><span id="layer2_layer2_lldpe_rate"></span></td>		
				<td ><input type="number" size="3" name="layer2_layer2_lld_percentage" id="layer2_layer2_lld_percentage" placeholder="%" maxlength="3" id="" min="0" max="100" value="<?php echo set_value('layer2_layer2_lld_percentage');?>" />
				</td>			
			</tr>

			<tr>
				<td> HD : <select name="layer2_layer2_sl_hdpe" id="layer2_layer2_sl_hdpe">
										<option value=''>--Select HDPE--</option>
										<?php
										foreach ($hdpe as $hdpe_row) {
											echo "<option value='".$hdpe_row->article_no."' ".set_select('sl_hdpe',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
										}
										?>
										</select>

				</td>
				<td><span id="layer2_layer2_hdpe_rate"></span></td>	
				<td ><input type="number" size="3" name="layer2_layer2_hd_percentage" id="layer2_layer2_hd_percentage" placeholder="%" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('layer2_layer2_hd_percentage');?>" />
				</td>			
			</tr>

			<tr>
				<td colspan="4">Quantity</td>

				
				<td> <input type="number" size="3" name="layer2_quantity" id="layer2_quantity" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('layer2_quantity');?>" />	</td>			
			</tr>

			<tr>
				<td colspan="4">Rejection</td>

				
				<td> <input type="number" size="3" name="layer2_rejection" id="layer2_rejection" placeholder="%" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('layer2_rejection');?>" />	</td>			
			</tr>

			<tr>
				<td colspan="4"><button id="layer2_sleevecost"> Check </button></td>

				<td><b><span style="color:red;" id="layer2_sleeve_cost"></span></b></td>

			</tr>
			</tbody>
		</table>
    
  </div>
</div>
<!--------------------------------------------------Layer 3 --------------------------------->
<div id="layer3" class="modal" style="display:none;">
  <div class="modal-content">
    <span class="close">&times;</span>
    
    <table class="ui celled structured table">
			<thead>
			<tr>
				<th>LAYER</th><th>RM </th><th>RATE </th><th>Micron</th><th>%</th>
				
			</tr>
		</thead>
		<tbody>
			<tr>
				<td rowspan="3">LAYER 1</td>

				<td> LD : <select name="layer3_layer1_sl_ldpe" id="layer3_layer1_sl_ldpe">
										<option value=''>--Select LDPE--</option>
										<?php
										foreach ($ldpe as $ldpe_row) {
											echo "<option value='".$ldpe_row->article_no."' ".set_select('sl_ldpe',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
										}
										?>
										</select>
				
				</td>
				<td><span id="layer3_layer1_ldpe_rate"></span></td>
				<td rowspan="3"><input type="text" style="width: 7em;" name="layer3_layer1_micron" id="layer3_layer1_micron" class="number3" value="<?php echo set_value('layer3_layer1_micron');?>"  />
				</td>
				<td><input type="number" name="layer3_layer1_ld_percentage" id="layer3_layer1_ld_percentage" placeholder="%" class="number3"  min="0" max="100" value="<?php echo set_value('layer3_layer1_ld_percentage');?>" />
				</td>			
			</tr>
			<tr>				
				<td> LLD : <select name="layer3_layer1_sl_lldpe" id="layer3_layer1_sl_lldpe">
										<option value=''>--Select LLDPE--</option>
										<?php
										foreach ($lldpe as $lldpe_row) {
											echo "<option value='".$lldpe_row->article_no."' ".set_select('sl_lldpe',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
										}
										?>
										</select>

				</td>
				<td><span id="layer3_layer1_lldpe_rate"></span></td>		
				<td ><input type="number" size="3" name="layer3_layer1_lld_percentage" id="layer3_layer1_lld_percentage" placeholder="%" maxlength="3" id="" min="0" max="100" value="<?php echo set_value('layer3_layer1_lld_percentage');?>" />
				</td>			
			</tr>

			<tr>
				<td> HD : <select name="layer3_layer1_sl_hdpe" id="layer3_layer1_sl_hdpe">
										<option value=''>--Select HDPE--</option>
										<?php
										foreach ($hdpe as $hdpe_row) {
											echo "<option value='".$hdpe_row->article_no."' ".set_select('sl_hdpe',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
										}
										?>
										</select>

				</td>
				<td><span id="layer3_layer1_hdpe_rate"></span></td>	
				<td ><input type="number" size="3" name="layer3_layer1_hd_percentage" id="layer3_layer1_hd_percentage" placeholder="%" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('layer3_layer1_hd_percentage');?>" />
				</td>			
			</tr>

			<tr>
				<td rowspan="3">LAYER 2</td>

				<td rowspan="3"> HD : <select name="layer3_layer2_sl_hdpe" id="layer3_layer2_sl_hdpe">
										<option value=''>--Select HDPE--</option>
										<?php
										foreach ($hdpe as $hdpe_row) {
											echo "<option value='".$hdpe_row->article_no."' ".set_select('sl_hdpe',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
										}
										?>
										</select>

				</td>
				<td rowspan="3"><span id="layer3_layer2_hdpe_rate"></span></td>
				<td rowspan="3"><input type="text" style="width: 7em;" name="layer3_layer2_micron" id="layer3_layer2_micron" class="number3" value="<?php echo set_value('layer3_layer2_micron');?>"  />
				</td>
				<td rowspan="3"><input type="number" name="layer3_layer2_hd_percentage" id="layer3_layer2_hd_percentage" placeholder="%" class="number3"  min="0" max="100" value="<?php echo set_value('layer3_layer2_hd_percentage');?>" />
				</td>			
			</tr>
			<tr></tr>

			<tr></tr>


			<tr>
				<td rowspan="3">LAYER 3</td>

				<td> LD : <select name="layer3_layer3_sl_ldpe" id="layer3_layer3_sl_ldpe">
										<option value=''>--Select LDPE--</option>
										<?php
										foreach ($ldpe as $ldpe_row) {
											echo "<option value='".$ldpe_row->article_no."' ".set_select('sl_ldpe',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
										}
										?>
										</select>
				
				</td>
				<td><span id="layer3_layer3_ldpe_rate"></span></td>
				<td rowspan="3"><input type="text" style="width: 7em;" name="layer3_layer3_micron" id="layer3_layer3_micron" class="number3" value="<?php echo set_value('layer3_layer3_micron');?>"  />
				</td>
				<td><input type="number" name="layer3_layer3_ld_percentage" id="layer3_layer3_ld_percentage" placeholder="%" class="number3"  min="0" max="100" value="<?php echo set_value('layer3_layer3_ld_percentage');?>" />
				</td>			
			</tr>
			<tr>				
				<td> LLD : <select name="layer3_layer3_sl_lldpe" id="layer3_layer3_sl_lldpe">
										<option value=''>--Select LLDPE--</option>
										<?php
										foreach ($lldpe as $lldpe_row) {
											echo "<option value='".$lldpe_row->article_no."' ".set_select('sl_lldpe',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
										}
										?>
										</select>

				</td>
				<td><span id="layer3_layer3_lldpe_rate"></span></td>		
				<td ><input type="number" size="3" name="layer3_layer3_lld_percentage" id="layer3_layer3_lld_percentage" placeholder="%" maxlength="3" id="" min="0" max="100" value="<?php echo set_value('layer3_layer3_lld_percentage');?>" />
				</td>			
			</tr>

			<tr>
				<td> HD : <select name="layer3_layer3_sl_hdpe" id="layer3_layer3_sl_hdpe">
										<option value=''>--Select HDPE--</option>
										<?php
										foreach ($hdpe as $hdpe_row) {
											echo "<option value='".$hdpe_row->article_no."' ".set_select('sl_hdpe',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
										}
										?>
										</select>

				</td>
				<td><span id="layer3_layer3_hdpe_rate"></span></td>	
				<td ><input type="number" size="3" name="layer3_layer3_hd_percentage" id="layer3_layer3_hd_percentage" placeholder="%" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('layer3_layer3_hd_percentage');?>" />
				</td>			
			</tr>

			<tr>
				<td colspan="4">Quantity</td>

				
				<td> <input type="number" size="3" name="layer3_quantity" id="layer3_quantity" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('layer3_quantity');?>" />	</td>			
			</tr>

			<tr>
				<td colspan="4">Rejection</td>

				
				<td> <input type="number" size="3" name="layer3_rejection" id="layer3_rejection" placeholder="%" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('layer3_rejection');?>" />	</td>			
			</tr>

			<tr>
				<td colspan="4"><button id="layer3_sleevecost"> Check </button></td>

				<td><b><span style="color:red;" id="layer3_sleeve_cost"></span></b></td>

			</tr>
			</tbody>
		</table>
    
  </div>
</div>
<!--------------------------------------------------Layer 5 --------------------------------->
<div id="layer5" class="modal" style="display:none;">
  <div class="modal-content">
    <span class="close">&times;</span>
    
    <table class="ui celled structured table">
			<thead>
			<tr>
				<th>LAYER</th><th>RM </th><th>RATE </th><th>Micron</th><th>%</th>
				
			</tr>
		</thead>
		<tbody>
			<tr>
				<td rowspan="3">LAYER 1</td>

				<td> LD : <select name="layer5_layer1_sl_ldpe" id="layer5_layer1_sl_ldpe">
										<option value=''>--Select LDPE--</option>
										<?php
										foreach ($ldpe as $ldpe_row) {
											echo "<option value='".$ldpe_row->article_no."' ".set_select('sl_ldpe',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
										}
										?>
										</select>
				
				</td>
				<td><span id="layer5_layer1_ldpe_rate"></span></td>
				<td rowspan="3"><input type="text" style="width: 7em;" name="layer5_layer1_micron" id="layer5_layer1_micron" class="number3" value="<?php echo set_value('layer5_layer1_micron');?>"  />
				</td>
				<td><input type="number" name="layer5_layer1_ld_percentage" id="layer5_layer1_ld_percentage" placeholder="%" class="number3"  min="0" max="100" value="<?php echo set_value('layer5_layer1_ld_percentage');?>" />
				</td>			
			</tr>
			<tr>				
				<td> LLD : <select name="layer5_layer1_sl_lldpe" id="layer5_layer1_sl_lldpe">
										<option value=''>--Select LLDPE--</option>
										<?php
										foreach ($lldpe as $lldpe_row) {
											echo "<option value='".$lldpe_row->article_no."' ".set_select('sl_lldpe',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
										}
										?>
										</select>

				</td>
				<td><span id="layer5_layer1_lldpe_rate"></span></td>		
				<td ><input type="number" size="3" name="layer5_layer1_lld_percentage" id="layer5_layer1_lld_percentage" placeholder="%" maxlength="3" id="" min="0" max="100" value="<?php echo set_value('layer5_layer1_lld_percentage');?>" />
				</td>			
			</tr>

			<tr>
				<td> HD : <select name="layer5_layer1_sl_hdpe" id="layer5_layer1_sl_hdpe">
										<option value=''>--Select HDPE--</option>
										<?php
										foreach ($hdpe as $hdpe_row) {
											echo "<option value='".$hdpe_row->article_no."' ".set_select('sl_hdpe',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
										}
										?>
										</select>

				</td>
				<td><span id="layer5_layer1_hdpe_rate"></span></td>	
				<td ><input type="number" size="3" name="layer5_layer1_hd_percentage" id="layer5_layer1_hd_percentage" placeholder="%" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('layer5_layer1_hd_percentage');?>" />
				</td>			
			</tr>

			<tr>
				<td rowspan="3">LAYER 2</td>

				<td rowspan="3"> ADMER : <select name="layer5_layer2_admer" id="layer5_layer2_admer" required>
                              <option value=''>--Select Admer--</option>
                              <?php
                              foreach ($admer as $admer_row) {
                                 echo "<option value='".$admer_row->article_no."' ".set_select('sl_admer_two',$admer_row->article_no).">".$admer_row->lang_article_description."</option>";
                              }
                              ?>
                              </select>

				</td>
				<td rowspan="3"><span id="layer5_layer2_admer_rate"></span></td>
				<td rowspan="3"><input type="text" style="width: 7em;" name="layer5_layer2_micron" id="layer5_layer2_micron" class="number3" value="<?php echo set_value('layer5_layer2_micron');?>"  />
				</td>
				<td rowspan="3"><input type="number" name="layer5_layer2_admer_percentage" id="layer5_layer2_admer_percentage" placeholder="%" class="number3"  min="0" max="100" value="<?php echo set_value('layer5_layer2_admer_percentage');?>" />
				</td>			
			</tr>
			<tr></tr>

			<tr></tr>

			<tr>
				<td rowspan="3">LAYER 3</td>

				<td rowspan="3"> EVOH : <select name="layer5_layer3_evoh" id="layer5_layer3_evoh" required>
                              <option value=''>--Select Evoh--</option>
                              <?php
                              foreach ($evoh as $evoh_row) {
                                 echo "<option value='".$evoh_row->article_no."' ".set_select('sl_evoh_three',$evoh_row->article_no).">".$evoh_row->lang_article_description."</option>";
                              }
                              ?>
                              </select>

				</td>
				<td rowspan="3"><span id="layer5_layer3_evoh_rate"></span></td>
				<td rowspan="3"><input type="text" style="width: 7em;" name="layer5_layer3_micron" id="layer5_layer3_micron" class="number3" value="<?php echo set_value('layer5_layer3_micron');?>"  />
				</td>
				<td rowspan="3"><input type="number" name="layer5_layer3_evoh_percentage" id="layer5_layer3_evoh_percentage" placeholder="%" class="number3"  min="0" max="100" value="<?php echo set_value('layer5_layer3_evoh_percentage');?>" />
				</td>			
			</tr>
			<tr></tr>

			<tr></tr>

			<tr>
				<td rowspan="3">LAYER 4</td>

				<td rowspan="3"> ADMER : <select name="layer5_layer4_admer" id="layer5_layer4_admer" required>
                              <option value=''>--Select Admer--</option>
                              <?php
                              foreach ($admer as $admer_row) {
                                 echo "<option value='".$admer_row->article_no."' ".set_select('sl_admer_two',$admer_row->article_no).">".$admer_row->lang_article_description."</option>";
                              }
                              ?>
                              </select>

				</td>
				<td rowspan="3"><span id="layer5_layer4_admer_rate"></span></td>
				<td rowspan="3"><input type="text" style="width: 7em;" name="layer5_layer4_micron" id="layer5_layer4_micron" class="number3" value="<?php echo set_value('layer5_layer4_micron');?>"  />
				</td>
				<td rowspan="3"><input type="number" name="layer5_layer4_admer_percentage" id="layer5_layer4_admer_percentage" placeholder="%" class="number3"  min="0" max="100" value="<?php echo set_value('layer5_layer4_admer_percentage');?>" />
				</td>			
			</tr>
			<tr></tr>

			<tr></tr>


			<tr>
				<td rowspan="3">LAYER 5</td>

				<td> LD : <select name="layer5_layer5_sl_ldpe" id="layer5_layer5_sl_ldpe">
										<option value=''>--Select LDPE--</option>
										<?php
										foreach ($ldpe as $ldpe_row) {
											echo "<option value='".$ldpe_row->article_no."' ".set_select('sl_ldpe',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
										}
										?>
										</select>
				
				</td>
				<td><span id="layer5_layer5_ldpe_rate"></span></td>
				<td rowspan="3"><input type="text" style="width: 7em;" name="layer5_layer5_micron" id="layer5_layer5_micron" class="number3" value="<?php echo set_value('layer5_layer5_micron');?>"  />
				</td>
				<td><input type="number" name="layer5_layer5_ld_percentage" id="layer5_layer5_ld_percentage" placeholder="%" class="number3"  min="0" max="100" value="<?php echo set_value('layer5_layer5_ld_percentage');?>" />
				</td>			
			</tr>
			<tr>				
				<td> LLD : <select name="layer5_layer5_sl_lldpe" id="layer5_layer5_sl_lldpe">
										<option value=''>--Select LLDPE--</option>
										<?php
										foreach ($lldpe as $lldpe_row) {
											echo "<option value='".$lldpe_row->article_no."' ".set_select('sl_lldpe',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
										}
										?>
										</select>

				</td>
				<td><span id="layer5_layer5_lldpe_rate"></span></td>		
				<td ><input type="number" size="3" name="layer5_layer5_lld_percentage" id="layer5_layer5_lld_percentage" placeholder="%" maxlength="3" id="" min="0" max="100" value="<?php echo set_value('layer5_layer5_lld_percentage');?>" />
				</td>			
			</tr>

			<tr>
				<td> HD : <select name="layer5_layer5_sl_hdpe" id="layer5_layer5_sl_hdpe">
										<option value=''>--Select HDPE--</option>
										<?php
										foreach ($hdpe as $hdpe_row) {
											echo "<option value='".$hdpe_row->article_no."' ".set_select('sl_hdpe',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
										}
										?>
										</select>

				</td>
				<td><span id="layer5_layer5_hdpe_rate"></span></td>	
				<td ><input type="number" size="3" name="layer5_layer5_hd_percentage" id="layer5_layer5_hd_percentage" placeholder="%" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('layer5_layer5_hd_percentage');?>" />
				</td>			
			</tr>

			<tr>
				<td colspan="4">Quantity</td>

				
				<td> <input type="number" size="3" name="layer5_quantity" id="layer5_quantity" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('layer5_quantity');?>" />	</td>			
			</tr>

			<tr>
				<td colspan="4">Rejection</td>

				
				<td> <input type="number" size="3" name="layer5_rejection" id="layer5_rejection" placeholder="%" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('layer5_rejection');?>" />	</td>			
			</tr>

			<tr>
				<td colspan="4"><button id="layer5_sleevecost"> Check </button></td>

				<td><b><span style="color:red;" id="layer5_sleeve_cost"></span></b></td>

			</tr>
			</tbody>
		</table>
  </div>
</div>
<!--------------------------------------------------Layer 7 --------------------------------->
<div id="layer7" class="modal" style="display:none;">
  <div class="modal-content">

    <span class="close">&times;</span>
    
    <table class="ui celled structured table">
			<thead>
			<tr>
				<th>LAYER</th><th>RM </th><th>RATE </th><th>Micron</th><th>%</th>
				
			</tr>
		</thead>
		<tbody>
			<tr>
				<td rowspan="3">LAYER 1</td>

				<td> LD : <select name="layer7_layer1_sl_ldpe" id="layer7_layer1_sl_ldpe">
										<option value=''>--Select LDPE--</option>
										<?php
										foreach ($ldpe as $ldpe_row) {
											echo "<option value='".$ldpe_row->article_no."' ".set_select('sl_ldpe',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
										}
										?>
										</select>
				
				</td>
				<td><span id="layer7_layer1_ldpe_rate"></span></td>
				<td rowspan="3"><input type="text" style="width: 7em;" name="layer7_layer1_micron" id="layer7_layer1_micron" class="number3" value="<?php echo set_value('layer7_layer1_micron');?>"  />
				</td>
				<td><input type="number" name="layer7_layer1_ld_percentage" id="layer7_layer1_ld_percentage" placeholder="%" class="number3"  min="0" max="100" value="<?php echo set_value('layer7_layer1_ld_percentage');?>" />
				</td>			
			</tr>
			<tr>				
				<td> LLD : <select name="layer7_layer1_sl_lldpe" id="layer7_layer1_sl_lldpe">
										<option value=''>--Select LLDPE--</option>
										<?php
										foreach ($lldpe as $lldpe_row) {
											echo "<option value='".$lldpe_row->article_no."' ".set_select('sl_lldpe',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
										}
										?>
										</select>

				</td>
				<td><span id="layer7_layer1_lldpe_rate"></span></td>		
				<td ><input type="number" size="3" name="layer7_layer1_lld_percentage" id="layer7_layer1_lld_percentage" placeholder="%" maxlength="3" id="" min="0" max="100" value="<?php echo set_value('layer7_layer1_lld_percentage');?>" />
				</td>			
			</tr>

			<tr>
				<td> HD : <select name="layer7_layer1_sl_hdpe" id="layer7_layer1_sl_hdpe">
										<option value=''>--Select HDPE--</option>
										<?php
										foreach ($hdpe as $hdpe_row) {
											echo "<option value='".$hdpe_row->article_no."' ".set_select('sl_hdpe',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
										}
										?>
										</select>

				</td>
				<td><span id="layer7_layer1_hdpe_rate"></span></td>	
				<td ><input type="number" size="3" name="layer7_layer1_hd_percentage" id="layer7_layer1_hd_percentage" placeholder="%" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('layer7_layer1_hd_percentage');?>" />
				</td>			
			</tr>

			<tr>
				<td rowspan="3">LAYER 2</td>

				<td> LD : <select name="layer7_layer2_sl_ldpe" id="layer7_layer2_sl_ldpe">
										<option value=''>--Select LDPE--</option>
										<?php
										foreach ($ldpe as $ldpe_row) {
											echo "<option value='".$ldpe_row->article_no."' ".set_select('sl_ldpe',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
										}
										?>
										</select>
				
				</td>
				<td><span id="layer7_layer2_ldpe_rate"></span></td>
				<td rowspan="3"><input type="text" style="width: 7em;" name="layer7_layer2_micron" id="layer7_layer2_micron" class="number3" value="<?php echo set_value('layer7_layer2_micron');?>"  />
				</td>
				<td><input type="number" name="layer7_layer2_ld_percentage" id="layer7_layer2_ld_percentage" placeholder="%" class="number3"  min="0" max="100" value="<?php echo set_value('layer7_layer2_ld_percentage');?>" />
				</td>			
			</tr>
			<tr>				
				<td> LLD : <select name="layer7_layer2_sl_lldpe" id="layer7_layer2_sl_lldpe">
										<option value=''>--Select LLDPE--</option>
										<?php
										foreach ($lldpe as $lldpe_row) {
											echo "<option value='".$lldpe_row->article_no."' ".set_select('sl_lldpe',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
										}
										?>
										</select>

				</td>
				<td><span id="layer7_layer2_lldpe_rate"></span></td>		
				<td ><input type="number" size="3" name="layer7_layer2_lld_percentage" id="layer7_layer2_lld_percentage" placeholder="%" maxlength="3" id="" min="0" max="100" value="<?php echo set_value('layer7_layer2_lld_percentage');?>" />
				</td>			
			</tr>

			<tr>
				<td> HD : <select name="layer7_layer2_sl_hdpe" id="layer7_layer2_sl_hdpe">
										<option value=''>--Select HDPE--</option>
										<?php
										foreach ($hdpe as $hdpe_row) {
											echo "<option value='".$hdpe_row->article_no."' ".set_select('sl_hdpe',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
										}
										?>
										</select>

				</td>
				<td><span id="layer7_layer2_hdpe_rate"></span></td>	
				<td ><input type="number" size="3" name="layer7_layer2_hd_percentage" id="layer7_layer2_hd_percentage" placeholder="%" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('layer7_layer2_hd_percentage');?>" />
				</td>			
			</tr>

			<tr>
				<td rowspan="3">LAYER 3</td>

				<td rowspan="3"> ADMER : <select name="layer7_layer3_admer" id="layer7_layer3_admer" required>
                              <option value=''>--Select Admer--</option>
                              <?php
                              foreach ($admer as $admer_row) {
                                 echo "<option value='".$admer_row->article_no."' ".set_select('sl_admer_two',$admer_row->article_no).">".$admer_row->lang_article_description."</option>";
                              }
                              ?>
                              </select>

				</td>
				<td rowspan="3"><span id="layer7_layer3_admer_rate"></span></td>
				<td rowspan="3"><input type="text" style="width: 7em;" name="layer7_layer3_micron" id="layer7_layer3_micron" class="number3" value="<?php echo set_value('layer7_layer3_micron');?>"  />
				</td>
				<td rowspan="3"><input type="number" name="layer7_layer3_admer_percentage" id="layer7_layer3_admer_percentage" placeholder="%" class="number3"  min="0" max="100" value="<?php echo set_value('layer7_layer3_admer_percentage');?>" />
				</td>			
			</tr>
			<tr></tr>

			<tr></tr>

			<tr>
				<td rowspan="3">LAYER 4</td>

				<td rowspan="3"> EVOH : <select name="layer7_layer4_evoh" id="layer7_layer4_evoh" required>
                              <option value=''>--Select Evoh--</option>
                              <?php
                              foreach ($evoh as $evoh_row) {
                                 echo "<option value='".$evoh_row->article_no."' ".set_select('sl_evoh_three',$evoh_row->article_no).">".$evoh_row->lang_article_description."</option>";
                              }
                              ?>
                              </select>

				</td>
				<td rowspan="3"><span id="layer7_layer4_evoh_rate"></span></td>
				<td rowspan="3"><input type="text" style="width: 7em;" name="layer7_layer4_micron" id="layer7_layer4_micron" class="number3" value="<?php echo set_value('layer7_layer4_micron');?>"  />
				</td>
				<td rowspan="3"><input type="number" name="layer7_layer4_evoh_percentage" id="layer7_layer4_evoh_percentage" placeholder="%" class="number3"  min="0" max="100" value="<?php echo set_value('layer7_layer4_evoh_percentage');?>" />
				</td>			
			</tr>
			<tr></tr>

			<tr></tr>

			<tr>
				<td rowspan="3">LAYER 5</td>

				<td rowspan="3"> ADMER : <select name="layer7_layer5_admer" id="layer7_layer5_admer" required>
                              <option value=''>--Select Admer--</option>
                              <?php
                              foreach ($admer as $admer_row) {
                                 echo "<option value='".$admer_row->article_no."' ".set_select('sl_admer_two',$admer_row->article_no).">".$admer_row->lang_article_description."</option>";
                              }
                              ?>
                              </select>

				</td>
				<td rowspan="3"><span id="layer7_layer5_admer_rate"></span></td>
				<td rowspan="3"><input type="text" style="width: 7em;" name="layer7_layer5_micron" id="layer7_layer5_micron" class="number3" value="<?php echo set_value('layer7_layer5_micron');?>"  />
				</td>
				<td rowspan="3"><input type="number" name="layer7_layer5_admer_percentage" id="layer7_layer5_admer_percentage" placeholder="%" class="number3"  min="0" max="100" value="<?php echo set_value('layer7_layer5_admer_percentage');?>" />
				</td>			
			</tr>
			<tr></tr>

			<tr></tr>


			<tr>
				<td rowspan="3">LAYER 6</td>

				<td> LD : <select name="layer7_layer6_sl_ldpe" id="layer7_layer6_sl_ldpe">
										<option value=''>--Select LDPE--</option>
										<?php
										foreach ($ldpe as $ldpe_row) {
											echo "<option value='".$ldpe_row->article_no."' ".set_select('sl_ldpe',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
										}
										?>
										</select>
				
				</td>
				<td><span id="layer7_layer6_ldpe_rate"></span></td>
				<td rowspan="3"><input type="text" style="width: 7em;" name="layer7_layer6_micron" id="layer7_layer6_micron" class="number3" value="<?php echo set_value('layer7_layer6_micron');?>"  />
				</td>
				<td><input type="number" name="layer7_layer6_ld_percentage" id="layer7_layer6_ld_percentage" placeholder="%" class="number3"  min="0" max="100" value="<?php echo set_value('layer7_layer6_ld_percentage');?>" />
				</td>			
			</tr>
			<tr>				
				<td> LLD : <select name="layer7_layer6_sl_lldpe" id="layer7_layer6_sl_lldpe">
										<option value=''>--Select LLDPE--</option>
										<?php
										foreach ($lldpe as $lldpe_row) {
											echo "<option value='".$lldpe_row->article_no."' ".set_select('sl_lldpe',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
										}
										?>
										</select>

				</td>
				<td><span id="layer7_layer6_lldpe_rate"></span></td>		
				<td ><input type="number" size="3" name="layer7_layer6_lld_percentage" id="layer7_layer6_lld_percentage" placeholder="%" maxlength="3" id="" min="0" max="100" value="<?php echo set_value('layer7_layer6_lld_percentage');?>" />
				</td>			
			</tr>

			<tr>
				<td> HD : <select name="layer7_layer6_sl_hdpe" id="layer7_layer6_sl_hdpe">
										<option value=''>--Select HDPE--</option>
										<?php
										foreach ($hdpe as $hdpe_row) {
											echo "<option value='".$hdpe_row->article_no."' ".set_select('sl_hdpe',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
										}
										?>
										</select>

				</td>
				<td><span id="layer7_layer6_hdpe_rate"></span></td>	
				<td ><input type="number" size="3" name="layer7_layer6_hd_percentage" id="layer7_layer6_hd_percentage" placeholder="%" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('layer7_layer6_hd_percentage');?>" />
				</td>			
			</tr>

			<tr>
				<td rowspan="3">LAYER 7</td>

				<td> LD : <select name="layer7_layer7_sl_ldpe" id="layer7_layer7_sl_ldpe">
										<option value=''>--Select LDPE--</option>
										<?php
										foreach ($ldpe as $ldpe_row) {
											echo "<option value='".$ldpe_row->article_no."' ".set_select('sl_ldpe',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
										}
										?>
										</select>
				
				</td>
				<td><span id="layer7_layer7_ldpe_rate"></span></td>
				<td rowspan="3"><input type="text" style="width: 7em;" name="layer7_layer7_micron" id="layer7_layer7_micron" class="number3" value="<?php echo set_value('layer7_layer7_micron');?>"  />
				</td>
				<td><input type="number" name="layer7_layer7_ld_percentage" id="layer7_layer7_ld_percentage" placeholder="%" class="number3"  min="0" max="100" value="<?php echo set_value('layer7_layer7_ld_percentage');?>" />
				</td>			
			</tr>
			<tr>				
				<td> LLD : <select name="layer7_layer7_sl_lldpe" id="layer7_layer7_sl_lldpe">
										<option value=''>--Select LLDPE--</option>
										<?php
										foreach ($lldpe as $lldpe_row) {
											echo "<option value='".$lldpe_row->article_no."' ".set_select('sl_lldpe',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
										}
										?>
										</select>

				</td>
				<td><span id="layer7_layer7_lldpe_rate"></span></td>		
				<td ><input type="number" size="3" name="layer7_layer7_lld_percentage" id="layer7_layer7_lld_percentage" placeholder="%" maxlength="3" id="" min="0" max="100" value="<?php echo set_value('layer7_layer7_lld_percentage');?>" />
				</td>			
			</tr>

			<tr>
				<td> HD : <select name="layer7_layer7_sl_hdpe" id="layer7_layer7_sl_hdpe">
										<option value=''>--Select HDPE--</option>
										<?php
										foreach ($hdpe as $hdpe_row) {
											echo "<option value='".$hdpe_row->article_no."' ".set_select('sl_hdpe',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
										}
										?>
										</select>

				</td>
				<td><span id="layer7_layer7_hdpe_rate"></span></td>	
				<td ><input type="number" size="3" name="layer7_layer7_hd_percentage" id="layer7_layer7_hd_percentage" placeholder="%" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('layer7_layer7_hd_percentage');?>" />
				</td>			
			</tr>

			<tr>
				<td colspan="4">Quantity</td>

				
				<td> <input type="number" size="3" name="layer7_quantity" id="layer7_quantity" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('layer7_quantity');?>" />	</td>			
			</tr>

			<tr>
				<td colspan="4">Rejection</td>

				
				<td> <input type="number" size="3" name="layer7_rejection" id="layer7_rejection" placeholder="%" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('layer7_rejection');?>" />	</td>			
			</tr>

			<tr>
				<td colspan="4"><button id="layer7_sleevecost"> Check </button></td>

				<td><b><span style="color:red;" id="layer7_sleeve_cost"></span></b></td>

			</tr>
			</tbody>
		</table>
  </div>
</div>

<!-----------------------------------Shoulder COst --------------------->



<!---------------------Shoulder DIv------------------>

<div id="shoulder_div" class="modal" style="display:none;">
  <div class="modal-content">
  		
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
					<option value='RM-HDPE-000-0009'>HDPE RELIANCE M60075</option>
					<?php
					foreach ($hdpe as $hdpe_row) {
						echo "<option value='".$hdpe_row->article_no."' ".set_select('sh_hdpe_one',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
					}
					?>
					</select>
					<input type="hidden" name="sh_hdpe_one" value="RM-HDPE-000-0009" />
        </td> 
        <td><span id="sh_hdpe_one_rate"></span></td>
        <td><input type="number" name="hdpe_m" id="hdpe_m" placeholder="%" class="number3"  min="0" max="100" value="<?php echo set_value('hdpe_m','30');?>" /></td>     
      </tr>

      <tr>
        <td >HD :
        		 <select name="sh_hdpe_two" id="sh_hdpe_two" >
					<option value='RM-HDPE-000-0008'>HDPE RELIANCE F46003</option>
					<?php
					foreach ($hdpe as $hdpe_row) {
						echo "<option value='".$hdpe_row->article_no."' ".set_select('sh_hdpe_two',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
					}
					?>
					</select>
					<input type="hidden" name="sh_hdpe_two" value="RM-HDPE-000-0008" />
        </td>
        <td><span id="sh_hdpe_two_rate"></span></td>
        <td><input type="number" name="hdpe_f" id="hdpe_f" placeholder="%" class="number3"  min="0" max="100" value="<?php echo set_value('hdpe_f','70');?>" /></td>     
      </tr>

       <tr>
        <td> MB : <select name="shoulder_mb" id="shoulder_mb" required><option value=''>--Select MB--</option>
                    <?php foreach ($masterbatch as $masterbatch_row) {
                      echo "<option value='".$masterbatch_row->article_no."' ".set_select('sl_masterbatch',$masterbatch_row->article_no).">".$masterbatch_row->lang_article_description."</option>";
                    }?></select>
        </td>
        <td><span id="shoulder_mb_rate"></span></td>
        <td><input type="number" size="3" name="shoulder_mb_percentage" id="shoulder_mb_percentage" placeholder="%" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('shoulder_mb_percentage','0');?>" />
        </td>     
      </tr>

      <tr>
			<td> MB : <input type="text" size="25" name="shoulder_mb1" id="shoulder_mb1" placeholder="If MB is not in system"value="<?php echo set_value('shoulder_mb1');?>" />
			</td>
			<td>  <input type="text" size="5" name="shoulder_mb1_rate" id="shoulder_mb1_rate" value="<?php echo set_value('shoulder_mb1_rate');?>" />  </td>	
			<td ><input type="number" size="3" name="shoulder_mb_percentage1" id="shoulder_mb_percentage1" placeholder="%" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('shoulder_mb_percentage1','0');?>" />
			</td>			
		</tr>

      <tr>
        <td colspan="2">Quantity</td>
        <td> <input type="number" size="3" name="sh_quantity" id="sh_quantity" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('sh_quantity','1');?>" />  </td>     
      </tr>

      <tr>
        <td colspan="2">Standard waste %</td>
        <?php 
          foreach($workprocedure as $workprocedure){
                      $sh_rejection=$this->common_model->read_number($workprocedure->rejection_perc,$this->session->userdata['logged_in']['company_id']);
                    }

          ?>
        <td><input type="number" size="3" name="sh_rejection" id="sh_rejection" placeholder="%" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('sh_rejection',$sh_rejection);?>" />
        	<input type="hidden" id="std_sh_rejection" value="<?php echo set_value('sh_rejection',$sh_rejection);?>" />
        	<input type="hidden" id="shoulder_weight" >
        </td>
      </tr>

      <tr>
        <td colspan="2"><button id="shouldercost"> Calculate Shoulder Cost </button></td>

        <td><input  readonly="readonly" type="number" size="3" id="shoulder_cost" maxlength="3" min="0" max="100"  />	
				</td>

      </tr>

      </tbody>
    </table>	
		
  </div>
</div>


<!---------------------Lacquer DIv------------------>

<div id="tube_lacquer_div" class="modal" style="display:none;">
  <div class="modal-content">
  	<span class="close">&times;</span>
      <table class="ui celled structured table">
	      <thead>
	       <tr><th>RM</th><th>RATE/KG</th><th>GM/TUBE</th><th>%</th></tr>
	      </thead>
		  <tbody>
		      <tr>
		        <td>GLOSS : <select name="lacquer_type_1" id="lacquer_type_1" required><option value=''>--Select Lacquer--</option>
					<?php if($lacquer==FALSE){
						echo "<option value=''>--Setup Required--</option>";}
						else{
							foreach($lacquer as $lacquer_row){
						echo "<option value='".$lacquer_row->article_no."'   ".set_select('lacquer_type_1',$lacquer_row->article_no).">".$lacquer_row->lang_article_description."</option>";
							}
					}?></select></td> 
		        <td><span id="lacquer_type_1_rate"></span></td>
		        <td><span id="lacquer_type_1_gm_per_tube"></span></td>
		        <td><input type="number" name="lacquer_type_1_percentage" id="lacquer_type_1_percentage" placeholder="%" class="number3"  min="0" max="100" value="<?php echo set_value('lacquer_type_1_percentage','100');?>" /></td>     
		      </tr>

		      <tr>
		        <td>MATT : <select name="lacquer_type_2" id="lacquer_type_2" required><option value=''>--Select Lacquer--</option>
					<?php if($lacquer==FALSE){
						echo "<option value=''>--Setup Required--</option>";}
						else{
							foreach($lacquer as $lacquer_row){
						echo "<option value='".$lacquer_row->article_no."'   ".set_select('lacquer_type_2',$lacquer_row->article_no).">".$lacquer_row->lang_article_description."</option>";
							}
					}?></select></td> 
		        <td><span id="lacquer_type_2_rate"></span></td>
		        <td><span id="lacquer_type_2_gm_per_tube"></span></td>		        
		        <td><input type="number" name="lacquer_type_2_percentage" id="lacquer_type_2_percentage" placeholder="%" class="number3"  min="0" max="100" value="<?php echo set_value('lacquer_type_2_percentage','0');?>" /></td>     
		      </tr>
		      <tr>
		        <td  colspan="3">Quantity</td>
		        <td><input type="number" size="3" name="lacquer_quantity" id="lacquer_quantity" placeholder="" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('lacquer_quantity','1');?>" />
		        </td>
		      </tr>

		      <tr>
		        <td  colspan="3">Rejection</td>
		        <?php 
		          foreach($workprocedure_printing as $workprocedure_printing){
		                      $printing_rejection=$this->common_model->read_number($workprocedure_printing->rejection_perc,$this->session->userdata['logged_in']['company_id']);
		                    }

		         ?>
		        <td><input type="number" size="3" name="printing_rejection" id="printing_rejection" placeholder="%" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('printing_rejection',$printing_rejection);?>" />
		        	<input type="hidden" id="std_print_rejection" value="<?php echo set_value('printing_rejection',$printing_rejection);?>" />
		        </td>
		      </tr>

		      <tr>
		        <td colspan="3"><button id="tube_lacquer_cost">Calculate</button></td>
		        <td><b><input  readonly="readonly" type="number" size="3" id="lacquer_cost_per_tube" maxlength="3" min="0" max="100" ></td>
		      </tr>
		  </tbody>
	  </table>	
  </div>
</div>

<!---------------------Plain DIv------------------>

<div id="plain_div" class="modal" style="display:none;">
  <div class="modal-content">
  	<span class="close">&times;</span>
      <p>Plain Div</p>
  </div>
</div>

<!---------------------label DIv------------------>

<div id="label_div" class="modal" style="display:none;">
  <div class="modal-content">
  	<span class="close">&times;</span>
      <table class="ui celled structured table">
	      <thead>
	       <tr><th>RM</th><th>Purchase Rate</th></tr>
	      </thead>
		  <tbody>
		      <tr>
		        <td>LABEL : </td> 
		        <td><input type="number" name="label_rate" id="label_rate" placeholder="Rate" class="number3"  min="0" max="100" value="<?php echo set_value('label_rate','0');?>" /></td>  
		      </tr>  
		      <tr>
		        <td>Rejection</td>
		        <?php 
		          foreach($workprocedure_label as $workprocedure_label){
		                      $label_rejection=$this->common_model->read_number($workprocedure_label->rejection_perc,$this->session->userdata['logged_in']['company_id']);
		                    }

		         ?>
		        <td><input type="number" size="3" name="label_rejection" id="label_rejection" placeholder="%" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('label_rejection',$label_rejection);?>" />
		        	<input type="hidden" id="std_lb_rejection" value="<?php echo set_value('label_rejection',$label_rejection);?>" />
		        </td>
		      </tr>
		      <tr>
		        <td><button id="label_cost">Calculate</button></td>
		        <td><b><input  readonly="readonly" type="number" size="3" id="label_cost_per_tube" maxlength="3" min="0" max="100" ></td>
		      </tr>
		  </tbody>
	  </table>	
  </div>
</div>
<!---------------------Offset DIv------------------>

<div id="offset_div" class="modal" style="display:none;">
  <div class="modal-content">
  	<span class="close">&times;</span>
      <table class="ui celled structured table">
	      <thead>
	       <tr><th>RM</th><th>RATE/KG</th><th>GM/TUBE</th><th>%</th></tr>
	      </thead>
		  <tbody>
		      <tr>
		        <td>OFFSET : <select name="offset_rm_month" id="offset_rm_month" required><option value=''>--Select Offset--</option>
		          <?php if($offset==FALSE){
						echo "<option value=''>--Setup Required--</option>";}
						else{
							foreach($offset as $offset_row){
						echo "<option value='".$offset_row->ipm_id."'   ".set_select('offset_rm_month',$offset_row->ipm_id).">".$offset_row->rm."</option>";
							}
					}?></select></td> 
		        <td><span id="offset_rate"></span></td>
		        <td><input type="number" size="3" name="offset_gm_per_tube" id="offset_gm_per_tube" placeholder="" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('offset_gm_per_tube','1');?>" /></td>
		        <td><input type="number" name="offset_percentage" id="offset_percentage" placeholder="%" class="number3"  min="0" max="100" value="<?php echo set_value('offset_percentage','100');?>" /></td>     
		      </tr>
		      <tr>
		        <td colspan="3">Rejection</td>
		        <td><input type="number" size="3" name="offset_rejection" id="offset_rejection" placeholder="%" maxlength="3" id="" min="0" max="100"  value="<?php echo set_value('offset_rejection',$offset_rejection);?>" />
		        	<input type="hidden" id="std_off_rejection" value="<?php echo set_value('offset_rejection',$printing_rejection);?>" />
		        </td>
		      </tr>

		      <tr>
		        <td colspan="3"><button id="offset_cost">Calculate</button></td>
		        <td><b><input  readonly="readonly" type="number" size="3" id="offset_cost_per_tube" maxlength="3" min="0" max="100" ></td>
		      </tr>
		  </tbody>
	  </table>	
  </div>
</div>



<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>

		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner" width="100%">
						<tr>
							<td>
								<fieldset >
									<legend>Information:</legend>
									<table class="form_table_inner">						 
										<tr>							
											<td class="label" width="26%"> Customer: <span style="color:red;">*</span> :</td>
											<td colspan="3"><input type="text" name="customer" id="customer_category"  size="55" value="<?php echo set_value('customer');?>"  /></td>							
										</tr>
										<tr>							
											<td class="label">Purchase Manager <span style="color:red;">*</span> :</td>
											<td colspan="3">
												<select name="pm_1" id="pm_1" >
													<option value="">--Select PM--</option>
												
												</select>
											</td>								
										</tr>
									
										<tr>							
											<td class="label">Product Name <span style="color:red;">*</span> :</td>
											<td colspan="3"> <input type="text"  name="product_name"  size="55" value="<?php echo set_value('product_name');?>" />
																	
											</td>								
										</tr>

										<tr>
											<td class="label">Payment Terms <span style="color:red;">*</span>  :</td>
											<td colspan="3"><input type="text" name="credit_days" value="<?php echo set_value('credit_days');?>" >
											</td>
									 	</tr>

									 	<tr>
											<td class="label">Date of Enquiry <span style="color:red;">*</span>  :</td>
											<td colspan="3"><input type="date" name="enquiry_date" value="<?php echo set_value('enquiry_date');?>" >
											</td>
									 	</tr>
										
											
										 
									</table>
								</fieldset>
							</td>
						</tr>
						<tr>
							<td colspan="4" >
								<fieldset>
									<legend>Tube Specification:</legend>
								<table class="form_table_inner">

									

									<tr>
										<td class="label" width="25%">Tube Dia <span style="color:red;">*</span>:</td>
										<td width="25%"> 
											
											<select name="sleeve_dia" id="sleeve_dia" ><option value=''>--Select Dia--</option>
										<?php if($sleeve_dia==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($sleeve_dia as $sleeve_dia_row){
													echo "<option value='".$sleeve_dia_row->sleeve_diameter."//".$sleeve_dia_row->sleeve_id."'  ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_diameter.'//'.$sleeve_dia_row->sleeve_id.'').">".$sleeve_dia_row->sleeve_diameter."</option>";
												}
										}?></select>
										</td>
										<td class="label" width="25%">Tube Length <span style="color:red;">*</span> :</td>
										<td width="25%"><input type="text" class="number1" name="sleeve_length" id="sleeve_length" size="5" maxlength="5" value="<?php echo set_value('sleeve_length');?>" >
										</td>

									</tr>

									<tr>
										<td class="label">Layer <span style="color:red;">*</span> :</td>
										<td>
											<select name="layer" id="layer" >
												<option value="">--Select Layer--</option>							 
												<option value="1" <?php echo set_select('layer',1);?> >1</option>
												<option value="2" <?php echo set_select('layer',2);?> >2</option>
												<option value="3" <?php echo set_select('layer',3);?> >3</option>
												
												<option value="5" <?php echo set_select('layer',5);?> >5</option>
												
												<option value="7" <?php echo set_select('layer',7);?> >7</option>
												
											</select>
										</td>
									</tr>

									
									<tr>
										<td class="label">Tube Color <span style="color:red;">*</span> :  </td>
										<td colspan="3"><input type="text" name="tube_color" id="tube_color" value="<?php echo set_value('tube_color');?>" >  <a href="<?php echo base_url('index.php/color_master');?>" target="_blank"><i class="edit icon"></i></a>
										</td>
									</tr>

									<!--
									<tr>
										<td class="label">Tube Color <span style="color:red;">*</span> :</td>
										<td><select name="tube_color" id="tube_color" required><option value=''>--Select Tube Color--</option>
										<?php if($tube_color==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($tube_color as $tube_color_row){
													echo "<option value='".$tube_color_row->color."'  ".set_select('tube_color',''.$tube_color_row->color.'').">".$tube_color_row->color."</option>";
												}
										}?>
										</select></td>
									</tr>-->

									<!--<tr>
										<td class="label">Tube Lacquer <span style="color:red;">*</span> :</td>
										<td>
											<select name="tube_lacquer" id="tube_lacquer" >
												<option value="">--Select Tube Lacquer--</option>
												<option value="GLOSS" <?php echo set_select('tube_lacquer','GLOSS');?> >GLOSS</option>
												<option value="MATT" <?php echo set_select('tube_lacquer','MATT');?> >MATT</option>
												<option value="SATIN_MATT" <?php echo set_select('tube_lacquer','SATIN_MATT');?> >SATIN MATT</option>
												<option value="SPOT" <?php echo set_select('tube_lacquer','SPOT');?> >SPOT</option>
											</select>
										</td>
									</tr>-->

									<tr>
										<td class="label">Tube Lacquer <span style="color:red;">*</span> :</td>
										<td>
											<select name="tube_lacquer" id="tube_lacquer" >
												<option value="">--Select Tube Lacquer--</option>
												<option value="YES" <?php echo set_select('tube_lacquer','YES');?> >YES</option>
												<option value="NO" <?php echo set_select('tube_lacquer','NO');?> >NO</option>
											</select>
										</td>
									</tr>
									
									<tr>
										<td class="label">Tube Print Type <span style="color:red;">*</span> :</td>
										<td>
											<select name="print_type" id="print_type" required>
												<option value=''>--Select Print Type--</option>
										<?php if($print_type==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
										else{
											foreach($print_type as $print_type_row){
												echo "<option value='".$print_type_row->print_type."'  ".set_select('print_type',''.$print_type_row->print_type.'').">".$print_type_row->print_type."</option>";
												}
											}?>
											</select>
										</td>
									</tr>

									
									<!--
									<tr>
										<td class="label">Tube Print Type <span style="color:red;">*</span> :</td>
										<td><select name="print_type" id="print_type" ><option value=''>--Select Print Type--</option>
										<?php if($print_type==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($print_type as $print_type_row){
													echo "<option value='".$print_type_row->lacquer_type."'  ".set_select('print_type',''.$print_type_row->lacquer_type.'').">".$print_type_row->lacquer_type."</option>";
												}
										}?>
										</select></td>
									</tr>-->

									<tr>	
										<td class="label">Special Ink <span style="color:red;">*</span> :</td>	 
										<td>  
											<select name="special_ink" id="special_ink" >
												<option value="">--Select Special ink--</option>
												<option value="YES" <?php echo set_select('special_ink','YES');?> >YES</option>
												<option value="NO" <?php echo set_select('special_ink','NO');?> >NO</option>
											</select>							
										</td>
									</tr>
									

									
								</table>
							</fieldset>
						</td>			
					 </tr>

					 <tr>
					 	<td colspan="4" >
								<fieldset>
									<legend>Shoulder Specification:</legend>
								<table class="form_table_inner">

									<tr>
										<td class="label">Shoulder <span style="color:red;">*</span> :</td>
										<td><select name="shoulder" id="shoulder"><option value=''>--Select Shoulder--</option>
										<?php if($shoulder_types==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($shoulder_types as $shoulder_types_row){
													echo "<option value='".$shoulder_types_row->shoulder_type."//".$shoulder_types_row->shld_type_id."'  ".set_select('shoulder',''.$shoulder_types_row->shoulder_type.'//'.$shoulder_types_row->shld_type_id.'').">".$shoulder_types_row->shoulder_type."</option>";
												}
										}?>
										</select></td>
									</tr>
									<tr>

											<td class="label">Shoulder Orifice  :</td>
											<td colspan="3"><select name="shoulder_orifice" id="shoulder_orifice"><option value=''>--Select Orifice--</option>
											<?php if($shoulder_orifice==FALSE){
															echo "<option value=''>--Setup Required--</option>";}
												else{
													foreach($shoulder_orifice as $shoulder_orifice_row){
														echo "<option value='".$shoulder_orifice_row->shoulder_orifice."//".$shoulder_orifice_row->orifice_id."'  ".set_select('shoulder_orifice',''.$shoulder_orifice_row->shoulder_orifice.'//'.$shoulder_orifice_row->orifice_id.'').">".$shoulder_orifice_row->shoulder_orifice."</option>";
													}
											}?></select></td>
									</tr>

									<tr>
										<td class="label">Shoulder Color <span style="color:red;">*</span>  :</td>
										<td colspan="3"><input type="text" name="shoulder_color"  id="shoulder_color" value="<?php echo set_value('shoulder_color');?>" >
										</td>
									</tr>

								</table>
							</fieldset>
						</td>						

					 </tr>	

					 <tr>
					 	<td colspan="4" >
								<fieldset>
									<legend>Cap Specification:</legend>
								<table class="form_table_inner">

									<tr>
										<td class="label">Cap Type <span style="color:red;">*</span> :</td>
										<td>
											<select name="cap_type" id="cap_type" ><option value=''>--Select Cap Type--</option>
											<?php if($cap_type==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($cap_type as $cap_type_row){
													echo "<option value='".$cap_type_row->cap_type."//".$cap_type_row->cap_type_id."'  ".set_select('cap_type',''.$cap_type_row->cap_type.'//'.$cap_type_row->cap_type_id.'').">".$cap_type_row->cap_type."</option>";
												}
										}?>
											</select>
										</td>
										
									</tr>

									<tr>
										<td class="label">Cap Finish <span style="color:red;">*</span> :</td>
										<td><select name="cap_finish" id="cap_finish"><option value=''>--Select Cap Finish--</option>
											<?php if($cap_finish==FALSE){
															echo "<option value=''>--Setup Required--</option>";}
												else{
													foreach($cap_finish as $cap_finish_row){
														echo "<option value='".$cap_finish_row->cap_finish."//".$cap_finish_row->cap_finish_id."'  ".set_select('cap_finish',''.$cap_finish_row->cap_finish.'//'.$cap_finish_row->cap_finish_id.'').">".$cap_finish_row->cap_finish."</option>";
													}
											}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">Cap Dia <span style="color:red;">*</span> :</td>
										<td><select name="cap_dia" id="cap_dia"><option value=''>--Select Cap Dia--</option>
										<?php if($cap_dia==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($cap_dia as $cap_dia_row){
													echo "<option value='".$cap_dia_row->cap_dia."//".$cap_dia_row->cap_dia_id."'  ".set_select('cap_dia',''.$cap_dia_row->cap_dia.'//'.$cap_dia_row->cap_dia_id.'').">".$cap_dia_row->cap_dia."</option>";
												}
										}?></select></td>
									</tr>

									<tr>
										<td class="label">Cap Orifice :</td>
										<td><select name="cap_orifice" id="cap_orifice">
										<option value=''>--Select Cap Orifice--</option>
											<?php if($cap_orifice==FALSE){
															echo "<option value=''>--Setup Required--</option>";}
												else{
													foreach($cap_orifice as $cap_orifice_row){
														echo "<option value='".$cap_orifice_row->cap_orifice."//".$cap_orifice_row->cap_orifice_id."'  ".set_select('cap_orifice',''.$cap_orifice_row->cap_orifice.'//'.$cap_orifice_row->cap_orifice_id.'').">".$cap_orifice_row->cap_orifice."</option>";
													}
											}?></select>
										</td>
									</tr>
									
										
									<!--	
									<tr>
												
										<td class="label">Cap MB <span style="color:red;">*</span> :</td>
										<td>
											<select name="cap_mb" id="cap_mb" required>
												<option value="">--Select Cap MB--</option>
												<option value="YES" <?php echo set_select('cap_mb','YES');?> >YES</option>
												<option value="NO" <?php echo set_select('cap_mb','NO');?> >NO</option>
											</select>
										</td>
									</tr>
									-->

									<tr>
										<td class="label">Cap Color <span style="color:red;">*</span>  :</td>
										<td colspan="3"><input type="text" name="cap_color" id="cap_color" value="<?php echo set_value('cap_color');?>" >
										</td>
									</tr>


								</table>
							</fieldset>
						</td>						

					 </tr>

					 <tr>
					 	<td colspan="4" >
								<fieldset>
									<legend>Decorative Elements:</legend>
								<table class="form_table_inner">

									<tr>
										<td class="label">Tube Foil <span style="color:red;">*</span>:</td>
										<td colspan="3">
											<select name="tube_foil" id="tube_foil" >
												<option value="">--Select Tube Foil--</option>
												<option value="YES" <?php echo set_select('tube_foil','YES');?> >YES</option>
												<option value="NO" <?php echo set_select('tube_foil','NO');?> >NO</option>
											</select>
										</td>
									</tr>

									<tr>
										<td class="label">Shoulder Foil <span style="color:red;">*</span> :</td>
										<td colspan="3">
											<select name="shoulder_foil" id="shoulder_foil" >
												<option value="">--Select Tube Foil--</option>
												<option value="YES" <?php echo set_select('shoulder_foil','YES');?> >YES</option>
												<option value="NO" <?php echo set_select('shoulder_foil','NO');?> >NO</option>
											</select>
										</td>
									</tr>
									<!--
									<tr>
										<td class="label">Cap Foil <span style="color:red;">*</span> :</td>
										<td>							   
											<select name="cap_foil" id="cap_foil" >
												<option value="">--Select Cap Foil--</option>
												<option value="YES" <?php echo set_select('cap_foil','YES');?> >YES</option>
												<option value="NO" <?php echo set_select('cap_foil','NO');?> >NO</option>
											</select>	
											
										</td>
									</tr>

										
									<tr>
										<td class="label">Cap Metalization <span style="color:red;">*</span> :</td>
										<td>									  
											<select name="cap_metalization" id="cap_metalization" >
												<option value="">--Select Metalization--</option>
												<option value="YES" <?php echo set_select('cap_metalization','YES');?> >YES</option>
												<option value="NO" <?php echo set_select('cap_metalization','NO');?> >NO</option>
											</select>	
											
										</td>
									</tr>
									-->
									<tr>
										<td class="label">Cap Shirnk Sleeve <span style="color:red;">*</span> :</td>
										<td>
											<select name="cap_shrink_sleeve" id="cap_shrink_sleeve" >
												<option value="">--Select Shrink Sleeve--</option>
												<option value="YES" <?php echo set_select('cap_shrink_sleeve','YES');?> >YES</option>
												<option value="NO" <?php echo set_select('cap_shrink_sleeve','NO');?> >NO</option>
											</select>
										</td>
									</tr>

									<!--//-----------------------CAP Metalizaion and Cap Foil CheckBox-->

									<?php

									
                    if($this->input->post('cap_metalization') &&  $this->input->post('cap_metalization')=='YES'){

                      echo '<tr>
                      <td class="label">Cap Metalization :</td>
                      <td><input type="checkbox" name="cap_metalization" id="cap_metalization" value="YES" '.set_checkbox('cap_metalization','YES').' /></td>
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
											<td><input type="checkbox" name="cap_metalization" id="cap_metalization" value="YES" <?php echo set_checkbox('cap_metalization','YES');?> /></td>
										</tr>

										<tr id="metalization_div" style="display: none">
											<td></td><td>
										Color : &nbsp;&nbsp;<select name="cap_metalization_color" id="cap_metalization_color">
                      <option value="">--Select--</option>
                      <option value='GOLD' <?php echo  set_select('cap_metalization_color', 'GOLD'); ?>>GOLD</option>
                      <option value='SILVER' <?php echo  set_select('cap_metalization_color', 'SILVER'); ?>>SILVER</option>
                      <option value='PINK' <?php echo  set_select('cap_metalization_color', 'PINK'); ?>>PINK</option>
                      <option value='CHAMPION' <?php echo  set_select('cap_metalization_color', 'CHAMPION'); ?>>CHAMPION</option>
                      <option value='WINE' <?php echo  set_select('cap_metalization_color', 'WINE'); ?>>WINE</option>
                      <option value='COPPER' <?php echo  set_select('cap_metalization_color', 'COPPER'); ?>>COPPER</option>
                      <option value='BELLISIMA' <?php echo  set_select('cap_metalization_color', 'BELISIMA'); ?>>BELLISIMA</option>
                      <option value='MAGENTA' <?php echo  set_select('cap_metalization_color', 'MAGENTA'); ?>>MAGENTA</option>
                      <option value='LIGHT PURPLE' <?php echo  set_select('cap_metalization_color', 'LIGHT PURPLE'); ?>>LIGHT PURPLE</option>
                      <option value='RHODAMINE RED' <?php echo  set_select('cap_metalization_color', 'RHODAMINE RED'); ?>>RHODAMINE RED</option>
                      <option value='ROSE GOLD' <?php echo  set_select('cap_metalization_color', 'ROSE GOLD'); ?>>ROSE GOLD</option>
                      <option value='SHINY GOLD' <?php echo  set_select('cap_metalization_color', 'SHINY GOLD'); ?>>SHINY GOLD</option>
                      <option value='COCO BROWN' <?php echo  set_select('cap_metalization_color', 'COCO BROWN'); ?>>COCO BROWN</option>
                    </select>

										<br/>

										Finish : &nbsp;<select name="cap_metalization_finish" id="cap_metalization_finish">
											<option value="">--Select--</option>
											<option value='GLOSS' <?php echo  set_select('cap_metalization_finish', 'GLOSS'); ?>>GLOSS</option>
											<option value='MATT' <?php echo  set_select('cap_metalization_finish', 'MATT'); ?>>MATT</option>
										</select>
									</td>
									</tr>


                    <?php }
                    ?>

										<tr>

									<?php
                    if($this->input->post('cap_foil') &&  $this->input->post('cap_foil')=='YES'){

                      echo '<tr>
                      <td class="label">Cap Foil :</td>
                      <td><input type="checkbox" name="cap_foil" id="cap_foil" value="YES" '.set_checkbox('cap_foil','YES').' /></td>
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
											<td><input type="checkbox" name="cap_foil" id="cap_foil" value="YES" <?php echo set_checkbox('cap_foil','YES');?> /></td>
										</tr>

										<tr id="foil_div" style="display: none">
											<td></td><td>
										Cap Foil Width : &nbsp;&nbsp;
                    			 <input type="number" min="1" max="5" step="any" name="cap_foil_width" id="cap_foil_width" size="3" maxlength="3" value="<?php echo set_value('cap_foil_width');?>">

										<br/>

										Cap Foil Dist From Bottom : &nbsp;
											<input type="number" min="0" max="20" step="any"  name="cap_foil_dist_frm_bottom" id="cap_foil_dist_frm_bottom" size="3" maxlength="3" value="<?php echo set_value('cap_foil_dist_frm_bottom');?>">
									</td>
									</tr>


                    <?php }
                    ?>

									<tr>		

									<!---------------------END --->
									<tr>
										<td class="label">Label Price :</td>
										<td colspan="3"><input type="text" class="number" name="label_price"    id="label_price" size="35" maxlength="5" value="<?php echo set_value('label_price');?>" >
										</td>
									</tr>

								</table>
							</fieldset>
						</td>						

					 </tr>						
						
						
					</table>						 
				</td>
				<td width="50%">
					<table class="form_table_inner">
						<!-- QUOTE -->
						<tr>
							<td colspan="5" width="100%">
								<fieldset>
										<legend>Quote:</legend>
								<table class="form_table_inner">
									<tr>
										<th width="2%"> </th><th width="18%">Quote</th><th width="20%">Target Contr.</th><th width="20%">Quoted Contr.</th><th width="20%">Cost</th>	<th width="20%">Quoted Price</th>
									</tr>
									<tr>
										<td><input type="checkbox" name="less_than_10k_flag" id="less_than_10k_flag" value="1" <?php echo set_checkbox('less_than_10k_flag','1');?> /></td>

										<td class="label"> < 10K <span style="color:red;">*</span></td>

										<td ><input type="text" class="number1" name="less_than_10k_target_contr" id="less_than_10k_target_contr"   value="<?php echo set_value('less_than_10k_target_contr');?>"  />
										</td>
										<td ><input type="text" class="number1" name="less_than_10k_quoted_contr" id="less_than_10k_quoted_contr"  value="<?php echo set_value('less_than_10k_quoted_contr');?>"  />
										</td>
										<td ><input type="text" class="number1" name="less_than_10k_cost" id="less_than_10k_cost"  value="<?php echo set_value('less_than_10k_cost');?>" />
										</td>
										

										<td > <input type="text" class="number1" name="less_than_10k_quoted_price" id="less_than_10k_quoted_price"  value="<?php echo set_value('less_than_10k_quoted_price');?>" />
										</td>
									</tr>
									<tr>
										<td><input type="checkbox" name="_10k_to_25k_flag" id="_10k_to_25k_flag" value="1" <?php echo set_checkbox('_10k_to_25k_flag','1');?> /></td>
										<td class="label" >10K - 25K <span style="color:red;">*</span></td>
										<td><input type="text" class="number1" name="_10k_to_25k_target_contr" id="_10k_to_25k_target_contr"  value="<?php echo set_value('_10k_to_25k_target_contr');?>" />
										</td>
										<td><input type="text" class="number1" name="_10k_to_25k_quoted_contr" id="_10k_to_25k_quoted_contr"  value="<?php echo set_value('_10k_to_25k_quoted_contr');?>" />
										</td>
										<td><input type="text" class="number1" name="_10k_to_25k_cost" id="_10k_to_25k_cost"   value="<?php echo set_value('_10k_to_25k_cost');?>"  />
										</td>

										

										<td><input type="text" class="number1" name="_10k_to_25k_quoted_price" id="_10k_to_25k_quoted_price" value="<?php echo set_value('_10k_to_25k_quoted_price');?>" />
										</td>
									</tr>
									<tr>
										<td><input type="checkbox" name="_25k_to_50k_flag" id="_25k_to_50k_flag" value="1" <?php echo set_checkbox('_25k_to_50k_flag','1');?> /></td>
										<td class="label">25K - 50K <span style="color:red;">*</span></td>
										<td><input type="text" class="number1" name="_25k_to_50k_target_contr" id="_25k_to_50k_target_contr"  value="<?php echo set_value('_25k_to_50k_target_contr');?>" />
										</td>
										<td><input type="text" class="number1" name="_25k_to_50k_quoted_contr" id="_25k_to_50k_quoted_contr"  value="<?php echo set_value('_25k_to_50k_quoted_contr');?>" />
										</td>
										<td><input type="text" class="number1" name="_25k_to_50k_cost" id="_25k_to_50k_cost"  value="<?php echo set_value('_25k_to_50k_cost');?>" />
										</td>

										

										<td><input type="text" class="number1" name="_25k_to_50k_quoted_price" id="_25k_to_50k_quoted_price"  value="<?php echo set_value('_25k_to_50k_quoted_price');?>" />
										</td>
									</tr>
									<tr>
										<td><input type="checkbox" name="_50k_to_100k_flag" id="_50k_to_100k_flag" value="1" <?php echo set_checkbox('_50k_to_100k_flag','1');?> /></td>
										<td class="label">50K - 100K <span style="color:red;">*</span></td>
										<td><input type="text" class="number1" name="_50k_to_100k_target_contr" id="_50k_to_100k_target_contr"  value="<?php echo set_value('_50k_to_100k_target_contr');?>" />
										</td>
										<td><input type="text" class="number1" name="_50k_to_100k_quoted_contr" id="_50k_to_100k_quoted_contr"  value="<?php echo set_value('_50k_to_100k_quoted_contr');?>" />
										</td>
										<td><input type="text" class="number1" name="_50k_to_100k_cost" id="_50k_to_100k_cost"  value="<?php echo set_value('_50k_to_100k_cost');?>"  />
										</td>

										

										<td><input type="text" class="number1" name="_50k_to_100k_quoted_price" id="_50k_to_100k_quoted_price"  value="<?php echo set_value('_50k_to_100k_quoted_price');?>" />
										</td>
									</tr>
									<tr>
										<td><input type="checkbox" name="_100k_to_250k_flag" id="_100k_to_250k_flag" value="1" <?php echo set_checkbox('_100k_to_250k_flag','1');?> /></td>
										<td class="label">100K -250K <span style="color:red;">*</span></td>
										<td><input type="text" class="number1" name="_100k_to_250k_target_contr" id="_100k_to_250k_target_contr"  value="<?php echo set_value('_100k_to_250k_target_contr');?>"  />
										</td>
										<td><input type="text" class="number1" name="_100k_to_250k_quoted_contr" id="_100k_to_250k_quoted_contr"  value="<?php echo set_value('_100k_to_250k_quoted_contr');?>" />
										</td>
										<td><input type="text" class="number1" name="_100k_to_250k_cost" id="_100k_to_250k_cost"  value="<?php echo set_value('_100k_to_250k_cost');?>"  />
										</td>

										

										<td><input type="text" class="number1" name="_100k_to_250k_quoted_price" id="_100k_to_250k_quoted_price" value="<?php echo set_value('_100k_to_250k_quoted_price');?>" />
										</td>
									</tr>
									<tr>
										<td><input type="checkbox" name="greater_than_250k_flag" id="greater_than_250k_flag" value="1" <?php echo set_checkbox('greater_than_250k_flag','1');?> /></td>
										<td class="label">>250K <span style="color:red;">*</span></td>
										<td><input type="text" class="number1" name="greater_than_250k_target_contr" id="greater_than_250k_target_contr"  value="<?php echo set_value('greater_than_250k_target_contr');?>"  />
										</td>
										<td><input type="text" class="number1" name="greater_than_250k_quoted_contr" id="greater_than_250k_quoted_contr"  value="<?php echo set_value('greater_than_250k_quoted_contr');?>" />
										</td>
										<td><input type="text" class="number1" name="greater_than_250k_cost" id="greater_than_250k_cost"  value="<?php echo set_value('greater_than_250k_cost');?>" />
										</td>

										

										<td><input type="text" class="number1" name="greater_than_250k_quoted_price" id="greater_than_250k_quoted_price"  value="<?php echo set_value('greater_than_250k_quoted_price');?>"  />
										</td>
									</tr>

								</table>
							</fieldset>
							</td>
						</tr>
						
						<!-- Freight Price Range -->
						
						<tr>
							<td colspan="4">
						
								<fieldset>
									<LEGEND> Freight & Packaging:</LEGEND>
									<table class="form_table_inner">		
									<tr>
										<td class="label">Freight <span style="color:red;">*</span> :</td>
										<td colspan="3"><input type="text" name="freight" id="freight"  value="<?php echo set_value('freight');?>" />
										</td>
									</tr>
									<tr>
										<td class="label">Packaging <span style="color:red;">*</span> :</td>
										<td colspan="3"><input type="text" name="packing" id="packing"  value="<?php echo set_value('packing');?>" />
										</td>
									</tr>
									
									</table>
								</fieldset>
							</td>
						</tr>
						<!-- Cost sheet details -->
						<tr>
							<td colspan="4">						
								<fieldset>
									<LEGEND> Cost Taken Based On:</LEGEND>
									<table class="form_table_inner">		
										
										<tr>
											<td class="label">Invoice no <span style="color:red;">*</span> :</td>
											<td colspan="3"><input type="text" name="invoice_no" id="invoice_no"  value="<?php echo set_value('invoice_no');?>" />
											</td>
										</tr>
										


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
										<td class="label" width="27%">Remarks :</td>
										<td colspan="3" >
											<textarea name="remarks" id="remarks" cols="50" rows="5" value="<?php echo trim(set_value('remarks'));?>" maxlength="512"><?php echo trim(set_value('remarks'));?></textarea>
										</td>
									</tr>
									<tr>
										<td class="label">Approval Authority :</td>
										<td>
											<select name="approval_authority">
											<option value=''>--Select Authority--</option>
											<?php 
												foreach ($approval_authority as $approval_authority_row) {
												echo "<option value='".$approval_authority_row->employee_id."' ".set_select('approval_authority',$approval_authority_row->employee_id).">".strtoupper($approval_authority_row->username)."</option>";
												}
											?>
										</select>
										</td>
									</tr>									
								</table>
								</fieldset>	


								<fieldset>
									<legend>Cost :</legend>

								<table class="form_table_inner">
									<tr>
										<td class="label" width="27%">Sleeve Cost :</td>
										<td colspan="3" ><span id="sleeve_cost_view"></span></td>
									</tr>

									<tr>
										<td class="label" width="27%">Shoulder Cost :</td>
										<td colspan="3" ><span id="shoulder_cost_view"></span></td>
									</tr>

									<tr>
										<td class="label" width="27%">Lacquer Cost :</td>
										<td colspan="3" ><span id="lacquer_cost_view"></span></td>
									</tr>

									<tr>
										<td class="label" width="27%">Label Cost :</td>
										<td colspan="3" ><span id="label_cost_view"></span></td>
									</tr>

									<tr>
										<td class="label" width="27%">Offset Cost :</td>
										<td colspan="3" ><span id="offset_cost_view"></span></td>
									</tr>
																		
								</table>
								</fieldset>	


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


	</div>	

	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button" onClick="return confirm('Are you sure to save Record?');">Save</button>
		</div>
	</div>

	
</form>




				
				
				
			