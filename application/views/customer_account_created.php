<?php $this->load->view('page_open'); ?>
	<p>Your account has been created successfully!</p>
	<?php 
		$login = site_url('login');
		echo "<a href='{$login}'>Login</a>";
	?>
<?php $this->load->view('page_close'); ?>