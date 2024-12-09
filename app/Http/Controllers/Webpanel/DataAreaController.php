<?php

namespace App\Http\Controllers\Webpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DataAreaController extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'dataarea';
    protected $folder = 'dataarea';
    public function index(Request $request)
    {
        // เริ่มต้น query ข้อมูล
        $query = DB::table('data_area_models');

        // ตรวจสอบว่ามีการส่งค่า type มาหรือไม่
        if ($request->has('type') && !empty($request->type)) {
            $query->where('type', $request->type); // เพิ่มเงื่อนไขการกรอง
        }

        // ดึงข้อมูล
        $data_area_models = $query->get();

        // ส่งข้อมูลไปยัง View
        return view("$this->prefix.pages.$this->folder.index", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
            'data_area_models' => $data_area_models,
            'selected_type' => $request->type, // ส่งค่าที่เลือกกลับไปให้ View
        ]);
    }


    public function add()
    {
        // ตรวจสอบสิทธิ์
        if (Auth::guard('admin')->user()->role_name !== 'Admin') {
            return redirect()->route('dataarea.index')->with('error', 'คุณไม่มีสิทธิ์ในการเพิ่มข้อมูล');
        }

        // ส่งตัวแปรไปยัง View
        return view('back-end.pages.dataarea.add', [
            'prefix' => $this->prefix,
            'segment' => $this->segment,
            'folder' => $this->folder,

        ]);
    }

    public function insert(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|in:รูปแบบที่1,รูปแบบที่2,รูปแบบที่3',
            'pic_area' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'area' => 'required|string|max:20|unique:data_area_models,area',
            'price' => 'required|numeric|min:0|max:1000000',
        ], [
            'area.unique' => 'ชื่อพื้นที่นี้มีในระบบแล้ว กรุณากรอกชื่อพื้นที่ที่แตกต่าง',
        ]);

        // ดึงข้อมูลผู้ใช้งานปัจจุบันเพื่อใช้ในการบันทึกชื่อลงในdatabase
        $user = Auth::guard('admin')->user();
        if (!$user) {
            return redirect()->back()->with('error', 'ไม่พบผู้ใช้งานที่ล็อกอิน');
        }

        $picareaFilename = null;
        if ($request->hasFile('pic_area')) {
            $picareaFilename = time() . '_' . $request->file('pic_area')->getClientOriginalName();
            $request->file('pic_area')->move(public_path('pic_areas'), $picareaFilename);
        }

        // บันทึกข้อมูลลงฐานข้อมูล
        DB::table('data_area_models')->insert([
            'type' => $validated['type'],
            'pic_area' => $picareaFilename,
            'area' => $validated['area'],
            'price' => $validated['price'],
            'created_by' => $user->email, // บันทึกอีเมลผู้สร้าง
            'created_at' => now(),
        ]);
        return redirect()->route('dataarea.index')->with('success', 'เพิ่มข้อมูลสำเร็จ');
    }

    public function edit($id)
    {
        // ตรวจสอบสิทธิ์
        if (Auth::guard('admin')->user()->role_name !== 'Admin') {
            return redirect()->route('dataarea.index')->with('error', 'คุณไม่มีสิทธิ์ในการแก้ไขข้มูลข้อมูล');
        }
        // ดึงข้อมูลจากฐานข้อมูลตาม ID
        $item = DB::table('data_area_models')->find($id);

        if (!$item) {
            return redirect()->route('dataarea.index')->with('error', 'ไม่พบข้อมูล');
        }

        // ส่งข้อมูลไปยังหน้า View พร้อมตัวแปรอื่นๆ
        return view('back-end.pages.dataarea.edit', [
            'item' => $item,
            'prefix' => $this->prefix,  // ส่งตัวแปร $prefix
            'segment' => $this->segment,
            'folder' => $this->folder,
        ]);
    }

    public function update(Request $request, $id)
    {
        // ดึงข้อมูลปัจจุบันของลูกค้าจากฐานข้อมูล
        $item = DB::table('data_area_models')->where('id', $id)->first();

        // ถ้าไม่พบข้อมูลให้ย้อนกลับไปหน้าหลัก
        if (!$item) {
            return redirect()->route('dataarea.index')->with('error', 'ไม่พบข้อมูล');
        }
        // ตรวจสอบและ validate ข้อมูล
        $validated = $request->validate([
            'type' => 'string|in:รูปแบบที่1,รูปแบบที่2,รูปแบบที่3',
            'pic_area' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'area' => 'string|max:20|unique:data_area_models,area,' . $id . ',id', // ตรวจสอบการซ้ำโดยยกเว้น id
            'price' => 'numeric|min:0|max:1000000',
        ], [
            'area.unique' => 'ชื่อพื้นที่นี้มีในระบบแล้ว กรุณากรอกชื่อพื้นที่ที่แตกต่าง',
        ]);

        // ดึงข้อมูลผู้ใช้งานปัจจุบันเพื่อใช้ในการบันทึกชื่อลงในdatabase
        $user = Auth::guard('admin')->user();
        if (!$user) {
            return redirect()->back()->with('error', 'ไม่พบผู้ใช้งานที่ล็อกอิน');
        }

        // จัดการรูปภาพ (ถ้ามีการอัปโหลด) 
        $picareaFilename = $item->pic_area; // ใช้ไฟล์เดิมเป็นค่าเริ่มต้น
        if ($request->hasFile('pic_area')) {
            // สร้างชื่อไฟล์ใหม่เพื่อไม่ให้ซ้ำกัน
            $picareaFilename = time() . '_' . $request->file('pic_area')->getClientOriginalName();

            // บันทึกไฟล์ไปยังโฟลเดอร์ public/pic_areas
            $request->file('pic_area')->move(public_path('pic_areas'), $picareaFilename);

            // ลบไฟล์เก่าถ้ามี
            if (!empty($item->pic_area) && file_exists(public_path('pic_areas/' . $item->pic_area))) {
                unlink(public_path('pic_areas/' . $item->pic_area));
            }
        }

        if (
            $item->type == $validated['type'] &&
            $item->pic_area == $picareaFilename &&
            $item->area == $validated['area'] &&
            $item->price == $validated['price']
        ) {
            // หากไม่มีการเปลี่ยนแปลงข้อมูล, กลับไปยังหน้า index
            return redirect()->route('dataarea.index')->with('success', 'ข้อมูลอัปเดตสำเร็จ');
        }


        // อัปเดตข้อมูลในฐานข้อมูล
        $updated = DB::table('data_area_models')->where('id', $id)->update([
            'type' => $validated['type'],
            'pic_area' => $picareaFilename,
            'area' => $validated['area'],
            'price' => $validated['price'],
            'updated_by' => $user->email, // บันทึกอีเมล
            'updated_at' => now(),
        ]);

        // ถ้าอัปเดตสำเร็จให้กลับไปที่หน้ารายการลูกค้า
        return $updated
            ? redirect()->route('dataarea.index')->with('success', 'ข้อมูลอัปเดตสำเร็จ')
            : back()->with('error', 'ไม่สามารถอัปเดตข้อมูลได้');

    }

    public function destroy($id)
    {
        // ตรวจสอบสิทธิ์
        if (Auth::guard('admin')->user()->role_name !== 'Admin') {
            return redirect()->route('dataarea.index');
        }
        // ค้นหาข้อมูลลูกค้าในฐานข้อมูล
        $item = DB::table('data_area_models')->where('id', $id)->first();

        if (!$item) {
            return redirect()->route('dataarea.index')->with('error', 'ไม่พบข้อมูลที่ต้องการลบ');
        }

        // ลบไฟล์จาก public
        if (!empty($item->pic_area)) {
            $picareaFilename = public_path('pic_areas/' . $item->pic_area);
            if (is_file($picareaFilename)) { // ตรวจสอบว่าเป็นไฟล์
                unlink($picareaFilename); // ลบไฟล์จากระบบ
            }
        }

        // ลบข้อมูลจากฐานข้อมูล
        DB::table('data_area_models')->where('id', $id)->delete();

        return redirect()->route('dataarea.index');
    }
}