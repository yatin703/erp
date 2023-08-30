<form name="<?php echo $this->router->fetch_class(); ?>" action="<?php echo base_url('index.php/' . $this->router->fetch_class() . '/update'); ?>" method="POST">
    <div class="form_design">
        <?php echo validation_errors("<p class='alert alert-error'>", "</p>"); ?>
        <?php if (isset($note)) {
            echo "<p class='alert alert-success'>$note</p>";
        } ?>
        <?php if (isset($error)) {
            echo "<p class='alert alert-error'>$error</p>";
        } ?>
        <table class="form_table_design">
            <tr>
                <td>
                    <table class="form_table_inner">
                        <?php foreach ($tally_ledger_master as $row) : ?>
                            <tr>
                                <td class="label">Name <span style="color:red;">* </span> :</td>
                                <td>
                                    <input type="hidden" name="id" value='<?php echo $row->id; ?>'>
                                    <input type="text" name="name" id="name" value="<?php echo set_value('name', $row->name); ?>" size="60" />
                                </td>
                            </tr>
                            <tr>
                                <td class="label">New Name <span style="color:red;">* </span> :</td>
                                <td>
                                    <input type="hidden" name="id" value='<?php echo $row->id; ?>'>
                                    <input type="text" name="new_name" id="new_name" value="<?php echo set_value('new_name', $row->new_name); ?>" size="60" />
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Under Group <span style="color:red;">* </span> :</td>
                                <td>
                                    <input type="text" name="under_group" id="under_group" size="60" value="<?php echo set_value('under_group', $row->under_group); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Default Credit Period:</td>
                                <td>
                                    <input type="text" name="default_credit_period" id="default_credit_period" size="20" value="<?php echo set_value('default_credit_period', $row->default_credit_period); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Maintain Balance Bill by Bill:</td>
                                <td>
                                    <input type="text" name="maintain_balance_bill_by_bill" id="maintain_balance_bill_by_bill" value="<?php echo set_value('maintain_balance_bill_by_bill', $row->maintain_balance_bill_by_bill); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Is TDS Deductable:</td>
                                <td>
                                    <input type="text" name="is_tds_deductable" id="is_tds_deductable" value="<?php echo set_value('is_tds_deductable', $row->is_tds_deductable); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Mailing Name:</td>
                                <td>
                                    <input type="text" name="mailing_name" id="mailing_name" size="60" value="<?php echo set_value('mailing_name', $row->mailing_name); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Address 1:</td>
                                <td>
                                    <input type="text" name="address_1" id="address_1" size="60" value="<?php echo set_value('address_1', $row->address_1); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Address 2:</td>
                                <td>
                                    <input type="text" name="address_2" id="address_2" size="60" value="<?php echo set_value('address_2', $row->address_2); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Address 3:</td>
                                <td>
                                    <input type="text" name="address_3" id="address_3" size="60" value="<?php echo set_value('address_3', $row->address_3); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Country:</td>
                                <td>
                                    <input type="text" name="country" id="country" size="20" value="<?php echo set_value('country', $row->country); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td class="label">State:</td>
                                <td>
                                    <input type="text" name="state" id="state" size="20" value="<?php echo set_value('state', $row->state); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Pincode:</td>
                                <td>
                                    <input type="text" name="pincode" id="pincode" size="20" value="<?php echo set_value('pincode', $row->pincode); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Contact Person:</td>
                                <td>
                                    <input type="text" name="contact_person" id="contact_person" size="60" value="<?php echo set_value('contact_person', $row->contact_person); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Phone No:</td>
                                <td>
                                    <input type="text" name="phone_no" id="phone_no" size="20" value="<?php echo set_value('phone_no', $row->phone_no); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Mobile No:</td>
                                <td>
                                    <input type="text" name="mobile_no" id="mobile_no" size="20" value="<?php echo set_value('mobile_no', $row->mobile_no); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Fax No:</td>
                                <td>
                                    <input type="text" name="fax_no" id="fax_no" size="20" value="<?php echo set_value('fax_no', $row->fax_no); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Email:</td>
                                <td>
                                    <input type="text" name="email" id="email" size="60" value="<?php echo set_value('email', $row->email); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td class="label">CC:</td>
                                <td>
                                    <input type="text" name="cc" id="cc" size="60" value="<?php echo set_value('cc', $row->cc); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Website:</td>
                                <td>
                                    <input type="text" name="website" id="website" size="60" value="<?php echo set_value('website', $row->website); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Provide Bank Details:</td>
                                <td>
                                    <input type="text" name="provide_bank_details" id="provide_bank_details" value="<?php echo set_value('provide_bank_details', $row->provide_bank_details); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Bank:</td>
                                <td>
                                    <input type="text" name="bank" id="bank" size="60" value="<?php echo set_value('bank', $row->bank); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Account No:</td>
                                <td>
                                    <input type="text" name="account_no" id="account_no" size="20" value="<?php echo set_value('account_no', $row->account_no); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td class="label">IFSC Code:</td>
                                <td>
                                    <input type="text" name="ifsc_code" id="ifsc_code" size="20" value="<?php echo set_value('ifsc_code', $row->ifsc_code); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td class="label">PAN No:</td>
                                <td>
                                    <input type="text" name="pan_no" id="pan_no" size="20" value="<?php echo set_value('pan_no', $row->pan_no); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Party Type:</td>
                                <td>
                                    <input type="text" name="party_type" id="party_type" size="20" value="<?php echo set_value('party_type', $row->party_type); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td class="label">GSTIN:</td>
                                <td>
                                    <input type="text" name="gstin" id="gstin" size="20" value="<?php echo set_value('gstin', $row->gstin); ?>" />
                                </td>
                            <tr>
                                <td class="label">Status:</td>
                                <td>
                                    <input type="text" name="status" id="status" size="20" value="<?php echo set_value('status', $row->status); ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Remarks:</td>
                                <td>
                                    <input type="text" name="remarks" id="remarks" size="60" value="<?php echo set_value('remarks', $row->remarks); ?>" />
                                </td>
                            </tr>

            </tr>

        <?php endforeach; ?>
        </table>
    </div>
    <div class="buttons">
        <input type="submit" value="Update" class="btn btn-primary" />
        <input type="button" value="Cancel" onclick="location.href='<?php echo site_url('party/index'); ?>';" class="btn btn-secondary" />
    </div>
</form>