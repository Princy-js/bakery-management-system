

  <!-- Loader 4 -->

  <div class="preloader" style="position: fixed;top:0;left:0;width: 100%;height: 100%;background-color: #fff;display: flex;align-items: center;justify-content: center;z-index: 9999;">
    <svg version="1.1" id="L4" width="100" height="100" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
    viewBox="0 0 50 100" enable-background="new 0 0 0 0" xml:space="preserve">
    <circle fill="#111" stroke="none" cx="6" cy="50" r="6">
      <animate
        attributeName="opacity"
        dur="1s"
        values="0;1;0"
        repeatCount="indefinite"
        begin="0.1"/>    
    </circle>
    <circle fill="#111" stroke="none" cx="26" cy="50" r="6">
      <animate
        attributeName="opacity"
        dur="1s"
        values="0;1;0"
        repeatCount="indefinite" 
        begin="0.2"/>       
    </circle>
    <circle fill="#111" stroke="none" cx="46" cy="50" r="6">
      <animate
        attributeName="opacity"
        dur="1s"
        values="0;1;0"
        repeatCount="indefinite" 
        begin="0.3"/>     
    </circle>
    </svg>
  </div>


<!-- Quick View Modal -->
<div class="modal fade" id="modaltoggle" aria-hidden="true" tabindex="-1">
  <div class="modal-dialog modal-fullscreen-md-down modal-md modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <div class="col-lg-12 col-md-12 me-3">
          <div class="image-holder position-relative">
            <img id="modalProductImage" class="img-fluid modal-product-img" alt="Product Image">
            <span id="modalOfferBadge" class="badge bg-success position-absolute top-0 start-0 m-2 d-none">Offer</span>
            <span id="modalOutOfStock" class="badge bg-danger position-absolute top-0 end-0 m-2 d-none">Out of Stock</span>
          </div>
        </div>
        <div class="col-lg-12 col-md-12">
          <div class="summary">
            <div class="summary-content fs-6">
              <div class="product-header d-flex justify-content-between mt-4">
                <h3 class="display-7" id="modalProductName"></h3>
                <div class="modal-close-btn">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
              </div>

              <!-- Price section -->
              <span class="product-price fs-3">
                <span id="modalOfferPrice" class="text-success fw-bold d-none"></span>
                <span id="modalOriginalPrice" class="text-muted text-decoration-line-through small ms-2 d-none"></span>
                <span id="modalRegularPrice" class="fw-bold"></span>
              </span>

              <div class="product-details">
                <p class="fs-7" id="modalProductDescription"></p>
              </div>

              <div class="variations-form shopify-cart">
                <div class="row">
                  <div class="col-md-6">
                    <div class="categories d-flex flex-wrap pt-3">
                      <strong class="pe-2">Category:</strong>
                      <span id="modalProductCategory"></span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <button id="modalAddToCartBtn" type="submit" class="btn btn-medium btn-purple add-to-cart-btn" data-id="<?php echo $pr['id'] ?? ''; ?>">
  Add to cart
</button>

                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


  
  <!-- Cart Modal -->
<div class="modal fade" id="modallong" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-fullscreen-md-down modal-md modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title fs-5">Cart</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="cart-modal-body">
        <!-- Dynamic cart content goes here -->
        <p class="text-center">Loading your cart...</p>
      </div>
    </div>
  </div>
</div>











<div id="homepageCarousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="<?php echo base_url('assets/images/1.png'); ?>" class="d-block w-100" alt="Banner 1">
    </div>
    <div class="carousel-item">
      <img src="<?php echo base_url('assets/images/2.png'); ?>" class="d-block w-100" alt="Banner 2">
    </div>
  </div>
  <!-- Controls -->
  <button class="carousel-control-prev" type="button" data-bs-target="#homepageCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#homepageCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>


      <div class="container py-5">
  <div class="row g-4 text-center">
    
    <!-- Card 1 -->
    <div class="col-md-3 col-sm-6">
      <div class="feature-card p-4 shadow-sm rounded">
        <div class="icon mb-3">
          <i class="fas fa-shipping-fast fa-2x icon-purple"></i>
        </div>
        <h5 class="fw-bold">Easy To Buy</h5>
        <p class="text-muted">Single click to buy.</p>
      </div>
    </div>
    
    <!-- Card 2 -->
    <div class="col-md-3 col-sm-6">
      <div class="feature-card p-4 shadow-sm rounded">
        <div class="icon mb-3">
          <i class="fas fa-headset fa-2x icon-pink"></i>
        </div>
        <h5 class="fw-bold">24x7 Support</h5>
        <p class="text-muted">Support 24 hours a day.</p>
      </div>
    </div>
    
    <!-- Card 3 -->
    <div class="col-md-3 col-sm-6">
      <div class="feature-card p-4 shadow-sm rounded">
        <div class="icon mb-3">
          <i class="fas fa-tags fa-2x icon-purple"></i>
        </div>
        <h5 class="fw-bold">Affordable Prices</h5>
        <p class="text-muted">Get factory prices.</p>
      </div>
    </div>
    
    <!-- Card 4 -->
    <div class="col-md-3 col-sm-6">
      <div class="feature-card p-4 shadow-sm rounded">
        <div class="icon mb-3">
          <i class="fas fa-lock fa-2x icon-pink"></i>
        </div>
        <h5 class="fw-bold">Secure Payments</h5>
        <p class="text-muted">100% protected.</p>
      </div>
    </div>

  </div>

