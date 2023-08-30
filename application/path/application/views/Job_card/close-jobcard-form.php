 
<div class="form_design">
	<!-- <?php echo validation_errors("<p class='alert alert-error'>","</p>");?> -->
	<?php if(isset($note_1)){
		foreach ($note_1 as  $note_1_row) {
		 	echo "<p class='alert alert-success'>".$note_1_row." </p>";		
		}
	}?>
	<?php if(isset($error_1)){

		foreach ($error_1 as  $error_1_row) {

		 	echo "<p class='alert alert-error'>".($error_1_row)." </p>";	
		}

	}?>
	 
</div>

				


						



	

				
				
				
				
				
			