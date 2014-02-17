<?php $this->load->view('page_open');

$message = $this->session->flashdata('fulfill_message');
if ($message) echo $message;
echo $table;

$this->load->view('page_close');?>