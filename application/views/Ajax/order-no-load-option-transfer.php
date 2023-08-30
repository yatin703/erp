<?php 

if($springtube_rfd_master==FALSE){
    echo "No Record Found";
}else{
    foreach ($springtube_rfd_master as $row){  
        echo $row->order_no."\n";

  }     
}

?>