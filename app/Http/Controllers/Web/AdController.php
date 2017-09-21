<?php

namespace App\Http\Controllers\Web;

use App\Exceptions\Web\WebLogicException;
use App\Models\Base\Ad;
use App\Models\ErrorCode;
use App\Models\Ret;
use App\Models\Web\Area;
use App\Models\Web\City;
use App\Repositories\Ad\AdRepository;
use App\Services\AdService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;

class AdController extends Controller
{
    public function __construct()
    {
//        $this->middleware('web.auth');
        $this->request = \Illuminate\Support\Facades\Request::all();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = Ad::orderby('id','desc')->get();
        if(!$result->isEmpty()){
            foreach ($result as $val){
                $inter = app(AdRepository::class)->find($val->id);
            }
        }
        return view('web.ad.index',['data' => $result]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $area = Area::get();
        $city = City::where('parent_id',0)->get();
        return view('web.ad.create',['area' => $area,'city' => $city]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
//            $v = $this->checkParameter($request);
//            if($v->fails()){
//                return redirect()->back()->with('message', $v->messages()->first());
//            }
            if((new AdService)->store() == 1){
                return redirect('/index')->with('message', '发布成功!');
            }
            return redirect('/index')->with('message', '发布失败!');
        }catch(\Exception $e){
            dd($e);
            return redirect()->back()->with('message', $e->getMessage().'!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = app(AdRepository::class)->find($id);
//        dd($result->toarray());
        return view('web.ad.show',['data' => $result]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $area = Area::get();
        $city = City::where('parent_id',0)->get();
        $result = app(AdRepository::class)->find($id);
        return view('web.ad.edit',['data' => $result,'area' => $area,'city' => $city]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        try{
            $ad = new AdService();
            $res=$ad->update();
            if($res[0]){
                return redirect('/ad/edit/'.$res[1]->id)->with('message', '修改成功!');
            }else{
                return redirect('/ad/edit/'.$res[1]->id)->with(['message'=>'没有什么需要修改!','level'=>'info']);
            }
        }catch(\Exception $e){
            dd($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inter = app(AdRepository::class);
        $obj = $inter->find($id);
        $obj->status = 0; //TODO
        $result =$inter->save($obj);
        return redirect('/ad/index')->with('message', '删除成功!');
    }

    public function checkParameter(Request $request){
        $v = Validator::make(
//        $this->validate(
            $request->all(),
            [
                'com_name' => "required|min:6|max:255",
                'job_name' => "required|min:6|max:255",
                'num' => "required|numeric|min:1|max:1000",
                'description' => "required|min:6|max:255",
                'contacts' => "required|min:3|max:10",
                'tel1' => "required|digits_between:8,13",//todo
                'email' => "required|email|min:6|max:255",
                'address' => "required|min:3|max:255",
            ],
            $messages = [
                'com_name.required' => ErrorCode::COMPANY_NAME_REQUIRED, //公司名称不能为空!
                'com_name.min' => ErrorCode::COMPANY_NAME_MIN, //公司名称不能少于6个汉字!
                'com_name.max' => ErrorCode::COMPANY_NAME_MAX, //公司名称不能多于255个汉字!
                'job_name.required' => ErrorCode::JOB_NAME_REQUIRED, //职位不能为空!
                'job_name.min' => ErrorCode::JOB_NAME_MIN, //职位不能少于6个汉字!
                'job_name.max' => ErrorCode::JOB_NAME_MAX, //职位不能多于255个汉字!
                'num.required' => ErrorCode::NUM_REQUIRED, //招聘人数不能为空!
                'num.min' => ErrorCode::NUM_MIN, //请正确填写招聘人数!
                'num.max' => ErrorCode::NUM_MAX, //请正确填写招聘人数!
                'num.numeric' => ErrorCode::NUM_NUMERIC, //请正确填写招聘人数!
                'description.required' => ErrorCode::DESCRIPTION_REQUIRED, //工作内容不能为空!
                'description.min' => ErrorCode::DESCRIPTION_MIN, //工作内容不能少于6个汉字!
                'description.max' => ErrorCode::DESCRIPTION_MAX, //工作内容不能多于255个汉字!
                'contacts.required' => ErrorCode::CONTACTS_REQUIRED, //联系人不能为空!
                'contacts.min' => ErrorCode::CONTACTS_MIN, //联系人不能少于6个汉字!
                'contacts.max' => ErrorCode::CONTACTS_MAX, //联系人不能多于255个汉字!
                'tel1.required' => ErrorCode::TEL_REQUIRED, //联系电话不能为空!
                'tel1.min' => ErrorCode::TEL_MIN, //联系电话不能少于8位!
                'tel1.max' => ErrorCode::TEL_MAX, //联系电话不能多于13位!
                'tel1.numeric' => ErrorCode::TEL_NUMERIC, //请正确填写电话号码!
                'email.required' => ErrorCode::EMAIL_REQUIRED, //邮箱不能为空!
                'email.min' => ErrorCode::EMAIL_MIN, //邮箱不能少于6个汉字!
                'email.max' => ErrorCode::EMAIL_MAX, //邮箱不能多于255个汉字!
                'email.email' => ErrorCode::EMAIL_EMAIL, //邮箱格式不正确!
                'address.required' => ErrorCode::ADDRESS_REQUIRED, //联系地址不能为空!
                'address.min' => ErrorCode::ADDRESS_MIN, //联系地址不能少于6个汉字!
                'address.max' => ErrorCode::ADDRESS_MAX, //联系地址不能多于255个汉字!
            ]
        );
        return $v;
    }
}
