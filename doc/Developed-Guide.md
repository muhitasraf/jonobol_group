26.01.2020: Remove Extra columns from existing employee info:

    ALTER TABLE `employee_info`
    DROP `IfPic`,
    DROP `EmployeeState`,
    DROP `WorkerType`,
    DROP `AttendancePaymentName`,
    DROP `CurrencyRuleName`,
    DROP `DayWisePaymentRuleCode`,
    DROP `LFARuleID`,
    DROP `StepCode`,
    DROP `MaternityLeaveRuleID`,
    DROP `ShiftStartDate`,
    DROP `CPR`,
    DROP `SuspensionDate`,
    DROP `TransactionEffective`,
    DROP `UnitLOCAL`,
    DROP `UnitSequenceNo`,
    DROP `DepartmentLOCAL`,
    DROP `DepartmentSequenceNo`,
    DROP `GradeInfoLOCAL`,
    DROP `GradeInfoSequenceNo`,
    DROP `CountryID`,
    DROP `CountryLOCAL`,
    DROP `CountrySequenceNo`,
    DROP `CityDES`,
    DROP `CityLOCAL`,
    DROP `CitySequenceNo`,
    DROP `DesignationLOCAL`,
    DROP `DesignationSequenceNo`,
    DROP `StaffCategoryLOCAL`,
    DROP `StaffCategorySequenceNo`,
    DROP `DivisionLOCAL`,
    DROP `DivisionSequenceNo`,
    DROP `SectionInfoLOCAL`,
    DROP `SectionInfoSequenceNo`,
    DROP `SubSectionLOCAL`,
    DROP `SubSectionSequenceNo`,
    DROP `StaffTypeLOCAL`,
    DROP `StaffTypeSequenceNo`,
    DROP `CompanyLOCAL`,
    DROP `CompanySequenceNo`,
    DROP `LineInfoLOCAL`,
    DROP `LineInfoSequenceNo`,
    DROP `AttenBonusLOCAL`,
    DROP `AttenBonusSequenceNo`,
    DROP `BonusDesignationLOCAL`,
    DROP `BonusDesignationSequenceNo`,
    DROP `EmployeeNatureLOCAL`,
    DROP `EmployeeNatureSequenceNo`,
    DROP `NomineeSpousLOCAL`,
    DROP `NomineeSpousSequenceNo`,
    DROP `NomineePhoneID`,
    DROP `NomineePhoneLOCAL`,
    DROP `NomineePhoneSequenceNo`,
    DROP `NomineeOcupassionID`,
    DROP `NomineeOcupassionLOCAL`,
    DROP `NomineeOcupassionSequenceNo`,
    DROP `PieceRateEntitled`,
    DROP `AssignWorkLOCAL`,
    DROP `AssignWorkSequenceNo`,
    DROP `OffDayLOCAL`,
    DROP `OffDaySequenceNo`,
    DROP `AttenBonusID`,
    DROP `AttenBonus`,
    DROP `AttenBonusDES`,
    DROP `BonusDesignationID`,
    DROP `BonusDesignation`,
    DROP `BonusDesignationDES`,
    DROP `EmployeeNatureID`,
    DROP `StaffCategory`,
    DROP `StaffCategoryDES`,
    DROP `BEPZACodeNo`,
    //DROP `EmployeeNature`,
    DROP `EmployeeNatureDES`,
    DROP `DisplayEmployeeCode`,
    DROP `LocalName`,
    DROP `PositionID`,
    DROP `CityID`,
    DROP `StaffTypeID`,
    DROP `StaffType`,
    DROP `StaffTypeDES`,
    DROP `NomineeSpousDES`,
    DROP `NomineePhoneDES`,
    DROP `NomineeOcupassionDES`,
    DROP `NomineeSpousID`;

26.01.2020: change datetime column to date according to needs

    ALTER TABLE `employee_info_format_for_taking_existing_data` CHANGE `DOJ` `DOJ` DATE NULL DEFAULT NULL, CHANGE `DOC` `DOC` DATE NULL DEFAULT NULL, CHANGE `DOS` `DOS` DATE NULL DEFAULT NULL, CHANGE `DOB` `DOB` DATE NULL DEFAULT NULL, CHANGE `OTEntitledDate` `OTEntitledDate` DATE NULL DEFAULT NULL;