</div>


  <section id="featured-products" class="product-store">
    <div class="container-md">
      <div class="display-header d-flex align-items-center justify-content-between">
        <h2 class="section-title text-uppercase">Our Products</h2>
        <div class="btn-right">
          <a href="<?php echo base_url('user/products'); ?>" class="d-inline-block text-uppercase text-hover fw-bold">View all</a>
        </div>
      </div>
      <div class="product-content padding-small">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5">
          <?php
            if(!empty($products)){
              $i=0;
              foreach($products as $pr){
                if ($i >= 10) break; 
                $i++;
          ?>
         <div class="col mb-4">
           <div class="product-card position-relative">
             <div class="card-img position-relative">
               <?php if (!empty($pr['image']) && file_exists('assets/images/'.$pr['image'])) : ?>
                 <img src="<?php echo base_url('assets/images/'.$pr['image']); ?>" alt="Product Image" class="product-image img-fluid">
               <?php else : ?>
                 <img src="<?php echo base_url()?>assets/images/no-image.png" alt="Product Image" class="product-image img-fluid">
               <?php endif; ?>

               <!-- Availability Badge -->
               <?php if (strtolower($pr['availability']) == 'not available') : ?>
                 <span class="availability-badge position-absolute top-0 start-0 bg-danger text-white px-2 py-1 small rounded-end">
                   Not Available
                 </span>
               <?php endif; ?>
                             <?php if (!empty($pr['offer_percent']) && $pr['offer_percent'] > 0) : ?>
                 <span class="offer-badge position-absolute top-0 end-0 text-white px-2 py-1 small rounded-end">
                   <?= $pr['offer_percent'] ?>% Off
                 </span>
               <?php endif; ?>

               <div class="cart-concern position-absolute d-flex justify-content-center">
                 <div class="cart-button d-flex gap-2 justify-content-center align-items-center">

                   <button type="button" class="btn btn-light add-to-cart-btn" data-id="<?php echo $pr['id']; ?>">
  <svg class="shopping-carriage">
    <use xlink:href="#shopping-carriage"></use>
  </svg>
</button>

                   


                   <button type="button" class="btn btn-light quick-view-btn"
  data-id="<?php echo $pr['id']; ?>"
  data-bs-toggle="modal" 
  data-bs-target="#modaltoggle">
  <svg class="quick-view ">
    <use xlink:href="quick-view"></use>
  </svg>

</button>


                 </div>
               </div>
             </div>
    
             <div class="card-detail d-flex justify-content-between align-items-center mt-3">
               <h3 class="card-title fs-6 fw-normal m-0">
                 <a href="#"><?php echo $pr['name']?></a>
               </h3>
              <?php if (!empty($pr['offer_id']) && !empty($pr['offer_price']) && $pr['offer_price'] > 0): ?>
  <span class="card-price fw-bold text-success">&#8377; <?php echo number_format($pr['offer_price'], 2); ?></span>
<?php else: ?>
  <span class="card-price fw-bold">&#8377; <?php echo number_format($pr['original_price'], 2); ?></span>
<?php endif; ?>
             </div>
           </div>
         </div>
          <?php }
              }?>
        </div>
      </div>
    </div>
  </section>

  <a
  href="https://wa.me/9188572656?text=Hi%20I%20am%20interested%20in%20placing%20a%20bulk%20order"
  class="whatsapp-float"
  target="_blank"
  title="Chat with us on whatsapp for bulk orders"
>
  <img src="https://img.icons8.com/ios-filled/50/ffffff/whatsapp.png" alt="WhatsApp" />
