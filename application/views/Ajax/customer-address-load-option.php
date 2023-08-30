<?php 

if($customer==FALSE){
	echo "No Record Found";
}else{
	foreach ($customer as $customer_row){
		echo $customer_row->strno." ".$customer_row->name2." ".$customer_row->street." ".$customer_row->name3." PIN ".$customer_row->city_code."\n";
		echo "<br/>";
		echo '<div class="ui label">
 				 <i class="mail icon"></i> '.$customer_row->email.'
			</div>';
  }    	
}

?>