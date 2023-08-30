<?php 

if($sales_quote_master==FALSE){
	echo "No Record Found";
}else{
	foreach ($sales_quote_master as $sales_quote_master_row){
		echo $sales_quote_master_row->quotation_no."\n";

  }    	
}

?>