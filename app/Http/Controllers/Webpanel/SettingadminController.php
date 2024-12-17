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
            'email' => 'required|string|unique:tb_admin,email,' . $id,
            'role_name' => 'required|in:Admin,User',
            'password' => 'nullable|string|min:4|confirmed', // ไม่จำเป็นต้องกรอกรหัสผ่าน
        ]);
    
        // ดึงข้อมูลผู้ใช้งานปัจจุบัน
        $user = Auth::guard('admin')->user();
        if (!$user) {
            return redirect()->route('reserve_history.index')->with('error', 'ไม่พบผู้ใช้งานที่ล็อกอิน');
        }
    
        // อัปเดตข้อมูล
        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role_name' => $validated['role_name'],
            'updated_by' => $user->email,
            'updated_at' => now(),
        ];
    
        // ถ้ามีการกรอกรหัสผ่านใหม่ ให้ทำการแฮชและอัปเดตรหัสผ่าน
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($validated['password']);
        }
    
        $updated = DB::table('tb_admin')->where('id', $id)->update($updateData);
    
        if ($updated) {
            return redirect()->route('settingadmin.index')->with('success', 'ข้อมูลอัปเดตสำเร็จ');
        } else {
            return back()->with('error', 'ไม่สามารถอัปเดตข้อมูลได้');
        }
    }
    
    public function add()
    {

        // ตรวจสอบสิทธิ์
        if (Auth::guard('admin')->user()->role_name !== 'Admin') {
            return redirect()->route('settingadmin.index')->with('error', 'คุณไม่มีสิทธิ์ในการเพิ่มข้อมูล');
        }
        // ส่งตัวแปรไปยัง View
        return view('back-end.pages.settingadmin.add', [
            'prefix' => $this->prefix,
            'segment' => $this->segment,
            'folder' => $this->folder,
        ]);
    }

    public function insert(Request $request)
    {
        // Validate ข้อมูลที่ได้รับ
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|unique:tb_admin,email',
            'password' => 'required|string|min:4|confirmed',
            'role_name' => 'required|in:Admin,User',
        ]);

        // ดึงข้อมูลผู้ใช้งานที่ล็อกอิน
        $user = Auth::guard('admin')->user() ?? Auth::user();
        if (!$user) {
            return redirect()->back()->with('error', 'ไม่พบผู้ใช้งานที่ล็อกอิน');
        }

        // บันทึกข้อมูลลงฐานข้อมูล
        DB::table('tb_admin')->insert([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_name' => $validated['role_name'],
            'created_by' => $user->email,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->route('settingadmin.index')->with('success', 'เพิ่มข้อมูลสำเร็จ');
    }

    public function destroy($id)
    {
        // ค้นหาข้อมูลลูกค้าในฐานข้อมูล
        $item = DB::table('tb_admin')->where('id', $id)->first();

        if (!$item) {
            return redirect()->route('settingadmin.index')->with('error', 'ไม่พบข้อมูลที่ต้องการลบ');
        }

        // ตรวจสอบสิทธิ์การลบ (Admin หรือผู้สร้างข้อมูล)
        if (Auth::guard('admin')->user()->role_name !== 'Admin' && Auth::guard('admin')->user()->email !== $item->created_by) {
            return redirect()->route('settingadmin.index')->with('error', 'คุณไม่มีสิทธิ์ในการลบข้อมูล');
        }

        // ลบข้อมูลจากฐานข้อมูล
        DB::table('tb_admin')->where('id', $id)->delete();

        return redirect()->route('settingadmin.index')->with('success', 'ลบข้อมูลสำเร็จ');
    }
}
