<?php
/**
 * auto create file for commands
 */
namespace App\Repositories\Attachment;

use App\Models\Base\Attachment;
use App\Repositories\BaseRepository;
use App\Traits\RepositoryDBTrait;

/**
 * Class AttachmentDBRepository
 * @package App\Repositories\Attachment
 */
class AttachmentDBRepository extends BaseRepository implements AttachmentRepository
{
    use RepositoryDBTrait;

    /**
     * @var string
     */
    protected $model = Attachment::class;

    public function findByUidAndType($uid, $type)
    {
        $instance = $this->currentBuilder->whereUid($uid)->whereType($type)->first();
        $this->currentInstance = $instance;
        return $instance;
    }

}