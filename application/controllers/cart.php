<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/home
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/home/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		// SHOULD NOT BE HARDCODED /////////////////////////
		// UPDATE CODE TO RETRIEVE THIS INFO THROUGH SESSION
		//$user = 'mklbtz@gmail.com';/////////////////////////
		////////////////////////////////////////////////////
		
		//if the user is logged in proceed
		if($this->session->userdata('email')){
			$user = $this->session->userdata('email');

			$q  = "SELECT c.upc AS upc, c.quantity AS quantity ";
			$q .= "FROM bodega_cart AS c ";
			$q .= "WHERE c.email = '".$user."'";
			$this->load->database();
			$query = $this->db->query($q);
			$results = $query->result_array();
			if($results){
				foreach($results as $row){
					$qi  = "SELECT i.title, i.base_price, i.promo_price ";
					$qi .= "FROM bodega_items i ";
					$qi .= "WHERE i.upc = {$row['upc']};";
					$queryi = $this->db->query($qi);
					$resultsi = $queryi->result_array();
					if($resultsi[0]){
						$cart_data[] = array(
							'quantity' => $row['quantity'],
							'title' => $resultsi[0]['title'],
							'upc' => $row['upc'],
							'promo_price' => $resultsi[0]['promo_price'],
							'base_price' => $resultsi[0]['base_price']
						);
					}
				}
			}
			else{
				$cart_data = null;
			}
		
			$qc  = "SELECT c.first_name, c.last_name, c.street, c.city, c.state ";
			$qc .= "FROM bodega_customers c ";
			$qc .= "WHERE c.email = '{$user}';";
			$queryc = $this->db->query($qc);
			$resultsc = $queryc->result_array();
			$customer_data = $resultsc[0];
			$customer_data['email'] = $user;
			$info = array('cart_data'=>$cart_data, 'customer_data'=>$customer_data);
			$this->load->view('cart',$info);
		}
		// else user not logged int
		// redirect to login with current url set as flashdata in users session
		else{
			$this->session->set_flashdata('goto_url',current_url());
			redirect(site_url('login'));
		}
		
	}

	public function add($upc)
	{
		//////////////////////////////
		//$email = 'mklbtz@gmail.com';
		//////////////////////////////
		if($this->session->userdata('email')){
			$email = $this->session->userdata('email');
			$q = "SELECT c.upc FROM bodega_cart c WHERE c.upc = {$upc} AND email='{$email}';";
			$query = $this->db->query($q);
			$results = $query->result_array();
			if(!$results){
				$q  = "INSERT INTO bodega_cart(upc,email,quantity) ";
				$q .= "VALUES ({$upc},'{$email}',1);";
				$this->load->database();
				$this->db->query($q);
			}
			
			redirect('/cart/', 'refresh');
		}
		else{
			$this->session->set_flashdata('goto_url',current_url());
			redirect(site_url('login'));
		}
	}

