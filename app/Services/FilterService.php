<?php
// 暂时不做，是自动化审核的东西
namespace App\Services;

use App\Models\Web\Authorization;

class FilterService
{

}

class Filter extends AndQuery {}
class FilterCollection extends Filter {}
class AndFilter extends Filter {}
class OrFilter extends OrQuery {}
class InFilter extends InQuery {}
class AttributeFilter extends Query {}
class TrueFilter extends TrueQuery {}
class ExceptFilter extends Query {
    public function accept($ad) {
        return !parent::accept($ad);
    }

    public function  __toString() {
        return '-'.parent::__toString();
    }
}

class RangeFilter extends RangeQuery {
    protected $isInt = false;
    public function __construct($field, $value, $value2 = false) {
        if (strpos($field, '_i')) $this->isInt = true;

        $this->field = $field;
        $this->value = $value;
        if ($value2 !== false) {
            $this->lower = $value;
            $this->upper = $value2;
        } else {
            @list($lower, $upper) = explode(',', $value);
            if (!$this->isInt || is_numeric($lower)) $this->lower = $lower;
            if (!$this->isInt || is_numeric($upper)) $this->upper = $upper;
        }
    }

    public function accept($ad) {
        $value = $ad->get(str_replace('_i', '', $this->field));
        if ($this->isInt) $value = intval($value);
        return ( (($this->upper === null) ? true : ($value <= $this->upper))
            && (($this->lower === null) ? true : ($value >= $this->lower)) );
    }
}

class StatRangeFilter extends RangeFilter { //根据统计数据过滤
    public function __construct($field, $value, $value2 = false) {
        $this->field = $field;
        $this->value = $value;
        $this->rangeFactor = 0.2;
        if ($value2 !== false) {
            $this->rangeFactor = $value2;
        }
        $this->lower = $value;
        $this->upper = $value * $this->rangeFactor;
    }

    public function accept($ad) {
        $value = $ad->get(str_replace('_i', '', $this->field));
        if ($this->isInt) $value = intval($value);
        return ( (($this->upper === null) ? true : ($value <= $this->upper))
            && (($this->lower === null) ? true : ($value >= $this->lower)) );
    }
}

class ExistFilter extends AttributeFilter {
    public function accept($ad) {
        return ($ad->get($this->field) !== false);
    }

    public function __toString() {
        return "{$this->field}:[* TO *]";
    }
}

class ReverseFilter extends AndQuery {
    public function __toString() {
        return '-' . parent::__toString();
    }

    public function accept($ad) {
        return !parent::accept($ad);
    }
}

class KeywordFilter extends AttributeFilter {
    public static $matchKeyword = array();

    public function __construct($field, $value) {
        $this->field = $field;
        $this->value = $value;
        if ($this->value == '') throw new Exception(get_class($this) . " {$field} :  has no value");
    }

    public function __toString() {
        return $this->block(str_replace(' ', ' OR ', $this->value));
    }

    public function accept($ad) {
        $stringForCheck = strtolower($this->field ? $ad->get($this->field) : $ad->content());
        foreach (explode(' ', strtolower($this->value)) as $keyword) {
            if ($keyword == '' || strpos($stringForCheck, $keyword) === false) continue;
            if (!in_array($keyword, self::$matchKeyword)) self::$matchKeyword[] = $keyword;
            return true;
        }
        return false;
    }
}

class TagFilter extends Query {
    public function accept($ad) {
        return in_array($this->value, explode(' ', $ad->get($this->field)));
    }
}

class ContactFilter extends RangeFilter {
    public function accept($ad) {
        if (!in_array($this->field, array('qq', 'contacts', 'mobiles', 'telephones', 'urls', 'numbers', 'emails', 'fingers', 'fingerQQ'))) return false;
        foreach($ad->recognizer()->{$this->field}() as $contact) {
            if ('*' == $this->value) return true;
            if ((($this->upper === null) ? true : ($contact <= $this->upper)) && (($this->lower === null) ? true : ($contact >= $this->lower))) return true;
        }
        return false;
    }
}

