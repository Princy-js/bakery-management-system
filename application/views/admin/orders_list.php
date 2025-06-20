<div class="container">
  <div class="page-inner">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h4 class="card-title">Orders</h4>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="basic-datatables" class="display table table-striped table-hover">
                <thead>
                  <tr>
                    <th class="col-1">#</th>
                    <th>Customer Name</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Order Status</th>
                    <th class="col-3">Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th class="col-1">#</th>
                    <th>Customer Name</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Order Status</th>
                  </tr>
                </tfoot>

                <tbody>
                        <?php
          if(!empty($orders)){
        $i=0;
          foreach($orders as $order){
            $i++;
            ?>
          <tr>
            <td><?php echo $i;?></td>
            <td><?= $order['customer_name']; ?></td>
            <td><?= $order['product_name']; ?></td>
            <td><?= $order['quantity']; ?></td>
            <td>₹<?= number_format($order['total_price'], 2); ?></td>
            <td>
              <?php
              if ($order['order_status'] == 'success') {
                  echo '<span class="badge bg-success">Delivered</span>';
              } elseif ($order['order_status'] == 'pending') {
                  echo '<span class="badge bg-warning text-dark">Pending</span>';
              } else {
                  echo '<span class="badge bg-danger">Canceled</span>';
              }
              ?>
            </td>
            <td>
              <button 
                class="btn btn-light toggleStatusBtn" 
                title="Change Status"
                data-id="<?= $order['order_id']; ?>" 
                data-status="<?= $order['order_status']; ?>">
                <?= $order['order_status'] == 'success' ? '✔️' : '❌'; ?>
              </button>

  
              <button class="btn btn-primary viewOrderBtn" title="View" data-id="<?= $order['order_id']; ?>">
                <i class="fa fa-search"></i>
              </button>

              <button class="btn btn-danger cancelOrderBtn" data-id="<?= $order['order_id']; ?>" title ="cancel">
                <i class="fa fa-trash"></i>
              </button>

            </td>

        </tr>
         <?php }
              }?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- View Order Modal -->
<div class="modal fade" id="viewOrderModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Order Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <table class="table table-striped">
          <tbody>
            <tr><th>Customer Name</th><td id="viewCustomerName"></td></tr>
            <tr><th>Product Name</th><td id="viewProductName"></td></tr>
            <tr><th>Quantity</th><td id="viewQuantity"></td></tr>
            <tr><th>Total Price</th><td id="viewTotalPrice"></td></tr>
            <tr><th>Status</th><td id="viewOrderStatus"></td></tr>
            <tr><th>Order Date</th><td id="viewOrderDate"></td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<script>
$(document).on('click', '.toggleStatusBtn', function() {
    var button = $(this);
    var orderId = button.data('id');
    var currentStatus = button.data('status');

    // Toggle status
    var newStatus = (currentStatus === 'success') ? 'pending' : 'success';

    $.ajax({
        url: '<?= base_url("admin/toggle_order_status"); ?>',
        type: 'POST',
        data: {
            order_id: orderId,
            status: newStatus
        },
        success: function(response) {
            // Remove whitespace and handle response correctly
            response = response.trim();

            if (response === 'updated') {
                // Update button appearance based on the new status
                button.data('status', newStatus);
                button
                    .removeClass('btn-success btn-secondary')
                    .addClass(newStatus === 'success' ? 'btn-success' : 'btn-secondary')
                    .html(newStatus === 'success' ? '✔️' : '❌');
            } else {
                alert('Failed to update status');
            }
        },
        error: function() {
            alert('Something went wrong, please try again.');
        }
    });
        
});
$(document).on('click', '.cancelOrderBtn', function() {
    if (!confirm('Are you sure you want to cancel this order?')) return;

    var orderId = $(this).data('id');
    var button = $(this);

    $.ajax({
        url: '<?= base_url("admin/cancel_order"); ?>',
        type: 'POST',
        data: { order_id: orderId },
        success: function(response) {
            response = response.trim();
            if (response === 'cancelled') {
                // Update the status in the UI and disable the button
                button.closest('tr').find('td:eq(5)').html('<span class="badge bg-danger">Canceled</span>');
                button.prop('disabled', true);
                alert('Order and items successfully canceled.');
            } else {
                alert('Failed to cancel the order.');
            }
        },
        error: function() {
            alert('Something went wrong. Please try again.');
        }
    });
});

$(document).on('click', '.viewOrderBtn', function() {
    var orderId = $(this).data('id');

    $.ajax({
        url: '<?= base_url("admin/get_order_details"); ?>',
        type: 'POST',
        data: { order_id: orderId },
        dataType: 'json',
        success: function(order) {
            if (order) {
                $('#viewCustomerName').text(order.customer_name);
                $('#viewProductName').text(order.product_name);
                $('#viewQuantity').text(order.quantity);
                $('#viewTotalPrice').text('₹' + parseFloat(order.total_price).toFixed(2));
                $('#viewOrderStatus').html(order.order_status === 'success' ? 
                  '<span class="badge bg-success">Delivered</span>' : 
                  order.order_status === 'pending' ? 
                  '<span class="badge bg-warning text-dark">Pending</span>' : 
                  '<span class="badge bg-danger">Canceled</span>'
                );
                $('#viewOrderDate').text(order.created_at);

                $('#viewOrderModal').modal('show');
            } else {
                alert('Order not found.');
            }
        },
        error: function() {
            alert('Failed to fetch order details.');
        }
    });
});


</script>







<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
