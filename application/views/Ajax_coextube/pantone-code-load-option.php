<?php 

if($coextube_ink_mixing_master==FALSE){
	echo "No Record Found";
}else{
	foreach ($coextube_ink_mixing_master as $row){
		echo $row->pantone_code."\n";

    }    	
}

?>