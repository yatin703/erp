<?php 

if($result==FALSE){
	echo "No Record Found";
}else{
	foreach ($result as $row){
		echo $row->complaint_no."\n";
  }    	
}

?>