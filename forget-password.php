<!DOCTYPE html>
<html lang="en">

<head>
  <title>Forget Password</title>
  <?php include './inc/head.php' ?>
  <?php
  if (isset($_POST['submitBtn'])) {
    echo $em = $_POST['email'];
    echo $sql1 = "SELECT * FROM admin where email='$em'";
    $select12 = mysqli_query($conn, $sql1);
    if (mysqli_num_rows($select12)) {
      $userdata = mysqli_fetch_array($select12);
      $username = $userdata['name'];
      $pass = $userdata['password'];
      if (mail($em, "Forget Password Recovery", "Hi, Your password is: $pass")) {
        header("location:login.php?success=Your password has been sent in your email inbox successfully");
      } else {
        header("location:forget-password.php?error=wrong email sending failed...");
      }
    } else {
      $sql = "SELECT * FROM supervisor where email='$em'";
      $select1 = mysqli_query($conn, $sql);
      if (mysqli_num_rows($select1)) {
        $userdta = mysqli_fetch_array($select1);
        $username = $userdta['name'];
        $pass = $userdta['password'];
        if (mail($em, "Forget Passwword Recovery", "Hi, Your password is: $pass")) {
          header("location:login.php?success=Your password has been sent in your email inbox successfully");
        } else {
          header("location:forget-password.php?error=wrong email sending failed...");
        }
      } else {
        header("location:forget-password.php?error=No email found");
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
                    <h5 class="card-title text-center pb-0 fs-4">Forget Password</h5>
                    <p class="text-center small">Enter your email for mail</p>
                  </div>
                  <form class="row g-3 needs-validation" action="forget-password.php" method="post">
                    <?php if (isset($_GET['error'])) { ?>
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>
                          <?= $_GET['error']; ?>
                        </strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                    <?php } ?>
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
                      <button class="btn btn-primary w-100" type="submit" name="submitBtn">Send mail</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="credits">
                <a href="login.php">Not have account?</a>
              </div>
              <div class="credits">
                Designed by <a href="https://fftechsol.com/">fftechsol.com</a>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </main><!-- End #main -->

</body>

</html>