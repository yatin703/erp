<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php ucwords($this->router->fetch_class());?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/print.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/semantic/semantic.min.css');?>">

     <script src="<?php echo base_url('assets/js/pdf.js');?>"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
</head>



<body>
    <div class="invoice-box" id="invoice">
    <?php foreach ($company_details as $company_details_row):?>
        <?php foreach ($company as $company_row):?>
        <table cellpadding="0" cellspacing="0" border="0">          
                        <tr>
                            <td class="title" width="5%">
                                <img src="<?php echo base_url('assets/img/'.$company_details_row->logo.'');?>" style="max-width:130px;height:30px;">
                            </td>
                            <td width="1%"></td>
                            <td>
                                <?php echo "<b>".strtoupper($company_row->title)."</b>";?><br>
                                <?php echo strtoupper($company_row->street);?><br>
                            </td>
                        </tr>           
           
        </table>
          <?php endforeach;?>
    <?php endforeach;?>