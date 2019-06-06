<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['adminlogin']) == 0) {
    header('location: index.php');
} else {
    if (isset($_POST['submit'])) {
        $vehicle_title = $_POST['title'];
        $overview = $_POST['overview'];
        $price = $_POST['price'];
        $type = $_POST['type'];
        $seat = $_POST['seat'];
        $year = $_POST['year'];
        $brand = $_POST['brandId'];
        $cartype = $_POST['carTypeId'];
        $store = $_POST['storeId'];
        $vimage1 = $_FILES["img1"]["name"];
        $vimage2 = $_FILES["img2"]["name"];
        $vimage3 = $_FILES["img3"]["name"];
        $air = $_POST['aircon'];
        $leatherseat = $_POST['leatherseat'];
        $cd = $_POST['cdplayer'];
        $airBag = $_POST['airbag'];
        $sensorCrash = $_POST['sensorcrash'];
        move_uploaded_file($_FILES["img1"]["tmp_name"],"img/vehicle/".$_FILES["img1"]["name"]);
        move_uploaded_file($_FILES["img2"]["tmp_name"],"img/vehicle/".$_FILES["img2"]["name"]);
        move_uploaded_file($_FILES["img3"]["tmp_name"],"img/vehicle/".$_FILES["img3"]["name"]);

        $sql = "INSERT INTO tblVehicle(brandId, storeId, carTypeId, vehicleTitle, overview, price, type, seat, year, img1, img2, img3, airCon, leatherSeat, airBag, cdPlayer, sensorCrash) VALUES(:brand, :store, :cartype, :title, :overview, :price, :type, :seat, :year, :img1, :img2, :img3, :air, :leather, :bag, :cd, :sensor)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':brand', $brand, PDO::PARAM_STR);
        $query->bindParam(':store', $store, PDO::PARAM_STR);
        $query->bindParam(':cartype', $cartype, PDO::PARAM_STR);
        $query->bindParam(':title', $vehicle_title, PDO::PARAM_STR);
        $query->bindParam(':overview', $overview, PDO::PARAM_STR);
        $query->bindParam(':price', $price, PDO::PARAM_STR);
        $query->bindParam(':type', $type, PDO::PARAM_STR);
        $query->bindParam(':seat', $seat, PDO::PARAM_STR);
        $query->bindParam(':year', $year, PDO::PARAM_STR);
        $query->bindParam(':img1', $vimage1, PDO::PARAM_STR);
        $query->bindParam(':img2', $vimage2, PDO::PARAM_STR);
        $query->bindParam(':img3', $vimage3, PDO::PARAM_STR);
        $query->bindParam(':air', $air, PDO::PARAM_STR);
        $query->bindParam(':leather', $leatherseat, PDO::PARAM_STR);
        $query->bindParam(':bag', $airBag, PDO::PARAM_STR);
        $query->bindParam(':cd', $cd, PDO::PARAM_STR);
        $query->bindParam(':sensor', $sensorCrash, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            $msg = "Vehicle posted successfully";
        } else {
            $error = "Something went wrong. Please try again";
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
    <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
    <link href="assets/css/slick.css" rel="stylesheet">
    <link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/fileinput.min.css" rel="stylesheet">
    <title>Admin | Add Vehicle</title>
    <style>
		.errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
        .succWrap{
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
	</style>
</head>
<body>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="page-title">Post A Vehicle</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Vehicle Info
                                </div>
                                <?php
                                if ($error) { ?>  <div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?></div> <?php } else if ($msg) { ?> <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?></div> <?php }
                                ?>
                                <div class="panel-body">
                                    <form method="post" class="form-horizontal" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Vehicle Title<span style="color:red">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="text" required class="form-control" name="title">
                                            </div>
                                            <label class="col-sm-1 control-label">Brand<span style="color:red">*</span></label>
                                            <div class="col-sm-2">
                                                <select class="selectpicker" name="brandId" required>
                                                    <option value=""> Select </option>
                                                    <?php 
                                                        $ret = "SELECT id, brandName FROM tblBrand";
                                                        $query = $dbh->prepare($ret);
                                                        $query->execute();
                                                        $results = $query -> fetchAll(PDO::FETCH_OBJ);
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $result) { ?>
                                                                <option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->brandName); ?></option>
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <label class="col-sm-1 control-label">Store<span style="color:red">*</span></label>
                                            <div class="col-sm-2">
                                                <select class="selectpicker" name="storeId" required>
                                                    <option value=""> Select </option>
                                                    <?php 
                                                        $ret = "SELECT id, name, address, city, managerName FROM tblStore";
                                                        $query = $dbh->prepare($ret);
                                                        $query->execute();
                                                        $results = $query -> fetchAll(PDO::FETCH_OBJ);
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $result) { ?>
                                                                <option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->name); ?>, <?php echo htmlentities($result->city); ?></option>
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="hr-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Vehical Overview<span style="color:red">*</span></label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="overview" rows="3" required></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Price Per Day(in USD)<span style="color:red">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="text" name="price" class="form-control" required>
                                            </div>
                                            <label class="col-sm-1 control-label">Fuel Type<span style="color:red">*</span></label>
                                            <div class="col-sm-2">
                                                <select class="selectpicker" name="type" required>
                                                    <option value=""> Select </option>
                                                    <option value="Petrol">Petrol</option>
                                                    <option value="Diesel">Diesel</option>
                                                    <option value="CNG">CNG</option>
                                                </select>
                                            </div>
                                            <label class="col-sm-1 control-label">Car Type<span style="color:red">*</span></label>
                                            <div class="col-sm-2">
                                                <select class="selectpicker" name="carTypeId" required>
                                                    <option value=""> Select </option>
                                                    <?php 
                                                        $ret= "SELECT * FROM tblCarType";
                                                        $query = $dbh->prepare($ret);
                                                        $query->execute();
                                                        $results = $query -> fetchAll(PDO::FETCH_OBJ);
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $result) { ?>
                                                                <option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->carType); ?></option>
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Model Year<span style="color:red">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="text" name="year" class="form-control" required>
                                            </div>
                                            <label class="col-sm-2 control-label">Seating Capacity<span style="color:red">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="text" name="seat" class="form-control" required>
                                            </div>

                                        </div>
                                        <div class="hr-dashed"></div>	
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <h4><b>Accessories</b></h4>
                                            </div>
                                        </div>
                                        <div class="form-control">
                                            <div class="col-sm-2">
                                                <div class="checkbox checkbox-inline">
                                                    <input type="checkbox" id="airconditioner" name="aircon" value="1">
                                                    <label for="airconditioner"> Air Conditioner </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="checkbox checkbox-inline">
                                                    <input type="checkbox" id="leatherseat" name="leatherseat" value="1">
                                                    <label for="leatherseat"> Leather Seat </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="checkbox checkbox-inline">
                                                    <input type="checkbox" id="airbag" name="airbag" value="1">
                                                    <label for="airbag"> Air Bag </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="checkbox checkbox-inline">
                                                    <input type="checkbox" id="cdplayer" name="cdplayer" value="1">
                                                    <label for="cdplayer"> CD Player </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="checkbox checkbox-inline">
                                                    <input type="checkbox" id="sensorcrash" name="sensorcrash" value="1">
                                                    <label for="sensorcrash"> Sensor Crash </label>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="hr-dashed"></div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <h4><b>Upload Images</b></h4>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-4">
                                                Image 1 <span style="color:red">*</span><input type="file" name="img1" required>
                                            </div>
                                            <div class="col-sm-4">
                                                Image 2 <span style="color:red">*</span><input type="file" name="img2" required>
                                            </div>
                                            <div class="col-sm-4">
                                                Image 3 <span style="color:red">*</span><input type="file" name="img3" required>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <div class="col-sm-8 col-sm-offset-0">
                                                <button class="btn btn-default" type="reset">Cancel</button>
											    <button class="btn btn-primary" name="submit" type="submit">Save changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  


<!-- Scripts --> 
<script src="asssets/js/fileinput.js"></script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/interface.js"></script> 
<!--bootstrap-slider-JS--> 
<script src="assets/js/bootstrap-slider.min.js"></script> 
<!--Slider-JS--> 
<script src="assets/js/slick.min.js"></script> 
<script src="assets/js/owl.carousel.min.js"></script>
</body>
</html>

<?php
}
?>