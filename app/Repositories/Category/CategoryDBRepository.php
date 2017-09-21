<?php
/**
 * auto create file for commands
 */
namespace App\Repositories\Category;

use App\Models\Base\Category;
use App\Repositories\BaseRepository;
use App\Traits\RepositoryDBTrait;

/**
 * Class CategoryDBRepository
 * @package App\Repositories\Category
 */
class CategoryDBRepository extends BaseRepository implements CategoryRepository
{
    use RepositoryDBTrait;

    /**
     * @var string
     */
    protected $model = Category::class;

    const LEVEL_CITY = 99;	//root
    const LEVEL_FIRST = 100;	//一级类目
    const LEVEL_SECOND = 101;	//二级类目

    public function parent() {
        if ($this->level == self::LEVEL_CITY) { //如果到达顶端 返回null
            return null;
        }
        $parent = new Category();
        return $parent->load($this->parentEnglishName);
    }

    public function children($excludeRedirect = true) {
        if (empty($this->englishName)) {
            throw new Exception("Category English Name is empty!");
        }

        $obj = new Category();
        $obj->parentEnglishName = $this->englishName;
        $options = array('order' => array('orderId' => 'ASC'));
        $children = array();
        foreach ($obj->find($options) as $obj) { // 获取所有的资源数
            if (!empty($obj->name)) {
                $children[] = $obj;
            }
        }
        return $children;
    }

    public function tree($excludeRedirect = true) {
        $allows = array(
            'parentEnglishName' => 'parentEnglishName',
            'name' => 'name',
            'shortname' => 'shortname',
            'englishName' => 'englishName',
            'level' => 'level',
            'createdTime' => 'createdTime',
            'displayOrder' => 'orderId',
            'redirect' => 'redirect',
            'style' => 'style',
            'strong' => 'strong',
            'segment' => 'segment',
        );
        $rtn = array();
        foreach ($allows as $key => $col) {
            $rtn[$key] = $this->get($col);
        }
        $rtn['children'] = array();
        foreach ($this->children($excludeRedirect) as $fstObj) {
            $oo = array();
            foreach ($allows as $key => $col) {
                $oo[$key] = $fstObj->get($col);
            }
            $oo['children'] = array();
            foreach ($fstObj->children($excludeRedirect) as $sndObj) {
                $ooo = array();
                foreach ($allows as $key => $col) {
                    $ooo[$key] = $sndObj->get($col);
                }
                $oo['children'][] = $ooo;
            }
            $rtn['children'][] = $oo;
        }
        return $rtn;
    }

    /**
     *@return Category
     */
    public static function loadByName($englishName, $refresh = false) {
        if (!isset(self::$categoryPool[$englishName]) || $refresh) {
            $category = new Category();
            self::$categoryPool[$englishName] = $category->load($englishName);
        }
        return self::$categoryPool[$englishName];
    }

    public static function getFirstCategoryArray() {
        $category = new Category();
        $category->load('root');
        return $category->children();
    }





}