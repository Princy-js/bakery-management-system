<div class="container">
  <div class="page-inner">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h4 class="card-title">Products</h4>
              <button class="btn btn-purple btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="fa fa-plus"></i>
                Add Product
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="basic-datatables" class="display table table-striped table-hover">
                <thead>
                  <tr>
                    <th class="col-1">#</th>
                    <th>image</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Availability</th>
                    <th>price</th>
                    <th>Offer Price</th>
                    <th class="col-3">Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th class="col-1">#</th>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Availability</th>
                    <th>Price</th>
                    <th>Offer Price</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php
                    if(!empty($products)){
                      $i=0;
                      foreach($products as $pr){
                        $i++;
                  ?>
                  <tr>
                    <td><?php echo $i;?></td>
                    <td class="avatar-sm">
                      <?php if (!empty($pr['image']) && file_exists('assets/images/'.$pr['image'])) : ?>
                        <img src="<?php echo base_url('assets/images/'.$pr['image']); ?>" alt="Product Image" class="avatar-img rounded-circle">
                      <?php else : ?>
                        <img src="<?php echo base_url()?>assets/images/no-image.png" alt="Product Image" class="avatar-img rounded-circle">
                      <?php endif; ?>
                    </td>
                    <td><?php echo $pr['name']?></td>
                    <td><?php echo $pr['category_name']?></td>
                    <td><?php echo $pr['availability']?></td>
                    <td>&#8377; <?php echo number_format($pr['original_price'], 1); ?></td>
                    <td>&#8377; <?php echo number_format($pr['offer_price'], 1); ?></td>
                    <td>
                      <button class="btn btn-primary" title="View" onclick="openViewModal(<?php echo $pr['id']; ?>)"><i class="fa fa-search"></i>
                      </button>
                      <button class="btn btn-purple" title="edit" data-bs-toggle="modal" data-bs-target="#editProductModal" onclick="openEditModal(<?php echo $pr['id']; ?>)"><i class="fa fa-edit"></i>
                      </button>
                      <button class="btn btn-danger" title="delete" onclick="delete_product_info(<?php echo $pr['id'];?>);"><i class="fa fa-trash"></i>
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

<!-- Add product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php $attributes = array("name" => "save_category","method"=>"POST");
        echo form_open_multipart("admin/save_product",$attributes);?>
        <form>
          <div class="row">
              <div class="col-md-6">
                <div class="row">
                  <div class="col-sm-12 mb-3">
                    <label for="productname" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="productname" name="productname" required>
                    <div class="invalid-feedback">name is required.</div>
                  </div>
                  <div class="col-sm-12 mb-3">
                    <label for="categoryname" class="form-label">Category</label>
                      <select class="form-select" id="categoryname" name="categoryname" required>
                        <option value="">Select category</option>
                          <?php foreach ($categories as $ca) : ?>
                          <option value="<?php echo $ca['id']; ?>"><?php echo $ca['category_name']; ?></option>
                          <?php endforeach; ?>
                      </select>
                    <div class="invalid-feedback">Category is required.</div>
                  </div>
                  <div class="col-sm-6 mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" class="form-control" id="price" name="price" required>
                    <div class="invalid-feedback">Price is required</div>
                  </div>
                  <div class="col-sm-6 mb-3">
                    <label for="availability" class="form-label">Availability</label>
                    <select class="form-select" id="availability" name="availability" required>
                      <option value="">Select</option>
                      <option value="Available">Available</option>
                      <option value="Not Available">Not Available</option>
                    </select> 
                    <div class="invalid-feedback">Availability is required.</div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="row">
                  <div class="col-sm-12 mb-3">
                    <label for="description" class="form-label">Description</label>
                      <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                  </div>
                  <div class="col-sm-12 mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" id="image" name="image">
                  </div>
                </div>
              </div>
            </div>
          <button type="submit" class="btn btn-purple btn-sm">Save Product</button>
        </form>
        <?php echo form_close();?>
      </div>
    </div>
  </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updateProductForm">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <input type="hidden" id="editProductId" name="id">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="row">
                        <div class="col-sm-12 mb3">
                          <label for="editProductName" class="form-label">Product Name</label>
                          <input type="text" class="form-control" id="editProductName" name="productname" required>
                        </div>
                        <div class="col-sm-12 mb3">
                          <label for="editCategoryName" class="form-label">Category</label>
                          <select class="form-select" id="editCategoryName" name="categoryname" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $cat) : ?>
                                <option value="<?php echo $cat['id']; ?>"><?php echo $cat['category_name']; ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="col-sm-6 mb-3">
                          <label for="editPrice" class="form-label">Price</label>
                          <input type="number" class="form-control" id="editPrice" name="price" required>
                        </div>
                        <div class="col-sm-6 mb-3">
                          <label for="editAvailability" class="form-label">Availability</label>
                          <select class="form-select" id="editAvailability" name="availability" required>
                            <option value="Available">Available</option>
                            <option value="Not Available">Not Available</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="row">
                        <div class="col-sm-12 mb-3">
                          <label for="editDescription" class="form-label">Description</label>
                          <textarea class="form-control" id="editDescription" name="description" rows="3"></textarea>
                        </div>
                        <div class="col-sm-12 mb-3">
                          <label for="editImage" class="form-label">Image</label>
                          <input type="file" class="form-control" id="editImage" name="image">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="modal-footer">
                    <button type="submit" class="btn btn-purple">Update Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Product Modal -->
<div class="modal fade" id="viewProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th>Product Name</th>
                            <td id="viewProductName"></td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td id="viewCategoryName"></td>
                        </tr>
                        <tr>
                            <th>Availability</th>
                            <td id="viewAvailability"></td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td> <span id="viewPrice"></span></td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td id="viewDescription"></td>
                        </tr>
                        <tr>
                            <th>Image</th>
                            <td>
                                <img id="viewProductImage" src="" alt="Product Image" class="img-fluid" width="150">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>




<script>


$(document).ready(function() {
    $('#addProductModal form').submit(function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: "<?php echo base_url('admin/save_product'); ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Close modal and reset form after success
                $('#addProductModal').modal('hide');
                $('#addProductModal form')[0].reset();

                // Reload the product list without refreshing the page
                loadProductList();
            }
        });
    });

    // Function to reload product list
    function loadProductList() {
        $.ajax({
            url: "<?php echo base_url('admin/products'); ?>",
            type: "GET",
            success: function(data) {
                var tableBody = $(data).find("tbody").html();
                $("#basic-datatables tbody").html(tableBody);
            }
        });
    }
});

