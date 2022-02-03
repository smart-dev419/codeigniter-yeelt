<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-lg">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <div class="nk-block-head-sub"><a class="back-to" href="<?= base_url('overview'); ?>"><em class="icon ni ni-arrow-left"></em><span>Overview</span></a></div>
                        <h3 class="nk-block-title page-title">Keyword list</h3>
                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <a href="<?= base_url('keywords/add'); ?>" class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
                            <em class="icon ni ni-plus"></em>
                            <span>Add keywords</span>
                        </a>
                    </div>
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->
            <div class="nk-block">
                <?= $alerts; ?>
                <div class="row g-gs">
                    <div class="col-sm-12">
                        <div class="alert alert-info">
                            <div class="alert-cta flex-wrap flex-md-nowrap">
                                <div class="alert-text">
                                    <p>You have got <strong style="text-decoration: underline;"><?= $num_suggestions; ?></strong> search suggestions based on your current keyword list</p>
                                </div>
                                <ul class="alert-actions gx-3 mt-3 mb-1 my-md-0">
                                    <li class="order-md-last"><a href="<?= base_url('keywords/suggestions'); ?>" class="btn btn-sm btn-info">Show suggestions</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="project-progress d-none">
                            <div class="project-progress-details">
                                <div class="project-progress-task"><em class="icon ni ni-list"></em><span><strong>8 keywords</strong> in your account</span></div>
                                <div class="project-progress-percent">35%</div>
                            </div>
                            <div class="progress progress-pill progress-md bg-light">
                                <div class="progress-bar" data-progress="35" style="width: 100%;"></div>
                            </div>
                        </div>

                        <div class="card card-bordered card-preview">
                            <table class="table table-tranx is-compact">
                                <thead>
                                    <tr class="tb-tnx-head">
                                        <th class="tb-tnx-id"><span class="">Keyword</span></th>
                                        <th class="tb-tnx-action"><span>&nbsp;</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(is_array($keywords) && count($keywords) > 0) {
                                        foreach($keywords as $keyword) :
                                            echo '<tr class="tb-tnx-item">
                                                        <td class="tb-tnx-id"><a href="#"><span>'.$keyword['Keyword'].'</span></a></td>
                                                        <td class="tb-tnx-action">
                                                            <a href="'.base_url('keywords/delete/'.$keyword['KeywordKey'].'/'.$keyword['Token']).'" class="btn btn-xs btn-danger">Remove</a>
                                                        </td>
                                                    </tr>';
                                        endforeach;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div><!-- .col -->
                </div><!-- .row -->
            </div><!-- .nk-block -->
        </div>
    </div>
</div>