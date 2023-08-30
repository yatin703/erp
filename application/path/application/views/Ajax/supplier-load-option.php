<?php 

if($supplier==FALSE){
	echo "No Record Found";
}else{
	foreach ($supplier as $supplier_row){
		echo $supplier_row->name1."//".$supplier_row->adr_company_id."//".$supplier_row->lang_property_name."\n";
  }    	
}

?>