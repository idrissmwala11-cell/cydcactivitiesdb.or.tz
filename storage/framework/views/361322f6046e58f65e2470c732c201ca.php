<?php if (! $__env->hasRenderedOnce('f961da8d-b1a8-408a-82af-639e3add8130')): $__env->markAsRenderedOnce('f961da8d-b1a8-408a-82af-639e3add8130'); ?>
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
<?php endif; ?>

<span <?php echo e($attributes->merge(['class' => 'cydc-switch-logo'])); ?>>
    <img src="<?php echo e(asset('public/logos/church-logo-1.jpeg')); ?>" alt="Church Logo 1" class="cydc-switch-logo__img cydc-switch-logo__img--first">
    <img src="<?php echo e(asset('public/logos/church-logo-2.jpeg')); ?>" alt="Church Logo 2" class="cydc-switch-logo__img cydc-switch-logo__img--second">
</span>
<?php /**PATH /home/cydcacti/cydcactivitiesdb.or.tz/resources/views/components/application-logo.blade.php ENDPATH**/ ?>