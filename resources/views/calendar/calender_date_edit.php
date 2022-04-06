<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content pt-2 pb-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card card-info card-outline">
                        <div class="tab-content" id="custom-content-above-tabContent">
                            <div class="tab-pane fade show active" id="step-one" role="tabpanel" aria-labelledby="step-one-tab">
                                <div class="card">
                                    <div class="card-group pt-1">
                                        <!-- card-deck -->
                                        <!-- center column -->
                                        <div class="card-body">
                                            <table class="table table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <!-- <th>Serial No</th> -->
                                                        <th class="text-center">Work Off Date</th>
                                                        <th class="text-center">Day Status Name</th>
                                                        <th class="text-center">Date Added</th>
                                                        <th class="text-center">Added By</th>
                                                        <th class="text-center">Work Date</th>
                                                        <th class="pl-5">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1;
                                                    foreach ($calender_date_info as $rows) { ?>
                                                        <tr>
                                                            <!-- <td>?php echo $rows['id']; ?></td> -->
                                                            <td class="text-center"><?php echo date('d-M-Y', strtotime($rows['WorkOffDate'])); ?></td>
                                                            <td class="text-center"><?php echo $rows['DayStatusName']; ?></td>
                                                            <td class="text-center"><?php
                                                                                    $date = $rows['DateAdded'];
                                                                                    echo date('d-M-Y', strtotime($date));
                                                                                    ?>
                                                            </td>
                                                            <td class="text-center"><?php echo $rows['name']; ?></td>
                                                            <td class="text-center"><?php echo date('d-M-Y', strtotime($rows['WorkDate'])); ?></td>
                                                            <td class=""><a href="#editModal<?php echo $rows['id']; ?>" class="btn btn-success" data-toggle="modal">Edit</a>
                                                                <a href="#deleteModal<?php echo $rows['id']; ?>" class="btn btn-danger" data-toggle="modal">Delete</a>
                                                                <!-- Model Edit -->
                                                                <div class="modal fade" id="editModal<?php echo $rows['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Are you sure to delete??</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form method="POST" action="<?php echo route('calendar/edit/' . $rows['id']); ?>">
                                                                                    <div class="form-group">
                                                                                        <label class="" for="work_off_date">WorkOffDate</label>
                                                                                        <?php
                                                                                        echo form_input('work_off_date', 'text', $rows['WorkOffDate'], 'class="form-control form-control-sm form_date" id="from_date" autocomplete="off" readonly');
                                                                                        ?>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="shift_all_day_status">DasyType Name</label><br>
                                                                                        <?php echo form_select('shift_all_day_status', $day_status, $rows['DayType'], 'class="shift_all_day_status form-control-sm"') ?>
                                                                                    </div>
                                                                            </div>
                                                                            <div class="modal-footer justify-content-between">
                                                                                <button type="submit" class="btn btn-danger ">Save</button>
                                                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Model Delete -->
                                                                <div class="modal fade" id="deleteModal<?php echo $rows['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Are you sure to delete??</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form method="GET" action="<?php echo route('calendar/delete/' . $rows['id']); ?>">
                                                                                    <button type="submit" class="btn btn-danger mr-4">Permanent Delete</button>
                                                                                    <button type="button" class="btn btn-primary ml-4" data-dismiss="modal">Cancel</button>
                                                                                </form>

                                                                            </div>
                                                                            <div class="modal-footer">

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php $i++;
                                                    } ?>
                                                </tbody>
                                            </table>
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
