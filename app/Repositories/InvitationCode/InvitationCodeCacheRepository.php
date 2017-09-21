<?php
namespace App\Repositories\InvitationCode;

use App\Traits\RepositoryCacheTrait;

class InvitationCodeCacheRepository extends InvitationCodeDBRepository
{
    use RepositoryCacheTrait;

    protected $cacheMinutes = 60;

    protected $cachePrefix = 'invitation_code:';

}