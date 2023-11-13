<?php include ("header.php"); include ("topbar.php"); include ("menu.php"); 
  
             
// $where = ''; 
// $action = ""; 
// if($header!=0 && $rows['assignlist']!=null)   
// {
//     if($rows['adminassigntype']!="ST") 
//     { 
//      $passvalue = $rows['assignlist'];   
//     } 
    
//     $action = 'where "documentdata'.$_SESSION['activeyears'].'"."docstid" = '.$rows['assignstids'].' and docids IN (select docids from documentlink'.$_SESSION['activeyears'].' where linkstids = '.$rows['assignstids'].')';
//     $where = ' AND  "STID'.$_SESSION['activeyears'].'" in ('.$rows['assignstids'].')';
// }
// else
// {
//     $action = "";  

// } 

// $where11='';
if($header!=0 && $rows['assignlist']!=null)   
{
// $where = ' AND  "STID" in ('.$rows['assignlist'].')';
// $where11 = ' AND  "docstid" in ('.$rows['assignlist'].')';


$qu = 'select * from "documentdata'.$_SESSION['activeyears'].'" ';
$result = pg_query($db,$qu );


$array11 = array('1',$rows['assignlist']);
$query = 'select "STID","STName" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 AND  "STID" in ($2) order by "STID" ASC';
 $resultstatelk = pg_query_params($db, $query,$array11);
 $row = pg_fetch_all($resultstatelk); 

$array22 = array('1','0','0',$rows['assignlist']);
 $querydoc = 'select * from "documentdata'.$_SESSION['activeyears'].'" where is_deleted=$1 AND docstatus=$2 AND link_docids=$3 AND  "docstid" in ($4) order by "docids" DESC';
 $resultstatelkdoc = pg_query_params($db, $querydoc,$array22);
 $rowdoc = pg_fetch_all($resultstatelkdoc); 

$array33 = array('1','1');
$querydoc1 = 'select * from "documentdata'.$_SESSION['activeyears'].'" where is_deleted=$1 AND docstatus=$2 order by "docids" DESC';
$resultstatelkdoc1 = pg_query_params($db, $querydoc1,$array33);
$rowdoc111= pg_fetch_all($resultstatelkdoc1); 

$array44 = array('ST','1');
$resultaction = pg_query_params($db, "select * from detailforread where comefrom=$1  and is_deleted=$2 order by statuslevel ASC",$array44);
$rowaction = pg_fetch_all($resultaction);
}
else {
    $qu = 'select * from "documentdata'.$_SESSION['activeyears'].'" ';
$result = pg_query($db,$qu );

$array11 = array('1');
$query = 'select "STID","STName" from "st'.$_SESSION['activeyears'].'" where is_deleted=$1 order by "STID" ASC';
 $resultstatelk = pg_query_params($db, $query,$array11);
 $row = pg_fetch_all($resultstatelk); 

$array22 = array('1','0','0');
 $querydoc = 'select * from "documentdata'.$_SESSION['activeyears'].'" where is_deleted=$1 AND docstatus=$2 AND link_docids=$3 order by "docids" DESC';
 $resultstatelkdoc = pg_query_params($db, $querydoc,$array22);
 $rowdoc = pg_fetch_all($resultstatelkdoc); 

$array3 = array('1','1');
$querydoc1 = 'select * from "documentdata'.$_SESSION['activeyears'].'" where is_deleted=$1 AND docstatus=$2 order by "docids" DESC';
$resultstatelkdoc1 = pg_query_params($db, $querydoc1,$array3);
$rowdoc111= pg_fetch_all($resultstatelkdoc1); 

$array4 = array('ST','1');
$resultaction = pg_query_params($db, "select * from detailforread where comefrom=$1  and is_deleted=$2 order by statuslevel ASC",$array4);
$rowaction = pg_fetch_all($resultaction); 

}



?>
<style type="text/css">
.dataTables_scrollBody {
    max-height: 550px !important;
}
</style>
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

                          
                            <h4 class="header-title mb-4"><span class="dropcap1 text-primary">Add Document</span>
                            </h4>

                    

                                      

                                 
                                            <div id="progressbarwizard1">

                                                <ul class="nav nav-tabs nav-justified form-wizard-header mb-3">
                                                    <li class="nav-item">
                                                        <a href="#account-2" data-toggle="tab" style="pointer-events: none;" class="nav-link rounded-0 pt-2 pb-2">
                                                            <i class="mdi mdi-account-circle mr-1"></i>
                                                            <span class="d-none d-sm-inline">Document</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#profile-tab-2" data-toggle="tab" style="pointer-events: none;" class="nav-link rounded-0 pt-2 pb-2">
                                                            <i class="mdi mdi-face-profile mr-1"></i>
                                                            <span class="d-none d-sm-inline">Action</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#finish-2" data-toggle="tab" style="pointer-events: none;" class="nav-link rounded-0 pt-2 pb-2">
                                                            <i class="mdi mdi-checkbox-marked-circle-outline mr-1"></i>
                                                            <span class="d-none d-sm-inline">Finish</span>
                                                        </a>
                                                    </li>
                                                    <!-- <li class="nav-item">
                                                        <a href="#finish-2" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                                            <i class="mdi mdi-checkbox-marked-circle-outline mr-1"></i>
                                                            <span class="d-none d-sm-inline">Finish</span>
                                                        </a>
                                                    </li> -->
                                                </ul>
                                             
                                                <div class="tab-content b-0 mb-0">
                                            
                                                  <!--   <div id="bar" class="progress mb-3" style="height: 7px;">
                                                        <div class="bar progress-bar progress-bar-striped progress-bar-animated bg-success"></div>
                                                    </div> -->
                                            
                                                    <div class="tab-pane" id="account-2">
                                                        <div class="row">
                                                      <div class="col-6">
                                                            <form enctype="multipart/form-data" class="form-horizontal group-border-dashed" data-parsley-validate
                novalidate data-parsley-trigger="keyup" id="adddocument">
                <input type="hidden" name="formname" id="formname" value="adddocumentdata">
                <input type="hidden" name="adddocnew" id="adddocnew" value="">
                <input type="hidden" name="doctype" id="doctype" value="<?php if(isset($_GET['doctype'])) { echo $_GET['doctype']; }  ?>">
                                                               <fieldset class="let">
                                <legend class="chha">Select Pending Document</legend> 
                                                                <div class="form-group row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="userName1">Select  Document </label>
                                                                    <div class="col-md-9">
                                                                       <select <?php if($_GET['come']=='comefromdocadd') { ?> disabled <?php } ?> data-toggle="select2" id="selectdocumnent" name="selectdocumnent"
                                            onchange="return getselecteddocument(this.value,'');">
                                            <option value="">Select Document</option>
                                            <?php foreach ($rowdoc as $key1 => $element1) { ?>
                                            <option value="<?php echo $element1['docids']; ?>">
                                                <?php echo $element1['doctitle']." - ".$element1['docdate']; ?></option>
                                            <?php } ?>
                                        </select>
                                                                    </div>
                                                                </div>
                                                            </fieldset>
                                                               <div class="row">
                                                                    <label class="col-md-12 col-form-label text-center" for="userName1"><h4>Or</h4></label>
                                                                    
                                                                </div>
                                                            <fieldset class="let" >
                           
                                                            <legend class="chha">New Document</legend>
                                                                 

                                                                <div class="form-group row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="userName1">State / UT Name</label>
                                                                    <div class="col-md-9">
                                                                       <select data-toggle="select2" <?php if($_GET['come']=='comefromdocadd') { ?> disabled <?php } ?> required id="addSTID2021" name="addSTID2021"
                                            onchange="return get_dist_select_data(this,'<?php echo $passvalue; ?>');">
                                            <option value="">Select State / UT Name</option>
                                            
                                              <?php foreach ($row as $key => $element) { ?>
                                            <option value="<?php echo $element['STID']; ?>" <?php if(pg_numrows($resultstatelk)==1){ ?> selected <?php } ?> >
                                                <?php echo $element['STName']; ?></option>
                                            <?php } ?>
                                        </select>
                                                                    </div>
                                                                </div>
                                                                

                                                                <div class="form-group row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="confirm1">Upload Document</label>
                                                                    <div class="col-md-9">
                                                                        <input type="file" onchange="PreviewImage1();" required="required" id="adddocnotification"
                                            name="adddocnotification" accept="application/pdf" class="dropify" />
                                                                    </div>
                                                                </div>



                                                                <div class="form-group row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="password1"> Type</label>
                                                                    <div class="col-md-9">
                                                       
                                                          <!-- <select required="required" id="adddoctype" <?php if($_GET['come']=='comefromdocadd') { ?> disabled <?php } ?>  name="adddoctype"
                                                                       onchange="return get_dist_select_data(this,'<?php echo $passvalue; ?>');">
                                            <option value="">Select Type</option>
                                            <option value="Notification">Notification</option>
                                            <option value="Corrigendum Notification">Corrigendum Notification</option>
                                            <option value="Resolution">Resolution</option>
                                            <option value="Clarification">Clarification</option>
                                            <option value="Collector Letter">Collector Letter</option>
                                            <option value="Others">Others</option>
                                        </select> -->
                                           <!-- adddocument type -->
                                        <select required="required" id="adddoctype" <?php if($_GET['come']=='comefromdocadd') { ?> disabled <?php } ?>  name="adddoctype"
                                            onchange="return get_doctype_data(this,'<?php echo $_GET['come']; ?>');">
                                            <option value="">Select Type</option>
                                            <option value="Notification">Notification</option>
                                            <option value="Erratum Notification">Erratum Notification</option>
                                            <option value="Resolution">Resolution</option>
                                            <option value="Clarification">Clarification</option>
                                            <option value="Collector Letter">Collector Letter</option>
                                            <option value="Others">Others</option>
                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="otherrmk" style="display: none;">
                                                                <div class="form-group row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="confirm1">Specify the Type</label>
                                                                    <div class="col-md-9">
                                                                       <textarea class="form-control otherrmk" data-parsley-pattern="^[a-zA-Z\s]+$" data-parsley-pattern-message="Input text can contain only alphabets and spaces." placeholder="Specify the Type" rows="4"
                                            id="otherremarks" name="otherremarks"></textarea>
                                                                    </div>
                                                                   
                                                                </div>
                                                                </div>
                                                                <div class="sdoc" style="display: none;">
                                                                <div class="form-group row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="userName1">Select Document</label>
                                                                    <div class="col-md-9">
                                                                       <select data-toggle="select2" <?php if($_GET['come']=='comefromdocadd') { ?> disabled <?php } ?> class="sdoc"  id="selectdocumnent_releted" name="selectdocumnent_releted">
                                            <option value="">Select Document</option>
                                            <?php foreach ($rowdoc111 as $key11 => $element11) { ?>
                                            <option value="<?php echo $element11['docids']; ?>">
                                                <?php echo $element11['doctitle']." - ".$element11['docdate']; ?></option>
                                            <?php } ?>
                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="userName1">Action Needed </label>
                                                                    <div class="col-md-9 pt-2">
                                                                        
                                                                       <input type="checkbox" name="haveaaction" id="haveaaction"> 
                                                                       <input type="hidden" name="stat" value="<?php echo $stat; ?>">


                                                                    </div>
                                                                </div>


                                                                </div>

                                                                
                                                                <!-- <div class="form-group row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="confirm1">Document Date</label>
                                                                    <div class="col-md-9">
                                                                       <input type="text" class="form-control" placeholder="dd-mm-yyyy"
                                                data-provide="datepicker" id="adddocdate" name="adddocdate" required="required" 
                                                data-date-autoclose="true" autocomplete="false">
                                         
                                                                    </div>
                                                                </div> -->

