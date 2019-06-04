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
        $store = $_POST['storeId'];
        $air = $_POST['aircon'];
        $leatherseat = $_POST['leatherseat'];
        $cd = $_POST['cdplayer'];
        $airBag = $_POST['airbag'];
        $sensorCrash = $_POST['sensorcrash'];
        $id = intval($_GET['id']);
        $sql = "UPDATE tblVehicle SET brandId = :brand, storeId = :store, vehicleTitle = :title, overview = :overview, price = :price, type = :type, seat = :seat, year = :year, airCon = :air, leatherSeat = :leatherseat, airBag = :bag, cdPlayer = :cd, sensorCrash = :sensor WHERE id = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':brand', $brand, PDO::PARAM_STR);
        $query->bindParam(':store', $store, PDO::PARAM_STR);
        $query->bindParam(':title', $vehicle_title, PDO::PARAM_STR);
        $query->bindParam(':overview', $overview, PDO::PARAM_STR);
        $query->bindParam(':price', $price, PDO::PARAM_STR);
        $query->bindParam(':type', $type, PDO::PARAM_STR);
        $query->bindParam(':seat', $seat, PDO::PARAM_STR);
        $query->bindParam(':year', $year, PDO::PARAM_STR);
        $query->bindParam(':air', $air, PDO::PARAM_STR);
        $query->bindParam(':leatherseat', $leatherseat, PDO::PARAM_STR);
        $query->bindParam(':bag', $airBag, PDO::PARAM_STR);
        $query->bindParam(':cd', $cd, PDO::PARAM_STR);
        $query->bindParam(':sensor', $sensorCrash, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        $msg = "Data updated successfully";
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
    <title>Admin | Edit Vehicle</title>
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
                <div class="col-md-12"></div>
                <h2 class="page-title">Edit Vehicle</h2>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Vehicle Info</div>
                            <div class="panel-body">
                                <?php
                                if ($error) { ?>  <div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?></div> <?php } else if ($msg) { ?> <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?></div> <?php }
                                ?>
                                <?php
                                $id = intval($_GET['id']);
                                $sql = "SELECT tblVehicle.*, tblBrand.brandName, tblBrand.id AS brandId, tblStore.id AS storeId, tblStore.name, tblStore.city FROM tblVehicle JOIN tblBrand ON tblBrand.id = tblVehicle.brandId JOIN tblStore ON tblStore.id = tblVehicle.storeId WHERE tblVehicle.id = :id";
                                $query = $dbh -> prepare($sql);
                                $query->bindParam(':id', $id, PDO::PARAM_STR);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $i = 1;
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) { ?>
                                    <form method="post" class="form-horizontal" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Vehicle Title<span style="color:red">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="text" required class="form-control" value="<?php echo htmlentities($result->vehicleTitle); ?>" name="title">
                                            </div>
                                            <label class="col-sm-1 control-label">Brand<span style="color:red">*</span></label>
                                            <div class="col-sm-2">
                                                <select class="selectpicker" name="brandId" required>
                                                    <option value="<?php echo htmlentities($result->brandId); ?>"><?php echo htmlentities($result->brandName); ?></option>
                                                    <?php 
                                                        $ret = "SELECT id, brandName FROM tblBrand";
                                                        $query = $dbh->prepare($ret);
                                                        $query->execute();
                                                        $resultss = $query -> fetchAll(PDO::FETCH_OBJ);
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($resultss as $results) {
                                                                if ($results->brandName == $result->brandName) {
                                                                    continue;
                                                                } else { ?>
                                                                <option value="<?php echo htmlentities($results->id);?>"><?php echo htmlentities($results->brandName); ?></option>
                                                    <?php
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <label class="col-sm-1 control-label">Store<span style="color:red">*</span></label>
                                            <div class="col-sm-2">
                                                <select class="selectpicker" name="storeId" required>
                                                    <option value="<?php echo htmlentities($result->storeId); ?>"><?php echo htmlentities($result->name); ?>, <?php echo htmlentities($result->city); ?>></option>
                                                    <?php 
                                                        $ret = "SELECT id, name, address, city, managerName FROM tblStore";
                                                        $query = $dbh->prepare($ret);
                                                        $query->execute();
                                                        $resultssss = $query -> fetchAll(PDO::FETCH_OBJ);
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($resultssss as $resultsss) {
                                                                if ($resultsss->name == $result->name) {
                                                                    continue;
                                                                } else { ?>
                                                                <option value="<?php echo htmlentities($resultsss->id);?>"><?php echo htmlentities($resultsss->name); ?>, <?php echo htmlentities($result->city); ?></option>
                                                    <?php
                                                                }
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
                                                <textarea class="form-control" name="overview" rows="3" required><?php echo htmlentities($result->overview); ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Price Per Day(in USD)<span style="color:red">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="text" name="price" class="form-control" value="<?php echo htmlentities($result->price); ?>" required>
                                            </div>
                                            <label class="col-sm-2 control-label">Fuel Type<span style="color:red">*</span></label>
                                            <div class="col-sm-4">
                                                <select class="selectpicker" name="type" required>
                                                    <option value="<?php echo htmlentities($result->type); ?>"> <?php echo htmlentities($result->type); ?> </option>
                                                    <option value="Petrol">Petrol</option>
                                                    <option value="Diesel">Diesel</option>
                                                    <option value="CNG">CNG</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Model Year<span style="color:red">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="text" name="year" value="<?php echo htmlentities($result->year); ?>" class="form-control" required>
                                            </div>
                                            <label class="col-sm-2 control-label">Seating Capacity<span style="color:red">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="text" name="seat" value="<?php echo htmlentities($result->seat); ?>" class="form-control" required>
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
                                                <?php if ($result->airCon == 1) { ?>
                                                    <div class="checkbox checkbox-inline">
                                                        <input type="checkbox" id="airconditioner" name="aircon" checked value="1">
                                                        <label for="airconditioner"> Air Conditioner </label>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="checkbox checkbox-inline">
                                                        <input type="checkbox" id="airconditioner" name="aircon" value="1">
                                                        <label for="airconditioner"> Air Conditioner </label>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class="col-sm-2">
                                                <?php if ($result->leatherSeat == 1) { ?>
                                                    <div class="checkbox checkbox-inline">
                                                        <input type="checkbox" id="leatherseat" name="leatherseat" checked value="1">
                                                        <label for="leatherseat"> Leather Seat </label>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="checkbox checkbox-inline">
                                                        <input type="checkbox" id="leatherseat" name="leatherseat" value="1">
                                                        <label for="leatherseat"> Leather Seat </label>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class="col-sm-2">

                                                <?php if ($result->airBag == 1) { ?>
                                                    <div class="checkbox checkbox-inline">
                                                        <input type="checkbox" id="airbag" name="airbag" checked value="1">
                                                        <label for="airbag"> Air Bag </label>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="checkbox checkbox-inline">
                                                        <input type="checkbox" id="airbag" name="airbag" value="1">
                                                        <label for="airbag"> Air Bag </label>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class="col-sm-2">
                                                <?php if ($result->cdPlayer == 1) { ?>
                                                    <div class="checkbox checkbox-inline">
                                                        <input type="checkbox" id="cdplayer" name="cdplayer" checked value="1">
                                                        <label for="cdplayer"> CD Player </label>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="checkbox checkbox-inline">
                                                        <input type="checkbox" id="cdplayer" name="cdplayer" value="1">
                                                        <label for="cdplayer"> CD Player </label>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class="col-sm-2">
                                                <?php if ($result->sensorCrash == 1) { ?>
                                                    <div class="checkbox checkbox-inline">
                                                        <input type="checkbox" id="sensorcrash" name="sensorcrash" checked value="1">
                                                        <label for="sensorcrash"> Sensor Crash </label>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="checkbox checkbox-inline">
                                                        <input type="checkbox" id="sensorcrash" name="sensorcrash" value="1">
                                                        <label for="sensorcrash"> Sensor Crash </label>
                                                    </div>
                                                <?php } ?>
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
                                                Image 1 <img src="img/vehicle/<?php echo htmlentities($result->img1);?>" width="300" height="200" style="border:solid 1px #000">
                                                <a href="changeimage1.php?imgid=<?php echo htmlentities($result->id)?>">Change Image 1</a>
                                            </div>
                                            <div class="col-sm-4">
                                                Image 2 <img src="img/vehicle/<?php echo htmlentities($result->img2);?>" width="300" height="200" style="border:solid 1px #000">
                                                <a href="changeimage2.php?imgid=<?php echo htmlentities($result->id)?>">Change Image 2</a>
                                            </div>
                                            <div class="col-sm-4">
                                                Image 3 <img src="img/vehicle/<?php echo htmlentities($result->img3);?>" width="300" height="200" style="border:solid 1px #000">
                                                <a href="changeimage3.php?imgid=<?php echo htmlentities($result->id)?>">Change Image 3</a>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <div class="col-sm-8 col-sm-offset-0">
											    <button class="btn btn-primary" name="submit" type="submit">Save changes</button>
                                            </div>
                                        </div>
                                    </form>
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
    </div>
</body>
</html>
<?php
}
?>