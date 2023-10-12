<head>
    <!-- toaster cdn changed by Veena -->
    <link href="assets/libs/toastr/toastr.min.css" rel="stylesheet" type="text/css">
    <script src="assets/libs/toastr/toastr.min.js"></script>
    <style>
        /* modified by sahana to Remove Arrows/Spinners */
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>

</head>

<div id="addnewdocument" class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" data-keyboard="false" data-backdrop="static" aria-hidden="true">

    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form class="form-horizontal group-border-dashed" data-parsley-validate novalidate
                data-parsley-trigger="keyup" id="assigndata">
                <input type="hidden" name="formname" id="formname" value="assignformdata">
                <input type="hidden" name="comefromcheck" id="comefromcheck" value="">
                <input type="hidden" name="docids" id="docids" value="">
                <input type="hidden" name="ostate[]" id="ostate1" value="">
                <input type="hidden" name="toStatus[]" id="toStatus_1" value="">

                <!--  <input type="hidden" name="ostold[]" id="ostold_1" value="">
                    <input type="hidden" name="odtold[]" id="odtold_1" value="">
                    <input type="hidden" name="osdold[]" id="osdold_1" value=""> -->

                <input type="hidden" name="vlevel[]" id="vlevel_1" value="">
                <input type="hidden" name="ovstatus[]" id="ovstatus_1" value="">
                <!--  <input type="hidden" name="dids" id="dids" value=""> 
                        <input type="hidden" name="didsup" id="didsup" value="">
                        <input type="hidden" name="sdidsup" id="sdidsup" value=""> -->
                <input type="hidden" name="fstids" id="fstids" value="">
                <input type="hidden" name="fdtids" id="fdtids" value="">
                <input type="hidden" name="fsdids" id="fsdids" value="">
                <input type="hidden" name="fvtids" id="fvtids" value="">
                <input type="hidden" name="tstids" id="tstids" value="">
                <input type="hidden" name="tdtids" id="tdtids" value="">
                <input type="hidden" name="tsdids" id="tsdids" value="">
                <input type="hidden" name="partiallyids1" id="partiallyids1" value="">
                <input type="hidden" name="flagof1" id="flagof1" value="">
                <input type="hidden" name="fromdata" id="fromdata">


                <!-- <input type="hidden" name="uploaddoc" id="uploaddoc" value=""> -->
                <input type="hidden" name="clickpopup" id="clickpopup" value="">

                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="maintitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div>
                                <!-- <div class="form-group row" id="">
                                        <label class="col-md-3 col-form-label" id="view1" style="display:none">State</label>
                                        <label class="col-md-5 col-form-label" id="view2" style="display:none"></label>
                                    </div> -->



                                <!--  <div style="display:none;" id="subdistrictstatus">
                                    <div  class="form-group row">
                                        <label class="col-md-3 col-form-label">Select Sub-District</label>
                                        <div class="col-md-9 pt-2">
                                            <select id="subdistrictget" onchange="return get_sub_district_popup(this,'Create');" name="subdistrictget">
                                                <option value="">Select Sub-District</option>   
                                            </select>
                                        </div>
                                    </div>
                                    </div> -->

                                <!--  <div style="display:none;" id="villagestatus">
                                    <div  class="form-group row">
                                        <label class="col-md-3 col-form-label">Select Town / Village</label>
                                        <div class="col-md-9 pt-2">
                                            <select id="villageget" onchange="return get_village_popup(this,'Create');" name="villageget">
                                                <option value="">Select Village / Town</option>        
                                            </select>
                                        </div>
                                    </div>
                                    </div>  -->

                                <!-- <div id="hiddenone"> -->
                                <fieldset class="let" id="let" style="display: none;">
                                    <legend class="chha lablefrom">Action From
                                        <?php echo $_SESSION['logindetails']['baseyear']; ?> -
                                        <?php echo $_SESSION['activeyears']; ?>
                                    </legend>



                                    <div id="adddataof">

                                        <div class="row" id="row_1">

                                            <div class="form-group col-md-3 fromstate ST pl-1 pr-1"
                                                style="display:none;">
                                                <label style="display:none;"
                                                    class="col-md-12 fromstate pl-1 pr-1">Select State / UT</label>
                                                <div style="display:none;" class="col-md-12 fromstate pl-1 pr-1">
                                                    <select id="fromstate1"
                                                        onchange="return get_district_popup_distdata(this,'Create');"
                                                        name="fromstate[]" class="fromstate">

                                                    </select>

                                                </div>

                                            </div>

                                            <div class="form-group col-md-3 districtstatus DT pl-1 pr-1"
                                                style="display:none;">
                                                <label style="display:none;" id="districtstatus"
                                                    class="col-md-12 pl-1 pr-1">Select District</label>
                                                <div style="display:none;" id="districtstatusdrop"
                                                    class="col-md-12 pl-1 pr-1">
                                                    <select id="districtget"
                                                        onchange="return get_district_popup(this,'Create');"
                                                        name="districtget[]">

                                                    </select>

                                                </div>

                                            </div>


                                            <div class="form-group col-md-3 sddistrictstatus SD1 pl-1 pr-1"
                                                style="display:none;">
                                                <label style="display:none;" id="sddistrictstatus"
                                                    class="col-md-12 pl-1 pr-1 sddistrictstatus">Select
                                                    Sub-District</label>
                                                <div style="display:none;" id="sddistrictstatusdrop"
                                                    class="col-md-12 pl-1 pr-1 sddistrictstatus">
                                                    <select id="sddistrictget_1" class="sddistrictstatus"
                                                        onchange="return get_sub_district_popup_new(this,'Create',1);"
                                                        name="sddistrictget[]">
                                                        <option value="">Select Sub-District</option>
                                                    </select>

                                                </div>

                                            </div>


                                            <div class="form-group col-md-3 SD pl-1 pr-1">

                                                <div class="col-md-12 pl-1 pr-1">
                                                    <label id="addlable1"></label>
                                                </div>

                                                <div class="col-md-12 pl-1 pr-1" id="comefromdata">

                                                    <select class="form-select  mainvaldata" required name="namefrom[]"
                                                        id="selected_come"
                                                        onchange="return get_fromvalue1(this.value,1)"></select>
                                                </div>

                                            </div>

                                            <div class="form-group col-md-3 AC pl-1 pr-1">
                                                <div class="col-md-12 pl-1 pr-1">
                                                    <label> Action </label>
                                                </div>
                                                <div class="col-md-12 pl-1 pr-1">
                                                    <select class="form-select actiondata" required
                                                        onchange="return getdata_action(this,1);" name="action[]"
                                                        id="action1">

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-3 FAC pl-1 pr-1" style="display:none">
                                                <div class="col-md-12 pl-1 pr-1">
                                                    <label> New Status of
                                                        <?php echo $_SESSION['activeyears']; ?>
                                                    </label>
                                                </div>
                                                <div class="col-md-12 pl-1 pr-1">
                                                    <select class="form-select FAC" name="fstatus[]" id="fstatus1">
                                                        <option value="">Select Status</option>
                                                        <option value="ST">State</option>
                                                        <option value="UT">Union Territory</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!--  <div class="col-md-2 pt-2 mt-4 OR pl-1 pr-1">

                                            <input type="checkbox" id="oremove1" name="oremove[]" value="1">
                                            <label for="oremove">As original remove</label>

                                            </div> -->

                                        </div>


                                    </div>

                                    <div class="field_wrapper">

                                    </div>
                                    <div class="col-md-2 mt-1" id="addbtu">
                                        <button type="button" disabled
                                            class="btn btn-primary btn-rounded waves-effect waves-light add_button">
                                            <i class="fas fa-plus-circle mr-1"></i>
                                            <span>ADD</span>
                                        </button>
                                    </div>
                                </fieldset>
                                <!-- </div> -->
                                <fieldset class="let">
                                    <legend class="chha">Action On
                                        <?php echo $_SESSION['activeyears']; ?> <span id="comespan"></span>
                                    </legend>

                                    <div class="row" id="todataaction_1">

                                        <div class="form-group col-md-3 stnew ST pl-1 pr-1" style="display:none">
                                            <label class="col-md-12 stnew pl-1 pr-1" id="stnew"
                                                style="display:none">Select State / UT</label>
                                            <div class="col-md-12 pl-1 pr-1 stnew" style="display:none">
                                                <select id="statenew1" name="statenew[]" class="stnew"
                                                    onchange="return get_district_popupto(this,'Create');">
                                                    <option value="">Select State / UT</option>
                                                </select>

                                            </div>
                                        </div>


                                        <div class="form-group col-md-3 dtnew DT pl-1 pr-1" style="display:none">
                                            <label class="col-md-12 dtnew pl-1 pr-1" id="dtnew">Select District</label>
                                            <div class="col-md-12 pl-1 pr-1 dtnew" id="dtnewdrop">
                                                <select id="districtnew1" class="dtnew"
                                                    onchange="return get_sddistrict_popupto(this,'Create');"
                                                    name="districtnew[]">
                                                    <option value="">Select District</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3 sdnew SD1 pl-1 pr-1" style="display:none">
                                            <label class="col-md-12 sdnew pl-1 pr-1" id="sdnew">Select
                                                Sub-District</label>
                                            <div class="col-md-12 pl-1 pr-1 sdnew" id="sdnewdrop">
                                                <select id="sddistrictnew1" onchange="return getvtlist(this,1);"
                                                    name="sddistrictnew[]" class="sdnew">
                                                    <option value="">Select Sub-District</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3 SD pl-1 pr-1">
                                            <label class="col-md-12 pl-1 pr-1" id="addlable"></label>

                                            <div class="col-md-12 pl-1 pr-1 newname">


                                                <input type="text" data-parsley-minlength="2"
                                                    data-parsley-pattern="^[^<>;]+$"
                                                    data-parsley-pattern-message="'<' OR '>' value seems to be invalid."
                                                    class="form-control newname" name="newname[]" id="name2021"
                                                    required />
                                            </div>
                                            <div class="col-md-12 pl-1 pr-1 newnamem">


                                                <select id="named2021" name="newnamem[]" class="newnamem"
                                                    onchange="return get_to_data(this,'');">
                                                    <option value="">Select State / UT</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3 vstatestatus1 ST pl-1 pr-1"
                                            style="display:none">
                                            <label class="col-md-12 pl-1 pr-1 vstatestatus1"
                                                style="display:none">Level</label>

                                            <div class="col-md-12 pl-1 pr-1 vstatestatus1" style="display:none">
                                                <select id="vStatus2021_1" name="vStateStatus[]"
                                                    onchange="return get_sub(this,1);" class="vstatestatus1">
                                                    <option value="">Select Level</option>
                                                    <option value="VILLAGE">Village</option>
                                                    <option value="TOWN">Town</option>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="form-group col-md-3 VAC pl-1 pr-1" style="display:none">
                                            <label class="col-md-12 pl-1 pr-1">Status</label>
                                            <div class="col-md-12 pl-1 pr-1">
                                                <select class="form-select VAC1" onchange="return getstatus(this,1);"
                                                    name="vstatus[]" id="vstatus1">
                                                    <option value="">Select Status</option>
                                                    <!--  <option value="RV">Revenue Village</option>
                                    <option value="FV">Forest Village</option> -->
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3 pl-1 pr-1 statestatus1 ST" style="display:none">
                                            <label class="col-md-12 pl-1 pr-1 statestatus1"
                                                style="display:none">Status</label>

                                            <div class="col-md-12 pl-1 pr-1 statestatus1" style="display:none">
                                                <select id="Statusyear_1" class="Statusyear" name="StateStatus[]">
                                                    <option value="">Select Status</option>
                                                    <option value="ST">State</option>
                                                    <option value="UT">Union Territory</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-2 ORR pl-1 pr-1" id="checkhide">

                                            <label for="oremove1">&nbsp;</label>
                                            <div class="col-md-12 pl-1 pr-1">

                                                <input type="checkbox" onchange="return gettext_data(this,'');"
                                                    id="oremovenew" name="oremovenew[]" class="oremovenew"
                                                    value="1"><label class="pl-2" for="oremove1">With New Name</label>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3 ORRN pl-1 pr-1">
                                            <label class="col-md-12 pl-1 pr-1">Enter New Name</label>
                                            <div class="col-md-12 pl-1 pr-1">
                                                <input type="text" data-parsley-minlength="2"
                                                    class="form-control newnamecheck" data-parsley-pattern="^[^<>;]+$"
                                                    data-parsley-pattern-message="'<' OR '>' value seems to be invalid."
                                                    name="newnamecheck[]" placeholder="Enter New Name"
                                                    id="newnamecheck">
                                            </div>
                                        </div>









                                    </div>
                                    <div class="field_wrapper_name">



                                    </div>
                                    <div class="col-md-2 mt-1" id="addbtut">
                                        <button type="button" disabled
                                            class="btn btn-primary btn-rounded waves-effect waves-light add_button_name">
                                            <i class="fas fa-plus-circle mr-1"></i>
                                            <span>ADD </span>
                                        </button>
                                    </div>
                                </fieldset>




                            </div>
                        </div><!-- end col -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-rounded waves-effect width-xl closepop1"
                        data-dismiss="modal" aria-label="Close">Cancel</button>
                    <button type="submit" name="submit" id="assignbtn"
                        class="btn btn-info btn-rounded width-xl waves-effect waves-light">Assign</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="alreadydocument" class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" data-keyboard="false" data-backdrop="static" aria-hidden="true">

    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form class="form-horizontal group-border-dashed parsley-examples" id="olddocumentselect">
                <input type="hidden" name="formname" id="formname" value="olddocselect">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="maintitle">The Document you are trying to upload may already
                        Exist. Please Verify...</h5>
                    <!--  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> -->
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">

                            <div class="card">
                                <div class="card-body">
                                    <table id="alreadydoc-datatable"
                                        class="table table-hover table-striped table-bordered nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>

                                            <tr>

                                                <th>#</th>
                                                <th style="display: none;">Document ID</th>
                                                <th>State Code</th>
                                                <th>Document Type</th>
                                                <th>Document Date</th>
                                                <th>Document No.</th>
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

                    <button type="button" class="btn btn-secondary waves-effect"
                        onclick="newdocumentadded();">New</button>
                    <button type="submit" name="submit" class="btn btn-info waves-effect waves-light">Continue</button>
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal"
                        aria-label="Close">Cancel</button>
                </div>
            </form>

        </div>
    </div>
