<?php 

if($cap_spec_no==FALSE){
	echo "No Record Found";
}else{
	foreach ($cap_spec_no as $cap_spec_no_row){
		echo $cap_spec_no_row->spec_id."\n";
  }    	
}

?>