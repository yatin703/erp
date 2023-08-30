<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php ucwords($this->router->fetch_class());?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/print.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/semantic/semantic.min.css');?>">
</head>



<body>
    <div class="invoice-box">
    <?php foreach ($company_details as $company_details_row):?>
        <?php foreach ($company as $company_row):?>
        
        <table cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;">
            <tr>

            <td width="80%">   
                <table cellpadding="0" cellspacing="0" border="0"  width="50%" style="border-collapse:collapse;border:0;">          
                    <tr>
                        <td class="title" width="5%">
                            <img src="<?php echo base_url('assets/img/'.$company_details_row->logo.'');?>" style="max-width:30px;height:30px;">
                        </td>
                        <td width="1%"></td>
                        <td>
                            <?php echo "<b>".strtoupper($company_row->title)."</b>";?><br>
                            <?php echo strtoupper($company_row->street);?><br>
                        </td>
                    </tr>           
                   
                </table>
            </td>
            <td>   

                <table cellpadding="0" cellspacing="0" border="0" width="50%" style="border-collapse:collapse;border:0;">          
                    <tr>
                        <td class="title" width="5%">
                            <?php                              

                                echo $doc['doc_no'];
                                echo'</br>';
                                echo'Rev no: '.$doc['rev_no'].' Date: '.$this->common_model->view_date($doc['date'],$this->session->userdata['logged_in']['company_id']);
                                echo'</br>';
                                //echo'Page No 1 Of 1';

                        ?>
                        </td>                             
                    </tr>           
                   
                </table>
            </td>
        </tr>

    </table>            
          <?php endforeach;?>
    <?php endforeach;?>