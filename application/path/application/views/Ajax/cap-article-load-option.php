<?php 

if($article==FALSE){
	echo "No Record Found";
}else{
	foreach ($article as $article_row){
		echo $article_row->lang_article_description."//".$article_row->article_no."//".$article_row->spec_id."//".$article_row->spec_version_no."\n";
  }    	
}

?>