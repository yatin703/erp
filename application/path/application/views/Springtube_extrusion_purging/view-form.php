

<?php foreach ($springtube_extrusion_purging_master as $master_row):

    $order_no='';
    $order_date='';
    $article_no='';
    $customer='';

    $production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $master_row->jobcard_no);
              
    foreach($production_master_result as $row) {
        $order_no=$row->sales_ord_no;
        $article_no=$row->article_no;
    }

    $data['order_master']=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);
    foreach($data['order_master'] as $order_master_row){
        $order_date=$order_master_row->order_date;
        $customer=$order_master_row->customer_no;
                
    }


?>
  
      
    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        PURGING REPORT
      </div>
    </div>

        <?php echo $master_row->final_approval_flag==1 ? '<span class="ui green right ribbon label"><i class="check circle icon"></i> Approved</span>' : '<span class="ui red right ribbon label">Unapproved</span>';?>

        <br/>

        <?php echo $this->common_model->view_date($master_row->purging_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label"><i class="calendar alternate outline icon"></i>'.$this->common_model->view_date($master_row->purging_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '';?>
        <br/>
        <br/>

        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="15%"> <i class="cogs icon"></i> PROCESS</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="30%" style="border-right:1px solid #D9d9d9;"><?php echo 'SPRINGTUBE PURGING';?></td>
                <td width="15%"><i class="bars icon"></i> JOBCARD NO </td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="30%"><?php echo $master_row->jobcard_no ;?></td>
                
                
                
            </tr>
        
            <tr class="item">
                <td> <b>REF JOBCARD </b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->ref_jobcard_no ;?></td>
                <td></i><b>REASON</b></td>                
                <td style="border-right:1px solid #D9d9d9;"></td> 
                <td><div class="ui red label"><?php echo $master_row->reason ;?></div></td>
            </tr>

            <tr class="item">
                <td><b>CUSTOMER </b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $this->common_model->get_customer_name($customer,$this->session->userdata['logged_in']['company_id']) ;?></td>
                <td></i><b>REMARKS</b></td>                
                <td style="border-right:1px solid #D9d9d9;"></td> 
                <td><?php echo $master_row->remarks ;?></td>
            </tr>
            <tr class="item">
                <td> <b>ORDER DATE </b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $this->common_model->view_date($order_date,$this->session->userdata['logged_in']['company_id']) ;?></td>
                <td></i><b>ORDER NO</b></td>                
                <td style="border-right:1px solid #D9d9d9;"></td> 
                <td><div ><?php echo $order_no ;?></div></td>
            </tr>
            <tr class="item">
                <td> <b>PRODUCT CODE </b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $article_no ;?></td>
                <td></i><b>PRODUCT NAME</b></td>                
                <td style="border-right:1px solid #D9d9d9;"></td> 
                <td><div ><?php echo $this->common_model->get_article_name($article_no,$this->session->userdata['logged_in']['company_id']) ;?></div></td>
            </tr>

            <tr class="item">
                <td><b>OPERATOR</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $this->common_model->get_user_name($master_row->user_id,$this->session->userdata['logged_in']['company_id']) ;?></td>              
                <td><b>SHIFT TIME</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td><?php echo $master_row->created_date;?></td>
            </tr>

            <tr class="item">
                <td><b>APPROVED BY</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $this->common_model->get_user_name($master_row->approved_by,$this->session->userdata['logged_in']['company_id']);?></td>
                <td><b>APPROVAL DATE</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $this->common_model->view_date($master_row->approved_date,$this->session->userdata['logged_in']['company_id']) ;?></td>              
                
            </tr>

            


        </table>


        
        <br/>                     
        <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="2%" style="border-right:1px solid #D9d9d9;">SR NO</td>
                <td width="1%"></td>
                <td width="15%" style="border-right:1px solid #D9d9d9;"><b>PURGING MATRIAL</b></td>
                <td width="30%" style="border-right:1px solid #D9d9d9;"><b>PURGING MATRIAL NAME</b></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"><b>QUANTITY</b></td>
                
               
            </tr>
            <?php
            $i=1;
            $sum_quantity=0;
            
                
                foreach ($springtube_extrusion_purging_details as  $details_row) {

                    $sum_quantity+=$details_row->quantity;
                    
                    

                    echo '<tr class="item">
                        <td style="border-right:1px solid #D9d9d9;">'.$i++.'</td>
                        <td></td>                        
                        <td style="border-right:1px solid #D9d9d9;">'.$details_row->article_no.'</td>
                        <td style="border-right:1px solid #D9d9d9;">'.$this->common_model->get_article_name($details_row->article_no,$this->session->userdata['logged_in']['company_id']).'</td>
                         <td style="border-right:1px solid #D9d9d9;">'.$details_row->quantity.'</td>
                       
                        ';
                }
                echo'</tr>
                <tr  class="item last" style="border-right:1px solid #D9d9d9;">
                <td colspan="4" style="border-right:1px solid #D9d9d9;"><b>TOTAL</b></td>
                <td style="border-right:1px solid #D9d9d9;"><b>'.$sum_quantity.'</b></td>
                </tr>';
            ?>
        </table>
        <br/>
        <br/>
        
                
     <?php endforeach;?>
    </div>
</body>
</html>   