<style>	
   tr:hover {background-color:#e4e4e4;}
</style>
<div class="record_form_design">
	<h4>Active Records <?php echo $this->input->post("from_date") != ""
     ? "From " .
         $this->input->post("from_date") .
         " To " .
         $this->input->post("to_date")
     : ""; ?></h4>
	<div class="record_inner_design" style="overflow: scroll; white-space: nowrap;"> 

<?php
echo '<table class="ui green sortable celled table"  style="font-size:9px">';
echo '<thead>
      <tr>
          <th colspan="9"></th>
          <th colspan="8" class="center aligned">PRODUCTION</th>   
      </tr>
			<tr>
				<thead>
					<th class="center aligned">Sr No</th>
					<th class="center aligned">Date</th>	
					<th class="center aligned">Customer</th>
					<th class="center aligned">Order No</th>									
					<th class="center aligned">Article No</th>					
					<th class="center aligned">Dia</th>
					<th class="center aligned">Length</th>
					<th class="center aligned">Total Order Qty</th>	
          <th class="center aligned">Print Type</th>	
          <th class="center aligned">Production Qty</th>
          <th class="center aligned">Production Scrap</th> 
          <th class="center aligned">QC Hold Qty</th>
          <th class="center aligned">QC Scrap Qty</th>
          <th class="center aligned">WIP Qty</th>
          <th class="center aligned">WIP Scrap Qty</th>
          <th class="center aligned">Heading Qty</th>
          <th class="center aligned">Printing Qty</th>
      </tr>
			</thead>';

$i = 1;
foreach ($coex_track_order as $row) {
    $ok_by_qc = "";
    $hold_by_qc = "";
    $scrap_by_qc = "";
    $scrap_by_wip="";
    $a = $row->extrusion_date;
    $convertDate = date("d-M-Y", strtotime($a));
    $s = $row->total_order_quantity;
    $t = $s / 100;

    $order_num = $this->trackmyorder_model->active_track_order_record_wip(
        $row->order_no
    );

    foreach ($order_num as $order_row) {
        $ok_by_qc = $order_row->ok_by_qc;
    }

   $order_scrap_wip = $this->trackmyorder_model->active_track_order_record_wip_scrap($row->order_no);

    foreach ($order_scrap_wip as $order_row) {
        $scrap_by_wip = $order_row->scrap_by_wip;
    }

    $order_qc = $this->trackmyorder_model->active_track_order_record_qc(
        $row->order_no
    );

    foreach ($order_qc as $order_row) {
        $hold_by_qc = $order_row->hold_by_qc;
    }

    $order_scrap = $this->trackmyorder_model->active_track_order_record_scrap($row->order_no);

    foreach ($order_scrap as $order_row) {
        $scrap_by_qc = $order_row->scrap_by_qc;
    }

    echo "
			<tr>
				<td class='right aligned'>$i</td>
        <td class='right aligned'>$convertDate</td>	
        <td>$row->customer</td>
        <td>$row->order_no</td>	
        <td class='right aligned'>$row->article_no</td> 
        <td class='right aligned'>$row->diameter</td>
        <td class='right aligned'>$row->length</td>
        <td class='right aligned'>$t</td>
        <td class='positive' style='text-align:right;'>$row->print_type</td>				
		    <td class='positive' style='text-align:right;'>$row->production_qty</td>
        <td class='negative' style='text-align:right;'>$row->production_scrap</td>
		    <td class='positive' style='text-align:right;'>$hold_by_qc</td>
        <td class='negative' style='text-align:right;'>$scrap_by_qc</td>
		    <td class='positive' style='text-align:right;'>$ok_by_qc</td>
        <td class='negative' style='text-align:right;'>$scrap_by_wip</td>
        <td class='positive' style='text-align:right;'></td>
        <td class='positive' style='text-align:right;'></td>";
      "</tr>";
    $i++;
}
echo "</table>";


?>
