<?php
session_start();
error_reporting(0);
include ('includes/config.php');
if (isset($_POST['submit'])) {
    $fromDate = $_POST['fromdate'];
    $toDate = $_POST['todate'];
    $msg = $_POST['message'];
    $user = $_SESSION['login'];
    $vehicleId = $_GET['vehicleId'];
    $pickup = $_POST['pickup'];
    $status = 0;
    $sql = "INSERT INTO tblBooking(vehicleId, email, fromDate, toDate, pickupPlace, message, statusId) 
    VALUES(:vehicleId, :email, :fromDate, :toDate, :pickup, :msg, :status)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $user, PDO::PARAM_STR);
    $query->bindParam(':vehicleId', $vehicleId, PDO::PARAM_STR);
    $query->bindParam(':fromDate', $fromDate, PDO::PARAM_STR);
    $query->bindParam(':toDate', $toDate, PDO::PARAM_STR);
    $query->bindParam(':msg', $msg, PDO::PARAM_STR);
    $query->bindParam(':pickup', $pickup, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();
    if ($lastInsertId) {
        echo "<script>alert('Booking successfull.');</script>";
    } else {
        echo "<script>alert('Something went wrong. Please try again');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <!--Bootstrap -->

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <!-- Font Awesome -->

    
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> -->
    
    <title>Vehicle Details</title>
</head>
<body>
    
<!--Header-->
<?php include('includes/header.php');?>
<!-- /Header --> 

<?php
$vehicleId = $_GET['vehicleId'];
$sql = "SELECT tblVehicle.*, tblBrand.brandName, tblCarType.carType, tblBrand.id AS brandId FROM tblVehicle JOIN tblBrand ON tblBrand.id = tblVehicle.brandId JOIN tblCarType ON tblCarType.id = tblVehicle.carTypeId WHERE tblVehicle.id = :vehicleId";
$query = $dbh->prepare($sql);
$query->bindParam(':vehicleId', $vehicleId, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if ($query->rowCount() > 0) {
    foreach ($results as $result) {
        $_SESSION['brandId'] = $result->brandId; ?>
        
        <div class="content-wrapper" style="margin-top: 60px;">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <img src="admin/img/vehicle/<?php echo htmlentities($result->img1);?>" width="400" height="300" alt="">
                    </div>
                    <div class="col-md-4">
                        <img src="admin/img/vehicle/<?php echo htmlentities($result->img2);?>" width="400" height="300" alt="">
                    </div>
                    <div class="col-md-4">
                        <img src="admin/img/vehicle/<?php echo htmlentities($result->img3);?>" width="400" height="300" alt="">
                    </div>
                </div>
            </div>
        </div>
        <section class="listing_detail">
            <div class="container">
                <div class="listing_detail_head row">
                    <div class="col-md-9">
                        <h2><?php echo htmlentities($result->brandName);?>, <?php echo htmlentities($result->vehicleTitle);?></h2>
                    </div>
                    <div class="col-md-3">
                        <div class="price_info" style="margin-top: 30px;">
                            <p>$<?php echo htmlentities($result->price);?> </p>Per Day<br><br>
                            <!-- <button class="btn btn-primary" style="background-color: #18bc9c; border: none;"><a href="#bookingform" data-toggle="modal" style="color: white;" data-dismiss="modal">Book Now</a></button> -->
                            <div class="sidebar_widget">
                                <div class="widget_heading">
                                    <h5><i class="fa fa-envelope" aria-hidden="true"></i>Book Now</h5>
                                </div>
                                <form method="post">
                                    <!-- <div class="form-group">
                                        <input type="text" class="form-control" name="daterange" value="01/01/2018 - 01/15/2018" />
                                    </div> -->
                                    <div class="input-group input-daterange">
                                        <input type="text" class="form-control" value="2012-04-05" name="fromdate">
                                        <div class="input-group-addon">to</div>
                                        <input type="text" class="form-control" value="2012-04-19" name="todate">
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <select name="pickup" id="" class="form-control" >
                                            <option value=""> Select </option>
                                            <?php 
                                                $ret1 = "SELECT id, name, address, city, managerName FROM tblStore";
                                                $query1 = $dbh->prepare($ret1);
                                                $query1->execute();
                                                $results1 = $query1 -> fetchAll(PDO::FETCH_OBJ);
                                                if ($query1->rowCount() > 0) {
                                                    foreach ($results1 as $result1) { ?>
                                                        <option value="<?php echo htmlentities($result1->id);?>"><?php echo htmlentities($result1->name); ?>, <?php echo htmlentities($result1->city); ?></option>
                                            <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <textarea rows="4" class="form-control" name="message" placeholder="Message*" required></textarea>
                                    </div>
                                    <?php if ($_SESSION['login']) { ?>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-block" name="booknow" style="background-color: #18bc9c; color: #fff;" value="Book Now">
                                    </div>
                                    <?php } else { ?>
                                        <a href="#loginform" class="btn btn-xs uppercase" style="color: #fff;" data-toggle="modal" data-dismiss="modal">Login To Book</a>
                                    <?php } ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <div class="main_features">
                            <ul>
                                <li><i class="fa fa-calendar" aria-hidden="true"></i><h4><?php echo htmlentities($result->year);?></h4><p>Year</p></li>
                                <li><i class="fa fa-gas-pump" aria-hidden="true"></i><h4><?php echo htmlentities($result->type);?></h4><p>Fuel Type</p></li>
                                <li><i class="fa fa-car" aria-hidden="true"></i><h4><?php echo htmlentities($result->seat);?></h4><p>Seats</p></li>
                                <li><i class="fa fa-car" aria-hidden="true"></i><h4><?php echo htmlentities($result->carType); ?></h4><p>Type</p></li>
                            </ul>
                        </div>
                        <div class="listing_more_info">
                            <h2>Vehicle Overview</h2>
                            <p><?php echo htmlentities($result->overview);?></p>
                            <table>
                                <thead>
                                    <tr><th colspan="2">Accessories</th></tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Air Condition</td>
                                        <?php if ($result->airCon == 1) { ?>
                                        <td><i class="fa fa-check" aria-hidden="true"></i></td>
                                        <?php } else { ?>
                                        <td><i class="fa fa-close" aria-hidden="true"></i></td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <td>Air Bag</td>
                                        <?php if ($result->airBag == 1) { ?>
                                        <td><i class="fa fa-check" aria-hidden="true"></i></td>
                                        <?php } else { ?>
                                        <td><i class="fa fa-close" aria-hidden="true"></i></td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <td>Seat Leather</td>
                                        <?php if ($result->leatherSeat == 1) { ?>
                                        <td><i class="fa fa-check" aria-hidden="true"></i></td>
                                        <?php } else { ?>
                                        <td><i class="fa fa-close" aria-hidden="true"></i></td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <td>CD Player</td>
                                        <?php if ($result->cdPlayer == 1) { ?>
                                        <td><i class="fa fa-check" aria-hidden="true"></i></td>
                                        <?php } else { ?>
                                        <td><i class="fa fa-close" aria-hidden="true"></i></td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <td>Crash Sensor</td>
                                        <?php if ($result->sensorCrash == 1) { ?>
                                        <td><i class="fa fa-check" aria-hidden="true"></i></td>
                                        <?php } else { ?>
                                        <td><i class="fa fa-close" aria-hidden="true"></i></td>
                                        <?php } ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <?php
    }
}
?>
        </section>



<?php
// include('booknow.php');
include('includes/login.php');
include('includes/signup.php');
include('includes/footer.php');
include('includes/about.php');
include('includes/services.php');
include('includes/contactus.php');
?>


<!-- Scripts --> 

<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/jquery.min.js"></script> 

<script>
$('.input-daterange input').each(function() {
    $(this).datepicker('clearDates');
});
</script>

</body>
</html>