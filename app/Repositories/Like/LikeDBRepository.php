<?php
/**
 * auto create file for commands
 */
namespace App\Repositories\Like;

use App\Models\Base\Like;
use App\Repositories\BaseRepository;
use App\Traits\RepositoryDBTrait;

/**
 * Class LikeDBRepository
 * @package App\Repositories\Like
 */
class LikeDBRepository extends BaseRepository implements LikeRepository
{
    use RepositoryDBTrait;

    /**
     * @var string
     */
    protected $model = Like::class;

}