<?php
$router = $this->router;
//Home Route
$router->map('GET','/', 'DashboardController@index', 'home');
//Auth route
$router->map('GET','/auth/login', 'Auth\AuthController@login');
$router->map('POST','/auth/login_check', 'Auth\AuthController@loginAuth');
$router->map('GET','/auth/logout', 'Auth\AuthController@logout');

//Dashboard Route
$router->map('GET','/dashboard', 'DashboardController@index', 'Dashboard');

// Employee controller resources
$router->map('GET','/employee/add', 'Employee\EmployeeController@create');
$router->map('GET','/employee/edit/[i:id]', 'Employee\EmployeeController@edit');
$router->map('GET','/employee/sync_badgenumber', 'Employee\EmployeeController@sync_badgenumber');
//$router->map('GET','/employee/show/[i:id]', 'Employee\EmployeeController@show');
$router->map('PATCH|POST','/employee/update/[i:id]', 'Employee\EmployeeController@update');
$router->map('POST','/employee/save', 'Employee\EmployeeController@store');
$router->map('DELETE|POST','/employee/delete/[i:id]', 'Employee\EmployeeController@destroy');
$router->map('GET','/employee/status/[i:id]/[a:type]', 'Employee\EmployeeController@status');
$router->map('GET','/employee/search_employee', 'Employee\EmployeeController@searchEmployee');
$router->map('GET','/employee/dtable_search', 'Employee\EmployeeController@dTableSearchEmployee');
$router->map('GET','/employee/punch_card_entry', 'Employee\EmployeeController@punchCardEntry');
$router->map('GET','/employee/punch_card_update', 'Employee\EmployeeController@punchCardUpdate');
$router->map('GET','/employee/employee_photo_info', 'Employee\EmployeeController@employee_photo');
$router->map('POST','/employee/employee_photo_call', 'Employee\EmployeeController@employee_photo_call');
$router->map('POST','/employee/employee_photo_store', 'Employee\EmployeeController@employee_photo_store');
$router->map('GET','/employee/employee_food_loan', 'Employee\EmployeeController@employee_food_loan');
$router->map('POST','/employee/employee_loaninfo', 'Employee\EmployeeController@employee_loaninfo');
$router->map('POST','/employee/employee_loaninfo_store', 'Employee\EmployeeController@employee_loaninfo_store');
$router->map('GET','/employee/employee_status', 'Employee\EmployeeController@employee_status');
$router->map('POST','/employee/employee_statusinfo', 'Employee\EmployeeController@employee_statusinfo');
$router->map('POST','/employee/employee_status_store', 'Employee\EmployeeController@employee_status_store');

//$router->map('POST','/multiple_apply_leave/multiple_apply_leave', 'Leave\ApplyLeaveController@multiple_apply_leave');



// Settings controller resources 
$router->map('GET','/settings/[:type]', 'SettingsController@index');
$router->map('POST','/settings/[:type]/save', 'SettingsController@store');
$router->map('GET','/settings/[:type]/edit/[i:id]', 'SettingsController@edit');
$router->map('GET','/settings/[:type]/show/[i:id]', 'SettingsController@show');
$router->map('PATCH|PUT|POST','/settings/[:type]/update/[i:id]', 'SettingsController@update');
$router->map('DELETE|POST','/settings/[:type]/delete/[i:id]', 'SettingsController@destroy');
$router->map('GET','/settings/search_district', 'SettingsController@searchDistrict');
$router->map('GET','/settings/search_country', 'SettingsController@searchCountry');




// ShiftPlanController controller resources
//$router->map('GET','/shift_plan', 'Shift\ShiftPlanController@index');
$router->map('GET','/shift_plan/add', 'Shift\ShiftPlanController@create');
$router->map('GET','/shift_plan/edit/[i:id]', 'Shift\ShiftPlanController@edit');
$router->map('GET','/shift_plan/show/[i:id]', 'Shift\ShiftPlanController@show');
$router->map('PATCH|PUT|POST','/shift_plan/update/[i:id]', 'Shift\ShiftPlanController@update');
$router->map('POST','/shift_plan/save', 'Shift\ShiftPlanController@store');
$router->map('DELETE|POST','/shift_plan/delete/[i:id]', 'Shift\ShiftPlanController@destroy');
$router->map('GET','/shift_plan/get_shift_plan', 'Shift\ShiftPlanController@getShiftPlan');