<div class="form-group row mb-3">
    <label class="col-md-3 col-form-label" for="confirm1">Document Date</label>
    <div class="col-md-9">
                <!-- document value alert removal -->

        <input type="text" class="form-control datepicker" placeholder="dd-mm-yyyy" data-provide="datepicker" id="adddocdate" name="adddocdate" required="required" data-date-autoclose="true" autocomplete="off"
        onchange="return get_dist_select_data(this,'<?php echo $passvalue; ?>');"> 
        <!-- <?php if ($_GET['come'] == 'comefromdocadd') { echo 'value="' . $yourDesiredDate . '"'; } ?>> -->
        <?php if ($_GET['come'] == 'comefromdocadd')  ?>
    </div>
</div>



                                                                 <div class="form-group row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="confirm1">Document No.</label>
                                                                    <div class="col-md-9">
                                                                       <input type="text" class="form-control"  name="adddoctitle" id="adddoctitle"
                                            required placeholder="Document No." data-parsley-pattern="^[^<>;]+$" data-parsley-pattern-message="'< >' OR ';' value seems to be invalid." data-parsley-minlength="2"  />
                                                                    </div>
                                                                </div>

                                                                    <div class="form-group row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="password1">Select the required action</label>
                                                                    <div class="col-md-9">
                                                                        <!-- document value alert removal -->
                                                                    <!-- <select required="required" id="adddockeydes" name="adddockeydes"> -->
                                                                    <select  id="adddockeydes" name="adddockeydes"   required=""
                                                                    onchange="return get_dist_select_data(this,'<?php echo $passvalue; ?>');">
                                                                    <option value="">Select the required action</option>
                                                                    <?php if($header==0 || $header==1)   
{ ?>
                                                                    <option value="Creation of State(s) / UT(s)">Creation of State(s) / UT(s)</option>
                        <?php } ?>
                                                                    <option value="Creation of District(s)">Creation of District(s)</option>
                                                                    <option value="Creation of Sub-district(s)">Creation of Sub-district(s)</option>
                                                                    <option value="Creation of Village(s) / Town(s)">Creation of Village(s) / Town(s)</option>
                                                                    <?php if($header==0 || $header==1)   
{ ?>
                                                                    <option value="Split / Merge / Partially Merge of State(s) / UT(s)">Split / Merge / Partially Merge of State(s) / UT(s) </option>
                        <?php } ?>
                                                                    <option value="Split / Merge / Partially Merge of District(s)">Split / Merge / Partially Merge of District(s)</option>
                                                                    <option value="Split / Merge / Partially Merge of Sub District(s)">Split / Merge / Partially Merge of Sub District(s)</option>
                                                                    <option value="Split / Merge / Partially Merge of Village(s) / Town(s)">Split / Merge / Partially Merge of Village(s) / Town(s)</option>
                                                                    <?php if($header==0 || $header==1)
{ ?>
                                                                    <option value="Rename / Status Change of State(s)/UT(s)">Rename / Status Change of State(s)/UT(s)</option>
                        <?php } ?>                          
                                                                    <option value="Rename the District(s)">Rename the District(s)</option>
                                                                    <option value="Rename the Sub District(s)">Rename the Sub District(s)</option>
                                                                    <option value="Rename / Status Change of Village(s) / Town(s)">Rename / Status Change of Village(s) / Town(s)</option>
                                                                   
                                                                    <option value="Move or Reshuffle the Sub District(s)">Move or Reshuffle the Sub District(s)</option>
                                                                    <option value="Move or Reshuffle the Village(s) / Town(s)">Move or Reshuffle the Village(s) / Town(s)</option>
                                                                   
                                                                    <option value="Addition of Village(s)">Addition of Village(s)</option>
                        
                                                                    <option value="Non Existence of the Village(s)">Non Existence of the Village(s)</option>
                                                                    <option value="Sub Merge of Village(s) / Town(s)">Sub Merge of Village(s) / Town(s)</option>
                                                                    <option value="Classified / Declassified the Civic Status">Classified / Declassified the Civic Status</option>
                                                                    <option value="Denotified Town(s)">Denotified Town(s)</option>
                                                                    <option value="Any other case, please specify">Any other case, please specify</option>
                                                                    </select>
                                                                    </div>
                                                                    </div>


                                                            <!-- modified by sahana This pattern matches alphabets (both uppercase and lowercase), numbers, parentheses, commas, periods and line breaks. -->

                                                                <div class="form-group row mb-3">
                                                                    <label class="col-md-3 col-form-label" for="confirm1">Description</label>
                                                                    <div class="col-md-9">
                                                                        <textarea class="form-control" required data-parsley-pattern="^[^<>;]+$" data-parsley-pattern-message="'< >' OR ';' value seems to be invalid." placeholder="Please specify" rows="4" id="docdescription" name="docdescription"></textarea>
                                                                    </div>
                                                                </div>

                                                            </fieldset>


                                                            </div> <!-- end col -->
                                                        <div class="col-6"> <iframe style="display:none;" id="viewer" frameborder="1"  width="100%" height="650"></iframe></div>    

                                                        
                                                            <div class="col-12"><button type="submit" name="submit" class="btn btn-info btn-rounded waves-effect waves-light float-right width-xl mt-2">SAVE</button> </div>
                                                            
                                                           </form>
                                                      
                                                        </div> <!-- end row -->
                                                        
                                                    </div>

                                                    <div class="tab-pane" id="profile-tab-2">
                                                        <div class="row">
                                                            <div class="col-5">  <iframe id="viewerlast" frameborder="1"  width="100%" height="530"></iframe></div>
                                                            <div class="col-7">

                                                        <div class="form-group row mb-3">
                                                                <label class="col-md-3 col-form-label" for="confirm1">Document Apply On</label>
                                                                <div class="col-md-9 row">
                                                                           <?php if($rows['admin_type']!=2 && $rows['admin_type']!=3) { ?>
                                                                            <div class="mt-2 col-md-3">
                                                                                <input id="checkboxstate" name="startfrom" type="radio" value="State">
                                                                                <label for="checkbox2">
                                                                                    State / UT
                                                                                </label>

                                                                            </div>
                                                                        <?php } ?>
                                                                            <div class="mt-2 col-md-3">
                                                                                <input id="checkboxdistrict" name="startfrom" type="radio" value="District">
                                                                                <label for="checkbox2">
                                                                                    District
                                                                                </label>
                                                                                
                                                                            </div>

                                                                            <div class="mt-2 col-md-3">
                                                                                <input id="checkboxsdistrict" name="startfrom" type="radio" value="Sub-District">
                                                                                <label for="checkbox2">
                                                                                    Sub-District
                                                                                </label>
                                                                                
                                                                            </div>

                                                                            <div class="mt-2 col-md-3">
                                                                                <input id="checkboxvillage" name="startfrom" type="radio" value="Village / Town">
                                                                                <label for="checkbox2">
                                                                                    Village / Town
                                                                                </label>
                                                                                
                                                                            </div>

                                                                            <!-- <div class="mt-2 col-md-2">
                                                                                <input id="checkboxward" name="startfrom" type="radio" value="Ward">
                                                                                <label for="checkbox2">
                                                                                    Ward
                                                                                </label>
                                                                                
                                                                            </div> -->

                                                                    </div>
                                                        </div> 


                                                        

