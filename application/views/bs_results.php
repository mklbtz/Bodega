<!-- This page shows item results for both browsing and searching. -->
<!-- Three parameters are passed to this page, $results, $category, and $searchTerms . -->
<!-- $results is an array containing the query results. -->
<!-- $category is the category, which may or may not have been selected by the user. -->
<!-- $searchTerms is an array of user-entered search terms. This will be used to pre-populate the search box. -->
<?php
$this->load->view('page_with_sidebar_open');

if (!empty($results)) {
    echo "<div id=\"browse_table_container\">" . $table . "</div>";
}
else {
    echo "<p style='text-align:center;'><em>Sorry, no results...</em></p>";
}

$this->load->view('page_with_sidebar_close');
?>