<article class="container_title">
	
 <h2>
	<?php $table='zip_code_master';?>
	<a href='<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>'><?php echo str_replace("_"," ",ucwords($this->router->fetch_class()));?></a> : <a href='<?php echo base_url('index.php/'.$this->router->fetch_class().'/create');?>'>Create</a> : 
	<a href='<?php echo base_url('index.php/'.$this->router->fetch_class());?>'>Active (<?php  
	echo $this->state_model->active_record_count($table,$this->session->userdata['logged_in']['language_id']);?>)</a>
	
</h2>

</article>