<!-- 
                                                        <div class="form-group row mb-3">
                                                                <label class="col-md-3 col-form-label" for="confirm1">Select Sassigndatatate</label>
                                                                <div class="col-md-9">

                                                                    <select data-toggle="select2" required id="addSTID2021" name="addSTID2021"
                                                                    onchange="return get_dist_select_data(this,'<?php //echo $passvalue; ?>');">
                                                                    <option value="">Select State Name</option>
                                                                    <?php //foreach ($row as $key => $element) { ?>
                                                                    <option value="<?php //echo $element['STID2021']; ?>">
                                                                    <?php //echo $element['STName2021']; ?></option>
                                                                    <?php //} ?>
                                                                    </select>     

                                                                </div>
                                                            </div> -->
                                                            <div id="actionuse" style="display:none;">
                                                        <div class="form-group row mb-3">
                                                            <label class="col-md-2 col-form-label" for="confirm1">Action Use</label>
                                                                <div class="col-md-10">
                                                                    <div class="col-md-12 row">

                                                                        <div class="col-sm-12 col-md-6 col-lg-6 pl-0 pt-2 col-xl-4">

                                                                            <button type="button"  onclick="createnew('Create')" name="createnew" class="btn btn-primary btn-rounded waves-effect waves-light width-xl disbut" id="Create" >Create New</button>

                                                                        </div>
                                                                        <div class="col-sm-12 col-md-6 col-lg-6 pl-0 pt-2 col-xl-4">
                                                                            
                                                                            <button type="button" onclick="createnew('Merge')" name="mergenew" class="btn btn-primary btn-rounded waves-effect waves-light width-xl disbut" id="Mergebt">Merge / Partially Merge</button>

                                                                        </div>
                                                                        <div class=" col-sm-12 col-md-6 col-lg-6 pl-0 pt-2 col-xl-4">

                                                                            <button type="button" onclick="createnew('Partiallysm')" name="mergenew" class="btn btn-primary btn-rounded waves-effect waves-light width-xl disbut" id="Partiallysm">Partially Incomplete</button>

                                                                        </div>
                                                                         <div class="col-sm-12 col-md-6 col-lg-6 pl-0 pt-2 col-xl-4">
                                                                            
                                                                            <button type="button" name="Rename" class="btn btn-primary btn-rounded waves-effect waves-light width-xl disbut" onclick="createnew('Rename')" id="Rename">Rename/Status Change</button>

                                                                        </div>
                                                                        <div class="col-sm-12 col-md-6 col-lg-6 pl-0 pt-2 col-xl-4">
                                                                            
                                                                            <button type="button" onclick="submerge('submerge')" name="mergenew" class="btn btn-primary btn-rounded waves-effect waves-light width-xl disbut" id="submerge">Sub-Merge</button>

                                                                        </div>
                                                                         <div class="col-sm-12 col-md-6 col-lg-6 pl-0 pt-2 col-xl-4">
                                                                            
                                                                            <button type="button" onclick="createnew('Reshuffle')" name="mergenew" class="btn btn-primary btn-rounded waves-effect waves-light width-xl disbut" id="Reshuffle">Move / Reshuffle</button>

                                                                        </div>
                                                                       <div class="col-sm-12 col-md-6 col-lg-6 pl-0 pt-2 col-xl-4">
                                                                            
                                                                            <button type="button" name="Addition" onclick="createnew('Addition')" class="btn btn-primary btn-rounded waves-effect waves-light width-xl disbut" id="Addition">Addition</button>

                                                                        </div>
                                                                        <div class="col-sm-12 col-md-6 col-lg-6 pl-0 pt-2 col-xl-4">
                                                                            
                                                                            <button type="button" name="Deletion" onclick="createnew('Deletion')" class="btn btn-primary btn-rounded waves-effect waves-light width-xl disbut" id="Deletion">Deletion</button>

                                                                        </div>
                                                                        <div class="col-sm-12 col-md-6 col-lg-6 pl-0 pt-2 col-xl-4">
                                                                            
                                                                            <button type="button" name="mergenew" class="btn btn-primary btn-rounded waves-effect waves-light width-xl disbut" id="Declassified">Denotified</button>

                                                                        </div>
                                                                        

                                                                    </div>
                                                                    
                                                                   
                                                                   

                                                                    
                                                                
                                                                </div>
                                                                 </div>
                                                       
</div>
 <form enctype="multipart/form-data" class="form-horizontal group-border-dashed" data-parsley-validate
                novalidate data-parsley-trigger="keyup" id="adddocumentnext">

<input type="hidden" name="formname" id="formname" value="finaladddocument">
<input type="hidden" name="applyon" id="applyon" value="">
<!-- JC_11 Modified By Arul Add Button-->
<input type="hidden" name="rowno" id="rowno" value="1">
<!-- <input type="hidden" name="selectstid" id="selectstid" value="">
<input type="hidden" name="selectstidupdated" id="selectstidupdated" value="">
 <input type="hidden" name="dtstname" id="dtstname" value="">
  <input type="hidden" name="dtselected" id="dtselected" value="">
    <input type="hidden" name="sdidsselected" id="sdidsselected" value=""> -->
     
  <input type="hidden" name="fstids" id="fstids" value="">
  <input type="hidden" name="fdtids" id="fdtids" value="">
  <input type="hidden" name="fsdids" id="fsdids" value="">
  <input type="hidden" name="fvtids" id="fvtids" value="">
  <input type="hidden" name="tstids" id="tstids" value="">
  <input type="hidden" name="tdtids" id="tdtids" value="">
  <input type="hidden" name="tsdids" id="tsdids" value="">

  <input type="hidden" name="flagof" id="flagof" value="false">
  <input type="hidden" name="partiallyids" id="partiallyids" value="">

  <input type="hidden" name="clickbuttonmid" id="clickbuttonmid" value="">
  
<input type="hidden" name="returndata" id="returndata" value="">
<input type="hidden" name="uploadeddocument" id="uploadeddocument" value="">
<div class="form-group row" id="daynamor">
    
</div>

 <div class="col-12" id="nextstep2" style="visibility: hidden;">
    <button type="submit"  name="submit" class="btn btn-info btn-rounded waves-effect waves-light width-xl float-right mt-2">NEXT</button>
    <button type="button"  name="BACK" onclick="return reloadpage();" class="btn btn-secondary btn-rounded waves-effect waves-light width-xl float-right mt-2 mr-2">BACK</button>

</div>
 


</form>



                                                            </div> <!-- end col -->
                                                           <div class="col-12" id="nextstep2">
   <button type="button" style="visibility: hidden;"  name="back" id="backbtnnew" class="btn btn-secondary btn-rounded waves-effect waves-light width-xl float-right mt-2 mr-2">BACK</button>

</div> 
                                                        </div> <!-- end row -->

                                                        

                                                    </div>

                                                     <div class="tab-pane" id="finish-2">
                                                        <form enctype="multipart/form-data" class="form-horizontal group-border-dashed" data-parsley-validate
                novalidate data-parsley-trigger="keyup" id="finalsubmitdocumentdata">
                                                        <input type="hidden" name="clickbutton" id="clickbutton">
                                                        <div class="row">
                                                             <div class="col-5">  <iframe id="viewerlaststep" frameborder="1"  width="100%" height="530"></iframe></div>
                                                            <div class="col-7">

                                                                 <div class="text-center">
                                                                    <i class="mdi mdi-check-all h2 text-success mt-0"></i>
                                                                    <h3 class="mt-0">Summary !</h3>

                                                                    <p class="w-75 mb-2 mx-auto" id="maintitledata"></p>
                                                                   
                                                                        <div class="table-responsive" id="mainaction">
                                                                      
                                                                    </div>
                                                                    <p class="w-75 mb-2 mx-auto" id="subtitle"></p>
                                                                    
                                                                    <input type="hidden" name="finaldata" id="finaldata">
                                                                    <input type="hidden" name="flagof" id="flagof" value="false">
                                                                     <input type="hidden" name="reusecome" id="reusecome" value="<?php echo $_GET['come']; ?>">
                                                                     <input type="hidden" name="reusedocids" id="reusedocids" value="<?php echo $_GET['idsdoc']; ?>">
                                                                    <input type="hidden" name="formname" id="formname" value="finaladddoc">
                                                                    <div class="mb-4"> 
                                                                        <div class="custom-control custom-checkbox mt-2 mb-4">
                                                                            <input type="checkbox" required class="custom-control-input" id="customCheck3" name="agree">
                                                                            <label class="custom-control-label" for="customCheck3">I have made all Jurisdictional Change(s)  as per Notification / Corrigendum / Resolution. </label>


                                                                           
                                                                        </div>
                                                                        <!-- <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input" id="docagain" name="docagain">
                                                                            <label class="custom-control-label" for="customCheck3">Use "<span id="docname" ></span>" <span id="doctype">Notification / Corrigendum / Resolution</span> again.</label>

                                                                            
                                                                           
                                                                        </div> -->
                                                                    </div>
                                                                </div>
                                                              
                                                            </div> <!-- end col -->
                                                               <div class="col-12" id="nextstep3" style="visibility: hidden;">

 
    <button type="submit"  name="submit" class="btn btn-info btn-rounded waves-effect waves-light width-xl float-right mt-2" id="FINISHDATA">FINISH</button>
   <button type="button"  name="back" id="backbtn" class="btn btn-secondary btn-rounded waves-effect waves-light width-xl float-right mt-2 mr-2">BACK</button>
</div>

<!-- modified by gowthami to uncheck the check box when click on back button -->
<script>
  
  const checkbox = document.getElementById("customCheck3");
  const backButton = document.getElementById("backbtn");
  backButton.addEventListener("click", function() {
    checkbox.checked = false;
  });
