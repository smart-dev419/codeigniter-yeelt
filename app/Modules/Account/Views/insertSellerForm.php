<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-lg">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <?= $alerts; ?>
                        <h3 class="nk-block-title page-title">
                           <?= $Title; ?>
                        </h3>
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->
            <div class="nk-block">
                <!-- Form -->
                <form action="<?= base_url('account/createSeller_process'); ?>" method="post" enctype='multipart/form-data'>
                    <h5>Fill in your Seller info</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Modi recusandae ea necessitatibus sunt velit unde veniam hic tempora molestiae magni aspernatur itaque debitis, corporis exercitationem libero consequuntur illum natus nesciunt!</p>
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name-1">Seller ID</label>
                                        <div class="form-control-wrap"><input type="text" name="seller_id" class="form-control" ></div>                                        
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name-1">Name</label>
                                        <div class="form-control-wrap"><input type="text" name="name" class="form-control" ></div>                                                                              
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name-1">Api Client ID</label>
                                        <div class="form-control-wrap"><input type="text" name="api_client_id" class="form-control" ></div>                                        
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name-1">Api Client Secret</label>
                                        <div class="form-control-wrap"><input type="text" name="api_client_secret" class="form-control" ></div>                                        
                                    </div>
                                </div>
                                <div class="col-lg-6">
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
                </form>
                <!-- / Form -->                
            </div>
        </div>
    </div>
</div>
