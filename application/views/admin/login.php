<!DOCTYPE html>
<html>
<head>
	<title>Homely Bakers</title>
  <link
      rel="icon"
      href="<?php echo base_url()?>assets/images/tt.png"
      type="image/x-icon"
    />
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap">
    <script src="<?php echo base_url();?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>
<body>
  <section class="bg-light py-5 py-md-5 py-xl-8">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
        <div class="mb-5">
          <h4 class="text-center mb-4">Welcome, Manage everything with ease!</h4>
        </div>
        <div class="card border border-light-subtle rounded-4">
          <div class="card-body p-3 p-md-4 p-xl-5">
            <form id="loginForm" action="<?php echo base_url('admin/login'); ?>" method="post">
              <p class="text-center mb-4">Admin Login</p>
              <div class="row gy-3 overflow-hidden">
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="username" id="username" placeholder="name@example.com" required>
                    <label for="username" class="form-label">Email</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="password" id="password" value="" placeholder="Password" required>
                    <label for="password" class="form-label">Password</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="d-grid">
                    <button class="btn btn-purple btn-lg" type="submit">Log in</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-center mt-4">
          <a href="" class="link-secondary text-decoration-none">Go to Home</a>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>


    <script>
        $(document).ready(function() {
            $('#loginForm').submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                // Get form data
                var formData = {
                    'username': $('input[name=username]').val(),
                    'password': $('input[name=password]').val()
                };

                // Send AJAX request
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('admin/login'); ?>',
                    data: formData,
                    dataType: 'json',
                    encode: true
                })
                .done(function(data) {
                    if (data.status == 'success') {
                        // Redirect to dashboard
                        window.location.href = '<?php echo base_url('admin/dashboard'); ?>';
                    } else {
                        // Show alert for incorrect login details
                        alert(data.message);
                    }
                })
                .fail(function(data) {
                    console.log(data);
                    alert('An error occurred. Please try again.');
                });
            });
        });
    </script>