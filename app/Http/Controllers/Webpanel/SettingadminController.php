<?php

namespace App\Http\Controllers\Webpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Backend\AdminModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class SettingadminController extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'settingadmin';
    protected $folder = 'settingadmin';

    public function index(Request $request)
    {
        $tb_admin = DB::table('tb_admin')->get();

        return view("$this->prefix.pages.$this->folder.index", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
            'tb_admin' => $tb_admin,
        ]);
    }
    public function edit($id)
    {
        // ตรวจสอบสิทธิ์
        if (Auth::guard('admin')->user()->role_name !== 'Admin') {
            return redirect()->route('settingadmin.index')->with('error', 'คุณไม่มีสิทธิ์ในการแก้ไขข้อมูล');
        }
        // ดึงข้อมูลจากฐานข้อมูลตาม ID
        $item = DB::table('tb_admin')->find($id);

        if (!$item) {
            return redirect()->route('settingadmin.index')->with('error', 'ไม่พบข้อมูล');
        }
        // ส่งข้อมูลไปยังหน้า View พร้อมตัวแปรอื่นๆ
        return view('back-end.pages.settingadmin.edit', [
            'item' => $item,
            'prefix' => $this->prefix,  // ส่งตัวแปร $prefix
            'segment' => $this->segment,
            'folder' => $this->folder,
        ]);
    }
    public function update(Request $request, $id)
    {
        // ดึงข้อมูลเดิมจากฐานข้อมูล
        $tb_admin = DB::table('tb_admin')->where('id', $id)->first();

        // Validate ข้อมูลที่ได้รับจากฟอร์ม
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role_name' => 'required|in:Admin,User',
        ]);
    
        // ตรวจสอบว่าไม่มีการเปลี่ยนแปลงข้อมูล
        if (
            $tb_admin->name == $validated['name'] &&   
            $tb_admin->role_name == $validated['role_name'] 
            
        )
         {
            return redirect()->route('settingadmin.index')->with('success', 'ข้อมูลอัปเดตสำเร็จ');
        }
        // อัปเดตข้อมูลในฐานข้อมูล
        $updated = DB::table('tb_admin')->where('id', $id)->update([
            'name' => $validated['name'],
            'role_name' => $validated['role_name'],
        ]);
    
        if ($updated) {
            return redirect()->route('settingadmin.index')->with('success', 'ข้อมูลอัปเดตสำเร็จ');
        } else {
            return back()->with('error', 'ไม่สามารถอัปเดตข้อมูลได้');
        }
    } 

}  

