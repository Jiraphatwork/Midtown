<?php

namespace App\Http\Controllers\Webpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        // ส่งตัวแปรไปยัง View
        return view('back-end.pages.reserve_history.add', [
            'prefix' => $this->prefix,
            'segment' => $this->segment,
            'folder' => $this->folder,
        ]);
    }

    public function insert(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'now_date' => 'required|date',
            'first_date' => 'required|date',
            'last_date' => 'required|date',
            'status' => 'required|in:จ่ายแล้ว,ยังไม่จ่าย',
            'product_type' => 'required|string|max:255',
            'area' => 'required|string|max:255',
        ]);


        DB::table('reserve_histories')->insert([
            'name' => $validated['name'],
            'now_date' => $validated['now_date'],
            'first_date' => $validated['first_date'],
            'last_date' => $validated['last_date'],
            'status' => $validated['status'],
            'product_type' => $validated['product_type'],
            'area' => $validated['area'],
        ]);

        return redirect()->route('reserve_history.index')->with('success', 'เพิ่มข้อมูลสำเร็จ');
    }

    public function edit($id)
    {
        // ดึงข้อมูลจากฐานข้อมูลตาม ID
        $history = DB::table('reserve_histories')->find($id);

        if (!$history) {
            return redirect()->route('reserve_history.index')->with('error', 'ไม่พบข้อมูล');
        }

        // ส่งข้อมูลไปยังหน้า View พร้อมตัวแปรอื่นๆ
        return view('back-end.pages.reserve_history.edit', [
            'history' => $history,
            'prefix' => $this->prefix,  // ส่งตัวแปร $prefix
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

            // หากข้อมูลไม่มีการเปลี่ยนแปลง, กลับไปยังหน้า index
            return redirect()->route('reserve_history.index');
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
        ]);

        // ตรวจสอบการอัปเดตข้อมูล
        if ($updated) {
            return redirect()->route('reserve_history.index')->with('success', 'ข้อมูลอัปเดตสำเร็จ');
        } else {
            return back()->with('error', 'ไม่สามารถอัปเดตข้อมูลได้');
        }
    }


    public function destroy($id)
    {
        $history = DB::table('reserve_histories')->where('id', $id)->first();

        if (!$history) {
            return redirect()->route('reserve_history.index')->with('error', 'ไม่พบข้อมูลที่ต้องการลบ');
        }
        DB::table('reserve_histories')->where('id', $id)->delete();

        return redirect()->route('reserve_history.index')->with('success', 'ลบข้อมูลสำเร็จ');
    }


}
