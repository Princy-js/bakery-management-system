<link rel="stylesheet" href="<?= base_url(); ?>assets/css/style.css">

<div class="container">
<div class="invoice-box">
    <div class="print-button text-right">
        <button onclick="window.print()">🖨️ Print Invoice</button>
    </div>

    <div class="invoice-header">
        <div class="invoice-title">Homely Bakers</div>
        <div><strong>Invoice #: </strong><?= $order->id ?></div>
        <div><strong>Date: </strong><?= date('d M Y, h:i A', strtotime($order->order_date)) ?></div>
    </div>

    <div class="invoice-details">
        <strong>Customer Details:</strong><br>
        <?= $user->name ?><br>
        <?= $user->address ?><br>
        Phone: <?= $user->phone ?><br>
        Email: <?= $user->email ?>
    </div>

    <table class="invoice-items">
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; $total = 0; foreach ($order_items as $item): ?>
                <?php if ($item->status == 1): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $item->product_name ?></td>
                    <td><?= $item->quantity ?></td>
                    <td>₹<?= number_format($item->unit_price, 2) ?></td>
                    <td>₹<?= number_format($item->total_price, 2) ?></td>
                </tr>
                <?php $total += $item->total_price; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="text-right">
        <p><strong>Subtotal: ₹<?= number_format($total, 2) ?></strong></p>
        <p><strong>Payment Mode: </strong><?= ucfirst($order->payment_mode) ?></p>
        <p><strong>Payment Status: </strong><?= ($payment && $payment->status == 1) ? 'Paid' : 'Pending' ?></p>
        <p><strong>Order Status: </strong><?= ucfirst($order->order_status) ?></p>
    </div>

    <div class="invoice-footer">
        <p>Thank you for ordering with Homely Bakers!</p>
    </div>
</div>
</div>
