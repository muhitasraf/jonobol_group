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
            <form action="<?php echo URL?>reports/employee/appointment_letter" method="GET" enctype="multipart/form-data" id="cat" >
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
         <div class="col-md-9">
            <!-- card -->
            <div class="card card-info-x card-outline print-employee-info d-print-block">
                  <div class="card-body-x p-3">
                     <button class="btn btn-info float-right btn-sm ml-3 btn-print d-print-none">
                        <i class="fa fa-print fa-2x"></i>
                     </button>
                     <div class="row content-data">                        
                        <div class="container" id="divIDClass">
                           <h5 class="text-center"><b>হ্যামকো লেদারস লিমিটেড</b></h5>
                           <p class="text-center" style="margin-top: -2px;">আন্দারমানিক , মৌচাক, কালিয়াকৈর, গাজীপুর</p>
                           <h6 class="text-center" style="margin-top: -8px;margin-bottom: 20px;"><b><u>নিয়োগত্র</u></b></h6>
                           <div class="row">
                              <div class="col-sm-4">                     
                                 <p>নামঃ <b> <?php if (isset($appoint[0]['name_bangla'])){echo $appoint[0]['name_bangla'];} ?> </b></P>                     
                              </div>
                              <div class="col-sm-4">
                                 <p>পিতার নামঃ <?php if (isset($appoint[0]['fathers_name_bangla'])){echo $appoint[0]['fathers_name_bangla'];} ?></P>
                              </div>
                              <div class="col-sm-4">
                                 <p>মাতার নামঃ <?php if (isset($appoint[0]['mothers_name_bangla'])){echo $appoint[0]['mothers_name_bangla'];} ?> </P>
                              </div>
                           </div>

                           <div class="row">
                              <div class="col-sm-5">
                                 <p>স্বামী/স্ত্রীর নাম (প্রযোজ্য ক্ষেত্রে) <?php if (isset($appoint[0]['spouse_name_bangla'])){echo $appoint[0]['spouse_name_bangla'];} ?> </P>
                              </div>
                              <div class="col-sm-3">
                                 <p>আইডি নংঃ <?php if (isset($appoint[0]['NationalIDCardNo'])){echo $appoint[0]['NationalIDCardNo'];} ?></P>
                              </div>
                              <div class="col-sm-3">
                                 <p>পদবীঃ <?php if (isset($appoint[0]['posting_place'])){echo $appoint[0]['posting_place'];} ?></P>
                              </div>
                              <!-- <div class="col-sm-3">
                                 <p >বিভাগঃ</P>
                              </div> -->
                           </div>
                           <div class="row">
                              <div class="col-sm-6">
                                 <p>বিভাগঃ <?php if (isset($appoint[0]['designation_bangla'])){echo $appoint[0]['designation_bangla'];} ?></P>
                              </div>
                              <div class="col-sm-6">
                                 <p>শ্রমিকের শ্রেণীঃ <?php if (isset($appoint[0]['labour_class'])){echo $appoint[0]['labour_class'];} ?></P>
                              </div>
                           </div>

                           <div class="row">
                              <div class="col-sm-4">
                                 <p>যোগদানের তারিখঃ <?php if (isset($appoint[0]['DOJ'])){echo $appoint[0]['DOJ'];} ?></P>
                              </div>
                              <div class="col-sm-4">
                                 <p>গ্রেড (শ্রমিক/কর্মচারী) <?php if (isset($appoint[0]['labour_grade'])){echo $appoint[0]['labour_grade'];} ?> ঃ</P>
                              </div>
                              <div class="col-sm-4">
                                 <p>সেকশনঃ <?php if (isset($appoint[0]['name_bangla'])){echo $appoint[0]['name_bangla'];} ?></P>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-12">
                                 <p>বর্তমান ঠিকানাঃ <?php if (isset($appoint[0]['present_vill_bangla'])){echo $appoint[0]['present_vill_bangla'];} ?>,
                                    <?php if (isset($appoint[0]['present_post_bangla'])){echo $appoint[0]['present_post_bangla'];} ?>,
                                    <?php if (isset($appoint[0]['present_thana_bangla'])){echo $appoint[0]['present_thana_bangla'];} ?>,
                                    <?php if (isset($appoint[0]['present_dist_bangla'])){echo $appoint[0]['present_dist_bangla'];} ?> </P>
                                 <p>স্থায়ী ঠিকানাঃ <?php if (isset($appoint[0]['permanent_vill_bangla'])){echo $appoint[0]['permanent_vill_bangla'];} ?>,
                                    <?php if (isset($appoint[0]['permanent_post_bangla'])){echo $appoint[0]['permanent_post_bangla'];} ?>,
                                    <?php if (isset($appoint[0]['permanent_thana_bangla'])){echo $appoint[0]['permanent_thana_bangla'];} ?>,
                                    <?php if (isset($appoint[0]['permanent_dist_bangla'])){echo $appoint[0]['permanent_dist_bangla'];} ?></P>                    
                              </div>
                           </div>
                           <p class="text-center" style="margin-top: -8px;margin-bottom: 30px;"><b><u>প্রার্থীর চাকুরীর শর্ত ও নিয়মাবলী</u></b></p>
                           <p class="text-left" style="margin-top: -8px;margin-bottom: 10px;"><b><u>১। বেতন ও ভাতা (Salary and Allownace) :</u></b></p>
                           <div class="row">
                              <div class="col-sm-4 ">
                                 <p style="margin-top: 2px ;margin-bottom: 2px;"> মূল বেতন (Monthly Basic Pay) </p>
                                 <p style="margin-top: 2px ;margin-bottom: 2px;"> বাড়ী ভাড়া (House Rent 50% Basic Pay)</p>
                                 <p style="margin-top: 2px ;margin-bottom: 2px;"> চিকিৎসা ভাতা (Medical Allowance)</p>
                                 <p style="margin-top: 2px ;margin-bottom: 2px;"> যাতায়াত ভাতা (Transport Allowance)</p>
                                 <p style="margin-top: 2px ;margin-bottom: 2px;"> খাদ্য ভাতা (Food Allowance)</p>
                                 <p style="margin-top: 2px ;margin-bottom: 2px;"><b> মোট বেতন (Monthly Gross Pay)</b></p>                   
                              </div>
                              <div class="col-sm-4">
                                 <p style="margin-top: 2px ;margin-bottom: 2px;">: টাকা ------ <?php if (isset($appoint[0]['EntrySalary'])){echo $appoint[0]['EntrySalary'];} ?></p>                                 
                                 <p style="margin-top: 2px ;margin-bottom: 2px;">: টাকা ------</p>                               
                                 <p style="margin-top: 2px ;margin-bottom: 2px;">: টাকা ------</p>                               
                                 <p style="margin-top: 2px ;margin-bottom: 2px;">: টাকা ------</p>                               
                                 <p style="margin-top: 2px ;margin-bottom: 2px;">: টাকা ------</p>                               
                                 <p style="margin-top: 2px ;margin-bottom: 2px;">: টাকা ------</p>                               
                              </div>
                              <div class="col-sm-4 justify-content-right border" style="border-width:2px  !important ; border-color:black !important; width:10px !important;">
                                 <h6 class="text-center" style="margin-top: 10px ;margin-bottom: 10px;"><b><u>প্রতি ঘন্টার ওভারটাইম</u></b></h6>
                                 <h6 class="text-center" style="margin-top: 10px ;margin-bottom: 10px;"><b><u>Per Hour OT Rate</u></b></h6>
                                 <p class="text-center">টাকাঃ -- </P>                     
                              </div>
                           </div> 
                           <p class="text-left" style="margin-top: 10px;margin-bottom: 10px;"><b>২। আপনার নিয়োগ ও চাকুরীর শর্তাবলী বাংলাদেশ শ্রম আইন, ২০০৬ এর বিধান অনুযায়ী পরিচালিত হইবে।</b></p>
                           <p class="text-left" style="margin-top: -8px;margin-bottom: 5px;"><b>৩। কর্মঘন্টা এবং ওভার টাইম (Working Hour and OverTime):</b></p>
                           <div class="row">
                              <div class="col-sm-3">
                                 <p style="margin-top: 2px ;margin-bottom: 2px;">ক) দৈনিক কর্মঘন্টাঃ</p>
                                 <p style="margin-top: 2px ;margin-bottom: 2px;">খ) বিরতিঃ</p>
                                 <p style="margin-top: 2px ;margin-bottom: 2px;">গ) দৈনিক ওভারটাইমঃ</p>
                                 <p style="margin-top: 2px ;margin-bottom: 2px;">ঘ) ওভারটাইম হিসাবঃ</p>
                                 <p>ঙ) বেতন প্রদানের সময়ঃ</p>
                              </div>
                              <div class="col-sm-9">
                                 <p style="margin-top: 2px ;margin-bottom: 2px;">০৮ ঘন্টা।</p>
                                 <p style="margin-top: 2px ;margin-bottom: 2px;">প্রতি কর্ম দিবসে / শিফটে ০১ ঘন্টা</p>
                                 <p style="margin-top: 2px ;margin-bottom: 2px;">শ্রমিকের সম্মতিক্রমে সর্বোচ্চ ০২ ঘন্টা বা প্রযোজ্য ক্ষেত্রে সরকারী নিয়ম মোতাবেক।</p>
                                 <p style="margin-top: 2px ;margin-bottom: 2px;">মূল বেতনের দ্বিগুণ হারে হিসাব করা হয়। হিসাবঃ মূল বেতন স্ট ২০৮দ্ধ২দ্ধমোট ওভারটাইম ঘন্টা।</p>
                                 <p style="margin-top: 2px ;margin-bottom: 2px;">প্রত্যেক মাসের মজুরী পরবর্তী মাসের ০৭ (সাত) কর্ম দিবসের মধ্যে বেতন ওভারটাইম একত্রে প্রদান করা হয়।</p>                     
                              </div>                 
                           </div>
                           <p class="text-left" style="margin-top: -8px;margin-bottom: 10px;"><b>৪। সাধারণ ছুটিঃ</b></p>
                           <div class="row">
                              <div class="col-sm-3">
                                 <p style="margin-top: 2px ;margin-bottom: 2px;">ক) সাপ্তাহিক ছুটিঃ</p>
                                 <p style="margin-top: 2px ;margin-bottom: 2px;">খ) উৎসবজনিত ছুটিঃ</p>
                                 <p style="margin-top: 2px ;margin-bottom: 2px;">গ) নৈমিত্তিক ছুটিঃ</p>
                                 <p style="margin-top: 2px ;margin-bottom: 2px;">ঘ) পীড়া/অসুস্থতাজনিত ছুটিঃ</p>
                                 <p style="margin-top: 2px ;margin-bottom: 2px;">ঙ) বাৎসরিক/অর্জিত ছুটিঃ</p>
                                 <p style="margin-top: 2px ;margin-bottom: 2px;">চ) মাতৃত্বকালীন ছুটিঃ</p>                     
                              </div>
                              <div class="col-sm-9">
                                 <p style="margin-top: 2px ;margin-bottom: 2px;">০৮ ঘন্টা।</p>
                                 <p style="margin-top: 2px ;margin-bottom: 2px;">প্রতি কর্ম দিবসে / শিফটে ০১ ঘন্টা</p>
                                 <p style="margin-top: 2px ;margin-bottom: 2px;">শ্রমিকের সম্মতিক্রমে সর্বোচ্চ ০২ ঘন্টা বা প্রযোজ্য ক্ষেত্রে সরকারী নিয়ম মোতাবেক।</p>
                                 <p style="margin-top: 2px ;margin-bottom: 2px;">মূল বেতনের দ্বিগুণ হারে হিসাব করা হয়। হিসাবঃ মূল বেতন স্ট ২০৮দ্ধ২দ্ধমোট ওভারটাইম ঘন্টা।</p>
                                 <p style="margin-top: 2px ;margin-bottom: 2px;">প্রত্যেক মাসের মজুরী পরবর্তী মাসের ০৭ (সাত) কর্ম দিবসের মধ্যে বেতন ওভারটাইম একত্রে প্রদান করা হয়।</p>
                                 <p>১৬ (ষোল) সপ্তাহ বা ১১২ (একশত বারো) দিন (পূর্ণ বেতনে)। (অন্যান্য শর্তগুলো শ্রম আইন অনুযায়ী হইবে)।</p>                     
                              </div>                 
                           </div>               
                           <p class="text-left" style="margin-top: -8px;margin-bottom: 10px;"><b>৫। অন্যান্য সুবিধা (Other Benefits):</b></p>
                           <div class="row col-sm-12">
                              <p style="margin-top: 2px ;margin-bottom: 2px;">ক) প্রাথমিক চিকিৎসা সুবিধা প্রদান করা হয়।</p>
                              <p style="margin-top: 2px ;margin-bottom: 2px;">খ) উৎসব ভাতাঃ নিরবিচ্ছন্নভাবে ০১(এক) বছর চাকুরী সম্পন্ন করলে বৎসরে ০২(দুই) টি উৎসব ভাতা প্রদান করা হয়, যা মাসিক মূল মজুরীর অধিক নহে।</p>
                              <p style="margin-top: 2px ;margin-bottom: 2px;">গ) হাজিরা বোনাসঃ আপনি বর্তমান পদবীতে হাজিরা বোনাস হিসেবে ৩০০ টাকা পাবেন। প্রযোজ্য ক্ষেত্রে/ কোম্পানীর নিয়ম অনুযায়ী।</p>
                              <p>ঘ) বেতন বৃদ্ধিঃ মূল মজুরির ০৫% হারে বাৎসরিক মজুরি বৃদ্ধি পাইবে।</p>
                           </div>
                           <p class="text-left" style="margin-top: -8px;margin-bottom: 5px;"><b>৬। শর্তাবলী (Conditions):</b></p>
                           <div class="row col-sm-12">
                              <p class="text-justify" style="margin-top: 8px;margin-bottom: 5px;">ক) আপনার শিক্ষানবীশ কাল ০৩ (তিন) মাস। কৃতিত্বের সাথে এই শিক্ষনবীশ কাল অতিক্রান্ত হওয়ার সাথে সাথেই আপনি চাকুরীতে স্থায়ী হয়েছেন বলে গণ্য হবে। তবে প্রথম ০৩ (তিন) মাস শিক্ষানবীশ কালে আপনার
                                 কাজের মান নির্ণয় করা সম্ভব না হলে আপনার শিক্ষানবীশ কাল আরও ০৩ (তিন) মাস বৃদ্ধি করা যাবে এবং সে ক্ষেত্রে আপনাকে লিখিতভাবে যথাসময়ে অবহিত করা হবে। শিক্ষানবীশ কালীন সময়ে কর্তৃপক্ষ আপনাকে 
                                 কোন প্রকার পূর্ব নোটিশ ছাড়াই আপনাকে চাকুরী থেকে টার্মিনেট/ অবসান করতে পারবেন এবং আপনিও পূর্ব নোটিশ ব্যতির‌্যকে চাকুরী থেকে ইস্তফা দিতে পারবেন। সেক্ষেত্রে আপনার হাজিরা অনুযায়ী সকল পাওনা 
                                 পরিশোধ করা হবে।</p>
                              <p class="text-justify" style="margin-top: 8px;margin-bottom: 5px;">খ) চাকুরী স্থায়ী হবার পর আপনি চাকুরী হইতে ইস্তফা দিতে চাইলে আপনাকে শ্রম আইন মোতাবেক ৬০ (ষাট) দিনের লিখিত নোটিশ বা নোটিশের পরিবর্তে ৬০(ষাট) দিনের মূল মজুরী কর্তৃপক্ষকে পরিশোধ করতে হবে। 
                                 অপরদিকে কর্তৃপক্ষ আপনার চাকুরীর অবসান করতে চাইলে ১২০ (একশত বিশ) দিনের লিখিত নোটিশ অথবা নোটিশের পরিবর্তে ১২০ দিনের মূল মজুরী প্রদান করবেন এবং প্রযোজ্য ক্ষেত্রে অন্যান্য আইনানুগ পাওনাদির 
                                 পরিশোধ করবেন।</p>
                              <p class="text-justify" style="margin-top: 8px;margin-bottom: 5px;">গ) কোম্পানীর প্রচলিত নিয়ম কানুন আপনি মেনে চলতে বাধ্য থাকবেন এবং সময়ে সময়ে পরিবর্তিত নিয়ম কানুন মেনে চলতে বাধ্য থাকবেন। আপনি শ্রম আইন অনুযায়ী অসদাচারনের দায়ে দোষী প্রমানিত হলে, কর্তৃপক্ষ 
                                 আপনাকে চাকুরী থেকে বরখাস্ত করতে পারেন অথবা ক্ষেত্র মতে বরখাস্তের পরিবর্তে শ্রম আইন অনুযায়ী লঘু শাস্তি প্রদান করতে পারবেন।</p>
                              <p class="text-justify" style="margin-top: 8px;margin-bottom: 5px;">ঘ) অত্র প্রতিষ্ঠানটি হ্যামকো গ্রুপের একটি প্রতিষ্ঠান। কর্তৃপক্ষ প্রয়োজনবোধে আপনাকে এই প্রতিষ্ঠানের যে কোন বিভাগে বা হ্যামকো গ্রুপের যে কোন প্রতিষ্ঠানে/কারখানায়/অফিসে বদলি করতে পারবেন।</p>
                              <p class="text-justify" style="margin-top: 8px;margin-bottom: 5px;">ঙ) অত্র প্রতিষ্ঠানে কর্মরত থাকাকালীন সময় আপনি অন্য কোথাও প্রত্যক্ষ বা পরোক্ষভাবে কোন চাকুরী গ্রহণ করতে পারবেন না। আপনার চাকুরীর পরিসমাপ্তি ঘটলে আপনি এই কোম্পানীর সমস্ত কাগজপত্র, 
                                 দলিলাদি অথবা অন্য কোন বস্তু আপনার হেফাজতে থাকলে, সেই সকল দ্রব্যাদি ফেরত দিবেন এবং কোম্পানীর ব্যবসা সংক্রান্ত কোন কাগজপত্রের সকল অথবা অংশ বিশেষ আপনার নিকট রাখতে পারবেন না। 
                                 আপনি নির্দিষ্ট দায়িত্ব পালনকালে বা চাকুরী পরিবর্তনের ক্ষেত্রে প্রতিষ্ঠানের ব্যবসায়িক কৌশলের গোপনীয়তা সংরক্ষন করবেন। নিয়োগের যাবতীয় শর্ত বিদ্যমান শ্রম আইন অনুযায়ী পরিচালিত হবে।</p>
                           </div>
                           <div class="row">
                              <div class="col-sm-8">
                              </div>
                              <div class="col-sm-4">
                                 <p class="text-center" style="margin-top: 30px">নিয়োগকর্তার স্বাক্ষর (Employer Signature)</p>
                              </div>
                           </div>
                           <div class="row">
                              <p><b><u>প্রত্যয়ন</u></b>:আমি এই নিয়োগপত্রের সকল শর্তাবলী পাঠ করেছি/আমাকে পাঠ করে শুনানো হয়েছে। এতে বর্ণিত সকল শর্তাদি সম্পূর্ণরূপে অবগত হয়ে, আমি স্বেচ্ছায় উপরোক্ত শর্তসমূহ মেনে নিয়ে, স্বজ্ঞানে স্বাক্ষর প্রদান করে নিয়োগ </p>
                           </div>
                           <div class="row" style="margin-top: 20px">
                              <div class="col-sm-8">
                                 <p>যোগদানের তারিখঃ <?php if (isset($appoint[0]['DOJ'])){echo $appoint[0]['DOJ'];} ?></p>
                              </div>
                              <div class="col-sm-4">
                                 <p class="text-center">প্রার্থীর স্বাক্ষার</p>
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