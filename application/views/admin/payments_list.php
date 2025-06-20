<div class="container">
  <div class="page-inner">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h4 class="card-title">Payments</h4>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="basic-datatables" class="display table table-striped table-hover">
                <thead>
                  <tr>
                    <th class="col-1">#</th>
                    <th>Customer Name</th>
                    <th>order id</th>
                    <th>Amount</th>
                    <th>payment mode</th>
                    <th>status</th>
                    <th class="col-3">Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th class="col-1">#</th>
                    <th>Customer Name</th>
                    <th>Order Id</th>
                    <th>Amount</th>
                    <th>Payment Mode</th>
                    <th>Status</th>
                  </tr>
                </tfoot>

                <tbody>
                                    <?php if (!empty($payments)) { ?>
                    <?php $i = 0; foreach ($payments as $payment) { $i++; ?>
                      <tr>
                        <td><?php echo $i; ?></td>
                        <td><?= $payment['customer_name']; ?></td>
                        <td><?= $payment['order_id']; ?></td>
                        <td>₹<?= number_format($payment['amount_paid'], 2); ?></td>
                        <td><?= ucfirst($payment['payment_mode']); ?></td>
                        <td>
                          <?php if ($payment['status'] == 1) { ?>
                            <span class="badge bg-success">Amount Paid</span>
                          <?php } else { ?>
                            <span class="badge bg-danger">Amount Not Paid</span>
                          <?php } ?>
                        </td>
                        <td>

                            <button class="btn btn-primary viewPaymentBtn" title="View" data-id="<?= $payment['payment_id']; ?>">
                                <i class="fa fa-search"></i>
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


<!-- View Payment Modal -->
<div class="modal fade" id="viewPaymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <tbody>
                        <tr><th>Customer Name</th><td id="viewPaymentCustomerName"></td></tr>
                        <tr><th>Order ID</th><td id="viewPaymentOrderId"></td></tr>
                        <tr><th>Amount Paid</th><td id="viewPaymentAmount"></td></tr>
                        <tr><th>Payment Mode</th><td id="viewPaymentMode"></td></tr>
                        <tr><th>Status</th><td id="viewPaymentStatus"></td></tr>
                        <!-- <tr><th>Payment Date</th><td id="viewPaymentDate"></td></tr> -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
$(document).on('click', '.viewPaymentBtn', function() {
    var paymentId = $(this).data('id');  // Get payment_id from the button
    console.log("Payment ID:", paymentId); // Log the payment ID to the console
    
    $.ajax({
        url: '<?= base_url("admin/view_payment_details"); ?>',
        type: 'POST',
        data: { payment_id: paymentId },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                // Populate modal with payment data
                var payment = response.data;
                $('#viewPaymentCustomerName').text(payment.customer_name);
                $('#viewPaymentOrderId').text(payment.order_id);
                $('#viewPaymentAmount').text('₹' + parseFloat(payment.amount_paid).toFixed(2));
                $('#viewPaymentMode').text(payment.payment_mode);
                $('#viewPaymentStatus').text(payment.payment_status == 1 ? 'Paid' : 'Not Paid');
                // $('#viewPaymentDate').text(payment.created_at);

                // Show the modal
                $('#viewPaymentModal').modal('show');
            } else {
                alert(response.message);
            }
        },
        error: function() {
            alert('Something went wrong, please try again.');
        }
    });
});

$(document).on('click', '.togglePaymentStatusBtn', function() {
    var button = $(this);
    var paymentId = button.data('id');
    var currentStatus = button.data('status');

    // Toggle status
    var newStatus = (currentStatus === 1) ? 0 : 1;

    $.ajax({
        url: '<?= base_url("admin/toggle_payment_status"); ?>',
        type: 'POST',
        data: {
            payment_id: paymentId,
            status: newStatus
        },
        success: function(response) {
            // Remove whitespace and handle response correctly
            response = response.trim();

            if (response === 'updated') {
                // Update button appearance based on the new status
                button.data('status', newStatus);
                button
                    .removeClass('btn-success btn-danger')
                    .addClass(newStatus === 1 ? 'btn-success' : 'btn-danger')
                    .html(newStatus === 1 ? 'Paid' : 'Not Paid');
            } else {
                alert('Failed to update payment status');
            }
        },
        error: function() {
            alert('Something went wrong, please try again.');
        }
    });
});


</script>

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">

