<?php 
echo "<div class='middle_form_design'>
    <table class='middle_form_table_design'>
        <tr><th>CAP DETAILS</th><th></th></tr>";
        if($specification==FALSE){
        echo "<tr><td>No Record Found</td></tr>";
        }else{
      foreach ($specification as $specification_row){

   echo '<tr>
            <td width="30%">CAP SPEC NO : </td><td>'.$specification_row->spec_id.'</td>
        </tr>
        <tr>
            <td width="30%">CAP VER NO : </td><td>'.$specification_row->spec_version_no.'</td>
        </tr>
        <tr>
            <td width="30%">CAP NAME : </td><td>'.$specification_row->article_name.'</td>
        </tr>
        <tr>
            <td width="30%">CAP NO : </td><td>'.$specification_row->article_no.'</td>
        </tr>';

        }
      }

     if($cap_spec_details==FALSE){
         echo "<tr><td>No Record Found</td></tr>";
     }else{
     	foreach($cap_spec_details as $cap_spec_details_row){
     echo '
            <tr>
                <td width="30%">SHRINK SLEEVE : </td><td>'.$cap_spec_details_row->CAP_SHRINK_SLEEVE.'</td>
            </tr>
            <tr>
                <td width="30%">CAP FOIL : </td><td>'.$cap_spec_details_row->CAP_FOIL_COLOR.'</td>
            </tr>
            <tr>
                <td>CAP FOIL WIDTH : </td><td>'.$cap_spec_details_row->CAP_FOIL_WIDTH.'</td>
            </tr>
            <tr>
                <td>CAP FOIL D FROM BOTTOM : </td><td>'.$cap_spec_details_row->CAP_FOIL_DIST_FROM_BOT.'</td>
            </tr>
            <tr>
                <td>PP : </td><td>'.$cap_spec_details_row->CAP_PP.' '.$cap_spec_details_row->CAP_PP_PERC.'</td>
            </tr>
            <tr>
                <td>MB : </td><td>'.$cap_spec_details_row->CAP_MASTER_BATCH.' '.$cap_spec_details_row->CAP_MB_PERC.'</td>
            </tr>';
     	}
     }

echo "</table>
</div>";

?>