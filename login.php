<!DOCTYPE html>
<html lang="en">

<head>

  <title>Pages / Login - Company Name</title>
  <?php

  include 'inc/head.php';

  if (isset($_REQUEST['submit'])) {
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];
    $sql1 = "SELECT * FROM `admin` where email='$email' and password='$password'";
    $sql1 = "SELECT * FROM admin where email='$email' and password='$password'";
    if ($rs1 = mysqli_query($conn, $sql1)) {
      if ($row1 = mysqli_fetch_assoc($rs1)) {

        session_start();
        $_SESSION["loggedin"] = true;
        $_SESSION["id"] = $row1['id'];
        $_SESSION["name"] = $row1['name'];
        $_SESSION["role"] = "ADMIN";
        header('location:index.php');
      } else {
        $sql = "SELECT * FROM supervisor where email='$email' and password='$password'";
        if ($rs = mysqli_query($conn, $sql)) {
          if ($row = mysqli_fetch_assoc($rs)) {
            session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $row['id'];
            $_SESSION["name"] = $row['name'];
            $_SESSION["role"] = "SUPERVISOR";

            header('location:index.php');
          } else {
            $status = false;
            $message = "Wrong username and password. Please try again or contact administrator.";
          }
        }
      }
    }
  }
  ?>
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.php" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">Company Name</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your email & password to login</p>
                  </div>

                  <form class="row g-3 needs-validation" action="#" method="post">
                    <?php if (isset($_GET['success'])) { ?>
                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>
                          <?= $_GET['success']; ?>
                        </strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                    <?php } ?>
                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Email</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="email" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter your Email.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <!-- <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                      </div>
                    </div> -->
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" name="submit">Login</button>
                    </div>
                    <!-- <div class="col-12">
                       <a href="forget.php">forget password</a>
                    </div> -->

                    <?php if (isset($status) && !$status) { ?>
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-octagon me-1"></i>
                        <?= $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                    <?php } ?>
                  </form>

                </div>
              </div>
              <div class="credits">
                <a href="forget-password.php">Forget Password?</a>
              </div>
              <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                Designed by <a href="https://fftechsol.com/">fftechsol.com</a>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>