</div>





<div id="submergedocument" class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" data-keyboard="false" data-backdrop="static" aria-hidden="true">

    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form class="form-horizontal group-border-dashed" data-parsley-validate novalidate
                data-parsley-trigger="keyup" id="submergedata">
                <input type="hidden" name="formname" id="formname" value="submergeform">
                <input type="hidden" name="comefromchecksub" id="comefromchecksub" value="">
                <input type="hidden" name="docidssub" id="docidssub" value="">
                <input type="hidden" name="clickpopup" id="clickpopup" value="">





                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="maintitlesub"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div>

                                <div style="display:none;" id="ststatussub">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Select State / UT</label>
                                        <div class="col-md-9 pt-2">
                                            <select id="stategetsub" onchange="return get_district_popup_list(this);"
                                                name="stategetsub[]">

                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div style="display:none;" id="districtstatussub">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Select District</label>
                                        <div class="col-md-9 pt-2">
                                            <select id="districtgetsub"
                                                onchange="return get_district_popup_sublist(this);"
                                                name="districtgetsub[]">

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div style="display:none;" id="subdistrictstatussub">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Select Sub-District</label>
                                        <div class="col-md-9 pt-2">
                                            <select id="subdistrictgetsub"
                                                onchange="return get_sub_district_popup_list(this);"
                                                name="subdistrictgetsub[]">
                                                <option value="">Select Sub-District</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <fieldset class="let" id="let" style="display: none;">
                                    <legend class="chha">Action On
                                        <?php echo $_SESSION['activeyears']; ?> <span id="comespan"></span>
                                    </legend>

                                    <div id="adddataofsub">

                                        <div class="form-group row">

                                            <div class="col-md-2 pt-2">
                                                <label id="addlablesub1"></label>
                                            </div>

                                            <div id="comefromdata123">

                                            </div>

                                            <div class="col-md-5 pt-2 mt-1">

                                                <label for="oremove">Submerge with Sea / River / Any Other</label>

                                            </div>



                                            <div class="col-md-8 offset-md-2 pt-2">
                                                <textarea class="form-control" required placeholder="Remark" rows="4"
                                                    name="remarksubmerge[]" id="remarksubmerge"></textarea>
                                            </div>




                                        </div>

                                    </div>


                                </fieldset>






                            </div>
                        </div><!-- end col -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-rounded waves-effect width-xl closepop1"
                        data-dismiss="modal" aria-label="Close">Cancel</button>
                    <button type="submit" name="submit"
                        class="btn btn-info btn-rounded width-xl waves-effect waves-light">Assign</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div id="con-link-document" class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" data-keyboard="false" data-backdrop="static" aria-hidden="true">

    <div class="modal-dialog modal-xl" style="max-inline-size: min-content;">
        <div class="modal-content" style="flex-direction: unset;">

            <form class="form-horizontal group-border-dashed parsley-examples" id="reusedoc">
                <input type="hidden" name="formname" id="formname" value="reusedocform1">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="maintitle">List of Document(s) </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                <div class="modal-body" style="padding: 0rem;">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <table id="alreadydoc-datatable-list"
                                        class="table table-hover table-striped table-bordered"
                                        style=" border-collapse: collapse; border-spacing: 0; width: 100%;"> <br />
                                        <thead>
                                            <tr>
                                            <tr>
                                                <th colspan="9"
                                                    style=" text-align: center; background-color: #5D6D7E; color: white; font-size:20px">
                                                    Original Document Information</th>
                                                <th colspan="3"
                                                    style=" text-align: center; background-color: #34495E; color: white; font-size:20px">
                                                    Reused Document Information</th>
                                                <th colspan="1"
                                                    style=" text-align: center; background-color: #5D6D7E; color: white; font-size:15px">
                                                    Document Status</th>
                                                <th colspan="1"
                                                    style="text-align: center; background-color: #34495E; color: white; font-size: 15px">
                                                </th>
                                            </tr>
                                            </tr>
                                            <th style="background-color: #5D6D7E; color: white;"></th>
                                            <th style="display: none;">Document ID</th>
                                            <th style="background-color: #5D6D7E; color: white ">Document</th>
                                            <th style="background-color: #5D6D7E; color: white ">Document Type</th>
                                            <th style="background-color: #5D6D7E; color: white ">Document No.</th>
                                            <th style="background-color: #5D6D7E; color: white ">Document Date</th>
                                            <th style="background-color: #5D6D7E; color: white ">Description</th>
                                            <th style="background-color: #5D6D7E; color: white ">Used By</th>
                                            <!--modified by sahana JC_22 -->
                                            <th style="background-color: #5D6D7E; color: white ">Used On</th>
                                            <!--modified by sahana JC_22 -->
                                            <th style="background-color: #34495E; color: white ">Reused Date & Time</th>
                                            <th style="background-color: #34495E; color: white ">Reused By</th>
                                            <th style="background-color: #34495E; color: white ">Reused Description</th>
                                            <th style="background-color: #5D6D7E; color: white ">Status</th>
                                            <th style="background-color: #34495E; color: white"> </th>
                                            <th style="display: none;">Freezed ID</th>
                                            <th style="display: none;">Have Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div><!-- end col -->
                    </div>
                </div><!-- modal-body -->


                <div class="modal-footer">

                    <button type="button" class="btn btn-info waves-effect waves-light" onclick="selecteddocumentrow();"
                        id="reuseBtn" disabled>Reuse</button>
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal" aria-label="Close"
                        onclick="refreshPage()">Cancel</button>

                </div>
            </form>

            <div id="myModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" id="popup1"
                        style="position: absolute;top: 410px;left: 220px;transform: translate(-50%, -50%);cursor: move;">

                        <div class="card card-color mb-0">
                            <div class="card-header bg-primary">
                                <!-- <button type="button" class="close" onclick="deselectCheckbox()">
                                        <span aria-hidden="true">&times;</span>
                                    </button> -->
                                <h3 class="card-title text-white mt-1 mb-0">Reused Document Description</h3>
                            </div>
                            <div class="card-body">
                                <form id="reusedescription" method="POST" action="">
                                    <div class="form-group">
                                        <label for="doc_reuse_desc" class="sr-only">Reused Document Description</label>
                                        <input type="text" class="form-control" id="doc_reuse_desc" required
                                            oninput="validatedoc_reuse_desc(this)" name="doc_reuse_desc"
                                            placeholder="Enter Reused Document Description"
                                            data-parsley-pattern="^[^<>;]+$"
                                            data-parsley-pattern-message="'<' OR '>' value seems to be invalid."
                                            onkeypress="return validatereusedescriptionn(event)" required data>
                                        <div id="error" class="error-message" style="color:red ;font-size: 0.78rem;">
                                        </div>
                                        <!-- reuse description character limit & validation -->



                                        <script>
                                            function validatedoc_reuse_desc(input) {
                                                var regex = /^[a-zA-Z0-9 \.(),._-]{5,80}$/;
                                                var errorMessage = document.getElementById("error");
                                                if (!regex.test(input.value)) {
                                                    input.setCustomValidity("character length should be more than 5");
                                                    errorMessage.innerHTML = "character length should be more than 5";
                                                    // $('#doc_reuse_desc').css('border-color', 'red');
                                                    errorMessage.classList.remove("fade-out");
                                                } else {
                                                    input.setCustomValidity("");
                                                    errorMessage.innerHTML = "";
                                                    errorMessage.classList.add("fade-out");
                                                    $('#doc_reuse_desc').css('border-color', '');
                                                }
                                            }

                                        </script>

                                        <script>
                                            //Function to restrict text box 
                                            function validatereusedescriptionn(key) {
                                                //getting key code of pressed key
                                                var keycode = (key.which) ? key.which : key.keyCode;
                                                var ofcname = document.getElementById('doc_reuse_desc');
                                                //comparing pressed keycodes
                                                if (!(keycode == 8 || keycode == 46 || keycode == 32 || keycode == 95) && (keycode < 65 || keycode > 90) && (keycode < 97 || keycode > 122) && (keycode < 40 || keycode > 46) && (keycode < 48 || keycode > 57)) {
                                                    return false;
                                                }
                                                else {
                                                    //Condition to check textbox contains 80 characters
                                                    if (ofcname.value.length < 80) {
                                                        return true;
                                                    }
                                                    else {
                                                        return false;
                                                    }
                                                }
                                            }
                                        </script>
                                    </div>

                                    <button type="button" class="btn btn-secondary waves-effect" aria-label="Close"
                                        style="float:right" onclick="deselectCheckbox()">Cancel</button>
                                    <button type="submit" class="btn btn-primary" style="float:right; margin-right:3px"
                                        onclick="enableReuse()">Save</button>

                                </form>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

        </div>
    </div>
