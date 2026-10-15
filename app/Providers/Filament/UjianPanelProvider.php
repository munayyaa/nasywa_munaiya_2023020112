<?php

namespace App\Providers\Filament;

use App\Filament\Ujian\Pages\Auth\Login; // <-- Pastikan mengarah ke sini
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;

class UjianPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('ujian')
            ->path('ujian') // Mengatur URL panel menjadi /ujian
            ->login(Login::class) // Mengaktifkan halaman login bawaan panel ini
            ->authGuard('siswas') // PENTING: Mengarahkan otentikasi ke guard siswa kita
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Ujian/Resources'), for: 'App\\Filament\\Ujian\\Resources')
            ->discoverPages(in: app_path('Filament/Ujian/Pages'), for: 'App\\Filament\\Ujian\\Pages')
            ->pages([
                \Filament\Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Ujian/Widgets'), for: 'App\\Filament\\Ujian\\Widgets')
            ->widgets([
                // Widgets bawaan panel
            ])
            ->middleware([
                \Illuminate\Cookie\Middleware\EncryptCookies::class,
                \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
                \Illuminate\Session\Middleware\StartSession::class,
                \Illuminate\Session\Middleware\AuthenticateSession::class,
                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                \Illuminate\Foundation\Http\Middleware\PreventRequestForgery::class,
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
            ])
            ->authMiddleware([
                \Filament\Http\Middleware\Authenticate::class,
            ]);
    }
}