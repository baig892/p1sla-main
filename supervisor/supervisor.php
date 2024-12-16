<?php
include_once('../inc/connection.php');

if (isset($_POST['submit'])) {
    $name = trim($_REQUEST['supervisor_name']);
    $email = trim($_REQUEST['email']);
    $password = trim($_REQUEST['password']);
    $sql = "INSERT INTO supervisor(name,email,password)  VALUES ('$name','$email','$password') ";
    try {
        $rs = mysqli_query($conn, $sql);
        if ($rs) {
            $status = true;
            $message = "Supervisor added successfully.";
        } else {
            $status = false;
            $message = "Supervisor is already present in the list.";
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            // Duplicate row
            $status = false;
            $message = "Supervisor is already present in the list.";
        } else {
            throw $e; // in case it's any other error
            $status = false;
            $message = "Data entry failed due to reason: " . $e;
        }
    }
}
?>
<?php include '../inc/valid_session.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add New Supervisor</title>
    <?php include '../inc/head.php' ?>
</head>

<body>
    <?php include '../inc/header.php' ?>
    <?php include '../inc/sidebar.php' ?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Supervisor</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Add New Supervisor</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-8">
                    <form method='post' action='<?php echo $_SERVER['PHP_SELF'] ?>' class="row g-3 needs-validation"
                        novalidate>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Add New Supervisor</h5>
                                <div class="row mb-3">
                                    <label for="supervisor_name" class="form-label">Name: </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name='supervisor_name'
                                            id="supervisor_name" required>
                                        <div class="invalid-feedback">
                                            Please Enter The Supervisor Name
                                        </div>
                                        <div class="valid-feedback">
                                            Looks Good!
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="username" class="form-label">Email: </label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" name='email' id="email" required>
                                        <div class="invalid-feedback">
                                            Please Enter The Email
                                        </div>
                                        <div class="valid-feedback">
                                            Looks Good!
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="password" class="form-label">Password: </label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" name='password' id="password"
                                            required>
                                        <div class="invalid-feedback">
                                            Please Enter The Password
                                        </div>
                                        <div class="valid-feedback">
                                            Looks Good!
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <input class="btn btn-primary" name='submit' type="submit">
                                    <?php
                                    if (isset($status)) {
                                        if ($status == true) {
                                    ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>
                                            <?= $message ?>
                                        </strong>
                                        <a href='./supervisor-list.php'>Click here to see all supervisor.</a>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    <?php
                                        } else {
                                        ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>
                                            <?= $message ?>
                                        </strong>
                                        <a href='./supervisor-list.php'><br />Click here to see all supervisor.</a>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </form><!-- End Custom Styled Validation -->
                </div>
            </div>
        </section>
    </main><!-- End #main -->
    <?php include '../inc/footer.php' ?>
</body>

</html>