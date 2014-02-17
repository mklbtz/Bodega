<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://128.163.47.145/bodega/index.php/home
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's also displayed at http://128.163.47.145/bodega
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$params = array('controller' => 'home', 'function' =>'index');

		// load featured items from database. "Featured" means "has lowered price".
		$this->load->model('items_model');
		$results = $this->items_model->load_featured_items();

		// format rows for html table
		$formattedRows = $this->items_model->generate_formatted_rows($results);

		// generate html table for featured items
		$featured_items_table = $this->_generate_table($formattedRows, 'Featured Items');
		$params['featured_items_table'] = $featured_items_table;

		// load the veiw, sending it everything:
		$this->load->view('home', $params);
	}
	
	/**
	 * Browse Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://128.163.47.145/bodega/index.php/home/browse/{category}
	 * {category} must match a category from the items table in the database.
	 * otherwise, it loads the "All" category,
	 */
	public function browse($category="All")
	{
		$params = array('category' => $category, 'controller' => 'home', 'function' =>'browse');
		$this->load->helper('url');
		$this->load->model('items_model');

		// get query string in URL (search terms)
		$searchTerms = $this->input->get('search');
		$searchTerms = $this->items_model->filter_search_input($searchTerms);
		$params['searchTerms'] = $searchTerms;

		// load items from database
		$results = $this->items_model->load_items($category, $searchTerms);
		$params['results'] = $results;

		// format rows for html table
		$formattedRows = $this->items_model->generate_formatted_rows($results);
		
		// generate an html table for the view:	
		$table = $this->_generate_table($formattedRows, $category);
		$params['table'] = $table;

		// load the view, sending it everything:
		$this->load->view('bs_results', $params);
	}

	private function _generate_table(array $formattedRows, $heading='Items')
	{
		$this->load->library('table');

		$template = array('table_open' => '<table class="browse_table">',
						  'heading_cell_start' => '<th><h2>',
						  'heading_cell_end' => '</h2></th>',
						  'row_start' => '<tr class="browse_tr_style">',
						  'row_alt_start' => '<tr class="browse_tr_alt_style">');

		$this->table->set_template($template);

		$this->table->set_heading(array($heading));

		return $this->table->generate($formattedRows);
	}
}
?>