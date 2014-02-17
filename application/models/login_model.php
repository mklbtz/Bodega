<?php
class Login_Model extends CI_Model {
	// simple login function checks if matching email and password are in customer table
	// if match exists, the session userdata is updated and true is returned
	// if not, return false
	public function login($email,$password){
		$this->load->model('items_model');
		$email = $this->items_model->filter_simple($email);
		$password = $this->items_model->filter_simple($password);
		
		$q = "SELECT * FROM bodega_customers c WHERE c.email = '{$email}' AND c.password = '{$password}';";
		//$this->load->database();
		$query = $this->db->query($q);
		$result = $query->result_array();
		if($result){
			$this->session->set_userdata('email',$email);
			$this->session->set_userdata('staff',$result[0]['staff']);
			$this->session->set_userdata('manager',$result[0]['manager']);
			return true;
		}
		else{
			return false;
		}
	}
	
	public function register($first_name,$last_name,$street,$city,$state,$email,$password){

		$this->load->model('items_model');

		$first_name = $this->items_model->filter_simple($first_name);
		$last_name = $this->items_model->filter_simple($last_name);
		$street = $this->items_model->filter_simple($street);
		$city = $this->items_model->filter_simple($city);
		$state = $this->items_model->filter_simple($state);
		$email = $this->items_model->filter_simple($email);
		$password = $this->items_model->filter_simple($password);

		$q = "SELECT * FROM bodega_customers c WHERE c.email = '{$email}';";
		$query = $this->db->query($q);
		if($query->result_array()){
			return false;
		}
		else{
			$q = "INSERT INTO bodega_customers(email,first_name,last_name,street,city,state,`password`) VALUES('{$email}','{$first_name}','{$last_name}','{$street}','{$city}','{$state}','{$password}');";
			$this->db->query($q);
			return true;
		}
		
	}

	public function current_user()
	{
		$email = $this->session->userdata('email');
		if (!empty($email)) {
			$q = "SELECT * FROM bodega_customers WHERE email = '{$email}';";
			$results = $this->db->query($q);
			$results = $results->results_array();
			if (!empty($results)) {
				return $results[0];
			}
			else return false;
		}
		else return false;
	}
}
?>