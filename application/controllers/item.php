<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/item
	 */
	public function index()
	{
		$upc = $this->input->get('upc');

		$q  = "SELECT * ";
		$q .= "FROM bodega_items i ";
		$q .= "WHERE i.upc = " . $upc . ";";
		
		$query = $this->db->query($q);
		$item = $query->result_array();

		// get related items
		$this->load->model('items_model');
		$related_items = $this->items_model->related_items(array($upc));
		
		if (!empty($item)) {
			$this->load->view('inspect_item',array('item'=>$item[0], 'related_items'=>$related_items));
		}
		else {
			redirect(site_url());
		}
	}
}
?>