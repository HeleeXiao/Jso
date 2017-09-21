<?php
namespace App\Services;

use App\Models\Visitor;
use App\Models\Web\Authorization;
use App\Repositories\City\CityRepository;

class FabuLogicService
{
    public static $imageLimit = 8;// 根据实际需求来调整，目前默认为8

    private static $recentAds = null;

    protected $params = array();

    public $user;

    public function __construct()
    {
        $this->user = Visitor::user();
    }

    public static function getRecentAttribute($ad, $attribute, $filterAttribute = null){
        if ($filterAttribute && !$ad->get($filterAttribute)) return;
        if ($ad && $ad->userId) {
            $userId = $ad->userId;
        } else {
            $user = Visitor::user();
            if (!$user) return null;
            $userId = $user->id;
        }
        $s = new ActiveSearcher(new Query('userId', $userId), array('rows' => 1, 'sort' => 'createdTime desc'));
        $recentAd = current($s->ads());
        if ($recentAd) return $recentAd->get($attribute);
        return null;
    }

    public static function saveAd($ad, $user) {
        if (is_null($ad)) return ;
        $isInsert = is_null($ad->id) ? true : false;
        $ad->title = preg_replace("/[\n\r]/", "", $ad->title);
        $ad->recalculate();
        $ad->save();
        AdPostLogger::log($ad->id, $isInsert ? AdPostLogger::TYPE_CREATE : AdPostLogger::TYPE_UPDATE);
        if (!$isInsert) AdLogger::log($user, $ad, null, null, null, AdLogger::TYPE_REEDIT);
        return $ad;
    }

    public function buildAd() { // 暂时不做

        return $ad;
    }

    private function getSource() {

    }

    public function getRedirectUrl($isBianji, $ad){

    }

    public function getCategoryMetaHtml($category, $ad, $city){

    }

    public function metaConfig($meta, $dataSource) {

    }

    private function att($city, $category, $ad) {

    }

    public function initData() {
        $ad = new Ad();
        if ($this->params->adId) {
            $ad = Api\Ad::loadAndCheck($this->params->adId, $this->visitor);
        } else {
            if ($this->uuid)
                $ad->set('uuid', $this->uuid);
            $user = $this->visitor;
            $ad->userId = ($user && $user->id) ? $user->id : null;
            $ad->insertedTime = time();
            $ad->id = 0;
            $city = $this->city;
            $category = $this->category;
            $ad->set('areaCityLevelId', $city->id);
            $ad->set('cityEnglishName', $city->englishName);
            $ad->set('categoryEnglishName', $category && $category->level == Category::LEVEL_SECOND ? $category->englishName : '');
            $ad->set('categoryFirstLevelEnglishName', $category ? ($category->level == Category::LEVEL_SECOND ? $category->parentEnglishName : $category->englishName) : '');
            $ad->set('faburen', self::getMostAttribute($ad, 'faburen', 'categoryEnglishName', 0.5, 1));

            if ($ad->get('categoryEnglishName')) {
                foreach ($ad->category()->metas() as $meta) {
                    if ($meta->name == 'faburen') continue;
                    if ($meta->remember) {
                        $mostAttribute = self::getRecentAttribute($ad, $meta->name);
                    } else {
                        $percent = 0.8;
                        $limit = (in_array($meta->name, array('具体地点', ''))) ? 1 : 3;
                        $mostAttribute = self::getMostAttribute($ad, $meta->name, 'categoryFirstLevelEnglishName', $percent, $limit);
                    }
                    if ($mostAttribute) $ad->set($meta->name, $mostAttribute);
                }
            }
        }
        foreach ($this->params as $k => $v) $ad->set($k, $v);
        return $ad;
    }

    public function chooseWhenDuplicated() {
        if ($this->params->cancel) {
            $this->deleteAdBySelf($this->ad, '重复');
        } elseif ($this->params->new) {
            new Rule();
            $r = new DuplicatedRule();
            $this->deleteCauseAds($r->getDuplicatedAds($this->ad), '重复', $this->ad->id);
            $this->recoverAd($this->ad, array('DuplicatedRule'));
        }
    }

    public function checkAndCountUser($mobile) {
        $user = $this->visitor;
        if ($user && !$user->isMobileVerified()) InstantCounter::count("用户没绑定手机号码");
    }

