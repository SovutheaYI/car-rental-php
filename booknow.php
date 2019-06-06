<?php 
session_start();
include('includes/config.php');
if (isset($_POST['booknow'])) {
    $fromDate = $_POST['startDate'];
    $toDate = $_POST['endDate'];
    $msg = $_POST['message'];
    $user = $_SESSION['login'];
    $vehicleId = $_GET['vehicleId'];
    $pickup = $_POST['pickup'];
    $status = 0;
    $sql = "INSERT INTO tblBooking(vehicleId, email, fromDate, toDate, storeId, message) 
    VALUES(:vehicleId, :email, :fromDate, :toDate, :pickup, :msg)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $user, PDO::PARAM_STR);
    $query->bindParam(':vehicleId', $vehicleId, PDO::PARAM_STR);
    $query->bindParam(':fromDate', $fromDate, PDO::PARAM_STR);
    $query->bindParam(':toDate', $toDate, PDO::PARAM_STR);
    $query->bindParam(':msg', $msg, PDO::PARAM_STR);
    $query->bindParam(':pickup', $pickup, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();
    if ($lastInsertId) {
        echo "<script>alert('Booking successfull.');</script>";
    } else {
        echo "<script>alert('Something went wrong. Please try again');</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <div class="modal fade" id="bookingform">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Booking Info</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="login_wrap">
                            <div class="col-md-12 col-sm-6">
                                <form method="post">
                                    
                                    <button id="btn" class="btn btn-primary" style="margin-top: -30px; background-color: #18bc9c; border: none;">Choose Date</button>
                                    
                                    <div id="date"></div>
                                    
                                    <!-- <div class="input-group input-daterange">
                                        <input id="startDate" name="startDate" type="text" class="form-control" readonly="readonly">
                                        <span class="input-group-addon">to</span>
                                        <input id="endDate" name="endDate" type="text" class="form-control" readonly="readonly">
                                    </div> -->
                                    <br>
                                    
                                    <div class="form-group" style="margin-top: -10px;">
                                        <select name="pickup" id="" class="form-control" >
                                            <option value=""> Select </option>
                                            <?php 
                                                $ret= "SELECT id, name, address, city, managerName FROM tblStore";
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
                                    <div class="form-group">
                                        <textarea rows="4" class="form-control" name="message" placeholder="Message*" required></textarea>
                                    </div>
                                    <?php if ($_SESSION['login']) { ?>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-block" name="booknow" style="background-color: #18bc9c; color: #fff;" value="Book Now">
                                    </div>
                                    <?php } else { ?>
                                        <a href="#loginform" class="btn btn-xs uppercase" style="color: #fff;" data-toggle="modal" data-dismiss="modal">Login To Book</a>
                                    <?php } ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>


<!-- <script>
    var disableDates = [];
    var from = moment().subtract(10, 'days').toDate();
    var to = new Date();
    while (from <= to) {
        disableDates.push(new Date(from));
        from = moment(from).add(1, 'days').toDate();
    }
    console.log(disableDates);
</script> -->



<script>
    function getSubCategory(val) {
        $.ajax({
            type: "POST",
            url: "getdisabledates.php",
            data:'vehicleid=' + val,
            success: function(data) {
                $("#date").html(data);
                $("#btn").hide();
                $("#date").css("margin-top", "-46px");
            }
        });
    }
</script>


<script>
var el = document.getElementById('btn');
el.addEventListener('click', function() {
    return getSubCategory('<?php echo $vehicleId; ?>');
});
</script>

<!-- <script type="text/javascript">
    $(document).ready(function() {
        $('.input-daterange').datepicker();
        $('#startDate').click(function() {
            $(this).datepicker('hide');
            $('#endDate').focus()
        });
    });
</script> -->

<?php include('includes/login.php');
include('includes/signup.php'); ?>