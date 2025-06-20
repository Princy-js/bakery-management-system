<div class="container">
  <div class="page-inner">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h4 class="card-title">Users</h4>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="basic-datatables" class="display table table-striped table-hover">
                <thead>
                  <tr>
                    <th class="col-1">#</th>
                    <th>Name</th>
                    <th>email</th>
                    <th>phone number</th>
                    <th>address</th>
                    <th class="col-3">Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th class="col-1">#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                  </tr>
                </tfoot>
                <tbody>
                       <?php
          if(!empty($users)){
        $i=0;
          foreach($users as $us){
            $i++;
            ?>
          <tr>
            <td><?php echo $i;?></td>
            <td><?php echo $us['name']?></td>
            <td><?php echo $us['email']?></td>
                    <td>
          <?php if (!empty($us['phone'])): ?>
            <?php echo $us['phone']; ?>
          <?php else: ?>
            Not added
          <?php endif; ?>
        </td>
        <td>
          <?php if (!empty($us['address'])): ?>
            <?php echo $us['address']; ?>
          <?php else: ?>
            Not added
          <?php endif; ?>
        </td>
            <td>
              <button class="btn btn-purple viewUserBtn" title="View" data-id="<?= $us['id']; ?>"><i class="fa fa-search"></i>
              </button>
              <button class="btn btn-pink deleteUserBtn" data-id="<?php echo $us['id']; ?>" title="Delete">
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


<!-- View User Modal -->
<div class="modal fade" id="viewUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">User Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <table class="table table-striped">
          <tbody>
            <tr><th>Name</th><td id="viewUserName"></td></tr>
            <tr><th>Email</th><td id="viewUserEmail"></td></tr>
            <tr><th>Phone</th><td id="viewUserPhone"></td></tr>
            <tr><th>Address</th><td id="viewUserAddress"></td></tr>
            <tr><th>Created At</th><td id="viewUserCreatedAt"></td></tr>
            <tr><th>Status</th><td id="viewUserStatus"></td></tr>
           


          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" id="deleteUserBtn">Delete User</button>
      </div>
    </div>

  </div>
</div>


<script>
// 1. Handle View User (you already have this)
$(document).on('click', '.viewUserBtn', function () {
  var userId = $(this).data('id');

  $.ajax({
    url: '<?= base_url("admin/get_user_by_id"); ?>',
    type: 'POST',
    data: { id: userId },
    dataType: 'json',
    success: function (res) {
      if (res.status === 'success') {
        $('#viewUserName').text(res.data.name || 'N/A');
        $('#viewUserEmail').text(res.data.email || 'N/A');
        $('#viewUserPhone').text(res.data.phone || 'Not added');
        $('#viewUserAddress').text(res.data.address || 'Not added');
        $('#viewUserCreatedAt').text(res.data.created_at);
        $('#viewUserStatus').html(
          res.data.status == 1
            ? '<span class="badge bg-success">Active</span>'
            : '<span class="badge bg-danger">Inactive</span>'
        );

        // Save user ID for deletion
        $('#deleteUserBtn').data('id', res.data.id);

        $('#viewUserModal').modal('show');
      } else {
        alert('User not found');
      }
    }
  });
});

// 2. Handle Delete
$(document).on('click', '#deleteUserBtn', function () {
  var userId = $(this).data('id');

  if (!userId) {
    alert("User ID not found.");
    return;
  }

  if (confirm('Are you sure you want to delete this user?')) {
    $.ajax({
      url: '<?= base_url("admin/delete_user"); ?>',
      type: 'POST',
      data: { id: userId },
      success: function (response) {
        alert(response);
        $('#viewUserModal').modal('hide');
        location.reload(); // Optional: Refresh list
      },
      error: function () {
        alert('Error deleting user.');
      }
    });
  }
});

</script>






<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">


