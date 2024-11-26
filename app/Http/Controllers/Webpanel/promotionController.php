<?php

namespace App\Http\Controllers\Webpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class promotionController extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'promotion';
    protected $folder = 'promotion';

    public function index(Request $request)
    {
        $promotion_models = DB::table('promotion_models')->get();

        return view("$this->prefix.pages.$this->folder.index", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
            'promotion_models' => $promotion_models,
        ]);
    }

    public function add()
    {
        // ส่งตัวแปรไปยัง View
        return view('back-end.pages.promotion.add', [
            'prefix' => $this->prefix,
            'segment' => $this->segment,
            'folder' => $this->folder,
        ]);
    }

    public function insert(Request $request)
    {
        $validated = $request->validate([
            'name_promotion' => 'required|string|max:255',
            'pic_promotion' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'detail' => 'required|string',
            'first_date' => 'required|date',
            'last_date' => 'required|date',
        ]);
        $picpromotionFilename = null;
        if ($request->hasFile('pic_promotion')) {
            $picpromotionFilename = time() . '_' . $request->file('pic_promotion')->getClientOriginalName();
            $request->file('pic_promotion')->move(public_path('pic_promotions'), $picpromotionFilename);
        }
        // บันทึกข้อมูลลงฐานข้อมูล
        DB::table('promotion_models')->insert([
            'name_promotion' => $validated['name_promotion'],
            'pic_promotion' => $picpromotionFilename,
            'detail' => $validated['detail'],
            'first_date' => $validated['first_date'],
            'last_date' => $validated['last_date'],
            'created_at' => now(), 
            'updated_at' => now(), 
        ]);

        return redirect()->route('promotion.index')->with('success', 'เพิ่มข้อมูลสำเร็จ');
    }

    public function edit($id)
    {
        // ดึงข้อมูลจากฐานข้อมูลตาม ID
        $item = DB::table('promotion_models')->find($id);

        if (!$item) {
            return redirect()->route('promotion.index')->with('error', 'ไม่พบข้อมูล');
        }
        // ส่งข้อมูลไปยังหน้า View พร้อมตัวแปรอื่นๆ
        return view('back-end.pages.promotion.edit', [
            'item' => $item,
            'prefix' => $this->prefix,  // ส่งตัวแปร $prefix
            'segment' => $this->segment,
            'folder' => $this->folder,
        ]);
    }

    public function update(Request $request, $id)
    {
        // ดึงข้อมูลปัจจุบันของลูกค้าจากฐานข้อมูล
        $item = DB::table('promotion_models')->where('id', $id)->first();

        // ถ้าไม่พบข้อมูลให้ย้อนกลับไปหน้าหลัก
        if (!$item) {
            return redirect()->route('promotion.index')->with('error', 'ไม่พบข้อมูล');
        }
        // ตรวจสอบและ validate ข้อมูล
        $validated = $request->validate([
            'name_promotion' => 'required|string|max:255',
            'pic_promotion' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'detail' => 'required|string',
            'first_date' => 'required|date',
            'last_date' => 'required|date',
        ]);

        // จัดการรูปภาพ (ถ้ามีการอัปโหลด) -pic_promotion
        $picpromotionFilename = $item->pic_promotion; // ใช้ไฟล์เดิมเป็นค่าเริ่มต้น
        if ($request->hasFile('pic_promotion')) {
            // สร้างชื่อไฟล์ใหม่เพื่อไม่ให้ซ้ำกัน
            $picpromotionFilename = time() . '_' . $request->file('pic_promotion')->getClientOriginalName();

            // บันทึกไฟล์ไปยังโฟลเดอร์ public/pic_promotions
            $request->file('pic_promotion')->move(public_path('pic_promotions'), $picpromotionFilename);

            // ลบไฟล์เก่าถ้ามี
            if (!empty($item->pic_promotion) && file_exists(public_path('pic_promotions/' . $item->pic_promotion))) {
                unlink(public_path('pic_promotions/' . $item->pic_promotion));
            }
        }

        if (
            $item->name_promotion == $validated['name_promotion'] &&
            $item->pic_promotion == $picpromotionFilename &&
            $item->detail == $validated['detail'] &&
            $item->first_date == $validated['first_date'] &&
            $item->last_date == $validated['last_date']
        ) {
            // หากไม่มีการเปลี่ยนแปลงข้อมูล, กลับไปยังหน้า index
            return redirect()->route('promotion.index')->with('success', 'ข้อมูลอัปเดตสำเร็จ');
        }

        // อัปเดตข้อมูลในฐานข้อมูล
        $updated = DB::table('promotion_models')->where('id', $id)->update([
            'name_promotion' => $validated['name_promotion'],
            'pic_promotion' => $picpromotionFilename,
            'detail' => $validated['detail'],
            'first_date' => $validated['first_date'],
            'last_date' => $validated['last_date'],
            'updated_at' => now(), 
        ]);

        return $updated
            ? redirect()->route('promotion.index')->with('success', 'ข้อมูลอัปเดตสำเร็จ')
            : back()->with('error', 'ไม่สามารถอัปเดตข้อมูลได้');

    }

    public function destroy($id)
    {
        // ค้นหาข้อมูลลูกค้าในฐานข้อมูล
        $item = DB::table('promotion_models')->where('id', $id)->first();
    
        if (!$item ) {
            return redirect()->route('promotion.index')->with('error', 'ไม่พบข้อมูลที่ต้องการลบ');
        }
    
        // ลบไฟล์จาก public
        if (!empty($item ->pic_promotion)) {
            $cardSlipFilePath = public_path('pic_promotions/' . $item ->pic_promotion);
            if (is_file($cardSlipFilePath)) { // ตรวจสอบว่าเป็นไฟล์
                unlink($cardSlipFilePath); // ลบไฟล์จากระบบ
            }
        }
        // ลบข้อมูลจากฐานข้อมูล
        DB::table('promotion_models')->where('id', $id)->delete();
    
        return redirect()->route('promotion.index')->with('success', 'ลบข้อมูลสำเร็จ');
    }
}