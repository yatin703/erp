<article class="container_title">
	
  <h2>
  <?php foreach($formrights as $formrights_row):

    $table='coex_extrusion_wip';

    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/coex_extrusion_wip/jobcard_plan').'" class="ui teal tag label">Jobcard Plan</a> : ' : '');

    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/search_jobcard_plan').'" class="ui tag label"><i class="search icon"></i>Search Jobcard Plan</a> : ' : '');

  	?> 
  <?php endforeach;?>
  </h2>

</article>