</div>

<script>
    // modified by sahana to save the input reuse description in local storage and send the data using ajax to insert_data.php

    $(document).ready(function () {
        // Get the saved value from local storage
        var savedValue = localStorage.getItem('doc_reuse_desc');

        // If the saved value exists, set the input field value
        if (savedValue !== null) {
            $('#doc_reuse_desc').val(savedValue);
        }

        // Set the form submit handler
        $('#reusedescription').submit(function (e) {
            // Prevent the form from submitting normally
            e.preventDefault();

            // Get the input field value
            var inputValue = $('#doc_reuse_desc').val();

            // Save the input field value to local storage
            localStorage.setItem('doc_reuse_desc', inputValue);

            // Make an AJAX request to submit the form data
            $.ajax({
                type: "POST",
                url: "insert_data.php",
                data: { doc_reuse_desc: inputValue, formname: "finaladddoc" },
                success: function (response) {
                    // Handle the successful response
                    console.log(response);
                },
                error: function (xhr, status, error) {
                    // Handle the error
                    console.log(error);
                }
            });

            // Close the modal
            closeModal();
        });
    });

    // modified by sahana to close the modal, deselect the row and checkbox when the user clicks the cancel button

    //It hides the modal and deselects the row and checkbox.
    function closeModal() {
        // Hide the modal and reset the form
        document.getElementById("myModal").style.display = "none";
        // Clear the input field
        $('#doc_reuse_desc').val('');

        form.reset();
    }

    //modified by sahana to state value required for dco admin
    function updateDropdown(dropdownUser) {
        if (dropdownUser.value == 1) {
            $("#addSTID2021").prop("disabled", true).val("").prop("required", false).trigger("change");
        } else {
            $("#addSTID2021").prop("disabled", false).prop("required", true);
        }
    }

    // It clears the input field and displays the modal dialog box.
    function showInput() {
        // Get the input field
        var inputField = document.getElementById("doc_reuse_desc");

        // Clear the input field
        inputField.value = "";

        // Get the modal
        var modal = document.getElementById("myModal");

        // Display the modal
        modal.style.display = "block";
    }

    // It deselects the input field and hides the modal dialog box.
    function hideInput() {
        // Deselect the input field
        var inputField = document.getElementById("doc_reuse_desc");
        inputField.value = "";

        // Get the modal
        var modal = document.getElementById("myModal");

        // Hide the modal
        modal.style.display = "none";
    }

    // Cancel button= It deselects the selected row and checkbox and hides the modal dialog box.(12-05-2023)
    function deselectCheckbox() {
        // Deselect the selected row
        $('#alreadydoc-datatable-list').DataTable().row('.selected').deselect();

        // Deselect the checkbox
        $('#alreadydoc-datatable-list input[type="checkbox"]').prop('checked', false);

        // Enable all checkboxes
        //   $('#alreadydoc-datatable-list input[type="checkbox"]').prop('disabled', false);

        // Hide the modal
        var modal = document.getElementById("myModal");
        modal.style.display = "none";
        // Hide the modal
        $('#con-link-document').modal('hide');
    }


    // reuse enable button when reuse description is saved untill then reuse should not be enabled

    function disableReuse() {
        document.getElementById("reuseBtn").disabled = true;
    }

    function enableReuse() {
        var inputText = document.getElementById("doc_reuse_desc").value;
        if (inputText.trim() !== "") {
            document.getElementById("reuseBtn").disabled = false;
        }
        return false; // Prevent form submission
    }

    $('#myModal').on('shown.bs.modal', function () {
        disableReuse();
    });

    $('#myModal').on('hidden.bs.modal', function () {
        enableReuse();
    });