// function for edit product
// Open edit modal and load product data
function openEditModal(id) {
    $.ajax({
        url: "<?php echo base_url('admin/edit_product/'); ?>" + id,
        type: "GET",
        dataType: "json",
        success: function(response) {
            $('#editProductId').val(response.products.id);
            $('#editProductName').val(response.products.name);
            $('#editCategoryName').val(response.products.category_id);
            $('#editDescription').val(response.products.description);
            $('#editPrice').val(response.products.original_price);
            $('#editAvailability').val(response.products.availability);

            $('#editProductModal').modal('show');
        }
    });
}

// Handle form submission for update
$('#updateProductForm').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: "<?php echo base_url('admin/update_product/'); ?>" + $('#editProductId').val(),
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            $('#editProductModal').modal('hide');
            location.reload(); // Reload table after update
        }
    });
});

// view product details
function openViewModal(id) {
    $.ajax({
        url: "<?php echo base_url('admin/view_product/'); ?>" + id,
        type: "GET",
        dataType: "json",
        success: function(response) {
            console.log(response);
            
            if (response.product) {
                $('#viewProductName').text(response.product.name || "N/A");
                $('#viewCategoryName').text(response.product.category_name || "N/A");
                $('#viewAvailability').text(response.product.availability || "N/A");
                $('#viewPrice').text("₹ " + (response.product.original_price || "0.00"));
                $('#viewDescription').text(response.product.description || "N/A");

                if (response.product.image) {
                    $('#viewProductImage').attr('src', "<?php echo base_url('assets/images/'); ?>" + response.product.image);
                } else {
                    $('#viewProductImage').attr('src', "<?php echo base_url('assets/images/no-image.png'); ?>");
                }

                $('#viewProductModal').modal('show');
            } else {
                alert("No product data received.");
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log(xhr.responseText);
            alert("Failed to fetch product details.");
        }
    });
}



// delete product
function delete_product_info(id) {
        var confirmDelete = confirm("Are you sure you want to delete?");
        if (confirmDelete) {
            $.ajax({
                url: '<?php echo base_url('admin/delete_product'); ?>',
                method: 'POST',
                data: { id: id },
                success: function(response) {
                    location.reload();
                },
        });
    }
}

</script>


<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">