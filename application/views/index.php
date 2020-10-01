<?php $this->load->view('template/layout/header'); ?>
<?php 
if(isset($_SESSION['logged_in']['user'])){
    $this->load->view('template/layout/content'); 
    $this->load->view('template/layout/footer');
}else{
    $this->load->view('pages/auth/login');
}
?>