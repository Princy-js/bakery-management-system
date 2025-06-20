<section class="bg-light py-5">
  <div class="container">
    <div class="row">
      <div class="col-md-4 mb-4">
        <div class="card p-3 feature-card p-4 shadow-sm rounded">
          <div class="text-center">
            <img src="<?= base_url('assets/images/profile.gif'); ?>" alt="Profile" class="img-fluid rounded-circle" >
            <h4 class="mt-2">Welcome, <?= $user['name']; ?></h4>
          </div>
          <hr>
          <p><strong>Email:</strong> <?= $user['email']; ?></p>
          <form method="post" action="<?= base_url('user/update_profile'); ?>">
            <div class="mb-3">
              <label for="phone">Phone:</label>
              <input type="text" name="phone" class="form-control" value="<?= $user['phone']; ?>" placeholder="Enter phone number">
            </div>
            <div class="mb-3">
              <label for="address">Address:</label>
              <textarea name="address" class="form-control" placeholder="Enter address"><?= $user['address']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-purple w-100">Update</button>
          </form>
          <a href="<?= base_url('user/logout'); ?>" class="btn btn-pink w-100 mt-3">Logout</a>
        </div>
      </div>


<div class="col-md-8">
  <h4>Your Orders</h4>
  <?php if (!empty($orders)): ?>
    <?php foreach ($orders as $order): ?>
      <div class="card mb-3 p-3 feature-card p-4 shadow-sm rounded">
        <div class="row">
          <div class="col-3">
            <img src="<?= base_url('assets/images/' . $order->image); ?>" class="img-fluid rounded" alt="<?= $order->name ?>">
          </div>
          <div class="col-9">
            <div class="d-flex justify-content-between">
              <h5><?= $order->name ?></h5>
              <form method="post" class="cancel-form" action="<?= base_url('user/cancel_order/' . $order->order_id); ?>">

                     <?php if ($order->status == 1): ?>
        <button class="btn btn-sm btn-danger cancel-item-btn" data-id="<?= $order->id ?>">
          ×
        </button>
      <?php else: ?>
          <span class="text-danger">Canceled</span>
      <?php endif; ?>

              </form>
            </div>
         
            <p>
  Qty: <?= $order->quantity ?> | 
  Unit Price: ₹<?= number_format($order->total_price / $order->quantity, 2) ?> | 
  Total: ₹<?= number_format($order->total_price, 2) ?>
</p>

<p>
  Order Status:
  <?php
    $order_status = strtolower(trim($order->order_status)); // normalize
    $status_class = 'text-secondary'; // default color

    if ($order_status === 'success') {
        $status_class = 'text-success';
    } elseif ($order_status === 'pending') {
        $status_class = 'text-warning';
    } elseif ($order_status === 'cancel') {
        $status_class = 'text-danger';
    }
  ?>
  <span class="<?= $status_class; ?>"><?= ucfirst($order_status); ?></span>
</p>



<p>
  Payment Status:
  <?php
    $pay_class = ($order->payment_status == 'Paid') ? 'text-success' : 'text-danger';
  ?>
  <span class="<?= $pay_class; ?>"><?= $order->payment_status; ?></span>
</p>

            
           

            <button class="btn btn-sm btn-purple open-review-modal" data-order-id="<?= $order->product_id ?>" data-name="<?= $order->name ?>" >
              Add Review
            </button>
        

   
          </div>
        </div>
      </div>
    <?php endforeach; ?>
    <a href="<?= base_url('user/invoice/' . $order->order_id) ?>" target="_blank" class="btn btn-sm btn-pink">
    🧾 View Invoice
</a>
  <?php else: ?>
    <p>You have no orders yet.</p>
  <?php endif; ?>
  


</div>



    </div>
  </div>
</section>



