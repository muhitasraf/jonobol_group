<?php

namespace App\Models;

class Dashboard extends Model {
     protected $pdo;
     public function __construct()
     {
        parent::__construct();
     }

     public function attendance_summary_by_date($from_date, $to_date) {
         $sql = "SELECT GROUP_CONCAT(WorkDate ORDER BY WorkDate) WorkDate,GROUP_CONCAT(cnt) Cnt,DayStatus FROM(
                 SELECT WorkDate,COUNT(*) cnt,DayStatus FROM `daywise_pay_hour` DPH WHERE 
                    WorkDate>='$from_date' AND WorkDate<='$to_date'
                     GROUP BY WorkDate,DayStatus ORDER BY WorkDate,DayStatus ASC
                 ) A GROUP BY DayStatus ORDER BY DayStatus DESC";
         //myLog($sql);
         return $this->pdo->query($sql )->fetchAll();
     }

    public function late_attendance_summary_by_date($from_date, $to_date) {
        return $this->pdo->query("SELECT GROUP_CONCAT(WorkDate) WorkDate,GROUP_CONCAT(Cnt) Cnt FROM(
            SELECT WorkDate,COUNT(*) Cnt FROM `daywise_pay_hour`
                WHERE WorkDate>='$from_date' AND WorkDate<='$to_date' AND LateHour>0 
                GROUP BY WorkDate ORDER BY WorkDate ASC
        ) RS"
        )->fetch();
    }
}