<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index(){
		//this flash data is set by the .php page that redirected user to login
		// it contains the url that was requested by the user
		if($this->session->flashdata('goto_url')){
			$this->session->keep_flashdata('goto_url');
		}
		$email = $this->input->post('email');
		$password = $this->input->post('password');
	
		// form validation takes 3 parameters: id, display name for message, validity rule
		$this->form_validation->set_rules('email','Email','required');
		$this->form_validation->set_rules('password','Password','required');
		if($this->form_validation->run() === false){
			$this->load->view('login_view');
		}
		else{
			$this->load->model('login_model');
			if($this->login_model->login($email,$password)){
				//upon the login send the user to the goto_url or if it is null send the user home
				$goto = $this->session->flashdata('goto_url');
				redirect($goto);
			}
			else{
				$data = array('wrong' => "Incorrect Username or Password");
				$this->load->view('login_view',$data);
			}
		}
			
			
	}
	public function register(){
		$this->load->model('login_model');
		
		$first_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name');
		$street = $this->input->post('street');
		$city = $this->input->post('city');
		$state = $this->input->post('state');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		
		$this->form_validation->set_rules('first_name','First Name','required');
		$this->form_validation->set_rules('last_name','Last Name','required');
		$this->form_validation->set_rules('street','Street Address','required');
		$this->form_validation->set_rules('city','City','required');
		$this->form_validation->set_rules('state','State','required');
		$this->form_validation->set_rules('email','Email','required');
		$this->form_validation->set_rules('password','Password','required');
		
		if($this->form_validation->run() === false){
			$this->load->view('register_form');
		}
		else if($this->login_model->register($first_name,$last_name,$street,$city,$state,$email,$password)){
			$this->load->view('customer_account_created');
		}
		else{
			$data = array('email_error_message' => "An account for this email has already been created");
			$this->load->view('register_form',$data);
		}
	}
}
?>