<?php

namespace App\Livewire\Admin\Settings;

use App\Settings\AdvancedSettings;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;
use Livewire\Component;

class Mail extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(AdvancedSettings $settings): void
    {
        $settings = [
            'current_mail_driver' => $settings->current_mail_driver,
            'mail_mailer' => env('MAIL_MAILER'),
            'mail_host' => env('MAIL_HOST'),
            'mail_port' => env('MAIL_PORT'),
            'mail_username' => env('MAIL_USERNAME'),
            'mail_password' => env('MAIL_PASSWORD'),
            'mail_encryption' => env('MAIL_ENCRYPTION'),
            'mail_from_address' => env('MAIL_FROM_ADDRESS'),
            'mail_from_name' => env('MAIL_FROM_NAME'),
            'mailgun_domain' => env('MAILGUN_DOMAIN'),
            'mailgun_secret' => env('MAILGUN_SECRET'),
            'mailgun_endpoint' => env('MAILGUN_ENDPOINT'),
            'aws_access_key_id' => env('AWS_ACCESS_KEY_ID'),
            'aws_secret_access_key' => env('AWS_SECRET_ACCESS_KEY'),
            'aws_default_region' => env('AWS_DEFAULT_REGION'),
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
                        Select::make('current_mail_driver')
                            ->label(__('Storage Driver'))
                            ->options([
                                'log' => 'Log',
                                'smtp' => 'SMTP',
                                'mailgun' => 'Mailgun',
                                'ses' => 'Amazon Simple Email Service (SES)',
                            ])
                            ->default('log')
                            ->selectablePlaceholder(false)
                            ->native(false)
                            ->live(onBlur: true),
                        TextInput::make('mail_host')
                            ->label(__('Mail Host'))
                            ->placeholder('smtp.domain.com')
                            ->visible(fn (Get $get) => $get('current_mail_driver') === 'smtp'),
                        TextInput::make('mail_port')
                            ->label(__('Mail Port'))
                            ->placeholder('1025')
                            ->visible(fn (Get $get) => $get('current_mail_driver') === 'smtp'),
                        TextInput::make('mail_username')
                            ->label(__('Mail Username'))
                            ->visible(fn (Get $get) => $get('current_mail_driver') === 'smtp'),
                        TextInput::make('mail_password')
                            ->label(__('Mail Password'))
                            ->visible(fn (Get $get) => $get('current_mail_driver') === 'smtp'),
                        TextInput::make('mail_encryption')
                            ->label(__('Mail Encryption'))
                            ->visible(fn (Get $get) => $get('current_mail_driver') === 'smtp'),
                        TextInput::make('mail_from_address')
                            ->label(__('Mail from Address'))
                            ->visible(fn (Get $get) => $get('current_mail_driver') === 'smtp'),
                        TextInput::make('mail_from_name')
                            ->label(__('Mail from Name'))
                            ->visible(fn (Get $get) => $get('current_mail_driver') === 'smtp'),
                        TextInput::make('mailgun_domain')
                            ->label(__('Mailgun Domain'))
                            ->visible(fn (Get $get) => $get('current_mail_driver') === 'mailgun'),
                        TextInput::make('mailgun_secret')
                            ->label(__('Mailgun Secret'))
                            ->visible(fn (Get $get) => $get('current_mail_driver') === 'mailgun'),
                        TextInput::make('mailgun_endpoint')
                            ->label(__('Mailgun Endpoint'))
                            ->visible(fn (Get $get) => $get('current_mail_driver') === 'mailgun'),
                        TextInput::make('mail_from_address')
                            ->label(__('Mail from Address'))
                            ->visible(fn (Get $get) => $get('current_mail_driver') === 'mailgun'),
                        TextInput::make('mail_from_name')
                            ->label(__('Mail from Name'))
                            ->visible(fn (Get $get) => $get('current_mail_driver') === 'mailgun'),
                        TextInput::make('aws_access_key_id')
                            ->label(__('AWS ACCESS KEY ID'))
                            ->visible(fn (Get $get) => $get('current_mail_driver') === 'ses'),
                        TextInput::make('aws_secret_access_key')
                            ->label(__('AWS SECRET ACCESS KEY'))
                            ->visible(fn (Get $get) => $get('current_mail_driver') === 'ses'),
                        TextInput::make('aws_default_region')
                            ->label(__('AWS DEFAULT REGION'))
                            ->visible(fn (Get $get) => $get('current_mail_driver') === 'ses'),
                        TextInput::make('mail_from_address')
                            ->label(__('Mail from Address'))
                            ->visible(fn (Get $get) => $get('current_mail_driver') === 'ses'),
                        TextInput::make('mail_from_name')
                            ->label(__('Mail from Name'))
                            ->visible(fn (Get $get) => $get('current_mail_driver') === 'ses'),
                    ]),
            ])
            ->statePath('data');
    }

    public function store(AdvancedSettings $settings)
    {
        if ($this->form->getState()['current_mail_driver'] === 'log') {
            $settings->current_mail_driver = $this->form->getState()['current_mail_driver'];
            $settings->save();

            Artisan::call('config:clear');

            setEnvironmentValue([
                'mail_mailer' => $this->form->getState()['current_mail_driver'],
            ]);
        }

        if ($this->form->getState()['current_mail_driver'] === 'smtp') {
            $settings->current_mail_driver = $this->form->getState()['current_mail_driver'];
            $settings->save();

            Artisan::call('config:clear');

            setEnvironmentValue([
                'mail_mailer' => $this->form->getState()['current_mail_driver'],
                'mail_host' => $this->form->getState()['mail_host'],
                'mail_port' => $this->form->getState()['mail_port'],
                'mail_username' => $this->form->getState()['mail_username'],
                'mail_password' => $this->form->getState()['mail_password'],
                'mail_encryption' => $this->form->getState()['mail_encryption'],
                'mail_from_address' => $this->form->getState()['mail_from_address'],
                'mail_from_name' => $this->form->getState()['mail_from_name'],
            ]);
        }

        if ($this->form->getState()['current_mail_driver'] === 'mailgun') {
            $settings->current_mail_driver = $this->form->getState()['current_mail_driver'];
            $settings->save();

            Artisan::call('config:clear');

            setEnvironmentValue([
                'mail_mailer' => $this->form->getState()['current_mail_driver'],
                'mailgun_domain' => $this->form->getState()['mailgun_domain'],
                'mailgun_secret' => $this->form->getState()['mailgun_secret'],
                'mailgun_endpoint' => $this->form->getState()['mailgun_endpoint'],
                'mail_from_address' => $this->form->getState()['mail_from_address'],
                'mail_from_name' => $this->form->getState()['mail_from_name'],
            ]);
        }

        if ($this->form->getState()['current_mail_driver'] === 'ses') {
            $settings->current_mail_driver = $this->form->getState()['current_mail_driver'];
            $settings->save();

            Artisan::call('config:clear');

            setEnvironmentValue([
                'mail_mailer' => $this->form->getState()['current_mail_driver'],
                'aws_access_key_id' => $this->form->getState()['aws_access_key_id'],
                'aws_secret_access_key' => $this->form->getState()['aws_secret_access_key'],
                'aws_default_region' => $this->form->getState()['aws_default_region'],
                'mail_from_address' => $this->form->getState()['mail_from_address'],
                'mail_from_name' => $this->form->getState()['mail_from_name'],
            ]);
        }

        Notification::make()
            ->success()
            ->title(__('Settings successfully updated'))
            ->seconds(10)
            ->send();
    }

    public function render()
    {
        return view('livewire.admin.settings.mail');
    }
}
