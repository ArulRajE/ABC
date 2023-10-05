<?php include ("header.php"); include ("topbar.php"); include ("menu.php"); 
$checkval = array($rows['id']); 
$qudata = 'select * from admin_login where id!=$1';
$result1= pg_query_params($db,$qudata,$checkval);


$checkval1 = array('1');
$sql = "SELECT \"STID\",\"STName\" FROM st2021 WHERE is_deleted=$1 ORDER BY \"STName\" ASC";
$sql_data= pg_query_params($db,$sql,$checkval1);
$sql_data_all= pg_fetch_all($sql_data);
?>
<!-- ============================================================== -->
<!-- Start Page Content here --> 
<!-- ============================================================== -->
<!-- modified by sahana to add download button cdn -->
<style type="text/css">
.dataTables_scrollBody {
    max-height: 550px !important;
}

/* modified by sahana to add download button styling */
.btn1 {
  background-color: #fe6271;
  border-radius: 2em;
  border: none;
  color: white;
  margin-left: 84%;
  padding: 8px;
 /* margin-top:2px; */
 /* margin-bottom:30px; */
  cursor: pointer;
  font-size: 15px;
}

/* Darker background on mouse-over */
.btn1:hover {
  background-color: #15bed2;
}

/* Custom style for admin type 1 */
.btn1.admin-type-1 {
    margin-left: 93%;
}

</style>

<!-- modified by sahana to export table data in excel for users -->
<script src="assets/js/xlsx.full.min.js"></script>
<script>
function export_data() {
    var export_table = document.getElementById('users-units-datatable');
    var headers = export_table.querySelectorAll('thead th.export');

    var export_table_filtered = document.createElement('table');
    var thead = document.createElement('thead');
    var tr = document.createElement('tr');

    for (var i = 0; i < headers.length; i++) {
        var th = document.createElement('th');
        th.textContent = headers[i].textContent;
        tr.appendChild(th);
    }

    thead.appendChild(tr);
    export_table_filtered.appendChild(thead);

    var tbody = document.createElement('tbody');
    var rows = export_table.querySelectorAll('tbody tr');

    for (var j = 0; j < rows.length; j++) {
        var filteredRow = document.createElement('tr');
        var cells = rows[j].querySelectorAll('td');

        for (var k = 0; k < headers.length; k++) {
            var td = document.createElement('td');
            td.textContent = cells[k].textContent;
            filteredRow.appendChild(td);
        }

        tbody.appendChild(filteredRow);
    }

    export_table_filtered.appendChild(tbody);

    var wb = XLSX.utils.table_to_book(export_table_filtered, { sheet: 'Users' });
    var wbout = XLSX.write(wb, { bookType: 'xlsx', type: 'base64' });

    var a = document.createElement('a');
    var today = new Date();
    var day = String(today.getDate()).padStart(2, '0');
    var month = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
    var year = today.getFullYear();
    var fname = 'Users_data_' + day + '-' + month + '-' + year + '.xlsx';

    a.href = 'data:application/octet-stream;base64,' + wbout;
    a.download = fname;
    a.click();
}

</script>




<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <?php  include("breadcrumbs.php"); ?>
            <!-- start page title -->

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">

