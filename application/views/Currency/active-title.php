<article class="container_title">
	
 <h2>
	
	<?php foreach($formrights as $formrights_row):

		$table='currency_rates_master';

		echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'').'" class="ui teal tag label">'.str_replace("_"," ",ucwords($this->router->fetch_class())).'</a> : ' : '');

  		echo ($formrights_row->new==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/create').'" class="ui blue tag label" ><i class="add circle icon"></i>Create</a> : ' : '');

  		echo ($formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/archive_records').'" class="ui red tag label"><i class="minus circle icon"></i>Archive ('.$this->common_model->archive_record_count_noncompany($table,$this->session->userdata['logged_in']['company_id']).')</a> : ' : '');

  		echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/search').'" class="ui tag label"><i class="search icon"></i>Search</a> : ' : '');
	?>

		

		<!--<a href='<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>'>
				<?php echo str_replace("_"," ",ucwords($this->router->fetch_class()));?></a> : 

		<a href='<?php echo base_url('index.php/'.$this->router->fetch_class().'/create');?>'>Create</a> : 

		<a href='<?php echo base_url('index.php/'.$this->router->fetch_class().'/archive_records');?>'>Archive (<?php  
		echo $this->common_model->archive_record_count_noncompany($table);?>) : </a>

		<a href='<?php echo base_url('index.php/'.$this->router->fetch_class().'/search');?>'>Search</a> :
	-->

	<?php endforeach;?>
	
</h2>

</article>