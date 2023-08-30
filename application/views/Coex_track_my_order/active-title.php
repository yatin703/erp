<article class="container_title">
	
  <h2>
  <?php foreach($formrights as $formrights_row):

    $table='springtube_printing_production_master';

  	echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'').'" class="ui teal tag label">Track My Order</a> : ' : '');

  	echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/search').'" class="ui tag label"><i class="search icon"></i>Search</a> : ' : '');

  	?> 
  <?php endforeach;?>
  </h2>

</article>