<style>
	.on-hower {
		background-color: #e4e4e4;
	}

	tr:hover {
		background-color: #e4e4e4;
	}
</style>
<div class="record_form_design">
	<h3>Active Records</h3>
	<div class="record_inner_design" style="overflow: scroll; white-space: nowrap;">
		<table class="ui very compact celled table" style="font-size:10px;">
			<thead>
				<tr>
					<th>Sr No</th>
					<th>Id</th>
					<th>Name</th>
					<th>New Name</th>
					<th>Under Group</th>
					<th>Credit Period</th>
					<th>Maintain Balance Bill By Bill</th>
					<th>Is Tds Deductable</th>
					<th>Treat As TDS Expense</th>
					<th>Deductee Type</th>
					<th>Deduct TDS On Same Voucher</th>
					<th>Mailing Name</th>
					<th>Address1</th>
					<th>Address2</th>
					<th>Address3</th>
					<th>Country</th>
					<th>State</th>
					<th>Pincode</th>
					<th>Contact Person</th>
					<th>Phone</th>
					<th>Mobile</th>
					<th>Fax</th>
					<th>Email</th>
					<th>CC</th>
					<th>Website</th>
					<th>Bank Details</th>
					<th>Bank</th>
					<th>A/C No</th>
					<th>IFSC Code</th>
					<th>PAN No</th>
					<th>Ragistration Type</th>
					<th>GSTIN</th>
					<th>Party Type</th>
					<th>Is Transporter</th>
					<th>Status</th>
					<th>Remark</th>
					<th>Transaction Date</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($tally_ledger_master == FALSE) {
					echo "<tr><td colspan='25'>No Active Records Found</td></tr>";
				} else {
					$i = ($this->uri->segment(3) == '' ? 0 : $this->uri->segment(3));
					foreach ($tally_ledger_master as $row) {
						echo "<tr>
									<td>" . ++$i . "</td>
									<td>" . $row->id . "</td>
									<td>" . $row->name . "</td>
									<td>" . $row->new_name . "</td>
									<td>" . $row->under_group . "</td>
									<td>" . $row->default_credit_period . "</td>
									<td>" . $row->maintain_balance_bill_by_bill . "</td>
									<td>" . $row->is_tds_deductable . "</td>
									<td>" . $row->treat_as_tds_expense . "</td>
									<td>" . $row->deductee_type . "</td>
									<td>" . $row->deduct_tds_on_same_voucher . "</td>
									<td>" . $row->mailing_name . "</td>
									<td>" . $row->address_1 . "</td>
									<td>" . $row->address_2 . "</td>
									<td>" . $row->address_3 . "</td>
									<td>" . $row->country . "</td>
									<td>" . $row->state . "</td>
									<td>" . $row->pincode . "</td>
									<td>" . $row->contact_person . "</td>
									<td>" . $row->phone_no . "</td>
									<td>" . $row->mobile_no . "</td>
									<td>" . $row->fax_no . "</td>							
									<td>" . $row->email . "</td>
									<td>" . $row->cc . "</td>
									<td>" . $row->website . "</td>
									<td>" . $row->provide_bank_details . "</td>
									<td>" . $row->bank . "</td>
									<td>" . $row->account_no . "</td>
									<td>" . $row->ifsc_code . "</td>
									<td>" . $row->pan_no . "</td>
									<td>" . $row->registration_type . "</td>
									<td>" . $row->gstin . "</td>
									<td>" . $row->party_type . "</td>
									<td>" . $row->is_transporter . "</td>
									<td>" . $row->status . "</td>
									<td>" . $row->remarks . "</td>
									<td>" . $row->transaction_date . "</td>
									<td><a href='" . base_url('index.php/' . $this->router->fetch_class() . "/modify/" . $row->id . '') . "' target='_blank'><i class='edit icon'></i></a></td>
															

							</tr>";
					}
				} ?>
			</tbody>
		</table>
		<div class="pagination"><?php echo $this->pagination->create_links(); ?></div>
	</div>
</div>