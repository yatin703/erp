<?php 

if($bill_of_material==FALSE){
	echo "No Record Found";
}else{
	foreach ($bill_of_material as $bill_of_material_row){
		echo $bill_of_material_row->bom_no."\n";

  }    	
}

?>