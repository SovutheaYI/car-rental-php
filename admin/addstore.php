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
        $sql = "INSERT INTO tblStore(name, address, city, managerName) VALUES(:name, :address, :city, :manager)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':name', $storename, PDO::PARAM_STR);
        $query->bindParam(':address', $address, PDO::PARAM_STR);
        $query->bindParam(':city', $city, PDO::PARAM_STR);
        $query->bindParam(':manager', $manager, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            $msg = "Store posted successfully";
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

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <!-- Font Awesome -->
    <title>Admin | Add Store</title>
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
                <div class="col-sm-12">
                    <h2 class="page-title">Post A Store</h2>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Store Info
                                </div>
                                <?php
                                if ($msg) { ?>  <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?></div> <?php } else if ($error) { ?> <div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?></div> <?php }
                                ?>
                                <div class="panel-body">
                                    <form method="post" class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Store Name<span style="color:red">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" required class="form-control" name="name">
                                            </div>
                                        </div>
                                        <div class="hr-dashed"></div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Address<span style="color:red">*</span></label>
                                            <div class="col-sm-6">
                                                <textarea class="form-control" name="address" rows="3" required></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">City<span style="color:red">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" required class="form-control" name="city">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Manager Name<span style="color:red">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" required class="form-control" name="manager">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-8 col-sm-offset-2">
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
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 

</body>
</html>
<?php
}
?>