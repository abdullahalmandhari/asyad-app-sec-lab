<?php

namespace App\Policies;

use App\Models\Shipment;
use App\Models\User;

class ShipmentPolicy
{
    /** Only the owning staff member may view the shipment */
    public function view(User $user, Shipment $shipment): bool
    {
        return $user->id === $shipment->user_id;
    }
}
