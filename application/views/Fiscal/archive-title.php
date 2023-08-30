<article class="container_title">
	
 <h2>
	<?php $table='account_periods_master';?>

		<a href='<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>'>
				<?php echo str_replace("_"," ",ucwords($this->router->fetch_class()));?></a> : 

		<a href='<?php echo base_url('index.php/'.$this->router->fetch_class().'/create');?>'>Create</a> : 

		<a href='<?php echo base_url('index.php/'.$this->router->fetch_class().'/index');?>'>Active (<?php  
		echo $this->fiscal_model->active_record_count($table,$this->session->userdata['logged_in']['company_id']);?>) : </a>

		
	
</h2>

</article>