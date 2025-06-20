<div class="container">
  <div class="page-inner">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h4 class="card-title">Reviews</h4>
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
                    <th>ratings</th>
                    <th>review</th>
                    <th class="col-3">Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th class="col-1">#</th>
                    <th>Customer Name</th>
                    <th>Product Name</th>
                    <th>Ratings</th>
                    <th>Review</th>
                  </tr>
                </tfoot>

                <tbody>
                   <?php
          if(!empty($reviews)){
        $i=0;
          foreach($reviews as $review){
            $i++;
            ?>
                <tr>
                  <td><?= $i; ?></td>
                  <td><?= $review['customer_name']; ?></td>
                  <td><?= $review['product_name']; ?></td>
                  <td><?= $review['ratings']; ?></td>
                  <td><?= $review['review']; ?></td>
                  <td>
                    <button class="btn btn-purple viewReviewBtn" data-id="<?= $review['id']; ?>" title="View">
                      <i class="fa fa-search"></i>
                    </button>
                    <button class="btn btn-danger deleteReviewBtn" data-id="<?= $review['id']; ?>" title="Delete">
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


<!-- View Review Modal -->
<div class="modal fade" id="viewReviewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Review Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <table class="table table-striped">
          <tbody>
            <tr><th>Customer Name</th><td id="viewCustomerName"></td></tr>
            <tr><th>Product Name</th><td id="viewProductName"></td></tr>
            <tr><th>Rating</th><td id="viewRating"></td></tr>
            <tr><th>Review</th><td id="viewReview"></td></tr>
            <tr><th>Posted At</th><td id="viewPostedAt"></td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  $(document).on('click', '.viewReviewBtn', function() {
    var reviewId = $(this).data('id');

    $.ajax({
        url: '<?= base_url("admin/get_review_details"); ?>',
        type: 'POST',
        data: { review_id: reviewId },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                $('#viewCustomerName').text(response.data.customer_name);
                $('#viewProductName').text(response.data.product_name);
                $('#viewRating').text(response.data.ratings);
                $('#viewReview').text(response.data.review);
                $('#viewPostedAt').text(response.data.posted_at);
                $('#viewReviewModal').modal('show');
            } else {
                alert('Review not found');
            }
        },
        error: function() {
            alert('Failed to fetch review details.');
        }
    });
});

  $(document).on('click', '.deleteReviewBtn', function() {
    if (confirm('Are you sure you want to delete this review?')) {
        var reviewId = $(this).data('id');
        var button = $(this);

        $.ajax({
            url: '<?= base_url("admin/delete_review"); ?>',
            type: 'POST',
            data: { review_id: reviewId },
            success: function(response) {
                if (response === 'deleted') {
                    // Remove the row from the table
                    button.closest('tr').remove();
                    alert('Review deleted successfully');
                } else {
                    // alert('Failed to delete review');
                }
            },
            error: function() {
                alert('Something went wrong. Please try again.');
            }
        });
    }
});


</script>


<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
