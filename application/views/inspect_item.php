<?php $this->load->view('page_open'); ?>
	<div id="item_image_price_container">
		<?php if($item['img_url']): ?>
		<div id="item_image_container">
			<?php
			echo "<img src='" . $item["img_url"] . "' class='item_image'";
			echo $item["title"]."'>";
			?>
		</div>
		<?php endif; ?>
		<div id='item_overview'>
			<h2><?php echo $item['title']; ?></h2>
			<div id= "item_price_container">
			
				<?php if($item["promo_price"]): ?>
					<p class="strikeout">$<?php echo $item["base_price"]?></p>
					<p class="promo"><?php echo "$".$item["promo_price"]?></p>
				
				<?php else: ?>
					<p>$<?php echo $item['base_price']?></p>
				<?php endif; ?>
				<?php $this->load->helper('url');
				$url = site_url("cart/add/{$item['upc']}"); ?>
				<?php if($item['quantity'] > 0): ?>
						<FORM METHOD="LINK" ACTION="<?php echo $url; ?>">
						<INPUT TYPE="submit" VALUE="Add to Cart">
						</FORM>
				<?php else: ?>
					<p class='out_of_stock'>Out of Stock</p>
				<?php endif; ?>
			</div>
			<?php if($item["promo_price"]): ?>
			<div id= "item_savings">
				<p>Save <?php echo round(($item["base_price"]-$item["promo_price"])/$item["base_price"]*100)."%";?></p>
			</div>
			<?php endif; ?>
		</div>
	</div>
	<div id="details">
		<h2>Details</h2>
		<table class='item_details'>
			<tr>
			<td class='item_row_head'>UPC:</td><td><?php echo $item['upc']; ?></td>
			</tr>
			<tr>
			<td class='item_row_head'>Category:</td><td><?php 
			if($item['category']) echo $item['category'];
			else echo "No category specified"; ?></td>
			</tr>
			<tr>
			<td class='item_row_head'>Description:</td> <td><?php 
			if($item['description']) echo $item['description'];
			else echo "No description provided"; ?></td>
			</tr>
		</table>
	</div>
	<div id="related_items_container">
	<?php if($related_items): ?>
		<h2>Related Items</h2>
		<?php foreach ($related_items as $item): ?>
			<div class="related_item">
				<?php if (!empty($item['img_url'])): ?>
				<img src="<?php echo $item['img_url'] ?>" class="related_item_image">
				<?php endif; ?>
				<h3 class="related_item_title"><?php echo "<a href='". site_url('/item/?upc='.$item['upc']). "'>". $item['title']. "</a>"; ?></h3>
				<?php
				if (empty($item['promo_price'])) {
					echo "<p class=\"center_align\">$" . $item['base_price'] . "</p>";
				}
				else echo "<p class=\"promo center_align\">$" . $item['promo_price'] . "</p>";
				?>
			</div>
		<? endforeach ?>
	<?php endif;?>
	</div>
<?php $this->load->view('page_close');