</a>

</body>

</html>


<script type="text/javascript">
  $(document).ready(function () {
    // ✅ Quick view modal - already working
    $('.quick-view-btn').on('click', function () {
      var product_id = $(this).data('id');

      $.ajax({
        url: "<?php echo base_url('user/get_product_details'); ?>",
        method: "POST",
        data: { id: product_id },
        dataType: "json",
        success: function (response) {
          $('#modalProductImage').attr('src', "<?php echo base_url('assets/images/'); ?>" + response.image);
          $('#modalProductName').text(response.name);
          $('#modalProductDescription').text(response.description);
          $('#modalProductCategory').text(response.category_name);

          // Hide all price/offer elements first
          $('#modalOfferPrice, #modalOriginalPrice, #modalRegularPrice, #modalOfferBadge, #modalOutOfStock').addClass('d-none');

          // Show price logic
          if (response.offer_id && response.offer_price > 0) {
            $('#modalOfferPrice').text('₹' + parseFloat(response.offer_price).toFixed(2)).removeClass('d-none');
            $('#modalOriginalPrice').text('₹' + parseFloat(response.original_price).toFixed(2)).removeClass('d-none');
            $('#modalOfferBadge').removeClass('d-none');
          } else {
            $('#modalRegularPrice').text('₹' + parseFloat(response.original_price).toFixed(2)).removeClass('d-none');
          }

          // Stock status + update Add to Cart button
          if (response.availability === 'Not Available') {
            $('#modalOutOfStock').removeClass('d-none');
            $('#modalAddToCartBtn').prop('disabled', true).text('Out of Stock');
          } else {
            $('#modalOutOfStock').addClass('d-none');
            $('#modalAddToCartBtn').prop('disabled', false).text('Add to Cart');
          }

          //  Set product ID to modal add-to-cart button
          $('#modalAddToCartBtn').attr('data-id', response.id);
        }
      });
    });

    // Reusable Add to Cart handler for all buttons (modal + card)
    $(document).on('click', '.add-to-cart-btn', function () {
      var product_id = $(this).data('id');

      //  Check stock only if it's the modal button
      if ($(this).attr('id') === 'modalAddToCartBtn' && $('#modalOutOfStock').is(':visible')) {
        alert('Sorry, this product is not available.');
        return;
      }

      console.log("Clicked Add to Cart. Product ID: " + product_id);

      $.ajax({
        url: "<?php echo base_url('user/add_to_cart'); ?>",
        method: "POST",
        data: { product_id: product_id },
        dataType: "json",
        success: function (response) {
          if (response.status === 'success') {
            alert('Product added to cart!');
            // Optionally update cart count or show toast
          } else if (response.status === 'login_required') {
            alert('Please log in to add items to cart.');
          } else {
            alert('You cannot add this product to cart.');
            console.log(response.message);
          }
        },
        error: function (xhr, status, error) {
          console.error('AJAX Error:', status, error);
          alert('Server error. Try again later.');
        }
      });
    });

  $('#modallong').on('show.bs.modal', function () {
    $.ajax({
      url: "<?php echo base_url('user/load_cart'); ?>",
      method: "GET",
      dataType: "html",
      success: function (response) {
        $('#cart-modal-body').html(response);
      },
      error: function () {
        $('#cart-modal-body').html('<p class="text-danger text-center">Failed to load cart.</p>');
      }
    });
  });
  $(document).on('click', '.increase-qty', function () {
    let cartId = $(this).data('id');
    updateQuantity(cartId, 'increase');
});

$(document).on('click', '.decrease-qty', function () {
    let cartId = $(this).data('id');
    updateQuantity(cartId, 'decrease');
});

$(document).on('click', '.remove-cart-item', function () {
    let cartId = $(this).data('id');
    $.ajax({
        url: "<?php echo base_url('user/remove_item'); ?>",
        method: 'POST',
        data: { id: cartId },
        success: function () {
            loadCartModal(); // Reload the modal content
        }
    });
});

function updateQuantity(cartId, action) {
    $.ajax({
        url: "<?php echo base_url('user/update_quantity'); ?>",
        method: 'POST',
        data: { id: cartId, action: action },
        success: function () {
            loadCartModal(); // Reload the modal content
        }
    });
}

function loadCartModal() {
    $.ajax({
        url: "<?php echo base_url('user/load_cart'); ?>",
        method: 'GET',
        success: function (data) {
            $('#cart-modal-body').html(data);
        }
    });
}


  });
</script>










