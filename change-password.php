<?php include './inc/valid_session.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Change Password</title>
  <?php include './inc/head.php' ?>
  <?php
 if (isset($_POST['submitBtn'])) {
  
$op = validate($_POST['oldPassword']);
$np = validate($_POST['newPassword']);

$id = $_SESSION['id'];

$sql1 = "SELECT password FROM admin WHERE id=$id AND password='$op'";
$result = mysqli_fetch_assoc(mysqli_query($conn, $sql1));
if ($result == true) {
  $sql_2 ="UPDATE admin SET password='$np' WHERE id=$id";
  mysqli_query($conn, $sql_2);
  header("location:change-password.php?success=Your password has been changed successfully");
} else {
  $sql = "SELECT password FROM supervisor WHERE id=$id AND password='$op'";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    if ($result == true) {
      $sql_21 = "UPDATE supervisor SET password='$np' WHERE id=$id";
      mysqli_query($conn, $sql_21);
      header("location:change-password.php?success=Your password has been changed successfully");
    }else {
        header("location:change-password.php?error=Incorrect old password"); 
  }
}
}



  function validate($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  ?>
</head>


<body>
  <?php include './inc/header.php' ?>
  <?php include './inc/sidebar.php' ?>

  <main>
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
              <div class="card mb-3">

                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Change Password</h5>
                  </div>

                  <form class="row g-3 needs-validation" action="change-password.php" method="post" novalidate oninput='cPassword.setCustomValidity(cPassword.value != newPassword.value ? "Passwords do not match." : "")'>
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
                      <label for="oldPassword" class="form-label">Old Password: </label>
                      <input type="password" name="oldPassword" class="form-control" id="oldPassword" required>
                      <div class="invalid-feedback"> Please enter the old password. </div>
                      <div class="valid-feedback"> Looks Good! </div>
                    </div>

                    <div class="col-12">
                      <label for="newPassword" class="form-label">New Password: </label>
                      <input type="password" name="newPassword" class="form-control" id="newPassword" required>
                      <div class="invalid-feedback">Please new enter new password!</div>
                      <div class="valid-feedback">Looks Good! </div>
                    </div>

                    <div class="col-12">
                      <label for="cPassword" class="form-label">Confirm Password: </label>
                      <input type="password" name="cPassword" class="form-control" id="cPassword" required>
                      <div class="invalid-feedback">Confirm Password do not match.</div>
                      <div class="valid-feedback"> Looks Good! </div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" name="submitBtn">Change</button>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->
  <?php include './inc/footer.php' ?>

</body>

</html>