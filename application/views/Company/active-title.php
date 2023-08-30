<article class="container_title">
	
  <h2><a href='<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>'><?php echo str_replace("_"," ",ucwords($this->router->fetch_class()));?></a> : <a href='<?php echo base_url('index.php/'.$this->router->fetch_class().'/');?>'>Archive (<?php $table='company_master'; echo $this->common_model->archive_record_count($table,$this->session->userdata['logged_in']['company_id']);?>)</a></h2>
</article>