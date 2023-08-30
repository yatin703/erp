<article class="container_title">
	
  <h2>
  <?php foreach($formrights as $formrights_row):

    $table='springtube_printing_production_master';

  	echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'').'" class="ui teal tag label">Film printing </a> : ' : '');

    echo ($formrights_row->new==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/create').'" class="ui blue tag label" ><i class="add circle icon"></i>Create</a> : ' : '');

    echo ($formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/archive_records').'" class="ui red tag label"><i class="trash outline icon"></i> Archive ('.$this->common_model->archive_record_count($table,$this->session->userdata['logged_in']['company_id']).')</a> : ' : '');

    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/search').'" class="ui tag label" target="_blank"><i class="search icon"></i>Search</a> : ' : '');

    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/springtube_printing_inspection').'" class="ui tag label" target="_blank"><i class="search icon" ></i>Inspection</a> : ' : '');

    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/springtube_printing_wip_after_print').'" class="ui tag label" target="_blank"><i class="search icon" ></i>Printing WIP</a> : ' : '');

    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/springtube_ink_mixing').'" class="ui tag label" target="_blank"><i class="search icon" ></i>Ink Mixing</a> : ' : '');

    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/Springtube_printing_jobsetup').'" class="ui tag label" target="_blank"><i class="search icon" ></i>Job Setup</a> : ' : '');

    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/springtube_printing_control_plan_qc').'" class="ui tag label" target="_blank"><i class="search icon" ></i>Control Plan</a> : ' : '');

  	?> 
  <?php endforeach;?>
  </h2>

</article> 