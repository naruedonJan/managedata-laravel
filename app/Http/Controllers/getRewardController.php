<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\rewarddb;
use App\userDB;
use RealRashid\SweetAlert\Facades\Alert;
use DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class getRewardController extends Controller
{
    //
    public function get_reward(){
        
        $rewards = rewarddb::leftjoin('category_reward','category','=','cat_id')->orderby('cat_id','asc')->get();
        return response()->json($rewards);
    }

    public function get_reward_id(Request $request){

        $rewards = rewarddb::where("reward_id" , $request->id )->first();
        return response()->json($rewards);
        
        // $rewards = rewarddb::where()->get();
        // return response()->json($rewards);
    }


    public function user_exchange(Request $request){

        $rewards = rewarddb::where("reward_id" , $request->reward_id )->first();
        $user = userDB::where("username" , $request->username)->where("password" , $request->password)->first();
        if(!empty($user) && !empty($rewards)){
            if($user->reward_point < $rewards->point){
                return response()->json(['status' => 'error', 'message' => 'แต้มไม่พอแรกสินค้า']);
            }else{

                DB::table('user_reward_table')->update(['address' => $request->address]);
                DB::table('user_reward_table')->update(['reward_point' => ($user->reward_point - $rewards->point)]);
                $user_result = userDB::where("username" , $request->username)->where("password" , $request->password)->first();

                return response()->json(['status' => 'success', 'message' => 'แลกสินค้าเรียบร้อย' , 'data' => $user_result]);
            }
        }else{
            return response()->json(['status' => 'error', 'message' => 'ไม่พบสินค้าที่ท่านต้องการ']);
        }
    }
    
    public function login_user(Request $request){
        // return response()->json(['status' => 'error', 'message' => 'ไลน์ไอดีไม่ถูกต้อง กรุณาตรวจสอบและลองใหม่อีกครั้ง']);
        // return response()->json($request);
        $post = [
            'mm_user' => $request->username
        ];

        $ch = curl_init('https://adminv2.mm88th.org/chk-soot');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $data_json = curl_exec($ch);
        $data_admin = json_decode($data_json);

        if($data_admin->status == 'true' && $data_admin->tel == $request->password){
            $userDB_check = userDB::where("username" , $request->username)->first();
            if(!empty($userDB_check)){

                $user = userDB::where("username" , $request->username)->where("password" , $request->password)->first();
                if(!empty($user)){
                    return response()->json($user);
                }else{
                    return response()->json(['status' => 'error', 'message' => 'รหัสผ่านไม่ถูกต้อง กรุณาลองใหม่']); 
                }


            }else{
        
                $ch = curl_init('https://adminv2.mm88th.org/chk-reward');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                $data_json_reward = curl_exec($ch);
                $data_reward = json_decode($data_json_reward);

                $userDB_add = new userDB;
                if($data_reward->status == "success"){
                    $userDB_add->reward_point = $data_reward->message;
                }else{
                    $userDB_add->reward_point = 0;
                }

               
                $userDB_add->username = $data_admin->mm_user;
                $userDB_add->password = $data_admin->tel;
                $cust_name = explode(" ", $data_admin->cust_name);
                $name = $cust_name[0];
                $surname = $cust_name[1];
                $userDB_add->name = $name;
                $userDB_add->surname = $surname;
                $userDB_add->agent_id = 1;
                $userDB_add->email = NULL;
                $userDB_add->address = NULL;
                $userDB_add->tel = $data_admin->tel;
                $userDB_add->line_id = $data_admin->line_id;
          
                if($userDB_add->save()){
                    // return response()->json($userDB_add);
                    $user = userDB::where('username', $request->username)->where('password', $request->password)->first();
                    return response()->json($user);
                }else{
                    return response()->json(['status' => 'error', 'message' => 'ขออภัยบันทึกไม่สำเร็จ']); 
                }
               

            }
        }else{
            return response()->json(['status' => 'error', 'message' => 'รหัสผ่านไม่ถูกต้อง กรุณาลองใหม่']); 
        }
        // return response()->json($data_admin);



        // return response()->json($data_admin);
        // return var_dump($data_admin)
    }


}
