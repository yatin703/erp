<article class="container_title">
	
  <h2>
  <?php foreach($formrights as $formrights_row):

    $table='springtube_extrusion_production_master';

  	echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'').'" class="ui teal tag label">Film Extrusion </a> : ' : '');

     echo ($formrights_row->new==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/create').'" class="ui blue tag label" ><i class="add circle icon"></i>Create</a> : ' : '');


    echo ($formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/archive_records').'" class="ui red tag label"><i class="trash outline icon"></i> Archive ('.$this->common_model->archive_record_count($table,$this->session->userdata['logged_in']['company_id']).')</a> : ' : '');


    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/search').'" class="ui tag label"><i class="search icon"></i>Search</a> : ' : '');

    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/Springtube_extrusion_wip').'" class="ui tag label" target="_blank"><i class="search icon"></i>Film WIP</a> : ' : '');

    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/Springtube_extrusion_wip/search_wip_diawise').'" class="ui tag label" target="_blank"><i class="search icon"></i> FIlm WIP Report</a> : ' : '');

    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/Springtube_extrusion_qc').'" class="ui tag label" target="_blank"><i class="search icon"></i>QC Hold</a> : ' : '');

    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/Springtube_extrusion_qc/scrap_search').'" class="ui tag label" target="_blank"><i class="search icon"></i>QC Scrap</a> : ' : '');

    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/search_scrap_diawise').'" class="ui tag label"><i class="search icon"></i>Film Scrap Report</a> : ' : '');

    //echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/Springtube_extrusion_control_plan_qc').'" class="ui tag label" target="_blank"><i class="search icon"></i>QC Control Plan</a> : ' : '');

    //echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/consolidated_search').'" class="ui tag label"><i class="search icon"></i>Film Extrusion Consolidated Report</a> : ' : '');

    // echo'<a class="ui green">
    //       <img class="ui right spaced avatar image" src="../assets/img/Eknath Parkhe.jpg">
    //         For any query contact administrator on 7506401634
    //     </a>';
     

  	?> 
  <?php endforeach;?>
  </h2>

</article>