class UniqueContactFilter extends RangeFilter {
    public function accept($ad) {
        if (!in_array($this->field, array('qq', 'mobiles', 'urls', 'emails'))) return false;
        foreach (array('qq', 'mobiles', 'urls', 'emails') as $regFunc) {
            if (count($ad->recognizer()->$regFunc()) && $this->field != $regFunc) return false;
        }
        return count($ad->recognizer()->{$this->field}()) > 0;
    }
}

class ActiveFilter extends AttributeFilter {
    public function __construct() {
        parent::__construct('status', Ad::STATUS_ACTIVE);
    }
}

class DateFilter extends AttributeFilter {
    private function daytotime($day) {
        return strtotime(date("Y-m-d", time() - 86400 * ($day - 1)) . ' 00:00:00');
    }

    public function accept($ad) {
        return $ad->get($this->field) >= $this->daytotime($this->value);
    }

    public function __toString() {
        $solrTime = date("Y-m-d\TH:i:s\Z", $this->daytotime($this->value));
        return "{$this->field}:[{$solrTime} TO *]";
    }
}

class AttributeExFilter extends AttributeFilter{ //加强版/如果属性不存在,则尝试通过调用同名方法获得对象比如user,
    public function accept($ad) {
        if($ad->get($this->field)){
            return $ad->get($this->field) == $this->value;
        }else{
            $arr = explode('.', $this->field);
            if(is_array($arr) && count($arr)>1 && method_exists($ad, $arr[0])){
                $o = $ad->$arr[0]();
                return $o->get($arr[1]) == $this->value;
            }else{
                return false;
            }
        }
    }

    public function __toString() {
        return " OR {$this->field}:[* TO *]";
    }
}

class CalendarDateFilter extends DateFilter {
    public function __construct($day = 1) {
        parent::__construct('insertedTime', $day);
    }
}

class NotBlockDeletedFilter extends ReverseFilter {
    public function __construct() {
        $this->add(new AttributeFilter('masterNickname', '机器人瓦力'));
        $this->add(new AttributeFilter('status', Ad::STATUS_SUSPENDED));
    }
}

class CmBadFilter extends Filter {
    public function __construct() {
        $cmBanguis = array(
            //'超限删除',
            '多城市发布',
            '累计重复删除',
            '不适合百姓网',
            '评论信息',
            '错类删除',
            '色情低俗'
        );
        $this->add(new InQuery('lastOperation', $cmBanguis));
    }
}

class TnsBadFilter extends InQuery {
    public function __construct() {
        parent::__construct('lastOperation', array_keys(Bangui::$banBangui));
    }
}

class NotSelfDeletedFilter extends ExceptFilter {
    public function __construct() {
        parent::__construct('status', Ad::STATUS_DELETED_BY_SELF);
    }
}

class NotAdIdFilter extends ExceptFilter {
    public function __construct($adId) {
        parent::__construct('id', $adId);
    }
}

class CloudFacetFilter extends RangeFilter {
    protected $func = 'ads';
    protected $ad;
    public $filter = null;
    public function __construct($field, $value, $filter = null) {
        $this->filter = $filter;
        parent::__construct($field, $value);
    }

    protected function parseFilter($filter) {
        if (!$filter) return;
        if (isset($filter->children) && count($filter->children) > 0) {
            foreach ($filter->children as $child) $this->parseFilter($child);
        } else {
            if (substr($filter->value, 0, 1) == '#') $filter->value = $this->ad->get(substr($filter->value, 1));
        }
    }

    protected function facet() {
        return new Facet($this->ad->cloud(60)->{$this->func}($this->filter));
    }

    protected function value() {
        $arr = $this->facet()->get($this->field);
        if (isset($arr['0'])) unset($arr['0']);
        if (isset($arr[0])) unset($arr[0]);
        return count($arr);
    }

