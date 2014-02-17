<?php $this->load->view('page_open'); ?>
	<h2>Bodega Login Page</h2>
	
	<?php
	if(!$this->session->userdata('email')){
		//$log_out_url = site_url('logout');
		//echo "<a href='{$log_out_url}'>Logout</a>";
		//echo "<p>".$error_message."</p>";
		//echo validation_errors();
		if(isset($wrong)){
			echo "<p class=\"error_message\">".$wrong."</p>";
		}
		echo form_open();
		
		echo "<table>";
		echo "<tr>";
		echo "<td>";	
		echo form_label('Email: ');
		echo "</td>";
		$data = array(
			'name' => 'email',
			'id' => 'email',
			'value' => set_value('email')
		);
		echo "<td>";
		echo form_input($data);
		echo "</td>";
		echo form_error('email');
		echo "</tr>";
		
		echo "<tr>";
		echo "<td>";
		echo form_label('Password: ');
		echo "</td>";
		$data = array(
			'name' => 'password',
			'id' => 'password',
			'value' => ''
		);
		echo "<td>";
		echo form_password($data);
		echo "</td>";
		echo form_error('password');
		echo "</tr>";
		echo "</table>";
		echo "<p>";
		$data = array(
			'name' => 'login',
			'id' => 'login',
			'value' => 'Login'
		);
		echo form_submit($data);

		echo "</p>";
		$reg_url = site_url('login/register');
		echo "<p>Don't have an account??? <a href='{$reg_url}'>Register here!</a></p>";
	
		echo form_close();
	}
	else{
		echo "<p>You are already logged in under email: ". $this->session->userdata('email')."</p>";
		$home_url = site_url();
		echo "<p><a href='{$home_url}'>Home</a></p>";
		$log_out_url = site_url('logout');
		echo "<a href='{$log_out_url}'>Logout</a>";
	}
	?>
<?php $this->load->view('page_close'); ?>