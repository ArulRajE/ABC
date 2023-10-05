<?php include ("header.php"); include ("topbar.php"); include ("menu.php"); 
$result = pg_query($db, 'select * from "circulars"');
// echo "JIGAR".$total = pg_numrows($result);
?>
<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">
 
        <!-- Start Content-->
        <div class="container-fluid">

            <?php include("breadcrumbs.php"); ?>
            <!-- start page title -->

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- <div class="dropdown float-right">
                                     <button class="btn btn-primary btn-rounded waves-effect waves-light" data-toggle="modal" data-target="#con-close-modal-add"> <i class="fas fa-plus-circle mr-1"></i> <span>ADD</span> </button>
                                        
                                        </div> -->
                            <h4 class="header-title mb-4"><span class="dropcap1 text-primary"></span>
                            </h4>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div>
                                        <ul class="nav nav-tabs" role="tablist">

                                            <li class="nav-item">
                                                <a class="nav-link active" id="profile-tab" data-toggle="tab"
                                                    href="#profile" role="tab" aria-controls="profile"
                                                    aria-selected="true">
                                                    <span class="d-block d-sm-none"><i class="fa fa-user"></i></span>
                                                    <span class="d-none d-sm-block">Profile</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="message-tab" data-toggle="tab" href="#message"
                                                    role="tab" aria-controls="message" aria-selected="false">
                                                    <span class="d-block d-sm-none"><i
                                                            class="fa fa-envelope-o"></i></span>
                                                    <span class="d-none d-sm-block">Change Password</span>
                                                </a>
                                            </li>

                                        </ul>

                                        <div class="tab-content p-3 border border-top-0">

                                            <div class="tab-pane show active" id="profile" role="tabpanel"
                                                aria-labelledby="profile-tab">
                                                <form class="form-horizontal group-border-dashed" data-parsley-validate
                                                    novalidate data-parsley-trigger="keyup" id="profileupdate">
                                                    <input type="hidden" name="formname" id="formname"
                                                        value="profiledata">
                                                         <input type="hidden" name="idslogin_update" id="idslogin_update"
                                                        value="<?php echo $rows['id']; ?>">
                                                    <!-- <div class="modal-header bg-primary">
                                                        <h5 class="modal-title text-white">ADD STATE</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div> -->
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-xl-12">
                                                                <div>
                                                                <!-- Designation, Email and Officer's name  having same character length as in Add User added by Pavithra -->
                                                                <div class="form-group row">
                                                                        <label
                                                                            class="col-md-2 col-form-label">Officer's Name</label>
                                                                        <div class="col-md-10">
                                                                            <input type="text" class="form-control"
                                                                                name="admin_lname"
                                                                                data-parsley-pattern="^[a-zA-Z.\s]+$" 
                                                                                data-parsley-pattern-message="Officer's Name can contain only alphabets and spaces."
                                                                                data-parsley-minlength="3"
                                                                                data-parsley-maxlength="25"
                                                                                id="admin_lname" required
                                                                                placeholder="Enter Officer's Name" style="width:400px"
                                                                                value="<?php echo $rows['admin_lname']; ?>"
                                                                                 />
                                                                        </div>

                                                                    </div>
                                                                  
                                                                   <!-- modified by sahana to disabled email for dco admin -->
                                                                   <div class="form-group row">
                                                                        <label
                                                                            class="col-md-2 col-form-label">Email</label>
                                                                        <div class="col-md-10">
                                                                            <input type="text" class="form-control"
                                                                                name="admin_email"
                                                                                data-parsley-pattern="^[a-z](?:[a-z0-9_.-]*[a-z0-9])?@(?:nic|gov)\.in$"
                                                                                data-parsley-minlength="10"
                                                                                data-parsley-maxlength="50"
                                                                                data-parsley-pattern-message="Email ID is invalid"
                                                                               id="admin_email" <?php echo ($rows['admin_type'] == 2) ? 'readonly' : '';?> required
                                                                                placeholder="Enter Email" style="width: 400px"
                                                                                value="<?php echo $rows['admin_email']; ?>"/>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="form-group row">
                                                                        <label
                                                                            class="col-md-2 col-form-label">Mobile Number</label>
                                                                        <div class="col-md-10">
                                                                            <input type="number" class="form-control"
                                                                                name="admin_mobile"
                                                                                data-parsley-pattern="^[6-9][0-9]{9}$" data-parsley-pattern-message="Invalid Mobile Number  OR  Mobile Number length should be 10 digits"
                                                                                data-parsley-minlength="10"
                                                                                data-parsley-maxlength="10"
                                                                                id="admin_mobile" required
                                                                                placeholder="Enter Mobile Number" style="width: 400px"
                                                                                value="<?php echo $rows['admin_mobile']; ?>" onkeypress="return validate(event)"/>
                                                                                
                                                                        </div>
                                                                    
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label
                                                                            class="col-md-2 col-form-label">Designation</label>
                                                                        <div class="col-md-10">
                                                                            <input type="text" class="form-control"
                                                                                name="designation"
                                                                                data-parsley-pattern="^[^<>]+$"
                                                                                data-parsley-pattern-message="Invalid Designation"
                                                                                data-parsley-minlength="3"
                                                                                data-parsley-maxlength="25"
                                                                                id="designation" required
                                                                                placeholder="Enter your updated Designation" style="width: 400px"
                                                                                value="<?php echo $rows['designation']; ?>"/>
                                                                                 
                                                                        </div>

                                                                    </div>
                                                                   
                                                                    <div class="form-group row">
                                                                        <label class="col-md-2 col-form-label">
                                                                            Login ID</label>
                                                                        <div class="col-md-10">
                                                                            <input type="text" class="form-control"
                                                                                name="admin_fname"
                                                                                data-parsley-pattern="^[^<>;]+$" data-parsley-pattern-message="'<' OR '>' value seems to be invalid." 
                                                                                data-parsley-minlength="3"
                                                                                data-parsley-maxlength="30"
                                                                                id="admin_fname" required
                                                                                placeholder="First Name" style="width: 400px"
                                                                                value="<?php echo $rows['admin_name']; ?>" 
                                                                                readonly="readonly" disable="disable" />
                                                                        </div>

                                                                    </div>
                                                                   <!--  <div class="form-group row">
                                                                        <label class="col-md-2 col-form-label">Last
                                                                            Name</label>
                                                                        <div class="col-md-10">
                                                                            <input type="text" class="form-control"
                                                                                name="admin_lname"
                                                                                data-parsley-maxlength="20"
                                                                                id="admin_lname" required
                                                                                placeholder="Last Name"
                                                                                value="<?php // echo $rows['admin_lname']; ?>" />
                                                                        </div>

                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-md-2 col-form-label">Mobile
                                                                            No</label>
                                                                        <div class="col-md-10">
                                                                            <input type="text" class="form-control"
                                                                                name="admin_mobile"
                                                                                data-parsley-maxlength="10"
                                                                                data-parsley-minlength="10"
                                                                                onkeypress="return numbersOnly12(event)"
                                                                                id="admin_mobile" required
                                                                                placeholder="Mobile No"
                                                                                value="<?php // echo $rows['admin_mobile']; ?>" />
                                                                        </div>

                                                                    </div> -->


                                                                </div>
                                                            </div><!-- end col -->

                                                        </div>
                                                    </div>


                                                    <div class="modal-footer">

                                                        <button type="submit" name="submit"
                                                            class="btn btn-info waves-effect waves-light">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane" id="message" role="tabpanel"
                                                aria-labelledby="message-tab">
                                                <form class="form-horizontal group-border-dashed" data-parsley-validate
                                                    novalidate data-parsley-trigger="keyup" id="changepassword">
                                                    <input type="hidden" name="formname" id="formname"
                                                        value="changepassworddata">
                                                    <input type="hidden" name="idslogin" id="idslogin"
                                                        value="<?php echo $rows['id']; ?>">

                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-xl-12">
                                                                <div>

                                                                    <div class="form-group row">
                                                                        <label class="col-md-2 col-form-label">Current
                                                                            Password</label>
                                                                        <div class="col-md-10">

                                                                             <div style="z-index: 9999; margin: 0px 10px -30px 370px;">
                                        <i class="fas fa-eye showpassp" style="cursor: pointer;"></i>
                                    </div>
                                                                            <input type="password" class="form-control"
                                                                                name="oldpassword" style="width: 400px"
                                                                                data-parsley-length="[8, 16]"  
                                                                                data-parsley-uppercase="1"
                                                                                data-parsley-lowercase="1"
                                                                                data-parsley-number="1"
                                                                                data-parsley-special="1"
                                                                                id="oldpassword" required
                                                                                placeholder="Enter Current Password" />
                                                                        </div>

                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-md-2 col-form-label">New
                                                                            Password</label>

                                                                        <div class="col-md-10">
                                                                            <div style="z-index: 9999; margin: 0px 10px -30px 370px;">
                                        <i class="fas fa-eye showpassn" style="cursor: pointer;"></i>
                                    </div>
                                                                            <input type="password" class="form-control"
                                                                                required 
                                                                                name="newpassword" id="newpassword" style="width: 400px"
                                                                                data-parsley-length="[8, 16]"  
                                                                                data-parsley-uppercase="1"
                                                                                data-parsley-lowercase="1"
                                                                                data-parsley-number="1"
                                                                                data-parsley-special="1"
                                                                                placeholder="Enter New Password" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">

                                                                        <label class="col-md-2 col-form-label">Confirm
                                                                            Password </label>

                                                                        <div class="col-md-10">
                                                                            <div style="z-index: 9999; margin: 0px 10px -30px 370px;">
                                        <i class="fas fa-eye showpasscn" style="cursor: pointer;"></i>
                                    </div>
                                                                            <input type="password" class="form-control"
                                                                                name="cpassword" style="width: 400px"
                                                                                data-parsley-length="[8, 16]" 
                                                                                data-parsley-equalto="#newpassword"
                                                                                id="cpassword" required
                                                                                placeholder="Re-enter New Password" />
                                                                        </div>
                                                                    </div>



                                                                </div>
                                                            </div><!-- end col -->

                                                        </div>
                                                    </div>


                                                    <div class="modal-footer">
                                                    <button type="reset" name="submit" class="btn btn-info waves-effect waves-light">Clear</button>
                                                        <button type="submit" name="submit" class="btn btn-info waves-effect waves-light">Save</button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>

                                </div><!-- end col -->

                            </div>

                        </div>
                    </div>
                </div>
            </div>



        </div> <!-- end container-fluid -->

    </div> <!-- end content -->



    <!-- Footer Start -->
    <?php include ("footertext.php"); ?>
    <!-- end Footer -->