    public function accept($ad) {
        $this->ad = $ad;
        $this->parseFilter($this->filter);
        return ( (($this->upper === null) ? true : ($this->value() <= $this->upper))
            && (($this->lower === null) ? true : ($this->value() >= $this->lower)) );
    }

    public function __toString() {
        return get_class($this) . "({$this->field}: {$this->value}, {$this->filter})";
    }
}

class WideFacetFilter extends CloudFacetFilter {
    protected $func = 'wide';
}

class SuperFacetFilter extends CloudFacetFilter {
    protected $func = 'superdeep';
}

class CloudCountFilter extends CloudFacetFilter {
    protected function value() {
        $limit = is_numeric($this->upper) ? $this->upper + 1 : null;
        if (!$limit) $limit = is_numeric($this->lower) ? $this->lower : null;
        return is_numeric($limit) ? count($this->ad->cloud(60)->{$this->func}($this->filter, $limit)) : $this->facet()->total();
    }
}

class WideCountFilter extends CloudCountFilter {
    protected $func = 'wide';
}

class SuperCountFilter extends CloudCountFilter {
    protected $func = 'superdeep';
}

class CloudPercentFilter extends CloudFacetFilter {
    protected function value() {
        $param = explode(',', $this->field);
        return $this->facet()->percent($param[0], $param[1]);
    }
}

class WidePercentFilter extends CloudPercentFilter {
    protected $func = 'wide';
}

class SuperPercentFilter extends CloudPercentFilter {
    protected $func = 'superdeep';
}

class UserFilter extends AttributeFilter{
    public function __construct($field,$value) {
        $this->field = $field;
        $this->value = $value;
    }

    public function accept($ad) {
        $user = new User();
        $user->load($ad->userId);
        $ad->set('user.'.$this->field,$this->value);
        return $user->get($this->field) == $this->value;
    }

    public function __toString() {
        return "user.{$this->field}:({$this->value})";
    }
}
class ObjectFilter extends AttributeFilter{
    private $childValues = array();
    private $values = array();
    private $objectType = null;
    public function __construct($field,$value) {
        $this->field = $field;
        $this->value = $value;
        $this->objectType = Type::get($this->field);
        $this->values = explode(' ',$this->value);
        foreach ($this->values as $v){
            if (preg_match("/^m[0-9]+/", $v)) {
                $object = Data::loadObj($v);
                $this->collectValues($object);
            }else{
                $query = new AndQuery(
                    new Query('name', $v)
                );
                $objects = Data::find(null, $query) ?: array();
                foreach($objects as $object)
                    $this->collectValues($object);
            }
        }
    }
    private function collectValues($object){
        if($object) $this->childValues[]  = "{$object->id}";
        else return;
        if(!$object->children) return;
        foreach ($object->children as $ch){
            if($ch->children){
                $this->collectValues($ch);
            }
        }
    }
    public function accept($ad) {
        $f = $this->field;
        if(!$ad->get($f)) return false;
        foreach ($this->childValues as $ch){
            if($ad->get($f) == $ch ) return true;
        }

        return false;
    }
    public function __toString() {
        $str = implode(' OR ',$this->childValues);
        $str = "{$this->field}:($str)";
        return $str;
    }
}

class SimilarFilter extends Query {
    protected $ad;
    protected $titleSimilarPercent = 70;
    protected $contentSimilarPercent = 70;
    private $biaoDianArray = array(
        ',', '.', '/', '`', '-', '=', '[', ']', '\\', ';', '\'',
        '~', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')',
        '_', '+', '{', '}', '|', ':', '"', '<', '>', '?', '，',
        '。', '？', '！', '～', '＠', '￥', '（', '）', '“', '”', '：',
        '《', '》', '；', '‘', '’', '、', '｜', '］', '［', '｛', '｝',
        '＃', '｀', '％', '……', '＆', '＊', '－', '＝', '／', '＋',' ', "\r", "\n", "\t", '　', ' '
    );

    public function __construct($ad) {
        $this->ad = $ad;
    }