</script>
                                                        </div> <!-- end row -->
                                                        </form>
                                                    </div>

                                                   

                                                </div> <!-- tab-content -->
                                            </div> <!-- end #progressbarwizard-->
                                  

                                   


                            
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

    
    $(document).ready(function() {

      


<?php if(isset($_GET) && $_GET['ids']!='')
{ 

    $datof = json_decode(base64_decode($_GET['ids']),true);
    //   print_r($datof);

    ?>
        
        $('#progressbarwizard1').bootstrapWizard('next');

        $('#Merge').prop('disabled', true);
        $('#Partiallysm').prop('disabled', false);



        $('#docids').val('<?php echo $datof['docids']; ?>');
        $('#docidsmrg').val('<?php echo $datof['docids']; ?>');
        $('#docidsmrgp').val('<?php echo $datof['docids']; ?>');
  

        // $('#dtselected').val('<?php //echo $datof['fromids']; ?>');
        // $('#sdidsselected').val('<?php //echo $datof['partiallydataids']; ?>');
        // $('#selectstid').val('<?php //echo $datof['docstid']; ?>');
        // $('#selectstidupdated').val('<?php //echo $datof['toids']; ?>');
         $('#flagof').val(true);

        $('#fstids').val('<?php echo $datof['STID']; ?>');
        $('#fdtids').val('<?php echo $datof['DTID']; ?>');
        $('#fsdids').val('<?php echo $datof['SDID']; ?>');
        $('#fvtids').val('<?php echo $datof['VTID']; ?>');

        $('#tstids').val('<?php echo $datof['STIDS']; ?>');
        $('#tdtids').val('<?php echo $datof['DTIDS']; ?>');
        $('#tsdids').val('<?php echo $datof['SDIDS']; ?>');

        $('#partiallyids').val('<?php echo $datof['partiallyids']; ?>');
        $('#partiallyids1').val('<?php echo $datof['partiallyids']; ?>');
        $('#mpartiallyids').val('<?php echo $datof['partiallyids']; ?>');
        $('#mpartiallyidsp').val('<?php echo $datof['partiallyids']; ?>');
        
        $('#viewerlast').css("display", "block");
        $('#pdf').css("display", "block")
        $('#viewerlast').attr('src','<?php echo "Alldocuments/".$datof['docstid']."/".$datof['docnotification']; ?>');
        $('#uploadeddocument').val('<?php echo "Alldocuments/".$datof['docstid']."/".$datof['docnotification']; ?>');
        $('#uploadeddocumentmrg').val('<?php echo "Alldocuments/".$datof['docstid']."/".$datof['docnotification']; ?>');
        $('#uploadeddocumentmrgp').val('<?php echo "Alldocuments/".$datof['docstid']."/".$datof['docnotification']; ?>');


        <?php if($datof['comefrom']=='State') { ?>
                $('#checkboxstate').attr('disabled',true);
                $('#checkboxsdistrict').attr('disabled',true);
                 $('#checkboxvillage').attr('disabled',true);
                $('#dtstname').val('<?php echo $datof['STNameof']; ?>');
        $('#didsmrgname').val('<?php echo $datof['STNameof']; ?>');
        <?php } else if($datof['comefrom']=='District') { ?>
            $('#checkboxstate').attr('disabled',true);
            $('#checkboxdistrict').attr('disabled',true);
             $('#checkboxvillage').attr('disabled',true);
           // $('#dtstname').val('<?php // echo $datof['STName']; ?>');
        $('#didsmrgname').val('<?php echo $datof['STName']; ?>');
        <?php } else if($datof['comefrom']=='Sub-District') { ?>
             $('#checkboxstate').attr('disabled',true);
            $('#checkboxdistrict').attr('disabled',true);
            $('#checkboxsdistrict').attr('disabled',true);

        <?php } ?>

<?php } else if(isset($_GET) && $_GET['idsdoc']!='') { 

    ?>
    $('#Mergebt').prop('disabled', false);
    $('#Partiallysm').prop('disabled', true);
<?php 
if($_GET['come']=='comefromdoc' && $_GET['doctype']=='')
{ ?>
 $('#selectdocumnent').val(<?php echo $_GET['idsdoc']; ?>).trigger('change');   
<?php 
}
else if($_GET['come']=='comefromdoc' && $_GET['doctype']!='')
{ ?>
getselecteddocument(<?php echo $_GET['idsdoc'] ?>,'');
   
<?php 
}
else if($_GET['come']=='comefromdocadd')
{ ?>
redirectcompleted(<?php echo $_GET['idsdoc']; ?>,'comefromdocadd','<?php echo $_GET['doctype']; ?>');
<?php 
}
else
{
    ?>

    redirectcompleted(<?php echo $_GET['idsdoc']; ?>);
   
<?php 
}
?>

 
<?php } else { ?>

 $('#Mergebt').prop('disabled', false);
 $('#Partiallysm').prop('disabled', true);
<?php } ?>
                $('input[type="radio"]').click(function() {
                    var inputValue = $(this).attr("value");

                     <?php if($datof['comefrom']=='State') { ?>
                $('#checkboxstate').attr('disabled',true);
                $('#checkboxsdistrict').attr('disabled',true);
                 $('#checkboxvillage').attr('disabled',true);
                $('#dtstname').val('<?php echo $datof['STNameof']; ?>');
        $('#didsmrgname').val('<?php echo $datof['STNameof']; ?>');
        <?php } else if($datof['comefrom']=='District') { ?>
            $('#checkboxstate').attr('disabled',true);
            $('#checkboxdistrict').attr('disabled',true);
             $('#checkboxvillage').attr('disabled',true);
           // $('#dtstname').val('<?php // echo $datof['STName']; ?>');
        $('#didsmrgname').val('<?php echo $datof['STName']; ?>');
        <?php } else if($datof['comefrom']=='Sub-District') { ?>
             $('#checkboxstate').attr('disabled',true);
            $('#checkboxdistrict').attr('disabled',true);
            $('#checkboxsdistrict').attr('disabled',true);

        <?php } ?>

$('.disbut').prop('disabled', false);

                 
                 

                  if(inputValue=='State' || inputValue=='District')
                  {
                  
                     $('#submerge').prop('disabled', true);
     $('#Reshuffle').prop('disabled', true);
     $('#Addition').prop('disabled', true);
     $('#Deletion').prop('disabled', true);
       $('#Declassified').prop('disabled', true);
                  }
                  else  if(inputValue=='Village / Town')
                  {
                    $('#Addition').prop('disabled', false);
                     $('#submerge').prop('disabled', false);

                    
     $('#Reshuffle').prop('disabled', false);
     $('#Addition').prop('disabled', false);
     $('#Deletion').prop('disabled', false);
       $('#Declassified').prop('disabled', true);

                  }
                   else
                  {
                   $('#Reshuffle').prop('disabled', false);
                    $('#Addition').prop('disabled', true);
                    $('#submerge').prop('disabled', true);
                    $('#Deletion').prop('disabled', true);
                       $('#Declassified').prop('disabled', true);
                  }
                 

              

              //      $('#Partiallysm').prop('disabled', true);
                 $('#applyon').val(inputValue);
                  $('#actionuse').css("display", "block");

 <?php if(isset($_GET) && $_GET['ids']!='') { ?>
   
    $('#Mergebt').prop('disabled', true);
    $('#Partiallysm').prop('disabled', false);
     $('#Rename').prop('disabled', true);
     $('#Deletion').prop('disabled', true);
    $('#Reshuffle').prop('disabled', true);
                    $('#Addition').prop('disabled', true);
                    $('#submerge').prop('disabled', true);
                       $('#Declassified').prop('disabled', true);

 // $('#selectdocumnent').val(<?php //echo $_GET['idsdoc']; ?>).trigger('change');
<?php } else if(isset($_GET) && $_GET['idsdoc']!='') { ?>
 $('#Mergebt').prop('disabled', false);
    $('#Partiallysm').prop('disabled', true);
    

<?php } else { ?>
$('#Mergebt').prop('disabled', false);
    $('#Partiallysm').prop('disabled', true);
   
<?php } ?>
                      
                  
    });
});

function PreviewImage1() {
    var pdffile = document.getElementById("adddocnotification").files[0];
    var pdffile_url = URL.createObjectURL(pdffile);
    $('#viewer').css("display", "block");
    $('#viewer').attr('src', pdffile_url);
}
//remove from Upload doc modified by gowthami
$(".dropify-clear").on("click", function() {
    $('#viewer').css("display", "none");
});


$(function() {

    // $('#adddocdate').datepicker({
    //     format: 'dd-mm-yyyy',
    //     todayHighlight: 'TRUE',
    //     autoclose: true,
    // //    endDate: '+0d',
    // })


    $('#docdate').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: 'TRUE',
        autoclose: true,
    endDate: '+0d',
    })


});
$('select').select2();

</script>

<!-- //modified by sahana to set document date between previous census and current census dates -->
<script>
$(function() {
    <?php
    $sql = "SELECT to_char(importantdate, 'dd-mm-yyyy') AS importantdatenew,
            to_char(previousdate, 'dd-mm-yyyy') AS previousimportantdate
            FROM importantdate
            WHERE impdate_year='".$_SESSION['activeyears']."'";
    $sql_qu = pg_query($db,$sql);
    $sql_qu_data = pg_fetch_array($sql_qu);
    $importantdate = $sql_qu_data['importantdatenew'];
    $previousdate = $sql_qu_data['previousimportantdate'];
    ?>
    var previousdate = "<?php echo $previousdate; ?>";
    var importantdate = "<?php echo $importantdate; ?>";
    var startDate;
    var endDate;
    // Check if it's comefromdocadd to have linkdocument and original document dates seperate
    <?php if ($_GET['come'] == 'comefromdocadd') { ?>
        // var startDate = moment().format('DD-MM-YYYY');
        startDate = moment(previousdate, 'DD-MM-YYYY').add(1, 'days').format('DD-MM-YYYY');
        endDate = moment(importantdate, 'DD-MM-YYYY').add(1, 'month').format('DD-MM-YYYY');
    <?php } else { ?>
        startDate = moment(previousdate, 'DD-MM-YYYY').add(1, 'days').format('DD-MM-YYYY');
        endDate = moment(importantdate, 'DD-MM-YYYY').toDate();
    <?php } ?>
    $('#adddocdate').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true,
        startDate: startDate,
        endDate: endDate,
        beforeShowDay: function(date) {
            // Disable dates after the current date
            var currentDate = new Date();
            if (date > currentDate) {
                return false;
            }
        }
    });
});
</script>

