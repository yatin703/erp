<?php 

if($coextube_ink_master==FALSE){
	echo "No Record Found";
}else{
	foreach ($coextube_ink_master as $row){
		echo $row->lang_article_description."//".$row->article_no."\n";

    }    	
}

?>