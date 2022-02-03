<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-lg">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <div class="nk-block-head-sub"><a class="back-to" href="<?= base_url('overview'); ?>"><em class="icon ni ni-arrow-left"></em><span>Overview</span></a></div>
                        <h3 class="nk-block-title page-title">Suggestions</h3>
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->

            <?= $alerts; ?>

            <p>
                Last suggestions fetched: <?= date("d-m-Y H:i:s", strtotime($suggestions[0]['DateTime'])); ?>
            </p>

            <div class="card card-bordered card-preview">
                <table class="table table-tranx is-compact">
                    <thead>
                        <tr class="tb-tnx-head">
                            <th class="tb-tnx-id"><span class="">Keyword</span></th>
                            <th class="tb-tnx-vol"><span class="">Volume</span></th>
                            <th class="tb-tnx-action"><span>&nbsp;</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(is_array($suggestions) && count($suggestions) > 0) {
                            foreach($suggestions as $suggestion) :
                                echo '<tr class="tb-tnx-item">
                                            <td class="tb-tnx-id"><span>'.$suggestion['Keyword'].'</span></td>
                                            <td class="tb-tnx-vol"><span>'.$suggestion['Volume'].'</span></td>
                                            <td class="tb-tnx-action">
                                                <a href="'.base_url('keywords/add_suggestion/'.$suggestion['KeywordsSuggestionsKey'].'/'.$suggestion['Token']).'" class="btn btn-xs btn-secondary">Add</a>
                                            </td>
                                        </tr>';
                            endforeach;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>