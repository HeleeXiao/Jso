<?php
/**
 * auto create file for commands
 */
namespace App\Repositories\InvitationCode;

use App\Models\Base\InvitationCode;
use App\Repositories\BaseRepository;
use App\Traits\RepositoryDBTrait;

/**
 * Class InvitationCodeDBRepository
 * @package App\Repositories\InvitationCode
 */
class InvitationCodeDBRepository extends BaseRepository implements InvitationCodeRepository
{
    use RepositoryDBTrait;

    /**
     * @var string
     */
    protected $model = InvitationCode::class;

}