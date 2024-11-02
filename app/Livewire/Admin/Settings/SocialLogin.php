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

class SocialLogin extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(AdvancedSettings $settings): void
    {
        $settings = [
            'facebook_login_active' => $settings->facebook_login_active,
            'google_login_active' => $settings->google_login_active,
            'facebook_client_id' => env('FACEBOOK_CLIENT_ID'),
            'facebook_client_secret' => env('FACEBOOK_CLIENT_SECRET'),
            'facebook_redirect_uri' => env('FACEBOOK_REDIRECT_URI'),
            'google_client_id' => env('GOOGLE_CLIENT_ID'),
            'google_client_secret' => env('GOOGLE_CLIENT_SECRET'),
            'google_redirect_uri' => env('GOOGLE_REDIRECT_URI'),
        ];

        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('Facebook Sign-In to Your Web App'))
                    ->description(__('Facebook Login allows visitors to use their Facebook profile to log into your website instead of creating a unique sign-in.'))
                    ->schema([
                        Toggle::make('facebook_login_active')
                            ->label(__('Allow Login via Facebook:'))
                            ->onIcon('heroicon-m-bolt')
                            ->offIcon('heroicon-m-bolt-slash')
                            ->live(onBlur: true),
                        TextInput::make('facebook_client_id')
                            ->label(__('Facebook Client ID'))
                            ->visible(fn (Get $get) => $get('facebook_login_active') === true),
                        TextInput::make('facebook_client_secret')
                            ->label(__('Facebook Client Secret'))
                            ->visible(fn (Get $get) => $get('facebook_login_active') === true),
                        TextInput::make('facebook_redirect_uri')
                            ->label(__('Facebook Redirect URI'))
                            ->url()
                            ->visible(fn (Get $get) => $get('facebook_login_active') === true),
                    ]),

                Section::make(__('Google Sign-In to Your Web App'))
                    ->description(__('Get users into your website quickly and securely, using a registration system they already use and trust; their Google account.'))
                    ->schema([
                        Toggle::make('google_login_active')
                            ->label(__('Allow Login via Google:'))
                            ->onIcon('heroicon-m-bolt')
                            ->offIcon('heroicon-m-bolt-slash')
                            ->live(onBlur: true),
                        TextInput::make('google_client_id')
                            ->label(__('Google Client ID'))
                            ->visible(fn (Get $get) => $get('google_login_active') === true),
                        TextInput::make('google_client_secret')
                            ->label(__('Google Client Secret'))
                            ->visible(fn (Get $get) => $get('google_login_active') === true),
                        TextInput::make('google_redirect_uri')
                            ->label(__('Google Redirect URI'))
                            ->url()
                            ->visible(fn (Get $get) => $get('google_login_active') === true),
                    ]),
            ])
            ->statePath('data');
    }

    public function store(AdvancedSettings $settings)
    {
        if ($this->form->getState()['facebook_login_active']) {
            $settings->facebook_login_active = $this->form->getState()['facebook_login_active'];
            $settings->save();

            Artisan::call('config:clear');

            setEnvironmentValue([
                'facebook_client_id' => $this->form->getState()['facebook_client_id'],
                'facebook_client_secret' => $this->form->getState()['facebook_client_secret'],
                'facebook_redirect_uri' => $this->form->getState()['facebook_redirect_uri'],
            ]);
        } else {
            $settings->facebook_login_active = $this->form->getState()['facebook_login_active'];
            $settings->save();
        }

        if ($this->form->getState()['google_login_active']) {
            $settings->google_login_active = $this->form->getState()['google_login_active'];
            $settings->save();

            Artisan::call('config:clear');

            setEnvironmentValue([
                'google_client_id' => $this->form->getState()['google_client_id'],
                'google_client_secret' => $this->form->getState()['google_client_secret'],
                'google_redirect_uri' => $this->form->getState()['google_redirect_uri'],
            ]);
        } else {
            $settings->google_login_active = $this->form->getState()['google_login_active'];
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
        return view('livewire.admin.settings.social-login');
    }
}
