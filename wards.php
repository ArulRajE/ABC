<?php include ("header.php"); include ("topbar.php"); include ("menu.php"); 
if(!isset($_GET) || $_GET['ids']=='')
{
     echo "<script language='javascript'>location.href='units';</script>";
        exit;
}
 $datof = base64_decode( $_GET['ids'] );



$STIDDATA = explode('**',$datof);


   // echo "++++++++++++++++++++++++++++++++++++++".$datof;
 $result = pg_query($db, 'select * from "wdCount2011" Full JOIN "wdCount2021" On "wdCount2011"."WDID2011"="wdCount2021"."WDID2021" where "wdCount2021"."VTID2021" = '.$STIDDATA[1].'');

// $where = "";
// if($header!=0 && $rows[0]['assignlist']!=null) 
// {
//     $where = 'where "STID2021" in ('.$rows[0]['assignlist'].')';
// }

$where = "";


$action = "";
$passvalue ="";

if($header!=0 && $rows['assignlist']!=null)  
{
    
    if($rows['adminassigntype']!="ST")
    {
     $passvalue = $rows['assignlist'];   
    }
   
    $action = explode(',',$rows['assignlist']);
    
    $where = 'where "STID2021" in ('.$rows['assignstids'].')';
}
else
{
    $action = "";

}


$resultstate = pg_query($db, 'select "STID2021","STName2021" from "st2021" '.$where.' order by "STID2021" ASC');

 $row = pg_fetch_all($resultstate); 
