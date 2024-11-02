@component('mail::message')
    # A comment was posted on your article

    {{ $comment->user->name }} commented on your article:


    @component('mail::button', ['url' => url])
        Go to Article
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
