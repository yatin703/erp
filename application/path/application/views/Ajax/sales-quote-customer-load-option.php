<?php 
    if($sales_quote_customer_master==FALSE){
    }
    else{ 
      	foreach ($sales_quote_customer_master as $row){
      		echo $row->customer_name."//".$row->customer_id."\n";
        }     
    }
?>