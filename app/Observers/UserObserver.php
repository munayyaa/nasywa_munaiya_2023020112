<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Siswa;

class UserObserver
{
    public function created(User $user): void
    {
        // Buat profil siswa otomatis jika user bukan staff/admin
        if (!$user->is_staff) {
            Siswa::create([
                'user_id' => $user->id,
                'nama_lengkap' => $user->name,
            ]);
        }
    }
}