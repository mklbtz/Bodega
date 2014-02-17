<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {
	// simply destroy session on logout
	public function index(){
		$this->session->sess_destroy();
		redirect(site_url());
	}
}
?>