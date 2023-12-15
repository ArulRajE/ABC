<?php include ("header.php"); include ("topbar.php"); include ("menu.php");
 $where = ""; 
$action = "";

if($header!=0 && $rows['assignlist']!=null)  
{
    $action = explode(',',$rows['assignlist']);
    // $where = 'where "stCount2021"."STID2021" in ('.$rows['assignlist'].')';
    $a1=array('1',$rows['assignlist']);
    $resultstate = pg_query_params($db, 'select "STID","STName" from "st'.$_SESSION['activeyears'].'" where "is_deleted"=$1  AND  "STID" in ($2) ORDER BY "STID" ASC',$a1);
$row = pg_fetch_all($resultstate); 

$resultDT = pg_query_params($db, 'select "DTID","DTName" from "dt'.$_SESSION['activeyears'].'" where "is_deleted"=$1 AND  "STID" in ($2)  ORDER BY "DTID" ASC',$a1);
$rowDT = pg_fetch_all($resultDT); 

}
else
{
    $a1=array('1');
   $resultstate = pg_query_params($db, 'select "STID","STName" from "st'.$_SESSION['activeyears'].'" where "is_deleted"=$1 ORDER BY "STID" ASC',$a1);
$row = pg_fetch_all($resultstate); 

$resultDT = pg_query_params($db, 'select "DTID","DTName" from "dt'.$_SESSION['activeyears'].'" where "is_deleted"=$1 ORDER BY "DTID" ASC',$a1);
$rowDT = pg_fetch_all($resultDT); 

}


// $resultstate = pg_query($db, 'select "STID","STName" from "st'.$_SESSION['activeyears'].'" where "is_deleted"=1  '.$where.' ORDER BY "STID" ASC');
// $row = pg_fetch_all($resultstate); 

// $resultDT = pg_query($db, 'select "DTID","DTName" from "dt'.$_SESSION['activeyears'].'" where "is_deleted"=1 '.$where.'  ORDER BY "DTID" ASC');
// $rowDT = pg_fetch_all($resultDT); 



?>
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
            
                           
                                 <!-- <div class=" col-md-12 col-form-label row">
                                 <div class="col-md-3 mt-3">
                                      <select onchange="return get_filter_new(this.value,'stselect','ST');" id="STID"
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

                                    <!-- pagination issue Gowthami -->
                                    <div class=" col-md-12 col-form-label row">
                                 <div class="col-md-3 mt-3">
                                      <select onchange="return get_filter_new(this.value,'stselect','ST');" id="STID"
                                            name="STID">
                                            <?php if (in_array($header, array(0, 1, 2, 3))) { ?>
                                            <option value="" >Select State / UT Name</option>
                                            <?php } ?>
                                            <?php foreach ($row as $key => $element) { ?>
                                                <option value="<?php echo $element['STID']; ?>">
                                          <?php echo $element['STName']; ?>
                                          </option>
                                            <?php } ?>
                                        </select>
                                    </div> 
                                    
                                    <div class="col-md-3 mt-3">
                                        <select id="DTID" name="DTID"
                                            onchange="return get_filter_new(this.value,'dtselect','DT');">
                                            <option value="">Select District Name</option>
                                          

                                        </select>

                                    </div>
                                  
                                    <div class="col-md-3 mt-3">
                                        <select  id="SDID"
                                            name="SDID" onchange="return get_filter_new(this.value,'sdselect','SD');">
                                            <option value="">Select Sub-District Name</option>
                                            
                                        </select>

                                    </div>

                                </div>
                        </div>
                            
                    </div>
                </div>
            </div>
              <!-- Forread Table fileds view-->
            <!-- <div class="row" id="ttable" style="display: none;"> -->
            <div class="row" id="ttable" style="display: block;">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-4"><span class="dropcap text-primary">Census Year
                                    <?php echo $_SESSION['activeyears'] ?></span>
                                For-Read : <?php echo $_SESSION['logindetails']['baseyear']; ?> - <?php echo  $_SESSION['activeyears']; ?></h4>

                            <!-- modified by sahana to add download button  -->
                            <button class="btn" type="submit" id="export_data" name='export_data' value="Export to excel" onclick="export_data()" ><i class="fa fa-download"></i> Download</button>
                               
                            <table id="ttable-datatable" class="table table-striped table-bordered"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                               
                                <thead>
                                    <tr>
                                        <th colspan="14" style="background-color: #fe6271; color: #FFFFFF">For - <?php echo $_SESSION['logindetails']['baseyear']; ?></th>
                                        <th colspan="17" style="background-color: #15bed2; color: #FFFFFF ">
                                            Read - <?php echo $_SESSION['activeyears']; ?></th>

                                    </tr>
                                   
                                    <tr>
                                        <th style="display: none;">STID</th>
                                        <th>State / UT MDDS Code</th>
                                        <th>State / UT Name</th>
                                        <th>State / UT  Status </th>
                                        <th style="display: none;">DTID</th>
                                        <th>District MDDS Code</th>
                                        <th>District Name</th>
                                        <th style="display: none;">SDID</th>
                                        <th>Sub-District MDDS Code</th>
                                        <th>Sub-District Name</th>
                                        <th>Village / Town MDDS Code</th>
                                        <th>Village / Town Name</th>
                                        <th>Village / Town Level</th>
                                        <th>Village / Town Status</th>
                                        <th style="display: none;">VTID</th>

                                        <th class="class2021" style="display: none;">STID</th>
                                        <th class="class2021">State / UT MDDS Code</th>
                                        <th class="class2021">State / UT Name</th>
                                        <th class="class2021">State / UT Status</th>
                                        <th class="class2021" style="display: none;">DTID</th>
                                        <th class="class2021">District MDDS Code</th>
                                        <th class="class2021">District Name</th>
                                        <th class="class2021" style="display: none;">SDID</th>
                                        <th class="class2021">Sub-District MDDS Code</th>
                                        <th class="class2021">Sub-District Name</th>
                                        <th class="class2021">Village / Town MDDS Code</th>
                                        <th class="class2021">Village / Town Name</th>
                                        <th class="class2021">Village / Town Level</th>
                                        <th class="class2021">Village / Town Status</th>
                                        <th class="class2021" style="display: none;">VTID</th>
                                        <th class="class2021">Remarks</th>
                                    

                                        
                                    </tr>
                                  
                                </thead>
                                

                            </table>
                        </div>
                    </div>
                </div>
            </div>
