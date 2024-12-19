<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $rule = [
            'name' => 'required|unique:users', 
            'email' => 'required|email', 
            'password' => 'required|min:6|confirmed', 
            'password_confirmation' => 'required'
        ];
        $message = [
            'name.required' => '用户名不能为空', 
            'name.unique' => '用户名不能重复', 
            'email.required' => '邮箱不能为空',
            'email.email' => '邮箱格式不正确',
            'password.required' => '密码不能为空',
            'password.min' => '密码长度不能小于6位',
            'password.confirmed' => '两次密码不一致',
        ];
        $validator = Validator::make($request->all(), $rule, $message); 
        if($validator->fails()){
            $errors = $validator->errors()->all();
            return response()->json(['status' => '1', 'msg' => $errors]);
        }
        $re = User::create($request->all());
        if($re){
            return response()->json(['status' => '1', 'msg' => '注册成功']);
        } else {
            return response()->json(['status' => '2', 'msg' => '注册失败']);
        }
    }

    public function login(Request $request){
        $rule = [
            'name' => 'required', 
            'password' => 'required|min:6'
        ]; 
        $message = [
            'name.required' => '用户名不能为空', 
            'password.required' => '密码不能为空', 
            'password.min' => '密码长度不能小于6位'
        ]; 
        $validator = Validator::make($request->all(), $rule, $message); 
        if($validator->fails()){
            foreach ($validator->getMessageBag()->toArray() as $v){
                $msg = $v[0];
            }
            return response()->json(['status' => '1', 'msg' => $msg]);
        }
        $name = $request->get('name');
        $password = $request->get('password'); 
        $theUser = User::where('name', $name)->first();
        if($theUser){
            if($password == $theUser->password){
                Session::put('users',['id' => $theUser->id,'name' => $name]);
                return response()->json(['status' => '1','msg' => '登录成功']);
            } else {
                return response()->json(['status' => '1','msg' => '密码错误']);
            }
        } else {
            return response()->json(['status' => '2', 'msg' => '用户名不存在']);
        }
    }

    public function logout(){
        if(request()->session()->has('users')){
            request()->session()->pull('users',session('users'));
        }
        return redirect('/');
    }
}
