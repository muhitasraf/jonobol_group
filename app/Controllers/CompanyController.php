<?php
    namespace App\Controllers;

    use App\library\Upload;
    use App\Models\Company;
    use Vendor\Valitron\Validator;

    class CompanyController extends Controller {
        public $company;
        public function __construct()
        {
            parent::__construct();
            $this->company = new Company();
            $this->upload = new Upload();
        }

        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            $title = "Company List";
            $company = $this->company->getData();
            return view('company/index',compact('title','company'));
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            $title = "New Company";
            return view('company/create',compact('title'));
        }
        /**
         * Store a newly created resource in storage.
         *
         * @param  Request  $inputs
         * @return Response View
         */
        public function store()
        {
            $inputs = $_POST;
            $inputs = $inputs+$_FILES;
            $v = new Validator($inputs);
            $v->rule('required', ['name','address','from_date','to_date']);

            //make sure we have no error
            if ($this->upload->fileExists('logo')) { //upload->
                $v->rule('in', 'logo.error', [0])->message('No image selected for {field}');
                $v->rule('in', 'logo.type', ['image/jpeg'])->message('Only jpg image is allowed for {field}.');
                $v->rule('max', 'logo.size', 300*1024)->message('Max size is 300kb for {field}.');
            }
            if ($this->upload->fileExists('owner_signature')) { //upload->
                $v->rule('in', 'owner_signature.error', [0])->message('No image selected for {field}');
                $v->rule('in', 'owner_signature.type', ['image/jpeg'])->message('Only jpg image is allowed for {field}.');
                $v->rule('max', 'owner_signature.size', 300*1024)->message('Max size is 300kb for {field}.');
            }

            if($v->validate()) {
                $name = validation($inputs['name'] ?? '');
                $address = validation($inputs['address'] ?? '');
                $logo = validation($inputs['logo'] ?? '');
                $local_name = validation($inputs['local_name'] ?? '');
                $local_address = validation($inputs['local_address'] ?? '');
                $owner_name = validation($inputs['owner_name'] ?? '');
                $owner_signature = validation($inputs['owner_signature'] ?? '');
                $office_phone = validation($inputs['office_phone'] ?? '');
                $web_address = validation($inputs['web_address'] ?? '');
                $from_date = date_conversion('Y-m-d',$inputs['from_date']);
                $to_date = date_conversion('Y-m-d',$inputs['to_date']);
                $IsActive = validation($inputs['IsActive'] ?? 0);

                $company_info = [
                    'name' => $name,
                    'address' => $address,
                    'local_name' => $local_name,
                    'local_address' => $local_address,
                    'owner_name' => $owner_name,
                    'office_phone' => ($office_phone),
                    'web_address' => ($web_address),
                    'from_date' => $from_date,
                    'to_date' => $to_date,
                    'is_active' => $IsActive
                ];

                $path = 'images/company/';
                $time = time();
                if ($this->upload->fileExists('logo')) { //upload->
                    $logo_file_name = $time . '-' . 'logo.jpg';
                    //remove image first
                    /*if(file_exists($path.$logo_file_name)) {
                        unlink($path.$logo_file_name);
                    }*/
                    $emPhoto = $this->upload->make('logo');
                    $emPhoto->save(upload_path($path . $logo_file_name));

                    $company_info['logo'] = $logo_file_name;
                }

                if ($this->upload->fileExists('owner_signature')) { //upload->
                    $sign_file_name = $time . '-' . 'sign.jpg';
                    //remove image first
                    /*if(file_exists($path.$sign_file_name)) {
                        unlink($path.$sign_file_name);
                    }*/
                    $emSign = $this->upload->make('owner_signature');
                    $emSign->save(upload_path($path . $sign_file_name));

                    $company_info['owner_signature'] = $sign_file_name;
                }


//                if(isset($logo_file_name))
//                    $company_info['logo'] = $logo_file_name;
//                if(isset($sign_file_name))
//                    $company_info['owner_signature'] = $sign_file_name;
                $rs = $this->company->insertData($company_info,'prepared');
                if($rs) {
                    notification(['type'=>'success', 'message'=>'Created Successfully']);
                }
                else {
                    session('errors',$rs->errorInfo());
                }
            } else {
                session('errors',$v->errors());
            }
            return redirect('company/create');
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  \App\Models\Employee  $employee
         * @return View
         */
        public function edit($id = null)
        {
            $title = "Update Company";
            $company = $this->company->getData($id)->fetch();
            return view('company/edit',compact('title','company'));

        }

        /**
         * Update the specified resource in storage.
         *
         * @param  shiftRuleId
         * @return View
         */
        public function update($id=null)
        {
            $inputs = $_POST;
            $inputs = $inputs+$_FILES;
            $v = new Validator($inputs);
            $v->rule('required', ['name','address','from_date','to_date']);

            //make sure we have no error
            if ($this->upload->fileExists('logo')) { //upload->
                $v->rule('in', 'logo.error', [0])->message('No image selected for {field}');
                $v->rule('in', 'logo.type', ['image/jpeg'])->message('Only jpg image is allowed for {field}.');
                $v->rule('max', 'logo.size', 300*1024)->message('Max size is 300kb for {field}.');
            }
            if ($this->upload->fileExists('owner_signature')) { //upload->
                $v->rule('in', 'owner_signature.error', [0])->message('No image selected for {field}');
                $v->rule('in', 'owner_signature.type', ['image/jpeg'])->message('Only jpg image is allowed for {field}.');
                $v->rule('max', 'owner_signature.size', 300*1024)->message('Max size is 300kb for {field}.');
            }

            if($v->validate()) {
                $company = $this->company->getData($id)->fetch();

                $name = validation($inputs['name'] ?? '');
                $address = validation($inputs['address'] ?? '');
                $logo = validation($inputs['logo'] ?? '');
                $local_name = validation($inputs['local_name'] ?? '');
                $local_address = validation($inputs['local_address'] ?? '');
                $owner_name = validation($inputs['owner_name'] ?? '');
                $owner_signature = validation($inputs['owner_signature'] ?? '');
                $office_phone = validation($inputs['office_phone'] ?? '');
                $web_address = validation($inputs['web_address'] ?? '');
                $from_date = date_conversion('Y-m-d',$inputs['from_date']);
                $to_date = date_conversion('Y-m-d',$inputs['to_date']);
                $IsActive = $inputs['IsActive'] ?? 0;

                $company_info = [
                    'name' => ($name),
                    'address' => ($address),
                    'local_name' => ($local_name),
                    'local_address' => ($local_address),
                    'owner_name' => ($owner_name),
                    'office_phone' => ($office_phone),
                    'web_address' => ($web_address),
                    'from_date' => ($from_date),
                    'to_date' => ($to_date),
                    'is_active' => $IsActive
                ];

                $path = 'images/company/';
                $time = time();
                if ($this->upload->fileExists('logo')) { //upload->
                    //remove image first
                    if(file_exists($path.$company->logo)) {
                        unlink($path.$company->logo);
                    }
                    $logo_file_name = $time.'-logo.jpg';
                    $logoPhoto = $this->upload->make('logo');
                    $logoPhoto->save(upload_path($path . $logo_file_name));

                    $company_info['logo'] = $logo_file_name;
                }

                if ($this->upload->fileExists('owner_signature')) { //upload->
                    //remove image first
                    if(file_exists($path.$company->owner_signature)) {
                        unlink($path.$company->owner_signature);
                    }
                    $sign_file_name = $time.'-owner_signature.jpg';;
                    $emSign = $this->upload->make('owner_signature');
                    $emSign->save(upload_path($path . $sign_file_name));

                    $company_info['owner_signature'] = $sign_file_name;
                }

                $rs = $this->company->updateData($company_info,$id);
                if($rs) {
                    notification(['type'=>'success', 'message'=>'Updated Successfully']);
                }
                else {
                    session('errors',$rs->errorInfo());
                }
            } else {
                session('errors',$v->errors());
            }
            return redirect('company/edit/'.$id);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return View
         */
        public function destroy($id=null) {
            if($id) {
                $user = $this->company->destroy($id);
                if($user) {
                    notification(['type'=>'success', 'message'=>'Deleted Successfully']);
                }
                else {
                    session('errors',$user->errorInfo());
                }
            }
            else {
                echo 'Update id not found.';
            }
            return redirect('company/index');
        }
}
