<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use \Illuminate\Http\Response as Res;
use App\User;
use App\UserDetail;
use App\UserJobDetail;
use App\Product;
use App\JobList;
use Illuminate\Support\Facades\Validator;

class UserController extends ApiController {
    
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' =>  'required',
            'email' =>  'required|unique:users|email',
            'mobile' =>  'required|unique:users',
            'password' => 'required|min:6',
        ]);
        if($validator->passes()){
            $user = new User();
            $user->username = $request['username'];
            $user->email = $request['email'];
            $user->mobile = $request['mobile'];
            $user->password = md5($request['password']);
            if (empty($request['promo_code'])) {
                $user->promo_code = '0';    
            }else{
                $user->promo_code = $request['promo_code'];
            }
            $user->type = $request['type'];
            $user->save();      
            $length = $user->count();      
            if($length > 0){
                return $this->respond(['status' => 'true', 'message' => 'User register successfully!', 'data' => $user]);
            }else{
                return $this->respond(['status' => 'false', 'message' => 'User register Failed!',]);
            }
        }else {
            return $this->respondWithError($validator->messages());
        }
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' =>  'required|email',
            'password' => 'required|min:6',
        ]);
        if($validator->passes()){
            //$user = User::where('email', $request['email'])->where('password', $request['password'])->first();
            $user = User::where('email', $request['email'])->where('password', md5($request['password']))->first();
            if ($user == null) {
                return $this->respond(['status' => 'false', 'message' => 'Login Failed!',]);
            }else {
                $length = $user->count();      
                if($length > 0){
                    return $this->respond(['status' => 'true', 'message' => 'Login successfully!', 'data' => $user]);
                }else{
                    return $this->respond(['status' => 'false', 'message' => 'Login Failed!',]);
                }
            }
        }else {
            return $this->respondWithError($validator->messages());
        }
    }

    public function userDetail(Request $request) {
        $validator = Validator::make($request->all(), [
            'contact_mobile' =>  'required',
            'city' =>  'required',
            'locality' =>  'required',
            'role' =>  'required',
            'sub_role' =>  'required',
            'age' =>  'required',
            'gender' =>  'required',
            'qualification' =>  'required',
        ]);
        if($validator->passes()){
            $user = new UserDetail();
            $user->user_id = $request['user_id'];
            $user->contact_mobile = $request['contact_mobile'];
            $user->city = $request['city'];
            $user->locality = $request['locality'];
            $user->role = $request['role'];
            $user->sub_role = $request['sub_role'];
            $user->age = $request['age'];
            $user->gender = $request['gender'];
            $user->qualification = $request['qualification'];
            $user->save();      
            $length = $user->count();      
            if($length > 0){
                return $this->respond(['status' => 'true', 'message' => 'Updated']);
            }else{
                return $this->respond(['status' => 'false', 'message' => 'Update Failed!']);
            }
        }else {
            return $this->respondWithError($validator->messages());
        }
    }

    public function user_job_detail(Request $request) {
        $validator = Validator::make($request->all(), [
            'language' =>  'required',
            'experience' =>  'required',
            'current_work' =>  'required',
            'desination' =>  'required',
            'current_salary' =>  'required',
            'passport' =>  'required',
            'type_job' =>  'required',
        ]);
        if($validator->passes()){
            $user = new UserJobDetail();
            $user->language = $request['language'];
            $user->experience = $request['experience'];
            $user->current_work = $request['current_work'];
            $user->desination = $request['desination'];
            $user->current_salary = $request['current_salary'];
            $user->passport = $request['passport'];
            $user->type_job = $request['type_job'];
            $user->user_id = $request['user_id'];
            $user->save();      
            $length = $user->count();      
            if($length > 0){
                return $this->respond(['status' => 'true', 'message' => 'Updated']);
            }else{
                return $this->respond(['status' => 'false', 'message' => 'Update Failed!']);
            }
        }else {
            return $this->respondWithError($validator->messages());
        }
    }

    public function checkmobile(Request $request){
         $validator = Validator::make($request->all(), [
            'mobile' =>  'required|min:10',
        ]);
        if($validator->passes()){
            $user = User::whereIn('mobile', [$request['mobile']])->get();
            $length = $user->count();
            if($length > 0){
                return $this->respond(['status' => 'true', 'message' => 'User details', 'user_id' => $user[0]->id]);
            }else {
                return $this->respond(['status' => 'false', 'message' => 'User not found']);
            }
        }else {
            return $this->respondWithError($validator->messages());
        }
    }

    public function changepassword(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' =>  'required',
            'password' =>  'required|min:6',
        ]);
        if($validator->passes()){
            $user = User::where('id', $request['user_id'])->first();
            $length = $user->count();
            if($length > 0){
                $user->password = md5($request['password']);
                $user->save();
                return $this->respond(['status' => 'true', 'message' => 'password update']);
            }else {
                return $this->respond(['status' => 'false', 'message' => 'password is not update']);
            }
        }else {
            return $this->respondWithError($validator->messages());
        }
    }

    public function joblist(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' =>  'required',
        ]);
        if($validator->passes()){
            $joblist = JobList::get();
            $length = $joblist->count();
            if($length > 0){
                return $this->respond(['status' => 'true', 'message' => 'JobList found', 'data' => $joblist]);
            }else {
                return $this->respond(['status' => 'false', 'message' => 'JobList not found']);
            }
        }else {
            return $this->respondWithError($validator->messages());
        }
    }
    
    public function user_profile(Request $request){
        $dbdata=array();
        $user = User::where('id', $request['user_id'])->first();
        $length = $user->count();
        if($length > 0){
            $dbdata['id']=$user->id;
            $dbdata['username']=$user->username;
            $dbdata['email']=$user->email;
            $dbdata['mobile']=$user->mobile;

            $userDetail = UserDetail::whereIn('user_id', [$user->id])->get();
            $user1 = $userDetail->count();  
            if ($user1 > 0) {
                $dbdata['contact_mobile']=$userDetail[0]->contact_mobile;
                $dbdata['city']=$userDetail[0]->city;
                $dbdata['locality']=$userDetail[0]->locality;
                $dbdata['role']=$userDetail[0]->role;
                $dbdata['sub_role']=$userDetail[0]->sub_role;
                $dbdata['age']=$userDetail[0]->age;
                $dbdata['gender']=$userDetail[0]->gender;
                $dbdata['qualification']=$userDetail[0]->qualification;
            }else{
                $dbdata['contact_mobile']='';
                $dbdata['city']='';
                $dbdata['locality']='';
                $dbdata['role']='';
                $dbdata['sub_role']='';
                $dbdata['age']='';
                $dbdata['gender']='';
                $dbdata['qualification']='';
            }
            $userJobDetail = UserJobDetail::whereIn('user_id', [$user->id])->get();
            $user2 = $userDetail->count();  
            if ($user2 > 0) {
                $dbdata['language']=$userJobDetail[0]->language;
                $dbdata['experience']=$userJobDetail[0]->experience;
                $dbdata['current_work']=$userJobDetail[0]->current_work;
                $dbdata['desination']=$userJobDetail[0]->desination;
                $dbdata['current_salary']=$userJobDetail[0]->current_salary;
                $dbdata['passport']=$userJobDetail[0]->passport;
                $dbdata['type_job']=$userJobDetail[0]->type_job;
            }else{
                $dbdata['language']='';
                $dbdata['experience']='';
                $dbdata['current_work']='';
                $dbdata['desination']='';
                $dbdata['current_salary']='';
                $dbdata['passport']='';
                $dbdata['type_job']='';
            }
            return $this->respond(['status' => 'true', 'message' => 'User details', 'data' => $dbdata]);
        }else{
            return $this->respond(['status' => 'false', 'message' => 'User details is not found']);
        }
    }

    public function profile(Request $request){
        $dbdata=array();
        $user = User::where('id', $request['user_id'])->first();
        $length = $user->count();
        if($length > 0){
            $userDetail = UserDetail::whereIn('user_id', [$user->id])->get();
            $user1 = $userDetail->count();  
            if ($user1 > 0) {
                $dbdata['userDetail']=$userDetail;    
            }
            $userJobDetail = UserJobDetail::whereIn('user_id', [$user->id])->get();
            $user2 = $userDetail->count();  
            if ($user2 > 0) {
                $dbdata['userJobDetail']=$userJobDetail;    
            }
            $dbdata['user']=$user;
            return $this->respond(['status' => 'true', 'message' => 'User details', 'data' => $dbdata]);
        }else{
            return $this->respond(['status' => 'false', 'message' => 'User details is not found']);
        }
    }
    
}
