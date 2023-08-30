

<?php foreach ($sales_quote_master as $sales_quote_master_row):?>
         
    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        SALES QUOTE
      </div>

    </div>

    <?php echo $sales_quote_master_row->final_approval_flag==1 ? '<span class="ui green right ribbon label"><i class="check circle icon"></i> Approved</span>' : '<span class="ui red right ribbon label">Unapproved</span>';?>

        <br/>

        <?php echo $this->common_model->view_date($sales_quote_master_row->quotation_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label"><i class="calendar alternate outline icon"></i>'.$this->common_model->view_date($sales_quote_master_row->quotation_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '';?>
        <br/>
        <br/>

        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr class="heading">
                <td width="15%"><b>QUOTE NO</td>
                <td width="1%"></td>
                <td width="34%" style="border-right:1px solid #D9d9d9;"><b><?php echo $sales_quote_master_row->quotation_no;?></b></td>
                <td width="15%">QUOTE DATE</td>
                <td width="1%"></td>
                <td width="34%"><?php echo $this->common_model->view_date($sales_quote_master_row->quotation_date,$this->session->userdata['logged_in']['company_id']); ?></td>
            </tr>

            <tr class="item last">
                <td>PREPARED BY  </td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;">
                    <?php echo $this->common_model->get_user_name($sales_quote_master_row->user_id,$this->session->userdata['logged_in']['company_id']);?>

                </td>
                
                <td>QUOTE VALIDITY</td>
                <td></td>
                <td><i>FOR 30 DAYS</i></td>
            </tr>

        </table>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr class="heading">
                <td width="15%"><b>BILLING </td>
                <td width="1%"></td>
                <td width="34%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="15%"><b>SHIPPING</td>
                <td width="1%"></td>
                <td width="34%"></td>
            </tr>

            <tr class="item">
                <td><b>BILL TO</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><b>
                    <?php $customer_result=$this->common_model->select_one_active_record('address_category_master',$this->session->userdata['logged_in']['company_id'],'adr_category_id',$sales_quote_master_row->customer_no);
                if($customer_result==TRUE){
                    foreach($customer_result as $customer_row){
                        echo $customer_row->category_name;
                    }
                }

                ?></b></td>
                <td><b>SHIP TO</b></td>
                <td></td>
                <td>SAME AS BILLING</td>
            </tr>

            <tr class="item">
                <td><b>NAME</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;">
                    <?php
                    $sales_quote_customer_contact_details=$this->common_model->select_one_record_with_company('address_category_contact_details',$this->session->userdata['logged_in']['company_id'],'address_category_contact_id',$sales_quote_master_row->pm_1);
                                    foreach ($sales_quote_customer_contact_details as $key => $sales_quote_customer_contact_details_row) {
                                        echo $sales_quote_customer_contact_details_row->contact_name;
                                    }

                    ?>
                    
                </td>
                <td><b>NAME</b></td>
                <td></td>
                <td>-</td>
            </tr>


            <tr class="item">
                <td><b>CONTACT NO</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;">
                    <?php echo $sales_quote_master_row->company_contact_no;  ?>
                    
                </td>
                <td><b>CONTACT NO</b></td>
                <td></td>
                <td>-</td>
            </tr>


            <tr class="item">
                <td><b>ADDRESS</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;">
                <?php echo $sales_quote_master_row->address;  ?>    

                </td>
                <td><b>ADDRESS</b></td>
                <td></td>
                <td>-</td>
            </tr>

            <tr class="item">
                <td><b>EMAIL</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;">

                <?php echo strtoupper($sales_quote_master_row->company_email);  ?> 

                </td>
                <td><b>EMAIL</b></td>
                <td></td>
                <td>-</td>
            </tr>

            <tr class="item">
                <td><b>STATE</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;">
                    <?php echo strtoupper($this->common_model->get_state_name($sales_quote_master_row->state,$this->session->userdata['logged_in']['company_id']));?>
                </td>
                <td><b>STATE</b></td>
                <td></td>
                <td>-</td>
            </tr>

            <tr class="item">
                <td><b>COUNTRY</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;">
                  <?php echo $sales_quote_master_row->lang_country_name;?>

                </td>
                <td><b>COUNTRY</b></td>
                <td></td>
                <td>-</td>
            </tr>

            <tr class="item">
                <td><b>PAYMENTS TERMS</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;">
                  <?php echo $sales_quote_master_row->credit_days;?>

                </td>
                <td><b></b></td>
                <td></td>
                <td></td>
            </tr>

            

        </table>
        

        <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
             

            <tr class="heading">
                <td width="4%"><b>SR NO</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="45%"  style="border-right:1px solid #D9d9d9;" >PRODUCT NAME</td>
                <td width="25%" style="border-right:1px solid #D9d9d9; text-align: right;">QUANTITY</td>
                <td width="25%" style="border-right:1px solid #D9d9d9; text-align: right;">UNIT PRICE</td>
                
            </tr>
            <tr class='item' >
                <td>1</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td rowspan="6"; style="border-right:1px solid #D9d9d9;vertical-align: inherit;"><?php echo strtoupper ($sales_quote_master_row->product_name);?>/-</td>
                <td style="border-right:1px solid #D9d9d9; text-align: right;">< 10K</td>
                               
                <td style="border-right:1px solid #D9d9d9; text-align: right;"><?php echo $sales_quote_master_row->less_than_10k_quoted_price;?>/-</td>                
            </tr>

            <tr class='item' >
                <td>2</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <td style="border-right:1px solid #D9d9d9;text-align: right;">10K - 25K</td>
                              
                
                <td style="border-right:1px solid #D9d9d9;text-align: right;"><?php echo $sales_quote_master_row->_10k_to_25k_quoted_price;?>/-</td>
            </tr>

            <tr class='item' >
                <td>3</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <td style="border-right:1px solid #D9d9d9;text-align: right;">25K - 50K</td>
                
                
                <td style="border-right:1px solid #D9d9d9;text-align: right;"><?php echo $sales_quote_master_row->_25k_to_50k_quoted_price;?>/-</td>
            </tr>

            <tr class='item' >
                <td>4</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                 <td style="border-right:1px solid #D9d9d9;text-align: right;">50K - 100K</td>
                
                <td style="border-right:1px solid #D9d9d9;text-align: right;"><?php echo $sales_quote_master_row->_50k_to_100k_quoted_price;?>/-</td>
            </tr>

            <tr class='item' >
                <td>5</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <td style="border-right:1px solid #D9d9d9;text-align: right;">100K - 250K</td>
                
                <td style="border-right:1px solid #D9d9d9;text-align: right;"><?php echo $sales_quote_master_row->_100k_to_250k_quoted_price;?>/-</td>
            </tr>

            <tr class='item' >
                <td>6</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <td style="border-right:1px solid #D9d9d9;text-align: right;">>250K</td>
                
                <td style="border-right:1px solid #D9d9d9;text-align: right;"><?php echo $sales_quote_master_row->greater_than_250k_quoted_price;?>/-</td>
            </tr>

            <tr> 
                <td colspan= "2"; style="border-bottom:1px solid #D9d9d9;">FREIGHT</td>

                <td style="border-right:1px solid #D9d9d9; border-bottom:1px solid #D9d9d9;text-align: left;">:<?php echo (!$sales_quote_master_row->less_than_10k_freight) ? 'EXCLUDING' : 'INCLUDING' ?> </td>
                <td></td>
                <td></td>
            </tr>   

            <tr> 
                <td colspan= "2";>PACKAGING</td>
                <td style="border-right:1px solid #D9d9d9;text-align: left;">:<?php echo (!$sales_quote_master_row->less_than_10k_packing) ? 'EXCLUDING' : 'INCLUDING' ?></td>
                <td></td>
                <td></td>
            </tr> 



        </table>
        <br>
        

        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
           
            

            <tr class="heading">
                <td width="100%" colspan="7" style="border-bottom:1px solid #D9d9d9;"><b>PRODUCT SPECIFICATION</td>
            </tr>

            <tr class="heading">
                <td width="33%" colspan="2" ><b>TUBE</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;" ></td>
                 <td width="33%" colspan="2" style="border-right:1px solid #D9d9d9;"><b>CAP</td>
                 <td width="33%" colspan="2"><b>DECORATIVE ELEMENTS</td>   
            </tr>

            <tr class="item">
                <td width="15%"><b>TUBE DIA X LENGTH</b></td>
                <td width="1%"></td>
                <td width="17%"style="border-right:1px solid #D9d9d9;"><?php 
                $sleeve_dia_result=$this->common_model->select_one_active_record('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id'],'sleeve_id',$sales_quote_master_row->sleeve_dia);
                if($sleeve_dia_result==TRUE){
                    foreach($sleeve_dia_result as $sleeve_dia_row){
                        $sleeve_dia=$sleeve_dia_row->sleeve_diameter;
                    }
                }
                echo $sales_quote_master_row->sleeve_diameter." X ".$sales_quote_master_row->sleeve_length." MM";?></td>
                <td width="15%"><b>CAP TYPE</b></td>
                <td width="18%" style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_master_row->cap_types;?></td>
                <td width="15%" ><b>SPECIAL INK</b></td>
                <td width="18%" ><?php echo ($sales_quote_master_row->special_ink== 'YES' ? 'YES' : '-'); ?></td>
            </tr>

            <tr class="item">
                <td width="15%"><b>TUBE LAYER</b></td>
                <td width="1%"></td>
                <td width="17%"style="border-right:1px solid #D9d9d9;">
                     <?php echo ($sales_quote_master_row->layer== '1' ? 'MONO LAYER' : ($sales_quote_master_row->layer== '7' ? 'SPRING': ($sales_quote_master_row->layer== '5' ? 'MULTI LAYER': ($sales_quote_master_row->layer== '2' ? '2 LAYER': ($sales_quote_master_row->layer== '3' ? '3 LAYER': '-')) ) )); ?>   

                    </td>
                <td width="15%"><b>CAP COLOR</b></td>
                <td width="18%"style="border-right:1px solid #D9d9d9;"><?php echo strtoupper( $sales_quote_master_row->cap_color);?></td>
                <td width="15%"><b>SHOULDER FOIL</b></td>
                <td width="18%"><?php echo ($sales_quote_master_row->shoulder_foil== 'YES' ? 'YES' : '-'); ?></td>
            </tr>

            <tr class="item">
                <td width="15%"><b>TUBE COLOR</b></td>
                <td width="1%"></td>
                <td width="17%"style="border-right:1px solid #D9d9d9;"><?php echo strtoupper($sales_quote_master_row->tube_color);?></td>
                <td width="15%"><b>CAP FINISH</b></td>
                <td width="18%"style="border-right:1px solid #D9d9d9;"><?php echo strtoupper($sales_quote_master_row->cap_finishes);?></td>
                <td width="15%"><b>CAP FOIL</b></td>
                <td width="18%"><?php echo ($sales_quote_master_row->cap_foil== 'YES' ? 'YES' : '-'); ?></td>
            </tr>

            <tr class="item">
                <td width="15%"><b>TUBE PRINT TYPE</b></td>
                <td width="1%"></td>
                <td width="17%" style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_master_row->print_type;?></td>
                <td width="15%"><b>CAP DIA</b></td>
                <td width="18%"style="border-right:1px solid #D9d9d9;"> <?php echo strtoupper($sales_quote_master_row->cap_dias);?></td>
                <td width="15%"><b>CAP SHRINK SLEEVE</b></td>
                <td width="18%"><?php echo ($sales_quote_master_row->cap_shrink_sleeve== 'YES' ? 'YES' : '-'); ?></td>
            </tr>

            <tr class="item">
                <td width="15%"><b>TUBE LACQUER </b></td>
                <td width="1%"></td>
                <td width="17%" style="border-right:1px solid #D9d9d9;"><?php echo strtoupper ($sales_quote_master_row->tube_lacquer);?></td>
                <td width="15%"><b>CAP ORIFICE</b></td>
                <td width="18%" style="border-right:1px solid #D9d9d9;">
                    <?php echo ($sales_quote_master_row->cap_ori);?>  </td>
                <td width="15%"><b>CAP METALIZATION</b></td>
                <td width="18%"><?php echo ($sales_quote_master_row->cap_metalization== 'YES' ? 'YES' : '-'); ?></td>
                
            </tr>

            <tr class="item">
                <td width="15%"><b>SHOULDER </b></td>
                <td width="1%"></td>
                <td width="17%" style="border-right:1px solid #D9d9d9;"><?php echo strtoupper ($sales_quote_master_row->shoulder_type);?></td>
                <td width="15%"><b></b></td>
                <td width="18%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="15%"><b>TUBE FOIL</b></td>
                <td width="18%"><?php echo ($sales_quote_master_row->tube_foil== 'YES' ? 'YES' : '-'); ?></td>
            </tr>

            <tr class="item">
                <td width="15%"><b>SHOULDER ORIFACE </b></td>
                <td width="1%"></td>
                <td width="17%" style="border-right:1px solid #D9d9d9;"><?php echo strtoupper ($sales_quote_master_row->shoulder_ori);?></td>
                <td width="15%"><b></b></td>
                <td width="18%" style="border-right:1px solid #D9d9d9;"> </td>
                <td width="15%"><b>LABEL PRICE</b></td>
                <td width="18%"><?php echo $sales_quote_master_row->label_price;?></td>
            </tr>

            <tr class="item">
                <td width="15%"><b>SHOULDER COLOR </b></td>
                <td width="1%"></td>
                <td width="17%" style="border-right:1px solid #D9d9d9;"><?php echo strtoupper ($sales_quote_master_row->shoulder_color);?> </td>
                <td width="15%"><b></b></td>
                <td width="18%">  </td>
                <td width="15%"></td>
                <td width="18%"><?php  ?></td>
            </tr>
            <!--
            <tr class="item">
                <td width="15%"><b>TEST</b></td>
                <td width="1%"></td>
                <td width="17%"style="border-right:1px solid #D9d9d9;"></td>
                <td width="15%"></td>
                <td width="18%"></td>
                <td width="15%"></td>
                <td width="18%"></td>
            </tr>
            -->
            

            
           
        </table>
        <!--
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
             <tr class="heading">
                <td colspan="7"><b>PRODUCT PRICE RANGE</b></td>
                <!-- <td style="border-right:1px solid #D9d9d9;"></td>
                <td><b>REMARK</b></td> -->
        <!--    </tr>
            <tr class="heading">
                <td width="5%"><b>SR NO</b></td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="17%" style="border-right:1px solid #D9d9d9;">PRODUCT</td>
                <td width="17%" style="border-right:1px solid #D9d9d9;">MIN</td>
                <td width="60%" style="border-right:1px solid #D9d9d9;">MAX</td>
            </tr>
            <tr class='item'>
                <td>1</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">50G</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_master_row->_50g_min;?>/-</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_master_row->_50g_max;?>/-</td>
            </tr>
            <tr class='item'>
                <td>2</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">100G</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_master_row->_100g_min;?>/-</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_master_row->_100g_max;?>/-</td>
            </tr>
            <tr class='item'>
                <td>3</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">150G</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_master_row->_150g_min;?>/-</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_master_row->_150g_max;?>/-</td>
            </tr>
            <tr class='item' >
                <td>4</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">200G</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_master_row->_200g_min;?>/-</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $sales_quote_master_row->_200g_max;?>/-</td>
            </tr>
        </table>-->
        <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
             <tr class="heading">
                <td colspan="7"><b>REMARKS</b></td>
                <!-- <td style="border-right:1px solid #D9d9d9;"></td>
                <td><b>REMARK</b></td> -->
            </tr>
            <tr class="item">
                <td></td>
                <td></td>
                <td width="100%"  style="border-right:1px solid #D9d9d9;"><span style="color:red;"><?php echo strtoupper($sales_quote_master_row->remarks);?>/- </span></td>               
            </tr>
        </table>   


        <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
             <tr class="heading">
                <td colspan="7"><b>TERMS AND CONDITIONS </b></td>
                <!-- <td style="border-right:1px solid #D9d9d9;"></td>
                <td><b>REMARK</b></td> -->
            </tr>
            <td width="5%"  style="font-size: 11px; text-transform: uppercase;line-height: 15px;border-right:1px solid #D9d9d9;">
                <ol>
                <li>The above Rates are basic rate/ex-factory.</li>
                <li>Supply will be done from Silvassa Factory.</li>
                <li><b>Excise duty shall be charged @ I GST of 18% </b></li>
                <li><b>Delivery Lead Time: 4-6 Weeks from date of PO or Receipt of artwork approval whichever is Later </b></li>
                <li>Freight: On Parties A/c.</li>
                <li>Quotation Validity: 60 Days.</li>
                <li>Compatibility & Stability of the tube is not our responsibility.</li>
                <li>*Tubes are manufactured under Air Conditioner rooms.</li>
                <li><b> 10% +/- variation in the ordered quantity is to be accepted.</b></li>
                <li>Rates are subject to change depending upon change in the final artwork.</li>
                <li>Insurance – On Parties Account.</li>
                <li>Preferable Transporter to be suggested by Party.</li>


                </ol></td>
            
             
        </table>
        <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
             <tr class="heading">
                <td colspan="7"><b>IF YOU HAVE ANY QUESTIONS CONCERNING THIS QUOTATION CONTACT OR E-MAIL US : sales@3d-neopac.com </b></td>
                <!-- <td style="border-right:1px solid #D9d9d9;"></td>
                <td><b>REMARK</b></td> -->
            </tr>
            
        </table>    





<?php endforeach; ?>
</div>
<div class="printbtn">
        <br/>
        <br/>
        <button class="ui mini red button" id="download"><i class="file pdf outline icon"></i>PDF</button>
</div>