// ShiftRoasterController controller resources
$router->map('GET','/shift_roaster', 'Shift\ShiftRoasterController@index');
$router->map('GET','/shift_roaster/employee_information', 'Shift\ShiftRoasterController@employee_information');
$router->map('POST','/shift_roaster/save_calendar', 'Shift\ShiftRoasterController@save_calendar');

// Rule controller resources
//$router->map('GET','/shift_rule', 'Shift\ShiftRuleController@index');
$router->map('GET','/shift_rule/add', 'Shift\ShiftRuleController@create');
$router->map('GET','/shift_rule/edit/[i:id]', 'Shift\ShiftRuleController@edit');
$router->map('GET','/shift_rule/show/[i:id]', 'Shift\ShiftRuleController@show');
$router->map('PATCH|PUT|POST','/shift_rule/update/[i:id]', 'Shift\ShiftRuleController@update');
$router->map('POST','/shift_rule/save', 'Shift\ShiftRuleController@store');
$router->map('DELETE|POST','/shift_rule/delete/[i:id]', 'Shift\ShiftRuleController@destroy');

// PunchMachine controller resources
$router->map('GET','/punch_machine', 'PunchMachineController@index');
$router->map('GET','/punch_machine/add', 'PunchMachineController@create');
$router->map('GET','/punch_machine/edit/[i:id]', 'PunchMachineController@edit');
$router->map('PATCH|PUT|POST','/punch_machine/update/[i:id]', 'PunchMachineController@update');
$router->map('POST','/punch_machine/save', 'PunchMachineController@store');

// Attendance controller resources
$router->map('GET','/attendance/temporary_attendence_data', 'Attendance\AttendanceController@temporaryAttendenceData');
$router->map('POST','/attendance/save_temporary_attendence_data', 'Attendance\AttendanceController@saveTemporaryAttendenceData');
$router->map('GET','/attendance/download_device_data', 'Attendance\AttendanceController@downloadDeviceData');
$router->map('GET','/attendance/synchronize_device_data', 'Attendance\AttendanceController@synchronizeDeviceData');
$router->map('POST','/attendance/save_sync_data', 'Attendance\AttendanceController@saveSyncData');
$router->map('POST','/attendance/device_file_upload', 'Attendance\AttendanceController@deviceFileUpload');
$router->map('POST','/attendance/save_device_data', 'Attendance\AttendanceController@saveDeviceData');
$router->map('GET','/attendance/replace_device_data', 'Attendance\AttendanceController@replaceDeviceData');
$router->map('POST','/attendance/replace_attendence_data', 'Attendance\AttendanceController@replaceAttendenceData');
$router->map('POST','/attendance/save_replace_attendence_data', 'Attendance\AttendanceController@saveReplaceAttendenceData');
$router->map('GET','/attendance/manual', 'Attendance\AttendanceController@manual');
$router->map('POST','/attendance/manual_store', 'Attendance\AttendanceController@manualStore');
$router->map('GET','/attendance/device', 'Attendance\AttendanceController@device');
$router->map('POST','/attendance/get_attendance_from_device_data', 'Attendance\AttendanceController@getAttendanceFromDeviceData');
// changed to POST for uri to long error

$router->map('GET','/attendance/save_attendance_from_device_data', 'Attendance\AttendanceController@saveAttendanceFromDeviceData');
$router->map('POST','/attendance/save_attendance_data', 'Attendance\AttendanceController@saveAttendanceData');
$router->map('GET','/attendance/get_employee', 'Attendance\AttendanceController@getEmployee');
$router->map('POST','/attendance/verify', 'Attendance\AttendanceController@verify');
$router->map('POST','/attendance/attendance_data_for_manual', 'Attendance\AttendanceController@attendanceDataForManual');
$router->map('GET','/attendance/process', 'Attendance\AttendanceController@process');
$router->map('POST','/attendance/daily_attendance', 'Attendance\AttendanceController@daily_attendance');
$router->map('POST','/attendance/save_attendance_process_data', 'Attendance\AttendanceController@save_attendance_process_data');

