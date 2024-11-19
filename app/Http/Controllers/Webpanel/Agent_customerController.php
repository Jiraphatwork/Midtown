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
            'business_card' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tax_card' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pic_id_card' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'id_card' => 'required|string|max:13',
            'address' => 'required|string|max:255',
            'address2' => 'nullable|string|max:255',
            'address3' => 'nullable|string|max:255',
            'tel' => 'required|string|max:10',
            'fax' => 'nullable|string|max:10',
            'tel2' => 'nullable|string|max:10',
            'tax_id' => 'nullable|string|max:13',
            'slip_card' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
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
            'address2' => $validated['address2'],
            'address3' => $validated['address3'],
            'tel' => $validated['tel'],
            'fax' => $validated['fax'],
            'tel2' => $validated['tel2'],
            'tax_id' => $validated['tax_id'],
            'slip_card' => $slipcardFilename,
        ]);
    
        return redirect()->route('agent_customer.index')->with('success', 'เพิ่มข้อมูลสำเร็จ');
    }
    
}