23.03.2020:

    ALTER TABLE `employee_info` ADD `ShiftStartDate` DATE NULL AFTER `ShiftRuleCode`;
    ALTER TABLE `employee_info` ADD `shift_roster_status` TINYINT NOT NULL AFTER `ShiftStartDate`;

23.03.2020:

    1. Empty data tables for new hr setup:
        TRUNCATE `address_info`;
        TRUNCATE `allocated_leave_days`;
        TRUNCATE `daily_attendance`;
        TRUNCATE `daywise_pay_hour`;
        TRUNCATE `day_wise_ot_hour`;
        TRUNCATE `device_row_data`;
        TRUNCATE `employee_info`;
        TRUNCATE `employee_leave_master`;
        TRUNCATE `employee_salary`;
        TRUNCATE `emp_leave_transaction_applied`;
        TRUNCATE `emp_leave_transaction_approved`;
        TRUNCATE `month_wise_salary_info`;
        TRUNCATE `nominee_info`;
        TRUNCATE `salary_process`;
        TRUNCATE `tmp_device_row_data`;
        TRUNCATE `workoff_calendar`;
        TRUNCATE `out_of_office`;
        TRUNCATE `transfer_history`;
        
11.06.2020:
    1. ALTER TABLE `employee_info`

         DROP `BranchName`,
         DROP `BankAccNo`,
         DROP `BankID`,
         DROP `Unit`,
         DROP `Department`,
         DROP `GradeInfo`,
         DROP `Designation`,
         DROP `Division`,
         DROP `SectionInfo`,
         DROP `SubSection`,
         DROP `Company`,
         DROP `LineInfo`,
         DROP `AssignWork`,
         DROP `OffDay`,
         DROP UnitDES,          
         DROP DepartmentDES,          
         DROP GradeInfoDES,          
         DROP CountryDES,          
         DROP DesignationDES,          
         DROP DivisionDES,          
         DROP SectionInfoDES,          
         DROP CompanyDES,          
         DROP SubSectionDES,          
         DROP LineInfoDES,          
         DROP AssignWorkDES,          
         DROP OffDayDES,          
       ALTER TABLE `employee_info` CHANGE `EmployeeName` `EmployeeName` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `Saluation` `Saluation` TINYINT NULL DEFAULT NULL, CHANGE `FName` `FName` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `MName` `MName` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `LName` `LName` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `Nick` `Nick` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `email` `email` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `Gender` `Gender` TINYINT NULL DEFAULT NULL, CHANGE `MaritalStatus` `MaritalStatus` TINYINT NULL DEFAULT NULL;

16.06.2020:

        ALTER TABLE `tmp_device_row_data` CHANGE `WorkDate` `WorkDate` DATE NOT NULL;
        DROP TABLE `bank_info2`, `bank_info3`, `countries`, `department`, `designation`, `division`, `permissions3`, `permission_role2`, `section`, `states`;
        DROP TABLE `skills`, `unit`;
17.06.2020:
    For application speedup:

        ALTER TABLE `active_employee_fordevice` ADD INDEX(`EmployeeCode`);  
        ALTER TABLE `address_info` ADD INDEX(`EmployeeCode`);
        ALTER TABLE `allocated_leave_days` ADD INDEX(`EmployeeCode`);
        ALTER TABLE `daily_attendance` ADD INDEX(`EmployeeCode`);
        ALTER TABLE `daywise_pay_hour` ADD INDEX(`EmployeeCode`);
        
        ALTER TABLE `daywise_pay_hour` CHANGE `WorkDate` `WorkDate` DATE NOT NULL;
        ALTER TABLE `day_wise_ot_hour` ADD INDEX(`EmployeeCode`);
        ALTER TABLE `day_wise_ot_hour` CHANGE `WorkDate` `WorkDate` DATE NOT NULL;
        ALTER TABLE `device_row_data` ADD INDEX(`EmployeeCode`);
        ALTER TABLE `employee_leave_master` ADD INDEX(`EmployeeCode`);
        ALTER TABLE `emp_leave_transaction_applied` ADD INDEX(`EmployeeCode`);
        ALTER TABLE `emp_leave_transaction_approved` ADD INDEX(`EmployeeCode`);
        ALTER TABLE `day_wise_ot_hour` CHANGE `WorkDate` `WorkDate` DATE NOT NULL;
        ALTER TABLE `daywise_pay_hour` CHANGE `WorkDate` `WorkDate` DATE NOT NULL;
        
    For new hr application setup:    
        TRUNCATE `address_info`;
        TRUNCATE `allocated_leave_days`;
        TRUNCATE `daily_attendance`;
        TRUNCATE `daywise_pay_hour`;
        TRUNCATE `day_wise_ot_hour`;
        TRUNCATE `device_row_data`;
        TRUNCATE `employee_bank_info`;
        TRUNCATE `employee_info`;
        TRUNCATE `employee_leave_master`;
        TRUNCATE `employee_salary`;
        TRUNCATE `emp_leave_transaction_applied`;
        TRUNCATE `emp_leave_transaction_approved`;
        TRUNCATE `month_wise_salary_info`;
        TRUNCATE `nominee_info`;
        TRUNCATE `out_of_office`;
        TRUNCATE `salary_process`;
        TRUNCATE `shift_roster`;
        TRUNCATE `tmp_device_row_data`;
        TRUNCATE `workoff_calendar`;
          
