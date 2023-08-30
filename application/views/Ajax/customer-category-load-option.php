<?php 
    if($customer_category==FALSE){
    }
    else{ 
      	foreach ($customer_category as $row){
      		echo $row->category_name."//".$row->adr_category_id."\n";
        }     
    }

?>