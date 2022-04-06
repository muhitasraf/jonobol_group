<?php
namespace App\Controllers\Reports;

    use App\Controllers\Controller;
    use App\Models\Company;
    use App\Models\Employee;
    use App\Models\Leave;
    use App\library\SimpleXLSXGen;
    use App\library\NumberConverter;

    class EmployeeReportsController extends Controller
    {
        public $employee;
        public function __construct()
        {
            parent::__construct();
            $this->employee = new Employee();
            $this->company = new Company();
            $this->leave = new Leave();
            $this->numcon = new NumberConverter();
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function employee_list()
        {
            $title = "All Employee list";
            
            $designations = $this->employee->table("settings_master")->where('type_name','designation');
            $designation = ['-- Select --'];
            foreach ($designations as $item) {
                $designation[$item->id] = $item->name;
            }

            $sections = $this->employee->table("settings_master")->where('type_name','section');
            $section = ['-- Select --'];
            foreach ($sections as $item) {
                $section[$item->id] = $item->name;
            }

            $departments = $this->employee->table("settings_master")->where('type_name','department');
            $department = ['-- Select --'];
            foreach ($departments as $item) {
                $department[$item->id] = $item->name;
            }

            $staff_categories = $this->employee->table("settings_master")->where('type_name','staff-category');
            $staff_category = ['-- Select --'];
            foreach ($staff_categories as $item) {
                $staff_category[$item->id] = $item->name;
            }
            return view('reports/employee/employee_list',compact('title','designation','department','section','staff_category'));
        }

        public function employee_list_result()
        {
            $title = "Employee Joining Status";
            $Department = validation($_GET['Department'] ?? null);
            $Designation = validation($_GET['Designation'] ?? null);
            $Section = validation($_GET['Section'] ?? null);
            $StaffCategory = validation($_GET['StaffCategory'] ?? null);
            $FromDate = date_conversion('Y-m-d',validation($_GET['FromDate'] ?? null));
            $ToDate = date_conversion('Y-m-d',validation($_GET['ToDate'] ?? null));
            $SearchBy = $_GET['SearchBy'] ?: 'CreatedAt';
            $EmployeeStatus = $_GET['EmployeeStatus'];
            //$SearchBy = date_conversion('Y-m-d',$SearchBy);
            //myLog(json_encode($_GET));
            $where = '';           

            $company_info = $this->company->table('company')->where('id',1)->fetch();
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
                $where .=" DATE($SearchBy) BETWEEN '$FromDate' AND '$ToDate'  AND";
                $title .= "(From : $FromDate To: $ToDate)";
            }

            $where .=" EmployeeStatus=$EmployeeStatus AND SalaryHeadID='Gross' AND";

            //myLog("where: ".$where);
            $employee_info = [];
            if ($where) {
                $employee_info = $this->employee->getEmployee($where);
            }
            //echo '<pre>';
            //print_r($employee_info);exit;
            return view('reports/employee/employee_list_result',compact('title','company_info','employee_info',
                'StaffCategory','FromDate','ToDate'),false);
        }

        
        public function bio_data()
        {
            $title = "Employee Bio Data";
            //$users = $this->user->table('users');
            return view('reports/employee/bio_data',compact('title'));
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function get_bio_data()
        {
            $EmpoyeeCode = validation($_GET['EmployeeCode'] ?? null);
            $company_info = $this->employee->table('company')->where('id',1)->fetch();
            $employee_info = $this->employee->table('employee_info')->where("EmployeeCode",$EmpoyeeCode)->fetch();
            if ($employee_info) {
                $employee_id = $employee_info->id;
                $pr_address_info = $this->employee->table("address_info")->where("EmployeeID",$employee_id)->where('Type',1)->fetch();
                if ($pr_address_info) {
                    $pr_address_info['StateId'] = $this->employee->table('districts',$pr_address_info->StateId)->name ?? '';//->fetch();
                }

                $prm_address_info = $this->employee->table("address_info")->where("EmployeeID",$employee_id)->where('Type',2)->fetch();
                if ($prm_address_info) {
                    $prm_address_info['StateId'] = $this->employee->table('districts',$prm_address_info->StateId)->name ?? '';//->fetch();
                }
                $designation = $this->employee->table("settings_master",$employee_info->DesignationID);//->fetch();
                if ($designation) {
                    $employee_info->DesignationID = $designation->name;
                }
                $section = $this->employee->table("settings_master",$employee_info->SectionID);//->fetch();
                if (isset($section->name)) {
                    $employee_info->SectionID = $section->name;
                }

                $employee_info->BloodGroup = $employee_info->BloodGroup > 0 ? config('constants.blood')['en'][$employee_info->BloodGroup] : null;
                $employee_info->MaritalStatus = $employee_info->MaritalStatus > 0 ? config('constants.maritial')[$employee_info->MaritalStatus] : null;
                //myLog("MaritalStatus: ". $employee_info->MaritalStatus);
            }
            return view('reports/employee/get_bio_data',compact('company_info','employee_info','pr_address_info','prm_address_info'),false);
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function datewise_new()
        {
            $title = "Date Wise New Employee";

            $designations = $this->employee->table("settings_master")->where('type_name','designation');
            $designation = ['-- Select --'];
            foreach ($designations as $item) {
                $designation[$item->id] = $item->name;
            }

            $sections = $this->employee->table("settings_master")->where('type_name','section');
            $section = ['-- Select --'];
            foreach ($sections as $item) {
                $section[$item->id] = $item->name;
            }

            $departments = $this->employee->table("settings_master")->where('type_name','department');
            $department = ['-- Select --'];
            foreach ($departments as $item) {
                $department[$item->id] = $item->name;
            }

            $staff_categories = $this->employee->table("settings_master")->where('type_name','staff-category');
            $staff_category = ['-- Select --'];
            foreach ($staff_categories as $item) {
                $staff_category[$item->id] = $item->name;
            }

            return view('reports/employee/datewise_new',compact('title','designation','department','section','staff_category'));
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function datewise_new_result()
        {
            $title = "Employee Joining Status";
            $Department = validation($_GET['Department'] ?? null);
            $Designation = validation($_GET['Designation'] ?? null);
            $Section = validation($_GET['Section'] ?? null);
            $StaffCategory = validation($_GET['StaffCategory'] ?? null);
            $FromDate = date_conversion('Y-m-d',validation($_GET['FromDate'] ?? null));
            $ToDate = date_conversion('Y-m-d',validation($_GET['ToDate'] ?? null));
            $SearchBy = $_GET['SearchBy'] ?: 'CreatedAt';
            $EmployeeStatus = $_GET['EmployeeStatus'];
            //$SearchBy = date_conversion('Y-m-d',$SearchBy);
            //myLog(json_encode($_GET));
            $where = '';           

            $company_info = $this->company->table('company')->where('id',1)->fetch();
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
                $where .=" DATE($SearchBy) BETWEEN '$FromDate' AND '$ToDate'  AND";
                $title .= "(From : $FromDate To: $ToDate)";
            }

            $where .=" EmployeeStatus=$EmployeeStatus AND SalaryHeadID='Gross' AND";

            //myLog("where: ".$where);
            $employee_info = [];
            if ($where) {
                $employee_info = $this->employee->getEmployee($where);
            }
            //echo '<pre>';
            //print_r($employee_info);exit;
            return view('reports/employee/datewise_new_result',compact('title','company_info','employee_info',
                'StaffCategory','FromDate','ToDate'),false);
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function total_summary()
        {
            $title = "Total Employee Summary";

            $designations = $this->employee->table("settings_master")->where('type_name','designation');
            $designation = ['-- Select --'];
            foreach ($designations as $item) {
                $designation[$item->id] = $item->name;
            }

            $sections = $this->employee->table("settings_master")->where('type_name','section');
            $section = ['-- Select --'];
            foreach ($sections as $item) {
                $section[$item->id] = $item->name;
            }

            $departments = $this->employee->table("settings_master")->where('type_name','department');
            $department = ['-- Select --'];
            foreach ($departments as $item) {
                $department[$item->id] = $item->name;
            }

            $staff_categories = $this->employee->table("settings_master")->where('type_name','staff-category');
            $staff_category = ['-- Select --'];
            foreach ($staff_categories as $item) {
                $staff_category[$item->id] = $item->name;
            }

            return view('reports/employee/total_summary',compact('title','designation','department','section','staff_category'));
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function total_summary_result()
        {
            $title = "Total Employee Summary of ";
            if ($_GET['Department']>0)
                $Department = validation($_GET['Department'] ?? null);
            if ($_GET['Designation']>0)
                $Designation = validation($_GET['Designation'] ?? null);
            if ($_GET['Section']>0)
                $Section = validation($_GET['Section'] ?? null);
            if ($_GET['StaffCategory']>0)
                $StaffCategory = validation($_GET['StaffCategory'] ?? null);

            $where = '';

            $company_info = $this->company->table('company')->where('id',1)->fetch();
            if (isset($Department)) {
                $where .=" DepartmentID=$Department AND";
                
                $department = $this->employee->table("settings_master")->where('type_name','department')->where('id',$Department)->fetch()->description;
                $title .= " Department: $department";
            }
            if (isset($Designation)) {
                $where .=" DesignationID=$Designation AND";

                $designation = $this->employee->table("settings_master")->where('type_name','designation')->where('id',$Designation)->fetch()->description;
                $title .= " Designation: $designation";
            }
            if (isset($Section)) {
                $where .=" SectionID=$Section AND";
	
				$section = $this->employee->table("settings_master")->where('type_name','section')->where('id',$Section)->fetch()->description;
                $title .= " Section: $section";
            }
            if (isset($StaffCategory)) {
                $where .=" StaffCategoryID=$StaffCategory AND";
	
				$staff_category = $this->employee->table("settings_master")->where('type_name','staff-category')->where('id',$StaffCategory)->fetch()->description;
                $title .= " Staff Category: $staff_category";
            }

            $employee_info = [];
            if ($where) {
                $employee_info = $this->employee->TotalSummary($where);
            }
            return view('reports/employee/total_summary_result',compact('title','company_info','employee_info',
                'StaffCategory'),false);
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function separated()
        {
            $title = "Separated Employee";

            $designations = $this->employee->table("settings_master")->where('type_name','designation');
            $designation = ['-- Select --'];
            foreach ($designations as $item) {
                $designation[$item->id] = $item->name;
            }

            $sections = $this->employee->table("settings_master")->where('type_name','section');
            $section = ['-- Select --'];
            foreach ($sections as $item) {
                $section[$item->id] = $item->name;
            }

            $departments = $this->employee->table("settings_master")->where('type_name','department');
            $department = ['-- Select --'];
            foreach ($departments as $item) {
                $department[$item->id] = $item->name;
            }

            $staff_categories = $this->employee->table("settings_master")->where('type_name','staff-category');
            $staff_category = ['-- Select --'];
            foreach ($staff_categories as $item) {
                $staff_category[$item->id] = $item->name;
            }

            return view('reports/employee/separated',compact('title','designation','department','section','staff_category'));
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function separated_result()
        {
            $title = "Separated Employee Status";
            $Department = validation($_GET['Department'] ?? null);
            $Designation = validation($_GET['Designation'] ?? null);
            $Section = validation($_GET['Section'] ?? null);
            $StaffCategory = validation($_GET['StaffCategory'] ?? null);
            $FromDate = date_conversion('Y-m-d',validation($_GET['FromDate'] ?? null));
            $ToDate = date_conversion('Y-m-d',validation($_GET['ToDate'] ?? null));
            $where = '';

            $company_info = $this->company->table('company')->where('id',1)->fetch();
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
            if ($FromDate && $ToDate) {
                $where .=" DOJ BETWEEN '$FromDate' AND '$ToDate' AND";
                $title .= "(From : $FromDate To: $ToDate)";
            }
            $employee_info = [];
            if ($where) {
                $where .=" EmployeeStatus=1";
                $employee_info = $this->employee->getEmployee($where);
            }
            return view('reports/employee/separated_result',compact('title','company_info','employee_info',
                'StaffCategory','FromDate','ToDate'),false);
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function id_card()
        {
            $title = "Employee ID Card";
            //$users = $this->user->table('users');
            return view('reports/employee/id_card',compact('title'));
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function id_card_result()
        {
            $EmployeeCodes = validation($_GET['EmployeeCode'] ?? null);
            $local_type = validation($_GET['LocalType'] ?? 'en');

            $EmployeeCodes = explode(',',$EmployeeCodes);
            $this->{'id_card_result_'.$local_type}($EmployeeCodes);
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function id_card_result_en($EmployeeCodes)
        {
            $company_info = $this->employee->table('company')->where('id',1)->fetch();
            $employee_infos = $this->employee->table('employee_info')->where("EmployeeCode",$EmployeeCodes)->fetchAll();
            $this_object = $this;
            return view('reports/employee/id_card_result_en',compact('company_info','employee_infos','this_object'),false);
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function id_card_result_bn($EmployeeCodes)
        {
            $company_info = $this->employee->table('company')->where('id',1)->fetch();
            $employee_infos = $this->employee->table('employee_info')->where("EmployeeCode",$EmployeeCodes)->fetchAll();
            $this_object = $this;
            return view('reports/employee/id_card_result_bn',compact('company_info','employee_infos','this_object'),false);
        }

        public function exportAsExcel() {
            $export_data = session('export_data');
            session('export_data', "");
           // myLog(json_encode(var_dump($export_data)));
            if ($export_data == "") {
                $export_data = json_encode([["There is no data."]]);
            }

            $fileName = "Export Data.xlsx";
            return SimpleXLSXGen::fromArray(json_decode($export_data))->downloadAs($fileName);
        }


        public function application_form()
        {    
            $key=0;
            $EmployeeCode='';$application_report='';
            if(isset($_POST['employee_code']))
            {
                $EmployeeCode = ($_POST['employee_code']);
                $application_report=$this->employee->query("SELECT *FROM employee_info where EmployeeCode='$EmployeeCode'")->fetchAll();
                $key=1;
               
            }            
            return view('reports/employee/application_form',['application_report'=>$application_report,'key'=>$key,'EmployeeCode'=>$EmployeeCode]);
             
           
        }       

        public function appointment_letter()
        {    
            $application_report='';       
            if(isset($_GET['employee_code']))
            {
                $EmployeeCode = ($_GET['employee_code']);
                $application_report=$this->employee->query("SELECT * FROM employee_info where EmployeeCode='$EmployeeCode'")->fetchAll();
                //dd($application_report);
            }
             return view('reports/employee/appointment_letter',['appoint'=> $application_report]);

        }

        public function age_verification()
        {    
            $application_report='';       
            if(isset($_GET['employee_code']))
            {
                $EmployeeCode = ($_GET['employee_code']);
                $application_report=$this->employee->query("SELECT * FROM employee_info where EmployeeCode='$EmployeeCode'")->fetchAll();
                //dd($application_report);
            }
             return view('reports/employee/age_verification',['appoint'=> $application_report]);

        }
        public function nominee()
        {    
            $application_report='';       
            if(isset($_GET['employee_code']))
            {
                $EmployeeCode = ($_GET['employee_code']);
                $application_report=$this->employee->query("SELECT * FROM employee_info where EmployeeCode='$EmployeeCode'")->fetchAll();
                //dd($application_report);
            }
             return view('reports/employee/nominee_form',['appoint'=> $application_report]);

        }

        public function bloodgroup()
        {
            $title = "Employee Blood Group"; 
            return view('reports/employee/employee_bloodgroup',compact('title'));
        }

        public function bloodgroup_result()
        {
            $BloodGroup = validation($_GET['BloodGroup'] ?? null);
            $title = " Showing Employees Blood Group Wise";
            $company_info = $this->company->table('company')->where('id',1)->fetch();
            $BloodGroup_info = $this->company->query("SELECT id, EmployeeCode, EmployeeName, BadgeNumber, DOJ, Mobile, Religion, BloodGroup FROM `employee_info` WHERE BloodGroup = '$BloodGroup'")->fetchAll();
            myLog(json_encode($BloodGroup_info));
            return view('reports/employee/employee_bloodgroup_result',compact('title','company_info','BloodGroup_info'),false);
        }

        public function section()
        {
            $title = "Section Wise Employee";
            $section_array = $this->employee->table("settings_master")->where('type_name','section')->fetchAll();
            $section = [''=>'- Select -'];
            foreach ($section_array as $item) {
                $section[$item->id] = $item->name;
            }
            
            return view('reports/employee/employee_section',compact('title','section'));
        }

        public function section_result()
        {
            
            $Section = validation($_GET['Section'] ?? null);
            $title = " Showing Section Wise Employees";
            $company_info = $this->company->table('company')->where('id',1)->fetch();
            $section_info = $this->company->query("SELECT employee_info.id, employee_info.EmployeeCode, employee_info.EmployeeName, employee_info.BadgeNumber, employee_info.DOJ, employee_info.Mobile, settings_master.name AS SectionName FROM employee_info, settings_master WHERE employee_info.SectionID = settings_master.id AND settings_master.type_name = 'section' AND settings_master.id = '$Section'")->fetchAll();
            //dd($section_info);
            myLog(json_encode($section_info));
            return view('reports/employee/employee_section_result',compact('title','company_info','section_info'),false);
        }


        public function resignation()
        {    
            $key=0;
            $NumberConverter = $this->numcon;
            $employee_info='';
            $company_info = $this->employee->table('company')->where('id',1)->fetch();
            $EmployeeCode='';

            if(isset($_POST['employee_code']))
            {
                $EmployeeCode = ($_POST['employee_code']);
                $key=1;
                $employee_info=$this->employee->query("SELECT employee_info.DesignationID,employee_info.name_bangla,employee_info.DOJ,settings_master.local_name as local_name FROM employee_info,settings_master WHERE employee_info.EmployeeCode='$EmployeeCode' AND settings_master.id=employee_info.DesignationID")->fetch();
            }            
            return view('reports/employee/resignation',compact('key','employee_info','NumberConverter','company_info','EmployeeCode'));
             

        }


        public function staff_leave()
        {    
            $key=0;
            $getStaffLeaveApproved='';
            $allocatedDaysApproved='';
            $availedDaysApproved='';
            $getStaffLeaveNotApproved='';
            $allocatedDaysNotApproved='';
            $availedDaysNotApproved='';
            $annual_leave='';
            $company_info = $this->employee->table('company')->where('id',1)->fetch();
            $EmployeeCode='';
            
              
            if(isset($_POST['employee_code']))
            {   
                $key=1;
                $EmployeeCode = ($_POST['employee_code']);
                //Approved=1
                $getStaffLeaveApproved=$this->leave->getStaffLeaveSummary($EmployeeCode,1);
                $allocatedDaysApproved=(explode(",",($getStaffLeaveApproved['allocatedDays'])));
                $availedDaysApproved=(explode(",",($getStaffLeaveApproved['availedDays'])));

                //Approved=0
                $getStaffLeaveNotApproved=$this->leave->getStaffLeaveSummary($EmployeeCode,0);
                $allocatedDaysNotApproved=(explode(",",($getStaffLeaveNotApproved['allocatedDays'])));
                $availedDaysNotApproved=(explode(",",($getStaffLeaveNotApproved['availedDays'])));
                
                $annual_leave=$this->employee->query("SELECT employee_info.id,sum(el_calculate.TotalDays) as TotalDays FROM employee_info,el_calculate where employee_info.EmployeeCode='$EmployeeCode' AND employee_info.id=el_calculate.EmployeeID")->fetch();

            }   

            return view('reports/employee/staff_leave',compact('key','company_info','allocatedDaysApproved','availedDaysApproved','allocatedDaysNotApproved','availedDaysNotApproved','annual_leave','getStaffLeaveApproved','EmployeeCode'));
             

        }


        
}
