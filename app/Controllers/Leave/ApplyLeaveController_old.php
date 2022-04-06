<?php
    namespace App\Controllers\Leave;

use App\Controllers\Controller;
use App\library\SSP;
use App\Models\Leave;
use Cassandra\Date;
use Vendor\Valitron\Validator;

class ApplyLeaveController extends Controller {
    private $leave;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->leave = new Leave();
    }

    /**
     * Display a listing of the resource.
     *
     * @return view
     */
    public function index()
    {
        $heading = "Leave";
        $title = "Apply Leave";
        $employee_leaves = $this->leave->query("SELECT ei.id,ei.EmployeeCode,EmployeeName,PunchCardNo FROM employee_info ei 
            INNER JOIN emp_leave_transaction lta ON ei.id=lta.EmployeeID WHERE IsNull(IsApproved)"
        )->fetchAll();
        return view('apply_leave/index',compact('title','heading','employee_leaves'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return view
     */
    public function create()
    {
        $heading = "Leave";
        $title = "Apply Leave";
        return view('apply_leave/create',compact('title','heading'));
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
        // dd($inputs);
        $v = new Validator($inputs);
        $v->rule('required', ['FromDate','ToDate','LeaveDays']);
        $id = $inputs['id'];
        if($v->validate()) {
            $EmployeeCode = validation($inputs['EmployeeCode'] ?? null);
            $LeaveType = validation($inputs['LeaveType'] ?? null);
            $FromDate = date_conversion('Y-m-d',$inputs['FromDate']);
            $ToDate = date_conversion('Y-m-d',$inputs['ToDate']);
            $LeaveDays = validation($inputs['LeaveDays'] ?? null);
            //$LeaveReason = validation($inputs['LeaveReason'] ?? null);
            //$LeaveAvailPlace = validation($inputs['LeaveAvailPlace'] ?? null);
            $IsPreApproved = $inputs['IsPreApproved'] ?? null;
            $IsPostApproved = $inputs['IsPreApproved'] ?? null;
            $emergency_contact_no = NULL;
            if($inputs['emergency_contact_no']!='') {$emergency_contact_no=$inputs['emergency_contact_no']; }
            $LeaveAvailPlace = NULL;
            if($inputs['LeaveAvailPlace']!='') {$LeaveAvailPlace=$inputs['LeaveAvailPlace']; }
            $LeaveReason = NULL;
            if($inputs['LeaveReason']!='') {$LeaveReason=$inputs['LeaveReason']; }
            $LeavePolicyID = $this->leave->table('leave_policy_master')->where('LeaveType',$LeaveType)->fetch()->id;
            $is_leave_availed = $this->check_leave_availability($id,$FromDate,$ToDate,$LeaveDays,$LeavePolicyID);
            if ($is_leave_availed) {
                notification(['type'=>'danger', 'message'=>'Leave exist/no balance at given dates.']);
                return redirect('apply_leave/edit/'.$id);
            }

            $leave_form = [
                'EmployeeID' => $id,
                'LeavePolicyID' => $LeavePolicyID,
                'FromDate' => $FromDate,
                'ToDate' => $ToDate,
                'LeaveDays' => $LeaveDays,
                'LeaveReason' => $LeaveReason,
                'LeaveAvailPlace' => $LeaveAvailPlace,
                'IsPreApproved' => $IsPostApproved,
                'IsPostApproved' => $IsPreApproved,
                'emergency_contact_no' => $emergency_contact_no,
                'TransactionDate' => date('Y-m-d H:i:s'),
                'AddedBy' => user_id(),
                'DateAdded' => date('Y-m-d')
            ];
            //dd($leave_form);
            $rs = $this->leave->table('emp_leave_transaction')->insert($leave_form, 'prepared');
            if($rs) {
                notification(['type'=>'success', 'message'=>'Apply Leave Success.']);
                return redirect('apply_leave/edit/'.$id);
            }
            else {
                notification(['type'=>'danger', 'message'=>'Failed.']);
                $rs->errorInfo();
            }
        } else {
            return redirect('apply_leave/edit/'.$id);
            //return view('apply_leave/edit',['title'=>'Apply Leave','errors'=>$v->errors()]);
        }
    }
    public function multiple_apply_leave()
    {
        $heading = "Leave";
        $title = "Multiple Apply Leave";
        //dd($title);
        $leave_types = $this->leave->table('leave_type')->fetchAll();
        foreach ($leave_types as $row) {
            $leave_type[$row->LeaveTypeName] = $row->LeaveTypeName;
        }
        if(isset($_POST['employee_id'])){
            $employee_id = json_decode($_POST['employee_id']) ?? '';
            $employee_name = json_decode($_POST['employee_name']) ?? '';
            $employee_code = json_decode($_POST['employee_code']) ?? '';
            $section = json_decode($_POST['section']) ?? '';
            //dd($employee_id);
            $data = ''; 
            for($i=0;$i<count($employee_id);$i++){
                $data .= '<tr>
                        <td>
                            <input type="hidden" autocomplete="off" class="form-control form-control-sm EmployeeID" name="employee_id" value="'.$employee_id[$i].'">
                            <input type="text" autocomplete="off" class="form-control form-control-sm" name="employee_code" value="'.$employee_code[$i].'" readonly>
                        </td>
                        <td><input type="text" class="form-control form-control-sm" name="employee_name" value="'.$employee_name[$i].'"></td>
                        <td>'.form_select('LeaveType',$leave_type,null,'class="form-control form-control-sm LeaveType" ').'</td>
                        <td>'.form_input('FromDate','text',old('FromDate'),'class="form-control form-control-sm form_date FromDate"  autocomplete="off"').'</td>
                        <td>'.form_input('ToDate','text',old('ToDate'),'class="form-control form-control-sm form_date ToDate" autocomplete="off" ').'</td>
                        <td>'.form_input('LeaveDays','number',old('LeaveDays'),'class="form-control form-control-sm LeaveDays" ').'</td>
                    </tr>';
            }
            echo ($data);
        }else{
            return view('reports/leave/multiple_apply_leave',compact('title','heading'));
        }
        
    }
    public function multiple_leave_store()
    {
        $inputs = $_POST;
        dd($inputs);
        $v = new Validator($inputs);
        $v->rule('required', ['EmployeeID','FromDate','ToDate','LeaveDays']);
        if($v->validate()) {
            $EmployeeID = json_decode($inputs['EmployeeID'] ?? null);
            $LeaveType = json_decode($inputs['LeaveType'] ?? null);
            $FromDate = json_decode($inputs['FromDate']);
            $ToDate = json_decode($inputs['ToDate']);
            $LeaveDays = json_decode($inputs['LeaveDays'] ?? null);
            for($i=0;$i<count($EmployeeID);$i++){                
                $LeavePolicyID = $this->leave->table('leave_policy_master')->where('LeaveType',$LeaveType[$i])->fetch()->id;
                $is_leave_availed = $this->check_leave_availability($EmployeeID[$i],date_conversion('Y-m-d',$FromDate[$i]),date_conversion('Y-m-d',$ToDate[$i]),$LeaveDays[$i],$LeavePolicyID);
                if ($is_leave_availed) {
                }else{
                    $leave_form[] = [
                        'EmployeeID' => $EmployeeID[$i],
                        'LeavePolicyID' => $LeavePolicyID,
                        'FromDate' => date_conversion('Y-m-d',$FromDate[$i]),
                        'ToDate' => date_conversion('Y-m-d',$ToDate[$i]),
                        'LeaveDays' => $LeaveDays[$i],
                        'LeaveReason' => NULL,
                        'LeaveAvailPlace' => NULL,
                        'IsPreApproved' => 0,
                        'IsPostApproved' => 1,
                        'emergency_contact_no' => NULL,
                        'TransactionDate' => date('Y-m-d H:i:s'),
                        'AddedBy' => user_id(),
                        'DateAdded' => date('Y-m-d')
                    ];
                }
            } 
            $rs = $this->leave->table('emp_leave_transaction')->insert($leave_form,'batch');
            if($rs) {
                echo "<h4 class='text text-info'>Apply Leave Success.</h4>";
            }
            else {
                echo "<h4 class='text text-info'>Failed.</h4>";
            }
        } 
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return View
     */
    public function edit($employee_id = null)
    {
        $heading = "Leave";
        $title = "Apply Leave";
        $employee_info = $this->leave->table("employee_info",$employee_id);
        $leave_types = $this->leave->table('leave_type')->fetchAll();
        foreach ($leave_types as $row) {
            $leave_type[$row->LeaveTypeName] = $row->LeaveTypeName;
        }

        $leave_year = $this->leave->table('company',1);//->fetch();
        $from_date = $leave_year->from_date ?? date('Y-01-01');
        $to_date = $leave_year->to_date ?? date('Y-12-31');
        $leave_approved = $this->leave->table('emp_leave_transaction')->where('EmployeeID',$employee_info->id)->where('IsApproved',1)->where('YEAR(FromDate)='.date_conversion('Y',$from_date))->fetchAll();
        $leave_policy = $this->leave->table('leave_policy_master')->fetchAll();
        foreach ($leave_policy as $row) {
            $policy[$row->id] = [
                'PolicyDescription' => $row->PolicyDescription,
                'LeaveType' => $row->LeaveType
            ];
        }

        $sql = 'SELECT lpd.*,availedDays,IF(LeaveType="EL",SUM(elm.OpeningBalance),0) AS OpeningBalance FROM (
				SELECT EmployeeID,ald.LeavePolicyID,PolicyDescription,LeaveType,LeaveDays as allocatedDays 
				FROM leave_policy_master lpm INNER JOIN allocated_leave_days ald ON ald.LeavePolicyID=lpm.id 
				WHERE ald.EmployeeID="'.$employee_info->id.'"
			)lpd LEFT JOIN(
				SELECT LeavePolicyID,SUM(LeaveDays) AS availedDays FROM emp_leave_transaction WHERE EmployeeID="'.$employee_info->id.'"
			    AND IsApproved=1 AND FromDate>="'.$from_date.'" AND ToDate<="'.$to_date.'" GROUP BY(LeavePolicyID)
			) lappr ON lpd.LeavePolicyID=lappr.LeavePolicyID
			LEFT JOIN employee_leave_master elm ON lpd.EmployeeID=elm.EmployeeID WHERE elm.EmployeeID="'.$employee_info->id.'" GROUP BY(LeavePolicyID)';
        //myLog($sql);
        $leave_allocation_dtls = $this->leave->query($sql)->fetchAll();
        //$employee_select2 = $employee_info->EmployeeCode.'-'.$employee_info->EmployeeName.'-'.$employee_info->PunchCardNo;
        //dump($leave_allocation_dtls);
        return view('apply_leave/edit',compact('title','heading','employee_info','leave_type','leave_approved','policy','leave_allocation_dtls','leave_year'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return View
     */
    public function show($employee_id = null)
    {
        $heading = "Leave";
        $title = "Leave Approval";
        $employee_info = $this->leave->table("employee_info", $employee_id);
        $leave_applied = $this->leave->table('emp_leave_transaction')->where('EmployeeID', $employee_info->id)->where('IsApproved', null)->fetch();

        $leave_year = $this->leave->table('company',1);//->fetch();
        $from_date = $leave_year->from_date ?? date('Y-01-01');
        $to_date = $leave_year->to_date ?? date('Y-12-31');
        $leave_applied_dtl = [];
        if ($leave_applied) {
            $leave_applied_dtl = $this->leave->query('SELECT lpd.*, availedDays FROM (
                SELECT lpm.LeavePolicyID,PolicyDescription,LeaveType,LeaveDays as allocatedDays FROM leave_policy_master lpm 
                INNER JOIN allocated_leave_days ald ON ald.LeavePolicyID=lpm.id 
                WHERE ald.EmployeeID="' . $employee_info->id . '" AND ald.LeavePolicyID="' . $leave_applied->LeavePolicyID . '") lpd 
                LEFT JOIN(
                    SELECT LeavePolicyID,SUM(LeaveDays) AS availedDays FROM emp_leave_transaction WHERE EmployeeID="' . $employee_info->ID . '" AND LeavePolicyID="' . $leave_applied->LeavePolicyID . '"
                     AND IsApproved=null AND FromDate>="'.$from_date.'" AND ToDate<="'.$to_date.'" GROUP BY(LeavePolicyID)
                ) lappr ON lpd.LeavePolicyID=lappr.LeavePolicyID
                GROUP BY(LeavePolicyID)')->fetchAll();
        }

        $user = $this->leave->table('users',$leave_applied['AddedBy']);
        $employee_leaves = $this->leave->query("SELECT ei.id,ei.EmployeeCode,EmployeeName,PunchCardNo FROM employee_info ei INNER JOIN emp_leave_transaction lta
            ON ei.id=lta.EmployeeID WHERE IsNull(IsApproved)")->fetchAll();
        //dd($employee_leaves);
        return view('apply_leave/show',compact('title','heading','employee_info','leave_applied','leave_applied_dtl','user','employee_leaves'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  leaveId
     * @return View
     */
    public function update($leave_applied_id=null)
    {
        $inputs = $_POST;
        $leave_applied = $this->leave->table('emp_leave_transaction',$leave_applied_id);
        if (isset($inputs['save'])) {
            $leave_applied->update(['IsApproved'=>1,'ApprovedBy' => user_id(),'ApprovedDate'=>date('Y-m-d H:i:s')]);
        }
        else {
            $leave_applied->delete();
        }
        notification(['type'=>'success', 'message'=>'Success']);
        return redirect('apply_leave/edit/'.$inputs['id']);
        //return redirect('apply_leave');
    }

    /**
     * Apply leave form
     */
    public function apply_leave() {
        $heading = "Leave";
        $title = "Apply Leave";
        return view('leave/apply_leave',compact('title','heading'));
    }

    private function check_leave_availability($id,$FromDate,$ToDate,$LeaveDays,$LeavePolicyID)//Date
    {
//echo $id.'-d->'.$FromDate.'-->'.$ToDate.'-->'.$LeaveDays.'-->'.$LeavePolicyID;exit;
       if ($this->leave->leave_exist_on_dates($FromDate, $ToDate, $id))
           return true;
       if ($this->has_leave_balance($id,$FromDate,$ToDate,$LeaveDays,$LeavePolicyID))
           return true;
       return false;
    }

    private function has_leave_balance($id,$FromDate,$ToDate,$LeaveDays,$LeavePolicyID)
    {
        $sql = 'SELECT lpd.*,availedDays,IF(LeaveType="EL",SUM(elm.OpeningBalance),0) AS OpeningBalance FROM (
    				SELECT EmployeeID,ald.LeavePolicyID,PolicyDescription,LeaveType,LeaveDays as allocatedDays 
	    			FROM leave_policy_master lpm 
		    		INNER JOIN allocated_leave_days ald ON ald.LeavePolicyID=lpm.id 
			    	WHERE ald.EmployeeID="'.$id.'" AND ald.LeavePolicyID="'.$LeavePolicyID.'"
			    )lpd LEFT JOIN(
				    SELECT LeavePolicyID,SUM(LeaveDays) AS availedDays FROM emp_leave_transaction WHERE EmployeeID="'.$id.'"
			        AND IsApproved=1 AND FromDate>="'.$FromDate.'" AND ToDate<="'.$ToDate.'" GROUP BY(LeavePolicyID)
			    ) lappr ON lpd.LeavePolicyID=lappr.LeavePolicyID
			    LEFT JOIN employee_leave_master elm ON lpd.EmployeeID=elm.EmployeeID WHERE elm.EmployeeID="'.$id.'"';

        $leave_allocation_dtls = $this->leave->query($sql)->fetch();
        $bal = $leave_allocation_dtls['allocatedDays']-$leave_allocation_dtls['availedDays'];
        if ($bal >= $LeaveDays)
            return false;

        return true;
    }
    
    public function absent()
    {
        $heading = "Leave";
        $title = "Employee Absent";
        $employee_absent = $this->leave->query("SELECT ei.id,ei.EmployeeCode,EmployeeName,PunchCardNo FROM employee_info ei 
            INNER JOIN emp_absent_transaction eat ON ei.id=eat.EmployeeID WHERE isNULL(IsApproved)"
        )->fetchAll();
        //dd($employee_absent);
        return view('absent/index',compact('title','heading','employee_absent'));
    }

    
    public function absentCreate()
    {
        $heading = "Leave";
        $title = "Employee Absent";
        return view('absent/create',compact('title','heading'));
    }
    public function absentStore()
    {
        $inputs = $_POST;
        //dump($inputs);
        $v = new Validator($inputs);
        $v->rule('required', ['FromDate','ToDate','AbsentDays']);
        $id = $inputs['id'];
        if($v->validate()) {
            $EmployeeCode = validation($inputs['EmployeeCode'] ?? null);
            $FromDate = date_conversion('Y-m-d',$inputs['FromDate']);
            $ToDate = date_conversion('Y-m-d',$inputs['ToDate']);
            $AbsentDays = validation($inputs['AbsentDays'] ?? null);
            $AbsentReason = validation($inputs['AbsentReason'] ?? null);
            $IsPreApproved = $inputs['IsPreApproved'] ?? '';
            $IsPostApproved = $inputs['IsPreApproved'] ?? '';

            $absent_form = [
                'EmployeeID' => $id,
                'TransactionDate' => date('Y-m-d H:i:s'),
                'FromDate' => $FromDate,
                'ToDate' => $ToDate,
                'AbsentDays' => $AbsentDays,
                'AbsentReason' => $AbsentReason,
                'AddedBy' => user_id(),
                'DateAdded' => date('Y-m-d')
            ];
            
            $rs = $this->leave->table('emp_absent_transaction')->insert($absent_form, 'prepared');
            if($rs) {
                notification(['type'=>'success', 'message'=>'Absent Entry Success.']);
                return redirect('absent/edit/'.$id);
            }
            else {
                notification(['type'=>'danger', 'message'=>'Failed.']);
                $rs->errorInfo();
            }
        } else {
            return redirect('absent/edit/'.$id);
            //return view('apply_leave/edit',['title'=>'Apply Leave','errors'=>$v->errors()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return View
     */
    public function absentEdit($employee_id = null)
    {
        $heading = "Employee Absent";
        $title = "Employee Absent";
        $employee_info = $this->leave->table("employee_info",$employee_id);

        $absent_year = $this->leave->table('company',1);//->fetch();
        $from_date = $leave_year->from_date ?? date('Y-01-01');
        $to_date = $leave_year->to_date ?? date('Y-12-31');
        $absent_approved = $this->leave->table('emp_absent_transaction')->where('EmployeeID',$employee_info->id)->where('IsApproved',1)->where('YEAR(FromDate)='.date_conversion('Y',$from_date))->fetchAll();
        

        $sql = 'SELECT eat.FromDate,eat.ToDate,eat.AbsentDays,eat.AbsentReason,eat.IsApproved,eat.EmployeeID,eat.TransactionDate FROM emp_absent_transaction eat
                INNER JOIN employee_info e ON e.id=eat.EmployeeID
                WHERE eat.EmployeeID="'.$employee_info->id.'"
			    AND eat.IsApproved=1 AND eat.FromDate>="'.$from_date.'" AND eat.ToDate<="'.$to_date.'" 
			';
        //myLog($sql);
        $absent_dtls = $this->leave->query($sql)->fetchAll();
        //$employee_select2 = $employee_info->EmployeeCode.'-'.$employee_info->EmployeeName.'-'.$employee_info->PunchCardNo;
        //dump($absent_dtls);
        return view('absent/edit',compact('title','heading','employee_info','absent_approved','absent_dtls','absent_year'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return View
     */
    public function absentShow($employee_id = null)
    {
        $heading = "Leave";
        $title = "Employee Absent";
        $employee_info = $this->leave->table("employee_info", $employee_id);
        $absent_applied = $this->leave->table('emp_absent_transaction')->where('EmployeeID', $employee_info->id)->where('IsApproved', null)->fetch();

        $leave_year = $this->leave->table('company',1);//->fetch();
        $from_date = $leave_year->from_date ?? date('Y-01-01');
        $to_date = $leave_year->to_date ?? date('Y-12-31');

        

        $user = $this->leave->table('users',$absent_applied['AddedBy']);
        $employee_absent = $this->leave->query("SELECT ei.id,ei.EmployeeCode,EmployeeName,PunchCardNo FROM employee_info ei INNER JOIN emp_absent_transaction eat
            ON ei.id=eat.EmployeeID WHERE isNULL(IsApproved)")->fetchAll();
        return view('absent/show',compact('title','heading','employee_info','absent_applied','user','employee_absent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  leaveId
     * @return View
     */
    public function absentUpdate($absent_id=null)
    {   //echo $absent_id;exit;
        $inputs = $_POST;
        $absent_applied = $this->leave->table('emp_absent_transaction',$absent_id);
        if (isset($inputs['save'])) {
            $absent_applied->update(['IsApproved'=>1,'ApprovedBy' => user_id(),'ApprovedDate'=>date('Y-m-d H:i:s')]);
        }
        else {
            $absent_applied->delete();
        }
        notification(['type'=>'success', 'message'=>'Success']);
        return redirect('absent/edit/'.$absent_id);
        //return redirect('apply_leave');
    }
}
