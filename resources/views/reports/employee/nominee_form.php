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
            <form action="<?php echo URL?>reports/employee/nominee" method="GET" enctype="multipart/form-data" id="cat" >
                  <div class="card-body-x p-1">
                     <div class="form-group">
                        <label class="m-0" for="EmployeeCode">Employee Code</label>
                        <!-- ?php echo form_input('EmployeeCode','text',null,'class="form-control form-control-sm EmployeeCode" name="datainput" id="EmployeeCode" placeholder="Type Employee Code" required'); ?> -->
                        <input type="text" autocomplete="off" name="employee_code" class="form-control form-control-sm EmployeeCode" id="" value="AC-01<?php if (isset($EmployeeCode)){echo $EmployeeCode;}?>">
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
                           <h5 class="text-center" style="margin-top: 20px;"><b>ফরম-৪১</b></h5>
                           <p class="text-center" style="margin-top: -2px;">[ধারা ১৯,১৩১(১)(ক),১৫৫(২),২৩৪,২৬৪,২৬৫ ও ২৭৩ এবং বিধি ১১৮(১),১৩৬,২৩২(২),২৬২(১),২৮৯(১)ও ৩২১(১)দ্রষ্টব্য]</p>
                           <h6 class="text-center" style="margin-top: -8px;margin-bottom: 60px;"><b><u>জমা ও বিভিন্নখাতে প্রাপ্য অর্থ পরিশোধের ঘোষণা ও মনোনয়নের ফরম</u></b></h6>
                           <p>১। কারখানার/প্রতিষ্ঠানের নামঃ</p>
                           <p>২। কারখানা/প্রতিষ্ঠানের ঠিকানাঃ</p>
                           <p>৩। শ্রমিকের নামঃ<b> <?php if (isset($appoint[0]['name_bangla'])){echo $appoint[0]['name_bangla'];} ?> </b></p>
                           <p>৪। পিতা/মাতা/স্বামী/স্ত্রীর নামঃ<b> <?php if (isset($appoint[0]['fathers_name_bangla'])){echo $appoint[0]['fathers_name_bangla'];} ?> </b></p>
                           <p>৫। জন্ম তারিখঃ <?php if (isset($appoint[0]['DOB'])){echo $appoint[0]['DOB'];} ?></P>
                           <p>৬। সনাক্তকরণ চিহ্ন (যদি থাকে) ঃ<?php if (isset($appoint[0]['identification'])){echo $appoint[0]['identification'];} ?></p>
                           <p>৭। বর্তমান ঠিকানাঃ <?php if (isset($appoint[0]['present_vill_bangla'])){echo $appoint[0]['present_vill_bangla'];} ?>,
                                 <?php if (isset($appoint[0]['present_post_bangla'])){echo $appoint[0]['present_post_bangla'];} ?>,
                                 <?php if (isset($appoint[0]['present_thana_bangla'])){echo $appoint[0]['present_thana_bangla'];} ?>,
                                 <?php if (isset($appoint[0]['present_dist_bangla'])){echo $appoint[0]['present_dist_bangla'];} ?> ।</p>
                           <p>৮। স্থায়ী ঠিকানাঃ <?php if (isset($appoint[0]['permanent_vill_bangla'])){echo $appoint[0]['permanent_vill_bangla'];} ?>,
                                 <?php if (isset($appoint[0]['permanent_post_bangla'])){echo $appoint[0]['permanent_post_bangla'];} ?>,
                                 <?php if (isset($appoint[0]['permanent_thana_bangla'])){echo $appoint[0]['permanent_thana_bangla'];} ?>,
                                 <?php if (isset($appoint[0]['permanent_dist_bangla'])){echo $appoint[0]['permanent_dist_bangla'];} ?> ।</p> 
                           <p>৯। চাকুরিতে নিযুক্তির তারিখঃ <?php if (isset($appoint[0]['DOJ'])){echo $appoint[0]['DOJ'];} ?></p>
                           <p>১০। পদের নামঃ<?php if (isset($appoint[0]['designation_bangla'])){echo $appoint[0]['designation_bangla'];} ?></p>
                           <p class="text-justify">আমি এতদ্বারা ঘোষণা করিতেছি যে,আমার মৃত্যু হইলে বা আমার অর্বতমানে,আমার অনুকুলে জমা ও বিভিন্নখাতে প্রাপ্য টাকা 
                              গ্রহণের জন্য আমি নিম্নেবর্ণিত ব্যক্তিকে/ব্যক্তিগণকে মনোনয়ন দান করিতেছি এবং নির্দেশ দিচ্ছি যে,উক্ত টাকা নিম্নেবর্ণিত পদ্ধতিতে 
                              মনোনীত ব্যক্তিদের মধ্যে বন্টন করিতে হইবেঃ-</p>
                           <table class="table table-bordered text-center">
                              <tr>
                                 <th>মনোনীত ব্যক্তি বা ব্যক্তিদের নাম,ঠিকানা ও ছবি(নমিনির ছবি ও স্বাক্ষর শ্রমিক কর্তৃক সত্যায়িত)এন আই ডি নং</th>
                                 <th>সদস্যদের সহিত মনোনীত ব্যক্তিদের সম্পর্ক</th>
                                 <th style="width: 100px">বয়স</th>
                                 <th colspan="2" >প্রত্যেক মনোনীত ব্যক্তিকে দেয়া অংশ</th>                                 
                              </tr>
                              <tr>
                                 <td>(১)</td>
                                 <td>(২)</td>
                                 <td>(৩)</td>
                                 <td style="width: 400px" colspan="2">(৪)</td>                                
                              </tr>
                              <tr>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td>জমা খাত</td>                                
                                 <td style="width: 100px">অংশ</td>                                
                              </tr>
                              <tr>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td>বকেয়া মজুরী</td>                                
                                 <td></td>                                
                              </tr><tr>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td>প্রভিডেন্ট ফান্ড</td>                                
                                 <td></td>                                
                              </tr><tr>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td>বীমা</td>                                
                                 <td></td>                                
                              </tr><tr>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td>দূর্ঘটনার ক্ষতিপূরণ</td>                                
                                 <td></td>                                
                              </tr><tr>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td>লভ্যাংশ</td>                                
                                 <td></td>                                
                              </tr><tr>
                                 <td></td>
                                 <td></td>
                                 <td></td>
                                 <td>অন্যান্য</td>                                
                                 <td></td>                                
                              </tr>
                           </table>

                           <p class="text-justify">প্রত্যয়ন করিতেছি যে, আমার উপস্থিতিতে জনাব/জনাবা <b> <?php if (isset($appoint[0]['name_bangla'])){echo $appoint[0]['name_bangla'];} ?> </b>
                              লিপিবদ্ধ বিবরণসমূহ পাঠ করিবার পর উক্ত ঘোষণা স্বাক্ষর করিয়াছেন।</p>
                           <div class="row">
                              <div class="col-sm-8">
                                 
                              </div>
                              <div class="col-sm-4">
                                 <p class="text-center" style="margin-top: 40px">মনোনয়ন প্রদানকারী শ্রমিকের স্বাক্ষর,টিপসহি ও তারিখ</p>
                              </div>
                           </div>
                           <div class="row" style="margin-top: 40px">
                              <div class="col-sm-4 text-center">
                                 <p>মনোনীত ব্যক্তিগণের স্বাক্ষর,টিপসহি ও তারিখ (শ্রমিক কর্তৃক সত্যায়িত ছবি)</p>
                              </div>                             
                              <div class="col-sm-8">
                                 <p class="text-right">মালিকের বা প্রধিকারপ্রাপ্ত কর্মকর্তার স্বাক্ষর<br> তারিখঃ_____________________</p>
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
           let url = "<?php echo route('reports/employee/nominee'); ?>";
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