<?php

namespace App\Repositories\Ad;


use App\Models\Base\Ad;

/**
 * Interface AdRepository
 * @package  App\Repositories\Ad
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
 * @property string $createdAt 
 * @property string $updatedAt 
 */

interface AdRepository
{
    /**
     * @param int $id
     *
     * @return Ad
     */
    public function find($id);

    /**
     *
     * @return bool
     */
    public function save();

    /**
     * @return $this
     */
    public function write();

    /**
     * @return Ad
     */
    public function getCurrentInstance();

    public function init();

}