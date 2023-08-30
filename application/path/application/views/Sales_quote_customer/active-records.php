
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/fixcolumn.css');?>"/>
<div class="record_form_design">

<!--
	<div class="zui-wrapper">
    <div class="zui-scroller">
        <table class="zui-table">
            <thead>
                <tr>
                    <th class="zui-sticky-col">Name</th>

                    <th class="zui-sticky-col2">ACTION</th>
                    <th>Number</th>
                    <th>Position</th>
                    <th>Height</th>
                    <th>Born</th>
                    <th>Salary</th>
                    <th>Prior to NBA/Country</th>
                    <th>Number</th>
                    <th>Position</th>
                    <th>Height</th>
                    <th>Born</th>
                    <th>Salary</th>
                    <th>Prior to NBA/Country</th>
                    <th>Number</th>
                    <th>Position</th>
                    <th>Height</th>
                    <th>Born</th>
                    <th>Salary</th>
                    <th>Prior to NBA/Country</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="zui-sticky-col">DeMarcus Cousins</td>

                    <td class="zui-sticky-col">DeMarcus Cousins</td>
                    <td>15</td>
                    <td>C</td>
                    <td>6'11"</td>
                    <td>08-13-1990</td>
                    <td>$4,917,000</td>
                    <td>Kentucky/USA</td>
                    <td>15</td>
                    <td>C</td>
                    <td>6'11"</td>
                    <td>08-13-1990</td>
                    <td>$4,917,000</td>
                    <td>Kentucky/USA</td>
                    <td>15</td>
                    <td>C</td>
                    <td>6'11"</td>
                    <td>08-13-1990</td>
                    <td>$4,917,000</td>
                    <td>Kentucky/USA</td>
                </tr>
                <tr>
                    <td class="zui-sticky-col">Isaiah Thomas</td>

                    <td class="zui-sticky-col">DeMarcus Cousins</td>
                    <td>22</td>
                    <td>PG</td>
                    <td>5'9"</td>
                    <td>02-07-1989</td>
                    <td>$473,604</td>
                    <td>Washington/USA</td>
                </tr>

            </tbody>
        </table>
    </div>
</div>-->

	<h4>Active Records <?php echo ($this->input->post('from_date')!=''? 'From '.$this->input->post('from_date').' To '.$this->input->post('to_date'):'')?></h4>
	<div class="record_inner_design" style="overflow: scroll; white-space: nowrap;">
			<table class="ui very compact celled table"  style="font-size:12px;">
			

				<tr>
				
					<thead>
						<th>Sr no.</th>
						<th>Action</th>

						<th>Add Contact</th>
						<th>Customer Name</th>
						<th>Address</th>

						<th>Country</th>

						<th>State</th>
						<th>City</th>
						<th>Pincode</th>
						<th>Company Type</th>
						<th>Ownership</th>

						<th>Category</th>
						<th>Product Type</th>
						<th>Packaging Type</th>
						<th>Printing Technology</th>
						<th>Current Supplier</th>
						<th>Price Range Min</th>
						<th>Price Range Max</th>
						<th>Tube Price Range Min</th>
						<th>Tube Price Range Max</th>
						<th>Customer Rating</th>
						<th>User id</th>					 
						
					</thead>					 
					 
				</tr>
			
			<tbody>
				<?php 

					
				if($sales_quote_customer_master==FALSE){
					echo "<tr><td colspan='14'>No Active Records Found</td></tr>";
				}else{
						$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
						
						foreach($sales_quote_customer_master as $row){

							
							echo"<tr>
										
									<td >".$i++."</td>
									<td>";
										foreach ($formrights as $formrights_row) {

										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->address_category_details_id.'/'.$row->adr_category_id.'').'" title="view" target="_blank"><i class="print icon"></i></a> ' : '');

										echo ($formrights_row->modify==1 ?' | <a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->address_category_details_id.'').'" title="Modify" target="_blank"><i class="edit icon"></i></a> ' : '');

										echo ($formrights_row->delete==1 ? ' | <a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->address_category_details_id.'').'" title="Delete" target="_blank"><i class="trash icon"></i></a> ' : '');
											
									}
									echo"</td>											
									<td>"; echo ($formrights_row->new==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/add_contact/'.$row->address_category_details_id.'').'" title="add" target="_blank"><i class="plus icon"></i></a> ' : ''); echo "</td> 								 
									<td>".$row->category_name."</td>
									<td>".$row->address."</td>
									<td>".$row->lang_country_name."</td>

									<td>".$this->common_model->get_state_name($row->state,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$row->city."</td>
									<td>".$row->pincode."</td>
									

									<td>";
									
									$sales_quotes_company_type_master_result=$this->common_model->select_one_active_record('sales_quotes_company_type_master',$this->session->userdata['logged_in']['company_id'],'id',$row->company_type);
										foreach ($sales_quotes_company_type_master_result as $key => $sales_quotes_company_type_master_row) {
											echo $sales_quotes_company_type_master_row->company_type;
										}

									echo"</td>
									<td>".$row->ownership."</td>

									<td><div class='ui small label'>".str_replace(',','</div><div class="ui small label">',$row->product_category)."</td>
									<td><div class='ui small label'>".str_replace(',','</div><div class="ui small label">',$row->product_type)."</td>
									<td><div class='ui small label'>".str_replace(',','</div><div class="ui small label">',$row->packaging_type)."</td>
									<td><div class='ui small label'>".str_replace(',','</div><div class="ui small label">',$row->printing_technology)."</td>
									<td><div class='ui small label'>".str_replace(',','</div><div class="ui small label">',$row->current_supplier)."</td>
									<td>".$row->product_price_range_min."</td>
									<td>".$row->product_price_range_max."</td>
									<td>".$row->product_price_range_intubes_min."</td>
									<td>".$row->product_price_range_intubes_max."</td>
									<td>";
									 
									if($row->images!=''){
										$img_arr=explode(",",$row->images);
																			
										foreach ($img_arr as $key => $image_name) {
											
											echo'<a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/customer_quotation/'.$image_name.'').'" target="_blank"><i class="file pdf outline icon"></i>
											</a>';
										}								
									
									}
									echo"</td>									
									 <td>".$this->common_model->get_user_name($row->user_id,$this->session->userdata['logged_in']['company_id'])."</td>";
										

						} 

					}?>
				</tbody>				
			</table>
			<div class="pagination"><?php echo $this->pagination->create_links();?></div>
	</div>
</div>