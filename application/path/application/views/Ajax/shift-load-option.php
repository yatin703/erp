<?php 
	echo '<option value="">--Select Shift--</option>';
if($shift_planned==FALSE){
	$first_shift=$this->coex_planning_model->check_shift_record($mac['machine_id'],$this->session->userdata['logged_in']['company_id']);
	foreach($first_shift as $first_shift_row){
		echo "<option value='".$first_shift_row->shift_no."'>".$first_shift_row->shift_no." / ".$this->common_model->view_date($first_shift_row->shift_start_date,$this->session->userdata['logged_in']['company_id'])." / ".date('h',strtotime($first_shift_row->shift_start_time))."-".date('h',strtotime($first_shift_row->shift_end_time))." / ".($first_shift_row->job_changeover)." min</option>";
	}

	
}else{
	foreach ($shift_planned as $shift_planned_row){
		//echo $shift_planned_row->article_no."\n";
		echo "<option value=''>HIIIIIII</option>";

  }    	
}

?>