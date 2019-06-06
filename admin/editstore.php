<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['adminlogin']) == 0) {
    header('location: index.php');
} else {
    if (isset($_POST['submit'])) {
        $storename = $_POST['name'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $manager = $_POST['manager'];
        $id = intval($_GET['id']);
        $sql = "UPDATE tblStore SET name = :name, address = :address, city = :city, managerName = :manager WHERE id = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':name', $storename, PDO::PARAM_STR);
        $query->bindParam(':address', $address, PDO::PARAM_STR);
        $query->bindParam(':city', $city, PDO::PARAM_STR);
        $query->bindParam(':manager', $manager, PDO::PARAM_STR);
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
                <div class="col-md-12">
                    <h2 class="page-title">Edit A Store</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Store Info
                                </div>
                                <?php
                                if ($error) { ?>  <div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?></div> <?php } else if ($msg) { ?> <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?></div> <?php }
                                ?>
                                <div class="panel-body">
                                    <?php
                                        $id = intval($_GET['id']);
                                        $sql = "SELECT * FROM tblStore WHERE id = :id";
                                        $query = $dbh->prepare($sql);
                                        $query->bindParam(':id', $id, PDO::PARAM_STR);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        if ($query->rowCount() > 0) {
                                            foreach($results as $result) { ?>
                                            <form method="post" class="form-horizontal">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Store Name<span style="color:red">*</span></label>
                                                    <div class="col-sm-6">
                                                        <input type="text" value="<?php echo htmlentities($result->name); ?>" required class="form-control" name="name">
                                                    </div>
                                                </div>
                                                <div class="hr-dashed"></div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Address<span style="color:red">*</span></label>
                                                    <div class="col-sm-6">
                                                        <textarea class="form-control" name="address" rows="3" required><?php echo htmlentities($result->address); ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">City<span style="color:red">*</span></label>
                                                    <div class="col-sm-6">
                                                        <input type="text" value="<?php echo htmlentities($result->city); ?>" required class="form-control" name="city">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Manager Name<span style="color:red">*</span></label>
                                                    <div class="col-sm-6">
                                                        <input type="text" value="<?php echo htmlentities($result->managerName); ?>" required class="form-control" name="manager">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-8 col-sm-offset-2">
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
    </div>
</body>
</html>
<?php
}
?>