<?php
class Orders_Model extends CI_Model 
{
	public function item_details($oid)
	{
		$q  = "SELECT cont.`upc`, cont.`quantity`, cont.`purchase_price`, ";
		$q .= "cont.`quantity` * cont.`purchase_price` as item_subtotal, items.upc, items.`title`, items.`category` ";
		$q .= "FROM bodega_orders as orders, bodega_items as items, bodega_contains as cont ";
		$q .= "WHERE orders.id = cont.`oid` AND cont.upc = items.`upc` AND orders.id = '{$oid}';";
		$items = $this->db->query($q);
		$items = $items->result_array();

		if (empty($items))
			return false;

		else return $items;
	}


	public function customer_details($oid)
	{
		$q  ="SELECT orders.`is_shipped`, orders.`datetime` as purchase_date, customers.`email`, customers.`first_name`, customers.`last_name`, customers.`street`, customers.`state`, customers.`city` ";
		$q .="FROM bodega_orders as orders, bodega_customers as customers ";
		$q .="WHERE orders.`email` = customers.`email` AND orders.id = '{$oid}';";
		$customers = $this->db->query($q);
		$customers = $customers->result_array();
		if (empty($customers)) {
			return false;
		}
		else {
			$customer = $customers[0];
			return $customer;
		}
	}


	public function unshipped_orders()
	{
		// Selects the order table fields, the number of items in each order, and the name of the customer
		$q  = "SELECT o.`id`, o.`email`, o.`datetime`, o.`is_shipped`, sum(c.`quantity`) as item_count, customers.`first_name`, customers.`last_name` ";
		$q .= "FROM `bodega_orders` AS o, `bodega_contains` AS c, `bodega_customers` as customers ";
		$q .= "WHERE o.`is_shipped` = 0 AND o.`id` = c.`oid` AND customers.`email` = o.`email` ";
		$q .= "GROUP BY c.`oid` ORDER BY o.`datetime` ASC;";
		$orders = $this->db->query($q);
		return $orders->result_array();
	}


	public function recent_orders($email){
		$q = "Select o.id, o.datetime, o.is_shipped From bodega_orders o Where o.email = '{$email}' ORDER BY o.datetime DESC;";
		$query = $this->db->query($q);
		$results = $query->result_array();
		$data = null;
		if($results){
			foreach($results as $order){
				$q1  = "Select c.upc, c.quantity, c.purchase_price, i.title, i.description From bodega_contains c, ";
				$q1 .= "bodega_items i Where c.upc = i.upc AND c.oid={$order['id']};";
				$query1 = $this->db->query($q1);
				$results1 = $query1->result_array();
				$data[$order['id']]['items'] = $results1;
				$data[$order['id']]['is_shipped'] = $order['is_shipped'];
				$data[$order['id']]['datetime'] = $order['datetime'];
			}
		}
		return $data;
	}

	
	public function shipped_orders()
	{
		// Selects the order table fields, the number of items in each order, and the name of the customer
		$q  = "SELECT o.`id`, o.`email`, o.`datetime`, o.`is_shipped`, sum(c.`quantity`) as item_count, customers.`first_name`, customers.`last_name` ";
		$q .= "FROM `bodega_orders` AS o, `bodega_contains` AS c, `bodega_customers` as customers ";
		$q .= "WHERE o.`is_shipped` = 1 AND o.`id` = c.`oid` AND customers.`email` = o.`email` ";
		$q .= "GROUP BY c.`oid` ORDER BY o.`datetime` ASC;";
		$orders = $this->db->query($q);
		return $orders->result_array();
	}


	public function weekly_best_sellers()
	{
		$query = $this->db->query(
		"SELECT c.upc, sum(c.quantity) as total_sold from bodega_contains c where c.oid IN(
			select o.id from bodega_orders o where o.datetime between date_sub(curdate(),interval 7 day) and curdate())
		group by c.upc order by total_sold desc;"
		);
		
	}


	//takes two parameters
	//	$sort_by : revenue or units_sold
	//	$interval: today - interval < time analyzed < today
	// returns array([0]=>result0, ..., [i] => resulti)
	//	where resulti = array(upc , units_sold, revenue)
	public function best_sellers_to_date($sort_by,$interval){
		$query = $this->db->query(
		"SELECT rpo.upc, sum(rpo.units_sold) as units_sold, 
				sum(rpo.revenue) as revenue
		from (
			select c.oid, c.upc, c.purchase_price, sum(c.quantity) as units_sold, sum(c.quantity)*c.purchase_price as revenue
			from bodega_contains c, bodega_orders o
			where c.oid = o.id
			AND	o.datetime between 
				date_sub(curdate(),interval {$interval} day) and curdate()
			group by c.oid, c.upc
		) as rpo
		group by rpo.upc order by sum(rpo.{$sort_by}) desc;"
		);
		return $query->result_array();
	}


	public function generate_formatted_rows(array $orders=array())
	{
		$this->load->helper('date');
		date_default_timezone_set('America/Kentucky/Louisville');

		$formattedRows = array();
		foreach ($orders as $row) {
			$link = site_url("staff/shipping/" . $row['id']);
			$date = human_to_unix($row['datetime']);
			$date = timespan($date, now());

            $temp  = "<div id=\"orders_table_row\">";
            $temp .= "<div id=\"upc{$row['id']}\"></div>";  // place marker for # section of url
            $temp .= "<p class=\"order_description\"><a href=\"{$link}\">";
            $temp .= "Order #{$row['id']}: {$row['item_count']} ";

            if ($row['item_count'] == 1) 
            	 $temp .= "item";
            else $temp .= "items";

            $temp .= " ordered by {$row['first_name']} {$row['last_name']} ({$row['email']}), {$date} ago.";
            $temp .= "</a></p></div>";
            $formattedRows[] = array($temp);
		}

		return $formattedRows;
	}
	public function stats_by_period($time_unit,$year){
		if(strtoupper($time_unit)=="MONTH"){
			$query = $this->db->query(
			"Select d.monthname as month, round(sum(d.revenue),2) as revenue
			From (
				Select monthname(date(o.datetime)) as monthname,month(date(o.datetime)) as monthnum, c.quantity * c.purchase_price as revenue
				From bodega_orders o, bodega_contains c
				Where o.id=c.oid
				And year(date(o.datetime))={$year}
			) as d
			Group by d.monthname
			Order by d.monthnum asc;");
			return $query->result_array();
		}
		else if(strtoupper($time_unit)=="WEEK"){
			$query = $this->db->query(
			"Select d.week as week, round(sum(d.revenue),2) as revenue
			From (
				Select weekofyear(date(o.datetime)) as week, c.quantity * c.purchase_price as revenue
				From bodega_orders o, bodega_contains c
				Where o.id=c.oid
				And year(date(o.datetime))={$year}
			) as d
			Group by d.week
			Order by d.week asc;"
			);
			return $query->result_array();
		}
	}
	public function stats_by_category($year){
		$query = $this->db->query(
			"Select d.category as category, round(sum(d.revenue),2) as revenue
			From (
				Select i.category, c.quantity * c.purchase_price as revenue
				From bodega_orders o, bodega_contains c, bodega_items i
				Where o.id=c.oid
				AND c.upc=i.upc
				And year(date(o.datetime))={$year}
			) as d
			Group by d.category
			Order by d.category asc;"
		);
		return $query->result_array();
	}
	public function possible_years(){
		$query = $this->db->query(
		"Select distinct(year(date(datetime))) year
		From bodega_orders
		Order by year(date(datetime)) desc;"
		);
		return $query->result_array();
	}
}
?>
