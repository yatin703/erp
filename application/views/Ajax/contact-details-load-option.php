<?php 
    if($contact_details==FALSE){
    }
    else{ 
      	foreach ($contact_details as $row){
      		echo $row->contact_name."//".$row->address_category_contact_id."\n";
        }     
    }

?>