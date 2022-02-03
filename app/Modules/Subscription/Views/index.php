<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-lg">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-content-wrap">
                    <div class="nk-block-head nk-block-head-lg">
                        <div class="nk-block-head-sub"><span>Manage Subscription</span></div>
                        <div class="nk-block-between-md g-4">
                            <div class="nk-block-head-content">
                                <h2 class="nk-block-title fw-normal">My Subscription</h2>
                                <div class="nk-block-des">
                                    <p>This account is using the following subscription plan. You can change your subscription at any time.</p>
                                </div>
                            </div>
                        </div>
                    </div><!-- .nk-block-head -->
                    <div class="nk-block">
                        <div class="card card-bordered sp-plan">

                            <!-- Active Subscription -->
                            <div class="row no-gutters">
                                <div class="col-md-8">
                                    <div class="sp-plan-info card-inner">
                                        <div class="row gx-0 gy-3">
                                            <div class="col-xl-9 col-sm-8">
                                                <div class="sp-plan-name">
                                                    <h6 class="title"><?= $data['Title']; ?> <span class="badge badge-light badge-pill">Current</span></h6>
                                                    <p>Subscription ID: <span class="text-base"><?= $data['Token']; ?></span></p>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-sm-4">
                                                <div class="sp-plan-opt">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="auto-plan-p2" disabled>
                                                        <label class="custom-control-label text-soft" for="auto-plan-p2">Auto Renew</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- .sp-plan-info -->
                                    <div class="sp-plan-desc card-inner">
                                        <ul class="row gx-1">
                                            <li class="col-6 col-lg-3">
                                                <p><span class="text-soft">Start date</span> <?= format_date($data['DateStart']); ?></p>
                                            </li>
                                            <li class="col-6 col-lg-3">
                                                <p><span class="text-soft">End date</span> -</p>
                                            </li>
                                            <li class="col-6 col-lg-3">
                                                <p><span class="text-soft">Recuring</span>  <?= ($data['Recurring'] == 1) ? 'Yes' : 'No'; ?></p>
                                            </li>
                                            <li class="col-6 col-lg-3">
                                                <p><span class="text-soft">Price</span> <?= bedrag($data['Price']); ?> p/m</p>
                                            </li>
                                        </ul>
                                    </div><!-- .sp-plan-desc -->
                                </div><!-- .col -->
                                <div class="col-md-4">
                                    <div class="sp-plan-action card-inner">
                                        <div class="sp-plan-btn">
                                            <button disabled="disabled" class="btn btn-dim btn-white btn-outline-primary"><span>Can't renew</span></button>
                                        </div>
                                        <div class="sp-plan-note text-md-center">
                                            <p>You can't renew the trial plan.</p>
                                        </div>
                                    </div>
                                </div><!-- .col -->
                            </div>
                            <!-- / Active Subscription -->

                        </div><!-- .sp-plan -->
                    </div><!-- .nk-block -->
                </div>
            </div>
        </div>
    </div>
</div>