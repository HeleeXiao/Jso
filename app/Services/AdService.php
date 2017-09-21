<?php
namespace App\Services;

use App\Models\Base\Ad;
use App\Models\ErrorCode;
use App\Models\Ret;
use App\Repositories\Ad\AdRepository;
use Illuminate\Support\Facades\Validator;

class AdService
{
    private $request;
    public function __construct()
    {
        $this->request = \Illuminate\Support\Facades\Request::all();
    }
    public function uploadpic( $filename)
    {

    }

    public function store(){
        $obj = app(AdRepository::class);
        $obj->title = $this->request['title']; //TODO
        $obj->categoryNames = 1;
        $obj->categoryEnglishNames = 1;
        $obj->areaNames = 1;
        $obj->userId = 1;
        $obj->areaCityLevelId = 11;
        $obj->areaFirstLevelId = 12;
        $obj->areaSecondLevelId = 13;
        $obj->status = 8;
        $obj->imageFlag = 9;
        $obj->masterNickName = 10;

        $obj->user_ip = $_SERVER["REMOTE_ADDR"];
        $obj->comName = $this->request['com_name'];
        $obj->jobName = $this->request['job_type'];
        $obj->com_type = $this->request['com_type'];
        $obj->com_industry = $this->request['com_industry'];
        $obj->job_type = $this->request['job_type'];
        $obj->com_persons = $this->request['com_persons'];
        $obj->com_url = $this->request['com_url'];
        $obj->com_profile = $this->request['com_profile'];
        $obj->areaCityLevelId = $this->request['area_city_level_id'];
        $obj->areaFirstLevelId = $this->request['area_first_level_id'];
        $obj->num = $this->request['num'];
        $obj->tel_secrecy = empty($this->request['tel_secrecy'])?0:1;
//        $obj->ed = $this->request['ed'];
//        $obj->workYears = $this->request['work_years'];
//        $obj->money = $this->request['money'];
//        $obj->jobRequirements = $this->request['job_requirements'];
//        $obj->description = $this->request['description'];
//        if(!empty($this->request['treatment'])){
//            foreach ($this->request['treatment'] as $val){
//                $str = "treatment".ucfirst($val);
//                $obj->$str = 1;
//            }
//        }

        $obj->contacts = $this->request['contacts'];
        $obj->tel1 = $this->request['tel1'];
        $obj->email = $this->request['email'];
        $obj->address = $this->request['address'];
//        $obj->picurl = $this->request['picurl'];
        return $obj->save();
    }

    public function update(){
        $validator = $this->checkParameter();
        if($validator === 1){
        }else{
            return redirect()->back()->withErrors($validator);
        }
        $inter = app(AdRepository::class);
        $obj = $inter->find($this->request['id']);
        $obj->title = $this->request['job_type']; //TODO
        $obj->categoryNames = 2;
        $obj->categoryEnglishNames = 2;
        $obj->areaNames = 2;
        $obj->userId = 2;
        $obj->areaCityLevelId = 11;
        $obj->areaFirstLevelId = 12;
        $obj->areaSecondLevelId = 13;
        $obj->status = 8;
        $obj->imageFlag = 9;
        $obj->masterNickName = 10;

        $obj->user_ip = $_SERVER["REMOTE_ADDR"];
        $obj->comName = $this->request['com_name'];
        $obj->jobName = $this->request['job_type'];
        $obj->com_type = $this->request['com_type'];
        $obj->com_industry = $this->request['com_industry'];
        $obj->job_type = $this->request['job_type'];
        $obj->com_persons = $this->request['com_persons'];
        $obj->com_url = $this->request['com_url'];
        $obj->areaCityLevelId = $this->request['area_city_level_id'];
        $obj->areaFirstLevelId = $this->request['area_first_level_id'];
        $obj->num = $this->request['num'];
        $obj->com_profile = $this->request['com_profile'];
        $obj->tel_secrecy = empty($this->request['tel_secrecy'])?0:1;
//        $obj->ed = $this->request['ed'];
//        $obj->workYears = $this->request['work_years'];
//        $obj->money = $this->request['money'];
//        $obj->jobRequirements = $this->request['job_requirements'];
//        $obj->description = $this->request['description'];
//        if(!empty($this->request['treatment'])){
//            $treatment = $this->request['treatment'];
//            $obj->treatmentWxyj = empty($treatment['wxyj'])?0:1;
//            $obj->treatmentBc = empty($treatment['bc'])?0:1;
//            $obj->treatmentBz = empty($treatment['bz'])?0:1;
//            $obj->treatmentZmsx = empty($treatment['zmsx'])?0:1;
//            $obj->treatmentNdsx = empty($treatment['ndsx'])?0:1;
//        }
        $obj->contacts = $this->request['contacts'];
        $obj->tel1 = $this->request['tel1'];
        $obj->email = $this->request['email'];
        $obj->address = $this->request['address'];
        return [$inter->save($obj),$inter];
    }
}