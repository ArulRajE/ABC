<?php include ("header.php"); include ("topbar.php"); include ("menu.php"); 
$where = '';
$action = "";




if($header!=0 && $rows['assignlist']!=null)   
{
// $where = ' AND  "STID" in ('.$rows['assignlist'].')';
        $array = array('1',$rows['assignlist']);
$query = 'select "STID","STName" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 AND  "STID" in ($2) order by "STID" ASC';
$resultstatelk = pg_query_params($db, $query,$array);
$array2 = array('0',$rows['assignlist']);
     $qu = 'select *,"STName","Short_ST",(select sum(doc_reuse)  from "documentdata2021" as "bbb" where "bbb"."docids"="documentdata2021"."docids"
  OR "bbb"."link_docids"="documentdata2021"."docids") as totalreuse,(select array_to_string(array_agg("AAA"."docnotification"),\',\') AS alldocnoti from "documentdata'.$_SESSION['activeyears'].'" AS "AAA" where "AAA".
"link_docids"="documentdata2021"."docids"), freezed from "documentdata'.$_SESSION['activeyears'].'" LEFT JOIN "st'.$_SESSION['activeyears'].'" ON "documentdata'.$_SESSION['activeyears'].'"."docstid"="st'.$_SESSION['activeyears'].'"."STID"  '.$action.' Where "documentdata'.$_SESSION['activeyears'].'"."link_docids" =$1 AND  "STID" in ($2) ORDER BY docids DESC';
$result = pg_query_params($db,$qu,$array2 );
}
else {
    $array1 = array('1');
    $query = 'select "STID","STName" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 order by "STID" ASC';
    $resultstatelk = pg_query_params($db, $query,$array1);
$array2 = array('0');
     $qu = 'select *,"STName","Short_ST",(select sum(doc_reuse)  from "documentdata2021" as "bbb" where "bbb"."docids"="documentdata2021"."docids"
  OR "bbb"."link_docids"="documentdata2021"."docids") as totalreuse,(select array_to_string(array_agg("AAA"."docnotification"),\',\') AS alldocnoti from "documentdata'.$_SESSION['activeyears'].'" AS "AAA" where "AAA".
"link_docids"="documentdata2021"."docids"), freezed from "documentdata'.$_SESSION['activeyears'].'" LEFT JOIN "st'.$_SESSION['activeyears'].'" ON "documentdata'.$_SESSION['activeyears'].'"."docstid"="st'.$_SESSION['activeyears'].'"."STID"  '.$action.' Where "documentdata'.$_SESSION['activeyears'].'"."link_docids" =$1  ORDER BY docids DESC';
$result = pg_query_params($db,$qu,$array2 );

}




// $query = 'select "STID","STName" from "st'.$_SESSION['activeyears'].'" where is_deleted=1 '.$where.' order by "STID" ASC';


//  $resultstatelk = pg_query($db, $query);
 $row = pg_fetch_all($resultstatelk); 

?>
<style type="text/css">
.dataTables_scrollBody {
    max-height: 550px !important;
}
</style>

<!-- modified by sahana to freez document styling  -->
<style>
  .switch-container {
    display: inline-block;
    vertical-align: middle;
    margin-left: 10px;
  }

  .switch {
    position: relative;
    display: inline-block;
    width: 40px;
    height: 20px;
  }

  .switch input[type="checkbox"] {
    opacity: 0;
    width: 0;
    height: 0;
  }

  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.4s;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 14px;
    width: 14px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: 0.4s;
  }

  input[type="checkbox"]:checked + .slider {
    background-color: green;
  }

  input[type="checkbox"]:checked + .slider:before {
    transform: translateX(20px);
  }

  /* Style the slider round knob */
  .slider:before {
    border-radius: 50%;
  }

  .slided {
    /* Add your desired CSS styling properties here */
    background-color: red;
}

/* SR No 14 By sahana */
.btn.btn-danger.btn-rounded.waves-effect.waves-light.width-xl.disbut1 {
      position: #FDDA0D;
      background-color: #FDDA0D;
      color: black;
    }

