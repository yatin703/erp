
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
        <table cellpadding="0" cellspacing="0">
            
            <tr class="heading">
                <td>
                    <?php echo strtoupper($this->router->fetch_class());?>
                </td>
                
                <td>
                    VERSION NO
                </td>
            </tr>
            
            <tr class="details">
                <td>
                    <?php echo $artwork_row->ad_id;?>
                </td>
                
                <td>
                    <?php echo $artwork_row->version_no;?>
                </td>
            </tr>
            
            <tr class="heading">
                <td>
                    OTHER DETAILS
                </td>
                
                <td>
                    
                </td>
            </tr>
            <tr class="item">
                <td>ARTWORK FILE</td>
                <td><?php echo ($artwork_row->artwork_image_nm!='' ? '<a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/artwork/'.$artwork_row->artwork_image_nm.'').'" target="_blank"><i class="file pdf outline icon"></i></a>' :'');?></td>
            </tr>
            <tr class="item">
                <td>CUSTOMER</td>
                <td><?php echo $artwork_row->customer_name;?>//<?php echo $artwork_row->adr_company_id;?></td>
            </tr>

            <tr class="item">
                <td>ARTICLE</td>
                <td><?php echo $artwork_row->article_name; ?>//<?php echo $artwork_row->article_no;?></td>
            </tr>

            <tr class="item">
                <td>DIA</td>
                <td><?php foreach($result_dia as $dia_row){ echo $dia_row->parameter_value; }?></td>
            </tr>

            <tr class="item">
                <td>LENGTH</td>
                <td><?php foreach($result_length as $length_row){ echo $length_row->parameter_value; }?></td>
            </tr>
            
            <tr class="item">
                <td>SLEEVE COLOR</td>
                <td><?php foreach($result_sleeve_color as $sleeve_color_row){ echo $sleeve_color_row->parameter_value; }?></td>
            </tr>

            <tr class="item">
                <td>PRINT TYPE</td>
                <td><?php foreach($result_print_type as $print_type_row){ echo $print_type_row->parameter_value; }?></td>
            </tr>

            <tr class="item">
                <td>PRINT UPTO NECK</td>
                <td><?php foreach($result_printing_upto_neck as $printing_upto_neck_row){ echo $printing_upto_neck_row->parameter_value; }?></td>
            </tr>

            <tr class="item">
                <td>HOT FOIL</td>
                <td><?php foreach($result_hot_foil as $hot_foil_row){
                    $hot_foil=substr($hot_foil_row->parameter_value,strpos($hot_foil_row->parameter_value, "||") + 2);
                    echo strtoupper(str_replace("^"," + ",$hot_foil));
                    }?></td>
            </tr>

            <tr class="item">
                <td>SEALING AND NON LACQUERING AREA</td>
                <td><?php foreach($result_sealing as $sealing_row){ echo $sealing_row->parameter_value; }?></td>
            </tr>

            <tr class="item last">
                <td>LACQUER TYPE</td>
                <td><?php foreach($result_lacquer_type as $lacquer_row){
                    $lacquer=substr($lacquer_row->parameter_value,strpos($lacquer_row->parameter_value, "||") + 2);
                    echo strtoupper(str_replace("^"," + ",$lacquer));
                    } ?></td>
            </tr>

            <tr class="item">
                <td>CREATED BY</td>
                <td><?php echo strtoupper($artwork_row->username);?></td>
            </tr>

            <tr class="item">
                <td>APPROVED BY</td>
                <td><?php echo strtoupper($artwork_row->approval_username);?></td>
            </tr>

        </table>
        <?php endforeach;?>

        <table cellpadding="0" cellspacing="0">
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
