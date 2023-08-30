<article class="container_title">
	
  <h2>
  <?php foreach($formrights as $formrights_row):

  	echo ($formrights_row->view==1 && $this->uri->segment(2)=='' ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'').'" class="ui teal tag label">'.str_replace("_"," ",ucwords($this->router->fetch_class())).'</a>' : 
  		'<a href="'.base_url('index.php/'.$this->router->fetch_class().'').'" class="ui teal tag label">'.str_replace("_"," ",ucwords($this->router->fetch_class())).'</a> <a href="'.base_url('index.php/'.$this->router->fetch_class().'/'.$this->uri->segment(2)).'" class="ui blue tag label">'.str_replace('_',' ',strtoupper($this->uri->segment(2))).'</a>');

    ?> 
  <?php endforeach;?>
  </h2>

</article>