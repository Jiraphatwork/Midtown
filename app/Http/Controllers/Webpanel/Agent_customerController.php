<?php

namespace App\Http\Controllers\Webpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Agent_customerController extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'agent_customer';
    protected $folder = 'agent_customer';

    public function index(Request $request)
    {
        // ดึงข้อมูลจาก table ordinary_customer_models
        $agent_customer = DB::table('agent_customer_models')->get();

        return view("$this->prefix.pages.$this->folder.index", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
            'agent_customer' => $agent_customer,
        ]);
    }

    public function add()
    {
        // ส่งตัวแปรไปยัง View
        return view('back-end.pages.agent_customer.add', [
            'prefix' => $this->prefix,
            'segment' => $this->segment,
            'folder' => $this->folder,
        ]);
    }

    public function insert(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'pic_id_card' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'id_card' => 'required|string|digits:13',
            'address' => 'required|string|max:255',
            'address2' => 'nullable|string|max:255',
            'address3' => 'nullable|string|max:255',
            'tel' => 'required|string|digits:10',
            'tel2' => 'nullable|string|max:10',
            'fax' => 'nullable|string|max:10',
            'tax_id' => 'nullable|string|digits:13',
        ], [
            'id_card.digits' => 'หมายเลขบัตรประชาชนต้องมีความยาว 13 หลักเท่านั้น',  
            'tel.digits' => 'หมายเลขเบอร์โทรศัพท์ต้องมีความยาว 10 หลักเท่านั้น', 
            'tax_id.digits' => 'หมายเลขผู้เสียภาษีต้องมีความยาว 13 หลักเท่านั้น', 
        ]);


        $businessCardFilename = null;
        if ($request->hasFile('business_card')) {
            $businessCardFilename = time() . '_' . $request->file('business_card')->getClientOriginalName();
            $request->file('business_card')->move(public_path('business_cards'), $businessCardFilename);
        }

        $picidcardFilename = null;
        if ($request->hasFile('pic_id_card')) {
            $picidcardFilename = time() . '_' . $request->file('pic_id_card')->getClientOriginalName();
            $request->file('pic_id_card')->move(public_path('pic_id_cards'), $picidcardFilename);
        }

        $taxcardFilename = null;
        if ($request->hasFile('tax_card')) {
            $taxcardFilename = time() . '_' . $request->file('tax_card')->getClientOriginalName();
            $request->file('tax_card')->move(public_path('tax_cards'), $taxcardFilename);
        }

        $slipcardFilename = null;
        if ($request->hasFile('slip_card')) {
            $slipcardFilename = time() . '_' . $request->file('slip_card')->getClientOriginalName();
            $request->file('slip_card')->move(public_path('slip_cards'), $slipcardFilename);
        }

        // บันทึกข้อมูลลงฐานข้อมูล
        DB::table('agent_customer_models')->insert([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'business_card' => $businessCardFilename,
            'tax_card' => $taxcardFilename,
            'pic_id_card' => $picidcardFilename,
            'id_card' => $validated['id_card'],
            'address' => $validated['address'],
            'address2' => $validated['address2'] ?? null, // ใช้ null หากไม่มีค่า
            'address3' => $validated['address3'] ?? null, // ใช้ null หากไม่มีค่า
            'tel' => $validated['tel'],
            'fax' => $validated['fax'] ?? null,           // ใช้ null หากไม่มีค่า
            'tel2' => $validated['tel2'] ?? null,         // ใช้ null หากไม่มีค่า
            'tax_id' => $validated['tax_id'] ?? null,     // ใช้ null หากไม่มีค่า
            'slip_card' => $slipcardFilename,
            'created_at' => now(), 
            'updated_at' => now(), 
        ]);

        return redirect()->route('agent_customer.index')->with('success', 'เพิ่มข้อมูลสำเร็จ');
    }

    public function edit($id)
    {
        // ดึงข้อมูลจากฐานข้อมูลตาม ID
        $item = DB::table('agent_customer_models')->find($id);

        if (!$item) {
            return redirect()->route('agent_customer.index')->with('error', 'ไม่พบข้อมูล');
        }

        // ส่งข้อมูลไปยังหน้า View พร้อมตัวแปรอื่นๆ
        return view('back-end.pages.agent_customer.edit', [
            'item' => $item,
            'prefix' => $this->prefix,  // ส่งตัวแปร $prefix
            'segment' => $this->segment,
            'folder' => $this->folder,
        ]);
    }

    public function update(Request $request, $id)
{
    // ดึงข้อมูลปัจจุบันของลูกค้าจากฐานข้อมูล
    $item = DB::table('agent_customer_models')->where('id', $id)->first();

    // ถ้าไม่พบข้อมูลให้ย้อนกลับไปหน้าหลัก
    if (!$item) {
        return redirect()->route('agent_customer.index')->with('error', 'ไม่พบข้อมูล');
    }
    
    // ตรวจสอบและ validate ข้อมูล
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'business_card' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'tax_card' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'pic_id_card' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'id_card' => 'required|string|digits:13',
        'address' => 'required|string|max:255',
        'address2' => 'nullable|string|max:255',
        'address3' => 'nullable|string|max:255',
        'tel' => 'required|string|digits:10',
        'fax' => 'nullable|string|max:10',
        'tel2' => 'nullable|string|max:10',
        'tax_id' => 'nullable|string|digits:13',
        'slip_card' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ], [
        'id_card.digits' => 'หมายเลขบัตรประชาชนต้องมีความยาว 13 หลักเท่านั้น',  
        'tel.digits' => 'หมายเลขเบอร์โทรศัพท์ต้องมีความยาว 10 หลักเท่านั้น', 
        'tax_id.digits' => 'หมายเลขผู้เสียภาษีต้องมีความยาว 13 หลักเท่านั้น', 
    ]);

    // จัดการไฟล์ (ถ้ามีการอัปโหลด)
    $businessCardFilename = $item->business_card;
    if ($request->hasFile('business_card')) {
        $businessCardFilename = time() . '_' . $request->file('business_card')->getClientOriginalName();
        $request->file('business_card')->move(public_path('business_cards'), $businessCardFilename);
        if (!empty($item->business_card) && file_exists(public_path('business_cards/' . $item->business_card))) {
            unlink(public_path('business_cards/' . $item->business_card));
        }
    }

    $taxCardFilename = $item->tax_card;
    if ($request->hasFile('tax_card')) {
        $taxCardFilename = time() . '_' . $request->file('tax_card')->getClientOriginalName();
        $request->file('tax_card')->move(public_path('tax_cards'), $taxCardFilename);
        if (!empty($item->tax_card) && file_exists(public_path('tax_cards/' . $item->tax_card))) {
            unlink(public_path('tax_cards/' . $item->tax_card));
        }
    }

    $picidCardFilename = $item->pic_id_card;
    if ($request->hasFile('pic_id_card')) {
        $picidCardFilename = time() . '_' . $request->file('pic_id_card')->getClientOriginalName();
        $request->file('pic_id_card')->move(public_path('pic_id_cards'), $picidCardFilename);
        if (!empty($item->pic_id_card) && file_exists(public_path('pic_id_cards/' . $item->pic_id_card))) {
            unlink(public_path('pic_id_cards/' . $item->pic_id_card));
        }
    }

    $slipCardFilename = $item->slip_card;
    if ($request->hasFile('slip_card')) {
        $slipCardFilename = time() . '_' . $request->file('slip_card')->getClientOriginalName();
        $request->file('slip_card')->move(public_path('slip_cards'), $slipCardFilename);
        if (!empty($item->slip_card) && file_exists(public_path('slip_cards/' . $item->slip_card))) {
            unlink(public_path('slip_cards/' . $item->slip_card));
        }
    }

   // ตรวจสอบว่าไม่มีการเปลี่ยนแปลงข้อมูล
