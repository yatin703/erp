<?php 

if($article==FALSE){
	echo "No Record Found";
}else{
	foreach ($article as $article_row){
		echo $article_row->article_no."\n";

  }    	
}

?>