<?php
namespace App\Services;

use App\Models\Visitor;
use App\Models\Web\Authorization;
use App\Repositories\Category\CategoryRepository;

class CategoryService
{
    const LEVEL_CITY = 99;	//root
    const LEVEL_FIRST = 100;	//一级类目
    const LEVEL_SECOND = 101;	//二级类目

    private static $categoryPool = array();

    public $categoryObj;// 设置对象

    public function setCategoryObj($categoryObj) {
        $this->categoryObj = $categoryObj;
    }

    public function parent() {
        if ($this->categoryObj->level == self::LEVEL_CITY) {
            return null;
        }
        return CategoryRepository::find($this->categoryObj->parentEnglishName);
    }

    public function children() {
        if (empty($this->categoryObj->englishName)) {
            throw new Exception("Category English Name is empty!");
        }

        $children = CategoryRepository::findListOrder($this->categoryObj->englishName);// 根据儿子节点找到的数据，以orderid排序，返回列表，如果有缓存，先读缓存，此处列表必须做缓存 by曾科
        return $children;
    }

    public function tree($excludeRedirect = true) {
        if (empty($this->categoryObj->englishName)) {
            $this->categoryObj = CategoryRepository::find('root');
        }

        $rs['children'] = array();
        foreach ($this->categoryObj->children($excludeRedirect) as $fstObj) {
            foreach ($fstObj->children($excludeRedirect) as $secondObj) {
                $oo['children'][] = $secondObj;
            }
            $rs['children'][] = $oo;
        }
        return $rs;
    }

    public static function getFirstCategoryArray() {
        $firstRootObj = CategoryRepository::find('root');
        return $firstRootObj->children();

    }
}