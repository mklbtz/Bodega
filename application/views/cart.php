<?php $this->load->view('page_open'); ?>
	<h2><?php echo $customer_data['first_name'];?>'s Cart</h2>
	<?php if($cart_data): ?>
	<div id='cart_items'>
		<?php
			$message = $this->session->flashdata('exceeds_message');
			echo "<p class='error_message'>{$message}</p>";
		?>
		<?php $this->load->helper('form');?>
		<?php //echo form_open('cart/update');?>
		<?php $this->load->helper('url')?>
		<?php $url = site_url("cart/update");?>
		<?php echo form_open($url);?>
		<table>
			<tr>
				<th>QTY</th>
				<th>Item Name</th>
				<th>Item Price</th>
			</tr>
			<?php $i = 1; ?>
				<?php foreach($cart_data as $item):?>
					<?php echo form_hidden('email', $customer_data['email'])?>
				<?php echo form_hidden('upc'.$i,$item['upc']); ?>
				<tr>
					<td><?php echo form_input(array('name' => 'qty'.$i, 'value' => $item['quantity'], 'class' => 'item_count_box')); ?></td>
					<td><?php echo $item['title']?></td>
					<td>
						<?php if($item['promo_price']){
							echo round($item['promo_price'],2);
						}
						else{
							echo round($item['base_price'],2);
						}
						?>
					</td>	
				</tr>	
				<?php $i++; ?>
				<?php endforeach;?>
		<tr>
			<td> </td>
			<td align='right'><strong>Total:</strong></td>
			<td>
				<?php $total = 0;
				foreach($cart_data as $item){
					if($item['promo_price']){
						$total = $total + $item['quantity'] * $item['promo_price'];
					}
					else{
						$total = $total + $item['quantity'] * $item['base_price'];
					}
				}
				echo round($total,2);
				?>
			</td>
		</tr>
		</table>
		<p><?php echo form_submit('',"Update your Cart");
			echo form_close(); ?>
			<?php 
				$path = 'cart/checkout/';
				$hidden = array("email" => $customer_data['email']);
				echo form_open($path,'', $hidden);
				echo form_submit('checkout','Checkout'); 
				echo form_close();
			?> 
		</p>
	</div>
	<?php else: ?>
		<?php if($this->session->flashdata('exceeds_message')){
			$message = $this->session->flashdata('exceeds_message');
			echo "<p class='error_message'>{$message}</p>";
		}?>
	<p>You have no items in your cart!!</p>
	<?php endif; ?>	
<?php $this->load->view('page_close'); ?>