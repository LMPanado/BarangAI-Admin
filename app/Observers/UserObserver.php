<?php

namespace App\Observers;

use App\Models\Resident;
use App\Models\User;

class UserObserver
{
    public function updated(User $user): void
    {
        // Only sync verified residents
        if ($user->verification_status !== 'verified') {
            return;
        }

        Resident::where('user_id', $user->id)->update([
            'first_name'   => $user->first_name,
            'middle_name'  => $user->middle_name,
            'last_name'    => $user->last_name,
            'suffix'       => $user->suffix,
            'email'        => $user->email,
            'phone'        => $user->phone,
            'age'          => $user->age,
            'gender'       => $user->gender,
            'civil_status' => $user->civil_status,
            'address'      => $user->address,
            'is_voter'     => $user->is_voter ?? false,
            'birth_date'   => $user->birth_date,
            'place_birth'  => $user->place_birth,
            'height_cm'    => $user->height_cm,
            'weight_kg'    => $user->weight_kg,
        ]);
    }
}
