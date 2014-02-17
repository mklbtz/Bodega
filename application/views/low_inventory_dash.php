<div id='low_inventory_dash'>
	<?php 
	// echo "<a href='" . site_url('/staff/inventory')."'>View All</a>"; 
	// echo form_open();
	// echo "<table class='full_width'>";
	// echo "<tr><th class='upc'>UPC</th><th class='title'>Title</th><th class='stock'>Stock</th></tr>";
	// foreach ($low_inventory as $row) {
	// 	echo "<tr class='center_align'>";
	// 	echo "<td>{$row['upc']}</td>";
	// 	echo "<td>{$row['title']}</td>";
	// 	echo "<td>";
	// 	$data = array(
	// 		'name' =>  $row['upc'],
	// 		'id'  =>  $row['upc'],
	// 		'value' => $row['quantity'],
	// 		'class' => 'item_count_box'
	// 	);
	// 	echo form_input($data);
	// 	echo "</td>";
	// 	echo "</tr>";
	// }
	// echo "</table>";
	// ///// form submit
	// echo form_submit('low_inventory_submit','Update Inventory');
	// echo form_close();
	echo $low_inventory_table;
	if (empty($low_inventory_table)) {
		echo "<p>No critically low inventory</p>";
	}
	?>
</div>