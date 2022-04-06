<?php
namespace App\Controllers\Employee;

use App\Controllers\Controller;
use App\Models\ManualShift;

class EmployeeBankController extends Controller {

    private $manual_shift;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->manual_shift = new ManualShift();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return view
     */
    public function create()
    {
        $heading = "Employee Bank";
        $title = "Employee Bank Create";

        $bank_array = $this->manual_shift->table("settings_master")->where('type_name','bank')->fetchAll();
        $bank_dropdown = ['-select-'];
        foreach ($bank_array as $item) {
            $bank_dropdown[$item->id] = $item->name;
        }
        return view('employee_bank/create',compact('title','heading','bank_dropdown'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $inputs
     * @return Response View
     */
    public function store()
    {
        $data = "There is no data.";
        $inputs = $_POST;
        
        $employee_id_array = json_decode($inputs['employee_id']) ?? '';
        $bank_acc_no = ($inputs['bank_acc_no']) ?? '';
        $bank_acc_no = validation($bank_acc_no);
        $bank = $inputs['bank'] ?? '';
        $branch = $inputs['branch'];

        $emp_bank_data = [];
        for ($i=0; $i<count($employee_id_array); $i++) {
          if ($bank_acc_no[$i]) {
              $employee_id = $employee_id_array[$i];
              $employee_bank_exists = $this->manual_shift->table("employee_bank_info")
                  ->where("EmployeeID",$employee_id)->fetch();

              if (!$employee_bank_exists) {
                  $emp_bank_data [] = [
                      'EmployeeID' => validation($employee_id),
                      'BankAccNo' => validation($bank_acc_no[$i]),
                      'BankID' => validation($bank[$i]) ?? '',
                      'BranchId' => validation($branch[$i]) ?? '',
                      'DateAdded' => date('Y-m-d H:i:s'),
                      'AddedBy' => user_id()
                  ];
              }
          }
        }
        if ($emp_bank_data) {
            $this->manual_shift->table("employee_bank_info")->insert($emp_bank_data,'prepared');
            $data = "Employee Bank Added Successfully.";
        }
        echo $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return view
     */
    public function bank_branches()
    {
        $inputs = $_GET;
        $employee_id = json_decode($inputs['employee_id']) ?? [];
        $bank_id = validation($inputs['bank'] ?? null);

        $bank = $this->manual_shift->table("settings_master",$bank_id);
        $branches = $this->manual_shift->table("bank_branch_info")->where('BankId',$bank_id);//->fetchAll();
        $branch_dropdown = ['-select-'];
        foreach ($branches as $branch) {
            echo 'branches. ..';
            $branch_dropdown[$branch->id] = $branch->BranchName;
        }

        $emp_bank_info = '';
        for ($i=0; $i<count($employee_id); $i++) {
            $emp_bank_info .= '<tr>'.
                '<td>'.$employee_id[$i].'<input type="hidden" name="employee_id[]" class="bank_employee_id" value="'.$employee_id[$i].'" readonly></td>' .
                '<td><input type="text"class="form-control-sm col-sm-10 bank_acc_no" name="bank_acc_no[]"></td>' .
                '<td>'.$bank->name.'<input type="hidden" class="bank" name="bank[]" value="'.$bank_id.'"></td>'.
                '<td>'.form_select('branch[]',$branch_dropdown,null,'class="form-control-sm col-sm-10 branch" id="branch" required').
                '<td><input type="text" name="address[]" class="form-control-sm col-sm-10 address" readonly></td>' .
                '</tr>';
        }
        echo $emp_bank_info;
    }
}
