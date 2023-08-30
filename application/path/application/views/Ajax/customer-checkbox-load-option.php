<script type="text/javascript">
    $(document).ready(function(){
    $('#chk:button').toggle(function(){
        $('.customer_no').attr('checked','checked');
        $(this).val('UNCHECK')
    },function(){
        $('.customer_no').removeAttr('checked');
        $(this).val('CHECK');        
    })
	});
</script>
<?php
if($customer==FALSE){
}else{
	echo "<div style='height:200px;overflow: scroll;'><table class='ui very compact table' style='font-size:9px'>
			<thead>
			    <tr>
			    	<td><input type='button' id='chk' class='ui mini toggle button active' value='CHECK' /></td>
			    	<td>Last Bill Days</td>
			  </tr>
			</thead>
			<tbody>";
	foreach ($customer as $customer_row){
		echo "<tr>
				<td>
				<div class='ui toggle checkbox'>
				<input type='checkbox' name='customer_no' class='customer_no' value='$customer_row->adr_company_id'>
				<label style='font-size:10px'>&nbsp;".$customer_row->name1." (".$customer_row->adr_company_id.")</label></div>
				</td>
				<td>".$this->customer_model->last_bill_days_before('',$customer_row->adr_company_id,$this->session->userdata['logged_in']['company_id'])."</td>
									
			  </tr>";
	}

	echo "</tbody>
		</table>
		</div>";
}
?>