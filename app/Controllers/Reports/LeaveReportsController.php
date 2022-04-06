<?php
namespace App\Controllers\Reports;

    use App\Controllers\Controller;
    use App\Models\Company;    
   // use App\Models\Leave;

    class LeaveReportsController extends Controller {
        /**
         * @var Company
         */
        private $company;
        /**
         * @var Leave
         */
        private $leave;

        public function __construct()
        {
            parent::__construct();
            $this->company = new Company();
            //$this->leave = new Leave();
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function transaction()
        {
            $title = "Leave Transaction";
            return view('reports/leave/transaction',compact('title'));
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function transaction_result()
        {
            $FromDate = validation($_GET['FromDate'] ?? null);
            $ToDate = validation($_GET['ToDate'] ?? null);
            $title = "Leave transaction from date $FromDate to $ToDate";
            $company_info = $this->company->table('company')->where('id',1)->fetch();
            $employee_info = $this->leave->getLeaveTransaction(date_conversion('Y-m-d',$FromDate),date_conversion('Y-m-d',$ToDate));
            //myLog("employee_info:".json_encode($employee_info));
            return view('reports/leave/transaction_result',compact('title','company_info','employee_info'),false);
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function summary()
        {
            $title = "Leave Summary";
            return view('reports/leave/summary',compact('title'));
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function summary_result()
        {
            $FromDate = validation($_GET['FromDate'] ?? null);
            $ToDate = validation($_GET['ToDate'] ?? null);
            $title = "Leave summary from date $FromDate to $ToDate";
            $FromDate = date_conversion('Y-m-d',$FromDate);
            $ToDate = date_conversion('Y-m-d',$ToDate);
            $company_info = $this->company->table('company')->where('id',1)->fetch();
            $employee_info = $this->leave->getLeaveSummary($FromDate,$ToDate);
            myLog(json_encode($employee_info));
            return view('reports/leave/summary_result',compact('title','company_info','employee_info'),false);
        }

        public function employee_leave()
        {
            $title = "Employee Leave Summary";           
            return view('reports/leave/employee_leave',compact('title'));
        }

        public function employee_leave_result()
        {

            $empcode = validation($_GET['employee_code'] ?? null);
            $FromDate = validation($_GET['FromDate'] ?? null);
            $ToDate = validation($_GET['ToDate'] ?? null);
            $title = "Leave summary from date $FromDate to $ToDate";
            $FromDate = date_conversion('Y-m-d',$FromDate);
            $ToDate = date_conversion('Y-m-d',$ToDate);
            
            $company_info = $this->company->table('company')->where('id',1)->fetch();
            $leave_info = $this->company->query("SELECT emp_leave_transaction.EmployeeID, employee_info.EmployeeCode, employee_info.EmployeeName, emp_leave_transaction.FromDate, emp_leave_transaction.ToDate, emp_leave_transaction.LeaveDays, emp_leave_transaction.LeaveReason, leave_policy_master.LeaveType FROM employee_info, emp_leave_transaction, leave_policy_master WHERE employee_info.id = emp_leave_transaction.EmployeeID AND emp_leave_transaction.LeavePolicyID = leave_policy_master.id AND employee_info.EmployeeCode = '$empcode' AND emp_leave_transaction.FromDate BETWEEN '$FromDate' AND '$ToDate'")->fetchAll();
            myLog(json_encode($leave_info));
            return view('reports/leave/employee_leave_result',compact('title','company_info','leave_info'),false);
        }

        public function department_leave()
        {
            $title = "Department Leave Summary";
            $departments = $this->company->table("settings_master")->where('type_name','department');
            $department = ['-- Select --'];
            foreach ($departments as $item) {
                $department[$item->id] = $item->name;
            }
            return view('reports/leave/department_leave',compact('title','department'));
        }

        public function department_leave_result()
        {

            $Department = validation($_GET['Department'] ?? null);
            $FromDate = validation($_GET['FromDate'] ?? null);
            $ToDate = validation($_GET['ToDate'] ?? null);
            $title = "Leave summary from date $FromDate to $ToDate";
            $FromDate = date_conversion('Y-m-d',$FromDate);
            $ToDate = date_conversion('Y-m-d',$ToDate);

            $company_info = $this->company->table('company')->where('id',1)->fetch();
            $dept_leave_info = $this->company->query("SELECT emp_leave_transaction.EmployeeID, employee_info.EmployeeCode, employee_info.EmployeeName, employee_info.DepartmentID, settings_master.name, emp_leave_transaction.FromDate, emp_leave_transaction.ToDate, emp_leave_transaction.LeaveDays, emp_leave_transaction.LeaveReason, leave_policy_master.LeaveType FROM employee_info, settings_master, emp_leave_transaction, leave_policy_master WHERE employee_info.id = emp_leave_transaction.EmployeeID AND emp_leave_transaction.LeavePolicyID = leave_policy_master.id AND employee_info.DepartmentID = settings_master.id AND settings_master.type_name = 'department' AND settings_master.id = '$Department' AND emp_leave_transaction.FromDate BETWEEN '$FromDate' AND '$ToDate'")->fetchAll();
            //dd($dept_leave_info);
            myLog(json_encode($dept_leave_info));
            return view('reports/leave/department_leave_result',compact('title','company_info','dept_leave_info'),false);
        }


}
