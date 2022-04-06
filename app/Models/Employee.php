<?php

namespace App\Models;

class Employee extends Model {
     public $_table = 'employee_info';
     protected $pdo;
     public function __construct()
     {
        parent::__construct();
        //$this->setPrimary($this->_table,"EmployeeId");
     }
     /*public function get_by_pdo_query() {  //good without param
         return $this->pdo->query("SELECT * FROM address_book");
     }
     public function get_by_pdo_prepare($param) { //good with param
         $rs = $this->pdo->prepare("SELECT * FROM address_book where id= ?");
         $rs->execute($param);
         return $rs->fetchAll();
     }*/
    public function searchEmployee($param) {
        $rs = $this->pdo->prepare("SELECT id,EmployeeCode,EmployeeName,PunchCardNo FROM $this->_table WHERE (EmployeeCode LIKE ? OR EmployeeName LIKE ? OR PunchCardNo LIKE ?) LIMIT 7");
        $rs->execute($param);
        return $rs->fetchAll();
    }

    public function getEmployee(string $where)
    {
        if ($where)
            $where = rtrim($where, "AND");
        $sql = "SELECT ei.EmployeeCode,ei.BadgeNumber,EmployeeName,GradeInfoID,DOJ,DOB,Mobile,Gender,NationalIDCardNo,StaffCategoryID,MAX(es.Amount) as EntrySalary,sp.ShiftID,lv.LeaveRuleID,
            OT,HolydayBonus,dp.name Department,dg.name Designation,sc.name,un.name Unit,sc.name Section,adr.Address,adr.local_address,fi.father_name,fi.mother_name
            FROM employee_info ei
            LEFT JOIN employee_salary es ON ei.id=es.EmployeeID 
            LEFT JOIN settings_master dg ON ei.DesignationID=dg.id
            LEFT JOIN settings_master dp ON ei.DepartmentID=dp.id 
            LEFT JOIN settings_master un ON ei.UnitID=un.id
            LEFT JOIN settings_master sc ON ei.SectionID=sc.id  
            LEFT JOIN address_info adr ON ei.id=adr.EmployeeID  
            LEFT JOIN family_info fi ON ei.id=fi.EmployeeID   
            LEFT JOIN shift_plan sp ON ei.ShiftID=sp.id    
            LEFT JOIN leave_rulenew lv ON ei.LeaveRuleID=lv.id                 
            WHERE $where GROUP BY ei.EmployeeCode";
        $query = $this->pdo->query($sql); 
        myLog($sql);
        //myLog("query qry:".json_encode($query));
        //myLog("query fetchAll:".json_encode($query->fetchAll()));
        //return $query;exit;
        return $query->fetchAll();
        //INNER JOIN rename currently to LEFT join
    }
    
    public function getStaffLeaveInfo(string $EmployeeCode)
    {

        $sql = "SELECT ei.EmployeeCode,ei.BadgeNumber,EmployeeName,GradeInfoID,DOJ,DOB,Mobile,Gender,NationalIDCardNo,StaffCategoryID,MAX(es.Amount) as EntrySalary,sp.ShiftID,lv.LeaveRuleID,
            OT,HolydayBonus,dp.name Department,dg.name Designation,sc.name,un.name Unit,sc.name Section,adr.Address,adr.local_address,fi.father_name,fi.mother_name
            FROM employee_info ei
            LEFT JOIN employee_salary es ON ei.id=es.EmployeeID 
            LEFT JOIN settings_master dg ON ei.DesignationID=dg.id
            LEFT JOIN settings_master dp ON ei.DepartmentID=dp.id 
            LEFT JOIN settings_master un ON ei.UnitID=un.id
            LEFT JOIN settings_master sc ON ei.SectionID=sc.id  
            LEFT JOIN address_info adr ON ei.id=adr.EmployeeID  
            LEFT JOIN family_info fi ON ei.id=fi.EmployeeID   
            LEFT JOIN shift_plan sp ON ei.ShiftID=sp.id    
            LEFT JOIN leave_rulenew lv ON ei.LeaveRuleID=lv.id                 
            WHERE ei.EmployeeCode='$EmployeeCode'";

        $query = $this->pdo->query($sql)->fetch();
        
        return $query;

    }

    public function TotalSummary(string $where)
    {
        $where = rtrim($where, "AND");
        /*return $this->pdo->query("SELECT count('*') totalEmployee,Gender FROM employee_info
            WHERE $where GROUP BY Gender")
            ->fetchAll();*/
        return $this->pdo->query("SELECT sum(male) male,sum(female) female FROM(
            SELECT IF(Gender=1, COUNT('Gender'), 0) as male,IF(Gender=2, COUNT('Gender'), 0) as female,UnitID FROM `employee_info` ei
            LEFT JOIN settings_master un ON ei.UnitID=un.id 
            WHERE $where GROUP BY Gender) eu
             GROUP BY UnitID")
        ->fetchAll();
    }

    public function getEmployees(string $where)
    {
        if ($where)
            $where = rtrim($where, "AND");
        $query = $this->pdo->query("SELECT id,EmployeeCode,PunchCardNo,EmployeeName,UnitID,DivisionID,un.name Unit,dv.name Division FROM employee_info ei 
            LEFT JOIN settings_master un ON ei.UnitID=sc.id        
            LEFT JOIN settings_master dv ON ei.DivisionID=sc.id            
            WHERE $where");
        //myLog("query qry:".json_encode($query));
        //myLog("query fetchAll:".json_encode($query->fetchAll()));
        return $query->fetchAll();
        //INNER JOIN rename currently to LEFT join
    }
}