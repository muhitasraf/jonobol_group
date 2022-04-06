<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content pt-2 pb-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class=""><?php echo $title; ?></div>
                    <div class="card card-info card-outline">
                     
                        <div class="tab-content" id="custom-content-above-tabContent">

                            <div class="tab-pane fade show active" id="step-one" role="tabpanel" aria-labelledby="step-one-tab">
                                    <div class="card">
                                        <div class="card-group pt-1"><!-- card-deck -->                                            
                                            <!-- center column -->
                                            <div class="col-sm-3">
                                                <!-- general form elements -->
                                                <div class="card card-primary">
                                                    <span class="bg-info text-center">Date Setting</span>
                                                    <div class="card-body-x p-1">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group mb-2">
                                                                    <label class="m-0" for="from_date">From Date</label>
                                                                    <?php
                                                                        echo form_input('from_date','text',date('d-m-Y'),'class="form-control form-control-sm form_date" id="from_date" autocomplete="off" readonly');
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group mb-2">
                                                                    <label class="m-0" for="to_date">To Date</label>
                                                                    <?php
                                                                    echo form_input('to_date','text',date('d-m-Y'),'class="form-control form-control-sm form_date" id="to_date" autocomplete="off" readonly');
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /.card-body -->
                                                    <div class="card card-primary">
                                                        <span class="bg-info text-center">Select your dates</span>
                                                        <div class="card-body-x p-3">
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <table class="table table-sm table-bordered table-scroll">
                                                                        <tbody class="dates-tbody">
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group mb-2 border-bottom">
                                                                    <div class="input-group">
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input off_day" type="checkbox" id="Friday" value="7" name="off_day">
                                                                            <label class="form-check-label" for="Friday">Friday</label>
                                                                        </div>
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input off_day" type="checkbox" id="Saturday" value="1" name="off_day">
                                                                            <label class="form-check-label" for="Saturday">Saturday</label>
                                                                        </div>
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input off_day" type="checkbox" id="Sunday" value="2" name="off_day">
                                                                            <label class="form-check-label" for="Sunday">Sunday</label>
                                                                        </div>
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input off_day" type="checkbox" id="Monday" value="3" name="off_day">
                                                                            <label class="form-check-label" for="Monday">Monday</label>
                                                                        </div>
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input off_day" type="checkbox" id="Tuesday" value="4" name="off_day">
                                                                            <label class="form-check-label" for="Tuesday">Tuesday</label>
                                                                        </div>
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input off_day" type="checkbox" id="Wednesday" value="5" name="off_day">
                                                                            <label class="form-check-label" for="Wednesday">Wednesday</label>
                                                                        </div>
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input off_day" type="checkbox" id="Thursday" value="6" name="off_day">
                                                                            <label class="form-check-label" for="Thursday">Thursday</label>
                                                                        </div>
                                                                    </div>
                                                                    <!-- /input-group -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                </div>
                                                <!-- /.card -->
                                            </div><!--/.col (center) -->
                                            <!-- right column -->
                                            <div class="col-sm-6">
                                                <div class="card card-primary">
                                                    <span class="bg-info text-center">Day status setting</span>
                                                    <div class="card-body-x p-1">
                                                        <div class="row forShift display_show">                                                            
                                                            <div class="col-sm-6">
                                                                <table class="table table-sm table-bordered AllShfit">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Status</th>
                                                                            <th>Remarks</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td><?php echo form_select('shift_all_day_status[]',$day_status,null,'class="shift_all_day_status form-control-sm"')?></td>
                                                                            <td>
                                                                                <?php
                                                                                    echo form_input('remarks','text',null,'class="form-control form-control-sm Remarks" ');
                                                                                ?>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /.card-body -->
                                                    <div class="card-footer">
                                                        <input type="button" class="btn btn-info btn-sm float-right btn-save" data-next="step-two-tab" value="Save" />
                                                    </div>
                                                    <div class="offset-sm-6 msg"></div>
                                            <div class="text-center p-3 save-spinner" style="display: none;">
                                                <strong>Loading...</strong>
                                                <div class="spinner-border text-info" role="status"> </div>
                                            </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<style type="text/css">
    .display_show{
        display: block;
    }
    .display_none{
        display: none;
    }
</style>
<script>
    $(function () {
        let from_date, to_date;

        $('#to_date').on('change',function () {
            from_date = $('#from_date').val();
            to_date = $(this).val();
            let fd = new Date(from_date.replace( /(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3"));
            let ed = new Date(to_date.replace( /(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3"));
            let dates = '';
            while (fd <= ed) {
                let dt = $.datepicker.formatDate('DD, MM d, yy', new Date(fd));
                let date = $.datepicker.formatDate('yy-mm-dd', new Date(fd));
                let day = $.datepicker.formatDate('DD', new Date(fd));
                let bg = '';
                if (day == 'Friday') {
                    bg ='bg-warning';
                }
                dates +='<tr><td><input type="checkbox" name="dates" class="dates '+day+'" value="'+date+'"></td><td class="'+bg+'">'+dt+'</td></tr>';
                fd.setDate(fd.getDate() + 1);
                //console.log("dates:"+dates);
            }
            $('.dates-tbody').empty().append(dates);
        });
        $('.off_day').on('click',function () {
            let day_class = $(this).attr('id');
            if($(this).is(':checked')) {
                $('.dates-tbody').find('input.'+day_class).attr('checked',true);
            } else {
                $('.dates-tbody').find('input.'+day_class).removeAttr('checked');
            }
        });
        $('.btn-save').on('click',function () {  
            let WorkOffDate = [];
            $.each($(".dates:checked"),function(i) {
                WorkOffDate[i] = $(this).val();
            });
            WorkOffDate = JSON.stringify(WorkOffDate);
            var DayStatus =  $('.shift_all_day_status').val();
            var Remarks = $('.Remarks').val();
            let form = {
                'WorkOffDate' : WorkOffDate,
                'DayStatus' : DayStatus,
                'Remarks' : Remarks,
            } ;
            console.log(form);
            let url = "<?php echo route('calendar/save_calendar_for_abco'); ?>";
            $.post(url,form,function (data) {
                $('.save-spinner').hide();

                $('div.msg').empty().append(data);
            });
        });
    });
</script>

<style>
    .table-scroll {
        display:block;
        height : 250px;
        overflow-y : scroll;
    }
</style>