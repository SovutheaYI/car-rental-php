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
    <!--Custome Style -->
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <title>Car Results</title>
</head>
<body>
<!--Header--> 
<?php include('includes/header.php');?>
<!-- /Header --> 


<div class="container">
    <div class="row">
        <div class="col-md-9 col-md-push-1">
            <div class="result-sorting-wrapper" style="margin-top:100px;">
                <div class="sorting-count">
                    <h2>Search Result</h2>
                    <?php
                    $brand = $_POST['brand'];
                    $fueltype = $_POST['fuel'];
                    $type = $_POST['type'];
                    $store = $_POST['store'];
                    $sql1 = "SELECT id FROM tblVehicle WHERE tblVehicle.brandId = :brand AND tblVehicle.type = :fueltype AND tblVehicle.carTypeId = :type AND tblVehicle.storeId = :store";
                    $query1 = $dbh->prepare($sql1);
                    $query1->bindParam(':brand', $brand, PDO::PARAM_STR);
                    $query1->bindParam(':fueltype', $fueltype, PDO::PARAM_STR);
                    $query1->bindParam(':type', $type, PDO::PARAM_STR);
                    $query1->bindParam(':store', $store, PDO::PARAM_STR);
                    $query1->execute();
                    $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                    $cnt = $query1->rowCount();
                    ?>
                    <p><span><?php echo htmlentities($cnt);?> Listings</span></p>
                </div>
            </div>


            <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Vehicle Title</th>
                                        <th>Price/day</th>
                                        <th>Type</th>
                                        <th>Fuel Type</th>
                                        <th>Store Name</th>
                                        <th>City</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $sql = "SELECT tblVehicle.*, tblBrand.brandName, tblCarType.*, tblBrand.id AS bid, tblStore.* FROM tblVehicle JOIN tblBrand ON tblBrand.id = tblVehicle.brandId JOIN tblStore ON tblStore.id = tblVehicle.storeId JOIN tblCarType ON tblCarType.id = tblVehicle.carTypeId WHERE tblVehicle.brandId = :brand AND tblVehicle.type = :fueltype AND tblVehicle.storeId = :store AND tblVehicle.carTypeId = :type";
                                    $query = $dbh->prepare($sql);
                                    $query->bindParam(':brand', $brand, PDO::PARAM_STR);
                                    $query->bindParam(':fueltype', $fueltype, PDO::PARAM_STR);
                                    $query->bindParam(':type', $type, PDO::PARAM_STR);
                                    $query->bindParam(':store', $store, PDO::PARAM_STR);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $i = 1;
                                    if ($query->rowCount() > 0) {
                                        foreach($results as $result) { ?>
                                            <tr>
                                                <td><?php echo htmlentities($i); ?></td>
                                                <td><?php echo htmlentities($result->vehicleTitle); ?></td>
                                                <td><?php echo htmlentities($result->price); ?></td>
                                                <td><?php echo htmlentities($result->carType); ?></td>
                                                <td><?php echo htmlentities($result->type); ?></td>
                                                <td><?php echo htmlentities($result->name); ?></td>
                                                <td><?php echo htmlentities($result->city); ?></td>
                                                <td><a class="ad-btn" href="vehicledetail.php?vehicleId=<?php echo htmlentities($result->id);?>">More detail</a></td>
                                            </tr>
                                    <?php
                                        $i = $i + 1;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
            
        </div>
    </div>
</div>




<!--Footer -->
<?php include('includes/footer.php');?>
<!-- /Footer-->

<!--Login-Form -->
<?php include('includes/login.php');?>
<!--/Login-Form --> 

<!--Register-Form -->
<?php include('includes/registration.php');?>

<!--/Register-Form --> 


<!-- Scripts --> 
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
    
</body>
</html>