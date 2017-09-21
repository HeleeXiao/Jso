<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

/**
 * Class Attachment
 * @package App\Models\Web
 * User: wsm@jtrips.com
 * @property integer $userId
 * @property integer $type
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 */
class Attachment extends Model
{
    use Eloquence, Mappable;

    protected $table = 'attachment';

    protected $maps = [
        'userId' => 'user_id'
    ];

    public function scopeWhereUid($query, $uid)
    {
        return $query->where('user_id', $uid);
    }

    public function scopeWhereType($query, $type)
    {
        return $query->where('type', $type);
    }
}
