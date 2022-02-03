<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags  -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <title><?= lang("General.platform_tm") ?></title>
        <link rel="icon" type="image/png" href="<?= site_url('/theme/images/favicon.png'); ?>" />

        <?php $append = (ENVIRONMENT !== 'production') ? '?v='.time() : ''; ?>

        <!--Core CSS -->
        <link rel="stylesheet" href="<?= site_url('/theme/assets/css/yeelt.css'.$append); ?>">
        <link rel="stylesheet" href="<?= site_url('/theme/assets/css/theme.css'.$append); ?>">

        <link rel="stylesheet" href="<?= site_url('/theme/assets/css/custom.css'.$append); ?>">
    </head>

    <body class="nk-body npc-crypto bg-white pg-auth">
        <!-- Content -->
        <div class="content-wrapper mt-5">
            <div class="dark" style="background-image: url(<?php echo base_url('themes/admin/images/motherboard1.png'); ?>);">
                <div class="p-4 p-md-5">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="<?php echo base_url('codeflowdemo/out'); ?>" class="btn btn-success">Login with bol</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        /**
         * Set javascript based on release version
         * For development we use a timestamp to always load the newest version
         */
        $getversioninfo = getenv('CI_RELEASE');
        $appendurl = (ENVIRONMENT == 'development') ? time() : $getversioninfo; 
        ?>
        <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
        <script src="<?= site_url('/theme/assets/js/bundle.js?v='.$appendurl); ?>"></script>
        <script src="<?= site_url('/theme/assets/js/scripts.js?v='.$appendurl); ?>"></script>
    </body>
</html>
