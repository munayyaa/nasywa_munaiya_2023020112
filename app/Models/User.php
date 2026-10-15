<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

// Kebutuhan user avatar atau foto profil

use Filament\AvatarProviders\UiAvatarsProvider;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

#[Fillable(['name', 'email', 'password', 'photo_path', 'is_staff'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser, HasAvatar
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    // autorisasi user untuk multi-panel (Admin & Siswa)
    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return (bool) $this->is_staff; // Hanya pegawai/staff
        }

        if ($panel->getId() === 'siswa') {
            return ! $this->is_staff; // Hanya siswa (bukan staff)
        }

        return false;
    }

    // Relasi ke tabel Siswa
    public function siswa(): HasOne
    {
        return $this->hasOne(Siswa::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_staff' => 'boolean',
        ];
    }

    // ubah foto dalam format URL
    public function getFilamentAvatarUrl(): ?string
    {
        if (
            $this->photo_path &&
            Storage::disk('public')->exists($this->photo_path)
        ) {
            return Storage::disk('public')->url($this->photo_path);
        }

        return (new UiAvatarsProvider)->get($this);
    }
}