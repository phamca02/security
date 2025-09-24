<?php
ini_set('session.save_handler', 'redis');
ini_set('session.save_path', 'tcp://vagrant_redis_1:6379');
session_start();

require_once 'models/UserModel.php';
$userModel = new UserModel();

$message = '';

if (!empty($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = $userModel->auth($username, $password);

    if ($user) {
        // Login successful
        $_SESSION['id'] = $user[0]['id'];
        $_SESSION['message'] = 'Login successful';

        // Tạo dữ liệu để lưu localStorage
        $userData = [
            'id' => $user[0]['id'],
            'username' => $username
        ];

        // Chuyển hướng nhưng gửi dữ liệu localStorage qua JS
        echo "<script>
                localStorage.setItem('user', '" . json_encode($userData) . "');
                window.location.href='list_users.php';
              </script>";
        exit;
    } else {
        // Login failed
        $message = 'Login failed';
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>User form</title>
    <?php include 'views/meta.php' ?>
</head>

<body>
    <?php include 'views/header.php' ?>

    <div class="container">
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">Login</div>
                    <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">Forgot password?</a></div>
                </div>

                <div style="padding-top:30px" class="panel-body">
                    <?php if ($message) echo "<p style='color:red;'>$message</p>"; ?>
                    <form method="post" class="form-horizontal" role="form">

                        <div class="margin-bottom-25 input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="login-username" type="text" class="form-control" name="username" placeholder="username or email">

                        </div>

                        <div class="margin-bottom-25 input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="login-password" type="password" class="form-control" name="password" placeholder="password">
                        </div>

                        <div class="margin-bottom-25">
                            <input type="checkbox" tabindex="3" class="" name="remember" id="remember">
                            <label for="remember"> Remember Me</label>
                        </div>

                        <div class="margin-bottom-25 input-group">
                            <div class="col-sm-12 controls">
                                <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 control">
                                Don't have an account!
                                <a href="form_user.php">Sign Up Here</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>