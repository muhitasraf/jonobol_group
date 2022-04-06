<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content pt-2 pb-0">
        <div class="container-fluid">
            <h5 class=""><?php echo $title; ?></h5>
            <div class="row">
                <!-- left column -->
                <div class="col-12">
                    <!-- card -->
                    <div class="card card-info card-outline">
<!--                        <div class="card-header p-1">-->
<!--                            <span class="card-title">Company List</span>-->
<!--                        </div>-->
                        <div class="card-body-x p-1">
                            <?php
                            
                            if (!$company)
                                echo "There is no data";
                            else {
                                ?>
                                <table class="table table-bordered-x table-hover table-responsive">
                                    <tr>
                                        <th>No.</th>
                                        <th>Logo</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Local Name</th>
                                        <th>Local Address</th>
                                        <th>Owner</th>
                                        <th>Owner Signature</th>
                                        <th>Leave Year</th>
                                        <th>Status</th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                    <?php foreach ($company as $key=>$row) { ?>
                                        
                                        <tr>
                                            <td><?php echo ++$key; ?></td>
                                            <td>
                                                <?php
                                                $path = "uploads/images/";
                                                $logo = $path."company/".$row->logo;
                                                if(!$row->logo){
                                                    $logo = $path."no-image.jpg";
                                                }
                                                ?>
                                                <img src="<?php echo asset($logo); ?>" alt="Logo" width="75">
                                            </td>
                                            <td><?php echo $row->name; ?></td>
                                            <td><?php echo $row->address; ?></td>
                                            <td><?php echo $row->local_name; ?></td>
                                            <td><?php echo $row->local_address; ?></td>
                                            <td><?php echo $row->owner; ?></td>
                                            <td>
                                                <?php
                                                $path = "uploads/images/";
                                                $sign = $path."company/".$row->owner_signature;
                                                if(!$row->owner_signature){
                                                    $sign = $path."no-image.jpg";
                                                }
                                                ?>
                                                <img src="<?php echo asset($sign); ?>" alt="Sign" width="75">
                                            </td>
                                            <td><?php echo date_conversion('d-m-Y',$row->from_date).' to '.date_conversion('d-m-Y',$row->to_date); ?></td>
                                            <td><?php echo $row->is_active == 1? 'Active':'Not active'; ?></td>
                                            <td>
                                                <a href="<?php echo route('company/edit/' . $row->id); ?>">Edit</a>
                                                <form action="<?php echo route('company/delete/'. $row->id); ?>" class="delete_btn" method="post">
                                                    <input type="submit" value="Delete" class="btn btn-xs btn-danger">
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<style>
    form.delete_btn {
        margin-top: -22px;
        margin-left: 35px;
    }
</style>