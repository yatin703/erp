<?php 
if($psm_no==FALSE){
	echo "No Record Found";
}else{
	foreach ($psm_no as $psm_no_row){
		echo $psm_no_row->data_mismatch."\n";
  }    	
}
?>