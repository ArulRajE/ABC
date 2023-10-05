<?php include ("header.php"); include ("topbar.php"); include ("menu.php"); 
//modified by sahana to fetch dates from db
$sql = "SELECT to_char(importantdate, 'dd-mm-yyyy') AS importantdatenew, 
               to_char(previousdate, 'dd-mm-yyyy') AS previousimportantdate, 
               to_char(documentdate, 'dd-mm-yyyy') AS documentimportantdatenew
        FROM importantdate
        WHERE impdate_year='".$_SESSION['activeyears']."'";

$sql_qu = pg_query($db,$sql);
$sql_qu_data = pg_fetch_array($sql_qu);



?>

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

                          
                            <h4 class="header-title mb-4"><span class="dropcap1 text-primary">Important Dates</span>
                            </h4>

                            <form enctype="multipart/form-data" class="form-horizontal group-border-dashed parsley-examples"
                id="saveimportantdate">

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Previous Census Freezing Date</label>
                               <div class="col-md-9">
                                                                    <input disabled <?php if($header==2) { ?> disabled <?php } ?> type="text" name="ipreviousdate" class="form-control" id="ipreviousdate" placeholder="dd/mm/yyyy" data-provide="datepicker" value="<?php echo $sql_qu_data['previousimportantdate']; ?>" style="width: 25%;"   data-date-orientation="bottom left">
                                                                 
                                                                </div><!-- input-group -->
                            </div>

                        </div><!-- end col -->

                    </div>
                    <!-- modified by sahana to Current Census Freezing Date -->
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Current Census Freezing Date</label>
                               <div class="col-md-9">
                                                                    <input <?php if($header==2 || $header==3 || $header==1) { ?> disabled <?php } ?> type="text" name="idate" class="form-control" id="idate" placeholder="dd/mm/yyyy" data-provide="datepicker" value="<?php echo $sql_qu_data['importantdatenew']; ?>" style="width: 25%;"   data-date-orientation="bottom left" readonly>
                                                                 
                                                                </div><!-- input-group -->
                            </div>

                        </div><!-- end col -->

                    </div>
                    <!-- modified by sahana to Document Freezing Date -->
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Work Finished Date (DCO)</label>
                               <div class="col-md-9">
                                    <input  disabled<?php if($header==2) { ?> disabled <?php } ?> type="text" name="idocumentdate" class="form-control" id="idocumentdate" placeholder="dd/mm/yyyy" data-provide="datepicker" value="<?php echo $sql_qu_data['documentimportantdatenew']; ?>" style="width: 25%;"   data-date-orientation="bottom left">
                                                                 
                                </div>
                            </div>

                        </div>

                    </div>
         	<?php if($header==0) { ?>
                    <button type="submit" name="submit" class="btn btn-info waves-effect waves-light" style="float: right;">Save</button>
              <?php } ?>
            </form>

                    
                            
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

<!-- modified by sahana to freez important date -->

<script>
$(function() {
    $('#ipreviousdate').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: 'TRUE',
        autoclose: true,
        constrainInput: false,
        startDate: '+0d',
        orientation: "bottom left",
    });

    $('#idate').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: 'TRUE',
        autoclose: true,
        constrainInput: false,
        startDate: '+0d',
        orientation: "bottom left",
    });

    $('#idocumentdate').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: 'TRUE',
        autoclose: true,
        constrainInput: false,
        startDate: '+0d',
        orientation: "bottom left",
    });

    var previousDate = $('#idate').val(); // Set the initial value of previous date to the value of "Current Census Freezing Date" field

    $('#idate').on('change', function() {
        var currentDate = $(this).val(); // Get the new value of "Current Census Freezing Date" field
        // $('#ipreviousdate').val(previousDate); // Set the value of "Previous Census Freezing Date" field to the previous value of "Current Census Freezing Date" field
        // previousDate = currentDate; // Update the previous date variable to be the new value of "Current Census Freezing Date" field

        // Set the value of "Document Freezing Date" field to one month after the new value of "Current Census Freezing Date" field
        var newDate = moment(currentDate, 'DD-MM-YYYY');
        var documentdate = moment(newDate).add(1, 'months');
        var documentDateFormatted = documentdate.format('DD-MM-YYYY');
        $('#idocumentdate').val(documentDateFormatted);
    });
});

$('select').select2();
</script>