</div>
</article>
<article class="container_footer">
			<div class="time"><?php echo date('d/m/Y');?> | <?php echo date("h:i:s a");?></div>
			<div class="user"><?php echo "User : ".$this->session->userdata['logged_in']['username'];?></div>
		</article>
	</section>
	<footer>
		<p class='copyright'>Copyright @ 2016 </p>
	</footer>


</body>
</html>
