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
use App\Helpers\Helper;

//=== Model Backend ===
use App\Models\Backend\CustomerModel;
use App\Models\Backend\Customer_question_headModel;
use App\Models\Backend\Customer_question_pointModel;
use App\Models\Backend\Customer_question_timeModel;
//=====================

class HomeController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    protected $prefix = 'front-end';

    // public function setLang(Request $request)
    // {
    // 	$lang = Session::get('lang');
    //     $referrer =  $request->headers->get('referer');
    //     Session::put('lang',$request->lang);
    //     $newReferer = str_replace('/'.$lang,'/'.$request->lang, $referrer);

    //     return redirect()->intended($newReferer);
    // }

    public function index(Request $request)
    {
        if(Auth::guard('user')->id() == null){
            return view("$this->prefix.index", [
                'prefix' => $this->prefix,
            ]);
        }else{
            return redirect("home");
        }
        
    }

    

    public function home(Request $request)
    {
        $head = Customer_question_headModel::where(['isActive'=>'waiting', 'customer_id'=>Auth::guard('user')->id()])->first();
        $time = null;
        if($head)
        {
            $time = Customer_question_timeModel::where(['customer_id'=>Auth::guard('user')->id(), 'question_head_id'=> $head->id])
                ->whereNotNull('performance1_point')
                ->whereNotNull('performance2_point')
                ->whereNotNull('performance3_point')
                ->orderby('id','desc')
            ->first();
        }

        return view("$this->prefix.home", [
            'prefix' => $this->prefix,
            'customer' => CustomerModel::find(Auth::guard('user')->id()),
            'curse' => Helper::homeGraph(Auth::guard('user')->id()),
            'head' => $head,
            'history' => $time,
        ]);
    }

    public function performance(Request $request)
    {
        return view("$this->prefix.performance", [
            'prefix' => $this->prefix,
            'customer' => CustomerModel::find(Auth::guard('user')->id()),
        ]);
    }

    
    public function history(Request $request)
    {
        $head = Customer_question_headModel::where(['isActive'=>'waiting', 'customer_id'=>Auth::guard('user')->id()])->first();
        $time = null;
        $times = null;

        $graph_data = array();
        $graph_title = array();
        $graph_date = array();
        $graph_url = array();

        if($head)
        {
            $times = Customer_question_timeModel::where(['customer_id'=>Auth::guard('user')->id(), 'question_head_id'=> $head->id, 'isActive'=>'success'])
                ->whereNotNull('performance1_point')
                ->whereNotNull('performance2_point')
                ->whereNotNull('performance3_point')
                ->get();
            if($times){
                foreach($times as $item){
                    $graph = Helper::findGraph(Auth::guard('user')->id(), $head->id, $item->id);

                    array_push($graph_data, $graph['result_point']);
                    array_push($graph_title, "ครั้งที่ ".$item->sort);
                    array_push($graph_date, date('d/m/Y',strtotime('+543 Years',strtotime($item['datetime_service']))));
                    array_push($graph_url, "history-detail?question=".$head->id."&time=".$item->id);
                }
            }
            
            $time = Customer_question_timeModel::where(['customer_id'=>Auth::guard('user')->id(), 'question_head_id'=> $head->id, 'isActive'=>'success'])
            ->whereNotNull('performance1_point')
            ->whereNotNull('performance2_point')
            ->whereNotNull('performance3_point')
            ->orderby('id','DESC')->first();
        }

        if($time != null){
            return view("$this->prefix.history", [
                'prefix' => $this->prefix,
                'customer' => CustomerModel::find(Auth::guard('user')->id()),
                'head' => $head,
                'historys' => $times,
                'time' => $time,
                // 'graph_data' => $graph_data,
                'graph_data' => json_encode($graph_data),
                'graph_title' => json_encode($graph_title),
                'graph_date' => json_encode($graph_date),
                'graph_url' => json_encode($graph_url),
            ]);
        }else{
            return view("$this->prefix.alert.alert", [
                'url' => 'home',
                'title' => "ไม่สามารถทำรายการได้",
                'text' => "ไม่พบประวัติการรักษา",
                'icon' => 'error'
            ]);
        }
    }
    
    public function historyDetail(Request $request)
    {
        $customer_id = Auth::guard('user')->id();
        $question_head_id = $request->question;
        $question_time_id = $request->time;

        if($question_head_id == null && $question_time_id == null){
            $arr['status'] = 500;
            $arr['message'] = "ไม่พบข้อมูลประวัติการรักษา";
        }else{
            $question = Customer_question_headModel::where(['customer_id'=> $customer_id, 'id'=>$question_head_id])->first(); 
            if($question)
            {
                $question_times = Customer_question_timeModel::where(['customer_id'=> $customer_id, 'question_head_id'=>$question_head_id, 'isActive'=>'success'])
                    ->whereNotNull('performance1_point')
                    ->whereNotNull('performance2_point')
                    ->whereNotNull('performance3_point')
                ->get(); 
                $time = Customer_question_timeModel::where(['customer_id'=> $customer_id, 'question_head_id'=>$question_head_id, 'id'=>$question_time_id])
                    ->whereNotNull('performance1_point')
                    ->whereNotNull('performance2_point')
                    ->whereNotNull('performance3_point')
                ->first(); 
                if($time){
                    $arr['status'] = 200;
                }else{
                    $arr['status'] = 500;
                    $arr['message'] = "ไม่พบข้อมูลประวัติการรักษา";
                }
            }else{
                $arr['status'] = 500;
                $arr['message'] = "ไม่พบข้อมูลประวัติการรักษา";
            }
        }

        if($arr['status'] == 200){
            return view("$this->prefix.history-detail", [
                'prefix' => $this->prefix,
                'customer' => CustomerModel::find(Auth::guard('user')->id()),
                'question' => $question,
                'time' => $time,
                'question_times' => $question_times,
                'curse' => Helper::findGraph(Auth::guard('user')->id(), $question_head_id, $question_time_id),
            ]);
        }else{
            return view("$this->prefix.alert.alert", [
                'url' => 'history',
                'title' => "".$arr['message'],
                'text' => "",
                'icon' => 'error'
            ]);
        }
     
    }

    public function presentDetail(Request $request)
    {

        $head = Customer_question_headModel::where(['isActive'=>'waiting', 'customer_id'=>Auth::guard('user')->id()])->first();
        $time = null;
        if($head)
        {
            $time = Customer_question_timeModel::where(['customer_id'=>Auth::guard('user')->id(), 'question_head_id'=> $head->id])
                ->whereNotNull('performance1_point')
                ->whereNotNull('performance2_point')
                ->whereNotNull('performance3_point')
                ->orderby('id','desc')
            ->first();
        }

        if($time == null){
            return view("$this->prefix.alert.alert", [
                'url' => 'home',
                'title' => "ไม่พบข้อมูลการรักษา",
                'text' => "",
                'icon' => 'error'
            ]);
        }else{
            return view("$this->prefix.present-detail", [
                'prefix' => $this->prefix,
                'head' => $head,
                'history' => $time,
                'curse' => Helper::homeGraph(Auth::guard('user')->id()),
            ]);
        }
       
    }
    
    
    

    public function login(Request $request)
    {
        if(Auth::guard('user')->id() == null){
            return view("$this->prefix.login", [
                'prefix' => $this->prefix,
            ]);
        }else{
            return redirect("home");
        }

    }

    public function questionnaire(Request $request)
    {
        return view("$this->prefix.questionnaire", [
            'prefix' => $this->prefix,
        ]);
    }

    public function profileSetting(Request $request)
    {
        return view("$this->prefix.profile-setting", [
            'prefix' => $this->prefix,
            'customer' => CustomerModel::find(Auth::guard('user')->id()),
        ]);
    }
    public function profileSettingUpdate(Request $request){
        try {

            DB::beginTransaction();
            $data = CustomerModel::find(Auth::guard('user')->id());
            $data->firstname = $request->firstname;
            $data->lastname = $request->lastname;
            $data->sex = $request->sex;
            $data->birthdate = $request->birthdate;
            $data->age = $request->age;
            if ($data->save()) {
                DB::commit();
                return view("$this->prefix.alert.success", ['url' => url("home")]);
            } else {
                return view("$this->prefix.alert.error", ['url' => url("home")]);
            }
        } catch (\Exception $e) {
            $error_log = $e->getMessage();
            $error_line = $e->getLine();
            $type_log = 'backend';
            $error_url = url()->current();
            // $log_id = LogsController::save_logbackend($type_log, $error_log, $error_line, $error_url);

            return view("$this->prefix.alert.alert", [
                'url' => $error_url,
                'title' => "เกิดข้อผิดพลาดทางโปรแกรม",
                'text' => "กรุณาแจ้งรหัส Code : 1 ให้ทางผู้พัฒนาโปรแกรม ",
                'icon' => 'error'
            ]);
        }
    }
}
