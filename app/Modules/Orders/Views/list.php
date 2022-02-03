<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-lg">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Orders</h3>
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->
            <div class="nk-block">

                <div class="card card-bordered card-preview">
                    <table class="table table-tranx is-compact">
                        <thead>
                            <tr class="tb-tnx-head">
                                <th class="tb-tnx-id"><span class="">Order Date</span></th>
                                <th class="tb-tnx-id"><span class="">Order ID</span></th>
                                <th class="tb-tnx-id"><span class="">Total</span></th>
                                <th class="tb-tnx-id"><span class="">Commision</span></th>
                                <th class="tb-tnx-id"><span class="">Products</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(is_array($orders) && count($orders) > 0) {
                                foreach($orders as $order) :
                                    echo '<tr class="tb-tnx-item">
                                            <td class="tb-tnx-id"><a href="'.base_url('orders/data/'.$order['OrderID']).'"><span>'.$order['DateTimePlaced'].'</span></a></td>
                                            <td class="tb-tnx-id"><a href="'.base_url('orders/data/'.$order['OrderID']).'"><span>'.$order['OrderID'].'</span></a></td>
                                            <td class="tb-tnx-id"><a href="'.base_url('orders/data/'.$order['OrderID']).'"><span>'.bedrag($order['Total']).'</span></a></td>
                                            <td class="tb-tnx-id"><a href="'.base_url('orders/data/'.$order['OrderID']).'"><span>'.bedrag($order['Commision']).'</span></a></td>
                                            <td class="tb-tnx-id"><a href="'.base_url('orders/data/'.$order['OrderID']).'"><span>'.$order['NumProducts'].'</span></a></td>
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