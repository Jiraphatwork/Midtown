<?php

namespace App\Http\Controllers\Webpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\SettingrefundModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Backend\AdminModel;
use Illuminate\Support\Facades\Auth;

class SettingrefundController extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'settingrefund';
    protected $folder = 'settingrefund';

    public function index(Request $request)
    {
        $items = SettingrefundModel::all();
        return view("$this->prefix.pages.$this->folder.index", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
            'items' => $items,
        ]);
    }
    public function add(Request $request)
    {
        // ตรวจสอบสิทธิ์
        if (Auth::guard('admin')->user()->role_name !== 'Admin') {
            return redirect()->route('settingrefund.index')->with('error', 'คุณไม่มีสิทธิ์ในการเพิ่มข้อมูล');
        }
    
        // ถ้าผู้ใช้มีสิทธิ์, ให้เปิดหน้าเพิ่มข้อมูล
        return view("$this->prefix.pages.$this->folder.add", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
        ]);
    }
    

    public function edit(Request $request, $id)
    {
         // ตรวจสอบสิทธิ์
         if (Auth::guard('admin')->user()->role_name !== 'Admin') {
            return redirect()->route('settingrefund.index')->with('error', 'คุณไม่มีสิทธิ์ในการแก้ไขข้อมูล');
        }
        $item = SettingrefundModel::find($id);
        return view("$this->prefix.pages.$this->folder.edit", [
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'segment' => $this->segment,
            'item' => $item,
        ]);
    }
    //==== Function Insert Update Delete Status Sort & Others ====
    public function insert(Request $request, $id = null)
    {
        return $this->store($request, $id = null);
    }
    public function update(Request $request, $id)
    {
        // dd($request);
        return $this->store($request, $id);
    }

    public function store(Request $request, $id = null)
    {
        Log::info('Data received:', $request->all());

        if (!$request->has('name') || empty($request->name)) {
            return response()->json(['success' => false, 'message' => 'Name is required']);
        }

        try {
            DB::beginTransaction();

            $user = AdminModel::find(Auth::guard('admin')->id());

            if ($id == null) {
                $data = new SettingrefundModel();
                $data->created_at = now();
                $data->created_by = $user->email;
            } else {
                $data = SettingrefundModel::find($id);
                $data->updated_by = $user->email;
                $data->updated_at = now();
            }
            $data->name = $request->name;
            $data->details = $request->details;

            if ($data->save()) {
                DB::commit();
                return response()->json(true);
            } else {
                return response()->json(false);
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error during saving data', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
             // ตรวจสอบสิทธิ์
             if (Auth::guard('admin')->user()->role_name !== 'Admin') {
                return redirect()->route('settingrefund.index');
            }
        try {
            $item = SettingrefundModel::find($id);

            if ($item) {
                $item->delete();
                return response()->json(['success' => true]);
            }

            return response()->json(['success' => false]);
        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }
    }
}
