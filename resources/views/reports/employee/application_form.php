<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Main content -->
<section class="content pt-2 pb-0">
   <div class="container-fluid">
      <div class="d-print-none"></div>
      <div class="row">
         <!-- left column -->
         <div class="col-sm-4 d-print-none">
            <!-- card -->
            <div class="card card-info card-outline">
            <form action="<?php echo URL?>reports/employee/application_form" method="post" enctype="multipart/form-data" id="cat" >
                  <div class="card-body-x p-1">
                     <div class="form-group">
                        <label class="m-0" for="EmployeeCode">Employee Code</label>
                        <!-- ?php echo form_input('EmployeeCode','text',null,'class="form-control form-control-sm EmployeeCode" name="datainput" id="EmployeeCode" placeholder="Type Employee Code" required'); ?> -->
                        <input type="text" autocomplete="off" name="employee_code" class="form-control form-control-sm EmployeeCode" id="" value="<?php if (isset($EmployeeCode)){echo $EmployeeCode;}?>">
                     </div>
                  </div>
                  <div class="card-footer">
                     <button class="btn btn-sm btn-info float-right btn-get-data" type="submit" >
                        <i class="fa fa-search"></i> Search
                     </button>
                  </form>
                  </div>
            </div>
         </div>
         <div class="col-md-7">
            <!-- card -->
            <div class="card card-info-x card-outline print-employee-info d-print-block">
                  <div class="card-body-x p-3">
                     <button class="btn btn-info float-right btn-sm ml-3 btn-print d-print-none">
                        <i class="fa fa-print fa-2x"></i>
                     </button>
                     <div class="row content-data">
                        
            <div class="container" id="divIDClass">
               <h5 class="text-center">চাকুরির আবেদন পত্র</h5>
               <p class="text-center" style="margin-top: -22px;"><b>______________________</b></p>
               <div class="row">
                  <div class="col-sm-12">
                     <p >তারিখ:</P>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-12">
                     <P  style="margin-top: -15px;">বরাবর</P>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-12">
                     <P style="margin-top: -15px;">মহাব্যবস্থাপক</P>
                     <P style="margin-top: -15px;">----------------- ।</p>
                     <P style="margin-top: -15px;">------------------- ।</p>
                     <P class="">বিষয়:...................পদে চাকুরির জন্য আবেদন।</P>
                  </div>
               </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <p >জনাব,</p>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <p style="margin-top: -15px;">সবিনয় নিবেদন এই যে, আমি বিশ্বস্ত সূত্রে/ বিজ্ঞপ্তির মাধ্যমে জানতে পারলাম আপনার প্রতিষ্ঠানে................. পদে কিছু সংখ্যক জনবল নিয়োগ করা হবে। আমি উক্ত পদের একজন আগ্রহী প্রার্থী হিসাবে নিন্মে আমার জীবন বৃত্তান্ত প্রদান/ উপস্থাপন করলাম</p>
                     </div>
                  </div>
                  <br>
                  <div class="row">
                     <div class="col-sm-3">
                        <p>১। নামঃ <?php if (isset($application_report[0]['name_bangla'])){echo $application_report[0]['name_bangla'];} ?></p>
                     </div>
                     <div class="col-sm-3">
                        <p>২। মাতাঃ <?php if (isset($application_report[0]['mothers_name_bangla'])){echo $application_report[0]['mothers_name_bangla'];} ?></p>
                     </div>
                     <div class="col-sm-3">
                        <p>৩। পিতাঃ <?php if (isset($application_report[0]['fathers_name_bangla'])){echo $application_report[0]['fathers_name_bangla'];} ?></p>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-sm-3">
                        <p>৪। স্বামী/স্ত্রীঃ <?php if (isset($application_report[0]['spouse_name_bangla'])){echo $application_report[0]['spouse_name_bangla'];} ?></p>
                     </div>
                     <div class="col-sm-3">
                        <p>৫। জন্ম তারিখঃ <?php if (isset($application_report[0]['dob_bangla'])){echo $application_report[0]['dob_bangla'];} ?></p>
                     </div>
                     
                  </div>
                  <div class="row">
                     <div class="col-sm-3">
                        <p>৬। বর্তমান ঠিকানাঃ</p>
                     </div>
                     <div class="col-sm-3">
                        <p>গ্রামঃ <?php if (isset($application_report[0]['present_vill_bangla'])){echo $application_report[0]['present_vill_bangla'];} ?></p>
                        <p>থানা/উপজেলাঃ <?php if (isset($application_report[0]['present_thana_bangla'])){echo $application_report[0]['present_thana_bangla'];} ?>.</p>
                     </div>
                     <div class="col-sm-3">
                        <p>ডাকঘরঃ <?php if (isset($application_report[0]['present_post_bangla'])){echo $application_report[0]['present_post_bangla'];} ?></p>
                        <p>জেলাঃ <?php if (isset($application_report[0]['present_dist_bangla'])){echo $application_report[0]['present_dist_bangla'];} ?></p>
                     </div>
                     
                  </div>
                  

                  <div class="row">
                     <div class="col-sm-3">
                        <p>৬। স্থায়ী ঠিকানাঃ</p>
                     </div>
                     <div class="col-sm-3">
                        <p>গ্রামঃ <?php if (isset($application_report[0]['permanent_vill_bangla	'])){echo $application_report[0]['permanent_vill_bangla'];} ?></p>
                        <p>থানা/উপজেলাঃ <?php if (isset($application_report[0]['permanent_thana_bangla'])){echo $application_report[0]['permanent_thana_bangla'];} ?></p>
                     </div>
                     <div class="col-sm-3">
                        <p>ডাকঘরঃ <?php if (isset($application_report[0]['permanent_post_bangla'])){echo $application_report[0]['permanent_post_bangla'];} ?></p>
                        <p>জেলাঃ <?php if (isset($application_report[0]['permanent_dist_bangla'])){echo $application_report[0]['permanent_dist_bangla'];} ?></p>
                     </div>
                     
                  </div>

                  <div class="row">
                     <div class="col-sm-4">
                        <p>৭। জরুরী ফোন( যদি থাকে) ঃ <?php if (isset($application_report[0]['phone_bangla'])){echo $application_report[0]['phone_bangla'];} ?></p>
                     </div>
                     <div class="col-sm-4">
                        <p>৮। রক্তের গ্রুপ‌ঃ <?php if (isset($application_report[0]['blood_bangla'])){echo $application_report[0]['blood_bangla'];} ?></p>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-4">
                        <p>৯। শিক্ষাগত যোগ্যতাঃ <?php if (isset($application_report[0]['education_bangla'])){echo $application_report[0]['education_bangla'];} ?></p>
                     </div>
                     <div class="col-sm-4">
                        <p>১০। জাতীয়তাঃ <?php if (isset($application_report[0]['nationality_bangla'])){echo $application_report[0]['nationality_bangla'];} ?></p>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-3">
                        <p>১১। ধর্মঃ <?php if (isset($application_report[0]['religion_bangla'])){echo $application_report[0]['religion_bangla'];} ?></p>
                     </div>
                     <div class="col-sm-3">
                        <p>১২। বৈবাহিক অবস্থাঃ <?php if (isset($application_report[0]['maritial_bangla'])){echo $application_report[0]['maritial_bangla'];} ?></p>
                     </div>
                     <div class="col-sm-3">
                        <p>১৩। সন্তানের সংখ্যাঃ <?php if (isset($application_report[0]['child_number_bangla'])){echo $application_report[0]['child_number_bangla'];} ?></p>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <p>১৪। অভিজ্ঞতাঃ <?php if (isset($application_report[0]['experience_bangla'])){echo $application_report[0]['experience_bangla'];} ?>বছর/মাস</p>
                     </div>
                     
                  </div>
                  <div class="row">
                     <div class="col-sm-3">
                        <p> ফ্যাক্টরী নাম: <?php if (isset($application_report[0]['exp_factory_bangla'])){echo $application_report[0]['exp_factory_bangla'];} ?></p>
                     </div>
                     <div class="col-sm-3">
                        <p>পদবী: <?php if (isset($application_report[0]['exp_designation_bangla'])){echo $application_report[0]['exp_designation_bangla'];} ?></p>
                     </div>
                     <div class="col-sm-3">
                        <p>কার্যকাল: <?php if (isset($application_report[0]['exp_year_bangla'])){echo $application_report[0]['exp_year_bangla'];} ?></p>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-sm-6">
                        <p>১৬। আমাকে চেনে এবং জানে এরুপ দুজন ব্যাক্তির নাম ও ঠিকানা:</p>
                     </div>
                     
                  </div>
                  <div class="row">
                     <div class="col-sm-4">
                        <p>ক। নাম: <?php if (isset($application_report[0]['intro_1_name'])){echo $application_report[0]['intro_1_name'];} ?></p>
                     </div>
                     <div class="col-sm-4">
                        <p>খ। নাম: <?php if (isset($application_report[0]['intro_2_name'])){echo $application_report[0]['intro_2_name'];} ?></p>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-sm-3">
                        <p>গ্রাম: <?php if (isset($application_report[0]['intro_1_vill'])){echo $application_report[0]['intro_1_vill'];} ?></p>
                        <p>থানা: <?php if (isset($application_report[0]['intro_1_thana'])){echo $application_report[0]['intro_1_thana'];}?></p>
                     </div>
                     <div class="col-sm-3">
                        <p>ডাকঘর: <?php if (isset($application_report[0]['intro_1_post'])){echo $application_report[0]['intro_1_post'];} ?></p>
                        <p>জেলা: <?php if (isset($application_report[0]['intro_1_dist'])){echo $application_report[0]['intro_1_dist'];} ?></p>
                     </div>
                     <div class="col-sm-3">
                        <p>গ্রাম: <?php if (isset($application_report[0]['intro_2_vill'])){echo $application_report[0]['intro_2_vill'];} ?></p>
                        <p>থানা: <?php if (isset($application_report[0]['intro_2_thana'])){echo $application_report[0]['intro_2_thana'];} ?></p>
                     </div>
                     <div class="col-sm-3">
                        <p>ডাকঘর: <?php if (isset($application_report[0]['intro_2_post'])){echo $application_report[0]['intro_2_post'];} ?></p>
                        <p>জেলা: <?php if (isset($application_report[0]['intro_2_dist'])){echo $application_report[0]['intro_2_dist'];} ?></p>
                     </div>
                     
                  </div>

                  <div class="row">
                     <div class="col-sm-5">
                        <p>ফোন নং: <?php if (isset($application_report[0]['intro_1_phone'])){echo $application_report[0]['intro_1_phone'];} ?></p>
                     </div>
                     <div class="col-sm-5">
                        <p>ফোন নং: <?php if (isset($application_report[0]['intro_2_phone'])){echo $application_report[0]['intro_2_phone'];} ?></p>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <p>অতএব, আমার আবেদন প্রেক্ষিতে যোগ্যতা যাচাই সাপেক্ষে আমাকে উক্ত পদে নিয়োগ দান করলে কৃতজ্ঞ থাকব।</p>
                     </div>

                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <p><b>সংযুক্তি: </b>পাসপোর্ট ছবি, জাতীয় পরিচয় পত্র,চেয়ারম্যান সাটিফিকেট,শিক্ষাগতা সনদের ফটোকপি এবং অবিজ্ঞতার প্রমাণ পত্র(যদি থাকে)এর ফটোকপি</p>
                     </div>

                  </div>
                  <div class="row ">
                     <div class="col-sm-12">
                     <p class="float-right" style="margin-bottom: -2px;">_______________</p>
                     </div>

                  </div>
                  <div class="row ">
                     <div class="col-sm-12">
                        <p class="float-right">আবেদনকারীর স্বাক্ষর</p>
                                                
                     </div>

                  </div>
               </div>
            
                     </div>
                  </div>
                  <!-- /.card-body -->
               </div>
               <!-- /.card -->
         </div>
         <!--/.col (left) -->
      </div>     
      <!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<script></script>
<script>
   $(function () {
       $('.btn-get-data').on('click',function () {   
           let EmployeeCode = $('.EmployeeCode').val();
           let url = "<?php echo route('reports/employee/application_form'); ?>";
           $.get(url,{EmployeeCode:EmployeeCode},function (data) {
               //hide spinner after data loaded.
               $('div.spinner').hide();
               $('div.content-data').empty().append(data);
           });
       });   
       $('.btn-print').on('click',function () {
           window.print();
       });
   });

  
</script>

<script> 
var s=<?php echo $key?>;

 if(s==0)
 {
   $("#divIDClass").hide();
 }

 else if(s==1){
    
   $('#cat').on('submit',function(){
         $("#divIDClass").show();
         s=0;
      });
 }
  
   </script>