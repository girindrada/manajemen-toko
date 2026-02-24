<?php

namespace App\Policies;

use App\Models\User;

class KasirStorePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function manageStore(User $user, int $storeId): bool
    {
        return $user->storeUsers()
            ->where('store_id', $storeId)
            ->whereHas('role', fn($q) => $q->where('name', 'kasir'))
            ->exists();
    }
}
