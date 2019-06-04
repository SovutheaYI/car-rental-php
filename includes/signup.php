<?php
if (isset($_POST['signup'])) {
    $sql = "INSERT INTO tblUser(fullName, Password, emailId, city, phoneNumber) VALUES(:fName, :pw, :email, :city, :phone)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':fName', $_POST['name'], PDO::PARAM_STR);
    $query->bindParam(':pw', md5($_POST['password']), PDO::PARAM_STR);
    $query->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
    $query->bindParam(':city', $_POST['city'], PDO::PARAM_STR);
    $query->bindParam(':phone', $_POST['phone'], PDO::PARAM_STR);
    $query->execute();
    $newId = $dbh->lastInsertId();

    if ($newId) {
        echo '<script language="javascript">';
        echo 'alert("message successfully sent")';
        echo '</script>';
    } else {
        echo '<script language="javascript">';
        echo 'alert("Error")';
        echo '</script>';
    }
}
?>

<script>
    function checkAvailability() {
        $("#loadIcon").show();
        jQuery.ajax({
            url: "checkavailable.php",
            data:'email='+$("#email").val(),
            type: "POST",
            success: function(data) {
                $("#user-availability-status").html(data);
                $("#loadIcon").hide();
            },
            error: function() {}
        });
    }
</script>

<script type="text/javascript">
    function valid() {
        if (document.signup.password.value != document.signup.confirmpassword.value) {
            document.getElementById("user-availability-status").innerHTML = "Password does not match each other";
            document.signup.confirmpassword.focus();
            return false;
        }
        return true;
    }
</script>

<div class="modal fade" id="signupform">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Sign Up</h3>
                <span style="color: red;" id="user-availability-status"></span>
                <span id="loadIcon"></span>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="signup_wrap">
                        <div class="col-md-12 col-sm-6">
                            <form method="post" onSubmit="return valid();">
                                <div class="form-group">
                                    <input type="text" required name="name" placeholder="Name*" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="email" required name="email" id="email" placeholder="Email*" class="form-control" onblur="checkAvailability();">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="phone" required placeholder="Mobile*" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" placeholder="Password*" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="confirmpassword" placeholder="Confirm Password*" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <select name="city" class="form-control" id="" required>
                                        <option value="">City*</option>
                                        <option value="Phnom Penh">Phnom Penh</option>
                                        <option value="Kompong Som">Kompong Som</option>
                                        <option value="Siem Reap">Siem Reap</option>
                                        <option value="Kratie">Kratie</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="submit" id="submit" style="background-color: #18bc9c; color: #fff;" class="btn btn-block" name="signup" value="Signup">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center">
                <p>Already have an account? <a href="#loginform" data-toggle="modal" data-dismiss="modal">Login Here</a></p>
            </div>
        </div>
    </div>
</div>