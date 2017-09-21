<?php

namespace App\Http\Controllers\Manager;

use App\Models\Base\Ad;
use App\Repositories\Ad\AdRepository;
use App\tools\AutoCreatePermissionSeeder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdController extends ParentController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware("manager.auth");
    }

    /**
     * @param Request $request
     * @param Ad $ad
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @auther <Helee>
     */
    public function index(Request $request , Ad $ad)
    {
        $query = new Ad();
        if($request->has('keywords'))
        {
            if($request->input('keywords') != "")
            {
                $query = $query->Where(function($query) use($request) {
                    $query->Where('title','like',"%".e($request->input('keywords'))."%")
                        ->orWhere('master_nick_name','like',"%".e($request->input('keywords'))."%")
                        ->orWhere('company_name','like',"%".e($request->input('keywords'))."%")
                        ->orWhere('job_name','like',"%".e($request->input('keywords'))."%")
                        ->orWhere('address','like',"%".e($request->input('keywords'))."%");
                });
            }
        }
        if($request->has('type')){
            $query = $query->where('type',intval($request->input('type')));
        }
        $limit = $request->has('l') && in_array($request->input('l'),[5,10,20,200]) ?
            $request->input('l')  : 10;
        $list = $query->paginate($limit);
        return view('man.ad.list',['list' => $list,'request'=>$request,'layui'=>true]);
    }

    public function info ($id , AdRepository $repository)
    {
        $ad = $repository->find($id);
        dd($ad);
    }

    /**
     * @param $id
     * @param AdRepository $repository
     * @return \Illuminate\Http\RedirectResponse
     * @auther <Helee>
     */
    public function setStatus ($id , AdRepository $repository)
    {
        $ad = $repository->find($id);
        $ad->status = 1;
        $ad->save();
        return back()->with('status',200)->with('message','审核通过');
    }

}
