<?php

namespace App\Livewire\Admin\Settings;

use App\Settings\AdvancedSettings;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Livewire\Component;

class Ads extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(AdvancedSettings $settings): void
    {
        $this->form->fill($settings->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('Google AdSense'))
                    ->description(__('Integrate Adsense platform here.'))
                    ->schema([
                        Toggle::make('adsense_active')
                            ->label(__('Enable Adsense ads'))
                            ->onIcon('heroicon-m-bolt')
                            ->offIcon('heroicon-m-bolt-slash')
                            ->live(onBlur: true),
                        TextInput::make('adsense_client_id')
                            ->label(__('Adsense ID'))
                            ->visible(fn (Get $get) => $get('adsense_active') === true)
                            ->placeholder(__('Paste your Adsense Client ID e.g. ca-pub-XXXXXXXXXXXXXXXXX')),
                    ]),
                Section::make(__('Ads'))
                    ->description(__('You can add custom ads banners or other providers code here.'))
                    ->schema([
                        Textarea::make('banner_above_header')
                            ->label(__('Header banner'))
                            ->placeholder(__('This banner will be showed above header'))
                            ->autosize()
                            ->rows(4),
                        Textarea::make('banner_before_content')
                            ->label(__('Before Content'))
                            ->placeholder(__('This banner will be shown before content'))
                            ->autosize()
                            ->rows(4),
                        Textarea::make('banner_after_content')
                            ->label(__('After Content'))
                            ->placeholder(__('This banner will be shown after content'))
                            ->autosize()
                            ->rows(4),
                        Textarea::make('banner_sidebar_widget')
                            ->label(__('Sidebar Widget'))
                            ->placeholder(__('This banner will be shown in sidebar'))
                            ->autosize()
                            ->rows(4),
                    ]),
            ])
            ->statePath('data');
    }

    public function store(AdvancedSettings $settings): void
    {
        $settings->adsense_active = $this->form->getState()['adsense_active'];

        isset($this->form->getState()['adsense_client_id'])
            ? $settings->adsense_client_id = $this->form->getState()['adsense_client_id']
            : $settings->adsense_client_id = '';

        isset($this->form->getState()['banner_above_header'])
            ? $settings->banner_above_header = $this->form->getState()['banner_above_header']
            : $settings->banner_above_header = '';

        isset($this->form->getState()['banner_before_content'])
            ? $settings->banner_before_content = $this->form->getState()['banner_before_content']
            : $settings->banner_before_content = '';

        isset($this->form->getState()['banner_after_content'])
            ? $settings->banner_after_content = $this->form->getState()['banner_after_content']
            : $settings->banner_after_content = '';

        isset($this->form->getState()['banner_sidebar_widget'])
            ? $settings->banner_sidebar_widget = $this->form->getState()['banner_sidebar_widget']
            : $settings->banner_sidebar_widget = '';

        $settings->save();

        Notification::make()
            ->success()
            ->title(__('Settings successfully updated'))
            ->seconds(10)
            ->send();
    }

    public function render()
    {
        return view('livewire.admin.settings.ads');
    }
}
