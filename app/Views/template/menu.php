<!-- sidebar @s -->
<div class="nk-sidebar nk-sidebar-fixed " data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head"> 
        <div class="nk-sidebar-brand">
            <a href="<?= base_url(); ?>" class="logo-link nk-sidebar-logo">
                <img class="logo-light logo-img" src="<?= base_url('theme/images/logo.png'); ?>" alt="logo">
                <img class="logo-dark logo-img" src="<?= base_url('theme/images/logo-dark.png'); ?>" alt="logo-dark">
            </a>
        </div>
        <div class="nk-menu-trigger mr-n2">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
        </div>
    </div><!-- .nk-sidebar-element -->
    <div class="nk-sidebar-element">
        <div class="nk-sidebar-body" data-simplebar>
            <div class="nk-sidebar-content">
                <div class="nk-sidebar-menu">
                    <ul class="nk-menu">
                        <li class="nk-menu-heading">
                            <h6 class="overline-title text-primary-alt"><?= lang('General.change_seller'); ?></h6>
                        </li><!-- .nk-menu-item -->
                        <li class="nk-menu-item" style="margin: 0 20px;">
                            <div class="form-control-wrap">
                                <form action="<?= base_url('login/switch_seller'); ?>" id="form_switch" method="post">
                                <select id="switch_seller" name="switch_seller" class="form-select form-control form-control-lg">
                                    <?php 
                                    foreach($seller_choices as $choice) :
                                        $selected = ($choice['SellersKey'] == $_SESSION['sellerData']['SellersKey']) ? 'selected="selected"' : '';
                                        echo '<option value="'.$choice['SellersKey'].'" '.$selected.'>'.$choice['Name'].'</option>';
                                    endforeach;
                                    ?>
                                </select>
                                </form>
                            </div>
                        </li><!-- .nk-menu-item -->
                        <li class="nk-menu-heading">
                            <h6 class="overline-title text-primary-alt">Insights</h6>
                        </li><!-- .nk-menu-item -->
                        <li class="nk-menu-item">
                            <a href="<?= base_url('overview'); ?>" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-eye"></em></span>
                                <span class="nk-menu-text">Overview</span>
                            </a>
                        </li><!-- .nk-menu-item -->
                        <li class="nk-menu-item" style="opacity: 0.5;">
                            <a href="#" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-coins"></em></span>
                                <span class="nk-menu-text">Revenue & sales</span>
                            </a>
                        </li><!-- .nk-menu-item -->
                        <li class="nk-menu-item" style="opacity: 0.5;">
                            <a href="#" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-growth"></em></span>
                                <span class="nk-menu-text">Rankings</span>
                            </a>
                        </li><!-- .nk-menu-item -->
                        <li class="nk-menu-item" style="opacity: 0.5;">
                            <a href="#" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-user"></em></span>
                                <span class="nk-menu-text">Consultancy</span>
                                <span class="nk-menu-icon text-warning ml-auto"><em class="icon ni ni-lock"></em></span>
                            </a>
                        </li><!-- .nk-menu-item -->
                        <li class="nk-menu-heading">
                            <h6 class="overline-title text-primary-alt">Manage</h6>
                        </li><!-- .nk-menu-heading -->
                        <li class="nk-menu-item has-sub">
                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                <span class="nk-menu-icon"><em class="icon ni ni-list"></em></span>
                                <span class="nk-menu-text">Keywords</span>
                            </a>
                            <ul class="nk-menu-sub">
                                <li class="nk-menu-item">
                                    <a href="<?= base_url('keywords/list'); ?>" class="nk-menu-link"><span class="nk-menu-text">Active keywords</span></a>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="<?= base_url('keywords/suggestions'); ?>" class="nk-menu-link"><span class="nk-menu-text">Suggestions</span></a>
                                </li>
                            </ul><!-- .nk-menu-sub -->
                        </li>
                        <li class="nk-menu-item">
                            <a href="<?= base_url('products'); ?>" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-bag"></em></span>
                                <span class="nk-menu-text">Products</span>
                            </a>
                        </li>
                        <li class="nk-menu-heading">
                            <h6 class="overline-title text-primary-alt">Seller</h6>
                        </li><!-- .nk-menu-heading -->
                        <li class="nk-menu-item has-sub">
                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                <span class="nk-menu-icon"><em class="icon ni ni-tranx"></em></span>
                                <span class="nk-menu-text">Settings</span>
                            </a>
                            <ul class="nk-menu-sub">
                                <li class="nk-menu-item">
                                    <a href="<?= base_url('settings'); ?>" class="nk-menu-link"><span class="nk-menu-text">General settings</span></a>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="<?= base_url('settings/users'); ?>" class="nk-menu-link"><span class="nk-menu-text">Users</span></a>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="<?= base_url('settings/logo'); ?>" class="nk-menu-link"><span class="nk-menu-text">Logo</span></a>
                                </li>
                            </ul><!-- .nk-menu-sub -->
                        </li><!-- .nk-menu-item -->
                    </ul>
                </div><!-- .nk-sidebar-menu -->
                <div class="nk-sidebar-footer">
                    <ul class="nk-menu nk-menu-footer">
                        <li class="nk-menu-item">
                            <a href="<?= base_url('support'); ?>" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-help-alt"></em></span>
                                <span class="nk-menu-text"><?= lang("General.support") ?></span>
                            </a>
                        </li>
                        <li class="nk-menu-item ml-auto">
                            <a class="dropdown-toggle dropdown-indicator has-indicator nav-link" style="padding: 4px;" data-toggle="dropdown" data-offset="0,10">
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
                    </ul><!-- .nk-footer-menu -->
                </div><!-- .nk-sidebar-footer -->
            </div><!-- .nk-sidebar-content -->
        </div><!-- .nk-sidebar-body -->
    </div><!-- .nk-sidebar-element -->
