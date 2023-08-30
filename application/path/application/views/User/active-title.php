<article class="container_title">
	
 <h2>
	<?php $table='user_master';?>

		<a href='<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>'>
				<?php echo str_replace("_"," ",ucwords($this->router->fetch_class()));?></a> : 

		<a href='<?php echo base_url('index.php/'.$this->router->fetch_class().'/create');?>'>Create</a> : 

		<a href='<?php echo base_url('index.php/'.$this->router->fetch_class().'/archive_records');?>'>Archive (<?php  
		echo $this->common_model->archive_record_count($table,$this->session->userdata['logged_in']['company_id']);?>) : </a>

		<a href='<?php echo base_url('index.php/'.$this->router->fetch_class().'/search');?>'>Search</a> :
	
</h2>

</article>