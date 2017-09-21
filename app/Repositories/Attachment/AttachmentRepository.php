<?php

namespace App\Repositories\Attachment;


use App\Models\Base\Attachment;

/**
 * Interface AttachmentRepository
 * @package  App\Repositories\Attachment
 * @property integer $userId
 * @property integer $type
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */

interface AttachmentRepository
{
    /**
     * @param int $id
     *
     * @return Attachment|null
     */
    public function find($id);

    /**
     * @param int $id
     *
     * @return Attachment
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail($id);

    /**
     *
     * @return bool
     */
    public function save();

    /**
     * @return $this
     */
    public function write();

    /**
     * @return Attachment
     */
    public function getCurrentInstance();

    public function init();

    /**
     * @param integer $uid
     * @param integer $type
     *
     * @return Attachment|null
     */
    public function findByUidAndType($uid, $type);

}