<?php
session_start();
include('includes/config.php');
error_reporting(0);
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
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <title>Car Rental Service</title>
    <style>
    #ads {
        margin: 30px 0 30px 0; 
    }
    #ads .card {
        padding: 14px;
    }
    #ads .card-notify-badge {
        position: absolute;
        left: -10px;
        top: -20px;
        background: #18bc9c;
        text-align: center;
        border-radius: 30px 30px 30px 30px; 
        color: #fff;
        padding: 5px 10px;
        font-size: 14px;

    }
    #ads .card-notify-year {
        position: absolute;
        right: 0px;
        top: -20px;
        background: #ff4444;
        border-radius: 50%;
        text-align: center;
        color: #fff;      
        font-size: 14px;      
        width: 50px;
        height: 50px;    
        padding: 15px 0 0 0;
    }
    #ads .card-detail-badge {      
        background: #18bc9c;
        text-align: center;
        border-radius: 30px 30px 30px 30px;
        color: #fff;
        padding: 5px 10px;
        font-size: 14px;        
    }
    #ads .card:hover {
        background: #e0e0e0;
        box-shadow: 12px 15px 20px 0px rgba(46,61,73,0.15);
        border-radius: 4px;
        transition: all 0.3s ease;
    }
    #ads .card-image-overlay {
        font-size: 20px;  
    }
    #ads .card-image-overlay span {
            display: inline-block;              
    }
    #ads .img-fluid {
        width: 430px;
        height: 300px;
    }
    #ads .ad-btn {
        width: 150px;
        height: 40px;
        border-radius: 80px;
        font-size: 16px;
        line-height: 35px;
        text-align: center;
        display: block;
        padding-top: 2px;
        text-decoration: none;
        margin: 20px auto 1px auto;
        color: #fff;
        overflow: hidden;        
        position: relative;
        background-color: #18bc9c;
    }
    #ads .ad-btn:hover {
        background-color: #e6de08;
        color: #1e1717;
        background: transparent;
        transition: all 0.3s ease;
        box-shadow: 12px 15px 20px 0px rgba(46,61,73,0.15);
    }
    #ads .ad-title h5 {
        font-size: 18px;
    }
    </style>
</head>
<body>


<!--Header-->
<?php include('includes/header.php'); ?>
<!-- /Header --> 

<section class="section-padding gray-bg">
    <div class="container">
        <div class="section-header text-center">
            <?php
                if (strlen($_SESSION['login']) == 0) { ?>
                    <h2><span>Car Rental Service For You</span></h2>
                <?php } else { ?>
                    <h2 style="margin-top: 50px;"><span>Car Rental Service For You</span></h2>
            <?php
                }
            ?>
        </div>
        <div class="row">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="resentnewcar" >
                    <div class="row">
                        <div class="col-md-4">
                            <div class="widget_heading">
                                <h5><i class="fa fa-filter" aria-hidden="true"></i> Find Your  Car </h5>
                            </div>
                            <div class="sidebar_filter">
                                <form action="search.php" method="post">
                                    <div class="form-group select">
                                        <select name="brand" class="form-control" id="">
                                            <option>Select Brand</option>
                                            <?php $sql = "SELECT * FROM tblBrand";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt = 1;
                                            if ($query->rowCount() > 0) {
                                            foreach ($results as $result) { ?>  
                                            <option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->brandName);?></option>
                                            <?php }} ?>
                                        </select>
                                    </div>
                                    <div class="form-group select">
                                        <select name="type" class="form-control" id="">
                                            <option>Select Type</option>
                                            <?php $sql = "SELECT * FROM tblCarType";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt = 1;
                                            if($query->rowCount() > 0) {
                                            foreach($results as $result) { ?>  
                                            <option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->carType);?></option>
                                            <?php }} ?>
                                        </select>
                                    </div>
                                    <div class="form-group select">
                                        <select name="fuel" class="form-control" id="">
                                            <option>Select Fuel</option>
                                            <option value="Diesel">Diesel</option>
                                            <option value="CNG">CNG</option>
                                            <option value="Petrol">Petrol</option>
                                        </select>
                                    </div>
                                    <div class="form-group select">
                                        <select name="store" class="form-control" id="">
                                            <option>Select Store</option>
                                            <?php $sql = "SELECT * FROM tblStore";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt = 1;
                                            if($query->rowCount() > 0) {
                                            foreach($results as $result) { ?>  
                                            <option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->name);?><span><?php echo htmlentities($result->city); ?></span></option>
                                            <?php }} ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-block"><i class="fa fa-search" aria-hidden="true"></i> Search Car</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php
                    $sql = "SELECT tblVehicle.vehicleTitle, tblBrand.brandName, tblVehicle.price, tblVehicle.type, 
                    tblVehicle.year, tblVehicle.id AS id, tblVehicle.seat, tblVehicle.img2, tblVehicle.img3, tblVehicle.overview, tblVehicle.img1,
                    tblStore.name AS storeName, tblStore.city FROM tblVehicle 
                    JOIN tblBrand on tblBrand.id = tblVehicle.brandId JOIN tblStore ON tblStore.id = tblVehicle.storeId LIMIT 3";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                    if ($query->rowCount() > 0) {
                        foreach ($results as $result) { ?>
                        <div class="row" id="ads">
                            <div class="col-md-5">
                                <div class="card rounded">
                                    <div class="card-image">
                                        <span class="card-notify-badge"><?php echo htmlentities($result->city); ?></span>
                                        <span class="card-notify-year"><?php echo htmlentities($result->year); ?></span>
                                        <img class="img-fluid" src="admin/img/vehicle/<?php echo htmlentities($result->img1); ?>" alt="Alternate Text" />
                                    </div>
                                    <div class="card-image-overlay m-auto text-center" style="margin-top: 10px;">
                                        <span class="card-detail-badge"><?php echo htmlentities($result->type); ?></span>
                                        <span class="card-detail-badge">$<?php echo htmlentities($result->price); ?>/Day</span>
                                        <span class="card-detail-badge"><?php echo htmlentities($result->seat); ?> Seats</span>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="ad-title m-auto">
                                            <h5><?php echo htmlentities($result->brandName); ?> , <?php echo htmlentities($result->vehicleTitle); ?></h5>
                                            <p><?php echo substr($result->overview, 0, 40); ?></p>
                                        </div>
                                        <a class="ad-btn" href="vehicledetail.php?vehicleId=<?php echo htmlentities($result->id);?>">More detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
        }
    }
?>
                </div>
            </div>
        </div>
    </div>
</section>


<!--Footer -->
<?php include('includes/footer.php');?>
<!-- /Footer--> 

<?php include('includes/login.php'); ?>
<?php include('includes/contactus.php'); ?>
<?php include('includes/signup.php'); ?>
<?php include('includes/about.php'); ?>
<?php include('includes/services.php'); ?>


<!-- Scripts --> 
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

</body>
</html>