<?php foreach ($company_details as $company_details_row):?>
    <?php foreach ($company as $company_row):?>
        <?php foreach ($customer as $customer_row):?>

            <?php echo $customer_row->lang_property_name!='' ? '<span class="ui green right ribbon label">'.$customer_row->lang_property_name.'</span>' : '<span class="ui red right ribbon label"></span>';?>

            <br/>

            <?php echo $this->common_model->view_date($customer_row->contact_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label">'.$this->common_model->view_date($customer_row->contact_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '';?>
            <br/>
            <br/>
    <table cellpadding="0" cellspacing="4">
            <tr class="heading">
                <td width="20%">
                    <?php echo strtoupper($this->router->fetch_class());?>
                </td>
                <td></td>
                
                <td>
                    ADDRESS
                </td>
            </tr>
            
            <tr class="details">

                <td>
                    <?php echo $customer_row->name1;?>
                </td>
                <td></td>
                <td>
                    <?php echo $customer_row->strno." ".$customer_row->name2." ".$customer_row->street." ".$customer_row->street." ".$customer_row->name3;?><br>
                    <?php 
                    $state_result=$this->customer_model->select_one_active_state_country_record('zip_code_master',$company_row->company_id,'zip_code',$customer_row->zip_code);

                    $country_result=$this->customer_model->select_one_active_state_country_record('country_master_lang',$company_row->company_id,'country_id',$customer_row->country_id);

                    if($country_result==FALSE){
                        echo '';
                    }else{
                        foreach($country_result as $country){
                            echo $country->lang_country_name;
                            echo "<br>";
                        }
                    }

                    if($state_result==FALSE){
                        echo '';
                    }else{
                        foreach($state_result as $state){
                            echo strtoupper($state->lang_city)." ".$state->state_code;
                            echo "<br>";
                        }
                    }

                    ?>
                </td>
            </tr>
            
            <tr class="heading">
                <td colspan="3">
                    OTHER DETAILS
                </td>
            </tr>

            <tr class="item">
                <td>Customer Id</td>
                <td></td>
                <td><?php echo $customer_row->adr_company_id;?></td>
            </tr>

           <tr class="item">
                <td>Email</td>
                <td></td>
                <td><?php echo $customer_row->email;?></td>
            </tr>

            <tr class="item">
                <td>Contact</td>
                <td></td>
                <td><?php echo $customer_row->telephone1." ".$customer_row->telephone2; ?></td>
            </tr>
            
            <tr class="item">
                <td>PAN No</td>
                <td></td>
                <td><?php echo $customer_row->post_box_code;?></td>
            </tr>

             <tr class="item">
                <td>GST No</td>
                <td></td>
                <td><?php echo $customer_row->isdn_local;?></td>
            </tr>

            <tr class="item">
                <td>Transit Days</td>
                <td></td>
                <td><?php echo $customer_row->transit_days;?></td>
            </tr>
            
            <tr class="item">
                <td>Payment Term</td>
                <td></td>
                <td><?php echo $customer_row->lang_description;?></td>
            </tr>

            <tr class="item">
                <td>Bank</td>
                <td></td>
                <td><?php echo $customer_row->bank_name." ".$customer_row->bank_code;?></td>
            </tr>

            <tr class="item last">
                <td>Account No</td>
                <td></td>
                <td><?php echo $customer_row->account_no;?></td>
            </tr>

        </table>

        <table cellpadding="0" cellspacing="4">
            <tr class="heading">
                <td width="20%">
                    LINKED DETAILS
                </td>
                <td></td>
                
                <td>
                    
                </td>
            </tr>
            <?php
            $data['bill_to']=$this->common_model->select_one_active_record_nonlanguage_without_archive('adr_relate_companies',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$customer_row->adr_company_id);
            if($data['bill_to']==FALSE){

                echo "<tr>
                    <td colspan='3'>NO RECORD FOUND</td>
                </tr>";

            }else{

            
                $i=1;
                foreach($data['bill_to'] as $bill_to_row){
                    $data['ship_to']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$bill_to_row->related_company_id);
                    
                    foreach($data['ship_to'] as $ship_to_row){
                        echo "<tr>
                                <td>$i</td>
                                <td></td>
                                <td><a href=".base_url('index.php/'.$this->router->fetch_class().'/view/'.$ship_to_row->adr_company_id.'')." target='_blank'> ($ship_to_row->adr_company_id) $ship_to_row->name1</a></td>
                            </tr>";
                            $i++;
                    }
                }
            }
            ?>
        </table>


    </div>
</body>
        <?php endforeach;?>
    <?php endforeach;?>
<?php endforeach;?>
</html>
