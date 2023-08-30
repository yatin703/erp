<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php 
	if(!empty($this->uri->segment(2))){
		echo str_replace('_',' ',strtoupper($this->uri->segment(2)));}else{
		echo str_replace('_',' ',strtoupper($this->uri->segment(1)));
		};?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/main.css');?>"/>
	<link rel="stylesheet" href="<?php echo base_url('assets/css/jquery.calendars.picker.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/semantic/semantic.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/modal.css');?>">
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.min.js');?>"></script>
	<script type="text/javascript">
	var auto_refresh = setInterval(function (){
	$('.time').load('<?php echo base_url('index.php/Login/time');?>').fadeIn("slow");}, 10000); 
	</script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.mini.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.calendars.js');?>"></script> 
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.calendars.plus.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.plugin.js');?>"></script> 
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.calendars.picker.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/treemenu/TreeMenu.js');?>" ></script>
	<script type="text/javascript">
	
	$(function() {

		$('#from_date,#to_date').calendarsPicker({dateFormat: 'yyyy-mm-dd'},{ 
    onSelect: customRange, showTrigger: '#calImg'}); 
		function customRange(dates) { 
		  	if (this.id == 'from_date') { 
		        $('#to_date').calendarsPicker('option', 'minDate',dates[0] || null); 
		    } 
		    else { 
		        $('#from_date').calendarsPicker('option', 'maxDate',dates[0] || null); 
		    } 
		}

		$('#validMinPicker').calendarsPicker({dateFormat: 'yyyy-mm-dd',
    	minDate:+1, showTrigger: '#calImg'});

   
	});

	
	
</script>

<script language="JavaScript">
    function clp_clear() {
        var content=window.clipboardData.getData("Text");
        if (content==null) {
            window.clipboardData.clearData();
        }
        setTimeout("clp_clear();",1000);
    }
    </script>
	<style type="text/css" media="print">
    * { display: none; }
</style>

</head>
<body onload='clp_clear()'>
<?php setlocale(LC_MONETARY, 'en_IN');?>