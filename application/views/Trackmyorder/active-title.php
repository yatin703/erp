<article class="container_title">
	
  <h2>
  <?php foreach($formrights as $formrights_row):

    //$table='springtube_aql_rfd_master';

  	echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'').'" class="ui teal tag label">'.$formrights_row->form_name.'</a> : ' : '');

    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'').'" class="ui tag label"><i class="search icon"></i>Search</a> : ' : '');

    //echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/trackmyorder').'" class="ui tag label"><i class="search icon"></i>Track My Order</a> : ' : '');

  	?> 
  <?php endforeach;?>
  </h2>

</article>