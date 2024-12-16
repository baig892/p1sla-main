<?php
include_once('../inc/connection.php');
if (isset($_POST['submit'])) {
    $name =  trim($_REQUEST['labour_name']);
    $pay =  $_REQUEST['pay'];
    $sql = "INSERT INTO labour(name,pay)  VALUES ('$name','$pay') ";
    try {
        $rs = mysqli_query($conn, $sql);
        if ($rs) {
            $status = true;
            $message = "Labour added successfully.";
        } else {
            $status = false;
            $message = "Labour is already present in the list.";
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            // Duplicate row
            $status = false;
            $message = "Labour is already present in the list.";
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
    <title>Labour Form</title>
    <?php include '../inc/head.php' ?>
</head>

<body>
    <?php include '../inc/header.php' ?>
    <?php include '../inc/sidebar.php' ?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Labour form</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Labour Form</li>
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
                                <h5 class="card-title">Add New Labour</h5>
                                <div class="row mb-3">
                                    <label for="validationCustom01" class="form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name='labour_name'
                                            id="validationCustom01" required>
                                        <div class="invalid-feedback">
                                            Please Enter The Labour Name
                                        </div>
                                        <div class="valid-feedback">
                                            Looks Good!
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="validationCustom01" class="form-label">Pay</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" name='pay' id="validationCustom01"
                                            required>
                                        <div class="invalid-feedback">
                                            Please Enter The Amount
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
                                        if ($status==true) {
                                          ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>
                                            <?= $message ?>
                                        </strong>
                                        <a href='./labour-list.php'>Click here to see all labours.</a>
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
                                        <a href='./labour-list.php'><br />Click here to see all labours.</a>
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