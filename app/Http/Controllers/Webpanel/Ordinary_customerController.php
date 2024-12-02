<?php

namespace App\Http\Controllers\Webpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

        // ตรวจสอบสิทธิ์
        if (Auth::guard('admin')->user()->role_name !== 'Admin') {
            return redirect()->route('ordinary_customer.index')->with('error', 'คุณไม่มีสิทธิ์ในการเพิ่มข้อมูล');
        }
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
            'id_card' => 'required|string|digits:13',
            'address' => 'required|string',
            'tel' => 'required|string|digits:10',
            'tel2' => 'nullable|string|digits:10',
            'tax_id' => 'nullable|string|digits:13',
        ], [
            'id_card.digits' => 'หมายเลขบัตรประชาชนต้องมีความยาว 13 หลักเท่านั้น',
            'tel.digits' => 'หมายเลขเบอร์โทรศัพท์ต้องมีความยาว 10 หลักเท่านั้น',
            'tax_id.digits' => 'หมายเลขผู้เสียภาษีต้องมีความยาว 13 หลักเท่านั้น',
            'tel2.digits' => 'หมายเลขตัวแทนติดต่อต้องมีความยาว 10 หลักเท่านั้น',
        ]);

        // จัดการรูปภาพ (ถ้ามีการอัปโหลด)
        $filename = null;
        if ($request->hasFile('pic_id_card')) {
            // สร้างชื่อไฟล์ใหม่เพื่อไม่ให้ซ้ำกัน
            $filename = time() . '_' . $request->file('pic_id_card')->getClientOriginalName();
            // บันทึกไฟล์ไปยังโฟลเดอร์ public/id_cards
            $request->file('pic_id_card')->move(public_path('pic_id_cards'), $filename);
        }

        // บันทึกข้อมูลลงฐานข้อมูล
        DB::table('ordinary_customer_models')->insert([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'pic_id_card' => $filename,
            'id_card' => $validated['id_card'],
            'address' => $validated['address'],
            'tel' => $validated['tel'],
            'tel2' => $validated['tel2'] ?? null,
            'tax_id' => $validated['tax_id'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('ordinary_customer.index')->with('success', 'เพิ่มข้อมูลสำเร็จ');
    }


    public function edit($id)
    {

        // ตรวจสอบสิทธิ์
        if (Auth::guard('admin')->user()->role_name !== 'Admin') {
            return redirect()->route('ordinary_customer.index')->with('error', 'คุณไม่มีสิทธิ์ในการแก้ไขข้อมูล');
        }
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

        // ตรวจสอบสิทธิ์
        if (Auth::guard('admin')->user()->role_name !== 'Admin') {
            return redirect()->route('ordinary_customer.index')->with('error', 'คุณไม่มีสิทธิ์ในการเพิ่มข้อมูล');
        }
        // ดึงข้อมูลลูกค้าเดิมจากฐานข้อมูล
        $item = DB::table('ordinary_customer_models')->where('id', $id)->first();

        // ถ้าไม่พบข้อมูลให้ย้อนกลับไปหน้าหลัก
        if (!$item) {
            return redirect()->route('ordinary_customer.index')->with('error', 'ไม่พบข้อมูล');
        }

        // ตรวจสอบและ validate ข้อมูล
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'pic_id_card' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'id_card' => 'required|string|digits:13',
            'address' => 'required|string',
            'tel' => 'required|string|digits:10',
            'tel2' => 'nullable|string|digits:10',
            'tax_id' => 'nullable|string|digits:13',
        ], [
            'id_card.digits' => 'หมายเลขบัตรประชาชนต้องมีความยาว 13 หลักเท่านั้น',
            'tel.digits' => 'หมายเลขเบอร์โทรศัพท์ต้องมีความยาว 10 หลักเท่านั้น',
            'tax_id.digits' => 'หมายเลขผู้เสียภาษีต้องมีความยาว 13 หลักเท่านั้น',
            'tel2.digits' => 'หมายเลขตัวแทนติดต่อต้องมีความยาว 10 หลักเท่านั้น',

        ]);

        // เริ่มต้นการจัดการรูปภาพ (ใช้ไฟล์เดิมถ้าไม่มีการอัปโหลดใหม่)
        $filename = $item->pic_id_card; // ใช้ไฟล์เดิมเป็นค่าเริ่มต้น
        if ($request->hasFile('pic_id_card')) {
            // สร้างชื่อไฟล์ใหม่เพื่อไม่ให้ซ้ำกัน
            $filename = time() . '_' . $request->file('pic_id_card')->getClientOriginalName();

            // บันทึกไฟล์ไปยังโฟลเดอร์ public/id_cards
            $request->file('pic_id_card')->move(public_path('pic_id_card'), $filename);

            // ลบไฟล์เก่าถ้ามี
            if (!empty($item->pic_id_card) && file_exists(public_path('pic_id_card/' . $item->pic_id_card))) {
                unlink(public_path('pic_id_card/' . $item->pic_id_card));
            }
        }

        // ตรวจสอบว่าไม่มีการเปลี่ยนแปลงข้อมูล
        if (
            $item->name == $validated['name'] &&
            $item->email == $validated['email'] &&
            $item->pic_id_card == $filename &&
            $item->id_card == $validated['id_card'] &&
            $item->address == $validated['address'] &&
            $item->tel == $validated['tel'] &&
            $item->tel2 == $validated['tel2'] &&
            $item->tax_id == $validated['tax_id']
        ) {
            // หากไม่มีการเปลี่ยนแปลงข้อมูล, กลับไปยังหน้า index
            return redirect()->route('ordinary_customer.index')->with('success', 'ข้อมูลอัปเดตสำเร็จ');
        }

        // อัปเดตข้อมูลในฐานข้อมูล
        $updated = DB::table('ordinary_customer_models')->where('id', $id)->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'pic_id_card' => $filename,
            'id_card' => $validated['id_card'],
            'address' => $validated['address'],
            'tel' => $validated['tel'],
            'tel2' => $validated['tel2'] ?? null,
            'tax_id' => $validated['tax_id'] ?? null,
            'updated_at' => now(),
        ]);

        // ตรวจสอบผลการอัปเดตข้อมูล
        return $updated
            ? redirect()->route('ordinary_customer.index')->with('success', 'ข้อมูลอัปเดตสำเร็จ')
            : back()->with('error', 'ไม่สามารถอัปเดตข้อมูลได้');
    }



    public function destroy($id)
    {
        // ตรวจสอบสิทธิ์
        if (Auth::guard('admin')->user()->role_name !== 'Admin') {
            return redirect()->route('ordinary_customer.index');
        }

        // ดึงข้อมูลที่ต้องการลบ
        $history = DB::table('ordinary_customer_models')->where('id', $id)->first();

        if (!$history) {
            return redirect()->route('ordinary_customer.index')->with('error', 'ไม่พบข้อมูลที่ต้องการลบ');
        }

        // ลบข้อมูล
        DB::table('ordinary_customer_models')->where('id', $id)->delete();

        return redirect()->route('ordinary_customer.index');
    }
}
