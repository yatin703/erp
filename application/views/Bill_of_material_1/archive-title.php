<article class="container_title">
	
  <h2>
  <?php foreach($formrights as $formrights_row):

    $table='bill_of_material';

    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'').'" class="ui teal tag label">'.str_replace("_"," ",ucwords($this->router->fetch_class())).'</a> : ' : ''); 	

  	echo ($formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/archive_records').'" class="ui red tag label"><i class="minus circle icon"></i> Active ('.$this->common_model->active_record_count($table,$this->session->userdata['logged_in']['company_id']).')</a> : ' : '');

  	
  	?> 
  <?php endforeach;?>
  </h2>

</article>