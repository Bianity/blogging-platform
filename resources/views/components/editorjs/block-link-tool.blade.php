<div class="link-embed">
    <a href="{{ $data['link'] }}" class="link-embed__link"
        @if (!\Illuminate\Support\Str::startsWith($data['link'], env('APP_URL'))) target="_blank" rel="nofollow" @endif>
        <div class="link-embed__image-wrapper">
            <img src="{{ $data['image']->url }}" class="link-embed__image" alt="{{ $data['title'] }}">
        </div>
        <div class="link-embed__info">
            <p class="link-embed__title">{{ $data['title'] }}</p>
            <p class="link-embed__description">{{ $data['description'] }}</p>
            <p class="link-embed__url">{{ $data['link'] }}</p>
        </div>
    </a>
</div>
