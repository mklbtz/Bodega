<?php $this->load->view('page_open'); ?>
	<h2>Register Your Bodega Account</h2>
	<div id'registration_form'>
		<?php
		if(isset($email_error_message)){
			// this error is specifically for registering an already existing email address
			echo "<p class=\"error_message\">{$email_error_message}</p>";
		}
		
		$this->form_validation->set_error_delimiters('<div class="error_message">', '</div>');

		echo form_open();
		echo "<table>";
		echo "<tr>";
		
		echo "<td class=\"right_align\">";
		echo form_label("First Name");
		echo "</td>";
		$data = array(
			"name" => "first_name",
			"id" => "first_name",
			"value" => set_value('first_name')
		);
		echo "<td class=\"right_align\">";
		echo form_input($data);
		echo "</td>";
		echo form_error('first_name');
		echo "</tr>";
		echo "<tr>";
		echo "<td class=\"right_align\">";
		echo form_label("Last Name");
		echo "</td>";
		$data = array(
			"name" => "last_name",
			"id" => "last_name",
			"value" => set_value('last_name')
		);
		echo "<td class=\"right_align\">";
		echo form_input($data);
		echo "</td>";
		echo form_error('last_name');
		echo "</tr>";
		
		echo "<tr>";
		echo "<td class=\"right_align\">";
		echo form_label("Street Address");
		echo "</td>";
		$data = array(
			"name" => "street",
			"id" => "street",
			"value" => set_value('street')
		);
		echo "<td class=\"right_align\">";
		echo form_input($data);
		echo "</td>";
		echo form_error('street');
		echo "</tr>";
		
		echo "<tr>";
		echo "<td class=\"right_align\">";
		echo form_label("City");
		echo "</td>";
		$data = array(
			"name" => "city",
			"id" => "city",
			"value" => set_value('city')
		);
		echo "<td class=\"right_align\">";
		echo form_input($data);
		echo "</td>";
		echo form_error('city');
		echo "</tr>";
		
		echo "<tr>";
		echo "<td class=\"right_align\">";
		echo form_label("State");
		echo "</td>";
		$data = array(
			"name" => "state",
			"id" => "state",
			"value" => set_value('state')
		);
		echo "<td class=\"right_align\">";
		echo form_input($data);
		echo "</td>";
		echo form_error('state');
		echo "</tr>";
		
		echo "<tr>";
		echo "<td class=\"right_align\">";
		echo form_label("Email");
		echo "</td>";
		$data = array(
			"name" => "email",
			"id" => "email",
			"value" => set_value('email')
		);
		echo "<td class=\"right_align\">";
		echo form_input($data);
		echo "</td>";
		echo form_error('email');
		echo "</tr>";
		
		echo "<tr>";
		echo "<td class=\"right_align\">";
		echo form_label('Password');
		echo "</td>";
		$data = array(
			'name' => 'password',
			'id' => 'password',
			'value' => ''
		);
		echo "<td class=\"right_align\">";
		echo form_password($data);
		echo "</td>";
		echo form_error('password');
		echo "</tr>";
		echo "</table>";
		echo "<p>";
		$data = array(
			'name' => 'register',
			'id' => 'register',
			'value' => 'Register'
		);
		echo form_submit($data);
		
		?>
	</div>
<?php $this->load->view('page_close'); ?>