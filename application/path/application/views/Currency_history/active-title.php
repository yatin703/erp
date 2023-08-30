<article class="container_title">
	
 <h2>
	<?php $table='currency_history';?>

		<?php foreach ($currency_rates_master as $row):?>
			<a href='<?php echo base_url('index.php/'.$this->router->fetch_class().'/index/'.$row->country_id.'/'.$row->for_currency.'/'.$row->to_currency);?>'>
			Currency History
			</a> : 

			 <a href='<?php echo base_url('index.php/'.$this->router->fetch_class().'/create/'.$row->country_id.'/'.$row->for_currency.'/'.$row->to_currency);?>'>
			 Add
			 </a> : 
		<?php endforeach; ?>	 
		
	
</h2>

</article>