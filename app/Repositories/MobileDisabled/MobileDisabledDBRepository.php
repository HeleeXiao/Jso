<?php
/**
 * auto create file for commands
 */
namespace App\Repositories\MobileDisabled;

use App\Models\Base\MobileDisabled;
use App\Repositories\BaseRepository;
use App\Traits\RepositoryDBTrait;

/**
 * Class MobileDisabledDBRepository
 * @package App\Repositories\MobileDisabled
 */
class MobileDisabledDBRepository extends BaseRepository implements MobileDisabledRepository
{
    use RepositoryDBTrait;

    /**
     * @var string
     */
    protected $model = MobileDisabled::class;

}