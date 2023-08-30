<article class="container_title">
	
  <h2>
  <?php foreach($formrights as $formrights_row):

    $table='ar_invoice_master';

  	echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'').'" class="ui teal tag label">'.str_replace("_"," ",ucwords($this->router->fetch_class())).'</a> : ' : '');

  	//echo ($formrights_row->new==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/create').'" class="ui blue tag label" ><i class="add circle icon"></i>Create</a> : ' : '');

  //	echo ($formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/archive_records').'" class="ui red tag label"><i class="trash outline icon"></i> Archive ('.$this->common_model->archive_record_count($table,$this->session->userdata['logged_in']['company_id']).')</a> : ' : '');


    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/index_value').'" class="ui blue tag label"><i class="search icon"></i>Costsheet Summary</a> : ' : '');

  	echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/search').'" class="ui blue tag label"><i class="search icon"></i>Coex Costsheet Report</a> : ' : '');

    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/search_spring').'" class="ui red tag label"><i class="search icon"></i>Spring Costsheet Report</a> : ' : '');

    //echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/search_spring').'" class="ui red tag label"><i class="search icon"></i>Spring Costsheet Report</a> : ' : '');

    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/search_by_product').'" class="ui green tag label"><i class="search icon"></i>Costsheet by Product</a> : ' : '');
    
    

    //echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/show_open_transactions').'" class="ui blue tag label"><i class="add circle icon"></i>Open Transactions</a> : ' : '');
  	?> 
  <?php endforeach;?>
  </h2>

</article>