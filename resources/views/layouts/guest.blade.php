<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=20260621b">
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=20260621b">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=20260621b">
        <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}?v=20260621b">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            @media screen and (min-width: 769px) {
                html {
                    font-size: 80%;
                }
            }

            @media print {
                html {
                    font-size: 100%;
                }
            }

            :root {
                --system-bg-image: url('{{ asset('public/images/system-background.png') }}?v=20260705');
            }

            body.system-photo-bg {
                min-height: 100vh;
                position: relative;
                isolation: isolate;
                background:
                    linear-gradient(135deg, rgba(102, 126, 234, 0.48), rgba(118, 75, 162, 0.44)),
                    var(--system-bg-image) center / cover fixed no-repeat !important;
            }

            body.system-photo-bg::before {
                content: "";
                position: fixed;
                inset: -26px;
                z-index: -2;
                pointer-events: none;
                background-image: var(--system-bg-image);
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                filter: blur(9px);
                opacity: 0.52;
                transform: scale(1.04);
            }

            body.system-photo-bg::after {
                content: "";
                position: fixed;
                inset: 0;
                z-index: -1;
                pointer-events: none;
                background:
                    linear-gradient(135deg, rgba(102, 126, 234, 0.42), rgba(118, 75, 162, 0.40)),
                    radial-gradient(circle at 50% 18%, rgba(255,255,255,0.18), transparent 34%);
            }

            .guest-auth-card {
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
            }
        </style>
    </head>
    <body class="system-photo-bg font-sans text-gray-900 antialiased">
        <!-- Animated background elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-white opacity-10 rounded-full animate-pulse"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-white opacity-5 rounded-full animate-pulse" style="animation-delay: 2s;"></div>
        </div>
        
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-10">
            <!-- Logo Section -->
            <div class="mb-8">
                <a href="/" class="block transform hover:scale-105 transition duration-300">
                    <x-application-logo class="w-24 h-24 fill-current text-white drop-shadow-lg" />
                </a>
            </div>

            <!-- Form Container -->
            <div class="w-full sm:max-w-md px-4 sm:px-0">
                <div class="guest-auth-card bg-white/95 backdrop-blur-sm shadow-2xl overflow-hidden rounded-2xl border border-white/20">
                    <div class="px-6 sm:px-8 py-8">
                        <div class="space-y-6">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-white/80 text-sm">© 2025 CYDC. All rights reserved.</p>
            </div>
        </div>
    </body>
</html>
