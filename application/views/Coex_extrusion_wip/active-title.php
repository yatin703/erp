<article class="container_title">
	
  <h2>
  <?php foreach($formrights as $formrights_row):

    $table='coex_extrusion_wip';

  	echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'').'" class="ui teal tag label">Coex Extrusion WIP</a> : ' : '');
    
    //echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/Coex_extrusion_wip/scrap').'" class="ui teal tag label">Coex Extrusion WIP Scrap</a> : ' : '');

    //echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/Coex_extrusion_jobcard_plan_wip').'" class="ui teal tag label">Coex Extrusion WIP  Jobcard Plan </a> : ' : '');

    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/search').'" class="ui tag label"><i class="search icon"></i>Search WIP</a> : ' : '');

     echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/search_wip_scrap').'" class="ui tag label"><i class="search icon"></i>Search WIP Scrap</a> : ' : '');

     //echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/Coex_extrusion_jobcard_plan_wip/search').'" class="ui tag label"><i class="search icon"></i>Search Jobcard Plan Wip</a> : ' : '');


     //echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/Coex_extrusion_wip/wip_release_qty').'" class="ui tag label"><i class="search icon"></i>WIP Release QTY</a> : ' : '');

  	?> 
  <?php endforeach;?>
  </h2>

</article>

