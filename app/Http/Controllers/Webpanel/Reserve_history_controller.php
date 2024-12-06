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
        // รับค่าจาก query string 'type'
        $type = $request->input('type');

        // เริ่มต้นคำสั่ง query
        $query = DB::table('reserve_histories');

        // ถ้ามีการเลือก 'type' ให้กรองข้อมูลตาม 'type'
        if ($type) {
            $query->where('type', $type);
        }

        // ดึงข้อมูลจากฐานข้อมูลตาม query ที่กรองแล้ว
        $reserveHistories = $query->get();

        // ส่งข้อมูลไปยัง view
        return view("$this->prefix.pages.$this->folder.index", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
            'reserveHistories' => $reserveHistories, // ส่งข้อมูลที่กรองแล้วไปที่ view
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

        // ดึงค่าจาก data_area_models โดยใช้ area ที่เลือก
        $areaData = DB::table('data_area_models')->where('area', $area)->first();

        if (!$areaData) {
            return redirect()->back()->with('error', 'ไม่พบข้อมูลพื้นที่ที่เลือก');
        }

        $price = $areaData->price; // รับค่าจากข้อมูลของพื้นที่ที่เลือก

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
                'type' => $type,
                'price' => $price,
                'pic_area' => $picareaFilename,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('reserve_history.index')->with('success', 'เพิ่มข้อมูลสำเร็จ');
        }
    }

    // Function ดึงข้อมูลจาก data_area_models
    public function getAreaData(Request $request)
    {
        $type = $request->input('type');
        $area = $request->input('area'); // รับค่า area

        if ($area) {
            // ดึงข้อมูลเฉพาะ area ที่เลือก
            $areaData = DB::table('data_area_models')->where('area', $area)->first();

            if ($areaData) {
                return response()->json([
                    'pic_area' => asset('pic_areas/' . $areaData->pic_area),
                    'price' => $areaData->price
                ]);
            }
        }

        // หากเลือก type ดึงข้อมูลพื้นที่ตาม type
        if ($type) {
            return response()->json([
                'areas' => DB::table('data_area_models')->where('type', $type)->get()
            ]);
        }

        // ถ้าไม่มีข้อมูลใดๆ
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

        // ดึงข้อมูลประเภทพื้นที่ (type) จาก data_area_models
        $areaTypes = DB::table('data_area_models')->select('type')->distinct()->get();
        // ดึงข้อมูลพื้นที่ทั้งหมดจาก data_area_models
        $areas = DB::table('data_area_models')->get();

        // ส่งข้อมูลไปยังหน้า View พร้อมตัวแปรอื่นๆ
        return view('back-end.pages.reserve_history.edit', [
            'history' => $history,
            'prefix' => $this->prefix,
            'segment' => $this->segment,
            'folder' => $this->folder,
            'areaTypes' => $areaTypes,
            'areas' => $areas, // ส่งข้อมูลพื้นที่ไปที่ view
        ]);
    }

    public function update(Request $request, $id)
    {
        // ตรวจสอบการ validate ข้อมูลที่ได้รับจากฟอร์ม
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'now_date' => 'required|date',
            'first_date' => 'required|date',
            'last_date' => 'required|date',
            'status' => 'required|in:จ่ายแล้ว,ยังไม่จ่าย',
            'product_type' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            // ไม่ต้องการ validation สำหรับไฟล์ pic_area
        ]);

        // ค้นหาข้อมูลเดิมในฐานข้อมูล
        $existingData = DB::table('reserve_histories')->where('id', $id)->first();
        if (!$existingData) {
            return redirect()->route('reserve_history.index')->with('error', 'ไม่พบข้อมูลที่ต้องการแก้ไข');
        }

        // ค่าจากฟอร์ม
        $area = $validated['area'];
        $type = $validated['type'];

        // ดึงข้อมูลพื้นที่ที่เลือก
        $areaData = DB::table('data_area_models')->where('area', $area)->first();
        if (!$areaData) {
            return redirect()->back()->with('error', 'ไม่พบข้อมูลพื้นที่ที่เลือก');
        }

        // เริ่มต้นด้วยชื่อไฟล์รูปภาพเดิม
        $picareaFilename = $existingData->pic_area;

        // ถ้าไม่มีการอัปโหลดรูปภาพใหม่ จะคัดลอกไฟล์จาก pic_areas ไปยัง pic_areas_reserve
        if ($areaData->pic_area) {
            // ลบไฟล์เก่าก่อน (ถ้ามี)
            $oldPicPath = public_path('pic_areas_reserve/' . $existingData->pic_area);
            if (file_exists($oldPicPath)) {
                unlink($oldPicPath); // ลบไฟล์เก่าที่ไม่ใช้แล้ว
            }

            // คัดลอกไฟล์จาก pic_areas ไปยัง pic_areas_reserve
            $picareaFilename = time() . '_' . $areaData->pic_area;
            $sourcePath = public_path('pic_areas/' . $areaData->pic_area);
            $destinationPath = public_path('pic_areas_reserve/' . $picareaFilename);

            if (file_exists($sourcePath)) {
                copy($sourcePath, $destinationPath); // คัดลอกไฟล์จาก pic_areas ไปยัง pic_areas_reserve
            }
        }

        // อัปเดตข้อมูลในฐานข้อมูล
        DB::table('reserve_histories')->where('id', $id)->update([
            'name' => $validated['name'],
            'now_date' => $validated['now_date'],
            'first_date' => $validated['first_date'],
            'last_date' => $validated['last_date'],
            'status' => $validated['status'],
            'product_type' => $validated['product_type'],
            'area' => $validated['area'],
            'type' => $validated['type'],
            'price' => $areaData->price,  // ใช้ราคาจากพื้นที่ที่เลือก
            'pic_area' => $picareaFilename,
            'updated_at' => now(),
        ]);

        return redirect()->route('reserve_history.index')->with('success', 'อัปเดตข้อมูลสำเร็จ');
    }



    public function destroy($id)
    {
        // ตรวจสอบสิทธิ์
        if (Auth::guard('admin')->user()->role_name !== 'Admin') {
            return redirect()->route('reserve_history.index');
        }
        // ค้นหาข้อมูลลูกค้าในฐานข้อมูล
        $item = DB::table('reserve_histories')->where('id', $id)->first();

        if (!$item) {
            return redirect()->route('reserve_history.index')->with('error', 'ไม่พบข้อมูลที่ต้องการลบ');
        }

        // ลบไฟล์จาก public
        if (!empty($item->pic_area)) {
            $picareaFilename = public_path('pic_areas_reserve/' . $item->pic_area);
            if (is_file($picareaFilename)) { // ตรวจสอบว่าเป็นไฟล์
                unlink($picareaFilename); // ลบไฟล์จากระบบ
            }
        }


        // ลบข้อมูลจากฐานข้อมูล
        DB::table('reserve_histories')->where('id', $id)->delete();

        return redirect()->route('reserve_history.index');
    }


}
