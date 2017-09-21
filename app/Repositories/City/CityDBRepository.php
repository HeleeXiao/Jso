<?php
/**
 * auto create file for commands
 */
namespace App\Repositories\City;

use App\Models\Base\City;
use App\Repositories\BaseRepository;
use App\Traits\RepositoryDBTrait;

/**
 * Class CityDBRepository
 * @package App\Repositories\City
 */
class CityDBRepository extends BaseRepository implements CityRepository
{
    use RepositoryDBTrait;

    /**
     * @var string
     */
    protected $model = City::class;

    /**
     * 根据city english name 获取数据，city的key默认为englishName
     * @param $englishName
     * @return City|null
     */
    public static function loadByName($englishName) {
        $city = '';
        return $city;
    }

    public static function getCities() {
        $cityArray = array();
        $city = new City();
        $options = array('order' => array('orderId' => 'ASC'));
        $cities = $city->find($options);
        foreach ($cities as $c) {
            $_city = array();
            $_city['englishName'] = $c->englishName;
            $_city['name'] = $c->name;
            $_city['sheng'] = $c->sheng;
            $cityArray[$c->id] = $_city;
        }


        return $cityArray;
    }

    public static function getAreas($englishName, $level = Area::LEVEL_FIRST) {

        return $areas;
    }

    public static function getShengs() {
        $shengs = array();
        foreach (City::getCities() as $o)
            $shengs[$o['sheng']] = 1;
        return array_keys($shengs);
    }



}