</script>


<div id="remarks_all_hist" class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" data-keyboard="false" data-backdrop="static" aria-hidden="true">

    <div class="modal-dialog modal-xl">
        <div class="modal-content" id="popup2"
            style="position: absolute;top: 410px;left: 410px;transform: translate(-50%, -50%);cursor: move;">

            <form class="form-horizontal group-border-dashed parsley-examples" id="reusedoc">
                <input type="hidden" name="formname" id="formname" value="reusedocform">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="maintitle">List of Remarks </h5>
                    <!--  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> -->
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">

                            <div class="card">
                                <div class="card-body">
                                    <table id="remarks-datatable-list"
                                        class="table table-hover table-striped table-bordered nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Remarks</th>
                                                <th>Date And Time</th>
                                                <th>Created By</th>
                                                <th>Link Document</th>
                                                <th style="display: none;">Link Document</th>
                                            </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>
                        </div><!-- end col -->
                    </div>
                </div>
                <div class="modal-footer">

                    <!--  <button type="button" class="btn btn-info waves-effect waves-light" onclick="selecteddocumentrow();">Reuse</button> -->

                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal"
                        aria-label="Close">Close</button>
                </div>
            </form>

        </div>
    </div>
</div>
<div id="con-close-modal-add123" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form enctype="multipart/form-data" class="form-horizontal group-border-dashed" data-parsley-validate
                novalidate data-parsley-trigger="keyup" id="adduser">
                <input type="hidden" name="formname" id="formname" value="adduserdata">
                <input type="hidden" name="admin_type" id="admin_type" value="2">

                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">ADD USER</h5>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">User Type</label>

                                <div class="col-md-9 pt-2">


                                    <select data-toggle="select1" required id="userType" name="userType"
                                        onchange="updateDropdown(this)">
                                        <option value="">Select User Type</option>
                                        <?php

                                        if ($_SESSION['login_type'] == "0") { ?>
                                        <option value="1">ORGI User</option>
                                        <option value="2">DCO Admin</option>


                                        <?php } ?>
                                        <?php

                                        if ($_SESSION['login_type'] == "2") { ?>

                                        <option value="3" Selected="Selected">DCO User</option>



                                        <?php } ?>


                                    </select>
                                    <script>
                                        function updateDropdown(selectElement) {
                                            var userType = selectElement.value;
                                            var stateSelect = document.getElementById("addSTID2021");

                                            if (userType == "1") {
                                                stateSelect.removeAttribute("data-parsley-required", "false");
                                                stateSelect.disabled = true;
                                                $(stateSelect).parsley().reset();
                                                $("#addSTID2021").prop("disabled", true).val("").prop("required", false).trigger("change");
                                            } else {
                                                stateSelect.setAttribute("data-parsley-required", "true");
                                                stateSelect.disabled = false;
                                                $(stateSelect).parsley().reset();
                                                $("#addSTID2021").prop("disabled", false).prop("required", true);
                                            }
                                        }
                                    </script>

                                </div>

                            </div>
                            <!-- if($rows['assignlist']==$element['STID']) -->

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">State / UT Name</label>
                                <div class="col-md-9 pt-2">
                                    <!-- <select data-toggle="select2" required id="addSTID2021" name="addSTID2021" 
                                    > -->
                                    <!-- Code to hide this value is required when state/ut name is selected -->
                                    <select data-toggle="select2" <?php if ($_GET['come']=='comefromdocadd' ) { ?>
                                        disabled
                                        <?php } ?> required id="addSTID2021" name="addSTID2021"
                                        onchange="return get_dist_select_data(this,'
                                        <?php echo $passvalue; ?>');">

                                        <option value="">Select State / UT Name</option>


                                        <?php foreach ($sql_data_all as $key => $element) { ?>

                                        <?php if ($rows['assignlist'] == $element['STID']) { ?>
                                        <option value="<?php echo $element['STID']; ?>" Selected="Selected" <?php } ?>>
                                            <?php echo $element['STName']; ?>
                                        </option>

                                        <?php if ($_SESSION['login_type'] == "0") { ?>

                                        <option value="<?php echo $element['STID']; ?>">
                                            <?php echo $element['STName']; ?>
                                        </option>
                                        <?php } ?>



                                        <?php } ?>


                                    </select>

                                </div>

                            </div>

                            <!-- <div class="form-group row">
                                <label class="col-md-3 col-form-label">Login ID</label>
                                
                                <div class="col-md-3">
                                    <input class="form-control" type="text" id="addusername" name="addusername" value=""
                                        placeholder="Enter Login ID"data-parsley-pattern="^[a-zA-Z0-9-\s]+$" data-parsley-pattern-message="User ID can contain only alphabets and spaces." data-parsley-minlength="5" data-parsley-maxlength="16" style="width: 328%;" required>
                                </div>
                            </div> -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Officer's Name</label>

                                <div class="col-md-3">
                                    <input class="form-control" type="text" id="username" name="username" value=""
                                        placeholder="Enter Officer's  Name" data-parsley-pattern="^[a-zA-Z.\s]+$"
                                        data-parsley-pattern-message="Officer's Name can contain only alphabets and spaces."
                                        data-parsley-minlength="3" data-parsley-maxlength="25" style="width: 328%;"
                                        required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Designation</label>

                                <div class="col-md-3">
                                    <input class="form-control" type="text" id="adddesignation" name="adddesignation"
                                        value="" placeholder="Enter Officer's Designation"
                                        data-parsley-pattern="^[^<>]+$"
                                        data-parsley-pattern-message="Designation can contain only alphabets and spaces."
                                        data-parsley-minlength="3" data-parsley-maxlength="25" style="width: 328%;"
                                        required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Mobile Number</label>
                                <div class="col-md-3">
                                    <input class="form-control" type="number" id="addmobile" name="addmobile" value=""
                                        placeholder="Enter Mobile Number" data-parsley-minlength="1"
                                        data-parsley-maxlength="10" onkeypress="return validate(event)"
                                        data-parsley-pattern="^[6-9][0-9]{9}$"
                                        data-parsley-pattern-message="Invalid Mobile Number  OR  Mobile Number length should be 10"
                                        style="width: 328%;" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Email</label>

                                <div class="col-md-3">
                                    <input class="form-control" type="text" id="addemail" name="addemail" value=""
                                        placeholder="Enter Email " data-parsley-minlength="3"
                                        data-parsley-pattern="^[a-z](?:[a-z0-9_.-]*[a-z0-9])?$"
                                        data-parsley-pattern-message="Email ID is invalid" required> <br>

                                </div>

                                <div class="col-md-1 col-form-label">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="email1" name="emailType"
                                            value="@nic.in" checked>
                                        <label class="form-check-label" for="email1">@nic.in</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="email2" name="emailType"
                                            value="@gov.in">
                                        <label class="form-check-label" for="email2">@gov.in</label>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Password</label>
                                <div class="col-md-9">
                                    <div style="z-index: 9999;text-align: end; margin: 0px 10px -30px 0px;">
                                        <i class="fas fa-eye showpass" style="cursor: pointer;"></i>
                                    </div>
                                    <input type="password" autocomplete="new-password" class="form-control"
                                        name="addpassword" data-parsley-length="[8, 16]" data-parsley-uppercase="1"
                                        data-parsley-lowercase="1" data-parsley-number="1" data-parsley-special="1"
                                        data-parsley-pattern="^(?=[^\W_])(?!.*[\W_ ]$).*$"
                                        data-parsley-pattern-message="Password should not begin or end with special characters or spaces."
                                        id="addpassword" required placeholder="Enter Password" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Confirm Password</label>
                                <div class="col-md-9" style="position:relative;">
                                    <input class="form-control" autocomplete="off" type="password"
                                        data-parsley-equalto="#addpassword" data-parsley-required="true" id="ncpassword"
                                        name="ncpassword" value="" data-parsley-length="[8, 16]"
                                        placeholder="Enter Confirm password" required>
                                    <div style="z-index: 9999;
                        width: fit-content;
                        
                        margin: 0 10px 0px 0px;
                        position:absolute;
                        left: 93%;
                        top: 10px;">
                                        <i class="fas fa-eye showpass2" style="cursor: pointer;"></i>
                                    </div>

                                </div>

                            </div>


                        </div><!-- end col -->

                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect closepop" data-dismiss="modal"
                        onclick="refreshPage()">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-info waves-effect waves-light">Save</button>
                </div>
            </form>
        </div>

    </div>
