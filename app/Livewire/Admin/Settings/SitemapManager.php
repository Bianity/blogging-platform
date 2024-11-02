<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Community;
use App\Models\Page;
use App\Models\Story;
use App\Models\User;
use App\Settings\SeoSettings;
use Carbon\Carbon;
use Cviebrock\EloquentTaggable\Models\Tag;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;
use Livewire\Component;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\Crawler;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;

class SitemapManager extends Component
{
    public $sitemapUpdatedDate;

    public function mount(SeoSettings $seoSettings)
    {
        $this->sitemapUpdatedDate = $seoSettings->sitemap_update;
    }

    public function update(SeoSettings $seoSettings)
    {
        $generator = SitemapGenerator::create(config('app.url'))
            ->maxTagsPerSitemap(10000)
            ->configureCrawler(function (Crawler $crawler) {
                $crawler
                    ->setUserAgent(config('app.name').'/'.app()->version())
                    ->setDelayBetweenRequests(150)
                    ->setParseableMimeTypes(['text/html']);
            })
            ->shouldCrawl(function (UriInterface $url) {
                // Only internal urls
                if (parse_url(config('app.url'), PHP_URL_HOST) !== $url->getHost()) {
                    return false;
                }

                // Don't crawl the models directly, we will add them later on.
                if (Str::startsWith($url->getPath(), '/story/')) {
                    return false;
                }

                if (Str::startsWith($url->getPath(), '/tag/')) {
                    return false;
                }

                if (Str::startsWith($url->getPath(), '/c/')) {
                    return false;
                }

                if (Str::startsWith($url->getPath(), '/p/')) {
                    return false;
                }

                // No pagination
                if (Str::contains($url->getQuery(), 'page=')) {
                    return false;
                }

                return true;
            })
            ->hasCrawled(function (Url $url) {
                // Ignore urls with trailing slash
                if (Str::endsWith($url->url, '/')) {
                    return;
                }

                if ($url->segment(1) === 'login') {
                    return;
                }
                if ($url->segment(1) === 'register') {
                    return;
                }
                if ($url->segment(1) === '') {
                    return;
                }
                if ($url->segment(1) === 'latest') {
                    return;
                }
                if ($url->segment(1) === 'featured') {
                    return;
                }
                if ($url->segment(1) === 'communities') {
                    return;
                }
                if ($url->segment(1) === 'contact') {
                    return;
                }

                // Ignore crawled users, we will add them later on.
                $users = User::all();
                foreach ($users as $user) {
                    if ($url->segment(1) === "$user->username") {
                        return;
                    }
                }

                return $url;
            });

        $sitemap = $generator->getSitemap();

        // Generate Base map
        $sitemap->add(Url::create('/')->setPriority(1)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));
        $sitemap->add(Url::create('/latest')->setPriority(0.7)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));
        $sitemap->add(Url::create('/featured')->setPriority(0.7)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
        $sitemap->add(Url::create('/communities')->setPriority(0.7)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
        $sitemap->add(Url::create('/contact')->setPriority(0.7)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
        $sitemap->writeToFile(public_path('/base_sitemap.xml'));

        // Generate Users map
        $usersMap = Sitemap::create();
        User::get()->each(function (User $user) use ($usersMap) {
            $usersMap->add(
                Url::create("{$user->username}")
                    ->setPriority(0.7)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            );
        });
        $usersMap->writeToFile(public_path('/users_sitemap.xml'));

        // Generate Tags map
        $tagsMap = Sitemap::create();
        Tag::get()->each(function (Tag $tag) use ($tagsMap) {
            $tagsMap->add(
                Url::create("/tag/{$tag->normalized}")
                    ->setPriority(0.7)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            );
        });
        $tagsMap->writeToFile(public_path('/tags_sitemap.xml'));

        // Generate Pages map
        $pagesMap = Sitemap::create();
        Page::get()->each(function (Page $page) use ($pagesMap) {
            $pagesMap->add(
                Url::create("/p/{$page->slug}")
                    ->setPriority(0.7)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            );
        });
        $pagesMap->writeToFile(public_path('/pages_sitemap.xml'));

        // Generate Communities map
        $communitiesMap = Sitemap::create();
        Community::get()->each(function (Community $community) use ($communitiesMap) {
            $communitiesMap->add(
                Url::create("/c/{$community->slug}")
                    ->setPriority(0.7)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            );
        });
        $communitiesMap->writeToFile(public_path('/communities_sitemap.xml'));

        // Generate Stories map
        $storiesMap = Sitemap::create();
        Story::get()->each(function (Story $story) use ($storiesMap) {
            $storiesMap->add(
                Url::create("/story/{$story->slug}")
                    ->setPriority(0.9)
                    ->setLastModificationDate($story->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            );
        });
        $storiesMap->writeToFile(public_path('/stories_sitemap.xml'));

        SitemapIndex::create()
            ->add('/base_sitemap.xml')
            ->add('/stories_sitemap.xml')
            ->add('/communities_sitemap.xml')
            ->add('/tags_sitemap.xml')
            ->add('/users_sitemap.xml')
            ->add('/pages_sitemap.xml')
            ->writeToFile(public_path('sitemaps.xml'));

        // Saving last update date
        $seoSettings->sitemap_update = Carbon::now();
        $seoSettings->save();

        Notification::make()
            ->success()
            ->title(__('Sitemap successfully updated'))
            ->seconds(10)
            ->send();
    }

    public function render()
    {
        return view('livewire.admin.settings.sitemap-manager');
    }
}
