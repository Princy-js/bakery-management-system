<div class="container">
  <div class="page-inner">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h4 class="card-title">Offers</h4>
              <button class="btn btn-purple btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#addOfferModal">
                <i class="fa fa-plus"></i>
                Add Offers
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="basic-datatables" class="display table table-striped table-hover">
                <thead>
                  <tr>
                    <th class="col-1">#</th>
                    <th>Offer</th>
                    <th>Category</th>
                    <th>offer percent</th>
                    <th>start date</th>
                    <th>end date</th>
                    <th>status</th>
                    <th class="col-3">Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th class="col-1">#</th>
                    <th>Offer</th>
                    <th>Category</th>
                    <th>Offer Percent</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php
          if(!empty($offers)){
        $i=0;
          foreach($offers as $off){
            $i++;
            ?>
            <tr>
        <td><?php echo $i;?></td>      
        <td><?php echo $off['offer_name']; ?></td>
        <td><?php echo $off['category_name']?></td>
        <td><?php echo $off['offer_percent']; ?></td>
        <td><?php echo $off['start_date']; ?></td>
        <td><?php echo $off['end_date']; ?></td>
        <td><?php echo ($off['status'] == 1) ? 'Active' : 'Inactive'; ?></td>
        <td>
                      <button class="btn btn-primary" title="View" onclick="openViewModal(<?php echo $off['id']; ?>)"><i class="fa fa-search"></i>
                      </button>
                      <button class="btn btn-purple" title="edit" onclick="openEditModal(<?php echo $off['id']; ?>)" ><i class="fa fa-edit"></i>
                      </button>
                      <button class="btn btn-danger" title="delete" onclick="deleteOffer(<?php echo $off['id'];?>);"><i class="fa fa-trash"></i>
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

<!-- Add Offer Modal -->
<div class="modal fade" id="addOfferModal" tabindex="-1" role="dialog" aria-labelledby="addOfferModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addOfferModalLabel">Add Offer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php $attributes = array("name" => "save_category","method"=>"POST");
        echo form_open_multipart("admin/save_offer",$attributes);?>
       <div class="row">
              <div class="col-md-6">
                <div class="row">
                  <div class="col-sm-12 mb-3">
                     <label for="offer_name" class="form-label">Offer Name</label>
            <input type="text" class="form-control" id="offer_name" name="offer_name" required>
                    <div class="invalid-feedback">name is required.</div>
                    
                  </div>
                  <div class="col-sm-12 mb-3">
                     <label for="editCategoryName" class="form-label">Category</label>
            <select class="form-select" id="editCategoryName" name="categoryname" required>
              <option value="">Select Category</option>
              <?php foreach ($categories as $cat) : ?>
                  <option value="<?php echo $cat['id']; ?>"><?php echo $cat['category_name']; ?></option>
              <?php endforeach; ?>
            </select>
                    <div class="invalid-feedback">Category is required.</div>
                  </div>
                  <div class="col-sm-6 mb-3">
                    <label for="offer_percent" class="form-label">Offer Percent</label>
            <input type="number" class="form-control" id="offer_percent" name="offer_percent" step="0.01" required>
                    <div class="invalid-feedback">Price is required</div>
                  </div>
                  <div class="col-sm-6 mb-3">
                   <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
              <option value="1">Active</option>
              <option value="0">Inactive</option>
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
                  <div class="col-sm-6 mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
            <input type="date" class="form-control" id="start_date" name="start_date" required>
                  </div>
                  <div class="col-sm-6 mb-3">
                    <label for="end_date" class="form-label">End Date</label>
            <input type="date" class="form-control" id="end_date" name="end_date" required>
                  </div>
                </div>
              </div>
            </div>
          <button type="submit" class="btn btn-purple">Save Offer</button>
      </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>

<!-- Edit modal -->
<div class="modal fade" id="editOfferModal" tabindex="-1" role="dialog" aria-labelledby="editOfferModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editOfferModalLabel">Edit Offer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php $attributes = array("name" => "update_offer","id" => "updateOfferForm","method"=>"POST");
        echo form_open_multipart("admin/update_offer", $attributes); ?>
        <input type="hidden" id="edit_offer_id" name="id">
        <div class="row">
          <div class="col-md-6">
            <div class="row">
              <div class="col-sm-12 mb-3">
                <label for="edit_offer_name" class="form-label">Offer Name</label>
                <input type="text" class="form-control" id="edit_offer_name" name="offer_name" required>
              </div>
              <div class="col-sm-12 mb-3">
                <label for="edit_offer_category" class="form-label">Category</label>
                <select class="form-select" id="edit_offer_category" name="categoryname" required>
                  <option value="">Select Category</option>
                  <?php foreach ($categories as $cat) : ?>
                      <option value="<?php echo $cat['id']; ?>"><?php echo $cat['category_name']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-sm-6 mb-3">
                <label for="edit_offer_percent" class="form-label">Offer Percent</label>
                <input type="number" class="form-control" id="edit_offer_percent" name="offer_percent" step="0.01" required>
              </div>
              <div class="col-sm-6 mb-3">
                <label for="edit_offer_status" class="form-label">Status</label>
                <select class="form-select" id="edit_offer_status" name="status" required>
                  <option value="1">Active</option>
                  <option value="0">Inactive</option>
                </select>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="row">
              <div class="col-sm-12 mb-3">
                <label for="edit_offer_description" class="form-label">Description</label>
                <textarea class="form-control" id="edit_offer_description" name="description" rows="4"></textarea>
              </div>
              <div class="col-sm-6 mb-3">
                <label for="edit_start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="edit_start_date" name="start_date" required>
              </div>
              <div class="col-sm-6 mb-3">
                <label for="edit_end_date" class="form-label">End Date</label>
                <input type="date" class="form-control" id="edit_end_date" name="end_date" required>
              </div>
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-purple">Update Offer</button>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>

<!-- View Product Modal -->
<div class="modal fade" id="viewOfferModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Offer Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th>Offer Name</th>
                            <td id="viewOfferName"></td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td id="viewCategoryName"></td>
                        </tr>
                         <tr>
                            <th>Description</th>
                            <td id="viewDescription"></td>
                        </tr>
                         <tr>
                            <th>Offer Percent</th>
                            <td id="viewOfferPercent"></td>
                        </tr>
                        <tr>
                            <th>Start Date</th>
                            <td id="viewStartDate"></td>
                        </tr>
                        <tr>
                            <th>End Date</th>
                            <td id="viewEndDate"></td>
                        </tr>
                         <tr>
                            <th>Offer status</th>
                            <td id="viewStatus"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>




<script type="text/javascript">
  $(document).ready(function () {

    // ✅ Add Offer AJAX Submit
    $('#addOfferModal form').submit(function (e) {
      e.preventDefault();
      var formData = new FormData(this);

      $.ajax({
        url: "<?php echo base_url('admin/save_offer'); ?>",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#addOfferModal').modal('hide');
          $('#addOfferModal form')[0].reset();
          loadOfferList();
        }
      });
    });
        function loadOfferList() {
        $.ajax({
            url: "<?php echo base_url('admin/offers'); ?>",
            type: "GET",
            success: function(data) {
                var tableBody = $(data).find("tbody").html();
                $("#basic-datatables tbody").html(tableBody);
            }
        });
    }

    // ✅ Edit Modal Open
    window.openEditModal = function (id) {
      $.ajax({
        url: "<?php echo base_url('admin/edit_offer/'); ?>" + id,
        type: "GET",
        dataType: "json",
        success: function (response) {
          console.log(response); // check this in console

          $("#edit_offer_id").val(response.offers.id);
          $("#edit_offer_name").val(response.offers.offer_name);
          $("#edit_offer_category").val(response.offers.category_id);
          $("#edit_offer_percent").val(response.offers.offer_percent);
          $("#edit_offer_status").val(response.offers.status);
          $("#edit_offer_description").val(response.offers.description);
          $("#edit_start_date").val(response.offers.start_date);
          $("#edit_end_date").val(response.offers.end_date);

          $('#editOfferModal').modal('show');
        },
        error: function () {
          alert("Failed to fetch offer details.");
        }
      });
    };

    // ✅ Update Offer AJAX Submit
$('#editOfferModal form').submit(function (e) {
  e.preventDefault();
  var formData = new FormData(this);

  $.ajax({
    url: "<?php echo base_url('admin/update_offer'); ?>",
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
    dataType: "json",
    success: function (response) {
      if (response.status === 'success') {
        alert('Offer updated successfully.');

        $('#editOfferModal').modal('hide');
        $('#editOfferModal form')[0].reset();

        // Call this only if it reloads your offers dynamically
        loadOfferList();
      } else {
        alert('Failed to update offer.');
      }
    },
    error: function (xhr, status, error) {
      alert('AJAX error: ' + xhr.responseText);
      console.log("Error:", error);
    }
  });
});

window.deleteOffer = function (id) {
  if (confirm("Are you sure you want to delete this offer?")) {
    $.ajax({
      url: "<?php echo base_url('admin/delete_offer/'); ?>" + id,
      type: "GET",
      success: function (response) {
        if (response.trim() === "success") {
          alert("Offer deleted successfully.");
          loadOfferList(); // Or reload offers list
        } else {
          alert("Failed to delete offer.");
        }
      },
      error: function () {
        alert("Error deleting offer.");
      }
    });
  }
};

window.openViewModal = function (id) {
  $.ajax({
    url: "<?php echo base_url('admin/view_offer'); ?>/" + id,
    type: "GET",
    dataType: "json",
    success: function (data) {
      if (data.offer) {
        $('#viewOfferName').text(data.offer.offer_name);
        $('#viewCategoryName').text(data.offer.category_name); // use category_name, not ID
        $('#viewDescription').text(data.offer.description);
        $('#viewOfferPercent').text(data.offer.offer_percent + '%');
        $('#viewStartDate').text(data.offer.start_date);
        $('#viewEndDate').text(data.offer.end_date);
        $('#viewStatus').text(data.offer.status == 1 ? 'Active' : 'Inactive');
        $('#viewOfferModal').modal('show');
      } else {
        alert("Offer not found.");
      }
    },
    error: function () {
      alert("Error fetching offer.");
    }
  });
};



  });
</script>








<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">




 




