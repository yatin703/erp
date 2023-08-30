<?php 

if($jobcard==FALSE){
	//echo "No Record Found";
}else{
	foreach ($jobcard as $jobcard_row){
		echo $jobcard_row->mp_pos_no."\n";

  }    	
}

if($article==FALSE){
	//echo "No Record Found";
}else{
	foreach ($article as $article_row){
		echo $article_row->article_no."\n";

  }    	
}

?>