$router->map('GET','/attendance/ot_calculate_query', 'Attendance\AttendanceController@ot_calculate_query');

//Apply leave controller resources
$router->map('GET','/apply_leave/create', 'Leave\ApplyLeaveController@create');
$router->map('POST','/apply_leave/save', 'Leave\ApplyLeaveController@store');
$router->map('GET','/multiple_apply_leave/multiple_apply_leave', 'Leave\ApplyLeaveController@multiple_apply_leave');
$router->map('POST','/multiple_apply_leave/multiple_apply_leave', 'Leave\ApplyLeaveController@multiple_apply_leave');
$router->map('GET','/multiple_apply_leave/multiple_apply_leave_abco', 'Leave\ApplyLeaveController@multiple_apply_leave_abco');
$router->map('POST','/multiple_apply_leave/multiple_apply_leave_abco', 'Leave\ApplyLeaveController@multiple_apply_leave_abco');
$router->map('GET','/multiple_apply_leave/get_employee_info', 'Leave\ApplyLeaveController@get_employee_info');
$router->map('POST','/multiple_apply_leave/multiple_leave_store', 'Leave\ApplyLeaveController@multiple_leave_store');
$router->map('POST','/multiple_apply_leave/multiple_leave_store_abco', 'Leave\ApplyLeaveController@multiple_leave_store_abco');
$router->map('GET','/apply_leave/edit/[i:id]', 'Leave\ApplyLeaveController@edit');
$router->map('GET','/apply_leave', 'Leave\ApplyLeaveController@index');
$router->map('PATCH|PUT|POST','/apply_leave/update/[i:id]', 'Leave\ApplyLeaveController@update');
$router->map('GET','/apply_leave/dtable_search', 'Leave\ApplyLeaveController@dTableSearchEmployeeLeave');
$router->map('GET','/dtable_search_employee_leave_applications', 'Leave\ApplyLeaveController@dTableSearchEmployeeLeaveApplications');
$router->map('GET','/apply_leave/applications/show/[i:id]', 'Leave\ApplyLeaveController@show');


$router->map('GET','/absent/create', 'Leave\ApplyLeaveController@absentCreate');
$router->map('POST','/absent/save', 'Leave\ApplyLeaveController@absentStore');
$router->map('GET','/absent', 'Leave\ApplyLeaveController@absent');
$router->map('GET','/absent/edit/[i:id]', 'Leave\ApplyLeaveController@absentEdit');
$router->map('PATCH|PUT|POST','/absent/update/[i:id]', 'Leave\ApplyLeaveController@absentUpdate');
$router->map('GET','/absent/show/[i:id]', 'Leave\ApplyLeaveController@absentShow');

//Employee transfer controller resources
$router->map('GET','/transfer/add', 'TransferController@create');
$router->map('POST','/transfer/save', 'TransferController@store');
$router->map('GET','/transfer/edit/[i:id]', 'TransferController@edit');

// Leave Rule controller resources
$router->map('GET','/leave_rule', 'Leave\LeaveRuleController@index');
$router->map('GET','/leave_rule/add', 'Leave\LeaveRuleController@create');
$router->map('GET','/leave_rule/edit/[i:id]', 'Leave\LeaveRuleController@edit');
$router->map('GET','/leave_rule/show/[i:id]', 'Leave\LeaveRuleController@show');
$router->map('PATCH|PUT|POST','/leave_rule/update/[i:id]', 'Leave\LeaveRuleController@update');
$router->map('POST','/leave_rule/save', 'Leave\LeaveRuleController@store');
$router->map('GET','/leave_rule/get_leave_policy', 'Leave\LeaveRuleController@get_leave_policy');

