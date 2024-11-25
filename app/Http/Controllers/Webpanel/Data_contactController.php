<?php

namespace App\Http\Controllers\Webpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Data_contactController extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'data_contact';
    protected $folder = 'data_contact';

    public function index(Request $request)
    {
        $data_contact_models = DB::table('data_contact_models')->get();

        return view("$this->prefix.pages.$this->folder.index", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
            'data_contact_models' => $data_contact_models,
        ]);
    }

    public function add()
    {
        // ส่งตัวแปรไปยัง View
        return view('back-end.pages.data_contact.add', [
            'prefix' => $this->prefix,
            'segment' => $this->segment,
            'folder' => $this->folder,
        ]);
    }

    public function insert(Request $request)
    {
        $validated = $request->validate([
            'map' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'address' => 'required|string',
            'tel' => 'required|digits:10',
        ], [
            'tel.digits' => 'หมายเลขเบอร์โทรศัพท์ต้องมีความยาว 10 หลักเท่านั้น', 
        ]);

        $mapFilename = null;
        if ($request->hasFile('map')) {
            $mapFilename = time() . '_' . $request->file('map')->getClientOriginalName();
            $request->file('map')->move(public_path('maps'), $mapFilename);
        }
        // บันทึกข้อมูลลงฐานข้อมูล
        DB::table('data_contact_models')->insert([
            'map' => $mapFilename,
            'address' => $validated['address'],
            'tel' => $validated['tel'],
            'created_at' => now(), 
            'updated_at' => now(), 
        ]);
        return redirect()->route('data_contact.index')->with('success', 'เพิ่มข้อมูลสำเร็จ');
    }

    public function edit($id)
    {
        // ดึงข้อมูลจากฐานข้อมูลตาม ID
        $item = DB::table('data_contact_models')->find($id);

        if (!$item) {
            return redirect()->route('data_contact.index')->with('error', 'ไม่พบข้อมูล');
        }
        // ส่งข้อมูลไปยังหน้า View พร้อมตัวแปรอื่นๆ
        return view('back-end.pages.data_contact.edit', [
            'item' => $item,
            'prefix' => $this->prefix,  // ส่งตัวแปร $prefix
            'segment' => $this->segment,
            'folder' => $this->folder,
        ]);
    }

    public function update(Request $request, $id)
    {
        // ดึงข้อมูลปัจจุบันของลูกค้าจากฐานข้อมูล
        $item = DB::table('data_contact_models')->where('id', $id)->first();

        // ถ้าไม่พบข้อมูลให้ย้อนกลับไปหน้าหลัก
        if (!$item) {
            return redirect()->route('data_contact.index')->with('error', 'ไม่พบข้อมูล');
        }

        // ตรวจสอบและ validate ข้อมูล
        $validated = $request->validate([
            'map' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'address' => 'required|string',
            'tel' => 'required|digits:10',
        ], [
            'tel.digits' => 'หมายเลขเบอร์โทรศัพท์ต้องมีความยาว 10 หลักเท่านั้น', 
        ]);

        // เริ่มต้นการจัดการไฟล์แผนที่
        $mapFilename = $item->map; // ใช้ไฟล์เดิมเป็นค่าเริ่มต้น

        // ตรวจสอบว่าอัปโหลดไฟล์ใหม่หรือไม่
        if ($request->hasFile('map')) {
            // สร้างชื่อไฟล์ใหม่เพื่อไม่ให้ซ้ำกัน
            $mapFilename = time() . '_' . $request->file('map')->getClientOriginalName();

            // บันทึกไฟล์ไปยังโฟลเดอร์ public/maps
            $request->file('map')->move(public_path('maps'), $mapFilename);

            // ลบไฟล์เก่าถ้ามี
            if (!empty($item->map) && file_exists(public_path('maps/' . $item->map))) {
                unlink(public_path('maps/' . $item->map));
            }
        }

        // ตรวจสอบว่าไม่มีการเปลี่ยนแปลงข้อมูล
        if ($item->map == $mapFilename && $item->address == $validated['address'] && $item->tel == $validated['tel']) {
            // ถ้าไม่มีการเปลี่ยนแปลงกลับไปหน้า index
            return redirect()->route('data_contact.index')->with('success', 'ข้อมูลอัปเดตสำเร็จ');
        }

        if (
            $item->map == $mapFilename &&
            $item->address == $validated['address'] &&
            $item->tel == $validated['tel'] 
            
        ) {
         
        }
        // อัปเดตข้อมูลในฐานข้อมูล
        $updated = DB::table('data_contact_models')->where('id', $id)->update([
            'map' => $mapFilename,
            'address' => $validated['address'],
            'tel' => $validated['tel'],
            'updated_at' => now(), 
        ]);

        // ตรวจสอบผลการอัปเดตข้อมูล
        return $updated
            ? redirect()->route('data_contact.index')->with('success', 'ข้อมูลอัปเดตสำเร็จ')
            : back()->with('error', 'ไม่สามารถอัปเดตข้อมูลได้');
    }

    public function destroy($id)
    {
        $item = DB::table('data_contact_models')->where('id', $id)->first();

        if (!$item) {
            return redirect()->route('data_contact.index')->with('error', 'ไม่พบข้อมูลที่ต้องการลบ');
        }
        DB::table('data_contact_models')->where('id', $id)->delete();

        return redirect()->route('data_contact.index')->with('success', 'ลบข้อมูลสำเร็จ');
    }
}