27.09.2020:   

    ALTER TABLE `employee_info` ADD `LocalName` VARCHAR(100) NULL AFTER `Nick`;
    ALTER TABLE `settings_master` ADD `local_name` VARCHAR(100) NULL AFTER `name`;
    ALTER TABLE `address_info` ADD `local_address` VARCHAR(100) NULL AFTER `Address`;
    ALTER TABLE `address_info` ADD `is_address_same` TINYINT(1) NULL AFTER `Type`; 
    UPDATE `address_info` SET `Type` = '12' WHERE `Type` = 1
    UPDATE `address_info` SET `Type` = '1' WHERE `Type` = 2
    UPDATE `address_info` SET `Type` = '2' WHERE `Type` = 12
    ALTER TABLE `address_info` CHANGE `Type` `Type` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '1=Permanent, 2=Present';         
    
22.10.2020:

    UPDATE `daily_attendance` SET PunchType=1 WHERE PunchType='In';
    UPDATE `daily_attendance` SET PunchType=0 WHERE PunchType='Out';    
    ALTER TABLE `daily_attendance` CHANGE `PunchType` `PunchType` TINYINT(1) NULL DEFAULT NULL;
    
25.10.20:

    SELECT td.EmployeeCode,ei.EmployeeName FROM `tmp_device_row_data` td LEFT JOIN employee_info ei ON td.EmployeeCode=ei.EmployeeCode

01.12.20:

    // changed to POST for uri to long error
        $router->map('POST','/attendance/get_attendance_from_device_data', 'AttendanceController@getAttendanceFromDeviceData');
        $router->map('POST','/attendance/daily_attendance', 'AttendanceController@daily_attendance');
06.12.20:

    ALTER TABLE `workoff_calendar` CHANGE `WorkOffDate` `WorkOffDate` DATE NOT NULL;
    ALTER TABLE `daywise_pay_hour` CHANGE `WorkDate` `WorkDate` DATE NOT NULL;
    ALTER TABLE `day_wise_ot_hour` CHANGE `WorkDate` `WorkDate` DATE NOT NULL;
    ALTER TABLE `emp_leave_transaction_applied` CHANGE `FromDate` `FromDate` DATE NULL DEFAULT NULL, CHANGE `ToDate` `ToDate` DATE NULL DEFAULT NULL;
    ALTER TABLE `emp_leave_transaction_approved` CHANGE `FromDate` `FromDate` DATE NULL DEFAULT NULL, CHANGE `ToDate` `ToDate` DATE NULL DEFAULT NULL;    
    ALTER TABLE `workoff_calendar` CHANGE `WorkDate` `WorkDate` DATE NULL DEFAULT NULL;            
