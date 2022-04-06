<aside class="main-sidebar elevation-4 sidebar-dark-info">
    <!-- sidebar-light-info -->
    <!-- Brand Logo -->
    <a href="<?php echo route('') ?>" class="brand-link p-1">
        <!-- brand-link p-1 navbar-dark navbar-info -->
        <img src="<?php echo asset($logo); ?>" alt="Logo" class="brand-image img-circle-x elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">HR</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo asset('uploads/images/profile/user-icon.jpg'); ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="<?php echo route('profile'); ?>" class="d-block"><?php echo session('user_name'); ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <?php if ($perm->hasPerm(['show-employee'])) : ?>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt text-info"></i>
                            <p>
                                Employee
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('employee/add'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p> Employee New</p>
                                </a>
                            </li>
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('employee/employee_photo_info'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>Employee Photos</p>
                                </a>
                            </li>
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('employee/employee_status'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>Employee Status</p>
                                </a>
                            </li>
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('employee/employee_food_loan'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>Employee Loan & Food</p>
                                </a>
                            </li>
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('employee/sync_badgenumber'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p> Synchronize BadgeNumber</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if ($perm->hasPerm(['show-transfer'])) : ?>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-random text-info"></i>
                            <p>
                                Transfer Management
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('transfer/add'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>New</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if ($perm->hasPerm(['show-shift-plan', 'show-shift-rule', 'show-shift-roaster', 'show-shift-manual'])) : ?>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-random text-info"></i>
                            <p>
                                Shift Management
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if ($perm->hasPerm(['show-shift-plan'])) : ?>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('shift_plan/add'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>Shift Plan</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($perm->hasPerm('show-shift-rule')) : ?>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('shift_rule/add'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>Shift Rule</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($perm->hasPerm('create-shift-roaster')) : ?>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('shift_roaster'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>Shift Roaster Process</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($perm->hasPerm('create-shift-manual')) : ?>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('manual_shift/create'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>Manual Shift Assigment</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if ($perm->hasPerm(['show-salary-head', 'show-salary-rule', 'show-salary', 'show-salary-process', 'show-employee-bank'])) : ?>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-book text-info"></i>
                            <p>
                                Salary Management
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if ($perm->hasPerm('show-salary-head')) : ?>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('salary_head'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>Salary Head </p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($perm->hasPerm('show-salary-rule')) : ?>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('salary_rule'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>Salary Rule </p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($perm->hasPerm('show-salary')) : ?>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('salary'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>Salary Info </p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($perm->hasPerm('create-salary-process')) : ?>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('salary_pre_process/create'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>Salary Pre Process </p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($perm->hasPerm('create-salary-process')) : ?>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('salary_process/create'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>Salary Process </p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($perm->hasPerm('create-salary-insert-deduct')) : ?>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('salary/insert_deduct'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>Salary Insertion/Deduction </p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('salary/fixed_deduct'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>Fixed Deduction</p>
                                </a>
                            </li>
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('salary/variable_deduct'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>Variable Deduction</p>
                                </a>
                            </li>
                            <?php if ($perm->hasPerm('create-employee-bank')) : ?>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('employee_bank/create'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>Employee Bank </p>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if ($perm->hasPerm(['show-leave-rule', 'show-leave-policy', 'show-leave-applications', 'show-leave-year-end'])) : ?>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-thermometer-half text-info"></i>
                            <p>
                                Leave Management
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if ($perm->hasPerm('show-leave-rule')) : ?>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('leave_rule/add'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>Leave Rule</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($perm->hasPerm('show-leave-policy')) : ?>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('leave_policy/add'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>Leave Policy</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($perm->hasPerm('show-leave-applications')) : ?>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('apply_leave/create'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>Apply Leave</p>
                                    </a>
                                </li>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('multiple_apply_leave/multiple_apply_leave'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>Multiple Apply Leave </p>
                                    </a>
                                </li>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('multiple_apply_leave/multiple_apply_leave_abco'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>Multiple Apply Leave ABCO </p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($perm->hasPerm('show-leave-applications')) : ?>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('apply_leave'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>Leave Applications</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($perm->hasPerm('show-leave-applications')) : ?>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('leave_allocation'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>Leave Allocation</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($perm->hasPerm('create-leave-year-end')) : ?>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('leave_year/end_process'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>Leave Year End Process</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($perm->hasPerm('show-leave-applications')) : ?>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('absent/create'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>Employee Absent</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($perm->hasPerm('show-leave-applications')) : ?>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('absent'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>Employee Absent View</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if ($perm->hasPerm(['show-punch-card', 'show-attendance', 'show-calendar'])) : ?>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-address-book text-info"></i>
                            <p>
                                Attendance Management
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if ($perm->hasPerm('show-punch-card')) : ?>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('employee/punch_card_entry'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>Punch Card </p>
                                    </a>
                                </li>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('punch_machine/add'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>Punch Machine Entry</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($perm->hasPerm('show-attendance')) : ?>
                                <!--li class="nav-item ml-2">
                                <a href="<?php echo route('attendance/download_device_data'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>Download Attendance Data</p>
                                </a>
                            </li-->
                            <?php endif; ?>
                            <?php if ($perm->hasPerm('show-attendance')) : ?>
                                <!--li class="nav-item ml-2">
                                <a href="<?php echo route('attendance/temporary_attendence_data'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>Temporary Attendance Data</p>
                                </a>
                            </li-->
                            <?php endif; ?>
                            <?php if ($perm->hasPerm('show-attendance')) : ?>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('attendance/synchronize_device_data'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>Synchronize Attendance Data</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($perm->hasPerm('show-attendance')) : ?>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('attendance/replace_device_data'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>Replace Attendance Data</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($perm->hasPerm('show-calendar')) : ?>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('calendar/add'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>Calendar</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($perm->hasPerm('show-attendance')) : ?>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('attendance/manual'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>Attendance Manual</p>
                                    </a>
                                </li>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('attendance/device'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>Attendance Device</p>
                                    </a>
                                </li>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('attendance/process'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>Attendance Process</p>
                                    </a>
                                </li>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('out_of_office/index'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>Out of Office</p>
                                    </a>
                                </li>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('attendance/ot_calculate_query'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>OT Calculate </p>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-address-book text-info"></i>
                            <p>
                                Calendar
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('calendar/add'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>Calendar</p>
                                </a>
                            </li>
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('calender/set'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>Calender Set</p>
                                </a>
                            </li>
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('calendar/add_for_abco'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>Calendar ABCO</p>
                                </a>
                            </li>
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('calendar/calender_date_edit'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>Calendar Date Edit</p>
                                </a>
                            </li>
                        </ul>

                    </li>
                <?php endif; ?>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-receipt text-info"></i>
                        <p>
                            Reports
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-2">
                        <?php if ($perm->hasPerm('print-employee')) : ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-user-alt text-info"></i>
                                    <p>
                                        Employee
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/employee/all_employee_list'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>All Employee List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/employee/bio_data'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Bio Data</p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/employee/bloodgroup'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>BloodGroup of Employees</p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/employee/section'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Section Wise Employees</p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/employee/datewise_new'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Employee List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/employee/total_summary'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Total employee summary</p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/employee/separated'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Separated Employee</p>
                                        </a>
                                    </li>
                                    <!--                                        <li class="nav-item ml-2">-->
                                    <!--                                            <a href="--><?php //echo route('reports/employee/promotion_letter');
                                                                                                ?>
                                    <!--" class="nav-link">-->
                                    <!--                                                <i class="fa fa-arrow-right"></i>-->
                                    <!--                                                <p>Promotion Letter</p>-->
                                    <!--                                            </a>-->
                                    <!--                                        </li>-->
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/employee/id_card'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>ID Card</p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/employee/application_form'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Application Form</p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/employee/appointment_letter'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Appointment Letter</p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/employee/age_verification'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Age Verification</p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/employee/nominee'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Nominee Form</p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/employee/resignation'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Resignation</p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/employee/staff_leave'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Staff Leave</p>
                                        </a>
                                    </li>
                                    <!--                                        <li class="nav-item ml-2">-->
                                    <!--                                            <a href="--><?php //echo route('reports/employee/appointment_letter');
                                                                                                ?>
                                    <!--" class="nav-link">-->
                                    <!--                                                <i class="fa fa-arrow-right"></i>-->
                                    <!--                                                <p>Appointment Letter</p>-->
                                    <!--                                            </a>-->
                                    <!--                                        </li>-->
                                </ul>
                            </li>
                        <?php endif; ?>
                        <?php if ($perm->hasPerm('print-attendance')) : ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-prescription text-info"></i>
                                    <p>
                                        Attendance
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/attendance/punch_miss'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Daily Punch Miss </p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/attendance/day_wise_absent'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Day wise absent employee </p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/attendance/day_wise_absent_summary'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Day wise absent summary </p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/attendance/day_wise_late'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Daily late employee </p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/attendance/day_wise_late_summary'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Day wise late (Summary) </p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/attendance/day_wise_present'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Daily present employee </p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/attendance/daily_attendance_summary'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Daily attendance (summary) </p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/attendance/monthly_attendance'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Monthly attendance </p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/attendance/manual_attendance'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Manual attendance </p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/attendance/day_wise_present_summary'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Day Wise Present (Summary) </p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/attendance/employee_ot_summary'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Employee OT (Summary) </p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/attendance/job_card'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Job Card </p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/attendance/actual_ot'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Actual OT </p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/attendance/buyer_ot'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Buyer OT </p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <?php if ($perm->hasPerm('print-leave')) : ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-leaf text-info"></i>
                                    <p>
                                        Leave
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/leave/transaction'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Leave Transaction</p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/leave/summary'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Leave Summary</p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/leave/employee_leave'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Employee Leave Summary</p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/leave/department_leave'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Department Leave Summary</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <?php if ($perm->hasPerm('print-salary')) : ?>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-leaf text-info"></i>
                                    <p>
                                        Payment
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/payment/month_wise_salary'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Month wise salary</p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/payment/monthly_salary_ot_reduce'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Monthly salary OT merge</p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/payment/monthly_salary_without_ot'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Monthly salary without OT</p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/payment/monthly_security_salary'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Monthly security salary</p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/payment/monthly_ot_payment'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Monthly OT payment</p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/payment/month_wise_deduction'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Month wise Deduction</p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/payment/monthly_salary_summary'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Monthly Salary Summary</p>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-2">
                                        <a href="<?php echo route('reports/payment/pay_slip'); ?>" class="nav-link">
                                            <i class="fa fa-arrow-right"></i>
                                            <p>Pay Slip</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-user text-info"></i>
                        <p>
                            User Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php if ($perm->hasPerm('show-user')) : ?>
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('user/index'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>Users </p>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ($perm->hasPerm('show-user')) : ?>
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('user/create'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>New User</p>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ($perm->hasPerm('show-role')) : ?>
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('role/index'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>Roles</p>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php if ($perm->hasPerm('show-company')) : ?>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-industry text-info"></i>
                            <p>
                                Company Management
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if ($perm->hasPerm('show-company')) : ?>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('company/index'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>Company List </p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($perm->hasPerm('create-company')) : ?>
                                <li class="nav-item ml-2">
                                    <a href="<?php echo route('company/create'); ?>" class="nav-link">
                                        <i class="fa fa-arrow-right"></i>
                                        <p>New company</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if ($perm->hasPerm('show-bulk-upload')) : ?>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-database text-info"></i>
                            <p>
                                Uploads
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('import/create'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>Bulk data </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                <?php endif; ?>
                <?php if ($perm->hasPerm('show-settings')) : ?>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-database text-info"></i>
                            <p>
                                Settings
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('settings/bank'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>Bank </p>
                                </a>
                            </li>
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('settings/unit'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>Unit </p>
                                </a>
                            </li>
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('settings/designation'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>Designation </p>
                                </a>
                            </li>
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('settings/department'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>Department </p>
                                </a>
                            </li>
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('settings/section'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>Section </p>
                                </a>
                            </li>
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('settings/division'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>Division </p>
                                </a>
                            </li>
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('settings/staff-category'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>Staff Category </p>
                                </a>
                            </li>
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('settings/country'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>Country </p>
                                </a>
                            </li>
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('district'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>District </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                <?php endif; ?>
                <?php if ($perm->hasPerm('show-user-module')) : ?>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-database text-info"></i>
                            <p>
                                User Module
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('employee/add'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>New Employee </p>
                                </a>
                            </li>
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('apply_leave/create'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>Apply Leave </p>
                                </a>
                            </li>
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('attendance/manual'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>Attendance Manual </p>
                                </a>
                            </li>
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('reports/leave/transaction'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>Leave Transaction</p>
                                </a>
                            </li>
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('reports/leave/summary'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>Leave Summary</p>
                                </a>
                            </li>
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('reports/attendance/monthly_attendance'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>Monthly attendance </p>
                                </a>
                            </li>
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('reports/employee/bio_data'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>Bio Data </p>
                                </a>
                            </li>
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('reports/employee/datewise_new'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>Employee List</p>
                                </a>
                            </li>
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('reports/employee/total_summary'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>Total employee summary</p>
                                </a>
                            </li>
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('reports/employee/separated'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>Separated Employee</p>
                                </a>
                            </li>
                            <li class="nav-item ml-2">
                                <a href="<?php echo route('reports/employee/id_card'); ?>" class="nav-link">
                                    <i class="fa fa-arrow-right"></i>
                                    <p>ID Card</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>