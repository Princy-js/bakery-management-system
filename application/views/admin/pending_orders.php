 <div class="container">
  <div class="page-inner">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h4 class="card-title">Pending Orders</h4>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="basic-datatables" class="display table table-striped table-hover">
                <thead>
                  <tr>
                    <th class="col-1">#</th>
                    <th>User Name</th>
                    <th>Order Id</th>
                    <th>Product</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th class="col-1">#</th>
                    <th>User Name</th>
                    <th>Order Id</th>
                    <th>Product</th>
                    <th>Status</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php if(!empty($pending_orders)): ?>
                    <?php $i = 1; foreach($pending_orders as $order): ?>
                    <tr>
                      <td><?= $i++; ?></td>
                      <td><?= $order['customer_name']; ?></td>
                      <td><?= $order['order_id']; ?></td>
                      <td><?= $order['product_name']; ?></td>
                      <td>
                        <span class="badge bg-warning text-dark">Pending</span>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="5" class="text-center">No Pending Orders</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
