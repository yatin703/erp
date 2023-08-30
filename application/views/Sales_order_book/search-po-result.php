
<div class="record_form_design">
	<!-- <a class="pull-right btn btn-warning btn-large" style="margin-right:40px" href="<?php echo base_url('index.php/'.$this->router->fetch_class().'/createExcel/'.str_replace("/","_", $this->input->post('cust_order_no')).'/'.str_replace("//","_", $this->input->post('adr_company_id')).'   ');?>"><button class="ui icon blue mini button"><i class="file excel outline icon"></i > Export to Excel  </button></a> -->

	<a class="pull-right btn btn-warning btn-large" style="margin-right:40px" href="<?php echo base_url('index.php/'.$this->router->fetch_class().'/createExcel/'.($this->input->post('cust_order_no')<>"" ? str_replace("/","_", $this->input->post('cust_order_no')) : "PO.NO.").'/'.  ($this->input->post('adr_company_id')<> "" ? str_replace("//","_", $this->input->post('adr_company_id')) : "CUST.NO.").'   ');?>"><button class="ui icon blue mini button"><i class="file excel outline icon"></i > Export to Excel  </button></a> 




	<div class="record_inner_design" >
		<div class="tableFixHead">		
		<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/hold');?>" method="POST" target="_blank">
		<table id="dataTable" class="ui very compact sortable selectable celled table" style="font-size:10px;">
			<thead>
			<tr>
				<th>Sr. No.</th>
				<th>OC Date</th>				
				<th>Order Date</th>
				<th>Order No.</th>			
				<th>Po No.</th>
				<th>Po Date</th>
				<th>Customer Product code</th>
				<th>Product No.</th>
				<th>Product Des</th>
				<th class="center aligned">Quantity</th>
				<th>Pending Qty</th>
				<th>Approval Date</th>		
			</tr>
			</thead>
			<tbody>
		<?php if($order_master==FALSE){
			echo "<tr><td colspan='7'>No Records Found</td></tr>";
		}
		else 
		{	
			
			$i=1;
			foreach($order_master as $row){
				echo "<tr>
				<td>".$i."</td>
				<td>".$this->common_model->view_date($row->oc_date,$this->session->userdata['logged_in']['company_id'])."</td>
				<td>".$this->common_model->view_date($row->order_date,$this->session->userdata['logged_in']['company_id'])."</td>
				<td>".$row->order_no."</td>
				<td>".$row->cust_order_no."</td>
				<td>".$this->common_model->view_date($row->cust_order_date,$this->session->userdata['logged_in']['company_id'])."</td>
				<td>".$row->cust_product_no."</td>
				<td>".$row->article_no."</td>
				<td>".$this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
				<td>".($row->quantity)."</td>
				<td>".$row->pending."</td>
				<td>".$this->common_model->view_date($row->approval_date,$this->session->userdata['logged_in']['company_id'])."</td>

				</tr>"; 

				$i++;
			}
		} 
		?>
		<?php  
		echo "</tbody>";

		?>				
	</table>
	</form>
	</div>			
	</div>
</div>
				
				
				
				
				
			