<!-- modified by sahana to export table data in excel for forread -->
<script src="assets/js/xlsx.full.min.js"></script>

<script>

// function export_data() {
//     var export_table = document.getElementById('ttable-datatable');
//     var lastThElement = export_table.querySelector('thead tr:last-child th:last-child');
//     lastThElement.parentNode.removeChild(lastThElement);
//     var wb = XLSX.utils.table_to_book(export_table, {sheet:'For Read'});
//     var wbout = XLSX.write(wb, {bookType:'xlsx', type: 'base64'});
//     var today = new Date();
//     var day = String(today.getDate()).padStart(2, '0');
//     var month = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
//     var year = today.getFullYear();
//     var stateSelect = document.getElementById('STID');
//     var stateName = stateSelect.options[stateSelect.selectedIndex].text;
//     var stateId = stateSelect.value;
//     var fname = 'forread_' + stateName + '_' + day + '-' + month + '-' + year + '.xlsx';
//     var file = base64toBlob(wbout);
//     saveAs(file, fname);
// }


// function base64toBlob(s) {
//     var b64 = atob(s), len = b64.length, u8arr = new Uint8Array(len);
//     while (len--) {
//         u8arr[len] = b64.charCodeAt(len);
//     }
//     return new Blob([u8arr], { type: 'application/octet-stream' });
// }

function export_data() {
    var export_table = document.getElementById('ttable-datatable');
    var columnNames = [
        'State / UT MDDS Code 2011',
        'State / UT Name 2011',
        'District MDDS Code 2011',
        'District Name 2011',
        'Sub-District MDDS Code 2011',
        'Sub-District Name 2011',
        'Village / Town MDDS Code 2011',
        'Village / Town Name 2011',
        'Village / Town Level 2011',
        'Village / Town Status 2011',
        'State / UT MDDS Code 2021',
        'State / UT Name 2021',
        'District MDDS Code 2021',
        'District Name 2021',
        'Sub-District MDDS Code 2021',
        'Sub-District Name 2021',
        'Village / Town MDDS Code 2021',
        'Village / Town Name 2021',
        'Village / Town Level 2021',
        'Village / Town Status 2021'
    ];
    var jsonData = tableToJson(export_table, columnNames);
    var wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, XLSX.utils.json_to_sheet(jsonData), 'For Read');
    var wbout = XLSX.write(wb, { bookType: 'xlsx', type: 'base64' });
    var today = new Date();
    var day = String(today.getDate()).padStart(2, '0');
    var month = String(today.getMonth() + 1).padStart(2, '0'); 
    var year = today.getFullYear();
    var stateSelect = document.getElementById('STID');
    var stateName = stateSelect.options[stateSelect.selectedIndex].text;
    var stateId = stateSelect.value;
    var fname = 'forread_' + stateName + '_' + day + '-' + month + '-' + year + '.xlsx';
    var file = base64toBlob(wbout);
    saveAs(file, fname);
}

function tableToJson(table, columnNames) {
    var data = [];
    if (table && table.rows && table.rows.length > 0) {
        for (var i = 2; i < table.rows.length; i++) {
            var rowData = {};
            for (var j = 0; j < table.rows[i].cells.length && j < columnNames.length; j++) {
                var cell = table.rows[i].cells[j];
                var columnName = columnNames[j];
                if (cell) {
                    rowData[columnName] = cell.textContent.trim();
                }
            }
            data.push(rowData);
        }
    }

    return data;
}

function base64toBlob(s) {
    var b64 = atob(s), len = b64.length, u8arr = new Uint8Array(len);
    while (len--) {
        u8arr[len] = b64.charCodeAt(len);
    }
    return new Blob([u8arr], { type: 'application/octet-stream' });
}
</script>




        </div> <!-- end container-fluid -->

    </div> <!-- end content -->
</div>



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
$('select').select2({
    maximumInputLength: 20 // only allow terms up to 20 characters long
});

    <?php if($header==2 || $header==3) { ?>
//  alert($('#STID').val());
 if($('#STID').val()!='')
 {
// alert($('#STID').val());
    get_filter_new($('#STID').val(),'stselect','ST');
 
}
<?php } ?>

</script>
