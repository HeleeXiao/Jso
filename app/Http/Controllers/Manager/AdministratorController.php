<?php

namespace App\Http\Controllers\Manager;

use App\Models\Base\Administrator;
use App\Models\Base\Permission;
use App\Models\Base\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdministratorController extends ParentController
{
    public function __construct(){
        parent::__construct();
        $this->middleware('auth');
        view()->share('name',\Config::get("app." . app()->getLocale()));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request)
    {
        $users = Administrator::where('id', '>', 1);
        if($request->has('keywords'))
        {
            if($request->input('keywords') != "")
            {
                $users = $users->where('name','like',"%".e($request->input('keywords'))."%");
                $users = $users->orWhere('email','like',"%".e($request->input('keywords'))."%");
            }
        }
        $users = $users->paginate($request->input('l')?:10);
        return view('man.administrator.list',[
            'list'=>$users,
            'request'=>$request,
            'layui' => true
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = \App\Models\Base\Role::where('status',0)->get();
        return view('man.administrator.add',['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'name' => "required|string|unique:cool_admin",
            'email' => "required|email|unique:cool_admin",
//            'password' => "sometimes|min:6|max:12",
        ],[
            'name.required' => trans('messages.request_required'),
            'name.unique'   => trans('messages.unique_user_name'),
            'email.required'   => trans('messages.request_required'),
            'email.unique'   => trans('messages.unique_email'),
            'email.email'   => trans('messages.email_fail'),
//            'password.min' => "密码长度不得少于6位",
//            'password.max' => "密码长度不得大于12位",
        ]);
        if( $validator->fails() )
        {
            return back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try{
            $user = new Administrator;
            $user->name = e(trim($request->input('name')));
            $user->email = e(trim($request->input('email')));
            $user->password = $request->has('password') ?
                bcrypt(trim($request->input('password'))) : bcrypt(123456);
            $user->status = $request->input('status');
            $user->save();
            $user->attachRole($request->input('role_id'));
            DB::commit();
            \Cache::tags(\Config::get('entrust.role_user_table'))->flush();
            return redirect()->route("users.index")->with('message',trans("messages.add_success") )->with('status',200);
        }catch (\Exception $e)
        {
            DB::rollBack();
            \Log::error("添加用户失败".$e->getMessage());
            return back()->with('message',trans("messages.add_fail") )->with('status',203);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles = \App\Models\Base\Role::where('status',0)->get();
        $info = Administrator::find($id);
        return view('man.administrator.edit',[
            'info'=>$info,
            'roles'=>$roles,
            'id'=>$id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /*
         * 修改用户密码
         */
        if($request->has('action') && $request->action == "P")
        {
            if( trim( $request->input("password") ) !== trim( $request->input("password-confirm") ) )
            {
                return back()->with('pageMsg',trans('messages.admin_password_again'))->with('level','error');
            }
            if( trim( $request->input("password") ) == "" || trim($request->input("password-confirm") ) == "" )
            {
                return back()->with('pageMsg',trans('messages.admin_password_not_null'))->with('level','error');
            }
            $user = \Auth::user();
            $user->password = bcrypt(trim($request->input("password")));
            $user->save();
            session([ 'login_status'=> 600]);
            return redirect(route("manager.logout",['e'=>1]));
//            return back()->with("message", trans("messages.option_success") )->with('status', 200);
        }

        $this->validate($request,[
            'name' => "required|string",
            'email' => "required|email",
            'role_id' => "required",
        ],[
            'name.required' => trans('messages.request_required'),
            'email.required' => trans('messages.request_required'),
            'role_id.required' => trans('messages.request_required'),
        ]);
//        dd($request->all());
        try{
            DB::beginTransaction();
            $user = Administrator::find($request->input('user_id'));
            /*
             * 判断是否有修改的数据
             */
            $updateNull = true; //判断有无基本数据修改需求的变量
            $updateRole = true; //判断有无所属角色修改需求的变量
            $afterRole  = false;//判断有无所属角色的变量
            if(e($request->input('name')) == $user->name && $request->input('email') == $user->email &&
                 $user->status == $request->input('status') ){
                $updateNull = false;
            }
            if($user->roles->count()){
                $request->input('role_id') == $user->roles[0]->id ? $updateRole = false : $updateRole = true;
                $afterRole  = true;
            }{
                $updateRole = true;
            }
            if( !$updateNull && !$updateRole ){
                return back()->with('message',trans("messages.nothing_update") )->with('status', 202)->withInput();
            }
            $user->name = e($request->input('name'));
            $user->email = $request->input('email');
            $user->status = $request->input('status');
            $save = $user->save();
                if($afterRole){
                    if($updateRole)
                    {
                        $user->detachRole($user->roles[0]->id);
                    }
                }
                $user->attachRole($request->input('role_id'));
            if(! $save ){
                DB::rollBack();
                return back()->with("message",trans("messages.option_fail") )->with('status',203);
            }
            DB::commit();
            \Cache::tags(\Config::get('entrust.role_user_table'))->flush();
            return redirect()->route("users.index")->with("message", trans("messages.option_success") )->with('status', 200);
        }catch (\Exception $e){
            \Log::error('修改用户信息失败'.$e->getMessage().'\n'.$e->getFile().$e->getLine());
            DB::rollBack();
            return back()->with("message",trans("messages.option_fail") )->with('status',203);
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
        if ($id == 1) { //超级管理员账号不能被操作
            return back()->with("message",'操作失败!')->with('status',203);
        }

        DB::beginTransaction();
        try{
            $delete = Administrator::where( ['id'=>$id] )->delete();
            if($delete){
                DB::commit();
                \Cache::tags(\Config::get('entrust.role_user_table'))->flush();
                return back()->with("message", '操作成功!')->with('status', 200);
            }
            DB::rollBack();
            return back()->with("message",'操作失败!')->with('status',203);
        }catch (\Exception $e){
            \Log::error('删除账号失败'.$e->getMessage());
            DB::rollBack();
            return back()->with("message",'操作失败!')->with('status',203);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @auther <Helee>
     */
    public function resetPassword($id)
    {
        if ($id == 1) { //超级管理员账号不能被操作
            return back()->with("message",'操作失败!')->with('status',203);
        }
        $user = Administrator::find($id);
        if(!$user){
            return back()->with("message",'没有该用户!')->with('status',203);
        }
        $user->password = bcrypt(123456);
        $user->save();
        return back()->with("message", '操作成功!')->with('status', 200);
    }

}