</div>

<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->

</div>

<?php // include ("rightsidebar.php"); ?>

<?php include ("footer.php"); ?>
<script>
    $('.showpassp').hover(function() {
        $('#oldpassword').attr('type', 'text');
    }, function() {
        $('#oldpassword').attr('type', 'password');
    });

     $('.showpassn').hover(function() {
        $('#newpassword').attr('type', 'text');
    }, function() {
        $('#newpassword').attr('type', 'password');
    });

      $('.showpasscn').hover(function() {
        $('#cpassword').attr('type', 'text');
    }, function() {
        $('#cpassword').attr('type', 'password');
    });


      window.Parsley.addValidator('uppercase', {
  requirementType: 'number',
  validateString: function(value, requirement) {
    var uppercases = value.match(/[A-Z]/g) || [];
    return uppercases.length >= requirement;
  },
  messages: {
    en: 'Your Password must contain at least (%s) uppercase letter.'
  }
});

//has lowercase
window.Parsley.addValidator('lowercase', {
  requirementType: 'number',
  validateString: function(value, requirement) {
    var lowecases = value.match(/[a-z]/g) || [];
    return lowecases.length >= requirement;
  },
  messages: {
    en: 'Your Password must contain at least (%s) lowercase letter.'
  }
});

//has number
window.Parsley.addValidator('number', {
  requirementType: 'number',
  validateString: function(value, requirement) {
    var numbers = value.match(/[0-9]/g) || [];
    return numbers.length >= requirement;
  },
  messages: {
    en: 'Your Password must contain at least (%s) number.'
  }
});

//has special char
window.Parsley.addValidator('special', {
  requirementType: 'number',
  validateString: function(value, requirement) {
    var specials = value.match(/[^a-zA-Z0-9]/g) || [];
    return specials.length >= requirement;
  },
  messages: {
    en: 'Your Password must contain atleast (%s) special characters.'
  }
});


    </script>

<!-- <script type="text/javascript">
$(function() {

    $('#districts_count_name').text(<?php //echo $dt; ?>);
    $('#sub_districts_count_name').text(<?php //echo $sd; ?>);
    $('#villages_count_name').text(<?php //echo $vt; ?>);
    $('#town_count_name').text(<?php //echo $ct; ?>);
    $('#wards_count_name').text(<?php //echo $wd; ?>);

});
</script> -->

<script>
//Function to allow only numbers to textbox modified by sahana
function validate(key)
{
//getting key code of pressed key
var keycode = (key.which) ? key.which : key.keyCode;
var phn = document.getElementById('admin_mobile');
//comparing pressed keycodes
if (!(keycode==8 || keycode==46)&&(keycode < 48 || keycode > 57))
{
return false;
}
else
{
//Condition to check textbox contains ten numbers or not
if (phn.value.length <10)
{
return true;
}
else
{
return false;
}
}
}
</script>