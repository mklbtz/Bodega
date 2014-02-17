<?php
class Items_Model extends CI_Model {

    // removes special characters and certain common words from a string of search terms
    // returns an array of the terms, exploded by spaces
    public function filter_search_input($searchTerms)
    {
        // specials
        static $symbols = array(';', '(', ')', '[', ']', '\'', '"', '%');
        static $common_words = array('a', 'an', 'the', 'at', 'in', 'by', 'am', 'was', 'were', 'is', 'are', 'be', 'being', 'been');

        // remove symbols
        foreach ($symbols as $c) {
            $searchTerms = str_replace($c, '', $searchTerms);
        }

        // remove words
        $searchTerms = explode(" ", $searchTerms);
        $searchTerms = array_diff($searchTerms, $common_words);
        return $searchTerms;
    }

    public function filter_simple($input)
    {
        static $symbols = array(';', '(', ')', '[', ']', '\'', '"', '%');
        // remove symbols
        foreach ($symbols as $c) {
            $input = str_replace($c, '', $input);
        }
        return $input;
    }

    public function load_items($category='All', array $searchTerms=array())
    {
        $q  = "SELECT * FROM bodega_items i ";

        if ($category == "All") {
            $category = "";
        }

        $q .= "WHERE i.category LIKE '%{$category}%' ";
        $q .= "AND ( i.description LIKE '%" . implode("%' AND i.description LIKE '%", $searchTerms) . "%' ";
        $q .= "OR ( i.title LIKE '%" . implode("%' AND i.title LIKE '%", $searchTerms) . "%'));";

        $query = $this->db->query($q);
        return $query->result_array();
    }


    public function load_featured_items()
    {
        $q = "SELECT * FROM bodega_items i WHERE i.promo_price IS NOT NULL;";
        $query = $this->db->query($q);
        $results = $query->result_array();

        return $results;
    }


	public function is_in_stock($upc){
		$q = "select * from bodega_items i where i.upc={$upc} AND i.quantity > 0;";
		$query = $this->db->query($q);
		$result = $query->result_array();
		if($result) return true;
		else return false;
	}


    public function low_inventory()
    {
        $query = $this->db->query("SELECT * FROM bodega_items WHERE quantity < 6 ORDER BY quantity ASC;");
        return $query->result_array();
    }


    public function related_items(array $upcs=array())
    {
        $upc_list = implode(", ", $upcs);

        $q = "Select ro.`upc`, i.title, i.base_price, i.promo_price, i.img_url ";
        $q .= "From ( ";
        $q .= "Select c1.`oid`, c1.`upc` ";
        $q .= "From bodega_contains c1 ";
        $q .= "Where c1.`oid` IN( ";
        $q .= "Select c2.`oid` ";
        $q .= "From bodega_contains c2 ";
        $q .= "Where c2.`upc` IN ({$upc_list}))) as ro, ";
		$q .= "bodega_items i ";
		$q .= "Where i.upc = ro.upc ";
        $q .= "And ro.`upc` NOT IN ({$upc_list}) ";
        $q .= "Group by ro.`upc` ";
        $q .= "Order by count(ro.`upc`) desc; ";

        $results = $this->db->query($q);
        $results = $results->result_array();
        return array_slice($results, 0, 5);
    }


    // creates formatted divs to go in table rows (for each $items row)
    public function generate_formatted_rows($items)
    {
        $formattedRows = array();

        foreach ($items as $row) {
            // opening div
            $temp =  '<div id="browse_table_row">';
            $temp .=  "<div id='upc{$row['upc']}'></div>";  // place marker for # section of url

            // item image on left
            if (!empty($row['img_url'])) {
                $temp .= '<a href="' . site_url("/item/?upc={$row['upc']}") . '"><img id="browse_items_image" src="' . $row['img_url'] . '"/></a>';
            }

            // div for title and prices in the middle
            $temp .= "<div id='browse_items_row_middle'>";
            $temp .= "<p><a href='" . site_url("/item/?upc={$row['upc']}") . "'>{$row['title']}</a></p>";
            if (empty($row['promo_price'])) {
                $temp .= "<p>\${$row['base_price']}</p>";
            }
            else {
                $temp .= "<table><tr>";
                $temp .= "<td><p class='strikeout'>\${$row['base_price']}</p></td>";
                $temp .= "<td><p class='promo'>\${$row['promo_price']}</p></td>";
                $temp .= "</tr></table>";
            }
            $temp .= "</div>";

            // div for cagegory on right
            $temp .= "<div id='browse_items_row_right'><p>";
            $temp .= "<a href='" . site_url("/home/browse/{$row['category']}") . "'>{$row['category']}</a>";
            $temp .= "</p></div>";

            $temp .= "</div>"; // closing div

            // append to array:
            $formattedRows[] = array($temp);
        }

        return $formattedRows;
    }


    // creates formatted divs to go in table rows (specifically for staff inventory section)
    public function generate_inventory_rows($items)
    {
        $formattedRows = array();

        foreach ($items as $row) {
            // opening div
            $temp =  '<div id="browse_table_row">';
            $temp .=  "<div id='upc{$row['upc']}'></div>";  // place marker for # section of url

            // item image on left
            if (!empty($row['img_url'])) {
                $temp .= '<a href="' . site_url("/item/?upc={$row['upc']}") . '"><img id="browse_items_image" src="' . $row['img_url'] . '"/></a>';
            }

            // div for title and prices in the middle
            $temp .= "<div id='browse_items_row_middle'>";
            $temp .= "<p><a href='" . site_url("/item/?upc={$row['upc']}") . "'>{$row['title']}</a><br/>"; // title
            $temp .= "UPC: {$row['upc']}</p>"; // upc

            // prices:
            if (empty($row['promo_price'])) {
                $temp .= "<p class='no_margin'>\${$row['base_price']}</p>";
            }
            else {
                $temp .= "<table><tr>";
                $temp .= "<td><p class='strikeout no_margin'>\${$row['base_price']}</p></td>";
                $temp .= "<td><p class='promo no_margin'>\${$row['promo_price']}</p></td>";
                $temp .= "</tr></table>";
            }
            $temp .= "</div>";

            // div for inventory count update field on right
            $post_url = site_url("/staff/inventory_update/{$row['upc']}");
            $temp .= "<div id='browse_items_row_right'>";
            $temp .= "<form name='item_update_{$row['upc']}' action='{$post_url}' method='post'>";
			$temp .= "<table><tr><td class='right_align'>Quantity</td><td>";
            $temp .= "<input type='text' class='item_count_box' name='new_quantity' value='{$row['quantity']}' onkeydown='if (event.keyCode == 13) item_update_{$row['upc']}.submit()'/></td></tr>";
			if($this->session->userdata('manager')){
				$temp .= "<tr><td class='right_align'>Promo Price</td><td><input type='text' class='item_promo_box' name='new_promo' value='{$row['promo_price']}' onkeydown='if (event.keyCode == 13) item_update_{$row['upc']}.submit()'/></td></tr>";
			}
			$temp .= "</table>";
            $temp .= "<input id='btnSearch' type='submit' class='hidden' value='submit'/>";
            $temp .= "</form>";

            $temp .= "</div>";

            $temp .= "</div>"; // closing div

            // append to array:
            $formattedRows[] = array($temp);
        }

        return $formattedRows;
    }
}
?>
