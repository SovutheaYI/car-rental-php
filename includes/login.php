<?php
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $sql = "SELECT emailId, Password, fullName FROM tblUser WHERE emailId = :email AND Password = :pw";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':pw', $password, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
        $_SESSION['login'] = $_POST['email'];
        $_SESSION['name'] = $results->name;
        $currentpage = $_SERVER['REQUEST_URI'];
        echo "<script type='text/javascript'> document.location = '$currentpage'; </script>";
    } else {
        echo "<script>alert('Invalid Details');</script>";
    }
}
?>


<div class="modal fade" id="loginform">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Login</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="login_wrap">
                        <div class="col-md-12 col-sm-6">
                            <form method="post">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" placeholder="Email*" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control" placeholder="Password*" required>
                                </div>
                                <div class="form-group checkbox">
                                    <input type="checkbox" id="remember">
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-block" name="login" style="background-color: #18bc9c; color: #fff;" value="Login">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center">
                <p>Don't have an account? <a href="#signupform" data-toggle="modal" data-dismiss="modal">Signup Here</a></p>
                <p><a href="#forgotpassword" data-toggle="modal" data-dismiss="modal">Forgot Password ?</a></p>
            </div>
        </div>
    </div>
</div>
