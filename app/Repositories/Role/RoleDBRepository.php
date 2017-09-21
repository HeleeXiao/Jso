<?php
/**
 * auto create file for commands
 */
namespace App\Repositories\Role;

use App\Models\Base\Role;
use App\Repositories\BaseRepository;
use App\Traits\RepositoryDBTrait;

/**
 * Class RoleDBRepository
 * @package App\Repositories\Role
 */
class RoleDBRepository extends BaseRepository implements RoleRepository
{
    use RepositoryDBTrait;

    /**
     * @var string
     */
    protected $model = Role::class;

}