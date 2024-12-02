<?php

namespace App\Http\Controllers\Webpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class Organization_customerController extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'organization_customer';
    protected $folder = 'organization_customer';

    public function index(Request $request)
    {
        // ดึงข้อมูลจาก table ordinary_customer_models
        $organization_customer = DB::table('organization_customer_models')->get();

        return view("$this->prefix.pages.$this->folder.index", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
            'organization_customer' => $organization_customer,
        ]);
    }

    public function add()
    {
         // ตรวจสอบสิทธิ์
         if (Auth::guard('admin')->user()->role_name !== 'Admin') {
            return redirect()->route('organization_customer.index')->with('error', 'คุณไม่มีสิทธิ์ในการเพิ่มข้อมูล');
        }
        // ส่งตัวแปรไปยัง View
        return view('back-end.pages.organization_customer.add', [
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
            'address' => 'required|string',
            'address2' => 'nullable|string',
            'address3' => 'nullable|string',
            'tel' => 'required|string|digits:10',
            'fax' => 'nullable|string|digits:10',
            'tel2' => 'nullable|string|digits:10',
            'tax_id' => 'nullable|string|digits:13',
            'card_slip' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'tel.digits' => 'หมายเลขเบอร์โทรศัพท์ต้องมีความยาว 10 หลักเท่านั้น',
            'tax_id.digits' => 'หมายเลขผู้เสียภาษีต้องมีความยาว 13 หลักเท่านั้น',
            'tel2.digits' => 'หมายเลขตัวแทนติดต่อต้องมีความยาว 10 หลักเท่านั้น',
            'fax.digits' => 'หมายเลขแฟกซ์ต้องมีความยาว 10 หลักเท่านั้น',
        ]);


        $businessCardFilename = null;
        if ($request->hasFile('business_card')) {
            $businessCardFilename = time() . '_' . $request->file('business_card')->getClientOriginalName();
            $request->file('business_card')->move(public_path('business_cards'), $businessCardFilename);
        }
        $cardSlipFilename = null;
        if ($request->hasFile('card_slip')) {
            $cardSlipFilename = time() . '_' . $request->file('card_slip')->getClientOriginalName();
            $request->file('card_slip')->move(public_path('card_slips'), $cardSlipFilename);
        }

        // บันทึกข้อมูลลงฐานข้อมูล
        DB::table('organization_customer_models')->insert([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'business_card' => $businessCardFilename,
            'address' => $validated['address'],
            'address2' => $validated['address2'] ?? null,
            'address3' => $validated['address3'] ?? null,
            'tel' => $validated['tel'],
            'fax' => $validated['fax'] ?? null,
            'tel2' => $validated['tel2'] ?? null,
            'tax_id' => $validated['tax_id'] ?? null,
            'card_slip' => $cardSlipFilename ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('organization_customer.index')->with('success', 'เพิ่มข้อมูลสำเร็จ');
    }

    public function edit($id)
    {
        // ตรวจสอบสิทธิ์
        if (Auth::guard('admin')->user()->role_name !== 'Admin') {
            return redirect()->route('organization_customer.index')->with('error', 'คุณไม่มีสิทธิ์ในการแก้ไขข้อมูล');
        }
        // ดึงข้อมูลจากฐานข้อมูลตาม ID
        $item = DB::table('organization_customer_models')->find($id);

        if (!$item) {
            return redirect()->route('organization_customer.index')->with('error', 'ไม่พบข้อมูล');
        }

        // ส่งข้อมูลไปยังหน้า View พร้อมตัวแปรอื่นๆ
        return view('back-end.pages.organization_customer.edit', [
            'item' => $item,
            'prefix' => $this->prefix,  // ส่งตัวแปร $prefix
            'segment' => $this->segment,
            'folder' => $this->folder,
        ]);
    }


    public function update(Request $request, $id)
    {
        // ดึงข้อมูลปัจจุบันของลูกค้าจากฐานข้อมูล
        $item = DB::table('organization_customer_models')->where('id', $id)->first();

        // ถ้าไม่พบข้อมูลให้ย้อนกลับไปหน้าหลัก
        if (!$item) {
            return redirect()->route('organization_customer.index')->with('error', 'ไม่พบข้อมูล');
        }

        // ตรวจสอบและ validate ข้อมูล
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'business_card' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'address' => 'required|string',
            'address2' => 'nullable|string',
            'address3' => 'nullable|string',
            'tel' => 'nullable|string|digits:10',
            'fax' => 'nullable|string|max:10',
            'tel2' => 'nullable|string|max:10',
            'tax_id' => 'nullable|string|digits:13',
            'card_slip' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'tel.digits' => 'หมายเลขเบอร์โทรศัพท์ต้องมีความยาว 10 หลักเท่านั้น',
            'tax_id.digits' => 'หมายเลขผู้เสียภาษีต้องมีความยาว 13 หลักเท่านั้น',
        ]);

        // เริ่มต้นการจัดการไฟล์ (ใช้ไฟล์เดิมถ้าไม่มีการอัปโหลดใหม่)
        $businessCardFilename = $item->business_card; // ใช้ไฟล์เดิมเป็นค่าเริ่มต้น
        if ($request->hasFile('business_card')) {
            // สร้างชื่อไฟล์ใหม่เพื่อไม่ให้ซ้ำกัน
            $businessCardFilename = time() . '_' . $request->file('business_card')->getClientOriginalName();

            // บันทึกไฟล์ไปยังโฟลเดอร์ public/business_cards
            $request->file('business_card')->move(public_path('business_cards'), $businessCardFilename);

            // ลบไฟล์เก่าถ้ามี
            if (!empty($item->business_card) && file_exists(public_path('business_cards/' . $item->business_card))) {
                unlink(public_path('business_cards/' . $item->business_card));
            }
        }

        // จัดการไฟล์ใบหัก ณ ที่จ่าย (card_slip)
        $cardSlipFilename = $item->card_slip; // ใช้ไฟล์เดิมเป็นค่าเริ่มต้น
        if ($request->hasFile('card_slip')) {
            // สร้างชื่อไฟล์ใหม่เพื่อไม่ให้ซ้ำกัน
            $cardSlipFilename = time() . '_' . $request->file('card_slip')->getClientOriginalName();

            // บันทึกไฟล์ไปยังโฟลเดอร์ public/card_slips
            $request->file('card_slip')->move(public_path('card_slips'), $cardSlipFilename);

            // ลบไฟล์เก่าถ้ามี
            if (!empty($item->card_slip) && file_exists(public_path('card_slips/' . $item->card_slip))) {
                unlink(public_path('card_slips/' . $item->card_slip));
            }
        }

        // ตรวจสอบว่าไม่มีการเปลี่ยนแปลงข้อมูล
        if (
            $item->name == $validated['name'] &&
            $item->email == $validated['email'] &&
            $item->business_card == $businessCardFilename &&
            $item->address == $validated['address'] &&
            $item->address2 == $validated['address2'] &&
            $item->address3 == $validated['address3'] &&
            $item->tel == $validated['tel'] &&
            $item->fax == $validated['fax'] &&
            $item->tel2 == $validated['tel2'] &&
            $item->tax_id == $validated['tax_id'] &&
            $item->card_slip == $cardSlipFilename
        ) {
            // หากไม่มีการเปลี่ยนแปลงข้อมูล, กลับไปยังหน้า index
            return redirect()->route('organization_customer.index')->with('success', 'ข้อมูลอัปเดตสำเร็จ');
        }

        // อัปเดตข้อมูลในฐานข้อมูล
        $updated = DB::table('organization_customer_models')->where('id', $id)->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'business_card' => $businessCardFilename,
            'address' => $validated['address'],
            'address2' => $validated['address2'] ?? null,
            'address3' => $validated['address3'] ?? null,
            'tel' => $validated['tel'],
            'fax' => $validated['fax'] ?? null,
            'tel2' => $validated['tel2'] ?? null,
            'tax_id' => $validated['tax_id'] ?? null,
            'card_slip' => $cardSlipFilename,
            'updated_at' => now(),
        ]);

        // ถ้าอัปเดตสำเร็จให้กลับไปที่หน้ารายการลูกค้า
        return $updated
            ? redirect()->route('organization_customer.index')->with('success', 'ข้อมูลอัปเดตสำเร็จ')
            : back()->with('error', 'ไม่สามารถอัปเดตข้อมูลได้');
    }


    public function destroy($id)
{
    // ตรวจสอบสิทธิ์
    if (Auth::guard('admin')->user()->role_name !== 'Admin') {
        return redirect()->route('organization_customer.index');
    }

    // ค้นหาข้อมูลลูกค้าในฐานข้อมูล
    $history = DB::table('organization_customer_models')->where('id', $id)->first();

    if (!$history) {
        return redirect()->route('organization_customer.index')->with('error', 'ไม่พบข้อมูลที่ต้องการลบ');
    }

    // ลบไฟล์จาก public/card_slips หากมีไฟล์
    if (!empty($history->card_slip)) {
        $cardSlipFilePath = public_path('card_slips/' . $history->card_slip);
        if (is_file($cardSlipFilePath)) { // ตรวจสอบว่าเป็นไฟล์
            unlink($cardSlipFilePath); // ลบไฟล์จากระบบ
        }
    }

    // ลบไฟล์จาก public/business_cards หากมีไฟล์
    if (!empty($history->business_card)) {
        $businessCardFilePath = public_path('business_cards/' . $history->business_card);
        if (is_file($businessCardFilePath)) { // ตรวจสอบว่าเป็นไฟล์
            unlink($businessCardFilePath); // ลบไฟล์จากระบบ
        }
    }

    // ลบข้อมูลจากฐานข้อมูล
    DB::table('organization_customer_models')->where('id', $id)->delete();

    return redirect()->route('organization_customer.index');
}


}

