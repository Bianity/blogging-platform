<?php

namespace App\Livewire\Admin\Settings;

use App\Settings\GeneralSettings;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class General extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(GeneralSettings $settings): void
    {
        $settings = [
            'site_name' => $settings->site_name,
            'site_language' => $settings->site_language,
            'site_maintenance_mode' => $settings->site_maintenance_mode,
            'site_logo' => $settings->site_logo,
            'site_logo_dark' => $settings->site_logo_dark,
            'site_favicon' => $settings->site_favicon,
            'default_feed' => config('alma.default_feed'),
            'default_font' => config('alma.default_font'),
        ];

        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('Website details'))
                    ->description(__('All the general settings shown here are applied on overall website.'))
                    ->schema([
                        TextInput::make('site_name')
                            ->label(__('Site name'))
                            ->required()
                            ->minLength(2)
                            ->maxLength(50),
                        Select::make('site_language')
                            ->label(__('Default Language'))
                            ->options([
                                'en' => 'English',
                                'de' => 'German',
                                'fr' => 'French',
                                'ru' => 'Russian',
                                'it' => 'Italian',
                                'pt' => 'Portuguese',
                                'es' => 'Spanish',
                                'tr' => 'Turkish',
                                'sk' => 'Slovak',
                                'hu' => 'Hungarian',
                                'id' => 'Indonesian',
                                'vi' => 'Vietnamese',
                            ])
                            ->default('en')
                            ->selectablePlaceholder(false)
                            ->native(false),

                        Grid::make([
                            'default' => 1,
                            'md' => 2,
                        ])
                            ->schema([
                                Select::make('default_feed')
                                    ->label(__('Default feed'))
                                    ->options([
                                        'popular' => __('Popular'),
                                        'latest' => __('Latest'),
                                    ])
                                    ->native(false)
                                    ->placeholder(__('Important! Need to update the sitemap after changing the feed.')),
                                TextInput::make('default_font')
                                    ->label(__('Default font'))
                                    ->placeholder(__('e.g: Montserrat')),
                            ]),

                    ]),
                Section::make(__('Maintenance Mode'))
                    ->description(__('It\'s a great way to notify visitors that your site is down but will be back up shortly.'))
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'md' => 2,
                        ])
                            ->schema([
                                ViewField::make('message')
                                    ->view('filament.forms.components.maintenance_message'),
                                Toggle::make('site_maintenance_mode')
                                    ->label(__('Maintenance Mode'))
                                    ->disabled(env('DEMO_MODE') === true)
                                    ->onIcon('heroicon-m-bolt')
                                    ->offIcon('heroicon-m-bolt-slash'),
                            ]),
                    ])->collapsible(),

                Section::make(__('Assets'))
                    ->description(__('Upload logo, dark logo and favicon of your platform, after upload will be visible on your site.'))
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'md' => 3,
                        ])
                            ->schema([
                                FileUpload::make('site_logo')
                                    ->label(__('Logo'))
                                    ->placeholder(__('Upload your site logo from here. (Only PNG)'))
                                    ->image()
                                    ->acceptedFileTypes(['image/png'])
                                    ->disk(getCurrentDisk())
                                    ->directory('media')
                                    ->visibility('public')
                                    ->maxSize(1024)
                                    ->afterStateUpdated(fn () => $this->validateOnly('data.site_logo')),
                                FileUpload::make('site_logo_dark')
                                    ->label(__('Dark Logo'))
                                    ->placeholder(__('Upload your site dark logo from here. (Only PNG)'))
                                    ->image()
                                    ->acceptedFileTypes(['image/png'])
                                    ->disk(getCurrentDisk())
                                    ->directory('media')
                                    ->visibility('public')
                                    ->maxSize(1024)
                                    ->afterStateUpdated(fn () => $this->validateOnly('data.site_logo_dark')),
                                FileUpload::make('site_favicon')
                                    ->label(__('Favicon'))
                                    ->placeholder(__('Upload a favicon here. (Only PNG)'))
                                    ->image()
                                    ->acceptedFileTypes(['image/png'])
                                    ->disk(getCurrentDisk())
                                    ->directory('media')
                                    ->visibility('public')
                                    ->maxSize(1024)
                                    ->afterStateUpdated(fn () => $this->validateOnly('data.site_favicon')),
                            ]),
                    ]),
            ])
            ->statePath('data');
    }

    public function store(GeneralSettings $settings)
    {
        if ($this->form->getState()['site_name']) {
            $settings->site_name = $this->form->getState()['site_name'];
            $settings->save();
        }

        if ($this->form->getState()['site_language']) {
            $settings->site_language = $this->form->getState()['site_language'];
            $settings->save();
        }

        if ($this->form->getState()['site_maintenance_mode'] === true) {
            $settings->site_maintenance_mode = $this->form->getState()['site_maintenance_mode'];
            $settings->save();
            Artisan::call('down');
        } else {
            $settings->site_maintenance_mode = $this->form->getState()['site_maintenance_mode'];
            $settings->save();
            Artisan::call('up');
        }

        if ($this->form->getState()['default_feed']) {
            Artisan::call('config:clear');

            Config::write('alma.default_feed', $this->form->getState()['default_feed']);
        }

        if ($this->form->getState()['default_font']) {
            Artisan::call('config:clear');

            Config::write('alma.default_font', $this->form->getState()['default_font']);
        }

        if (! is_null($this->form->getState()['site_logo'])) {
            $settings->site_logo = $this->form->getState()['site_logo'];
            $settings->save();
        } else {
            if (isset($settings->site_logo) && Storage::disk(getCurrentDisk())->exists($settings->site_logo)) {
                Storage::disk(getCurrentDisk())->delete($settings->site_logo);

                $settings->site_logo = '';
                $settings->save();
            }
        }

        if (! is_null($this->form->getState()['site_logo_dark'])) {
            $settings->site_logo_dark = $this->form->getState()['site_logo_dark'];
            $settings->save();
        } else {
            if (isset($settings->site_logo_dark) && Storage::disk(getCurrentDisk())->exists($settings->site_logo_dark)) {
                Storage::disk(getCurrentDisk())->delete($settings->site_logo_dark);

                $settings->site_logo_dark = '';
                $settings->save();
            }
        }

        if (! is_null($this->form->getState()['site_favicon'])) {
            $settings->site_favicon = $this->form->getState()['site_favicon'];
            $settings->save();
        } else {
            if (isset($settings->site_favicon) && Storage::disk(getCurrentDisk())->exists($settings->site_favicon)) {
                Storage::disk(getCurrentDisk())->delete($settings->site_favicon);

                $settings->site_favicon = '';
                $settings->save();
            }
        }

        Notification::make()
            ->success()
            ->title(__('Settings successfully updated'))
            ->seconds(10)
            ->send();
    }

    public function render()
    {
        return view('livewire.admin.settings.general');
    }
}
