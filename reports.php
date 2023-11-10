<?php include ("header.php"); include ("topbar.php"); include ("menu.php");

$yearl = $_SESSION['activeyears'];

$where = "";
$where1 = "";
$table = "";

if($header!=0 && $rows['assignlist']!=null)   
{
// $where = ' AND  "STID" in ('.$rows['assignlist'].')';
    $a1=array('1',$rows['assignlist']);
$resultstate = pg_query_params($db, 'select "STID","STName" from "st'.$_SESSION['activeyears'].'" where "is_deleted"=$1   AND  "STID" in ($2) ORDER BY "STID" ASC',$a1);
$row = pg_fetch_all($resultstate); 

$resultDT = pg_query_params($db, 'select "DTID","DTName" from "dt'.$_SESSION['activeyears'].'" where "is_deleted"=$1 AND  "STID" in ($2)  ORDER BY "DTID" ASC',$a1);
$rowDT = pg_fetch_all($resultDT); 
}
else {
    $a1=array('1');
$resultstate = pg_query_params($db, 'select "STID","STName" from "st'.$_SESSION['activeyears'].'" where "is_deleted"=$1 ORDER BY "STID" ASC',$a1);
$row = pg_fetch_all($resultstate); 

$resultDT = pg_query_params($db, 'select "DTID","DTName" from "dt'.$_SESSION['activeyears'].'" where "is_deleted"=$1 ORDER BY "DTID" ASC',$a1);
$rowDT = pg_fetch_all($resultDT); 
}



