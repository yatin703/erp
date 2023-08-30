<article class="container_title">
			<h2>Transansactions</h2>
		</article>
		<article class="sub_container">
			<div class="left_div">
				<table class="menu_table">
				<?php if($formrights==FALSE){
						echo "<tr><td>No Active Records Found</td></tr>";
				}else{
					$i=1;
					$icon="";
					foreach($formrights as $formrights_row){
						$icon=($formrights_row->icon!='' ? $formrights_row->icon : '<i class="arrow circle right icon"></i>');
						echo "<tr><td>".$icon."</td><td><a href='".base_url('index.php/'.$formrights_row->file_name.'')."'>".$formrights_row->form_name."</a></td></tr>";

						if($i==10 OR $i==21 OR $i==30 OR $i==40){
							echo "</table></div><div class='left_div'><table class='menu_table'>";
						}

					$i++;
					}
				}
				?>
				
				</table>
			</div>
		
		</article>