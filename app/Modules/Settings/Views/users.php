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
                                        <h4 class="nk-block-title">Users</h4>
                                        <div class="nk-block-des">
                                            <p>Manage user access of this seller account.</p>
                                        </div>
                                    </div>
                                    <div class="nk-block-head-content">
                                        <a href="" class="btn btn-outline-light bg-white d-none d-sm-inline-flex" data-toggle="modal" data-target="#user-add">
                                            <em class="icon ni ni-plus"></em>
                                            <span>Invite user</span>
                                        </a>
                                    </div>
                                    <div class="nk-block-head-content align-self-start d-lg-none">
                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1"
                                            data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <?= $alerts; ?>
                                <!-- userlist -->
                                <div class="card card-bordered">
                                    <table class="table table-tranx">
                                        <thead>
                                            <tr class="tb-tnx-head">
                                                <th class="tb-tnx-email"><span class="tb-tnx-email d-none d-sm-inline-block"><span>E-mailaddress</span></span></th>
                                                <th class="tb-tnx-name"><span class="tb-tnx-total">Name</span></th>
                                                <th class="tb-tnx-userstatus" width="160"><span class="tb-tnx-status">Status</span></th>
                                                <th class="tb-tnx-action"><span>&nbsp;</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if(is_array($users) && count($users) > 0) { 
                                                foreach($users as $user) :
                                                    $userApproved = '';
                                                    $removeButton = '';
                                                    if($user['Primary'] == 1) {
                                                        $userApproved = '<span class="badge badge-dot badge-info">Primary</span>';
                                                    } else { 
                                                        if($user['AcceptedByUser'] == 1) {
                                                            $userApproved = '<span class="badge badge-dot badge-success">Approved</span>';
                                                        } elseif($user['AcceptedByUser'] == 0) {
                                                            $userApproved = '<span class="badge badge-dot badge-warning">Pending</span>';
                                                        } elseif($user['AcceptedByUser'] == 2) {
                                                            $userApproved = '<span class="badge badge-dot badge-danger">Denied</span>';
                                                        }

                                                        $removeButton = '<div class="dropdown">
                                                                            <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
                                                                                <ul class="link-list-plain">
                                                                                    <li><a href="'.base_url('settings/users/delete/'.$user['UsersKey'].'/'.$user['Token']).'" onclick="return confirm(\'Are you sure? This can\'t be undone.\')">Remove</a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>';
                                                    }
                                                    
                                                    echo '<tr class="tb-tnx-item">
                                                            <td class="tb-tnx-email"><span class="email">'.$user['Email'].'</span></td>
                                                            <td class="tb-tnx-name"><span class="name">'.$user['FirstName'].' '.$user['LastName'].'</span></td>
                                                            <td class="tb-tnx-userstatus">'.$userApproved.'</td>
                                                            <td class="tb-tnx-action">
                                                                '.$removeButton.'
                                                            </td>
                                                        </tr>';
                                                endforeach;
                                            } 
                                            ?>
                                        </tbody>
                                    </table>
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