<?php $this->load->view('page_open'); ?>
	<p><?php echo $first_name; ?>, Congratulations on you purchase from Bodega. Your order number is <?php echo $oid; ?>.</p>
	<p>Your item(s) will be shipped to the address below in 3-5 business days. You can review your recent order(s) and track their shipment status via the Orders tab in the above. Thank you for shopping at your local Bodega!</p>
	<table>
		<tr>
			<th colspan=2>Shipping Information</th>
		</tr>
		<tr>
			<td>First Name</td><td><?php echo $first_name?></td>
		</tr>
		<tr>
			<td>Last Name</td><td><?php echo $last_name?></td>
		</tr>
		<tr>
			<td>Street Address</td><td><?php echo $street?></td>
		</tr>
		<tr>
			<td>City</td><td><?php echo $city?></td>
		</tr>
		<tr>
			<td>State</td><td><?php echo $state?></td>
		</tr>
	</table>
	<!-- Continue shopping button goes here-->
	<?php $this->load->helper('url');?>
	<form name='continue_shopping'
	<button type='submit'><a href='<?php echo site_url();?>'></a></button>
<?php $this->load->view('page_close'); ?>