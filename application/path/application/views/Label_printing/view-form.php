

     <div style="margin:0.4cm;size:A4;padding:0;">
        	<?php 

        	$j=0;
        	$j=$this->input->post('end_range')-$this->input->post('start_range');
        	$j=$j+1;
        	$sticke_no=$this->input->post('start_range');
        	$result=$this->sales_order_book_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_master.order_no',$this->input->post('order_no'));

        	//echo $this->db->last_query();
        	//$result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$this->input->post('order_no'));
        	if($result==TRUE){
        
        		foreach($result as $row){

        			$customer_name=$row->customer_name;
        			$customer_address=$row->strno." ".$row->name2." ".$row->street." ".$row->name3." ".strtoupper($row->lang_city)." ".$row->country_name;;
        			$customer_po_no=$row->cust_order_no;
        			$customer_po_date=$row->cust_order_date;;
        			$order_flag=$row->order_flag;
        			//echo $row->order_flag;
        			$consin_adr_company_id=$row->consin_adr_company_id;
        		}
        	}else{
        		$customer_po_no="";
        		$customer_po_date="";
        		$order_flag="";
        		$customer_no="";
        		$consin_adr_company_id="";
        		$customer_address="";
        	}

        	$order_data=array('order_no'=>$this->input->post('order_no'),'article_no'=>$this->input->post('article_no'));
	    	
        	$result_order_details=$this->common_model->select_one_active_record_nonlanguage_without_archives('order_details',$this->session->userdata['logged_in']['company_id'],$order_data);
        	if($result_order_details==TRUE){
        		foreach($result_order_details as $row){
        			$sleeve_dia=$row->sleeve_dia;
        			$sleeve_length=$row->sleeve_length;
        		}
        	}else{
        		$sleeve_dia="";
        		$sleeve_length="";
        	}

        	//echo '1';
        	//echo $order_flag;

        	if($order_flag==0){
        			$order_data=array('sales_ord_no'=>$this->input->post('order_no'),'article_no'=>$this->input->post('article_no'),'jobcard_type'=>'0');
        	}else{

        	    $order_data=array('sales_ord_no'=>$this->input->post('order_no'),'article_no'=>$this->input->post('article_no'),'jobcard_type'=>'2');
	    	}

        	$result_job=$this->common_model->select_one_active_record_nonlanguage_without_archives('production_master',$this->session->userdata['logged_in']['company_id'],$order_data);

        	//echo $this->db->last_query();
        	$jobcard_no="";
        	if($result_job==TRUE){
        		foreach($result_job as $row_job){
        			$jobcard_no=$row_job->mp_pos_no;
        		}
        	}


        	for($i=1;$i<=$j;$i++){

        		echo '<div style="width:47.2%;height:4.7cm;float:left;font-family:verdana;border:0px solid #000;border-radius:10px;'.($i % 2 == 0 ? 'margin-left:0.9cm':'').'">

        		<table width="99%" height="95%" style="font-size:10px;border:0.5px solid #000;padding:3px;margin:5px;border-radius:10px;">
        			<tr>
        				<td colspan="2" style="border-bottom:1px solid #ddd;">
        					<span style="font-size:8px;float:right"><b>UNIT/BOX : '.$this->input->post('unit_box').'</b></span>
        				
        					<b>3D TECHNOPACK PVT LTD ('.$sticke_no.')</b>
        					<br/>';

        					//echo '<span style="font-size:8px;">Survey No 9/1, Village Athal, Silvassa, Dadra & Nagar Haveli, 396230</span><br/>';
        					echo '<span style="font-size:8px;">Email : support@3d-neopac.com  </span><br>
        					<span style="font-size:8px;">Manufacturing Date : ';
        					//$CI = &get_instance();

           					//$this->db2= $CI->load->database('another_db', TRUE);
           					//$this->load->model('production_model');
            				
            				if($order_flag!='1'){
            					$search_array=array('so_no'=>$this->input->post('order_no'),
                                'psppsm_no'=>$this->input->post('article_no'));
            					$data['printing']=$this->production_model->select_active_records_where('1','0','printing',$search_array);
            					//echo $this->db->last_query();
            				}else{
            					$search_array=array('order_no'=>$this->input->post('order_no'),
                                'article_no'=>$this->input->post('article_no'));
            					$data['printing']=$this->common_model->select_active_records_where('springtube_printing_production_master',$this->session->userdata['logged_in']['company_id'],$search_array);
            					//echo $this->db->last_query();
            				}
        					foreach($data['printing'] as $printingrow){

        						if($order_flag!='1'){
        							echo $this->common_model->view_date($printingrow->date,$this->session->userdata['logged_in']['company_id']);
        						}else{
        							echo $this->common_model->view_date($printingrow->production_date,$this->session->userdata['logged_in']['company_id']);
        						}
        					}

        					echo'  </span>
        					<span style="font-size:8px;float:right;">Best use before 6 months  </span>
        					

        				</td>
        				
        			</tr>

        			<tr>
        				<td style="border-right:1px solid #ddd;border-bottom:0.5px solid #ddd;width:65%">
        					<span style="font-size:8px;"><b>LOT NO : '.$this->input->post('order_no').' / '.$jobcard_no.' </b></span><br/>
        					</td>
        				<td style="border-bottom:1px solid #ddd;" ><span style="font-size:11px;"><b>'.$this->input->post('article_no').'</b></span>
        				</td>
        			</tr>


        			<tr>
        				<td style="border-bottom:1px solid #ddd;width:50%" colspan="2">
        					<span style="font-size:8px;"><b>REF NO :</b> '.$customer_po_no.'/ '.$this->common_model->view_date($customer_po_date,$this->session->userdata['logged_in']['company_id']).'&nbsp;&nbsp;<b>DIA X LENGTH : </b>'.$sleeve_dia.' X '.$sleeve_length.'</span> <br/>
        					</td>
        				
        			</tr>

        			<tr>
        				<td colspan="2" style="border-bottom:1px solid #ddd;"><b><span style="font-size:8px;">';


        				//$this->common_model->get_customer_name($customer_no,$this->session->userdata['logged_in']['company_id']);


			                if(!empty($consin_adr_company_id)){
			                    explode("|",$consin_adr_company_id)[0];
			                    $data['ship_to']=$this->customer_model->select_one_active_record("address_master",$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',explode("|",$consin_adr_company_id)[0]);
			                    foreach($data['ship_to'] as $ship_to_row){
			                        echo $ship_to_row->name1;			                        
			                    }
			                }else{
			                	echo $customer_name;
			                }


               

        				echo '</span></b><br/>
        				<span style="font-size:8px;">';


		                if(!empty($consin_adr_company_id)){
		                    explode("|",$consin_adr_company_id)[0];

		                    $data['ship_to']=$this->customer_model->select_one_active_record("address_master",$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',explode("|",$consin_adr_company_id)[0]);
		                    foreach($data['ship_to'] as $ship_to_row){
		                    echo ucwords(strtolower($ship_to_row->strno))." ".ucwords(strtolower($ship_to_row->name2))." ".ucwords(strtolower($ship_to_row->street))." ".ucwords(strtolower($ship_to_row->name3));

		                    	$country_result=$this->customer_model->select_one_active_state_country_record('country_master_lang',$this->session->userdata['logged_in']['company_id'],'country_id',$ship_to_row->country_id);
		                           // echo $this->db->last_query();
		                            if($country_result==FALSE){
		                                //echo '';
		                            }else{
		                                foreach($country_result as $country){
		                                    echo " ".ucwords(strtolower($country->lang_country_name));
		                                    
		                                }
		                            }
		                    
		                    }
		                }else{
		                    echo ucwords(strtolower($customer_address));
		                }


               			echo '</span>
        				</td>
        			</tr>
        			
        			<tr>
        				<td colspan="2" ><span style="font-size:11px;"><b>'.$this->common_model->get_article_name($this->input->post('article_no'),$this->session->userdata['logged_in']['company_id']).'</span></b></td>
        			</tr>

        			




        		</table>
        		<div style="padding:5px;">
        			</div>
        		</div>';

        		if($i % 2 == 0){
        			echo "<div style='clear:left;'></div>";
        		}

        		if($i % 12 == 0){
        			echo "<div style='clear:left;height:1.5cm;'></div>";
        		}
        		$sticke_no++;
        	}?>

        </div>       
    </body>
</html>
	