// Leave Policy controller resources
$router->map('GET','/leave_policy', 'Leave\LeavePolicyController@index');
$router->map('GET','/leave_policy/add', 'Leave\LeavePolicyController@create');
$router->map('GET','/leave_policy/edit/[i:id]', 'Leave\LeavePolicyController@edit');
$router->map('GET','/leave_policy/show/[i:id]', 'Leave\LeavePolicyController@show');
$router->map('PATCH|PUT|POST','/leave_policy/update/[i:id]', 'Leave\LeavePolicyController@update');
$router->map('POST','/leave_policy/save', 'Leave\LeavePolicyController@store');

// Calendar controller resources
// $router->map('GET','/calendar/add', 'CalendarController@create');
// $router->map('POST','/calendar/employee_information', 'CalendarController@employee_information');
// $router->map('POST','/calendar/save_calendar', 'CalendarController@save_calendar');

$router->map('GET','/calendar/add', 'CalendarController@create');
$router->map('POST','/calendar/employee_information', 'CalendarController@employee_information');
$router->map('POST','/calendar/save_calendar', 'CalendarController@save_calendar');
$router->map('GET','/calendar/add_for_abco', 'CalendarController@create_for_abco');
$router->map('POST','/calendar/save_calendar_for_abco', 'CalendarController@save_calendar_for_abco');
$router->map('GET','/calender/set', 'CalendarController@calenderSet');
$router->map('POST','/calender/calender_set_save', 'CalendarController@calenderSetStore');

$router->map('GET','/calendar/calender_date_edit', 'CalendarController@calender_date_edit');
$router->map('POST','/calendar/edit/[i:id]', 'CalendarController@edit');
$router->map('GET','/calendar/delete/[i:id]', 'CalendarController@delete');
//$router->map('GET','/calendar/dates', 'CalendarController@create');

// Salary head controller resources
$router->map('GET','/salary_head', 'Salary\SalaryHeadController@index');
//$router->map('GET','/salary_head/edit/[i:id]', 'Salary\SalaryHeadController@edit');
//$router->map('PATCH|PUT|POST','/salary_head/update/[i:id]', 'Salary\SalaryHeadController@update');
$router->map('POST','/salary_head/save', 'Salary\SalaryHeadController@store');
//$router->map('DELETE|POST','/salary_head/delete/[i:id]', 'Salary\SalaryHeadController@destroy');

// Salary controller resources
$router->map('GET','/salary', 'Salary\SalaryController@index');
$router->map('GET','/salary/edit/[i:id]', 'Salary\SalaryController@edit');
//$router->map('PATCH|PUT|POST','/salary/update/[i:id]', 'Salary\SalaryController@update');
$router->map('POST','/salary/save', 'Salary\SalaryController@store');
//$router->map('DELETE|POST','/salary_rule/delete/[i:id]', 'Salary\SalaryController@destroy');
$router->map('GET','/salary/insert_deduct', 'Salary\SalaryController@insert_deduct');
$router->map('POST','/salary/insert_deduct/save', 'Salary\SalaryController@insertDeductStore');
$router->map('GET','/salary/insert_deduct/edit', 'Salary\SalaryController@insertDeductEdit');
$router->map('POST','/salary/insert_deduct/update', 'Salary\SalaryController@insertDeductUpdate');

$router->map('GET','/salary/insert_deduct/get_employee', 'Salary\SalaryController@getEmployee');
$router->map('GET','/salary/get_employee_info', 'Salary\SalaryController@get_employee_info');
$router->map('GET','/salary/search', 'Salary\SalaryController@search');

// Salary rule controller resources
$router->map('GET','/salary_rule', 'Salary\SalaryRuleController@index');
$router->map('POST','/salary_rule/save', 'Salary\SalaryRuleController@store');
$router->map('GET','/salary_rule/edit/[i:id]', 'Salary\SalaryRuleController@edit');
$router->map('PATCH|PUT|POST','/salary_rule/update/[i:id]', 'Salary\SalaryRuleController@update');
$router->map('DELETE|POST','/salary_rule/delete/[i:id]', 'Salary\SalaryRuleController@destroy');


