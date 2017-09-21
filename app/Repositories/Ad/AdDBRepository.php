<?php
/**
 * auto create file for commands
 */
namespace App\Repositories\Ad;

use App\Models\Base\Ad;
use App\Repositories\BaseRepository;
use App\Traits\RepositoryDBTrait;

/**
 * Class AdDBRepository
 * @package App\Repositories\Ad
 */
class AdDBRepository extends BaseRepository implements AdRepository
{
    use RepositoryDBTrait;

    /**
     * @var string
     */
    protected $model = Ad::class;

}