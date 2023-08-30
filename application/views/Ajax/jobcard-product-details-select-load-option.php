<?php if($production_master==FALSE){
}else{
	foreach($production_master as $production_row){
		echo '<select name="product_no" id="product_no"><option value="'.$production_row->article_no.'">'.$production_row->article_no.'</option></select>';
	}
}?>