.btn.btn-danger.btn-rounded.waves-effect.waves-light.width-xl.disbut1::before {
    content: '\26A0';
    font-size: 20px;
    color: black; 
    background-color: #FDDA0D;
    position: absolute;
    top: 10px;
    right: 8px;
}
</style>



<!-- // Include the xlsx library by adding the following script tag to your HTML: -->
<script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
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

                            <div class="dropdown float-right">
                               <!--  <button class="btn btn-primary btn-rounded waves-effect waves-light" data-toggle="modal"
                                    data-target="#con-close-modal-add" data-backdrop="static" data-keyboard="false"> <i
                                        class="fas fa-plus-circle mr-1"></i> <span>ADD DOCUMENT</span> </button> -->

                                 <a href="adddocument" class="btn btn-primary btn-rounded waves-effect waves-light" style="border: 0.3px solid transparent;padding: 0.1rem 1.2rem;"><i
                                        class="fas fa-plus-circle mr-1"></i> <span>ADD DOCUMENT</span></a>       

                            </div>
                            <h4 class="header-title mb-4"><span class="dropcap1 text-primary">Census Documents</span>
                            </h4>



                            <table id="documents-units-datatable" class="table table-striped table-bordered nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <!--  <tr>
                                                    <th colspan="7" style="background-color: #fe6271; color: #FFFFFF">Administrative Units Information - 2011</th>
                                                     <th colspan="8" style="background-color: #15bed2; color: #FFFFFF ">Administrative Units Information - 2021</th>
                                                    
                                                </tr> -->
                                    <tr>
                                        
                                        <th>Sr. No.</th>
                                        <th>State / UT <br> Code</th>
                                        <th>State / UT Name</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Document No.</th>
                                        <th>Description</th>
                                        <th>Document Status</th>
                                        <th>Link Document</th>
                                        <th>Reuse Document</th>
                                        <th>Action</th>
                                        <th>Freeze</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                            $flag=0;
                                                while ($data = pg_fetch_array($result)) {
                                                
                                                       $filedata = explode('|',$data['docnotification']);
                                                       $filedata1 = explode(',',$data['alldocnoti']);

                                                       if(count($filedata1)>0 && $filedata1[0]!='')
                                                       {
                                                         $filedata =array_merge($filedata,$filedata1);
                                                       }
                                                       $flag=$flag+1;

                                                        //  SR No. 14 By sahana 
                                                        $docids = $data['docids'];
                                                        $query = "SELECT docids, docstatus FROM documentdata2021 WHERE link_docids = $1";
                                                        $stmt = pg_prepare($db, " ", $query);
                                                        $hello = pg_execute($db, " ", array($docids));
                                                        $world = pg_fetch_all($hello);
                                                    ?>

                                    <tr>
                                        <td><?php echo $flag; ?></td>
                                        <td><?php echo $data['Short_ST']; ?></td>
                                        <td><?php echo $data['STName']; ?></td>
                                       <!-- modified by sahana for display Others specified type for normal document -->
                                       <td><?php echo ($data['doctype'] === 'Others') ? 'Others: <span style="font-weight:bold;color:#1C39BB;;">' . $data['doctypeother'] . '</span>' : $data['doctype']; ?></td>
                                        <td><?php echo date("d-m-Y",strtotime($data['docdate'])); ?></td>
                                        <td><?php echo htmlspecialchars($data['doctitle']); ?></td>
                                        
                                        <td class="wrap"><?php echo htmlspecialchars($data['docdescription']); ?></td>
                                        <!-- SR No. 14 By sahana  -->
                                        <td><?php if($data['docstatus']==0) {  
                                                    if( $data['created_by']==$_SESSION['login_email']) { ?>
                                                        <span class="badge badge-purple" data-id="<?php echo $data['docids']; ?>" onclick="return getselecteddocumentredirect(<?php echo $data['docids']; ?>,'comefromdoc','');" >Pending - Only Document Uploaded</span>
                                                    <?php } else {  ?>
                                                        <span class="badge badge-purple" data-id="<?php echo $data['docids']; ?>" style="cursor: not-allowed;">Pending - Only Document Uploaded</span>
                                                <?php } } else if($data['docstatus']==2){ ?>
                                            <span class="badge badge-warning" style="cursor: not-allowed">Partially Incomplete</span>
                                        <?php } else { ?>
                                           <span class="badge badge-success" style="cursor: not-allowed">Completed</span>

                                       <?php } ?></td>
                                       <!-- modified by sahana when freezed other function should not proceed further action  -->
                                        <td>
                                            <?php 
                                            if($data['freezed']==0) {
                                                if($data['docstatus']==1) { ?>
                                                    <select onchange="return linkeddocument(this,<?php echo $data['docids']; ?>,'comefromdocadd');" id="linkeddocument_doc" name="linkeddocument_doc">
                                                        <option value="">Select Document Type</option>
                                                        <option value="Resolution">Resolution</option>
                                                        <option value="Clarification">Clarification</option>
                                                        <option value="Collector Letter">Collector Letter</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                <?php } else { ?>
                                                    -
                                                <?php }
                                            } else { ?>
                                                <select disabled >
                                                <option value="">Select Document Type</option>
                                            </select>
                                            <?php  }
                                            ?>
                                        </td>

                                        <td class="classcolor wrap">

                                            <?php  
                                            if($data['freezed']==0){
                                            if($data['docstatus']==1){   
                                                // SR No. 14 By sahana 
                                                if($world[0]['docstatus']==2) { ?> 
                                                <button type="button" onclick="return getdoc_list(<?php echo $data['docids']; ?>,<?php echo $data['docstid']; ?>)" name="reuse" class="btn btn-danger btn-rounded waves-effect waves-light width-xl disbut1" id="reuse">Reused (<?php echo $data['totalreuse']; ?>) & Total Document (<?php echo count($filedata); ?>)</button>
                                                <?php } else { ?>
                                                    <button type="button" onclick="return getdoc_list(<?php echo $data['docids']; ?>,<?php echo $data['docstid']; ?>)" name="reuse" class="btn btn-danger btn-rounded waves-effect waves-light width-xl disbut" id="reuse" style="background-color: #5D6D7E">Reused (<?php echo $data['totalreuse']; ?>) & Total Document (<?php echo count($filedata); ?>)</button>
                                                <?php } } else { echo " - ";  } 
                                            }
                                            else {?>
                                                <button type="button" onclick="return getdoc_list(<?php echo $data['docids']; ?>,<?php echo $data['docstid']; ?>)" name="reuse" class="btn btn-danger btn-rounded waves-effect waves-light width-xl disbut" id="reuse" style="background-color: #5D6D7E">Reused (<?php echo $data['totalreuse']; ?>) & Total Document (<?php echo count($filedata); ?>)</button>
                                                <?php  }
                                            
                                            ?>
                                        </td>

                                        <td class="class2021">
                                       
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                                                    aria-expanded="true">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                <?php   if($data['freezed']==0){  ?>
                                                    <li><a href="javascript:void(0);" id="<?php echo $data['docids']; ?>" class="dropdown-item <?php if ($data['docstatus'] == 0) { if( $data['created_by']==$_SESSION['login_email']) { ?>deletetablerow<?php } } ?>" style="cursor: <?php echo ($data['docstatus'] == 0 && $data['created_by']==$_SESSION['login_email']) ? 'pointer' : 'not-allowed'; ?>">Delete</a></li>                        
                                                    <!-- <li><a href="javascript:void(0);" onclick="downloadTableData('<?php echo $data['docids']; ?>');" class="dropdown-item">Download</a></li> -->
                                                <?php   }  else { ?>
                                                    <li><a href="javascript:void(0);" class="dropdown-item" style="cursor:not-allowed">Delete</a></li>                          
                                                    <!-- <li><a href="javascript:void(0);" class="dropdown-item" style="cursor:not-allowed">Download</a></li> -->
                                                <?php } ?>
                                                </ul>
                                            </div>
                                           
                                        </td>
                                        <!-- modified by sahana to freez  -->
                                        <td>
                                            <?php 
                                            if ($data['docstatus'] == 1) {
                                                if ($data['freezed'] == 1) { ?>
                                                    <div class="switch-container">
                                                        <label class="switch">
                                                            <input type="checkbox" class="freez-switch" data-docids="<?php echo $data['docids']; ?>" data-freezed="<?php echo $data['freezed']; ?>">
                                                            <span class="slider"></span>
                                                        </label>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="switch-container">   
                                                        <label class="switch">
                                                            <input type="checkbox" class="freez-switch" data-docids="<?php echo $data['docids']; ?>">
                                                            <span class="slider"></span>
                                                        </label>
                                                    </div>
                                                <?php  
                                                } 
                                            } else {
                                                echo "-";
                                            }
                                        }
                                            ?>
                                        </td>

                                </tr>
                            </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>



        </div> <!-- end container-fluid -->

    </div> <!-- end content -->




