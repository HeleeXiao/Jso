<?php

namespace App\Http\Controllers\Web;

use App\Models\Base\Ad;
use App\Repositories\Ad\AdRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $typeid = (integer) $request->get('typeid');
        $result = Ad::orderby('id','desc');
        if(is_numeric($typeid)){
            $result = $result->where('job_type',$typeid);
        }
        $result = $result->paginate(20);
        if(!$result->isEmpty()){
            foreach ($result as $val){
                $inter = app(AdRepository::class)->find($val->id);
            }
        }
        return view('web.index',['data' => $result]);
    }
}
