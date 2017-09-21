<?php

namespace App\Http\Controllers\Manager;

use App\Models\Base\User;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class UserController extends ParentController
{

    /**
     * @var array
     */
    protected $type = [
        '普通用户',
        '游戏推广',
        '专业推广',
        '商家用户',
    ];

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware("manager.auth");
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @auther <Helee>
     */
    public function index(Request $request)
    {
        $users = new User;
        $list = [];
        if($request->has("keywords")){
            if($request->input("keywords") != ""){
                $users = $users->Where(function($query) use($request) {
                    $query->Where('nickname','like',"%".e($request->input('keywords'))."%")
                        ->orWhere('email','like',"%".e($request->input('keywords'))."%")
                        ->orWhere('mobile','like',"%".e($request->input('keywords'))."%")
                        ->orWhere('description','like',"%".e($request->input('keywords'))."%")
                        ->orWhere('register_ip','=',e($request->input('keywords')));
                });
                $limit = $request->has('l') && in_array($request->input('l'),[5,10,20,200]) ?
                    $request->input('l')  : 10;
                $list = $users->paginate($limit);
            }
        }
        return view('man.user.index',[ 'list' => $list ,'type' => $this->type,'layui'=>true ,'status'=>[
            '启用','禁用'
        ]]);
    }

    /**
     * @param $id
     * @param UserRepository $repository
     * @return \Illuminate\Http\RedirectResponse
     * @auther <Helee>
     */
    public function setType($id , UserRepository $repository)
    {
        $user = $repository->find($id);
        $user->type = $user->type == 3 ? 1 : 3;
        $user->save();
        return back()->with('status',200);
    }

    /**
     * @param $id
     * @param UserRepository $repository
     * @return \Illuminate\Http\RedirectResponse
     * @auther <Helee>
     */
    public function setStatus($id , UserRepository $repository)
    {
        $user = $repository->find($id);
        $user->status = $user->status == 0 ? 1 : 0;
        $user->save();
        return back()->with('status',200);
    }

}
