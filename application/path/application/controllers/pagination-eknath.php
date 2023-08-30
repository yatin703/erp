<?php
	$config['base_url']=base_url().'index.php/'.$this->router->fetch_class().'/'.$this->router->fetch_method();
	$config['total_rows']=$num_of_rows;
	$config['per_page']=5;
	$config['num_links'] = 10;
	$config['next_link'] = 'Next';
	$config['prev_link'] = 'Previous';

	$this->pagination->initialize($config);
?>