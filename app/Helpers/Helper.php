<?php

namespace App\helpers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Backend\AdminModel;
use App\Models\Backend\CustomerModel;
use App\Models\Backend\QustionModel;
use App\Models\Backend\Customer_question_headModel;
use App\Models\Backend\Customer_question_pointModel;
use App\Models\Backend\Customer_question_timeModel;
use DB;

class Helper 
{
    protected $prefix = 'back-end';
    //==== Menu Active ====
    public static function auth_menu()
    {
        return view("back-end.alert.alert",[
            'url'=> "webpanel",
            'title' => "เกิดข้อผิดพลาด",
            'text' => "คุณไม่ได้รับสิทธิ์ในการใช้เมนูนี้ ! ",
            'icon' => 'error'
        ]); 
    }
    
    public static function menu_active($menu_id)
    {
        $member_id = Auth::guard('admin')->id();
        $member = \App\Models\Backend\AdminModel::find($member_id);
        $role = \App\Models\Backend\RoleModel::find($member->role);
        $list_role = \App\Models\Backend\Role_listModel::where(['role_id'=>$role->id, 'menu_id'=>$menu_id])->first();
        return $list_role;
    }

    public static function getRandomID($size, $table, $column_name)
    {
        $check_status = 0;
        while ($check_status == 0) 
        {
            $random_id = Helper::randomCode($size);

            $data = DB::table($table)->where("$column_name","$random_id")->get();
            if($data->count() == 0)
            {
                $check_status = 1;
            }
        }
        return $random_id;
    }

    public static function randomCode($length)
    {
        $possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghigklmnopqrstuvwxyz"; //ตัวอักษรที่ต้องการสุ่ม
        $str = "";
        while (strlen($str) < $length) {
            $str .= substr($possible, (rand() % strlen($possible)), 1);
        }
        return $str;
    }

    public static function convertThaiDate($date, $type = 'date')
    {
        $thai_months = [
            1 => 'ม.ค.',
            2 => 'ก.พ.',
            3 => 'มี.ค.',
            4 => 'เม.ย.',
            5 => 'พ.ค.',
            6 => 'มิ.ย.',
            7 => 'ก.ค.',
            8 => 'ส.ค.',
            9 => 'ก.ย.',
            10 => 'ต.ค.',
            11 => 'พ.ย.',
            12 => 'ธ.ค.',
        ];
        $date = Carbon::parse($date);
        $month = $thai_months[$date->month];
        $year = $date->year + 543;

        if ($type == 'datetime') {
            return $date->format("j $month $year H:i:s");
        }

        return $date->format("j $month $year");
    }


    public static function typeLogs($type){
        $html = "";
        if($type == "Error"){
            $html.='
            
            <span class="fw-semibold text-danger"><b><i class="fas fa-exclamation-circle"></i> Error</b></span>';
        }
        return $html;
    }

    public static function typeLogsSystem($type){
        $html = "";
        if($type == "backend"){
            $html.='
            <span class="fw-semibold text-info"><b>Backend</b></span>';
        }else if($type == "frontend"){
            $html.='
            <span class="fw-semibold text-primary"><b>Frontend</b></span>';
        }
        return $html;
    }

    public static function isActive($status)
    {
        $data = "";
        if ($status == 'Y') {
            $data = '<i style="font-size:20px;" class="fa fa-check-circle text-success"></i> ใช้งาน';
        } elseif ($status == 'N') {
            $data = '<i style="font-size:20px;" class="fa fa-times-circle text-danger"></i> ไม่ใช้งาน';
        }
        return $data;
    }

    public static function Status($status)
    {
        $data = "";
        if ($status == 'Y') {
            $data = 'bg-success';
        } elseif ($status == 'N') {
            $data = 'bg-danger';
        }
        return $data;
    }

    public static function authMe($id){
        $data = "";
        $item = AdminModel::find($id);
        if($item){
            $data = $item;
        }
        return $data;
    }

    public static function mainMenu(){
        $menus = \App\Models\Backend\MenuModel::whereIn('position', ['main','topic'])->where('status','on')->orderby('sort', 'asc')->get();
        return $menus;
    }

    public static function subMenu($menu_id){
        $menus = \App\Models\Backend\MenuModel::where(['position'=>'secondary', '_id'=>$menu_id])
        ->where('status','on')
        ->orderby('sort', 'asc')
        ->get();;
        return $menus;
    }
    //=====================
}