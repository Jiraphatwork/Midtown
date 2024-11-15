<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Webpanel\LogsController;

//=== Model Backend ===
use App\Models\Backend\CustomerModel;
//=====================

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    protected $prefix = 'front-end';
    public function postLogin(Request $request)
    {
        try {
            $credentials = $request->only('phone', 'password');

            if (Auth::guard('user')->attempt($credentials)) {
                $customer = CustomerModel::find(Auth::guard('user')->id());
                if ($customer->isActive != "Y") {
                    return redirect('webpanel\login')->with(['error' => 'ไม่สามารถใช้งานได้ กรุณาติดต่อผู้ดูแล !']);
                } else {
                    $arr = [
                        'status' => '200',
                        'result' => 'success',
                        'message' => 'ดำเนินการสำเร็จ'
                    ];
                }
            } else {
                $arr = [
                    'status' => '500',
                    'result' => 'error',
                    'title' => 'ไม่สามารถทำรายการได้',
                    'text' => 'ชื่อผู้ใช้งาน หรือรหัสผ่านไม่ถูกต้อง !'
                ];
                // return redirect('webpanel\login')->with(['error' => 'ชื่อผู้ใช้งาน หรือรหัสผ่านผิด !']);
            }
            echo json_encode($arr);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function logOut()
    {
        if (!Auth::guard('user')->logout()) {
            return redirect("login");
        }
    }
}