    private function recoverAd($ad, $ignoreRules) {
        $causeAds = $ad->get('causeAds');
        Bangui::excute('直接发布', $ad, '机器人瓦力');
        $ad->save();

        sleep(1);

        $rule = new BianjiRuleCollection();
        $rule->ignore($ignoreRules);
        $ad->checkMe($rule);
    }

    private function deleteCauseAds($ads, $cause, $currentAdId) {
        $u = new User();
        $u->nickname = '机器人瓦力';
        $mallet = current($u->find());
        if (!$mallet) return;
        foreach ($ads as $a) {
            $_ad_ = new Ad();
            $_ad_->load($a->id);
            if ($_ad_->isOnService()) continue;
            AdLogger::log($mallet, $_ad_, $_ad_->status, Ad::STATUS_DELETED_BY_SELF, $cause, AdLogger::TYPE_DELETE_BY_SELF, 'adId => ' . $currentAdId);
            $_ad_->set('lastOperation', '用户删除-' . $cause);
            $_ad_->status = Ad::STATUS_DELETED_BY_SELF;
            $_ad_->save();
        }
    }

    private function deleteAdBySelf($ad, $cause) {
        $ad->status = Ad::STATUS_DELETED_BY_SELF;
        $ad->set('lastOperation', '用户放弃-' .  $cause);
        $ad->save();
    }

    private function getCategoryDailyPostCount($ad, $isPort = false) {
        if(date('Ymd', time()) != date('Ymd', $ad->insertedTime)) return;
        if(!$ad->categoryEnglishName) return;
        $days = 1;
        if ($ad->get('categoryEnglishName') == 'chongwulingyang') $days = 7;
        $filter = new AndFilter(
            new ExceptFilter('id', $ad->id),
            new AttributeFilter('cityEnglishName', $ad->get('cityEnglishName')),
            new CalendarDateFilter($days)
        );
        if ($isPort) {
            $filter->add(new AttributeFilter('userId', $ad->userId));
            $filter->add(new AttributeFilter('categoryFirstLevelEnglishName', $ad->get('categoryFirstLevelEnglishName')));
            $searcher = new Searcher($filter, array('waitSuccess', true));
            $ads = $searcher->ads();
        } else {
            $filter->add(new AttributeFilter('categoryEnglishName', $ad->categoryEnglishName));
            $ads = $ad->cloud(60)->ads($filter, 10);
            if ($ad->get('categoryEnglishName') == 'ktvjiuba') $ads = array_merge($ads, $ad->cloud(60)->wide($filter, 10));
        }
        $exceptStatus = array(Ad::STATUS_PENDING, Ad::STATUS_DELETED_BY_SELF);
        foreach ($ads as $k => $o) if (in_array($o->status, $exceptStatus)) unset($ads[$k]);
        return count($ads);
    }

    private function metaScript($category = null) {
        $scriptContent = "<script>";
        if ($category->englishName == "ktvjiuba") $scriptContent .= "$('#imgupload').hide();";
        else $scriptContent .= "$('#imgupload').show();";
        $scriptContent .= "</script>";
        return $scriptContent;
    }

    private function getCategoryLimit($ad) {
        new Rule();
        $ad2 = clone $ad;
        $ruleForCategory = new CategoryLimitRule();
        $limit = array();
        $ad2->setPosterType('商家');
        $limit['商家'] = $ruleForCategory->limit($ad2);

        $limit[] = $limit['中介'] = $limit['商家'];
        $ad2->setPosterType('个人');
        $limit['个人'] = $ruleForCategory->limit($ad2);
        $limit['isPort'] = ($ruleForCategory->bangui == "端口超限删除" ? 1 : 0);
        return $limit;
    }

    public static function usedCategory($ad) {
        $facet = new Facet($ad->cloud()->ads(new Filter(new NotAdIdFilter($ad->id),new CalendarDateFilter(30))));
        $cates = $facet->get('categoryEnglishName');
        arsort($cates);
        $arr = array();
        foreach (array_keys(array_slice($cates, 0, 6)) as $categoryEnglishName) {
            $arr[] = Category::loadByName($categoryEnglishName);
        }
        return $arr;
    }
}