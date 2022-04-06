<?php

namespace App\Controllers;

use App\Models\Calendar;
use App\Models\Attendance;
use Vendor\Valitron\Validator;
use App\library\Upload;
use App\library\SSP;

class CalendarController extends Controller
{
    private $calendar;
    private $attendance;
    //testing git
    //working

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->calendar = new Calendar();
        $this->attendance = new Attendance();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $heading = "Calendar";
        $title = "Calendar [Holiday]";
        $shifts = $this->calendar->table("shift_plan")->select('id','ShiftID','Alais')->fetchAll();
        $attendance_day_status = $this->calendar->table('attendance_day_status')->where('id',[5,6])->fetchAll();
        $day_status = [];
        foreach ($attendance_day_status as $status) {
            $day_status[$status['id']] = $status['DayStatusName'];
        }
        return view('calendar/create',compact('title','heading','shifts','day_status'));
    }

    /**
     * Get employee_code,shift id and dates for making daily attendance information
     *
     */
    public function employee_information() {//dd($_POST);exit;
        $inputs = $_POST;

        $employee_id = json_decode($inputs['employee_id'] ?? null);
        $shiftID = validation($inputs['shiftID'] ?? 0);
        $day_status = validation($inputs['day_status'] ?? '');
        $remarks = validation($inputs['remarks'] ?? '');
        $roaster = validation($inputs['roaster'] ?? 0);
        $data = 'No data found to process.';
        $attendance_day_status = $this->calendar->table('attendance_day_status')->where('id',[5,6])->fetchAll();
        $attn_day_status = [];
        foreach ($attendance_day_status as $status) {
            $attn_day_status[$status['DayStatusName']] = $status['id'];
        }
        //dd($shiftID);exit;
        if(!is_array($employee_id)) // i think no needs this, test and remove later
            $employee_id = [$employee_id];
        $dates = $inputs['dates'] ?? [];
        if(!empty($employee_id) && !empty($dates)) {
            if(!empty($roaster)){   
                //$employee_data = $this->calendar->getRoasterEmployeeByID($employee_id,$dates);             
                if($shiftID[0] == "all") {
                    $employee_data = $this->calendar->getRoasterEmployeeByID($employee_id,$dates);
                } else {
                    $employee_data = $this->calendar->getRoasterEmployeeData($employee_id,$dates,$shiftID);
                }  
            }else{
                if($shiftID[0] == "all") {
                    $employee_data = $this->calendar->getEmployeeByID($employee_id);
                } else {
                    $employee_data = $this->calendar->getEmployeeData($employee_id,$shiftID);
                }                
            }
            $employee_data = $employee_data->fetchAll();

            //dd($employee_data);
            if(!empty($employee_data)>0) {
                $data = '';
                foreach ($employee_data as $row) {
                    if($shiftID[0] == "all") {
                        $d_status = $day_status[0];
                    }
                    else {
                        $d_status = $day_status[0];//$day_status[$transform_shift[$row['ShiftID']]];
                    }
                    for ($i=0; $i<count($dates); $i++) {
                        $work_date = $dates[$i]; //date('Y-m-d',strtotime($i));
                        $data .= '<tr>
                            <td>'.$row['EmployeeCode'].'</td>
                            <td>'.$row['PunchCardNo'].'</td>
                            <td>'.$row['EmployeeName'].'</td>
                            <td>'.$work_date.'</td>
                            <td>'.$row['ShiftID'].'</td>
                            <td>'.$row['Alais'].'</td>
                            <td>'.$d_status.'</td>
                            <td></td>
                            <td>'.$remarks.'</td>
                            <td>
                                <input type="hidden" class="EmployeeID" name="EmployeeID[]" value="'.$row['id'].'">
                                <input type="hidden" class="EmployeeCode" name="EmployeeCode[]" value="'.$row['EmployeeCode'].'">
                                <input type="hidden" class="WorkOffDate" name="WorkOffDate[]" value="'.$work_date.'"> 
                                <input type="hidden" class="ShiftID" name="ShiftID[]" value="'.$row['ShiftID'].'">
                                <input type="hidden" class="ShiftType" name="ShiftType[]" value="'.$row['ShiftType'].'"> 
                                <input type="hidden" class="DayType" name="DayType[]" value="'.$attn_day_status[$d_status].'"> 
                                <input type="hidden" class="Remarks" name="Remarks[]" value="'.$remarks.'">
                            </td>
                        </tr>';
                    }
                }
            }
        }
        echo ($data);
    }

    /**
     * store calendar data
     *
     * @return status
     */
    public function save_calendar() {
        $inputs = $_POST;
        $EmployeeID = json_decode($inputs['EmployeeID']);
        $EmployeeCode = json_decode($inputs['EmployeeCode']);
        $WorkOffDate = json_decode($inputs['WorkOffDate']);
        $ShiftID = json_decode($inputs['ShiftID']);
        $ShiftType = json_decode($inputs['ShiftType']);
        $DayType = json_decode($inputs['DayType']);
        $Remarks = $inputs['Remarks'];

        if (!empty($inputs)) {
            $calendar_data = [];
            for ( $i = 0; $i < count($EmployeeID); $i++ ) {
                $employee_code = $EmployeeCode[$i];
                $employee_id = $EmployeeID[$i];
                $work_date = $WorkOffDate[$i];
                $exist_calendar_data = $this->calendar->table('workoff_calendar')->where('EmployeeID',$employee_id)->where('WorkOffDate',$work_date)->count();
                if(!$exist_calendar_data) {
                    $calendar_data[] = [
                        'EmployeeID' => $employee_id,
                        'WorkOffDate' => $work_date,
                        'WorkDate' => $work_date,
                        'DayType' => $DayType[$i],
                        'Remarks' => $Remarks,
                        'AddedBy' => user_id(),
                        'DateAdded' => date('Y-m-d H:i:s')
                    ];
                }
            }

            if(!empty($calendar_data)) {
                $this->calendar->table('workoff_calendar')->insert($calendar_data,'batch');
                echo "<h4 class='text text-info'>Inserted Successfully.</h4>";
            }
            else {
                echo "<h4 class='text text-danger'>Data already processed.</h4>";
            }
        }
        else
            echo "<h4 class='text text-danger'>There is no data.</h4>";
    }
    public function calenderSet(){
        $heading = "Calender Set";
        $employee_code = '';
        $title = "Calender Set";
        //echo 'sf';
        return view('calendar/calender_set',compact('title','heading','employee_code'));
    }
    public function calenderSetStore(){
        $inputs = $_POST;
        $FormDate = validation($inputs['FormDate'] ?? null);
        $ToDate = validation($inputs['ToDate'] ?? null);
        $EmployeeCode = validation($inputs['EmployeeCode'] ?? null);
        $FromDay = explode('-',$FormDate);
        $ToDay = explode('-',$ToDate);
        $num_of_days = cal_days_in_month(CAL_GREGORIAN, $FromDay[1], $FromDay[2]);
        if($FromDay[0]==26 && $ToDay[0]==25 && $FromDay[1]!=$ToDay[1]){
            $delete_from = $FromDay[2]."-".$FromDay[1]."-".$FromDay[0];
            $delete_to = $ToDay[2]."-".$ToDay[1]."-".$ToDay[0];
            $Where = "WorkDate BETWEEN '".$delete_from."' AND '".$delete_to."' ";
            $this->attendance->table('employee_attn_month')->where($Where)->delete();
            //dd($this->attendance->table('employee_attn_month')->where($Where)->delete());
            $startday = $FromDay[0];
            for($i=0;$i<=($num_of_days-$FromDay[0]);$i++){
                $emp_attn_data [] = [
                    //'EmployeeID' => $employee['id'],
                    'WorkDate' => $FromDay[2].'-'.$FromDay[1].'-'.$startday,
                ];
                $startday += 1;
            }
            for($i=1;$i<=$ToDay[0];$i++){
                $startday = $i;
                if($startday<=9){
                    $emp_attn_data [] = [
                        //'EmployeeID' => $employee['id'],
                        'WorkDate' => $ToDay[2].'-'.$ToDay[1].'-0'.$startday,
                    ];
                }else{
                    $emp_attn_data [] = [
                        //'EmployeeID' => $employee['id'],
                        'WorkDate' => $ToDay[2].'-'.$ToDay[1].'-'.$startday,
                    ];
                }                
                $startday += 1;
            }
        }else{
            $data = 'Failed';
        }
        if(!empty($emp_attn_data)){
            $this->attendance->table('employee_attn_month')->insert($emp_attn_data,'batch');
            $data = 'Success';
        }
        echo ($data);
    }
    public function create_for_abco()
    {
        $heading = "Calendar";
        $title = "Calendar [Holiday]";
        $shifts = $this->calendar->table("shift_plan")->select('id','ShiftID','Alais')->fetchAll();
        $attendance_day_status = $this->calendar->table('attendance_day_status')->where('id',[5,6])->fetchAll();
        $day_status = [];
        foreach ($attendance_day_status as $status) {
            $day_status[$status['id']] = $status['DayStatusName'];
        }
        return view('calendar/create_for_abco',compact('title','heading','shifts','day_status'));
    }
    public function save_calendar_for_abco() {
        $inputs = $_POST;
        $WorkOffDate = json_decode($inputs['WorkOffDate']);
        $DayType = json_decode($inputs['DayStatus']);
        $Remarks = $inputs['Remarks'];

        if (!empty($inputs)) {
            $calendar_data = [];
            for ( $i = 0; $i < count($WorkOffDate); $i++ ) {
                $work_date = $WorkOffDate[$i];
                $exist_calendar_data = $this->calendar->table('workoff_calendar')->where('WorkOffDate',$work_date)->count();
                if(!$exist_calendar_data) {
                    $calendar_data[] = [
                        'EmployeeID' => 0,
                        'WorkOffDate' => $work_date,
                        'WorkDate' => $work_date,
                        'DayType' => $DayType,
                        'Remarks' => $Remarks,
                        'AddedBy' => user_id(),
                        'DateAdded' => date('Y-m-d H:i:s')
                    ];
                }
            }
            if(!empty($calendar_data)) {
                $this->calendar->table('workoff_calendar')->insert($calendar_data,'batch');
                echo "<h4 class='text text-info'>Inserted Successfully.</h4>";
            }
            else {
                echo "<h4 class='text text-danger'>Data already processed.</h4>";
            }
        }
        else
            echo "<h4 class='text text-danger'>There is no data.</h4>";
    }

    public function calender_date_edit()
    {
        $calender_date_info=$this->calendar->calender_date_edit();
        $attendance_day_status = $this->calendar->table('attendance_day_status')->where('id',[5,6])->fetchAll();
        $day_status = [];
        foreach ($attendance_day_status as $status) {
            $day_status[$status['id']] = $status['DayStatusName'];
        }

        return view('calendar/calender_date_edit',compact('calender_date_info','day_status'));
    }

    public function edit($id)
    {
        $inputs = $_POST;
        $DayType= $inputs['shift_all_day_status'];
        $WorkOffDate=date('Y-m-d', strtotime($inputs['work_off_date']));
        $WorkDate=date('Y-m-d', strtotime($inputs['work_off_date']));
        $calendar_data = [   
            'DayType'=>$DayType,
            'WorkOffDate'=>$WorkOffDate,
            'WorkDate'=>$WorkDate
        ];

        $calendar_update_info=$this->calendar->table("workoff_calendar")->where("id",$id)->update($calendar_data);

        return redirect('calendar/calender_date_edit');
    }

    public function delete($id)
    {
        $rowDelete = $this->calendar->table("workoff_calendar")->where('id',$id)->delete();
        return redirect('calendar/calender_date_edit');
    }


  


}
