<article class="container_title">
	
 <h2>
	<?php $table='autogeneration_format_master';?>

		<a href='<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>'>
				<?php echo str_replace("_"," ",ucwords($this->router->fetch_class()));?></a> : 

		<a href='<?php echo base_url('index.php/'.$this->router->fetch_class().'/create');?>'>Create</a> : 


		<a href='<?php echo base_url('index.php/'.$this->router->fetch_class().'/search');?>'>Search</a> :
	
</h2>

</article>