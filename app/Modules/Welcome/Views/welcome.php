<!-- content @s -->
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-lg">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-lg wide-xs mx-auto">
                <div class="nk-block-head-content text-center">
                    <h2 class="nk-block-title fw-normal">Nice, <?= $_SESSION['userData']['FirstName']; ?>!</h2>
                    <div class="nk-block-des">
                        <p>Welcome to our <strong>Yeelt Dashboard</strong>. You are few steps away to complete your profile.</p>
                    </div>
                </div>
            </div><!-- .nk-block-head -->
            <div class="nk-block">
            <?= $alerts ?>
            </div>
        </div>
    </div>
</div>
<!-- content @e -->