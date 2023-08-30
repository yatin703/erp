<article class="container_title">
			<h2>Transansactions</h2>
</article>
<!-- <article class="sub_container"> -->
	<div class="left_div">
				<table class="menu_table" height="200px">
				<?php if($formrights==FALSE){
						echo "<tr><td>No Active Records Found</td></tr>";
				}else{
					foreach($formrights as $formrights_row){
						$check=stripos($formrights_row->form_name,"extrusion");
						if($check!=''){
							echo "<tr>
								<td>".$formrights_row->icon."</td>
								<td><a href='".base_url('index.php/'.$formrights_row->file_name.'')."'>".$formrights_row->form_name."</a>
								</td>
							</tr>";
					    }


					}
				}
				?>
				
				</table>
	</div>

	<div class="left_div">
		<table class="menu_table"  height="200px">
				<?php if($formrights==FALSE){
						echo "<tr><td>No Active Records Found</td></tr>";
				}else{
					foreach($formrights as $formrights_row){
						$check=stripos($formrights_row->form_name,"printing");
						if($check!=''){
							echo"<tr>
								<td>".$formrights_row->icon."</td>
								<td><a href='".base_url('index.php/'.$formrights_row->file_name.'')."'>".$formrights_row->form_name."</a>
								</td>
							</tr>";
						}


					}
				}
				?>
				
		</table>
	</div>

	<div class="left_div">
		<table class="menu_table">
				<?php if($formrights==FALSE){
						echo "<tr><td>No Active Records Found</td></tr>";
				}else{
					foreach($formrights as $formrights_row){
						$check=stripos($formrights_row->form_name,"body making");
						if($check!=''){
							echo"<tr>
								<td>".$formrights_row->icon."</td>
								<td><a href='".base_url('index.php/'.$formrights_row->file_name.'')."'>".$formrights_row->form_name."</a>
								</td>
							</tr>";
						}


					}
				}
				?>
				
		</table>
	</div>

	<div class="left_div">
		<table class="menu_table">
				<?php if($formrights==FALSE){
						echo "<tr><td>No Active Records Found</td></tr>";
				}else{
					foreach($formrights as $formrights_row){
						$extrusion=stripos($formrights_row->form_name,"extrusion");
						$printing=stripos($formrights_row->form_name,"printing");
						$bodymaking=stripos($formrights_row->form_name,"body making");

						if($extrusion=='' && $printing=='' && $bodymaking=='' ){
							echo"<tr>
								<td>".$formrights_row->icon."</td>
								<td><a href='".base_url('index.php/'.$formrights_row->file_name.'')."'>".$formrights_row->form_name."</a>
								</td>
							</tr>";
						}


					}
				}
				?>
				
		</table>
	</div>
	 


	

		
<!-- </article> -->