
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-lg">
        <div class="nk-content-body">
            <div class="nk-block">
                <div class="card card-bordered">
                    <div class="card-aside-wrap">
                        <div class="card-inner card-inner-lg">
                            <div class="nk-block-head nk-block-head-lg">
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">General settings</h4>
                                        <div class="nk-block-des">
                                            <p>Seller info, like your information and api connection, that you use on Yeelt Platform.</p>
                                        </div>
                                    </div>
                                    <div class="nk-block-head-content align-self-start d-lg-none">
                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="nk-data data-list">
                                    <div class="data-head">
                                        <h6 class="overline-title">Basics</h6>
                                    </div>
                                    <div class="data-item" data-toggle="modal" data-target="#profile-edit">
                                        <div class="data-col">
                                            <span class="data-label">Seller ID</span>
                                            <span class="data-value"><?= $data_seller['SellerID']; ?></span>
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                    </div><!-- data-item -->
                                    <div class="data-item" data-toggle="modal" data-target="#profile-edit">
                                        <div class="data-col">
                                            <span class="data-label">Name</span>
                                            <span class="data-value"><?= $data_seller['Name']; ?></span>
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                    </div><!-- data-item -->
                                </div><!-- data-list -->
                                <div class="nk-data data-list">
                                    <div class="data-head">
                                        <h6 class="overline-title">Bol.com API Connection</h6>
                                    </div>
                                    <div class="data-item" data-toggle="modal" data-target="#profile-edit" data-tab-target="#address">
                                        <div class="data-col">
                                            <span class="data-label">Client ID</span>
                                            <span class="data-value"><?= $data_seller['ApiClientID']; ?></span>
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                    </div><!-- data-item -->
                                    <div class="data-item" data-toggle="modal" data-target="#profile-edit" data-tab-target="#address">
                                        <div class="data-col">
                                            <span class="data-label">Client Secret</span>
                                            <span class="data-value">***********</span>
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                    </div><!-- data-item -->
                                    <div class="data-item" data-toggle="modal" data-target="#profile-edit" data-tab-target="#address">
                                        <div class="data-col">
                                            <span class="data-label">Connection status</span>
                                            <?php 
                                            if($data_seller['ApiClientToken'] !== "") {
                                                echo '<span class="data-value"><span class="badge badge-info">Active</span></span>';
                                            } else {
                                                echo '<span class="data-value"><span class="badge badge-danger">Inactive</span></span>';
                                            }                                            
                                            ?>
                                        </div>
                                        <div class="data-col data-col-end"> </div>
                                    </div>
                                </div><!-- data-list -->
                            </div><!-- .nk-block -->
                        </div>
                        <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
                            <div class="card-inner-group" data-simplebar>
                                <div class="card-inner p-0">
                                    <ul class="link-list-menu">
                                        <li><a class="active" href="<?= base_url('settings'); ?>"><em class="icon ni ni-user-fill-c"></em><span>General settings</span></a></li>
                                        <li><a href="<?= base_url('settings/users'); ?>"><em class="icon ni ni-users"></em><span>Users</span></a></li>
                                        <li><a class="active" href="<?= base_url('settings/logo'); ?>"><em class="icon ni ni-camera"></em><span>Logo</span></a></li>
                                    </ul>
                                </div><!-- .card-inner -->
                            </div><!-- .card-inner-group -->
                        </div><!-- card-aside -->
                    </div><!-- .card-aside-wrap -->
                </div><!-- .card -->
            </div><!-- .nk-block -->
        </div>
    </div>
</div>

<!-- @@ Profile Edit Modal @e -->
<div class="modal fade" tabindex="-1" role="dialog" id="profile-edit">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content has-loader">
            <!--Loader element-->
            <div class="h-loader-wrapper">
                <div class="loader is-large is-loading"></div>
            </div>

            <form action="#" id="processProfile" method="post">
                <div class="modal-body modal-body-lg">
                    <h5 class="title">Seller settings</h5>
                    <ul class="nk-nav nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#personal">Basics</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#address">API Connection</a>
                        </li>
                    </ul><!-- .nav-tabs -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="personal">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name">Seller ID</label>
                                        <input type="text" class="form-control form-control-lg" name="SellerID" id="full-name" value="<?= $data_seller['SellerID']; ?>" placeholder="Enter Seller ID">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="display-name">Display Name</label>
                                        <input type="text" class="form-control form-control-lg" name="Name" id="display-name" value="<?= $data_seller['Name']; ?>" placeholder="Enter your display name">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            <button type="submit" class="btn btn-lg btn-primary">Update settings</button>
                                        </li>
                                        <li>
                                            <a href="#" data-dismiss="modal" class="link link-light">Cancel</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div><!-- .tab-pane -->
                        <div class="tab-pane" id="address">
                            <div class="row gy-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="address-l1">Client ID</label>
                                        <input type="text" class="form-control form-control-lg" name="ApiClientID" id="address-l1" value="<?= $data_seller['ApiClientID']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="address-l2">Client Secret</label>
                                        <input type="text" class="form-control form-control-lg" name="ApiClientSecret" id="address-l2" value="<?= $data_seller['ApiClientSecret']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="alert alert-fill alert-light alert-icon"><em class="icon ni ni-alert-circle"></em> <strong>Updating your API Connection wil disable the API Connection and reconnect after x amount of minutes.</strong></div>
                                </div>
                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            <button type="submit" class="btn btn-lg btn-primary">Update API Connection</button>
                                        </li>
                                        <li>
                                            <a href="#" data-dismiss="modal" class="link link-light">Cancel</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div><!-- .tab-pane -->
                    </div><!-- .tab-content -->
                </div><!-- .modal-body -->
            </form>
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->