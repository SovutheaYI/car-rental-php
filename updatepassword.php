<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['login']) == 0) {
    header('location: index.php');
} else {
    if (isset($_POST['updatepassword'])) {
        $pw = md5($_POST['password']);
        $newpw = md5($_POST['newpassword']);
        $email = $_SESSION['login'];
        $sql = "SELECT Password FROM tblUser WHERE emailId = :email AND Password = :password";
        $query = $dbh->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $pw, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            $con = "UPDATE tblUser SET Password = :newpassword WHERE emailId = :email";
            $change = $dbh->prepare($con);
            $change->bindParam(':newpassword', $newpw, PDO::PARAM_STR);
            $change->bindParam(':email', $email, PDO::PARAM_STR);
            $change->execute();
            $msg = "Your Password succesfully changed";
        } else {
            $error_msg = "Your current password is wrong"; 
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
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <title>Update Password</title>
</head>
<body>

<!--Header-->
<?php include('includes/header.php');?>
<!-- /Header --> 


    <div class="page-heading">
        <h1>Your Profile</h1>
    </div>
    <ul class="coustom-breadcrumb">
        <li><a href="#">Home</a></li>
        <li>Profile</li>
    </ul>

<?php
$useremail = $_SESSION['login'];
$sql = "SELECT * FROM tblUser WHERE emailId = :useremail";
$query = $dbh->prepare($sql);
$query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$cnt = 1;
if ($query->rowCount() > 0) {
    foreach ($results as $result) { ?>
        <section class="container">
            <div class="">
                <h5><?php echo htmlentities($result->fullName);?></h5>
                <p><?php echo htmlentities($result->address);?><br>
                <?php echo htmlentities($result->city);?></p>
            </div>


            <form method="post" onSubmit="return valid();">
                <div style="color: red;">
                    <h2>Update Password</h2>
                </div>
                <?php if ($error_msg) {?> 
                <div class="alert alert-danger"><strong>ERROR</strong>:<?php echo htmlentities($error_msg); ?> </div><?php } 
                else if ($msg) { ?><div class="alert alert-success"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }}}?>
                <div class="form-group">
                    <label class="">Current Password</label>
                    <input class="form-control" id="password" name="password"  type="password" required />
                </div>
                <div class="form-group">
                    <label class="">Password</label>
                    <input class="form-control" id="newpassword" type="password" name="newpassword" required />
                </div>
                <div class="form-group">
                    <label class="">Confirm Password</label>
                    <input class="form-control" id="confirmpassword" type="password" name="confirmpassword"  required>
                </div>
                <div class="">
                    <input type="submit" value="Update" name="updatepassword" id="submit" class="btn" />
                </div>
                <br>
            </form>
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

<script type="text/javascript">
        function valid() {
            if (document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
                alert("New Password and Confirm Password Field do not match  !!");
                document.chngpwd.confirmpassword.focus();
                return false;
            }
            return true;
        }
</script>