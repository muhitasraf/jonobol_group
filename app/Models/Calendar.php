<?php

namespace App\Models;

class Calendar extends Model {
     public function __construct()
     {
        parent::__construct();
     }

    public function getRoasterEmployeeByID($employee_id=[],$dates=[]) {
        $employee_id = implode('","',$employee_id);
        $dates = implode('","',$dates);
        $sql = 'SELECT ei.id,ei.PunchCardNo,ei.EmployeeName,ei.EmployeeCode,sp.ShiftID,sp.ShiftType,sp.Alais 
            FROM employee_info ei
            INNER JOIN shift_roster sr ON ei.id=sr.EmployeeID
            INNER JOIN shift_plan sp ON sr.ShiftID=sp.id
            WHERE ei.id IN("'.$employee_id.'") AND ei.EmployeeStatus=0 AND ei.SRA=1 AND sr.ShiftDate IN("'.$dates.'")
         ';
        //myLog($sql);
        return $this->pdo->query($sql);
    }

    public function getRoasterEmployeeData($employee_id=[],$dates=[], $shiftID = []) {
        $shiftID = implode('","',$shiftID);
        $dates = implode('","',$dates);
        $employee_id = implode('","',$employee_id);
        $sql = 'SELECT ei.id,ei.PunchCardNo,ei.EmployeeName,ei.EmployeeCode,sp.ShiftID,sp.ShiftType,sp.Alais 
            FROM employee_info ei
            INNER JOIN shift_roster sr ON ei.id=sr.EmployeeID
            INNER JOIN shift_plan sp ON sr.ShiftID=sp.id
            WHERE ei.id IN("'.$employee_id.'") AND sp.id IN ("'.$shiftID.'")  AND ei.EmployeeStatus=0 AND ei.SRA=1 AND sr.ShiftDate IN("'.$dates.'")
         ';
        //myLog($sql);
        return $this->pdo->query($sql);
    }
    public function getEmployeeByID($employee_id=[]) {
         $employee_id = implode('","',$employee_id);
        return $this->pdo->query('SELECT ei.id,ei.PunchCardNo,ei.EmployeeName,ei.EmployeeCode,sp.ShiftID,sp.ShiftType,sp.Alais 
            FROM employee_info ei INNER JOIN shift_plan sp on ei.ShiftID=sp.id WHERE ei.id IN("'.$employee_id.'") AND ei.EmployeeStatus=0
         ');
    }

    public function getEmployeeData($employee_id=[], $shiftID = []) {
        $shiftID = implode('","',$shiftID);
        $employee_id = implode('","',$employee_id);
        return $this->pdo->query('SELECT ei.id,ei.PunchCardNo,ei.EmployeeName,ei.EmployeeCode,sp.ShiftID,sp.ShiftType,sp.Alais 
            FROM employee_info ei INNER JOIN shift_plan sp on ei.ShiftID=sp.id WHERE ei.id IN("'.$employee_id.'")
            AND sp.id IN ("'.$shiftID.'")  AND ei.EmployeeStatus=0
         ');
    }

    public function calender_date_edit()
    {
        $sql ='SELECT users.name,attendance_day_status.DayStatusName,workoff_calendar.DayType,workoff_calendar.WorkOffDate,workoff_calendar.id,workoff_calendar.DateAdded,workoff_calendar.WorkDate 
        from workoff_calendar,attendance_day_status,users 
        where workoff_calendar.DayType=attendance_day_status.id AND workoff_calendar.AddedBy=users.id';

        return $this->pdo->query($sql)->fetchAll();
    }
}