<?php 

if($customer==FALSE){
	echo "No Record Found";
}else{
	foreach ($customer as $customer_row){
		
		echo '&nbsp;&nbsp;<div class="ui label">
 				 <i class="truck icon"></i>'.($customer_row->max_lead_time!='' ? $customer_row->max_lead_time.' Days Delivery' : 'NA').'
			</div>';
  }    	
}

?>