@if ($data['style'] == 'ordered')
    <ol class="w-content content-block-list-ordered">
    @elseif($data['style'] == 'unordered')
        <ul class="w-content content-block-list-unordered">
@endif

@foreach ($data['items'] as $item)
    <li class="content-block-list-item">{!! $item !!}</li>
@endforeach

@if ($data['style'] == 'ordered')
    </ol>
@elseif($data['style'] == 'unordered')
    </ul>
@endif
