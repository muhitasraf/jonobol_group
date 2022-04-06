<?php
    namespace App\Controllers;

use App\Models\Dashboard;

class DashboardController extends Controller {
    private $dashboard;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->dashboard = new Dashboard();
    }

    /**
     * Display a listing of the resource.
     *
     * @return view
     */
    public function index()
    {
        $title = "Dashboard";
        $employee_count = $this->dashboard->table('employee_info')->count();
        $user_count = $this->dashboard->table('users')->count();
        $shift_plan_count = $this->dashboard->table('shift_plan')->count();
        $shift_rule_count = $this->dashboard->table('shift_rule')->count();
        $to_date = date('Y-m-d');
        $prev_date = date_conversion('Y-m-d',$to_date.' -7 days');

        $attendance_data = $this->dashboard->attendance_summary_by_date($prev_date, $to_date);

        $day_status = isset($attendance_data[0]) ? $attendance_data[0]['DayStatus'] : '';
        $work_date = isset($attendance_data[0]) ? $attendance_data[0]['WorkDate'] : '';
        $present_data = isset($attendance_data[0]) ? $attendance_data[0]['Cnt']: '';
        $lv_data = isset($attendance_data[1]) ? $attendance_data[1]['Cnt'] : '';
        $absent_data = isset($attendance_data[2]) ? $attendance_data[2]['Cnt'] : '';

        $work_date = explode(',',$work_date);
        $work_date = "'".implode("','",$work_date)."'";

        $late_attendance_data = $this->dashboard->late_attendance_summary_by_date($prev_date, $to_date);
        $late_attendance_data = isset($late_attendance_data) ? $late_attendance_data['Cnt'] : '';

        return view('dashboard/index',compact('title','employee_count','user_count','shift_plan_count',
            'shift_rule_count','work_date','present_data','lv_data','absent_data','late_attendance_data')
        );
    }
}
