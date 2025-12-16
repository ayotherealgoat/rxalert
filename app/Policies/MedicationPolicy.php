<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Medication;

class MedicationPolicy
{
    public function update(User $user, Medication $medication)
    {
        return $user->id === $medication->user_id || $user->is_admin;
    }

    public function delete(User $user, Medication $medication)
    {
        return $user->id === $medication->user_id || $user->is_admin;
    }
}