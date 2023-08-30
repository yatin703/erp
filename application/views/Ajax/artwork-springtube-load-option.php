<?php 

if($springtube_artwork_devel_master==FALSE){
	echo "No Record Found";
}else{
	foreach ($springtube_artwork_devel_master as $springtube_artwork_devel_master_row){
		echo $springtube_artwork_devel_master_row->ad_id."\n";

  }    	
}

?>