<?php 

if($order_master==FALSE){
	echo "No Record Found";
}else{
	foreach ($order_master as $order_master_row){
		echo $order_master_row->order_no."\n";

  }    	
}

?>