//Leave year controller resources
$router->map('GET','/leave_year/create', 'Leave\LeaveYearController@create');
$router->map('POST','/leave_year/save', 'Leave\LeaveYearController@store');
$router->map('GET','/leave_year/end_process', 'Leave\LeaveYearController@end_process');
$router->map('POST','/leave_year/process', 'Leave\LeaveYearController@process');

$router->map('PATCH|PUT|POST','/leave_year/update/[i:id]', 'Leave\SalaryRuleController@update');
$router->map('GET','/leave_year/dtable_search', 'Leave\SalaryRuleController@dTableSearchEmployeeLeave');
$router->map('GET','/dtable_search_employee_leave_applications', 'Leave\SalaryRuleController@dTableSearchEmployeeLeaveApplications');
$router->map('GET','/leave_year/applications/show/[i:id]', 'Leave\ApplyLeaveController@show');

// Salary process controller resources
$router->map('GET','/salary_pre_process/create', 'Salary\SalaryPreProcessController@create');
$router->map('POST','/salary_pre_process/process', 'Salary\SalaryPreProcessController@process');
$router->map('POST','/salary_pre_process/get_adjustment', 'Salary\SalaryPreProcessController@get_adjustment');
$router->map('POST','/salary_pre_process/save_adjustment', 'Salary\SalaryPreProcessController@save_adjustment');

// Salary preprocess controller resources
$router->map('GET','/salary_process/create', 'Salary\SalaryProcessController@create');
$router->map('POST','/salary/process', 'Salary\SalaryProcessController@process');

// Out off office controller resources
$router->map('GET','/out_of_office/index', 'OutOfOfficeController@index');
$router->map('GET','/out_of_office/create/[i:id]', 'OutOfOfficeController@create');
$router->map('GET','/out_of_office/get_employee_data', 'OutOfOfficeController@get_employee_data');
$router->map('POST','/out_of_office/save', 'OutOfOfficeController@save');

// user controller resources
$router->map('GET','/user/index', 'Auth\UserController@index');
$router->map('GET','/user/create', 'Auth\UserController@create');
$router->map('POST','/user/save', 'Auth\UserController@store');
$router->map('GET','/user/edit/[i:id]', 'Auth\UserController@edit');
$router->map('PATCH|PUT|POST','/user/update/[i:id]', 'Auth\UserController@update');
$router->map('DELETE|POST','/user/delete/[i:id]', 'Auth\UserController@destroy');

// profile controller resources
$router->map('GET','/profile', 'Auth\ProfileController@edit');
$router->map('PATCH|PUT|POST','/profile/update/[i:id]', 'Auth\ProfileController@update');

// role resources
$router->map('GET','/role/index', 'Auth\RoleController@index');
$router->map('POST','/role/save', 'Auth\RoleController@store');
$router->map('GET','/role/edit/[i:id]', 'Auth\RoleController@edit');
$router->map('PATCH|PUT|POST','/role/update/[i:id]', 'Auth\RoleController@update');
$router->map('DELETE|POST','/role/delete/[i:id]', 'Auth\RoleController@destroy');

// permission resources
//$router->map('GET','/permission/index', 'Auth\RoleController@index');
//$router->map('POST','/role/save', 'Auth\RoleController@store');
$router->map('GET','/permission/edit/[i:id]', 'Auth\PermissionController@edit');
$router->map('PATCH|PUT|POST','/permission/update/[i:id]', 'Auth\PermissionController@update');

// company controller resources
$router->map('GET','/company/index', 'CompanyController@index');
$router->map('GET','/company/create', 'CompanyController@create');
$router->map('POST','/company/save', 'CompanyController@store');
$router->map('GET','/company/edit/[i:id]', 'CompanyController@edit');
$router->map('PATCH|PUT|POST','/company/update/[i:id]', 'CompanyController@update');
$router->map('DELETE|POST','/company/delete/[i:id]', 'CompanyController@destroy');

