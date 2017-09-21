<?php
/**
 * auto create file for commands
 */
namespace App\Repositories\User;

use App\Models\Base\User;
use App\Repositories\BaseRepository;
use App\Traits\RepositoryDBTrait;

/**
 * Class UserDBRepository
 * @package App\Repositories\User
 */
class UserDBRepository extends BaseRepository implements UserRepository
{
    use RepositoryDBTrait;

    /**
     * @var string
     */
    protected $model = User::class;

}