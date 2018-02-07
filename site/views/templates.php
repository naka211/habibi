<!DOCTYPE html>
<html lang="vn">
<?php $this->load->view("html/header");?>
<body>
<div id="loader" style="display: none;"></div>
<?php $this->load->view("html/top");?>
<?php
/*if($this->session->flashdata('message')){
    echo '<div class="alert alert-success alert-dismissible" role="alert"><i class="icon wb-check" aria-hidden="true"></i> '.$this->session->flashdata('message').'</div>';
}if(!empty($message)){
    echo '<div class="alert alert-success alert-dismissible" role="alert"><i class="icon wb-check" aria-hidden="true"></i> '.$message.'</div>';
}*/
?>
<?php $this->load->view($page);?>
<?php $this->load->view("html/footer");?>
<?php $this->load->view("html/analytics");?>
</body>
</html>