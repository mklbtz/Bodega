<?php $this->load->view('page_open'); ?>


<?php $this->load->view('low_inventory_dash'); ?>

<?php $this->load->view('need_shipping_dash'); ?>

<?php 
	if($this->session->userdata('manager')){
		$this->load->view('weekly_best_dash');
	}
?>

<?php $this->load->view('page_close'); ?>