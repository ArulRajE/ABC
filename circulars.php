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
                            <h4 class="header-title mb-4"><span class="dropcap1 text-primary">Census Circulars</span>
                            </h4>



                            <table id="circulars-units-datatable" class="table table-striped table-bordered nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <!--  <tr>
                                                    <th colspan="7" style="background-color: #fe6271; color: #FFFFFF">Administrative Units Information - 2011</th>
                                                     <th colspan="8" style="background-color: #15bed2; color: #FFFFFF ">Administrative Units Information - 2021</th>
                                                    
                                                </tr> -->
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Date</th>
                                        <th>Circular No.</th>
                                        <th>File</th>
                                        <th>Subject</th>
                                        <th>Download/View</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                                $flag =0;
                                                while ($data = pg_fetch_array($result)) { 
                                                        $filedata = explode('|',$data['file']);
                                                       $flag = $flag+1;

                                                    ?>

                                    <tr>
                                        <td><?php echo $flag; ?></td>
                                        <td><?php echo date("d-m-Y",strtotime($data['date'])); ?></td>
                                        <td><?php echo $data['no']; ?></td>
                                        <td class="wrap"><?php echo $data['filename']; ?></td>
                                        <td class="wrap"><?php echo $data['subjectdata']; ?></td>
                                        <td class="classcolor wrap">
                                            <?php for($i=0;$i<count($filedata);$i++){ 
                                                        $ext = explode('.',$filedata[$i]);
                                                            ?>
                                            <a href="Circular/<?php echo $filedata[$i]; ?>" target="_blank">
                                                <?php if($ext[1]=="xlsx") { ?>
                                                <i class="fas fa-file-excel fa-2x mb-2" data-toggle="tooltip"
                                                    data-placement="top" title=""
                                                    data-original-title="<?php echo $filedata[$i]; ?>"></i> &nbsp;
                                                <?php } elseif ($ext[1]=="doc") { ?>
                                                <i class="fas fa-file-word fa-2x mb-2" data-toggle="tooltip"
                                                    data-placement="top" title=""
                                                    data-original-title="<?php echo $filedata[$i]; ?>"></i> &nbsp;
                                                <?php } else {  ?>
                                                <i class="fas fa-file-pdf fa-2x mb-2" data-toggle="tooltip"
                                                    data-placement="top" title=""
                                                    data-original-title="<?php echo $filedata[$i]; ?>"></i> &nbsp;
                                                <?php } ?>
                                            </a>
                                            <?php } ?>
                                        </td>

                                    </tr>
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
<div id="con-close-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-horizontal group-border-dashed parsley-examples" id="updatestate">
                <input type="hidden" name="update_ids" id="update_ids" value="">
                <!--  <input type="hidden" name="formname" id="formname" value="updatestatedata"> -->
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">UPDATE STATE</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div>

                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">&nbsp;</label>

                                    <label class="col-md-5 col-form-label">2011</label>
                                    <label class="col-md-5 col-form-label">2021</label>


                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">State Name</label>
                                    <div class="col-md-5">
                                        <input type="text" name="STName2011" id="STName2011" class="form-control"
                                            disabled="disabled" placeholder="State Name 2011" />
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="STName2021" id="STName2021"
                                            placeholder="State Name 2021" />
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Short code</label>

                                    <div class="col-md-5">
                                        <input type="text" class="form-control" id="Short_ST2011" name="Short_ST2011"
                                            disabled="disabled" placeholder="Short code" />
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" data-parsley-minlength="1"
                                            data-parsley-maxlength="3" id="Short_ST2021" name="Short_ST2021" required
                                            placeholder="Short code" />
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-md-2 col-form-label">MDDS Code</label>

                                    <div class="col-md-5">
                                        <input type="text" class="form-control" disabled="disabled"
                                            placeholder="MDDS Code" id="MDDS_ST2011" name="MDDS_ST2011" />
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" id="MDDS_ST2021" data-parsley-minlength="1"
                                            data-parsley-maxlength="3" name="MDDS_ST2021"
                                            onkeypress="return numbersOnly12(event)" class="form-control" required
                                            placeholder="MDDS Code" />
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

<div id="con-close-modal-add" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-horizontal group-border-dashed" data-parsley-validate novalidate
                data-parsley-trigger="keyup" id="addstate">
                <input type="hidden" name="formname" id="formname" value="addstatedata">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">ADD STATE</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div>

                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">&nbsp;</label>
                                    <label class="col-md-5 col-form-label">2021</label>


                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">State Name</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="addSTName2021" id="addSTName2021"
                                            required placeholder="State Name 2021" />
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Short code</label>

                                    <div class="col-md-10">
                                        <input type="text" class="form-control" required name="addShort_ST2021"
                                            id="addShort_ST2021" data-parsley-minlength="1" data-parsley-maxlength="3"
                                            placeholder="Short code" onkeypress="return numbersOnly12(event)"
                                            data-parsley-trigger="keyup" />
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-md-2 col-form-label">MDDS Code</label>

                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="addMDDS_ST2021"
                                            id="addMDDS_ST2021" required data-parsley-minlength="1"
                                            data-parsley-maxlength="3" onkeypress="return numbersOnly12(event)"
                                            data-parsley-trigger="keyup" placeholder="MDDS Code" />
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

<script type="text/javascript">
$(function() {

    $('#districts_count_name').text(<?php echo $dt; ?>);
    $('#sub_districts_count_name').text(<?php echo $sd; ?>);
    $('#villages_count_name').text(<?php echo $vt; ?>);
    $('#town_count_name').text(<?php echo $ct; ?>);
    $('#wards_count_name').text(<?php echo $wd; ?>);

});
</script>