<!-- modified by sahana to add download button -->
<?php if ($rows['admin_type'] == '0' || $rows['admin_type'] == '1' || $rows['admin_type'] == '2') { ?>
                    <button class="btn1 <?php if ($rows['admin_type'] == '1') { echo 'admin-type-1'; } ?>" type="submit" id="export_data" name='export_data' value="Export to excel" onclick="export_data()">
                        <i class="fa fa-download"></i> Download
                    </button>
                <?php } ?>

                            <?php if ($rows['admin_type'] != '1') { ?>
                            <div class="dropdown float-right">

                                <button class="btn btn-primary btn-rounded waves-effect waves-light" id="add_users"
                                    > <i class="fas fa-plus-circle mr-1"></i> <span>ADD USER</span>
                                </button>

                            </div>
                            <?php } ?>
                            <!-- code changed by veena -->
                            <h4 class="header-title mb-4"><span class="dropcap1 text-primary"></span></h4>



                            <table id="users-units-datatable" class="table table-striped table-bordered nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="export">Sr. No.</th>
                                        <th class="export">Login ID</th>
                                        <th class="export">Email</th>
                                        <th class="export">Designation</th> <!-- modified by sahana  -->
                                        <th class="export">User Type</th>                                      
                                        <th>Active</th>
                                        <th>Reset Password</th>
                                        <th>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown">
                                                    
                                                </a>
                                            </div>
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $i=0;
                                                while ($data = pg_fetch_array($result1)) { 
                                        
                                                 //    print_r($data);
                                                //  && $data['admin_type']!='3'
                                                
                                    if ($rows['admin_type'] == '0') {   $i=$i+1; ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $data['admin_name']; ?></td>
                                        <td><?php echo $data['admin_email']; ?></td>
                                        <td><?php echo $data['designation']; ?></td>  <!-- modified by sahana  -->
                                        <td><?php if($data['admin_type']=='2') {
                                            echo "DCO Admin";
                                        }
                                        else if($data['admin_type']=='0')
                                        {
                                            echo "ORGI Admin";
                                        }  
                                        else if($data['admin_type']=='3'){
                                            echo "DCO User";

                                        }
                                        else if($data['admin_type']=='1') {
                                            echo "ORGI User";
                                        }
                                        ?></td>                                 
                                        <td><input type="checkbox" class="swi"
                                                <?php if ($data['status']==1) { ?>checked<?php } ?>
                                                data-plugin="switchery" data-id="<?php echo $data['docids']; ?>"
                                                data-todo='<?php echo json_encode($data); ?>' data-color="#1AB394"
                                                data-secondary-color="#ED5565" /></td>

                                                <td class="btnresetpass" data-id="<?php echo $data['id']; ?>"
                                            data-todo='<?php echo json_encode($data); ?>'
                                            data-target="#resetcon-close-modal" data-backdrop="static"
                                            data-toggle="modal" style='cursor: pointer;'>
                                            <i data-id="<?php echo $data['id']; ?>" data-toggle="modal"
                                                data-target="#resetcon-close-modal"
                                                data-todo='<?php echo json_encode($data); ?>' data-toggle="tooltip"
                                                data-placement="top" title="" data-original-title="Reset Password"
                                                class='fas mdi mdi-lock-reset'
                                                style='font-size:24px; cursor: pointer; color: #fe6271!important'></i>
                                        </td>


                                        <td class="class2021">
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                                                    aria-expanded="true">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </a>
                                                <!-- <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="#" data-toggle="modal" data-target="#con-close-modal"
                                                            class="dropdown-item btnEditnew"
                                                            data-id="<?php echo $data['id']; ?>"
                                                            data-todo='<?php echo json_encode($data); ?>'>Update</a>
                                                    </li>
                                                    <li class="dropdown-divider"></li>
                                                    <li><a href="javascript:void(0);" id="<?php echo $data['id']; ?>"
                                                            class="dropdown-item deletetablerow">Delete</a></li>
                                                </ul> -->
                                            </div>
                                        </td>

                                    </tr>
                                    <?php } else if ($rows['admin_type'] == '1') {   
                                          if ($data['admin_type'] != '0') { $i=$i+1;?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $data['admin_name']; ?></td>
                                        <td><?php echo $data['admin_email']; ?></td>
                                        <td><?php echo $data['designation']; ?></td>  <!-- modified by sahana  -->
                                        <td><?php if($data['admin_type']=='2') {
                                            echo "DCO Admin";
                                        } 
                                        else if($data['admin_type']=='3'){
                                            echo "DCO User";

                                        }
                                        else if($data['admin_type']=='1') {
                                            echo "ORGI User";
                                        }
                                        ?></td>                                 
                                        <td><input type="checkbox" class="swi"
                                                <?php if ($data['status']==1) { ?>checked<?php } ?>
                                                data-plugin="switchery" data-id="<?php echo $data['docids']; ?>"
                                                data-todo='<?php echo json_encode($data); ?>' data-color="#1AB394"
                                                data-secondary-color="#ED5565" /></td>

                                                <td class="btnresetpass" data-id="<?php echo $data['id']; ?>"
                                            data-todo='<?php echo json_encode($data); ?>'
                                            data-target="#resetcon-close-modal" data-backdrop="static"
                                            data-toggle="modal" style='cursor: pointer;'>
                                            <i data-id="<?php echo $data['id']; ?>" data-toggle="modal"
                                                data-target="#resetcon-close-modal"
                                                data-todo='<?php echo json_encode($data); ?>' data-toggle="tooltip"
                                                data-placement="top" title="" data-original-title="Reset Password"
                                                class='fas mdi mdi-lock-reset'
                                                style='font-size:24px; cursor: pointer; color: #fe6271!important'></i>
                                        </td>


                                        <td class="class2021">
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                                                    aria-expanded="true">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <!-- <li><a href="#" data-toggle="modal" data-target="#con-close-modal"
                                                            class="dropdown-item btnEditnew"
                                                            data-id="<?php echo $data['id']; ?>"
                                                            data-todo='<?php echo json_encode($data); ?>'>Update</a>
                                                    </li> -->
                                                    <!-- <li class="dropdown-divider"></li> -->
                                                    <li><a href="javascript:void(0);" id="<?php echo $data['id']; ?>"
                                                            class="dropdown-item deletetablerow">Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>

                                    </tr>

                                   <?php }
                                   }
                                       else if($rows['assignlist']==$data['assign_state_id'])
                                    {  $i=$i+1; ?>
                                        <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $data['admin_name']; ?></td>
                                        <td><?php echo $data['admin_email']; ?></td>
                                        <td><?php echo $data['designation']; ?></td>  <!-- modified by sahana  -->
                                        <td><?php if($data['admin_type']=='2') {
                                            echo "DCO Admin";
                                        }
                                        else if($data['admin_type']=='0')
                                        {
                                            echo "ORGI Admin ";
                                        }  
                                        else if($data['admin_type']=='3'){
                                            echo "DCO User";

                                        }
                                        else {
                                            echo "ORGI User";
                                        }
                                        ?></td>
                                        <td><input type="checkbox" class="swi"
                                                <?php if ($data['status']==1) { ?>checked<?php } ?>
                                                data-plugin="switchery" data-id="<?php echo $data['docids']; ?>"
                                                data-todo='<?php echo json_encode($data); ?>' data-color="#1AB394"
                                                data-secondary-color="#ED5565" /></td>

                                                <td class="btnresetpass" data-id="<?php echo $data['id']; ?>"
                                            data-todo='<?php echo json_encode($data); ?>'
                                            data-target="#resetcon-close-modal" data-backdrop="static"
                                            data-toggle="modal" style='cursor: pointer;'>
                                            <i data-id="<?php echo $data['id']; ?>" data-toggle="modal"
                                                data-target="#resetcon-close-modal"
                                                data-todo='<?php echo json_encode($data); ?>' data-toggle="tooltip"
                                                data-placement="top" title="" data-original-title="Reset Password"
                                                class='fas mdi mdi-lock-reset'
                                                style='font-size:24px; cursor: pointer; color: #fe6271!important'></i>
                                        </td>


                                        <td class="class2021">
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                                                    aria-expanded="true">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <!-- <li><a href="#" data-toggle="modal" data-target="#con-close-modal"
                                                            class="dropdown-item btnEditnew"
                                                            data-id="<?php echo $data['id']; ?>"
                                                            data-todo='<?php echo json_encode($data); ?>'>Update</a>
                                                    </li> -->
                                                    <!-- <li class="dropdown-divider"></li> -->
                                                    <li><a href="javascript:void(0);" id="<?php echo $data['id']; ?>"
                                                            class="dropdown-item deletetablerow">Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>

                                    </tr> <?php } 
                                    
                                                ?>
                                    <?php } 
                                                ?>
                                </tbody>

                            </table>
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