    private function intersect($str1, $str2) {
        $cncharnum1 = preg_match_all("/([" . chr(228) . "-" . chr(233) . "]{1}[" . chr(128) . "-" . chr(191) . "]{1}[" . chr(128) . "-" . chr(191) . "]{1}){1}/", $str1, $zharr1);
        $ennum1 = preg_match_all("/[0-9a-zA-Z]+/", $str1, $enarr1);
        $newArray1 = array_merge($zharr1[0],$enarr1[0]);

        $cncharnum2 = preg_match_all("/([" . chr(228) . "-" . chr(233) . "]{1}[" . chr(128) . "-" . chr(191) . "]{1}[" . chr(128) . "-" . chr(191) . "]{1}){1}/", $str2, $zharr2);
        $ennum2 = preg_match_all("/[0-9a-zA-Z]+/", $str2, $enarr2);
        $newArray2 = array_merge($zharr2[0], $enarr2[0]);

        $num1 = count($newArray1);
        $num2 = count($newArray2);
        $num = $num1 > $num2 ? $num1 : $num2;

        $result = array_intersect($newArray1, $newArray2);

        $va = $num == 0 ? 100 : (count($result) / $num * 100);

        return intval($va);
    }

    protected function titleSimilar($str1, $str2) {
        $str1 = str_replace($this->biaoDianArray, '', $str1);
        $str2 = str_replace($this->biaoDianArray, '', $str2);
        return $this->intersect($str1, $str2) > $this->titleSimilarPercent;
    }

    protected function contentSimilar($str1, $str2) {
        return $this->intersect($str1, $str2) > $this->contentSimilarPercent;
    }

    public function accept($o) {
        if($this->ad->id == $o->id) return false;
        $ad_text = $this->generateCompareContent($this->ad);
        $o_text = $this->generateCompareContent($o);
        return $this->titleSimilar($this->ad->title, $o->title) || $this->contentSimilar($ad_text, $o_text);
    }

    protected function generateCompareContent($o) {
        return $o->content(array('具体地点', 'faburen')) . ' ' . str_replace('.jpg', '', join(' ', $o->images()));
    }
}

class FangSimilarFilter extends SimilarFilter {
    protected $attris = array();
    protected $titleSimilarPercent = 80;
    protected $contentSimilarPercent = 90;
    protected $defaultNoSimilar = 2;
    protected function generateCompareContent($o) {
        $content = '';
        foreach ($o->category()->metas() as $key => $meta) {
            if (!in_array($key, array('faburen', '房屋配置'))) $content .= $o->get($key);
        }
        return $content . ' ' . str_replace('.jpg', '', join(' ', $o->images()));
    }

    public function accept($o) {
        if($this->ad->id == $o->id) return false;
        if (empty($this->attris)) return parent::accept ($o);
        $noSimilarAttriCount = 0;
        foreach ($this->attris as $k) {
            if (strlen($this->ad->get($k)) == 0 || strlen($o->get($k)) == 0 || $this->ad->get($k) != $o->get($k)) $noSimilarAttriCount++;
        }
        return !($noSimilarAttriCount >= $this->defaultNoSimilar);
    }

    public function isPort() {
        if ($this->ad && $this->ad->userId) {
            try {
                $user = new User();
                $user->load($this->ad->userId);
                return ($user->isOnService('port'));
            } catch (Exception $e) {}
        }
        return false;
    }
}

class ErshouFangSimilarFilter extends FangSimilarFilter {
    protected $attris = array('具体地点', '面积', '楼层', '价格');
    public function accept($o) {
        if ($this->isPort()) $this->defaultNoSimilar = 1;
        return parent::accept($o);
    }
}

