<?php

namespace App\Http\Controllers\Webpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Data_equipmentController extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'data_equipment';
    protected $folder = 'data_equipment';

    public function index(Request $request)
    {
        $equipment_models = DB::table('equipment_models')->get();

        return view("$this->prefix.pages.$this->folder.index", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
            'equipment_models' => $equipment_models,
        ]);
    }

    public function add()
    {
        // ส่งตัวแปรไปยัง View
        return view('back-end.pages.data_equipment.add', [
            'prefix' => $this->prefix,
            'segment' => $this->segment,
            'folder' => $this->folder,
        ]);
    }

    public function insert(Request $request)
    {
        $validated = $request->validate([
            'name_equipment' => 'required|string|max:255',
            'pic_equipment' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'price' => 'required|integer|max:10000',
            'quantity' => 'required|integer|max:10000',
           
        ]);
        $picequipmentFilename = null;
        if ($request->hasFile('pic_equipment')) {
            $picequipmentFilename = time() . '_' . $request->file('pic_equipment')->getClientOriginalName();
            $request->file('pic_equipment')->move(public_path('pic_equipments'), $picequipmentFilename);
        }

        // บันทึกข้อมูลลงฐานข้อมูล
        DB::table('equipment_models')->insert([
            'name_equipment' => $validated['name_equipment'],
            'pic_equipment' => $picequipmentFilename, 
            'price' => $validated['price'],
            'quantity' => $validated['quantity'], 
        ]);

        return redirect()->route('data_equipment.index')->with('success', 'เพิ่มข้อมูลสำเร็จ');
}

public function edit($id)
    {
        // ดึงข้อมูลจากฐานข้อมูลตาม ID
        $item = DB::table('equipment_models')->find($id);

        if (!$item) {
            return redirect()->route('data_equipment.index')->with('error', 'ไม่พบข้อมูล');
        }

        // ส่งข้อมูลไปยังหน้า View พร้อมตัวแปรอื่นๆ
        return view('back-end.pages.data_equipment.edit', [
            'item' => $item,
            'prefix' => $this->prefix,  // ส่งตัวแปร $prefix
            'segment' => $this->segment,
            'folder' => $this->folder,
        ]);
    }

    public function update(Request $request, $id)
    {
        // ดึงข้อมูลปัจจุบันของลูกค้าจากฐานข้อมูล
        $item = DB::table('equipment_models')->where('id', $id)->first();
    
        // ถ้าไม่พบข้อมูลให้ย้อนกลับไปหน้าหลัก
        if (!$item) {
            return redirect()->route('data_equipment.index')->with('error', 'ไม่พบข้อมูล');
        }
        // ตรวจสอบและ validate ข้อมูล
        $validated = $request->validate([
            'name_equipment' => 'required|string|max:255',
            'pic_equipment' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'price' => 'required|integer|max:10000',
            'quantity' => 'required|integer|max:10000',
        ]);
           // จัดการรูปภาพ (ถ้ามีการอัปโหลด) - pic_equipment
           $picequipmentFilename = $item->pic_equipment; // ใช้ไฟล์เดิมเป็นค่าเริ่มต้น
           if ($request->hasFile('pic_equipment')) {
               // สร้างชื่อไฟล์ใหม่เพื่อไม่ให้ซ้ำกัน
               $picequipmentFilename = time() . '_' . $request->file('pic_equipment')->getClientOriginalName();
               
               // บันทึกไฟล์ไปยังโฟลเดอร์ public/pic_equipments
               $request->file('pic_equipment')->move(public_path('pic_equipments'), $picequipmentFilename);
       
               // ลบไฟล์เก่าถ้ามี
               if (!empty($item->pic_equipment) && file_exists(public_path('pic_equipments/' . $item->pic_equipment))) {
                   unlink(public_path('pic_equipments/' . $item->pic_equipment));
               }
           }

                  // อัปเดตข้อมูลในฐานข้อมูล
        $updated = DB::table('equipment_models')->where('id', $id)->update([
            'name_equipment' => $validated['name_equipment'],
            'pic_equipment' => $picequipmentFilename, 
            'price' => $validated['price'],
            'quantity' => $validated['quantity'], 
        ]);

        // ถ้าอัปเดตสำเร็จให้กลับไปที่หน้ารายการลูกค้า
        return $updated
            ? redirect()->route('data_equipment.index')->with('success', 'ข้อมูลอัปเดตสำเร็จ')
            : back()->with('error', 'ไม่สามารถอัปเดตข้อมูลได้');

            }

            public function destroy($id)
            {
                $item = DB::table('equipment_models')->where('id', $id)->first();
        
                if (!$item) {
                    return redirect()->route('data_equipment.index')->with('error', 'ไม่พบข้อมูลที่ต้องการลบ');
                }
                DB::table('equipment_models')->where('id', $id)->delete();
        
                return redirect()->route('data_equipment.index')->with('success', 'ลบข้อมูลสำเร็จ');
            }
}
