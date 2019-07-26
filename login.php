

<!DOCTYPE html>

<html lang="en">

<head>
    <title>Login V18</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->


</head>

<div class="php"> 
<?php
include "cookies.php";
if ($_GET['action'] == "logout"){
    resetCookies();
}
?>

</div>

<body style="background-color: #666666;">

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-form">
                    <!-- FORM IS SUBMITTED THROUGH MAIN.JS FIRST AND HANDLED BY AUTH.PHP FOR AJAX AND ASYNCHRONOUS PROCESSING-->
                    <form class=" validate-form">
                        <span class="login100-form-title p-b-43 loginTitle">
                            Login to continue
                        </span>
                        <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                            <input class="input100" type="text" name="username">
                            <span class="focus-input100"></span>
                            <span class="label-input100">Username</span>
                        </div>
                        <div class="wrap-input100 validate-input" data-validate="Password is required">
                            <input class="input100" type="password" name="password">
                            <span class="focus-input100"></span>
                            <span class="label-input100">Password</span>
                        </div>
                        <div style="display: none" class="wrap-input100 validate-input emailInput" data-validate="Valid email is required: ex@abc.xyz">
                            <input class="input100" type="text" name="email">
                            <span class="focus-input100"></span>
                            <span class="label-input100">Email</span>
                        </div>
                        <div style="display: none" class="wrap-input100 validate-input nameInput" data-validate="Password is required">
                            <input class="input100" type="text" name="name">
                            <span class="focus-input100"></span>
                            <span class="label-input100">Name</span>
                        </div>
                        <div style="display: none" class="wrap-input100 validate-input phoneInput" data-validate="Password is required">
                            <input class="input100" type="text" name="phone">
                            <span class="focus-input100"></span>
                            <span class="label-input100">Phone</span>
                        </div>

                        <input class="toggleInput" name="toggle" type="hidden" value="login">

                        <div class="flex-sb-m w-full p-t-3 p-b-32 rmbInput">
                            <div class="contact100-form-checkbox">
                                <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
                                <label class="label-checkbox100" for="ckb1">
                                    Remember me
                                </label>
                            </div>

                            <div>
                                <button class="txt1 forgotpwInput">
                                    Forgot Password?
                                </button>
                            </div>
                        </div>


                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn buttonInput">
                                Login
                            </button>
                        </div>


                    </form>
                    <div class="text-center p-t-46 p-b-20">
                        <span class="txt2">
                            or <button class="toggle" style="text-decoration: underline; cursor:pointer!important;">sign up</button> using
                        </span>
                    </div>

                    <div class="login100-form-social flex-c-m">
                        <a href="#" class="login100-form-social-item flex-c-m bg1 m-r-5">
                            <i class="fa fa-facebook-f" aria-hidden="true"></i>
                        </a>

                        <a href="#" class="login100-form-social-item flex-c-m bg2 m-r-5">
                            <i class="fa fa-twitter" aria-hidden="true"></i>
                        </a>
                    </div>

                </div>

                <div class="login100-more" style="background-color:#ffecea; text-align: center;">
                    <img src="images/bf-03.jpg">
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

    <!--===============================================================================================-->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/daterangepicker/moment.min.js"></script>
    <script src="vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->
    <script src="js/main.js"></script>

</body>

</html>