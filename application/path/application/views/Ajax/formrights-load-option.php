<?php 
    if($formrights==FALSE){
      echo "--No Rights Defined Yet--";
        }else{
			
		
          
      foreach ($formrights as $row){
            echo "".($row->view==1 ? 'View : <input type="checkbox" name="view" value="1">' : '<input type="hidden" name="view" value="0">')."";
             echo "".($row->new==1 ? 'New : <input type="checkbox" name="new" value="1">' : '<input type="hidden" name="new" value="0">')."";
              echo "".($row->modify==1 ? 'Modify : <input type="checkbox" name="modify" value="1">' : '<input type="hidden" name="modify" value="0">')."";
               echo "".($row->delete==1 ? 'Archive : <input type="checkbox" name="delete" value="1">' : '<input type="hidden" name="delete" value="0">')."";
               echo "".($row->copy==1 ? 'Copy : <input type="checkbox" name="copy" value="1">' : '<input type="hidden" name="copy" value="0">')."";
               echo "".($row->dearchive==1 ? 'Dearchive : <input type="checkbox" name="dearchive" value="1">' : '<input type="hidden" name="dearchive" value="0">')."";
			   echo "".($row->approval==1 ? 'Approval : <input type="checkbox" name="approval" value="1">' : '<input type="hidden" name="approval" value="0">')."";

          }     
        }

?>