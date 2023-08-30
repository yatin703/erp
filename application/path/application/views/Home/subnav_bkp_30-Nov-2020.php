<section class="container">
		<article class="container_header">
			<div class="cmp_name">
			<?php echo $this->session->userdata['logged_in']['company_id'];?> | 
			<?php echo $this->session->userdata['logged_in']['username'];?> | 
			<?php echo $this->session->userdata['logged_in']['user_id'];?> | 
			Preferences | 
			Change Password |
			<a href='<?php echo base_url('index.php/home/logout');?>'>Logout</a>

			<!-- <div>
			<?php 
				echo'<a class="ui green">
          				<img class="ui right spaced avatar image" src="../assets/img/eknath.png">For any query contact administrator on 7506401634
        			</a>';
        	?>


		</div> -->
			
       
		</article>

		<!--<article class="container_title">
			<h2>Country Master</h2>
		</article>-->
		<article class="sub_container">
			<div class="form_container">