if (
    $item->name == $validated['name'] &&
    $item->email == $validated['email'] &&
    $item->business_card == $businessCardFilename &&
    $item->tax_card == $taxCardFilename &&
    $item->pic_id_card == $picidCardFilename &&
    $item->id_card == $validated['id_card'] &&
    $item->address == $validated['address'] &&
    $item->address2 == ($validated['address2'] ?? null) &&
    $item->address3 == ($validated['address3'] ?? null) &&
    $item->tel == $validated['tel'] &&
    $item->tel2 == ($validated['tel2'] ?? null) &&
    $item->tax_id == ($validated['tax_id'] ?? null) &&
    $item->slip_card == $slipCardFilename
) {
    // หากไม่มีการเปลี่ยนแปลงข้อมูล, กลับไปยังหน้า index
    return redirect()->route('agent_customer.index')->with('success', 'ข้อมูลอัปเดตสำเร็จ');
}

    // อัปเดตข้อมูลในฐานข้อมูล
    $updated = DB::table('agent_customer_models')->where('id', $id)->update([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'business_card' => $businessCardFilename,
        'tax_card' => $taxCardFilename,
        'pic_id_card' => $picidCardFilename,
        'id_card' => $validated['id_card'],
        'address' => $validated['address'],
        'address2' => $validated['address2'] ?? null,
        'address3' => $validated['address3'] ?? null,
        'tel' => $validated['tel'],
        'fax' => $validated['fax'] ?? null,
        'tel2' => $validated['tel2'] ?? null,
        'tax_id' => $validated['tax_id'] ?? null,
        'slip_card' => $slipCardFilename,
        'updated_at' => now(), 
    ]);
    // ถ้าอัปเดตสำเร็จให้กลับไปที่หน้ารายการลูกค้า
    return $updated
        ? redirect()->route('agent_customer.index')->with('success', 'ข้อมูลอัปเดตสำเร็จ')
        : back()->with('error', 'ไม่สามารถอัปเดตข้อมูลได้');
}

