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
    // ตรวจสอบข้อมูลจากฟอร์ม
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'now_date' => 'required|date',
        'first_date' => 'required|date',
        'last_date' => 'required|date',
        'status' => 'required|in:active,inactive',
        'product_type' => 'required|string|max:255',
        'area' => 'required|string|max:255',
    ]);

    // เพิ่มข้อมูลลงในฐานข้อมูล
    DB::table('reserve_histories')->insert([
        'name' => $validated['name'],
        'now_date' => $validated['now_date'],
        'first_date' => $validated['first_date'],
        'last_date' => $validated['last_date'],
        'status' => $validated['status'],
        'product_type' => $validated['product_type'],
        'area' => $validated['area'],
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Redirect กลับไปที่หน้ารายการจอง พร้อมข้อความ success
    return redirect()->route('reserve_history.index')->with('success', 'เพิ่มข้อมูลสำเร็จ');
}





    
    
}
