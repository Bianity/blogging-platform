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

class Storage extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(AdvancedSettings $settings): void
    {
        $settings = [
            'current_file_storage' => $settings->current_file_storage,
            'aws_access_key_id' => env('AWS_ACCESS_KEY_ID'),
            'aws_secret_access_key' => env('AWS_SECRET_ACCESS_KEY'),
            'aws_default_region' => env('AWS_DEFAULT_REGION'),
            'aws_bucket' => env('AWS_BUCKET'),
            'aws_url' => env('AWS_URL'),
            'aws_endpoint' => env('AWS_ENDPOINT'),
            'wasabi_access_key_id' => env('WASABI_ACCESS_KEY_ID'),
            'wasabi_secret_access_key' => env('WASABI_SECRET_ACCESS_KEY'),
            'wasabi_default_region' => env('WASABI_DEFAULT_REGION'),
            'wasabi_bucket' => env('WASABI_BUCKET'),
            'wasabi_root' => env('WASABI_ROOT'),
            'wasabi_endpoint' => env('WASABI_ENDPOINT'),
            'dos_access_key_id' => env('DOS_ACCESS_KEY_ID'),
            'dos_secret_access_key' => env('DOS_SECRET_ACCESS_KEY'),
            'dos_default_region' => env('DOS_DEFAULT_REGION'),
            'dos_bucket' => env('DOS_BUCKET'),
            'dos_folder' => env('DOS_FOLDER'),
            'dos_cdn_endpoint' => env('DOS_CDN_ENDPOINT'),
            'dos_url' => env('DOS_URL'),
            'dos_endpoint' => env('DOS_ENDPOINT'),
            'b2_application_key_id' => env('B2_APPLICATION_KEY_ID'),
            'b2_application_key_secret' => env('B2_APPLICATION_KEY_SECRET'),
            'b2_bucket_name' => env('B2_BUCKET_NAME'),
            'b2_region' => env('B2_REGION'),
            'b2_endpoint' => env('B2_ENDPOINT'),
            'ftp_host' => env('FTP_HOST'),
            'ftp_username' => env('FTP_USERNAME'),
            'ftp_password' => env('FTP_PASSWORD'),
            'ftp_port' => env('FTP_PORT'),
            'ftp_root' => env('FTP_ROOT'),
        ];

        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('File storage services'))
                    ->description(__('Additional supported file storage services - AWS S3, Wasabi, Digital Ocean Spaces. By default used local file storage.'))
                    ->schema([
                        Select::make('current_file_storage')
                            ->label(__('Storage Driver'))
                            ->options([
                                'local' => 'Local',
                                'aws' => 'AWS S3',
                                'wasabi' => 'Wasabi',
                                'dos' => 'DigitalOcean Spaces',
                                'backblaze' => 'Backblaze',
                                'ftp' => 'FTP',
                            ])
                            ->default('local')
                            ->selectablePlaceholder(false)
                            ->native(false)
                            ->live(onBlur: true),
                        TextInput::make('aws_access_key_id')
                            ->label(__('AWS ACCESS KEY ID'))
                            ->visible(fn (Get $get) => $get('current_file_storage') === 'aws'),
                        TextInput::make('aws_secret_access_key')
                            ->label(__('AWS SECRET ACCESS KEY'))
                            ->visible(fn (Get $get) => $get('current_file_storage') === 'aws'),
                        TextInput::make('aws_default_region')
                            ->label(__('AWS DEFAULT REGION'))
                            ->visible(fn (Get $get) => $get('current_file_storage') === 'aws'),
                        TextInput::make('aws_bucket')
                            ->label(__('AWS BUCKET'))
                            ->visible(fn (Get $get) => $get('current_file_storage') === 'aws'),
                        TextInput::make('aws_url')
                            ->label(__('AWS URL'))
                            ->visible(fn (Get $get) => $get('current_file_storage') === 'aws'),
                        TextInput::make('aws_endpoint')
                            ->label(__('AWS ENDPOINT'))
                            ->visible(fn (Get $get) => $get('current_file_storage') === 'aws'),
                        TextInput::make('wasabi_access_key_id')
                            ->label(__('WASABI ACCESS KEY ID'))
                            ->visible(fn (Get $get) => $get('current_file_storage') === 'wasabi'),
                        TextInput::make('wasabi_secret_access_key')
                            ->label(__('WASABI SECRET ACCESS KEY'))
                            ->visible(fn (Get $get) => $get('current_file_storage') === 'wasabi'),
                        TextInput::make('wasabi_default_region')
                            ->label(__('WASABI DEFAULT REGION'))
                            ->visible(fn (Get $get) => $get('current_file_storage') === 'wasabi'),
                        TextInput::make('wasabi_bucket')
                            ->label(__('WASABI BUCKET'))
                            ->visible(fn (Get $get) => $get('current_file_storage') === 'wasabi'),
                        TextInput::make('wasabi_root')
                            ->label(__('WASABI ROOT'))
                            ->visible(fn (Get $get) => $get('current_file_storage') === 'wasabi'),
                        TextInput::make('wasabi_endpoint')
                            ->label(__('WASABI ENDPOINT'))
                            ->visible(fn (Get $get) => $get('current_file_storage') === 'wasabi'),
                        TextInput::make('dos_access_key_id')
                            ->label(__('DOS ACCESS KEY ID'))
                            ->visible(fn (Get $get) => $get('current_file_storage') === 'dos'),
                        TextInput::make('dos_secret_access_key')
                            ->label(__('DOS SECRET ACCESS KEY'))
                            ->visible(fn (Get $get) => $get('current_file_storage') === 'dos'),
                        TextInput::make('dos_default_region')
                            ->label(__('DOS DEFAULT REGION'))
                            ->visible(fn (Get $get) => $get('current_file_storage') === 'dos'),
                        TextInput::make('dos_bucket')
                            ->label(__('DOS BUCKET'))
                            ->visible(fn (Get $get) => $get('current_file_storage') === 'dos'),
                        TextInput::make('dos_folder')
                            ->label(__('DOS FOLDER'))
                            ->visible(fn (Get $get) => $get('current_file_storage') === 'dos'),
                        TextInput::make('dos_cdn_endpoint')
                            ->label(__('DOS CDN ENDPOINT'))
                            ->visible(fn (Get $get) => $get('current_file_storage') === 'dos'),
                        TextInput::make('dos_url')
                            ->label(__('DOS URL'))
                            ->visible(fn (Get $get) => $get('current_file_storage') === 'dos'),
                        TextInput::make('dos_endpoint')
                            ->label(__('DOS ENDPOINT'))
                            ->visible(fn (Get $get) => $get('current_file_storage') === 'dos'),
                        TextInput::make('b2_application_key_id')
                            ->label(__('B2 APPLICATION KEY ID'))
                            ->visible(fn (Get $get) => $get('current_file_storage') === 'backblaze'),
                        TextInput::make('b2_application_key_secret')
                            ->label(__('B2 APPLICATION KEY SECRET'))
                            ->visible(fn (Get $get) => $get('current_file_storage') === 'backblaze'),
                        TextInput::make('b2_bucket_name')
                            ->label(__('B2 BUCKET NAME'))
                            ->visible(fn (Get $get) => $get('current_file_storage') === 'backblaze'),
                        TextInput::make('b2_region')
                            ->label(__('B2 REGION'))
                            ->visible(fn (Get $get) => $get('current_file_storage') === 'backblaze'),
                        TextInput::make('b2_endpoint')
                            ->label(__('B2 ENDPOINT'))
                            ->visible(fn (Get $get) => $get('current_file_storage') === 'backblaze'),
                        TextInput::make('ftp_host')
                            ->label(__('FTP HOST'))
                            ->visible(fn (Get $get) => $get('current_file_storage') === 'ftp'),
                        TextInput::make('ftp_username')
                            ->label(__('FTP USERNAME'))
                            ->visible(fn (Get $get) => $get('current_file_storage') === 'ftp'),
                        TextInput::make('ftp_password')
                            ->label(__('FTP PASSWORD'))
                            ->visible(fn (Get $get) => $get('current_file_storage') === 'ftp'),
                        TextInput::make('ftp_port')
                            ->label(__('FTP PORT'))
                            ->visible(fn (Get $get) => $get('current_file_storage') === 'ftp'),
                        TextInput::make('ftp_root')
                            ->label(__('FTP ROOT'))
                            ->visible(fn (Get $get) => $get('current_file_storage') === 'ftp'),
                    ]),
            ])
            ->statePath('data');
    }

    public function store(AdvancedSettings $settings)
    {
        if ($this->form->getState()['current_file_storage'] === 'local') {
            $settings->current_file_storage = $this->form->getState()['current_file_storage'];
            $settings->save();

            Artisan::call('config:clear');

            setEnvironmentValue([
                'filesystem_disk' => $this->form->getState()['current_file_storage'],
                'media_disk' => $this->form->getState()['current_file_storage'],
            ]);
        }

        if ($this->form->getState()['current_file_storage'] === 'aws') {
            $settings->current_file_storage = $this->form->getState()['current_file_storage'];
            $settings->save();

            Artisan::call('config:clear');

            setEnvironmentValue([
                'filesystem_disk' => $this->form->getState()['current_file_storage'],
                'media_disk' => $this->form->getState()['current_file_storage'],
                'aws_access_key_id' => $this->form->getState()['aws_access_key_id'],
                'aws_secret_access_key' => $this->form->getState()['aws_secret_access_key'],
                'aws_default_region' => $this->form->getState()['aws_default_region'],
                'aws_bucket' => $this->form->getState()['aws_bucket'],
                'aws_url' => $this->form->getState()['aws_url'],
                'aws_endpoint' => $this->form->getState()['aws_endpoint'],
            ]);
        }

        if ($this->form->getState()['current_file_storage'] === 'wasabi') {
            $settings->current_file_storage = $this->form->getState()['current_file_storage'];
            $settings->save();

            Artisan::call('config:clear');

            setEnvironmentValue([
                'filesystem_disk' => $this->form->getState()['current_file_storage'],
                'media_disk' => $this->form->getState()['current_file_storage'],
                'wasabi_access_key_id' => $this->form->getState()['wasabi_access_key_id'],
                'wasabi_secret_access_key' => $this->form->getState()['wasabi_secret_access_key'],
                'wasabi_default_region' => $this->form->getState()['wasabi_default_region'],
                'wasabi_bucket' => $this->form->getState()['wasabi_bucket'],
                'wasabi_root' => $this->form->getState()['wasabi_root'],
                'wasabi_endpoint' => $this->form->getState()['wasabi_endpoint'],
            ]);
        }

        if ($this->form->getState()['current_file_storage'] === 'dos') {
            $settings->current_file_storage = $this->form->getState()['current_file_storage'];
            $settings->save();

            Artisan::call('config:clear');

            setEnvironmentValue([
                'filesystem_disk' => $this->form->getState()['current_file_storage'],
                'media_disk' => $this->form->getState()['current_file_storage'],
                'dos_access_key_id' => $this->form->getState()['dos_access_key_id'],
                'dos_secret_access_key' => $this->form->getState()['dos_secret_access_key'],
                'dos_default_region' => $this->form->getState()['dos_default_region'],
                'dos_bucket' => $this->form->getState()['dos_bucket'],
                'dos_folder' => $this->form->getState()['dos_folder'],
                'dos_cdn_endpoint' => $this->form->getState()['dos_cdn_endpoint'],
                'dos_url' => $this->form->getState()['dos_url'],
                'dos_endpoint' => $this->form->getState()['dos_endpoint'],
            ]);
        }

        if ($this->form->getState()['current_file_storage'] === 'backblaze') {
            $settings->current_file_storage = $this->form->getState()['current_file_storage'];
            $settings->save();

            Artisan::call('config:clear');

            setEnvironmentValue([
                'filesystem_disk' => $this->form->getState()['current_file_storage'],
                'media_disk' => $this->form->getState()['current_file_storage'],
                'b2_application_key_id' => $this->form->getState()['b2_application_key_id'],
                'b2_application_key_secret' => $this->form->getState()['b2_application_key_secret'],
                'b2_bucket_name' => $this->form->getState()['b2_bucket_name'],
                'b2_region' => $this->form->getState()['b2_region'],
                'b2_endpoint' => $this->form->getState()['b2_endpoint'],
            ]);
        }

        if ($this->form->getState()['current_file_storage'] === 'ftp') {
            $settings->current_file_storage = $this->form->getState()['current_file_storage'];
            $settings->save();

            Artisan::call('config:clear');

            setEnvironmentValue([
                'filesystem_disk' => $this->form->getState()['current_file_storage'],
                'media_disk' => $this->form->getState()['current_file_storage'],
                'ftp_host' => $this->form->getState()['ftp_host'],
                'ftp_username' => $this->form->getState()['ftp_username'],
                'ftp_password' => $this->form->getState()['ftp_password'],
                'ftp_port' => $this->form->getState()['ftp_port'],
                'ftp_root' => $this->form->getState()['ftp_root'],
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
        return view('livewire.admin.settings.storage');
    }
}