?>
<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <?php include("breadcrumbs.php"); ?>
            <!-- end page title -->



            <?php include("box.php"); ?>
            <!-- end row -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dropdown float-right">
                                <button class="btn btn-primary btn-rounded waves-effect waves-light" data-toggle="modal"
                                    data-target="#con-close-modal-add" data-backdrop="static" data-keyboard="false"> <i
                                        class="fas fa-plus-circle mr-1"></i> <span>ADD WARD</span> </button>
                            </div>

                            <h4 class="header-title mb-4"><span class="dropcap text-primary">Ward Wise</span>
                                Administrative Units Information 2021</h4>
                            <input type="hidden" name="ids" id="ids" value="<?php echo $_GET['ids']; ?>">

                            <table id="wards-units-datatable" class="table table-hover table-striped table-bordered"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="4" style="background-color: #fe6271; color: #FFFFFF">Administrative
                                            Units Information - 2011</th>
                                        <th colspan="6" style="background-color: #15bed2; color: #FFFFFF ">
                                            Administrative Units Information - 2021</th>

                                    </tr>
                                    <tr>
                                        <th>Ward Code</th>
                                        <th>Ward Name</th>
                                        <th>Ward Level 2011</th>
                                        <th>Population 2011</th>
                                        <th>Ward Code</th>
                                        <th>Ward Name</th>
                                        <th>Ward Level 2021</th>
                                        <th>Population 2021</th>
                                        <th>Linked Document</th>
                                        <th>
                                            <!-- float-right -->
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </a>
                                            </div>
                                        </th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($data = pg_fetch_array($result)) {  
                                                    ?>
                                    <tr>

                                        <td><?php echo $data['WDID2011']; ?></td>
                                        <td><?php echo $data['WDName2011']; ?></td>
                                        <td><?php echo $data['Level2011']; ?></td>
                                        <td><?php echo $data['Pop2011']; ?></td>
                                        <td class="class2021"><?php echo $data['WDID2021']; ?></td>
                                        <td class="class2021"><?php echo $data['WDName2021']; ?></td>
                                        <td class="class2021"><?php echo $data['Level2021']; ?></td>
                                        <td class="class2021"><?php echo $data['Pop2021']; ?></td>

                                        <td class="class2021 <?php if((int)$data['linkeddocument21']!=0 && ($action == "" || in_array($data['STID2021'], $action) || in_array($data['DTID2021'], $action) || in_array($data['SDID2021'], $action) || in_array($data['VTID2021'], $action))) { ?> btnlinked <?php } ?>"
                                            <?php if((int)$data['linkeddocument21']!=0 && ($action == "" || in_array($data['STID2021'], $action) || in_array($data['DTID2021'], $action) || in_array($data['SDID2021'], $action) || in_array($data['VTID2021'], $action))) { ?>
                                            data-target="#con-close-modal-linked"
                                            data-todo='<?php echo json_encode($data); ?>'
                                            data-id="<?php echo $data['STID2021']; ?>" <?php } ?>><a
                                                <?php if((int)$data['linkeddocument21']!=0 && ($action == "" || in_array($data['STID2021'], $action) || in_array($data['DTID2021'], $action) || in_array($data['SDID2021'], $action) || in_array($data['VTID2021'], $action))) { ?>
                                                href="javascript:void(0);" class="btnlinked"
                                                data-target="#con-close-modal-linked"
                                                data-todo='<?php echo json_encode($data); ?>'
                                                data-id="<?php echo $data['STID2021']; ?>" <?php } else {  ?>
                                                class="noaction" data-id="<?php echo $data['STID2021']; ?>"
                                                <?php } ?>><?php echo (int)$data['linkeddocument21']; ?></a>
                                        </td>

                                        <td class="class2021">
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                                                    aria-expanded="true">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a <?php if($action == "" || in_array($data['STID2021'], $action) || in_array($data['DTID2021'], $action) || in_array($data['SDID2021'], $action) || in_array($data['VTID2021'], $action)) { ?>
                                                            href="#" data-toggle="modal" data-target="#con-close-modal"
                                                            class="dropdown-item btnEditnew"
                                                            data-id="<?php echo $data['WDID2021']; ?>"
                                                            data-todo='<?php echo json_encode($data); ?>'
                                                            <?php } else {  ?> class="dropdown-item noaction"
                                                            id="<?php echo $data['WDID2021']; ?>" <?php } ?>>Update</a>
                                                    </li>
                                                    <li><a <?php if($action == "" || in_array($data['STID2021'], $action) || in_array($data['DTID2021'], $action) || in_array($data['SDID2021'], $action) || in_array($data['VTID2021'], $action)) { ?>
                                                            href="javascript:void(0);"
                                                            data-target="#con-close-modal-link"
                                                            data-todo='<?php echo json_encode($data); ?>'
                                                            data-id="<?php echo $data['STID2021']; ?>"
                                                            class="dropdown-item btnlink" <?php } else {  ?>
                                                            class="dropdown-item noaction"
                                                            id="<?php echo $data['WDID2021']; ?>" <?php } ?>>Link
                                                            Document</a>
                                                    </li>
                                                    <!-- <li><a href="javascript:void(0);" class="dropdown-item">View</a></li> -->
                                                    <li class="dropdown-divider"></li>
                                                    <li><a <?php if($action == "" || in_array($data['STID2021'], $action) || in_array($data['DTID2021'], $action) || in_array($data['SDID2021'], $action) || in_array($data['VTID2021'], $action)) { ?>
                                                            href="javascript:void(0);"
                                                            id="<?php echo $data['WDID2021']; ?>"
                                                            class="dropdown-item deletetablerow" <?php } else {  ?>
                                                            class="dropdown-item noaction"
                                                            id="<?php echo $data['WDID2021']; ?>" <?php } ?>>Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>

                                    </tr>
                                    <?php } ?>
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

