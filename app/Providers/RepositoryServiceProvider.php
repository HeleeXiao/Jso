<?php

namespace App\Providers;

use App\Repositories\Ad\AdCacheRepository;
use App\Repositories\Ad\AdRepository;
use App\Repositories\Administrator\AdministratorCacheRepository;
use App\Repositories\Administrator\AdministratorRepository;
use App\Repositories\Attachment\AttachmentCacheRepository;
use App\Repositories\Category\CategoryCacheRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\City\CityCacheRepository;
use App\Repositories\City\CityRepository;
use App\Repositories\InvitationCode\InvitationCodeCacheRepository;
use App\Repositories\InvitationCode\InvitationCodeRepository;
use App\Repositories\Like\LikeCacheRepository;
use App\Repositories\Like\LikeRepository;
use App\Repositories\MobileDisabled\MobileDisabledCacheRepository;
use App\Repositories\MobileDisabled\MobileDisabledRepository;
use App\Repositories\Permission\PermissionCacheRepository;
use App\Repositories\Permission\PermissionRepository;
use App\Repositories\Role\RoleCacheRepository;
use App\Repositories\Role\RoleRepository;
use App\Repositories\Attachment\AttachmentRepository;
use App\Repositories\User\UserCacheRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(UserRepository::class, UserCacheRepository::class);
        $this->app->bind(AdministratorRepository::class, AdministratorCacheRepository::class);
        $this->app->bind(PermissionRepository::class, PermissionCacheRepository::class);
        $this->app->bind(RoleRepository::class, RoleCacheRepository::class);
        $this->app->bind(AdRepository::class, AdCacheRepository::class);
        $this->app->bind(CityRepository::class, CityCacheRepository::class);
        $this->app->bind(LikeRepository::class, LikeCacheRepository::class);
        $this->app->bind(MobileDisabledRepository::class, MobileDisabledCacheRepository::class);
        $this->app->bind(InvitationCodeRepository::class, InvitationCodeCacheRepository::class);
        $this->app->bind(CategoryRepository::class, CategoryCacheRepository::class);
        $this->app->bind(AttachmentRepository::class, AttachmentCacheRepository::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
