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

.doc-no-align{
  border-bottom: solid 1px #D9d9d9;
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  padding: 10px;
  height: 50px;
}
.doc-rev{
  padding: 10px;
  height: 50px;
  display: flex;
  justify-content: space-between;
}

p{font-weight: 700;
    color: red;}


</style>
</head>
<body>
    <div class="invoice-box" id="invoice"> 

    <div class="doc-no-align">
        <h4 style="margin-top: 6px;">CONTROL PLAN OF PRINTING SPRING TUBE</h4>
        <img src="<?php echo base_url('assets/img/logo.png');?>" style="max-width:130px;height:30px;">
    </div> 

    <div class="doc-rev" >
        <p>Document No - QC/F/36</p>
        <p>Revision No - 01</p>
        <p>Revision Date - 15/05/2023</p>
    </div>
 