<div id="con-close-modal-link" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">

    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <form class="form-horizontal group-border-dashed parsley-examples" id="linkdata">
                <input type="hidden" name="datadtids" id="datadtids" value="">
                <input type="hidden" name="datasdids" id="datasdids" value="">
                <input type="hidden" name="datavtids" id="datavtids" value="">
                <input type="hidden" name="datawdids" id="datawdids" value="">
                <input type="hidden" name="dataids" id="dataids" value="">
                <input type="hidden" name="comefrom" id="comefrom" value="WD">
                <input type="hidden" name="formname" id="formname" value="linkdatas">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">LINK DOCUMENT</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <table id="jigardata-datatable"
                                        class="table table-hover table-striped table-bordered nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>

                                            <tr>

                                                <th><input name="select_all" value="1" id="example-select-all"
                                                        type="checkbox"></th>
                                                <th>Document ID</th>
                                                <th>State Code</th>
                                                <th>Document Type</th>
                                                <th>Date</th>
                                                <th>Document No</th>
                                                <th>Description</th>
                                                <th>Document</th>
                                            </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>
                        </div><!-- end col -->

                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-info waves-effect waves-light">Link</button>
                </div>
            </form>
        </div>

    </div>
</div>
<div id="con-close-modal-linked" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">

    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <form class="form-horizontal group-border-dashed parsley-examples" id="linkeddataupdate">
                <input type="hidden" name="linkeddataids" id="linkeddataids" value="">
                <input type="hidden" name="linkeddtdataids" id="linkeddtdataids" value="">
                <input type="hidden" name="linkedsddataids" id="linkedsddataids" value="">
                <input type="hidden" name="linkedvtdataids" id="linkedvtdataids" value="">
                <input type="hidden" name="linkedwddataids" id="linkedwddataids" value="">
                <input type="hidden" name="linkedcomefrom" id="linkedcomefrom" value="WD">
                <input type="hidden" name="formname" id="formname" value="linkedlinkdatas">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">LINKED DOCUMENT</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <table id="linked-datatable"
                                        class="table table-hover table-striped table-bordered nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>

                                            <tr>
                                                <th><input name="linkedselect_all" value="1" id="linkedselect-all"
                                                        type="checkbox"></th>
                                                <th>Document ID</th>
                                                <th>State Code</th>
                                                <th>Document Type</th>
                                                <th>Date</th>
                                                <th>Document No</th>
                                                <th>Description</th>
                                                <th>Document</th>
                                            </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>
                        </div><!-- end col -->

                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect closepop"
                        data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-info waves-effect waves-light">Unlinked</button>
                </div>
            </form>
        </div>

    </div>
</div>

