<?php if (empty($cart)): ?>
  <p class="text-center">Your cart is empty.</p>
<?php else:
  $subtotal = 0;
  foreach ($cart as $crt):
    $price = $crt->offer_id && $crt->offer_price ? $crt->offer_price : $crt->original_price;
    $total = $price * $crt->quantity;
    $subtotal += $total;
?>
  <div class="mini-cart-item d-flex border-bottom pb-3">
  <div class="cart-img me-3">
    <img src="<?= base_url('assets/images/' . $crt->image); ?>" class="img-fluid" alt="<?= $crt->name ?>">
  </div>
  <div class="cart-details flex-grow-1">
    <div class="d-flex justify-content-between align-items-start">
      <h5 class="cart-title mb-0"><?= $crt->name ?></h5>
      <button class="btn btn-sm btn-pink remove-cart-item" title="delete product" data-id="<?= $crt->id ?>">×</button>
    </div>
    <div class="d-flex justify-content-between align-items-center mt-2">
      <div class="input-group qty-group" style="width: 120px;">
        <button class="btn btn-light decrease-qty" data-id="<?= $crt->id ?>">-</button>
        <input type="text" class="form-control text-center" value="<?= $crt->quantity ?>" readonly>
        <button class="btn btn-light increase-qty" data-id="<?= $crt->id ?>">+</button>
      </div>
      <div class="cart-price ms-3">
        <strong>₹<?= number_format($total, 2) ?></strong>
      </div>
    </div>
  </div>
</div>

<?php endforeach; ?>

  <div class="mini-cart-total d-flex justify-content-between py-4">
    <span class="fs-6">Subtotal:</span>
    <span><strong>₹<?= number_format($subtotal, 2) ?></strong></span>
  </div>

  <div class="modal-footer my-4 justify-content-center">
    <a href="<?= base_url('user/checkout') ?>" class="btn btn-purple">Order Now</a>
    
  </div>
<?php endif; ?>


<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">