<!-- Add a custom JavaScript function -->
<script>
function downloadTableData(rowIdx) {
  // Get the table element by its ID
  var table = document.getElementById('documents-units-datatable');

  // Check if the provided row index is within the valid range
  if (rowIdx >= 0 && rowIdx < table.rows.length) {
    var row = table.rows[rowIdx];
    var headingRowData = [];
    var rowData = [];

    // Include the table headings in the headingRowData array
    var headings = table.getElementsByTagName('th');
    for (var h = 0; h < headings.length - 4; h++) {
      var heading = headings[h].innerText;
      headingRowData.push(heading);
    }

    // Include the row data in the rowData array, excluding the last three columns
    for (var j = 0; j < row.cells.length - 4; j++) {
      var cell = row.cells[j];

      // Append the cell data to the rowData array
      rowData.push(cell.innerText);
    }

    // Prepare the worksheet data with separate arrays for headings and row data
    var worksheetData = [headingRowData, rowData];
    var worksheet = XLSX.utils.aoa_to_sheet(worksheetData);
    var workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, 'Sheet1');

    // Generate a Blob object from the workbook data
    var workbookData = XLSX.write(workbook, { bookType: 'xlsx', type: 'array' });
    var blob = new Blob([workbookData], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });

    // Create a temporary <a> element to initiate the download
    var downloadLink = document.createElement('a');
    downloadLink.href = URL.createObjectURL(blob);
    downloadLink.download = 'document_data.xlsx';

    // Programmatically trigger the download
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
  }
}


