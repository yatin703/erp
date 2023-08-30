</div>
</article>
<article class="container_footer">
			<div class="time"><?php echo date('d/m/Y');?> | <?php echo date("h:i:s a");?></div>
			<div class="user"><?php echo "User : ".$this->session->userdata['logged_in']['username'];?></div>

			 


			<div id="backupModal" class="modal">
				<div class="modal-content" >
		            <span class="close" id="span_order">&times;</span>
		            <p style="color: red; font-size: 14;">Please hold your work for some time. Back up Process is running on Server (Aprox. Time 5 to 6 min).</p>
		        </div>    
			</div>	

<script>


		var myVar = setInterval(myTimer, 1000);

		function myTimer() {

   			var d = new Date();
  			var h = d.getHours();
  			var m = d.getMinutes();
 	 	    
 	 	    var modal = document.getElementById("backupModal"); 
		 
			if( (h==12 && m >=58) || (h==13 && m<=4)){
				modal.style.display = "block";
			}else{
				modal.style.display = "none";
			}
		}

		

</script>
		</article>
	</section>
	<footer>
		<p class='copyright'>Copyright @ 2016 </p>
	</footer>

	
	<style type="text/css">
	/* The Modal (background) */
	.modal {
	  display: none;  /*Hidden by default*/ 
	  position: fixed; /* Stay in place */
	  z-index: 1; /* Sit on top */
	  padding-top: 100px; /* Location of the box */
	 
	  left: 0;
	  top: 0;
	  width: 100%; /* Full width */
	  height: 100%; /* Full height */
	  overflow: auto; /* Enable scroll if needed */
	  background-color: rgb(0,0,0); /* Fallback color */
	  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
	}

	/* Modal Content */
	.modal-content {
	  	background-color: #fefefe;
	  	margin: auto;
	  	padding: 20px;
	  	border: 1px solid #888;
	 	width: 80%;
	}

	/* The Close Button */
	.close {
	  	color: #aaaaaa;
	  	float: right;
	  	font-size: 28px;
	  	font-weight: bold;
	}

	.close:hover,
	.close:focus {
	  	color: #000;
	  	text-decoration: none;
	  	cursor: pointer;
	}

	/*table {
		width:90%;
	    border-collapse: collapse;
	    text-align: center;
	}

	table, td, th {
	  	border: 1px solid black;
	}*/
        

</style>
</body>
</html>
