<?php
/**
 * auto create file for commands
 */
namespace App\Repositories\Administrator;

use App\Models\Base\Administrator;
use App\Repositories\BaseRepository;
use App\Traits\RepositoryDBTrait;

/**
 * Class AdministratorDBRepository
 * @package App\Repositories\Administrator
 */
class AdministratorDBRepository extends BaseRepository implements AdministratorRepository
{
    use RepositoryDBTrait;

    /**
     * @var string
     */
    protected $model = Administrator::class;

}