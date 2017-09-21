<?php
namespace App\Repositories\City;

use App\Traits\RepositoryCacheTrait;

class CityCacheRepository extends CityDBRepository
{
    use RepositoryCacheTrait;

    protected $cacheMinutes = 60;

    protected $cachePrefix = 'city:';

}