<div id="categories">
	<h3 class="categories">Categories</h3>
	<?php
	$q = "SELECT distinct(i.category) FROM bodega_items i ORDER BY i.category;";

	$this->load->database();
	$query = $this->db->query($q);
	$results = $query->result_array();

	$this->load->helper('url');
	
	if ($controller == "staff") {
		$link_base = '/staff/inventory/';
	}
	else {
		$link_base = '/home/browse/';
	}

	echo "<ul class=\"categories\">\n";

	// prepend 'All' category to list:
	$allRecord = array(array('category' => 'All'));
	$results = array_merge($allRecord, $results);

	foreach ($results as $row) {
		$link = site_url($link_base . $row['category']);

		if (isset($category) && $category == $row['category']) {
			echo "<li class=\"category selected\">";
			echo $row['category'] . "</li>\n";
		}
		else { echo "<li class=\"category\">";
			echo "<a href=\"{$link}\">{$row['category']}</a></li>\n";
		}
	}
	echo "</ul>\n";
	?>
</div>