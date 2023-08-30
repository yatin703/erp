<?php foreach ($company_details as $company_details_row):?>
    <?php foreach ($company as $company_row):?>
        <?php foreach ($supplier as $supplier_row):?>
    <table cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td>
                    <?php echo strtoupper($this->router->fetch_class());?>
                </td>
                <td>
                    
                </td>
                
                <td>
                    ADDRESS
                </td>
            </tr>
            
            <tr class="details">
                <td>
                    <?php echo $supplier_row->name1;?>
                </td>

                <td>
                    
                </td>
                
                <td>
                    <?php echo $supplier_row->strno." ".$supplier_row->name2." ".$supplier_row->street." ".$supplier_row->street." ".$supplier_row->name3;?><br>
                    <?php 
                    $state_result=$this->supplier_model->select_one_active_state_country_record('zip_code_master',$company_row->company_id,'zip_code',$supplier_row->zip_code);

                    $country_result=$this->supplier_model->select_one_active_state_country_record('country_master_lang',$company_row->company_id,'country_id',$supplier_row->country_id);

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
                <td>EMAIL</td>
                <td></td>
                <td><?php echo $supplier_row->email;?></td>
            </tr>

            <tr class="item">
                <td>CONTACT NO</td>
                <td></td>
                <td><?php echo $supplier_row->telephone1." ".$supplier_row->telephone2; ?></td>
            </tr>

            <tr class="item">
                <td>PROPERTY</td>
                <td></td>
                <td><?php echo $supplier_row->lang_property_name; ?></td>
            </tr>

            <tr class="item">
                <td>FINANCE LEDGER NO</td>
                <td></td>
                <td><?php echo $supplier_row->financial_account_no; ?></td>
            </tr>
            
            <tr class="item">
                <td>PAN NO</td>
                <td></td>
                <td><?php echo $supplier_row->post_box_code;?></td>
            </tr>

             <tr class="item">
                <td>GST No</td>
                <td></td>
                <td><?php echo $supplier_row->isdn_local;?></td>
            </tr>

            <tr class="item">
                <td>TRANSIT DAYS</td>
                <td></td>
                <td><?php echo $supplier_row->transit_days;?></td>
            </tr>
            
            <tr class="item">
                <td>PAYMENT TERM</td>
                <td></td>
                <td><?php echo $supplier_row->lang_description;?></td>
            </tr>

            <tr class="item">
                <td>BANK</td>
                <td></td>
                <td><?php echo $supplier_row->bank_name." ".$supplier_row->bank_code;?></td>
            </tr>

            <tr class="item last">
                <td>ACCOUNT NO</td>
                <td></td>
                <td><?php echo $supplier_row->account_no;?></td>
            </tr>
        </table>
    </div>
</body>
        <?php endforeach;?>
    <?php endforeach;?>
<?php endforeach;?>
</html>
