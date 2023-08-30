<?php
   setlocale(LC_MONETARY, 'en_IN');
   		if($gcm2==FALSE){
   
   		}else{
echo '<table class="ui sortable selectable celled table" style="font-size:10px;">
	<thead>
   <tr>
    	<th colspan="20">'.($from_date!='' && $to_date!='' ? 
    		' <a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($from_date,$this->session->userdata['logged_in']['company_id']).'  TO '.$this->common_model->view_date($to_date,$this->session->userdata['logged_in']['company_id']).'</a><br/><br/>' : '');
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
   <th class="center aligned">QUT TOTAL</th>
	<th class="center aligned">SCRAP TOTAL</th>
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

 foreach($gcm2 as $row){ 
   		 	
      	echo "
   <tr>
        <td><b>$i</b></td>
		  <td><b>".$row->year."</b></td>
		  <td><b>".$row->month."</b></td>
		  <td class='right aligned'>".$this->common_model->read_number_million( $row->prod_Gcm_1)."</td>
		  <td  class='right aligned'>".$this->common_model->read_number_million($row->scrap_Gcm_1)."</td>
		  <td  class='right aligned'>".$this->common_model->read_number_million($row->rejection_Gcm_1)."</b></td>
		  <td  class='right aligned'>".$this->common_model->read_number_million($row->prod_Gcm_2)."</td>
		  <td  class='right aligned'>".$this->common_model->read_number_million($row->scrap_Gcm_2)."</td>
		  <td  class='right aligned'>".$this->common_model->read_number_million($row->rejection_Gcm_2)."</td>
		  <td  class='right aligned'>".$this->common_model->read_number_million($row->prod_Breyer_3)."</td>
		  <td  class='right aligned'>".$this->common_model->read_number_million($row->scrap_Breyer_3)."</td>
		  <td  class='right aligned'>".$this->common_model->read_number_million($row->rejection_breyer_2)."</td>
		  <td  class='right aligned'>".$this->common_model->read_number_million($row->prod_Breyer_4)."</td>
		  <td  class='right aligned'>".$this->common_model->read_number_million($row->scrap_Breyer_4)."</td>
		  <td  class='right aligned'>".$this->common_model->read_number_million($row->rejection_breyer_3)."</td>
		  <td  class='right aligned'><b>".$this->common_model->read_number_million($row->prod_Gcm_1+$row->prod_Gcm_2+$row->prod_Breyer_3+$row->prod_Breyer_4)."</b></td>
		   <td  class='right aligned'><b>".$this->common_model->read_number_million($row->scrap_Gcm_1+$row->scrap_Gcm_2+$row->scrap_Breyer_3+$row->scrap_Breyer_4)."</b></td>
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
       <td  class='right aligned'><b>".$this->common_model->read_number_million($total_quantity_gcm_1)."</b></td>
       <td  class='right aligned'><b>".$this->common_model->read_number_million($total_value_gcm_1_scrap)."</b></td>
       <td  class='right aligned'><b></b></td>
       <td  class='right aligned'><b>".$this->common_model->read_number_million($total_quantity_gcm_2)."</b></td>
       <td  class='right aligned'><b>".$this->common_model->read_number_million($total_value_gcm_2_scrap)."</b></td>
       <td  class='right aligned'><b></b></td>
       <td  class='right aligned'><b>".$this->common_model->read_number_million($total_quantity_brayer_2)."</b></td>
       <td  class='right aligned'><b>".$this->common_model->read_number_million($total_value_brayer_2_scrap)."</b></td>
       <td  class='right aligned'><b></b></td>
       <td  class='right aligned'><b>".$this->common_model->read_number_million($total_quantity_brayer_3)."</b></td>
       <td  class='right aligned'><b>".$this->common_model->read_number_million($total_value_brayer_3_scrap)."</b></td>
       <td></td>
       <td></td>
       <td></td>
	
	 </tr>";
	  echo'</table>';
   
   
   
   
   }
   ?>