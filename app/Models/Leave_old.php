<?php

namespace App\Models;

class Leave extends Model {
     protected $pdo;
     public function __construct()
     {
        parent::__construct();
     }

    public function getLeaveTransaction($from_date, $to_date)
    {
        return $this->pdo->query('SELECT ei.id,ei.EmployeeName,ei.EmployeeCode,dg.name Designation,dp.name Department,sc.name Section,FromDate,ToDate,LeaveType,LeaveDays FROM employee_info ei            
            INNER JOIN emp_leave_transaction apr ON ei.id=apr.EmployeeID
            INNER JOIN leave_policy_master lpm ON apr.LeavePolicyID=lpm.id
            LEFT JOIN settings_master dg ON ei.DesignationID=dg.id
            LEFT JOIN settings_master dp ON ei.DepartmentID=dp.id
            LEFT JOIN settings_master sc ON ei.SectionID=sc.id
            WHERE (apr.FromDate>="'.$from_date.'" AND apr.FromDate<="'.$to_date.'")
        ')->fetchAll();
    }

    public function getLeaveSummary($from_date, $to_date)
    {
        $sql2 = 'SELECT ei.id,ei.EmployeeName,ei.EmployeeCode,ei.DOJ,dg.name Designation,dp.name Department,sc.name Section,FromDate,ToDate,LeaveType,LeaveDays FROM employee_info ei            
            INNER JOIN emp_leave_transaction apr ON ei.id=apr.EmployeeID
            INNER JOIN leave_policy_master lpm ON apr.LeavePolicyID=lpm.id
            LEFT JOIN settings_master dg ON ei.DesignationID=dg.id
            LEFT JOIN settings_master dp ON ei.DepartmentID=dp.id
            LEFT JOIN settings_master sc ON ei.SectionID=sc.id
            WHERE (apr.FromDate>="'.$from_date.'" AND apr.FromDate<="'.$to_date.'")
        ';
        $sql = 'SELECT ei.EmployeeCode,ei.EmployeeName,ei.DOJ,dg.name Designation,dp.name Department,sc.name Section,staffcat.name StaffCategory,
            GROUP_CONCAT(IF(ISNULL(LeaveType),'.'",LeaveType) ORDER BY aldm.LeavePolicyID) LeaveType,
            GROUP_CONCAT(IF(ISNULL(allocatedDays),"'.'",allocatedDays) ORDER BY aldm.LeavePolicyID) allocatedDays,
            GROUP_CONCAT(IF(ISNULL(availedDays),"'.'",availedDays) ORDER BY aldm.LeavePolicyID) availedDays FROM (
                SELECT ald.LeavePolicyID,LeaveType,EmployeeID,LeaveDays allocatedDays FROM allocated_leave_days ald
                INNER JOIN leave_policy_master lpm ON lpm.id=ald.LeavePolicyID 
                GROUP BY lpm.LeavePolicyID,EmployeeID
            ) aldm	
            LEFT JOIN(
                SELECT LeavePolicyID,EmployeeID,SUM(LeaveDays) availedDays FROM emp_leave_transaction elta
                WHERE FromDate BETWEEN "'.$from_date.'" AND "'.$to_date.'" AND ToDate BETWEEN "'.$from_date.'" AND "'.$to_date.'"
                GROUP BY LeavePolicyID,EmployeeID
            ) elta ON aldm.EmployeeID=elta.EmployeeID AND aldm.LeavePolicyID=elta.LeavePolicyID
            INNER JOIN employee_info ei ON ei.id=aldm.EmployeeID           
             LEFT JOIN settings_master dg ON ei.DesignationID=dg.id
             LEFT JOIN settings_master dp ON ei.DepartmentID=dp.id 
             LEFT JOIN settings_master sc ON ei.SectionID=sc.id
             LEFT JOIN settings_master staffcat ON ei.StaffCategoryID=staffcat.id
        GROUP BY ei.id  ORDER BY sc.name
        ';
        $sql = 'SELECT ei.EmployeeCode,ei.EmployeeName,ei.DOJ,dg.name Designation,dp.name Department,sc.name Section,staffcat.name StaffCategory,GROUP_CONCAT(IF(ISNULL(LeaveType),0,LeaveType) ORDER BY aldm.LeavePolicyID) LeaveType,
                GROUP_CONCAT(IF(ISNULL(allocatedDays),0,allocatedDays) ORDER BY aldm.LeavePolicyID) allocatedDays,
                GROUP_CONCAT(IF(ISNULL(availedDays),0,availedDays) ORDER BY aldm.LeavePolicyID) availedDays FROM (
                    SELECT ald.LeavePolicyID,LeaveType,EmployeeID,LeaveDays allocatedDays FROM allocated_leave_days ald
                    INNER JOIN leave_policy_master lpm ON lpm.id=ald.LeavePolicyID 
                    GROUP BY lpm.LeavePolicyID,EmployeeID
                ) aldm	
                LEFT JOIN(
                    SELECT LeavePolicyID,EmployeeID,SUM(LeaveDays) availedDays FROM emp_leave_transaction elta
                    WHERE FromDate BETWEEN "'.$from_date.'" AND "'.$to_date.'" AND ToDate BETWEEN "'.$from_date.'" AND "'.$to_date.'"
                    GROUP BY LeavePolicyID,EmployeeID
                ) elta ON aldm.EmployeeID=elta.EmployeeID AND aldm.LeavePolicyID=elta.LeavePolicyID
                INNER JOIN employee_info ei ON ei.id=aldm.EmployeeID           
                 LEFT JOIN settings_master dg ON ei.DesignationID=dg.id
                 LEFT JOIN settings_master dp ON ei.DepartmentID=dp.id 
                 LEFT JOIN settings_master sc ON ei.SectionID=sc.id
                 LEFT JOIN settings_master staffcat ON ei.StaffCategoryID=staffcat.id
            GROUP BY ei.id  ORDER BY sc.name';
        //myLog($sql);
        return $this->pdo->query($sql)->fetchAll();
    }

    public function leave_exist_on_dates($from_date, $to_date, int $id) //\Cassandra\Date
    {
        $sql = 'SELECT id FROM emp_leave_transaction WHERE 
                ((FromDate BETWEEN "'.$from_date.'" AND "'.$to_date.'") OR (ToDate BETWEEN "'.$from_date.'" AND "'.$to_date.'"))
                AND EmployeeID="'.$id.'" limit 1
        ';
        myLog('leave_exist_on_dates: '.$sql);
        return $this->pdo->query($sql)->fetch();
    }

    
    public function getStaffLeaveSummary(string $EmployeeCode,int $id)
    {
        
            $sql="SELECT ei.EmployeeCode,ei.EmployeeName,ei.DOJ,ei.Mobile,dg.name Designation,dp.name Department,sc.name Section,staffcat.name StaffCategory,GROUP_CONCAT(IF(ISNULL(LeaveType),0,LeaveType) ORDER BY aldm.LeavePolicyID) LeaveType,
                    GROUP_CONCAT(IF(ISNULL(allocatedDays),0,allocatedDays) ORDER BY aldm.LeavePolicyID) allocatedDays,
                    GROUP_CONCAT(IF(ISNULL(availedDays),0,availedDays) ORDER BY aldm.LeavePolicyID) availedDays FROM (
                        SELECT ald.LeavePolicyID,LeaveType,EmployeeID,LeaveDays allocatedDays FROM allocated_leave_days ald
                        INNER JOIN leave_policy_master lpm ON lpm.id=ald.LeavePolicyID 
                        GROUP BY lpm.LeavePolicyID,EmployeeID
                    ) aldm	
                    LEFT JOIN(
                        SELECT LeavePolicyID,EmployeeID,SUM(LeaveDays) availedDays FROM emp_leave_transaction elta
                        WHERE elta.IsApproved=$id  GROUP BY LeavePolicyID,EmployeeID 
                    ) elta ON aldm.EmployeeID=elta.EmployeeID AND aldm.LeavePolicyID=elta.LeavePolicyID
                    INNER JOIN employee_info ei ON ei.id=aldm.EmployeeID           
                        LEFT JOIN settings_master dg ON ei.DesignationID=dg.id
                        LEFT JOIN settings_master dp ON ei.DepartmentID=dp.id 
                        LEFT JOIN settings_master sc ON ei.SectionID=sc.id
                        LEFT JOIN settings_master staffcat ON ei.StaffCategoryID=staffcat.id
                        WHERE ei.EmployeeCode='$EmployeeCode' 
                GROUP BY ei.id  ORDER BY sc.name";
            return $this->pdo->query($sql)->fetch();

    }

}