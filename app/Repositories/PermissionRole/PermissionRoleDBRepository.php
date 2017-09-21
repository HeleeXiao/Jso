<?php
/**
 * auto create file for commands
 */
namespace App\Repositories\PermissionRole;

use App\Models\Base\PermissionRole;
use App\Repositories\BaseRepository;
use App\Traits\RepositoryDBTrait;

/**
 * Class PermissionRoleDBRepository
 * @package App\Repositories\PermissionRole
 */
class PermissionRoleDBRepository extends BaseRepository implements PermissionRoleRepository
{
    use RepositoryDBTrait;

    /**
     * @var string
     */
    protected $model = PermissionRole::class;

}