<?php

namespace App\Traits;

trait UserStatusTrait
{
    // Method to get the authenticated user
    public function getAuthUser()
    {
        return auth()->user();
    }

    // Method to get the user status from the config
    public function getUserStatus($statusKey = null)
    {
        $statuses = config('constants.USER_STATUS');

    // If no specific status key is passed, return all statuses
        if ($statusKey === null) {
            return $statuses;
        }

    // Return the specific status value if the key exists, otherwise null
        return $statuses[$statusKey] ?? null;
    }
}