<script type="text/javascript">
$(function() {

    
    var maxField = 100;
      var maxField1 = 100;
  
    var x = 1;
    var y = 0;


 var x1 = 1;
    var y1 = 0;



    var addButton = $('.add_button');
 var addButton1 = $('.add_button_name');

    var wrapper = $('.field_wrapper');
    var wrapper_name = $('.field_wrapper_name');
   
    // var optionstate = '';
    //  optionstate +=
    //     '<option value = "">Select State</option>';
    // <?php  //foreach ($row as $key => $element) { 
    //     if($element['STID2021']==null)
    //     {
    //        $valueof = $element['STID2011'];
    //        $valueofname = $element['STName2011'];
    //     }
    //     else
    //     {
    //         $valueof = $element['STID2021'];
    //         $valueofname = $element['STName2021'];
    //     }
    //     ?>
   
    // optionstate +=
    //     '<option value = "<?php  //echo $valueof; ?>"><?php  //echo $valueofname; ?></option>';
    // <?php  // } ?>

   

    // var optionaction = '';
    // <?php  //foreach ($rowaction as $key => $element) { ?>
    // optionaction +=
    //     '<option value = "<?php  //echo $element['statuslevel']; ?>"><?php  //echo $element['forreaddetails']; ?></option>';
    // <?php // } ?>

  


         

     

    $(addButton).click(function(){

        if (x < maxField) {
          
             if(x==1)
            {
                        $("#ms-selected_come [class*=ms-elem-selectable]").addClass("disabled");
                        $("#ms-selected_come [class*=ms-elem-selection]").addClass("disabled");
                        $('#row_1').find('input, textarea, button, select').attr('disabled','disabled');   
            }
            else
            {
                        $("#ms-id2021"+x+" [class*=ms-elem-selectable]").addClass("disabled");
                        $("#ms-id2021"+x+" [class*=ms-elem-selection]").addClass("disabled");
                         $('#row_1').find('input, textarea, button, select').attr('disabled','disabled'); 
                        $('#row_'+x+'').find('input, textarea, button, select').attr('disabled','disabled');
            }
            x++;
            // JC_11 Modified By Arul For Add Button 
            $('#rowno').val(x);

 var seleted = $('#applyon').val();
var clickpopup = $('#clickpopup').val();

  var fieldHTML =
        '<div class="row boxborder" id="row_'+x+'" ><input type="hidden" name="ostate[]" id="ostate'+x+'" value=""><div class="form-group col-md-3 fromstate ST pl-1 pr-1 mb-0" style="display:none;"><label style="display:none;" class="col-md-12 pl-1 pr-1 fromstate">Select State / UT</label><div style="display:none;" class="col-md-12 pl-1 pr-1 fromstate"><select id="fromstate'+x+'" class="form-select fromstate" onchange="return get_district_popup_distdata_add(this,\''+clickpopup+'\','+x+');" name="fromstate[]"></select></div></div><div class="form-group col-md-3 pl-1 pr-1 mb-0 districtstatus DT"><label id="districtstatus" class="col-md-12 pl-1 pr-1 districtstatus">Select District</label><div  id="districtstatusdrop" class="col-md-12 districtstatusdrop districtstatus pl-1 pr-1"><select class="form-select districtstatus" id="districtget_'+x+'" onchange="return get_district_popup(this,\''+clickpopup+'\');" name="districtget[]"></select></div></div><div class="form-group col-md-3 mb-0 sddistrictstatus SD1 pl-1 pr-1"><label id="sddistrictstatus" class="col-md-12 pl-1 pr-1 sddistrictstatus">Select Sub-District</label><div id="sddistrictstatusdrop" class="col-md-12 pl-1 pr-1 sddistrictstatus"><select id="sddistrictget_'+x+'" onchange="return get_sub_district_popup_new(this,\''+clickpopup+'\','+x+');" name="sddistrictget[]" class="form-select sddistrictstatus"><option value="">Select Sub-District</option></select></div></div><div class="form-group col-md-3 mb-0 SD pl-1 pr-1"><label class="col-md-12 addlable3 pl-1 pr-1">Select Sub-District</label><div class ="col-md-12 pl-1 pr-1"  id="did2021'+x+'" ><select class="form-select namefrom selected_come" onchange="return get_fromvalue1(this.value,'+x+')" required name = "namefrom[]" id="id2021'+x+'"></select></div></div><div class="form-group col-md-3 mb-0 AC ACNN'+x+' pl-1 pr-1"><div class = "col-md-12 pl-1 pr-1"><label> Action </label></div><div class = "col-md-12  pl-1 pr-1"><select class="form-select" id="action'+x+'" onchange="return actionoremove(this.value,'+x+')" required name = "action[]" ><option value = "">Action</option></select></div></div><div class="form-group col-md-3 mb-0 FAC pl-1 pr-1" style="display:none" ><div class = "col-md-12 pl-1 pr-1"><label> New Status of <?php echo $_SESSION['activeyears']; ?> </label></div><div class = "col-md-12 pl-1 pr-1"><select class="form-select FAC" name = "fstatus[]" id="fstatus'+x+'"><option value="">Select Status</option><option value="ST">State</option><option value="UT">Union Territory</option></select></div></div><div class = "col-md-1 pt-2 '
           if(seleted=='Village / Town'){
                 fieldHTML +=' mb-0 ';
                 if(clickpopup=='Reshuffle')
                 {
                    fieldHTML +=' mt-3 ';
                 }

            }
            else
            {
                 fieldHTML +=' mt-3';
            }
            fieldHTML +=' "><button type="button" class = "btn-block btn-primary btn-rounded waves-effect waves-light remove_button" ><i class = "fas fa-times-circle" ></i></button></div></div>';
// <div class="';
//             if(seleted=='District' || seleted=='State') {
//               fieldHTML +='col-md-2';
//           }
//           else
//           {
//             fieldHTML +='col-md-1';
//           }
//            fieldHTML +=' pt-2 mt-4 OR pl-1 pr-1"><input type="checkbox" id="oremove'+x+'" name="oremove[]" value="1"><label for="oremove">As original remove</label></div>
            $(wrapper).append(fieldHTML);

          

               
 var seleteda = $('select[name="districtget[]"] option:selected').map(function () {
                return this.value;

            }).get();

  var subdistrictget = $('select[name="sddistrictget[]"] option:selected').map(function () {
                return this.value;

            }).get();

  var dids = $('select[name="fromstate[]"] option:selected').map(function () {
                return this.value;

            }).get();



        var fstids = $('select[name="fromstate[]"] option:selected').map(function () {
        return this.value;

        }).get();

        var fdtids = $('select[name="districtget[]"] option:selected').map(function () {
                return this.value;

            }).get();

        var fsdids = $('select[name="sddistrictget[]"] option:selected').map(function () {
                if(this.value!='')
                {
                    return this.value;    
                }
                
            }).get();


        var tstids = $('#tstids').val();
        var tdtids = $('#tdtids').val();
        var tsdids = $('#tsdids').val();

               //  var seleteda = $('#districtget').val();
               //  var dids = $('#dids').val();
               //  var subdistrictget = $('#subdistrictget').val();
                
                if(clickpopup=='Create')
                {

                    if(seleted=='State')
                    {
                        $('.FAC').css("display", "block");
                        $(".FAC").prop('required',true);
                    }
                    else
                    {
                    $('.FAC').css("display", "none");
                    $(".FAC").prop('required',false);
                    }
                $('.OR').css("display", "block");

                }
                else
                {

                    if(clickpopup=='Merge' && seleted=='State')
                    {
                        $('.FAC').css("display", "block");
                        $(".FAC").prop('required',true);
                    }
                    else
                    {
                    $('.FAC').css("display", "none");
                    $(".FAC").prop('required',false);
                    }

                $('.OR').css("display", "none");

                }
                var lalo = '';
                var lalo1 = '';
                if(seleted=='Sub-District')
                {
                   
                        $('.fromstate').css("display", "block");
                        $(".fromstate").prop('required',true);

                        $('.districtstatus').css("display", "block");
                        $(".districtstatus").prop('required',true);

                        $('.sddistrictstatus').css("display", "none");
                        $(".sddistrictstatus").prop('required',false);

                        $(".ST,.DT,.SD,.SD1,.AC,.OR").removeClass("col-md-3");
                        $(".ST,.DT,.SD,.SD1,.AC,.OR").addClass("col-md-2");
                lalo = 'getdataofpopupsub';
                lalo1 = "&clickpopup="+clickpopup+"&fstids="+fstids+"&fdtids="+fdtids+"&fsdids="+fsdids+"&tstids="+tstids+"&tdtids="+tdtids+"&tsdids="+tsdids+"&createfrom="+clickpopup;
                }
                else if(seleted=='Village / Town')
                {
                        $('.fromstate').css("display", "block");
                        $(".fromstate").prop('required',true);

                        $('.districtstatus').css("display", "block");
                        $(".districtstatus").prop('required',true);

                        $('.sddistrictstatus').css("display", "block");
                        $(".sddistrictstatus").prop('required',true);

                        $(".ST,.DT,.SD,.SD1,.AC,.OR").removeClass("col-md-3");
                        $(".ST,.DT,.SD,.SD1,.AC,.OR").addClass("col-md-2");

                lalo = 'getdataofpopup';
                lalo1 = "&selectstid="+dids+"&clickpopup="+clickpopup;
                }
                else if(seleted=='District')
                {
                     $(".ST,.DT,.SD,.SD1,.AC").removeClass("col-md-2");
                     $(".ST,.DT,.SD,.SD1,.AC").addClass("col-md-3");

                     $(".OR").removeClass("col-md-3");
                     $(".OR").addClass("col-md-2");

    //               $(".ST,.DT,.SD,.AC,.OR").removeClass("col-md-2");
    // $(".ST,.DT,.SD,.AC,.OR").addClass("col-md-3");

                $('.fromstate').css("display", "block");
                $(".fromstate").prop('required',true); 

                $('.districtstatus').css("display", "none");
                $(".districtstatus").prop('required',false);

                $('.sddistrictstatus').css("display", "none");
                $(".sddistrictstatus").prop('required',false);


                lalo = 'getdataofpopup';
                lalo1 = "&selectstid="+dids+"&clickpopup="+clickpopup;
                }
                else
                {
                   
                    $('.fromstate').css("display", "none");
                    $(".fromstate").prop('required',false);

                    $('.districtstatus').css("display", "none");
                    $(".districtstatus").prop('required',false);

                    $('.sddistrictstatus').css("display", "none");
                    $(".sddistrictstatus").prop('required',false);

                     $(".ST,.DT,.SD,.SD1,.AC").removeClass("col-md-2");
                     $(".ST,.DT,.SD,.SD1,.AC").addClass("col-md-3");
                     $(".OR").removeClass("col-md-3");
                     $(".OR").addClass("col-md-2");

                    $('.sddistrictstatus').css("display", "none");
                      $('.districtstatus').css("display", "none");
                    $('.districtstatusdrop').css("display", "none");

                lalo = 'getdataofpopup';
                lalo1 = "&clickpopup="+clickpopup+"&fstids="+fstids+"&fdtids="+fdtids+"&fsdids="+fsdids+"&tstids="+tstids+"&tdtids="+tdtids+"&tsdids="+tsdids+"&createfrom="+clickpopup;
                }

                 $.ajax({
                        type: "POST",
                        url: "insert_data.php",
                        data: "formname="+lalo+"&comefrom=" + seleted+lalo1
                    }).done(function (result) {

                         var finalresult = result.split("|");
                           //  console.log(finalresult);
                                           
                                   // alert(finalresult[7]);         

                                            if(finalresult[7]!='null')
                                            {
                                                $("#fromstate"+x+"").children().remove();

                                                $("#fromstate"+x+"").append($('<option>', {
                                                value: '',
                                                text: 'Select State / UT',
                                                }));

                                                var arr = $('select[name="fromstate[]"] option:selected').map(function () {
                                                return this.value;  // $(this).val()
                                                }).get();
                                                var filtered = arr.filter(function (el) {
                                                return el != null && el != "";
                                                });

                                                $(JSON.parse(finalresult[7])).each(function () {
                                                if($.inArray(this.id, filtered) == -1 && finalresult[2]=='State')
                                                {
                                                $("#fromstate"+x+"").append($('<option>', {
                                                value: this.id,
                                                text: this.Name,
                                                }));
                                                }
                                                else
                                                {
                                                  $("#fromstate"+x+"").append($('<option>', {
                                                value: this.id,
                                                text: this.Name,
                                                }));
                                                   
                                                }
                                                });
                                                if(finalresult[9]!='')
                                                {
                                                    $("#fromstate"+x+"").val(finalresult[9]).trigger('change');

                                                }
                                                else
                                                {
                                                    $("#fromstate"+x+"").val('').trigger('change');
                                                }
                                                
                                            }
                                           //  alert(finalresult[2]);
                                            
                                                $("#id2021"+x+"").children().remove();
                                                if(seleted=='State')
                                                {
                                                    $("#id2021"+x+"").append($('<option>', {
                                                    value: '',
                                                    text: 'Select '+finalresult[2]+' / UT',
                                                    }));
                                                }
                                                else
                                                {
                                                    $("#id2021"+x+"").append($('<option>', {
                                                    value: '',
                                                    text: 'Select '+finalresult[2]+'',
                                                    }));
                                                }
                                             
                                                $("#id2021"+x+"").val('').trigger('change'); 
                                                

                                                if( $("#fromstate"+x+"").val()!='')
                                                {
                                                
                                                var arr = $('select[name="namefrom[]"] option:selected').map(function () {
                                                return this.value;  // $(this).val()
                                                }).get();


                                                var filtered = arr.filter(function (el) {
                                                return el != null && el != "";
                                                });
                                                $(JSON.parse(finalresult[0])).each(function () {
                                                if($.inArray(this.id, filtered) == -1)
                                                {
                                                $("#id2021"+x+"").append($('<option>', {
                                                value: this.id,
                                                text: this.Name,
                                                }));
                                                }
                                                });
                                               
                                                }
                                                

                                        $("#districtget_"+x+"").children().remove();
                                        $("#districtget_"+x+"").append($('<option>', {
                                        value: '',
                                        text: 'Select District',
                                        }));

                                        var arr1 = $('select[name="districtget[]"] option:selected').map(function () {
                                        return this.value;  // $(this).val()
                                        }).get();

                                        var filtered1 = arr1.filter(function (el) {
                                        return el != null && el != "";
                                        });

                                        $(JSON.parse(finalresult[4])).each(function () {
                                        if($.inArray(this.id, filtered1) == -1)
                                        {
                                        $("#districtget_"+x+"").append($('<option>', {
                                        value: this.id,
                                        text: this.Name,
                                        }));
                                        }


                                        });

                                        $("#districtget_"+x+"").val('').trigger('change');

                                $("#action"+x+",#actionto"+x+"").children().remove();

                                $("#action"+x+",#actiona"+x+"").append($('<option>', {
                                value: '',
                                text: 'Select Action',
                                }));

                                $(JSON.parse(finalresult[1])).each(function () {

                                $("#action"+x+",#actionto"+x+"").append($('<option>', {
                                value: this.forreaddetails,
                                text: this.forreaddetails,
                                }));

                                });
                                if(clickpopup=='Create')
                                {
                                    if(seleted=='District')
                                    {
                                        $("#action"+x+",#actionto"+x+"").val('Split').trigger('change');
                                    }
                                    else
                                    {
                                    $("#action"+x+",#actionto"+x+"").val('').trigger('change');    
                                    }
                                    
                                }

                                else
                                {

                                    $("#action"+x+",#actionto"+x+"").val('').trigger('change');    
                                }
                                

                          

                                if(seleted=='State')
                                {
                                    $(".addlable3").html("Select "+seleted+" / UT");
                                }
                                else
                                {
                                    $(".addlable3").html("Select "+seleted+"");
                                }
             
  addButton.attr('disabled', true);

                        
                    });


          

            
            $('select.form-select').select2({
                maximumInputLength: 20
            });

            

        }
    });

 $(addButton1).click(function() {


        if (x1 < maxField1) {

             if(x1==1)
            {
                        // $("#ms-selected_come [class*=ms-elem-selectable]").addClass("disabled");
                        // $("#ms-selected_come [class*=ms-elem-selection]").addClass("disabled");
                        $('#todataaction_1').find('input, textarea, button, select').attr('disabled','disabled');   
            }
            else
            {
                        // $("#ms-id2021"+x+" [class*=ms-elem-selectable]").addClass("disabled");
                        // $("#ms-id2021"+x+" [class*=ms-elem-selection]").addClass("disabled");
                         $('#todataaction_1').find('input, textarea, button, select').attr('disabled','disabled'); 
                        $('#todataaction_'+x1+'').find('input, textarea, button, select').attr('disabled','disabled');
            }

            x1++;
   var clickpopup = $('#clickpopup').val();
var seleted = $('#applyon').val();
        
        var lasttital
        if(seleted=='Village / Town' && clickpopup=='Addition')
        {
            lasttital = "New Village Name";
        }
        else
        {
            lasttital = seleted;
        }


             var fieldHTML1 =
        '<div class="row boxborder" id="todataaction_'+x1+'"><input type="hidden" name="toStatus[]" id="toStatus_'+x1+'" value=""><input type="hidden" name="vlevel[]" id="vlevel_'+x1+'" value=""><input type="hidden" name="ovstatus[]" id="ovstatus_'+x1+'" value=""><div class="form-group col-md-3 stnew ST pl-1 pr-1 mb-0" style="display:none"><label class="col-md-12 pl-1 pr-1 stnew" id="stnew">Select State / UT</label><div class="col-md-12 stnew pl-1 pr-1" id="stnewdrop1" style="display:none"><select id="statenew'+x1+'" name="statenew[]" onchange="return get_district_popupto_ii(this,\''+clickpopup+'\','+x1+');" class="form-select stnew" required><option value="">Select State / UT</option></select></div></div><div class="form-group col-md-3 dtnew DT pl-1 pr-1 mb-0" style="display:none"><label class="col-md-12 dtnew pl-1 pr-1" id="dtnew">Select District</label><div class="col-md-12 pl-1 pr-1" id="dtnewdrop" ><select id="districtnew'+x1+'" name="districtnew[]" class="form-select dtnew" onchange="return get_sddistrict_popupto_ii(this,\''+clickpopup+'\','+x1+');"><option value="">Select District</option></select></div></div><div class="form-group col-md-3 sdnew SD1 pl-1 pr-1 mb-0" style="display:none"><label class="col-md-12 sdnew pl-1 pr-1" id="sdnew">Select Sub-District</label><div class="col-md-12 pl-1 pr-1 sdnew" id="sdnewdrop" ><select id="sddistrictnew'+x1+'" name="sddistrictnew[]" onclick="return getvtlist_more(this,'+x1+');"  class="form-select sdnew"><option value="">Select Sub-District</option></select></div></div><div class="form-group col-md-3 SD pl-1 pr-1 mb-0"><label class="col-md-12 addlable2" ></label><div class="col-md-12 pl-1 pr-1 newname"><input type="text" data-parsley-minlength="2" data-parsley-pattern="^[^<>;]+$" data-parsley-pattern-message="< OR > value seems to be invalid." class="form-control jigar newname" name="newname[]" onkeyup="checkdataoftext(this,'+x1+')" id="name2021'+x1+'" required/></div><div class="col-md-12 pl-1 pr-1 newnamem" ><select id="named2021'+x1+'" onchange="return get_to_data(this,'+x1+');" name="newnamem[]" class="newnamem form-select"><option value="">Select '+seleted+'</option></select></div></div><div class="form-group col-md-3 pl-1 pr-1 statestatus1 SD mb-0" style="display:none"><label class="col-md-12 statestatus1 pl-1 pr-1" style="display:none">Status</label><div class="col-md-12 statestatus1 pl-1 pr-1" style="display:none"><select id="Status2021_'+x1+'" name="StateStatus[]" class="form-select Statusyear Statusyearof" ><option value="">Select Status</option><option value="ST">State</option><option value="UT">Union Territory</option></select></div></div><div class="form-group col-md-3 vstatestatus1 ST pl-1 pr-1 mb-0" style="display:none"><label class="col-md-12 pl-1 pr-1 vstatestatus1" style="display:none">Level</label><div class="col-md-12 pl-1 pr-1 vstatestatus1" style="display:none"><select id="vStatus2021_'+x1+'" name="vStateStatus[]" onchange="return get_sub(this,'+x1+');" class="form-select vstatestatus1" ><option value="">Select Level</option><option value="VILLAGE">Village</option><option value="TOWN">Town</option></select></div></div><div class="form-group col-md-3 VAC pl-1 pr-1 mb-0" style="display:none" ><label class="col-md-12 pl-1 pr-1">Status</label><div class = "col-md-12 pl-1 pr-1"><select class="form-select VAC1" name = "vstatus[]" id="vstatus'+x1+'" onchange="return getstatus(this,'+x1+');"><option value="">Select Status</option></select></div></div><div class="form-group col-md-2 ORR pl-1 pr-1"><label for="oremove1">&nbsp;</label><div class="col-md-12 pl-1 pr-1"><input type="checkbox" id="oremovenew'+x1+'" name="oremovenew[]" onchange="return gettext_data(this,'+x1+');" class="oremovenew" value="1"><label class="pl-2" for="oremove1">With New Name</label></div></div><div class="form-group col-md-3 ORRNN'+x1+' pl-1 pr-1 mb-0"><label class="col-md-12 pl-1 pr-1">Enter New Name</label><div class="col-md-12 pl-1 pr-1"><input type="text" data-parsley-pattern="^[^<>;]+$" data-parsley-pattern-message="< OR > value seems to be invalid." data-parsley-minlength="2" class="form-control newnamecheck" name="newnamecheck[]" placeholder="Enter New Name" id="newnamecheck'+x1+'"></div></div><div class = "col-md-1 ';
            if(seleted=='Village / Town' && clickpopup=='Create'){
                 fieldHTML1 +='mb-2';
            }
            else
            {
                 fieldHTML1 +='pt-3 mt-3';
            }
             fieldHTML1 +=' "><button type="button" class = "btn-block btn-primary btn-rounded waves-effect waves-light remove_button_name" ><i class = "fas fa-times-circle" ></i></button></div></div></div></div>';
          

            $(wrapper_name).append(fieldHTML1);

            if(seleted=='State'){


                $('.stnew').css("display", "none");
                $(".stnew").prop('required',false);

                $('.dtnew').css("display", "none");
                $(".dtnew").prop('required',false);

                $('.sdnew').css("display", "none");
                $(".sdnew").prop('required',false);

                $('.vstatestatus1').css("display", "none");
                $(".vstatestatus1").prop('required',false);

                if(clickpopup=='Create' || clickpopup=='Addition')
                {

                    $('.newname').css("display", "block");
                    $(".newname").prop('required',true);
                    $('.newnamem').css("display", "none");
                    $(".newnamem").prop('required',false);
                    $('.OR').css("display", "block");
                    $('.ORR').css("display", "none");
                    $('.ORRNN'+x1+'').css("display", "none");
                    $('.newnamecheck').prop('required',false);

                    $('.statestatus1').css("display", "block");
                    $(".Statusyear").prop('required',true);

                    //modified by sahana for state validation (Destroy and reinitialize the validation plugin)                                
                    $('.newname').on('input', function() {
                    var input = $(this).val();
                    var regex = /(<|>)/gi;
                    var validInput = input.replace(regex, '');
                    if (input !== validInput) {
                        alert("Invalid input: '<' or '>' values are not allowed.");
                        $(this).val(validInput);
                    }

                    // destroy and reinitialize the validation plugin
                    if ($.validator) {
                        $.validator.destroy();
                    }
                    });
                }
                else
                {
                        // if(clickpopup=='Rename')
                        // {
                        // $('.ORR').css("display", "none");
                        // $('.ORRN').css("display", "block");
                        // $('.newnamecheck').prop('required',true);
                        // $('.statestatus1').css("display", "none");
                        // $(".Statusyear").prop('required',false);
                        // $('.add_button_name').attr('disabled', true);  
                        // }
                        // else
                        // {


                        $('.ORR').css("display", "block"); 
                        if(clickpopup=='Rename')
                       {
                        $('.ORRNN'+x1+'').css("display", "none");  
                       }
                        $('.newnamecheck').prop('required',false);
                        $('.statestatus1').css("display", "block");
                        $(".Statusyear").prop('required',true);
                        $('.Statusyear').change(function(){
                        var value = $(this).val();
                      // This value required removed -Arun
                     if(value !='')
                        {
                            $(this).parsley().removeError('required',{updateClass: true});
                        }
                    });

                        $('.add_button_name').attr('disabled', false);  
                        //}

                        $('.OR').css("display", "none");
                        $('.newname').css("display", "none");
                        $(".newname").prop('required',false);
                        $('.newnamem').css("display", "block");
                        $(".newnamem").prop('required',true);


                }

              

               //  $('#vStatus2021').prop('required', false);
                //$("#vStatus2021").prop('required',false);
                
              
                }
                else if(seleted=='Village / Town'){

               if(clickpopup=='Addition')
                                {
                                    $('#vStatus2021_'+x1+' option').each(function() {
    if ( $(this).val() == 'TOWN' ) {
        $(this).remove();
    }
    $("#vStatus2021_"+x1+"").val('VILLAGE').trigger('change'); 
});
                                    //  $("select [id*='vStatus2021_"+x1+"'] option[value='TOWN']").remove();       
                                }

                   

//                     if(clickpopup=='Addition')
//                                 {
//                                      $("select[name*='vStateStatus[]'] option[value='TOWN']").remove();       
//                                 }
//                                 else
//                                 {
//                                     $("select[name*='vStateStatus[]'] option[value='TOWN']").remove();    
// $("select[name*='vStateStatus[]']").append(`<option value="TOWN">
//                                       Town
//                                   </option>`);
                                  
//                                 }



                     if(clickpopup=='Create' || clickpopup=='Addition')
                {

                    $('.newname').css("display", "block");
                    $(".newname").prop('required',true);
                    $('.newnamem').css("display", "none");
                    $(".newnamem").prop('required',false);
                    $('.OR').css("display", "block");
                    $('.ORR').css("display", "none");
                    $('.ORRNN'+x1+'').css("display", "none");
                    $('.newnamecheck').prop('required',false);

                    $('.statestatus1').css("display", "none");
                    $(".Statusyear").prop('required',false);



                }
                else
                {
                        if(clickpopup=='Rename')
                        {
                        $('.ORR').css("display", "block");
                        $('.ORRNN'+x1+'').css("display", "none");
                       //  $('.newnamecheck').prop('required',true);
                        $('.statestatus1').css("display", "none");
                        $(".Statusyear").prop('required',false);
                        $('.add_button_name').attr('disabled', true);  
                        }
                        else
                        {
                        $('.ORR').css("display", "block"); 
                        $('.ORRNN'+x1+'').css("display", "none");  
                        $('.newnamecheck').prop('required',false);
                        $('.statestatus1').css("display", "block");
                        $(".Statusyear").prop('required',true);
                        $('.add_button_name').attr('disabled', false);  
                        }

                        $('.OR').css("display", "none");
                        $('.newname').css("display", "none");
                        $(".newname").prop('required',false);
                        $('.newnamem').css("display", "block");
                        $(".newnamem").prop('required',true);


                }



                $('.stnew').css("display", "block");
                $(".stnew").prop('required',true);

                $('.dtnew').css("display", "block");
                $(".dtnew").prop('required',true);

                $('.sdnew').css("display", "block");
                $(".sdnew").prop('required',true);
if(clickpopup=='Reshuffle')
    {
        $('.vstatestatus1').css("display", "none");
         $(".vstatestatus1").prop('required',false); 
           $('.VAC').css("display", "none");
         $(".VAC1").prop('required',false); 
    }
   else if(clickpopup=='Addition')
    {
        $('.vstatestatus1').css("display", "block");
         $(".vstatestatus1").prop('required',true); 
         $('.VAC').css("display", "block");
         $(".VAC1").prop('required',true); 
    }
    else
    {
         $('.vstatestatus1').css("display", "block");
         $(".vstatestatus1").prop('required',true); 
          $('.VAC').css("display", "block");
         $(".VAC1").prop('required',true); 
    }
                            
                $('.stnewdrop').css("display", "none");
                }
                else if(seleted=='District'){

                    if(clickpopup=='Create' || clickpopup=='Addition')
                {

                    $('.newname').css("display", "block");
                    $(".newname").prop('required',true);
                    $('.newnamem').css("display", "none");
                    $(".newnamem").prop('required',false);
                    $('.OR').css("display", "block");
                    $('.ORR').css("display", "none");
                    $('.ORRNN'+x1+'').css("display", "none");
                    $('.newnamecheck').prop('required',false);

                    $('.statestatus1').css("display", "none");
                    $(".Statusyear").prop('required',false);

                     //modified by sahana for disitict validation (Destroy and reinitialize the validation plugin)                                
                     $('.newname').on('input', function() {
                    var input = $(this).val();
                    var regex = /(<|>)/gi;
                    var validInput = input.replace(regex, '');
                    if (input !== validInput) {
                        alert("Invalid input: '<' or '>' values are not allowed.");
                        $(this).val(validInput);
                    }

                    // destroy and reinitialize the validation plugin
                    if ($.validator) {
                        $.validator.destroy();
                    }
                    });


                }
                else
                {
                    if(clickpopup=='Rename'|| clickpopup=='Deletion')
                        {
                        $('.ORR').css("display", "none");
                        $('.ORRNN'+x1+'').css("display", "block");
                        $('.newnamecheck').prop('required',true);
                        $('.statestatus1').css("display", "none");
                        $(".Statusyear").prop('required',false);
                        $('.add_button_name').attr('disabled', true);  
                        }
                        else
                        {
                        $('.ORR').css("display", "block"); 
                        $('.ORRNN'+x1+'').css("display", "none");  
                        $('.newnamecheck').prop('required',false);
                        $('.statestatus1').css("display", "none");
                        $(".Statusyear").prop('required',false);
                        $('.add_button_name').attr('disabled', false);  
                        }

                        $('.OR').css("display", "none");
                        $('.newname').css("display", "none");
                        $(".newname").prop('required',false);
                        $('.newnamem').css("display", "block");
                        $(".newnamem").prop('required',true);

                }


                    $('.stnew').css("display", "block");
                    $(".stnew").prop('required',true);

                    $('.dtnew').css("display", "none");
                    $(".dtnew").prop('required',false);

                    $('.sdnew').css("display", "none");
                    $(".sdnew").prop('required',false);

                    $('.vstatestatus1').css("display", "none");
                    $(".vstatestatus1").prop('required',false);

                    // $('.statestatus1').css("display", "none");
                    // $(".Statusyear").prop('required',false);


                    // $('.statestatus').css("display", "none");
                    // $('.statestatus1').css("display", "none");
                }
                else{


                       if(clickpopup=='Create' || clickpopup=='Addition')
                {

                    $('.newname').css("display", "block");
                    $(".newname").prop('required',true);
                    $('.newnamem').css("display", "none");
                    $(".newnamem").prop('required',false);
                    $('.OR').css("display", "block");
                    $('.ORR').css("display", "none");
                    $('.ORRNN'+x1+'').css("display", "none");
                    $('.newnamecheck').prop('required',false);

                    $('.statestatus1').css("display", "none");
                    $(".Statusyear").prop('required',false);

                     //modified by sahana for sub-disitict validation (Destroy and reinitialize the validation plugin)                                
                     $('.newname').on('input', function() {
                    var input = $(this).val();
                    var regex = /(<|>)/gi;
                    var validInput = input.replace(regex, '');
                    if (input !== validInput) {
                        alert("Invalid input: '<' or '>' values are not allowed.");
                        $(this).val(validInput);
                    }

                    // destroy and reinitialize the validation plugin
                    if ($.validator) {
                        $.validator.destroy();
                    }
                    });

                }
                else
                {
                    if(clickpopup=='Rename'||clickpopup=='Deletion')
                        {
                        $('.ORR').css("display", "none");
                        $('.ORRNN'+x1+'').css("display", "block");
                        $('.newnamecheck').prop('required',true);
                        $('.statestatus1').css("display", "none");
                        $(".Statusyear").prop('required',false);
                        $('.add_button_name').attr('disabled', true);  
                        }
                        else
                        {
                        $('.ORR').css("display", "block"); 
                        $('.ORRNN'+x1+'').css("display", "none");  
                        $('.newnamecheck').prop('required',false);
                        $('.statestatus1').css("display", "none");
                        $(".Statusyear").prop('required',false);
                        $('.add_button_name').attr('disabled', false);  
                        }

                        $('.OR').css("display", "none");
                        $('.newname').css("display", "none");
                        $(".newname").prop('required',false);
                        $('.newnamem').css("display", "block");
                        $(".newnamem").prop('required',true);


                }


                   $('.stnew').css("display", "block");
                   $(".stnew").prop('required',true);

                    $('.dtnew').css("display", "block");
                    $(".dtnew").prop('required',true);

                    $('.sdnew').css("display", "none");
                    $(".sdnew").prop('required',false);

                $('.vstatestatus1').css("display", "none");
                $(".vstatestatus1").prop('required',false);

                // $('.statestatus').css("display", "none");
                // $('.statestatus1').css("display", "none");

                // $('.statestatus1').css("display", "none");
                // $(".Statusyear").prop('required',false);
                
                // $('#vStatus2021').prop('required', false);
                 
                }
                // var seleteda = $('#districtget').val();
                // var dids = $('#dids').val();
                // var subdistrictget = $('#subdistrictget').val();


    var fstids = $('select[name="statenew[]"] option:selected').map(function () {
        if(this.value!='')
        {
            return this.value;
        }

        }).get();

        var fdtids = $('select[name="districtnew[]"] option:selected').map(function () {
            if(this.value!='')
        {
            return this.value;
        }


            }).get();

        var fsdids = $('select[name="sddistrictnew[]"] option:selected').map(function () {
                if(this.value!='')
                {
                    return this.value;    
                }
                
            }).get();


        var tstids = $('#tstids').val();
        var tdtids = $('#tdtids').val();
        var tsdids = $('#tsdids').val();


               
                if(clickpopup=='Rename' && seleted=='State')
                {
                $(".addlable2").html("Select "+seleted+" / UT");
                }
                else if(clickpopup=='Rename' && seleted!='State')
                {
                $(".addlable2").html("Select "+seleted+"");
                }
                else if(clickpopup=='Addition')
                {
                $(".addlable2").html("Enter Village");
                 $(".jigar").attr("placeholder", "New Village Name");
                }
                else
                {
                    if(seleted=='State'){
                        $(".addlable2").html("Enter "+seleted+" / UT");
                        $(".jigar").attr("placeholder", ""+seleted+"  / UT Name");
                    }
                    else{
                        $(".addlable2").html("Enter "+seleted+"");
                        $(".jigar").attr("placeholder", ""+seleted+" Name");
                    }
               

                }


               




                var lalo = '';
                var lalo1 = '';
                if(seleted=='Sub-District')
                {
                   
                    // $(".statenew").prop('required',false);

                      $(".ST,.DT,.SD,.SD1,.AC,.OR").removeClass("col-md-3");
                      $(".ST,.DT,.SD,.SD1,.AC,.OR").addClass("col-md-2");

                lalo = 'getdataofpopup';
                lalo1 = "&clickpopup="+clickpopup+"&fstids="+fstids+"&fdtids="+fdtids+"&fsdids="+fsdids+"&tstids="+tstids+"&tdtids="+tdtids+"&tsdids="+tsdids;
                }
                else if(seleted=='Village / Town')
                {

                     $(".ST,.DT,.SD,.SD1,.AC,.VAC,.OR").removeClass("col-md-3");
                     $(".ST,.DT,.SD,.SD1,.AC,.VAC,.OR").addClass("col-md-2");

                lalo = 'getdataofpopup';
                lalo1 = "&clickpopup="+clickpopup+"&fstids="+fstids+"&fdtids="+fdtids+"&fsdids="+fsdids+"&tstids="+tstids+"&tdtids="+tdtids+"&tsdids="+tsdids;
                }
                else
                {
                     $(".ST,.DT,.SD,.SD1,.AC,.OR").removeClass("col-md-2");
                     $(".ST,.DT,.SD,.SD1,.AC,.OR").addClass("col-md-3");

                lalo = 'getdataofpopup';
                lalo1 = "&clickpopup="+clickpopup+"&fstids="+fstids+"&fdtids="+fdtids+"&fsdids="+fsdids+"&tstids="+tstids+"&tdtids="+tdtids+"&tsdids="+tsdids;
                }

                 $.ajax({
                        type: "POST",
                        url: "insert_data.php",
                        data: "formname="+lalo+"&comefrom=" + seleted+lalo1
                    }).done(function (result) {

                         var finalresult = result.split("|");
                         // console.log(finalresult);
                          $('.add_button_name').attr('disabled', true);
                                 if(finalresult[8]!='null')
                            {
                                 if(clickpopup=='Rename' && seleted=='State')
                                 {



                                $("#named2021"+x1+"").children().remove();
               
                                $("#named2021"+x1+"").append($('<option>', {
                                value: '',
                                text: 'Select '+seleted+' / UT',
                                }));

                                var arr = $('select[name="newnamem[]"] option:selected').map(function () {
                                return this.value;  // $(this).val()
                                }).get();
                                     // console.log(arr);

                                var filtered = arr.filter(function (el) {
                               
                                return el != null && el != '';
                                });
                              //   console.log(filtered);

                                $(JSON.parse(finalresult[8])).each(function () {
                                  //   console.log($.inArray(this.id, filtered));
                                    if($.inArray(this.id, filtered) == -1 && finalresult[2]!="Sub-District")
                                    {
                                       
                                      
                                                $("#named2021"+x1+"").append($('<option>', {
                                value: this.id,
                                text: this.Name,
                                }));
                                    }
                                    else
                                    {
                                       //  console.log('OUT');
                                       if(finalresult[2]=="Sub-District")
                                       {
                                               $("#named2021"+x1+"").append($('<option>', {
                                value: this.id,
                                text: this.Name,
                                }));
                                       }


                                         
                                    }
                            

                                });

                                $("#named2021"+x1+"").val('').trigger('change');
                                 }
                                 else
                                 {

                                   //  console.log(finalresult);

                                $("#statenew"+x1+"").children().remove();
               

                                $("#statenew"+x1+"").append($('<option>', {
                                value: '',
                                text: 'Select State / UT',
                                }));

                                var arr = $('select[name="statenew[]"] option:selected').map(function () {
                                return this.value;  // $(this).val()
                                }).get();

                                var filtered = arr.filter(function (el) {
                                return el != null && el != "";
                                });
                              
                                $(JSON.parse(finalresult[8])).each(function () {
                                    if($.inArray(this.id, filtered) == -1 && finalresult[2]!="Sub-District")
                                    {
                                                $("#statenew"+x1+"").append($('<option>', {
                                value: this.id,
                                text: this.Name,
                                }));
                                    }
                                    else
                                    {
                                            $("#statenew"+x1+"").append($('<option>', {
                                value: this.id,
                                text: this.Name,
                                }));
                                    }
                            

                                });
                                if(finalresult[9]!='')
                                {
                                         $("#statenew"+x1+"").val(finalresult[9]).trigger('change');
                                }
                               

                                 }
                              

                              //  

                            }
                        
                    });



            

            $('select.form-select').select2({
                maximumInputLength: 20
            });
        }
    });

   


    $(wrapper).on('click', '.remove_button', function(e) {
        e.preventDefault();
        $(this).parent().parent('div').remove();
         addButton.attr('disabled', false);
        x--;
        // JC_11 Modified By Arul For Add Button 
        $('#rowno').val(x);
                    var action = $('select[name="action[]"]').map(function () {
                        return this.value;    
                   
                    
            }).get();

                       if(action.length==1)
                       {
                        $('#row_1').find('input, textarea, button, select').removeAttr('disabled','disabled');   
                         $("#ms-selected_come [class*=ms-elem-selectable]").removeClass("disabled");
                        $("#ms-selected_come [class*=ms-elem-selection]").removeClass("disabled");
                       }
                        else
                        {
                             $("#ms-id2021"+x+" [class*=ms-elem-selectable]").removeClass("disabled");
                        $("#ms-id2021"+x+" [class*=ms-elem-selection]").removeClass("disabled");
                        // if(x==2)
                        // {
                        // $('#row_1').find('input, textarea, button, select').removeAttr('disabled','disabled');     
                        // }
                        $('#row_'+x+'').find('input, textarea, button, select').removeAttr('disabled','disabled'); 
                        }
                       
           
    });

     $(wrapper_name).on('click', '.remove_button_name', function(e) {
        e.preventDefault();
        $(this).parent().parent('div').remove();
         addButton1.attr('disabled', false);
        x1--;


         var action = $('select[name="statenew[]"]').map(function () {
                        return this.value;    
                   
                    
            }).get();
                 
                       if(action.length==1)
                       {
                        $('#todataaction_1').find('input, textarea, button, select').removeAttr('disabled','disabled');   
                        //  $("#ms-selected_come [class*=ms-elem-selectable]").removeClass("disabled");
                        // $("#ms-selected_come [class*=ms-elem-selection]").removeClass("disabled");
                       }
                        else
                        {
                        //      $("#ms-id2021"+x+" [class*=ms-elem-selectable]").removeClass("disabled");
                        // $("#ms-id2021"+x+" [class*=ms-elem-selection]").removeClass("disabled");
                        // if(x==2)
                        // {
                        // $('#row_1').find('input, textarea, button, select').removeAttr('disabled','disabled');     
                        // }
                        $('#todataaction_'+x1+'').find('input, textarea, button, select').removeAttr('disabled','disabled'); 
                        }


    });

 $(wrapper_name).on('keyup', '.newnamecheck', function(e) {

 
            var value = $(this).val();
            var come = $('#comefromcheck').val();
            var clickpopup = $('#clickpopup').val();
           
          if(clickpopup=='Rename')
           {
            
            var fromaction = $('input[name="newnamecheck[]"]').map(function () {
                    if(this.value!='')
                    {
                        return this.value;    
                    }
                    
            }).get();
            

                if(value!='' && value.length>0 && fromaction!='')
                {
                    // $('.add_button').attr('disabled', true);
                    $('.add_button_name').attr('disabled', false);
                }
                else
                {
                   // $('.add_button').attr('disabled', false);
                    $('.add_button_name').attr('disabled', true);
                }
            }
            
            

    }); 


  $(wrapper_name).on('change', '.Statusyear', function(e) {

     var value = $(this).val();
    var idindex = this.id;
    var i = idindex.split('_');
// JC_11
//  var fromaction = document.getElementsByName('namefrom[]');

// if(value!='' && fromaction.length==1)
//     {
        
//         $('.add_button').attr('disabled', true);

        
//          $('.add_button_name').attr('disabled', false);
//     }
//     else
//     {
//          //$('#oremove1').attr('disabled', true);
//      //    $('.field_wrapper').empty();
//         $('.add_button').attr('disabled', false);
//         $('.add_button_name').attr('disabled', true);
//     }

   // var fromaction = $('select[name="namefrom[]"] option:selected').map(function () {
   //                  if(this.value!='')
   //                  {
   //                      return this.value;    
   //                  }
                    
   //          }).get();
    // alert($('#toStatus_'+i[1]+'').val());
    // alert(value);
    var newname = $('#name2021'+i[1]).val();
    if(value != '' && newname.length >= 1){
            EnableAddButton2();
        } else if(value == '' && newname.length >= 0) {
            DisableAddButton2();
        }
  if($('#clickpopup').val()=='Rename')
  {
    if($('#toStatus_'+i[1]+'').val() !='' && $('#toStatus_'+i[1]+'').val()!=value)
    {
         $('#assignbtn').attr('disabled', false);
          $('.add_button_name').attr('disabled', false);
    }
    else
    {
        // JIGARGOHEL
        if(i[1]==1)
        {
var status = $('#oremovenew').is(":checked");
        }
        else
        {
var status = $('#oremovenew'+i[1]+'').is(":checked");
        }
     
       if(status==true) 
       {
         $('#assignbtn').attr('disabled', false);
          $('.add_button_name').attr('disabled', false);
       }
       else
       {
         $('#assignbtn').attr('disabled', true);
          $('.add_button_name').attr('disabled', true);
       }

 
    } 
  }
            
            

    }); 

});

</script>