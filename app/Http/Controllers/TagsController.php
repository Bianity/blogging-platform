<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Settings\SeoSettings;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Cviebrock\EloquentTaggable\Models\Tag;
use Illuminate\Support\Facades\Storage;

class TagsController extends Controller
{
    public function index(SeoSettings $seoSettings)
    {
        SEOMeta::addMeta('csrf-token', csrf_token(), 'name');
        SEOMeta::addMeta('viewport', 'width=device-width, initial-scale=1', 'name');
        SEOMeta::addMeta('X-UA-Compatible', 'IE=edge,chrome=1', 'http-equiv');
        SEOMeta::setTitle(__('Popular Tags'));
        SEOMeta::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        SEOMeta::setKeywords(isset($seoSettings->meta_keywords) ? $seoSettings->meta_keywords : null);
        SEOMeta::setRobots('index,follow,max-image-preview:large');
        SEOMeta::setCanonical(url()->current());

        OpenGraph::addProperty('site_name', $seoSettings->og_site_name);
        OpenGraph::addProperty('type', $seoSettings->og_type);
        OpenGraph::addProperty('locale', app()->getLocale());
        OpenGraph::setTitle(__('Popular Tags'));
        OpenGraph::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        TwitterCard::setType('summary_large_image');
        TwitterCard::setTitle(__('Popular Tags'));
        TwitterCard::setSite('@'.env('APP_NAME'));
        TwitterCard::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        TwitterCard::setUrl(url()->current());
        TwitterCard::setImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        JsonLd::setTitle(__('Popular Tags'));
        JsonLd::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        JsonLd::setType('Website');
        JsonLd::addImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        return view('tags.index');
    }

    public function show(Tag $tag, Story $story, SeoSettings $seoSettings)
    {
        SEOMeta::addMeta('csrf-token', csrf_token(), 'name');
        SEOMeta::addMeta('viewport', 'width=device-width, initial-scale=1', 'name');
        SEOMeta::addMeta('X-UA-Compatible', 'IE=edge,chrome=1', 'http-equiv');
        SEOMeta::setTitle($tag->name);
        SEOMeta::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        SEOMeta::setKeywords(isset($seoSettings->meta_keywords) ? $seoSettings->meta_keywords : null);
        SEOMeta::setRobots('index,follow,max-image-preview:large');
        SEOMeta::setCanonical(url()->current());

        OpenGraph::addProperty('site_name', $seoSettings->og_site_name);
        OpenGraph::addProperty('type', $seoSettings->og_type);
        OpenGraph::addProperty('locale', app()->getLocale());
        OpenGraph::setTitle($tag->name);
        OpenGraph::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        TwitterCard::setType('summary_large_image');
        TwitterCard::setTitle($tag->name);
        TwitterCard::setSite('@'.env('APP_NAME'));
        TwitterCard::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        TwitterCard::setUrl(url()->current());
        TwitterCard::setImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        JsonLd::setTitle($tag->name);
        JsonLd::setDescription(isset($seoSettings->meta_description) ? $seoSettings->meta_description : null);
        JsonLd::setType('Website');
        JsonLd::addImage(Storage::disk(getCurrentDisk())->url($seoSettings->og_image));

        return view('tags.show', compact('tag', 'story'));
    }
}