24.12.2020:

    ALTER TABLE `device_row_data` ADD `UpdatedBy` INT NOT NULL AFTER `DateAdded`, ADD `DateUpdated` DATETIME NOT NULL AFTER `UpdatedBy`;
    ALTER TABLE `day_wise_ot_hour` ADD `id` INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`id`);
    ALTER TABLE `allocated_leave_days` CHANGE `EmployeeCode` `EmployeeCode` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `LeavePolicyID` `LeavePolicyID` INT(10) NULL DEFAULT NULL;
    ALTER TABLE `company` CHANGE `is_active` `is_active` TINYINT(1) NOT NULL;
    ALTER TABLE `daily_attendance` CHANGE `EmployeeCode` `EmployeeCode` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `AddedBy` `AddedBy` INT(10) NULL DEFAULT NULL, CHANGE `UpdatedBy` `UpdatedBy` INT(10) NULL DEFAULT NULL, CHANGE `ApprovedBy` `ApprovedBy` INT(10) NULL DEFAULT NULL;
    ALTER TABLE `daywise_pay_hour` CHANGE `EmployeeCode` `EmployeeCode` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `AddedBy` `AddedBy` INT(10) NOT NULL, CHANGE `ApprovedBy` `ApprovedBy` INT(10) NULL DEFAULT NULL, CHANGE `UpdatedBy` `UpdatedBy` INT(10) NULL DEFAULT NULL;
    ALTER TABLE `day_wise_ot_hour` CHANGE `EmployeeCode` `EmployeeCode` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `AddedBy` `AddedBy` INT(10) NULL DEFAULT NULL, CHANGE `UpdatedBy` `UpdatedBy` INT(10) NULL DEFAULT NULL;
    ALTER TABLE `device_row_data` CHANGE `EmployeeCode` `EmployeeCode` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `DeviceID` `DeviceID` INT(10) NULL DEFAULT NULL, CHANGE `AddedBy` `AddedBy` INT(10) NULL DEFAULT NULL;
    ALTER TABLE `employee_leave_master` CHANGE `EmployeeCode` `EmployeeCode` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `LeavePolicyID` `LeavePolicyID` INT(10) NOT NULL, CHANGE `AddedBy` `AddedBy` INT(10) NULL DEFAULT NULL, CHANGE `UpdatedBy` `UpdatedBy` INT(10) NULL DEFAULT NULL;
    ALTER TABLE `employee_salary` CHANGE `EmployeeCode` `EmployeeCode` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
    ALTER TABLE `emp_leave_transaction_applied` CHANGE `EmployeeCode` `EmployeeCode` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `LeavePolicyID` `LeavePolicyID` INT(10) NULL DEFAULT NULL, CHANGE `AddedBy` `AddedBy` INT(10) NULL DEFAULT NULL, CHANGE `UpdatedBy` `UpdatedBy` INT(10) NULL DEFAULT NULL;
    ALTER TABLE `emp_leave_transaction_approved` CHANGE `EmployeeCode` `EmployeeCode` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `LeavePolicyID` `LeavePolicyID` INT(10) NULL DEFAULT NULL, CHANGE `AddedBy` `AddedBy` INT(10) NULL DEFAULT NULL, CHANGE `UpdatedBy` `UpdatedBy` INT(10) NULL DEFAULT NULL;
    ALTER TABLE `leave_policy_master` CHANGE `AddedBy` `AddedBy` INT(10) NOT NULL, CHANGE `UpdatedBy` `UpdatedBy` INT(10) NULL DEFAULT NULL;
    ALTER TABLE `leave_rulenew` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, CHANGE `AddedBy` `AddedBy` INT(10) UNSIGNED NULL DEFAULT NULL, CHANGE `UpdatedBy` `UpdatedBy` INT(10) UNSIGNED NULL DEFAULT NULL;
    ALTER TABLE `leave_rule_details` CHANGE `LeaveRuleID` `LeaveRuleID` INT(10) UNSIGNED NOT NULL, CHANGE `LeavePolicyID` `LeavePolicyID` INT(10) UNSIGNED NOT NULL;
    ALTER TABLE `month_wise_salary_info` CHANGE `EmployeeCode` `EmployeeCode` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `FromDate` `FromDate` DATE NULL DEFAULT NULL, CHANGE `ToDate` `ToDate` DATE NULL DEFAULT NULL, CHANGE `ApprovedBy` `ApprovedBy` INT(10) NULL DEFAULT NULL;
    ALTER TABLE `out_of_office` CHANGE `EmployeeCode` `EmployeeCode` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `ApprovedBy` `ApprovedBy` INT(10) NULL DEFAULT NULL, CHANGE `AddedBy` `AddedBy` INT(10) NULL DEFAULT NULL, CHANGE `UpdatedBy` `UpdatedBy` INT(10) NULL DEFAULT NULL;
    ALTER TABLE `permissions` CHANGE `name` `name` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, CHANGE `display_name` `display_name` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL, CHANGE `module` `module` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
    ALTER TABLE `salary_process` CHANGE `EmployeeCode` `EmployeeCode` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `FromDate` `FromDate` DATE NOT NULL, CHANGE `ToDate` `ToDate` DATE NOT NULL, CHANGE `AddedBy` `AddedBy` INT(10) NULL DEFAULT NULL, CHANGE `ApprovedBy` `ApprovedBy` INT(10) NULL DEFAULT NULL;
    ALTER TABLE `salary_rule` CHANGE `Formula1` `Formula1` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `Formula2` `Formula2` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `AddedBy` `AddedBy` INT(10) NULL DEFAULT NULL, CHANGE `UpdatedBy` `UpdatedBy` INT(10) NULL DEFAULT NULL;
    ALTER TABLE `shift_plan_history` CHANGE `EmployeeCode` `EmployeeCode` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `ShiftID` `ShiftID` INT(10) NOT NULL;
    ALTER TABLE `shift_roster` CHANGE `EmployeeCode` `EmployeeCode` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `ShiftID` `ShiftID` INT(10) NOT NULL, CHANGE `AddedBy` `AddedBy` INT(10) NULL DEFAULT NULL, CHANGE `UpdatedBy` `UpdatedBy` INT(10) NULL DEFAULT NULL;
    ALTER TABLE `shift_rule_detail` CHANGE `ShiftRuleCode` `ShiftRuleCode` INT(10) NOT NULL, CHANGE `ShiftID` `ShiftID` INT(10) NOT NULL;
    ALTER TABLE `tmp_device_row_data` CHANGE `EmployeeCode` `EmployeeCode` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `AddedBy` `AddedBy` INT(10) NULL DEFAULT NULL;
    ALTER TABLE `workoff_calendar` CHANGE `AddedBy` `AddedBy` INT(10) NULL DEFAULT NULL, CHANGE `UpdatedBy` `UpdatedBy` INT(10) NULL DEFAULT NULL;
