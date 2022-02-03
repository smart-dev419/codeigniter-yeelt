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
                        <form action="<?= base_url('keywords/add_volumes'); ?>" method="post" class="nk-wizard nk-wizard-simple is-alter">
                            <div class="steps clearfix">
                                <ul role="tablist">
                                    <li role="tab" class="first current" aria-disabled="false" aria-selected="true">
                                        <a id="steps-uid-0-t-0" href="#" aria-controls="steps-uid-0-p-0">
                                            <span class="current-info audible">current step: </span><span class="number">1.</span> 
                                            <h5>Keyword list</h5>
                                        </a>
                                    </li>
                                    <li role="tab" class="done" aria-disabled="false" aria-selected="false">
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
                                        <textarea class="form-control required" name="keywords" style="font-size: 16px; resize: none; min-height: 300px;"></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">Next step</button>
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