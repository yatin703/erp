<?php 

if($pg==FALSE){
	echo "No Record Found";
}else{
	foreach ($pg as $pg_row){
		echo $pg_row->price_list_name."//".$pg_row->pg_no."\n";

  }    	
}

?>