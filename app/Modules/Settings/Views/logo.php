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
                                        <h4 class="nk-block-title">Logo</h4>
                                        <div class="nk-block-des">
                                            <p>Here you can edit your logo.</p>
                                        </div>
                                    </div>                                    
                                    <div class="nk-block-head-content align-self-start d-lg-none">
                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <?= $alerts; ?>
                                <!-- userlist -->
                                <div class="card card-bordered">
                                    <form action="<?= base_url('settings/logo_process'); ?>" method="post" enctype='multipart/form-data'>
                                        <div class="card-inner">
                                            <div class="row g-4">                                                
                                                <div class="col-lg-6">
                                                    <?php 
                                                        $pad = FCPATH . 'uploads/logos/'.$_SESSION['sellerData']['Logo'];
                                                        if(!empty($_SESSION['sellerData']['Logo']) && file_exists($pad) && !is_dir($pad)) : 
                                                    ?> 
                                                    <div class="form-group">
                                                        <label class="form-label" for="customFileLabel">Chosen logo</label>
                                                        <div class="form-control-wrap">
                                                            <div class="form-group">
                                                                <div class="form-control-wrap"><img src="<?= base_url('uploads/logos/'.$data['Logo']); ?>"  width="auto" height="auto"></div>
                                                            </div>    
                                                        </div>                                    
                                                    </div>
                                                    <?php else: ?>
                                                    <div class="form-group">
                                                        <label class="form-label" for="customFileLabel">Chosen logo</label>
                                                        <div class="form-control-wrap">
                                                            <div class="form-group">
                                                                <div class="form-control-wrap"><h5>No logo selected yet</h5></div>
                                                            </div>    
                                                        </div>                                    
                                                    </div>
                                                    <?php endif; ?>
                                                    <div class="form-group">
                                                        <label class="form-label" for="full-name-1">Logo</label>
                                                        <div class="form-control-wrap"><input type="file" name="logo" class="form-control" ></div>
                                                    </div>
                                                </div>                            
                                            
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-lg btn-primary">Save Informations</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                       
                                    </form>
                                </div>
                                <!-- / userlist -->
                            </div><!-- .nk-block -->
                        </div>
                        <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg"
                            data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
                            <div class="card-inner-group" data-simplebar>
                                <div class="card-inner p-0">
                                    <ul class="link-list-menu">
                                        <li><a href="<?= base_url('settings'); ?>"><em class="icon ni ni-user-fill-c"></em><span>General settings</span></a></li>
                                        <li><a class="active" href="<?= base_url('settings/users'); ?>"><em class="icon ni ni-users"></em><span>Users</span></a></li>
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
<div class="modal fade" tabindex="-1" role="dialog" id="user-add">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content has-loader">
            <!--Loader element-->
            <div class="h-loader-wrapper">
                <div class="loader is-large is-loading"></div>
            </div>

            <form action="<?= base_url('settings/users/process_invite'); ?>" id="processInvite" method="post">
                <div class="modal-body modal-body-lg">
                    <h5 class="title">Invite a user</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam egestas elementum ante. Fusce consequat nunc eu sodales scelerisque. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                    <div class="tab-content">
                        <div class="tab-pane active" id="personal">
                            <div class="row gy-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="Emailaddress">E-mailaddress</label>
                                        <input type="text" class="form-control form-control-lg" name="Emailaddress" id="Emailaddress" value="" placeholder="Enter E-mailaddress of user">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            <button type="submit" class="btn btn-lg btn-primary">Invite user</button>
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