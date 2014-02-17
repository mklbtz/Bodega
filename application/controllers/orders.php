<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders extends CI_Controller {

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
		if($this->session->userdata('email')){
			$email = $this->session->userdata('email');
			//Do Orders stuff with a logged in user HERE
			////////////////////////////////////////////
			$this->load->model('orders_model');
			$recent_orders = $this->orders_model->recent_orders($email);
			$this->load->view('orders_view',array('recent_orders' => $recent_orders));
//			if(!$recent_orders){
//				echo "You have no recnet orders";
//			}
//			else{
//				foreach($recent_orders as $oid => $order){
//					echo "Order Number: ". $oid. "-----";
//					if($order['is_shipped']){
//						echo "Your order is shipped------";
//					}
//					else{
//						echo "Your order is NOT shipped---------";
//					}
//					echo "Your order contains item #s : ";
//					foreach($order['items'] as $item){
//						echo $item['upc']. ", ";
//					}
//				}
//			}
		}
		else{
			$this->session->set_flashdata('goto_url',current_url());
			redirect(site_url('login'));
		}
	}
	public function generate($x){
		for($a = 0; $a < $x; $a++){
			$rOffset = rand(1,365);
			$rHour = rand(0,23);
			$rMinute = rand(0,59);
			$rSecond = rand(0,59);
			$q = "Select timestamp(makedate(2012,{$rOffset}),maketime({$rHour},{$rMinute},{$rSecond})) as datetime;";
			$query = $this->db->query($q);
			$result = $query->result_array();
			$datetime = $result[0]['datetime'];
			//echo $datetime;
		
			$items = $this->db->query("Select upc, promo_price,base_price From bodega_items;");
			$items = $items->result_array();

			$emails = $this->db->query("Select email from bodega_customers");
			$emails = $emails->result_array();
			$rand_email_index = rand(0,count($emails)-1);
			$this->db->query("Insert into bodega_orders(email,is_shipped) Values('{$emails[$rand_email_index]['email']}',1);");

			$oid = $this->db->query("SELECT o.id FROM bodega_orders o WHERE o.email = '{$emails[$rand_email_index]['email']}' ORDER BY o.datetime DESC;");
			$oid = $oid->result_array();
			$oid = $oid[0]['id'];

			$this->db->query("Update bodega_orders Set datetime='{$datetime}' Where id={$oid};");
			$num_items = rand(1,5);
			$used_items = array();
			for($k = 0; $k < $num_items; $k++){
				$rand_item_index = rand(0,count($items)-1);
				while(in_array($rand_item_index,$used_items)){
					$rand_item_index = rand(0,count($items)-1);
				}
				$used_items[] = $rand_item_index;
				if($items[$rand_item_index]['promo_price']){
					$price = $items[$rand_item_index]['promo_price'];
				}
				else{
					$price = $items[$rand_item_index]['base_price'];
				}
				$quantity = rand(1,6);
				$this->db->query("INSERT into bodega_contains(oid,upc,quantity,purchase_price) Values({$oid},{$items[$rand_item_index]['upc']},{$quantity},{$price});");
			}
		}	
		echo "Done";
	}
}
?>