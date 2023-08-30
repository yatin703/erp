<?php 

if($cap_height==FALSE){
	echo "No Record Found";
}else{
	foreach ($cap_height as $cap_height_row){
		echo $cap_height_row->cap_height."\n";

  }    	
}

?>
