<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/javascript/semantic.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.address/1.6/jquery.address.min.js"></script>
<script>
	$(document).ready(function(){

		$('.menu .item').tab();

});
</script>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>-->
<div class="record_form_design">
	<div class="record_inner_design" style="overflow: scroll;">
		
		<!--<div class="ui menu">
		  <a class="red item active"  data-tab="first">Ink</a>
		  <a class="orange item" data-tab="second">Packing</a>
		  <a class="yellow item" data-tab="third">Other Consumable</a>
		  <a class="olive item" data-tab="fourth">UV</a>
		  <a class="green item" data-tab="five">Screen & Plates</a>
		  <a class="teal item " data-tab="six">Stores & Spares</a>
		</div>
		<div class="ui bottom attached tab segment active" data-tab="first">
		  <?php
		  	setlocale(LC_MONETARY, 'en_IN');
  			$query=$this->db->query("SELECT YEAR( ink_consumption_master.apply_from_date ) AS cost_apply_year, MONTH( ink_consumption_master.apply_from_date ) AS month_no, LEFT( MONTHNAME( ink_consumption_master.apply_from_date ) , 3 ) AS cost_apply_month, ink_consumption_master.cost_per_tube, lacquer_types_master.printing_group AS print
				FROM ink_consumption_master
				INNER JOIN lacquer_types_master ON ink_consumption_master.lacquer_type_id = lacquer_types_master.lacquer_type_id
				WHERE ink_consumption_master.archive <>1
				AND lacquer_types_master.archive <>1
				GROUP BY lacquer_types_master.printing_group, cost_apply_year, month_no
				ORDER BY cost_apply_year DESC , month_no DESC limit 0,3
				");
			$result=$query->result();
			//echo $this->db->last_query();
			?>

			<div id="ink" style="height:250px;" data-colors="#1ab394,#ffc142"></div>
				<script>
				var labelColor = jQuery('#ink').css('color');
				Morris.Bar({
				  element: 'ink',
				  data: [
				  <?php
				  $output = array ();
				  foreach($result as $row){
				  	$output[] = "{ Ink : '$row->cost_apply_month $row->cost_apply_year  $row->print', Cost : $row->cost_per_tube}"; 
				  }
				  echo implode(',', $output);
				  ?>],
				  xkey: 'Ink',
				  ykeys: ['Cost'],
				  labels: ['Cost'],
				});
				</script>
		
		</div>
		<div class="ui bottom attached tab segment" data-tab="second">
		  Second
		</div>
		<div class="ui bottom attached tab segment" data-tab="third">
		  Third
		</div>

		-->

	</div>
</div>