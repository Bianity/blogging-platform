<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
{!! SEOMeta::generate() !!}
{!! OpenGraph::generate() !!}
{!! Twitter::generate() !!}
{!! JsonLd::generate() !!}
<link rel="shortcut icon"
    href="{{ $generalSettings->site_favicon ? Storage::disk(getCurrentDisk())->url($generalSettings->site_favicon) : asset('images/favicon.png') }}"
    type="image/png">
@if (config('alma.pwa_active') === true)
    @include('layouts.partials.pwa')
@endif
<script>
    if (localStorage.getItem('darkMode') === 'false' || (!('darkMode' in localStorage))) {
        document.documentElement.classList.remove('dark');
    } else {
        document.documentElement.classList.add('dark');
    }
</script>

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family={{ config('alma.default_font') }}:wght@400;600;700&display=swap">

<!-- Styles -->
<style>
    .font-sans {
        font-family: @php echo config('alma.default_font')
    @endphp
    ,
    sans-serif !important;
    }
</style>
@stack('styles')

<!-- Scripts -->
<wireui:scripts />
@vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/tagify.css', 'resources/js/tagify.js'])
@if ($advancedSettings->google_analytics_code !== '')
    {!! $advancedSettings->google_analytics_code !!}
@endif
@if ($advancedSettings->custom_head_code !== '')
    {!! $advancedSettings->custom_head_code !!}
@endif
