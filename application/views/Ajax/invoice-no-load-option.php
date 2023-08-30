<?php 

if($ar_invoice_master==FALSE){
	echo "No Record Found";
}else{
	foreach ($ar_invoice_master as $ar_invoice_row){
		echo $ar_invoice_row->ar_invoice_no."\n";

  }    	
}

?>