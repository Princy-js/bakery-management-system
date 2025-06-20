<section class="bg-light py-5">
  <div class="container">
    <div class="col-md-4 mb-4">
    <div class="card feature-card p-4 shadow-sm rounded">
      <form action="<?= base_url('user/confirm_order'); ?>" method="post">
  <?php $subtotal = 0; ?>
<?php foreach($cart as $crt): ?>
  <div>
    <img src="<?= base_url('assets/images/' . $crt->image); ?>" width="50">
    <?= $crt->name; ?> - ₹<?= $crt->total_price; ?> × <?= $crt->quantity; ?>
    <input type="hidden" name="product_ids[]" value="<?= $crt->product_id; ?>">
    <input type="hidden" name="quantities[]" value="<?= $crt->quantity; ?>">
    <input type="hidden" name="total_prices[]" value="<?= $crt->total_price; ?>">
    <?php $subtotal += $crt->total_price * $crt->quantity; ?>
  </div>
<?php endforeach; ?>

  <h4>Subtotal: ₹<?= number_format($subtotal, 2); ?></h4>
  <input type="hidden" name="subtotal" value="<?= $subtotal; ?>">

  <label for="user_note">Note (e.g., cake message):</label>
  <textarea name="user_note" class="form-control"></textarea>

  <h4>Select Payment Mode:</h4>
  <select name="payment_mode" required class="form-control">
    <option value="cod">Cash on Delivery</option>
    <option value="card">Card</option>
    <option value="net banking">Net Banking</option>
  </select>

  <br>
  <button type="submit" class="btn btn-purple">Place Order</button>
</form>
</div>
</div>
</div>
</section>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">


