<?php

namespace App\Http\Controllers;
use App\userDB;
use App\LuckyboxDB;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class gameRewardController extends Controller
{
    //

    public function play_game_reward (Request $request){
        $user = userDB::where("username" , $request->username)->where("password" , $request->password)->first();
        if($request->result == "plus"){
            // DB::table('user_reward_table')->update(['address' => $request->address]);
            // DB::table('user_reward_table')->update(['reward_point' => ($user->reward_point - $rewards->point)]);
        }else if($request->result == "minus"){

        }

    }

    public function buy_box_amount (Request $request){
    
        $user = userDB::where("username" , $request->username)->where("password" , $request->password)->first();
        // return response()->json($user);
        if($user->reward_point >= $request->amount && $request->amount > 0){
            DB::table('user_reward_table')->update(['reward_point' => ($user->reward_point - $request->amount)]);
            $user_result = userDB::where("username" , $request->username)->where("password" , $request->password)->first();
            if($request->amount == 10){
                return response()->json(
                    ['status' => 'success', 
                    'message' => 'ซื้อกล่องสำเร็จ' , 
                    'amount' => 3 , 
                    'point' => $user_result->reward_point]);

            }else if($request->amount == 5){
                return response()->json(
                    ['status' => 'success', 
                    'message' => 'ซื้อกล่องสำเร็จ' , 
                    'amount' => 1 , 
                    'point' => $user_result->reward_point]);
                    
            }
            
        }else{
            return response()->json(['status' => 'error', 'message' => 'ขออภัยค่ะ Point ของคุณไม่พอ']);
        }
    }

    public function Luckybox_show (){
        if (Auth::user()->web_agent == 0) {
            $box_item = DB::table('luckybox_table')->get();
        }
        else {
            $box_item = DB::table('luckybox_table')->where('agent_id', '=', Auth::user()->web_agent)->get();
        }
        
        return view('luckybox_setting', compact('box_item'));
    }

    public function addItem_inLuckybox(Request $request){
        $item_check = LuckyboxDB::where('item_name',$request->name)->first();
        if(empty($item_check)){
            $item = new LuckyboxDB;
            $original_filename = $request->file('file_upload')->getClientOriginalName();
            $original_filename_arr = explode('.', $original_filename);
            $file_ext = end($original_filename_arr);
            $destination_path = 'storage/lucky_box/';
            $image = time() . '.' . $file_ext;
            $request->file('file_upload')->move($destination_path, $image); 
    
            $item->item_name = $request->name;
            $item->item_image = "storage/lucky_box/".$image;
            $item->item_rate = $request->rate;
            $item->action = $request->action;
            $item->attribute = $request->attribute;
            $item->agent_id = Auth::user()->web_agent;
            
            if($item->save()){
                alert()->success('Success','บันทึกสำเร็จ');
                return redirect()->back();
            }else{
                alert()->error('Error','บันทึกไม่สำเร็จ');
                return redirect()->back();
            }
        }else{
            alert()->error('Error','มีไอเท็มชื่อนี้แล้ว');
            return redirect()->back();
        }
    }

    public function editItem_inLuckybox(Request $request){
        $item_check = LuckyboxDB::where('item_id',$request->itemid)->first();
        if(!empty($item_check)){
            DB::table('luckybox_table')->where('item_id',$request->itemid)
            ->update([
                'item_name' => $request->name ,
                'item_rate' => $request->rate,
                'action' => $request->action,
                'attribute' => $request->attribute,
                'agent_id' => Auth::user()->web_agent,
                ]);
            if(!empty($request->file_upload)){
                $original_filename = $request->file('file_upload')->getClientOriginalName();
                $original_filename_arr = explode('.', $original_filename);
                $file_ext = end($original_filename_arr);
                $destination_path = 'storage/lucky_box/';
                $image = time() . '.' . $file_ext;
                $request->file('file_upload')->move($destination_path, $image); 
                DB::table('luckybox_table')->where('item_id',$request->itemid)->update(['item_image' => "storage/lucky_box/".$image ]);
            }
            alert()->success('Success','บันทึกการแก้ไขสำเร็จ');
            return redirect()->back();
        }else{
            alert()->error('Error','ไม่พบสินค้าที่ต้องการแก้ไข');
            return redirect()->back();
        }
        
    }

    public function randombox(){
        $data_item = LuckyboxDB::get();
        $item = array();
        $random_number = mt_rand(1,1000);

        foreach($data_item as $data){
       
            array_push($item , ($data->item_rate * 10));
           
        }

        // return response()->json(['random' => $random_number ,'data' => $item]);
        $sum = 0;
        for($i = 0 ; $i < count($item) ; $i++){
            // echo ' : '.$item[$i].' : ';
            // echo 'Random : '.$random_number;
            $sum =  $sum + $item[$i];
            if($random_number <= $sum){
                // return 'sumitem : '.$sum.' number : '.$i;
                return response()->json(['number' => ($i+1) , 'data' => $data_item[$i] ]);
            }
            
        }

        
    }

    public function Spinner_show (){
        
    }

  

}