public function destroy($id)
{
    // ค้นหาข้อมูลลูกค้าในฐานข้อมูล
    $item = DB::table('agent_customer_models')->where('id', $id)->first();

    if (!$item ) {
        return redirect()->route('agent_customer.index')->with('error', 'ไม่พบข้อมูลที่ต้องการลบ');
    }

    // ลบไฟล์จาก public/card_slips หากมีไฟล์
    if (!empty($item ->slip_card)) {
        $cardSlipFilePath = public_path('slip_cards/' . $item ->slip_card);
        if (is_file($cardSlipFilePath)) { // ตรวจสอบว่าเป็นไฟล์
            unlink($cardSlipFilePath); // ลบไฟล์จากระบบ
        }
    }

    // ลบไฟล์จาก public/bussiness_cards หากมีไฟล์
    if (!empty($item ->business_card)) {
        $businessCardFilePath = public_path('business_cards/' . $item ->business_card);
        if (is_file($businessCardFilePath)) { // ตรวจสอบว่าเป็นไฟล์
            unlink($businessCardFilePath); // ลบไฟล์จากระบบ
        }
    }

    if (!empty($item ->pic_id_card)) {
        $cardSlipFilePath = public_path('pic_id_cards/' . $item ->pic_id_card);
        if (is_file($cardSlipFilePath)) { // ตรวจสอบว่าเป็นไฟล์
            unlink($cardSlipFilePath); // ลบไฟล์จากระบบ
        }
    }

    if (!empty($item ->tax_card)) {
        $cardSlipFilePath = public_path('tax_cards/' . $item ->tax_card);
        if (is_file($cardSlipFilePath)) { // ตรวจสอบว่าเป็นไฟล์
            unlink($cardSlipFilePath); // ลบไฟล์จากระบบ
        }
    }
    // ลบข้อมูลจากฐานข้อมูล
    DB::table('agent_customer_models')->where('id', $id)->delete();

    return redirect()->route('agent_customer.index')->with('success', 'ลบข้อมูลสำเร็จ');
}


}