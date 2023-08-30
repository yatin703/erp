<article class="container_title">
  
  <h2>
  <?php foreach($formrights as $formrights_row):

    $table='product_block_pricing_master';

    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'').'">'.str_replace("_"," ",ucwords($this->router->fetch_class())).'</a> : ' : '');

    echo ($formrights_row->new==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/create').'">Create</a> : ' : '');

    echo ($formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'').'">Active ('.$this->common_model->active_record_count($table,$this->session->userdata['logged_in']['company_id']).')</a> : ' : '');

    echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/search').'">Search</a> : ' : '');
    ?> 
  <?php endforeach;?>
  </h2>

</article>