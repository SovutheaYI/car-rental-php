<?php
if (isset($_POST['update'])) {
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $newpw = md5($_POST['newpassword']);

    $sql ="SELECT emailId FROM tblUser WHERE EmailId = :email AND phoneNumber = :phone";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':email', $email, PDO::PARAM_STR);
    $query-> bindParam(':phone', $phone, PDO::PARAM_STR);
    $query-> execute();
    $results = $query -> fetchAll(PDO::FETCH_OBJ);
    if($query -> rowCount() > 0) {
        $con = "UPDATE tblUser SET Password = :newpw WHERE emailId = :email AND phoneNumber = :phone";
        $chngpwd1 = $dbh->prepare($con);
        $chngpwd1-> bindParam(':email', $email, PDO::PARAM_STR);
        $chngpwd1-> bindParam(':phone', $phone, PDO::PARAM_STR);
        $chngpwd1-> bindParam(':newpw', $newpw, PDO::PARAM_STR);
        $chngpwd1->execute();
        echo "<script>alert('Your Password succesfully changed');</script>";
    } else {
        echo "<script>alert('Email id or Mobile no is invalid');</script>";
    }
}
?>

<script>
    function valid() {
        if (document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
            alert("New Password and Confirm Password Field do not match  !!");
            document.chngpwd.confirmpassword.focus();
            return false;
        } return true;
    }
</script>

<div id="forgotform">
    <h3 class="modal-title">Password Recovery</h3>
    <form method="post" name="changepw" onsubmit="return valid();">
        <div>
            <input type="email" name="email" class="" placeholder="Email Address *" required="" />
        </div>
        <div>
            <input type="text" name="phone" class="" placeholder="Phone Number *" required="" />
        </div>
        <div>
            <input type="password" name="newpassword" class="" placeholder="Password *" required="" />
        </div>
        <div>
            <input type="password" name="confirmpassword" class="" placeholder="Confirm Password" required="" />
        </div>
        <div>
            <input type="submit" name="update" value="Reset My Password" class="" />
        </div>
    </form>
    <div class="text-center">
        <p class="gray_text">For security reasons we don't store your password. Your password will be reset and a new one will be send.</p>
        <p><a href="#loginform" data-toggle="modal" data-dismiss="modal"><i class="fa fa-angle-double-left" aria-hidden="true"></i> Back to Login</a></p>
    </div>
</div>