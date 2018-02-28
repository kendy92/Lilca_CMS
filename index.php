<?php
    session_start();
    if(isset($_SESSION['login_status'])){
        header("Location: cms_panel.php");
    }

    if(isset($_POST["btnSubmit"])){
        require "system.php";
        $cms = new LILCA_CMS();
        $cms->connectDB();
        $email = mysqli_real_escape_string($cms->conn, trim($_POST['email']));
        $password = mysqli_real_escape_string($cms->conn, trim($_POST['password']));
        $cms->closeDB();
        $check_user = $cms->authentication($email, md5($password),$cms->tbl_user);
        if($check_user == true){
            $_SESSION['login_status'] = "Success";
            header("Location: cms_panel.php");
        }else{
            echo "<div class='alert alert-danger' role='alert'>Authentication failed!</div>";
        }
    }
?>
<!doctype html>
<html>
<?php include("meta/header.php"); ?>
    <body>
        <main>
            <div class="container login-page">
                <h1><i class="fa fa-user-secret" aria-hidden="true"></i> &nbsp;LOGIN PORTAL</h1>
                <form id="loginFrm" method="post" action="index.php">
                  <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter email">
                  </div>
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                  </div>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input">
                      Check me out
                    </label>
                  </div>
                  <button type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-default">Submit</button>
                </form>
            </div>
        </main>
        <footer id="footer">
            <p>Powered By LilcaSoft <?php echo Date("Y"); ?></p>
        </footer>
    </body>
</html>
