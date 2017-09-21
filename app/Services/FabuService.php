<?php
namespace App\Services;

use App\Models\Web\Authorization;
use App\Repositories\City\CityRepository;

class FabuService
{

    protected $logic;
    public function __construct()
    {
        $this->logic = new Fabu_Logic($this->settings);
    }

    public function post() {
/*
 * 这三行放在控制器里面。
        if (!$visitor->id || !($visitor instanceof User)) return $this->showError('请先注册或登录后再发帖', $page);
        if (!$uuid) return $this->showError('请按正常流程发帖', $page);
        if ((!$city || !$category) && !$params->adId) return $this->showError('请先选择城市和类目', $page);
*/

        $_fabu_ = $this->logic;

        try {
            $unSavedAd = $_fabu_->buildAd();
        } catch (Exception $e) {
            $message = in_array($e->getCode(), array('422', '423')) ? $e->getMessage() : '发布错误';
            return $this->showError($message, $page);
        }

        //@todo 需要扔到前置的rule里，或者需要换一个关联的方式 by zhaojun
        if ($unSavedAd->categoryEnglishName == 'nvzhaonan') {
            foreach ($unSavedAd->recognizer()->mobiles() as $m) {
                if ($m != $visitor->mobile) return $this->showError('不允许发别人的手机', $page);
            }
        }

        $isBianji = (bool)$unSavedAd->id;
        try {
            $form = new Form();
            if (!$isBianji && $visitor->type != User::TYPE_SUPERMAN) $form->validate();
        } catch (Bad $bad) {
            AntispamLogger::log($unSavedAd, $bad->bangui, $bad->info);
            return $this->showError('请用正常的浏览器(开启Javascript)发布', $page);
        }

        //保存ad
        try {
            $ad = Fabu_Logic::saveAd($unSavedAd, $visitor);
            if ($isBianji && $unSavedAd->isOnService()) $_fabu_->suitServiceTo($unSavedAd);
        } catch (Exception $e) {
            Logger::error('post error', $e->getMessage(), 'zhaojun@baixing.com');
            return $this->showError('发布出错，请重新发布', $page);
        }

        new Rule();
        $ruleCollection = $isBianji ? new BianjiRuleCollection() : new AllRuleCollection();

        $ad->checkMe($ruleCollection);

        if (!$isBianji) {
            if (in_array($ad->get('cityEnglishName'), array('shanghai', 'beijing')) &&
                $ad->mobile() && $visitor->isMobileVerified() === false ) {
                Queue::create('DaoyongSmsQueue')->push(array('adId' => $ad->id));
            }
        }

        //统计手机用户的
        if (!$isBianji) $_fabu_->checkAndCountUser($params->username);

        new Action\PostAd($ad);
        //发布成功，跳走
        $redirectUrl = $_fabu_->getRedirectUrl($isBianji, $ad);
        return $this->redirect($redirectUrl);
    }
}