<div id="con-close-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-horizontal group-border-dashed" data-parsley-validate novalidate
                data-parsley-trigger="keyup" id="updateward">
                <input type="hidden" name="formname" id="formname" value="updatewarddata">
                <input type="hidden" name="update_ids" id="update_ids" value="">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">UPDATE WARD</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">&nbsp;</label>

                                    <label class="col-md-4 col-form-label">2011</label>
                                    <label class="col-md-4 col-form-label">2021</label>


                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">State Name</label>
                                    <div class="col-md-9 pt-2">
                                        <select required id="STID2021" name="STID2021"
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
                                    <label class="col-md-3 col-form-label">District Name</label>
                                    <div class="col-md-9 pt-2">
                                        <select required id="DTID2021" name="DTID2021"
                                            onchange="return get_subdist_select_data(this);">
                                            <option value="">Select Districts Name</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Subdistrict Name</label>
                                    <div class="col-md-9 pt-2">
                                        <select required id="SDID2021" name="SDID2021"
                                            onchange="return get_subdist_select_datavals(this);">
                                            <option value="">Select Sub Districts Name</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Village / Town Name</label>
                                    <div class="col-md-9 pt-2">
                                        <select required onchange="return get_subdist_select_datavt(this);"
                                            id="VTID2021" name="VTID2021">
                                            <option value="">Select Village / Town</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-md-3 col-form-label">Ward Name</label>

                                    <div class="col-md-4">
                                        <input type="text" id="WDName2011" name="WDName2011" class="form-control"
                                            disabled="disabled" placeholder="Ward Name" />
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="WDName2021" name="WDName2021" class="form-control"
                                            required placeholder="Ward Name" />
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-md-3 col-form-label">Short code</label>

                                    <div class="col-md-4">
                                        <input type="text" data-parsley-minlength="4" id="Short_WD2011"
                                            name="Short_WD2011" data-parsley-maxlength="4"
                                            onkeypress="return numbersOnly12(event)" class="form-control"
                                            disabled="disabled" placeholder="" />
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" data-parsley-minlength="4" id="Short_WD2021"
                                            name="Short_WD2021" data-parsley-maxlength="4"
                                            onkeypress="return numbersOnly12(event)" class="form-control"
                                            placeholder="Short code" />
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-md-3 col-form-label">MDDS Code</label>

                                    <div class="col-md-4">
                                        <input type="text" id="MDDS_WD2011" name="MDDS_WD2011"
                                            data-parsley-minlength="4" data-parsley-maxlength="4"
                                            onkeypress="return numbersOnly12(event)" class="form-control"
                                            disabled="disabled" placeholder="" />
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="MDDS_WD2021" name="MDDS_WD2021"
                                            data-parsley-minlength="4" data-parsley-maxlength="4"
                                            onkeypress="return numbersOnly12(event)" class="form-control"
                                            placeholder="MDDS Code" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Level</label>
                                    <div class="col-md-9 pt-2">
                                        <select data-toggle="select2" required="required" id="Level2021"
                                            name="Level2021" onchange="return get_status_data(this);">
                                            <option value="">Select Level</option>
                                            <option value="WARD">WARD</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Status</label>
                                    <div class="col-md-9 pt-2">
                                        <select data-toggle="select2" required="required"
                                            onchange="return get_subdist_select_datavt(this);" id="Status2021"
                                            name="Status2021">
                                            <option value="">Select Status</option>
                                        </select>
                                    </div>
                                </div>
                                <!--   <div class="form-group row">
                                                                    <label class="col-md-3 col-form-label">OGTYPE</label>
                                                                     <div class="col-md-9">
                                                                        <input type="text" class="form-control" required
                                                                                placeholder="OGTYPE"/>
                                                                    </div>
                                                                </div> -->
                                <div class="form-group row">

                                    <label class="col-md-3 col-form-label">Population</label>

                                    <div class="col-md-4">
                                        <input type="text" id="Pop2011" name="Pop2011" data-parsley-minlength="1"
                                            data-parsley-maxlength="10" onkeypress="return numbersOnly12(event)"
                                            class="form-control" disabled="disabled" placeholder="Population" />
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="Pop2021" name="Pop2021" data-parsley-minlength="1"
                                            data-parsley-maxlength="10" onkeypress="return numbersOnly12(event)"
                                            class="form-control" required placeholder="Population" />
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-md-3 col-form-label">Area</label>

                                    <div class="col-md-4">
                                        <input type="text" id="Area2011" disabled="disabled"
                                            onkeypress="return numbersOnly12(event)" name="Area2021"
                                            class="form-control" placeholder="" />
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="Area2021" required
                                            onkeypress="return numbersOnly12(event)" name="Area2021"
                                            class="form-control" placeholder="Area" />
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-md-3 col-form-label">Remark 1</label>

                                    <div class="col-md-4">
                                        <textarea class="form-control" placeholder="" disabled="disabled" rows="4"
                                            id="Remark12011" name="Remark12011"></textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <textarea class="form-control" placeholder="Remark 1" rows="4" id="Remark1"
                                            name="Remark1"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-md-3 col-form-label">Remark 2</label>

                                    <div class="col-md-4">
                                        <textarea class="form-control" placeholder="" rows="4" id="Remark22011"
                                            name="Remark22011" disabled="disabled"></textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <textarea class="form-control" placeholder="Remark 2" rows="4" id="Remark2"
                                            name="Remark2"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->

                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect closepop" data-dismiss="modal"
                        aria-label="Close">Cancel</button>
                    <button type="submit" class="btn btn-info waves-effect waves-light">Save</button>
                </div>
            </form>
        </div>

    </div>
