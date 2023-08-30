<article class="container_title">
			<h2>Transansactions</h2>
		</article>
		<article class="sub_container">
			<div class="left_div">
				<table class="menu_table">
				<?php if($formrights==FALSE){
						echo "<tr><td>No Active Records Found</td></tr>";
				}else{
					foreach($formrights as $formrights_row){
						echo "<tr><td>".$formrights_row->icon."</td><td><a href='".base_url('index.php/'.$formrights_row->file_name.'')."'>".$formrights_row->form_name."</a></td></tr>";
					}
				}
				?>
				
				</table>
			</div>
		
		</article>