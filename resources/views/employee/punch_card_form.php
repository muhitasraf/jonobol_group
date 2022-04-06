<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content pt-2 pb-0">
        <div class="container-fluid">
            <div class="row">
                <?php //include_once ("d-employee_search.php")?>
                <div class="col-sm-8">
                    <div class="card card-info card-outline">
                        <h4 class="p-2">Employee Punch Card Entry</h4>
                        <div class="row">
                            <div class="col-sm-6 offset-sm-3 mb-2">
                                <input type="text" name="searchTerm" class="form-control-sm searchTerm" placeholder="Type your searching text." autocomplete="off" required> <br />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 ml-4">
                                <table class="table table-responsive employee_table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Employee Code</th>
                                            <th scope="col">Employee Name</th>
                                            <th scope="col">Punch Card No</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <h1 class="msg text-info font-italic ml-4"></h1>
                            <input type="button" class="btn btn-info float-right punch_card_update" value="Submit" />
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<script>
    $(function () {
        $('.searchTerm').on('keyup',function () {
            let url = "<?php echo route('employee/search_employee');?>";
            let searchTerm = $(this).val();
            if(searchTerm.length>1) {
                $.get(url,{searchTerm:searchTerm},function (data) {
                    $('.employee_table tbody').html(data);
                });
            }
        });
        /*$('.employee_table').on('DOMSubtreeModified','.punch_card',function () {
            let employee_id = $(this).attr('id');
            let employee_code = $(this).text();
            console.log(employee_id);
        });*/

        $('.punch_card_update').click(function () {
            let card_index =0;
            employee_punch_cards = [];
            $('.punch_card').each(function (i) {
                let employee_id = $(this).attr('id');
                let employee_code_txt = $(this).text();
                let employee_code = $(this).attr('data-val');
                //console.log('employee_code:'+employee_code+'-employee_code_txt:'+employee_code_txt);
                if(employee_code != employee_code_txt) {
                    employee_punch_cards[card_index++] = {
                        'employee_id': employee_id,
                        'card_no': employee_code_txt
                    };
                }
            });
            let url = "<?php echo route('employee/punch_card_update');?>";
            if (employee_punch_cards.length>0) {
                $.get(url,{employee_punch_cards:JSON.stringify(employee_punch_cards)},function (data) {
                    $('.msg').text(data);
                });
            }
        });
    });
</script>