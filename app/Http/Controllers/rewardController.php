<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\rewarddb;
use RealRashid\SweetAlert\Facades\Alert;

class rewardController extends Controller
{
    public function rewardShow(){
        if (Auth::user()->web_agent == 0) {
            $reward = rewarddb::leftjoin('category_reward', 'category', '=', 'cat_id')->get();
        }
        else {
            $reward = rewarddb::leftjoin('category_reward', 'category', '=', 'cat_id')->where('reward_table.agent_id', '=', Auth::user()->web_agent)->get();
        }
        $categorys = DB::table('category_reward')->get();
        return view('reward_setting', compact('reward','categorys'));
    }

    public function addReward(Request $request){
        $reward = new rewarddb;

        // $path = $request->file('file_upload')->store('/public/reward_image');        
        // $path = str_replace("public","storage",$path);    
        $original_filename = $request->file('file_upload')->getClientOriginalName();
        $original_filename_arr = explode('.', $original_filename);
        $file_ext = end($original_filename_arr);
        $destination_path = 'storage/reward_image/';
        $image = time() . '.' . $file_ext;
        $request->file('file_upload')->move($destination_path, $image);    

        $reward->name_item = $request->name;
        $reward->point = $request->point;
        $reward->url_image = "storage/reward_image/".$image;
        $reward->description = $request->description;
        $reward->category = $request->category;
        $reward->agent_id = Auth::user()->web_agent;
        $reward->save();
        if($reward->save()){
            alert()->success('Success','บันทึกสำเร็จ');
            return redirect()->back();
        }else{
            alert()->Error('Error','บันทึกไม่สำเร็จ');
            return redirect()->back();
        }
    }

    public function editReward(Request $request)
    {
        $reward = new rewarddb;

        try {
            if($request->file('url_image') == NULL) {
                $image = $_POST['old_url_image'];
            }
            else{
                $original_filename = $request->file('url_image')->getClientOriginalName();
                $original_filename_arr = explode('.', $original_filename);
                $file_ext = end($original_filename_arr);
                $destination_path = 'storage/reward_image/';
                $image = time() . '.' . $file_ext;
                $request->file('url_image')->move($destination_path, $image);
            }
            $reward->where('reward_id', $request->get('reward_id'))
            ->update([
                'name_item' => $request->get('name_item'),
                'point' => trim($request->get('point')),
                'url_image' => "storage/reward_image/".trim($image),
                'description' => $request->get('description'),
                'category' => $request->get('category'),
                'agent_id' => Auth::user()->web_agent
            ]);
            alert()->success('บันทึกข้อมูลสำเร็จ');
            return redirect()->back();
        } catch (QueryException $e) {
            alert()->error('บันทึกข้อมูลไม่สำเร็จ กรุณาตรวจสอบข้อมูลอีกครั้ง')->autoclose(5000);
            return redirect()->back();
        }
    }

    public function deleteReward(Request $request)
    {
        $reward = new rewarddb;

        try {
            $reward->where('reward_id', '=', $_GET['reward_id'])->delete();
            alert()->success('ลบเรียบร้อย');
            return redirect()->back();
        } catch (QueryException $e) {
            alert()->error('บันทึกข้อมูลไม่สำเร็จ กรุณาตรวจสอบข้อมูลอีกครั้ง')->autoclose(5000);
            return redirect()->back();
        }
    }

    public function rewardGet(){
        if (Auth::user()->web_agent == 0) {
            $rewards = DB::table('log_reward')->leftjoin('reward_table', 'reward', '=', 'reward_id')->get();
        }
        else {
            $rewards = DB::table('log_reward')->leftjoin('reward_table', 'reward', '=', 'reward_id')->where('log_reward.agent_id', '=', Auth::user()->web_agent)->get();
        }
        
        return view('rewardGet', compact('rewards'));
    }

    public function category(){
        if (Auth::user()->web_agent == 0) {
            $categorys = DB::table('category_reward')->get();
        }
        else {
            $categorys = DB::table('category_reward')->where('agent_id', '=', Auth::user()->web_agent)->get();
        }
        return view('category', compact('categorys'));
    }

    public function addCategory(Request $request){
        try {
            DB::table('category_reward')->insert([
                'cat_name' => $request->get('cat_name'),
                'agent_id' => Auth::user()->web_agent
            ]);

            alert()->success('บันทึกข้อมูลแล้ว');
            return redirect()->back();
        } catch (QueryException $e) {
            alert()->error('บันทึกข้อมูลไม่สำเร็จ กรุณาตรวจสอบข้อมูลอีกครั้ง')->autoclose(5000);
            return redirect()->back();
        }
    }

    public function editCategory(Request $request)
    {
        try {
            DB::table('category_reward')->where('cat_id', $request->get('cat_id'))
            ->update([
                'cat_name' => $request->get('cat_name'),
                'agent_id' => Auth::user()->web_agent
            ]);
            alert()->success('บันทึกข้อมูลสำเร็จ');
            return redirect()->back();
        } catch (QueryException $e) {
            alert()->error('บันทึกข้อมูลไม่สำเร็จ กรุณาตรวจสอบข้อมูลอีกครั้ง')->autoclose(5000);
            return redirect()->back();
        }
    }

    public function deleteCategory(Request $request)
    {
        try {
            DB::table('category_reward')->where('cat_id', '=', $_GET['cat_id'])->delete();
            alert()->success('ลบเรียบร้อย');
            return redirect()->back();
        } catch (QueryException $e) {
            alert()->error('บันทึกข้อมูลไม่สำเร็จ กรุณาตรวจสอบข้อมูลอีกครั้ง')->autoclose(5000);
            return redirect()->back();
        }
    }
}
