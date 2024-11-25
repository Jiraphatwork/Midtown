<?php

namespace App\Http\Controllers\Webpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CalendarController extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'calendar';
    protected $folder = 'calendar';

    public function index(Request $request)
    {
        // ดึงข้อมูลจากฐานข้อมูล
        $calendars = DB::table('calendar_models')->get(); // หรือใช้ Model: CalendarModel::all();
    
        // ส่งข้อมูลไปยัง view
        return view("$this->prefix.pages.$this->folder.index", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
            'calendars' => $calendars, 
        ]);
    }
       
}