// employee reports controller resources
$router->map('GET','/reports/employee/all_employee_list', 'Reports\EmployeeReportsController@employee_list');
$router->map('GET','/reports/employee/employee_list_result', 'Reports\EmployeeReportsController@employee_list_result');
$router->map('GET','/reports/employee/bio_data', 'Reports\EmployeeReportsController@bio_data');
$router->map('GET','/reports/employee/get_bio_data', 'Reports\EmployeeReportsController@get_bio_data');
$router->map('GET','/reports/employee/datewise_new', 'Reports\EmployeeReportsController@datewise_new');
$router->map('GET','/reports/employee/datewise_new_result', 'Reports\EmployeeReportsController@datewise_new_result');
$router->map('GET','/reports/employee/total_summary', 'Reports\EmployeeReportsController@total_summary');
$router->map('GET','/reports/employee/total_summary_result', 'Reports\EmployeeReportsController@total_summary_result');
$router->map('GET','/reports/employee/separated', 'Reports\EmployeeReportsController@separated');
$router->map('GET','/reports/employee/separated_result', 'Reports\EmployeeReportsController@separated_result');
$router->map('GET','/reports/employee/id_card', 'Reports\EmployeeReportsController@id_card');
$router->map('GET','/reports/employee/id_card_result', 'Reports\EmployeeReportsController@id_card_result');
$router->map('GET','/reports/employee/application_form', 'Reports\EmployeeReportsController@application_form');
$router->map('POST','/reports/employee/application_form', 'Reports\EmployeeReportsController@application_form');    
$router->map('GET','/reports/employee/appointment_letter', 'Reports\EmployeeReportsController@appointment_letter');
$router->map('GET','/reports/employee/age_verification', 'Reports\EmployeeReportsController@age_verification');
$router->map('GET','/reports/employee/nominee', 'Reports\EmployeeReportsController@nominee');
$router->map('GET','/reports/employee/bloodgroup', 'Reports\EmployeeReportsController@bloodgroup');
$router->map('GET','/reports/employee/bloodgroup_result', 'Reports\EmployeeReportsController@bloodgroup_result');
$router->map('GET','/reports/employee/section', 'Reports\EmployeeReportsController@section');
$router->map('GET','/reports/employee/section_result', 'Reports\EmployeeReportsController@section_result');
//$router->map('GET','/reports/employee/resignation', 'Reports\EmployeeReportsController@resignation');
//$router->map('POST','/reports/employee/resignation', 'Reports\EmployeeReportsController@resignation');
$router->map('GET','/reports/employee/resignation', 'Reports\EmployeeReportsController@resignation');
$router->map('POST','/reports/employee/resignation', 'Reports\EmployeeReportsController@resignation');
$router->map('GET','/reports/employee/staff_leave', 'Reports\EmployeeReportsController@staff_leave');
$router->map('POST','/reports/employee/staff_leave', 'Reports\EmployeeReportsController@staff_leave');








