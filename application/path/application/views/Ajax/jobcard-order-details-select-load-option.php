<?php if($production_master==FALSE){
}else{
	foreach($production_master as $production_row){
		echo '<select name="order_no" id="order_no">
		<option value="'.$production_row->sales_ord_no.'">'.$production_row->sales_ord_no.'</option></select>&nbsp;&nbsp;&nbsp;
		<b>Product No</b> : &nbsp;&nbsp;&nbsp;<select name="article_no" id="article_no">
		<option value="'.$production_row->article_no.'">'.$production_row->article_no.'</option></select>';
	}
}?>