<div class="modal" id="reviewModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 shadow" style="max-width: 450px;">

      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">
          <i class="bi bi-star-fill text-warning"></i> Feedback
        </h4>
        <button type="button" class="btn-close" aria-label="Close" onclick="$('#reviewModal').fadeOut();"></button>
      </div>

      <h5 class="fw-semibold mb-2">How was your experience with <span id="modalProductName" class="text-primary"></span>?</h5>

      <form id="reviewForm">
        <input type="hidden" name="product_id" id="product_id">

        <!-- Star Rating -->
        <div class="mb-3 star-rating">
          <input type="radio" name="rating" value="5" id="rate-5"><label for="rate-5">★</label>
          <input type="radio" name="rating" value="4" id="rate-4"><label for="rate-4">★</label>
          <input type="radio" name="rating" value="3" id="rate-3"><label for="rate-3">★</label>
          <input type="radio" name="rating" value="2" id="rate-2"><label for="rate-2">★</label>
          <input type="radio" name="rating" value="1" id="rate-1"><label for="rate-1">★</label>
        </div>

        <!-- Review Comment -->
        <div class="mb-3">
          <textarea class="form-control" name="comment" placeholder="Add a comment..." rows="3" required></textarea>
        </div>

        <!-- Submit -->
        <div class="d-grid">
          <button type="submit" class="btn btn-purple btn-lg">
            Submit Now
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


<div id="reviewSuccessMsg" class="alert alert-success position-fixed top-0 end-0 m-4" style="display:none; z-index:9999;">
  ✅ Review submitted successfully!
</div>
<a
  href="https://wa.me/9188572656?text=Hi%20I%20am%20interested%20in%20placing%20a%20bulk%20order"
  class="whatsapp-float"
  target="_blank"
  title="Chat with us on WhatsApp for bulk orders"
>
  <img src="https://img.icons8.com/ios-filled/50/ffffff/whatsapp.png" alt="WhatsApp" />
</a>

<script>
$(document).ready(function() {

  // Cancel Item AJAX
  $('.cancel-item-btn').click(function(e) {
    e.preventDefault();
    const itemId = $(this).data('id');

    if (confirm("Are you sure you want to cancel this item?")) {
      $.ajax({
        url: '<?= base_url("user/cancel_order_item") ?>',
        type: 'POST',
        data: { item_id: itemId },
        dataType: 'json',
        success: function(response) {
          alert(response.message);
          if (response.status === 'success') {
            location.reload();
          }
        },
        error: function() {
          alert('Something went wrong. Try again.');
        }
      });
    }
  });

  // Open Review Modal
  $('.open-review-modal').click(function() {
    const productId = $(this).data('order-id');
    const productName = $(this).data('name');

    $('#product_id').val(productId);
    $('#modalProductName').text(productName);
    $('#reviewModal').fadeIn();
  });

  // Close Modal
  $('.close-btn').click(function() {
    $('#reviewModal').fadeOut();
  });

  // Submit Review AJAX
  $('#reviewForm').submit(function(e) {
    e.preventDefault();
    $.ajax({
      url: '<?= base_url("user/submit_review") ?>',
      type: 'POST',
      data: $(this).serialize(),
      success: function(response) {
        let res = JSON.parse(response);
        if (res.status === 'success') {
          $('#reviewModal').fadeOut();
          $('#reviewForm')[0].reset();
          $('.star-rating label').removeClass('selected');

          // Show success toast
          $('#reviewSuccessMsg').fadeIn().delay(2000).fadeOut();
        } else {
          alert(res.message);
        }
      },
      error: function() {
        alert('Something went wrong. Try again.');
      }
    });
  });

  // Interactive Star Rating
  $('.star-rating label').on('mouseenter', function() {
    $(this).addClass('hovered');
    $(this).prevAll('label').addClass('hovered');
    $(this).nextAll('label').removeClass('hovered');
  });

  $('.star-rating label').on('mouseleave', function() {
    $('.star-rating label').removeClass('hovered');
  });

  $('.star-rating input[type="radio"]').on('change', function() {
    const val = $(this).val();
    $('.star-rating label').each(function() {
      const labelFor = $(this).attr('for');
      const labelVal = labelFor.split('-')[1];
      if (labelVal <= val) {
        $(this).addClass('selected');
      } else {
        $(this).removeClass('selected');
      }
    });
  });

});
</script>










<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">


