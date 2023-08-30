<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>ERP</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/main.css');?>"/>
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.min.js');?>"></script>
	<script type="text/javascript">
	var auto_refresh = setInterval(function (){
	$('.time').load('<?php echo base_url('index.php/Login/time');?>').fadeIn("slow");}, 10); 
	</script>
</head>
<body>
	
	<section class="container">
		<article class="container_header">
			<div class="cmp_name">ERP</div>
		</article>
		<article class="container_title">
			<h2>Company Setup</h2>
		</article>