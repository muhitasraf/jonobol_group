<?php

namespace App\Controllers\Employee;

use App\Controllers\Controller;
use App\Models\Employee;
//use App\Models\SqlServer;
use App\Traits\AllocateLeaveDays;
use Vendor\Valitron\Validator;
use App\library\Upload;
use App\library\SSP;
use App\Models\Leave;

class EmployeeController extends Controller
{
    use AllocateLeaveDays;

    private $employee;
    private $upload;
    private $leave;
    //private $sql_server;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->employee = new Employee();
        $this->upload = new Upload();
        $this->leave = new Leave();
        //$this->sql_server = new SqlServer();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Employees";
        return view('employee/index',compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        $heading = "Employee";
        $title = "New Employee";

        list($countries, $districts) = $this->country_distict_list();
        return view('employee/create',compact('title','heading','districts','countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $inputs
     * @return Response View
     */
    public function store()
    {
        $inputs = $_POST;
        $inputs = $inputs+$_FILES;
        if(isset($inputs['employee_basic_info'])) {
            if (!$this->employeeCodeExists(trim($inputs['EmployeeCode']),null))
            { 
                $v = $this->validate_form_data($inputs);
                if($v->validate()) {                        
                    list($EmployeeCode, $data_employee_info) = $this->process_input_data($inputs);
                    $rs = $this->employee->table('employee_info')->insert($data_employee_info);
                    //dd($data_employee_info);
                    //echo $rs;
                    //print_r($this->employee->table("employee_info")->insert($data_employee_info));
                    //echo '<pre>';print_r( $data_employee_info);exit;
                    //echo date('Y').'--'.date('m').'-'.date('d');exit;
                    if($rs) {
                        $employee_info = $this->employee->table('employee_info')->where('EmployeeCode',$EmployeeCode)->fetch();
                        $EmployeeID = $employee_info->id;
                        $is_address_same = $inputs['is_address_same'] ?? 0;
                        $data = $this->process_address_input_data($inputs, $EmployeeID, $is_address_same);
                        $address = $this->employee->table("address_info")->insert($data,'prepared');
                        //print_r($this->employee->table("address_info")->insert($data,'prepared'));
                        //echo '<pre>';print_r( $data);exit;
                        
                        
                        
                        $days_array = [
                            '1'=>'01','2'=>'02','3'=>'03','4'=>'04','5'=>'05','6'=>'06','7'=>'07','8'=>'08','9'=>'09','10'=>'10',
                            '11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20',
                            '21'=>'21','22'=>'22','23'=>'23','24'=>'24','25'=>'25','26'=>'26','27'=>'27','28'=>'28','29'=>'29','30'=>'30','31'=>'31'
                        ];
                        for($i=1;$i<=cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));$i++){
                            $emp_attn_data [] = [
                                'EmployeeID' => $EmployeeID,
                                'WorkDate' => date('Y').'-'.date('m').'-'.$days_array[$i],
                            ];                              
                        }
                        $this->employee->table('employee_attn_month')->insert($emp_attn_data,'batch');    
                        for($i=1;$i<=date('d');$i++){
                            $daywise_pay_hour_data[] = [
                                'EmployeeCode' => $EmployeeCode,
                                'EmployeeID' => $EmployeeID,
                                'WorkDate' => date('Y').'-'.date('m').'-'.$days_array[$i],
                                'PunchOutDate' => date('Y').'-'.date('m').'-'.$days_array[$i],
                                'ShiftID' => 1,
                                'ShiftInTime' => '08:00:00',
                                'ShiftOutTime' => '17:00:00',
                            ];                                                        
                        }
                        if(!empty($daywise_pay_hour_data)){
                            $this->employee->table('daywise_pay_hour')->insert($daywise_pay_hour_data,'batch');
                        }
                        
                        
                        
                        
                        notification(['type' => 'success', 'message' => 'Created Successfully']);
                        return redirect('employee/edit/'.$EmployeeID);
                    }
                    else {
                        $errors = $rs->errorInfo();
                    }
                } else { 
                    $errors = $v->errors();
                }
            }
            else {
                $errors = [
                    'EmployeeCode' => ['Employee Code is already exists.']
                ];
            }
        }
        $with = [
            'errors' => $errors ?? '',
            'inputs' => $_REQUEST
        ];
        return redirect('employee/add',['with' => $with]);
    }

    public function employee_photo()
    {
        $title = "Employee Photo";
        $employees = $this->employee->table("employee_info")->select('id','EmployeeCode','EmployeeName','EmployeePhoto','EmployeeSignature','NomineePhoto','NomineeSignature')->fetchALL();     
        return view('employee/employee_photo_info',compact('title','employees'));
    }




    public function employee_photo_call()
    {
        $heading = "Employee Photo";
        $title = "Employee Photo";
        
        if(isset($_POST['employee_id'])){
            $employee_id = json_decode($_POST['employee_id']) ?? '';
            $employee_name = json_decode($_POST['employee_name']) ?? '';
            $employee_code = json_decode($_POST['employee_code']) ?? '';
            
            //dd ($employee_name);
            $data = ''; 
            for($i=0;$i<count($employee_id);$i++){
                $data .= '<tr>
                        <td>
                            <input type="hidden" autocomplete="off" class="form-control form-control-sm EmployeeID" name="employee_id[]" value="'.$employee_id[$i].'">
                            <input type="text" autocomplete="off" class="form-control form-control-sm EmployeeCode" name="employee_code[]" value="'.$employee_code[$i].'" readonly>
                        </td>
                        <td><input type="text" autocomplete="off" class="form-control form-control-sm EmployeeName" name="employee_name[]" value="'.$employee_name[$i].'" readonly></td>
    
                        <td>
                        <input type="file" autocomplete="off" class="form-control form-control-sm" name="employee_photo[]" accept="image/jpeg">
                        </td>
                        <td>'.form_input('EmployeeSignature[]','file',null,'class="form-control form-control-sm" accept="image/jpeg" ').'</td>
                        <td>'.form_input('NomineePhoto[]','file',null,'class="form-control form-control-sm" accept="image/jpeg" ').'</td>
                        <td>'.form_input('NomineeSignature[]','file',null,'class="form-control form-control-sm" accept="image/jpeg" ').'</td>

                    </tr>';
            }
            echo ($data);

        }else{
            return view('employee/employee_photo_info',compact('title','heading','employee_id','employee_name'));
        }







        // return view('employee/employee_photo_info',compact('title'));
    }

    public function employee_photo_store()
    {   /*echo '<pre>'; print_r($_POST['employee_id']);
        echo '<pre>'; print_r($_FILES['employee_photo']);
        echo '<pre>'; print_r($_FILES['EmployeeSignature']);
        echo '<pre>'; print_r($_FILES['NomineePhoto']);*/
        $title = "Employee Photos";
        $Employee_Photo =$_FILES['employee_photo'];
        $EmployeeCode = $_POST['employee_code'];
        $EmployeeID = $_POST['employee_id'];
        $path = 'images/employee/';
        $nomineepath = 'images/nominee/';
        $signaturepath = 'images/signature/';
        $nsignaturepath = 'images/nominee_signature/';
        for($i=0;$i<count($_POST['employee_id']);$i++){
            $photo_file_name ='';
            $signature_file_name = '';
            $nominee_file_name= '';
            $nsignature_file_name='';
            if(!empty($_FILES['employee_photo']) && ($_FILES['employee_photo']['size'][$i])<101000){
                if(empty($_FILES['employee_photo']['error'][$i]))
                {
                    $photo_file_name = $EmployeeID[$i] . '-' . 'EP.jpg';
                    // $emPhoto = $this->upload->make_multiple('employee_photo',$i);
                    // $emPhoto->save(upload_path($path . $photo_file_name));

                    $file=$_FILES['employee_photo']['tmp_name'][$i];
                    list($width,$height)=getimagesize($file);
                    $nwidth=$width/4;
                    $nheight=$height/4;
                    $newimage=imagecreatetruecolor($nwidth,$nheight);
                    $source=imagecreatefromjpeg($file);
                    imagecopyresized($newimage,$source,0,0,0,0,$nwidth,$nheight,$width,$height);
                    imagejpeg($newimage,'./public/assets/uploads/images/employee/'.$photo_file_name,100);

                    $emp_photo_info=[
                        'EmployeePhoto'=>$photo_file_name,                 
                    ];           
                    $update_info = $this->employee->table("employee_info")->where("id", $_POST['employee_id'][$i])->update($emp_photo_info);
                }
            }
            if(!empty($_FILES['EmployeeSignature']) && ($_FILES['EmployeeSignature']['size'][$i])<101000){
                if(empty($_FILES['EmployeeSignature']['error'][$i]))
                {
                    $signature_file_name = $EmployeeID[$i] . '-' . 'ES.jpg';
                    $emPhoto = $this->upload->make_multiple('EmployeeSignature',$i);
                    $emPhoto->save(upload_path($signaturepath . $signature_file_name));

                    $emp_photo_info=[                       
                        'EmployeeSignature'=>$signature_file_name,                        
                    ];           
                    $update_info = $this->employee->table("employee_info")->where("id", $_POST['employee_id'][$i])->update($emp_photo_info);
                }
            }
            if(!empty($_FILES['NomineePhoto']) && ($_FILES['NomineePhoto']['size'][$i])<101000){
                if(empty($_FILES['NomineePhoto']['error'][$i]))
                {
                    $nominee_file_name = $EmployeeID[$i] . '-' . 'NP.jpg';
                    $emPhoto = $this->upload->make_multiple('NomineePhoto',$i);
                    $emPhoto->save(upload_path($nomineepath . $nominee_file_name));

                    $emp_photo_info=[
                        'NomineePhoto'=>$nominee_file_name,
                    ];           
                    $update_info = $this->employee->table("employee_info")->where("id", $_POST['employee_id'][$i])->update($emp_photo_info);
                }
            }
            if(!empty($_FILES['NomineeSignature']) && ($_FILES['NomineeSignature']['size'][$i])<101000){
                if(empty($_FILES['NomineeSignature']['error'][$i]))
                {
                    $nsignature_file_name = $EmployeeID[$i] . '-' . 'NS.jpg';
                    $emPhoto = $this->upload->make_multiple('NomineeSignature',$i);
                    $emPhoto->save(upload_path($nsignaturepath . $nsignature_file_name));
                    $emp_photo_info=[
                        'NomineeSignature'=>$nsignature_file_name,
                    ];           
                    $update_info = $this->employee->table("employee_info")->where("id", $_POST['employee_id'][$i])->update($emp_photo_info);
                }
            }
        }

        notification(['type' => 'success', 'message' => 'Image Uploaded Successfully']);
       // return view('employee/employee_food_loan', compact('title'));
        return redirect('employee/employee_photo_info',compact('title'));

    }


    public function employee_food_loan()
    {
        $title = "Employee Food Load";
        return view('employee/employee_food_loan', compact('title'));
    }

    public function employee_loaninfo()
    {
        $heading = "Employee";
        $title = "Employee Food Loan";
       
        $leave_types = $this->leave->table('leave_type')->fetchAll();
        foreach ($leave_types as $row) {
            $leave_type[$row->LeaveTypeName] = $row->LeaveTypeName;
        }
        if(isset($_POST['employee_id'])){
            $employee_id = json_decode($_POST['employee_id']) ?? '';
            $employee_name = json_decode($_POST['employee_name']) ?? '';
            $employee_code = json_decode($_POST['employee_code']) ?? '';            
            
            $data = ''; 
            for($i=0;$i<count($employee_id);$i++){
                $data .= '<tr>
                        <td>
                            <input type="hidden" autocomplete="off" class="form-control form-control-sm EmployeeID" name="employee_id" value="'.$employee_id[$i].'">
                            <input type="text" autocomplete="off" class="form-control form-control-sm" name="employee_code" value="'.$employee_code[$i].'" readonly>
                        </td>
                        <td><input type="text" class="form-control form-control-sm" name="employee_name" value="'.$employee_name[$i].'"></td>
                        <td><input type="number" class="form-control form-control-sm AdjustLoan" name="AdjustLoan" value=""></td>
                        <td><input type="number" class="form-control form-control-sm FoodAllowance" name="FoodAllowance" value=""></td>
                    </tr>';
            }
            echo ($data);
        }else{
            return view('employee/employee_food_loan',compact('title','heading'));
        }
        
    }
    public function employee_loaninfo_store()
    {
        $inputs = $_POST;
        //dd($inputs);
        $v = new Validator($inputs);
        $v->rule('required', ['EmployeeID','AdjustLoan','FoodAllowance']);
        if($v->validate()) {
            $EmployeeID = json_decode($inputs['EmployeeID'] ?? null);
            $AdjustLoan = json_decode($inputs['AdjustLoan'] ?? null);
            $FoodAllowance = json_decode($inputs['FoodAllowance'] ?? null);
           
            for($i=0;$i<count($EmployeeID);$i++){
                    $loan_info[] = [
                        'EmployeeID' => $EmployeeID[$i],
                        'AdjustLoan' => $AdjustLoan[$i],                       
                        'FoodAllowance' => $FoodAllowance[$i]                        
                    ];
                    
            } 
            $rs = $this->leave->table('employee_loan')->insert($loan_info,'batch');
            if($rs) {
                notification(['type' => 'success', 'message' => 'Information Inserted Successfully']);
                //return view('employee/employee_food_loan',compact('title','heading'));
            }
            else {
                echo "<h4 class='text text-info'>Failed.</h4>";
            }
        } 
    }

    public function employee_status()
    {
        $title = "Employee Status";
        return view('employee/employee_status', compact('title'));
    }

    public function employee_statusinfo()
    {
        $heading = "Employee";
        $title = "Employee Status";
       
        $leave_types = $this->leave->table('leave_type')->fetchAll();
        foreach ($leave_types as $row) {
            $leave_type[$row->LeaveTypeName] = $row->LeaveTypeName;
        }
        if(isset($_POST['employee_id'])){
            $employee_id = json_decode($_POST['employee_id']) ?? '';
            $employee_name = json_decode($_POST['employee_name']) ?? '';
            $employee_code = json_decode($_POST['employee_code']) ?? '';            
            
            $data = ''; 
            for($i=0;$i<count($employee_id);$i++){
                $data .= '<tr>
                <td>
                    <input type="hidden" autocomplete="off" class="form-control form-control-sm EmployeeID" name="employee_id" value="'.$employee_id[$i].'">
                    <input type="text" autocomplete="off" class="form-control form-control-sm" name="employee_code" value="'.$employee_code[$i].'" readonly>
                </td>
                <td><input type="text" class="form-control form-control-sm" name="employee_name" value="'.$employee_name[$i].'"></td>
                <td>'.form_select('LeaveType',$leave_type,null,'class="form-control form-control-sm LeaveType" ').'</td>
                <td>'.form_input('FromDate','date',old('FromDate'),'class="form-control form-control-sm form_date FromDate"  autocomplete="off"').'</td>
                <td>'.form_input('ToDate','date',old('ToDate'),'class="form-control form-control-sm form_date ToDate" autocomplete="off" ').'</td>
                <td>'.form_input('LeaveDays','number',old('LeaveDays'),'class="form-control form-control-sm LeaveDays" ').'</td>
            </tr>';
            }
            echo ($data);
        }else{
            return view('employee/employee_status',compact('title','heading'));
        }
        
    }
    public function employee_status_store()
    {
        $inputs = $_POST;
        //dd($inputs);
        $v = new Validator($inputs);
        $v->rule('required', ['EmployeeID','AdjustLoan','FoodAllowance']);
        if($v->validate()) {
            $EmployeeID = json_decode($inputs['EmployeeID'] ?? null);
            $AdjustLoan = json_decode($inputs['AdjustLoan'] ?? null);
            $FoodAllowance = json_decode($inputs['FoodAllowance'] ?? null);
           
            for($i=0;$i<count($EmployeeID);$i++){
                    $loan_info[] = [
                        'EmployeeID' => $EmployeeID[$i],
                        'AdjustLoan' => $AdjustLoan[$i],                       
                        'FoodAllowance' => $FoodAllowance[$i]                        
                    ];
                    
            } 
            $rs = $this->leave->table('employee_loan')->insert($loan_info,'batch');
            if($rs) {
                notification(['type' => 'success', 'message' => 'Information Inserted Successfully']);
                //return view('employee/employee_food_loan',compact('title','heading'));
            }
            else {
                echo "<h4 class='text text-info'>Failed.</h4>";
            }
        } 
    }



    /**
     * Check employee code exists.
     *
     * @param  Request  $EmployeeCode
     * @return Response View
     */
    public function employeeCodeExists($EmployeeCode,$employee_id) {
        $employee_info = $this->employee->table('employee_info')->where('EmployeeCode',$EmployeeCode);
        if ($employee_info->count()) {
            if ($employee_info->fetch()->id == $employee_id)
                return false;
            return true;
        }
        return false;
    }

    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($employee_id = null)
    {
        $heading = "Employee";
        $title = "Update Employee";
        $employee_info = $this->employee->table("employee_info")->where("id",$employee_id)->fetch();
        $family_info = $this->employee->table("family_info")->where("EmployeeID",$employee_id)->fetch();
        if($employee_info) {
            // show district and district related to bangladesh(19) currently
            $address_info = $this->employee->table("address_info")->where("EmployeeID",$employee_info->id)->orderBy('Type')->fetchAll();
            //print_r($address_info);exit;
            $nominee_info = $this->employee->table("nominee_info")->where("EmployeeID",$employee_info->id)->fetchAll();
            $employee_select2 = $employee_info->EmployeeCode.'-'.$employee_info->EmployeeName.'-'.$employee_info->PunchCardNo;

            list($countries, $districts) = $this->country_distict_list();

            $unit_array = $this->employee->table("settings_master")->where('type_name','unit')->fetchAll();
            $unit = [''=>'- Select -'];
            foreach ($unit_array as $item) {
                $unit[$item->id] = $item->name;
            }

            $designation_array = $this->employee->table("settings_master")->where('type_name','designation')->fetchAll();
            $designation = [''=>'- Select -'];
            foreach ($designation_array as $item) {
                $designation[$item->id] = $item->name;
            }

            $section_array = $this->employee->table("settings_master")->where('type_name','section')->fetchAll();
            $section = [''=>'- Select -'];
            foreach ($section_array as $item) {
                $section[$item->id] = $item->name;
            }

            $division_array = $this->employee->table("settings_master")->where('type_name','division')->fetchAll();
            $division = [''=>'- Select -'];
            foreach ($division_array as $item) {
                $division[$item->id] = $item->name;
            }

            $departments = $this->employee->table("settings_master")->where('type_name','department')->fetchAll();
            $department = [''=>'- Select -'];
            foreach ($departments as $item) {
                $department[$item->id] = $item->name;
            }

            $staff_category_array = $this->employee->table("settings_master")->where('type_name','staff-category')->fetchAll();
            $staff_category = [''=>'- Select -'];
            foreach ($staff_category_array as $item) {
                $staff_category[$item->id] = $item->name;
            }


            $shifts = $this->employee->table("shift_plan")->select('id','ShiftID');//->fetchAll();
            $shift = [''=>'- Select -'];
            foreach ($shifts as $item) {
                $shift[$item->id] = $item->ShiftID;
            }

            $shift_rules = $this->employee->table("shift_rule")->select('id','ShiftRuleCode');//->fetchAll();
            $shift_rule = [''=>'- Select -'];
            foreach ($shift_rules as $item) {
                $shift_rule[$item->id] = $item->ShiftRuleCode; //$item->id
            }

            $leave_rules = $this->employee->table("leave_rulenew")->select('id','LeaveRuleID');//->fetchAll();
            $leave_rule = [''=>'- Select -'];
            foreach ($leave_rules as $item) {
                $leave_rule[$item->id] = $item->LeaveRuleID;
            }
            $employee_education = $this->employee->table("employee_education")->where('employee_id',$employee_info->id)->fetchAll();
            return view('employee/edit',compact('title','heading','employee_info','address_info','family_info','nominee_info','countries','districts','unit','section','department','shift','employee_select2','leave_rule','designation','division','shift_rule','staff_category','employee_education'));
        }
        else {
            echo "Something went wrong.";
            exit(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $employee_id
     * @return View
     */
    public function update($employee_id=null)
    {
        $inputs = $_POST;               
        
        if(isset($inputs['basic_info'])) {
            
            $this->basic_info($employee_id,$inputs);
        }
        elseif(isset($inputs['official_info'])) {
            $this->official_info($employee_id,$inputs);
        }

        elseif(isset($inputs['rule_info'])) {
            $this->rule_info($employee_id,$inputs);
        }
        
        elseif(isset($inputs['education_info'])) {
            $this->education_info($employee_id,$inputs);
        }

        elseif(isset($inputs['nominee_info'])) {
            $this->nominee_info($employee_id,$inputs);
        }

        elseif(isset($inputs['user_defined'])) {
            $this->user_defined($employee_id,$inputs);
        }

        elseif(isset($inputs['family_info'])) {
            $this->family_info($employee_id,$inputs);
        }
        elseif(isset($inputs['bangla_info'])) {
            $this->bangla_info($employee_id,$inputs);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }


    /**
     * Get last insert id with a predefined txt.
     *
     * @return String
     */
    public function getEmployeeCode()
    {
        $last_insert_id = $this->employee->table('employee_info')->max("Id");

        // for initial state there is no empoyee so id is null, then initial code from 1
        $last_insert_id = $last_insert_id + 1;
        if(strlen($last_insert_id) != 6) {
            $min_6_digit_number = 100000;
            $code = $min_6_digit_number + $last_insert_id;
            $code = preg_replace('/^1/', '0', $code);
        }
        return 'Ga-'.$code;
    }

    /**
     * Get employee data by employee code or punch card
     *
     */
    public function searchEmployee() {
        $q = $_GET['searchTerm'];
        if($q != null) {
            $employees = $this->employee->searchEmployee(["%$q%","%$q%","%$q%"]);
            $data = '';
            if(count($employees)>0) {
                foreach ($employees as $row) {
                    $data .= '<tr><td>'.$row['EmployeeCode'].'</td><td>'.$row['EmployeeName'].'</td><td class="punch_card" id="'.$row['id'].'" data-val="'.$row['PunchCardNo'].'" class="punch_machine" contenteditable="true">'.$row['PunchCardNo'].'</td></tr>';
                }
            }
            else
                $data = 'No matching data found.';
            echo ($data);
        }
    }

    /**
     * Get data according to datatable search
     * @param searchtext
     * @return json
     */
    public function dTableSearchEmployee() {
        $db = require App . 'config/database.php';

        //$url = $_GET['url']; is forwarding url on click

        // DB table to use
        $table = 'employee_info';

        // Table's primary key
        $primaryKey = 'id';

        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes
        $columns = array(
            array( 'db' => 'EmployeeCode', 'dt' => 0 ),
            array(
                'db'        => 'EmployeeName',
                'dt'        => 1,
                'formatter' => function( $d, $row ) {
                    return '<a href="'.$_GET['forward_url'].'/'.$row[3].'">'.$d.'</a>';
                }
            ),
            array( 'db' => 'BadgeNumber',   'dt' => 2 ),
            array( 'db' => 'id', 'dt' => 3 ),
        );

        // SQL server connection information
        $sql_details = array(
            'user' => $db['DB_USER'],
            'pass' => $db['DB_PASS'],
            'db'   => $db['DB_NAME'],
            'host' => $db['DB_HOST']
        );
        $d =  json_encode(
            SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
        );
        echo $d;
    }

    public function basic_info($employee_id=null,$inputs)
    {
        if (!$this->employeeCodeExists(trim($inputs['EmployeeCode']),$employee_id)) {
            $employee_info = $this->employee->table('employee_info',$employee_id);//->select('EmployeeCode');//->fetch();
            if($employee_info) {
                $v = $this->validate_form_data($inputs);

                if($v->validate()) {
                    list($EmployeeCode, $data_employee_info) = $this->process_input_data($inputs);
                    
                    $rs = $employee_info->update($data_employee_info);

                    if($rs) {
                        $EmployeeID = $employee_info->id;
                        $is_address_same = $inputs['is_address_same'] ?? 0;

                        $data = $this->process_address_input_data($inputs, $EmployeeID, $is_address_same);

                        $address = $this->create_or_update_address($EmployeeID, $data, $is_address_same);
                        notification(['type' => 'success', 'message' => 'Updated Successfully']);
                    }
                    else {
                        session('errors',$rs->errorInfo());
                    }
                } else {
                    session('errors',$v->errors());
                }
            }
        }
        else {
            $errors = [
                'EmployeeCode' => ['Employee Code is already exists.']
            ];
        }
        $with = [
            'errors' => $errors ?? '',
            'inputs' => $_REQUEST
        ];
        //return redirect('employee/add',['with' => $with]);
        return redirect('employee/edit/'.$employee_id,['with' => $with]);
    }

    public function official_info($employee_id=null,$inputs)
    {
        //$employee_code = $inputs['EmployeeCode'];
        $official_info = $this->employee->table("employee_info",$employee_id);
        $DOJ = date_conversion( 'Y-m-d',$inputs['DOJ']);
        $DOC = date_conversion( 'Y-m-d',$inputs['DOC']);
        $separation_date = date_conversion( 'Y-m-d',$inputs['separation_date']);
        $separation_effective_date = date_conversion( 'Y-m-d',$inputs['separation_effective_date']);
        $unit = NULL;
        if($inputs['UnitID']!='') {$unit=$inputs['UnitID']; }
        $DepartmentID = NULL;
        if($inputs['DepartmentID']!='') {$DepartmentID=$inputs['DepartmentID']; }
        $SectionID = NULL;
        if($inputs['SectionID']!='') {$SectionID=$inputs['SectionID']; }
        $SubSectionID = NULL;
        if($inputs['SubSectionID']!='') {$SubSectionID=$inputs['SubSectionID']; }
        $StaffCategoryID = NULL;
        if($inputs['StaffCategoryID']!='') {$StaffCategoryID=$inputs['StaffCategoryID']; }
        $DOS = NULL;
        if($inputs['DOS']!='') {$DOS=$inputs['DOS']; }
        $posting_place = NULL;
        if($inputs['posting_place']!='') {$posting_place=$inputs['posting_place']; }
        $DesignationID = NULL;
        if($inputs['DesignationID']!='') {$DesignationID=$inputs['DesignationID']; }
        $DivisionID = NULL;
        if($inputs['DivisionID']!='') {$DivisionID=$inputs['DivisionID']; }
        $SupvisorCode = NULL;
        if($inputs['SupvisorCode']!='') {$SupvisorCode=$inputs['SupvisorCode']; }
        $AdminReportingPerson = NULL;
        if($inputs['AdminReportingPerson']!='') {$AdminReportingPerson=$inputs['AdminReportingPerson']; }
        $medical_note = NULL;if($inputs['medical_note']!=''){$medical_note=$inputs['medical_note'];}
        $separation_cause = NULL;if($inputs['separation_cause']!=''){$separation_cause=$inputs['separation_cause'];}
        $separation_note = NULL;if($inputs['separation_note']!=''){$separation_note=$inputs['separation_note'];}
        $official_info_data = [
            'UnitID' =>  $unit,
            'DepartmentID' => $DepartmentID,
            'SectionID' => $SectionID,
            'StaffCategoryID' => $StaffCategoryID,
            'DOJ' => date_conversion('Y-m-d',$DOJ),
            'DOC' => date_conversion('Y-m-d',$DOC),
            'DOS' => date_conversion('Y-m-d',$inputs['DOS']),
            'provision_period' => $inputs['provision_period'] ,
            'training_period' => $inputs['training_period'] ,
            'TCD' => date_conversion('Y-m-d',$inputs['TCD']),
            'resign' => date_conversion('Y-m-d',$inputs['resign']),
            'resign_confirm' => date_conversion('Y-m-d',$inputs['resign_confirm']),
            'resign_effective' => date_conversion('Y-m-d',$inputs['resign_effective']),
            'posting_place' => $posting_place,
            'DesignationID' => $DesignationID,
            'DivisionID' => $DivisionID,
            'SubSectionID' => $SubSectionID,
            'OT' => $inputs['OT'],
            'HolydayBonus' => $inputs['HolydayBonus'],
            'medical_note' => $medical_note,
            'separation_cause' => $separation_cause,
            'separation_note' => $separation_note,
            'separation_date' => $separation_date,
            'separation_effective_date' => $separation_effective_date,
            'SupvisorCode' => $SupvisorCode,
            'AdminReportingPerson' => $AdminReportingPerson
        ];

        if($official_info) {
            if ($DOJ != date_conversion('Y-m-d',$official_info->DOJ)) {
                $this->add_allocated_leave_days($official_info->id, $DOJ);
            }

            $official_info->update($official_info_data);
            notification(['type' => 'success', 'message' => 'Updated Successfully']);
        }
        return redirect('employee/edit/'.$employee_id);
    }

    public function rule_info($employee_id=null,$inputs)
    {
        //$employee_code = $inputs['EmployeeCode'];
        $employee_info = $this->employee->table("employee_info",$employee_id);
        $LeaveRuleID = 0;
        if($inputs['LeaveRuleID']!='') {$LeaveRuleID=$inputs['LeaveRuleID']; }
        $SRA = 0;
        if($inputs['SRA']!='') {$SRA=$inputs['SRA']; }
        $ShiftRuleCode = NULL;
        if($inputs['ShiftRuleCode']!='') {$ShiftRuleCode=$inputs['ShiftRuleCode']; }
        $ShiftID = NULL;
        if($inputs['ShiftID']!='') {$ShiftID=$inputs['ShiftID']; }
        $employee_info_data = [
            'LeaveRuleID' => $LeaveRuleID,
            //'MaternityLeaveRuleID' => $inputs['MaternityLeaveRuleID'],
            'SRA' => $SRA,
            'ShiftRuleCode' => $ShiftRuleCode,
            'ShiftID' => $ShiftID,
            'ShiftStartDate' => date_conversion('Y-m-d',$inputs['ShiftStartDate']),
            //'BankAccNo' => $inputs['BankAccNo'] ?? 0,
            //'BranchName' => $inputs['BranchName'] ?? 0,
            //'BankAccNo' => $inputs['BankAccNo'] ?? 0,
            //'BranchName' => $inputs['BranchName'] ?? 0,
        ];
        $employee_info->update($employee_info_data);
        notification(['type' => 'success', 'message' => 'Updated Successfully']);
        return redirect('employee/edit/'.$employee_id);
    }
    public function education_info($employee_id=null,$inputs)
    {
        //$employee_code = $inputs['EmployeeCode'];
        $employee_info = $this->employee->table("employee_info",$employee_id);
        $row = $this->employee->table("employee_education")->where('employee_id',$employee_id)->delete();
        if(!empty($inputs['institute'])){
            for($i=0;$i<count($inputs['institute']);$i++){
                if(!empty($inputs['institute'][$i])){
                    $data = [
                        'employee_id'=>$employee_id,
                        'institute'=>$inputs['institute'][$i],
                        'board'=>$inputs['board'][$i],
                        'exam_title'=>$inputs['exam_title'][$i],
                        'group'=>$inputs['group'][$i],
                        'p_year'=>$inputs['p_year'][$i],
                        'duration'=>$inputs['duration'][$i],
                        'result'=>$inputs['result'][$i],
                        'certificate'=>$inputs['certificate'][$i],
                    ];
                    $rs = $this->employee->table('employee_education')->insert($data,'prepared');
                }
            }
        }
        notification(['type' => 'success', 'message' => 'Updated Successfully']);
        return redirect('employee/edit/'.$employee_id);
    }
    public function nominee_info($employee_id=null,$inputs)
    {
        //$employee_code = $inputs['EmployeeCode'];
        $employee_info = $this->employee->table("employee_info",$employee_id);
        $PF = 0;
        if($inputs['PF']!='') {$PF=$inputs['PF']; }
        $IsInsuranceEntitled = 0;
        if($inputs['IsInsuranceEntitled']!='') {$IsInsuranceEntitled=$inputs['IsInsuranceEntitled']; }
        $employee_info_data = [
            'PF' => $PF,
            'PFEntitledDate' => date_conversion('Y-m-d',$inputs['PFEntitledDate']),
            'PFAccNo' => $inputs['PFAccNo'],
            'InsuranceCompanyID' => $inputs['InsuranceCompanyID'],
            'InsuranceAccount' => $inputs['InsuranceAccount'],
            'IsInsuranceEntitled' => $IsInsuranceEntitled
        ];
        $employee_info->update($employee_info_data);

        //$upload = new Upload();
        $total_input = count($inputs['NomineeName']);
        $path = 'images/employee/';
        for ($i=0; $i<$total_input; $i++) {
            $nominee_type = $i+1; //$inputs['nominee_type'][$i] ??
            if (isset($inputs['NomineeName'][$i]) && $inputs['NomineeName'][$i]!=null && isset($inputs['NationalIDCardNo'][$i]) && $inputs['NationalIDCardNo'][$i]!=null) {
                $data = [
                    'EmployeeID' => $employee_info->id,
                    'NomineeName' => $inputs['NomineeName'][$i],
                    'DOB' => date_conversion('Y-m-d',$inputs['DOB'][$i]),
                    'FatherName' => $inputs['FatherName'][$i],
                    'MotherName' => $inputs['MotherName'][$i],
                    'Relationship' => $inputs['Relationship'][$i],
                    'Address' => $inputs['Address'][$i],
                    'NationalIDCardNo' => $inputs['NationalIDCardNo'][$i],
                    'Distribution' => $inputs['Distribution'][$i],
                    'NomineeType' => $nominee_type
                ];

                /*if ($this->fileExists('NomineeImage')) {
                    $photo_file_name = $EmployeeCode . '-' . 'photo.jpg';
                    //remove image first
                    if(file_exists($path.$photo_file_name)) {
                        unlink($path.$photo_file_name);
                    }
                    $emPhoto = $upload->make('EmployeePhoto');
                    $emPhoto->save(upload_path($path . $photo_file_name));
                }*/
                $photo_file_name = null;
                if(isset($_FILES['NomineeImage']['tmp_name'][$i]) && $_FILES['NomineeImage']['error'][$i] != UPLOAD_ERR_NO_FILE) {
                    $photo_file_tmp = $_FILES['NomineeImage']['tmp_name'][$i];
                    $photo_file_name = $employee_info->EmployeeCode.'-nm-'.$nominee_type.'-photo.jpg';

                    //remove image first
                    if(file_exists($path.$photo_file_name)) {
                        unlink($path.$photo_file_name);
                    }
                    move_uploaded_file($photo_file_tmp,upload_path($path.$photo_file_name));
                }
                //myLog($photo_file_name);
                if (isset($photo_file_name))
                    $data['NomineeImage'] = $photo_file_name;

                $nominee_info = $this->employee->table("nominee_info")->where("EmployeeID",$employee_info->id)->where("NomineeType",$nominee_type);
                //dump($nominee_info->fetch());
                //echo "taking";
                if($nominee_info->fetch()) {
                    $nominee_info->update($data);
                } else {
                    $this->employee->table("nominee_info")->insert($data);
                    notification(['type' => 'success', 'message' => 'Updated Successfully']);
                }
            }
        }
        return redirect('employee/edit/'.$employee_id);
    }

    public function user_defined($employee_id, $inputs)
    {
        $employee_code = $inputs['EmployeeCode'];
        $employee_info = $this->employee->table("employee_info",$employee_id);
        $GradeInfoID = 0;
        if($inputs['GradeInfoID']!='') {$GradeInfoID=$inputs['GradeInfoID']; }
        $AssignWorkID = 0;
        if($inputs['AssignWorkID']!='') {$AssignWorkID=$inputs['AssignWorkID']; }
        $NomineePhone = 0;
        if($inputs['NomineePhone']!='') {$NomineePhone=$inputs['NomineePhone']; }
        $NomineeOcupassion = 0;
        if($inputs['NomineeOcupassion']!='') {$NomineeOcupassion=$inputs['NomineeOcupassion']; }
        $employee_info_data = [
            'GradeInfoID' => $GradeInfoID,
            //'EmployeeNatureID' => $inputs['EmployeeNatureID'],
            'NomineeSpous' => $inputs['NomineeSpous'],
            'LineInfoID' => $inputs['LineInfoID'],
            //'AttenBonusID' => $inputs['AttenBonusID'],
            'AssignWorkID' => $AssignWorkID,
            'NomineePhone' => $NomineePhone,
            //'BonusDesignationID' => $inputs['BonusDesignationID'] ?? 0,
            'NomineeOcupassion' => $NomineeOcupassion
        ];
        $employee_info->update($employee_info_data);
        notification(['type' => 'success', 'message' => 'Updated Successfully']);
        return redirect('employee/edit/'.$employee_id);
    }

    /**
     * @param int $employee_id
     * @param array $inputs
     * @return bool
     */
    public function family_info(int $employee_id, array $inputs) :bool
    {
        $employee_code = $inputs['EmployeeCode'] ?? null;
        $father_name = NULL;
        if($inputs['father_name']!='') {$father_name=$inputs['father_name']; }
        $mother_name = Null;
        if($inputs['mother_name']!='') {$mother_name=$inputs['mother_name']; }
        $spouse_name = Null;
        if($inputs['spouse_name']!='') {$spouse_name=$inputs['spouse_name']; }
        $num_of_child = 0;
        if($inputs['num_of_child']!='') {$num_of_child=$inputs['num_of_child']; }
        $contact_number = 0;
        if($inputs['contact_number']!='') {$contact_number=$inputs['contact_number']; }
        $family_info_data = [
            'EmployeeID' => $employee_id,
            'father_name' => $father_name,
            'mother_name' => $mother_name,
            'spouse_name' => $spouse_name,
            'num_of_child' => $num_of_child,
            'contact_number' => $contact_number
        ];
        
        $family_info = $this->employee->table("family_info")->where('EmployeeID',$employee_id)->fetch();
        if (isset($family_info)) {
            $family_info->update($family_info_data);
        } else
            $this->employee->table('family_info')->insert($family_info_data);

        notification(['type' => 'success', 'message' => 'Updated Successfully']);
        return redirect('employee/edit/'.$employee_id);
    }
    public function bangla_info(int $employee_id, array $inputs) :bool
    {        
        // $employee_code = $inputs['EmployeeCode'] ?? null;
        $employeeName = NULL;
        if($inputs['employeeName']!='') {$employeeName=$inputs['employeeName']; }
        $FatherName = NULL;
        if($inputs['FatherName']!='') {$FatherName=$inputs['FatherName']; }
        $MotherName = Null;
        if($inputs['MotherName']!='') {$MotherName=$inputs['MotherName']; }
        $SpouseName = Null;
        if($inputs['SpouseName']!='') {$SpouseName=$inputs['SpouseName']; }
        $PermanentAddress = Null;
        if($inputs['PermanentAddress']!='') {$PermanentAddress=$inputs['PermanentAddress']; }
        $PermanentPS = Null;
        if($inputs['PermanentPS']!='') {$PermanentPS=$inputs['PermanentPS']; }
        $PermanentPO = Null;
        if($inputs['PermanentPO']!='') {$PermanentPO=$inputs['PermanentPO']; }
        $PermanentDist = Null;
        if($inputs['PermanentDist']!='') {$PermanentDist=$inputs['PermanentDist']; }
        $PermanentCountryId = Null;
        if($inputs['PermanentCountryId']!='') {$PermanentCountryId=$inputs['PermanentCountryId']; }
        $PresentAddress = Null;
        if($inputs['PresentAddress']!='') {$PresentAddress=$inputs['PresentAddress']; }
        $PresentPS = Null;
        if($inputs['PresentPS']!='') {$PresentPS=$inputs['PresentPS']; }
        $PresentPO = Null;
        if($inputs['PresentPO']!='') {$PresentPO=$inputs['PresentPO']; }
        $PresentDist = Null;
        if($inputs['PresentDist']!='') {$PresentDist=$inputs['PresentDist']; }
        $PresentCountryId = Null;
        if($inputs['PresentCountryId']!='') {$PresentCountryId=$inputs['PresentCountryId']; }
        $exp = Null;
        if($inputs['exp']!='') {$exp=$inputs['exp']; }        
        $factoryName = Null;
        if($inputs['factoryName']!='') {$factoryName=$inputs['factoryName']; }
        $jobPost = Null;
        if($inputs['jobPost']!='') {$jobPost=$inputs['jobPost']; }
        $jobTime = Null;
        if($inputs['jobTime']!='') {$jobTime=$inputs['jobTime']; }
        $enrollPost = Null;
        if($inputs['enrollPost']!='') {$enrollPost=$inputs['enrollPost']; }        
        $labourClass = Null;
        if($inputs['labourClass']!='') {$labourClass=$inputs['labourClass']; }
        $jobGrade = Null;
        if($inputs['jobGrade']!='') {$jobGrade=$inputs['jobGrade']; }
        $salary = Null;
        if($inputs['salary']!='') {$salary=$inputs['salary']; }
        $gender = Null;
        if($inputs['gender']!='') {$gender=$inputs['gender']; }
        $religion = Null;
        if($inputs['religion']!='') {$religion=$inputs['religion']; }
        $nationality = Null;
        if($inputs['nationality']!='') {$nationality=$inputs['nationality']; }
        $maritualStatus = Null;
        if($inputs['maritualStatus']!='') {$maritualStatus=$inputs['maritualStatus']; }
        $bloodGroup = Null;
        if($inputs['bloodGroup']!='') {$bloodGroup=$inputs['bloodGroup']; }
        $weight = Null;
        if($inputs['weight']!='') {$weight=$inputs['weight']; }
        $height = Null;
        if($inputs['height']!='') {$height=$inputs['height']; }
        $bodyCapability = Null;
        if($inputs['bodyCapability']!='') {$bodyCapability=$inputs['bodyCapability']; }
        $identyMark = Null;
        if($inputs['identyMark']!='') {$identyMark=$inputs['identyMark']; }
        $mobile = Null;
        if($inputs['mobile']!='') {$mobile=$inputs['mobile']; }
        $email = Null;
        if($inputs['email']!='') {$email=$inputs['email']; }
        $emergencyContact = Null;
        if($inputs['emergencyContact']!='') {$emergencyContact=$inputs['emergencyContact']; }
        $noochild = Null;
        if($inputs['noochild']!='') {$noochild=$inputs['noochild']; }
        $rf1name = Null;
        if($inputs['rf1name']!='') {$rf1name=$inputs['rf1name']; }
        $rf1v = Null;
        if($inputs['rf1v']!='') {$rf1v=$inputs['rf1v']; }
        $rf1po = Null;
        if($inputs['rf1po']!='') {$rf1po=$inputs['rf1po']; }
        $rf1ps = Null;
        if($inputs['rf1ps']!='') {$rf1ps=$inputs['rf1ps']; }
        $rf1d = Null;
        if($inputs['rf1d']!='') {$rf1d=$inputs['rf1d']; }
        $rf1m = Null;
        if($inputs['rf1m']!='') {$rf1v=$inputs['rf1m']; }
        $rf2name = Null;
        if($inputs['rf2name']!='') {$rf2name=$inputs['rf2name']; }
        $rf2v = Null;
        if($inputs['rf2v']!='') {$rf2v=$inputs['rf2v']; }
        $rf2po = Null;
        if($inputs['rf2po']!='') {$rf2po=$inputs['rf2po']; }
        $rf2ps = Null;
        if($inputs['rf2ps']!='') {$rf2ps=$inputs['rf2ps']; }
        $rf2d = Null;
        if($inputs['rf2d']!='') {$rf2d=$inputs['rf2d']; }
        $rf2m = Null;
        if($inputs['rf2m']!='') {$rf2m=$inputs['rf2m']; }

        
        $bangla_info = [
            'name_bangla'           => $employeeName,
            'fathers_name_bangla'   => $FatherName,
            'mothers_name_bangla'   => $MotherName,
            'spouse_name_bangla'    => $SpouseName,
            'permanent_vill_bangla' => $PermanentAddress,
            'permanent_thana_bangla' => $PermanentPS,
            'permanent_post_bangla' => $PermanentPO,
            'permanent_dist_bangla' => $PermanentDist,           
            'present_vill_bangla' => $PresentAddress,
            'present_thana_bangla' => $PresentPS,
            'present_post_bangla' => $PresentPO,
            'present_dist_bangla' => $PresentDist,
            'experience_bangla' => $exp,
            'exp_factory_bangla' => $factoryName,
            'exp_designation_bangla' => $jobPost,
            'exp_year_bangla' => $jobTime,
            'designation_bangla' => $enrollPost,
            'labour_class' => $labourClass,
            'labour_grade' => $jobGrade,
            'salary_bangla' => $salary,
            //'' => $gender,
            'religion_bangla' => $religion,
            'nationality_bangla' => $nationality,
            'maritial_bangla' => $maritualStatus,
            'blood_bangla' => $bloodGroup,
            'weight' => $weight,
            'height' => $height,
            'body_capability' => $bodyCapability,
            'identification' => $identyMark,
            'phone_bangla' => $mobile,           
            //'' => $emergencyContact,
            'child_number_bangla' => $noochild,
            'intro_1_name' => $rf1name,
            'intro_1_vill' => $rf1v,
            'intro_1_post' => $rf1po,
            'intro_1_thana' => $rf1ps,
            'intro_1_dist' => $rf1d,
            'intro_1_phone' => $rf1m,
            'intro_2_name' => $rf2name,
            'intro_2_vill' => $rf2v,
            'intro_2_post' => $rf2po,
            'intro_2_thana' => $rf2ps,
            'intro_2_dist' => $rf2d,
            'intro_2_phone' => $rf2m,

        ];
         
          
        $user_info = $this->employee->table("employee_info")->where('id',$employee_id); //->fetch();
               
        if (isset($user_info)) { 
           // dd($user_info->update($bangla_info));            
            $user_info->update($bangla_info);
        }

        notification(['type' => 'success', 'message' => 'Updated Successfully']);
        return redirect('employee/edit/'.$employee_id);
    }
        
      

    public function punchCardEntry() {
        $heading = "Employee";
        $title = "Punch Card Entry";
        return view('employee/punch_card_form',compact('title','heading'));
    }

    /**
     * Punch card information updating
     *
     * @return text
     */

    public function punchCardUpdate() {
        $employee_punch_cards = json_decode($_GET['employee_punch_cards']);
        $employee_punch_update = 0;
        if(!empty($employee_punch_cards)) {
            foreach ($employee_punch_cards as $employee) {
                if(isset($employee->employee_id)) {
                    $data = [
                        'PunchCardNo' => $employee->card_no
                    ];
                    $employee_punch_update = $this->employee->table('employee_info',$employee->employee_id)->update($data);
                }
            }
            if ($employee_punch_update) {
                echo "Punch card updated successfully.";
            }
            else
                echo "There is an error. Try again later.";
        }
        else
            echo "Punch card updated successfully.";
    }

    /**
     * @param $inputs
     * @return Validator
     */
    public function validate_form_data($inputs): Validator
    {
        $v = new Validator($inputs);
        $v->rule('optional', ['NationalIDCardNo']);
        //$v->rule('in', 'NationalIDCardNo',['10','20']);
        $v->rule('email', 'EMail');
        $v->rule('optional', 'EmployeePhoto');
        $v->rule('optional', 'EmployeeSignature');

        //make sure we have no error
        if ($this->upload->fileExists('EmployeePhoto')) {
            $v->rule('in', 'EmployeePhoto.error', [0])->message('No image selected for {field}');
            $v->rule('in', 'EmployeePhoto.type', ['image/jpeg'])->message('Only jpg image is allowed for {field}.');
            $v->rule('max', 'EmployeePhoto.size', 300 * 1024)->message('Max size is 300kb for {field}.');
        }
        if ($this->upload->fileExists('EmployeeSignature')) {
            $v->rule('in', 'EmployeeSignature.error', [0])->message('No image selected for {field}');
            $v->rule('in', 'EmployeeSignature.type', ['image/jpeg'])->message('Only jpg image is allowed for {field}.');
            $v->rule('max', 'EmployeeSignature.size', 300 * 1024)->message('Max size is 300kb for {field}.');
        }
        return $v;
    }

    /**
     * @param $inputs
     * @return array
     */
    public function process_input_data_photo($inputs): array
    {
        $EmployeeCode = validation($inputs['EmployeeCode'] ?? null);
        if ($EmployeeCode == '' || is_null($EmployeeCode)) {
            $EmployeeCode = $this->getEmployeeCode();
        }
        $EmployeePhoto = $_FILES['EmployeePhoto'];
        $EmployeeSignature = $_FILES['EmployeeSignature'];



        $data_employee_info = [
            'EmployeeCode' => $EmployeeCode,
            
        ];
        echo ('Before In');
        //$upload = new Upload();
        $path = 'images/employee/';
        $nomineepath = 'images/nominee/';
        $signaturepath = 'images/signatur/';
        if ($this->upload->fileExists('EmployeePhoto')) {
            $photo_file_name = $EmployeeCode . '-' . 'p.jpg';
            $emPhoto = $this->upload->make('EmployeePhoto');
            $emPhoto->save(upload_path($path . $photo_file_name));
            // dd($photo_file_name);
            echo ('In');
        }
        if ($this->upload->fileExists('EmployeeSignature')) {
            $sign_file_name = $EmployeeCode . '-' . 's.jpg';
            $emSign = $this->upload->make('EmployeeSignature');
            $emSign->save(upload_path($signaturepath . $sign_file_name));
        }
        if ($this->upload->fileExists('NomineePhoto')) {
            $nominee_file_name = $EmployeeCode . '-' . 'n.jpg';
            $emNominee = $this->upload->make('NomineePhoto');
            $emNominee->save(upload_path($nomineepath . $nominee_file_name));
        }
        /*$photo_file_tmp = $_FILES['EmployeePhoto']['tmp_name'];
        $photo_file_name = $EmployeeCode.'-'.'photo.jpg';
        move_uploaded_file($photo_file_tmp,upload_path("images/employee/".$photo_file_name));*/
        if (isset($photo_file_name))
            $data_employee_info['EmployeePhoto'] = $photo_file_name;
        if (isset($sign_file_name))
            $data_employee_info['EmployeeSignature'] = $sign_file_name;
        if (isset($sign_file_name))
            $nominee_file_name['NomineePhoto'] = $nominee_file_name;    
        return array($EmployeeCode, $data_employee_info);
    }

    public function process_input_data($inputs): array
    {
        $EmployeeCode = validation($inputs['EmployeeCode'] ?? null);
        if ($EmployeeCode == '' || is_null($EmployeeCode)) {
            $EmployeeCode = $this->getEmployeeCode();
        }
        $NationalIDCardNo = validation($inputs['NationalIDCardNo'] ?? null);
        $EmployeeStatus = validation($inputs['EmployeeStatus'] ?? null);
        $PunchCardNo = validation($inputs['PunchCardNo'] ?? null);
        $BadgeNumber = validation($inputs['BadgeNumber'] ?? 0);
        $EmpType = validation($inputs['EmpType'] ?? 1);
        $Saluation = validation($inputs['Saluation'] ?? 1);
        //$EmployeeNature = validation($inputs['EmployeeNature'] ?? null);
        $EmployeeName = validation($inputs['EmployeeName'] ?? null);
        $FatherName = validation($inputs['FatherName'] ?? null);
        $MotherName = validation($inputs['MotherName'] ?? null);
        $SpouseName = validation($inputs['SpouseName'] ?? null);
        $DOB = date_conversion('Y-m-d', $inputs['DOB']);
        $Gender = $inputs['Gender'] ?? 1;
        $Religion = $inputs['Religion']??1;
        $MaritalStatus = $inputs['MaritalStatus']??1;
        $BloodGroup = validation($inputs['BloodGroup']??1);
        $Nationality = validation($inputs['Nationality'] ?? null);
        $Mobile = validation($inputs['Mobile'] ?? null);
        $EMail = validation($inputs['EMail'] ?? null);
        $RefAddress = validation($inputs['RefAddress'] ?? null);
        $identification = validation($inputs['identification'] ?? null);
        $name_bangla = validation($inputs['name_bangla'] ?? null);
        $fathers_name_bangla = validation($inputs['fathers_name_bangla'] ?? null);
        $mothers_name_bangla = validation($inputs['mothers_name_bangla'] ?? null);
        $spouse_name_bangla = validation($inputs['spouse_name_bangla'] ?? null);
        $permanent_address_bangla = validation($inputs['permanent_address_bangla'] ?? null);
        $present_address_bangla = validation($inputs['present_address_bangla'] ?? null);
        $noochild = validation($inputs['noochild'] ?? null);
        $weight = validation($inputs['weight'] ?? null);
        $height = validation($inputs['height'] ?? null);
        $bodyCapability = validation($inputs['bodyCapability'] ?? null);
        $rf1name = validation($inputs['rf1name'] ?? null);
        $rf1v = validation($inputs['rf1v'] ?? null);
        $rf1po = validation($inputs['rf1po'] ?? null);
        $rf1ps = validation($inputs['rf1ps'] ?? null);
        $rf1d = validation($inputs['rf1d'] ?? null);
        $rf1m = validation($inputs['rf1m'] ?? null);
        $rf2name = validation($inputs['rf2name'] ?? null);
        $rf2v = validation($inputs['rf2v'] ?? null);
        $rf2po = validation($inputs['rf2po'] ?? null);
        $rf2ps = validation($inputs['rf2ps'] ?? null);
        $rf2d = validation($inputs['rf2d'] ?? null);
        $rf2m = validation($inputs['rf2m'] ?? null);
        $EmployeePhoto = $_FILES['EmployeePhoto'];
        $EmployeeSignature = $_FILES['EmployeeSignature'];
        $OffDay = NULL;
        if($inputs['OffDay']!='') {$OffDay=$inputs['OffDay']; }
        if($BadgeNumber==''){
            $BadgeNumber = 0;
        }
        if($EmpType==''){
            $EmpType = 1;
        }
        if($Saluation==''){
            $Saluation = 1;
        }
        if($Gender==''){
            $Gender = 1;
        }
        if($Religion==''){
            $Religion = 1;
        }

        $data_employee_info = [
            'EmployeeCode' => $EmployeeCode,
            'EmployeeName' => $EmployeeName,
            'NationalIDCardNo' => $NationalIDCardNo,
            'EmployeeStatus' => $EmployeeStatus,
            'PunchCardNo' => $PunchCardNo,
            'BadgeNumber'=>$BadgeNumber,
            'EmpType' => $EmpType,
            'OffDay' => $OffDay,
            //'EmployeeNature' => $EmployeeNature,
            'Saluation' => $Saluation,
            'FatherName' => $FatherName,
            'MotherName' => $MotherName,
            'SpouseName' => $SpouseName,
            'DOB' => $DOB,
            'Gender' => $Gender,
            'Religion' => $Religion,
            'Nationality' => $Nationality,
            'BloodGroup' => $BloodGroup,
            'MaritalStatus' => $MaritalStatus,
            'Mobile' => $Mobile,
            'email' => $EMail,
            'RefAddress' => $RefAddress,
            'identification' => $identification,
            'child_number_bangla' => $noochild,
            'name_bangla' => $name_bangla,
            'fathers_name_bangla' => $fathers_name_bangla,
            'mothers_name_bangla' => $mothers_name_bangla,
            'spouse_name_bangla' => $spouse_name_bangla,
            'permanent_address_bangla' => $permanent_address_bangla,
            'present_address_bangla' => $present_address_bangla,
            'weight' => $weight,
            'height' => $height,
            'body_capability' => $bodyCapability,
            'intro_1_name' => $rf1name,
            'intro_1_vill' => $rf1v,
            'intro_1_post' => $rf1po,
            'intro_1_thana' => $rf1ps,
            'intro_1_dist' => $rf1d,
            'intro_1_phone' => $rf1m,
            'intro_2_name' => $rf2name,
            'intro_2_vill' => $rf2v,
            'intro_2_post' => $rf2po,
            'intro_2_thana' => $rf2ps,
            'intro_2_dist' => $rf2d,
            'intro_2_phone' => $rf2m,
            'CreatedBy' => user_id(),
            'CreatedAt' => date('Y-m-d H:i:s')
        ];

        //$upload = new Upload();
        $path = 'images/employee/';
        $nomineepath = 'images/nominee/';
        $signaturepath = 'images/signatur/';
        
        if ($this->upload->fileExists('EmployeePhoto')) {
            $photo_file_name = $EmployeeCode . '-' . 'p.jpg';
            $emPhoto = $this->upload->make('EmployeePhoto');
            $emPhoto->save(upload_path($path . $photo_file_name));
            // dd($emPhoto);
            // dd($photo_file_name);
        }
        if ($this->upload->fileExists('EmployeeSignature')) {
            $sign_file_name = $EmployeeCode . '-' . 's.jpg';
            $emSign = $this->upload->make('EmployeeSignature');
            $emSign->save(upload_path($signaturepath . $sign_file_name));
            // dd($sign_file_name);
        }
        /*$photo_file_tmp = $_FILES['EmployeePhoto']['tmp_name'];
        $photo_file_name = $EmployeeCode.'-'.'photo.jpg';
        move_uploaded_file($photo_file_tmp,upload_path("images/employee/".$photo_file_name));*/
        if (isset($photo_file_name))
            $data_employee_info['EmployeePhoto'] = $photo_file_name;
        if (isset($sign_file_name))
            $data_employee_info['EmployeeSignature'] = $sign_file_name;    
        return array($EmployeeCode, $data_employee_info);
    }

    /**
     * @param array $inputs
     * @param string $EmployeeID
     * @param boolean $is_address_same
     * @return array
     */
    public function process_address_input_data($inputs, $EmployeeID, $is_address_same): array
    {
        $PermanentAddress = validation($inputs['PermanentAddress'] ?? null);
        $PermanentStateId = validation($inputs['PermanentStateId'] ?? null);
        $PermanentZipCode = validation($inputs['PermanentZipCode'] ?? null);
        $PermanentCity = validation($inputs['PermanentCity'] ?? null);
        //$PermanentCountryId = $inputs['PermanentCountryId'];

        $data[] = [
            'EmployeeID' => $EmployeeID,
            'Address' => $PermanentAddress,
            // 'local_address' => $PermanentAddressLocal,
            'City' => $PermanentCity,
            'StateId' => $PermanentStateId,
            'ZipCode' => $PermanentZipCode,
            'CountryId' => 1,
            'is_address_same' => $is_address_same,
            'Type' => 1
        ];

        if (!$is_address_same) {
            $PresentAddress = validation($inputs['PresentAddress'] ?? null);
            $PresentStateId = validation($inputs['PresentStateId'] ?? null);
            $PresentZipCode = validation($inputs['PresentZipCode'] ?? null);
            $PresentCity = validation($inputs['PresentCity'] ?? null);
            //$PresentCountryId = validation($inputs['PresentCountryId'] ?? null);
            $data[] = [
                'EmployeeID' => $EmployeeID,
                'Address' => $PresentAddress,
                // 'local_address' => $PresentAddressLocal,
                'City' => $PresentCity,
                'StateId' => $PresentStateId,
                'ZipCode' => $PresentZipCode,
                'CountryId' => 1,
                'is_address_same' => $is_address_same,
                'Type' => 2
            ];
        } else {
            $data[1] = $data[0];
            $data[1]['Type'] = 2;
        }
        return $data;
    }

    /**
     * @param $EmployeeID
     * @param array $data
     * @param int $is_address_same
     */
    public function create_or_update_address($EmployeeID, array $data, int $is_address_same): void
    {
        $address_info = $this->employee->table("address_info")->where("EmployeeID", $EmployeeID)->where("Type", '1')->fetch();
        if ($address_info) {
            $address_info->update($data[0]);
            if (!$is_address_same) {
                $address_info = $this->employee->table("address_info")->where("EmployeeID", $EmployeeID)->where("Type", '2')->fetch();
                if ($address_info) {
                    $address_info->update($data[1]);
                } else {
                    $this->employee->table("address_info")->insert($data[1], 'prepared');
                }
            } else {
                $address_info = $this->employee->table("address_info")->where("EmployeeID", $EmployeeID)->where("Type", '2')->fetch();
                if ($address_info) {
                    $address_info->update($data[1]);
                } else {
                    $this->employee->table("address_info")->insert($data[1], 'prepared');
                }
            }
        } else {
            $this->employee->table("address_info")->insert($data, 'prepared');
        }
    }

    /**
     * @return array
     */
    public function country_distict_list(): array
    {
        $country_array = $this->employee->table("settings_master")->where('type_name', 'country')->fetchAll();
        $countries = [];
        foreach ($country_array as $item) {
            $countries[$item->id] = $item->name;
        }
        $district_array = $this->employee->table("districts")->where('country_id', 2)->fetchAll();
        $districts = [];
        foreach ($district_array as $item) {
            $districts[$item->id] = $item->name;
        }
        return array($countries, $districts);
    }
    public function sync_badgenumber(){
        $query = "SELECT USERID,BADGENUMBER,NAME FROM USERINFO";
        $emp_info = $this->sql_server->query($query)->fetchAll();
        if(!empty($emp_info)){
            foreach($emp_info as $emp){
                $update_badgenumber = $this->employee->table("employee_info")->where(['EmployeeCode'=>$emp['NAME']]);
                $update_badgenumber = $update_badgenumber->update(array('BadgeNumber'=>$emp['BADGENUMBER']));
            }
        }
        if($update_badgenumber){
            $msg = "Success";
        }else{
            $msg = 'Failed';
        }
        return view('employee/badgenumber',compact('msg'));
        //echo '<pre>';print_r($emp_info);
    }
}
