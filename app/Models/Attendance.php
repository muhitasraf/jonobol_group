<?php

namespace App\Models;

use http\QueryString;

class Attendance extends Model {
    //protected $pdo;
    public function __construct()
    {
        parent::__construct();
    }

    public function getActiveEmployee($EmployeeCode) {
        if(!empty($EmployeeCode)){
            return $this->pdo->query("SELECT id,BadgeNumber FROM employee_info WHERE EmployeeStatus=0 AND BadgeNumber!='' AND EmployeeCode='".$EmployeeCode."'");
        }else{
            return $this->pdo->query("SELECT id,BadgeNumber FROM employee_info WHERE EmployeeStatus=0 AND BadgeNumber!='' ");
        }
    }
    public function getEmployeeDataForManualAttendance($employee_id=[],$form_date,$to_date,$attendence_type,$holiday_data,$leave_data) {
        if (is_array($employee_id))
            $employee_id = implode('","',$employee_id);
        $form_date = date_conversion('Y-m-d',$form_date);
        $to_date = date_conversion('Y-m-d',$to_date);
        
        if(empty($holiday_data) && empty($leave_data)){//return $attendence_type.$holiday_data.$leave_data;
            return $this->pdo->query('SELECT ei.id as employee_id,ei.EmployeeName,ei.EmployeeCode,ei.OT,ei.DOJ,ei.OffDay,da.PunchIN as InTime,da.PunchOUT as OutTime,da.WorkDate,
                da.PunchOutDate,NULL as WorkOffDate,NULL as FromDate  FROM employee_info ei
                INNER JOIN daily_attendance da on ei.id=da.EmployeeID
                WHERE (da.WorkDate between "'.$form_date.'" AND "'.$to_date.'") '.$attendence_type.' AND ei.id IN("'.$employee_id.'") AND ei.EmployeeStatus=0               
            ');
        }
        if(!empty($holiday_data) && !empty($leave_data)){
            return $this->pdo->query('SELECT a.*,b.*,c.* FROM (
                    ( SELECT ei.id as employee_id,ei.EmployeeName,ei.EmployeeCode,ei.OT,ei.DOJ,ei.OffDay,da.PunchIN as InTime,da.PunchOUT as OutTime,da.WorkDate,da.PunchOutDate
                    FROM employee_info ei
                    INNER JOIN daily_attendance da on ei.id=da.EmployeeID
                    WHERE (da.WorkDate between "'.$form_date.'" AND "'.$to_date.'") '.$attendence_type.' AND ei.id IN("'.$employee_id.'") AND ei.EmployeeStatus=0
                    ) a
                    
                    LEFT JOIN 
            
                    ( SELECT EmployeeID,DayType,WorkOffDate
                    FROM workoff_calendar wc
                    WHERE (wc.WorkDate between "'.$form_date.'" AND "'.$to_date.'") AND wc.EmployeeID IN("'.$employee_id.'")
                    ) b
                    ON (a.employee_id=b.EmployeeID AND a.WorkDate=b.WorkOffDate ) 
            
                    LEFT JOIN
                    ( SELECT EmployeeID,FromDate,ToDate
                    FROM emp_leave_transaction elt
                    WHERE (elt.FromDate>= "'.$form_date.'" AND elt.FromDate<="'.$to_date.'") AND elt.EmployeeID IN("'.$employee_id.'")
                    ) c
                    ON (a.employee_id=c.EmployeeID AND a.WorkDate>=c.FromDate AND a.WorkDate<=c.ToDate )
                ) ORDER BY a.employee_id,a.WorkDate ASC'
            );
        }
        if(!empty($holiday_data) && empty($leave_data)){
            return $this->pdo->query('SELECT a.*,b.* FROM (
                    ( SELECT ei.id as employee_id,ei.EmployeeName,ei.EmployeeCode,ei.OT,ei.DOJ,ei.OffDay,da.PunchIN as InTime,da.PunchOUT as OutTime,da.WorkDate,
                    da.PunchOutDate,NULL as FromDate FROM employee_info ei
                    INNER JOIN daily_attendance da on ei.id=da.EmployeeID
                    WHERE (da.WorkDate between "'.$form_date.'" AND "'.$to_date.'") '.$attendence_type.' AND ei.id IN("'.$employee_id.'") AND ei.EmployeeStatus=0
                    ) a
                    
                    LEFT JOIN 
            
                    ( SELECT EmployeeID,DayType,WorkOffDate
                    FROM workoff_calendar wc
                    WHERE (wc.WorkDate between "'.$form_date.'" AND "'.$to_date.'") AND wc.EmployeeID IN("'.$employee_id.'")
                    ) b
                    ON (a.employee_id=b.EmployeeID AND a.WorkDate=b.WorkOffDate ) 
                ) ORDER BY a.employee_id,a.WorkDate ASC'
            );
        }
        if(empty($holiday_data) && !empty($leave_data)){
            return $this->pdo->query('SELECT a.*,c.* FROM (
                    ( SELECT ei.id as employee_id,ei.EmployeeName,ei.EmployeeCode,ei.OT,ei.DOJ,ei.OffDay,da.PunchIN as InTime,da.PunchOUT as OutTime,da.WorkDate,
                    da.PunchOutDate,NULL as WorkOffDate FROM employee_info ei
                    INNER JOIN daily_attendance da on ei.id=da.EmployeeID
                    WHERE (da.WorkDate between "'.$form_date.'" AND "'.$to_date.'") '.$attendence_type.' AND ei.id IN("'.$employee_id.'") AND ei.EmployeeStatus=0
                    ) a 
            
                    LEFT JOIN
                    ( SELECT EmployeeID,FromDate,ToDate
                    FROM emp_leave_transaction elt
                    WHERE (elt.FromDate>= "'.$form_date.'" AND elt.FromDate<="'.$to_date.'") AND elt.EmployeeID IN("'.$employee_id.'")
                    ) c
                    ON (a.employee_id=c.EmployeeID AND a.WorkDate>=c.FromDate AND a.WorkDate<=c.ToDate )
                ) ORDER BY a.employee_id,a.WorkDate ASC'
            );
        }
    }
    public function getShiftInfo($shiftID){
        return $this->pdo->query('SELECT sp.ShiftID,sp.ShiftType,sp.InTime,sp.OutTime,sp.id shift_id,sp.RoundAfter,sp.RoundFor FROM
            shift_plan sp
            WHERE sp.id ="'.$shiftID.'"
         ');
    }
    public function tmpAttendanceDeviceDataByEmployeeCode($employee_code=[]) {
        if (is_array($employee_code))
            $employee_code = implode('","',$employee_code);
        return $this->pdo->query('SELECT ei.id,ei.EmployeeName,ei.EmployeeCode,ei.ShiftID,sp.ShiftID ShiftIDText,sp.ShiftType,dvd.WorkDate,dvd.PunchType,dvd.InTime,dvd.OutTime FROM employee_info ei
            INNER JOIN shift_plan sp on ei.ShiftID=sp.id
            INNER JOIN (SELECT EmployeeCode,WorkDate,PTime,PunchType,GROUP_CONCAT(InTime) as InTime,GROUP_CONCAT(OutTime) as OutTime FROM(
            SELECT EmployeeCode,WorkDate,PTime,PunchType,(CASE WHEN PunchType=1 THEN PTime END) as InTime,(CASE WHEN PunchType!=1 THEN PTime END) as OutTime from tmp_device_row_data GROUP BY PunchType,WorkDate,EmployeeCode
            )dvd GROUP BY WorkDate,EmployeeCode) dvd
            ON ei.EmployeeCode=dvd.EmployeeCode WHERE ei.EmployeeCode IN("'.$employee_code.'")  AND ei.EmployeeStatus=0
        ');
    }
    public function tmpSyncAttendanceDataByEmployeeCode($BadgeNumber=[]) {
        if (is_array($BadgeNumber))
            $BadgeNumber = implode('","',$BadgeNumber);
        return $this->pdo->query('SELECT ei.id,ei.EmployeeName,ei.EmployeeCode,ei.ShiftID,sp.ShiftID ShiftIDText,sp.ShiftType,tdrd.WorkDate,tdrd.PunchIN as InTime,
            tdrd.PunchOUT as OutTime,tdrd.PunchOutDate,tdrd.PunchOutTime FROM employee_info ei
            INNER JOIN shift_plan sp on ei.ShiftID=sp.id
            INNER JOIN tmp_device_row_data tdrd
            ON ei.BadgeNumber=tdrd.BadgeNumber WHERE ei.BadgeNumber IN("'.$BadgeNumber.'")  AND ei.EmployeeStatus=0
        ');
        /*return $this->pdo->query('
            SELECT md.WorkDate as WD,tdrd.BadgeNumber,tdrd.WorkDate,tdrd.PunchIN as InTime,
            tdrd.PunchOUT as OutTime,tdrd.PunchOutDate,tdrd.PunchOutTime FROM tmp_device_row_data tdrd
            OUTER JOIN month_day md ON md.WorkDate=tdrd.WorkDate
        ');*/
    
    
        /*return $this->pdo->query('
            SELECT md.WorkDate as WD,t1.* FROM month_day md
            LEFT JOIN (SELECT ei.id,ei.EmployeeName,ei.EmployeeCode,ei.ShiftID,sp.ShiftID ShiftIDText,sp.ShiftType,tdrd.WorkDate,tdrd.PunchIN as InTime,
            tdrd.PunchOUT as OutTime,tdrd.PunchOutDate,tdrd.PunchOutTime FROM employee_info ei
            INNER JOIN shift_plan sp on ei.ShiftID=sp.id
            INNER JOIN tmp_device_row_data tdrd
            ON ei.BadgeNumber=tdrd.BadgeNumber WHERE ei.BadgeNumber IN("'.$BadgeNumber.'")  AND ei.EmployeeStatus=0) t1 ON md.WorkDate=t1.WorkDate
            WHERE md.year=2021 AND month=9
        ');*/
    }
    public function replaceAttendenceData($duty_date) {//return $duty_date;
        return $this->pdo->query('SELECT ei.id,ei.EmployeeName,ei.EmployeeCode,ei.ShiftID,sp.ShiftID ShiftIDText,sp.ShiftType,dvd.WorkDate,dvd.InTime,dvd.OutTime
            FROM employee_info ei
            INNER JOIN shift_plan sp on ei.ShiftID=sp.id
            INNER JOIN (SELECT EmployeeID,WorkDate,GROUP_CONCAT(InTime) as InTime,GROUP_CONCAT(OutTime) as OutTime FROM(
            SELECT EmployeeID,WorkDate,PunchIN as InTime,PunchOUT as OutTime from device_row_data
            WHERE WorkDate="'.$duty_date.'" GROUP BY WorkDate,EmployeeID
            )dvd GROUP BY WorkDate,EmployeeID) dvd
            ON ei.id=dvd.EmployeeID WHERE ei.EmployeeStatus=0
        ');
    }
    public function tempAttendanceDeviceDataByDate($form_date,$to_date) {
        return $this->pdo->query("SELECT ei.id,ei.EmployeeCode,ei.ShiftID,sp.InTime,tdd.WorkDate,tdd.PunchType,tdd.PTime,tdd.PunchIN,tdd.PunchOUT,tdd.DeviceID,tdd.AddedBy,tdd.DateAdded,tdd.DiffTime FROM employee_info ei
            INNER JOIN shift_plan sp on ei.ShiftID=sp.id
            INNER JOIN tmp_device_row_data tdd ON ei.EmployeeCode=tdd.EmployeeCode where (WorkDate between '$form_date' AND '$to_date') AND ei.EmployeeStatus=0
        ");
    }
    public function tempSyncAttendanceDataByDate($form_date,$to_date) {
        $sql = "SELECT ei.id,ei.EmployeeCode,ei.ShiftID,sp.InTime,tdd.WorkDate,tdd.PunchIN,tdd.PunchOUT,tdd.PunchOutDate,tdd.PunchOutTime,tdd.AddedBy,tdd.DateAdded FROM employee_info ei
            INNER JOIN shift_plan sp on ei.ShiftID=sp.id
            INNER JOIN tmp_device_row_data tdd ON ei.BadgeNumber=tdd.BadgeNumber
            where (WorkDate between '$form_date' AND '$to_date') AND ei.EmployeeStatus=0
        ";
         $sql = "SELECT ei.id,ei.EmployeeCode,ei.ShiftID,sp.InTime,tdd.WorkDate,tdd.PunchIN,tdd.PunchOUT,tdd.PunchOutDate,tdd.PunchOutTime,tdd.AddedBy,tdd.DateAdded
                FROM employee_info ei
                INNER JOIN shift_plan sp ON ei.ShiftID=sp.id
                INNER JOIN tmp_device_row_data tdd ON ei.BadgeNumber=tdd.BadgeNumber
                WHERE (tdd.WorkDate between '$form_date' AND '$to_date') AND ei.EmployeeStatus=0
                UNION
                SELECT ei.id,ei.EmployeeCode,sr.ShiftID,sp.InTime,tdd.WorkDate,tdd.PunchIN,tdd.PunchOUT,tdd.PunchOutDate,tdd.PunchOutTime,tdd.AddedBy,tdd.DateAdded
                FROM employee_info ei
                LEFT JOIN tmp_device_row_data tdd ON ei.BadgeNumber=tdd.BadgeNumber
                INNER JOIN shift_roster sr ON (ei.id=sr.EmployeeID AND tdd.WorkDate=sr.ShiftDate)
                INNER JOIN shift_plan sp ON sr.ShiftID=sp.id
                WHERE (tdd.WorkDate between '$form_date' AND '$to_date') AND ei.EmployeeStatus=0 AND ei.SRA=1
        ";
        //myLog($sql);
        return $this->pdo->query($sql);
    }
    public function devAttendanceDeviceDataByDate($duty_date) {
        return $this->pdo->query("SELECT ei.id,ei.EmployeeCode,ei.ShiftID,sp.InTime,tdd.WorkDate,tdd.PunchType,tdd.PTime,tdd.DeviceID,tdd.AddedBy,tdd.DateAdded,tdd.DiffTime FROM employee_info ei
            INNER JOIN shift_plan sp on ei.ShiftID=sp.id
            INNER JOIN device_row_data tdd ON ei.EmployeeCode=tdd.EmployeeCode where WorkDate = '$duty_date'  AND ei.EmployeeStatus=0
        ");
    }
    public function duty_date_data($duty_date,$employee_id) {
        return $this->pdo->query('SELECT id,EmployeeCode,EmployeeID,PunchIN,PunchOUT,WorkDate,PunchOutDate,PunchOutTime FROM device_row_data
         where EmployeeID IN('.$employee_id.')  AND WorkDate = "'.$duty_date.'"
        ');
    }
    public function attendanceDeviceData($employee_id=[], $from_date=null, $to_date=null) {
        if (is_array($employee_id))
            $employee_id = implode('","',$employee_id);
        $sql = 'SELECT ei.id,ei.EmployeeName,ei.EmployeeCode,ei.ShiftID,sp.ShiftID ShiftIDText,sp.ShiftType,eam.WorkDate,dvd.PunchIN as InTime,dvd.PunchOUT as OutTime,dvd.PunchOutDate,dvd.PunchOutTime
                FROM employee_attn_month eam
                LEFT JOIN device_row_data dvd ON (eam.EmployeeID=dvd.EmployeeID AND eam.WorkDate=dvd.WorkDate) 
                INNER JOIN employee_info ei on eam.EmployeeID=ei.id
                INNER JOIN shift_plan sp on ei.ShiftID=sp.id
                WHERE (eam.WorkDate between "'.$from_date.'" AND "'.$to_date.'") AND eam.EmployeeID IN("'.$employee_id.'") AND ei.EmployeeStatus=0
                GROUP BY eam.WorkDate,eam.EmployeeID
        ';
         $sql = 'SELECT ei.id,ei.EmployeeName,ei.EmployeeCode,ei.ShiftID,sp.ShiftID ShiftIDText,sp.ShiftType,eam.WorkDate,dvd.PunchIN as InTime,dvd.PunchOUT as OutTime,dvd.PunchOutDate,dvd.PunchOutTime
                FROM employee_attn_month eam
                LEFT JOIN device_row_data dvd ON (eam.EmployeeID=dvd.EmployeeID AND eam.WorkDate=dvd.WorkDate) 
                INNER JOIN employee_info ei on eam.EmployeeID=ei.id
                INNER JOIN shift_plan sp on ei.ShiftID=sp.id
                WHERE (eam.WorkDate between "'.$from_date.'" AND "'.$to_date.'") AND eam.EmployeeID IN("'.$employee_id.'") AND ei.EmployeeStatus=0 AND ei.SRA=0
                GROUP BY eam.WorkDate,eam.EmployeeID
                UNION
                SELECT ei.id,ei.EmployeeName,ei.EmployeeCode,sr.ShiftID,sp.ShiftID ShiftIDText,sp.ShiftType,eam.WorkDate,
                dvd.PunchIN as InTime,dvd.PunchOUT as OutTime,dvd.PunchOutDate,dvd.PunchOutTime
                FROM employee_attn_month eam
                LEFT JOIN device_row_data dvd ON (eam.EmployeeID=dvd.EmployeeID AND eam.WorkDate=dvd.WorkDate) 
                INNER JOIN employee_info ei on eam.EmployeeID=ei.id
                INNER JOIN shift_roster sr on (eam.EmployeeID=sr.EmployeeID AND eam.WorkDate=sr.ShiftDate)
                INNER JOIN shift_plan sp on sr.ShiftID=sp.id
                WHERE (eam.WorkDate between "'.$from_date.'" AND "'.$to_date.'") AND eam.EmployeeID IN("'.$employee_id.'") AND ei.EmployeeStatus=0 AND ei.SRA=1
                GROUP BY eam.WorkDate,eam.EmployeeID
        ';
        //myLog($sql);
        return $this->pdo->query($sql);
    }
    public function attendanceData($employee_id=[], $from_date=null, $to_date=null) {
        if (is_array($employee_id))
            $employee_id = implode('","',$employee_id);
        $sql = 'SELECT ei.id,ei.EmployeeName,ei.EmployeeCode,OT,OTEntitledDate,OffDayOT,
            HolydayBonus,ei.ShiftID,sp.ShiftID ShiftIDText,sp.ShiftType,sp.InTime as ShiftInTime,sp.OutTime as ShiftOutTime,sp.InTimeStartMargin,sp.OutTimeEndMargin,
            sp.Alais,sp.LateMargin,sp.RoundAfter,sp.RoundFor,sp.IsDefaultPlan,da.WorkDate,da.PunchIN as InTime,da.PunchOUT as OutTime,da.PunchOutDate,
            DOJ,separation_effective_date FROM employee_info ei
            INNER JOIN shift_plan sp on ei.ShiftID=sp.id
            INNER JOIN daily_attendance da ON ei.id=da.EmployeeID 
            WHERE (da.WorkDate between "'.$from_date.'" AND "'.$to_date.'") AND ei.id IN("'.$employee_id.'") AND ei.EmployeeStatus=0 GROUP BY da.WorkDate,da.EmployeeID
            ';
        $sql = 'SELECT ei.id,ei.EmployeeName,ei.EmployeeCode,OT,OTEntitledDate,OffDayOT,OffDay,
            HolydayBonus,ei.ShiftID,sp.ShiftID ShiftIDText,sp.ShiftType,sp.InTime as ShiftInTime,sp.OutTime as ShiftOutTime,sp.InTimeStartMargin,sp.OutTimeEndMargin,
            sp.Alais,sp.LateMargin,sp.RoundAfter,sp.RoundFor,sp.IsDefaultPlan,da.WorkDate,da.PunchIN as InTime,da.PunchOUT as OutTime,da.PunchOutDate,
            DOJ,separation_effective_date FROM employee_info ei
            INNER JOIN shift_plan sp on ei.ShiftID=sp.id
            INNER JOIN daily_attendance da ON ei.id=da.EmployeeID 
            WHERE (da.WorkDate between "'.$from_date.'" AND "'.$to_date.'") AND ei.id IN("'.$employee_id.'") AND ei.EmployeeStatus=0 AND ei.SRA=0 GROUP BY da.WorkDate,da.EmployeeID
            UNION
            SELECT ei.id,ei.EmployeeName,ei.EmployeeCode,OT,OTEntitledDate,OffDayOT,OffDay,
            HolydayBonus,sr.ShiftID,sp.ShiftID ShiftIDText,sp.ShiftType,sp.InTime as ShiftInTime,sp.OutTime as ShiftOutTime,sp.InTimeStartMargin,sp.OutTimeEndMargin,
            sp.Alais,sp.LateMargin,sp.RoundAfter,sp.RoundFor,sp.IsDefaultPlan,da.WorkDate,da.PunchIN as InTime,da.PunchOUT as OutTime,da.PunchOutDate,
            DOJ,separation_effective_date FROM employee_info ei
            INNER JOIN daily_attendance da ON ei.id=da.EmployeeID 
            INNER JOIN shift_roster sr on (da.EmployeeID=sr.EmployeeID AND da.WorkDate=sr.ShiftDate)
            INNER JOIN shift_plan sp on sr.ShiftID=sp.id
            WHERE (da.WorkDate between "'.$from_date.'" AND "'.$to_date.'") AND ei.id IN("'.$employee_id.'") AND ei.EmployeeStatus=0 AND ei.SRA=1 GROUP BY da.WorkDate,da.EmployeeID            
        ';
        //myLog($sql);
        return $this->pdo->query($sql);
    }

    public function checkLeave($employee_id, $from_date, $to_date)
    {
        $sql = 'SELECT emp_leave_transaction.EmployeeID,emp_leave_transaction.LeavePolicyID,leave_policy_master.LeaveType FROM emp_leave_transaction
        INNER JOIN leave_policy_master ON emp_leave_transaction.LeavePolicyID=leave_policy_master.id
        WHERE emp_leave_transaction.EmployeeID="'.$employee_id.'" AND emp_leave_transaction.IsApproved=1 AND (emp_leave_transaction.FromDate <= "'.$from_date.'" AND emp_leave_transaction.ToDate >= "'.$to_date.'")';
        //myLog("Leave query:".$sql);
        return $this->pdo->query($sql)->fetch();
    }
    public function checkAbsent($employee_id, $from_date, $to_date)
    {
        $sql = 'SELECT * FROM emp_absent_transaction WHERE EmployeeID="'.$employee_id.'" AND IsApproved=1 AND (FromDate <= "'.$from_date.'" AND ToDate >= "'.$to_date.'")';
        //myLog("Leave query:".$sql);
        return $this->pdo->query($sql)->fetch();
    }
    public function checkAttendance($employee_id, $from_date, $to_date)
    {
        $sql = 'SELECT * FROM daywise_pay_hour WHERE EmployeeID="'.$employee_id.'" AND (WorkDate BETWEEN "'.$from_date.'" AND "'.$to_date.'")';
        return $this->pdo->query($sql)->fetch();
    }

    public function getMissedAttendance(string $where) {
        if ($where)
            $where = rtrim($where, "AND");
        $query = $this->pdo->query("SELECT ei.id,ei.EmployeeName,ei.EmployeeCode,ei.DOJ,sp.ShiftType,sp.InTime as ShiftInTime,sp.OutTime as ShiftOutTime,sp.Alais,
            da.WorkDate,da.PunchIN,da.PunchOUT,dg.name Designation,dp.name  Department,sc.name Section FROM employee_info ei
            INNER JOIN shift_plan sp on ei.ShiftID=sp.id
            INNER JOIN daily_attendance da ON ei.id=da.EmployeeID
            LEFT JOIN settings_master dg ON ei.DesignationID=dg.id
            LEFT JOIN settings_master dp ON ei.DepartmentID=dp.id
            LEFT JOIN settings_master sc ON ei.SectionID=sc.id
            WHERE $where");
        //myLog("query: ".json_encode($query));
        return $query->fetchAll();
    }

    public function getLateAttendance($from_date=null) {
        return $this->pdo->query('SELECT ei.id,ei.EmployeeName,ei.EmployeeCode,PunchCardNo,sp.ShiftType,sp.InTime as ShiftInTime,sp.OutTime as ShiftOutTime,sp.Alais,da.WorkDate,da.PTime,da.PunchType,dg.name Designation,dp.name Department,sc.name Section FROM employee_info ei
            INNER JOIN shift_plan sp on ei.ShiftID=sp.id
            INNER JOIN daily_attendance da ON ei.id=da.EmployeeID
            LEFT JOIN settings_master dg ON ei.DesignationID=dg.id
            LEFT JOIN settings_master dp ON ei.DepartmentID=dp.id
            LEFT JOIN settings_master sc ON ei.SectionID=sc.id
            WHERE (da.WorkDate="'.$from_date.'") AND IsLate=1 AND da.PunchType=1
        ')->fetchAll();
    }

    public function getPresentEmployee(string $where) {
        if ($where)
            $where = rtrim($where, "AND");
       // myLog($where);
        return $this->pdo->query("SELECT ei.id,ei.EmployeeName,ei.EmployeeCode,ei.DOJ,PunchCardNo,sp.ShiftType,sp.InTime as ShiftInTime,sp.OutTime as ShiftOutTime,sp.Alais,
            da.WorkDate,da.PunchIN,da.PunchOUT,dg.name Designation,dp.name Department,sc.name Section FROM employee_info ei
            INNER JOIN shift_plan sp on ei.ShiftID=sp.id
            INNER JOIN daily_attendance da ON ei.id=da.EmployeeID
            LEFT JOIN settings_master dg ON ei.DesignationID=dg.id
            LEFT JOIN settings_master dp ON ei.DepartmentID=dp.id
            LEFT JOIN settings_master sc ON ei.SectionID=sc.id
            WHERE $where")->fetchAll();
    }

    public function attendanceSummary(string $where) {
        if ($where)
            $where = rtrim($where, "AND");
        return $this->pdo->query("SELECT da.WorkDate,da.InTime,da.OutTime,ei.id,ei.EmployeeName,ei.EmployeeCode,OT,OTEntitledDate,OffDayOT,HolydayBonus,ei.ShiftID,sp.ShiftID ShiftIDText,
            sp.ShiftType,sp.InTime as ShiftInTime,sp.OutTime as ShiftOutTime,sp.Alais,sp.LateMargin,sp.RoundAfter,sp.RoundFor,sp.IsDefaultPlan FROM employee_info ei
            INNER JOIN shift_plan sp on ei.ShiftID=sp.id
            INNER JOIN (
                SELECT EmployeeID,WorkDate,GROUP_CONCAT(InTime) as InTime,GROUP_CONCAT(OutTime) as OutTime FROM(
                    SELECT EmployeeID,WorkDate,PunchIN as InTime,PunchOUT as OutTime
                    from daily_attendance
                    GROUP BY WorkDate,EmployeeID
                ) da GROUP BY WorkDate,EmployeeID
            ) da ON ei.id=da.EmployeeID
            WHERE $where AND ei.EmployeeStatus=0")->fetchAll();
    }

    public function TotalSummary(String $where, String $attendance_where)
    {
        $where = rtrim($where, "AND");
        $sql = "SELECT sum(male) male,sum(female) female FROM(
            SELECT IF(Gender=1, COUNT('Gender'), 0) as male,IF(Gender=2, COUNT('Gender'), 0) as female, EmployeeID FROM(
                SELECT EmployeeID,WorkDate,GROUP_CONCAT(InTime) as InTime,GROUP_CONCAT(OutTime) as OutTime,
                IsLate FROM(
                    SELECT EmployeeID,WorkDate,PunchIN as InTime,
                        PunchOUT as OutTime,IsLate from daily_attendance
                        WHERE $attendance_where
                        GROUP BY WorkDate,EmployeeID
                )
                da GROUP BY WorkDate,EmployeeID
            ) da
            INNER JOIN employee_info ei ON ei.id=da.EmployeeID where $where AND ei.EmployeeStatus=0 GROUP BY Gender
        ) g2";
        //myLog($sql);
        //return $sql;exit;
        return $this->pdo->query($sql)->fetchAll();
    }

    public function monthly_attendance(String $where, String $where_date)
    {
        $where = rtrim($where, "AND");
        if ($where) {
            $where = "WHERE $where";
        }
        $sql = "SELECT EmployeeName,EmployeeCode,DOJ,dg.name Designation,dp.name Department,sc.name Section,staffcat.name StaffCategory,EmployeeID,WorkDate,ShiftInTime,InTime,OutTime,slab_1_ot,slab_2_ot,w_ot,DayStatus,
                    separation_effective_date FROM(
                    SELECT EmployeeID, GROUP_CONCAT(WorkDate ORDER BY WorkDate) WorkDate,GROUP_CONCAT(ShiftInTime ORDER BY WorkDate) ShiftInTime,GROUP_CONCAT(InTime ORDER BY WorkDate) InTime,GROUP_CONCAT(slab_1_ot ORDER BY WorkDate) slab_1_ot,
                        GROUP_CONCAT(slab_2_ot ORDER BY WorkDate) slab_2_ot,GROUP_CONCAT(w_ot ORDER BY WorkDate) w_ot,GROUP_CONCAT(OutTime ORDER BY WorkDate) OutTime,GROUP_CONCAT(DayStatus ORDER BY WorkDate) DayStatus FROM
	                    `daywise_pay_hour` DPH WHERE $where_date
                    GROUP BY DPH.EmployeeID ORDER BY DPH.EmployeeID
                ) FRS
                INNER JOIN employee_info ei ON ei.id=FRS.EmployeeID
                LEFT JOIN settings_master dg ON ei.DesignationID=dg.id
                LEFT JOIN settings_master dp ON ei.DepartmentID=dp.id
                LEFT JOIN settings_master sc ON ei.SectionID=sc.id
                LEFT JOIN settings_master staffcat ON ei.StaffCategoryID=staffcat.id
                $where GROUP BY EmployeeID  ORDER BY EmployeeID";
        //myLog($sql);
        //return $sql;
        return $this->pdo->query($sql)->fetchAll();
    }
    public function manual_attendance(String $where, String $where_date)
    {
        $where = rtrim($where, "AND");
        if ($where) {
            $where = "WHERE $where";
        }
        $sql = "SELECT EmployeeName,EmployeeCode,dg.name Designation,dp.name Department,sc.name Section,staffcat.name StaffCategory,EmployeeID,WorkDate,InTime,OutTime,Remarks,DateAdded,AddedBy
                FROM(
                    SELECT EmployeeID, WorkDate,InTime,OutTime,Remarks,DateAdded,AddedBy FROM
	                    `manual_attendence` MA WHERE $where_date 
                ) FRS
                INNER JOIN employee_info ei ON ei.id=FRS.EmployeeID
                LEFT JOIN settings_master dg ON ei.DesignationID=dg.id
                LEFT JOIN settings_master dp ON ei.DepartmentID=dp.id
                LEFT JOIN settings_master sc ON ei.SectionID=sc.id
                LEFT JOIN settings_master staffcat ON ei.StaffCategoryID=staffcat.id
                $where ORDER BY EmployeeID,WorkDate";
        //myLog($sql);
        //return $sql;
        return $this->pdo->query($sql)->fetchAll();
    }
    public function monthly_attendance_with_ot(String $where, String $where_date)
    {
        $where = rtrim($where, "AND");
        if ($where) {
            $where = "WHERE $where";
        }

        $sql = "SELECT EmployeeName,EmployeeCode,DOJ,OTEntitledDate,OffDayOT,HolydayBonus,dg.name Designation,dp.name Department,sc.name Section,staffcat.name StaffCategory,
                    EmployeeID,WorkDate,InTime,OutTime,DayStatus,ShiftOutTime,LateHour,separation_effective_date FROM(
                        SELECT EmployeeID, GROUP_CONCAT(WorkDate ORDER BY WorkDate) WorkDate,GROUP_CONCAT(InTime ORDER BY WorkDate) InTime,
                            GROUP_CONCAT(DATE_FORMAT(OutTime, '%h:%i %p') ORDER BY WorkDate) OutTime,GROUP_CONCAT(DayStatus ORDER BY WorkDate) DayStatus,
                            GROUP_CONCAT(DATE_FORMAT(ShiftOutTime, '%h:%i %p') ORDER BY WorkDate) ShiftOutTime,GROUP_CONCAT(LateHour ORDER BY WorkDate) LateHour FROM `daywise_pay_hour` DPH WHERE $where_date
                    GROUP BY DPH.EmployeeID ORDER BY DPH.EmployeeID
                ) FRS
                INNER JOIN employee_info ei ON ei.id=FRS.EmployeeID
                LEFT JOIN settings_master dg ON ei.DesignationID=dg.id
                LEFT JOIN settings_master dp ON ei.DepartmentID=dp.id
                LEFT JOIN settings_master sc ON ei.SectionID=sc.id
                LEFT JOIN settings_master staffcat ON ei.StaffCategoryID=staffcat.id
                $where GROUP BY EmployeeID ORDER BY EmployeeID";
        //echo ($sql);exit;
        return $this->pdo->query($sql)->fetchAll();
    }
}
