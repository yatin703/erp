<article class="container_title">
	
  <h2>
  <?php foreach($formrights as $formrights_row):

    $table='springtube_bodymaking_production_master';

  	echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'').'" class="ui teal tag label">Film Body Making </a> : ' : '');

     echo ($formrights_row->new==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/create').'" class="ui blue tag label" ><i class="add circle icon"></i>Create</a> : ' : '');


    echo ($formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/archive_records').'" class="ui red tag label"><i class="trash outline icon"></i> Archive ('.$this->common_model->archive_record_count($table,$this->session->userdata['logged_in']['company_id']).')</a> : ' : '');


    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/search').'" class="ui tag label"><i class="search icon"></i>Search</a> : ' : '');

    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/Springtube_bodymaking_wip').'" class="ui tag label" target="_blank"><i class="search icon"></i>Film Bodymaking WIP</a> : ' : '');
    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/Springtube_bodymaking_qc').'" class="ui tag label" target="_blank"><i class="search icon"></i>QC Hold</a> : ' : '');

     echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/Springtube_bodymaking_control_plan_qc').'" class="ui tag label" target="_blank"><i class="search icon"></i>QC Control Plan</a> : ' : '');

  	?> 
  <?php endforeach;?>
  </h2>

</article>