</div>
<div id="con-close-modal-add" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-horizontal group-border-dashed" data-parsley-validate novalidate
                data-parsley-trigger="keyup" id="addward">
                <input type="hidden" name="formname" id="formname" value="addwarddata">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">ADD WARD</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">&nbsp;</label>
                                    <label class="col-md-9 col-form-label">2021</label>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">State Name</label>
                                    <div class="col-md-9 pt-2">
                                        <select required id="addSTID2021" name="addSTID2021"
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
                                    <label class="col-md-3 col-form-label">District Name</label>
                                    <div class="col-md-9 pt-2">
                                        <select required id="addDTID2021" name="addDTID2021"
                                            onchange="return get_subdist_select_data(this);">
                                            <option value="">Select Districts Name</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Subdistrict Name</label>
                                    <div class="col-md-9 pt-2">
                                        <select required id="addSDID2021" name="addSDID2021"
                                            onchange="return get_subdist_select_datavals(this);">
                                            <option value="">Select Sub Districts Name</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Village / Town Name</label>
                                    <div class="col-md-9 pt-2">
                                        <select required onchange="return get_subdist_select_datavt(this);"
                                            id="addVTID2021" name="addVTID2021">
                                            <option value="">Select Village / Town</option>

                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Ward Name</label>
                                    <div class="col-md-9">
                                        <input type="text" id="addWDName2021" name="addWDName2021" class="form-control"
                                            required placeholder="Ward Name" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Short code</label>
                                    <div class="col-md-9">
                                        <input type="text" data-parsley-minlength="4" id="addShort_WD2021"
                                            name="addShort_WD2021" data-parsley-maxlength="4"
                                            onkeypress="return numbersOnly12(event)" class="form-control"
                                            placeholder="Short code" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">MDDS Code</label>
                                    <div class="col-md-9">
                                        <input type="text" id="addMDDS_WD2021" name="addMDDS_WD2021"
                                            data-parsley-minlength="4" data-parsley-maxlength="4"
                                            onkeypress="return numbersOnly12(event)" class="form-control"
                                            placeholder="MDDS Code" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Level</label>
                                    <div class="col-md-9 pt-2">
                                        <select data-toggle="select2" required="required" id="addLevel2021"
                                            name="addLevel2021" onchange="return get_status_data(this);">
                                            <option value="">Select Level</option>
                                            <option value="WARD">WARD</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Status</label>
                                    <div class="col-md-9 pt-2">
                                        <select data-toggle="select2" required="required"
                                            onchange="return get_subdist_select_datavt(this);" id="addStatus2021"
                                            name="addStatus2021">
                                            <option value="">Select Status</option>
                                        </select>
                                    </div>
                                </div>
                                <!--   <div class="form-group row">
                                                                    <label class="col-md-3 col-form-label">OGTYPE</label>
                                                                     <div class="col-md-9">
                                                                        <input type="text" class="form-control" required
                                                                                placeholder="OGTYPE"/>
                                                                    </div>
                                                                </div> -->
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Population</label>
                                    <div class="col-md-9">
                                        <input type="text" id="addPop2021" name="addPop2021" data-parsley-minlength="1"
                                            data-parsley-maxlength="10" onkeypress="return numbersOnly12(event)"
                                            class="form-control" required placeholder="Population" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Area</label>
                                    <div class="col-md-9">
                                        <input type="text" id="addArea2021" required
                                            onkeypress="return numbersOnly12(event)" name="addArea2021"
                                            class="form-control" placeholder="Area" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Remark 1</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" placeholder="Remark 1" rows="4" id="addRemark1"
                                            name="addRemark1"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Remark 2</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" placeholder="Remark 2" rows="4" id="addRemark2"
                                            name="addRemark2"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->

                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect closepop" data-dismiss="modal"
                        aria-label="Close">Cancel</button>
                    <button type="submit" class="btn btn-info waves-effect waves-light">Save</button>
                </div>
            </form>
        </div>

    </div>
</div>

<script type="text/javascript">
$('select').select2({
    maximumInputLength: 20 // only allow terms up to 20 characters long
});
</script>