</div>

<!-- Cancel button refresh -->
<script>
    function refreshPage() {
        location.reload();
    }
</script>

<div id="resetcon-close-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form enctype="multipart/form-data" class="form-horizontal group-border-dashed parsley-examples"
                id="resetupdateusers">

                <input type="hidden" name="userids" id="userids" value="">

                <div class="modal-header bg-primary">
                    <!-- reset password functionallt eye icon resolved by shashi** -->
                    <h5 class="modal-title text-white">Reset Password</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">New Password</label>
                                <div class="col-md-9" style="position:relative;">
                                    <input class="form-control" type="password" data-parsley-required="true"
                                        id="npassword" autocomplete="off" name="npassword" value=""
                                        data-parsley-length="[8, 16]" data-parsley-uppercase="1"
                                        data-parsley-lowercase="1" data-parsley-number="1" data-parsley-special="1"
                                        placeholder="Enter password" required>

                                    <div style="z-index: 9999;
            width: fit-content;
            
            margin: 0 10px 0px 0px;
            position:absolute;
            left: 93%;
            top: 10px;">
                                        <i class="fas fa-eye showpass1" style="cursor: pointer;"></i>
                                    </div>

                                </div>

                            </div>

                            <div class="form-group row">
                                <!-- reset password functionallt eye icon resolved by shashi** -->

                                <label class="col-md-3 col-form-label">Confirm Password</label>
                                <div class="col-md-9" style="position:relative;">
                                    <input class="form-control" autocomplete="off" type="password"
                                        data-parsley-equalto="#npassword" data-parsley-required="true" id="cpassword"
                                        name="cncpassword" value="" data-parsley-length="[8, 16]"
                                        placeholder="Enter Confirm password" required>
                                    <div style="z-index: 9999;
                        width: fit-content;
                        
                        margin: 0 10px 0px 0px;
                        position:absolute;
                        left: 93%;
                        top: 10px;">
                                        <i class="fas fa-eye showpass3" style="cursor: pointer;"></i>
                                    </div>

                                </div>

                            </div>
                        </div><!-- end col -->

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect closepop" data-dismiss="modal"
                        onclick="resetModal()">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-info waves-effect waves-light">Reset</button>
                </div>

            </form>
        </div>

    </div>
