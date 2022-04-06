<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Main content -->
   <section class="content pt-2 pb-0">
      <div class="container-fluid">
         <div class="d-print-none"></div>
         <div class="row">
            <!-- left column -->
            <div class="col-sm-3 d-print-none">
               <!-- card -->
               <div class="card card-info card-outline">
                  <form action="<?php echo URL ?>reports/employee/resignation" method="post" enctype="multipart/form-data" id="cat">
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
         <div class="col-md-9" id="divIDClass">
            <!-- card -->
            <div class="card card-info-x card-outline print-employee-info d-print-block">
               <div class="card-body-x p-3">
                  <button class="btn btn-info float-right btn-sm ml-3 btn-print d-print-none">
                     <i class="fa fa-print fa-2x"></i>
                  </button>
                  <div class="row content-data">

                     <div class="container" ><br><br><br><br><br>

                        <p>বরাবর,</p>
                        <p style="margin-bottom:7px;">মানব-সম্পদ ও প্রশাসন বিভাগ,</p>
                        <p style="margin-bottom:7px;"><?php echo $company_info['local_name']; ?></p>
                        <p><?php echo $company_info['local_address']; ?></p><br>
                        <p>বিষয়ঃ চাকুরী হতে অব্যহতি প্রসঙ্গে ।</p><br>
                        <p>জনাব </p>
                        <p class="text-justify">যথাবিহীত সম্মান পূবর্ক নিবেদন এই যে, আমি 
                           <?php if (!empty($employee_info['name_bangla'])) {
                              echo $employee_info['name_bangla'];
                           }
                           if (!empty($employee_info['local_name'])) {
                              echo ' ' . $employee_info['local_name'];
                           }else{echo "__________________________________";} ?> এই র্মমে অবগত করতেছি যে আমার ব্যাক্তিগত পারিবারিক ও জমি সংক্রান্ত জামেলার জন্য আপনার কারখানায় চাকুরী করা সম্ভব হচ্ছেনা । আমকে যতেষ্ট সময় সেটির জন্য দিতে হচ্ছে । আমার এই অবস্থান বিবেচনা করে আমাকে ৩১/১২/২০২১ ইং থেকে অব্যহতি দিয়ে বাধিত করবেন ।</p><br>
                        <p>অতএব, আমাকে ৩১/১২/২০২১ ইং থেকে অব্যহতি দিয়ে আমার সমুদয় পাওনাদি পরিশোধ করার জন্য অনুরোধ জানাচ্ছি।</p>
                        <br><br><br>
                        <p class="mb-4">বিনীত,</p>
                        <div class="row">
                           <div class="col"><?php if (!empty($employee_info['name_bangla'])) {
                                                echo $employee_info['name_bangla'];
                                             }else{echo"___________________";} ?></div>
                        </div>
                        <div class="row">
                           <div class="col"><?php if (!empty($employee_info['local_name'])) {
                                                echo ' ' . $employee_info['local_name'];
                                             }else{echo"<br>___________________";} ?></div>
                        </div>
                        <div class="row">
                           <div class="col">যোগদানের তারিখঃ <?php if (!empty($employee_info['DOJ'])) {
                                                               $date = date_create($employee_info['DOJ']);
                                                               $employee_info['DOJ'] = date_format($date, "d-m-Y");
                                                               $employee_info['DOJ'] = $NumberConverter->en2bn($employee_info['DOJ']);
                                                               $employee_info['DOJ'] = str_replace("-", "/", $employee_info['DOJ']);
                                                               echo $employee_info['DOJ'] . ' ইং';
                                                            } ?> </div>
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