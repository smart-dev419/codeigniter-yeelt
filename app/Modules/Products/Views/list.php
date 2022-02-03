<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-lg">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Product list</h3>
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->
            <div class="nk-block">

                <div class="card card-bordered card-preview">
                    <table class="table table-tranx is-compact">
                        <thead>
                            <tr class="tb-tnx-head">
                                <th class="tb-tnx-id" width="100"><span class="">Image</span></th>
                                <th class="tb-tnx-id"><span class="">Title</span></th>
                                <th class="tb-tnx-id"><span class="">Ean</span></th>
                                <th class="tb-tnx-id"><span class="">Category 1</span></th>
                                <th class="tb-tnx-id"><span class="">Category 2</span></th>
                                <th class="tb-tnx-id"><span class="">Category 3</span></th>
                                <th class="tb-tnx-id"><span class="">&nbsp;</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(is_array($products) && count($products) > 0) {
                                foreach($products as $product) :
                                    $image = '';
                                    if(!empty($product['ImageURL'])) {
                                        $image = '<img class="thumb" src="'.$product['ImageURL'].'" alt="" />';
                                    }

                                    $jsoninfo = json_decode($product['JSONProduct'], TRUE);
                                    $url = '';
                                    if(isset($jsoninfo[0]['urls'][0]['value'])) {
                                        $url = $jsoninfo[0]['urls'][0]['value'];
                                        $url = '<a href="'.$url.'" class="btn btn-icon btn-sm btn-primary" target="_blank"><em class="icon ni ni-eye"></em></a>';
                                    }

                                    echo '<tr class="tb-tnx-item">
                                            <td class="tb-tnx-id">'.$image.'</td>
                                            <td class="tb-tnx-id">'.$product['Title'].'</td>
                                            <td class="tb-tnx-id">'.$product['Ean'].'</td>
                                            <td class="tb-tnx-id">'.$product['parentCategories0'].'</td>
                                            <td class="tb-tnx-id">'.$product['parentCategories1'].'</td>
                                            <td class="tb-tnx-id">'.$product['parentCategories2'].'</td>
                                            <td class="tb-tnx-id">'.$url.'</td>
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
</div>