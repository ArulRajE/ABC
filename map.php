<?php include ("header.php"); include ("topbar.php"); include ("menu.php");
?>



<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <?php // include("breadcrumbs.php"); ?>
            <!-- start page title -->

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title"> View Map</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <?php   //include("box.php"); ?>
            <!-- end row -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                           
                                <div class="form-group row">

                            
                                    <iframe src="https://map.census.gov.in/portal/apps/dashboards/10136e1510204abcaebf17fbd0498887" style="overflow:hidden;height:700px;width:100%" height="100%" width="100%"></iframe>

                              

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

<script type="text/javascript">

selected = $("#STID").find(':selected').text().trim();
$('#reportlable').html(selected);


$('select').select2({
    maximumInputLength: 20 // only allow terms up to 20 characters long
});
    <?php if($header==2) { ?>
 if($('#STID').val()!='')
 {
 var pcatable1 = $("#ReportPCA-Village-datatable").DataTable({

        

            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "scrollX": "100%",
            "pageLength": 50,
            "scrollY": "550px",
            "processing": true,
            "serverSide": true,
            "bServerSide": true, 
            "bDestroy": true,
         //   "oLanguage": {"sProcessing": "<div class='modal-backdrop fade show'><div class='spinner-border text-primary mt-2 mr-2 lod' role='status'></div></div>"},
            "ajax": {

                "url": "insert_data.php",
                "type": "POST",
                "data": function (d) {
                    d.formname = "getreportPCA";
                    d.stids = $('#STID').val();
                    d.dtids = $('#DTID').val();
                    d.sdids = $('#SDID').val();
                }
            },
            'order': [[0, 'asc'],[2, 'asc'],[4, 'asc'],[6, 'asc']],
     });
}
<?php } ?>
</script>