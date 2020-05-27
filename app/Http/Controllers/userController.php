<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class userController extends Controller
{
    public function showAgent(Request $request){
        $agents = DB::table('agent')->get();
        return view('manageAgent', compact('agents'));
    }

    public function showUser(Request $request){
        if (Auth::user()->web_agent == 0) {
            $users = DB::table('users')->selectRaw('*, users.name as uname , agent.name as aname')->leftjoin('agent', 'web_agent', '=', 'agent_id')->get();
        }
        else {
            $users = DB::table('users')->selectRaw('*, users.name as uname , agent.name as aname')->leftjoin('agent', 'web_agent', '=', 'agent_id')->where('users.web_agent', '=', Auth::user()->web_agent)->get();
        }
        
        $agents = DB::table('agent')->get();
        return view('manageUser', compact('users', 'agents'));
    }

    public function addUser(Request $request){
        try {
            DB::table('users')->insert([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password')),
                'web_agent' => $request->get('web_agent'),
            ]);

            alert()->success('บันทึกข้อมูลแล้ว');
            return redirect()->back();
        } catch (QueryException $e) {
            alert()->error('บันทึกข้อมูลไม่สำเร็จ กรุณาตรวจสอบข้อมูลอีกครั้ง')->autoclose(5000);
            return redirect()->back();
        }
    }

    public function editUser(Request $request)
    {
        try {
            DB::table('users')->where('id', $request->get('id'))
            ->update([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'web_agent' => $request->get('web_agent'),
            ]);
            alert()->success('บันทึกข้อมูลสำเร็จ');
            return redirect()->back();
        } catch (QueryException $e) {
            alert()->error('บันทึกข้อมูลไม่สำเร็จ กรุณาตรวจสอบข้อมูลอีกครั้ง')->autoclose(5000);
            return redirect()->back();
        }
    }

    public function deleteUser(Request $request)
    {
        try {
            DB::table('users')->where('id', '=', $_GET['user_id'])->delete();
            alert()->success('ลบเรียบร้อย');
            return redirect()->back();
        } catch (QueryException $e) {
            alert()->error('บันทึกข้อมูลไม่สำเร็จ กรุณาตรวจสอบข้อมูลอีกครั้ง')->autoclose(5000);
            return redirect()->back();
        }
    }

    public function changePassword(Request $request)
    {
        try {
            DB::table('users')->where('id', $request->get('id'))
            ->update([
                'password' => bcrypt($request->get('password'))
            ]);
            alert()->success('บันทึกข้อมูลสำเร็จ');
            return redirect()->back();
        } catch (QueryException $e) {
            alert()->error('บันทึกข้อมูลไม่สำเร็จ กรุณาตรวจสอบข้อมูลอีกครั้ง')->autoclose(5000);
            return redirect()->back();
        }
    }

    public function addAgent(Request $request){
        try {
            if($request->file('image') != NULL) {
                $original_filename = $request->file('image')->getClientOriginalName();
                $original_filename_arr = explode('.', $original_filename);
                $file_ext = end($original_filename_arr);
                $destination_path = 'storage/agent/';
                $image = time() . '.' . $file_ext;
                $request->file('image')->move($destination_path, $image);
                $image = $destination_path.$image;
            }
            else {
                $image = '' ;
            }

            DB::table('agent')->insert([
                'name' => $request->get('name'),
                'domain' => $request->get('domain'),
                'ip' => $request->get('ip'),
                'line' => $request->get('line'),
                'image' => $image,
                // 'status' => $request->get('status')
            ]);

            alert()->success('บันทึกข้อมูลแล้ว');
            return redirect()->back();
        } catch (QueryException $e) {
            alert()->error('บันทึกข้อมูลไม่สำเร็จ กรุณาตรวจสอบข้อมูลอีกครั้ง')->autoclose(5000);
            return redirect()->back();
        }
    }

    public function editAgent(Request $request)
    {
        try {
            if($request->file('image') == NULL) {
                $image = $_POST['old_image'];
            }
            else{
                $original_filename = $request->file('image')->getClientOriginalName();
                $original_filename_arr = explode('.', $original_filename);
                $file_ext = end($original_filename_arr);
                $destination_path = 'storage/agent/';
                $image = time() . '.' . $file_ext;
                $request->file('image')->move($destination_path, $image);
                $image = $destination_path.$image;
            }
            DB::table('agent')->where('agent_id', $request->get('agent_id'))
            ->update([
                'name' => $request->get('name'),
                'domain' => $request->get('domain'),
                'ip' => $request->get('ip'),
                'line' => $request->get('line'),
                'image' => $image,
                'status' => $request->get('status')
            ]);
            alert()->success('บันทึกข้อมูลสำเร็จ');
            return redirect()->back();
        } catch (QueryException $e) {
            alert()->error('บันทึกข้อมูลไม่สำเร็จ กรุณาตรวจสอบข้อมูลอีกครั้ง')->autoclose(5000);
            return redirect()->back();
        }
    }

    public function deleteAgent(Request $request)
    {
        try {
            DB::table('agent')->where('agent_id', '=', $_GET['agent_id'])->delete();
            alert()->success('ลบเรียบร้อย');
            return redirect()->back();
        } catch (QueryException $e) {
            alert()->error('บันทึกข้อมูลไม่สำเร็จ กรุณาตรวจสอบข้อมูลอีกครั้ง')->autoclose(5000);
            return redirect()->back();
        }
    }
}