$router->map('GET','/reports/attendance/employee_ot_summary', 'Reports\AttendanceReportsController@employee_ot_summary');
$router->map('GET','/reports/attendance/employee_ot_summary_result', 'Reports\AttendanceReportsController@employee_ot_summary_result'); //Reports
$router->map('GET','/reports/attendance/punch_miss', 'Reports\AttendanceReportsController@punch_miss');
$router->map('GET','/reports/attendance/punch_miss_result', 'Reports\AttendanceReportsController@punch_miss_result');
$router->map('GET','/reports/attendance/day_wise_absent', 'Reports\AttendanceReportsController@day_wise_absent');
$router->map('GET','/reports/attendance/day_wise_absent_result', 'Reports\AttendanceReportsController@day_wise_absent_result');
$router->map('GET','/reports/attendance/day_wise_absent_summary', 'Reports\AttendanceReportsController@day_wise_absent_summary');
$router->map('GET','/reports/attendance/day_wise_absent_summary_result', 'Reports\AttendanceReportsController@day_wise_absent_summary_result');
$router->map('GET','/reports/attendance/day_wise_late', 'Reports\AttendanceReportsController@day_wise_late');
$router->map('GET','/reports/attendance/day_wise_late_result', 'Reports\AttendanceReportsController@day_wise_late_result');
$router->map('GET','/reports/attendance/day_wise_late_summary', 'Reports\AttendanceReportsController@day_wise_late_summary');
$router->map('GET','/reports/attendance/day_wise_late_summary_result', 'Reports\AttendanceReportsController@day_wise_late_summary_result');
$router->map('GET','/reports/attendance/day_wise_present', 'Reports\AttendanceReportsController@day_wise_present');
$router->map('GET','/reports/attendance/day_wise_present_result', 'Reports\AttendanceReportsController@day_wise_present_result');
$router->map('GET','/reports/attendance/daily_attendance_summary', 'Reports\AttendanceReportsController@daily_attendance_summary');
$router->map('GET','/reports/attendance/daily_attendance_summary_result', 'Reports\AttendanceReportsController@daily_attendance_summary_result');
$router->map('GET','/reports/attendance/day_wise_present_summary', 'Reports\AttendanceReportsController@day_wise_present_summary');
$router->map('GET','/reports/attendance/day_wise_present_summary_result', 'Reports\AttendanceReportsController@day_wise_present_summary_result');

$router->map('GET','/reports/attendance/job_card', 'Reports\AttendanceReportsController@job_card');
$router->map('GET','/reports/attendance/job_card_result', 'Reports\AttendanceReportsController@job_card_result'); //Reports
$router->map('GET','/reports/attendance/actual_ot', 'Reports\AttendanceReportsController@actual_ot');
$router->map('GET','/reports/attendance/actual_ot_result', 'Reports\AttendanceReportsController@actual_ot_result'); //Reports

$router->map('GET','/reports/attendance/buyer_ot', 'Reports\AttendanceReportsController@buyer_ot');
$router->map('GET','/reports/attendance/buyer_ot_result', 'Reports\AttendanceReportsController@buyer_ot_result'); //Reports

$router->map('GET','/reports/attendance/monthly_attendance', 'Reports\AttendanceReportsController@monthly_attendance');
$router->map('GET','/reports/attendance/monthly_attendance_result', 'Reports\AttendanceReportsController@monthly_attendance_result');

$router->map('GET','/reports/attendance/manual_attendance', 'Reports\AttendanceReportsController@manual_attendance');
$router->map('GET','/reports/attendance/manual_attendance_result', 'Reports\AttendanceReportsController@manual_attendance_result');

$router->map('GET','/reports/leave/transaction', 'Reports\LeaveReportsController@transaction');
$router->map('GET','/reports/leave/transaction_result', 'Reports\LeaveReportsController@transaction_result');
$router->map('GET','/reports/leave/summary', 'Reports\LeaveReportsController@summary');
$router->map('GET','/reports/leave/summary_result', 'Reports\LeaveReportsController@summary_result');
$router->map('GET','/reports/leave/employee_leave', 'Reports\LeaveReportsController@employee_leave');
$router->map('GET','/reports/employee_leave_result', 'Reports\LeaveReportsController@employee_leave_result');
$router->map('GET','/reports/leave/department_leave', 'Reports\LeaveReportsController@department_leave');
$router->map('GET','/reports/leave/department_leave_result', 'Reports\LeaveReportsController@department_leave_result');


