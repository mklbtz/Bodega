<?php $this->load->view('page_open');
if($customer && $items):

    $order_total = 0;
    foreach ($items as $item) {
        $order_total += $item['item_subtotal'];
    }
    $order_total = round($order_total, 2);

    // catch if order already fulfilled
    if ($customer['is_shipped']) echo "<p class='success_message'>This order has already been shipped!</p>";

    // Print this order heading
    echo "<h2>Order #{$oid} Details</h2>";
    echo "<table style=''>";
    echo "<tr><td class='item_list_cells'>Purchase Date: {$customer['purchase_date']}</td><tr>";
    echo "<tr><td class='item_list_cells'>Total Sale: \${$order_total}</td><tr>";
    echo "</table>";

    // Print customer info
    echo "<h3>Ship To</h3>";
    echo "<p>{$customer['first_name']} {$customer['last_name']} ({$customer['email']})<br/>";
    echo $customer['street'] . '<br/>' . $customer['city'] . ', ' . $customer['state'] . "</p>";

    // Print as table the list of items in this order 
    echo "<h3>Items</h3><table id='item_list_table'>";
    echo "<th class='item_list_cells'> </th>";
    echo "<th class='item_list_cells'>UPC</th>";
    echo "<th class='item_list_cells'>Title</th>";
    echo "<th class='item_list_cells'>Quantity</th>";
    echo "<th class='item_list_cells'></th>";
    echo "<th class='item_list_cells'>Unit Price</th>";
    echo "<th class='item_list_cells'></th>";
    echo "<th class='item_list_cells'>Item Subtotal</th>";
    echo "</tr>";

    foreach ($items as $item) {
        echo "<tr>";
        echo "<td class='item_list_cells' style='font-size:20px;'>•</td>";
        echo "<td class='item_list_cells'>" . $item['upc'] . "</td>";
        echo "<td class='item_list_cells'>" . $item['title'] . "</td>";
        echo "<td class='item_list_cells'>" . $item['quantity'] . " units</td>";
        echo "<td class='item_list_cells'>at</td>";
        echo "<td class='item_list_cells'>$" . $item['purchase_price'] . "</td>";
        echo "<td class='item_list_cells'>=</td>";
        echo "<td class='item_list_cells'>$" . round($item['item_subtotal'], 2) . "</td>";
        echo "</tr>";
    }
    echo "</table>";

    // make sure this order isn't already shipped
    if (!$customer['is_shipped']) {
        $update_url = site_url("/staff/fulfill_order/{$oid}");
        echo "<form action='{$update_url}' method='POST' class='fulfill_button'><input type='submit' value='Fulfill Order'></form>";
    }

endif;
$this->load->view('page_close');?>
