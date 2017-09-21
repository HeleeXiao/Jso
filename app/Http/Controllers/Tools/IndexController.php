<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use App\Models\Web\Area;
use App\Models\Web\City;
use phpQuery;

class IndexController extends Controller
{
    public function __construct(){
        session_start();
        ob_end_flush(); //关闭缓存
//echo str_repeat("　",256); //ie下 需要先发送256个字节
        set_time_limit(0);
    }
    public function get_area(){
        $url = 'https://townwork.net/?arc=1';
        phpQuery::newDocumentFile($url);
        $area_num = pq('.area-sch-lst > h2 > a')->count();
        for ($area_i=0;$area_i<$area_num;$area_i++){
            $name = pq('.area-sch-lst > h2 > a:eq('.$area_i.')')->text();
            $res = Area::where('name',$name)->first();
            if($res){
                echo $name."已存在->跳过<br/>";
                continue;
            }
            $en = trim(pq('.area-sch-lst > h2 > a:eq('.$area_i.')')->attr('href'),'/');
            echo "区域:".$name."<br/>";
            echo "英文名:".$en."<br/>";
            echo "<br/><br/>";
            $area_m = new Area();
            $area_m->name = $name;
            $area_m->english_name = $en;
            $area_m->order_id = $area_i;
            $area_m->save();
            flush();
        }
        echo "总共采集:".$area_num."条<br/>";
    }
    public function get_city(){
        $area_m = Area::get();
        foreach ($area_m as $val){
            $url = 'https://townwork.net/'.$val->english_name.'/';
            phpQuery::newDocumentFile($url);
            if(pq(".sa-inner-area-nav3")->text()){
                $nav = 3;
            }elseif(pq(".sa-inner-area-nav4")->text()){
                $nav = 4;
            }else{
                $res = City::where('name',$val->name)->first();
                if($res){
                    echo "<a style='color: red;'>".$val->name."已存在->跳过</a><br/>";
                    continue;
                }
                $city_m = new City();
                $city_m->area_id = $val->id;
                $city_m->name = $val->name;
                $city_m->parent_id = 0;
                $city_m->english_name = $val->english_name;
                $city_m->order_id = 0;
                $city_m->save();
                continue;
            }
            $city_num = pq(".sa-btn-area")->count();
            for ($city_i=0;$city_i<$city_num;$city_i++){
                $res = pq(".sa-btn-area:eq(".$city_i.")");
                $en =$res->attr('href');
                $en = trim($en,'/');
                $name =pq(".sa-btn-area:eq(".$city_i.")")->text();
                echo "<br/>";
                $res = City::where('name',$name)->first();
                if($res){
                    echo "<a style='color: red;'>".$name."已存在->跳过</a><br/>";
                    continue;
                }
                $city_m = new City();
                $city_m->area_id = $val->id;
                $city_m->name = $name;
                $city_m->parent_id = 0;
                $city_m->english_name = $en;
                $city_m->order_id = $city_i;
                $city_m->save();
            }
            echo "<br/><br/><br/>";
            flush();
        }
    }

    public function get_part(){
        $p_m = City::where('parent_id','0')->get();
        if(!$p_m){
            echo "没有数据";
            exit;
        }
        foreach ($p_m as $val) {
            $url = 'https://townwork.net/okinawa/';
            phpQuery::newDocumentFile($url);
            echo "-----".$val->name."√<br/>";
            $url = 'https://townwork.net/' . $val->english_name . '/';
            phpQuery::newDocumentFile($url);
            if(pq(".areaSec")->text()){
                $part_num = pq(".btn-area-input")->count();
                for ($part_i=0;$part_i<$part_num;$part_i++){
                    //处理tab
                    $name = pq(".areaSec:eq(".$part_i.") > p:eq(0)")->text();
                    $res = City::where('name',$name)->where('parent_id',$val->id)->first();
                    if($res){
                        echo "<a style='color: red;'>----- -----".$name."已存在->跳过</a><br/>";
                        continue;
                    }
                    echo "----- -----".$name."√<br/>";
                    $city_m = new City();
                    $city_m->area_id = $val->area_id;
                    $city_m->parent_id = $val->id;
                    $city_m->name = $name;
                    $city_m->order_id = 0;
                    $city_m->save();
                    $pid = $city_m->id;
                    //处理列表
                    $cpart_num = pq("ul .small-area-lst:eq(".$part_i.") > li > a")->count();
                    for ($cpart_i=0;$cpart_i<$cpart_num;$cpart_i++) {
                        $name = pq("ul .small-area-lst:eq(".$part_i.") > li > a:eq(".$cpart_i.")")->text();
                        $res = City::where('name', $name)->where('parent_id', $pid)->first();
                        if ($res) {
                            echo "<a style='color: red;'>----- ----- -----".$name."已存在->跳过</a><br/>";
                            continue;
                        }
                        echo "----- ----- -----".$name."√<br/>";
                        $city_m = new City();
                        $city_m->area_id = $val->area_id;
                        $city_m->parent_id = $pid;
                        $city_m->name = $name;
                        $city_m->order_id = 0;
                        $city_m->save();
                    }
                }
            }else{
                $part_num = pq('.small-area-lst > li > a')->count();
                for ($part_i=0;$part_i<$part_num;$part_i++) {
                    //处理无tab
                    $name = pq(".small-area-lst > li > a:eq(" . $part_i . ")")->text();
                    $res = City::where('name',$name)->where('parent_id',$val->id)->first();
                    if($res){
                        echo "<a style='color: red;'>----- -----".$name."已存在->跳过</a><br/>";
                        continue;
                    }
                    echo "<a style='color: green'>----- -----" . $name . $val->id . "√</a><br/>";
                    $city_m = new City();
                    $city_m->area_id = $val->area_id;
                    $city_m->parent_id = $val->id;
                    $city_m->name = $name;
                    $city_m->order_id = 0;
                    $city_m->save();
                }
            }
            flush();
        }
    }
}
