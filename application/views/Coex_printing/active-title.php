<article class="container_title">
	
  <h2>
  <?php foreach($formrights as $formrights_row):

    $table='coex_printing';

  	echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'').'" class="ui teal tag label">Coex Printing</a> : ' : '');

    echo ($formrights_row->new==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/create').'" class="ui blue tag label" ><i class="add circle icon"></i>Create</a> : ' : '');

  	echo ($formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/archive_records').'" class="ui red tag label"><i class="trash outline icon"></i> Archive ('.$this->common_model->archive_record_count($table,$this->session->userdata['logged_in']['company_id']).')</a> : ' : '');

  	echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/search').'" class="ui tag label"><i class="search icon"></i>Search</a> : ' : '');

     echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/current_status').'" class="ui tag label"><i class="search icon"></i>Current Status</a> : ' : '');

    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/runtime').'" class="ui tag label"><i class="search icon"></i>Runtime</a> : ' : '');

    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/runtime_search').'" class="ui tag label"><i class="search icon"></i>Runtime Search</a> : ' : '');

    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/downtime').'" class="ui tag label"><i class="search icon"></i>Downtime</a> : ' : '');

    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/downtime_search').'" class="ui tag label"><i class="search icon"></i>Downtime Search</a> : ' : '');

    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/printing_time_summary').'" class="ui tag label"><i class="search icon"></i>Prinitng Time Summary</a> : ' : '');

    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/summary').'" class="ui blue tag label"><i class="search icon"></i>Summary</a> : ' : '');

  	?> 
  <?php endforeach;?>
  </h2>

</article>