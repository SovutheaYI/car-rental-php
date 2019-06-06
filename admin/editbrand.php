<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['adminlogin']) == 0) {
    header('location: index.php');
} else {
    if (isset($_POST['submit'])) {
        $brandname = $_POST['brand'];
        $id = $_GET['id'];
        $sql = "UPDATE tblBrand SET brandName = :brand WHERE id = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':brand', $brandname, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin | Edit Brand</title>
    <!--Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
    <link href="assets/css/slick.css" rel="stylesheet">
    <link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/fileinput.min.css" rel="stylesheet">
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
                    <h2 class="page-title">Create Brand</h2>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="panel panel-default">
                                <div class="panel-heading">Form fields</div>
                                <div class="panel-body">
                                    <form method="post" class="form-horizontal" onSubmit="return valid();">
                                    <?php
                                    if ($error) { ?>  <div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?></div> <?php } else if ($msg) { ?> <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?></div> <?php }
                                    ?>
                                    <?php
                                    $id = $_GET['id'];
                                    $sql = "SELECT * FROM tblBrand WHERE id = :id";
                                    $query = $dbh->prepare($sql);
                                    $query->bindParam(':id', $id, PDO::PARAM_STR);
                                    $query->execute();
                                    $results = $query -> fetchAll(PDO::FETCH_OBJ);
                                    $i = 1;
                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $result) { ?>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Brand Name</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" value="<?php echo htmlentities($result->brandName);?>" name="brand" id="brand" required>
                                                </div>
                                            </div>
                                            <div class="hr-dashed"></div>
                                    <?php
                                        }
                                    }
                                    ?>
                                        <div class="form-group">
                                            <div class="col-sm-8 col-sm-offset-4">
                                                <button class="btn btn-primary" name="submit" type="submit">Submit</button>
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
</body>
</html>
<?php
}
?>