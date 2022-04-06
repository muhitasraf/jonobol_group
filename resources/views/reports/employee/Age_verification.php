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
            <form action="<?php echo URL?>reports/employee/age_verification" method="GET" enctype="multipart/form-data" id="cat" >
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
                           <p class="text-center">ফরম-১৫</p>
                           <p class="text-center">[ধারা ৩৪,৩৬,৩৭ ও ২৭৭ এবং বিধি ৩৪ (১) ও ৩৩৬ (৪) দ্রষ্টব্য]</p>
                           <h6 class="text-center" style="margin-top: -8px;margin-bottom: 20px;">বয়স ও সক্ষমতার প্রত্যয়নপত্র (Certificate of Age and Fitness)</h6>
                           <div class="row">
                              <table class="table table-bordered" style="border-color:black">
                                 <tr>
                                    <th class="text-center" style="width: 50%"><b>বয়স ও সক্ষমতার প্রত্যয়নপত্র</b></th>
                                    <th class="text-center" style="width: 50%"><b>বয়স ও সক্ষমতার প্রত্যয়নপত্র</b></th>
                                 </tr>
                                 <tr>
                                    <td>
                                       <div class="row">
                                          <div class="col-sm-6">
                                             <p>১. ক্রমিক নং..........</p>
                                          </div>
                                          <div class="col-sm-6">
                                             <p class="text-right">তারিখ:..................</p>
                                          </div>
                                       </div>                                       
                                       <p>২. নামঃ <b> <?php if (isset($appoint[0]['name_bangla'])){echo $appoint[0]['name_bangla'];} ?> </b></p>
                                       <p>৩. পিতার নামঃ <b> <?php if (isset($appoint[0]['fathers_name_bangla'])){echo $appoint[0]['fathers_name_bangla'];} ?> </b></p>
                                       <p>৪. মাতার নামঃ <b> <?php if (isset($appoint[0]['mothers_name_bangla'])){echo $appoint[0]['mothers_name_bangla'];} ?> </b></p>
                                       <p>৫. লিঙ্গঃ <b> <?php if (isset($appoint[0]['Gender'])){echo $appoint[0]['Gender'];} ?> </b></P>
                                       <p>৬. স্থায়ী ঠিকানাঃ <b> <?php if (isset($appoint[0]['permanent_vill_bangla'])){echo $appoint[0]['permanent_vill_bangla'];} ?>,
                                          <?php if (isset($appoint[0]['permanent_post_bangla'])){echo $appoint[0]['permanent_post_bangla'];} ?>,
                                          <?php if (isset($appoint[0]['permanent_thana_bangla'])){echo $appoint[0]['permanent_thana_bangla'];} ?>,
                                          <?php if (isset($appoint[0]['permanent_dist_bangla'])){echo $appoint[0]['permanent_dist_bangla'];} ?></b> ।</p>
                                       <p>৭. বর্তমান ঠিকানাঃ<b> <?php if (isset($appoint[0]['present_vill_bangla'])){echo $appoint[0]['present_vill_bangla'];} ?>,
                                          <?php if (isset($appoint[0]['present_post_bangla'])){echo $appoint[0]['present_post_bangla'];} ?>,
                                          <?php if (isset($appoint[0]['present_thana_bangla'])){echo $appoint[0]['present_thana_bangla'];} ?>,
                                          <?php if (isset($appoint[0]['present_dist_bangla'])){echo $appoint[0]['present_dist_bangla'];} ?></b> ।</p>
                                       <p>৮. জন্ম সনদ/শিক্ষা সনদ অনুসারে বয়স/ জন্ম তারিখঃ<b> <?php if (isset($appoint[0]['DOB'])){echo $appoint[0]['DOB'];} ?> </b></p>
                                       <div class="row">
                                          <div class="col-sm-6">
                                             <p>৯. ওজনঃ<?php if (isset($appoint[0]['weight'])){echo $appoint[0]['weight'];} ?></p>
                                          </div>
                                          <div class="col-sm-6">
                                             <p>১০. উচ্চতাঃ<?php if (isset($appoint[0]['height'])){echo $appoint[0]['height'];} ?></p>
                                          </div>
                                       </div>
                                       <p>১১. দৈহিক সক্ষমতাঃ<?php if (isset($appoint[0]['body_capability'])){echo $appoint[0]['body_capability'];} ?></p>
                                       <p>১২. সনাক্তকরণচিহ্নঃ<?php if (isset($appoint[0]['identification'])){echo $appoint[0]['identification'];} ?></p>
                                    </td>                                    
                                    <td>
                                       <div class="row">
                                          <div class="col-sm-6">
                                             <p>১. ক্রমিক নং..........</p>
                                          </div>
                                          <div class="col-sm-6">
                                             <p class="text-right">তারিখ:..................</p>
                                          </div>
                                       </div>                                       
                                       <p>আমি এই মর্মে প্রত্যয়ন করিতেছি যে,<b> <?php if (isset($appoint[0]['name_bangla'])){echo $appoint[0]['name_bangla'];} ?> </b></p>
                                       <p>পিতার নামঃ <b> <?php if (isset($appoint[0]['fathers_name_bangla'])){echo $appoint[0]['fathers_name_bangla'];} ?> </b></p>
                                       <p>মাতার নামঃ <b> <?php if (isset($appoint[0]['mothers_name_bangla'])){echo $appoint[0]['mothers_name_bangla'];} ?> </b></p>
                                       <p>ঠিকানাঃ <b> <?php if (isset($appoint[0]['present_vill_bangla'])){echo $appoint[0]['present_vill_bangla'];} ?>,
                                          <?php if (isset($appoint[0]['present_post_bangla'])){echo $appoint[0]['present_post_bangla'];} ?>,
                                          <?php if (isset($appoint[0]['present_thana_bangla'])){echo $appoint[0]['present_thana_bangla'];} ?>,
                                          <?php if (isset($appoint[0]['present_dist_bangla'])){echo $appoint[0]['present_dist_bangla'];} ?></b> ।</p>
                                       <p>কে আমি পরীক্ষা করিয়াছি।</p>
                                       <p class="text-justify">তিনি প্রতিষ্ঠানে নিযুক্ত হইতে ইচ্ছুক এবং আমার পরীক্ষা হইতে এইরুপ পাওয়া গিয়েছে যে, তাহার বয়স ____বৎসর এবং তিনি প্রতিষ্ঠানে প্রাপ্ত বয়স্ক/কিশোর হিসাবে নিযুক্ত হইবার যোগ্য।</p>
                                       <p style="margin-top: 50px;">তাহার সনাক্তকরেণর চিহ্নঃ<?php if (isset($appoint[0]['identification'])){echo $appoint[0]['identification'];} ?></p>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td>
                                       <div class="row" style="margin-top: 100px">
                                          <div class="col-sm-6">
                                             <p>প্রার্থীর স্বাক্ষরঃ</p>
                                          </div>
                                          <div class="col-sm-6">
                                             <p>রেজিস্টার্ড চিকিৎসকের স্বাক্ষরঃ</p>
                                          </div>
                                       </div>
                                    </td>
                                    <td>
                                       <div class="row" style="margin-top: 100px">
                                          <div class="col-sm-6">
                                             <p>প্রার্থীর স্বাক্ষরঃ</p>
                                          </div>
                                          <div class="col-sm-6">
                                             <p>রেজিস্টার্ড চিকিৎসকের স্বাক্ষরঃ</p>
                                          </div>
                                       </div>
                                    </td>
                                 </tr>
                              </table>
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
           let url = "<?php echo route('reports/employee/age_verification'); ?>";
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