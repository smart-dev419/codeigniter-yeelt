<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags  -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <title>DBL HUB - Internal Error</title>
        <link rel="icon" type="image/png" href="<?= site_url('/theme/img/favicon.png'); ?>" />

        <?php $append = (ENVIRONMENT !== 'production') ? '?v='.time() : ''; ?>

        <!--Core CSS -->
        <link rel="stylesheet" href="<?= site_url('/theme/css/app.css'.$append); ?>">
        <link rel="stylesheet" href="<?= site_url('/theme/css/main.css'.$append); ?>">
        
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800;900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700" rel="stylesheet">

        <link rel="stylesheet" href="<?= site_url('/theme/css/custom.css'.$append); ?>">
    </head>
    <body>
    <div id="huro-app" class="app-wrapper">
        <div class="minimal-wrapper darker">
            <div class="error-container">
                <div class="error-wrapper">
                    <div class="error-inner has-text-centered">
                        <div class="bg-number">500</div>
                        <img src="<?= base_url('theme/img/illustrations/placeholders/error-5.svg'); ?>" alt="" />
                        <h3>Internal Server Error</h3>
                        <p><?= $message; ?></p>
                        <div class="button-wrap">
                            <a href="javascript:history.back(-1);" class="button h-button is-primary is-elevated">Terug naar DBL Hub</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= site_url('/theme/js/app.js'); ?>"></script>
</body>
</html>

