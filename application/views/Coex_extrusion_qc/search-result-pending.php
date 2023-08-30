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
th{text-align: center !important;padding: 5px 5px 5px 5px !important;border-top: 1px solid rgba(34,36,38,.1)}
table th{background-color:#e4e4e4 !important;font-size: 12px;}

</style>
<div class="record_form_design">
<?php 
setlocale(LC_MONETARY, 'en_IN');
if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
<?php 
setlocale(LC_MONETARY, 'en_IN');
if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
<h4>Active Records</h4>
   <div class="record_inner_design" >
         <table class="ui very basic collapsing celled table"  style="font-size:10px;" id="tbl_data">
				<thead>
				<tr>
					<th>Id</th>
					<th>Date</th>
					<th >Machine</th>
					<th>Shift</th>
					<th>Order No</th>
					<th>Product No</th>
					<th>Job No</th>
					<th>Layer No.</th>
					<th>Sleeve Weight</th>
					<th>Dia</th>
					<th>Length</th>
					<th>Rm Used Kg</th>
					<th>Production Qty</th>
					
					<th>Scrap Qty</th>
					<th>Scrap Weight Kg</th>
					<!--<th>Job Runtime</th>-->
					<th>Cutting Speed</th>
					<th>R %</th>
					<th>QC</th>
					<th>Action</th>
				</tr>
				</thead><tbody>
				<?php if($coex_extrusion==FALSE){
					echo "<tr><td colspan='15'>No Active Records Found</td></tr>";
				}else{
						$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);

						foreach($coex_extrusion as $row){

							if($row->dyn_qty_present == 'SLEEVE|1')
								{ $layer_no ='1';}
							elseif($row->dyn_qty_present == 'SLEEVE|2')
								{$layer_no ='2';}
							elseif($row->dyn_qty_present == 'SLEEVE|3')
								{$layer_no ='3';}
							elseif($row->dyn_qty_present == 'SLEEVE|4')
								{$layer_no ='4';}
							elseif($row->dyn_qty_present == 'SLEEVE|5')
								{$layer_no ='5';}
							else{$layer_no ='Not Applicable';}
                            
                            $total_box=$this->common_model->get_total_box('coex_extrusion_qc',$row->jobcard_no,$this->session->userdata['logged_in']['company_id']);

							echo "<tr>
									<td>".$i."</td>
									<td>".$this->common_model->view_date($row->extrusion_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$row->machine_name."</td>
									<td>".$row->shift_name."</td>
									<td>".($row->order_no=='' ? 'Purging' : $row->order_no)."</td>
									<td>".$row->article_no."</td>
									<td>".$row->jobcard_no."</td>
									<td style='text-align: center !important;'>".$layer_no."</td>
									<td class='right aligned'>".($row->sleeve_weight_kg*1000)."<i> Gm</i></td>
									<td>".$row->diameter."</td>
									<td>".($row->length=='' ? '' : $row->length." MM")."</td>
									<td class='right aligned'>".$row->rm_mixed_qty_kg." Kg</td>
									<td class='positive right aligned'><b>".money_format('%!.0n',$row->ok_qty_no)."</b><i> No</i></td>
									<td class='negative right aligned'><b>".($row->scrap_tube_no!=0 ? money_format('%!.0n',$row->scrap_tube_no) : '0')."</b> <i>No</i></td>
									<td class='right aligned'>".round($row->scrap_weight_kg,1)." <i>Kg</i></td>
									<td class='right aligned'>".$row->cutting_speed_minutes." <i>Min</i></td>
									<td class='warning right aligned'>".round($row->rejection_percentage)."%</td>
									<td>".($row->qc_flag==1 ? '<i style="color:#338fd4" class="check circle icon"></i>' :'<a href="'.base_url('index.php/'.$this->router->fetch_class().'/qc_create/'.$row->ce_id).'"><i class="hand paper icon"></i></a>')."</td>
									<td>";

									foreach($formrights as $formrights_row){ 

										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/Coex_extrusion/view/'.$row->ce_id).'" target="_blank"><i class="print icon"></i></a> ' : '');										
									} 
									echo "</td>

									</tr>";
							$i++;
						}
					}
					?>
		</tbody>			
		</table>
		<div class="pagination"><?php echo $this->pagination->create_links();?></div>
						
	</div>	
</div>