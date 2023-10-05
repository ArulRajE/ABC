<?php include ("header.php"); include ("topbar.php"); include ("menu.php");
// $where = ""; 
$action = "";
if($header!=0 && $rows['assignlist']!=null)  
{
    $action = explode(',',$rows['assignlist']);
    // $where = 'where "stCount2021"."STID2021" in ('.$rows['assignlist'].')';
}
else
{
    $action = "";
}

$result = pg_query($db, 'select * from (select * from "dtCount2011"
LEFT JOIN forreaddata2021
On "dtCount2011"."DTID2011" = forreaddata2021."frfromids" 
) data2011 
INNER JOIN "forreaddt2021"  
ON data2011."frtoids"="forreaddt2021"."DTID" ORDER BY data2011."DTID2011",data2011."frids" ASC');


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


            <!-- end page title -->
           
            <!-- end row -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-4"><span class="dropcap text-primary">District wise</span>
                                For Read - <?php echo  $_SESSION['activeyears']; ?></h4>



                            <table id="units-datatable" class="table table-hover table-striped table-bordered"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th colspan="4" style="background-color: #fe6271; color: #FFFFFF">For - <?php echo $_SESSION['logindetails']['baseyear']; ?></th>
                                        <th colspan="5" style="background-color: #15bed2; color: #FFFFFF ">
                                            Read - <?php echo $_SESSION['activeyears']; ?></th>

                                    </tr>
                                    <tr>
                                        <th>State MDDS</th>
                                        <th>States/UTs Name</th>
                                        <th>District MDDS</th>
                                        <th>District Name</th>
                                       
                                        <th>State MDDS</th>
                                        <th>States/UTs Name</th>
                                        <th>District MDDS</th>
                                        <th>District Name</th>
                                        <th>Remarks</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 

                                                while ($data = pg_fetch_array($result)) { 
                                                   
                                                    $remarksdata ='';
                                                      
                                                           


                                          ?>

                                    <tr>

                                        <td><?php echo $data['MDDS_ST'.$_SESSION['logindetails']['baseyear'].'']; ?></td>
                                        <td><?php echo $data['STName'.$_SESSION['logindetails']['baseyear'].'']; ?></td>
                                        <td><?php echo $data['MDDS_DT'.$_SESSION['logindetails']['baseyear'].'']; ?></td>
                                        <td><?php echo $data['DTName'.$_SESSION['logindetails']['baseyear'].'']; ?></td>
                                        <td class="class2021"><?php echo $data['MDDS_ST']; ?></td>
                                        <td class="class2021"><?php echo $data['STName']; ?></td>
                                        <td class="class2021"><?php echo $data['MDDS_DT']; ?></td>
                                        <td class="class2021"><?php echo $data['DTName']; ?></td>
                                        <td class="class2021"><?php echo $data['']; ?></td>
                                      
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


<script type="text/javascript">
$('select').select2({
    maximumInputLength: 20 // only allow terms up to 20 characters long
});
</script>
