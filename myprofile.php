<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['login']) == 0) {
    header('location: index.php');
} else {
    if (isset($_POST['updateprofile'])) {
        $email = $_SESSION['login'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $dob = $_POST['dob'];
        $adress = $_POST['address'];
        $city = $_POST['city'];

        $sql = "UPDATE tblUser set fullName = :name, phoneNumber = :phone, dob = :dob, address = :adress, city = :city where emailId = :email";
        $query = $dbh->prepare($sql);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':phone', $phone, PDO::PARAM_STR);
        $query->bindParam(':dob', $dob, PDO::PARAM_STR);
        $query->bindParam(':adress', $adress, PDO::PARAM_STR);
        $query->bindParam(':city', $city, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();
        $msg = " Profile Updated Successfully";
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


    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
        $(function() {
        $('input[name="dob"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            maxYear: parseInt(moment().format('YYYY'),10)
        }, function(start, end, label) {
            var years = moment().diff(start, 'years');
            alert("You are " + years + " years old!");
        });
        });
    </script>
    <title>Car Rental Service | My Profile</title>
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
    $userEmail = $_SESSION['login'];
    $sql = "SELECT * from tblUser WHERE emailId = :email";
    $query = $dbh -> prepare($sql);
    $query->bindParam(':email', $userEmail, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    $i = 1;

    
    if ($query->rowCount() > 0) {
        foreach ($results as $result) { ?>

            <div class="container">
                <div>
                    <h4><?php echo htmlentities($result->fullName); ?></h4>
                    <p><?php echo htmlentities($result->address); ?><br>
                    <?php echo htmlentities($result->city); ?></p>
                </div>
    
                <div style="color: red;">
                    <h2>Profile Setting</h2>
                </div>
    
                <?php  
                if ($msg) {?> <div class="alert alert-success" role="alert"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
    
    
                <form method="post">
                    <div class="">
                        <label class="">Reg Date -</label>
                        <?php echo htmlentities($result->regDate); ?>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="">Full Name</label>
                        <input class="form-control" name="name" value="<?php echo htmlentities($result->fullName);?>" id="fullname" type="text" required />
                    </div>
                    <div class="form-group">
                        <label class="">Email Address</label>
                        <input class="form-control" value="<?php echo htmlentities($result->emailId); ?>" name="emailid" id="email" type="email" required readonly />
                    </div>
                    <div class="form-group">
                        <label class="">Phone Number</label>
                        <input class="form-control" name="phone" value="<?php echo htmlentities($result->phoneNumber);?>" id="phone-number" type="text" required />
                    </div>
                    <div class="form-group">
                        <label class="">Date of Birth&nbsp;(dd/mm/yyyy)</label>
                        <input class="form-control" value="<?php echo htmlentities($result->dob);?>" name="dob" placeholder="dd/mm/yyyy" id="birth-date" type="text" >
                    </div>
                    <div class="form-group">
                        <label class="">Your Address</label>
                        <textarea class="form-control" name="address" rows="4" ><?php echo htmlentities($result->address);?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="">City</label>
                        <input class="form-control"  id="city" name="city" value="<?php echo htmlentities($result->city);?>" type="text">
                    </div>
                
                
    <?php
            }
        }
    ?>
                    <div class="">
                        <button type="submit" name="updateprofile" class="btn">Save Changes <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></button>
                    </div>
                    <br>
                </form>

            </div>
<?php
include('includes/footer.php');
include('includes/about.php');
include('includes/services.php');
include('includes/contactus.php');
?>


<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

</body>
</html>