

<?php foreach ($springtube_printing_production_master as $master_row):
    
    $jobcard_qty='';
    $ad_id='';
    $version_no='';
    $bom_no='';
    $bom_version_no='';
    $order_no='';
    $article_no='';

    $production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $master_row->jobcard_no);
              
    foreach($production_master_result as $row) {
          $order_no=$row->sales_ord_no;
          $article_no=$row->article_no;
          $jobcard_qty=$this->common_model->read_number($row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
    }

    $data_order_details=array(
        'order_no'=>$master_row->order_no,
        'article_no'=>$master_row->article_no
        );

    $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
    foreach($order_details_result as $order_details_row){
      $ad_id=$order_details_row->ad_id;
      $version_no=$order_details_row->version_no;
      $bom_no=$order_details_row->spec_id;
      $bom_version_no=$order_details_row->spec_version_no;
    }



?>
   
      
    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        PRINTING REPORT
      </div>
    </div>

        <?php echo $master_row->final_approval_flag==1 || 1 ? '<span class="ui green right ribbon label"><i class="check circle icon"></i> Approved</span>' : '<span class="ui red right ribbon label">Unapproved</span>';?>

        <br/>

        <?php echo $this->common_model->view_date($master_row->production_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label"><i class="calendar alternate outline icon"></i>'.$this->common_model->view_date($master_row->production_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '';?>
        <br/>
        <br/>

        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="10%"> <i class="cogs icon"></i> PROCESS</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo 'SPRINGTUBE PRINTING';?></td>
                <td width="15%"><i class="user secret icon"></i> MACHINE</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="30%"><?php echo $master_row->machine_name ;?></td>
                
                
                
            </tr>
        
            <tr class="item">
                <td><i class="bars icon"></i> <b>SHIFT</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->shift ;?></td>
                <td><i class="paypal icon"></i><b>OPERATOR</b></td>                
                <td style="border-right:1px solid #D9d9d9;"></td> 
                <td><?php echo $master_row->login_name ;?></td>
            </tr>
            

        </table>


        
        <br/>                     
        <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="2%" style="border-right:1px solid #D9d9d9;">SR NO</td>
                <td width="1%"></td>
                <td width="7%" style="border-right:1px solid #D9d9d9;"><b>CUSTOMER</b></td>
                <td width="6%" style="border-right:1px solid #D9d9d9;"><b>ORDER</b></td>
                <td width="6%" style="border-right:1px solid #D9d9d9;"><b>PRODUCT</b></td>
                <td width="6%" style="border-right:1px solid #D9d9d9;"><b>ARTWORK</b></td>
                <td width="7%" style="border-right:1px solid #D9d9d9;"><b>JOBCARD</b></td>
                <td width="7%" style="border-right:1px solid #D9d9d9;"><b>DIA X LENGTH</b></td>
                <td width="7%" style="border-right:1px solid #D9d9d9;"><b>PRINT TYPE</b></td>
                <td width="7%" style="border-right:1px solid #D9d9d9;"><b>LAMINATE COLOR</b></td>

                <td width="7%" style="border-right:1px solid #D9d9d9;"><b>BODY MAKING TYPE</b></td>
                <td width="7%" style="border-right:1px solid #D9d9d9;"><b>JOB CARD QTY</b></td>

                <td width="7%" style="border-right:1px solid #D9d9d9;"><b>COUNTER</b></td>
                <td width="7%" style="border-right:1px solid #D9d9d9;"><b>PRINTING QTY</b></td>
                <td width="7%" style="border-right:1px solid #D9d9d9;"><b>STOP REASON</b></td>
            </tr>
            <?php
            $i=1;
            $sum_counter=0;
            $sum_printing_qty=0;

            $rowspan=count($springtube_printing_production_details);
            $tr=$rowspan;
            
            echo'<tr class="item">
                    <td style="border-right:1px solid #D9d9d9;" rowspan="'.$rowspan.'" >'.$i++.'</td>
                    <td rowspan="'.$rowspan.'" ></td>
                    <td style="border-right:1px solid #D9d9d9;" rowspan="'.$rowspan.'" >'.$this->common_model->get_customer_name($master_row->customer,$this->session->userdata['logged_in']['company_id']).'</td>

                    <td style="border-right:1px solid #D9d9d9;" rowspan="'.$rowspan.'" >'.$master_row->order_no.'</td>
                    <td style="border-right:1px solid #D9d9d9;" rowspan="'.$rowspan.'" >'.$this->common_model->get_article_name($master_row->article_no,$this->session->userdata['logged_in']['company_id']).'['.$master_row->article_no.']</td>
                    <td style="border-right:1px solid #D9d9d9;" rowspan="'.$rowspan.'" >'.$ad_id.'_R'.$version_no.'</td>
                    <td style="border-right:1px solid #D9d9d9;" rowspan="'.$rowspan.'" >'.$master_row->jobcard_no.'</td>
                    <td style="border-right:1px solid #D9d9d9;" rowspan="'.$rowspan.'" >'.$master_row->sleeve_dia.' X '.$master_row->sleeve_length.'</td>
                    <td style="border-right:1px solid #D9d9d9;" rowspan="'.$rowspan.'" >'.$master_row->print_type.'</td>
                    <td style="border-right:1px solid #D9d9d9;" rowspan="'.$rowspan.'" >'.$master_row->laminate_color.'</td>
                    <td style="border-right:1px solid #D9d9d9;" rowspan="'.$rowspan.'" >'.$master_row->body_making_type.'</td>
                    <td style="border-right:1px solid #D9d9d9;" rowspan="'.$rowspan.'" >'.$jobcard_qty.'</td>
                    ';
                
                if($rowspan>0){ 

                    $r=0;

                    foreach ($springtube_printing_production_details as  $details_row) {

                        $sum_counter+=$details_row->counter;
                        $sum_printing_qty+=$details_row->counter*2;

                        echo '<td style="border-right:1px solid #D9d9d9;">'.$details_row->counter.'</td>
                        <td style="border-right:1px solid #D9d9d9; text-align:left;">'.round($details_row->counter*2).'</td>
                            <td style="border-right:1px solid #D9d9d9; text-align:left;">'.$details_row->stop_reason.'</td>';
                        
                        echo "</tr>";

                        if($rowspan>1 && --$tr>0){
                            echo'<tr class="item">';
                        }

                        $r++;    
                           
                    }
                }else{
                    
                    echo'<td style="border-right:1px solid #D9d9d9;"></td><td style="border-right:1px solid #D9d9d9;"></td><td style="border-right:1px solid #D9d9d9;"></td>';
                    echo '</tr>';
                }
                


                echo'<tr><td style="border-right:1px solid #D9d9d9;" colspan="11"><b>TOTAL</b></td><td style="border-right:1px solid #D9d9d9;"></td><td style="border-right:1px solid #D9d9d9;"><b>'.$sum_counter.'</b></td><td style="border-right:1px solid #D9d9d9;"><b>'.$sum_printing_qty.'</b></td></tr>';
            ?>
        </table>
        <br/>
        <br/>
        
                
     <?php endforeach;?>
    </div>
</body>
</html>   