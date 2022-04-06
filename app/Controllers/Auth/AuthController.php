<?php

namespace App\Controllers\Auth;

use App\Models\User;
use Vendor\Valitron\Validator;

class AuthController // extends Controller
{
    private $auth;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->auth = new User();
    }

    /**
     * Display a login page
     *
     * @return view
     */
    public function login()
    {
        $title = "Login";
        return view('auth/login',[],false);
    }

    /**
     * Login with credentials.
     *
     * @return \Illuminate\Http\Response
     */
    public function loginAuth()
    {
        $inputs = $_POST;
        $v = new Validator($inputs);
        $v->rule('required', ['user_name', 'password','captcha']);
        $v->rule('alphaNum', 'user_name');
        $v->rule('lengthBetween', 'password', 5, 20);
        if($v->validate()) {
            $user_data = [
                'user_name' => validation($inputs['user_name'])
            ];
            if($inputs['firstNumber']+$inputs['secondNumber']==$inputs['captcha']){  
                $user = $this->auth->table("users")->where($user_data)->fetch();
                if ($user) {
                    if (verify_hash(validation($inputs['password']), $user->password)) {
                        $login_data = [
                            'is_logged_in' => true,
                            'user_id' => $user->id,
                            'role_id' => $user->role_id,
                            'user_name' => $user->name
                        ];
                        session($login_data);
                        return redirect('dashboard');
                    }else {
                        $errors['user_name'] = [
                            '0' => 'Username/Password did not match.'
                        ];
                    }
                }else {
                    $errors['user_name'] = [
                        '0' => 'Username/Password did not match.'
                    ];
                }
             }else{
                $errors['captcha'] = [
                        '0' => 'Captche does not match.'
                    ];
             }
        }
        else {
            $errors = $v->errors();
        }
        session('errors',$errors);
        return redirect('auth/login');
    }

    /**
     * Logout from this system
     *
     * @return view
     */
    public function logout()
    {
        session_empty();
        return redirect("auth/login");
    }

}
