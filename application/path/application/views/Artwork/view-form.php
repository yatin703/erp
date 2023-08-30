
<?php foreach ($artwork as $artwork_row):?>

    <?php
        $result_dia=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','1');

        $result_length=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','2');

        $result_sleeve_color=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','7');

        $result_print_type=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','17');

        foreach($result_print_type as $print_type_row){ $prin_type=$print_type_row->parameter_value; }

       $result_printing_upto_neck=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','8');

        $result_hot_foil=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','11');

        $result_lacquer_type=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','12');

        $result_sealing=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','5');
    ?>
        <?php echo $artwork_row->final_approval_flag==1 ? '<a class="ui green right ribbon label">Approved</a>' : '<a class="ui  red right ribbon label">Unapproved</a>';?>
         <br/>

        <?php echo $this->common_model->view_date($artwork_row->ad_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label">'.$this->common_model->view_date($artwork_row->ad_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '';?>
        <br/>
        <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            <tr class="heading">
                <td width="20%"><b>ARTWORK NO</td>
                <td width="5%"></td>
                <td width="25%" style="border-right:1px solid #D9d9d9;"><b><?php echo $artwork_row->ad_id;?></b></td>
                <td width="15%">VERSION NO</td>
                <td width="5%"></td>
                <td width="30%"><?php echo $artwork_row->version_no; ?></td>
                
            </tr>
            
            <tr class="item last">
                <td>CUSTOMER</td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $artwork_row->customer_name;?>//<?php echo $artwork_row->adr_company_id;?></td>
                
                <td>ARTICLE</td>
                <td></td>
                <td><?php echo $artwork_row->article_name; ?>//<?php echo $artwork_row->article_no;?></td>
            </tr>
            
            <tr class="heading">
                <td colspan="6">
                    OTHER DETAILS
                </td>
               
            </tr>
            <tr class="item last">
                <td ><b>ARTWORK FILE</b></td>
                <td ></td>
               
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($artwork_row->artwork_image_nm!='' ? '<a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/artwork/'.$artwork_row->artwork_image_nm.'').'" target="_blank"><i class="file pdf outline icon"></i></a>' :'');?>
                    
                </td>

                
            </tr>
            <tr class="item last">
                <td width="15%"><b>DIA</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php foreach($result_dia as $dia_row){ echo $dia_row->parameter_value; }?></td>
                <td ><b>LENGTH</b></td>
                <td></td>
                <td><?php foreach($result_length as $length_row){ echo $length_row->parameter_value; }?></td>
            </tr>

            
            <tr class="item last">
                <td><b>SLEEVE COLOR</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php foreach($result_sleeve_color as $sleeve_color_row){ echo $sleeve_color_row->parameter_value; }?></td>
                <td><b>PRINT TYPE</b></td>
                <td></td>
                <td><?php foreach($result_dia as $dia_row){ echo $dia_row->parameter_value; }?></td>

            </tr>
            
            <tr class="item last">
                <td><b>PRINT UP TO NECK</b></td>
                <td></td>
                 <td style="border-right:1px solid #D9d9d9;"><?php foreach($result_print_type as $print_type_row){ echo $print_type_row->parameter_value; }?></td>
                 <td><b>HOT FOIL</b></td>
                <td></td>
                <td><?php foreach($result_hot_foil as $hot_foil_row){
                    $hot_foil=substr($hot_foil_row->parameter_value,strpos($hot_foil_row->parameter_value, "||") + 2);
                    echo strtoupper(str_replace("^"," + ",$hot_foil));
                    }?></td>

            </tr>
            
             <tr class="item last">
                <td><b>SEALING AND NON LACQUERING AREA</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php foreach($result_sealing as $sealing_row){ echo $sealing_row->parameter_value; }?></td>
                <td><b>LACQUER TYPE</b></td>
                <td></td>
                <td><?php foreach($result_lacquer_type as $lacquer_row){
                    $lacquer=substr($lacquer_row->parameter_value,strpos($lacquer_row->parameter_value, "||") + 2);
                    echo strtoupper(str_replace("^"," + ",$lacquer));
                    } ?></td>
            </tr>
            
             <tr class="item last">
                <td><b>CREATED BY</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo strtoupper($artwork_row->username);?></td>
                
                <td><b>APPROVED BY</b></td>
                <td></td>
                <td><?php echo strtoupper($artwork_row->approval_username);?></td>
            </tr>

      

        </table>
        <?php endforeach;?>
    </br>
    </br>

        <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr class="heading">
                <td colspan='6'>APPROVAL FOLLOWUPS</td>
            </tr>
            <tr class="heading">
                <td>SR NO</td>
                <td></td>
                <td>DATE</td>
                <td>FROM</td>
                <td>TO</td>
                <td>STATUS</td>
            </tr>
            <?php 
                if($followup==FALSE){
                    echo "<tr>
                            <td colspan='6'>NO RECORD FOUND</td>
                        </tr>";

                }else{
                    foreach($followup as $followup_row){

                        echo "<tr class='item'>
                                <td>$followup_row->transaction_no</td>
                                <td></td>
                                <td>".$this->common_model->view_date($followup_row->followup_date,$this->session->userdata['logged_in']['company_id'])."</td>
                                <td>".strtoupper($followup_row->from_user)."</td>
                                <td>".strtoupper($followup_row->to_user)."</td>
                                <td>".($followup_row->status==99 ? 'SETTLED' : '')."
                                    ".($followup_row->status==999 && $followup_row->approved_flag==1? 'APPROVED' : '')."
                                    ".($followup_row->status==999 && $followup_row->approved_flag==2? 'REJECTED' : '')."
                                    ".($followup_row->status==1 ? 'PENDING' : '')."</td>
                            </tr>";
                     }
                }
                ?>
        </table>   
    </div>
</body>
        
  
</html>
