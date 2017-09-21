<?php

namespace App\Events;

use App\Models\Base\Permission;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UpdatePermissionNameEvent
{
    use SerializesModels;

    public $permission;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct( Permission $permission)
    {
        $this->permission = $permission;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
