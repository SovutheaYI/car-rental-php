<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['adminlogin']) == 0) {
    header('location: index.php');
} else {
    if (isset($_REQUEST['del'])) {
        $id = $_GET['del'];
        $sql = "DELETE FROM tblBrand WHERE id = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        $msg = "Brand record deleted successfully";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin | Manage Brand</title>
    <!--Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <!-- Font Awesome -->
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
                    <h2 class="page-title">Manage Brands</h2>
                    <div class="panel panel-default">
                        <div class="panel-heading">Listed Brands</div>
                        <div class="panel-body">
                            <?php
                                if ($error) { ?>  <div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?></div> <?php } else if ($msg) { ?> <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?></div> <?php }
                            ?>
                            <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Brand Name</th>
                                        <th>Creation Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM tblBrand";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $i = 1;
                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $result) { ?>
                                            <tr>
                                                <td><?php echo htmlentities($i); ?></td>
                                                <td><?php echo htmlentities($result->brandName); ?></td>
                                                <td><?php echo htmlentities($result->createDate); ?></td>
                                                <td><a href="editbrand.php?id=<?php echo $result->id;?>"><i style="color: green;" class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                                    <a href="managebrand.php?del=<?php echo $result->id;?>" onclick="return confirm('Do you want to delete');"><i class="fa fa-times"></i></a></td>
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