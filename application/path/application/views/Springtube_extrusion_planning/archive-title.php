<article class="container_title">
	
  <h2>
  <?php foreach($formrights as $formrights_row):

    $table='spring_extrusion_planning_master';

  	echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'').'" class="ui teal tag label">'.str_replace("_"," ",ucwords($this->router->fetch_class())).'</a> : ' : '');

  	echo ($formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class()).'" class="ui green tag label"><i class="check square icon"></i>Active ('.$this->common_model->active_record_count($table,$this->session->userdata['logged_in']['company_id']).')</a> : ' : '');

  	echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/search').'" class="ui tag label"><i class="search icon"></i>Search</a> : ' : '');
  ?> 
  <?php endforeach;?>
  </h2>

</article>