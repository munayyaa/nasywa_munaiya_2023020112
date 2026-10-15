<?php

namespace App\Filament\Ujian\Pages\Auth;

use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class Login extends Page implements HasForms
{
    use InteractsWithForms;

    // Hapus kata 'static' karena mengikuti parent class Page
    protected string $view = 'filament.ujian.pages.auth.login';

    protected static bool $shouldRegisterNavigation = false;

    public ?array $data = [];

    public function mount(): void
    {
        if (Auth::guard('siswas')->check()) {
            redirect()->intended('/ujian');
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nis')
                    ->label('Nomor Induk Siswa (NIS)')
                    ->required()
                    ->autocomplete('off')
                    ->autofocus(),
                
                TextInput::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->required()
                    ->autocomplete('off'),

                Checkbox::make('remember')
                    ->label('Ingat Saya'),
            ])
            ->statePath('data');
    }

    public function authenticate()
    {
        $data = $this->form->getState();

        $authenticated = Auth::guard('siswas')->attempt([
            'nis' => $data['nis'],
            'nama_lengkap' => $data['nama_lengkap'],
        ], $data['remember'] ?? false);

        if (! $authenticated) {
            throw ValidationException::withMessages([
                'data.nis' => 'NIS atau Nama Lengkap yang Anda masukkan salah.',
            ]);
        }

        session()->regenerate();

        return redirect()->intended('/ujian');
    }
}