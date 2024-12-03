<?php

namespace App\Http\Controllers\Webpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class Reserve_history_controller extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'reserve_history';
    protected $folder = 'reserve_history';


    public function index(Request $request)
    {
        // ดึงข้อมูลจาก table reserve_histories
        $reserveHistories = DB::table('reserve_histories')->get();

        return view("$this->prefix.pages.$this->folder.index", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
            'reserveHistories' => $reserveHistories, // ส่งข้อมูลไปยัง view
        ]);
    }
    public function add()
    {
        // ตรวจสอบสิทธิ์
        if (Auth::guard('admin')->user()->role_name !== 'Admin') {
            return redirect()->route('reserve_history.index')->with('error', 'คุณไม่มีสิทธิ์ในการเพิ่มข้อมูล');
        }

        // ดึงข้อมูลประเภทพื้นที่ (type) จาก data_area_models
        $areaTypes = DB::table('data_area_models')->select('type')->distinct()->get();

        // ส่งข้อมูลไปยัง View
        return view('back-end.pages.reserve_history.add', [
            'prefix' => $this->prefix,
            'segment' => $this->segment,
            'folder' => $this->folder,
            'areaTypes' => $areaTypes, // ส่งข้อมูลประเภทพื้นที่ไปที่ view
        ]);
    }
    public function insert(Request $request)
    {
        // Validate ข้อมูลจากฟอร์ม
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'now_date' => 'required|date',
            'first_date' => 'required|date',
            'last_date' => 'required|date',
            'status' => 'required|in:จ่ายแล้ว,ยังไม่จ่าย',
            'product_type' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'type' => 'required|string|max:255', // ตรวจสอบ type
            'pic_area' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048' // เพิ่มการ validate สำหรับรูปภาพ
        ]);
    
        // ค่าจากฟอร์ม
        $area = $validated['area']; // รับค่า area จากฟอร์ม
    
        // ดึงราคา (price) จาก data_area_models โดยใช้ area ที่เลือก
        $areaData = DB::table('data_area_models')->where('area', $area)->first();
    
        if (!$areaData) {
            return redirect()->back()->with('error', 'ไม่พบข้อมูลพื้นที่ที่เลือก');
        }
    
        $price = $areaData->price; // รับราคา (price) จากข้อมูลของพื้นที่ที่เลือก
    
        // ค่าจากฟอร์ม
        $type = $validated['type'];
    

     if ($areaData) {
        // คัดลอกไฟล์รูปภาพ
        $picareaFilename = null;
        if ($areaData->pic_area) {
            $picareaFilename = time() . '_' . $areaData->pic_area;
            $sourcePath = public_path('pic_areas/' . $areaData->pic_area);
            $destinationPath = public_path('pic_areas_reserve/' . $picareaFilename);
            if (file_exists($sourcePath)) {
                copy($sourcePath, $destinationPath);
            }
        }
        // บันทึกข้อมูลลงในฐานข้อมูล
        DB::table('reserve_histories')->insert([
            'name' => $validated['name'],
            'now_date' => $validated['now_date'],
            'first_date' => $validated['first_date'],
            'last_date' => $validated['last_date'],
            'status' => $validated['status'],
            'product_type' => $validated['product_type'],
            'area' => $validated['area'],
            'type' => $type,  // บันทึก type ลงในฐานข้อมูล
            'price' => $price,  // บันทึกราคา (price) ลงในฐานข้อมูล
            'pic_area' => $picareaFilename,  // บันทึกชื่อไฟล์รูปภาพลงในฐานข้อมูล
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        return redirect()->route('reserve_history.index')->with('success', 'เพิ่มข้อมูลสำเร็จ');
    }
    
}
    
    public function getAreaData(Request $request)
    {
        $type = $request->input('type');

        // ดึงข้อมูลจาก data_area_models ตาม type ที่เลือก
        $areaData = DB::table('data_area_models')->where('type', $type)->first();

        if ($areaData) {
            // ส่งข้อมูลกลับในรูปแบบ JSON
            return response()->json([
                'areas' => DB::table('data_area_models')->where('type', $type)->get(),
                // ใช้ asset() สำหรับเส้นทางรูปภาพ
                'pic_area' => asset('pic_areas/' . $areaData->pic_area), // แก้ไขให้ถูกต้อง
                'price' => $areaData->price
            ]);
        }

        // ถ้าไม่พบข้อมูล
        return response()->json([], 404);
    }

    public function edit($id)
    {
        // ตรวจสอบสิทธิ์
        if (Auth::guard('admin')->user()->role_name !== 'Admin') {
            return redirect()->route('reserve_history.index')->with('error', 'คุณไม่มีสิทธิ์ในการแก้ไขข้อมูล');
        }

        // ดึงข้อมูลจากฐานข้อมูลตาม ID
        $history = DB::table('reserve_histories')->find($id);

        if (!$history) {
            return redirect()->route('reserve_history.index')->with('error', 'ไม่พบข้อมูล');
        }

        // ส่งข้อมูลไปยังหน้า View พร้อมตัวแปรอื่นๆ
        return view('back-end.pages.reserve_history.edit', [
            'history' => $history,
            'prefix' => $this->prefix,
            'segment' => $this->segment,
            'folder' => $this->folder,
        ]);
    }

    public function update(Request $request, $id)
    {
        // ดึงข้อมูลเดิมจากฐานข้อมูล
        $existingData = DB::table('reserve_histories')->where('id', $id)->first();

        // Validate ข้อมูลที่ได้รับจากฟอร์ม
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'now_date' => 'required|date',
            'first_date' => 'required|date',
            'last_date' => 'required|date',
            'status' => 'required|in:จ่ายแล้ว,ยังไม่จ่าย',
            'product_type' => 'required|string|max:255',
            'area' => 'required|string|max:255',
        ]);

        // ตรวจสอบว่าไม่มีการเปลี่ยนแปลง
        if (
            $existingData->name == $validated['name'] &&
            $existingData->now_date == $validated['now_date'] &&
            $existingData->first_date == $validated['first_date'] &&
            $existingData->last_date == $validated['last_date'] &&
            $existingData->status == $validated['status'] &&
            $existingData->product_type == $validated['product_type'] &&
            $existingData->area == $validated['area']
        ) {
            return redirect()->route('reserve_history.index')->with('success', 'ข้อมูลอัปเดตสำเร็จ');
        }

        // อัปเดตข้อมูลในฐานข้อมูล
        $updated = DB::table('reserve_histories')->where('id', $id)->update([
            'name' => $validated['name'],
            'now_date' => $validated['now_date'],
            'first_date' => $validated['first_date'],
            'last_date' => $validated['last_date'],
            'status' => $validated['status'],
            'product_type' => $validated['product_type'],
            'area' => $validated['area'],
            'updated_at' => now(),
        ]);

        if ($updated) {
            return redirect()->route('reserve_history.index')->with('success', 'ข้อมูลอัปเดตสำเร็จ');
        } else {
            return back()->with('error', 'ไม่สามารถอัปเดตข้อมูลได้');
        }
    }

    public function destroy($id)
    {
        // ตรวจสอบสิทธิ์
        if (Auth::guard('admin')->user()->role_name !== 'Admin') {
            return redirect()->route('reserve_history.index');
        }

        // ดึงข้อมูลที่ต้องการลบ
        $history = DB::table('reserve_histories')->where('id', $id)->first();

        if (!$history) {
            return redirect()->route('reserve_history.index')->with('error', 'ไม่พบข้อมูลที่ต้องการลบ');
        }

        // ลบข้อมูล
        DB::table('reserve_histories')->where('id', $id)->delete();

        return redirect()->route('reserve_history.index');
    }


}
