<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php ucwords($this->router->fetch_class());?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/print.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/semantic/semantic.min.css');?>">

     <script src="<?php echo base_url('assets/js/pdf.js');?>"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>

     <style>

.coa.label {
   font-size: 14px;
   font-weight: 800;
   color: #000000;
   text-align: left;
   margin-right: 625px;
}
.logo{
 text-align: right;	
}
.doc-no-align {
    display: inline-flex;
    margin: auto;
    border-bottom: 1px solid #000;
vertical-align: middle!important;
}
.doc-rev{
	margin-top: 5px;
	display: inline-flex;
	margin-bottom: 25px;
}

</style>
</head>
<body>
    <div class="invoice-box" id="invoice"> 

    <div class="doc-no-align " >
      <div class="coa label">
        <h3>CERTIFICATE OF ANALYSIS</h3>
      </div>
      <div class="logo">     	
            <img src="<?php echo base_url('assets/img/logo.png');?>" style="max-width:130px;height:30px;">
      </div>
    </div> 

    <div class="doc-rev" >
      <div class="doc no">
        <p style="font-size: 12px;font-weight: 500;margin-right: 280px;">Document No: QC/F/22</p>
      </div>
      <div class="rev-no" style="text-align: center !important;">     	
        <p style="font-size: 12px;font-weight: 500;margin-right: 280px;">Revision No:05</p>
      </div>
      <div class="rev-date" style="text-align: right !important;">     	
        <p style="font-size: 12px;font-weight: 500;">Revision Date:16/05/2023</p>
      </div>
    </div>


