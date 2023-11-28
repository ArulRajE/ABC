<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login | CMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Responsive bootstrap 4 admin template" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="image/logo1.jpg">

    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" type="text/css" />

<!-- "email-box" modified by sahana added styling to the forgot password -->
<style>
.email-box {
  border: 2px solid #045A3B;
  padding: 20px;
  font-size: 18px;
  line-height: 1.5;
  text-align: center;
  background-color: #f8f9fa;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
  margin: -4px;
}

.email-box a {
  color: #007bff;
  text-decoration: none;
  font-weight: bold;
}

</style>

</head>

<body class="authentication-page">

    <div class="account-pages my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">

                    <div class="card" id="login">

                        <div class="card-body p-4" id="">
                            <div class="text-center">
                                <h4 class="text-uppercase">Jurisdictional Changes</h4>
                            </div>
                            <div class="text-center">
                                <h6 class="text-uppercase">Office of The Registrar General <br>and Census Commissioner, India <br></h6><h6>Ministry of Home Affairs, Government of India</h6>
                            </div>
                            <div class="text-center pb-1">
                                
                                    <span><img src="image/logo1.jpg" alt="" height="120"></span>
                                
                                <!--     <h5 class="font-14 text-muted mt-3">Bootstrap 4 Responsive Admin Dashboard</h5> -->
                            </div>
                            <div class="text-center">
                                <h5 class="text-uppercase">Sign In</h5>
                            </div>
                            <div class="alert alert-success alert-dismissible alert-link" id="success_alert"
                                role="alert" style="display: none;">
                                <div id="success_alert_msg"></div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="alert alert-danger alert-dismissible alert-link" id="danger_alert" role="alert"
                                style="display: none;">
                                <div id="danger_alert_msg"></div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form class="p-2" data-parsley-validate novalidate data-parsley-trigger="keyup"
                                id="login_form">
                                <input type="hidden" name="formname" id="formname" value="login_data">
                                <div class="form-group mb-3">
                                    <input class="form-control" type="text" id="email" name="email"
                                        value="<?php if(isset($_COOKIE["member_login"])) { echo $_COOKIE["member_login"]; } ?>"
                                        placeholder="Enter Login ID " parsley-trigger="change" required>
                                </div>

                                <div class="form-group mb-3" style="position:relative;">
                                    <div style="z-index: 9999;text-align: end; margin: 0px 10px -30px 0px;">
                                        <i class="fas fa-eye showpass" style="cursor: pointer;"></i>
                                    </div>
                                    <input class="form-control" type="password" data-parsley-required="true"
                                        id="password" name="password"
                                        value="<?php if(isset($_COOKIE["member_login_pass"])) { echo $_COOKIE["member_login_pass"]; } ?>"
                                        data-parsley-minlength="13" data-parsley-maxlength="16" placeholder="Enter your password" required>

                                </div>

                                    <img src="assets/captcha.php" id='captchaCode'>
                                <div style="z-index: 9999;text-align: end; margin: -29.5px 10px -30px 0px;">
                                        <a href="javascript:void(0);" onclick="return getcpachanew();"  style="color:currentcolor;"><i  class="fas fa-redo-alt" style="cursor: pointer;"></i></a>
                                    </div>

                                  <div class="form-group mb-3" style="">
                                    
                                  
                                       
                                        <input name="captcha_code" autocomplete="off" data-parsley-minlength="6" data-parsley-maxlength="6" data-parsley-required="true" type="text"
                    class="demo-input captcha-input form-control" id="captcha_Code" data-parsley-capch="#capcha"
                                            data-parsley-trigger="keyup blur" required>
                                     


                                </div> 

                                <!-- <div class="form-group mb-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkbox-signin"
                                            name="checkbox-signup" <?php //if(isset($_COOKIE["member_login"])) { ?>
                                            checked <?php // } ?>>
                                        <label class="custom-control-label" for="checkbox-signin">Remember me</label>
                                    </div>
                                </div> -->

                                <div class="form-group mb-4">
                                    <button
                                        class="btn btn-primary btn-bordered-primary btn-block waves-effect waves-light"
                                        type="submit" name="submit"> Log In </button>
                                </div>
                                <a href="javascript:void(0)" id="fdiv" class="text-muted">
                                    <!-- modified by sahana changed styling -->
                                    <i class="mdi mdi-lock mr-1" style="padding-left: 107px"></i><b>Forgot your password?</b></a>

                            </form>


                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <!-- <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p>Don't have an account? <a href="pages-register.html" class="text-primary ml-1"><b>Sign Up</b></a></p>
                            </div>
                        </div> -->
                    <!-- end row -->

                    <!-- end col -->

                    <!-- forgot password div -->

                    <!--  <div class="col-md-8 col-lg-6 col-xl-5"> -->

                    <div class="card" style="display: none;" id="forgot">

                        <div class="card-body p-4">
                            <div class="text-center">
                                <h4 class="text-uppercase">Jurisdictional Changes</h4>
                            </div>
                            <div class="text-center">
                                <h6 class="text-uppercase">Office of The Registrar General <br>and Census Commissioner, India <br></h6><h6>Ministry of Home Affairs, Government of India</h6>
                            </div>
                            <div class="text-center pb-1">
                                
                                    <span><img src="image/logo1.jpg" alt="" height="120"></span>
                                
                                <!--     <h5 class="font-14 text-muted mt-3">Bootstrap 4 Responsive Admin Dashboard</h5> -->
                            </div>
                            <div class=" mb-4">
                                <div class="text-center">
                                    <h5 class="text-uppercase">Forgot Password</h5>
                                </div>

                                <div class="alert alert-success alert-dismissible alert-link" id="success_alert_for"
                                    role="alert" style="display: none;">
                                    <div id="success_alert_msg_for"></div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="alert alert-danger alert-dismissible alert-link" id="danger_alert_for"
                                    role="alert" style="display: none;">
                                    <div id="danger_alert_msg_for"></div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <!-- <p class="font-13">Enter your email address and we'll send you an email with
                                    instructions to reset your password. </p> -->

                                    <!-- "email-box" modified by sahana to contact Administrator message -->
                                    <p class="font-17" style="color:red;">Please contact Administrator to reset your password. </p>
                                </div>

                            <form class="p-2" data-parsley-validate novalidate data-parsley-trigger="keyup"
                                id="forgot_pass">
                                <input type="hidden" name="formname" id="formname" value="forgot_password_form">
                                <div class="form-group mb-3">
                                    <!-- <input class="form-control" type="email" parsley-trigger="change" id="email_forgot"
                                        name="email_forgot" required placeholder="Enter your email"> -->

                                        <!-- modifed by sahana to send email when clicked on the link -->
                                        <div class="email-box">
                                        Please click the following link to compose an email and send to <a href="https://mail.google.com/mail/?view=cm&to=admin%40gmail.com&su=Password%20Reset%20Request&body=Dear Administrator,%0D%0A%0D%0AI am writing to inform you that I have lost access to my account and I'm unable to log in to it. Due to which I request a password reset for my account on 'jurisdiction.census.gov.in'.%0D%0AI would be very grateful if you could reset my password and send it back to me at your earliest convenience.%0D%0A%0D%0APlease find below information you may require to process my password reset request:%0D%0AFull name: [ ]%0D%0ARegistered email address: [ ]%0D%0AA brief explanation of why you need to reset your password: [ ]%0D%0A%0D%0AThank you for your attention to this matter.%0D%0ABest regards, %0D%0A[Your Name]">Administrator</a> to reset your password
                                        </div>
                                        </div>

                                <!-- <div class="form-group mb-0">
                                    <button
                                        class="btn btn-primary btn-bordered-primary btn-block waves-effect waves-light"
                                        type="submit"> Reset Password </button>
                                </div> -->

                                <div class="row mt-3">
                                    <div class="col-12 text-center">
                                        <p>Back to <a href="javascript:void(0)" id="ldiv"
                                                class="text-primary ml-1"><b>Log in</b></a></p>
                                    </div> <!-- end col -->
                                </div>

                            </form>

                        </div> <!-- end card-body -->
                        <!-- </div> -->
                        <!-- end card -->


                        <!-- end row -->
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>

    <!-- end page -->
    <!-- Hide and Show div -->


    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>

    <script src="assets/libs/parsleyjs/parsley.min.js"></script>

    <!-- validation init -->
    <script src="assets/js/pages/form-validation.init.js"></script>

    <script src="assets/js/validation.js"></script>
    <script>
    $('.showpass').hover(function() {
        $('#password').attr('type', 'text');
    }, function() {
        $('#password').attr('type', 'password');
    });
    </script>
</body>

</html>