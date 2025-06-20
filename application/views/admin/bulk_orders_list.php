<div class="container">
  <div class="page-inner">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h4 class="card-title">Bulk Orders</h4>
              <button class="btn btn-purple btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="fa fa-plus"></i>
                Add Bulk Order
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="basic-datatables" class="display table table-striped table-hover">
                <thead>
                  <tr>
                    <th class="col-1">#</th>
                    <th>Customer Name</th>
                    <th>Phone number</th>
                    <th>address</th>
                    <th>product</th>
                    <th>quantity</th>
                    <th>total price</th>
                    <th class="col-3">Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th class="col-1">#</th>
                    <th>Customer Name</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                  </tr>
                </tfoot>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>





<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
