<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Manager\ParentController;
use App\Models\Base\Permission;
use App\Models\Base\Role;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends ParentController
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
    public function index(Request $request)
    {
        $roles = Role::where('status',0)->paginate(10);
        $permissions = Permission::all();
        return view('man.role.list',[
            'list'=>$roles,
            'request'=>$request,
            'permissions'=>$permissions,
            'layui'=>true
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::where('status',0)->get();
        return view('man.role.add',[
            'permissions'=>$permissions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => "required|string|unique:roles",
            'name_zh' => "required|string|unique:roles",
            'name_jp' => "required|string|unique:roles",
            'permission_id' => "required",
        ],[
            'name.required' => trans('messages.request_required'),
            'name_zh.required' => trans('messages.request_required'),
            'name_jp.required' => trans('messages.request_required'),
            'permission_id.required' => trans('messages.request_required'),
            'name.unique'      => "已经存在该数据，请修改",
            'name_zh.unique'   => "已经存在该数据，请修改",
            'name_jp.unique'   => "已经存在该数据，请修改",
        ]);
        try{
            DB::beginTransaction();
            $roles = Role::create([
                'name' => e($request->input('name')),
                'name_zh' => e($request->input('name_zh')),
                'name_jp' => e($request->input('name_jp')),
                'description' => e($request->input('description')),
            ]);
            if($roles){
                foreach ($request->input('permission_id') as $permission_id) {
                    $roles->attachPermission($permission_id);
                }
                DB::commit();
                \Cache::tags(\Config::get('entrust.permission_role_table'))->flush();
                return back()->withInput()->with("message", trans("messages.add_success") )->with('status', 200);
            }
            DB::rollBack();
            return back()->withInput()->with("message",trans("messages.add_fail") )->with('status',203);
        }catch (\Exception $e){
            \Log::error('添加角色失败'.$e);
            DB::rollBack();
            return back()->withInput()->with("message",trans("messages.add_fail") )->with('status',203);
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
        $roles = Role::where('status',0)->where('id',$id)->get();
        $permissions = Permission::where('status',0)->select(['id','name_zh','name_jp'])->get();
        return view('man.role.info',['roles'=>$roles,'permissions'=>$permissions,'layui'=>true]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles = Role::find($id);
        return view('man.role.edit',['role'=>$roles,'layui'=>true]);
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
        $thisRole = Role::where('id',$id)->first();
        $originalPerms = $thisRole->perms->pluck('id')->toArray();
        $nowPerms = $request->input('permissions');
        $delete = [];
        $insert = [];
        foreach ($originalPerms as $perm)
        {
            if( ! in_array($perm , $nowPerms) )
            {
                array_push($delete,$perm);
            }
        }
        foreach ($nowPerms as $perm)
        {
            if( ! in_array($perm , $originalPerms) )
            {
                array_push($insert,$perm);
            }
        }
        foreach ($insert as $value)
        {
            $thisRole->attachPermission($value);
        }
        foreach ($delete as $value)
        {
            $thisRole->detachPermission($value);
        }
        \Cache::tags(\Config::get('entrust.permission_role_table'))->flush();
        return back()->withInput()->with("message",'操作成功!')->with('status',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $thisRole = Role::where('id',$id)->first();
        $originalPerms = $thisRole->perms->pluck('id')->toArray();
        foreach ($originalPerms as $value)
        {
            $thisRole->detachPermission($value);
        }
        Role::where('id',$id)->delete();
        \Cache::tags(\Config::get('entrust.permission_role_table'))->flush();
        return back()->with("message",'操作成功!')->with('status',200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @auther <Helee>
     */
    public function postUpdateInfo(Request $request){
        $update = Role::where('id', e($request->input('d')) )
            ->update([
               'name' => e($request->input('name')),
               'name_zh' => e($request->input('name_zh')),
               'name_jp' => e($request->input('name_jp')),
               'description' => e($request->input('description')),
            ]);
        if($update){
            $ro = Role::where('id', e($request->input('d')) )->first();
            $ro->created_at = Carbon::now();
            $ro->save();
            \Cache::tags(\Config::get('entrust.permission_role_table'))->flush();
            return back()->with("message",'操作成功!')->with('status',200);
        }
    }

}
