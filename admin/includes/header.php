<?php

$email = $_SESSION['login'];
$sql = "SELECT name FROM tblUser WHERE email=:email";
$query= $dbh->prepare($sql);
$query->bindParam(':email', $email, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
if ($query->rowCount() > 0) {
    foreach ($results as $result) {
        echo htmlentities($result->name);
    }
}
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <title>Document</title>
</head>
<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#page-top">Car Rental Services</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <?php
            if (strlen($_SESSION['login']) == 0) { ?>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="hidden">
                            <a href="#page-top"></a>
                        </li>
                        <li class="page-scroll">
                            <a href="#portfolio">Services</a>
                        </li>
                        <li class="page-scroll">
                            <a href="#about">About</a>
                        </li>
                        <li class="page-scroll">
                            <a href="#contact">Contact</a>
                        </li>
                        <li class="page-scroll">
                            <a href="#">Login / Register</a>
                        </li>
                    </ul>
                </div>
            <?php
            } else { ?>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="hidden">
                            <a href="#page-top"></a>
                        </li>
                        <li class="page-scroll">
                            <a href="">Services</a>
                        </li>
                        <li class="page-scroll">
                            <a href="">About</a>
                        </li>
                        <li class="page-scroll">
                            <a href="myprofile.php">Profile Setting</a>
                        </li>
                        <li class="page-scroll">
                            <a href="updatepassword.php">Update Password</a>
                        </li>
                        <li class="page-scroll">
                            <a href="mybooking.php">My Booking</a>
                        </li>
                        <li class="page-scroll">
                            <a href="logout.php">Sign Out</a>
                        </li>
                    </ul>
                </div>
            <?php
            }
            ?>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
    <header id="page-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <img class="img-responsive" src="http://ironsummitmedia.github.io/startbootstrap-freelancer/img/profile.png" alt="">
                    <div class="intro-text">
                        <span class="name">Inspired by PureCSS.io</span>
                        <hr class="star-light">
                        <p class="skills">Landing Page Layout</p>
                        <p class="skills">Scroll to see the effect</p>
                    </div>
                </div>
            </div>
        </div>
    </header>
</body>
</html>