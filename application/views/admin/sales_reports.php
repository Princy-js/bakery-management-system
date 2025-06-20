<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Sales Report</h4>
                    </div>
                    <div class="card-body">
                        <!-- Form for filtering -->
                        <form method="get" action="<?= base_url('admin/generate_sales_report'); ?>">
                           
                            <button type="submit" class="btn btn-purple mt-3">Download Report</button>
                        </form>

                        <!-- Table to display sales -->
                        <div class="table-responsive mt-4">
                            <table class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer Name</th>
                                        <th>Order ID</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Total Price</th>
                                        <th>Payment Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($sales)) { ?>
                                        <?php $i = 0; foreach ($sales as $sale) { $i++; ?>
                                            <tr>
                                                <td><?= $i; ?></td>
                                                <td><?= $sale['customer_name']; ?></td>
                                                <td><?= $sale['order_id']; ?></td>
                                                <td><?= $sale['product_name']; ?></td>
                                                <td><?= $sale['quantity']; ?></td>
                                                <td>₹<?= number_format($sale['total_price'], 2); ?></td>
                                                <td>
        <!-- Payment Status Badge -->
        <?php if ($sale['payment_status'] == 1): ?>
          <span class="badge bg-success">Paid</span>
        <?php else: ?>
          <span class="badge bg-danger">Not Paid</span>
        <?php endif; ?>
      </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tr><td colspan="7">No sales found.</td></tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">