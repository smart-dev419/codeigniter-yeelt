<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-lg">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Order ID: <?= $data[0]['OrderID']; ?></h3>
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->
            <div class="nk-block">

                <div class="card card-bordered card-preview">
                    <table class="table table-tranx is-compact">
                        <thead>
                            <tr class="tb-tnx-head">
                                <th class="tb-tnx-id"><span class="">Ean</span></th>
                                <th class="tb-tnx-id"><span class="">Title</span></th>
                                <th class="tb-tnx-id"><span class="">Quantity</span></th>
                                <th class="tb-tnx-id"><span class="">Unit Price</span></th>
                                <th class="tb-tnx-id"><span class="">Commission</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(is_array($data) && count($data) > 0) {
                                foreach($data as $order) :
                                    echo '<tr class="tb-tnx-item">
                                            <td class="tb-tnx-id"><span>'.$order['Ean'].'</span></td>
                                            <td class="tb-tnx-id"><span>'.$order['Title'].'</span></td>
                                            <td class="tb-tnx-id"><span>'.$order['Quantity'].'</span></td>
                                            <td class="tb-tnx-id"><span>'.bedrag($order['UnitPrice']).'</span></td>
                                            <td class="tb-tnx-id"><span>'.bedrag($order['Commission']).'</span></td>
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