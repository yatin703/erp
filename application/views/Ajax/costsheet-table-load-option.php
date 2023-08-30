 <style>
      .tableFixHead {
        overflow-y: auto;
        height: 480px;
      }
      .tableFixHead thead th {
        position: sticky;
        top: 0;
      }
  </style>

		<?php 

		if($costsheet_data==FALSE){
			//echo "NO RECORD FOUND";
		}else{


					echo ($layer<>'' || $sleeve_dia<>'' ? "<a class='ui green label'>TUBE</a>&nbsp;" : "");
					echo ($layer<>'' ? "<a class='ui green label'>".$layer." LAYER</a>&nbsp" : "");
					echo ($sleeve_dia<>'' ? "<a class='ui green label'>".$sleeve_dia."</a>&nbsp " : "");
					echo ($print_type<>'' ? "<a class='ui green label'>".$print_type." </a>&nbsp <br/><br/>" : "");
					echo ($shoulder<>'' ? "<a class='ui blue label'>SHOULDER</a>&nbsp;" : "");
					echo ($shoulder<>'' ? "<a class='ui blue label'>".$shoulder."</a>&nbsp <br/><br/>" : "");
					echo ($cap_type<>'' || $cap_dia<>'' || $cap_finish<>'' ? "<a class='ui orange label'>CAP</a>&nbsp;" : "");
					echo ($cap_type<>'' ? "<a class='ui orange label'>".$cap_type."</a>&nbsp" : "");
					echo ($cap_finish<>'' ? "<a class='ui orange label'>".$cap_finish."</a>&nbsp" : "");
					echo ($cap_dia<>'' ? "<a class='ui orange label'>".$cap_dia."</a>&nbsp <br/><br/>" : "");
					echo ($shoulder_foil<>'' || $cap_foil<>'' || $cap_metalization<>'' || $cap_shrink_sleeve<>'' || $tube_foil<>'' ? "<a class='ui purple label'>DECORATIVE</a>&nbsp;" : "");
					echo ($shoulder_foil=='YES' ? "<a class='ui purple label'> SHOULDER FOIL</a>&nbsp" : "");
					echo ($cap_foil=='YES' ? "<a class='ui purple label'> CAP FOIL</a>&nbsp" : "");
					echo ($cap_metalization=='YES' ? "<a class='ui purple label'> CAP METALIZATION</a>&nbsp" : "");
					echo ($cap_shrink_sleeve=='YES' ? "<a class='ui purple label'> CAP SHRINK SLEEVE</a>&nbsp" : "");
					echo ($tube_foil=='YES' ? "<a class='ui purple label'> TUBE FOIL</a>&nbsp" : "");
				
				 echo "<br/><br/>";
		}

		?>

<div class="tableFixHead">
<table class="ui  celled table"  style="font-size:8px; overflow: scroll;">
	
		<thead>
			<tr>
			<th>SR NO</th>
			<th>INVOICE NO</th>
			<th>INVOICE DATE</th>
			
			<th>ORDER NO </th>
			<th>ARTICLE NO </th>
			<th>ARTICLE DESCRIPTION </th>
			<th>QUANTITY</th>	
			<th>UNIT RATE</th>
			<th>COST/TUBE	</th>
			<th>CON</th>
			<th>CON%</th>

			<th>Sleeve</th>
			<th>Purg</th>
			<th>Shoulder</th>
			<th>Printing</th>
			<th>Consumable</th>
			<th>Label</th>
			<th>Foil</th>
			<th>Shoulder Foil</th>
			<th>Cap</th>
			<th>Moulding Cost</th>
			<th>Shrink Sleeve	</th>
			<th>Packing	</th>
			<th>Stores & Spares	</th>
			<th>Additional	</th>
			<th>Freight	</th>
			<th>Other Cost	</th>



			</tr>
		</thead>
	
	<tbody>
<?php 
setlocale(LC_MONETARY, 'en_IN');
if($costsheet_data==FALSE){
	echo "<tr><td colspan='5'>NO RECORD FOUND</td></tr>";
}else{
	$i=1;
	foreach ($costsheet_data as $costsheet_data_row){
		echo "<tr>

				<td>".$i."</td>
				<td><a href='".base_url('index.php/costsheet/view/'.$costsheet_data_row->invoice_no.'/'.$costsheet_data_row->order_no.'/'.$costsheet_data_row->article_no)."' target='_blank'>".$costsheet_data_row->invoice_no."</a></td>

				<td>".$this->common_model->view_date($costsheet_data_row->invoice_date,$this->session->userdata['logged_in']['company_id'])."</td>
				
				<td><a href=".base_url('index.php/sales_order_book/view/'.$costsheet_data_row->order_no)." target='_blank'>".$costsheet_data_row->order_no."</a></td>	


				<td>".$costsheet_data_row->article_no."</td>	
				<td>".$this->common_model->get_article_name($costsheet_data_row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>	

				<td>".money_format('%!.0n',$costsheet_data_row->dispatch_quantity)."</td>	
				<td>".$costsheet_data_row->unit_rate."</td>
				<td>".$costsheet_data_row->total_cost."</td>
				<td>".$costsheet_data_row->con_per_tube."</td>
				<td>".$costsheet_data_row->con_percentage." %</td>

				<td>".$costsheet_data_row->sleeve_cost."</td>
				<td>".$costsheet_data_row->purging_cost."</td>
				<td>".$costsheet_data_row->shoulder_cost."</td>
				<td>".$costsheet_data_row->printing_cost."</td>
				<td>".$costsheet_data_row->cosumable_cost."</td>
				<td>".$costsheet_data_row->label_cost."</td>
				<td>".$costsheet_data_row->foil_cost."</td>
				<td>".$costsheet_data_row->shoulder_foil_cost."</td>
				<td>".$costsheet_data_row->capping_cost."</td>
				<td>".$costsheet_data_row->moulding_cost."</td>
				<td>".$costsheet_data_row->shrink_sleeve_cost."</td>
				
				<td>".$costsheet_data_row->packaging_cost."</td>
				<td>".$costsheet_data_row->stores_spares_cost."</td>
				<td>".$costsheet_data_row->additional_cost."</td>
				<td>".$costsheet_data_row->freight_cost."</td>
				<td>".$costsheet_data_row->other_cost."</td>

			  </tr>";
			  $i++;
  }    	
}

?>
	</tbody>
</table>
</div>