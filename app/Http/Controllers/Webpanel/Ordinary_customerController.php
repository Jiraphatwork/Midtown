<?php

namespace App\Http\Controllers\Webpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Ordinary_customerController extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'ordinary_customer';
    protected $folder = 'ordinary_customer';

    public function index(Request $request)
    {
        // ดึงข้อมูลจาก table ordinary_customer_models
        $ordinary_customer = DB::table('ordinary_customer_models')->get();

        return view("$this->prefix.pages.$this->folder.index", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
            'ordinary_customer' => $ordinary_customer, // ส่งข้อมูลไปยัง view
        ]);
    }

    public function add()
    {
        // ส่งตัวแปรไปยัง View
        return view('back-end.pages.ordinary_customer.add', [
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
            'email' => 'required|email|max:255',
            'pic_id_card' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'id_card' => 'required|string|max:13',
            'address' => 'required|string',
            'tel' => 'required|string|max:10',
            'tel2' => 'required|string|max:10',
            'tax_id' => 'required|string|max:13',
        ]);

        // จัดการรูปภาพ (ถ้ามีการอัปโหลด)
        $filename = null;
        if ($request->hasFile('pic_id_card')) {
            // สร้างชื่อไฟล์ใหม่เพื่อไม่ให้ซ้ำกัน
            $filename = time() . '_' . $request->file('pic_id_card')->getClientOriginalName();
            // บันทึกไฟล์ไปยังโฟลเดอร์ public/id_cards
            $request->file('pic_id_card')->move(public_path('id_cards'), $filename);
        }

        // บันทึกข้อมูลลงฐานข้อมูล
        DB::table('ordinary_customer_models')->insert([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'pic_id_card' => $filename, // บันทึกชื่อไฟล์ลงในฐานข้อมูล
            'id_card' => $validated['id_card'],
            'address' => $validated['address'],
            'tel' => $validated['tel'],
            'tel2' => $validated['tel2'],
            'tax_id' => $validated['tax_id'],
        ]);

        return redirect()->route('ordinary_customer.index')->with('success', 'เพิ่มข้อมูลสำเร็จ');
    }


    public function edit($id)
    {
        // ดึงข้อมูลจากฐานข้อมูลตาม ID
        $item = DB::table('ordinary_customer_models')->find($id);

        if (!$item) {
            return redirect()->route('ordinary_customer.index')->with('error', 'ไม่พบข้อมูล');
        }

        // ส่งข้อมูลไปยังหน้า View พร้อมตัวแปรอื่นๆ
        return view('back-end.pages.ordinary_customer.edit', [
            'item' => $item,
            'prefix' => $this->prefix,  // ส่งตัวแปร $prefix
            'segment' => $this->segment,
            'folder' => $this->folder,
        ]);
    }

    public function update(Request $request, $id)
{
    // ดึงข้อมูลจากฐานข้อมูล
    $item = DB::table('ordinary_customer_models')->where('id', $id)->first();

    if (!$item) {
        return redirect()->route('ordinary_customer.index')->with('error', 'ไม่พบข้อมูล');
    }

    // Validate ข้อมูลที่ได้รับจากฟอร์ม
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'pic_id_card' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'id_card' => 'required|string|max:13',
        'address' => 'required|string',
        'tel' => 'required|string|max:10',
        'tel2' => 'required|string|max:10',
        'tax_id' => 'required|string|max:13',
    ]);

    if ($request->hasFile('pic_id_card')) {
        $file = $request->file('pic_id_card');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/id_cards'), $filename);
    
        // ลบไฟล์เก่า
        if (!empty($item->pic_id_card) && file_exists(public_path('uploads/id_cards/' . $item->pic_id_card))) {
            unlink(public_path('uploads/id_cards/' . $item->pic_id_card));
        }
    } else {
        $filename = $item->pic_id_card; // ใช้ไฟล์เดิม
    }
    

    // อัปเดตข้อมูลในฐานข้อมูล
    $updated = DB::table('ordinary_customer_models')->where('id', $id)->update([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'pic_id_card' => $filename,
        'id_card' => $validated['id_card'],
        'address' => $validated['address'],
        'tel' => $validated['tel'],
        'tel2' => $validated['tel2'],
        'tax_id' => $validated['tax_id'],
    ]);

    return $updated
        ? redirect()->route('ordinary_customer.index')->with('success', 'ข้อมูลอัปเดตสำเร็จ')
        : back()->with('error', 'ไม่สามารถอัปเดตข้อมูลได้');
}


}
