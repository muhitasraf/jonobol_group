<?php

namespace App\Traits;


use App\Models\Model;

trait AllocateLeaveDays
{
    public function add_allocated_leave_days(int $EmployeeID,String $from_date)
    {
        // if join is previous year, then calculate from 1st january
        // if same year then current date
        //myLog("from date ".$from_date);
        $curr_yr = date('Y');
        $from_yr = date_conversion('Y',$from_date);
        if ($curr_yr > $from_yr) {
            $from_date = $curr_yr.'-01-01';
        }
        //myLog("from date ".$from_date.'-->'.$from_yr.'-->'.$curr_yr);

        $this->model = new Model();
        $LeavePolicy = $this->model->table('leave_policy_master')->fetchAll();
        $allocated_days = [];
        $total_days_in_yr = 365+date_conversion('L',$from_date);
        $total_days_at_present = date_conversion("z",$from_date)+1;
        $rest_days_in_yr = ($total_days_in_yr - $total_days_at_present);//-1;

        $leave_year = $this->model->table('company')->where('id',1)->fetch();
        $from_date = $leave_year->from_date ?? date('Y-01-01');
        $to_date = $leave_year->to_date ?? date('Y-12-31');
        //print_r($leave_year);
        //myLog("from date ".$leave_year->from_date.'->'.$from_date." to date ".$leave_year->to_date.'->'.$to_date);
        //el calculating for leave year end process
        /*$total_present_day = $this->model->table("daywise_pay_hour")->where("EmployeeID",$EmployeeID)->where("DayStatus",['L','P','W','H','PW','PH','LW','LH','PLV','LLV'])
            ->where("WorkDate BETWEEN $from_date AND $to_date")->fetchAll();
        dd($total_present_day);*/
        $total_present_day = $this->model->query("SELECT * FROM daywise_pay_hour WHERE EmployeeID=".$EmployeeID." AND
                            DayStatus IN ('L','P','W','H','PW','PH','LW','LH','PLV','LLV') AND
                            WorkDate BETWEEN '".$from_date."' AND '".$to_date."'")
                    ->fetchAll();
        $curr_allocated_el = round(count($total_present_day)/18);

        /*$leave_days = [
            'CL' => 10,
            'SL' => 14,
            'LWP' => $rest_days_in_yr+1,
            'SPL' => $rest_days_in_yr+1,
            'EL' => $curr_allocated_el//0
        ];*/
        //myLog(" curr_allocated_el: ".$curr_allocated_el);
        /*myLog(" DOJ: ".$from_date);
        myLog(" total_days_in_yr: ".$total_days_in_yr);
        myLog(" total_days_at_present: ".$total_days_at_present);
        myLog(" rest_days_in_yr: ".$rest_days_in_yr);*/
        $emp_lv_master_data = [];
        foreach ($LeavePolicy as $row) {
            //$leave_day = round(($leave_days[$row->LeaveType])*($rest_days_in_yr/$total_days_in_yr));
            //myLog($row->lv_days);
            if ($row->LeaveType == 'CL' || $row->LeaveType == 'SL') {
                $leave_day = $row->lv_days;
                $leave_day = round($leave_day*($rest_days_in_yr/$total_days_in_yr));
            }
            else if ($row->LeaveType == 'EL') {
                // Glogo currently EL not active, so put default 0
                $leave_day = $curr_allocated_el;//0; 
            }
            else if ($row->LeaveType == 'LWP' || $row->LeaveType == 'SPL') {
                //* it is right for calculation the exact next days
                $total_days_in_yr = $row->lv_days;
                $total_days_at_present = date("z",strtotime($from_date))+1;
                $rest_days_in_yr = ($total_days_in_yr - $total_days_at_present);//-1;
                $leave_day = $rest_days_in_yr;

                //for gazipur, LWP and SPL is fixed to 365 which inserted a leave days
                //$leave_day = $row->lv_days;
            }
            //myLog($leave_day);
            /*myLog(" leave_days[row->LeaveType]: ".$leave_days[$row->LeaveType]);
            myLog(" rest_days_in_yr/total_days_in_yr: ".($rest_days_in_yr/$total_days_in_yr));
            myLog(" leave_day: ".$leave_day);*/

            $exist_allocated_data = $this->model->table('allocated_leave_days')->where("EmployeeID",$EmployeeID)->where("LeavePolicyID",$row->id);//->fetch();
            //myLog(" exist_allocated_data: ".json_encode($exist_allocated_data->fetch()));
            if ($exist_allocated_data->fetch()) {
                $exist_allocated_data->update(['LeaveDays' => $leave_day]);
            }
            else {
                $allocated_days[] = [
                    'EmployeeID' => $EmployeeID,
                    'LeavePolicyID' => $row->id,
                    'LeaveDays' => $leave_day,
                ];
            }

            //for dummy year end process
            $emp_lv_exist = $this->model->table("employee_leave_master")->where('EmployeeID', $EmployeeID)->where('LeavePolicyID', $row->id)
                ->where('AvailFrom', $from_date)->where('AvailTo', $to_date);
            if (!$emp_lv_exist->fetch()) {
                $emp_lv_master_data[] = [
                    'EmployeeID' => $EmployeeID,
                    'LeavePolicyID' => $row->id,
                    'AvailFrom' => $from_date,
                    'AvailTo' => $to_date,
                    'OpeningBalance' => 0,
                    'EntitlementDate' => date('Y-m-d'),
                    'AddedBy' => user_id(),
                    'DateAdded' => date('Y-m-d H:i:s')
                ];
            }
        }
        //dd($allocated_days);
        if ($allocated_days) {
            $this->model->table('allocated_leave_days')->insert($allocated_days, 'prepared');
        }

        if ($emp_lv_master_data) {
            $this->model->table("employee_leave_master")->insert($emp_lv_master_data,'prepared');
        }
        //dump($allocated_days);
        //dd(count($emp_lv_master_data));
        return;
    }

}
