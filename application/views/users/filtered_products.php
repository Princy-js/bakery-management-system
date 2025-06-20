<?php if(!empty($products)){ foreach($products as $pr){ ?>
  <div class="col mb-4">
    <div class="product-card position-relative">
      <div class="card-img">
        <img src="<?php echo base_url('assets/images/'.$pr['image']); ?>" alt="<?php echo $pr['name']?>" class="product-image img-fluid">
        <div class="cart-concern position-absolute d-flex justify-content-center">
          <div class="cart-button d-flex gap-2 justify-content-center align-items-center">
            <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#modallong">
              <svg class="shopping-carriage"><use xlink:href="#shopping-carriage"></use></svg>
            </button>
            <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#modaltoggle">
              <svg class="quick-view"><use xlink:href="#quick-view"></use></svg>
            </button>
          </div>
        </div>
      </div>
      <div class="card-detail d-flex justify-content-between align-items-center mt-3">
        <h3 class="card-title fs-6 fw-normal m-0"><a href="#"><?php echo $pr['name']?></a></h3>
        <span class="card-price fw-bold">&#8377; <?php echo number_format($pr['price'], 1); ?></span>
      </div>
    </div>
  </div>
<?php }} else { ?>
  <div class="col-12"><p>No products found in this category.</p></div>
<?php } ?>
