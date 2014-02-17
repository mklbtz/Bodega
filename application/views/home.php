<?php
$this->load->view('page_with_sidebar_open');

$this->load->view('featured_items', array('featured_items_table' => $featured_items_table));

$this->load->view('page_with_sidebar_close');
?>