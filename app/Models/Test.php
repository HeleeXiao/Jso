<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

/**
 * Class Test
 * @package App\Models
 * User: wsm@jtrips.com
 * @property string $title
 * @property string $content
 * @property string $author
 */

class Test extends Model
{
    use Eloquence, Mappable;

    protected $table = 'test';

    protected $maps = [
        'title' => 'title_1',
        'content' => 'content_1',
        'author' => 'author_1'
    ];
}
