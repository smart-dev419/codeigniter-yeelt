                    <!-- footer @s -->
                    <div class="nk-footer">
                        <div class="container-fluid">
                            <div class="nk-footer-wrap">
                                <div class="nk-footer-copyright"> &copy; <?= date('Y'); ?> <?= lang("General.platform_tm") ?>
                                </div>
                                <div class="nk-footer-links">
                                    <ul class="nav nav-sm">
                                        <li class="nav-item"><a class="nav-link" href="https://yeelt.io/terms"><?= lang("General.terms") ?></a></li>
                                        <li class="nav-item"><a class="nav-link" href="https://yeelt.io/privacy"><?= lang("General.privacy") ?></a></li>
                                        <li class="nav-item"><a class="nav-link" href="<?= base_url('support'); ?>"><?= lang("General.support") ?></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- footer @e -->
                </div>
                <!-- wrap @e -->
            </div>
            <!-- main @e -->
        </div>
        <!-- app-root @e -->
        
        <input type="hidden" id="js_site_url" value="<?php echo site_url(); ?>" />

        <?php
        /**
         * Set javascript based on release version
         * For development we use a timestamp to always load the newest version
         */
        $getversioninfo = getenv('CI_RELEASE');
        $appendurl = (ENVIRONMENT == 'development') ? time() : $getversioninfo; 
        ?>

        <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
        <script src="<?= site_url('/theme/assets/js/bundle.js'); ?>"></script>
        <script src="<?= site_url('/theme/assets/js/scripts.js'); ?>"></script>

        <?php
        // Load JS assets if available
        if(isset($assets) && isset($assets['js'])) {
            if(!isset($assets_path)) {
                $assets_path = 'theme/assets/js/';
            } else {
                $assets_path = $assets_path.'js/';
            }

            foreach($assets['js'] as $assets_js) {
                $append = '';
                if(strpos($assets_js, '?') === false) {
                    $append = '?v='.$appendurl;
                }

                if(strpos($assets_js, 'http') === false) {
                    echo "\t\t\t<script src='".site_url($assets_path.$assets_js.$append)."'></script>\n";
                } else {
                    echo "\t\t\t<script src='".$assets_js.$append."'></script>\n";
                }
            }
        }
        ?>
    </body>
</html>
