<?php
namespace App\Services;

use App\Models\Web\Area;
use App\Models\Web\Authorization;
use App\Repositories\City\CityRepository;

class CityService
{
    public function __construct()
    {

    }

    public static function getCities() {
        $cacheId = "cities";
        $cache = new CacheManager('City');//本地寄存器，另外计算，看laravel是怎么实现的 by zengke
        $cityArray = $cache->get($cacheid);

        if ($cityArray === false) {
            $cityArray = array();
            $city = new City();
            $options = array('order' => array('orderId' => 'ASC'));
            $cities = $city->find($options);
            foreach ($cities as $c) {
                $cityTmp = array();
                $cityTmp['englishName'] = $c->englishName;
                $cityTmp['name'] = $c->name;
                $cityTmp['sheng'] = $c->sheng;
                $cityArray[$c->id] = $cityTmp;
            }
            $cache->set($cacheid, $cityArray);
        }
        return $cityArray;
    }

    public static function getAreas($englishName, $level = Area::LEVEL_FIRST) {
        if (empty($englishName)) return null;

        $cacheId = $englishName.'_areas_' . $level;
        $cache = new CacheManager('City');//本地寄存器
        if (($areas = $cache->get($cacheId)) !== false) return unserialize($areas);

        $areas = AreaRepo::findList();

        /*
        areas 逻辑
        $options = array('order' => array('orderId' => 'ASC'));
        foreach ($a->find($options) as $o) {
            if (empty($o->name)) continue;
            if ($level == Area::LEVEL_FIRST) {
                $areas[] = $o;
            } else {
                $areas[$o->pid][] = $o;
            }
        }*/

        $cache->set($cacheId, serialize($areas));

        return $areas;
    }

    public static function getShengs() {

    }

    public function getAroundCities() {

    }
}