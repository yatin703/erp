<div class="record_form_design">
<?php 
setlocale(LC_MONETARY, 'en_IN');
if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
<h4>Active Records</h4>
   <div class="record_inner_design" style="overflow: scroll;">
         <table class="ui very basic collapsing celled table"  style="font-size:10px;">
            <thead>
               <tr>
                  <th>Sr no.</th>
                  <th>Action</th>
         			<th>WIP Scrap Date</th>
                  <th>Machine</th>
                  <th>Shift</th>
                  <th>Order No</th>
                  <th>Article No</th>
                  <th>Jobcard No</th>
         			<th>Sleeve Weight</th>
                  <th>Dia</th>
                  <th>Length</th>
         			<th>WIP QTY</th>
                  <th>WIP Code</th>
               </tr>
            </thead>
            <tbody>
               <?php 
               $sum_bm_wip_qty=0;
               if($coex_extrusion_wip_scrap==FALSE){
               echo "<tr><td colspan='12'>No Active Records Found</td></tr>";
               }else{
               	$i=1;
               	foreach($coex_extrusion_wip_scrap as $row){
               
               		echo "<tr>
               				<td>".$i."</td>
                           <td>";
                                 foreach($formrights as $formrights_row){ 
                                 echo ($formrights_row->new==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/wip_release/'.$row->scrap_id).'" target="_blank"><i class="edit icon"></i></a> ' : '');                                                         
                                 }
                           echo"

                           </td>
               				<td></td>
                           <td>".$row->machine_name."</td>
                           <td>".$row->shift_name."</td>
                           <td>".($row->order_no=='' ? 'Purging' : $row->order_no)."</td>
                           <td>".$row->article_no."</td>
               				<td>".$row->jobcard_no."</td>
                           <td>".($row->sleeve_weight_gm)."<i> Gm</i></td>
                           <td>".$row->diameter."</td>
                           <td>".($row->length=='' ? '' : $row->length." MM")."</td>
               				<td style='text-align:right;' ".($row->scrap_qty==0? "class='td_wip_cost'":"")."> &#x20B9; ".$row->scrap_qty." <i> No</i></td>
                           <td></td>
                                ";
                               echo "</td>
               				</tr>";
               		$i++;
               	 $sum_bm_wip_qty+=$row->scrap_qty;
               }
               echo"<tr><td colspan='11' style='text-align:right;'><b>TOTAL</b></td>
               <td class='positive right aligned'><b>".number_format($sum_bm_wip_qty,0,'.',',')."</b> <i>NOS</i></td></tr>";
               }
               ?>
            </tbody>
      </table>
      <div class="pagination"><?php echo $this->pagination->create_links();?></div>
   </div>
</div>

