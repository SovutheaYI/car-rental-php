<?php
session_start();
error_reporting(0);
include ('includes/config.php');

if (strlen($_SESSION['login']) == 0) {
    header('location: index.php');
} else {
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet"> 
    <!--Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <title>My Booking</title>
</head>
<body>

<!--Header-->
<?php include('includes/header.php');?>
<!-- /Header --> 

<section class="content-wrapper text-center" style="margin-top: 80px; margin-bottom: 80px;">
    <div class="container">
        <h2 style="color: #18bc9c;">My Booking</h2>
    </div>
</section>

    <?php
    $useremail = $_SESSION['login'];
    $sql = "SELECT * FROM tblUser WHERE emailId = :useremail";
    $query = $dbh->prepare($sql);
    $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
        foreach ($results as $result) { ?>

            <section class="user_profile inner_pages">
                <div class="container">
                    <div class="user_profile_info gray-bg padding_4x4_40">
                        <div class="dealer_info">
                            <h3><?php echo htmlentities($result->fullName);?></h3>
                            <p><?php echo htmlentities($result->address);?><br>
                            <?php echo htmlentities($result->city);?>&nbsp;<?php }}?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            <div class="col-md-6 col-sm-8">
                                <div class="profile_wrap">
                                    <h5 class="uppercase underline">My Booikngs</h5>
                                    <div class="my_vehicles_list">
                                        
                                        <?php 
                                        $email = $_SESSION['login'];
                                        $sql = "SELECT tblVehicle.img1 AS img1, tblVehicle.vehicleTitle, tblBooking.pickupPlace, tblVehicle.id AS vehicleId, tblBrand.brandName, tblBooking.fromDate, tblBooking.toDate, tblBooking.message, tblBooking.statusId FROM tblBooking JOIN tblVehicle ON tblBooking.vehicleId = tblVehicle.id JOIN tblBrand ON tblBrand.id = tblVehicle.brandId WHERE tblBooking.email = :email";
                                        $query = $dbh->prepare($sql);
                                        $query->bindParam(':email', $email, PDO::PARAM_STR);
                                        $query->execute();
                                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                                        
                                        if($query->rowCount() > 0) {
                                            foreach ($results as $result) { ?>
                                            
                                                <div class="">
                                                    <a href=""><img src="admin/img/vehicle/<?php echo htmlentities($result->img1);?>" alt="image"></a>
                                                </div>
                                                <div class="">
                                                    <h6><a href=""><?php echo htmlentities($result->brandName); ?> , <?php echo htmlentities($result->vehicleTitle); ?></a></h6>
                                                    <p><b>From Date:</b> <?php echo htmlentities($result->fromDate);?><br /> <b>To Date:</b> <?php echo htmlentities($result->toDate);?></p>
                                                </div>
                                                <div><p><b>Message:</b> <?php echo htmlentities($result->message);?> </p></div>
                                                <div><p><b>Location:</b> <?php echo htmlentities($result->pickupPlace); ?> </p></div>
                                                <?php if ($result->statusId == 1) { ?>
                                                <div class="vehicle_status">
                                                    <a href="#" class="btn outline btn-xs active-btn">Confirmed</a>
                                                </div>
                                                <?php } else if ($result->statusId == 0) { ?>
                                                <div class="vehicle_status">
                                                    <a href="#" class="btn outline btn-xs active-btn">Cancelled</a>
                                                </div>
                                                <?php } else if ($result->statusId == 2) { ?>
                                                <div class="vehicle_status">
                                                    <a href="#" class="btn outline btn-xs active-btn">Not Confirm Yet</a>
                                                </div>
                                                <?php } ?>
                                            
                                            <?php
                                        }
                                        }
                                        ?>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
<?php
include('includes/footer.php');
include('includes/about.php');
include('includes/services.php');
include('includes/contactus.php');
?>
    
<!-- Scripts --> 
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>


<?php
}
?>