// modified by sahana to freez document page
$(document).ready(function() {
    
        // Freeze switch change event handler
        $(document).on('change', '.freez-switch', function(event) {
            var docids = $(this).data('docids');
            var isFreezed = $(this).is(':checked');
            
            updateFreezeStatus(docids, isFreezed);
           
        });
   

   // Set initial state of the slider based on the "freezed" column
    $('.freez-switch').each(function() {
        var isFreezed = parseInt($(this).data('freezed'));

        if (isFreezed === 1) {
            $(this).prop('checked', true);
            $(this).parent().find('.slider').addClass('slided');
            
            
        }
    });

});    

//modified by sahana to freez document
    function updateFreezeStatus(docids, isFreezed) {
        var formData = new FormData();
        formData.append('formname', 'updatefreeze');
        formData.append('docids', docids);
        formData.append('isFreezed', isFreezed ? 1 : 0);
       
    
        $.ajax({
            url: 'insert_data.php',
            type: 'POST',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data === 'dontfreeze') {

                    toastr["error"]("Please Complete The Linked Document Before Freezing.");
                    setTimeout(function() {
                        location.reload(); // Reload the page after 1 milliseconds
                    }, 1500);
                } 
                else if (data === 'updatedata') {
                    if (isFreezed) {
                        toastr["success"]("Document Freezed Successfully.");
                    } else {
                        toastr["success"]("Document Unfreezed Successfully.");
                    }
                    setTimeout(function() {
                        location.reload(); // Reload the page after 0.5 milliseconds
                    }, 500);
                
                } else if (data === 'error') {

                    Command: toastr["error"]("Error updating freeze status.");
                    return false;
                }
            },
            error: function(jqXHR, exception) {
                
                if (jqXHR.status === 0) {
                    Command: toastr["error"]("Not connect.\n Verify Network.")

                } else if (jqXHR.status == 404) {
                    Command: toastr["error"]("Requested page not found. [404]")

                } else if (jqXHR.status == 500) {
                    Command: toastr["error"]("Internal Server Error [500].")

                }
                else if (exception === 'timeout') {
                    Command: toastr["error"]("Time out error.")

                } else if (exception === 'abort') {
                    Command: toastr["error"]("Ajax request aborted.")

                } else {
                    Command: toastr["error"]("Uncaught Error.\n")

                }
            }
            
        });
       
    }
    
