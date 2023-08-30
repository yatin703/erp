<header>
		<nav>
			<ul>
			<li class="<?php echo $active=($page_name==='home') ? 'active' : ''?>"><a href="<?php echo base_url('index.php/home');?>">Home</a></li>
			<?php if($this->session->userdata['logged_in']['admin']==1){ echo '<li';?> class="<?php echo $active=($page_name==='setup') ? 'active' : ''?>"<?php echo '><a href="'.base_url('index.php/setup').'">Setup</a></li>';}?>

				<?php foreach($module as $module_row):?>
					<li class="<?php echo $active=($page_name===$module_row->module_name) ? 'active' : ''?>"><a href="<?php echo base_url('index.php/'.$module_row->module_name.'');?>"><?php echo $module_row->module_name;?></a></li>
				<?php endforeach;?>
			</ul>
		</nav>
	</header>
	<span class="clear"></span>