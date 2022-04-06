<?php
    namespace App\Controllers\Salary;

use App\Controllers\Controller;
use App\Models\Salary;
use App\Models\Leave;
use App\Models\Company;
use Vendor\Valitron\Validator;

class SalaryController extends Controller {
    private $salary;private $leave;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->salary = new Salary();
        $this->leave = new Leave();
        $this->company = new Company();
    }

    /**
     * Display a listing of the resource.
     *
     * @return view
     */
    public function index()
    {
        $title = "Salary Info";
        return view('salary/rule/index',compact('title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param null $employee_id
     * @return View
     */
    public function edit($employee_id = null)
    {
        $heading = "Salary Info";
        $title = "Update Salary Info";
        $employee_info = $this->salary->table("employee_info",$employee_id);//->fetch();
        //if salary rule exist for this employee, go for edit
        $sql = "select max(changed) as changed From employee_salary WHERE EmployeeID =".$employee_id." ";
        $array  = array();
        $max_changed = $this->salary->get_data_single($sql,$array);
        //dd($employee_info);
        $employee_salary = $this->salary->table("employee_salary")->where('EmployeeID',$employee_id)->where('changed',$max_changed['changed'])->fetchAll();
        if (!empty($employee_salary)) {
            //dd($employee_info);
            /*$salary_rule = $this->salary->query('SELECT * FROM salary_rule WHERE SalaryRuleCode="'.$employee_salary[0]->SalaryRuleCode.'" limit 1')->fetchAll();
            $salary_rules = [];
            foreach ($salary_rule as $row) {
                $salary_rules[$row['SalaryRuleCode']] = $row['SalaryRuleCode'];
            }
            $salary_rule_data = $employee_salary;*/
            foreach($employee_salary as $emp_sal){
                $emp_sal_array[$emp_sal['SalaryHeadID']]=$emp_sal['Amount'];
            }
            $salary_rule = $this->salary->query("SELECT DISTINCT SalaryRuleCode FROM salary_rule")->fetchAll();
            $salary_rules = [];
            foreach ($salary_rule as $row) {
                $salary_rules[$row['SalaryRuleCode']] = $row['SalaryRuleCode'];
            }
            $salary_rule_data = $this->salary->query("SELECT * FROM salary_rule ORDER BY SalaryRuleCode")->fetchAll();
            //dd($salary_rule_data);
            return view('salary/edit',compact('title','heading','employee_info','employee_salary','emp_sal_array','salary_rule','salary_rules','salary_rule_data'));
        }else {
            //dd($employee_salary);
            $salary_rule = $this->salary->query("SELECT DISTINCT SalaryRuleCode FROM salary_rule")->fetchAll();
            $salary_rules = [];
            foreach ($salary_rule as $row) {
                $salary_rules[$row['SalaryRuleCode']] = $row['SalaryRuleCode'];
            }
            $salary_rule_data = $this->salary->query("SELECT * FROM salary_rule ORDER BY SalaryRuleCode")->fetchAll();
            return view('salary/rule/edit',compact('title','heading','employee_info','salary_rule','salary_rules','salary_rule_data'));
        }
    }

    /**
     * store the specified resource in storage.
     *
     * @return View
     */
    public function store()
    {
        $inputs = $_POST;
        //dd($inputs);
        //$v = new Validator($inputs);
        //$v->rule('required', ['EmployeeCode']);
        if($inputs) {
            $EmployeeCode = $inputs['EmployeeCode'] ?? null;
            $EmployeeID = $inputs['EmployeeID'] ?? null;
            $SalaryRuleCode = $inputs['SalaryRuleCode'] ?? null;
            $SalaryHeadID = $inputs['SalaryHeadID'] ?? null;
            $Amount = $inputs['Amount'] ?? null;
            $IsFixed = $inputs['IsFixed'] ?? null;
            $data_salary = [];
            $sql = "select max(changed) as changed From employee_salary WHERE EmployeeID=".$EmployeeID." ";
            $array  = array();
            $max_changed = $this->salary->get_data_single($sql,$array);
            //dd($max_changed);
            //$max_changed = $this->salary->table("employee_salary")->select('id,max(changed) as changed')->where('EmployeeID',$EmployeeID)->fetch();
            for ($i=0; $i<count($SalaryHeadID); $i++) {
                if( !empty($Amount[$i]) ) {
                    $data_salary[] = [
                    //$data_salary = [
                        'EmployeeCode' => $EmployeeCode,
                        'EmployeeID' => $EmployeeID,
                        'SalaryRuleCode' => $SalaryRuleCode,
                        'SalaryHeadID' => $SalaryHeadID[$i],
                        'Amount' => $Amount[$i],
                        'IsFixed' => $IsFixed[$i],
                        'changed'=> $max_changed['changed']+1
                    ];
                    if($SalaryHeadID[$i]=='Gross'){
                        $this->salary->table('employee_info')->where(['id'=>$EmployeeID])->update(['EntrySalary'=>$Amount[$i]]);
                    }
                }
            }
            $rs = $this->salary->table('employee_salary')->insert($data_salary,'batch');

            //echo '<pre>';print_r( $rs);exit;
            //dd($data_salary);
            if(!$rs) {
                $rs->errorInfo();
            }
            else {
                notification(['type'=>'success', 'message'=>'Updated Successfully']);
            }
        }
        return redirect('salary');
    }
    public function insert_deduct()
    {
        $title = "Salary Insertion Deduction";
        $month_array = $this->month_names_with_id();
        $YearNo = date('Y');
        return view('salary/insert_deduct',compact('title','month_array','YearNo'));
    }
    public function insertDeductStore()
    {
        $check_emp_salary = $this->salary->table("month_wise_salary_info")->where('MonthNo',date("n",strtotime($_POST['Month'])))->where('YearNo',$_POST['Year'])->fetchAll();
        if(!empty($check_emp_salary)){
            for($i=0;$i<count($_POST['emp_id']);$i++){
                if(!empty($_POST['emp_id'][$i])){
                    if($_POST['pf'][$i]==''){$_POST['pf'][$i]=0;}
                    if($_POST['tax'][$i]==''){$_POST['tax'][$i]=0;}
                    if($_POST['advance'][$i]==''){$_POST['advance'][$i]=0;}
                    if($_POST['food'][$i]==''){$_POST['food'][$i]=0;}
                    if($_POST['arear'][$i]==''){$_POST['arear'][$i]=0;}
                    $data = [
                        'PF' => $_POST['pf'][$i],
                        'TAX' => $_POST['tax'][$i],
                        'ADVANCE' => $_POST['advance'][$i],
                        'FOOD' => $_POST['food'][$i],
                        'ARREAR' => $_POST['arear'][$i]
                    ];
                    $row = $this->salary->table("month_wise_salary_info")->where('EmployeeID',$_POST['emp_id'][$i])->where('MonthNo',date("n",strtotime($_POST['Month'])))->where('YearNo',$_POST['Year']);
                    //dd($row->update($data));
                    $row = $row->update($data);
                    //echo '<pre>';print_r( $row);exit;
                    notification(['type'=>'success', 'message'=>'Inserted Successfully']);
                }
            }
        }else{
            notification(['type'=>'success', 'message'=>'Salary Processed Not Yet Of '.$_POST['Month'].','.$_POST['Year'].'']);
        }
        return redirect('salary/insert_deduct');
    }
    public function insertDeductEdit() {
        $inputs = $_GET;
        $data = '';
        if (!empty($inputs)) {
            $EmployeeID = json_decode($inputs['EmployeeID']) ?? null;
            $MonthNo = validation($inputs['MonthNo'] ?? null);
            $YearNo = validation($inputs['YearNo'] ?? null);
            $month_array = $this->month_names_with_id();
            $Month = $month_array[$MonthNo];

            $employees = $this->salary->table("month_wise_salary_info")->select('id','EmployeeCode','EmployeeID','MonthNo','YearNo','ARREAR','PF','TAX','ADVANCE','FOOD')->where('EmployeeID',$EmployeeID)->where('MonthNo',$MonthNo)->where('YearNo',$YearNo)->fetchAll();
            foreach ($employees as $row) {
                $data .= '<tr>
                        <td>'.$row['EmployeeCode'].'
                            <input type="hidden" class="form-control form-control-sm salary_id" name="salary_id[]"  autocomplete="off" value="'.$row['id'].'"></td>
                        <td><input type="text" class="form-control form-control-sm pf" name="pf[]" autocomplete="off" value="'.$row['PF'].'"></td>
                        <td><input type="text" class="form-control form-control-sm tax" name="tax[]" autocomplete="off" value="'.$row['TAX'].'"></td>
                        <td><input type="text" class="form-control form-control-sm advance" name="advance[]" autocomplete="off" value="'.$row['ADVANCE'].'"></td>
                        <td>
                            <input type="text" class="form-control form-control-sm food" name="food[]" autocomplete="off" value="'.$row['FOOD'].'">
                        </td>
                        <td class="no_padding"><input type="text" class="form-control form-control-sm arear" name="arear[]" autocomplete="off" value="'.$row['ARREAR'].'"></td>
                        <td><button type="button" class="btn-xs btn-danger remove_row">X</button></td>
                    </tr>';
            }
        }
        else
            $data = 'No data found.';
        echo ($data);
    }
    public function insertDeductUpdate()
    {
        if(!empty($_POST['salary_id'])){
            for($i=0;$i<count($_POST['salary_id']);$i++){
                if(!empty($_POST['salary_id'][$i])){
                    $data = [
                        'PF' => $_POST['pf'][$i],
                        'TAX' => $_POST['tax'][$i],
                        'ADVANCE' => $_POST['advance'][$i],
                        'FOOD' => $_POST['food'][$i],
                        'ARREAR' => $_POST['arear'][$i]
                    ];
                    $row = $this->salary->table("month_wise_salary_info")->where('id',$_POST['salary_id'][$i]);
                    $row = $row->update($data);
                    //echo '<pre>';print_r( $row);
                    notification(['type'=>'success', 'message'=>'Updated Successfully']);
                }
            }
        }else{
            notification(['type'=>'success', 'message'=>'Salary Processed Not Yet Of '.$_POST['Month'].','.$_POST['Year'].'']);
        }
        return redirect('salary/insert_deduct');
    }

    public function fixed_deduct()
    {
        $title = "Salary Fixed Deduction";
        $month_array = $this->month_names_with_id();
        $YearNo = date('Y');
        $from_date = '';
        $to_date ='';
        $company_data = $this->company->getData();
        foreach($company_data as $key=>$row){
            $from_date = $row['from_date'];
            $to_date = $row['to_date'];
        }
        return view('salary/fixed_deduct',compact('title','month_array','YearNo','from_date','to_date'));
    }


    public function fixed_deduct_data()
    {
        echo($_POST['emp_id']);
        //echo($_POST['from_date']);
        //echo($_POST['to_date']);
        $check_emp_salary = $this->salary->table("month_wise_salary_info")->where('MonthNo',)->fetchAll();
    }


    public function fixedDeductStore()
    {
        if(!empty($_POST['emp_id'])){
            for($i=0;$i<count($_POST['emp_id']);$i++){
                if(!empty($_POST['emp_id'][$i])){
                    if($_POST['pf'][$i]==''){$_POST['pf'][$i]=0;}
                    if($_POST['tax'][$i]==''){$_POST['tax'][$i]=0;}
                    if($_POST['food'][$i]==''){$_POST['food'][$i]=0;}
                    $salary_fixed_deduct[] = [
                        'EmployeeID' =>$_POST['emp_id'][$i],
                        'pf' => $_POST['pf'][$i],
                        'tax' => $_POST['tax'][$i],
                        'food' => $_POST['food'][$i],
                        'from_date' => date_conversion('Y-m-d',$_POST['from_date']),
                        'to_date' => date_conversion('Y-m-d',$_POST['to_date']),
                        'status' => 1,
                    ];
                    $del = $this->salary->table("employee_salary_deduct")->where('EmployeeID',$_POST['emp_id'][$i])->where('from_date',date_conversion('Y-m-d',$_POST['from_date']))->where('to_date',date_conversion('Y-m-d',$_POST['to_date']))->where('status',1);
                    $del = $del->delete();
                    notification(['type'=>'success', 'message'=>'Inserted Successfully']);
                }
            }
        }else{
            notification(['type'=>'success', 'message'=>'Salary Processed Not Yet Of '.$_POST['Month'].','.$_POST['Year'].'']);
        }
        if(!empty($salary_fixed_deduct)) {
            $this->salary->table('employee_salary_deduct')->insert($salary_fixed_deduct,'batch');
        }
        return redirect('salary/fixed_deduct');
    }
    public function variable_deduct()
    {
        $title = "Salary Variable Deduction";
        $month_array = $this->month_names_with_id();
        $YearNo = date('Y');
        return view('salary/variable_deduct',compact('title','month_array','YearNo'));
    }
    public function variableDeductStore()
    {
        if(!empty($_POST['emp_id'])){
            for($i=0;$i<count($_POST['emp_id']);$i++){
                if(!empty($_POST['emp_id'][$i])){
                    if($_POST['advance'][$i]==''){$_POST['advance'][$i]=0;}
                    if($_POST['loan'][$i]==''){$_POST['loan'][$i]=0;}
                    if($_POST['bakery'][$i]==''){$_POST['bakery'][$i]=0;}
                    if($_POST['others'][$i]==''){$_POST['others'][$i]=0;}
                    // $data = [
                    //     'ADVANCE' => $_POST['advance'][$i],
                    //     'LOAN' => $_POST['loan'][$i],
                    //     'Bakery' => $_POST['bakery'][$i],
                    //     'Others' => $_POST['others'][$i],
                    // ];
                    $salary_variable_deduct[] = [
                        'EmployeeID' =>$_POST['emp_id'][$i],
                        'advance' => $_POST['advance'][$i],
                        'loan' => $_POST['loan'][$i],
                        'bakery' => $_POST['bakery'][$i],
                        'others' => $_POST['others'][$i],
                        'month_no' => date("n",strtotime($_POST['Month'])),
                        'year_no' => $_POST['Year'],
                        'status' => 2,
                    ];
                    $del = $this->salary->table("employee_salary_deduct")->where('EmployeeID',$_POST['emp_id'][$i])->where('month_no',date("n",strtotime($_POST['Month'])))->where('year_no',$_POST['Year'])->where('status',2);
                    $del = $del->delete();
                    //$row = $this->salary->table("employee_salary_deduct")->where('EmployeeID',$_POST['emp_id'][$i])->where('month_no',date("n",strtotime($_POST['Month'])))->where('year_no',$_POST['Year']);
                    //dd($row->update($data));
                    //$row = $row->update($salary_variable_deduct);
                    //echo '<pre>';print_r( $row);exit;
                    notification(['type'=>'success', 'message'=>'Inserted Successfully']);
                }
            }
        }else{
            notification(['type'=>'success', 'message'=>'Salary Processed Not Yet Of '.$_POST['Month'].','.$_POST['Year'].'']);
        }
        //dd($salary_variable_deduct);
        if(!empty($salary_variable_deduct)) {
            $this->salary->table('employee_salary_deduct')->insert($salary_variable_deduct,'batch');
        }
        return redirect('salary/variable_deduct');
    }
    public function getEmployee() {
        $inputs =  $_GET;
        //$employees = $this->attendance->table("month_wise_salary_info")->select('id','EmployeeCode','EmployeeID','MonthNo','YearNo','ARREAR','PF','TAX');
        $employees = $this->salary->table("month_wise_salary_info")->select('id','EmployeeCode','EmployeeID','MonthNo','YearNo','ARREAR','PF','TAX');
        //$employees = $this->employee->getEmployee();
        $employees = $employees->where('MonthNo',$inputs['month'])->where('YearNo',$inputs['year']);
        if (!empty($inputs['employee_code'])) {
            $employees = $employees->where('EmployeeCode',$inputs['employee_code']);
        }
        $employees = $employees->fetchAll();
        if($employees) {
            $data = '';
            foreach ($employees as $row) {
                $data .= '<tr>
                    <td>
                        <input type="checkbox" class="employee_id" name="employee_id[]" value="'.$row['EmployeeID'].'" checked>
                        <input type="hidden" class="employee_code" name="employee_code[]" value="'.$row['EmployeeCode'].'">
                    </td>
                    <td>'.$row['EmployeeCode'].'</td>
                    <td>'. $row['EmployeeCode'].'</td>
                    <td>'. $row['EmployeeCode'].'</td>
                </tr>';
            }
        }
        echo ($data);
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
    public function get_employee_info() {
        $search = $_GET['emp_id'];
        $month = date("m", strtotime($_GET['month']));
        $year = $_GET['year'];
        $emp_info = $this->leave->get_employee_info($search);
        $emp_salary_deduct = $this->salary->employee_salary_deduct($search,$month,$year);
        //dd($emp_info);
        /*$sql = "SELECT id,EmployeeCode,EmployeeName FROM employee_info
            WHERE id=?";
        $whr = array($_GET['emp_id']); 
        $emp_info = $this->salary->get_data_single($sql,$whr); */
        if(empty($emp_salary_deduct)){
            echo json_encode(array(
                'id'=>$emp_info['id'],
                'EmployeeName'=>$emp_info['EmployeeName'],
                'EmployeeCode'=>$emp_info['EmployeeCode'],
                'DOJ'=>$emp_info['DOJ'],
                'section'=>$emp_info['section'],
        
            ));
        }else{
            echo json_encode(array(
                'id'=>$emp_info['id'],
                'EmployeeName'=>$emp_info['EmployeeName'],
                'EmployeeCode'=>$emp_info['EmployeeCode'],
                'DOJ'=>$emp_info['DOJ'],
                'section'=>$emp_info['section'],
                'advance'=>$emp_salary_deduct['advance'],
                'loan'=>$emp_salary_deduct['loan'],
                'bakery'=>$emp_salary_deduct['bakery'],
                'others'=>$emp_salary_deduct['others'],
            ));
        }
    }


    public function get_deduct_data() {
        $employee_code = $_GET['emp_id'];
        $month='';
        if(isset($_GET['month'])){
            $month = date("n",strtotime($_GET['month']));
            if($month<10){
                $month="0".$month;
            }
        }
        if(isset($_GET['year'])){
            $year = $_GET['year'];
        }
        $status = $_GET['status'];
        $emp_info = $this->leave->get_employee_info($employee_code);

        if($status=='2'){
            $emp_salary_deduct = $this->salary->employee_salary_deduct($employee_code,$month,$year,'','','',$status);
        }else{
            $employee_id = $emp_info['id'];
            $from_date=date('Y-m-d', strtotime($_GET['from_date']));
            $to_date=date('Y-m-d', strtotime($_GET['to_date']));

            $employee_salary_deduct= $this->salary->employee_salary_deduct('','','',$employee_id,$from_date,$to_date,$status);

            if(empty($employee_salary_deduct['pf']))
            {
                // $employee_salary= $this->salary->get_basic_salary($employee_id);
                $basic=$employee_salary_deduct['Amount'];
                $pf=$basic*(5/100);
            }else{
                $pf=$employee_salary_deduct['pf'];
            }
        }
        if(empty($emp_salary_deduct)){
            echo json_encode(array(
                'id'=>$emp_info['id'],
                'EmployeeName'=>$emp_info['EmployeeName'],
                'EmployeeCode'=>$emp_info['EmployeeCode'],
                'DOJ'=>$emp_info['DOJ'],
                'section'=>$emp_info['section'],
                'pf'=>$pf ?? '',
                'food'=>$employee_salary_deduct['food'] ?? '',
                'tax'=>$employee_salary_deduct['tax'] ?? '',
        
            ));
        }else{
            echo json_encode(array(
                'id'=>$emp_info['id'],
                'EmployeeName'=>$emp_info['EmployeeName'],
                'EmployeeCode'=>$emp_info['EmployeeCode'],
                'DOJ'=>$emp_info['DOJ'],
                'section'=>$emp_info['section'],
                'advance'=>$emp_salary_deduct['advance'],
                'loan'=>$emp_salary_deduct['loan'],
                'bakery'=>$emp_salary_deduct['bakery'],
                'others'=>$emp_salary_deduct['others'],
                'pf'=>$pf ?? '',
                'food'=>$employee_salary_deduct['food'] ?? '',
                'tax'=>$employee_salary_deduct['tax'] ?? '',
            ));
        }
    }
    public function search() {
        if(isset($_GET['search'])){
            $search = $_GET['search'];
            $sql = "SELECT id,EmployeeCode,EmployeeName FROM employee_info
                WHERE EmployeeCode like '$search%' OR EmployeeName like '$search%'";
            $where = array();
            $emp_info = $this->salary->get_data($sql,$where);
            //dd($emp_info);
            if(!empty($emp_info)){
                foreach($emp_info as $emp){                    
                    $array[] = array(
                         'label' => $emp['EmployeeCode'],
                         'emp_id'  => $emp['id']
                     );
                }
                echo json_encode($array);
            }else{ 
                $array[] = array(
                    'label' => 'Nothing Found',
                    'emp_id'  => ''
                );           
                echo json_encode($array);
            }
        }
    }
}