</div>



<script>
 //To refresh current page
 function resetModal() {
    // Clear the form data
    document.getElementById("resetupdateusers").reset();
    // Reset Parsley validation
    $('#resetupdateusers').parsley().reset();
    // Close the modal
    $('#resetcon-close-modal').modal('hide');  
}

//Password details to clear the filled details modified by Rithisha
// function clearAllPasswords() {
//     var passwordFields = document.querySelectorAll("input[type='password']");
//     for (var i = 0; i < passwordFields.length; i++) {
//         passwordFields[i].value = "";
//     }
// }


// movable Reuse description and Remarks  popup box modified By Shashi* // 
var popup1 = document.getElementById('popup1');
var popup2 = document.getElementById('popup2');
var isDragging1 = false;
var initialX1;
var initialY1;
var isDragging2 = false;
var initialX2;
var initialY2;

function startDragging1(event) {
  isDragging1 = true;
  initialX1 = event.clientX;
  initialY1 = event.clientY;
}
function stopDragging1() {
  isDragging1 = false;
}
function handleDragging1(event) {
  if (isDragging1) {
    var currentX = event.clientX;
    var currentY = event.clientY;
    var deltaX = currentX - initialX1;
    var deltaY = currentY - initialY1;
    var popupLeft = parseInt(popup1.style.left) + deltaX;
    var popupTop = parseInt(popup1.style.top) + deltaY;
    popup1.style.left = popupLeft + 'px';
    popup1.style.top = popupTop + 'px';
    initialX1 = currentX;
    initialY1 = currentY;
  }
}
function startDragging2(event) {
  isDragging2 = true;
  initialX2 = event.clientX;
  initialY2 = event.clientY;
}
function stopDragging2() {
  isDragging2 = false;
}
function handleDragging2(event) {
  if (isDragging2) {
    var currentX = event.clientX;
    var currentY = event.clientY;
    var deltaX = currentX - initialX2;
    var deltaY = currentY - initialY2;
    var popupLeft = parseInt(popup2.style.left) + deltaX;
    var popupTop = parseInt(popup2.style.top) + deltaY;
    popup2.style.left = popupLeft + 'px';
    popup2.style.top = popupTop + 'px';
    initialX2 = currentX;
    initialY2 = currentY;
  }
}
popup1.addEventListener('mousedown', startDragging1);
document.addEventListener('mouseup', stopDragging1);
document.addEventListener('mousemove', handleDragging1);

popup2.addEventListener('mousedown', startDragging2);
document.addEventListener('mouseup', stopDragging2);
document.addEventListener('mousemove', handleDragging2);


//Function to allow only numbers to textbox modified by sahana
function validate(key)
{
//getting key code of pressed key
var keycode = (key.which) ? key.which : key.keyCode;
var phn = document.getElementById('addmobile');
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