28.12.2020: Create Index:

    ALTER TABLE `address_info` ADD INDEX(`EmployeeID`);
    ALTER TABLE `allocated_leave_days` ADD INDEX(`EmployeeID`);
    ALTER TABLE `bank_branch_info` ADD INDEX( `BankId`);
    ALTER TABLE `daily_attendance` ADD INDEX( `EmployeeID`);
    ALTER TABLE `daywise_pay_hour` ADD INDEX( `EmployeeID`);
    ALTER TABLE `day_wise_ot_hour` ADD INDEX( `EmployeeID`);
    ALTER TABLE `device_row_data` ADD INDEX( `EmployeeID`);
    ALTER TABLE `employee_bank_info` ADD INDEX( `EmployeeID`);
    ALTER TABLE `employee_leave_master` ADD INDEX( `EmployeeID`);
    ALTER TABLE `employee_salary` ADD INDEX( `EmployeeID`);
    ALTER TABLE `emp_leave_transaction_applied` ADD INDEX( `EmployeeID`);
    ALTER TABLE `emp_leave_transaction_approved` ADD INDEX( `EmployeeID`);
    ALTER TABLE `leave_rule_details` ADD INDEX( `LeavePolicyID`);
    ALTER TABLE `month_wise_salary_info` ADD INDEX( `EmployeeID`);
    ALTER TABLE `nominee_info` ADD INDEX( `EmployeeID`);
    ALTER TABLE `out_of_office` ADD INDEX( `EmployeeID`);
    ALTER TABLE `salary_calculation_formula` ADD INDEX( `SalaryHeadID`);
    ALTER TABLE `salary_process` ADD INDEX( `EmployeeID`);
    ALTER TABLE `shift_rule_detail` ADD INDEX( `ShiftRuleCode`);
    ALTER TABLE `tmp_device_row_data` ADD INDEX(`EmployeeCode`);
    ALTER TABLE `workoff_calendar` ADD INDEX( `EmployeeID`);
    
