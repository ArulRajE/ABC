
<div class="row">
                            <div class="col-xl-4 col-md-6">
                                <div class="card">
                                    <div class="card-body" style="background-color: #7bc01e;">
                                         <a href="<?php echo $ahrfdt; ?>" style="cursor: pointer;">
                                        <div class="media">
                                            
                                            <div class="media-body overflow-hidden">
                                                <h2 style="color: #FFFFFF !important" class="mt-0 mb-1" <?php if(gettype($statecount)=="integer") {  ?>data-plugin="counterup"<?php } ?>  id="state_count_name"><?php echo $statecount; ?></h2>
                                               
                                                <big style="color: #FFFFFF !important" class="text-primary"><b>States/UTs (<?php echo $_SESSION['activeyears']; ?>)</b></big>
                                            </div>
                                             <img src="image/state.png" class="avatar-md mr-3 align-self-center" alt="user">
                                        </div>
                                    </a>
                                    </div>
                                </div>
                            </div>
        
                            <div class="col-xl-4 col-md-6">
                                <div class="card">
                                    <div class="card-body" style="background-color:#15bfd3;">
                                         <a href="<?php echo $ahrfsd; ?>" style="cursor: pointer;">
                                        <div class="media">
                                              <div class="media-body overflow-hidden">
                                                <h2 style="color: #FFFFFF !important" class="mt-0 mb-1" <?php if(gettype($districtscount)=="integer") {  ?>data-plugin="counterup"<?php } ?>  id="districts_count_name"><?php echo $districtscount; ?></h2>
                                               
                                                <big style="color: #FFFFFF !important" class="text-primary"><b>Districts (<?php echo $_SESSION['activeyears']; ?>)</b></big>
                                            </div>
                                             <img src="image/districts.png" class="avatar-md mr-3 align-self-center" alt="user">
                                        </div>
                                       </a>
                                    </div>
                                </div>
                            </div>
        
                            <div class="col-xl-4 col-md-6">
                                <div class="card">
                                    <div class="card-body" style="background-color: #c04585;">
                                       <a href="<?php echo $ahrfvt; ?>"  style="cursor: pointer;">
                                        <div class="media">
                                             <div class="media-body overflow-hidden">
                                                <h2 style="color: #FFFFFF !important" class="mt-0 mb-1" <?php if(gettype($subdistrictscount)=="integer") {  ?>data-plugin="counterup"<?php } ?> id="sub_districts_count_name"><?php echo $subdistrictscount; ?></h2>
                                               
                                                <big style="color: #FFFFFF !important" class="text-primary"><b>Sub-Districts (<?php echo $_SESSION['activeyears']; ?>)</b></big>
                                            </div>
                                             <img src="image/subdistricts.png" class="avatar-md mr-3 align-self-center" alt="user">
                                        </div>
                                    </a>
                                    </div>
                                </div>
                            </div>
        
                          
                        </div>


                        <div class="row">
                            
                            <div class="col-xl-4 col-md-6">
                                <div class="card">
                                    <div class="card-body" style="background-color: #aba000;">
                                         <a href="#"  style="cursor: pointer;">
                                        <div class="media">
                                             <div class="media-body overflow-hidden">
                                                <h2 style="color: #FFFFFF !important" class="mt-0 mb-1"  id="villages_count_name" <?php if(gettype($villagecount)=="integer") {  ?>data-plugin="counterup"<?php } ?>><?php echo $villagecount; ?></h2>
                                               
                                                <big style="color: #FFFFFF !important" class="text-primary"><b>Villages (<?php echo $_SESSION['activeyears']; ?>)</b></big>
                                            </div>
                                             <img src="image/villages.png" class="avatar-md mr-3 align-self-center" alt="user">
                                        </div>
                                    </a>
                                    </div>
                                </div>
                            </div>

                             <div class="col-xl-4 col-md-6">
                                <div class="card">
                                    <div class="card-body" style="background-color: #fe6271;">
                                         <a href="#"  style="cursor: pointer;">
                                        <div class="media">
                                           
                                             <div class="media-body overflow-hidden">
                                                <h2 style="color: #FFFFFF !important" class="mt-0 mb-1"  id="town_count_name" <?php if(gettype($towncount)=="integer") {  ?>data-plugin="counterup"<?php } ?> ><?php echo $towncount; ?></h2>
                                               
                                                <big style="color: #FFFFFF !important" class="text-primary"><b>Towns (<?php echo $_SESSION['activeyears']; ?>)</b></big>
                                            </div>
                                        
                                             <img src="image/villages.png" class="avatar-md mr-3 align-self-center" alt="user">
                                        </div>
                                    </a>
                                    </div>
                                </div>
                            </div>

                            <?php /* ?><div class="col-xl-4 col-md-6">
                                <div class="card">
                                    <div class="card-body" style="background-color: #fd7700;">
                                         <a href="javascript:void(0);" style="cursor: pointer;">
                                        <div class="media">
                                             <div class="media-body overflow-hidden">
                                                <h2 style="color: #FFFFFF !important" class="mt-0 mb-1"  id="wards_count_name" <?php if(gettype($wardscount)=="integer") {  ?>data-plugin="counterup"<?php } ?>><?php echo $wardscount; ?></h2>
                                               
                                                <big style="color: #FFFFFF !important" class="text-primary"><b>Wards (<?php echo $_SESSION['activeyears']; ?>)</b></big>
                                            </div>
                                             <img src="image/blocks.png" class="avatar-md mr-3 align-self-center" alt="user">
                                        </div>
                                    </a>
                                    </div>
                                </div>
                            </div> <?php */ ?>

                            <!-- <div class="col-xl-4 col-md-6">
                                <div class="card">
                                    <div class="card-body" style="background-color: #fe6271;">
                                        <div class="media">
                                             <div class="media-body overflow-hidden">
                                                <h5 style="color: #FFFFFF !important" class="mt-0 mb-1" data-plugin="counterup">660668</h5>
                                               
                                                <big style="color: #FFFFFF !important" class="text-primary"><b>Local Bodies</b></big>
                                            </div>
                                             <img src="image/local-bodies.png" class="avatar-md mr-3 align-self-center" alt="user">
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>