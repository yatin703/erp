
  <style type="text/css">
  	th{font-size: 11px;}
  </style>
 
	<?php

	    $exchange_rate=0; 
        $freight_in_rupees=0;
        $packaging_in_rupees=0;
        $insurance_in_rupees=0;
        $gross_amount_in_rupees=0;
        $ci =&get_instance();
        
		setlocale(LC_MONETARY, 'en_IN');
		if($ar_invoice_master==FALSE){

		}else{
			echo '<table class="ui sortable selectable celled table" style="font-size:9px;">
		        	

		        	<thead>
								    <tr>
								    	<th colspan="9"><a class="ui orange label">SALES FOR PCB</a>';						    	

								    	echo '<a class="ui olive label"><i class="calendar icon"></i>'.date('d-M',strtotime($this->common_model->view_date($from_date,$this->session->userdata['logged_in']['company_id']))).' TO '.date('d-M',strtotime($this->common_model->view_date($to_date,$this->session->userdata['logged_in']['company_id']))).'</a>';
								    	
								    	echo '</th>
								    </tr>
								    <tr>
								<th>Sr. No.</th>
								<th>Invoice Date</th>
								<th>Invoice No.</th>
								<th>Customer (Bill To)</th>
								<th>Address (Bill To Address)</th>
								<th>State</th>
								<th>Contact No</th>
								<th>GST No</th>
								<th>GST Amount</th>	
							</tr>					        	    
					        	</thead>
		        <tbody>

		        ';
            $i=1;
			foreach ($ar_invoice_master as $key => $row) {
                
                $exchange_rate=($row->exchange_rate!='0' ? $ci->common_model->read_number($row->exchange_rate,$this->session->userdata['logged_in']['company_id']):'');
				
				$freight_in_rupees=$ci->common_model->read_number($row->freight_amt,$this->session->userdata['logged_in']['company_id'])*$exchange_rate;
				
				$packaging_in_rupees=$ci->common_model->read_number($row->packagingcost,$this->session->userdata['logged_in']['company_id'])*$exchange_rate;
				
				$insurance_in_rupees=$ci->common_model->read_number($row->insu_amt,$this->session->userdata['logged_in']['company_id'])*$exchange_rate;
				
				$gross_amount_in_rupees= ($ci->common_model->read_number($row->totalpricewithtax,$this->session->userdata['logged_in']['company_id'])*$exchange_rate)+ $freight_in_rupees + $packaging_in_rupees + $insurance_in_rupees + $row->tcs_amt;

				$data=array('ar_invoice_no'=>$row->ar_invoice_no);

				$data['ar_invoice_master']=$this->sales_invoice_book_model->sales_report_pcb('ar_invoice_master',$this->session->userdata['logged_in']['company_id'],date('Y-m-01',strtotime('-6 month')),date('Y-m-d',strtotime('last day of previous month')),'','','',$data);
			
				echo '<tr>
						<td>'.$i.'</td>
						<td>'.$this->common_model->view_date($row->invoice_date,$this->session->userdata['logged_in']['company_id']).'</td>
						<td>'.$row->ar_invoice_no.'</td>
						<td>'.$row->name1.' ('.strtoupper($row->lang_property_name).')</td>
						<td>'.strtoupper($row->strno).' '.strtoupper($row->name2).' '.strtoupper($row->street).' '.strtoupper($row->name3).'</td>
						<td>'.strtoupper($row->lang_city).'</td>
						<td>'.$row->telephone1.'</td>
						<td>'.$row->isdn_local.'</td>
						<td>'.number_format($gross_amount_in_rupees,2,'.',',').'</td>';
						echo '</tr>';
					$i++;

			}

			 echo "</tbody>


						</table>";
		}
	?>
		 
