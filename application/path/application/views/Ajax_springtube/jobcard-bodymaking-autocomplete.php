<?php 

if($production_master==FALSE){
	echo "No Record Found";
}else{
	foreach ($production_master as $row){
		echo $row->mp_pos_no."\n";

  	}    	
}

?>