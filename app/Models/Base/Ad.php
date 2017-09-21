<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

/**
 * @Class Ad
 * @package App\Models\Base
 * @User: ???@jtrips.com
 * @property string $id 文章
 * @property string $title 文章标题
 * @property string $categoryNames 分类名称 : [待定]
 * @property string $categoryEnglishNames 分类名称 : [待定]
 * @property string $areaNames 区域名集合
 * @property string $userId 用户id
 * @property string $description 内容
 * @property string $attr 邮箱
 * @property string $userIp 用户发帖ip
 * @property string $areaCityLevelId 区域层级id
 * @property string $areaFirstLevelId 区域第一级id
 * @property string $areaSecondLevelId 区域第二级id
 * @property string $status 状态 [暂缺详细说明]
 * @property string $imageFlag 图片地址
 * @property string $masterNickName 发布者
 * @property string $jobName 职位名称
 * @property string $jobRequirements 任职要求
 * @property string $workYears 任职要求
 * @property string $treatmentWxyj 五险一金
 * @property string $treatmentBc 包吃
 * @property string $treatmentBz 包住
 * @property string $createdAt 
 * @property string $updatedAt 
 *
 */

class Ad extends Model
{
    use Eloquence, Mappable;

    protected $table = 'ad';

    protected $maps = [
//        'title'          => 'title',          //文章标题
        'categoryNames'  => 'category_names', //分类名称 : [待定]
        'categoryEnglishNames'=> 'category_english_names',//分类名称 : [待定]
        'areaNames'      => 'area_names',     //区域名集合
        'userId'         => 'user_id',        //用户id
//        'description'    => 'description',    //内容
//        'attr'           => 'attr',           //邮箱
        'userIp'         => 'user_ip',        //用户发帖ip
        'areaCityLevelId'=> 'area_city_level_id',//区域层级id
        'areaFirstLevelId'=> 'area_first_level_id',//区域第一级id
        'areaSecondLevelId'=> 'area_second_level_id',//区域第二级id
//        'status'         => 'status',         //状态 [暂缺详细说明]
        'imageFlag'      => 'image_flag',     //图片地址
        'masterNickName' => 'master_nick_name',//发布者
        'comName' => 'com_name',//职位名称
        'jobName' => 'job_name',//职位名称
        'jobRequirements' => 'job_requirements', //任职要求
        'workYears' => 'work_years', //任职要求
        'treatmentWxyj' => 'treatment_wxyj', //五险一金
        'treatmentBc' => 'treatment_bc', //包吃
        'treatmentBz' => 'treatment_bz', //包住
        'treatmentZmsx' => 'treatment_zmsx', //周末双休
        'treatmentNdsx' => 'treatment_ndsx', //年底双薪
    ];

    const STATUS_ACTIVE = 0; //正常
    const STATUS_DELETED_BY_SELF = 3; //自己删除
    const STATUS_SUSPENDED = 4; //无法显示
    const STATUS_PENDING = 20; //延迟发布

    protected static $statusList = array(
        Ad::STATUS_ACTIVE => '正常', // 后面修改成语言包
        Ad::STATUS_SUSPENDED => '无法显示',
        Ad::STATUS_DELETED_BY_SELF => '自已删除',
        Ad::STATUS_PENDING => '延迟发布',
    );


//    public function save($flag = false) {
//        if (mb_strlen($this->title) > 25) $this->title = mb_substr($this->title, 0, 25);
//        db::save();// 新增和插入记得判断
//        Queue::create("ESPostQueue")->push($this->id); // 把该条数据放入ES队列中
//        return $this;
//    }


}