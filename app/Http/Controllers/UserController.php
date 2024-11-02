<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Settings\SeoSettings;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function show(User $user, SeoSettings $seoSettings)
    {
        SEOMeta::addMeta('csrf-token', csrf_token(), 'name');
        SEOMeta::addMeta('viewport', 'width=device-width, initial-scale=1', 'name');
        SEOMeta::addMeta('X-UA-Compatible', 'IE=edge,chrome=1', 'http-equiv');
        SEOMeta::setTitle(isset($user->name) ? $user->name : $user->username);
        SEOMeta::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        SEOMeta::setKeywords(isset($seoSettings->meta_keywords) ? $seoSettings->meta_keywords : null);
        SEOMeta::setRobots('index,follow,max-image-preview:large');
        SEOMeta::setCanonical(url()->current());

        OpenGraph::addProperty('site_name', $seoSettings->og_site_name);
        OpenGraph::addProperty('type', $seoSettings->og_type);
        OpenGraph::addProperty('locale', app()->getLocale());
        OpenGraph::setTitle(isset($user->name) ? $user->name : $user->username);
        OpenGraph::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        TwitterCard::setType('summary_large_image');
        TwitterCard::setTitle(isset($user->name) ? $user->name : $user->username);
        TwitterCard::setSite('@'.env('APP_NAME'));
        TwitterCard::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        TwitterCard::setUrl(url()->current());
        TwitterCard::setImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        JsonLd::setTitle(isset($user->name) ? $user->name : $user->username);
        JsonLd::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        JsonLd::setType('Website');
        JsonLd::addImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        return view('user.show', compact('user'));
    }

    public function settings(User $user, SeoSettings $seoSettings)
    {
        SEOMeta::addMeta('csrf-token', csrf_token(), 'name');
        SEOMeta::addMeta('viewport', 'width=device-width, initial-scale=1', 'name');
        SEOMeta::addMeta('X-UA-Compatible', 'IE=edge,chrome=1', 'http-equiv');
        SEOMeta::setTitle(isset($user->name) ? $user->name : $user->username.' '.__('Settings'));
        SEOMeta::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        SEOMeta::setKeywords(isset($seoSettings->meta_keywords) ? $seoSettings->meta_keywords : null);
        SEOMeta::setRobots('noindex,nofollow');
        SEOMeta::setCanonical(url()->current());

        OpenGraph::addProperty('site_name', $seoSettings->og_site_name);
        OpenGraph::addProperty('type', $seoSettings->og_type);
        OpenGraph::addProperty('locale', app()->getLocale());
        OpenGraph::setTitle(isset($user->name) ? $user->name : $user->username.' '.__('Settings'));
        OpenGraph::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        TwitterCard::setType('summary_large_image');
        TwitterCard::setTitle(isset($user->name) ? $user->name : $user->username.' '.__('Settings'));
        TwitterCard::setSite('@'.env('APP_NAME'));
        TwitterCard::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        TwitterCard::setUrl(url()->current());
        TwitterCard::setImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        JsonLd::setTitle(isset($user->name) ? $user->name : $user->username.' '.__('Settings'));
        JsonLd::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        JsonLd::setType('Website');
        JsonLd::addImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        return view('user.settings', compact('user'));
    }
}