$router->map('GET','/reports/payment/month_wise_salary', 'Reports\PaymentReportsController@month_wise_salary');
$router->map('GET','/reports/payment/month_wise_salary_result', 'Reports\PaymentReportsController@month_wise_salary_result');
$router->map('GET','/reports/payment/monthly_salary_ot_reduce', 'Reports\PaymentReportsController@monthly_salary_ot_reduce');
$router->map('GET','/reports/payment/monthly_salary_ot_reduce_result', 'Reports\PaymentReportsController@monthly_salary_ot_reduce_result');
$router->map('GET','/reports/payment/monthly_salary_without_ot', 'Reports\PaymentReportsController@monthly_salary_without_ot');
$router->map('GET','/reports/payment/monthly_salary_without_ot_result', 'Reports\PaymentReportsController@monthly_salary_without_ot_result');
$router->map('GET','/reports/payment/monthly_security_salary', 'Reports\PaymentReportsController@monthly_security_salary');
$router->map('GET','/reports/payment/monthly_security_salary_result', 'Reports\PaymentReportsController@monthly_security_salary_result');
$router->map('GET','/reports/payment/monthly_ot_payment', 'Reports\PaymentReportsController@monthly_ot_payment');
$router->map('GET','/reports/payment/monthly_ot_payment_result', 'Reports\PaymentReportsController@monthly_ot_payment_result');
$router->map('GET','/reports/payment/merge_ot_monthly_salary', 'Reports\PaymentReportsController@merge_ot_monthly_salary');
$router->map('GET','/reports/payment/pay_slip', 'Reports\PaymentReportsController@pay_slip');
$router->map('GET','/reports/payment/pay_slip_result', 'Reports\PaymentReportsController@pay_slip_result');
$router->map('GET','/reports/payment/month_wise_deduction', 'Reports\PaymentReportsController@month_wise_deduction');
$router->map('GET','/reports/payment/month_wise_deduction_result', 'Reports\PaymentReportsController@month_wise_deduction_result');
$router->map('GET','/reports/payment/monthly_salary_summary', 'Reports\PaymentReportsController@monthly_salary_summary');
$router->map('GET','/reports/payment/monthly_salary_summary_result', 'Reports\PaymentReportsController@monthly_salary_summary_result');

// Import controller resources
$router->map('GET','/import/create', 'Import\ImportController@create');
$router->map('POST','/import/file_upload', 'Import\ImportController@fileUpload');

// Manual shift controller resources
$router->map('GET','/manual_shift/create', 'Shift\ManualShiftController@create');
$router->map('POST','/manual_shift/save', 'Shift\ManualShiftController@store');

// Leave allocation controller resources
$router->map('GET','/leave_allocation', 'Leave\LeaveAllocationController@index');
$router->map('GET','/leave_allocation/show/[i:id]', 'Leave\LeaveAllocationController@show');

// user bank controller resources
$router->map('GET','/employee_bank/create', 'Employee\EmployeeBankController@create');
$router->map('GET','/employee_bank/edit/[i:id]', 'Employee\EmployeeBankController@edit');
$router->map('POST','/employee_bank/save', 'Employee\EmployeeBankController@store');
$router->map('GET','/employee_bank/bank_branches', 'Employee\EmployeeBankController@bank_branches');

// district controller resources
$router->map('GET','/district', 'DistrictController@index');
$router->map('POST','/district/save', 'DistrictController@store');
$router->map('GET','/district/edit/[i:id]', 'DistrictController@edit');
$router->map('GET','/district/show/[i:id]', 'DistrictController@show');
$router->map('PATCH|PUT|POST','/district/update/[i:id]', 'DistrictController@update');
$router->map('DELETE|POST','/district/[:type]/delete/[i:id]', 'DistrictController@destroy');

//export as excel
$router->map('GET','/reports/employee/export_as_excel', 'Reports\EmployeeReportsController@exportAsExcel');



//salary
$router->map('GET','/salary/fixed_deduct', 'Salary\SalaryController@fixed_deduct');
$router->map('post','/salary/fixed_deduct/data', 'Salary\SalaryController@fixed_deduct_data');
$router->map('POST','/salary/fixed_deduct/save', 'Salary\SalaryController@fixedDeductStore');
$router->map('GET','/salary/variable_deduct', 'Salary\SalaryController@variable_deduct');
$router->map('POST','/salary/variable_deduct/save', 'Salary\SalaryController@variableDeductStore');
$router->map('GET','/salary/get_deduct_data', 'Salary\SalaryController@get_deduct_data');