<script type="text/javascript">
$('select').select2();
</script>
<script>
$('.showpass').hover(function() {
    $('#addpassword').attr('type', 'text');
}, function() {
    $('#addpassword').attr('type', 'password');
});

$('.showpass2').hover(function() {
    $('#ncpassword').attr('type', 'text');
}, function() {
    $('#ncpassword').attr('type', 'password');
});
//  reset password functionallt eye icon resolved by shashi** 
$('.showpass3').hover(function() {
    $('#cpassword').attr('type', 'text');
}, function() {
    $('#cpassword').attr('type', 'password');
});
 

$('.showpass1').hover(function() {
    $('#npassword').attr('type', 'text');
}, function() {
    $('#npassword').attr('type', 'password');
});

// $('.showpass2').hover(function() {
//     $('#nccpassword').attr('type', 'text');
// }, function() {
//     $('#nccpassword').attr('type', 'password');
// });



 window.Parsley.addValidator('uppercase', {
  requirementType: 'number',
  validateString: function(value, requirement) {
    var uppercases = value.match(/[A-Z]/g) || [];
    return uppercases.length >= requirement;
  },
  messages: {
    en: 'Your password must contain atleast (%s) uppercase letter.'
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
    en: 'Your password must contain atleast (%s) lowercase letter.'
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
    en: 'Your password must contain atleast (%s) number.'
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
    en: 'Your password must contain atleast (%s) special characters.'
  }
});

</script>