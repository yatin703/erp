<?php 

if($customer==FALSE){
	echo "No Record Found";
}else{
	foreach ($customer as $customer_row){
		echo $customer_row->name1."//".$customer_row->adr_company_id."//".$customer_row->lang_property_name."\n";
  }    	
}

?>