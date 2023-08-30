<?php 

if($color_master==FALSE){
	echo "No Record Found";
}else{
	foreach ($color_master as $color_master_row){
		echo $color_master_row->color."//".$color_master_row->color_id."\n";

  }    	
}

?>