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
    <!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script> -->
    <!-- Font Awesome -->
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous"> -->
    <!-- Font Awesome -->
    <title>Document</title>
</head>
<body>
    <nav class="navbar navbar-default navbar-fixed-top" style="background-color: #18bc9c;">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" style="font-size: 28px; margin-top: 10px; color: white;" href="index.php"><b>Car Rental</b></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <?php
            if (strlen($_SESSION['login']) == 0) { ?>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="page-scroll">
                            <a href="#service" data-toggle="modal" style="color: white;" data-dismiss="modal">Services</a>
                        </li>
                        <li class="page-scroll">
                            <a href="#about" data-toggle="modal" style="color: white;" data-dismiss="modal">About</a>
                        </li>
                        <li class="page-scroll">
                            <a href="carlisting.php" style="color: white;">Car Listing</a>
                        </li>
                        <li class="page-scroll">
                            <a href="#contact" data-toggle="modal" style="color: white;" data-dismiss="modal">Contact</a>
                        </li>
                        <li class="page-scroll">
                            <a href="#loginform" data-toggle="modal" style="color: white;" data-dismiss="modal">Login / Register</a>
                        </li>
                        <div class="header_search">
                            <div id="search_toggle"><i class="fa fa-search" aria-hidden="true"></i></div>
                            <form action="#" method="get" id="header-search-form">
                                <input type="text" placeholder="Search..." class="form-control">
                                <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </form>
                        </div>
                    </ul>
                </div>
            <?php
            } else { ?>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="page-scroll">
                            <a href="#service" data-toggle="modal" style="color: white;" data-dismiss="modal">Services</a>
                        </li>
                        <li class="page-scroll">
                            <a href="#about" data-toggle="modal" style="color: white;" data-dismiss="modal">About</a>
                        </li>
                        <li class="page-scroll">
                            <a href="carlisting.php" style="color: white;">Car Listing</a>
                        </li>
                        <li class="page-scroll">
                            <a href="#contact" data-toggle="modal" style="color: white;" data-dismiss="modal">Contact</a>
                        </li>
                        <li class="page-scroll">
                            <a href="myprofile.php" style="color: white;">Profile Setting</a>
                        </li>
                        <li class="page-scroll">
                            <a href="updatepassword.php" style="color: white;">Update Password</a>
                        </li>
                        <li class="page-scroll">
                            <a href="mybooking.php" style="color: white;">My Booking</a>
                        </li>
                        <li class="page-scroll">
                            <a href="logout.php" style="color: white;">Sign Out</a>
                        </li>
                    </ul>
                    <div class="header_search">
                        <div id="search_toggle"><i class="fa fa-search" aria-hidden="true"></i></div>
                        <form action="#" method="get" id="header-search-form">
                            <input type="text" placeholder="Search..." class="form-control">
                            <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </form>
                    </div>
                </div>
            <?php
            }
            ?>
            
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
    <!-- <script>
    $(function() {
    $('a[href*=#]:not([href=#])').click(function() {
      if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
        if (target.length) {
          $('html,body').animate({
            scrollTop: target.offset().top
          }, 1000);
          return false;
        }
      }
    });
    });
    </script> -->

</body>
</html>