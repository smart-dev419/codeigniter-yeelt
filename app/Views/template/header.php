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
        <link rel="stylesheet" href="<?= site_url('/theme/assets/css/yeelt.css'); ?>">
        <link rel="stylesheet" href="<?= site_url('/theme/assets/css/theme.css'); ?>">
        
        <?php 
        // Load CSS assets if available
        if(isset($assets) && isset($assets['css'])) {
            if(!isset($assets_path)) {
                $assets_path = '';
            }
            foreach($assets['css'] as $assets_css) {
                if(strpos($assets_css, 'http') === false) {
                    echo "\t\t<link href='".site_url($assets_path.'css/'.$assets_css)."' rel='stylesheet'>\n";
                } else {
                    echo "\t\t<link href='".$assets_css."' rel='stylesheet'>\n";
                }
            }
        }
        ?>

        <link rel="stylesheet" href="<?= site_url('/theme/assets/css/custom.css'.$append); ?>">
    </head>
    <body class="nk-body bg-white has-sidebar <?php if(isset($_COOKIE['yeelt-dark-mode']) && $_COOKIE['yeelt-dark-mode'] == 1) { echo 'dark-mode'; } ?>">
        <div class="nk-app-root">
            <!-- main @s --> 
            <div class="nk-main ">
                <!-- sidebar @s -->