//	public function update($upc,$new_quantity)
	public function update()
	{
		// TODO: add code to sanitize input
		// i.e. desired quantity exceeds quantity available
		$post_data = $this->input->post();
		
		$email = $post_data['email'];
		$i = 1;
		while(isset($post_data['upc'.$i])){
			$upc = $post_data['upc'.$i];
			$quantity = $post_data['qty'.$i];
			$qvalidate = "select i.title, i.quantity from bodega_items i, bodega_cart c where i.upc = {$upc} and c.email = '{$email}' and {$quantity} > i.quantity;";
			$query = $this->db->query($qvalidate);
			$results = $query->result_array();
			if($results){
				$q  = "UPDATE bodega_cart ";
				$q .= "SET quantity = {$results[0]['quantity']} ";
				$q .= "WHERE email = '{$email}' AND ";
				$q .= "upc = {$upc};";
				$exceeds[$results[0]['title']] = $results[0]['quantity']; 
			}
			else if($quantity > 0){
				$q  = "UPDATE bodega_cart ";
				$q .= "SET quantity = {$quantity} ";
				$q .= "WHERE email = '{$email}' AND ";
				$q .= "upc = {$upc};";
			}
			else{
				$q  = "DELETE FROM bodega_cart ";
				$q .= "WHERE email = '{$email}' AND ";
				$q .= "upc = {$upc};";
			}
			$this->load->database();
			$this->db->query($q);
			$i++;
			
		}
		
		if(isset($exceeds)){
			$i = 0;
			foreach($exceeds as $t => $qty){
				$subs[$i] = "{$qty} {$t}'s";
				$i++;
			}
			$i--;
			$exceeds_message = "Sorry, only ";
			for($k = $i; $k >=0; $k--){
				if($k > 0) $exceeds_message .= $subs[$i] . ", and ";
				else $exceeds_message .= $subs[0];
			}
			$exceeds_message .= " in stock";
			$this->session->set_flashdata('exceeds_message',$exceeds_message);
		}
		
		//$this->load->helper('url');
		//redirect('/cart/', 'refresh');
		redirect('/cart/');
	}
	
	public function checkout()
	{
		$post_data = $this->input->post();
		$email = $post_data['email'];

		$q = "SELECT c.upc, c.quantity, i.base_price, i.promo_price FROM bodega_cart as c, bodega_items as i WHERE c.upc = i.upc AND email='{$email}';";
		$this->load->database();
		$query = $this->db->query($q);
		$cart_data = $query->result_array();
		$i = 0;
		while(isset($cart_data[$i]['upc'])){
			$upc = $cart_data[$i]['upc'];
			$quantity = $cart_data[$i]['quantity'];
			$qvalidate = "select i.title, i.quantity from bodega_items i, bodega_cart c where i.upc = {$upc} and c.email = '{$email}' and {$quantity} > i.quantity;";
			$query = $this->db->query($qvalidate);
			$results = $query->result_array();
			if($results){
				$itemmax = $this->db->query("Select quantity from bodega_items where upc = {$upc};");
				$itemmax = $itemmax->result_array();
				$itemmax = $itemmax[0]['quantity'];
				if($itemmax > 0){
					$q  = "UPDATE bodega_cart ";
					$q .= "SET quantity = {$itemmax} ";
					$q .= "WHERE email = '{$email}' AND ";
					$q .= "upc = {$upc};";
					$this->db->query($q);
				}
				else{
					$q = "Delete from bodega_cart where email = '{$email}' And upc={$upc};";
					$this->db->query($q);
				}
				$exceeds[$results[0]['title']] = $results[0]['quantity']; 				
			}
			$i++;
		}
		if(isset($exceeds)){
			$i = 0;
			foreach($exceeds as $t => $qty){
				$subs[$i] = "{$qty} {$t}'s";
				$i++;
			}
			$i--;
			$exceeds_message = "Sorry, only ";
			for($k = $i; $k >=0; $k--){
				if($k > 0) $exceeds_message .= $subs[$i] . ", and ";
				else $exceeds_message .= $subs[0];
			}
			$exceeds_message .= " in stock";
			$this->session->set_flashdata('exceeds_message',$exceeds_message);
			redirect('/cart/');
		}
		else if (!empty($cart_data)) {
			$q  = "INSERT INTO bodega_orders(email) ";
			$q .= "VALUES('{$email}');";
			$this->load->database();
			$this->db->query($q);
			
			$q = "SELECT o.id FROM bodega_orders o WHERE o.email = '{$email}' ORDER BY o.datetime DESC;";
			$this->load->database();
			$query = $this->db->query($q);
			$results = $query->result_array();
			$id = $results[0]['id'];

			foreach($cart_data as $item){
				if($item['promo_price']){
					$price = $item['promo_price'];
				}
				else{
					$price = $item['base_price'];
				}
				$q = "INSERT INTO bodega_contains(oid,upc,quantity,purchase_price) VALUES({$id},{$item['upc']},{$item['quantity']},{$price});";
				$this->load->database();
				$this->db->query($q);
				$q = "UPDATE bodega_items SET quantity = quantity - {$item['quantity']} WHERE upc = {$item['upc']};";
				$this->db->query($q);
			}
			$q = "DELETE FROM bodega_cart WHERE email='{$email}';";
			$this->load->database();
			$this->db->query($q);
			
			$q = "SELECT c.first_name, c.last_name, c.email, c.street, c.city, c.state FROM bodega_customers as c WHERE c.email = '{$email}';";
			$this->load->database();
			$query = $this->db->query($q);
			$results = $query->result_array();
			$customer_order_info = $results[0];
			$customer_order_info['oid'] = $id;
			
			$this->load->view('congratulations',$customer_order_info);
		}
		else redirect('/cart');
		
		
	}
}
?>