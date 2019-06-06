<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (isset($_POST['send'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];
}
?>


<div id="contact" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Contact Us</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-6">
                        <span><h3>Email: </h3>sovutheay@yahoo.com</span>
                        <span><h3>Phone: </h3>+855-10-600-712</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>