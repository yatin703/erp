<div class="record_form_design">
    <h4>RFD</h4>
    <div class="record_inner_design" style="overflow: scroll;white-space: nowrap;">
        <div class="tableFixHead">
            <table class="ui green sortable selectable celled table" style="font-size:10px;">
                <thead>
                    <tr>
                        <th>Sr.no</th>
                        <th>RFD Date</th>
                        <th>Order No</th>
                        <th>Customer</th>
                        <th>Article No.</th>
                        <th>Article Desc</th>
                        <th>Microns</th>
                        <th>Dia X Length</th>
                        <th>Second layer MB</th>
                        <th>Sixth Layer MB</th>
                        <th>RFD Qty</th>
                        <th>Total RFD</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $sr_no = 1;
                    foreach ($rdf_data as $row) {
                        $article_no = $row->article_no;
                    ?>
                        <tr>
                            <td><?php echo $sr_no++; ?></td>
                            <td><?php echo date('d-M-Y', strtotime($row->rfd_date)); ?></td>
                            <td><?php echo $row->order_no; ?></td>
                            <td><?php echo $this->common_model->get_parent_name($article_no, $this->session->userdata['logged_in']['company_id']); ?></td>
                            <td>
                                <a href="#" onclick="showOrderNumbers('<?php echo $row->article_no; ?>')">
                                    <?php echo $row->article_no; ?>
                                </a>
                            </td>
                            <td><?php echo $this->common_model->get_article_name($article_no, $this->session->userdata['logged_in']['company_id']); ?></td>
                            <td><?php echo $row->total_microns; ?></td>
                            <td><?php echo $row->sleeve_dia . " X " . $row->sleeve_length; ?></td>
                            <td><?php echo $this->common_model->get_article_name($row->second_layer_mb, $this->session->userdata['logged_in']['company_id']); ?></td>
                            <td><?php echo $this->common_model->get_article_name($row->sixth_layer_mb, $this->session->userdata['logged_in']['company_id']); ?></td>
                            <td><?php echo $row->rfd_qty; ?></td>
                            <td><?php echo $row->total_rfd_qty; ?></td>
                        </tr>

                    <?php
                    }

                    ?>
                </tbody>
            </table>

            <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>
</div>