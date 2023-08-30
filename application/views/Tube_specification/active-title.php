<article class="container_title">
	
  <h2>
  <?php foreach($formrights as $formrights_row):

    $table='specification_sheet';

  	echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'').'" class="ui teal tag label">'.str_replace("_"," ",ucwords($this->router->fetch_class())).'</a> : ' : '');

    echo ($formrights_row->new==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/create_single_layer').'" class="ui blue tag label" ><i class="add circle icon"></i>1 Layer</a> : ' : '');

    echo ($formrights_row->new==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/create_two_layer_with_cap').'" class="ui blue tag label" ><i class="add circle icon"></i>2 Layer</a> : ' : '');

    echo ($formrights_row->new==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/create_three_layer_with_cap').'" class="ui blue tag label" ><i class="add circle icon"></i>3 Layer</a> : ' : '');

    echo ($formrights_row->new==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/create_five_layer_with_cap').'" class="ui blue tag label" ><i class="add circle icon"></i>5 Layer</a> : ' : '');

    echo ($formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/archive_records').'" class="ui red tag label"><i class="trash outline icon"></i> Archive ('.$this->common_model->archive_record_count($table,$this->session->userdata['logged_in']['company_id']).')</a> : ' : '');


    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/search').'" class="ui tag label"><i class="search icon"></i>Search</a> : ' : '');
  	?> 
  <?php endforeach;?>
  </h2>

</article>