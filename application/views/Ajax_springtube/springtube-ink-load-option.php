<?php 

if($springtube_ink_master==FALSE){
	echo "No Record Found";
}else{
	foreach ($springtube_ink_master as $row){
		echo $row->ink_desc."//".$row->ink_id."\n";

    }    	
}

?>