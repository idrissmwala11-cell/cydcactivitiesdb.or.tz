@once
    <style>
        .cydc-switch-logo {
            position: relative;
            display: inline-block;
            overflow: hidden;
        }

        .cydc-switch-logo__img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: inherit;
            backface-visibility: hidden;
        }

        .cydc-switch-logo__img--first {
            animation: cydcLogoFadeFirst 8s infinite;
        }

        .cydc-switch-logo__img--second {
            animation: cydcLogoFadeSecond 8s infinite;
        }

        @keyframes cydcLogoFadeFirst {
            0%, 45% { opacity: 1; transform: scale(1); }
            50%, 95% { opacity: 0; transform: scale(0.98); }
            100% { opacity: 1; transform: scale(1); }
        }

        @keyframes cydcLogoFadeSecond {
            0%, 45% { opacity: 0; transform: scale(1.02); }
            50%, 95% { opacity: 1; transform: scale(1); }
            100% { opacity: 0; transform: scale(1.02); }
        }
    </style>
@endonce

<span {{ $attributes->merge(['class' => 'cydc-switch-logo']) }}>
    <img src="{{ asset('public/logos/church-logo-1.jpeg') }}" alt="Church Logo 1" class="cydc-switch-logo__img cydc-switch-logo__img--first">
    <img src="{{ asset('public/logos/church-logo-2.jpeg') }}" alt="Church Logo 2" class="cydc-switch-logo__img cydc-switch-logo__img--second">
</span>
