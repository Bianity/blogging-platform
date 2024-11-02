<?php

namespace App\Http\Controllers;

use App\Settings\SeoSettings;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function popular(SeoSettings $seoSettings)
    {
        if (config('alma.default_feed') === 'popular') {
            SEOMeta::addMeta('csrf-token', csrf_token(), 'name');
            SEOMeta::addMeta('viewport', 'width=device-width, initial-scale=1', 'name');
            SEOMeta::addMeta('X-UA-Compatible', 'IE=edge,chrome=1', 'http-equiv');
            SEOMeta::setTitle(isset($seoSettings->meta_title) ? $seoSettings->meta_title : __('Popular stories'));
            SEOMeta::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
            SEOMeta::setKeywords(isset($seoSettings->meta_keywords) ? $seoSettings->meta_keywords : null);
            SEOMeta::setRobots('index,follow,max-image-preview:large');
            SEOMeta::setCanonical(url()->current());

            OpenGraph::addProperty('site_name', $seoSettings->og_site_name);
            OpenGraph::addProperty('type', $seoSettings->og_type);
            OpenGraph::addProperty('locale', app()->getLocale());
            OpenGraph::setTitle(isset($seoSettings->meta_title) ? $seoSettings->meta_title : __('Popular stories'));
            OpenGraph::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
            OpenGraph::setUrl(url()->current());
            OpenGraph::addImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

            TwitterCard::setType('summary_large_image');
            TwitterCard::setTitle(isset($seoSettings->meta_title) ? $seoSettings->meta_title : __('Popular stories'));
            TwitterCard::setSite('@'.env('APP_NAME'));
            TwitterCard::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
            TwitterCard::setUrl(url()->current());
            TwitterCard::setImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

            JsonLd::setTitle(isset($seoSettings->meta_title) ? $seoSettings->meta_title : __('Popular stories'));
            JsonLd::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
            JsonLd::setType('Website');
            JsonLd::addImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));
        } else {
            SEOMeta::addMeta('csrf-token', csrf_token(), 'name');
            SEOMeta::addMeta('viewport', 'width=device-width, initial-scale=1', 'name');
            SEOMeta::addMeta('X-UA-Compatible', 'IE=edge,chrome=1', 'http-equiv');
            SEOMeta::setTitle(__('Popular stories'));
            SEOMeta::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
            SEOMeta::setKeywords(isset($seoSettings->meta_keywords) ? $seoSettings->meta_keywords : null);
            SEOMeta::setRobots('index,follow,max-image-preview:large');
            SEOMeta::setCanonical(url()->current());

            OpenGraph::addProperty('site_name', $seoSettings->og_site_name);
            OpenGraph::addProperty('type', $seoSettings->og_type);
            OpenGraph::addProperty('locale', app()->getLocale());
            OpenGraph::setTitle(__('Popular stories'));
            OpenGraph::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
            OpenGraph::setUrl(url()->current());
            OpenGraph::addImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

            TwitterCard::setType('summary_large_image');
            TwitterCard::setTitle(__('Popular stories'));
            TwitterCard::setSite('@'.env('APP_NAME'));
            TwitterCard::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
            TwitterCard::setUrl(url()->current());
            TwitterCard::setImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

            JsonLd::setTitle(__('Popular stories'));
            JsonLd::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
            JsonLd::setType('Website');
            JsonLd::addImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));
        }

        return view('home.popular');
    }

    public function latest(SeoSettings $seoSettings)
    {
        if (config('alma.default_feed') === 'latest') {
            SEOMeta::addMeta('csrf-token', csrf_token(), 'name');
            SEOMeta::addMeta('viewport', 'width=device-width, initial-scale=1', 'name');
            SEOMeta::addMeta('X-UA-Compatible', 'IE=edge,chrome=1', 'http-equiv');
            SEOMeta::setTitle(isset($seoSettings->meta_title) ? $seoSettings->meta_title : __('Latest stories'));
            SEOMeta::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
            SEOMeta::setKeywords(isset($seoSettings->meta_keywords) ? $seoSettings->meta_keywords : null);
            SEOMeta::setRobots('index,follow,max-image-preview:large');
            SEOMeta::setCanonical(url()->current());

            OpenGraph::addProperty('site_name', $seoSettings->og_site_name);
            OpenGraph::addProperty('type', $seoSettings->og_type);
            OpenGraph::addProperty('locale', app()->getLocale());
            OpenGraph::setTitle(isset($seoSettings->meta_title) ? $seoSettings->meta_title : __('Latest stories'));
            OpenGraph::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
            OpenGraph::setUrl(url()->current());
            OpenGraph::addImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

            TwitterCard::setType('summary_large_image');
            TwitterCard::setTitle(isset($seoSettings->meta_title) ? $seoSettings->meta_title : __('Latest stories'));
            TwitterCard::setSite('@'.env('APP_NAME'));
            TwitterCard::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
            TwitterCard::setUrl(url()->current());
            TwitterCard::setImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

            JsonLd::setTitle(isset($seoSettings->meta_title) ? $seoSettings->meta_title : __('Latest stories'));
            JsonLd::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
            JsonLd::setType('Website');
            JsonLd::addImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));
        } else {
            SEOMeta::addMeta('csrf-token', csrf_token(), 'name');
            SEOMeta::addMeta('viewport', 'width=device-width, initial-scale=1', 'name');
            SEOMeta::addMeta('X-UA-Compatible', 'IE=edge,chrome=1', 'http-equiv');
            SEOMeta::setTitle(__('Latest stories'));
            SEOMeta::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
            SEOMeta::setKeywords(isset($seoSettings->meta_keywords) ? $seoSettings->meta_keywords : null);
            SEOMeta::setRobots('index,follow,max-image-preview:large');
            SEOMeta::setCanonical(url()->current());

            OpenGraph::addProperty('site_name', $seoSettings->og_site_name);
            OpenGraph::addProperty('type', $seoSettings->og_type);
            OpenGraph::addProperty('locale', app()->getLocale());
            OpenGraph::setTitle(__('Latest stories'));
            OpenGraph::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
            OpenGraph::setUrl(url()->current());
            OpenGraph::addImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

            TwitterCard::setType('summary_large_image');
            TwitterCard::setTitle(__('Latest stories'));
            TwitterCard::setSite('@'.env('APP_NAME'));
            TwitterCard::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
            TwitterCard::setUrl(url()->current());
            TwitterCard::setImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

            JsonLd::setTitle(__('Latest stories'));
            JsonLd::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
            JsonLd::setType('Website');
            JsonLd::addImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));
        }

        return view('home.latest');
    }

    public function featured(SeoSettings $seoSettings)
    {
        SEOMeta::addMeta('csrf-token', csrf_token(), 'name');
        SEOMeta::addMeta('viewport', 'width=device-width, initial-scale=1', 'name');
        SEOMeta::addMeta('X-UA-Compatible', 'IE=edge,chrome=1', 'http-equiv');
        SEOMeta::setTitle(__('Featured stories'));
        SEOMeta::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        SEOMeta::setKeywords(isset($seoSettings->meta_keywords) ? $seoSettings->meta_keywords : null);
        SEOMeta::setRobots('index,follow,max-image-preview:large');
        SEOMeta::setCanonical(url()->current());

        OpenGraph::addProperty('site_name', $seoSettings->og_site_name);
        OpenGraph::addProperty('type', $seoSettings->og_type);
        OpenGraph::addProperty('locale', app()->getLocale());
        OpenGraph::setTitle(__('Featured stories'));
        OpenGraph::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        TwitterCard::setType('summary_large_image');
        TwitterCard::setTitle(__('Featured stories'));
        TwitterCard::setSite('@'.env('APP_NAME'));
        TwitterCard::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        TwitterCard::setUrl(url()->current());
        TwitterCard::setImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        JsonLd::setTitle(__('Featured stories'));
        JsonLd::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        JsonLd::setType('Website');
        JsonLd::addImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        return view('home.featured');
    }

    public function myFeed(SeoSettings $seoSettings)
    {
        SEOMeta::addMeta('csrf-token', csrf_token(), 'name');
        SEOMeta::addMeta('viewport', 'width=device-width, initial-scale=1', 'name');
        SEOMeta::addMeta('X-UA-Compatible', 'IE=edge,chrome=1', 'http-equiv');
        SEOMeta::setTitle(__('My Feed'));
        SEOMeta::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        SEOMeta::setKeywords(isset($seoSettings->meta_keywords) ? $seoSettings->meta_keywords : null);
        SEOMeta::setRobots('noindex,nofollow');
        SEOMeta::setCanonical(url()->current());

        OpenGraph::addProperty('site_name', $seoSettings->og_site_name);
        OpenGraph::addProperty('type', $seoSettings->og_type);
        OpenGraph::addProperty('locale', app()->getLocale());
        OpenGraph::setTitle(__('My Feed'));
        OpenGraph::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        TwitterCard::setType('summary_large_image');
        TwitterCard::setTitle(__('My Feed'));
        TwitterCard::setSite('@'.env('APP_NAME'));
        TwitterCard::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        TwitterCard::setUrl(url()->current());
        TwitterCard::setImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        JsonLd::setTitle(__('My Feed'));
        JsonLd::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        JsonLd::setType('Website');
        JsonLd::addImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        return view('home.myfeed');
    }

    public function savedStories(SeoSettings $seoSettings)
    {
        SEOMeta::addMeta('csrf-token', csrf_token(), 'name');
        SEOMeta::addMeta('viewport', 'width=device-width, initial-scale=1', 'name');
        SEOMeta::addMeta('X-UA-Compatible', 'IE=edge,chrome=1', 'http-equiv');
        SEOMeta::setTitle(__('Saved stories'));
        SEOMeta::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        SEOMeta::setKeywords(isset($seoSettings->meta_keywords) ? $seoSettings->meta_keywords : null);
        SEOMeta::setRobots('noindex,nofollow');
        SEOMeta::setCanonical(url()->current());

        OpenGraph::addProperty('site_name', $seoSettings->og_site_name);
        OpenGraph::addProperty('type', $seoSettings->og_type);
        OpenGraph::addProperty('locale', app()->getLocale());
        OpenGraph::setTitle(__('Saved stories'));
        OpenGraph::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        TwitterCard::setType('summary_large_image');
        TwitterCard::setTitle(__('Saved stories'));
        TwitterCard::setSite('@'.env('APP_NAME'));
        TwitterCard::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        TwitterCard::setUrl(url()->current());
        TwitterCard::setImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        JsonLd::setTitle(__('Saved stories'));
        JsonLd::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        JsonLd::setType('Website');
        JsonLd::addImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        return view('home.saved-stories');
    }

    public function savedComments(SeoSettings $seoSettings)
    {
        SEOMeta::addMeta('csrf-token', csrf_token(), 'name');
        SEOMeta::addMeta('viewport', 'width=device-width, initial-scale=1', 'name');
        SEOMeta::addMeta('X-UA-Compatible', 'IE=edge,chrome=1', 'http-equiv');
        SEOMeta::setTitle(__('Saved comments'));
        SEOMeta::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        SEOMeta::setKeywords(isset($seoSettings->meta_keywords) ? $seoSettings->meta_keywords : null);
        SEOMeta::setRobots('noindex,nofollow');
        SEOMeta::setCanonical(url()->current());

        OpenGraph::addProperty('site_name', $seoSettings->og_site_name);
        OpenGraph::addProperty('type', $seoSettings->og_type);
        OpenGraph::addProperty('locale', app()->getLocale());
        OpenGraph::setTitle(__('Saved comments'));
        OpenGraph::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        TwitterCard::setType('summary_large_image');
        TwitterCard::setTitle(__('Saved comments'));
        TwitterCard::setSite('@'.env('APP_NAME'));
        TwitterCard::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        TwitterCard::setUrl(url()->current());
        TwitterCard::setImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        JsonLd::setTitle(__('Saved comments'));
        JsonLd::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        JsonLd::setType('Website');
        JsonLd::addImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        return view('home.saved-comments');
    }

    public function topCommunities(SeoSettings $seoSettings)
    {
        SEOMeta::addMeta('csrf-token', csrf_token(), 'name');
        SEOMeta::addMeta('viewport', 'width=device-width, initial-scale=1', 'name');
        SEOMeta::addMeta('X-UA-Compatible', 'IE=edge,chrome=1', 'http-equiv');
        SEOMeta::setTitle(__('Top communities'));
        SEOMeta::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        SEOMeta::setKeywords(isset($seoSettings->meta_keywords) ? $seoSettings->meta_keywords : null);
        SEOMeta::setRobots('index,follow,max-image-preview:large');
        SEOMeta::setCanonical(url()->current());

        OpenGraph::addProperty('site_name', $seoSettings->og_site_name);
        OpenGraph::addProperty('type', $seoSettings->og_type);
        OpenGraph::addProperty('locale', app()->getLocale());
        OpenGraph::setTitle(__('Top communities'));
        OpenGraph::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        TwitterCard::setType('summary_large_image');
        TwitterCard::setTitle(__('Top communities'));
        TwitterCard::setSite('@'.env('APP_NAME'));
        TwitterCard::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        TwitterCard::setUrl(url()->current());
        TwitterCard::setImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        JsonLd::setTitle(__('Top communities'));
        JsonLd::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        JsonLd::setType('Website');
        JsonLd::addImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        return view('home.top-communities');
    }
}
