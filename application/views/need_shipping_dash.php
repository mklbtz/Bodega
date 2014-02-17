<div id='unshipped_orders_dash'>
	<?php if(!$unshipped_orders): ?>
		<p>All current orders have been shipped</p>
	<?php else:?>
		<?php $num_of_orders = 2; ?>
		<?php
		echo $unshipped_orders_table;
		?>
	<?php endif;?>
</div>
