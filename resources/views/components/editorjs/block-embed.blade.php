<div class="content-block">
    @if (!empty($data))
        @foreach ($data as $key => $value)
            @if (($key == 'service' && $value == 'youtube') || ($key == 'service' && $value == 'vimeo'))
                <div class="aspect-w-16 aspect-h-9">
                    <iframe src="{{ $data['embed'] }}"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
            @elseif (($key == 'service' && $value == 'coub') ||
                ($key == 'service' && $value == 'gfycat') ||
                ($key == 'service' && $value == 'facebook'))
                <div class="w-content aspect-w-16 aspect-h-9">
                    <iframe src="{{ $data['embed'] }}"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
            @elseif ($key == 'service' && $value == 'instagram')
                <div class="w-content aspect-w-1 aspect-h-1">
                    <iframe src="{{ $data['embed'] }}"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
            @elseif ($key == 'service' && $value == 'twitter')
                <div class="w-content-embed-twitter aspect-w-1 aspect-h-1">
                    <iframe src="{{ $data['embed'] }}"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
            @endif
        @endforeach
    @endif

    @if (isset($data['caption']) && $data['caption'])
        <div class="w-content-embed-caption">{!! $data['caption'] !!}</div>
    @endif
</div>
