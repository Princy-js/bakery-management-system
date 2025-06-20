<div class="container">
  <div class="page-inner">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h4 class="card-title">Category</h4>
              <button class="btn btn-purple btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="fa fa-plus"></i>
                Add Category
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="basic-datatables" class="display table table-striped table-hover">
                <thead>
                  <tr>
                    <th class="col-1">#</th>
                    <th>Category</th>
                    <th class="col-3">Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th class="col-1">#</th>
                    <th>Category</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php
          if(!empty($categories)){
        $i=0;
          foreach($categories as $ca){
            $i++;
            ?>
          <tr>
            <td><?php echo $i;?></td>
            <td><?php echo $ca['category_name']?></td>
            <td>
              <button class="btn btn-purple" title="edit" data-toggle="modal" data-target="editCategoryModal" onclick="openEditModal('<?php echo $ca['id']; ?>', '<?php echo $ca['category_name']; ?>')">
                <i class="fa fa-edit"></i>
              </button>
              <button class="btn btn-danger" title="delete" onclick="delete_category_info(<?php echo $ca['id'];?>);"><i class="fa fa-trash"></i></button>
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


<!-- Add category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
              <?php $attributes = array("name" => "save_category","method"=>"POST");
            echo form_open_multipart("admin/save_category",$attributes);?>
        <form>
          <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <input type="text" class="form-control" id="category" name="categoryname" required>
          </div>
          <button type="submit" class="btn btn-purple btn-sm">Save</button>
        </form>
        <?php echo form_close();?>
      </div>
    </div>
  </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="editCategoryForm">
          <input type="hidden" id="editCategoryId">
          <div class="mb-3">
            <label class="form-label">Category Name</label>
            <input type="text" class="form-control" id="editCategoryName" required>
          </div>
          <button type="button" class="btn btn-purple" onclick="updateCategory()">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>






<script type="text/javascript">
    $(document).ready(function () {
    $('#addLeaveTypeForm').on('submit', function (e) {
      e.preventDefault();
      $.ajax({
        url: '<?php echo base_url('admin/save_category'); ?>',
        method: 'POST',
        data: $(this).serialize(),
        success: function (response) {
          $('#addCategoryModal').modal('hide');
          location.reload();
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
    });
  });

function openEditModal(id, name) {
    $('#editCategoryId').val(id);
    $('#editCategoryName').val(name);
    $('#editCategoryModal').modal('show');
}


function updateCategory() {
    var id = $('#editCategoryId').val();
    var categoryname = $('#editCategoryName').val();

    $.post("<?php echo base_url('admin/update_category/'); ?>" + id, 
        { categoryname: categoryname },
        function(response) {
            let res = JSON.parse(response);
            if (res.status === 'success') {
                // Close the modal first
                $('#editCategoryModal').modal('hide');

                // Show success message after the modal is closed
                setTimeout(() => {
                    alert(res.message);
                    location.reload(); // Reload to reflect changes
                }, 300);
            }
        }
    );
}


  function delete_category_info(id) {
        var confirmDelete = confirm("Are you sure you want to delete?");
        if (confirmDelete) {
            $.ajax({
                url: '<?php echo base_url('admin/delete_category'); ?>',
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