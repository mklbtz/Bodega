<div id='weekly_best_dash'>
	<h2 class='center_align'><a class='header' href='<?php echo site_url('staff/statistics') ?>'>Weekly Best Sellers</a></h2>
	<?php $num_of_best_to_show = 2;?>
	<?php if(!$weekly_best):?>
		<p>No items sold</p>
	<?php else:?>
		<?php
		echo "<table class='full_width'>";
		echo "<tr><th>UPC</th><th>Units Sold</th><th>Revenue</th></tr>";
		for($k = 0; $k < $num_of_best_to_show;$k++){
			if(isset($weekly_best[$k])){
				echo "<tr class='center_align'>";
				echo "<td>{$weekly_best[$k]['upc']}</td>";
				echo "<td>{$weekly_best[$k]['units_sold']}</td>";
				echo "<td>$".round($weekly_best[$k]['revenue'],2)."</td>";
				echo "</tr>";
			}
			else{
				echo "<tr><td colspan=3>Only {$k} items sold</td></tr>";
				break;
			}
		}
		echo "</table>";
		?>
	
	<?php endif;?>
	<?php
	?>
</div>