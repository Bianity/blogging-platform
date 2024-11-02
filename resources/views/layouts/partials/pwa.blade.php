<!-- Web Application Manifest -->
<link rel="manifest" href="{{ route('pwa.manifest') }}">
<!-- Chrome for Android theme color -->
<meta name="theme-color" content="{{ config('pwa.manifest.theme_color') }}">
<!-- Add to homescreen for Chrome on Android -->
<meta name="mobile-web-app-capable" content="{{ config('pwa.manifest.display') }}">
<meta name="application-name" content="{{ config('pwa.manifest.short_name') }}">
<link rel="icon" sizes="512x512" href="{{ asset(config('pwa.manifest.icons.512x512.path')) }}">
<!-- Add to homescreen for Safari on iOS -->
<meta name="apple-mobile-web-app-capable" content="{{ config('pwa.manifest.display') }}">
<meta name="apple-mobile-web-app-status-bar-style" content="{{ config('pwa.manifest.status_bar') }}">
<meta name="apple-mobile-web-app-title" content="{{ config('pwa.manifest.short_name') }}">
<link rel="apple-touch-icon" sizes="72x72" href="{{ asset(config('pwa.manifest.icons.72x72.path')) }}">
<link rel="apple-touch-icon" sizes="96x96" href="{{ asset(config('pwa.manifest.icons.96x96.path')) }}">
<link rel="apple-touch-icon" sizes="128x128" href="{{ asset(config('pwa.manifest.icons.144x144.path')) }}">
<link rel="apple-touch-icon" sizes="144x144" href="{{ asset(config('pwa.manifest.icons.128x128.path')) }}">
<link rel="apple-touch-icon" sizes="152x152" href="{{ asset(config('pwa.manifest.icons.152x152.path')) }}">
<link rel="apple-touch-icon" sizes="192x192" href="{{ asset(config('pwa.manifest.icons.192x192.path')) }}">
<link rel="apple-touch-icon" sizes="384x384" href="{{ asset(config('pwa.manifest.icons.384x384.path')) }}">
<link rel="apple-touch-icon" sizes="512x512" href="{{ asset(config('pwa.manifest.icons.512x512.path')) }}">