class XinFangSimilarFilter extends ErshouFangSimilarFilter {
    public $nullNoSimilar = false;
    public function accept($o) {
        if($this->ad->id == $o->id) return false;
        $noSimilarAttriCount = 0;
        foreach ($this->attris as $k) {
            if ((strlen($this->ad->get($k)) == 0 || strlen($o->get($k)) == 0) && $this->nullNoSimilar) $noSimilarAttriCount++;
            if ($this->ad->get($k) == $o->get($k)) continue;
            if (in_array($k, array('面积', '价格'))) {
                $f = new NumricFilter($k, floatval($this->ad->get($k)), floatval($this->ad->get($k)));
                if (!$f->accept($o)) $noSimilarAttriCount++;
            } else $noSimilarAttriCount++;
        }
        return !($noSimilarAttriCount >= $this->defaultNoSimilar);
    }
}

class ZuFangSimilarFilter extends XinFangSimilarFilter {
    public $nullNoSimilar = true;
    protected $attris = array('具体地点', '租用面积', '楼层情况', '价格');
}

class CheSimilarFilter extends SimilarFilter {
    public function accept($o) {
        if($this->ad->id == $o->id) return false;
        foreach (array('品牌', '类型') as $name) {
            if (!($this->ad->get($name) && $o->get($name))) continue;
            $ad_tags = array_filter(explode(' ', $this->ad->get($name)));
            $o_tags = array_filter(explode(' ', $o->get($name)));
            if (count(array_diff($ad_tags, $o_tags)) == 0 && count(array_diff($o_tags, $ad_tags)) == 0) return parent::accept ($o);
            else return false;
        }
        return parent::accept($o);
    }
}

class ErshouQicheSimilarFilter extends SimilarFilter {
    public function accept($o) {
        if($this->ad->id == $o->id) return false;
        foreach (array('年份','车品牌') as $name) {
            if ($this->ad->get($name) && $o->get($name) && $this->ad->get($name) != $o->get($name)) {
                return false;
            }
        }
        return parent::accept($o);
    }
}

class JinengPeixunSimilarFilter extends SimilarFilter {
    protected $contentSimilarPercent = 80;
}

class ErshouSimilarFilter extends SimilarFilter {
    protected $titleSimilarPercent = 90;
    protected $contentSimilarPercent = 90;
}

class GongzuoSimilarFilter extends SimilarFilter {
    protected $contentSimilarPercent = 90;
    public function accept($o) {
        if($this->ad->id == $o->id) return false;
        $user = $this->ad->user();

        if($user && $user->userPortType() == 'jobPort'){
            $name = 'areaNames' ; //招聘端口用户如果地区不同则跳过内容判断
            if ($this->ad->get($name) && $o->get($name) && $this->ad->get($name) != $o->get($name)) {
                return false;
            }
        }
        return parent::accept($o);
    }
}

class GongrenSimilarFilter extends GongzuoSimilarFilter {
    public function accept($o) {
        if($this->ad->id == $o->id) return false;
        $name = '分类';
        if (!($this->ad->get($name) && $o->get($name))) return parent::accept($o);
        $ad_tags = array_filter(explode(' ', $this->ad->get($name)));
        $o_tags = array_filter(explode(' ', $o->get($name)));
        if (count(array_diff($ad_tags, $o_tags)) == 0 && count(array_diff($o_tags, $ad_tags)) == 0) return parent::accept ($o);
        else return false;
    }
}

class NumricFilter extends RangeFilter {
    function accept($ad) {
        return ( (($this->upper === null) ? true : (floatval($ad->get($this->field)) <= $this->upper))
            && (($this->lower === null) ? true : (floatval($ad->get($this->field)) >= $this->lower)));
    }

    function  __toString() {
        return "{$this->field}_i:[{$this->format($this->lower)} TO {$this->format($this->upper)}]";
    }

    function format($v) {
        return ($v === null || $v == '*') ? '*' : intval($v);
    }
}

class RegExpFilter extends Filter{ //正则匹配filter
    public function __construct($field,$value) {
        $this->field = $field;
        $this->value = $value;
    }

    public function accept($ad) {
        $attValue = $ad->get($this->field);
        return preg_match($this->value,$attValue);
    }

    public function __toString() {
        return "";
    }
}