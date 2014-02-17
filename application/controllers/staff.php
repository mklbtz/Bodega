<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Staff extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/staff
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/staff/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$params = array('controller' => 'staff', 'function' => 'index');

		if(!$this->session->userdata('email')){
			$this->session->set_flashdata('goto_url',current_url());
			redirect(site_url('login'));
		}
		else if(!$this->session->userdata('staff')){
			$this->load->view('must_be_staff');
		}
		else{
			$this->load->model('items_model');
			$this->load->model('orders_model');

			//get low inventory items
			$low_inventory = $this->items_model->low_inventory();
			$low_inventory = array_slice($low_inventory, 0, 5);  // only take top 5 items
			$params['low_inventory'] = $low_inventory;
			$formattedRows = $this->items_model->generate_inventory_rows($low_inventory);
			$params['low_inventory_table'] = $this->_generate_table($formattedRows, "<a class='header' href='" . site_url('/staff/inventory') . "'>Low Inventory</a>");
			
			//get overdue shippment items
			$params['unshipped_orders'] = $this->orders_model->unshipped_orders();
			$params['unshipped_orders'] = array_slice($params['unshipped_orders'], 0, 5);  // only take top 5 orders
			$formattedRows = $this->orders_model->generate_formatted_rows($params['unshipped_orders']);
			$params['unshipped_orders_table'] = $this->_generate_table($formattedRows, "<a class='header' href='" . site_url('/staff/shipping') . "'>Unshipped Orders</a>");
			
			//if manager, get this week's sales statistics
			if($this->session->userdata('manager')) {
				$weekly_best = $this->orders_model->best_sellers_to_date('units_sold',7);
				$params['weekly_best'] = $weekly_best;
			}

			$this->load->view('staff_view',$params);
		}
	}
	
	public function inventory($category='All')
	{
		$params = array('category' => $category, 'controller' => 'staff', 'function' => 'inventory');
		$this->load->model('items_model');

		// get query string in URL (search terms)
		$searchTerms = $this->input->get('search');
		$searchTerms = $this->items_model->filter_search_input($searchTerms);
		$params['searchTerms'] = $searchTerms;

		// load items from database
		$results = $this->items_model->load_items($category, $searchTerms);
		$params['results'] = $results;

		// format rows for html table
		$formattedRows = $this->items_model->generate_inventory_rows($results);
		
		// generate an html table for the view:	
		$table = $this->_generate_table($formattedRows, 'Inventory: ' . $category);
		$params['table'] = $table;

		// load the view, sending it everything:
		$this->load->view('inventory_browse', $params);
	}


	public function inventory_update($upc)
	{
		$new_quantity = $this->input->post('new_quantity');
		$new_promo = $this->input->post('new_promo');
		if($this->session->userdata('manager')){
			$query = $this->db->query("UPDATE bodega_items SET quantity='{$new_quantity}', promo_price='{$new_promo}' WHERE upc='$upc';");			
		}
		else{
			$query = $this->db->query("UPDATE bodega_items SET quantity='{$new_quantity}' WHERE upc='$upc';");			
		}


		redirect("/staff/inventory#upc{$upc}");
	}


	// page to view and fulfill unshipped orders
	public function shipping($oid=false)
	{
		$params = array('oid' => $oid, 'controller' => 'staff', 'function' => 'shipping');
		$this->load->model('orders_model');

		// show specific order page
		if ($oid) {
			$params['items'] = $this->orders_model->item_details($oid);
			$params['customer'] = $this->orders_model->customer_details($oid);
			$this->load->view('unshipped_order_details', $params);
		}

		// show list of all unshipped orders
		else {

			$params['unshipped_orders'] = $this->orders_model->unshipped_orders();
			$formattedRows = $this->orders_model->generate_formatted_rows($params['unshipped_orders']);
			$params['table'] = $this->_generate_table($formattedRows, "Unshipped Orders");
			$this->load->view('unshipped_orders_list', $params);
		}
	}


	public function fulfill_order($oid)
	{
		$q = "UPDATE bodega_orders SET is_shipped=1 WHERE id=" . $oid;
		$success = $this->db->query($q);
		if ($success)
			$message = "<p class='success_message'>Order #{$oid} sucessfully fulfilled!</p>";
		else {
			$link = site_url('/staff/shipping/' . $oid);
			$message = "<p class='error_message'>Order #{$oid} failed to fulfill! <a class='error_message' href='{$link}'>Try Again</a></p>";
		}
		$this->session->set_flashdata('fulfill_message', $message);
		redirect('/staff/shipping');
	}


	public function statistics()
	{
		$this->load->model('orders_model');
		
		$viewing_year = $this->input->get('year');
		$time_unit = $this->input->get('unit');

		if (empty($viewing_year)) $viewing_year = '2013';
		if (empty($time_unit)) $time_unit = 'month';

		$params = array('controller' => 'staff', 'function' => 'statistics', 'viewing_year' => $viewing_year, 'time_unit' => $time_unit);

		$params['revenue_over_time'] = $this->orders_model->stats_by_period($time_unit, $viewing_year);
		$params['revenue_by_category'] = $this->orders_model->stats_by_category($viewing_year);
		$params['possible_years'] = $this->orders_model->possible_years();

		$this->load->view('stats_page', $params);
	}


	private function _generate_table(array $formattedRows, $heading='')
	{
		$this->load->library('table');

		$template = array('table_open' => '<table class="full_width">',
						  'heading_cell_start' => '<th><h2>',
						  'heading_cell_end' => '</h2></th>',
						  'row_start' => '<tr class="orders_tr_style">',
						  'row_alt_start' => '<tr class="orders_tr_alt_style">');

		$this->table->set_template($template);

		$this->table->set_heading(array($heading));

		return $this->table->generate($formattedRows);
	}

}

/* End of file staff.php */
/* Location: ./application/controllers/staff.php */