// fixed highlighted for reuse popupmodal
$(document).ready(function() {
    $('button[name="reuse"]').on('click', function() {
        var tdId = $(this).data('tdid');
        var tdElement = $('#' + tdId);
        tdElement.toggleClass('selected');
    });
});

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
<div id="con-close-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form enctype="multipart/form-data" class="form-horizontal group-border-dashed parsley-examples"
                id="updatedocuments">
                <input type="hidden" name="update_ids" id="update_ids" value="">
                <input type="hidden" name="STIDS" id="STIDS" value="">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">UPDATE DOCUMENT</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div>


                                 <div class="form-group row">
                                    <label class="col-md-3 col-form-label">State Name</label>
                                    <div class="col-md-9 pt-2">
                                        <select required id="docstid" name="docstid" disabled="disabled"
                                            onchange="return get_dist_select_data(this,'<?php echo $passvalue; ?>');">
                                            <option value="">Select State Name</option>
                                            <?php foreach ($row as $key => $element) { ?>
                                            <option value="<?php echo $element['STID2021']; ?>">
                                                <?php echo $element['STName2021']; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Type</label>
                                    <div class="col-md-9 pt-2">
                                        <select required="required" id="doctype" name="doctype"
                                            onchange="return get_doctype_data(this);">
                                            <option value="">Select Type</option>
                                            <option value="Notification">Notification</option>
                                            <option value="Resolution">Resolution</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Document Date</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="dd-mm-yyyy"
                                                data-provide="datepicker" id="docdate" name="docdate"
                                                data-date-autoclose="true">
                                            <div class="input-group-append">
                                                <span class="input-group-text bg-primary b-0 text-white"><i
                                                        class="ti-calendar"></i></span>
                                            </div>
                                        </div><!-- input-group -->
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Document No.</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="doctitle" id="doctitle" required
                                            placeholder="Document No." />
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Description</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" required placeholder="Description" rows="4"
                                            id="docdescription" name="docdescription"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Upload Document</label>
                                    <div class="col-md-9">
                                        <input type="file" id="docnotification" name="docnotification"
                                            accept="application/pdf" class="dropify" />
                                        <a href="" target="_blank" id="upploaded_doc">Uploaded Document</a>
                                    </div>
                                </div>







                            </div>
                        </div><!-- end col -->

                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-info waves-effect waves-light">Save</button>
                </div>
            </form>
        </div>

    </div>
</div>
<!-- bs-example-modal-xl modal-xl-->
<div id="con-close-modal-add" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;" data-keyboard="false" data-backdrop="static">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form enctype="multipart/form-data" class="form-horizontal group-border-dashed" data-parsley-validate
                novalidate data-parsley-trigger="keyup" id="adddocument">
                <input type="hidden" name="formname" id="formname" value="adddocumentdata">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">ADD DOCUMENT</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">State Name</label>
                                    <div class="col-md-9 pt-2">
                                        <select data-toggle="select2" required id="addSTID2021" name="addSTID2021"
                                            onchange="return get_dist_select_data(this,'<?php echo $passvalue; ?>');">
                                            <option value="">Select State Name</option>
                                            <?php foreach ($row as $key => $element) { ?>
                                            <option value="<?php echo $element['STID2021']; ?>">
                                                <?php echo $element['STName2021']; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Type</label>
                                    <div class="col-md-9 pt-2">
                                        <select required="required" id="adddoctype" name="adddoctype"
                                            onchange="return get_doctype_data(this);">
                                            <option value="">Select Type</option>
                                            <option value="Notification">Notification</option>
                                            <option value="Resolution">Resolution</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Document Date</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="dd-mm-yyyy"
                                                data-provide="datepicker" id="adddocdate" name="adddocdate"
                                                data-date-autoclose="true" autocomplete="false">
                                            <div class="input-group-append">
                                                <span class="input-group-text bg-primary b-0 text-white"><i
                                                        class="ti-calendar"></i></span>
                                            </div>
                                        </div><!-- input-group -->
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Document No.</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="adddoctitle" id="adddoctitle"
                                            required placeholder="Document No." />
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Description</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" required placeholder="Description" rows="4"
                                            id="docdescription" name="docdescription"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Upload Document</label>
                                    <div class="col-md-9">
                                        <input type="file" onchange="PreviewImage();" required="required" id="adddocnotification"
                                            name="adddocnotification" accept="application/pdf" class="dropify" />

                                    </div>
                                </div>







                            </div>
                           
                        </div><!-- end col -->
 <iframe style="display:none;" id="viewer" frameborder="1"  width="100%" height="350"></iframe>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-info waves-effect waves-light">Upload</button>
                </div>
            </form>
        </div>

    </div>
</div>

<div id="con-close-modal-linkdc" class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;" data-keyboard="false" data-backdrop="static">

    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form enctype="multipart/form-data" class="form-horizontal group-border-dashed" data-parsley-validate
                novalidate data-parsley-trigger="keyup" id="documentlink">
                <input type="hidden" name="formname" id="formname" value="documentlinkdata">
                <input type="hidden" name="docidsdata" id="docidsdata" value="">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">DOCUMENT LINK 2021</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-6" style="display:none;" id="pdf" >
                             <iframe style="display:none;" id="viewerlast" frameborder="1"  width="100%" height="100%"></iframe>
                        </div>
                        <div class="col-xl-6">
                            <div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">State Name</label>
                                    <div class="col-md-9 pt-2">
                                        <select id="lSTID2021" name="lSTID2021"
                                            onchange="return get_document_dist_select_data(this);">
                                            <option value="">Select State Name</option>
                                            <?php foreach ($row as $key => $element) { ?>
                                            <option value="<?php echo $element['STID2021']; ?>">
                                                <?php echo $element['STName2021']; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">District Name</label>
                                    <div class="col-md-9 pt-2">
                                        <select id="lDTID2021" name="lDTID2021"
                                            onchange="return get_document_subdist_select_data(this);">
                                            <option value="">Select District Name</option>
                                        </select>

                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Sub-District Name</label>
                                    <div class="col-md-9 pt-2">
                                        <select id="lSDID2021" name="lSDID2021"
                                            onchange="return get_document_village_select_data(this);">
                                            <option value="">Select Sub-District Name</option>
                                        </select>

                                    </div>

                                </div>
                                    <div class="row">
                                        <label class="col-md-3 col-form-label">&nbsp;</label>
                                         <div class="col-md-9">
                                        <label class="col-md-6 col-form-label listcomefrom pl-0">State List 2011 - 2021</label>
                                        <label class="col-md-5 col-form-label listcomefrom1 pl-0" >State List 2021</label>
                                    </div>
                                    </div>

                                <div class="form-group row" id="LKSTIDS">
                                    <label class="col-md-3 col-form-label">&nbsp;</label>
                                    <div class="col-md-9">
                                     
                                        <select multiple="multiple" id="linkSTID2021" name="linkSTID2021[]">
                                            <?php foreach ($row as $key => $element) { ?>
                                            <option value="<?php echo $element['STID2021']; ?>">
                                                <?php echo $element['STName2021']; ?></option>
                                            <?php } ?>
                                        </select>


                                    </div>

                                </div>
                                
                                <div class="form-group row" id="LKDTIDS">


                                </div>
                                <div class="form-group row" id="LKSDIDS">


                                </div>
                                <div class="form-group row" id="LKVTIDS">


                                </div>


                            </div>
                        </div><!-- end col -->

                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect closepop"
                        data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-info waves-effect waves-light">Save & Link</button>
                </div>
            </form>
        </div>

    </div>
</div>

<script type="text/javascript">
function PreviewImage() {
    pdffile=document.getElementById("adddocnotification").files[0];
    pdffile_url=URL.createObjectURL(pdffile);
  $('#viewer').css("display", "block")
    $('#viewer').attr('src',pdffile_url);
}
$(function() {



    $('#adddocdate').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: 'TRUE',
        autoclose: true,
       endDate: '+0d',
    })


    $('#docdate').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: 'TRUE',
        autoclose: true,
    endDate: '+0d',
    })


});
$('select').select2();
</script>