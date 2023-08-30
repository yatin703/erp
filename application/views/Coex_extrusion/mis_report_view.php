<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/semantic/tablesort.js');?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
   $(document).ready(function(){
    $("#loading").hide(); $("#cover").hide(); 
    /*$('table').tablesort();*/
    
    /*$("#adr_company_id").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});*/
   
    
    
    $("#search").click(function(){
        $("#loading").show(); $("#cover").show();
   
        $('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
        $.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/mis_report_ajax');?>",data: {from_date : $(".from_date").val(),to_date :$('.to_date').val(),convert:$('.convert').val(),convert:$('.convert').val()},cache: false,success: function(html){
            setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
            $("#check").html(html);
            } 
        });
    });
   
   
    $("#check-all").hide();
    $('#check-all').click(function(){
        $(".inv_type").prop('checked', true);
        $("#uncheck-all").show();
        $("#check-all").hide();
        
    });
   
    $('#uncheck-all').click(function(){
        $("#check-all").show();
        $(".inv_type").attr('checked', false);
        $("#uncheck-all").hide();
    });
   
    
   
   });
   
</script>
<div class="record_form_design">
<div class="record_inner_design" style="overflow: scroll;">
<div class="row">
<div class="column">
   <span id="check">
   <?php
      setlocale(LC_MONETARY, 'en_IN');
      if($gcm2==FALSE){
      
      }else{
        echo '<table class="ui sortable selectable celled table" style="font-size:10px;">
                <thead>
                   <tr>
                        <th colspan="20">';
                        if($account_periods_master==FALSE){
                        }else{
                            foreach ($account_periods_master as $account_periods_master_row ){
                                echo '<a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($account_periods_master_row->fin_year_start,$this->session->userdata['logged_in']['company_id']).' TO '.$this->common_model->view_date(date('Y-m-d'),$this->session->userdata['logged_in']['company_id']).'</a><br/><br/>';
                            }
                        }
                        echo '</th>
                  </tr>
      
      
      
      
      
      
                  
                  <tr>
                        <th colspan="3"></th>
                        <th colspan="3" class="center aligned">GCM-1</th>
                        <th colspan="3" class="center aligned">GCM-2</th>
                        <th colspan="3" class="center aligned">BRAYER-2</th>
                        <th colspan="3" class="center aligned">BRAYER-3</th>
                        <th colspan="3" class="center aligned">TOTAL</th>                                       
                    
                  </tr>
                        <tr>
                        <th>SR NO</th>
                        <th>YEAR</th>
                        <th>MONTH</th>
                        <th class="center aligned">QUANTITY</th> 
                        <th class="center aligned">SCRAP</th>
                        <th class="center aligned">SCRAP %</th>
                        <th class="center aligned">QUANTITY</th>
                        <th class="center aligned">SCRAP</th>
                        <th class="center aligned">SCRAP %</th>
                        <th class="center aligned">QUANTITY</th> 
                        <th class="center aligned">SCRAP</th>
                        <th class="center aligned">SCRAP %</th>
                        <th class="center aligned">QUANTITY</th>
                        <th class="center aligned">SCRAP</th>
                        <th class="center aligned">SCRAP %</th>
                        <th class="center aligned">QTY TOTAL</th>
                        <th class="center aligned">TOTAL SCRAP</th>
                        <th class="center aligned">TOTAL SCRAP %</th>
                    
                    </tr>
                </thead>';
                 $i=1;
       

       $total_quantity_gcm_1=0;
       $total_value_gcm_1_scrap=0;
       $gcm_1_scrap_percent=0;
      
       $total_quantity_gcm_2=0;
       $total_value_gcm_2_scrap=0;
       $gcm_2_scrap_percent=0;
      
       $total_quantity_brayer_2=0;
       $total_value_brayer_2_scrap=0;
       $brayer_2_scrap_percent=0;
      
       $total_quantity_brayer_3=0;
       $total_value_brayer_3_scrap=0;
       $brayer_3_scrap_percent=0;
      
       $total_quantity=0;
       $total_scrap=0;
       $s=0;
       $p=0;
      
       if($total_quantity_gcm_1 == 0){
           $a = '0';  
       }else{
           $a = $total_value_gcm_1_scrap/$total_quantity_gcm_1*'100';
       }

       if($total_quantity_gcm_2 == 0){
           $b = '0';  
       }else{
           $b= $total_value_gcm_2_scrap/$total_quantity_gcm_2*'100';
       }
       

       foreach($gcm2 as $row){         
        
        echo "
                      <tr>
            <td><b>$i</b></td>
                      <td><b>".$row->year."</b></td>
                      <td><b>".$row->month."</b></td>
                      <td class='right aligned'>".number_format( $row->prod_Gcm_1)."</td>
                      <td  class='right aligned'>".number_format($row->scrap_Gcm_1)."</td>
                      <td  class='right aligned'>".number_format($row->rejection_Gcm_1)."%"."</b></td>
                      <td  class='right aligned'>".number_format($row->prod_Gcm_2)."</td>
                      <td  class='right aligned'>".number_format($row->scrap_Gcm_2)."</td>
                      <td  class='right aligned'>".number_format($row->rejection_Gcm_2)."%"."</td>
                      <td  class='right aligned'>".number_format($row->prod_Breyer_3)."</td>
                      <td  class='right aligned'>".number_format($row->scrap_Breyer_3)."</td>
                      <td  class='right aligned'>".number_format($row->rejection_breyer_2)."%"."</td>
                      <td  class='right aligned'>".number_format($row->prod_Breyer_4)."</td>
                      <td  class='right aligned'>".number_format($row->scrap_Breyer_4)."</td>
                      <td  class='right aligned'>".number_format($row->rejection_breyer_3)."%"."</td>";
                        $s=$s+$row->prod_Gcm_1+$row->prod_Gcm_2+$row->prod_Breyer_3+$row->prod_Breyer_4;
                       $p=$p+$row->scrap_Gcm_1+$row->scrap_Gcm_2+$row->scrap_Breyer_3+$row->scrap_Breyer_4;
                       echo"<td  class='right aligned'><b>".number_format($row->prod_Gcm_1+$row->prod_Gcm_2+$row->prod_Breyer_3+$row->prod_Breyer_4)."</b></td>
                       <td  class='right aligned'><b>".number_format($row->scrap_Gcm_1+$row->scrap_Gcm_2+$row->scrap_Breyer_3+$row->scrap_Breyer_4)."</b></td>
                       <td  class='right aligned' style='border-bottom: 1px solid rgba(34,36,38,.1 !important'><b>".round($p/$s*'100')."%"."</b></td>
      
                       
           
                       
                      </tr>";
            $i++;
                     
                      $total_quantity_gcm_1=$total_quantity_gcm_1+$row->prod_Gcm_1;
                      $total_value_gcm_1_scrap=$total_value_gcm_1_scrap+$row->scrap_Gcm_1;
      
                      $total_quantity_gcm_2=$total_quantity_gcm_2+$row->prod_Gcm_2;
                      $total_value_gcm_2_scrap=$total_value_gcm_2_scrap+$row->scrap_Gcm_2;
                       $total_quantity_brayer_2=$total_quantity_brayer_2+$row->prod_Breyer_3;
                      $total_value_brayer_2_scrap=$total_value_brayer_2_scrap+$row->scrap_Breyer_3;
                       $total_quantity_brayer_3=$total_quantity_brayer_3+$row->prod_Breyer_4;
                      $total_value_brayer_3_scrap=$total_value_brayer_3_scrap+$row->scrap_Breyer_4;
      
      
                     }
      
                     echo"<tr>
                   <td colspan='3' style='text-align:right'><b>TOTAL</b></td>
                   <td  class='right aligned'><b>".number_format($total_quantity_gcm_1)."</b></td>
                   <td  class='right aligned'><b>".number_format($total_value_gcm_1_scrap)."</b></td>
                    <td  class='right aligned'><b>".round($a)."%"."</b></td>
                   <td  class='right aligned'><b>".number_format($total_quantity_gcm_2)."</b></td>
                   <td  class='right aligned'><b>".number_format($total_value_gcm_2_scrap)."</b></td>
                    <td  class='right aligned'><b>".round($b)."%"."</b></td>
                   <td  class='right aligned'><b>". number_format($total_quantity_brayer_2)."</b></td>
                   <td  class='right aligned'><b>".number_format($total_value_brayer_2_scrap)."</b></td>
                   <td  class='right aligned'><b></b></td>
                   <td  class='right aligned'><b>".  number_format($total_quantity_brayer_3)."</b></td>
                   <td  class='right aligned'><b>".number_format($total_value_brayer_3_scrap)."</b></td>
                   <td></td>
                   <td></td>
                   <td></td>
                    
                     </tr>";
                      echo'</table>';
      
      
      
      
      }
      ?>
</div>