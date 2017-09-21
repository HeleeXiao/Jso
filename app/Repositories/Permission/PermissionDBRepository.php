<?php
/**
 * auto create file for commands
 */
namespace App\Repositories\Permission;

use App\Models\Base\Permission;
use App\Repositories\BaseRepository;
use App\Traits\RepositoryDBTrait;

/**
 * Class PermissionDBRepository
 * @package App\Repositories\Permission
 */
class PermissionDBRepository extends BaseRepository implements PermissionRepository
{
    use RepositoryDBTrait;

    /**
     * @var string
     */
    protected $model = Permission::class;

    /**
     * @param $ids
     * @return \Illuminate\Support\Collection
     * @auther <Helee>
     */
    public function findByIds($ids)
    {
        $result = [];
        foreach ($ids as $id) {
            $result[] = $this->find($id);
        }
        return collect($result);
    }

}