
<?php foreach ($product_pricing as $product_pricing_row):?>

    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        Product Price List
      </div>
    </div>

    

    
    <br/>

    <?php 
        echo ($this->common_model->view_date($product_pricing_row->product_pricing_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label">'.$this->common_model->view_date($product_pricing_row->product_pricing_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '');
    ?>
    <br/>
    <br/>

    <!-- HEADER TABLE START........................-->

    <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
            
        <tr class="heading">
            <td width="10%"><b>PRODUCT NO</b></td>
            <td width="5%"></td>
            <td width="35%"><?php echo $product_pricing_row->article_no;?></b></td>
            <td width="10%">PRODUCT NAME</td>
            <td width="5%"></td>
            <td width="35%"><?php echo $this->common_model->get_article_name($product_pricing_row->article_no,$this->session->userdata['logged_in']['company_id']);?></td>
        </tr>

        <tr class="item">
            <td><b>CUSTOMER</b></td>
            <td></td>
            <td><?php echo $product_pricing_row->category_name; ?></td>
            <td></td>
            <td></td>
            <td></td>
            
        </tr>
        <tr>
            <td colspan="6">
        <?php

        $dat=array('product_block_pricing.pg_no'=>$product_pricing_row->pg_no);
        $data['product_block_pricing']=$this->product_block_pricing_model->active_record_search('product_block_pricing',$dat,$this->session->userdata['logged_in']['company_id']);
        ?>

             <table class="ui very basic collapsing celled table"  style="font-size:10px;">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Price List Name</th>
                    <th>Customer</th>
                    <th>Block</th>
                    <th>Quantity From</th>
                    <th>Quantity To</th>
                    <th>Currency</th>
                    <th>Final Unit Price</th>
                    <th>Freight</th>
                    <th>Other Cost</th>
                    <th>Mark Up</th>
                    <th>Ex-Works</th>
                </tr>
                </thead>
                <tbody>
                <?php if($data['product_block_pricing']==FALSE){
                    echo "<tr><td colspan='12'>No Active Records Found</td></tr>";
                }else{
                            foreach($data['product_block_pricing'] as $row){

                                echo "<tr>
                                    <td>$row->pbp_id</td>
                                    <td>$row->price_list_name</td>
                                    <td><b>$row->category_name</b></td>
                                    <td class='right aligned'>$row->block_name</td>
                                    <td class='right aligned'>".money_format('%!.0n',$this->common_model->read_number($row->block_from,$this->session->userdata['logged_in']['company_id']))."</td>
                                    <td class='right aligned'>".money_format('%!.0n',$this->common_model->read_number($row->block_to,$this->session->userdata['logged_in']['company_id']))."</td>
                                    <td>$row->currency_id</td>
                                    <td class='positive right aligned'><b>".money_format('%!.0n',$this->common_model->read_number($row->price_1,$this->session->userdata['logged_in']['company_id']))."</b></td>
                                    <td class='warning right aligned'>".money_format('%!.0n',$this->common_model->read_number($row->price_2,$this->session->userdata['logged_in']['company_id']))."</td>
                                    <td class='negative right aligned'>".money_format('%!.0n',$this->common_model->read_number($row->price_3,$this->session->userdata['logged_in']['company_id']))."</td>
                                    <td class='positive right aligned'>".money_format('%!.0n',$this->common_model->read_number($row->price_4,$this->session->userdata['logged_in']['company_id']))."</td>
                                    <td class='active right aligned'>".$this->common_model->read_number($row->unit_price,$this->session->userdata['logged_in']['company_id'])."</td>
                                    
                            </tr>";
                            }
                        }?>
                    </tbody>            
                </table>

            </td>
        </tr>

       
       
       
    </table>

<?php endforeach;?>

    <!-- APPROVAL/FOLLOWUP TABLE START........................-->

</div>
</body>
</html>
