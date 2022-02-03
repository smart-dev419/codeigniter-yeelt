<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-lg">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Overview</h3>
                        <div class="nk-block-des text-soft">
                            <p>Here you can find your latest rankings based on the given filters and labels.</p>
                        </div>
                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <div id="reportrange" style="width: 100%; min-width: 350px;">
                            <em class="icon ni ni-calendar"></em>&nbsp;
                            <span> </span> <em class="icon ni ni-caret-down-fill"></em>
                        </div>
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->
            <div class="nk-block">
                <div class="row g-gs">
                    <div class="col-sm-3">
                        <div class="card card-bordered" id="stats_rankings">
                            <div class="card-inner has-loader has-loader-active">
                                <!--Loader element-->
                                <div class="h-loader-wrapper">
                                    <div class="loader is-large is-loading"></div>
                                </div>
                                <div class="card-title-group align-start mb-2">
                                    <div class="card-title">
                                        <h6 class="title">Avg. Ranking</h6>
                                    </div>
                                    <div class="card-tools">
                                        <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="Average rankings"></em>
                                    </div>
                                </div>
                                <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                    <div class="nk-sale-data">
                                        <span class="amount">-</span>
                                        <span class="sub-title"><span class="change"> </span>vs previous period</span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .card -->
                    </div><!-- .col -->
                    <div class="col-sm-3">
                        <div class="card card-bordered" id="stats_revenue">
                            <div class="card-inner has-loader has-loader-active"> 
                                <!--Loader element-->
                                <div class="h-loader-wrapper">
                                    <div class="loader is-large is-loading"></div>
                                </div>
                                <div class="card-title-group align-start mb-2">
                                    <div class="card-title">
                                        <h6 class="title">Revenue</h6>
                                    </div>
                                    <div class="card-tools">
                                        <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="Revenue"></em>
                                    </div>
                                </div>
                                <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                    <div class="nk-sale-data">
                                        <span class="amount">-</span>
                                        <span class="sub-title"><span class="change"> </span>vs previous period</span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .card -->
                    </div><!-- .col -->
                    <div class="col-sm-3">
                        <div class="card card-bordered" id="stats_sales">
                            <div class="card-inner has-loader has-loader-active">
                                <!--Loader element-->
                                <div class="h-loader-wrapper">
                                    <div class="loader is-large is-loading"></div>
                                </div>
                                <div class="card-title-group align-start mb-2">
                                    <div class="card-title">
                                        <h6 class="title">Sales</h6>
                                    </div>
                                    <div class="card-tools">
                                        <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="Sales"></em>
                                    </div>
                                </div>
                                <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                    <div class="nk-sale-data">
                                        <span class="amount">-</span>
                                        <span class="sub-title"><span class="change"> </span>vs previous period</span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .card -->
                    </div><!-- .col -->
                    <div class="col-sm-3">
                        <div class="card card-bordered" id="stats_visits">
                            <div class="card-inner has-loader has-loader-active">
                                <!--Loader element-->
                                <div class="h-loader-wrapper">
                                    <div class="loader is-large is-loading"></div>
                                </div>
                                <div class="card-title-group align-start mb-2">
                                    <div class="card-title">
                                        <h6 class="title">Visits</h6>
                                    </div>
                                    <div class="card-tools">
                                        <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="Visits"></em>
                                    </div>
                                </div>
                                <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                    <div class="nk-sale-data">
                                        <span class="amount">-</span>
                                        <span class="sub-title"><span class="change"> </span>vs previous period</span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .card -->
                    </div><!-- .col -->
                    <div class="col-xl-12">
                        <div class="card card-bordered card-full">
                            <div class="card-inner">
                                <ul class="nav nav-tabs mt-n3">
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tabItem1"><em
                                                class="icon ni ni-bar-chart-alt"></em><span>Avg. Ranking</span></a> </li>
                                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#tabItem2"><em
                                                class="icon ni ni-growth-fill"></em><span>Revenue</span></a> </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tabItem3"><em
                                                class="icon ni ni-coins"></em><span>Sales</span></a> </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tabItem4"><em
                                                class="icon ni ni-eye-alt"></em><span>Visits</span></a> </li>
                                </ul>
                                <div class="tab-content has-loader has-loader-active">
                                    <!--Loader element-->
                                    <div class="h-loader-wrapper">
                                        <div class="loader is-large is-loading"></div>
                                    </div>
                                    <div class="tab-pane" id="tabItem1">
                                        <div class="nk-ck" style="min-height: 320px;">
                                            <canvas id="chart_rankings" style="max-height: 29.1rem"></canvas>
                                        </div>
                                    </div>
                                    <div class="tab-pane active" id="tabItem2">
                                        <div class="nk-ck" style="min-height: 320px;">
                                            <canvas id="chart_revenue" style="max-height: 29.1rem"></canvas>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabItem3">
                                        <div class="nk-ck" style="min-height: 320px;">
                                            <canvas id="chart_sales" style="max-height: 29.1rem"></canvas>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabItem4">
                                        <div class="nk-ck" style="min-height: 320px;">
                                            <canvas id="chart_visits" style="max-height: 29.1rem"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card card-bordered card-full">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">
                                            <span class="mr-2">Category</span>
                                        </h6>
                                    </div>
                                </div>
                            </div><!-- .card-inner -->
                            <div class="card-inner p-0 border-top has-loader has-loader-active" style="min-height: 300px;">
                                <!--Loader element-->
                                <div class="h-loader-wrapper">
                                    <div class="loader is-large is-loading"></div>
                                </div>
                                <div class="nk-tb-list nk-tb-orders table_headers">
                                    <div class="nk-tb-item nk-tb-head table_headers_cat">
                                        <div class="nk-tb-col tb-col-xxl"><span>Category</span></div>
                                        <div class="nk-tb-col tb-col-sm"><span>Visits</span></div>
                                        <div class="nk-tb-col tb-col-sm"><span>Conv. ratio</span></div>
                                        <div class="nk-tb-col tb-col-sm"><span>Sales</span></div>
                                        <div class="nk-tb-col tb-col-sm"><span>Revenue</span></div>
                                        <div class="nk-tb-col tb-col-sm"><span>Avg. Rank</span></div>
                                    </div><!-- .nk-tb-item -->
                                    <!-- .nk-tb-item -->
                                </div>
                            </div><!-- .card-inner -->
                        </div><!-- .card -->
                    </div><!-- .col -->
                    <div class="col-xl-12">
                        <div class="card card-bordered card-full">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">
                                            <span class="mr-2">Product</span>
                                        </h6>
                                    </div>
                                </div>
                            </div><!-- .card-inner -->
                            <div class="card-inner p-0 border-top has-loader has-loader-active" style="min-height: 300px; max-height: 600px; overflow-y: scroll;">
                                <!--Loader element-->
                                <div class="h-loader-wrapper">
                                    <div class="loader is-large is-loading"></div>
                                </div>
                                <div class="nk-tb-list nk-tb-orders table_headers_prod">
                                    <div class="nk-tb-item nk-tb-head table_headers_prod">
                                        <div class="nk-tb-col tb-col-xxl"><span>Title</span></div>
                                        <div class="nk-tb-col tb-col-sm"><span>Visits</span></div>
                                        <div class="nk-tb-col tb-col-sm"><span>Quantity</span></div>
                                        <div class="nk-tb-col tb-col-sm"><span>Revenue</span></div>
                                        <div class="nk-tb-col tb-col-sm"><span>Avg. Rank</span></div>
                                    </div><!-- .nk-tb-item -->
                                </div>
                            </div><!-- .card-inner -->
                        </div><!-- .card -->
                    </div><!-- .col -->
                </div>
            </div><!-- .nk-block -->
        </div>
    </div>
</div>

<input type="hidden" id="overview_category" value="<?= $category; ?>">
<input type="hidden" id="overview_level" value="<?= $level; ?>">