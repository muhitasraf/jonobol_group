<?php
namespace App\Controllers\Reports;

    use App\Controllers\Controller;
    use App\Models\Company;
    use App\Models\Salary;
    use App\Traits\CompanyTrait;
    use App\Traits\SettingsMasterTrait;

    class PaymentReportsController extends Controller {
        use CompanyTrait,SettingsMasterTrait;
        /**
         * @var Company
         */
        private $company;
        /**
         * @var Leave
         */
        private $salary;

        public function __construct()
        {
            parent::__construct();
            $this->salary = new Salary();
        }
        private function month_names_with_id()
        {
            return [
                '01' => 'January',
                '02' => 'February',
                '03' => 'March',
                '04' => 'April',
                '05' => 'May',
                '06' => 'June',
                '07' => 'July',
                '08' => 'August',
                '09' => 'September',
                '10' => 'October',
                '11' => 'November',
                '12' => 'December'
            ];
        }
        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function month_wise_salary()
        {
            $title = "Salary sheet";

            $designation = $this->generateList('type_name','designation');
            $section = $this->generateList('type_name','section');
            $department = $this->generateList('type_name','department');
            $staff_category = $this->generateList('type_name','staff-category');

            $company_info = $this->company_info();
            return view('reports/payment/month_wise_salary',compact('title','company_info','designation','section','department','staff_category'));
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function month_wise_salary_result()
        {
            $inputs = $_GET;
            //myLog(json_encode($inputs));

            $title = "Salary sheet";
            $EmployeeCode = validation($inputs['EmployeeCode'] ?? null);
            $Department = validation($inputs['Department'] ?? null);
            $Designation = validation($inputs['Designation'] ?? null);
            $Section = validation($inputs['Section'] ?? null);
            $StaffCategory = validation($inputs['StaffCategory'] ?? null);
            $Month = validation($inputs['Month'] ?? date('F'));
            $Year = validation($inputs['Year'] ?? date('Y'));
            $where = '';

            $cb_code = $inputs['cbCode'] ?? null;
            $cb_name = $inputs['cbName'] ?? null;
            $cb_designation = $inputs['cbDesignation'] ?? null;
            $cb_section = $inputs['cbSection'] ?? null;
            $cb_department = $inputs['cbDepartment'] ?? null;
            $cb_doj = $inputs['cbDoj'] ?? null;
            $cb_staffcat = $inputs['cbStaffCat'] ?? null;

            $company_info = $this->company_info();
            if ($EmployeeCode) {
                $title .= "of the employee code:".$EmployeeCode;
                $where .=" ei.EmployeeCode='$EmployeeCode' AND";
            }
            if ($Department) {
                $where .=" DepartmentID=$Department AND";
            }
            if ($Designation) {
                $where .=" DesignationID=$Designation AND";
            }
            if ($Section) {
                $where .=" SectionID=$Section AND";
            }
            if ($StaffCategory >0) {
                $where .=" StaffCategoryID = $StaffCategory AND";
            }
            if ($Month && $Year) {
                //myLog("Month: ".$Month);
                $MonthNo = date("n",strtotime($Month)); //date_conversion("$Month","n");
                //myLog("MonthNo: ".$MonthNo);
                //myLog("Monthdate str: ".date("n",strtotime($Month)));
                $from_date = $Year.'-'.$MonthNo.'-01';
                $to_date = $Year.'-'.$MonthNo.'-31';
                $where .=" MonthNo='$MonthNo' AND YearNo='$Year' ";
                $title .= " of the month of $Month,$Year";
            }
            $employee_info = [];
            if ($where) {
                $employee_info = $this->salary->getSalary($where, $from_date, $to_date);
                myLog(json_encode($employee_info));
            }
            $count_section = array_count_values(array_column($employee_info, 'Section'));
            // dd( $employee_info);
            //echo '<pre>';print_r($employee_info);exit;
            return view('reports/payment/month_wise_salary_result',
                compact('title','company_info','count_section','employee_info','cb_code','cb_name','cb_designation',
                    'cb_section','cb_department','cb_doj','cb_staffcat'
                ),false
            );
        }
        public function monthly_salary_ot_reduce()
        {
            $title = "Salary sheet";

            $designation = $this->generateList('type_name','designation');
            $section = $this->generateList('type_name','section');
            $department = $this->generateList('type_name','department');
            $staff_category = $this->generateList('type_name','staff-category');

            $company_info = $this->company_info();
            return view('reports/payment/monthly_salary_ot_reduce',compact('title','company_info','designation','section','department','staff_category'));
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function monthly_salary_ot_reduce_result()
        {
            $inputs = $_GET;
            //myLog(json_encode($inputs));

            $title = "Salary sheet";
            $EmployeeCode = validation($inputs['EmployeeCode'] ?? null);
            $Department = validation($inputs['Department'] ?? null);
            $Designation = validation($inputs['Designation'] ?? null);
            $Section = validation($inputs['Section'] ?? null);
            $StaffCategory = validation($inputs['StaffCategory'] ?? null);
            $Month = validation($inputs['Month'] ?? date('F'));
            $Year = validation($inputs['Year'] ?? date('Y'));
            $where = '';

            $cb_code = $inputs['cbCode'] ?? null;
            $cb_name = $inputs['cbName'] ?? null;
            $cb_designation = $inputs['cbDesignation'] ?? null;
            $cb_section = $inputs['cbSection'] ?? null;
            $cb_department = $inputs['cbDepartment'] ?? null;
            $cb_doj = $inputs['cbDoj'] ?? null;
            $cb_staffcat = $inputs['cbStaffCat'] ?? null;

            $company_info = $this->company_info();
            if ($EmployeeCode) {
                $title .= "of the employee code:".$EmployeeCode;
                $where .=" ei.EmployeeCode='$EmployeeCode' AND";
            }
            if ($Department) {
                $where .=" DepartmentID=$Department AND";
            }
            if ($Designation) {
                $where .=" DesignationID=$Designation AND";
            }
            if ($Section) {
                $where .=" SectionID=$Section AND";
            }
            if ($StaffCategory >0) {
                $where .=" StaffCategoryID = $StaffCategory AND";
            }
            if ($Month && $Year) {
                //myLog("Month: ".$Month);
                $MonthNo = date("n",strtotime($Month)); //date_conversion("$Month","n");
                //myLog("MonthNo: ".$MonthNo);
                //myLog("Monthdate str: ".date("n",strtotime($Month)));
                $from_date = $Year.'-'.$MonthNo.'-01';
                $to_date = $Year.'-'.$MonthNo.'-31';
                $where .=" MonthNo='$MonthNo' AND YearNo='$Year' ";
                $title .= " of the month of $Month,$Year";
            }
            $employee_info = [];
            if ($where) {
                $employee_info = $this->salary->getSalary($where, $from_date, $to_date);
                //myLog(json_encode($employee_info));
            }
            $count_section = array_count_values(array_column($employee_info, 'Section'));
            //echo '<pre>';print_r($employee_info);exit;
            return view('reports/payment/monthly_salary_ot_reduce_result',
                compact('title','company_info','count_section','employee_info','cb_code','cb_name','cb_designation',
                    'cb_section','cb_department','cb_doj','cb_staffcat'
                ),false
            );
        }
        
        public function monthly_salary_without_ot()
        {
            $title = "Salary sheet without OT";

            $designation = $this->generateList('type_name','designation');
            $section = $this->generateList('type_name','section');
            $department = $this->generateList('type_name','department');
            $staff_category = $this->generateList('type_name','staff-category');

            $company_info = $this->company_info();
            return view('reports/payment/monthly_salary_without_ot',compact('title','company_info','designation','section','department','staff_category'));
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function monthly_salary_without_ot_result()
        {
            $inputs = $_GET;
            //myLog(json_encode($inputs));

            $title = "Salary sheet";
            $EmployeeCode = validation($inputs['EmployeeCode'] ?? null);
            $Department = validation($inputs['Department'] ?? null);
            $Designation = validation($inputs['Designation'] ?? null);
            $Section = validation($inputs['Section'] ?? null);
            $StaffCategory = validation($inputs['StaffCategory'] ?? null);
            $Month = validation($inputs['Month'] ?? date('F'));
            $Year = validation($inputs['Year'] ?? date('Y'));
            $where = ' ei.DepartmentID!=153 AND';

            $cb_code = $inputs['cbCode'] ?? null;
            $cb_name = $inputs['cbName'] ?? null;
            $cb_designation = $inputs['cbDesignation'] ?? null;
            $cb_section = $inputs['cbSection'] ?? null;
            $cb_department = $inputs['cbDepartment'] ?? null;
            $cb_doj = $inputs['cbDoj'] ?? null;
            $cb_staffcat = $inputs['cbStaffCat'] ?? null;

            $company_info = $this->company_info();
            if ($EmployeeCode) {
                $title .= "of the employee code:".$EmployeeCode;
                $where .=" ei.EmployeeCode='$EmployeeCode' AND";
            }
            if ($Department) {
                $where .=" DepartmentID=$Department AND";
            }
            if ($Designation) {
                $where .=" DesignationID=$Designation AND";
            }
            if ($Section) {
                $where .=" SectionID=$Section AND";
            }
            if ($StaffCategory >0) {
                $where .=" StaffCategoryID = $StaffCategory AND";
            }
            if ($Month && $Year) {
                //myLog("Month: ".$Month);
                $MonthNo = date("n",strtotime($Month)); //date_conversion("$Month","n");
                //myLog("MonthNo: ".$MonthNo);
                //myLog("Monthdate str: ".date("n",strtotime($Month)));
                $from_date = $Year.'-'.$MonthNo.'-01';
                $to_date = $Year.'-'.$MonthNo.'-31';
                $where .=" MonthNo='$MonthNo' AND YearNo='$Year' ";
                $title .= " of the month of $Month,$Year";
            }
            $employee_info = [];
            if ($where) {
                $employee_info = $this->salary->getSalary($where, $from_date, $to_date);
                //myLog(json_encode($employee_info));
            }
            $count_section = array_count_values(array_column($employee_info, 'Section'));
            //echo '<pre>';print_r($employee_info);exit;
            return view('reports/payment/monthly_salary_without_ot_result',
                compact('title','company_info','count_section','employee_info','cb_code','cb_name','cb_designation',
                    'cb_section','cb_department','cb_doj','cb_staffcat'
                ),false
            );
        }
        public function monthly_security_salary()
        {
            $title = "Security Salary sheet";
            $company_info = $this->company_info();
            return view('reports/payment/monthly_security_salary',compact('title','company_info'));
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function monthly_security_salary_result()
        {
            $inputs = $_GET;
            //myLog(json_encode($inputs));
            $title = "Security Salary sheet";
            $Month = validation($inputs['Month'] ?? date('F'));
            $Year = validation($inputs['Year'] ?? date('Y'));
            $cb_code = $inputs['cbCode'] ?? null;
            $cb_name = $inputs['cbName'] ?? null;
            $cb_designation = $inputs['cbDesignation'] ?? null;
            $cb_section = $inputs['cbSection'] ?? null;
            $cb_department = $inputs['cbDepartment'] ?? null;
            $cb_doj = $inputs['cbDoj'] ?? null;
            $cb_staffcat = $inputs['cbStaffCat'] ?? null;
            $where = ' ei.DepartmentID=153 AND';
            $company_info = $this->company_info();
            if ($Month && $Year) {
                //myLog("Month: ".$Month);
                $MonthNo = date("n",strtotime($Month)); //date_conversion("$Month","n");
                //myLog("MonthNo: ".$MonthNo);
                //myLog("Monthdate str: ".date("n",strtotime($Month)));
                $from_date = $Year.'-'.$MonthNo.'-01';
                $to_date = $Year.'-'.$MonthNo.'-31';
                $where .=" MonthNo='$MonthNo' AND YearNo='$Year' ";
                $title .= " of the month of $Month,$Year";
            }
            $employee_info = [];
            if ($where) {
                $employee_info = $this->salary->getSalary($where, $from_date, $to_date);
                //myLog(json_encode($employee_info));
            }
            $count_section = array_count_values(array_column($employee_info, 'Section'));
            //echo '<pre>';print_r($employee_info);exit;
            return view('reports/payment/monthly_security_salary_result',
                compact('title','employee_info','count_section','company_info','cb_code','cb_name','cb_designation',
                    'cb_section','cb_department','cb_doj','cb_staffcat'),false
            );
        }
        
        public function monthly_ot_payment()
        {
            $title = "Security Salary sheet";
            $staff_category = $this->generateList('type_name','staff-category');
            $company_info = $this->company_info();
            return view('reports/payment/monthly_ot_payment',compact('title','company_info','staff_category'));
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function monthly_ot_payment_result()
        {
            $inputs = $_GET;
            //myLog(json_encode($inputs));
            $title = "Security Salary sheet";
            $StaffCategory = validation($inputs['StaffCategory'] ?? null);
            $Month = validation($inputs['Month'] ?? date('F'));
            $Year = validation($inputs['Year'] ?? date('Y'));
            $cb_code = $inputs['cbCode'] ?? null;
            $cb_name = $inputs['cbName'] ?? null;
            $cb_designation = $inputs['cbDesignation'] ?? null;
            $cb_section = $inputs['cbSection'] ?? null;
            $cb_department = $inputs['cbDepartment'] ?? null;
            $cb_doj = $inputs['cbDoj'] ?? null;
            $cb_staffcat = $inputs['cbStaffCat'] ?? null;
            $company_info = $this->company_info();
            $where = '';
            if ($StaffCategory >0) {
                $where .=" StaffCategoryID = $StaffCategory AND";
            }
            if ($Month && $Year) {
                //myLog("Month: ".$Month);
                $MonthNo = date("n",strtotime($Month)); //date_conversion("$Month","n");
                //myLog("MonthNo: ".$MonthNo);
                //myLog("Monthdate str: ".date("n",strtotime($Month)));
                $from_date = $Year.'-'.$MonthNo.'-01';
                $to_date = $Year.'-'.$MonthNo.'-31';
                $where .=" MonthNo='$MonthNo' AND YearNo='$Year' ";
                $title .= " of the month of $Month,$Year";
            }
            $employee_info = [];
            if ($where) {
                $employee_info = $this->salary->getSalary($where, $from_date, $to_date);
                //myLog(json_encode($employee_info));
            }
            $count_section = array_count_values(array_column($employee_info, 'Section'));
            //echo '<pre>';print_r($employee_info);exit;
            return view('reports/payment/monthly_ot_payment_result',
                compact('title','employee_info','count_section','company_info','cb_code','cb_name','cb_designation',
                    'cb_section','cb_department','cb_doj','cb_staffcat'),false
            );
        }
        public function merge_ot_monthly_salary()
        {
            $inputs = $_GET;
            $merge_ot_hour = $this->salary->table('month_wise_salary_info')->where('id',$inputs['update_id'])->update(['MergeOT'=>$inputs['merge_ot_hour']]);
        }
        public function month_wise_deduction()
        {
            $title = "Monthlt Salary Deduction";

            $designation = $this->generateList('type_name','designation');
            $section = $this->generateList('type_name','section');
            $department = $this->generateList('type_name','department');
            $staff_category = $this->generateList('type_name','staff-category');

            $company_info = $this->company_info();
            return view('reports/payment/month_wise_deduction',compact('title','company_info','designation','section','department','staff_category'));
        }
        public function month_wise_deduction_result()
        {
            $inputs = $_GET;
            //myLog(json_encode($inputs));

            $title = "Salary Deduction";
            //$deductionType = validation($inputs['deductionType']);
            $EmployeeCode = validation($inputs['EmployeeCode'] ?? null);
            $Department = validation($inputs['Department'] ?? null);
            $Designation = validation($inputs['Designation'] ?? null);
            $Section = validation($inputs['Section'] ?? null);
            $StaffCategory = validation($inputs['StaffCategory'] ?? null);
            $Month = validation($inputs['Month'] ?? date('F'));
            $Year = validation($inputs['Year'] ?? date('Y'));
            $where = '';

            $pf = $inputs['pf'] ?? null;
            $advance = $inputs['advance'] ?? null;
            $loan = $inputs['loan'] ?? null;

            $company_info = $this->company_info();
            $month_names = $this->month_names_with_id();
            if(empty($EmployeeCode) && empty($Department) && empty($Designation) && empty($Section) && empty($StaffCategory) ){
                if(!empty($Year) && !empty($Month)){
                    $where .="d.MonthNo='$Month' AND d.YearNo='$Year' ";
                    $title .= " of $month_names[$Month],$Year";
                }elseif(!empty($Year)){
                    $where .="d.YearNo='$Year' ";
                    $title .= " of the $Year";
                }elseif(!empty($Month)){                
                    $where .="d.MonthNo='$Month' ";
                    $title .= " of $month_names[$Month]";
                }else{
                    $where .=" d.MonthNo BETWEEN 01 AND 12 ";
                }
            }else{
                if ($EmployeeCode) {
                    $title .= "of the employee code:".$EmployeeCode;
                    $where .=" ei.EmployeeCode='$EmployeeCode' AND";
                }
                if ($Department) {
                    $where .=" ei.DepartmentID=$Department AND";
                }
                if ($Designation) {
                    $where .=" ei.DesignationID=$Designation AND";
                }
                if ($Section) {
                    $where .=" ei.SectionID=$Section AND";
                }
                if ($StaffCategory >0) {
                    $where .=" ei.StaffCategoryID = $StaffCategory AND";
                }
                if(!empty($Year) && !empty($Month)){
                    $where .=" d.MonthNo='$Month' AND d.YearNo='$Year' ";
                    $title .= " of $month_names[$Month],$Year";
                }elseif(!empty($Year)){
                    $where .=" d.YearNo='$Year' ";
                    $title .= " of the $Year";
                }elseif(!empty($Month)){                
                    $where .=" d.MonthNo='$Month' ";
                    $title .= " of $month_names[$Month]";
                }else{
                    $where .=" d.MonthNo BETWEEN 01 AND 12 ";
                }
            }
            /*if ($Month && $Year) {
                $MonthNo = date("n",strtotime($Month)); 
                $from_date = $Year.'-'.$MonthNo.'-01';
                $to_date = $Year.'-'.$MonthNo.'-31';
                $where .=" MonthNo='$MonthNo' AND YearNo='$Year' ";
                $title .= " of the month of $Month,$Year";
            }*/
            //echo $where;exit;
            $deduction_info = [];
            if ($where) {
                $deduction_info = $this->salary->getDeduction($where);
                //myLog(json_encode($deduction_info));
            }
            $count_section = array_count_values(array_column($deduction_info, 'Section'));
            //echo '<pre>';print_r($deduction_info);exit;
            return view('reports/payment/month_wise_deduction_result',compact('title','company_info','month_names','count_section','deduction_info','pf','advance','loan'),false);
        }
        public function monthly_salary_summary()
        {
            $title = "Monthly Salary Summary";
            $company_info = $this->company_info();
            return view('reports/payment/monthly_salary_summary',compact('title','company_info'));
        }
        public function monthly_salary_summary_result()
        {
            $inputs = $_GET;
            //myLog(json_encode($inputs));

            $title = "Monthly Salary Summary";
            $Month = validation($inputs['Month'] ?? date('F'));
            $Year = validation($inputs['Year'] ?? date('Y'));
            $where = 'ei.EmployeeStatus=0 AND';
            $company_info = $this->company_info();
            if ($Month && $Year) {
                $MonthNo = date("n",strtotime($Month)); 
                $where .=" mwsi.MonthNo='$MonthNo' AND mwsi.YearNo='$Year' ";
                $title .= " of the month of $Month,$Year";
            }
            $salary_summary_info = [];
            if ($where) {
                $salary_summary_info = $this->salary->getSalarySummary($where);
                
            }
            // dd($salary_summary_info);
            //dd($salary_summary_info);
            return view('reports/payment/monthly_salary_summary_result',compact('title','salary_summary_info','company_info'),false);
        }
        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function pay_slip()
        {
            $title = "Pay Slip";
            $designations = $this->salary->table("settings_master")->where('type_name','designation');
            $designation = [ '' => '-- Select--'];
            foreach ($designations as $item) {
                $designation[$item->id] = $item->name;
            }

            $sections = $this->salary->table("settings_master")->where('type_name','section');
            $section = [ '' => '-- Select--'];
            foreach ($sections as $item) {
                $section[$item->id] = $item->name;
            }

            $departments = $this->salary->table("settings_master")->where('type_name','department');
            $department = [ '' => '-- Select--'];
            foreach ($departments as $item) {
                $department[$item->id] = $item->name;
            }
            return view('reports/payment/pay_slip',compact('title','designation','department','section'));
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function pay_slip_result()
        {
            $inputs = $_GET;
            $EmployeeCode = validation($inputs['EmployeeCode'] ?? null);
            $Department = validation($inputs['Department'] ?? null);
            $Designation = validation($inputs['Designation'] ?? null);
            $Section = validation($inputs['Section'] ?? null);
            $Month = validation($inputs['Month'] ?? date('F'));
            $Year = validation($inputs['Year'] ?? date('Y'));
            $where = '';

            $company_info = $this->company_info();
            if ($EmployeeCode) {
                $where .=" ei.EmployeeCode='$EmployeeCode' AND";
            }
            if ($Department) {
                $where .=" DepartmentID=$Department AND";
            }
            if ($Designation) {
                $where .=" DesignationID=$Designation AND";
            }
            if ($Section) {
                $where .=" SectionID=$Section AND";
            }
            if ($Month && $Year) {
                $MonthNo = date("n",strtotime($Month)); //date_conversion("$Month","n");
                $from_date = $Year.'-'.$MonthNo.'-01';
                $to_date = $Year.'-'.$MonthNo.'-31';
                $where .=" MonthNo='$MonthNo' AND YearNo='$Year'";
                $title = "";
            }

            $employee_info = [];
            if ($where) {
                $employee_info = $this->salary->getSalary($where, $from_date, $to_date);
            }
            return view('reports/payment/pay_slip_result',compact('title','company_info','employee_info','Month','Year'),false);
        }
}
