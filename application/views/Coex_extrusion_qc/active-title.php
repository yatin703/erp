<article class="container_title">
	
  <h2>
  <?php foreach($formrights as $formrights_row):

    $table='coex_extrusion_qc';

  	echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/coex_extrusion_qc/pending').'" class="ui teal tag label">Coex Extrusion QC</a> : ' : '');
    
    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/search').'" class="ui tag label"><i class="search icon"></i>QC Hold Search</a> : ' : '');    
    
    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/released_search').'" class="ui tag label"><i class="search icon"></i>QC Released Search</a> : ' : '');   

    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/coex_extrusion_qc/pending_search').'" class="ui tag label"><i class="search icon"></i>QC Pending Search</a> : ' : '');

    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/coex_extrusion_qc/scrap_search').'" class="ui tag label"><i class="search icon"></i>QC Scrap Search</a> : ' : '');

  	?> 
  <?php endforeach;?>
  </h2>

</article>