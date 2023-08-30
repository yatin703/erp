<?php 

if($jobcard==FALSE){
	//echo "No Record Found";
}else{
	foreach ($jobcard as $jobcard_row){
		echo $jobcard_row->mp_pos_no."\n";

  }    	
}


?>