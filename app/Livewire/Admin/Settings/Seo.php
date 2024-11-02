<?php

namespace App\Livewire\Admin\Settings;

use App\Settings\SeoSettings;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Seo extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(SeoSettings $settings): void
    {
        $this->form->fill($settings->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('Search Engine Optimization'))
                    ->description(__('Search engine optimization is the process of improving the quality and quantity of website traffic to a website or a web page from search engines.'))
                    ->schema([
                        TextInput::make('meta_title')
                            ->label(__('Site meta title'))
                            ->placeholder(__('Site name'))
                            ->required()
                            ->minLength(5)
                            ->maxLength(60),
                        Textarea::make('meta_description')
                            ->label(__('Site meta description'))
                            ->placeholder(__('Site meta description'))
                            ->autosize()
                            ->rows(3)
                            ->maxLength(160),
                        TextInput::make('meta_keywords')
                            ->label(__('Site meta keywords'))
                            ->placeholder(__('Site meta keywords'))
                            ->maxLength(60),
                    ]),
                Section::make(__('Open Graph Meta Tags'))
                    ->description(__('The Open Graph protocol is a markup that determines the type of link to a site in social networks and instant messengers. Thanks to this micro-markup, the correct image and the specified text with a brief description are added to the post, which makes the post look more attractive, it becomes like an ad in contextual advertising and gets more attention. Such a kind of banner significantly increases the click-through rate and the number of reposts.'))
                    ->schema([
                        TextInput::make('og_site_name')
                            ->label(__('OG site name'))
                            ->placeholder(__('OG site name'))
                            ->maxLength(60),
                        TextInput::make('og_title')
                            ->label(__('OG title'))
                            ->placeholder(__('OG title'))
                            ->maxLength(60),
                        Textarea::make('og_description')
                            ->label(__('OG description'))
                            ->placeholder(__('OG description'))
                            ->autosize()
                            ->rows(3)
                            ->maxLength(160),
                        TextInput::make('og_url')
                            ->label(__('OG url'))
                            ->placeholder(__('OG url'))
                            ->url()
                            ->maxLength(60),
                        TextInput::make('og_type')
                            ->label(__('OG type'))
                            ->placeholder(__('OG type'))
                            ->maxLength(100),
                        FileUpload::make('og_image')
                            ->label(__('OG image'))
                            ->image()
                            ->acceptedFileTypes(['image/jpg', 'image/jpeg', 'image/png'])
                            ->disk(getCurrentDisk())
                            ->directory('media')
                            ->visibility('public')
                            ->maxSize(1024)
                            ->afterStateUpdated(fn () => $this->validateOnly('data.og_image')),
                    ]),
            ])
            ->statePath('data');
    }

    public function store(SeoSettings $settings): void
    {
        $settings->meta_title = $this->form->getState()['meta_title'];
        $settings->meta_description = $this->form->getState()['meta_description'];
        $settings->meta_keywords = $this->form->getState()['meta_keywords'];
        $settings->og_site_name = $this->form->getState()['og_site_name'];
        $settings->og_title = $this->form->getState()['og_title'];
        $settings->og_description = $this->form->getState()['og_description'];
        $settings->og_url = $this->form->getState()['og_url'];
        $settings->og_type = $this->form->getState()['og_type'];

        if (! is_null($this->form->getState()['og_image'])) {
            $settings->og_image = $this->form->getState()['og_image'];
        } else {
            if (isset($settings->og_image) && Storage::disk(getCurrentDisk())->exists($settings->og_image)) {
                Storage::disk(getCurrentDisk())->delete($settings->og_image);

                $settings->og_image = '';
            }
        }

        $settings->save();

        Notification::make()
            ->success()
            ->title(__('Settings successfully updated'))
            ->seconds(10)
            ->send();
    }

    public function render()
    {
        return view('livewire.admin.settings.seo');
    }
}
