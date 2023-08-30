<article class="container_title">
	
  <h2>
  <?php foreach($formrights as $formrights_row):


  	echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'').'" class="ui teal tag label">'.str_replace("_"," ",ucwords($this->router->fetch_class())).'</a> : ' : '');

  	
  	?> 
  <?php endforeach;?>
  </h2>

</article>