// $result = pg_query($db,'select * from concordance2021');

 
if(pg_numrows($result)>0) { 

    ?>
<style type="text/css">
.dataTables_scrollBody {
    max-height: 550px !important;
}
</style>
<!-- modified by sahana to add download button cdn -->

<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
<style type="text/css">
.dataTables_scrollBody {
    max-height: 550px !important;
}

/* modified by sahana to add download button styling */
.btn {
  background-color: #fe6271;
  border: none;
  color: white;
 margin-left: 92%;
 margin-top:2px;
 margin-bottom:30px;
  cursor: pointer;
  font-size: 15px;
}

/* Darker background on mouse-over */
.btn:hover {
  background-color: #15bed2;
  color: black;
}
</style>
<?php } ?>

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
                        <h4 class="page-title"> Concordance Reports</h4>
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
                            <form class="form-horizontal group-border-dashed" data-parsley-validate novalidate
                                data-parsley-trigger="keyup" id="searchpcavt">
                                <input type="hidden" name="formname" id="formname" value="searchdata">

                                <!-- <input type="hidden" name="STIDNAME" id="STIDNAME" value="">
                    <input type="hidden" name="DTIDNAME" id="DTIDNAME" value="">
                    <input type="hidden" name="SDIDNAME" id="SDIDNAME" value=""> -->

                                <div class="form-group row">

                                    <!-- <div class="col-md-3 mt-3">
                                         <!-- <select onchange="return reportfilterst(this,'ST');" id="STID"
                                            name="STID">
                                            <select onchange="return reportfilterst(this.value,'stselect','ST');" id="STID"
                                            name="STID">
                                            <?php if (in_array($header, array(0, 1, 2, 3))) { ?>
                                            <option value="">Select State / UT Name</option>
                                            <?php } ?>
                                            <?php foreach ($row as $key => $element) { ?>
                                            <option value="<?php echo $element['STID']; ?>"
                                                <?php if($element['STID']==$rows['assignlist']) { ?>
                                                Selected="Selected" <?php } ?>>
                                                <?php echo $element['STName']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div> -->

                                    <!-- pagination issue Gowthami-->
                                    <div class=" col-md-12 col-form-label row">
                                 <div class="col-md-3 mt-3"> <select onchange="return reportfilterst(this.value,'stselect','ST');" id="STID"
                                            name="STID">
                                            <?php if (in_array($header, array(0, 1, 2, 3))) { ?>
                                            <option value="">Select State / UT Name</option>
                                            <?php } ?>
                                            <?php foreach ($row as $key => $element) { ?>
                                            <option value="<?php echo $element['STID']; ?>"
    >
                                                <?php echo $element['STName']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-3 mt-3">
                                        <!-- <select id="DTID"
                                         name="DTID" onchange="return reportfilterst(this,'DT');">
                                           <option value="">Select District Name</option>
                                            -->
                                            <select id="DTID"
                                         name="DTID" onchange="return reportfilterst(this.value,'dtselect','DT');">
                                           <option value="">Select District Name</option>

                                             <?php /* foreach ($rowDT as $key => $element) { ?>
                                            <option value="<?php echo $element['DTID']; ?>">
                                                <?php echo $element['DTName']; ?></option>
                                            <?php } */ ?>

                                        </select>

                                    </div>

                             
                                  
                                    <div class="col-md-3 mt-3">
                                        <!-- <select  id="SDID"
                                            name="SDID" onchange="return reportfilterst(this,'SD');"> -->
                                            <select  id="SDID"
                                            name="SDID" onchange="return reportfilterst(this.value,'sdselect','SD');">
                                            <option value="">Select Sub-District Name</option>
                                            
                                        </select>

                                    </div>


                                    <div class="col-md-3 mt-2">
                                        <!--  <button
                                            class="btn btn-primary btn-rounded waves-effect waves-light" disabled="disabled" id="Searchreport">
                                            <i
                                        class="fas fa-search mr-1"></i><span>Search</span> </button> -->
                                        <?php if($header==2) { ?>
                                        <!-- <a href="exportcsvvillage.php?stids=<?php //echo $_SESSION['logindetails']['assignlist']; ?>"
                                            class="btn btn-primary btn-rounded waves-effect waves-light exportdataid1"
                                            id="exportdataid1"><i class="fas fa-file-export mr-1"></i>
                                            <span>Export</span></a> -->
                                        <?php } else { ?>
                                       <!--  <a href="exportcsvvillage.php?<?php //echo $_SERVER['QUERY_STRING'];?>"
                                            class="btn btn-primary btn-rounded waves-effect waves-light"
                                            id="exportdataid"><i class="fas fa-file-export mr-1"></i>
                                            <span>Export</span></a> -->
                                        <?php } ?>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                     

                    <div class="card ">
                        <div class="card-body">

                            <h4 class="header-title mb-4">
                                <span class="dropcap text-primary">Census Year
                                    <?php echo $_SESSION['activeyears'] ?></span>

                                <!-- <span id="reportlable">All States</span> -->

                            </h4>
                            <!-- modified by sahana to add download button  -->
                     <button class="btn" type="submit" id="export_data" name='export_data' value="Export to excel" onclick="export_data()" ><i class="fa fa-download"></i> Download</button>

                            <table id="ReportPCA-Village-datatable"
                                class="table table-striped table-bordered "
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="10" style="background-color: #fe6271; color: #FFFFFF">Census <?php echo $_SESSION['logindetails']['baseyear']; ?></th>
                                        <th colspan="10" style="background-color: #15bed2; color: #FFFFFF ">
                                           Census <?php echo $_SESSION['activeyears']; ?></th>

                                    </tr>
                                    <tr>
                                        <th>State / UT MDDS <?php echo $_SESSION['logindetails']['baseyear']; ?></th>
                                        <th>State / UT Name <?php echo $_SESSION['logindetails']['baseyear']; ?></th>
                                        <th>District MDDS <?php echo $_SESSION['logindetails']['baseyear']; ?></th>
                                        <th>District Name <?php echo $_SESSION['logindetails']['baseyear']; ?></th>
                                        <th>Sub-District MDDS <?php echo $_SESSION['logindetails']['baseyear']; ?></th>
                                        <th>Sub-District Name <?php echo $_SESSION['logindetails']['baseyear']; ?></th>
                                        <th>Village / Town MDDS <?php echo $_SESSION['logindetails']['baseyear']; ?></th>
                                        <th>Village / Town Name <?php echo $_SESSION['logindetails']['baseyear']; ?></th>
                                        <th>Village / Town Level <?php echo $_SESSION['logindetails']['baseyear']; ?></th>
                                        <th>Village / Town Status <?php echo $_SESSION['logindetails']['baseyear']; ?></th> <!-- modified by sahana to add status column in Concordance Reports -->


                                        <th>State / UT MDDS <?php echo $_SESSION['activeyears']; ?></th>
                                        <th>State / UT Name <?php echo $_SESSION['activeyears']; ?></th>
                                        <th>District MDDS <?php echo $_SESSION['activeyears']; ?></th>
                                        <th>District Name <?php echo $_SESSION['activeyears']; ?></th>
                                        <th>Sub-District MDDS <?php echo $_SESSION['activeyears']; ?></th>
                                        <th>Sub-District Name <?php echo $_SESSION['activeyears']; ?></th>
                                        <th>Village / Town MDDS <?php echo $_SESSION['activeyears']; ?></th>
                                        <th>Village / Town Name <?php echo $_SESSION['activeyears']; ?></th>
                                        <th>Village / Town Level <?php echo $_SESSION['activeyears']; ?></th>
                                        <th>Village / Town Status <?php echo $_SESSION['activeyears']; ?></th>   <!-- modified by sahana to add status column in Concordance Reports -->
                                        <!-- <th>Remarks</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>



        </div> <!-- end container-fluid -->

    </div> <!-- end content -->

<!-- modified by sahana to export table data in excel for forread -->
<script src="assets/js/xlsx.full.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js" integrity="sha512-r22gChDnGvBylk90+2e/ycr3RVrDi8DIOkIGNhJlKfuyQM4tIRAI062MaV8sfjQKYVGjOBaZBOA87z+IhZE9DA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->

<script>

function export_data() {
    var export_table = document.getElementById('ReportPCA-Village-datatable');
    var lastThElement = export_table.querySelector('thead tr:last-child th:last-child');
    // lastThElement.parentNode.removeChild(lastThElement);
    var wb = XLSX.utils.table_to_book(export_table, {sheet:'Concordance'});
    var wbout = XLSX.write(wb, {bookType:'xlsx', type: 'base64'});
    var today = new Date();
    var day = String(today.getDate()).padStart(2, '0');
    var month = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var year = today.getFullYear();
    var stateSelect = document.getElementById('STID');
    var stateName = stateSelect.options[stateSelect.selectedIndex].text;
    var stateId = stateSelect.value;
    var fname = 'Concordance_' + stateName + '_' + day + '-' + month + '-' + year + '.xlsx';
    var file = base64toBlob(wbout);
    saveAs(file, fname);
}


function base64toBlob(s) {
    var b64 = atob(s), len = b64.length, u8arr = new Uint8Array(len);
    while (len--) {
        u8arr[len] = b64.charCodeAt(len);
    }
    return new Blob([u8arr], { type: 'application/octet-stream' });
}
</script>

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
    <?php if($header==2 || $header==3) { ?>
 if($('#STID').val()!='')
 {

    reportfilterst($('#STID').val());
 
}
<?php } ?>
</script>