
   <section class="bg-light py-5 py-md-5 py-xl-8">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">

  
    <div class="card border border-light-subtle rounded-4">
      <div class="card-body p-3 p-md-4 p-xl-5">
        <form id="registerForm"  method="post" action="<?php echo base_url('user/register');?>">
          <p class="text-center mb-4">Registration</p>
            <div class="row gy-3 overflow-hidden">
              <div class="col-12">
              <div class="form-floating mb-3">
                  <input type="text" class="form-control" name="name" placeholder="name" required>
                  <label for="name" class="form-label">Name</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="email" class="form-control" name="email" placeholder="name@example.com" required>
                  <label for="email" class="form-label">Email</label>
                </div>
              </div>
              <div class="col-12">
                <div class="form-floating mb-3">
                  <input type="password" class="form-control" name="password" placeholder="Password" required>
                  <label for="password" class="form-label">Password</label>
                </div>
              </div>
              <div class="col-12">
                <div class="form-floating mb-3">
                  <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required>
                  <label for="confirm_password" class="form-label">Confirm Password</label>
                </div>
              </div>
              <div class="col-12">
                <div class="d-grid">
                  <button class="btn btn-purple btn-lg rounded-2" type="submit">Register</button>
                </div>
              </div>
            </div>
           
          </form>
        </div>
      </div>
        <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-center mt-4">
          <a href="<?php echo base_url('user/login');?>" class="link-secondary text-decoration-none">Already Registered ? Go to login!</a>
        </div>
</div>
</div>
</div>
</section>



<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap">
    <script src="<?php echo base_url();?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        




