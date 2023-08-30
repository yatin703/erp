<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

    $(document).ready(function(){

        // $(".invoice-box").css("max-width", "1300px");
        // $(".invoice-box table tr td").css("text-align", "left");

    });
 </script> 
 <style type="text/css">
        table{
            border:1px solid #D9d9d9;
            border-collapse: collapse;
            font-size: 10px;

            /*text-align: left;*/
            /*cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;border-collapse: collapse;"*/
        }
        td,th{
             
            text-align: left;
            padding: 2px;
            /*white-space: nowrap;*/
            /*display: table-cell;*/
           

        }
</style>        

<?php foreach ($capa_complaint_register_master as $row):
    //$customer=1;
    $article_no='';

?>            
    
    <br/>
    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        CORRECTIVE ACTION REPORT
      </div>
    </div>

    <?php  
        echo'<span class="ui green right ribbon label"><b>'.$row->complaint_no.'</b></span>';
    ?> 

    <br/>
        <?php echo $this->common_model->view_date($row->qc_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label"><i class="calendar alternate outline icon"></i>'.$this->common_model->view_date($row->qc_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '';?>
    <br/>
    <br/>

    <table>
        <tr class="heading" style="border:1px solid #D9d9d9;">
            <td colspan='7' style="border:1px solid #D9d9d9;text-align:center;">CATEGORY OF POTENTIAL NON-CONFORMITY: Product / Process / System / Customer complaint / Customer feedback</td>
        </tr> 
    </table>
    <br/>
    <table>               
        <tr class="heading" style="border-right:1px solid #D9d9d9;">
            <td width="1%" style="border-bottom:1px solid #D9d9d9;">Department</td>
            <td width="1%" style="border-bottom:1px solid #D9d9d9;"></td>             
            <td width="10%" style="border:1px solid #D9d9d9;">Customer</td>                
            <td width="15%" style="border:1px solid #D9d9d9;">Product Name</td>
            <td width="1%" style="border:1px solid #D9d9d9;">Reference</td>
            <td width="1%" style="border:1px solid #D9d9d9;">ComplaintDate</td> 
        </tr>
        <tr >
            <td>QC</td>
            <td style="border-right:1px solid #D9d9d9;"></td>
            <td ><?php echo $this->common_model->get_customer_name($row->customer,$this->session->userdata['logged_in']['company_id']);?></td>           
            
            <td style="border:1px solid #D9d9d9;">
                <?php 
                $article_array=explode(",", $row->article_no);
                foreach ($article_array as $key => $article_no) {
                    echo $this->common_model->get_article_name($article_no,$this->session->userdata['logged_in']['company_id']);
                    echo'</br>';
                }
                ;?>
                    
                </td>
            <td style="border:1px solid #D9d9d9;">Email</td>
            <td style="border:1px solid #D9d9d9;"><?php echo $this->common_model->view_date($row->complaint_date,$this->session->userdata['logged_in']['company_id']);?></td>
             
        </tr>
    </table>
    </br>

    <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;" width="100%">    
        <tr class="heading" style="border-right:1px solid #D9d9d9;">
            <td colspan='7'  style="border-bottom:1px solid #D9d9d9;">Non-Conformity Details :</td>
        </tr>
        <tr style="border-right:1px solid #D9d9d9;height:100px;">
            <td colspan='7'>
                <?php 
                    echo $row->comment;
                    echo '</br>';
                    echo '</br>';
                    echo 'Product: '.$row->article_no.', Ref No.: '.$row->reference_no.', Qty: '.$row->qty; 

                ?>                    
            </td>
        </tr>
    </table>
       
    <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;" width="100%">
        <tr class="heading" style="border-right:1px solid #D9d9d9;">
            <td style="border-bottom:1px solid #D9d9d9;">Investigation / Causes :</td>
        </tr>
        <tr style="border-right:1px solid #D9d9d9;height:100px;" >
            <td style="white-space:nowrap;"><?php echo $row->investigation ?></td>
        </tr>
    </table>      
        
    <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;" width="100%">
        <tr class="heading" style="border-right:1px solid #D9d9d9;">
            <td colspan='7' style="border-bottom:1px solid #D9d9d9;">Corrective Action: [Action on cause of detected non-conformity to avoid recurrence] :</td>
        </tr>
        <tr style="border-right:1px solid #D9d9d9;height:100px;">
            <td colspan='7' style="border-bottom:1px solid #D9d9d9"><?php echo $row->corrective_action ?></td>
        </tr>
        <tr  >
            <td colspan='3'  >Responsibility : QA/Production/Maintenance</td>
            <td colspan='4' style="border-right:1px solid #D9d9d9">Target Date: <?php echo $this->common_model->view_date($row->corrective_action_date,$this->session->userdata['logged_in']['company_id']); ?></td>
        </tr>
    </table>
       
        
    <table>
        <tr class="heading" style="border-right:1px solid #D9d9d9;">
            <td colspan='7' style="border-bottom:1px solid #D9d9d9;">Preventive  Action: [Action on cause of detected non-conformity to avoid  Occurrences] :</td>
        </tr>
        <tr style="border-right:1px solid #D9d9d9;height:100px;">
            <td colspan='7'><?php echo $row->preventive_action ?></td>
        </tr>
        <tr >
            <td colspan='3'  >Responsibility : QA/Production/Maintenance</td>
            <td colspan='4' style="border-right:1px solid #D9d9d9">Target Date: <?php echo $this->common_model->view_date($row->preventive_action_date,$this->session->userdata['logged_in']['company_id']); ?></td>
        </tr>    
    </table>
    <table style="overflow: scroll;">    
        <tr class="heading" style="border-right:1px solid #D9d9d9;">
            <td colspan='7'  style="border-bottom:1px solid #D9d9d9;">Time Scale for Verification of Effectiveness :</td>
        </tr>
        <tr style="border-right:1px solid #D9d9d9;height:50px;">
            <td colspan='7'><?php echo $row->verification_of_effectiveness ?></td>
        </tr>
    </table>
    <table style="overflow: scroll;">    
        <tr class="heading" style="border-right:1px solid #D9d9d9;">
            <td colspan='7'  style="border-bottom:1px solid #D9d9d9;">Effectiveness of Action taken :</td>
        </tr>
        <tr style="border-right:1px solid #D9d9d9;height:50px;">
            <td colspan='7'><?php echo $row->effectiveness_action_taken ?></td>
        </tr>
    </table>  
    </br>
    <table>               
        <tr class="heading" style="border-right:1px solid #D9d9d9;">
            <td width="1%" style="border-bottom:1px solid #D9d9d9;">Prepared by</td>
            <td width="1%" style="border-bottom:1px solid #D9d9d9;"></td>             
            <td width="5%" style="border:1px solid #D9d9d9;">Approved by</td>                
            
        </tr>
        <tr >
            <td width="50%" style="border-bottom:1px solid #D9d9d9;"><?php echo $this->common_model->get_user_name($row->qc_name,$this->session->userdata['logged_in']['company_id']);?></td>
            <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
            <td width="50%" style="border-bottom:1px solid #D9d9d9;"></td>
             
        </tr>
    </table>
 

  
                
    <?php endforeach;?>


    </div>
</body>
</html>   