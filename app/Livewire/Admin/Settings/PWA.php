<?php

namespace App\Livewire\Admin\Settings;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class PWA extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $settings = [
            'pwa_active' => config('alma.pwa_active'),
            'name' => config('pwa.name'),
            'manifest_name' => config('pwa.manifest.name'),
            'short_name' => config('pwa.manifest.short_name'),
            'start_url' => config('pwa.manifest.start_url'),
            'background_color' => config('pwa.manifest.background_color'),
            'theme_color' => config('pwa.manifest.theme_color'),
            'display' => config('pwa.manifest.display'),
            'orientation' => config('pwa.manifest.orientation'),
            'status_bar' => config('pwa.manifest.status_bar'),
            'icon_72' => config('pwa.manifest.icons.72x72.path'),
            'icon_96' => config('pwa.manifest.icons.96x96.path'),
            'icon_128' => config('pwa.manifest.icons.128x128.path'),
            'icon_144' => config('pwa.manifest.icons.144x144.path'),
            'icon_152' => config('pwa.manifest.icons.152x152.path'),
            'icon_192' => config('pwa.manifest.icons.192x192.path'),
            'icon_384' => config('pwa.manifest.icons.384x384.path'),
            'icon_512' => config('pwa.manifest.icons.512x512.path'),
        ];

        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('Progressive Web Apps'))
                    ->description(__('Progressive Web Apps are applications that run on browsers built using conventional website development technologies but also combine the features of a native application.'))
                    ->schema([
                        Toggle::make('pwa_active')
                            ->label(__('Enable PWA'))
                            ->onIcon('heroicon-m-bolt')
                            ->offIcon('heroicon-m-bolt-slash')
                            ->live(onBlur: true),
                        TextInput::make('name')
                            ->label(__('Site name'))
                            ->required()
                            ->maxLength(100)
                            ->visible(fn (Get $get) => $get('pwa_active') === true),
                        TextInput::make('manifest_name')
                            ->label(__('Manifest site name'))
                            ->maxLength(100)
                            ->visible(fn (Get $get) => $get('pwa_active') === true),
                        Grid::make([
                            'default' => 1,
                            'md' => 2,
                        ])->schema([
                            TextInput::make('short_name')
                                ->label(__('Short name'))
                                ->visible(fn (Get $get) => $get('pwa_active') === true),
                            TextInput::make('start_url')
                                ->label(__('Start URL'))
                                ->visible(fn (Get $get) => $get('pwa_active') === true),
                            ColorPicker::make('background_color')
                                ->label(__('Background color'))
                                ->visible(fn (Get $get) => $get('pwa_active') === true),
                            ColorPicker::make('theme_color')
                                ->label(__('Theme color'))
                                ->visible(fn (Get $get) => $get('pwa_active') === true),
                        ]),
                        Grid::make([
                            'default' => 1,
                            'md' => 3,
                        ])->schema([
                            TextInput::make('display')
                                ->label(__('Display'))
                                ->visible(fn (Get $get) => $get('pwa_active') === true),
                            TextInput::make('orientation')
                                ->label(__('Orientation'))
                                ->visible(fn (Get $get) => $get('pwa_active') === true),
                            TextInput::make('status_bar')
                                ->label(__('Status bar'))
                                ->visible(fn (Get $get) => $get('pwa_active') === true),
                        ]),
                    ]),
                Section::make(__('Icons'))
                    ->description(__('Icons must be saved in the public folder'))
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'md' => 2,
                        ])->schema([
                            TextInput::make('icon_72')
                                ->label(__('Icon size ').'72x72')
                                ->visible(fn (Get $get) => $get('pwa_active') === true),
                            TextInput::make('icon_96')
                                ->label(__('Icon size ').'96x96')
                                ->visible(fn (Get $get) => $get('pwa_active') === true),
                            TextInput::make('icon_128')
                                ->label(__('Icon size ').'128x128')
                                ->visible(fn (Get $get) => $get('pwa_active') === true),
                            TextInput::make('icon_144')
                                ->label(__('Icon size ').'144x144')
                                ->visible(fn (Get $get) => $get('pwa_active') === true),
                            TextInput::make('icon_152')
                                ->label(__('Icon size ').'152x152')
                                ->visible(fn (Get $get) => $get('pwa_active') === true),
                            TextInput::make('icon_192')
                                ->label(__('Icon size ').'192x192')
                                ->visible(fn (Get $get) => $get('pwa_active') === true),
                            TextInput::make('icon_384')
                                ->label(__('Icon size ').'384x384')
                                ->visible(fn (Get $get) => $get('pwa_active') === true),
                            TextInput::make('icon_512')
                                ->label(__('Icon size ').'512x512')
                                ->visible(fn (Get $get) => $get('pwa_active') === true),
                        ]),
                    ])->visible(fn (Get $get) => $get('pwa_active') === true),
            ])
            ->statePath('data');
    }

    public function store()
    {
        if ($this->form->getState()['pwa_active']) {
            Artisan::call('config:clear');

            Config::write('alma.pwa_active', $this->form->getState()['pwa_active']);
            Config::write('pwa.name', $this->form->getState()['name']);
            Config::write('pwa.manifest.name', $this->form->getState()['manifest_name']);
            Config::write('pwa.manifest.short_name', $this->form->getState()['short_name']);
            Config::write('pwa.manifest.start_url', $this->form->getState()['start_url']);
            Config::write('pwa.manifest.background_color', $this->form->getState()['background_color']);
            Config::write('pwa.manifest.theme_color', $this->form->getState()['theme_color']);
            Config::write('pwa.manifest.display', $this->form->getState()['display']);
            Config::write('pwa.manifest.orientation', $this->form->getState()['orientation']);
            Config::write('pwa.manifest.status_bar', $this->form->getState()['status_bar']);
            Config::write('pwa.manifest.icons.72x72.path', $this->form->getState()['icon_72']);
            Config::write('pwa.manifest.icons.96x96.path', $this->form->getState()['icon_96']);
            Config::write('pwa.manifest.icons.128x128.path', $this->form->getState()['icon_128']);
            Config::write('pwa.manifest.icons.144x144.path', $this->form->getState()['icon_144']);
            Config::write('pwa.manifest.icons.144x144.path', $this->form->getState()['icon_144']);
            Config::write('pwa.manifest.icons.152x152.path', $this->form->getState()['icon_152']);
            Config::write('pwa.manifest.icons.192x192.path', $this->form->getState()['icon_192']);
            Config::write('pwa.manifest.icons.384x384.path', $this->form->getState()['icon_384']);
            Config::write('pwa.manifest.icons.512x512.path', $this->form->getState()['icon_512']);
        } else {
            Config::write('alma.pwa_active', $this->form->getState()['pwa_active']);
        }

        Notification::make()
            ->success()
            ->title(__('Settings successfully updated'))
            ->seconds(10)
            ->send();
    }

    public function render()
    {
        return view('livewire.admin.settings.p-w-a');
    }
}
