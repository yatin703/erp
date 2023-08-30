<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#adr_company_id").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});
		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no_springtube');?>", {selectFirst: true});
		$("#artwork_no").autocomplete("<?php echo base_url('index.php/ajax/artwork_springtube_autocomplete');?>", {selectFirst: true});

		$("#article_no").live('keyup',function() {
		   var article_no = $('#article_no').val();
		   $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
		   $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/artwork_version_no_springtube",data: {article_no : $('#article_no').val()},cache: false,success: function(html){
		    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
		       $("#version_no").html(html);
		    } 
		    });
        });
        $("#article_no").blur(function() {

		   var article_no = $('#article_no').val();

		   if(article_no!=''){
		   
			    $("#loading").show();
				$("#cover").show();
				$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			   $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/artwork_version_no_springtube",data: {article_no : $('#article_no').val()},cache: false,success: function(html){
			    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
			       $("#version_no").html(html);
			    } 
			    });
		    }


        });


	});
</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" method="POST" id="artwork">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">
						<tr>
							<td class="label" width="25%">From Date <span style="color:red;">*</span> :</td>
							<td width="25%"><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date',date('2019-02-01'));?>"/></td>
							<td class="label" width="25%">To Date <span style="color:red;">*</span> :</td>
							<td width="25%"><input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date',date('Y-m-d'));?>"/></td>
						</tr>
						
						<tr>
							<td class="label">Artwork No  :</td>
							<td ><input type="text" name="artwork_no" id="artwork_no"  size="15" value="<?php echo set_value('artwork_no');?>"  />
							</td>
							<td class="label">Version No  :</td>
							<td ><input type="text" name="version_no"   size="15" value="<?php echo set_value('version_no');?>" /></td>
						</tr>
							
									
					</table>			
				 </td>
			</tr>
		</table>
					
	</div>

	<div class="form_design">
		<div class="ui buttons">
	  <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  <div class="or"></div>
	  <button class="ui positive button">Search</button>
		</div>
	</div>
		
</form>
				
				
				
				
				
			