</div>
<!-- sidebar @e -->
<!-- wrap @s -->
<div class="nk-wrap ">
    <!-- main header @s -->
    <div class="nk-header nk-header-fixed is-light">
        <div class="container-fluid">
            <div class="nk-header-wrap">
                <div class="nk-menu-trigger d-xl-none ml-n1">
                    <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                </div>
                <div class="nk-header-brand d-xl-none">
                    <a href="html/index.html" class="logo-link">
                        <img class="logo-light logo-img" src="<?= base_url('theme/images/logo.png'); ?>" alt="logo">
                        <img class="logo-dark logo-img" src="<?= base_url('theme/images/logo-dark.png'); ?>" alt="logo-dark">
                    </a>
                </div><!-- .nk-header-brand -->
                <div class="nk-header-news d-none d-xl-block">
                    <div class="nk-news-list">
                        
                    </div>
                </div><!-- .nk-header-news -->
                <div class="nk-header-tools">
                    <ul class="nk-quick-nav">
                        <li class="dropdown user-dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <div class="user-toggle">                                
                                    <?php 
                                    $pad = FCPATH . 'uploads/logos/'.$_SESSION['sellerData']['Logo'];
                                    if(!empty($_SESSION['sellerData']['Logo']) && file_exists($pad) && !is_dir($pad)) : 
                                    ?>                                    
                                    <div class="user-avatar sm" style="background-color:transparent !important;">
                                        <img src="<?= base_url('uploads/logos/'.$_SESSION['sellerData']['Logo']); ?>"  width="auto" height="auto">
                                    </div>
                                    <?php else : ?>                                    
                                    <div class="user-avatar sm">
                                        <em class="icon ni ni-user-alt"></em>
                                    </div>
                                    <?php endif; ?>
                                    <div class="user-info d-none d-md-block">
                                        <div class="user-name dropdown-indicator"><?= ucfirst($_SESSION['userData']['FirstName'])." ".ucfirst($_SESSION['userData']['LastName']); ?></div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-md dropdown-menu-right dropdown-menu-s1">
                                <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                    <div class="user-card">
                                        <div class="user-avatar" style="background-color:transparent !important;">
                                            <img src="<?= base_url('uploads/logos/'.$_SESSION['sellerData']['Logo']); ?>"  width="auto" height="auto">
                                        </div>
                                        <div class="user-info">
                                            <span class="lead-text"><?= ucfirst($_SESSION['userData']['FirstName'])." ".ucfirst($_SESSION['userData']['LastName']); ?></span>
                                            <span class="sub-text"><?= $_SESSION['userData']['Email']; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-inner">
                                    <ul class="link-list">
                                        <li><a href="<?= base_url('account'); ?>"><em class="icon ni ni-setting-alt"></em><span>Account settings</span></a></li>
                                        <li><a class="dark-switch" href="#"><em class="icon ni ni-moon"></em><span>Dark theme</span></a></li>
                                    </ul>
                                </div>
                                <div class="dropdown-inner">
                                    <ul class="link-list">
                                        <li><a href="<?= base_url('login/logout'); ?>"><em class="icon ni ni-signout"></em><span>Logout</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </li><!-- .dropdown -->
                    </ul><!-- .nk-quick-nav -->
                </div><!-- .nk-header-tools -->
            </div><!-- .nk-header-wrap -->
        </div><!-- .container-fliud -->
    </div>
    <!-- main header @e -->