19. 01.2021
    ALTER TABLE `workoff_calendar` CHANGE `id` `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT;

24.01.2021:

    ALTER TABLE `employee_info` ADD `medical_note` VARCHAR(255) NULL AFTER `PFAccNo`, ADD `separation_cause` VARCHAR(255) NULL AFTER `medical_note`, ADD `separation_note` VARCHAR(255) NULL AFTER `separation_cause`, ADD `separation_effective_date` DATETIME NOT NULL AFTER `separation_note`;
    ALTER TABLE `address_info` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `allocated_leave_days` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `bank_branch_info` CHANGE `id` `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `company` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `daily_attendance` CHANGE `id` `id` BIGINT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `daywise_pay_hour` CHANGE `id` `id` BIGINT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `day_wise_ot_hour` CHANGE `id` `id` BIGINT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `device_row_data` CHANGE `id` `id` BIGINT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `employee_bank_info` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `employee_info` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `employee_leave_master` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `employee_salary` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `emp_leave_transaction_applied` CHANGE `id` `id` BIGINT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `emp_leave_transaction_approved` CHANGE `id` `id` BIGINT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `family_info` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `leave_policy_master` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `leave_rule_details` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `leave_type` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `month_wise_salary_info` CHANGE `id` `id` BIGINT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `nominee_info` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `out_of_office` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `permission_role` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL;
    ALTER TABLE `punch_machine_info` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `salary_calculation_formula` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `salary_head` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `salary_head_adjust_info` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `salary_process` CHANGE `id` `id` BIGINT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `salary_rule` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `settings_master` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `shift_plan` CHANGE `id` `id` SMALLINT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `shift_plan_history` CHANGE `id` `id` SMALLINT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `shift_roster` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `shift_rule` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `shift_rule_detail` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `tmp_device_row_data` CHANGE `id` `id` BIGINT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `transfer_history` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
    ALTER TABLE `workoff_calendar` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
   
   ALTER TABLE `daily_attendance` CHANGE `id` `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;
   ALTER TABLE `daywise_pay_hour` CHANGE `id` `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;
   ALTER TABLE `day_wise_ot_hour` CHANGE `id` `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;
   ALTER TABLE `device_row_data` CHANGE `id` `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;
   ALTER TABLE `tmp_device_row_data` CHANGE `id` `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;
   ALTER TABLE `shift_roster` CHANGE `id` `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;
   ALTER TABLE `shift_plan_history` CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
   ALTER TABLE `salary_process` CHANGE `id` `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;
   ALTER TABLE `month_wise_salary_info` CHANGE `id` `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT; 

10.02.2021:

    Get rest days form shift roaster:
    SELECT COUNT(ShiftID) ShiftTaken ,ShiftID,ShiftType,EmployeeID,ShiftDate FROM `shift_roster` WHERE EmployeeID=1 GROUP BY(ShiftID) HAVING(ShiftTaken)<7

13.02.2021:

    /*Employee wise cl,sl,el,spl,pwl*/
    /*Leave Summary completed, user it for live*/
    SELECT LeaveType,aldm.LeavePolicyID,aldm.EmployeeID,allocatedDays,availedDays FROM (
    SELECT ald.LeavePolicyID,LeaveType,EmployeeID,LeaveDays allocatedDays FROM allocated_leave_days ald
    INNER JOIN leave_policy_master lpm ON lpm.id=ald.LeavePolicyID
    GROUP BY lpm.LeavePolicyID,EmployeeID
    ) aldm
    LEFT JOIN(
    SELECT LeavePolicyID,EmployeeID,SUM(LeaveDays) availedDays FROM emp_leave_transaction_approved elta
    WHERE FromDate BETWEEN '2021-01-01' AND '2021-01-31' AND ToDate BETWEEN '2021-01-01' AND '2021-01-31'
    GROUP BY LeavePolicyID,EmployeeID
    ) elta ON aldm.EmployeeID=elta.EmployeeID AND aldm.LeavePolicyID=elta.LeavePolicyID
    GROUP BY aldm.LeavePolicyID,aldm.EmployeeID
    
    ALTER TABLE `employee_info` ADD `separation_date` DATE NULL AFTER `separation_cause`;
    ALTER TABLE `employee_info` CHANGE `separation_effective_date` `separation_effective_date` DATE NULL;
    UPDATE `employee_info` SET `separation_effective_date` = NULL

14.02.2021:
    
    1. Added daystatus as null on salary process for dates as before join date and after resigned date.
    2. // Address controller resources for demonstration the working logic of routes
    /*$router->map('GET','/demo/demo-code', 'DemoController@demo');
    $router->map('GET','/demo', 'DemoController@index');
    $router->map('GET','/demo/add', 'DemoController@create');
    $router->map('GET','/demo/edit/[i:id]', 'DemoController@edit');
    $router->map('GET','/demo/show/[i:id]', 'DemoController@show');
    $router->map('PATCH|PUT|POST','/demo/update/[i:id]', 'DemoController@update');
    $router->map('POST','/demo/save', 'DemoController@store');
    $router->map('DELETE|POST','/demo/delete/[i:id]', 'DemoController@destroy');
    $router->map('GET','/demo/status/[i:id]/[a:type]', 'DemoController@status');*/

15.02.2021:
    
    1. Add extra earnings and deduction on salary preprocess after salary process
    