<article class="container_title">
	
  <h2>
  <?php foreach($formrights as $formrights_row):

    $table='coex_extrusion_printing';

  	echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'').'" class="ui teal tag label">Coex Extrusion Printing</a> : ' : '');

   // echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/search').'" class="ui tag label"><i class="search icon"></i>Search WIP</a> : ' : '');

    //echo ($formrights_row->view==1 ? '<a href="'.base_url('').'" class="ui tag label"><i class="search icon"></i>WIP Report</a> : ' : '');

   // echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/Coex_extrusion_wip_scrap').'" class="ui tag label"><i class="search icon"></i>WIP Scrap</a> : ' : '');

  	?> 
  <?php endforeach;?>
  </h2>

</article>