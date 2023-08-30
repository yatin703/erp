<?php 

if($artwork_devel_master==FALSE){
	echo "No Record Found";
}else{
	foreach ($artwork_devel_master as $artwork_devel_master_row){
		echo $artwork_devel_master_row->ad_id."\n";

  }    	
}

?>