<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/received_after_printing_save');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">

						<?php
                               $release_date='';
                               $sofp_id='';
                               $order_no='';
                               $article_no='';
                               $film_code='';
                               $film_name='';
                               $sleeve_dia='';
                               $sleeve_length='';
                               $total_microns='';
                               $second_layer_mb='';
                               $sixth_layer_mb='';
                               $jobcard_no='';
                               $pt_release_meters='';
                               $sqr_mtr='';
                               $a='';

						 foreach($springtube_outsource_for_printing as $row){
                                
                                $release_date=$row->outsource_date;
                                $sofp_id=$row->sofp_id;
                                $order_no=$row->order_no;
                                $article_no=$row->article_no;
                                $film_code=$row->film_code;
                                $film_name=$row->film_name;
                                $sleeve_dia=$row->sleeve_dia;
                                $sleeve_length=$row->sleeve_length;
                                $total_microns=$row->total_microns;
                                $second_layer_mb=$row->second_layer_mb;
                                $sixth_layer_mb=$row->sixth_layer_mb;
                                $jobcard_no=$row->jobcard_no;
                                $pt_release_meters=$row->released_meters;

                                

						}

                             if($sleeve_dia=='35 MM'){
                               
                               $a=$pt_release_meters*0.244;
                                 }
                                 elseif($sleeve_dia=='40 MM'){

                               $a=$pt_release_meters*0.276;

                                 }else{

                               $a=$pt_release_meters*0.335;

                                 }
						 ?>
                                 


							
						

						<tr>
							<td class="label">Release Date <span style="color:red;">*</span> :</td>
							<td><input type="hidden" name="sofp_id" value="<?php echo set_value('sofp_id',$sofp_id);?>">
								<input type="date" name="date"   value="<?php echo set_value('date',$release_date);?>" readonly />
								&nbsp;&nbsp;&nbsp; Order No.  : 
								<input type="text" name="order_no" id="order_no"  size="20" value="<?php echo set_value('order_no',$order_no);?>" readonly/> 

							</td>
							
						</tr>
						<!-- <tr> 
							<td class="label">Order No.  :</td>
							<td ><input type="text" name="order_no" id="order_no"  size="20" value="<?php echo set_value('order_no',$order_no);?>" readonly/></td>
						</tr> -->
		
						<tr>
							<td class="label">Article No.  :</td>
							<td ><input type="text" name="article_no" id="article_no"  size="60" value="<?php echo set_value('article_no',$article_no); ?>" readonly/></td>
						</tr>

						<tr>
							<td class="label">Film Code  :</td>
							<td ><input type="text" name="film_code" id="film_code"  size="60" value="<?php echo set_value('film_code',$film_code);?>" readonly/></td>
						</tr>
						
           	<tr>
							<td class="label">Film Name  :</td>
							<td ><input type="text" name="film_name" id="film_name"  size="60" value="<?php echo set_value('film_name',$film_name); ?>" readonly/></td>
						</tr>
						<tr>

							<td class="label">Sleeve Dia :</td>
				      <td><input type="text"  name="sleeve_diameter" id="sleeve_diameter" value="<?php echo set_value('sleeve_dia',$sleeve_dia); ?>" readonly>
				             &nbsp;Length : <input type="text"  name="sleeve_length" id="sleeve_length" value="<?php echo set_value('sleeve_length',$sleeve_length); ?>"  size="10"readonly>
				       </td>
				    </tr>

				     <tr>
				            <td class="label">Total Microns :</td>
				            <td><input type="text"  name="total_microns" id="total_microns" value="<?php echo set_value('total_microns',$total_microns); ?>" readonly>
				            </td>
				        </tr>
				        <tr>
				            <td class="label">Second Layer MB :</td>
				            <td><input type="text"  name="film_mb_2" id="film_mb_2" value="<?php echo set_value('second_layer_mb',$second_layer_mb); ?>" readonly>
				            </td>
				        </tr>
				        <tr>
				            <td class="label">Sixth Layer MB :</td>
				            <td><input type="text"  name="film_mb_6" id="film_mb_6" value="<?php echo set_value('sixth_layer_mb',$sixth_layer_mb); ?>" readonly>
				            </td>
				        </tr>
						
						<tr>
							<td class="label">Jobcard No.  :</td>
							<td ><input type="text" name="jobcard_no" id="jobcard_no"  size="20" value="<?php echo set_value('jobcard_no',$jobcard_no);?>" readonly/></td>
						</tr>
						<tr>
							<td class="label">Total Released Meters for Outsource Printing  :</td>
							<td >				
							<input type="text" name="total_ok_meters" id="total_ok_meters"  size="20" value="<?php echo set_value('pt_release_meters',$pt_release_meters);?>" readonly/>
							
						</td>
						</tr>

						<tr>
							<td class="label">Total Released SQM for Outsource Printing :</td>
							<td >				
							<input type="text" name="total_ok_sqm" id="total_ok_sqm"  size="20" value="<?php echo set_value('pt_release_meters',$a);?>" readonly/>
							
						</td>
						</tr>
					</table>
				</td>
			
				<td>
					<table class="form_table_inner">

						<tr>
							<td class="label">Received Date <span style="color:red;">*</span> :</td>
							<td><input type="date" name="received_date"   value="<?php echo set_value('received_date',date('Y-m-d'));?>" readonly /></td>
							
						</tr>
<!--
						<tr>
							<td class="label">Total Received Printed Film in Meters  :</td>
							<td >				
							<input type="text" name="total_resived_meters" id="total_resived_meters"  size="20" value="" />
							
						</td>
						</tr>-->

						<tr>
							<td class="label">Total Received Printed Film in SQM :</td>
							<td >				
							<input type="text" name="total_resived_sqm" id="total_resived_sqm"  size="20" value="" />
							
						</td>
						</tr>

						<tr>
							<td class="label">Unit Rate/SQM :</td>
							<td >				
							<input type="text" name="rate_per_sqm" id="rate_per_sqm"  size="20" value="" />
							
						</td>
						</tr>

						<!--
						<tr>
							<td class="label">Total Amount :</td>
							<td >				
							<input type="text" name="amount" id="amount"  size="20" value="" />
							
						</td>
						</tr>-->

						
						<!--<tr>
							<td class="label">Total Ok Reels  :</td>
							<td ><input type="number" name="total_ok_reels" id="total_ok_reels"  size="20" maxlength="5" min="1" max="1000" step="1" value="<?php echo set_value('total_ok_reels',round($row->total_ok_meters/$default_reel_length,2));?>" readonly/></td>
						</tr> 
					-->
						<!-- <tr>
							<td class="label">Release Reels <span  style="color:red;">*</span>  :</td>
							<td ><input type="number" name="release_reels" id="release_reels"  size="20" maxlength="5" min="1" max="1000" step="1" value="<?php echo set_value('release_reels');?>" required/></td>
						</tr> -->
						
						

										

					</table>
			
				</td>
					
							
			</tr>

		</table>
					
	</div>



	
	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button">Save</button>
		</div>
	</div>


	
</form>
