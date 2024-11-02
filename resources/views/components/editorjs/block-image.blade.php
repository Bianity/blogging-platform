@if ($data['stretched'])
    <figure class="content-block-image">
        <img src="{{ $data['file']->url }}" data-zoomable
            class="content-block-image{{ $data['stretched'] ? ' content-block-image--stretched' : '' }}"
            @if (isset($data['caption'])) alt="{{ strip_tags($data['caption']) }}" @endif>
        @if (isset($data['caption']) && $data['caption'])
            <figcaption class="content-block-image__caption">{!! $data['caption'] !!}</figcaption>
        @endif
    </figure>
@else
    <figure class="w-content content-block-image">
        <img src="{{ $data['file']->url }}" data-zoomable
            class="content-block-image{{ $data['withBorder'] ? ' content-block-image--with-border' : '' }} {{ $data['withBackground'] ? ' content-block-image--with-background' : '' }}"
            @if (isset($data['caption'])) alt="{{ strip_tags($data['caption']) }}" @endif>
        @if (isset($data['caption']) && $data['caption'])
            <figcaption class="content-block-image__caption">{!! $data['caption'] !!}</figcaption>
        @endif
    </figure>
@endif
