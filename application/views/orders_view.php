<?php $this->load->view('page_open');?>
			<h2>Recent Orders</h2>
			<?php if(!$recent_orders): ?>
				<p>You have no recent orders</p>
				<?php $home_url = site_url(); ?>
				<?php echo "<a href='{$home_url}'>Home</a>"; ?>
			<?php else: ?>
				<?php foreach($recent_orders as $oid => $order):?>
				<div id='recent_order'>
					<div id='recent_order_table_top' style='width:60%'>
						<div id='recent_order_number' style="float:left; width:20%"><p>Order #: <?php echo $oid;?></p></div>
						<div id='recent_order_date' style="float:left; width:40%"><p>Date: <?php echo $order['datetime']; ?></p></div>
						<div id='recent_order_is_shipped' style="float:left; width:40%"><p><?php if($order['is_shipped']) echo "Shipped"; else echo "Not Yet Shipped"; ?></p></div>
					</div>
					<div id='recent_order_table' style='border: solid 1px'>
					<table width=60%>
						<tr>
							<th align=left>UPC</th>
							<th align=left>Title</th>
							<th align=left>Quantity</th>
							<th align=left>Purchase Price</th>
						</tr>
						<?php foreach($order['items'] as $item): ?>
							<tr>
								<td width=20%><?php echo $item['upc'];?></td>
								<?php echo "<td width=40%><a href='". site_url("/item/?upc={$item['upc']}"). "'>{$item['title']}</a></td>";?>
								
								<td width=20%><?php echo $item['quantity'];?></td>
								<td width=20%><?php echo $item['purchase_price'];?></td>
							</tr>
						<?php endforeach; ?>
					</table>
					</div>
				</div>
				<?php endforeach; ?>
			<?php endif; ?>
<?php $this->load->view('page_close');?>