<?php
    namespace App\Controllers\Reports;

    use App\Controllers\Controller;
    use App\Models\Attendance;
    use App\Models\Company;
    use App\Models\Employee;
    use App\Traits\CompanyTrait;
    use App\Traits\SettingsMasterTrait;

    class AttendanceReportsController extends Controller {

        use CompanyTrait, SettingsMasterTrait;

        /**
         * @var Attendance
         */
        private $employee;
        /**
         * @var Attendance
         */
        private $attendance;
        /**
         * @var Company
         */
        private $company;

        public function __construct()
        {
            parent::__construct();
            $this->attendance = new Attendance();
            $this->employee = new Employee();
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function id_card_result()
        {
            $EmpoyeeCode = validation($_GET['EmployeeCode'] ?? null);
            $company_info = $this->company_info();
            $employee_info = $this->employee->table('employee_info')->where("EmployeeCode",$EmpoyeeCode)->fetch();
            if ($employee_info) {
                $pr_address_info = $this->employee->table("address_info")->where("EmployeeCode",$EmpoyeeCode)->where('Type',1)->fetch();
                if ($pr_address_info) {
                    $pr_address_info['StateId'] = $this->company->table('districts',$pr_address_info->StateId)->name ?? '';//->fetch();
                }

                $prm_address_info = $this->employee->table("address_info")->where("EmployeeCode",$EmpoyeeCode)->where('Type',2)->fetch();
                if ($prm_address_info) {
                    $prm_address_info['StateId'] = $this->company->table('districts',$prm_address_info->StateId)->name ?? '';//->fetch();
                }
                //$designation = $this->employee->table("designation")->where('id',$employee_info->DesignationID)->fetch();
                $designation = $this->attendance->table("settings_master",$employee_info->DesignationID);
                if ($designation) {
                    $employee_info->DesignationID = $designation->name;
                }
                $department = $this->attendance->table("settings_master",$employee_info->DepartmentID);//->fetch();
                if ($department) {
                    $employee_info->DepartmentID = $department->name;
                }

                $employee_info->BloodGroup = config('constants.blood')[$employee_info->BloodGroup];
                $employee_info->MaritalStatus = config('constants.maritial')[$employee_info->MaritalStatus];
                //myLog("MaritalStatus: ". $employee_info->MaritalStatus);
            }
            return view('reports/employee/id_card_result',compact('company_info','employee_info','pr_address_info','prm_address_info'),false);
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function punch_miss()
        {
            $title = "Employee Punch Miss Summary";

            $designation = $this->generateList('type_name','designation');
            $section = $this->generateList('type_name','section');
            $department = $this->generateList('type_name','department');
            $staff_category = $this->generateList('type_name','staff-category');

            return view('reports/attendance/punch_miss',compact('title','designation','department','section','staff_category'));
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function punch_miss_result()
        {
            $inputs = $_GET;
            $FromDate = validation($inputs['FromDate'] ?? date('d-m-Y'));
            $ToDate = validation($inputs['ToDate'] ?? date('d-m-Y'));
            $PunchType = validation($inputs['PunchType'] ?? 'In');
            $FromDate = date_conversion('Y-m-d',$FromDate);
            $ToDate = date_conversion('Y-m-d',$ToDate);

            $title = "Employee $PunchType Punch Miss";

            //$punch_type_value = $PunchType == 'In' ? 1 : 0;
            $punch_miss = $PunchType == 'In' ? 'PunchIN' : 'PunchOUT';
            $Department = validation($inputs['Department'] ?? null);
            $Designation = validation($inputs['Designation'] ?? null);
            $Section = validation($inputs['Section'] ?? null);
            $StaffCategory = validation($inputs['StaffCategory'] ?? null);
            $where = '';
            if ($Department >0) {
                $where .=" DepartmentID=$Department AND";
            }
            if ($Designation >0) {
                $where .=" DesignationID=$Designation AND";
            }
            if ($Section >0) {
                $where .=" SectionID=$Section AND";
            }
            if ($StaffCategory >0) {
                $where .=" StaffCategoryID=$StaffCategory AND";
            }
            if (isset($FromDate) && isset($ToDate)) {
                $where .=" DATE(WorkDate) BETWEEN '$FromDate' AND '$ToDate'";
                //$where .= " AND ISNULL(PTime) AND PunchType='$punch_type_value'";
                $where .= " AND ISNULL($punch_miss)";

                $title .= " (From : $FromDate To: $ToDate)";
            }
            $employee_info = [];
            if ($where) {
                $employee_info = $this->attendance->getMissedAttendance($where);
            }
            //print_r($employee_info);exit;
            $company_info = $this->company_info();
            return view('reports/attendance/punch_miss_result',compact('title','company_info','employee_info','PunchType'),false);
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function day_wise_absent()
        {
            $title = "Day wise absent";

            $designation = $this->generateList('type_name','designation');
            $section = $this->generateList('type_name','section');
            $department = $this->generateList('type_name','department');
            $staff_category = $this->generateList('type_name','staff-category');
            return view('reports/attendance/day_wise_absent',compact('title','designation','department','section','staff_category'));
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function day_wise_absent_result()
        {
            $inputs = $_GET;
            $OnDate = date_conversion('Y-m-d',$inputs['OnDate']);
            //$PunchType = "In";

            $title = "Day wise absent employee on date $OnDate";

            //$punch_type_value = $PunchType == 'In' ? 1 : 0;
            //$punch_miss = $PunchType == 'In' ? 'PunchIN' : 'PunchOUT';
            $Department = validation($inputs['Department'] ?? null);
            $Designation = validation($inputs['Designation'] ?? null);
            $Section = validation($inputs['Section'] ?? null);
            $StaffCategory = validation($inputs['StaffCategory'] ?? null);
            $EmployeeCode = validation($inputs['EmployeeCode'] ?? null);
            $where = '';
            if ($Department >0) {
                $where .=" DepartmentID=$Department AND";
            }
            if ($Designation >0) {
                $where .=" DesignationID=$Designation AND";
            }
            if ($Section >0) {
                $where .=" SectionID=$Section AND";
            }
            if ($StaffCategory >0) {
                $where .=" StaffCategoryID=$StaffCategory AND";
            }
            if ( !empty($EmployeeCode) ) {
                $where .=" ei.EmployeeCode = '$EmployeeCode' AND";
            }
            if (isset($OnDate)) {
                $where .=" DATE(WorkDate)='$OnDate'";
                $where .= " AND ISNULL(PunchIN) AND ISNULL(PunchOUT) ";
            }
            $employee_info = [];
            if ($where) {
                $employee_info = $this->attendance->getMissedAttendance($where);
            }

            $company_info = $this->company_info();
            //$employee_info = $this->attendance->getMissedAttendance($OnDate, $OnDate,$PunchType);
            return view('reports/attendance/day_wise_absent_result',compact('title','company_info','employee_info'),false);
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function day_wise_late()
        {
            $title = "Day wise late";

            $designation = $this->generateList('type_name','designation');
            $section = $this->generateList('type_name','section');
            $department = $this->generateList('type_name','department');
            $staff_category = $this->generateList('type_name','staff-category');
            return view('reports/attendance/day_wise_late',compact('title','designation','department','section','staff_category'));
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function day_wise_late_result()
        {
            $inputs = $_GET;
            $OnDate = date_conversion('Y-m-d',validation($inputs['OnDate']));
            $PunchType = "In";

            $title = "Day wise late employee on date $OnDate";

            $punch_type_value = $PunchType == 'In' ? 1 : 0;
            $Department = validation($inputs['Department'] ?? null);
            $Designation = validation($inputs['Designation'] ?? null);
            $Section = validation($inputs['Section'] ?? null);
            $StaffCategory = validation($inputs['StaffCategory'] ?? null);
            $EmployeeCode = validation($inputs['EmployeeCode'] ?? null);
            $where = '';
            if ($Department >0) {
                $where .=" DepartmentID=$Department AND";
            }
            if ($Designation >0) {
                $where .=" DesignationID=$Designation AND";
            }
            if ($Section >0) {
                $where .=" SectionID=$Section AND";
            }
            if ($StaffCategory >0) {
                $where .=" StaffCategoryID=$StaffCategory AND";
            }
            if ( !empty($EmployeeCode) ) {
                $where .=" ei.EmployeeCode = '$EmployeeCode' AND";
            }
            if (isset($OnDate)) {
                $where .=" DATE(WorkDate)='$OnDate'";
                $where .= " AND IsLate=1";
            }
            $employee_info = [];
            if ($where) {
                $employee_info = $this->attendance->getMissedAttendance($where);
            }

            $company_info = $this->company_info();
            //$employee_info = $this->attendance->getLateAttendance($OnDate);
            return view('reports/attendance/day_wise_late_result',compact('title','company_info','employee_info'),false);
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function day_wise_present()
        {
            $title = "Day wise present";

            $designation = $this->generateList('type_name','designation');
            $section = $this->generateList('type_name','section');
            $department = $this->generateList('type_name','department');
            $staff_category = $this->generateList('type_name','staff-category');

            return view('reports/attendance/day_wise_present',compact('title','designation','department','section','staff_category'));
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function day_wise_present_result()
        {
            $inputs = $_GET;

            $OnDate = date_conversion('Y-m-d', trim($inputs['OnDate']));
            $PunchType = "In";

            $title = "Day wise present employee on date $OnDate";

            $punch_type_value = $PunchType == 'In' ? 1 : 0;
            $Department = validation($inputs['Department'] ?? null);
            $Designation = validation($inputs['Designation'] ?? null);
            $Section = validation($inputs['Section'] ?? null);
            $StaffCategory = validation($inputs['StaffCategory'] ?? null);
            $EmployeeCode = validation($inputs['EmployeeCode'] ?? null);
            $where = '';

            if ($Department >0) {
                $where .=" DepartmentID=$Department AND";
            }
            if ($Designation >0) {
                $where .=" DesignationID=$Designation AND";
            }
            if ($Section >0) {
                $where .=" SectionID=$Section AND";
            }
            if ($StaffCategory >0) {
                $where .=" StaffCategoryID = $StaffCategory AND";
            }
            if (isset($OnDate)) {
                $where .=" DATE(WorkDate)='$OnDate'";
                $where .= " AND (PunchIN !='' AND PunchOUT != '')  AND";
            }
            if ( !empty($EmployeeCode) ) {
                $where .=" ei.EmployeeCode = '$EmployeeCode' AND";
            }

            $employee_info = [];
            if (isset($where)) {
                $employee_info = $this->attendance->getPresentEmployee($where);
            }

            $company_info = $this->company_info();

            return view('reports/attendance/day_wise_present_result',compact('title','company_info','employee_info'),false);
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function daily_attendance_summary()
        {
            $title = "Daily attendance summary";

            $designation = $this->generateList('type_name','designation');
            $section = $this->generateList('type_name','section');
            $department = $this->generateList('type_name','department');
            $staff_category = $this->generateList('type_name','staff-category');

            return view('reports/attendance/daily_attendance_summary',compact('title','designation','department','section','staff_category'));
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function daily_attendance_summary_result()
        {
            $inputs = $_GET;

            $OnDate = date_conversion('Y-m-d',validation($inputs['OnDate'] ?? null));
            $title = "Daily attendance summary on date $OnDate";

            $Department = validation($inputs['Department'] ?? null);
            $Designation = validation($inputs['Designation'] ?? null);
            $Section = validation($inputs['Section'] ?? null);
            $StaffCategory = validation($inputs['StaffCategory'] ?? null);
            $where = '';

            if ($Department >0) {
                $where .=" DepartmentID=$Department AND";
            }
            if ($Designation >0) {
                $where .=" DesignationID=$Designation AND";
            }
            if ($Section >0) {
                $where .=" SectionID=$Section AND";
            }
            if ($StaffCategory >0) {
                $where .=" StaffCategoryID=$StaffCategory AND";
            }
            if (isset($OnDate)) {
                $where .=" WorkDate='$OnDate'";
            }
            $employee_info = [];
            if ($where) {
                $employee_info = $this->attendance->attendanceSummary($where);
            }

            $company_info = $this->company_info();
            return view('reports/attendance/daily_attendance_summary_result',compact('title','company_info','employee_info'),false);
        }


        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function day_wise_present_summary()
        {
            $title = "Day Wise Present (Summary)";

            $designation = $this->generateList('type_name','designation');
            $section = $this->generateList('type_name','section');
            $department = $this->generateList('type_name','department');
            $staff_category = $this->generateList('type_name','staff-category');

            return view('reports/attendance/day_wise_present_summary',compact('title','designation','department','section','staff_category'));
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function day_wise_present_summary_result()
        {
            $inputs = $_GET;

            $OnDate = date_conversion('Y-m-d', validation($inputs['OnDate'] ?? null));
            $Department = validation($inputs['Department'] ?? null);
            $Designation = validation($inputs['Designation'] ?? null);
            $Section = validation($inputs['Section'] ?? null);
            $StaffCategory = validation($inputs['StaffCategory'] ?? null);
            $where = '';
            $attendance_where = "PunchIN IS NOT NULL OR PunchOUT IS NOT NULL";
            $title = "Day Wise Present (Summary) on date:$OnDate ";

            if ($Department > 0) {
                $where .=" DepartmentID=$Department AND";

                $department = $this->employee->table("settings_master")->where('type_name','department')->where('id',$Department)->fetch()->description;
                $title .= " Department: $department,";
            }
            elseif ($Designation  > 0) {
                $where .=" DesignationID=$Designation AND";

                $designation = $this->employee->table("settings_master")->where('type_name','designation')->where('id',$Designation)->fetch()->description;
                $title .= " Designation: $designation,";
            }
            elseif ($Section > 0) {
                $where .=" SectionID=$Section AND";

                $section = $this->employee->table("settings_master")->where('type_name','section')->where('id',$Section)->fetch()->description;
                $title .= " Section: $section,";
            }
            elseif ($StaffCategory  > 0) {
                $where .=" StaffCategoryID=$StaffCategory AND";

                $staff_category = $this->employee->table("settings_master")->where('type_name','staff-category')->where('id',$StaffCategory)->fetch()->description;
                $title .= " Staff Category: $staff_category";
            }
            if (isset($OnDate)) {
                $where .=" DATE(WorkDate)='$OnDate'";
                //$where .= " AND PTime !='' AND";
            }

            $employee_info = [];
            if ($where) {
                $employee_info = $this->attendance->TotalSummary($where, $attendance_where);
            }

            $company_info = $this->company_info();

            return view('reports/attendance/day_wise_present_summary_result',compact('title','company_info','employee_info'),false);
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function day_wise_late_summary()
        {
            $title = "Day wise late summary";

            $designation = $this->generateList('type_name','designation');
            $section = $this->generateList('type_name','section');
            $department = $this->generateList('type_name','department');
            $staff_category = $this->generateList('type_name','staff-category');

            return view('reports/attendance/day_wise_late_summary',compact('title','designation','department','section','staff_category'));
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function day_wise_late_summary_result()
        {
            $inputs = $_GET;

            $OnDate = date_conversion('Y-m-d', trim($inputs['OnDate']));
            $Department = validation($inputs['Department'] ?? null);
            $Designation = validation($inputs['Designation'] ?? null);
            $Section = validation($inputs['Section'] ?? null);
            $StaffCategory = validation($inputs['StaffCategory'] ?? null);
            $where = '';
            $attendance_where = "IsLate=1";
            $title = "Day wise late (Summary)  on date:$OnDate ";

            if ($Department > 0) {
                $where .=" DepartmentID=$Department AND";

                $department = $this->employee->table("settings_master")->where('type_name','department')->where('id',$Department)->fetch()->description;
                $title .= " Department: $department,";
            }
            elseif ($Designation  > 0) {
                $where .=" DesignationID=$Designation AND";

                $designation = $this->employee->table("settings_master")->where('type_name','designation')->where('id',$Designation)->fetch()->description;
                $title .= " Designation: $designation,";
            }
            elseif ($Section > 0) {
                $where .=" SectionID=$Section AND";

                $section = $this->employee->table("settings_master")->where('type_name','section')->where('id',$Section)->fetch()->description;
                $title .= " Section: $section,";
            }
            elseif ($StaffCategory  > 0) {
                $where .=" StaffCategoryID=$StaffCategory AND";

                $staff_category = $this->employee->table("settings_master")->where('type_name','staff-category')->where('id',$StaffCategory)->fetch()->description;
                $title .= " Staff Category: $staff_category";
            }
            if (isset($OnDate)) {
                $where .=" DATE(WorkDate)='$OnDate'";
                //$where .= " AND da.IsLate=1 AND PunchType='1'";
            }

            $employee_info = [];
            if ($where) {
                $employee_info = $this->attendance->TotalSummary($where,$attendance_where);
            }

            $company_info = $this->company_info();

            return view('reports/attendance/day_wise_late_summary_result',compact('title','company_info','employee_info'),false);
        }



        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function day_wise_absent_summary()
        {
            $title = "Day wise absent summary";

            $designation = $this->generateList('type_name','designation');
            $section = $this->generateList('type_name','section');
            $department = $this->generateList('type_name','department');
            $staff_category = $this->generateList('type_name','staff-category');

            return view('reports/attendance/day_wise_absent_summary',compact('title','designation','department','section','staff_category'));
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function day_wise_absent_summary_result()
        {
            $inputs = $_GET;
            $OnDate = date_conversion('Y-m-d',$inputs['OnDate']);
            $attendance_where = "PunchIN IS NULL AND PunchOUT IS NULL";

            $title = "Day wise absent summary on date:$OnDate";

            $Department = validation($inputs['Department'] ?? null);
            $Designation = validation($inputs['Designation'] ?? null);
            $Section = validation($inputs['Section'] ?? null);
            $StaffCategory = validation($inputs['StaffCategory'] ?? null);
            $where = '';
            if ($Department >0) {
                $where .=" DepartmentID=$Department AND";

                $department = $this->employee->table("settings_master")->where('type_name','department')->where('id',$Department)->fetch()->description;
                $title .= " Department: $department,";
            }
            if ($Designation >0) {
                $where .=" DesignationID=$Designation AND";

                $designation = $this->employee->table("settings_master")->where('type_name','designation')->where('id',$Designation)->fetch()->description;
                $title .= " Designation: $designation,";
            }
            if ($Section >0) {
                $where .=" SectionID=$Section AND";

                $section = $this->employee->table("settings_master")->where('type_name','section')->where('id',$Section)->fetch()->description;
                $title .= " Section: $section,";
            }
            if ($StaffCategory >0) {
                $where .=" StaffCategoryID=$StaffCategory AND";

                $staff_category = $this->employee->table("settings_master")->where('type_name','staff-category')->where('id',$StaffCategory)->fetch()->description;
                $title .= " Staff Category: $staff_category,";
            }
            if (isset($OnDate)) {
                $where .=" DATE(WorkDate)='$OnDate'";
                //$where .= " AND ISNULL(PTime) AND";
            }
            $employee_info = [];
            if ($where) {
                $employee_info = $this->attendance->TotalSummary($where, $attendance_where);
            }
            //echo $employee_info;exit;
            $company_info = $this->company_info();
            return view('reports/attendance/day_wise_absent_summary_result',compact('title','company_info','employee_info'),false);
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function monthly_attendance()
        {
            $title = "Monthly attendance summary";
            $designation = $this->generateList('type_name','designation');
            $section = $this->generateList('type_name','section');
            $department = $this->generateList('type_name','department');
            $staff_category = $this->generateList('type_name','staff-category');
            return view('reports/attendance/monthly_attendance',compact('title','designation','department','section','staff_category'));
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function monthly_attendance_result()
        {
            $inputs = $_GET;
            $from_date = date_conversion('Y-m-d',validation($inputs['FromDate'] ?? null));
            $to_date = date_conversion('Y-m-d',validation($inputs['ToDate'] ?? null));
            $Department = validation($inputs['Department'] ?? null);
            $Designation = validation($inputs['Designation'] ?? null);
            $Section = validation($inputs['Section'] ?? null);
            $StaffCategory = validation($inputs['StaffCategory'] ?? null);
            $EmployeeCode = validation($inputs['EmployeeCode'] ?? null);
            $where_date = '';
            $where = "ei.EmployeeStatus=0 AND";

            $cb_code = $inputs['cbCode'] ?? null;
            $cb_name = $inputs['cbName'] ?? null;
            $cb_designation = $inputs['cbDesignation'] ?? null;
            $cb_section = $inputs['cbSection'] ?? null;
            $cb_department = $inputs['cbDepartment'] ?? null;
            $cb_doj = $inputs['cbDoj'] ?? null;
            $cb_staffcat = $inputs['cbStaffCat'] ?? null;
            $cb_present = $inputs['cbPresent'] ?? null;
            $cb_absent = $inputs['cbAbsent'] ?? null;
            $cb_late = $inputs['cbLate'] ?? null;
            $cb_ot = $inputs['cbOT'] ?? null;

            $title = "Monthly attendance from $from_date to $to_date";

            if ($Department >0) {
                $where .=" DepartmentID=$Department AND";
            }
            if ($Designation >0) {
                $where .=" DesignationID=$Designation AND";
            }
            if ($Section >0) {
                $where .=" SectionID=$Section AND";
            }
            if ($StaffCategory >0) {
                $where .=" StaffCategoryID = $StaffCategory AND";
            }
            if ( !empty($EmployeeCode) ) {
                $where .=" ei.EmployeeCode = '$EmployeeCode' AND";
            }
            if (isset($from_date)) {
                $where_date = "DPH.WorkDate BETWEEN '$from_date' AND '$to_date' ";
            }

            $days_in_month = date_conversion('t', $from_date);
            for ($day = 0; $day < $days_in_month; $day++) {
                $header[$day] = $day + 1;
            }
            $employee_info = $this->attendance->monthly_attendance($where, $where_date);
            //dd( $employee_info);
            $company_info = $this->company_info();
            return view('reports/attendance/monthly_attendance_result',compact('title','company_info',
                'employee_info','header','cb_code','cb_name','cb_designation','cb_section','cb_department','cb_doj','cb_staffcat','cb_present','cb_absent','cb_late','cb_ot'),false
            );
        }

        
        public function manual_attendance()
        {
            $title = "Manual attendance summary";
            $designation = $this->generateList('type_name','designation');
            $section = $this->generateList('type_name','section');
            $department = $this->generateList('type_name','department');
            $staff_category = $this->generateList('type_name','staff-category');
            return view('reports/attendance/manual_attendance',compact('title','designation','department','section','staff_category'));
        }
         public function manual_attendance_result()
        {
            $inputs = $_GET;
            $from_date = date_conversion('Y-m-d',validation($inputs['FromDate'] ?? null));
            $to_date = date_conversion('Y-m-d',validation($inputs['ToDate'] ?? null));
            $Department = validation($inputs['Department'] ?? null);
            $Section = validation($inputs['Section'] ?? null);
            $StaffCategory = validation($inputs['StaffCategory'] ?? null);
            $EmployeeCode = validation($inputs['EmployeeCode'] ?? null);
            $where_date = '';
            $where = "ei.EmployeeStatus=0 AND";

            $title = "Moanual attendance from $from_date to $to_date";

            if ($Department >0) {
                $where .=" DepartmentID=$Department AND";
            }
            if ($Section >0) {
                $where .=" SectionID=$Section AND";
            }
            if ($StaffCategory >0) {
                $where .=" StaffCategoryID = $StaffCategory AND";
            }
            if ( !empty($EmployeeCode) ) {
                $where .=" ei.EmployeeCode = '$EmployeeCode' AND";
            }
            if (isset($from_date)) {
                $where_date = "MA.WorkDate BETWEEN '$from_date' AND '$to_date' ";
            }

            $manual_attn = $this->attendance->manual_attendance($where, $where_date);
            //dd( $manual_attn);
            $company_info = $this->company_info();
            return view('reports/attendance/manual_attendance_result',compact('title','company_info',
                'manual_attn'),false
            );
        }
        public function employee_ot_summary() {
            $title = "Employee OT";

            $designation = $this->generateList('type_name','designation');
            $section = $this->generateList('type_name','section');
            $department = $this->generateList('type_name','department');
            $staff_category = $this->generateList('type_name','staff-category');

            return view('reports/attendance/employee_ot_summary',compact('title','designation','department','section','staff_category'));
        }

        public function employee_ot_summary_result() {
            $inputs = $_GET;
            //myLog(json_encode($inputs));
            $from_date = date_conversion('Y-m-d',validation($inputs['FromDate'] ?? null));
            $to_date = date_conversion('Y-m-d',validation($inputs['ToDate'] ?? null));
            $Department = validation($inputs['Department'] ?? null);
            $Designation = validation($inputs['Designation'] ?? null);
            $Section = validation($inputs['Section'] ?? null);
            $StaffCategory = validation($inputs['StaffCategory'] ?? null);
            $EmployeeCode = validation($inputs['EmployeeCode'] ?? null);
            $where_date = "";
            $where = "OT=1 AND ei.EmployeeStatus=0 AND";

            $cb_code = $inputs['cbCode'] ?? null;
            $cb_name = $inputs['cbName'] ?? null;
            $cb_designation = $inputs['cbDesignation'] ?? null;
            $cb_section = $inputs['cbSection'] ?? null;
            $cb_department = $inputs['cbDepartment'] ?? null;
            $cb_doj = $inputs['cbDoj'] ?? null;
            $cb_staffcat = $inputs['cbStaffCat'] ?? null;

            $title = "OT Report on date $from_date to $to_date";

            if ($Department >0) {
                $where .=" DepartmentID=$Department AND";
            }
            if ($Designation >0) {
                $where .=" DesignationID=$Designation AND";
            }
            if ($Section >0) {
                $where .=" SectionID=$Section AND";
            }
            if ($StaffCategory >0) {
                $where .=" StaffCategoryID = $StaffCategory AND";
            }
            if ( !empty($EmployeeCode) ) {
                $where .=" ei.EmployeeCode = '$EmployeeCode' AND";
            }
            if (isset($from_date) && isset($to_date)) {
                $where_date = "WorkDate BETWEEN '$from_date' AND '$to_date' ";
            }

            $days_in_month = date_conversion('t', $from_date);
            for ($day = 0; $day < $days_in_month; $day++) {
                $header[$day] = $day + 1;
            }
            $employee_info = $this->attendance->monthly_attendance_with_ot($where, $where_date);
            //echo (json_encode($employee_info));exit;
            $company_info = $this->company_info();

            return view('reports/attendance/employee_ot_summary_result',compact('title','company_info','employee_info','header',
                'cb_code','cb_name','cb_designation','cb_section','cb_department','cb_doj','cb_staffcat'),false
            );
        }

        public function job_card() {
            $title = "Job Card";

            return view('reports/attendance/job_card',compact('title'));
        }

        public function job_card_result() {
            $inputs = $_GET;
            $from_date = date_conversion('Y-m-d',validation($inputs['FromDate'] ?? null));
            $to_date = date_conversion('Y-m-d',validation($inputs['ToDate'] ?? null));
            $EmployeeCode = validation($inputs['EmployeeCode'] ?? null);
            $where_date = "";
            $where = "ei.EmployeeStatus=0 AND";

            $title = "Job Card";

            if ( !empty($EmployeeCode) ) {
                $where .=" ei.EmployeeCode = '$EmployeeCode' AND";
            }
            if (isset($from_date) && isset($to_date)) {
                $where_date = "WorkDate BETWEEN '$from_date' AND '$to_date' ";
            }

            $employee_info = $this->attendance->monthly_attendance_with_ot($where, $where_date);
            //myLog(json_encode($employee_info));
            $company_info = $this->company_info();

            return view('reports/attendance/job_card_result',compact('title','company_info','employee_info','to_date'),false
            );
        }

        public function buyer_ot() {
            $title = "Buyer OT";
    
            return view('reports/attendance/buyer_ot/buyer_ot',compact('title'));
        }

        public function buyer_ot_result() {
            $inputs = $_GET;
            $from_date = date_conversion('Y-m-d',validation($inputs['FromDate'] ?? null));
            $to_date = date_conversion('Y-m-d',validation($inputs['ToDate'] ?? null));
            $EmployeeCode = validation($inputs['EmployeeCode'] ?? null);
            $where_date = "";
            $where = "OT=1 AND ei.EmployeeStatus=0 AND";

            $title = "Buyer OT";

            if ( !empty($EmployeeCode) ) {
                $where .=" ei.EmployeeCode = '$EmployeeCode' AND";
            }
            if (isset($from_date) && isset($to_date)) {
                $where_date = "WorkDate BETWEEN '$from_date' AND '$to_date' ";
            } 
            $employee_info = $this->attendance->monthly_attendance_with_ot($where, $where_date);
            $company_info = $this->company_info();
            return view('reports/attendance/buyer_ot/buyer_ot_result',compact('title','company_info','employee_info','to_date'),false
            );
        }



        public function actual_ot() {
            $title = "Actual OT";

            return view('reports/attendance/actual_ot/actual_ot',compact('title'));
        }

        public function actual_ot_result() {
            $inputs = $_GET;
            $from_date = date_conversion('Y-m-d',validation($inputs['FromDate'] ?? null));
            $to_date = date_conversion('Y-m-d',validation($inputs['ToDate'] ?? null));
            $EmployeeCode = validation($inputs['EmployeeCode'] ?? null);
            $where_date = "";
            $where = "OT=1 AND ei.EmployeeStatus=0 AND";

            $title = "Actual OT";

            if ( !empty($EmployeeCode) ) {
                $where .=" ei.EmployeeCode = '$EmployeeCode' AND";
            }
            if (isset($from_date) && isset($to_date)) {
                $where_date = "WorkDate BETWEEN '$from_date' AND '$to_date' ";
            }

            $employee_info = $this->attendance->monthly_attendance_with_ot($where, $where_date);
            //myLog(json_encode($employee_info));
            $company_info = $this->company_info();

            return view('reports/attendance/actual_ot/actual_ot_result',compact('title','company_info','employee_info','to_date'),false
            );
        }
}

