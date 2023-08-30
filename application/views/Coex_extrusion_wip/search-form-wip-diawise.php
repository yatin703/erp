<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>


<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result_wip_diawise');?>" method="POST"  >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<fieldset style="border: 1px solid #8cacbb;">
		<legend><b>WIP Report Search</b></legend>

		<table class="form_table_design">
			<tr>
				<td width="45%">
					<table class="form_table_inner">
						<?php foreach ($account_periods_master as $account_periods_master_row ):?>
						<tr>
							<td class="label" >From Date <span style="color:red;">*</span>  :</td>
							<td><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date','2020-04-01');?>"/></td>
							<td class="label" >To Date <span style="color:red;">*</span>  :</td>
							<td><input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date',date('Y-m-d'));?>"/></td>
						</tr>
					    <?php endforeach;?>
						 
						<tr>
							<td class="label">Sleeve Length :</td>
							<td>
							 	<input type="number" name="diameter" min="10"  max="500" step="0.1"  id="diameter" size="5" maxlength="5" value="<?php echo set_value('diameter');?>">
							</td> 
						</tr>

					</table>											
				</td>											
			</tr>

			<tr>
			    <td colspan="2">
					<div class="ui buttons">
					  <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
					  <div class="or"></div>
					  <button class="ui positive button" id="btnsubmit" >Search</button>	 
					</div>
				</td>
			</tr>

		</table>		 

		</field>		

 	</div>



 	<div class="record_form_design" style="width:90%;">	
	<div class="record_inner_design" >
        <div class="ui equal width grid">
		  <div class="equal width row">
		    <div class="column">
                <div class="ui segments">
					<div class="ui blue segment">
					    <p><a  class="ui orange label">WIP</a><a  class="ui blue label"> MONTH WISE</a> 
					    <a class="ui olive label"><i class="calendar icon"></i><?php echo($this->input->post('from_date')!='' && $this->input->post('to_date')!=''?$this->input->post('from_date').' TO '.$this->input->post('to_date') : $from_date.' TO '.$to_date);?></a></p>
					</div>	

					<div class="ui segment">
						<table class="ui very basic collapsing celled table"  style="font-size:10px;" id="tbl_data" >
							<thead>
							 <?php echo ($this->input->post('from_date')!='' && $this->input->post('to_date') ? '<a class="ui olive label"><i class="calendar icon"></i>'.$this->input->post('from_date').'  TO '.$this->input->post('to_date').'</a>':'' )?>

							<?php echo $this->input->get('from_date');?>

								<tr>				
									<th>Sr no.</th>						 
									<th>Month</th>
									<th>Order No</th>
									<th>Article No</th>
									<th>Jobcard No</th>
									<th>Dia</th>					
									<th>Length</th>					
									<th style="text-align: center;">WIP</th>
								</tr>

						    </thead>
							<tbody>
								<?php 
								if($coex_extrusion_wip==FALSE){
									echo "<tr><td colspan='8'>No Active Records Found</td></tr>";
								}else{
								$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
									foreach($coex_extrusion_wip as $master_row){
		                                echo"<tr class='tr_test'>		
												<td >".$i++."</td>										
												<td>".$master_row->year."-".strtoupper(substr($master_row->month,0,3))."</td>
												<td>".$master_row->order_no."</td>
												<td>".$this->common_model->get_article_name($master_row->article_no,$this->session->userdata['logged_in']['company_id'])."   (".$master_row->article_no.")</td>
												<td>".$master_row->jobcard_no."</td>
												<td>".$master_row->diameter."</td>
												<td>".$master_row->length."</td>
												<td class='positive right aligned'><b>".money_format('%!.0n',$master_row->ok_by_qc)."</b><i> NOS</i></td>
										    </tr>";										 							
									}//master Foreach
								}?>
							</tbody>				
						</table>
					</div>	
   	            </div>
	        </div>
	      </div>
	    </div>
    </div>
	</div>	
</form>
