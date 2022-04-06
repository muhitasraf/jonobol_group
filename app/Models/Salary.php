<?php

namespace App\Models;

class Salary extends Model {
     protected $pdo;
     public function __construct()
     {
        parent::__construct();
     }
    public function get_data($sql,$array) { 
        $rs = $this->pdo->prepare($sql);
        $rs->execute($array);
        return $rs->fetchAll();
    }
    public function get_data_single($sql,$array) { 
        $rs = $this->pdo->prepare($sql);
        $rs->execute($array);
        return $rs->fetch();
    }
    public function totalAttendance($EmployeeID, $from_date, $to_date,$day_status=null)
    {
        if (is_array($day_status))
            $day_status = implode('","', $day_status);
        $sql = 'SELECT * FROM daywise_pay_hour WHERE EmployeeID="'.$EmployeeID.'" AND (DATE(WorkDate) 
            BETWEEN "'.$from_date.'" AND "'.$to_date.'") AND DayStatus IN ("'.$day_status.'")';
        myLog('Total attendance: '.$sql);
        return $this->pdo->query($sql)->fetchAll();
    }

    public function totalCalendar($EmployeeID, $from_date, $to_date,$day_status=null)
    {
        if (is_array($day_status))
            $day_status = implode('","', $day_status);
        return $this->pdo->query('SELECT * FROM workoff_calendar WHERE EmployeeID="'.$EmployeeID.'" AND (DATE(WorkOffDate) 
            BETWEEN "'.$from_date.'" AND "'.$to_date.'") AND DayType IN ("'.$day_status.'")')->fetchAll();
    }

    public function OT_data($EmployeeID, $from_date, $to_date)
    {
        /*return $this->pdo->query('SELECT * FROM day_wise_ot_hour WHERE EmployeeID="'.$EmployeeID.'" AND (DATE(WorkDate) 
            BETWEEN "'.$from_date.'" AND "'.$to_date.'")')->fetchAll();*/
        return $this->pdo->query('SELECT id,slab_1_ot,slab_2_ot,w_ot FROM daywise_pay_hour WHERE EmployeeID="'.$EmployeeID.'" AND (DATE(WorkDate) 
            BETWEEN "'.$from_date.'" AND "'.$to_date.'")')->fetchAll();
    }

    public function getSalary($where, $from_date, $to_date) {
        $where = rtrim($where, "AND");        
        $sql = "SELECT ei.EmployeeCode,ei.EmployeeName,ei.DOJ,dg.name Designation,dp.name Department,sc.name Section,staffcat.name StaffCategory,
                ms.id,ROUND(ms.orgGROSS,2) orgGROSS,ROUND(ms.orgBASIC,2) orgBASIC,ROUND(ms.orgHOUSERENT,2) orgHOUSERENT,
                ROUND(ms.orgMEDICAL,2) orgMEDICAL,ROUND(ms.ATTENDANCEBONUS,2) ATTENDANCEBONUS,ms.ToDate,ROUND(ms.Absenteeism,2) Absenteeism,
                ROUND(ms.OT,2) OT,ROUND(ms.OT_HOUR,2) OT_HOUR,ROUND(ms.OT_PER_HOUR,2) OT_PER_HOUR,ROUND(ms.PF,2) PF,ROUND(ms.ADVANCE,2) ADVANCE,
                ROUND(ms.STAMP,2) STAMP,ROUND(ms.TAX,2) TAX,ROUND(ms.FOOD,2) FOOD,ROUND(ms.ARREAR,2) ARREAR,ROUND(ms.orgCONVEYANCE,2) orgCONVEYANCE,
                ms.MergeOT,wc.WeeklyOffDay,lv.LeaveType,lv.LeaveDays,dph.AbsentDay,fhd.Festival,prday.PresentDay 
            FROM employee_info ei 
            LEFT JOIN settings_master dg ON ei.DesignationID=dg.id
            LEFT JOIN settings_master dp ON ei.DepartmentID=dp.id 
            LEFT JOIN settings_master sc ON ei.SectionID=sc.id            
            LEFT JOIN settings_master staffcat ON ei.StaffCategoryID=staffcat.id
            LEFT JOIN month_wise_salary_info ms ON ei.id=ms.EmployeeID 
            LEFT JOIN (                
                SELECT EmployeeID,count(DayStatus) WeeklyOffDay FROM daywise_pay_hour 
                WHERE WorkDate BETWEEN '$from_date' AND '$to_date' AND DayStatus='W' GROUP BY EmployeeID
            ) wc ON ei.id=wc.EmployeeID
            LEFT JOIN (
				SELECT EmployeeID,COUNT(DayStatus) AbsentDay FROM daywise_pay_hour 
				WHERE WorkDate BETWEEN '$from_date' AND '$to_date' AND DayStatus='A' GROUP BY EmployeeID
			) dph ON ei.id=dph.EmployeeID
            LEFT JOIN (
				SELECT EmployeeID,COUNT(DayStatus) Festival FROM daywise_pay_hour 
				WHERE WorkDate BETWEEN '$from_date' AND '$to_date' AND DayStatus='H' GROUP BY EmployeeID
			) fhd ON ei.id=fhd.EmployeeID
            LEFT JOIN (
				SELECT EmployeeID,COUNT(DayStatus) PresentDay FROM daywise_pay_hour 
				WHERE WorkDate BETWEEN '$from_date' AND '$to_date' AND DayStatus IN ('P','L','PW','PH','LW','LH','PLV','LLV') GROUP BY EmployeeID
			) prday ON ei.id=prday.EmployeeID
            LEFT JOIN (
                SELECT EmployeeID,GROUP_CONCAT(LeaveDays) LeaveDays,GROUP_CONCAT(LeaveType) LeaveType FROM ( 
                    SELECT LeaveType,EmployeeID,SUM(LeaveDays) LeaveDays FROM emp_leave_transaction elta 
                    INNER JOIN leave_policy_master lpm ON lpm.id=elta.LeavePolicyID 
                    WHERE (FromDate BETWEEN '$from_date' AND '$to_date') AND (ToDate BETWEEN '$from_date' AND '$to_date') 
                    GROUP BY lpm.LeavePolicyID,EmployeeID
                ) lvs GROUP BY EmployeeID 
            ) lv ON ei.id=lv.EmployeeID    
            WHERE $where AND ei.EmployeeStatus=0 ORDER BY sc.name
        ";
        return $this->pdo->query($sql)->fetchAll();
    }
    public function getSalarySummary($where) {
        $where = rtrim($where, "AND");        
        $sql = "SELECT  ei.SectionID,sm.name as section,
                COUNT(CASE WHEN ei.StaffCategoryID=8 THEN 1 ELSE NULL END) as  Staff,
                COUNT(CASE WHEN ei.StaffCategoryID=5 THEN 1 ELSE NULL END) as  Worker,
                SUM(CASE WHEN ei.StaffCategoryID=8 THEN Round (mwsi.OrgGross,0) ELSE NULL END) as  StaffGross,
                SUM(CASE WHEN ei.StaffCategoryID=5 THEN Round (mwsi.OrgGross,0) ELSE NULL END) as  WorkerGross,
                SUM(Round (mwsi.OrgGross,0)) as Gross,
                SUM(CASE WHEN ei.StaffCategoryID=8 THEN  Round (mwsi.OT,0) ELSE NULL END) as  StaffOT,
                SUM(CASE WHEN ei.StaffCategoryID=5 THEN  Round (mwsi.OT,0) ELSE NULL END) as  WorkerOT,
                SUM(Round(mwsi.OT,0)) as OT,
                SUM(CASE WHEN ei.StaffCategoryID=8 THEN Round (mwsi.ARREAR,0) ELSE NULL END) as  StaffARREAR,
                SUM(CASE WHEN ei.StaffCategoryID=5 THEN Round (mwsi.ARREAR,0) ELSE NULL END) as  WorkerARREAR,
                SUM(Round(mwsi.ARREAR,0))as ARREAR,
                SUM(CASE WHEN ei.StaffCategoryID=8 THEN Round (mwsi.ATTENDANCEBONUS,0) ELSE NULL END) as  StaffATTENDANCEBONUS,
                SUM(CASE WHEN ei.StaffCategoryID=5 THEN Round (mwsi.ATTENDANCEBONUS,0) ELSE NULL END) as  WorkerATTENDANCEBONUS,
                SUM(Round(mwsi.ATTENDANCEBONUS,0))as ATTENDANCEBONUS,
                SUM(CASE WHEN ei.StaffCategoryID=8 THEN Round (mwsi.Absenteeism,0)  ELSE NULL END) as  StaffAbsenteeism ,
                SUM(CASE WHEN ei.StaffCategoryID=5 THEN Round (mwsi.Absenteeism,0)  ELSE NULL END) as  WorkerAbsenteeism ,
                SUM(Round(mwsi.Absenteeism,0)) as  Absenteeism, 
                SUM(CASE WHEN ei.StaffCategoryID=8 THEN Round (mwsi.PF,0) ELSE NULL END) as  StaffPF ,
                SUM(CASE WHEN ei.StaffCategoryID=5 THEN Round (mwsi.PF,0) ELSE NULL END) as  WorkerPF ,
                SUM(Round(mwsi.PF,0)) as  PF,
                SUM(CASE WHEN ei.StaffCategoryID=8 THEN Round (mwsi.ADVANCE,0)  ELSE NULL END) as  StaffADVANCE ,
                SUM(CASE WHEN ei.StaffCategoryID=5 THEN Round (mwsi.ADVANCE,0)  ELSE NULL END) as  WorkerADVANCE ,
                SUM(Round(mwsi.ADVANCE,0)) as  ADVANCE, 
                SUM(CASE WHEN ei.StaffCategoryID=8 THEN Round (mwsi.STAMP,0)  ELSE NULL END) as  StaffSTAMP,
                SUM(CASE WHEN ei.StaffCategoryID=5 THEN Round (mwsi.STAMP,0)  ELSE NULL END) as  WorkerSTAMP ,
                SUM(Round(mwsi.STAMP,0)) as  STAMP, 
                SUM(CASE WHEN ei.StaffCategoryID=8 THEN Round (mwsi.TAX,0)  ELSE NULL END) as  StaffTAX,
                SUM(CASE WHEN ei.StaffCategoryID=5 THEN Round (mwsi.TAX,0)  ELSE NULL END) as  WorkerTAX ,
                SUM(Round(mwsi.TAX,0)) as  TAX, 
                SUM(CASE WHEN ei.StaffCategoryID=8 THEN Round (mwsi.FOOD,0)  ELSE NULL END) as  StaffFOOD,
                SUM(CASE WHEN ei.StaffCategoryID=5 THEN Round (mwsi.FOOD,0) ELSE NULL END) as  WorkerFOOD ,
                SUM(Round(mwsi.FOOD,0)) as  FOOD,
                SUM(CASE WHEN ei.StaffCategoryID=8 THEN Round (mwsi.orgGROSS,0)  ELSE NULL END) as  StafforgGROSS,
                SUM(CASE WHEN ei.StaffCategoryID=5 THEN Round (mwsi.orgGROSS,0) ELSE NULL END) as  WorkerorgGROSS ,
                SUM(Round(mwsi.orgGROSS,0)) as  orgGROSS 
                FROM employee_info ei
                LEFT JOIN month_wise_salary_info mwsi ON mwsi.EmployeeID=ei.id
                INNER JOIN settings_master sm ON sm.id=ei.SectionID
                WHERE $where GROUP BY ei.SectionID    
        ";

        return $this->pdo->query($sql)->fetchAll();
    }
    public function getDeduction($where){
        $where = rtrim($where, "AND");
        $sql = 'SELECT d.EmployeeID,d.MonthNo,d.YearNo,d.PF,d.Advance,d.Loan,ei.EmployeeCode,ei.EmployeeName,dg.name Designation,dp.name Department,sc.name Section,staffcat.name StaffCategory
            FROM deduction d
            INNER JOIN employee_info ei ON ei.id=d.EmployeeID
            LEFT JOIN settings_master dg ON ei.DesignationID=dg.id
            LEFT JOIN settings_master dp ON ei.DepartmentID=dp.id 
            LEFT JOIN settings_master sc ON ei.SectionID=sc.id            
            LEFT JOIN settings_master staffcat ON ei.StaffCategoryID=staffcat.id
            WHERE '.$where.' ';
        //myLog($sql);
        //return $sql;exit;
        return $this->pdo->query($sql)->fetchAll();
    }
    public function getSalaryCompliance($where, $from_date, $to_date) {
        $where = rtrim($where, "AND");
        $sql = "SELECT ei.EmployeeCode,ei.EmployeeName,ei.DOJ,dg.name Designation,dp.name Department,sc.name Section,staffcat.name StaffCategory,
                ROUND(ms.orgGROSS,2) orgGROSS,ROUND(ms.orgBASIC,2) orgBASIC,ROUND(ms.orgHOUSERENT,2) orgHOUSERENT,
                ROUND(ms.orgMEDICAL,2) orgMEDICAL,ROUND(ms.ATTENDANCEBONUS,2) ATTENDANCEBONUS,ms.ToDate,ROUND(ms.Absenteeism,2) Absenteeism,
                ROUND(ms.OT,2) OT, ROUND(ms.PF,2) PF,ROUND(ms.ADVANCE,2) ADVANCE,ROUND(ms.STAMP,2) STAMP,ROUND(ms.orgCONVEYANCE,2) orgCONVEYANCE,
                wc.WeeklyOffDay,lv.LeaveType,lv.LeaveDays,dph.AbsentDay,ROUND(dothr.OTHour,2) OTHour,ROUND((ms.OT/OTHour),2) OTRate 
                FROM employee_info ei
            LEFT JOIN settings_master dg ON ei.DesignationID=dg.id
            LEFT JOIN settings_master dp ON ei.DepartmentID=dp.id 
            LEFT JOIN settings_master sc ON ei.SectionID=sc.id            
            LEFT JOIN settings_master staffcat ON ei.StaffCategoryID=staffcat.id
            LEFT JOIN month_wise_salary_info ms ON ei.id=ms.EmployeeID 
            LEFT JOIN (
                SELECT EmployeeID,SUM(OTHour) OTHour FROM day_wise_ot_hour 
                WHERE WorkDate BETWEEN '$from_date' AND '$to_date' AND SlabType='Slab-01'  GROUP BY EmployeeID
            ) dothr ON ei.id=dothr.EmployeeID  
            LEFT JOIN (
                SELECT EmployeeID,count(DayType) WeeklyOffDay FROM workoff_calendar 
                WHERE WorkDate BETWEEN '$from_date' AND '$to_date' GROUP BY EmployeeID
            ) wc ON ei.id=wc.EmployeeID
            LEFT JOIN (
				SELECT EmployeeID,COUNT(DayStatus) AbsentDay FROM daywise_pay_hour 
				WHERE WorkDate BETWEEN '$from_date' AND '$to_date' AND DayStatus='A' GROUP BY EmployeeID
			) dph ON ei.id=dph.EmployeeID
            LEFT JOIN (
                SELECT EmployeeID,GROUP_CONCAT(LeaveDays) LeaveDays,GROUP_CONCAT(LeaveType) LeaveType FROM ( 
                    SELECT LeaveType,EmployeeID,SUM(LeaveDays) LeaveDays FROM emp_leave_transaction elta 
                    INNER JOIN leave_policy_master lpm ON lpm.id=elta.LeavePolicyID 
                    WHERE (FromDate BETWEEN '$from_date' AND '$to_date') AND (ToDate BETWEEN '$from_date' AND '$to_date') 
                    GROUP BY lpm.LeavePolicyID,EmployeeID
            ) lvs GROUP BY lvs.LeaveType,EmployeeID 
            ) lv ON ei.id=lv.EmployeeID    
            WHERE $where AND ei.EmployeeStatus=0 ORDER BY sc.name
        ";
        //myLog($sql);
        return $this->pdo->query($sql)->fetchAll();
    }

    public function employee_salary_deduct($search,$month,$year,$employee_id,$from_date,$to_date,$status)
    {
        if($status=='1'){
            // $sql = "SELECT esd.id, esd.EmployeeID, esd.pf, esd.tax, esd.food, esd.from_date, esd.to_date, esd.status, es.Amount FROM employee_salary_deduct esd
            // LEFT JOIN (SELECT e.Amount, e.EmployeeID FROM employee_salary e WHERE e.EmployeeID='$employee_id' 
            // AND e.SalaryHeadID='Basic' ORDER BY e.id DESC) es ON es.EmployeeID = esd.EmployeeID
            // WHERE esd.EmployeeID='$employee_id' AND esd.status='1' AND esd.from_date Between '$from_date' AND '$to_date'";

            $sql = "SELECT e.Amount, e.EmployeeID, emp.id, emp.EmployeeID, emp.pf, emp.tax, emp.food, emp.from_date, emp.to_date, emp.status FROM employee_salary e 
            LEFT join (SELECT esd.id, esd.EmployeeID, esd.pf, esd.tax, esd.food, esd.from_date, esd.to_date, esd.status FROM employee_salary_deduct esd 
            WHERE esd.EmployeeID='$employee_id' AND esd.status='1' AND esd.from_date Between '$from_date' AND '$to_date' ) emp ON emp.EmployeeID = e.EmployeeID
            WHERE e.EmployeeID='$employee_id' AND e.SalaryHeadID='Basic' GROUP BY e.id ORDER BY e.id DESC;";
            
        }else{
            $sql = "SELECT esd.advance AS advance, esd.loan AS loan, esd.bakery AS bakery, esd.others AS others FROM employee_info ei
            LEFT JOIN settings_master sec ON sec.id=ei.SectionID
            LEFT JOIN settings_master sc ON sc.id=ei.StaffCategoryID
            LEFT JOIN employee_salary_deduct esd ON esd.EmployeeID = ei.id
            WHERE EmployeeCode like '%$search' AND esd.month_no=$month AND esd.year_no=$year AND esd.status=2 ORDER BY esd.id DESC ";
        }
        //myLog($sql);
        return $this->pdo->query($sql)->fetch();
    }
    // public function get_basic_salary($employee_id)
    // {
    //     $sql = "SELECT * FROM employee_salary WHERE EmployeeID='$employee_id' AND SalaryHeadID='Basic' ORDER BY id DESC";
    //     return $this->pdo->query($sql)->fetch();
    // }
}