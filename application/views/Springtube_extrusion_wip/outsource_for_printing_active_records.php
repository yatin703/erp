<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		
	    $("table tr").click(function(e){
	    	$("table tr").removeClass('on-hower');	
	        $(this).addClass('on-hower');
	    }); 

	    $("#tbl_data .td_wip_cost").each(function(){
			//alert($(this).html());
			//if($(this).html()==0){
				//$(this).parent("tr").css("background-color","pink");
				$(this).parent("tr").addClass("negative");
			//}

		})
	});
</script>

<style>
	.on-hower{
        background-color:#e4e4e4;
    }
	tr:hover {background-color:#e4e4e4;}
	th{text-align:center;border-top: 1px solid rgba(34,36,38,.1)}
</style>	
   
<div class="record_form_design">
	<h4>Film WIP Active Records <?php echo ($this->input->post('from_date')!=''? 'From '.$this->input->post('from_date').' To '.$this->input->post('to_date'):'')?></h4>
	<div class="record_inner_design" style="overflow: scroll; white-space: nowrap;">
			<table class="ui green sortable selectable celled table" style="font-size:10px;"  id="tbl_data" >
				<thead>
					<tr>
						<th colspan="12">Details</th>
						<th colspan="2">Released in Mtr</th>
						<th colspan="2">Released in Sqm</th>
						<th colspan="3">Received in Mtr</th>
						<th colspan="2">Received in Sqm</th>
						<th colspan="2"></th>
					</tr>
  <tr>		
   				<th>Sr no.</th>
					<th>Release Date</th>
					<!-- <th>From Process</th> -->					
					<th>Customer</th>					
					<th>Order No.</th>					 	
					<th>Article No.</th>
					<th>Article Name</th>
					<th>Dia</th>
					<th>Tube Length</th>
					<th>Microns</th>					
					<!-- <th>Film_code</th> -->
					<th>Second Layer MB</th>				
					<th>Sixth Layer MB</th>								
					<th>Film Code</th>
<!-- 					<th>Film Name</th> -->
					<th>Released Qty in Mtr</th>
					<th>Released Cost/Mtr</th>
					<th>Released Qty in SQM</th>
					<th>Released Cost/SQM</th>
					

					<th>Received Date</th>
					<th>Received Qty in Mtr</th>
					<th>Received Cost/Mtr</th>
					<th>Received Qty in SQM</th>
					<th>Received Cost/SQM</th>
					<th>Total Amount</th>
					<th>Action</th> 
  </tr>
</thead>
  <?php
            $date='';
			$i=1;
			 foreach($springtube_outsource_for_printing as $row){ 

			 		if($row->sleeve_dia=='35 MM'){
                               
                               $a=$row->released_meters*0.244;
                                 }
                                 elseif($row->sleeve_dia=='40 MM'){

                               $a=$row->released_meters*0.276;

                                 }else{

                               $a=$row->released_meters*0.335;

                                 }

			 	?> 
  
  <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $this->common_model->view_date($row->outsource_date,$this->session->userdata['logged_in']['company_id']) ?></td>
              <td><?php echo $this->common_model->get_customer_name($row->customer,$this->session->userdata['logged_in']['company_id']);  ?></td>
              <td><?php echo $row->order_no;  ?></td>
              <td><?php echo $row->article_no;  ?></td>
              <td><?php echo $this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id']);  ?></td>
              <td><?php echo $row->sleeve_dia;  ?></td>
              <td><?php echo $row->sleeve_length;  ?></td>
              <td><?php echo $row->total_microns;  ?></td>
              <td><?php echo $this->common_model->get_article_name($row->second_layer_mb,$this->session->userdata['logged_in']['company_id']);  ?></td>
              <td><?php echo $this->common_model->get_article_name($row->sixth_layer_mb,$this->session->userdata['logged_in']['company_id']);  ?></td>
              <td><?php echo $row->film_code;  ?></td>
              <td><?php echo $row->released_meters;?></td>
              <td><?php echo $row->cost_per_meter;?></td>
              <td><?php echo $a;  ?></td>
              <td><?php echo ($a<>0 ? round(($row->released_meters*$row->cost_per_meter)/$a,2) : '0');  ?></td>
              

              <td><?php echo $this->common_model->view_date($row->received_date,$this->session->userdata['logged_in']['company_id']) ?></td>

              <td><?php echo round($row->received_qty_in_meter,2);  ?></td>
              <td><?php echo round($row->received_cost_per_meter,2);  ?></td>
              <td><?php echo $row->received_qty_in_sqm;  ?></td>
              <td><?php echo $row->received_qty_cost_per_sqm;  ?></td>
              <td><?php echo round($row->total_amount,2); ?></td>
              <td><?php foreach ($formrights as $formrights_row) {

              	echo ($formrights_row->new==1 && $row->received_flag<>1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/received_after_printing/'.$row->sofp_id.'').'" title="Received after Printinng"><i class="edit icon"></i></a> | ' : '');
              	
              	echo ($formrights_row->new==1 && $row->inspection_flag<>1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/outsource_inspection_create/'.$row->sofp_id.'').'" title="Inspection Entry"><i class="plus icon"></i></a>' : '');
              

              }?></td>

              </tr>
              <?php $i++;	}   ?>
</table>
			
	</div>
</div>



