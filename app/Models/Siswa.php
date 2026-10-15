<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Models\Contracts\HasAvatar; // <-- 1. Tambahkan ini
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage; // <-- 2. Tambahkan ini

class Siswa extends Authenticatable implements FilamentUser, HasName, HasAvatar
{
    use HasFactory;

    protected $table = 'siswas';

    protected $fillable = [
        'nis',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'foto', // <-- Pastikan kolom foto ada di fillable
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function getFilamentName(): string
    {
        return $this->nama_lengkap;
    }

    // 3. Tambahkan method ini agar Filament bisa membaca foto profil siswa
   public function getFilamentAvatarUrl(): ?string
{
    if (!$this->foto) {
        return null;
    }

    // Jika sudah berupa URL lengkap
    if (filter_var($this->foto, FILTER_VALIDATE_URL)) {
        return $this->foto;
    }

    return Storage::disk('public')->url($this->foto);
}
}