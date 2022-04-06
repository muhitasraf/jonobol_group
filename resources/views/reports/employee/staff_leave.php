<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Main content -->
   <section class="content pt-2 pb-0">
      <div class="container-fluid">
         <div class="d-print-none"></div>
         <div class="row">
            <!-- left column -->
            <div class="col-sm-2 d-print-none">
               <!-- card -->
               <div class="card card-info card-outline">
                  <form action="<?php echo URL ?>reports/employee/staff_leave" method="post" enctype="multipart/form-data" id="cat">
                     <div class="card-body-x p-1">
                        <div class="form-group">
                           <label class="m-0" for="EmployeeCode">Employee Code</label>
                           <!-- ?php echo form_input('EmployeeCode','text',null,'class="form-control form-control-sm EmployeeCode" name="datainput" id="EmployeeCode" placeholder="Type Employee Code" required'); ?> -->
                           <input type="text" autocomplete="off" name="employee_code" class="form-control form-control-sm EmployeeCode" id="" value="<?php if (isset($EmployeeCode)) {
                                                                                                                                                         echo $EmployeeCode;
                                                                                                                                                      } ?>">
                        </div>
                     </div>
                     <div class="card-footer">
                        <button class="btn btn-sm btn-info float-right btn-get-data" type="submit">
                           <i class="fa fa-search"></i> Search
                        </button>
                  </form>
               </div>
            </div>
         </div>
         <div class="col-md-10" id="divIDClass">
            <!-- card -->
            <div class="card card-info-x card-outline print-employee-info d-print-block">
               <div class="card-body-x p-3">
                  <button class="btn btn-info float-right btn-sm ml-3 btn-print d-print-none">
                     <i class="fa fa-print fa-2x"></i>
                  </button>
                  <div class="row content-data">
                     <div class="container" >
                        <div class="row container">
                           <div class="col-sm-12 text-center pt-3 mt-3">
                              <div class="float-center">
                                 <?php
                                 $path = "uploads/images/";
                                 $company_photo = $path . "company/" . $company_info->logo;
                                 $file_dir = upload_path("/images/company/" . $company_info->logo);
                                 if (!$company_info->logo || !is_file($file_dir)) {
                                    $company_photo = $path . "no-image.jpg";
                                 }
                                 ?>
                                 <img class="img img-fluid rounded company-logo" src="<?php echo asset($company_photo); ?>" alt="Company Logo">
                                 <p class=""><b><u>Leave Application From</u></b></p>
                              </div>
                           </div>
                        </div>
                        <!-- <div class="content-justify-center"><img src="" alt=""></div> -->
                        <div class="ml-3 mr-4">
                           <div class="row mt-4">
                              <div class="col-md-8">
                                 <p>Name: <?php echo ($getStaffLeaveApproved['EmployeeName']); ?></p>
                                 <p>Designation: <?php echo ($getStaffLeaveApproved['Designation']); ?></p>
                              </div>
                              <div class="col-md-4">
                                 <p>ID No: <?php echo ($getStaffLeaveApproved['EmployeeCode']); ?></p>
                                 <p>Department: <?php echo ($getStaffLeaveApproved['Department']); ?></p>
                              </div>
                              <div class="col">
                                 <p>Date of Joining: <?php if (!empty($getStaffLeaveApproved['DOJ'])) {
                                                         $date = date_create($getStaffLeaveApproved['DOJ']);
                                                         echo date_format($date, "d-m-Y");
                                                      } ?>
                                 </p>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-4">
                                 <p>Leave From:</p>
                              </div>
                              <div class="col-md-4">
                                 <p>To:</p>
                              </div>
                              <div class="col-md-4">
                                 <p>Total:</p>
                              </div>
                              <div class="col">
                                 <p>Leave Type: <i class="fa-solid fa-square-full border border-dark"></i> Casual Leave <i class="fa-solid fa-square border border-dark"></i> Medical Leave (Sick Leave) <i class="fa-solid fa-square border border-dark"></i> Earn Leave (Annual Leave)</p>
                                 <p>Cause of leave:</p>
                                 <p>Contract Address on Leave:</p>
                                 <p>Phone/Mobile: <?php echo ($getStaffLeaveApproved['Mobile']); ?></p>
                                 <p>Duties Will Be Carried Out By:</p>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <p>Name:</p>
                                       <p>Section:</p>
                                    </div>
                                    <div class="col-md-5">
                                       <p>Designation:</p>
                                       <p>Cell:</p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <br><br><br>
                           <div class="row">
                              <div class="col-md-4">
                                 <p>_____________________</p>
                                 <p style="margin-top: -18px;">Signature of the Applicant</p>
                              </div>
                              <div class="col-md-4">
                              </div>
                              <div class="col-md-4">
                                 <p class="text-right">_____________________</p>
                                 <p class="text-right" style="margin-top: -18px;">Signature of Cover Person</p>
                              </div>
                           </div>
                           <br>
                           <p class="text-center"><b>Leave Status (To Be Filled by HR Department)</b></p>
                           <p class="text-center" style="margin-top: -30px;">_________________________________________</p>
                           <p>Data of joining: <?php if (!empty($getStaffLeaveApproved['DOJ'])) {
                                                   $date = date_create($getStaffLeaveApproved['DOJ']);
                                                   echo date_format($date, "d-m-Y");
                                                } ?>
                           </p>
                           <table border="1" bordercolor="black" width="100%" height="250px" class="">
                              <tr class="text-center">
                                 <th class="">Leave</th>
                                 <th class="">Casual</th>
                                 <th class="">Sick</th>
                                 <th class="">Annual</th>
                                 <th class="" rowspan="4"></th>
                              </tr>
                              <tr>
                                 <td class="p-1">Entitled</td>
                                 <td class="text-center"><?php if (!empty($allocatedDaysApproved[0])) {
                                                            echo $allocatedDaysApproved[0];
                                                         } ?></td>
                                 <td class="text-center"><?php if (!empty($allocatedDaysApproved[1])) {
                                                            echo $allocatedDaysApproved[1];
                                                         } ?></td>
                                 <td class="text-center" rowspan="4"><?php if (!empty($annual_leave['TotalDays'])) {
                                                                        echo (round($annual_leave['TotalDays'] / 18));
                                                                     } ?></td>
                              </tr>
                              <tr>
                                 <td class="p-1">Availed</td>
                                 <td class="text-center"><?php if (!empty($availedDaysApproved[0])) {
                                                            echo (int)$availedDaysApproved[0];
                                                         } ?></td>
                                 <td class="text-center"><?php if (!empty($availedDaysApproved[1])) {
                                                            echo  (int)$availedDaysApproved[1];
                                                         } ?></td>
                              </tr>
                              <tr>
                                 <td class="p-1">Balance</td>
                                 <td class="text-center"><?php if (!empty($allocatedDaysApproved[0])) {
                                                            echo $allocatedDaysApproved[0] - $availedDaysApproved[0];
                                                         } ?></td>
                                 <td class="text-center"><?php if (!empty($allocatedDaysApproved[1])) {
                                                            echo $allocatedDaysApproved[1] - $availedDaysApproved[1];
                                                         } ?></td>
                              </tr>
                              <tr>
                                 <td class="p-1">Approved</td>
                                 <td class="text-center"><?php if (!empty($availedDaysNotApproved[0])) {
                                                            echo (int)$availedDaysNotApproved[0];
                                                         } ?></td>
                                 <td class="text-center"><?php if (!empty($availedDaysNotApproved[1])) {
                                                            echo  (int)$availedDaysNotApproved[1];
                                                         } ?></td>
                                 <td class="text-center"><b>HR &amp; ADMIN</b></td>
                              </tr>
                           </table>
                           <br>
                           <br>
                           <div class="row mt-4 pt-4">
                              <div class="col-md-4">
                                 <span class="">______________________</span>
                                 <p class="">Recommend by Dept. Head</p>
                              </div>
                              <div class="col-md-3">
                                 <span class="">_________________</span>
                                 <p class="">Department Manager</p>
                              </div>
                              <div class="col-md-2">
                                 <span class="">__________</span>
                                 <p class="">HR & ADMIN</p>
                              </div>
                              <div class="col-md-3 text-right">
                                 <span class="">__________________</span>
                                 <p class="">Approved By DMD/MD</p>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!--/.col (left) -->
                  </div>
                  <!-- /.container-fluid -->
   </section>
   <!-- /.content -->
</div>

<script>
   var s = <?php echo $key ?>;

   if (s == 0) {
      $("#divIDClass").hide();
   } else if (s == 1) {

      $('#cat').on('submit', function() {
         $("#divIDClass").show();
         s = 0;
      });
   }
</script>