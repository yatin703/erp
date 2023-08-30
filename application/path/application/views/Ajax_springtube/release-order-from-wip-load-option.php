<?php 
    if($order_master==FALSE){
      	echo '<option value="">--Please Select--</option>';
    }
    else{ 

        echo '<option value="">--Select Release To Order--</option>';
      	foreach ($order_master as $row){
      		
          echo '<option value="'.$row->order_no.'" '.set_select('release_to_order_no').'>'.$row->order_no.'</option>';
        }     
    }

?>