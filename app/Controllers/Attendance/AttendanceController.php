<?php
namespace App\Controllers\Attendance;

use App\Controllers\Controller;
use App\Models\Attendance;
//use App\Models\SqlServer;
use App\library\SimpleXLSX;
use Vendor\Valitron\Validator;
use App\Models\Employee;

class AttendanceController extends Controller {
    private $attendance;
    private $employee;
    //private $sql_server;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->attendance = new Attendance();
        $this->employee = new Employee();
        //$this->sql_server = new SqlServer();
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
     * Show the form for download device data.
     *
     * @return view
     */
    public function ot_calculate_query(){
        $ot_enable_emp = $this->attendance->table("employee_info")->select('id,EmployeeCode')->where('OT',1)->fetchAll();
        $emp_list =array();
        foreach($ot_enable_emp as $emp){
            array_push($emp_list,$emp['id']);
        }
        $emp_list = implode(',', $emp_list);
        echo "UPDATE `daywise_pay_hour` SET w_ot=0,slab_1_ot=0,slab_2_ot=0 WHERE EmployeeID IN($emp_list) AND OutTime>='17:00:00' AND OutTime<'17:45:00' AND (DayStatus='P' OR DayStatus='L') ";
        echo '<br/><br/>';
        echo "UPDATE `daywise_pay_hour` SET w_ot=0,slab_1_ot=1,slab_2_ot=0 WHERE EmployeeID IN($emp_list) AND OutTime>='17:45:00' AND OutTime<'18:45:00' AND (DayStatus='P' OR DayStatus='L') ";
        echo '<br/><br/>';
        echo "UPDATE `daywise_pay_hour` SET w_ot=0,slab_1_ot=2,slab_2_ot=0 WHERE EmployeeID IN($emp_list) AND OutTime>='18:45:00' AND OutTime<'19:45:00' AND (DayStatus='P' OR DayStatus='L') ";
        echo '<br/><br/>';
        echo "UPDATE `daywise_pay_hour` SET w_ot=0,slab_1_ot=2,slab_2_ot=1 WHERE EmployeeID IN($emp_list) AND OutTime>='19:45:00' AND OutTime<'20:45:00' AND (DayStatus='P' OR DayStatus='L') ";
        echo '<br/><br/>';
        echo "UPDATE `daywise_pay_hour` SET w_ot=0,slab_1_ot=2,slab_2_ot=2 WHERE EmployeeID IN($emp_list) AND OutTime>='20:45:00' AND OutTime<'21:45:00' AND (DayStatus='P' OR DayStatus='L') ";
        echo '<br/><br/>';
        echo "UPDATE `daywise_pay_hour` SET w_ot=0,slab_1_ot=2,slab_2_ot=3 WHERE EmployeeID IN($emp_list) AND OutTime>='21:45:00' AND OutTime<'22:45:00' AND (DayStatus='P' OR DayStatus='L') ";
        echo '<br/><br/>';
        echo "UPDATE `daywise_pay_hour` SET w_ot=0,slab_1_ot=2,slab_2_ot=4 WHERE EmployeeID IN($emp_list) AND OutTime>='22:45:00' AND OutTime<'23:45:00' AND (DayStatus='P' OR DayStatus='L') ";
        echo '<br/><br/>';
        echo "UPDATE `daywise_pay_hour` SET w_ot=0,slab_1_ot=2,slab_2_ot=5 WHERE EmployeeID IN($emp_list) AND OutTime>='23:45:00' AND OutTime<'23:59:59' AND (DayStatus='P' OR DayStatus='L') ";
        echo '<br/><br/>';
        echo "UPDATE `daywise_pay_hour` SET w_ot=0,slab_1_ot=2,slab_2_ot=5 WHERE EmployeeID IN($emp_list) AND OutTime>='00:00:01' AND OutTime<'00:45:00' AND (DayStatus='P' OR DayStatus='L') ";
        echo '<br/><br/>';
        echo "UPDATE `daywise_pay_hour` SET w_ot=0,slab_1_ot=2,slab_2_ot=6 WHERE EmployeeID IN($emp_list) AND OutTime>='00:45:00' AND OutTime<'01:45:00' AND (DayStatus='P' OR DayStatus='L') ";
        echo '<br/><br/>';
        echo "UPDATE `daywise_pay_hour` SET w_ot=0,slab_1_ot=2,slab_2_ot=7 WHERE EmployeeID IN($emp_list) AND OutTime>='01:45:00' AND OutTime<'02:45:00' AND (DayStatus='P' OR DayStatus='L') ";
        echo '<br/><br/>';
        echo "UPDATE `daywise_pay_hour` SET w_ot=0,slab_1_ot=2,slab_2_ot=8 WHERE EmployeeID IN($emp_list) AND OutTime>='02:45:00' AND OutTime<'03:45:00' AND (DayStatus='P' OR DayStatus='L') ";
        echo '<br/><br/>';
        echo "UPDATE `daywise_pay_hour` SET w_ot=0,slab_1_ot=2,slab_2_ot=9 WHERE EmployeeID IN($emp_list) AND OutTime>='03:45:00' AND OutTime<'04:45:00' AND (DayStatus='P' OR DayStatus='L') ";
        echo '<br/><br/>';
        echo "UPDATE `daywise_pay_hour` SET w_ot=0,slab_1_ot=2,slab_2_ot=10 WHERE EmployeeID IN($emp_list) AND OutTime>='04:45:00' AND OutTime<'05:45:00' AND (DayStatus='P' OR DayStatus='L') ";
        echo '<br/><br/>';
        echo "UPDATE `daywise_pay_hour` SET w_ot=0,slab_1_ot=2,slab_2_ot=11 WHERE EmployeeID IN($emp_list) AND OutTime>='05:45:00' AND OutTime<'06:30:00' AND (DayStatus='P' OR DayStatus='L') ";

        echo '<pre>';
        print_r($emp_list);
    }
    public function temporaryAttendenceData(){
        $heading = "Attendance";
        $month_array = $this->month_names_with_id();
        $YearNo = date('Y');
        $employee_code = '';
        $title = "Temporary Attendence Data";
        return view('attendance/temporary_attendence_data',compact('title','month_array','YearNo','heading','employee_code'));
    }
    public function saveTemporaryAttendenceData(){
        $inputs = $_POST;
        $MonthNo = validation($inputs['MonthNo'] ?? null);
        $YearNo = validation($inputs['YearNo'] ?? null);
        $employee_code = validation($inputs['employee_code'] ?? null);
        $num_of_days = cal_days_in_month(CAL_GREGORIAN, $MonthNo, $YearNo);
        $days_array = [
            '1'=>'01','2'=>'02','3'=>'03','4'=>'04','5'=>'05','6'=>'06','7'=>'07','8'=>'08','9'=>'09','10'=>'10',
            '11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20',
            '21'=>'21','22'=>'22','23'=>'23','24'=>'24','25'=>'25','26'=>'26','27'=>'27','28'=>'28','29'=>'29','30'=>'30','31'=>'31'
        ];
        if($employee_code){
            $check_attendence = $this->attendance->table('tmp_device_row_data')->select('id,BadgeNumber')->where('BadgeNumber',$employee_code)->where('month_no',$MonthNo)->where('year_no',$YearNo)->fetchAll();
            if(empty($check_attendence)){
                $get_active_employee = $this->attendance->table('employee_info')->select('id,BadgeNumber')->where('BadgeNumber',$employee_code)->fetchAll();
            }
        }else{
            $get_active_employee = $this->attendance->getActiveEmployee()->fetchAll();
        }
        //echo $employee_code;print_r($get_active_employee);exit;
        if(!empty($get_active_employee)){
            foreach($get_active_employee as $employee){
                $day = 1;
                for($i=$day;$i<=$num_of_days;$i++){
                    $emp_attn_data [] = [
                        'EmployeeID' => $employee['id'],
                        'WorkDate' => $YearNo.'-'.$MonthNo.'-'.$days_array[$i],
                    ];
                }
            }
            if(!empty($emp_attn_data)){
                $this->attendance->table('employee_attn_month')->insert($emp_attn_data,'batch');
                $data = 'Success';
            }
            echo ($data);
        }else{
            $data = 'No Data Found!!';
        }
    }
    public function synchronizeDeviceData()
    {
        $heading = "Attendance";
        $title = "Synchronize Device Data";
        return view('attendance/synchronize_device_data',compact('title','heading'));
    }
    public function saveSyncData(){
        $inputs = $_POST;
        $from_date = date_conversion('Y-m-d',validation($inputs['FromDate']));
        $to_date = date_conversion('Y-m-d',validation($inputs['ToDate']));
        $EmployeeCode = null;
        if(!empty($inputs['EmployeeCode'])){
            $EmployeeCode = $inputs['EmployeeCode'];
        } 
        $get_active_employee = $this->attendance->getActiveEmployee($EmployeeCode)->fetchAll();
        $MonthNo = explode('-',$from_date)[1];
        $YearNo = explode('-',$from_date)[0];
        $num_of_days = cal_days_in_month(CAL_GREGORIAN, $MonthNo, $YearNo);
        $days_array = [
            '1'=>'01','2'=>'02','3'=>'03','4'=>'04','5'=>'05','6'=>'06','7'=>'07','8'=>'08','9'=>'09','10'=>'10',
            '11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20',
            '21'=>'21','22'=>'22','23'=>'23','24'=>'24','25'=>'25','26'=>'26','27'=>'27','28'=>'28','29'=>'29','30'=>'30','31'=>'31'
        ];
        $AddWhere = '';
        if(!empty($inputs['EmployeeCode'])){
            $AddWhere = " AND us.BADGENUMBER='".$get_active_employee[0]['BadgeNumber']."'";
            if(!empty($get_active_employee)){
                $delete_from = $YearNo."-".$MonthNo."-01";
                $delete_to = $YearNo.'-'.$MonthNo.'-31';
                $Where = "EmployeeID='".$get_active_employee[0]['id']."' AND WorkDate BETWEEN '".$delete_from."' AND '".$delete_to."' ";
                $this->attendance->table('employee_attn_month')->where($Where)->delete();
                foreach($get_active_employee as $employee){
                    $day = 1;
                    for($i=$day;$i<=$num_of_days;$i++){
                        $emp_attn_data [] = [
                            'EmployeeID' => $employee['id'],
                            'WorkDate' => $YearNo.'-'.$MonthNo.'-'.$days_array[$i],
                        ];
                    }
                }
            }
        }else{
             if(empty($this->attendance->table('employee_attn_month')->select('id,WorkDate')->where('WorkDate',$from_date)->fetch())){
                if(!empty($get_active_employee)){
                    foreach($get_active_employee as $employee){
                        $day = 1;
                        for($i=$day;$i<=$num_of_days;$i++){
                            $emp_attn_data [] = [
                                'EmployeeID' => $employee['id'],
                                'WorkDate' => $YearNo.'-'.$MonthNo.'-'.$days_array[$i],
                            ];
                        }
                    }
                }
            }
        }
        //dd($Where);exit;
        //dd($this->attendance->table('employee_attn_month')->where($Where)->delete() );exit;
        if(!empty($emp_attn_data)){
            $this->attendance->table('employee_attn_month')->insert($emp_attn_data,'batch');
        }
       
        $query = "SELECT * FROM (
            SELECT * FROM (
                SELECT us.NAME,us.BADGENUMBER,cast(cio.CHECKTIME as date) [date],
                (CASE WHEN (MIN(cast(cio.CHECKTIME as time)) >= '06:30:00' AND MIN(cast(cio.CHECKTIME as time)) <= '11:59:59') THEN MIN(cast(cio.CHECKTIME as time)) ELSE NULL END) as [InTime],
                (CASE WHEN (MAX(cast(cio.CHECKTIME as time)) >= '12:00:00' AND MAX(cast(cio.CHECKTIME as time)) <= '23:59:59') THEN MAX(cast(cio.CHECKTIME as time)) ELSE NULL END) as [OutTime],
                null as [OutTimeTreat]
                FROM USERINFO us INNER JOIN CHECKINOUT cio ON us.USERID=cio.USERID
                WHERE (cast(cio.CHECKTIME as date) BETWEEN '".$from_date."' AND '".$to_date."') AND cast(cio.CHECKTIME as time)>='04:00:00' ".$AddWhere."
                GROUP BY cast(cio.CHECKTIME as date),cio.USERID,us.BADGENUMBER,us.NAME
            ) first
            UNION
            SELECT * FROM (
                SELECT us.NAME,us.BADGENUMBER,cast(cio.CHECKTIME as date) [date],null as InTime,null as OutTime, cast(cio.CHECKTIME as time) [OutTimeTreat]
                FROM USERINFO us INNER JOIN CHECKINOUT cio ON us.USERID=cio.USERID
                WHERE (cast(cio.CHECKTIME as date) BETWEEN '".$from_date."' AND '".$to_date."') AND cast(cio.CHECKTIME as time)<'06:30:00' ".$AddWhere."
                GROUP BY cast(cio.CHECKTIME as date),cast(cio.CHECKTIME as time),cio.USERID,us.BADGENUMBER,us.NAME
            ) last
        ) as unionized ORDER BY BADGENUMBER";
        //print_r($query);exit;
        $sync_device_data = $this->sql_server->query($query)->fetchAll();
        //echo '<pre>';
        //print_r($query);exit;
        $device_data = [];
        if(!empty($sync_device_data)){
            foreach($sync_device_data as $data){
                if($data['OutTimeTreat']!=null){
                    $update_data[] = [
                        'BadgeNumber' => $data['BADGENUMBER'],
                        'WorkDate' => date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $data['date'] ) ) )),
                        'PunchOutDate' => $data['date'],
                        'PunchOutTime'=>$data['OutTimeTreat']
                    ];
                }else{
                    $device_data [] = [
                        'BadgeNumber' => $data['BADGENUMBER'],
                        'PunchIN' =>$data['InTime'],
                        'PunchOUT' => $data['OutTime'],
                        'WorkDate' => $data['date'],
                    ];
                    $BadgeNumber[] = $data['BADGENUMBER'];
                }
            }
            if (!empty($device_data)) {
                $this->attendance->delete('tmp_device_row_data');
                $BadgeNumber = array_unique($BadgeNumber);
                $this->attendance->table('tmp_device_row_data')->insert($device_data,'batch');
                if(!empty($update_data)){
                    foreach($update_data as $up_data){
                        $update_out_data = $this->attendance->table("tmp_device_row_data")->where(['BadgeNumber'=>$up_data['BadgeNumber'],'WorkDate'=>$up_data['WorkDate']]);
                        $update_out_data = $update_out_data->update($up_data);
                    }
                }
                $attendanceData = $this->attendance->tmpSyncAttendanceDataByEmployeeCode($BadgeNumber);
                $attendanceData = $attendanceData->fetchAll();
                $data = '';
                if(!empty($attendanceData)>0) {
                    foreach ($attendanceData as $row) {
                        $work_date = date_conversion('d-m-Y',$row['WorkDate']);
                        $out_date = date_conversion('d-m-Y',$row['WorkDate']);
                        $in_time = null;
                        $out_time = null;
                        if(!is_null($row['InTime'])){
                            $in_time = date('h:i a',strtotime($row['InTime']));
                        }
                        if(!is_null($row['OutTime'])){
                            $out_time = date('h:i a',strtotime($row['OutTime']));
                        }

                        if(!is_null($row['PunchOutTime'])){
                            $out_date = date_conversion('d-m-Y',$row['PunchOutDate']);
                            $out_time = date('h:i a',strtotime($row['PunchOutTime']));
                        }
                        $data .= '<tr><td>'.$row['EmployeeCode'].'</td>'.'</td><td>'.$row['EmployeeName'].'</td><td>'.$row['ShiftIDText'].'</td><td>'.$row['ShiftType'].'</td><td>'.$work_date.'</td><td>'.$work_date.'</td>
                        <td>'.$in_time.'</td><td>'.$out_date.'</td><td>'.$out_time.'</td>
                        </tr>';
                    }
                }
            }
            echo ($data);
        }else{
            $data = 'No Data Found!!';
        }
    }
    public function downloadDeviceData()
    {
        $heading = "Attendance";
        $title = "Download Device Data";
        return view('attendance/download_device_data',compact('title','heading'));
    }
    public function deviceFileUpload() {
        $data = 'No data found.';
        $inputs = $_POST;

        if (isset($_FILES['file'])) {
            $from_date = date_conversion('Y-m-d',validation($inputs['FromDate']));
            $to_date = date_conversion('Y-m-d',validation($inputs['ToDate']));
            $time_diff = ($inputs['TimeDifference']) ?? null;
            $time_diff = validation($time_diff);
            $collect_all_data = ($inputs['CollectAllData']) ?? null;
            $uploaded_file = $_FILES['file'] ?? null;
            $uploaded_file_path = $uploaded_file['tmp_name'] ?? null;
            $device_data = [];
            $employee_code = [];

            if ( $xlsx = SimpleXLSX::parse($uploaded_file_path)) {
                // Produce array keys from the array values of 1st array element
                $header_values = $rows = [];
                foreach ( $xlsx->rows() as $k => $r ) {
                    if ( $k === 0 ) {
                        $header_values = $r;
                        continue;
                    }

                    if(isset($r[0]) && $r[0] != '') { //employee code
                        $work_date = date_conversion('Y-m-d',$r[1]); // attendance date
                        $ptime_in = null;
                        $ptime_out = null;
                        if (isset($r[2]) && $r[2] !='1970-01-01 00:00:00') { // intime
                            //$ptime_in = $work_date.' '.date_conversion('H:i:s',$r[2]);
                            $ptime_in = date_conversion('H:i:s',$r[2]);
                        }
                        if (isset($r[3]) && $r[3] !='1970-01-01 00:00:00') { // out time
                            //$ptime_out = $work_date.' '.date_conversion('H:i:s',$r[3]);
                            $ptime_out = date_conversion('H:i:s',$r[3]);
                            //myLog("r[3]:$r[3], ptime_out:$ptime_out");
                        }

                        if ($from_date <= $work_date && $to_date >=$work_date ) {
                            //$work_date = date_conversion('Y-m-d H:i:s',$r[2]); // date('Y-m-d H:i',strtotime($r[2])); //1
                            $device_data [] = [
                                'EmployeeCode' => $r[0], //15
                                //'PTime' => $work_date.' '.$ptime_in,
                                'PunchIN' =>$ptime_in,
                                'PunchOUT' => $ptime_out,
                                'WorkDate' => $work_date,
                                'PunchCardNo' => '',
                                'PunchType' => 1,
                                'DeviceID' => 1,
                                'AddedBy' => user_id(),
                                'DateAdded' => date('Y-m-d H:i:s'),
                                'DiffTime' => $time_diff
                            ];
                            $employee_code[] = $r[0];
                        }
                    }
                }
            }
            else {
                $data = SimpleXLSX::parseError();
            }
        }
        if (!empty($device_data)) {
            $employee_code = array_unique($employee_code);
            $this->attendance->delete('tmp_device_row_data');

            $this->attendance->table('tmp_device_row_data')->insert($device_data,'batch');
            $attendanceData = $this->attendance->tmpAttendanceDeviceDataByEmployeeCode($employee_code);
            $attendanceData = $attendanceData->fetchAll();
            $data = '';
            if(!empty($attendanceData)>0) {
                foreach ($attendanceData as $row) {
                    $work_date = date_conversion('d-m-Y',$row['WorkDate']);
                    $in_time = date_conversion('h:i A',$row['InTime']);
                    $out_time = date_conversion('h:i A',$row['OutTime']);
                    $data .= '<tr><td>'.$row['EmployeeCode'].'</td>'.'</td><td>'.$row['EmployeeName'].'</td><td>'.$row['ShiftIDText'].'</td><td>'.$row['ShiftType'].'</td><td>'.$work_date.'</td><td>'.$work_date.'</td>
                    <td>'.$in_time.'</td><td>'.$work_date.'</td><td>'.$out_time.'</td>
                    </tr>';
                }
            }
        }
        echo ($data);
    }

    /**
     * Save device data after user save clicked
     */
    public function saveDeviceData() {
        $inputs = $_POST;
        $from_date = date_conversion('Y-m-d',validation($inputs['FromDate']));
        $to_date = date_conversion('Y-m-d',validation($inputs['ToDate']));
        $msg = "There is no data to process.";

        if (!$this->is_uploadable($to_date)) {
            echo "Already Salary Processed.";

        }
        else {
            $EmployeeID = [];
            $temp_attendance_data = $this->attendance->tempSyncAttendanceDataByDate($from_date,$to_date)->fetchAll();
            //print_r($temp_attendance_data);exit;
            if (!empty($temp_attendance_data)) {
                foreach ($temp_attendance_data as $data) {
                    $EmployeeID[] = $data['id'];
                    $attendance_data[] = [
                        'EmployeeCode' => $data['EmployeeCode'],
                        'EmployeeID' => $data['id'],
                        'PunchIN' => $data['PunchIN'],
                        'PunchOUT' => $data['PunchOUT'],
                        'WorkDate' => $data['WorkDate'],
                        'PunchOutDate' => $data['PunchOutDate'],
                        'PunchOutTime' => $data['PunchOutTime'],
                        'AddedBy' => $data['AddedBy'],
                        'DateAdded' => $data['DateAdded']
                    ];
                }

                if(!empty($attendance_data)) {
                    // delete old data on this date before newly insert
                    $this->deleteExistingData('device_row_data',$EmployeeID,$from_date,$to_date);
                    $this->attendance->table('device_row_data')->insert($attendance_data,'batch');
                    $msg = "Inserted Successfully";
                }
            }
            echo $msg;
        }
    }

    /**
     * Show the form for replace attendance data.
     *
     * @return view
     */
    public function replaceDeviceData()
    {
        $heading = "Replace Data";
        $title = "Replace Attendence Data";
        return view('attendance/replace_device_data',compact('title','heading'));
    }
    public function replaceAttendenceData() {
        $data = 'No data found.';
        $inputs = $_POST;
        $duty_date = date_conversion('Y-m-d',validation($inputs['WorkDate']));
        $replace_date = date_conversion('Y-m-d',validation($inputs['ReplaceDate']));
        $attendanceData = $this->attendance->replaceAttendenceData($duty_date);
        $attendanceData = $attendanceData->fetchAll();
        if(!empty($attendanceData)>0) {
            foreach ($attendanceData as $row) {
                $work_date = date_conversion('d-m-Y',$row['WorkDate']);
                $in_time = date_conversion('h:i A',$row['InTime']);
                $out_time = date_conversion('h:i A',$row['OutTime']);
                $data .= '<tr><td>
                        <input type="checkbox" class="employee_id" name="employee_id[]" value="'.$row['id'].'" checked>
                        <input type="hidden" class="employee_code" name="employee_code[]" value="'.$row['EmployeeCode'].'">
                    </td><td>'.$row['EmployeeCode'].'</td>'.'</td><td>'.$row['EmployeeName'].'</td><td>'.$row['ShiftIDText'].'</td><td>'.$row['ShiftType'].'</td><td>'.$work_date.'</td><td>'.$work_date.'</td>
                <td>'.$in_time.'</td><td>'.$work_date.'</td><td>'.$out_time.'</td>
                </tr>';
            }
        }
        echo ($data);
    }
    public function saveReplaceAttendenceData() {
        $inputs = $_POST;
        $duty_date = date_conversion('Y-m-d',validation($inputs['WorkDate']));
        $replace_date = date_conversion('Y-m-d',validation($inputs['ReplaceDate']));
        $employee_id = json_decode($inputs['employee_id']) ?? '';
        $employee_id = implode(',',$employee_id);
        $duty_date_data = $this->attendance->duty_date_data($duty_date,$employee_id)->fetchAll();
        if(!empty($duty_date_data)){
            foreach($duty_date_data as $row){
                //$ptime = explode(' ',$row['PTime']);
                $update_duty_date_data = [
                    'PunchIN' => NULL,
                    'PunchOUT'=>NULL
                ];
                $update_rep_date_data[] = [
                    //'PTime'=> $replace_date.' '.$ptime[1],
                    'EmployeeCode' => $row['EmployeeCode'],
                    'EmployeeID' => $row['EmployeeID'],
                    'PunchIN' => $row['PunchIN'],
                    'PunchOUT'=> $row['PunchOUT'],
                    'WorkDate' => $replace_date,
                    'PunchOutDate' => $row['PunchOutDate'],
                    'PunchOutTime' => $row['PunchOutTime']
                ];
                $update_duty = $this->attendance->table("device_row_data")->where(['EmployeeID'=>$row['EmployeeID'],'WorkDate'=>$duty_date]);
                $update_duty = $update_duty->update($update_duty_date_data);
                /*$update_rep = $this->attendance->table("device_row_data")->where(['EmployeeID'=>$row['EmployeeID'],'WorkDate'=>$replace_date]);
                $update_rep = $update_rep->update($update_rep_date_data);*/

            }
            $this->attendance->table('device_row_data')->insert($update_rep_date_data,'batch');
        }
        $msg = "Duty Replaced Successfully";
        //echo json_encode($update_duty_date_data);exit;
        echo $msg;

    }
     /**
     * Show the form for manual attendance data.
     *
     * @return view
     */
    public function manual()
    {
        $heading = "Attendance";
        $title = "Attendance Manual";
        $shifts = $this->attendance->table('shift_plan')->fetchAll();//->select()
        return view('attendance/attendance_manual',compact('title','heading','shifts'));
    }

    /**
     * Get employee data for attendance processed
     *
     */
    public function verify() {
        $inputs = $_POST;
        $from_date = date_conversion('Y-m-d',validation($inputs['from_date']));
        $to_date = date_conversion('Y-m-d',validation($inputs['to_date']));
        $employee_code = json_decode($inputs['employee_code']) ?? '';
        $employee_id = json_decode($inputs['employee_id']) ?? '';
        //myLog("employee_code:".json_encode($employee_code));
        //myLog("employee_id:".json_encode($employee_id));
        $msg = "Verified.";

        if(!is_array($employee_id)) {
            $employee_id = [$employee_id];
            $employee_code = [$employee_code];
        }
        if(!empty($from_date) && !empty($employee_id)) {
            $msg = '';
            $count_employee = count($employee_id);
            //myLog("count_employee:".$count_employee);
            for ($i=0; $i < $count_employee; $i++) {
                $is_attendance_processed = $this->attendance->checkAttendance($employee_id[$i], $from_date, $to_date);
                //myLog("is_attendance_processed:".json_encode($is_attendance_processed));
                if(!$is_attendance_processed) {
                    $msg .= "<br /> Employee Code: $employee_code[$i], attendance is not processed";
                }
            }
        }
        else {
            $msg = "Date/Employee is not selected.";
        }
        echo ($msg);
    }

    /**
     * Get employee data for attendance manual
     *
     */
    public function getEmployee() {
        $inputs =  $_GET;
        $data = 'No data found.';
        $shiftID = $inputs['shiftID'] ?? null;
        $shiftID = validation($shiftID);
        $roaster = $inputs['roaster'] ?? null;
        $roaster = validation($roaster);
        $employees = $this->attendance->table("employee_info")->select('id','EmployeeCode','EmployeeName','DivisionID','UnitID','SectionID','HolydayBonus','OT');
        //$employees = $this->employee->getEmployee();

        if (isset($shiftID)) {
            if(!is_array($shiftID)){
                $shiftID = [$shiftID];
            }
            $employees = $employees->where('ShiftID',$shiftID);
        }
        
        if (isset($roaster)) {
            $employees = $employees->where('SRA',$roaster);
        }
        //dump($employees);
        $employees = $employees->fetchAll();        
        //echo '<pre>';print_r($employees);exit;       

        $divisions = $this->employee->table("settings_master")->where('type_name','division');
        $division = [0=>''];
        foreach ($divisions as $item) {
            $division[$item->id] = $item->name;
        }

        $units = $this->employee->table("settings_master")->where('type_name','unit');
        $unit = [ 0 => ''];
        foreach ($units as $item) {
            $unit[$item->id] = $item->name;
        }
        $sections = $this->employee->table("settings_master")->where('type_name','section');
        $section = [0=>''];
        foreach ($sections as $item) {
            $section[$item->id] = $item->name;
        }
        //dump($units);
        //myLog("section:".json_encode($section));
        if($employees) {
            $data = '';
            foreach ($employees as $row) {
                //myLog("id: ".$row['id']);
                //myLog("section_id:".$row['SectionID']);
                $division_name = isset($row['DivisionID']) ? $division[$row['DivisionID']] : null;
                $unit_name = isset($row['UnitID']) ? $unit[$row['UnitID']] : null;
                // We used the value of employee_code and employee_id with reverse name
                // At then end we will remove employee code, if it is not needed.
                $data .= '<tr>
                    <td>
                        <input type="checkbox" class="employee_id" name="employee_id[]" value="'.$row['id'].'" checked>
                        <input type="hidden" class="employee_code" name="employee_code[]" value="'.$row['EmployeeCode'].'">
                        <input type="hidden" class="section" name="section[]" value="'.$section[$row['SectionID']].'">
                        <input type="hidden" class="OT" name="OT[]" value="'.$row['OT'].'">
                        <input type="hidden" class="HolydayBonus" name="HolydayBonus[]" value="'.$row['HolydayBonus'].'">
                    </td>
                    <td>'.$row['EmployeeCode'].'</td>
                    <td class="emp_name">'.$row['EmployeeName'].'</td>
                    <td>'. $unit_name.'</td>
                    <td>'. $division_name.'</td>
                </tr>';
            }
        }
        echo ($data);
    }

    /**
     * Get employee data with shift for attendance manual
     *
     */
    public function getEmployeeShift() {
        $employees = $this->attendance->table("employee_info")->select('EmployeeCode','PunchCardNo','EmployeeName','UnitID','DivisionID')->fetchAll();
        $data = '';
        if(count($employees)>0) {
            foreach ($employees as $row) {
                $data .= '<tr>
                    <td><input type="checkbox" name="employee_code[]" value="'.$row['EmployeeCode'].'" checked></td>
                    <td>'.$row['EmployeeCode'].'</td>
                    <td>'.$row['EmployeeName'].'</td>
                    <td>Unit</td>
                    <td>Division</td>
                 </tr>';
            }
        }
        else
            $data = 'No data found.';
        echo ($data);
    }

    /**
     * Get employee_code,shift id and dates for making daily attendance information
     *
     */
    public function attendanceDataForManual() { 
        $inputs = $_POST;
        $shiftID = $inputs['shiftID'] ?? '';
        $employee_id = json_decode($inputs['employee_id']) ?? '';
        $in_cb = ($inputs['in_cb']) ?? null;
        $out_cb = ($inputs['out_cb']) ?? null;
        /*if(!is_array($shiftID))
            $shiftID = [$shiftID];*/
        if(!is_array($employee_id))
            $employee_id = [$employee_id];
        if(!empty($shiftID) && !empty($employee_id)) {
            $date_from = $inputs['from_date'];
            $date_to = $inputs['to_date'];
            if($inputs['attendence_type']=='All'){
                $attendence_type = '';
            }elseif($inputs['attendence_type']=='P'){
                $attendence_type = "AND (da.PunchIN IS NOT NULL OR da.PunchOUT IS NOT NULL)";
            }elseif($inputs['attendence_type']=='A'){
                $attendence_type = "AND da.PunchIN IS NULL AND da.PunchOUT IS NULL";
            }elseif($inputs['attendence_type']=='MI'){
                $attendence_type = "AND da.PunchIN IS NULL";
            }elseif($inputs['attendence_type']=='MO'){
                $attendence_type = "AND da.PunchOUT IS NULL";
            }
            $holiday_data = $inputs['holiday_data'];
            $leave_data = $inputs['leave_data'];
            $shiftInfo = $this->attendance->getShiftInfo($shiftID[0])->fetch();
            $employees = $this->attendance->getEmployeeDataForManualAttendance($employee_id,$date_from,$date_to,$attendence_type,$holiday_data,$leave_data)->fetchAll();
            //dd($employees);
            $date_from = strtotime($date_from);
            $date_to = strtotime($date_to);
            $data = '';
            $data .='
                <thead>
                    <tr>
                        <th>Employee Code</th>
                        <th>Employee Name</th>
                        <th>Shift ID</th>
                        <th>Shift Type</th>
                        <th>Work Date</th>';
                        if ( $in_cb ) {
                            $data .='<th>In Date</th>
                                    <th>In Time</th>';
                        }
                        if ( $out_cb ) {
                            $data .=' <th>Out Date</th>
                                    <th>Out Time</th>';
                        }
                        $data .='
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>';

            if(!empty($employees)) {
                foreach ($employees as $row) {
                    if(empty($row['WorkOffDate'])){
                        if(empty($row['FromDate'])){
                            $in_time = date_conversion('h:i A',$row['InTime']); //date('h:i A',strtotime($row['InTime']));
                            //$in_time =$row['InTime']; //date('h:i A',strtotime($row['InTime']));
                            $out_time = date_conversion( 'h:i A',$row['OutTime']); //date('h:i A',strtotime($row['OutTime']));
                            $today = strtotime(date('Y-m-d'));
                            if ($today > $row['WorkDate']){
                                $out_date = $row['PunchOutDate'];//$row['WorkDate'];
                                $out_time = $out_time;
                                $read_only = '';
                            }
                            else {
                                $out_date = null;
                                $out_time = null;
                                $read_only = 'disabled';
                            }
                            if(!empty($inputs['ot_hour'])){
                                $out_time = date_conversion('h:i A',((explode(':',$shiftInfo['OutTime'])[0]+$inputs['ot_hour']).':00:00'));
                            }
                            if(!empty($inputs['overwrite_existing'])){
                                $in_time = date_conversion('h:i A',$shiftInfo['InTime']);
                                //$in_time = $shiftInfo['InTime'];
                                $out_time = date_conversion( 'h:i A',$shiftInfo['OutTime']);
                            }
                            $data .= '<tr>
                                <td>'.$row['EmployeeCode'].'</td>
                                <td>'.$row['EmployeeName'].'</td>
                                <td>'.$shiftInfo['ShiftID'].'</td>
                                <td>'.$shiftInfo['ShiftType'].'</td>
                                <td>'.$row['WorkDate'].'</td>';
                            if ( $in_cb ) {
                                $data .= '<td><input type="text" autocomplete="off" class="col-sm-10 form_date" name="InDate[]" value="'.$row['WorkDate'].'"></td>
                                <td><input type="text" autocomplete="off" class="col-sm-8 form_time timepicker" name="InTime[]" value="'.$in_time.'" '.$read_only.'>
                                <!--input type="time" autocomplete="off" class="" name="InTime[]" value="'.$in_time.'"--></td>';
                            }
                            if ( $out_cb ) {
                                $data .= '<td><input type="text" autocomplete="off" class="col-sm-10 form_date" name="OutDate[]" value="'.$out_date.'" '.$read_only.'></td>
                                <td><input type="text" autocomplete="off" class="col-sm-8 form_time timepicker" name="OutTime[]" value="'.$out_time.'" '.$read_only.'></td>';
                            }
                            $data .= '
                                <td><input type="text" name="Remarks[]" value=""></td>
                                <input type="hidden" name="EmployeeID[]" value="'.$row['employee_id'].'">
                                <input type="hidden" name="DOJ[]" value="'.$row['DOJ'].'">
                                <input type="hidden" name="WorkDate[]" value="'.$row['WorkDate'].'">
                                <input type="hidden" name="ShiftID[]" value="'.$shiftInfo['shift_id'].'">
                                <input type="hidden" name="ShiftType[]" value="'.$shiftInfo['ShiftType'].'">
                                <input type="hidden" name="ShiftInTime[]" value="'.$shiftInfo['InTime'].'">
                                <input type="hidden" name="ShiftOutTime[]" value="'.$shiftInfo['OutTime'].'">
                                <input type="hidden" name="RoundAfter[]" value="'.$shiftInfo['RoundAfter'].'">
                                <input type="hidden" name="RoundFor[]" value="'.$shiftInfo['RoundFor'].'">
                                <input type="hidden" name="ot[]" value="'.$row['OT'].'">
                                <input type="hidden" name="OffDay[]" value="'.$row['OffDay'].'">
                            </tr>';
                        }
                    }
                }
                $data .= '</tbody>';
            }
            else
                $data = 'No data found.';
        }
        else
            $data = 'No data found.';
        echo ($data);
    }
    /**
     * Get employee_code,shift id and dates for making daily attendance information
     *
     */
    public function getAttendanceFromDeviceData() {
        $inputs = $_POST;
        //myLog('inputs: '.$inputs);
        $employee_id = json_decode($inputs['employee_id']) ?? '';
        //myLog('employee_id: '.$employee_id);
        $data = 'No data found for process.';
        if(!is_array($employee_id))
            $employee_id = [$employee_id];
        if(!empty($employee_id)) {
            $from_date = date_conversion('Y-m-d',validation($inputs['from_date']));
            $to_date = date_conversion('Y-m-d',validation($inputs['to_date']));
            $attendance_data = $this->attendance->attendanceDeviceData($employee_id, $from_date, $to_date);
            $attendance_data = $attendance_data->fetchAll();
            //echo json_encode($attendance_data);exit;
            if(!empty($attendance_data)) {
                foreach ($attendance_data as $row) {
                    $work_date = date_conversion('d-m-Y',$row['WorkDate']);
                    $out_date = date_conversion('d-m-Y',$row['WorkDate']);
                    //date('Y-m-d',strtotime($row['WorkDate']));
                    $in_time = null;
                    $out_time = null;
                    if (isset($row['InTime']) && !is_null($row['InTime'])) {
                        $in_time = date('h:i A',strtotime($row['InTime']));
                    }
                    if (isset($row['OutTime']) && !is_null($row['OutTime'])) {
                        $out_time = date('h:i A',strtotime($row['OutTime']));
                    }
                    //$in_time = date_conversion('h:i A',$row['InTime']); //date('h:i A',strtotime($row['InTime']));
                    //$out_time = date_conversion('h:i A',$row['OutTime']); //date('h:i A',strtotime($row['OutTime']));

                    //$in_time = $row['InTime']; //date('h:i A',strtotime($row['InTime']));
                    //$out_time = $row['OutTime']; //date('h:i A',strtotime($row['OutTime']));
                    if(isset($row['PunchOutTime']) && !is_null($row['PunchOutTime'])){
                        $out_date = date_conversion('d-m-Y',$row['PunchOutDate']);
                        $out_time = date('h:i a',strtotime($row['PunchOutTime']));
                    }

                    $data .= '<tr>
                        <td>'.$row['EmployeeCode'].'</td>
                        <td>'.$row['EmployeeName'].'</td>
                        <td>'.$row['ShiftIDText'].'</td>
                        <td>'.$row['ShiftType'].'</td>
                        <td>'.$work_date.'</td>
                        <td>'.$work_date.'</td>
                        <td><input type="text" autocomplete="off" class="col-sm-10 InTime" name="InTime[]" value="'.$in_time.'"></td>
                        <td>'.$out_date.'</td>
                        <td>
                        <input type="text" autocomplete="off" class="col-sm-10 OutTime" name="OutTime[]" value="'.$out_time.'">
                        <input type="hidden" class="EmployeeID" name="EmployeeID[]" value="'.$row['id'].'">
                        <input type="hidden" class="WorkDate" name="WorkDate[]" value="'.$work_date.'">
                        <input type="hidden" class="OutDate" name="OutDate[]" value="'.$out_date.'">
                        <input type="hidden" class="ShiftID" name="ShiftID[]" value="'.$row['ShiftID'].'">
                        </td>
                    </tr>';
                }
            }
        }
        echo ($data);
    }

    /**
     * store employee in/out time from device data
     *
     * @return table tr of
     */
    public function saveAttendanceData() {
        $inputs = $_POST;

        $ShiftID = json_decode($inputs['ShiftID']);
        $InTime = json_decode($inputs['InTime']);
        $OutTime = json_decode($inputs['OutTime']);
        $EmployeeID = json_decode($inputs['EmployeeID']);
        $WorkDate = json_decode($inputs['WorkDate']);
        $OutDate = json_decode($inputs['OutDate']);

        $from_date = reset($WorkDate);
        $to_date = end($WorkDate);

        if (!empty($inputs)) {
            $attendance_data = [];
            for ($i=0; $i<count($EmployeeID); $i++) {
                $employee_id = $EmployeeID[$i];
                $work_date = date_conversion('Y-m-d',$WorkDate[$i]);
                $out_date = date_conversion('Y-m-d',$OutDate[$i]);
                $shift_time = $this->attendance->table('shift_plan',$ShiftID[$i]);
                $late = 0;

                if (strtotime($shift_time->InTime) < strtotime($InTime[$i])) {
                    $late = 1;
                }
                $attendance_data[] = [
                    'EmployeeID' => $employee_id,
                    'WorkDate' => $work_date,
                    'PunchOutDate'=>$out_date,
                    'ShiftID' => $ShiftID[$i],
                    'PunchIN'=>date_conversion('H:i:s',$InTime[$i]),
                    'PunchOUT'=>date_conversion('H:i:s',$OutTime[$i]),
                    //'PunchIN'=>$InTime[$i],
                    //'PunchOUT'=>$OutTime[$i],
                    'IsManual' => 0,
                    'IsLate' => $late,
                    'AddedBy' => user_id(),
                    'DateAdded' => date('Y-m-d H:i:s')
                ];
            }
            if(!empty($attendance_data)) {
                // delete old data on this date before newly insert but kept manual entry
                $from_date = date_conversion('Y-m-d',$from_date);
                $to_date = date_conversion('Y-m-d',$to_date);
                $employee_id = implode(',',array_unique($EmployeeID));
                //$this->attendance->delete('daily_attendance',["WorkDate>='$from_date'","WorkDate<='$to_date'","EmployeeID IN($employee_id)","IsManual=0"]);
                $this->attendance->delete('daily_attendance',["WorkDate>='$from_date'","WorkDate<='$to_date'","EmployeeID IN($employee_id)"]);
                $this->attendance->table('daily_attendance')->insert($attendance_data,'batch');
                echo "<h4 class='text text-info'>Inserted Successfully.</h4>";
            } else {
                echo "<h4 class='text text-danger'>Data already processed.</h4>";
            }
        }
        else
            echo "<h4 class='text text-danger'>There is no data.</h4>";
    }

    /**
     * store employee in/out time
     *
     * @return table tr of
     */

    public function manualStore() {
        $inputs = $_POST;
        $ShiftID = $inputs['ShiftID'] ?? null;
        $EmployeeID = $inputs['EmployeeID'] ?? null;
        $DOJ = $inputs['DOJ'] ?? null;
        $WorkDate = $inputs['WorkDate'];
        $ShiftType = $inputs['ShiftType'];
        $Remarks = $inputs['Remarks'];
        $from_date = reset($WorkDate); // take first value
        $to_date = end($WorkDate); // take last value
        if (!empty($inputs)) {
            $attendance_data = [];
            for ($i=0; $i<count($EmployeeID); $i++) {
                $InTime = $inputs['InTime'][$i] ?? null;
                $OutTime = $inputs['OutTime'][$i] ?? null;
                $InDate = $inputs['InDate'][$i] ?? null;
                $OutDate = $inputs['OutDate'][$i] ?? null;
                $work_date = $WorkDate[$i] ?? null;
                $ShiftInTime = $inputs['ShiftInTime'][$i] ?? null;
                $ShiftOutTime = $inputs['ShiftOutTime'][$i] ?? null;
                $employee_id = $EmployeeID[$i] ?? null;
                $offDay = $inputs['OffDay'][$i];
                $doj = $DOJ[$i] ?? null;
                $shift_id = $ShiftID[$i] ?? null;
                $shift_type = $ShiftType[$i] ?? null;
                $remarks =  null;
                if($Remarks[$i] !=''){
                    $remarks = $Remarks[$i];
                }
                $shift_time = $this->attendance->table('shift_plan',$shift_id);
                $late = 0;
                if(strtotime($shift_time->InTime) < strtotime($InTime)) {
                    $late = 1;
                }

                if(isset($inputs['effect_on_report'])){
                    $RoundAfter = $inputs['RoundAfter'][$i] ?? null;
                    $RoundFor = $inputs['RoundFor'][$i] ?? null;
                    $ot_time = '00:00';
                    $late_hour = 0;
                    $pay_hour = '00:00';
                    $work_hour = 0;
                    $day_status = 'P';
                    $late_hour = calculate_late_hour($InTime,$ShiftInTime,5);
                    if(!empty($OutTime)){
                        $pay_hour = getHoursMinutes((strtotime($OutDate.' '.$OutTime)-strtotime($work_date.' '.$ShiftInTime)),1);
                        $work_hour = getHoursMinutes((strtotime($OutDate.' '.$OutTime)-strtotime($work_date.' '.$ShiftInTime)),1);
                    }

                    if ($late != 0) {
                        $day_status = 'L';
                    }
                    //echo 'out==>'.$OutTime.'<br/>in==>'.$ShiftInTime.'<br/>'.$pay_hour;exit;
                    if($offDay!=strtolower(date("l", strtotime($work_date)))){
                        $day_status = $this->retrieve_day_status($employee_id, $work_date, $day_status, 0,0);
                    }else{
                        $day_status='W';
                    }                    
                    $total_ot_hour = 0;
                    $w_ot = 0;
                    $slab1 = 0;
                    $slab2 = 0;
                    if(!empty($inputs['ot'][$i])){
                        if($day_status=='W'){
                            //if(!empty($OutTime) && !empty($InTime)){
                            if(!empty($OutTime)){
                                $subtract = 1;
                                if( explode(':',$OutTime)[1]>44){
                                    $subtract = 0;
                                }
                                if(strtotime($OutDate.' '.$OutTime)>strtotime($work_date.' '.$ShiftInTime)){
                                    $pay_hour = getHoursMinutes((strtotime($OutDate.' '.$OutTime)-strtotime($work_date.' '.$ShiftInTime)));
                                }

                                if($pay_hour>'06:00'){
                                    $pay_hour = (explode(':',$pay_hour)[0]-1).':'.explode(':',$pay_hour)[1];
                                }
                                if(explode(':',$pay_hour)[1]>44){
                                    $pay_hour = explode(':',$pay_hour)[0]+1;
                                }else{
                                    $pay_hour = explode(':',$pay_hour)[0];
                                }
                                $work_hour = getHoursMinutes((strtotime($OutDate.' '.$OutTime)-strtotime($work_date.' '.$ShiftInTime)),$subtract);
                                $w_ot_array = explode('.',$pay_hour);
                                $w_ot = $w_ot_array[0];
                                if (!empty($late_hour) ) {
                                    $day_status = 'LW';
                                }else{
                                    $day_status = 'PW';
                                }
                            }
                        }else{
                            if(!empty($OutTime) && strtotime($OutDate.' '.$OutTime)>strtotime($work_date.' '.$ShiftOutTime)){
                                $ot_time = getHoursMinutes(strtotime($OutDate.' '.$OutTime)-strtotime($work_date.' '.$ShiftOutTime));
                            }
                            $ot_time = explode(':',$ot_time);
                            if( $ot_time[1]>44){
                                $total_ot_hour = ((int)$ot_time[0])+1;
                            }else{
                                $total_ot_hour = ((int)$ot_time[0]);
                            }
                            $slab = calculate_slab($total_ot_hour);
                            if (!empty($slab)) {
                                $slab1 = $slab[0];
                                $slab2 = $slab[1];
                            }
                        }
                    }
                    if(!empty($InTime)){
                        $InTime = date_conversion('H:i:s',$InTime);
                    }else{
                        $InTime = '00:00:00';
                    }
                    if(!empty($OutTime)){
                        $OutTime = date_conversion('H:i:s',$OutTime);
                    }else{
                        $OutTime = '00:00:00';
                    }
                    
                    if($InTime == '00:00:00' && $OutTime == '00:00:00' && $day_status!='W'){
                        $day_status = 'A';
                    }
                    if ($work_date<$doj) {
                        $day_status = '';
                    }
                    //echo $InTime.'-->'.$OutTime.'->'.$day_status.'<br/>';//exit;
                    $DateAdded = date('Y-m-d H:i:s');
                    $AddedBy = user_id();
                    $manual_data_dph[] = [
                        'EmployeeID' => $employee_id,
                        'WorkDate' => $work_date,
                        'PunchOutDate' => $OutDate,
                        'ShiftID' => $shift_id,
                        'ShiftInTime' => $ShiftInTime,//date_conversion('H:i:s',$ShiftInTime),
                        'ShiftOutTime' => $ShiftOutTime,//date_conversion('H:i:s',$ShiftOutTime),
                        'PayHour' => $pay_hour,
                        'DayStatus' => $day_status,
                        'IsDefault' => 1,
                        'LateHour' => $late_hour,
                        'ARADayStatus' => $day_status,
                        'InTime' => $InTime,
                        'OutTime' => $OutTime,
                        'slab_1_ot'=>(int)$slab1,
                        'slab_2_ot'=>(int)$slab2,
                        'w_ot'=>(int)$w_ot,
                        'DateAdded' => $DateAdded,
                        'AddedBy' => $AddedBy
                    ];
                }
                if (isset($InDate)) {
                    if(!empty($InTime)){
                        $InTime = date_conversion('H:i:s',$InTime);
                    }else{
                        $InTime = NULL;
                    }
                    if(!empty($OutTime)){
                        $OutTime = date_conversion('H:i:s',$OutTime);
                    }else{
                        $OutTime = NULL;
                    }
                    $manual_data_da[] = [
                        'EmployeeID' => $employee_id,
                        'WorkDate' => $work_date,
                        'PunchOutDate'=>$OutDate,
                        'ShiftID' =>$shift_id,
                        'PunchIN'=>$InTime,//date_conversion('H:i:s',$InTime),
                        'PunchOUT'=>$OutTime,//date_conversion('H:i:s',$OutTime),
                        'IsManual' => 1,
                        'IsLate' => $late,
                        'AddedBy' => user_id(),
                        'DateAdded' => date('Y-m-d H:i:s'),
                        //'Remarks' => $remarks
                    ];
                    $manual_data_track[] = [
                        'EmployeeID' => $employee_id,
                        'WorkDate' => $work_date,
                        'OutDate' => $OutDate,
                        'ShiftID' =>$shift_id,
                        'InTime'=>$InTime,//date_conversion('H:i:s',$InTime),
                        'OutTime'=>$OutTime,//date_conversion('H:i:s',$OutTime),
                        'AddedBy' => user_id(),
                        'DateAdded' => date('Y-m-d H:i:s'),
                        'Remarks' => $remarks
                    ];
                }
            }
            //echo '<pre>';print_r($manual_data_da);
            //echo '<pre>';print_r($manual_data_dph);exit;
            if(!empty($manual_data_dph)) {
                // delete old data on this date before newly insert
                //$this->deleteExistingData('daywise_pay_hour',$EmployeeID,$from_date,$to_date);
                //$this->attendance->table('daywise_pay_hour')->insert($manual_data_dph,'batch');
                foreach($manual_data_dph as $data){
                    $update_attn = $this->attendance->table("daywise_pay_hour")->where(['WorkDate'=>$data['WorkDate'],'EmployeeID'=>$data['EmployeeID']]);
                    $update_attn = $update_attn->update($data);
                }
            }
            if(!empty($manual_data_da)) {
                // delete old data on this date before newly insert
                //$this->deleteExistingData('daily_attendance',$EmployeeID,$from_date,$to_date);
                //$this->attendance->table('daily_attendance')->insert($manual_data_da,'batch');
                foreach($manual_data_da as $data){
                    $update_attn = $this->attendance->table("daily_attendance")->where(['WorkDate'=>$data['WorkDate'],'EmployeeID'=>$data['EmployeeID']]);
                    $update_attn = $update_attn->update($data);
                }
            }
            if(!empty($manual_data_track)) {
                $this->attendance->table('manual_attendence')->insert($manual_data_track,'batch');
            }
            echo "<h4 class='text text-info'>Inserted Successfully.</h4>";
        }
        else
            echo "<h4 class='text text-danger'>There is no data.</h4>";
    }
    /**
     * Show the form for device attendance data.
     *
     * @return view
     */
    public function device()
    {
        $heading = "Attendance";
        $title = "Attendance Device";
        return view('attendance/attendance_device',compact('title','heading'));
    }

    /**
     * Get employee_code,shift id and dates for making daily attendance information
     *
     */
    public function daily_attendance() {
        $start_time = microtime(true);
        $inputs = $_POST;
        $employee_id = json_decode($inputs['employee_id']);
        $holiday_but_present= $inputs['holiday_but_present'] ?? '';
        $leave_but_present= $inputs['leave_but_present'] ?? '';
        $holiday_present_day_status= $inputs['holiday_present_day_status'] ?? '';

        $data = 'No data found for process.';
        if(!is_array($employee_id))
            $employee_id = [$inputs['employee_id']];
        //echo json_encode($employee_id);exit;
        if(!empty($employee_id)) {
            $from_date = date_conversion('Y-m-d',$inputs['from_date']);
            $to_date = date_conversion('Y-m-d',$inputs['to_date']);
            $attendance_data = $this->attendance->attendanceData($employee_id, $from_date, $to_date);
            $attendance_data = $attendance_data->fetchAll();
            $work_date_array = [];
            $employee_id_array = [];
            //dd($attendance_data);
            if(!empty($attendance_data) >0) {
                foreach ($attendance_data as $row) {
                    $in_time = null;
                    $out_time = null;
                    $ot_time = '00:00';
                    $late_hour = 0;
                    $pay_hour = 0;
                    $work_hour = 0;
                    $bg_color = '';

                    $employee_id = $row['id'];
                    $employee_code = $row['EmployeeCode'];
                    $offDay =   $row['OffDay'];
                    $shift = $row['ShiftIDText'];
                    $shift_id = $row['ShiftID'];
                    $InTimeStartMargin = $row['InTimeStartMargin'];
                    $OutTimeEndMargin = $row['OutTimeEndMargin'];
                    $work_date = date_conversion('Y-m-d',$row['WorkDate']); //date('Y-m-d',strtotime($row['WorkDate']));
                    $shift_in_time = date_conversion('h:i A',$row['ShiftInTime']);// date('h:i A',strtotime($row['ShiftInTime']));
                    $shift_out_time = date_conversion('h:i A',$row['ShiftOutTime']);// date('h:i A',strtotime($row['ShiftOutTime']));

                    $in_time = $row['InTime']; //date('h:i A',strtotime($row['InTime']));
                    $out_time = $row['OutTime']; //date('h:i A',strtotime($row['OutTime']))
                    $work_date_array[] = $work_date;
                    $employee_id_array[] = $employee_id;

                    $late_margin = intval($row['LateMargin']);
                    $day_status = 'P';
                    if (!is_null($in_time) && $in_time>$shift_in_time){
                        $late_hour = calculate_late_hour($in_time,$shift_in_time,$late_margin);
                    }
                    if (!is_null($shift_in_time) && !is_null($out_time)) {
                        //$pay_hour = $this->calculate_pay_hour($out_time, $shift_in_time);
                        $pay_hour = getHoursMinutes((strtotime($row['PunchOutDate'].' '.$row['OutTime'])-strtotime($row['WorkDate'].' '.$row['ShiftInTime'])),1);
                    }
                    if ( !is_null($in_time) && !is_null($out_time)) {
                        //$work_hour = $this->calculate_pay_hour($out_time, $in_time);
                        $work_hour = getHoursMinutes((strtotime($row['PunchOutDate'].' '.$row['OutTime'])-strtotime($row['WorkDate'].' '.$row['ShiftInTime'])),1);
                    }

                    if (is_null($in_time) && is_null($out_time)) {
                        $day_status = 'A';
                    }
                    //if ($late_hour != 0) {
                    if($late_hour != 0 && $row['ShiftType']!='NoShift') {
                        $day_status = 'L';
                    }
                    //echo strtolower(date("l", strtotime($work_date)));exit;
                    if($offDay!=strtolower(date("l", strtotime($work_date)))){
                        /*use $OutTimeEndMargin hereto calculate day status EO with programming*/
                        $day_status = $this->retrieve_day_status($employee_id, $work_date, $day_status, $leave_but_present, $holiday_but_present);
                    }else{
                        $day_status='W';
                    }
                    
                    $total_ot_hour = 0;
                    $w_ot = 0;
                    $slab1 = null;
                    $slab2 = null;
                    if ($row['DOJ'] > $work_date || $row['separation_effective_date'] < $work_date && !is_null($row['separation_effective_date'])) {
                        $day_status = null;
                    }else {
                        if (check_ot_status($row['OT'])) {
                            //if (!is_null($out_time) && $day_status!='W'){
                            if (!is_null($out_time) && $day_status!='W' && $row['ShiftType']!='NoShift'){
                                $p_out_time =  $row['PunchOutDate'].' '.$row['OutTime'];
                                $p_out_time = strtotime($p_out_time);
                                $p_shiftout_time =  $row['WorkDate'].' '.$row['ShiftOutTime'];
                                $p_shiftout_time = strtotime($p_shiftout_time);
                                if($p_out_time>$p_shiftout_time){
                                    $ot_time = getHoursMinutes($p_out_time-$p_shiftout_time);
                                }
                                $ot_time = explode(':',$ot_time);
                                if( $ot_time[1]>44){
                                    $total_ot_hour = ((int)$ot_time[0])+1;
                                }else{
                                    $total_ot_hour = ((int)$ot_time[0]);
                                }
                                $slab = calculate_slab($total_ot_hour);
                                if (!empty($slab)) {
                                    $slab1 = $slab[0];
                                    $slab2 = $slab[1];
                                }
                            }
                            //if($day_status=='W'){
                            if($day_status=='W' && $row['ShiftType']!='NoShift'){
                                if(!empty($out_time)){
                                    $subtract = 1;
                                    if( explode(':',$row['OutTime'])[1]>44){
                                        $subtract = 0;
                                    }
                                    $pay_hour = getHoursMinutes((strtotime($row['PunchOutDate'].' '.$row['OutTime'])-strtotime($row['WorkDate'].' '.$row['ShiftInTime'])));
                                    if($pay_hour>'06:00'){
                                        $pay_hour = (explode(':',$pay_hour)[0]-1).':'.explode(':',$pay_hour)[1];
                                    }
                                    if(explode(':',$pay_hour)[1]>44){
                                        $pay_hour = explode(':',$pay_hour)[0]+1;
                                    }else{
                                        $pay_hour = explode(':',$pay_hour)[0];
                                    }
                                    $work_hour = getHoursMinutes((strtotime($row['PunchOutDate'].' '.$row['OutTime'])-strtotime($row['WorkDate'].' '.$row['ShiftInTime'])),$subtract);
                                    $w_ot_array = explode('.',$pay_hour);
                                    $w_ot = $w_ot_array[0];
                                    if (!empty($late_hour) ) {
                                        $day_status = 'LW';
                                    }else{
                                        $day_status = 'PW';
                                    }
                                }
                            }
                        }
                    }

                    // hide before DOJ and after separation effective date
                    if (is_null($day_status))
                        $bg_color = 'd-none';
                    elseif ( ($leave_but_present == 1 || $holiday_but_present == 1) && !in_array($day_status,['A','LV','H','W','P','L']) ) { //separate this attendance data as color(separating for extra benefit)
                        $bg_color = 'bg bg-warning';
                    }

                    $data .= '<tr class="'.$bg_color.'">
                            <td>'.$employee_code.'</td>
                            <td>'.$row['EmployeeName'].'</td>
                            <td>'.date_conversion('d-m-Y',$work_date).'</td>
                            <td>'.$shift.'</td>
                            <td>'.$row['Alais'].'</td>
                            <td><input type="checkbox" class="" name="IsDefault[]" value="1" checked></td>
                            <td>'.$day_status.'</td>
                            <td>100%</td>
                            <td>'.$late_hour.'</td>
                            <td>00</td>
                            <td>'.$pay_hour.'</td>
                            <td>'.$work_hour.'</td>
                            <td>'.$shift_in_time.'</td>
                            <td>'.$shift_out_time.'</td>
                            <td>'.$in_time.'</td>
                            <td>'.$out_time.'</td>
                            <td>'.$total_ot_hour.'</td>
                            <td>'.$slab1.'</td>
                            <td>'.$slab2.'</td>
                            <input type="hidden" name="EmployeeCode[]" class="EmployeeCode" value="'.$employee_code.'">
                            <input type="hidden" name="EmployeeID[]" class="EmployeeID" value="'.$employee_id.'">
                            <input type="hidden" name="WorkDate[]" class="WorkDate" value="'.$work_date.'">
                            <input type="hidden" name="PunchOutDate[]" class="PunchOutDate" value="'.$row['PunchOutDate'].'">
                            <input type="hidden" name="ShiftID[]" class="ShiftID" value="'.$shift_id.'">
                            <input type="hidden" name="InTime[]" class="InTime" value="'.$row['InTime'].'">
                            <input type="hidden" name="OutTime[]" class="OutTime" value="'.$row['OutTime'].'">
                            <input type="hidden" name="ShiftInTime[]" class="ShiftInTime" value="'.$row['ShiftInTime'].'">
                            <input type="hidden" name="ShiftOutTime[]" class="ShiftOutTime" value="'.$row['ShiftOutTime'].'">
                            <input type="hidden" name="PayHour[]" class="PayHour" value="'.$pay_hour.'">
                            <input type="hidden" name="DayStatus[]" class="DayStatus" value="'.$day_status.'">
                            <input type="hidden" name="LateHour[]" class="LateHour" value="'.$late_hour.'">
                            <input type="hidden" name="OTHour[]" class="OTHour" value="'.$total_ot_hour.'">
                            <input type="hidden" name="slab1[]" class="slab1" value="'.$slab1.'">
                            <input type="hidden" name="slab2[]" class="slab2" value="'.$slab2.'">
                            <input type="hidden" name="w_ot[]" class="w_ot" value="'.$w_ot.'">
                    </tr>';
                }
            }
        }
        $end_time = microtime(true);
        //myLog('Runs in '.($start_time-$end_time).' sec');
        echo ($data);
    }



    /**
     * Show the form for attendance form.
     *
     * @return view
     */
    public function process()
    {
        $heading = "Attendance";
        $title = "Attendance Process";
        return view('attendance/attendance_process',compact('title','heading'));
    }

    public function save_attendance_process_data() {
        $inputs = $_POST;

        $EmployeeCodes = json_decode($inputs['EmployeeCode']);
        $EmployeeIDs = json_decode($inputs['EmployeeID']);
        $WorkDates = json_decode($inputs['WorkDate']);
        $PunchOutDates = json_decode($inputs['PunchOutDate']);
        $ShiftIDs = json_decode($inputs['ShiftID']);
        $PayHours = json_decode($inputs['PayHour']);
        $slab1s = json_decode($inputs['slab1']);
        $slab2s = json_decode($inputs['slab2']);
        $w_ots  = json_decode($inputs['w_ot']);
        $ShiftInTime = json_decode($inputs['ShiftInTime']);
        $ShiftOutTime = json_decode($inputs['ShiftOutTime']);
        $DayStatus = json_decode($inputs['DayStatus']);
        $IsDefault = 1; // fixed so that we did not know
        $LateHour = json_decode($inputs['LateHour']);
        $InTime = json_decode($inputs['InTime']);
        $OutTime = json_decode($inputs['OutTime']);

        $from_date = reset($WorkDates);
        $to_date = end($WorkDates);

        $data = 'There is no data to process.';
        //dd($data);
        if (!empty($inputs)) {
            $attendance_process_data = [];
            $ot_data = [];
            $total = count($EmployeeCodes);
            for ($i=0; $i<$total; $i++) {
                $EmployeeCode = $EmployeeCodes[$i];
                $EmployeeID = $EmployeeIDs[$i];
                $WorkDate = $WorkDates[$i];
                $PunchOutDate = $PunchOutDates[$i];

                $ShiftID = $ShiftIDs[$i];
                if($PayHours[$i]<0){
                    $PayHour = 0;
                }else{
                    $PayHour = $PayHours[$i] ;
                }
                
                $slab_1 = $slab1s[$i] ?? 0;
                $slab_2 = $slab2s[$i] ?? 0;
                $w_ot = $w_ots[$i] ?? 0;
                $DateAdded = date('Y-m-d H:i:s');
                $AddedBy = user_id();
                $attendance_process_data[] = [
                    'EmployeeCode' => $EmployeeCode,
                    'EmployeeID' => $EmployeeID,
                    'WorkDate' => $WorkDate,
                    'PunchOutDate' => $PunchOutDate,
                    'ShiftID' => $ShiftID,
                    'ShiftInTime' => date_conversion('H:i:s',$ShiftInTime[$i]), //$inputs['ShiftInTime'][$i],
                    'ShiftOutTime' => date_conversion('H:i:s',$ShiftOutTime[$i]), //$inputs['ShiftOutTime'][$i],
                    'PayHour' => $PayHour,
                    'DayStatus' => $DayStatus[$i],
                    'IsDefault' => $IsDefault,
                    'LateHour' => $LateHour[$i],
                    'ARADayStatus' => $DayStatus[$i],
                    //'InTime' => date_conversion('H:i:s',$InTime[$i]),//$InTime[$i],
                    //'OutTime' => date_conversion('H:i:s',$OutTime[$i]),//$OutTime[$i],
                    'InTime' => $InTime[$i],
                    'OutTime' => $OutTime[$i],
                    'slab_1_ot'=>(int)$slab_1,
                    'slab_2_ot'=>(int)$slab_2,
                    'w_ot'=>(int)$w_ot,
                    'DateAdded' => $DateAdded,
                    'AddedBy' => $AddedBy
                    //'EarlyOutHour' => $inputs['EarlyOutHour'][$i]
                ];
            }
            //dd($this->attendance->table('daywise_pay_hour')->insert($attendance_process_data,'batch'));
            if(!empty($attendance_process_data)) {
                // delete old data on this date before newly insert
                $this->deleteExistingData('daywise_pay_hour',$EmployeeIDs,$from_date,$to_date);
                //print_r($this->attendance->table('daywise_pay_hour')->insert($attendance_process_data,'batch'));exit;

                $this->attendance->table('daywise_pay_hour')->insert($attendance_process_data,'batch');
                $data = "Attendance Data Processed Successfully.";
            }
            else {
                $data = "Attendance data is processed already.";
            }
        }
        echo $data;
    }


    private function calculate_pay_hour(string $out_time, string $in_time)
    {
        $date1 = date_create($out_time);
        $date2 = date_create($in_time);
        $diff = date_diff($date1,$date2);
        $pay_hour = abs(($diff->format("%H")-1).'.'.$diff->format("%I"));
        return $pay_hour;
    }


    private function is_salary_processed($ToDate)
    {
        return !!$this->employee->select('month_wise_salary_info',['where'=>["ToDate='$ToDate'"]])->rowCount();
    }

    private function is_uploadable($ToDate)
    {
        return !$this->is_salary_processed($ToDate);
    }

    private function deleteExistingData(string $string, $employee_id, string $from_date, string $to_date)
    {
        $from_date = date_conversion('Y-m-d',$from_date);
        $to_date = date_conversion('Y-m-d',$to_date);
        $employee_id = implode(',',array_unique($employee_id));
        return $this->attendance->delete($string,["WorkDate>='$from_date'","WorkDate<='$to_date'","EmployeeID IN($employee_id)"]);
    }

    /**
     * @param $employee_id
     * @param string|null $work_date
     * @param string $day_status
     * @param string $leave_but_present
     * @param string $holiday_but_present
     * @return mixed|string
     */
    private function retrieve_day_status(int $employee_id, string $work_date, $day_status, int $leave_but_present, int $holiday_but_present)
    {
        $leave_data = null;
        $absent_data = null;
        $workoff_data = null;
        $workoff_data = $this->attendance->table('workoff_calendar')->where('EmployeeID', $employee_id)->where('WorkOffDate', $work_date)->fetch();
        $leave_data = $this->attendance->checkLeave($employee_id, $work_date, $work_date);
        $absent_data = $this->attendance->checkAbsent($employee_id, $work_date, $work_date);

        if ($day_status != 'A') {
            if ($leave_but_present == 3 || $holiday_but_present == 3) {
                //take only leave data (ignore attendance) if not
                //take only workoff data (ignore attendance)
                if ($leave_data) {
                    $real_day_status = $leave_data['LeaveType'];//'LV';//comment for laave type
                    $day_status = $real_day_status; // LV
                } elseif ($workoff_data) {
                    $real_day_status = $workoff_data->DayType;
                    $day_status = $real_day_status; // for W, H
                }
            } elseif ($leave_but_present == 2 || $holiday_but_present == 2) {
                //take only attendance data (ignore leave) if not
                //take only attendance (ignore workoff data)
                if ($leave_data) {
                    $real_day_status = $leave_data['LeaveType'];//'LV';//comment for laave type
                    $day_status = $day_status . $real_day_status; // PLV, LLV
                } elseif ($workoff_data) {
                    $real_day_status = $workoff_data->DayType;
                    $day_status = $day_status . $real_day_status; // for PH, PW, LH, LW, W, H
                }
            }
        }
        if ($workoff_data) {
            $day_status = $workoff_data->DayType;
        }
        if ($leave_data) {
            $day_status = $leave_data['LeaveType'];//'LV';//comment for laave type
        }
        if($absent_data){
            $day_status = 'A';
        }
        return $day_status;
    }

}
