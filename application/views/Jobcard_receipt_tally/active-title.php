<article class="container_title">
	
 <h2>
	<?php $table='tally_issued_material_receipt';?>

		<a href='<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>'>
				<?php echo str_replace("_"," ",ucwords($this->router->fetch_class()));?></a> :  
		
		<a href='<?php echo base_url('index.php/'.$this->router->fetch_class().'/search');?>'>Search</a> :

		<a href='<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_summary');?>'>Search Summary</a> :
	
</h2>

</article>