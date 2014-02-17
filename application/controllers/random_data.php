<?php
	$rOffset = rand(1,117);
	$rHour = rand(0,23);
	$rMinute = rand(0,59);
	$rSecond = rand(0,59);
	$q = "Select timestamp(makedate(2013,{$rOffset}),maketime({$rHour},{$rMinute},{$rSecond})))";
	$query = $this->db->query($q);
	$result = $query->result_array();
	$datetime = $result[0];
	
	$items = $this->db->query("Select upc, promo_price,base_price From bodega_items;");
	$items = $users->result_array();

	$emails = $this->db->query("Select email from bodega_customers");
	$emails = $emails->result_array();
	$rand_email_index = rand(0,count($emails)-1);
	$this->db->query("Insert into bodega_orders(email,is_shipped) Values('{$emails[$rand_email_index]}',1);");

	$oid = $this->db->query("SELECT o.id FROM bodega_orders o WHERE o.email = '{$emails[$rand_email_index]}' ORDER BY o.datetime DESC;");
	$oid = $oid->result_array();
	$oid = $oid[0];

	$this->db->query("Update bodega_orders Set datetime='{$datetime}';");
	$num_items = rand(1,5);
	for($k = 0; $k < $num_items; $k++){
		$rand_item_index = rand(0,count($items)-1);
		if($items[$rand_item_index]['promo_price']){
			$price = $items[$rand_item_index]['promo_price'];
		}
		else{
			$price = $items[$rand_item_index]['base_price']
		}
		$quantity = rand(1,6);
		$this->db->query("INSERT into bodega_contains(oid,upc,quantity,purchase_price) Values({$oid},{$items[$rand_item_index]['upc']},{$quantity},{$price});");
	}
	echo "Done";
?>
