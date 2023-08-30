<style>
   .ui.button, .ui.buttons .button, .ui.buttons .or {
    font-size: 0.8rem;
}
.ui.button {
    cursor: pointer;
    display: inline-block;
    min-height: 1em;
    outline: 0;
    border: none;
    vertical-align: baseline;
    background: #f7f7f7 none; 
    color: rgba(0,0,0,.6);
    font-family: Lato,'Helvetica Neue',Arial,Helvetica,sans-serif;
    margin: 0 0.25em 0 0;
    padding: 0em;
    text-transform: none;
    text-shadow: none;
    font-weight: 700;
    line-height: 1em;
    font-style: normal;
    text-align: center;
    text-decoration: none;
    border-radius: 0.28571429rem;
    box-shadow: 0 0 0 1px transparent inset, 0 0 0 0 rgb(34 36 38 / 15%) inset;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    transition: opacity .1s ease,background-color .1s ease,color .1s ease,box-shadow .1s ease,background .1s ease;
    will-change: '';
}
i.print.icon{
  color:#2185d0;
}
i.edit.icon{
   color: #00b5ad;
}
i.archive{
   color:#db2828;
}
</style>
<div class="record_form_design">
   <?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
   <h4>Active Records: <!-- Total: --><?php //echo $count_active_records;?></h4>
   <div class="record_inner_design">
      <table class="record_table_design_without_fixed">
         <tr>
            <th>Id</th>
            <th>Date</th>
            <th>Invoice No.</th>
            <th>Customer Name</th>
            <th>Product Name</th>
            <th>Order No</th>
            <th>AQL</th>
            <th>Total QTY</th>
            <th>Sample Size</th>
            <th>Created By</th>
            <th>Approve By</th>
            <th>Approval Date</th>
            <th>Action</th>
         </tr>
         <?php 
            if($certificate_of_analysis==FALSE){
            echo "<tr><td colspan='16'>No Active Records Found</td></tr>";
            }else{
            	$i=1;
            	foreach($certificate_of_analysis as $row){
            
            		echo "<tr>
            				<td>".$i."</td>
            				<td>".$row->inspection_date."</td>
            				<td>".($row->final_approval_flag==1 ? "" : "")." <a class='mla' href=".base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->certificate_no)." target='_blank'>".$row->certificate_no."</a></td>
            				<td>".$row->customer_name."</td>
                        <td>".$row->product_name."</td>
            				<td>".$row->so_no."</td>
            				<td>".$row->quality."</td>
            				<td>".$row->total_qty."</td>
            				<td>".$row->sample_size."</td>
                        <td><a class='ui tiny label'><i class='user icon'></i> ".strtoupper($this->common_model->get_user_name($row->user_id,$this->session->userdata['logged_in']['company_id']))."</a></td>
                        <td>".($row->approved_by!='' ? "<a class='ui tiny label'><i class='checkmark box icon'></i>":'' )."".strtoupper($this->common_model->get_user_name($row->approved_by,$this->session->userdata['logged_in']['company_id']))."</td>
                        <td>".$this->common_model->view_date($row->approval_date,$this->session->userdata['logged_in']['company_id'])."</td>
            				<td>";
            
            				foreach($formrights as $formrights_row){ 
            
            					echo ($formrights_row->view==1 ? '<div class="ui button view-clr" data-tooltip="View" data-position="top center"><a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->certificate_no).'" target="_blank"><i class="print icon" ></i></a></div>' : '');
   
            
                           echo ($formrights_row->modify==1 && $row->final_approval_flag<>1 && $row->pending_flag<>1  ? '<div class="ui button" data-tooltip="Modify" data-position="top center"><a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->certificate_no.'').'"><i class="edit icon"></i></a> </div>' : '');
            
            					echo ($row->archive<>1 && $row->final_approval_flag<>1 && $row->pending_flag<>1  && $formrights_row->delete==1 ? '<div class="ui button" data-tooltip="Delete" data-position="top center"><a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->coa_id.'/'.$row->certificate_no).'"><i class="trash icon archive"></i></a></div> ' : '');
            					
            				}  echo "</td>
            				</tr>";
            		$i++;
            	}
            }
            ?>
      </table>
      <div class="pagination"><?php echo $this->pagination->create_links();?></div>
   </div>
</div>