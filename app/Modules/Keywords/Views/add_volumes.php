<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-lg">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <div class="nk-block-head-sub"><a class="back-to" href="<?= base_url('keywords/list'); ?>"><em class="icon ni ni-arrow-left"></em><span>Back to keywords</span></a></div>
                        <h3 class="nk-block-title page-title">Add keywords</h3>
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->
            <div class="nk-block nk-block-lg">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <form action="<?= base_url('keywords/add_process'); ?>" method="post" class="nk-wizard nk-wizard-simple is-alter">
                            <div class="steps clearfix">
                                <ul role="tablist">
                                    <li role="tab" class="first current" aria-disabled="false" aria-selected="true">
                                        <a id="steps-uid-0-t-0" href="#" aria-controls="steps-uid-0-p-0">
                                            <span class="current-info audible">current step: </span><span class="number">1.</span> 
                                            <h5>Keyword list</h5>
                                        </a>
                                    </li>
                                    <li role="tab" class="current" aria-disabled="false" aria-selected="false">
                                        <a id="steps-uid-0-t-1" href="#" aria-controls="steps-uid-0-p-1">
                                            <span class="number">2.</span> 
                                            <h5>Search volumes</h5>
                                        </a>
                                    </li>
                                    <li role="tab" class="last done" aria-disabled="false" aria-selected="false">
                                        <a id="steps-uid-0-t-2" href="#" aria-controls="steps-uid-0-p-2">
                                            <span class="number">3.</span> 
                                            <h5>Result</h5>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="nk-wizard-head">
                                <h5>Keyword list</h5>
                            </div>
                            <div class="nk-wizard-content">
                                <div class="row gy-3">
                                    <div class="col-md-12">
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus mauris velit, tincidunt in commodo nec, scelerisque interdum eros. Proin hendrerit facilisis enim, vel elementum nibh hendrerit quis. Pellentesque ipsum arcu, tincidunt eu neque ut, accumsan efficitur eros. Aliquam neque lacus, rutrum nec ligula non, varius aliquet eros. Etiam eu nibh dui.
                                        </p>
                                    </div>
                                    <div class="col-md-12">
                                        <h6>Your keywords</h6>
                                        <div class="card card-bordered card-preview">
                                            <table class="table table-tranx is-compact">
                                                <thead>
                                                    <tr class="tb-tnx-head">
                                                        <th width="580" class="tb-tnx-id"><span class="">Keyword</span></th>
                                                        <th width="300" class="tb-tnx-test">Volume</th>
                                                        <th class="tb-tnx-add">Add/Remove</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $gedaan = array();
                                                    $keywords_array = array_values(array_filter(explode(PHP_EOL, $keywords['keywords'])));
                                                    if(isset($keywords_array) && count($keywords_array) > 0) {
                                                        $i = 0;
                                                        foreach($keywords_array as $keyword) :
                                                            $keyword = preg_replace("/[^A-Za-z0-9']/", '', $keyword);
                                                            $keyword = strtolower($keyword);
                                                            $keyword = rtrim($keyword);
                                                            $keyword = ltrim($keyword);

                                                            if($i >= 10) {
                                                                break;
                                                            }

                                                            if(!in_array($keyword, $gedaan)) {
                                                                $gedaan[] = $keyword;
                                                                echo '<tr class="tb-tnx-item search_volume" data-keyword="'.$keyword.'">
                                                                        <td class="tb-tnx-id"><span>'.$keyword.'</span></td>
                                                                        <td class="tb-tnx-result">
                                                                            <div class="spinner-border spinner-border-sm" role="status">  <span class="sr-only">Loading...</span></div>
                                                                        </td>
                                                                        <td class="tb-tnx-action">
                                                                            <div class="custom-control custom-control custom-switch">
                                                                                <input type="checkbox" name="keywords[]" class="custom-control-input" checked id="customSwitch'.$i.'" value="'.$keyword.'">
                                                                                <label class="custom-control-label" for="customSwitch'.$i.'"></label>
                                                                            </div>
                                                                        </td>
                                                                    </tr>';
                                                                $i++;
                                                            }
                                                        endforeach;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div id="suggestions" class="d-none has-loader">
                                            <h6 class="pt-4">Suggestions</h6>
                                            <div class="card card-bordered card-preview">
                                                <!--Loader element-->
                                                <div class="h-loader-wrapper">
                                                    <div class="loader is-large is-loading"></div>
                                                </div>

                                                <table class="table table-tranx is-compact">
                                                    <tbody id="suggestions_body">
                                                    </tbody>
                                                </table>
                                            </div>  
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">Add selected</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- .nk-block -->
        </div>
    </div>
</div>