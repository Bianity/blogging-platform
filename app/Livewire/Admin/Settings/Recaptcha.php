<?php

namespace App\Livewire\Admin\Settings;

use App\Settings\AdvancedSettings;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;
use Livewire\Component;

class Recaptcha extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(AdvancedSettings $settings): void
    {
        $settings = [
            'recaptcha_active' => $settings->recaptcha_active,
            'recaptcha_site_key' => env('RECAPTCHA_SITE_KEY'),
            'recaptcha_secret_key' => env('RECAPTCHA_SECRET_KEY'),
        ];

        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('Google reCaptcha'))
                    ->description(__('reCaptcha uses an advanced risk analysis engine and adaptive challenges to keep malicious software from engaging in abusive activities on your website. Meanwhile, legitimate users will be able to login, make purchases, view pages, or create accounts and fake users or bots will be blocked.'))
                    ->schema([
                        Toggle::make('recaptcha_active')
                            ->label(__('Enable reCaptcha'))
                            ->onIcon('heroicon-m-bolt')
                            ->offIcon('heroicon-m-bolt-slash')
                            ->live(onBlur: true),
                        TextInput::make('recaptcha_site_key')
                            ->label(__('reCaptcha site Key'))
                            ->visible(fn (Get $get) => $get('recaptcha_active') === true),
                        TextInput::make('recaptcha_secret_key')
                            ->label(__('reCaptcha secret key'))
                            ->visible(fn (Get $get) => $get('recaptcha_active') === true),
                    ]),
            ])
            ->statePath('data');
    }

    public function store(AdvancedSettings $settings)
    {
        if ($this->form->getState()['recaptcha_active']) {
            $settings->recaptcha_active = $this->form->getState()['recaptcha_active'];
            $settings->save();

            Artisan::call('config:clear');

            setEnvironmentValue([
                'recaptcha_site_key' => $this->form->getState()['recaptcha_site_key'],
                'recaptcha_secret_key' => $this->form->getState()['recaptcha_secret_key'],
            ]);
        } else {
            $settings->recaptcha_active = $this->form->getState()['recaptcha_active'];
            $settings->save();
        }

        Notification::make()
            ->success()
            ->title(__('Settings successfully updated'))
            ->seconds(10)
            ->send();
    }

    public function render()
    {
        return view('livewire.admin.settings.recaptcha');
    }
}
