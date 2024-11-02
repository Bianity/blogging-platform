<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\User;
use App\Settings\SeoSettings;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

class StoryController extends Controller
{
    use AuthorizesRequests;

    public function create(SeoSettings $seoSettings)
    {
        $this->authorize('add_stories');

        SEOMeta::addMeta('csrf-token', csrf_token(), 'name');
        SEOMeta::addMeta('viewport', 'width=device-width, initial-scale=1', 'name');
        SEOMeta::addMeta('X-UA-Compatible', 'IE=edge,chrome=1', 'http-equiv');
        SEOMeta::setTitle(__('New Story'));
        SEOMeta::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        SEOMeta::setKeywords(isset($seoSettings->meta_keywords) ? $seoSettings->meta_keywords : null);
        SEOMeta::setRobots('noindex,nofollow');
        SEOMeta::setCanonical(url()->current());

        OpenGraph::addProperty('site_name', $seoSettings->og_site_name);
        OpenGraph::addProperty('type', $seoSettings->og_type);
        OpenGraph::addProperty('locale', app()->getLocale());
        OpenGraph::setTitle(__('New Story'));
        OpenGraph::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        TwitterCard::setType('summary_large_image');
        TwitterCard::setTitle(__('New Story'));
        TwitterCard::setSite('@'.env('APP_NAME'));
        TwitterCard::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        TwitterCard::setUrl(url()->current());
        TwitterCard::setImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        JsonLd::setTitle(__('New Story'));
        JsonLd::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        JsonLd::setType('Website');
        JsonLd::addImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        return view('story.create');
    }

    public function show(Story $story, User $user, SeoSettings $seoSettings)
    {
        $mediaItems = $story->getMedia('featured-image');
        $publicFullUrl = isset($mediaItems[0]) ? $mediaItems[0]->getFullUrl() : null;

        SEOMeta::addMeta('csrf-token', csrf_token(), 'name');
        SEOMeta::addMeta('viewport', 'width=device-width, initial-scale=1', 'name');
        SEOMeta::addMeta('X-UA-Compatible', 'IE=edge,chrome=1', 'http-equiv');
        SEOMeta::addMeta('author', $story->user->username);
        SEOMeta::setTitle(isset($story->meta['meta_title']) ? $story->meta['meta_title'] : $story->title);
        SEOMeta::setDescription(isset($story->meta['meta_description']) ? $story->meta['meta_description'] : $story->summary);
        SEOMeta::setKeywords(isset($story->meta['meta_keywords']) ? $story->meta['meta_keywords'] : $story->allTagsList());
        SEOMeta::setRobots('index,follow,max-image-preview:large');
        SEOMeta::setCanonical(isset($story->meta['meta_canonical_url']) ? $story->meta['meta_canonical_url'] : url()->current());

        if ($story->isPublished()) {
            SEOMeta::addMeta('article:published_time', $story->published_at->toW3CString(), 'property');
        }
        if (isset($story->community)) {
            SEOMeta::addMeta('article:section', $story->community->name, 'property');
        }

        OpenGraph::addProperty('site_name', $seoSettings->og_site_name);
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', app()->getLocale());
        OpenGraph::setTitle(isset($story->meta['meta_title']) ? $story->meta['meta_title'] : $story->title);
        OpenGraph::setDescription(isset($story->meta['meta_description']) ? $story->meta['meta_description'] : $story->summary);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addImage(isset($publicFullUrl) ? $publicFullUrl : Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        TwitterCard::setType('summary_large_image');
        TwitterCard::setTitle(isset($story->meta['meta_title']) ? $story->meta['meta_title'] : $story->title);
        TwitterCard::setSite('@'.env('APP_NAME'));
        TwitterCard::setDescription(isset($story->meta['meta_description']) ? $story->meta['meta_description'] : $story->summary);
        TwitterCard::setUrl(url()->current());
        TwitterCard::setImage(isset($publicFullUrl) ? $publicFullUrl : Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        JsonLd::setTitle(isset($story->meta['meta_title']) ? $story->meta['meta_title'] : $story->title);
        JsonLd::setDescription(isset($story->meta['meta_description']) ? $story->meta['meta_description'] : $story->summary);
        JsonLd::setType('Article');
        JsonLd::addImage(isset($publicFullUrl) ? $publicFullUrl : Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        if ($story->isPublished()) {
            views($story)->cooldown(now()->addHours(24))->record();
        }

        return view('story.show', compact('story'));
    }

    public function edit(Story $story, SeoSettings $seoSettings)
    {
        $this->authorize('update', $story);

        SEOMeta::addMeta('csrf-token', csrf_token(), 'name');
        SEOMeta::addMeta('viewport', 'width=device-width, initial-scale=1', 'name');
        SEOMeta::addMeta('X-UA-Compatible', 'IE=edge,chrome=1', 'http-equiv');
        SEOMeta::setTitle(__('Edit Story'));
        SEOMeta::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        SEOMeta::setKeywords(isset($seoSettings->meta_keywords) ? $seoSettings->meta_keywords : null);
        SEOMeta::setRobots('noindex,nofollow');
        SEOMeta::setCanonical(url()->current());

        OpenGraph::addProperty('site_name', $seoSettings->og_site_name);
        OpenGraph::addProperty('type', $seoSettings->og_type);
        OpenGraph::addProperty('locale', app()->getLocale());
        OpenGraph::setTitle(__('Edit Story'));
        OpenGraph::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        TwitterCard::setType('summary_large_image');
        TwitterCard::setTitle(__('Edit Story'));
        TwitterCard::setSite('@'.env('APP_NAME'));
        TwitterCard::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        TwitterCard::setUrl(url()->current());
        TwitterCard::setImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        JsonLd::setTitle(__('Edit Story'));
        JsonLd::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        JsonLd::setType('Website');
        JsonLd::addImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        return view('story.edit')->with('story', $story);
    }
}
