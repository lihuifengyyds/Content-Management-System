<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
class UserController extends Controller
{
    public function login()
    {
        return view('admin\login');
    }

    public function check(Request $request)
    {
        $rule = [
            'username' => 'required',
            'password' => 'required|min:6',
            'captcha' => 'required|captcha'
        ];
        $message = [
            'username.required' => '用户名不能为空',
            'password.required' => '密码不能为空',
            'password.min' => '密码长度不能小于6位',
            'captcha.required' => '验证码不能为空',
            'captcha.captcha' => '验证码错误'
        ];

        $validator = Validator::make($request->all(), $rule, $message);
        if($validator->fails()){
            foreach($validator->getMessageBag()->toArray() as $v){
                $msg = $v[0];
            }
            return response()->json(['code' => 0, 'msg' => $msg]);
        }

        $username = $request->input('username');
        $password = $request->input('password'); 
        $theUser = Admin::where('username',$username)->first();
        if($theUser->password == md5(md5($password).$theUser->salt)){
            Session::put('user',['id' => $theUser->id, 'name' => $username]);
            // return response()->json(['code' => 1, 'msg' => '登录成功']);
            return redirect('/admin/index');
        }else{
            return response()->json(['code' => 0, 'msg' => '登录失败']);
        }
    }

    public function logout(){
        if(request()->session()->has('user')){
            request()->session()->pull('user',session('user'));
        }
        return redirect('admin/login');
    }
}
