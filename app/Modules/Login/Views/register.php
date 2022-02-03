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
        <!-- app body @s -->
        <div class="nk-app-root">
            <div class="nk-split nk-split-page nk-split-md">
                <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container bg-white">
                    <div class="absolute-top-right d-lg-none p-3 p-sm-5">
                        <a href="#" class="toggle btn-white btn btn-icon btn-light" data-target="athPromo"><em class="icon ni ni-info"></em></a>
                    </div>
                    <div class="nk-block nk-block-middle nk-auth-body">
                        <div class="brand-logo pb-5">
                            <a href="html/index.html" class="logo-link">
                                <img class="logo-light logo-img logo-img-lg" src="<?= base_url('theme/images/logo.png'); ?>" alt="logo">
                                <img class="logo-dark logo-img logo-img-lg" src="<?= base_url('theme/images/logo-dark.png'); ?>" alt="logo-dark">
                            </a>
                        </div>
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h5 class="nk-block-title">Sign up</h5>
                                <div class="nk-block-des">
                                    <p>Insert your First Name, Last Name and Emailaddress and create a password.</p>
                                </div>
                            </div>
                        </div><!-- .nk-block-head -->

                        <?= $alerts; ?>

                        <form action="<?= base_url('login/register_proccess'); ?>" method="post">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="default-01">First Name</label>                                    
                                </div>
                                <input type="text" name="firstname" class="form-control form-control-lg" id="default-01" placeholder="Please enter you First Name">
                            </div>
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="default-01">Last Name</label>                                    
                                </div>
                                <input type="text" name="lastname" class="form-control form-control-lg" id="default-01" placeholder="Please enter you First Name">
                            </div>
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="default-01">Emailaddress</label>                                    
                                </div>
                                <input type="text" name="emailaddress" class="form-control form-control-lg" id="default-01" placeholder="Please enter you Emailaddress">
                            </div><!-- .foem-group -->
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="password">Password</label>                                    
                                </div>
                                <div class="form-control-wrap">                                    
                                    <input name="password" type="password" class="form-control form-control-lg" id="password" placeholder="<?= lang("Login.passcode_placeholder") ?>">
                                </div>
                            </div><!-- .foem-group -->
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label" for="password">Verify Password</label>                                    
                                </div>
                                <div class="form-control-wrap">                                    
                                    <input name="password2" type="password" class="form-control form-control-lg" id="password" placeholder="<?= lang("Login.passcode_placeholder") ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-primary btn-block">Sign up</button>
                            </div>
                        </form><!-- form -->                        
                    </div><!-- .nk-block -->
                    <div class="nk-block nk-auth-footer">
                        <div class="nk-block-between">
                            <ul class="nav nav-sm">
                                <li class="nav-item">
                                    <a class="nav-link" href="#"><?= lang("General.terms") ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#"><?= lang("General.privacy") ?></a>
                                </li>
                                <li class="nav-item dropup">
                                    <a class="dropdown-toggle dropdown-indicator has-indicator nav-link" data-toggle="dropdown" data-offset="0,10">
                                        <?php 
                                        if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'en') {
                                            echo '<small>English</small>';    
                                        } elseif(isset($_SESSION['lang']) && $_SESSION['lang'] == 'nl') {
                                            echo '<small>Nederlands</small>';    
                                        }
                                        ?>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                        <ul class="language-list">
                                            <li>
                                                <a href="<?= base_url('lang/nl'); ?>" class="language-item">
                                                    <img src="<?= base_url('theme/images/flags/dutch.png'); ?>" alt="" class="language-flag">
                                                    <span class="language-name"><?= lang("General.lang_nl") ?></span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= base_url('lang/en'); ?>" class="language-item">
                                                    <img src="<?= base_url('theme/images/flags/english.png'); ?>" alt="" class="language-flag">
                                                    <span class="language-name"><?= lang("General.lang_en") ?></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul><!-- .nav -->
                        </div>
                        <div class="mt-3">
                            <p>&copy; <?= date('Y'); ?> <?= lang("General.platform_tm") ?></p>
                        </div>
                    </div><!-- .nk-block -->
                </div><!-- .nk-split-content -->
                <div class="nk-split-content nk-split-stretch bg-image-yeelt"></div><!-- .nk-split-content -->
            </div><!-- .nk-split -->
        </div><!-- app body @e -->

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
